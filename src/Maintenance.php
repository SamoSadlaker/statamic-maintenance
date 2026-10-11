<?php

namespace SamoSadlaker\StatamicMaintenance;

use Statamic\Facades\File;
use Statamic\Facades\YAML;
class Maintenance
{
    /**
     * The maintenance mode status.
     *
     * @var boolean
     */
    protected bool $enabled = false;

    /**
     * The path to the maintenance file.
     *
     * @var string
     */
    private string $path = 'content/maintenance.yaml';

    /**
     * Default maintenance values.
     *
     * @var array<string, mixed>
     */
    private array $defaults = [
        'maintenance_enabled' => false,
        'maintenance_use_default_page' => true,
        'maintenance_page' => null,
        'maintenance_title' => 'Maintenance Mode',
        'maintenance_message' => [],
    ];

    /**
     * The values from the maintenance file.
     *
     * @var array
     */
    protected array $values = [];


    public function __construct()
    {
        $this->values = $this->defaults;

        if (File::exists($this->path)) {
            $values = YAML::parse(File::get($this->path));

            if (is_array($values)) {
                // Back-compat: settings saved before the "use default page"
                // toggle existed have no key. Derive it from whether a custom
                // page was already selected so existing sites keep rendering
                // the same page.
                if (! array_key_exists('maintenance_use_default_page', $values)) {
                    $values['maintenance_use_default_page'] = empty($values['maintenance_page']);
                }

                $this->values = array_merge($this->defaults, $values);
            }
        }

        $this->enabled = (bool) ($this->values['maintenance_enabled'] ?? false);
    }

    /**
     * @param array<string, mixed> $values
     */
    public function save(array $values): void
    {
        $values = array_merge($this->defaults, $values);
        File::put($this->path, YAML::dump($values));
        $this->values = $values;
        $this->enabled = (bool) ($values['maintenance_enabled'] ?? false);
    }

    /**
     * Get the maintenance mode status.
     *
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * Get the maintenance mode status.
     *
     * @return boolean
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
