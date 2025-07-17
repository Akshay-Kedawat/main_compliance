<?php
namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ResetPassword\CreateResetPassword;
use Illuminate\Support\Facades\{DB, Hash};
use Illuminate\Http\Request;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function resetPassword(CreateResetPassword $request)
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            $user->password = Hash::make($request->password);
            $user->save();
                            
            DB::commit();
            $this->status  = true;
            $this->message = trans('message.reset-password');
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
