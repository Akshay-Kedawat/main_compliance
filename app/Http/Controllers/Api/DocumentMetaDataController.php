<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\{DocumentMetaData,DocumentLanguage};
use Illuminate\Http\Request;

class DocumentMetaDataController extends Controller
{
    public function getDocumentMetaData()
    {
        DB::beginTransaction();
        try {
            $documentMetaData = DocumentMetaData::all();
            if (count($documentMetaData) > 0) {
                DB::commit();
                $this->status  = true;
                $this->message = trans('message.list-document-meta-data');
                $this->data    = $documentMetaData;
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
    public function storeDocumentMetaData(Request $request)
    {
        DB::beginTransaction();
        try {
            $documentMetaData = DocumentMetaData::create($request->all());
            
            
            DB::commit();
            $this->status  = true;
            $this->message = trans('message.add-document-meta-data');
            $this->data    = $documentMetaData;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
    public function storeDocumentLanguage(Request $request)
    {
        DB::beginTransaction();
        try {
            $documentLanguage = DocumentLanguage::create($request->all());
            
            DB::commit();
            $this->status  = true;
            $this->message = trans('message.add-document-language');
            $this->data    = $documentLanguage;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
}
