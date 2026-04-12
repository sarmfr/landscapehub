<?php

namespace App\Exceptions;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e): HttpResponse
    {
        try {
            return parent::render($request, $e);
        } catch (BindingResolutionException $renderException) {
            $message = $renderException->getMessage();

            if (
                !str_contains($message, 'Target class [view] does not exist.')
                && !str_contains($message, 'Target class [view.finder] does not exist.')
                && !str_contains($message, 'Target class [files] does not exist.')
            ) {
                throw $renderException;
            }

            $status = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;
            $headers = $e instanceof HttpExceptionInterface ? $e->getHeaders() : [];

            $message = config('app.debug')
                ? sprintf('%s: %s', $e::class, $e->getMessage())
                : ($status === 404 ? 'Not Found' : 'Server Error');

            return new HttpResponse($message, $status, array_merge([
                'Content-Type' => 'text/plain; charset=UTF-8',
            ], $headers));
        }
    }
}
