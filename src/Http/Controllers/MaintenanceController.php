<?php

namespace SamoSadlaker\StatamicMaintenance\Http\Controllers;

use Illuminate\View\View;
use SamoSadlaker\StatamicMaintenance\Maintenance;
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
    $values = $maintenance->getValues();
    $html = (new Bard())->augment($values['maintenance_message'] ?? []);

    $useDefault = $values['maintenance_use_default_page'] ?? true;
    $page = $values['maintenance_page'] ?? null;

    if (!$useDefault && !empty($page)) {
      return view($page, [
        'title' => $values['maintenance_title'] ?? 'Maintenance Mode',
        'maintenance_message' => $html
      ]);
    }
    return view('statamic-maintenance::maintenance', [
      'title' => $values['maintenance_title'] ?? 'Maintenance Mode',
      'maintenance_message' => $html
    ]);
  }

}
