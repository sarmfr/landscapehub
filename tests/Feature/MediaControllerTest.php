<?php

namespace Tests\Feature;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Tests\TestCase;

class MediaControllerTest extends TestCase
{
    public function test_public_media_route_serves_files_from_the_public_disk(): void
    {
        $path = 'products/example.txt';
        $fullPath = storage_path('app/public/' . $path);

        if (! is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0777, true);
        }

        file_put_contents($fullPath, 'media test');

        $response = app(Kernel::class)->handle(
            Request::create('/storage/' . $path, 'GET')
        );

        try {
            $this->assertSame(200, $response->getStatusCode());
            $this->assertStringContainsString('public', (string) $response->headers->get('Cache-Control'));
            $this->assertStringContainsString('max-age=3600', (string) $response->headers->get('Cache-Control'));
            $this->assertInstanceOf(BinaryFileResponse::class, $response);
            $this->assertSame(realpath($fullPath), $response->getFile()->getRealPath());
        } finally {
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }

    public function test_public_media_route_rejects_path_traversal(): void
    {
        $this->get('/storage/../.env')->assertNotFound();
    }
}
