<?php
namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Login\CreateLoginRequest;
use Illuminate\Support\Facades\{Hash, DB};
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;


class LoginController extends Controller
{
    public function login(CreateLoginRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::where(['email' => $request->email])->first();
            if (!empty($user) && Hash::check($request['password'], $user->password)) {
                $user->getRoleNames()->first();
                $jwtToken = JWTAuth::fromUser($user);
                
                DB::commit();
                $this->status  = true;
                $this->code    = 201;
                $this->expires = auth('api')->factory()->getTTL();
                $this->message = trans('message.login');
                $this->data    = $user;
                $this->type    = 'bearer';
                $this->token   = $jwtToken;
            } else {
                DB::rollback();
                $this->status  = false;
                $this->message = trans('message.credentials_not_match');
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
