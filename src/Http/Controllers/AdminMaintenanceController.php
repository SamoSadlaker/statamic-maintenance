<?php

namespace SamoSadlaker\StatamicMaintenance\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SamoSadlaker\StatamicMaintenance\Blueprints\MaintenanceBlueprint;
use SamoSadlaker\StatamicMaintenance\Maintenance;
use Statamic\CP\PublishForm;
use Statamic\Http\Controllers\CP\CpController;

class AdminMaintenanceController extends CpController
{
    /**
     * Display the maintenance settings page.
     *
     * Statamic 6 ships a built-in PublishForm that renders the standard
     * Control Panel publish form (header, tabs, save button, validation
     * and success toast) straight from a blueprint. No custom assets needed.
     */
    public function index()
    {
        return PublishForm::make((new MaintenanceBlueprint)())
            ->title('Maintenance settings')
            ->icon('utilities')
            ->values((new Maintenance())->getValues())
            ->submittingTo(cp_route('samosadlaker.maintenance.update'), 'PUT');
    }

    /**
     * Update the maintenance settings.
     */
    public function update(Request $request): JsonResponse
    {
        $values = PublishForm::make((new MaintenanceBlueprint)())->submit($request->all());

        (new Maintenance())->save($values);

        return response()->json(['saved' => true]);
    }
}
