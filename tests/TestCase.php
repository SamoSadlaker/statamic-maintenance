<?php

namespace SamoSadlaker\StatamicMaintenance\Tests;

use SamoSadlaker\StatamicMaintenance\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
