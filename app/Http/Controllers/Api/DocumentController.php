<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Document\{CreateDocumentRequest, UpdateCategoryRequest, DeleteCategoryRequest};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Document;
use JWTAuth;

class DocumentController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {
            $paginate = env('PAGINATE');

            $document = Document::with(['user' => function($q) {
                $q->select('id', 'name', 'email');
            }, 'regulation' => function($q) {
                $q->select('id', 'name');
            }])->orderByDesc('id')->paginate($paginate);

            if (count($document) > 0) {
                DB::commit();
                $this->status  = true;
                $this->message = trans('message.list-document');
                $this->data    = $document;
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
    public function store(CreateDocumentRequest $request)
    {
        DB::beginTransaction();
        try {
            $userId = JWTAuth::parseToken()->authenticate()->id;

            if ($request->file('file')) {
                $path = 'uploads/documents/';
                $file = $this->uploadFile($request->file, $path);
            }

            $document                  = new Document;
            $document->user_id         = $userId;
            $document->regulation_id   = $request->regulation_id;
            $document->jurisdiction_id = $request->jurisdiction_id;
            $document->country_id      = $request->country_id;
            $document->category_id     = $request->category_id;
            $document->file            = !empty($request->file) ?
            $file['filePath'] : null;
            $document->save();

            DB::commit();
            $this->status  = true;
            $this->message = trans('message.add-document');
            $this->data    = $document;
        } catch (\Exception $e) {
            DB::rollback();
            $this->status  = false;
            $this->message = $e->getMessage();
            $this->data    = (object) [];
        }
        $this->apiResponse();
    }
}
