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
    protected $enabled = false;

    /**
     * The path to the maintenance file.
     *
     * @var string
     */
    private $path = 'content/maintenance.yaml';

    /**
     * The values from the maintenance file.
     *
     * @var array
     */
    protected $values = null;


    public function __construct()
    {
        if (File::exists($this->path)) {
            $this->values = YAML::parse(File::get($this->path));
            $this->enabled = $this->values['maintenance_enabled'];
        }
    }

    public function save($values)
    {
        File::put($this->path, YAML::dump($values));
    }

    /**
     * Get the maintenance mode status.
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Get the maintenance mode status.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}
