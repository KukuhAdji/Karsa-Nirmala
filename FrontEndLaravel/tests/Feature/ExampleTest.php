<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_how_it_works_page_explains_the_scan_workflow(): void
    {
        $response = $this->get(route('how-it-works'));

        $response->assertOk();
        $response->assertSee('Cara Kerja Karsa Nirmala');
        $response->assertSee('Ambil atau unggah foto');
        $response->assertSee('AI mengenali sampah');
        $response->assertSee('Hasil scan tersimpan di Riwayat');
    }

    public function test_landing_navigation_links_to_how_it_works_without_education_item(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(route('how-it-works'), false);
        $response->assertDontSee('href="#education"', false);
    }
}
