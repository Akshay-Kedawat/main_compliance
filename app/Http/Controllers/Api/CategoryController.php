<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Category\{CreateCategoryRequest, UpdateCategoryRequest, DeleteCategoryRequest};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use JWTAuth;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:list-category', ['only' => ['index']]);
        $this->middleware('permission:add-category', ['only' => ['store']]);
        $this->middleware('permission:edit-category', ['only' => ['update']]);
        $this->middleware('permission:delete-category', ['only' => ['destroy']]);
    }
    public function index()
    {
        DB::beginTransaction();
        try {
            $active = Category::STATUS['Active'];
            $category = Category::where('status', $active)->orderByDesc('id')->get();

            if (count($category) > 0) {
                DB::commit();
                $this->status  = true;
                $this->message = trans('message.list-category');
                $this->data    = $category;
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
    public function store(CreateCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $active = Category::STATUS['Active'];

            $category         = new Category;
            $category->name   = $request->name;
            $category->status = $active;
            $category->save();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.add-category');
            $this->data    = $category;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function update(UpdateCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $category = Category::find($request->category_id);
            $category->name   = $request->name;
            $category->save();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.update-category');
            $this->data    = $category;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function destroy(DeleteCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            Category::find($request->category_id)->delete();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.delete-category');
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
