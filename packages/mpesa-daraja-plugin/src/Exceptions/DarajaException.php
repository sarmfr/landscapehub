<?php

namespace LandscapeHub\Payments\MpesaDaraja\Exceptions;

use RuntimeException;

class DarajaException extends RuntimeException
{
    public static function configuration(string $message): self
    {
        return new self($message);
    }

    public static function requestFailed(string $message): self
    {
        return new self($message);
    }
}
