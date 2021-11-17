<?php

namespace App\Http\Controllers\Api\Permission;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function createPermission(Request $request)
    {

        if (auth()->user()->is_admin == 1) {
            $request->validate(['name' => 'required']);

            $permission = Permission::create(['name' => $request->name]);

            return response()->json(['status' => 'success', 'data' => $permission]);
        } else {
            return response()->json(['status' => 'success', 'data' => 'You do not have permission for this action']);

        }
    }

    public function permissions()
    {
        if (auth()->user()->is_admin == 1) {
            $permissions = Permission::all();
            if ($permissions->count() > 0) {
                return response()->json(['status' => 'success', 'data' => $permissions]);

            }

            return response()->json(['status' => 'error', 'data' => 'No Permissions Found']);
        } else {
            return response()->json(['status' => 'success', 'data' => 'You do not have permission for this action']);

        }

    }


}
