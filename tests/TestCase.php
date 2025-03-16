<?php

namespace Samosadlaker\StatamicMaintenance\Tests;

use Samosadlaker\StatamicMaintenance\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
