<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Jurisdiction\{CreateJurisdictionRequest, UpdateJurisdictionRequest, DeleteJurisdictionRequest};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Jurisdiction;

class JurisdictionController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {
            $active = Jurisdiction::STATUS['Active'];
            $jurisdiction = Jurisdiction::where('status', $active)->orderByDesc('id')->get();

            if (count($jurisdiction) > 0) {
                DB::commit();
                $this->status  = true;
                $this->message = trans('message.list-jurisdiction');
                $this->data    = $jurisdiction;
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
    public function store(CreateJurisdictionRequest $request)
    {
        DB::beginTransaction();
        try {
            $active = Jurisdiction::STATUS['Active'];

            $jurisdiction         = new Jurisdiction;
            $jurisdiction->name   = $request->name;
            $jurisdiction->status = $active;
            $jurisdiction->save();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.add-jurisdiction');
            $this->data    = $jurisdiction;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function update(UpdateJurisdictionRequest $request)
    {
        DB::beginTransaction();
        try {
            $jurisdiction = Jurisdiction::find($request->jurisdiction_id);
            $jurisdiction->name   = $request->name;
            $jurisdiction->save();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.update-jurisdiction');
            $this->data    = $jurisdiction;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function destroy(DeleteJurisdictionRequest $request)
    {
        DB::beginTransaction();
        try {
            Jurisdiction::find($request->jurisdiction_id)->delete();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.delete-jurisdiction');
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
