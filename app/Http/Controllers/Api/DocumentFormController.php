<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DocumentForm\CreateDocumentForm;
use App\Models\documentForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use JWTAuth;

class DocumentFormController extends Controller
{
    /**
     * List document forms
     */
    public function index(Request $request)
    {
        try {
            $query = DocumentForm::query();

            if ($request->filled('_form_descriptor')) {
                $query->where('_form_descriptor', 'like', '%' . $request->_form_descriptor . '%');
            }

            $documents = $query->orderByDesc('_date_added')
                ->paginate(env('PAGINATE', 10));

            return response()->json([
                'status'  => true,
                'message' => $documents->isEmpty()
                    ? 'No document forms found.'
                    : 'Document forms retrieved successfully.',
                'data'    => $documents,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Server Error: ' . $e->getMessage(),
                'data'    => [],
            ], 500);
        }
    }

    /**
     * Store a new document form
     */
    public function store(CreateDocumentForm $request)
    {
        DB::beginTransaction();

        try {
            $document = DocumentForm::create([
                '_idext_document'        => $request->_idext_document,
                '_form_descriptor'       => $request->_form_descriptor,
                '_url'                   => $request->_url,
                '_content_format'        => $request->_content_format,
                '_language'              => $request->_language,
                '_crc32_checksum'        => $request->_crc32_checksum,
                '_createdby_editor_id'   => $request->_createdby_editor_id,
                '_date_added'            => now(),
                '_modifiedby_editor_id'  => $request->_modifiedby_editor_id,
                '_date_modified'         => $request->_date_modified,
                '_approvedby_editor_id'  => $request->_approvedby_editor_id,
                '_date_approved'         => $request->_date_approved,
                '_is_current_version'    => $request->_is_current_version ?? true,
                '_version_number'        => $request->_version_number ?? 1,
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Document form created successfully.',
                'data'    => $document,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Server Error: ' . $e->getMessage(),
                'data'    => null,
            ], 500);
        }
    }

}
