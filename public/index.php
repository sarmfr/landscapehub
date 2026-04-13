<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Wasmer deployments may start from a package without empty storage folders.
foreach ([
    __DIR__.'/../storage/app/public',
    __DIR__.'/../storage/framework/cache/data',
    __DIR__.'/../storage/framework/sessions',
    __DIR__.'/../storage/framework/views',
    __DIR__.'/../storage/logs',
] as $directory) {
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

$appKey = getenv('APP_KEY') ?: ($_SERVER['APP_KEY'] ?? $_ENV['APP_KEY'] ?? null);

if (!is_string($appKey) || !preg_match('/^base64:(.+)$/', $appKey, $matches)) {
    error_log('Invalid APP_KEY format detected before Laravel bootstrap.');
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    exit('Server misconfiguration: invalid APP_KEY format.');
}

$decodedKey = base64_decode($matches[1], true);

if ($decodedKey === false || strlen($decodedKey) !== 32) {
    error_log('Invalid APP_KEY length detected before Laravel bootstrap.');
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    exit('Server misconfiguration: APP_KEY must decode to 32 bytes.');
}

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
