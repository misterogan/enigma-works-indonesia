<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\Setting;
use App\Support\ContentSnapshot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentSnapshotTest extends TestCase
{
    use RefreshDatabase;

    /** @var array<string, list<array<string, mixed>>> */
    private array $snapshot;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->snapshot = json_decode(File::get(ContentSnapshot::path('content.json')), true);
    }

    public function test_seeding_an_empty_database_fills_it_with_the_snapshot(): void
    {
        $this->seed();

        foreach (ContentSnapshot::TABLES as $table => $key) {
            foreach ($this->snapshot[$table] as $row) {
                $this->assertDatabaseHas($table, [$key => $row[$key]]);
            }
        }

        $logo = collect($this->snapshot['settings'])->firstWhere('key', 'logo')['value'];
        $this->assertSame($logo, Setting::get('logo'));
        if ($logo) {
            Storage::disk('public')->assertExists($logo);
        }

        $this->get('/')->assertOk()->assertSee('Enigma Health');
    }

    public function test_import_keeps_existing_rows_unless_overwrite_is_requested(): void
    {
        $this->seed();
        $slug = $this->snapshot['services'][0]['slug'];
        Service::where('slug', $slug)->update(['name' => 'Diubah di production']);

        $this->artisan('content:import')->assertSuccessful();
        $this->assertSame('Diubah di production', Service::where('slug', $slug)->value('name'));

        $this->artisan('content:import', ['--overwrite' => true])->assertSuccessful();
        $this->assertSame($this->snapshot['services'][0]['name'], Service::where('slug', $slug)->value('name'));
    }
}
