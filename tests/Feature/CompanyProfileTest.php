<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_company_domain_shows_company_profile(): void
    {
        $this->get('https://enigmaworks.web.id/')
            ->assertOk()
            ->assertSee('<title>Enigma Works Indonesia | Perusahaan Teknologi &amp; Integrasi Sistem</title>', false)
            ->assertSee('<link rel="canonical" href="https://enigmaworks.web.id/">', false)
            ->assertSee('"@type":"Organization"', false)
            ->assertSee('https://enigmaworks.web.id/css/company.css', false)
            ->assertSee('Teknologi yang kami gunakan')
            ->assertSee('FHIR R4')
            ->assertSee('id="keamanan"', false)
            ->assertSee('DLP (Data Loss Prevention)')
            ->assertSee('IT audit')
            ->assertDontSee('Proyek yang sedang berjalan')
            ->assertDontSee('[ISI', false)
            ->assertDontSee('DHealth');
    }

    public function test_other_paths_on_company_domain_redirect_to_enigma_health(): void
    {
        $this->get('https://enigmaworks.web.id/layanan')->assertStatus(301)->assertRedirect('https://enigmaworks.online/layanan');
        $this->get('https://enigmaworks.web.id/admin/login')->assertStatus(301)->assertRedirect('https://enigmaworks.online/admin/login');
        $this->get('https://enigmaworks.web.id/blog?page=2')->assertStatus(301)->assertRedirect('https://enigmaworks.online/blog?page=2');
    }

    public function test_www_redirects_to_bare_company_domain(): void
    {
        $this->get('https://www.enigmaworks.web.id/')->assertStatus(301)->assertRedirect('https://enigmaworks.web.id/');
        $this->get('https://www.enigmaworks.web.id/layanan')->assertStatus(301)->assertRedirect('https://enigmaworks.web.id/');
    }

    public function test_enigma_health_domain_is_unchanged(): void
    {
        $this->get('https://enigmaworks.online/')->assertOk()->assertSee('Enigma Health')->assertDontSee('company.css');
        $this->get('https://enigmaworks.online/layanan')->assertOk();
        $this->get('https://enigmaworks.online/admin/login')->assertOk();
    }
}
