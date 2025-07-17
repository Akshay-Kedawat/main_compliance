<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use JWTAuth;

class PermissionController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {
            $permission = Permission::all();

            if (count($permission) > 0) {
                DB::commit();
                $this->status  = true;
                $this->message = trans('message.list-permission');
                $this->data    = $permission;
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
}
