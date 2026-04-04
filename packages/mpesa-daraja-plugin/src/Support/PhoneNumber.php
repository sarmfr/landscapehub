<?php

namespace LandscapeHub\Payments\MpesaDaraja\Support;

use InvalidArgumentException;

class PhoneNumber
{
    public static function normalize(string $value): string
    {
        $digits = preg_replace('/\D+/', '', trim($value));

        if ($digits === null || $digits === '') {
            throw new InvalidArgumentException('The phone number is required.');
        }

        if (str_starts_with($digits, '0')) {
            $digits = '254' . substr($digits, 1);
        }

        if (str_starts_with($digits, '7') || str_starts_with($digits, '1')) {
            $digits = '254' . $digits;
        }

        if (!preg_match('/^254(7|1)\d{8}$/', $digits)) {
            throw new InvalidArgumentException('Use a valid Kenyan phone number in the format 07XXXXXXXX or 2547XXXXXXXX.');
        }

        return $digits;
    }
}
