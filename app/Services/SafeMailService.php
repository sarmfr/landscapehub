<?php

namespace App\Services;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SafeMailService
{
    public function send(string $to, Mailable $mailable, string $logMessage, array $context = []): bool
    {
        try {
            Mail::to($to)->send($mailable);

            return true;
        } catch (Throwable $e) {
            Log::warning($logMessage, $context + [
                'email' => $to,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function queue(string $to, Mailable $mailable, string $logMessage, array $context = []): bool
    {
        try {
            Mail::to($to)->queue($mailable);

            return true;
        } catch (Throwable $e) {
            Log::warning($logMessage, $context + [
                'email' => $to,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
