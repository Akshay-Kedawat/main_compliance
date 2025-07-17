<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\{CreateUserRequest, UpdateUserRequest, DeleteUserRequest};
use Illuminate\Support\Facades\{DB, Hash};
use Illuminate\Http\Request;
use App\Models\{User, Role};
use JWTAuth;

class UserController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {
            $admin = Role::ROLE_NAME['admin'];

            $user = User::with('roles')->whereDoesntHave('roles', function($q) use($admin) {
                $q->where('name', $admin);
            })->orderByDesc('id')->get();

            if (count($user) > 0) {
                DB::commit();
                $this->status  = true;
                $this->message = trans('message.list-user');
                $this->data    = $user;
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
    public function store(CreateUserRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->file('file')) {
                $path = 'uploads/users/profile_picture/';
                $file = $this->uploadFile($request->profile_picture, $path);
            }

            $user                  = new User;
            $user->name            = $request->name;
            $user->email           = $request->email;
            $user->mobile_number   = $request->mobile_number;
            $user->password        = Hash::make($request->password);
            $user->profile_picture = !empty($request->profile_picture) ?
            $file['filePath'] : null;
            $user->status          = User::STATUS['Active'];
            $user->save();
            $user->assignRole($request->role_name);

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.add-user');
            $this->data    = $user;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function update(UpdateUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::find($request->user_id);

            if ($request->file('profile_picture')) {
                $this->unlinkFile($user->profile_picture);

                $path = 'uploads/users/profile_picture/';
                $file = $this->uploadFile($request->profile_picture, $path);
            }
            
            $user->name            = $request->name;
            $user->email           = $request->email;
            $user->mobile_number   = $request->mobile_number;
            $user->profile_picture = !empty($request->profile_picture) ? $file['filePath'] : $user->profile_picture;
            $user->save();

            $user->syncRoles($request->role_name);
            
            DB::commit();
            $this->status  = true;
            $this->message = trans('message.update-user');
            $this->data    = $user;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function destroy(DeleteUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::find($request->user_id);
            $this->unlinkFile($user->profile_picture);
            $user->roles()->detach();
            $user->delete();
            
            DB::commit();
            $this->status  = true;
            $this->message = trans('message.delete-user');
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
