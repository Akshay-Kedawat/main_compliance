<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;

class ProfileController extends Controller
{
    public function getProfile()
    {
        DB::beginTransaction();
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $user->getRoleNames()->first();

            DB::commit();
            $this->status            = true;
            $this->message           = trans('message.my_profile');
            $this->data              = $user;
        }catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function logout()
    {
        DB::beginTransaction();
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            DB::commit();
            $this->status  = true;
            $this->message = trans('message.logout');
            $this->data    = (object) [];
        }catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
}
