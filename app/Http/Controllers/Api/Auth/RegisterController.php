<?php
namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Register\CreateRegisterRequest;
use Illuminate\Support\Facades\{DB, Hash};
use Illuminate\Http\Request;
use App\Models\{User, Role};


class RegisterController extends Controller
{
    public function register(CreateRegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $legalReviewer = Role::ROLE_NAME['legal-reviewer'];

            $user                = new User;
            $user->name          = $request->name;
            $user->email         = $request->email;
            $user->mobile_number = $request->mobile_number;
            $user->password      = Hash::make($request->password);
            $user->status        = User::STATUS['Active'];
            $user->save();
            $user->assignRole($legalReviewer);

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.registration');
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
