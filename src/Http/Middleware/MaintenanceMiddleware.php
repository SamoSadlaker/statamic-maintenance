<?php

namespace SamoSadlaker\StatamicMaintenance\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SamoSadlaker\StatamicMaintenance\Maintenance;
use Statamic\Facades\User;

class MaintenanceMiddleware
{

  /**
   * Check if the maintenance mode is activated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|object
   */
  public function handle(Request $request, Closure $next)
  {
    $maintenance = new Maintenance();

    if ($authUser = auth()->user()) {
      $user = User::fromUser($authUser);

      if ($user && ($user->isSuper() || $user->hasPermission('access cp'))) {
        return $next($request);
      }
    }

    $currentRoute = $request->route()?->getName();
    $isMaintenanceRoute = $currentRoute === 'maintenance' || $request->is('maintenance');

    if ($maintenance->isEnabled() === false && $isMaintenanceRoute) {
      return redirect('/');
    }

    if ($maintenance->isEnabled() === false) {
      return $next($request);
    }

    if ($maintenance->isEnabled() === true && $isMaintenanceRoute) {
      return $next($request);
    }

    if ($maintenance->isEnabled() === true && !$isMaintenanceRoute) {
      return redirect('maintenance');
    }

    return $next($request);
  }
}
