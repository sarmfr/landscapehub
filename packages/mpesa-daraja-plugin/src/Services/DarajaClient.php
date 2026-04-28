<?php

namespace LandscapeHub\Payments\MpesaDaraja\Services;

use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use LandscapeHub\Payments\MpesaDaraja\DTO\CallbackResult;
use LandscapeHub\Payments\MpesaDaraja\DTO\QueryResult;
use LandscapeHub\Payments\MpesaDaraja\DTO\StkPushResult;
use LandscapeHub\Payments\MpesaDaraja\Exceptions\DarajaException;
use LandscapeHub\Payments\MpesaDaraja\Support\PhoneNumber;

class DarajaClient
{
    public function __construct(private readonly HttpFactory $http)
    {
    }

    public function initiateStkPush(
        string $phoneNumber,
        int|float|string $amount,
        string $reference,
        string $description,
        ?string $callbackUrl = null
    ): StkPushResult {
        $this->guardConfiguration();

        $timestamp = now()->format('YmdHis');
        $shortCode = (string) Config::get('mpesa-daraja.short_code');
        $payload = [
            'BusinessShortCode' => $shortCode,
            'Password' => base64_encode($shortCode . Config::get('mpesa-daraja.passkey') . $timestamp),
            'Timestamp' => $timestamp,
            'TransactionType' => $this->transactionType(),
            'Amount' => (int) round((float) $amount),
            'PartyA' => PhoneNumber::normalize($phoneNumber),
            'PartyB' => (string) Config::get('mpesa-daraja.party_b', $shortCode),
            'PhoneNumber' => PhoneNumber::normalize($phoneNumber),
            'CallBackURL' => $callbackUrl ?: (string) Config::get('mpesa-daraja.callback_url'),
            'AccountReference' => Str::limit($reference, 12, ''),
            'TransactionDesc' => Str::limit($description, 13, ''),
        ];

        if ($payload['CallBackURL'] === '') {
            throw DarajaException::configuration('MPESA_CALLBACK_URL is required for STK push callbacks.');
        }

        $response = $this->request('post', '/mpesa/stkpush/v1/processrequest', $payload);

        return new StkPushResult(
            accepted: (string) ($response['ResponseCode'] ?? '') === '0',
            merchantRequestId: $response['MerchantRequestID'] ?? null,
            checkoutRequestId: $response['CheckoutRequestID'] ?? null,
            responseCode: $response['ResponseCode'] ?? null,
            responseDescription: $response['ResponseDescription'] ?? null,
            customerMessage: $response['CustomerMessage'] ?? null,
            raw: $response
        );
    }

    public function queryStkPush(string $checkoutRequestId): QueryResult
    {
        $this->guardConfiguration();

        $timestamp = now()->format('YmdHis');
        $shortCode = (string) Config::get('mpesa-daraja.short_code');
        $payload = [
            'BusinessShortCode' => $shortCode,
            'Password' => base64_encode($shortCode . Config::get('mpesa-daraja.passkey') . $timestamp),
            'Timestamp' => $timestamp,
            'CheckoutRequestID' => $checkoutRequestId,
        ];

        $response = $this->request('post', '/mpesa/stkpushquery/v1/query', $payload);

        return new QueryResult(
            successful: (string) ($response['ResultCode'] ?? '') === '0',
            responseCode: $response['ResponseCode'] ?? null,
            responseDescription: $response['ResponseDescription'] ?? null,
            merchantRequestId: $response['MerchantRequestID'] ?? null,
            checkoutRequestId: $response['CheckoutRequestID'] ?? null,
            resultCode: isset($response['ResultCode']) ? (string) $response['ResultCode'] : null,
            resultDescription: $response['ResultDesc'] ?? null,
            raw: $response
        );
    }

    public function parseStkCallback(array $payload): CallbackResult
    {
        $callback = $payload['Body']['stkCallback'] ?? [];
        $metadata = [];

        foreach (($callback['CallbackMetadata']['Item'] ?? []) as $item) {
            if (!isset($item['Name'])) {
                continue;
            }

            $metadata[$item['Name']] = $item['Value'] ?? null;
        }

        return new CallbackResult(
            successful: (int) ($callback['ResultCode'] ?? -1) === 0,
            merchantRequestId: $callback['MerchantRequestID'] ?? null,
            checkoutRequestId: $callback['CheckoutRequestID'] ?? null,
            resultCode: isset($callback['ResultCode']) ? (int) $callback['ResultCode'] : null,
            resultDescription: $callback['ResultDesc'] ?? null,
            receiptNumber: $metadata['MpesaReceiptNumber'] ?? null,
            amount: isset($metadata['Amount']) ? (float) $metadata['Amount'] : null,
            phoneNumber: isset($metadata['PhoneNumber']) ? (string) $metadata['PhoneNumber'] : null,
            transactionDate: isset($metadata['TransactionDate']) ? (string) $metadata['TransactionDate'] : null,
            metadata: $metadata,
            raw: $payload
        );
    }

    protected function request(string $method, string $uri, array $payload = []): array
    {
        $response = $this->http
            ->baseUrl($this->baseUrl())
            ->acceptJson()
            ->timeout((int) Config::get('mpesa-daraja.timeout', 30))
            ->connectTimeout((int) Config::get('mpesa-daraja.connect_timeout', 10))
            ->withToken($this->accessToken())
            ->send($method, $uri, ['json' => $payload]);

        if ($response->failed()) {
            throw DarajaException::requestFailed(
                sprintf(
                    'Daraja request to [%s] failed with status [%s]: %s',
                    $uri,
                    $response->status(),
                    $response->body()
                )
            );
        }

        return $response->json() ?? [];
    }

    protected function accessToken(): string
    {
        $cacheKey = 'mpesa-daraja.access-token.' . md5(
            (string) Config::get('mpesa-daraja.environment') . '|' . (string) Config::get('mpesa-daraja.consumer_key')
        );

        return Cache::remember($cacheKey, (int) Config::get('mpesa-daraja.token_cache_seconds', 3300), function () {
            $response = $this->http
                ->baseUrl($this->baseUrl())
                ->acceptJson()
                ->timeout((int) Config::get('mpesa-daraja.timeout', 30))
                ->connectTimeout((int) Config::get('mpesa-daraja.connect_timeout', 10))
                ->withBasicAuth(
                    (string) Config::get('mpesa-daraja.consumer_key'),
                    (string) Config::get('mpesa-daraja.consumer_secret')
                )
                ->get('/oauth/v1/generate', ['grant_type' => 'client_credentials']);

            if ($response->failed()) {
                throw DarajaException::requestFailed(
                    sprintf('Unable to fetch Daraja access token: %s', $response->body())
                );
            }

            $accessToken = $response->json('access_token');

            if (!$accessToken) {
                throw DarajaException::requestFailed('Daraja access token response did not include access_token.');
            }

            return $accessToken;
        });
    }

    protected function transactionType(): string
    {
        $configured = Config::get('mpesa-daraja.transaction_type');
        if (is_string($configured) && $configured !== '') {
            return $configured;
        }

        return Config::get('mpesa-daraja.business_type', 'paybill') === 'till'
            ? 'CustomerBuyGoodsOnline'
            : 'CustomerPayBillOnline';
    }

    protected function baseUrl(): string
    {
        return Config::get('mpesa-daraja.environment', 'sandbox') === 'production'
            ? 'https://api.safaricom.co.ke'
            : 'https://sandbox.safaricom.co.ke';
    }

    protected function guardConfiguration(): void
    {
        $required = [
            'mpesa-daraja.consumer_key' => Config::get('mpesa-daraja.consumer_key'),
            'mpesa-daraja.consumer_secret' => Config::get('mpesa-daraja.consumer_secret'),
            'mpesa-daraja.short_code' => Config::get('mpesa-daraja.short_code'),
            'mpesa-daraja.passkey' => Config::get('mpesa-daraja.passkey'),
        ];

        $missing = [];

        foreach ($required as $key => $value) {
            if (!is_string($value) || trim($value) === '') {
                $missing[] = $key;
            }
        }

        if ($missing !== []) {
            throw DarajaException::configuration(
                'Missing Daraja configuration values: ' . implode(', ', $missing)
            );
        }
    }
}
