<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    public function toggle(Request $request)
    {
        $isMaintenanceMode = $request->has('maintenance_mode');
        DB::table('settings')->updateOrInsert(
            ['key' => 'maintenance_mode'],
            ['value' => $isMaintenanceMode]
        );

        return redirect()->back()->with('status', 'Maintenance mode updated successfully.');
    }
}
