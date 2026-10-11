<?php

namespace SamoSadlaker\StatamicMaintenance\Tests;

require_once __DIR__ . '/TestCase.php';

use SamoSadlaker\StatamicMaintenance\Maintenance;
use Statamic\Facades\User;
use Statamic\Facades\YAML;

class ExampleTest extends TestCase
{
    private ?string $originalMaintenance = null;

    protected function setUp(): void
    {
        parent::setUp();

        $path = base_path('content/maintenance.yaml');
        $directory = dirname($path);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if (file_exists($path)) {
            $this->originalMaintenance = file_get_contents($path) ?: null;
        }

        $this->app['view']->addLocation(__DIR__ . '/views');

        $this->app['router']->middleware('web')->get('/test-page', fn() => 'ok')->name('test.page');
    }

    protected function tearDown(): void
    {
        $path = base_path('content/maintenance.yaml');

        if ($this->originalMaintenance === null) {
            @unlink($path);
        } else {
            file_put_contents($path, $this->originalMaintenance);
        }

        parent::tearDown();
    }

    public function test_maintenance_defaults_are_loaded_when_file_is_missing_or_partial(): void
    {
        $path = base_path('content/maintenance.yaml');
        @unlink($path);

        $maintenance = new Maintenance();

        $this->assertFalse($maintenance->isEnabled());
        $this->assertTrue($maintenance->getValues()['maintenance_use_default_page']);
        $this->assertSame('Maintenance Mode', $maintenance->getValues()['maintenance_title']);

        $this->writeMaintenance(['maintenance_enabled' => false, 'maintenance_title' => 'Planned Maintenance']);

        $maintenance = new Maintenance();

        $this->assertFalse($maintenance->isEnabled());
        $this->assertSame('Planned Maintenance', $maintenance->getValues()['maintenance_title']);
    }

    public function test_public_route_redirects_to_maintenance_when_enabled(): void
    {
        $this->writeMaintenance(['maintenance_enabled' => true]);

        $this->get('/test-page')
            ->assertRedirect('maintenance');
    }

    public function test_maintenance_route_is_accessible_when_enabled(): void
    {
        $this->writeMaintenance(['maintenance_enabled' => true, 'maintenance_title' => 'Scheduled Maintenance']);

        $this->get('/maintenance')
            ->assertOk()
            ->assertSee('Scheduled Maintenance');
    }

    public function test_maintenance_route_redirects_home_when_disabled(): void
    {
        $this->writeMaintenance(['maintenance_enabled' => false]);

        $this->get('/maintenance')
            ->assertRedirect('/');
    }

    public function test_maintenance_route_uses_default_page_when_toggle_enabled(): void
    {
        $this->writeMaintenance([
            'maintenance_enabled' => true,
            'maintenance_use_default_page' => true,
            'maintenance_page' => 'custom',
            'maintenance_title' => 'Default Page',
        ]);

        $this->get('/maintenance')
            ->assertOk()
            ->assertSee('Default Page')
            ->assertDontSee('CUSTOM-MAINTENANCE');
    }

    public function test_maintenance_route_uses_custom_page_when_toggle_disabled(): void
    {
        $this->writeMaintenance([
            'maintenance_enabled' => true,
            'maintenance_use_default_page' => false,
            'maintenance_page' => 'custom',
            'maintenance_title' => 'Custom Page',
        ]);

        $this->get('/maintenance')
            ->assertOk()
            ->assertSee('CUSTOM-MAINTENANCE')
            ->assertSee('Custom Page');
    }

    public function test_legacy_settings_without_toggle_keep_using_custom_page(): void
    {
        $this->writeRawMaintenance([
            'maintenance_enabled' => true,
            'maintenance_page' => 'custom',
            'maintenance_title' => 'Legacy Page',
            'maintenance_message' => [],
        ]);

        $this->get('/maintenance')
            ->assertOk()
            ->assertSee('CUSTOM-MAINTENANCE')
            ->assertSee('Legacy Page');
    }

    public function test_admin_maintenance_page_renders_publish_form(): void
    {
        $this->actingAs(User::make()->id('admin')->email('admin@example.com')->makeSuper());

        $this->get('/cp/maintenance')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('PublishForm')
                ->where('title', 'Maintenance settings')
                ->has('blueprint')
                ->has('values')
                ->has('meta')
                ->where('submitUrl', cp_route('samosadlaker.maintenance.update'))
                ->where('submitMethod', 'PUT')
            );
    }

    public function test_admin_maintenance_update_saves_values(): void
    {
        $this->actingAs(User::make()->id('admin')->email('admin@example.com')->makeSuper());

        $this->put('/cp/maintenance', [
            'maintenance_enabled' => true,
            'maintenance_use_default_page' => false,
            'maintenance_page' => null,
            'maintenance_title' => 'Down for maintenance',
            'maintenance_message' => [
                [
                    'type' => 'paragraph',
                    'content' => [
                        ['type' => 'text', 'text' => 'We will be back soon.'],
                    ],
                ],
            ],
        ])
            ->assertOk()
            ->assertJson(['saved' => true]);

        $maintenance = new Maintenance();

        $this->assertTrue($maintenance->isEnabled());
        $this->assertFalse($maintenance->getValues()['maintenance_use_default_page']);
        $this->assertSame('Down for maintenance', $maintenance->getValues()['maintenance_title']);
        $this->assertNotEmpty($maintenance->getValues()['maintenance_message']);
    }

    /**
     * @param array<string, mixed> $overrides
     */
    private function writeMaintenance(array $overrides = []): void
    {
        $this->writeRawMaintenance(array_merge([
            'maintenance_enabled' => false,
            'maintenance_use_default_page' => true,
            'maintenance_page' => null,
            'maintenance_title' => 'Maintenance Mode',
            'maintenance_message' => [],
        ], $overrides));
    }

    /**
     * @param array<string, mixed> $values
     */
    private function writeRawMaintenance(array $values): void
    {
        $path = base_path('content/maintenance.yaml');
        $directory = dirname($path);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($path, YAML::dump($values));
    }
}
