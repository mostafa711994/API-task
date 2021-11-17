<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register',[App\Http\Controllers\Api\UserController::class,'register']);
Route::post('/login',[App\Http\Controllers\Api\LoginController::class,'login']);

Route::group(['middleware'=>['auth:api']],function (){
    Route::post('/create/permission',[App\Http\Controllers\Api\Permission\PermissionController::class,'createPermission']);
    Route::get('/permissions',[App\Http\Controllers\Api\Permission\PermissionController::class,'permissions']);
    Route::post('/create/role',[App\Http\Controllers\Api\Permission\RoleController::class,'createRole']);
    Route::post('/role/assign/permission',[App\Http\Controllers\Api\Permission\RoleController::class,'assignPermissionToRole']);
    Route::get('/roles',[App\Http\Controllers\Api\Permission\RoleController::class,'roles']);
    Route::get('/profile',[App\Http\Controllers\Api\UserController::class,'profile']);
    Route::get('/logout',[App\Http\Controllers\Api\LoginController::class,'logout']);
    Route::post('/assign-role-permission',[App\Http\Controllers\Api\Admin\AdminController::class,'assignRolePermissionToUser']);

});



