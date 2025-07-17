<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Regulation\{CreateRegulationRequest, UpdateRegulationRequest, DeleteRegulationRequest};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Regulation;

class RegulationController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {
            $active = Regulation::STATUS['Active'];
            $regulation = Regulation::where('status', $active)->orderByDesc('id')->get();

            if (count($regulation) > 0) {
                DB::commit();
                $this->status  = true;
                $this->message = trans('message.list-regulation');
                $this->data    = $regulation;
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
    public function store(CreateRegulationRequest $request)
    {
        DB::beginTransaction();
        try {
            $active = Regulation::STATUS['Active'];

            $regulation         = new Regulation;
            $regulation->name   = $request->name;
            $regulation->status = $active;
            $regulation->save();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.add-regulation');
            $this->data    = $regulation;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function update(UpdateRegulationRequest $request)
    {
        DB::beginTransaction();
        try {
            $regulation = Regulation::find($request->regulation_id);
            $regulation->name   = $request->name;
            $regulation->save();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.update-regulation');
            $this->data    = $regulation;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function destroy(DeleteRegulationRequest $request)
    {
        DB::beginTransaction();
        try {
            Regulation::find($request->regulation_id)->delete();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.delete-regulation');
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
