<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
   public function assignRolePermissionToUser(Request $request){
        if(auth()->user()->is_admin == 1){
            $user = User::find($request->user_id);

            if($request->role_id){

                $this->assignRole($request,$user);
            }
            if($request->permissions){
                $this->assignPermission($request,$user);
            }

            return response()->json(['status' => 'success', 'data' => $user]);
        }else{
            return response()->json(['status' => 'success', 'data' => 'You do not have permission for this action']);

        }

   }

   protected function assignRole(Request $request,$user){
       $user_role = $user->getRoleNames();
       if(isset($user_role)){

           $removed_role = Role::where('name',$user_role[0])->first();
            $user->removeRole($removed_role);
       }
       $role = Role::find($request->role_id);
       $user->assignRole($role);

   }

    protected function assignPermission(Request $request,$user){
       foreach($request->permissions as $value){
           $permission = Permission::find($value);
           $user->givePermissionTo($permission);
       }
    }


}
