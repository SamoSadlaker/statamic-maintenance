<?php

namespace SamoSadlaker\StatamicMaintenance\Http\Middleware;

use Illuminate\Support\Str;
use SamoSadlaker\StatamicMaintenance\Maintenance;

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
    $url = Str::start($request->getRequestUri(), '/');
    $maintenance = new Maintenance();
    if (auth()->user() && (auth()->user()->isSuper() || auth()->user()->hasPermission("access cp"))) {
      return $next($request);
    }
    if($maintenance->isEnabled() === false && $url == '/maintenance'){
        return redirect('/');
    }
    if($maintenance->isEnabled() === false){
        return $next($request);
    }
    if ($maintenance->isEnabled() === true && $url == '/maintenance') {
      return $next($request);
    }
    if ($maintenance->isEnabled() === true && $url != '/maintenance') {
      return redirect('maintenance');
    }
    return $next($request);
  }
}
