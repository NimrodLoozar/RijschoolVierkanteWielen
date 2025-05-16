<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ShareMaintenanceMode
{
    public function handle($request, Closure $next)
    {
        $isMaintenanceMode = DB::table('settings')->where('key', 'maintenance_mode')->value('value') ?? false;
        view()->share('isMaintenanceMode', $isMaintenanceMode);

        return $next($request);
    }
}
