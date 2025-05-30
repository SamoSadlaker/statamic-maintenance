<?php

namespace SamoSadlaker\StatamicMaintenance\Http\Middleware;

use SamoSadlaker\StatamicMaintenance\Maintenance;
use \Statamic\Facades\User;

class MaintenanceMiddleware
{

  /**
   * Check if the maintenance mode is activated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|object
   */
  public function handle($request, $next)
  {
    $maintenance = new Maintenance();
    $user = User::fromUser(auth()->user());
    if (auth()->user() && ($user->isSuper() || $user->hasPermission('access cp'))) {
      return $next($request);
    }
    $currentRoute = $request->route()->getName();
    if ($maintenance->isEnabled() === false && $currentRoute === 'maintenance') {
      return redirect('/');
    }
    if ($maintenance->isEnabled() === false) {
      return $next($request);
    }
    if ($maintenance->isEnabled() === true && $currentRoute === 'maintenance') {
      return $next($request);
    }
    if ($maintenance->isEnabled() === true && $currentRoute !== 'maintenance') {
      return redirect('maintenance');
    }
    return $next($request);
  }
}
