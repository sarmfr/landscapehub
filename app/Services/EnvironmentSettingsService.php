<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use RuntimeException;

class EnvironmentSettingsService
{
    public function update(array $values): void
    {
        $envPath = app()->environmentFilePath();

        if (!File::exists($envPath)) {
            throw new RuntimeException('.env file was not found.');
        }

        $contents = File::get($envPath);

        foreach ($values as $key => $value) {
            $contents = $this->setValue($contents, (string) $key, $value);
        }

        File::put($envPath, $contents);

        if (app()->configurationIsCached()) {
            Artisan::call('config:clear');
        }
    }

    protected function setValue(string $contents, string $key, mixed $value): string
    {
        $escapedKey = preg_quote($key, '/');
        $normalizedValue = $this->normalizeValue($value);
        $line = $key . '=' . $normalizedValue;

        if (preg_match("/^{$escapedKey}=.*$/m", $contents)) {
            return (string) preg_replace("/^{$escapedKey}=.*$/m", $line, $contents);
        }

        return rtrim($contents) . PHP_EOL . $line . PHP_EOL;
    }

    protected function normalizeValue(mixed $value): string
    {
        if ($value === null) {
            return '';
        }

        $value = trim((string) $value);

        if ($value === '') {
            return '';
        }

        return '"' . addcslashes($value, "\"\\") . '"';
    }
}
