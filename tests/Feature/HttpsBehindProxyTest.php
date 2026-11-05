<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HttpsBehindProxyTest extends TestCase
{
    use RefreshDatabase;

    public function test_urls_use_https_when_cloudflare_forwards_https(): void
    {
        $this->seed();
        $headers = ['X-Forwarded-Proto' => 'https', 'X-Forwarded-Host' => 'enigmaworks.online', 'X-Forwarded-Port' => '443'];

        $this->get('/', $headers)
            ->assertOk()
            ->assertSee('<link rel="canonical" href="https://enigmaworks.online">', false)
            ->assertSee('<meta property="og:url" content="https://enigmaworks.online">', false)
            ->assertSee('href="https://enigmaworks.online/css/app.css', false)
            ->assertDontSee('http://enigmaworks.online', false);

        $this->get('/sitemap.xml', $headers)
            ->assertOk()
            ->assertSee('<loc>https://enigmaworks.online/layanan/simrs</loc>', false)
            ->assertDontSee('<loc>http://', false);
    }
}
