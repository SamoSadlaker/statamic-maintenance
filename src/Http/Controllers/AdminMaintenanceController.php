<?php
namespace SamoSadlaker\StatamicMaintenance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use SamoSadlaker\StatamicMaintenance\Blueprints\MaintenanceBlueprint;
use SamoSadlaker\StatamicMaintenance\Maintenance;
use Statamic\Http\Controllers\CP\CpController;

class AdminMaintenanceController extends CpController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
  /**
   * Display the maintenance settings page.
   *
   * @return View
   */
  public function index(): View
  {
    $blueprint = new MaintenanceBlueprint();
    $fields = $blueprint()->fields()->preProcess();
    $values = (new Maintenance())->getValues() ?? $fields->values();

    return view('statamic-maintenance::cp.index', [
      'blueprint' => $blueprint()->toPublishArray(),
      'values' => $values,
      'meta' => $fields->meta(),
    ]);
  }

    /**
     * Update the maintenance settings.
     *
     * @param Request $request
     * @return true
     */
    public function update(Request $request)
    {
        $blueprint = new MaintenanceBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        (new Maintenance())->save($fields->process()->values()->all());
        return true;
    }
}
