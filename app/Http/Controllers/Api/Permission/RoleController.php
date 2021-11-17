<?php

namespace App\Http\Controllers\Api\Permission;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function createRole(Request $request)
    {
        if (auth()->user()->is_admin == 1) {
            $request->validate([
                'name' => 'required'
            ]);
            $role = Role::create(['name' => $request->name]);

            $role->syncPermissions($request->permissions);

            return response()->json(['status' => 'success', 'data' => $role]);

        } else {
            return response()->json(['status' => 'success', 'data' => 'You do not have permission for this action']);

        }

    }

    public function roles()
    {

        if (auth()->user()->is_admin == 1) {

            $roles = Role::all();
            foreach ($roles as $role) {
                $role->permissions;
            }
            if ($roles->count() > 0) {
                return response()->json(['status' => 'success', 'data' => $roles]);

            }

            return response()->json(['status' => 'error', 'data' => 'No Permissions Found']);

        } else {
            return response()->json(['status' => 'success', 'data' => 'You do not have permission for this action']);

        }

    }


    public function assignPermissionToRole(Request $request)
    {

        if (auth()->user()->is_admin == 1) {
            $role = Role::find($request->role_id);

            $role->syncPermissions($request->permissions);

            if (isset($role)) {
                return response()->json(['status' => 'success', 'data' => $role]);

            } else {
                return response()->json(['status' => 'error', 'data' => 'Role Not Found']);

            }

        } else {
            return response()->json(['status' => 'success', 'data' => 'You do not have permission for this action']);

        }


    }


}
