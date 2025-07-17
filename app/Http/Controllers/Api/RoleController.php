<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Role\CreateRolePermissionRequest;
use Illuminate\Support\Facades\DB;
use App\Models\{Role, Permission};
use Illuminate\Http\Request;
use JWTAuth;

class RoleController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {
            $role = Role::all();

            if (count($role) > 0) {
                DB::commit();
                $this->status  = true;
                $this->message = trans('message.list-role');
                $this->data    = $role;
            } else {
                DB::rollback();
                $this->status  = false;
                $this->message = trans('message.data_not_found');
                $this->data    = (object) [];
            }
        }catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function assignRolePermission(CreateRolePermissionRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::find($request->role_id);
            
            $permissionNames = Permission::whereIn('id', $request->permission_id)->pluck('id')->toArray();
            $role->syncPermissions($permissionNames);

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.assign-permission');
            $this->data    = (object) [];
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
}
