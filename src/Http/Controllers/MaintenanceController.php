<?php

namespace SamoSadlaker\StatamicMaintenance\Http\Controllers;

use Illuminate\View\View;
use SamoSadlaker\StatamicMaintenance\Maintenance;
use Statamic\Facades\File;
use Statamic\Facades\YAML;
use Statamic\Fieldtypes\Bard;

class MaintenanceController
{
  /**
   * Display the maintenance mode page.
   *
   * @return View
   */
  public function index()
  {
    $maintenance = new Maintenance();
    $values = $maintenance->getValues() ;
    $html = (new Bard())->augment($values['maintenance_message'] ?? '');

    if(!empty($values) && $values['maintenance_page'] !== null) {
      return view($values['maintenance_page'], [
          'title' => $values['maintenance_title'],
          'maintenance_message' => $html
      ]);
    }
      return view('statamic-maintenance::maintenance', [
          'title' => $values['maintenance_title'] ?? 'Maintenance Mode',
          'maintenance_message' => $html
      ]);
    }

}
