<?php

namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgotPassword\CreateForgotPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(CreateForgotPassword $request)
    {
        DB::beginTransaction();
        try {
            $user = User::where(['email' => $request->email])->first();
                            
            DB::commit();
            $this->status  = true;
            $this->message = trans('message.forgot-password');
            $this->data    = $user;
        }catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
}
