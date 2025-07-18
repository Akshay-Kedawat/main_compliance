<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DocumentManagementField\CreateDocumentManagementField;
use App\Models\DocumentManagementField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentManagementFieldController extends Controller
{    /**
     * List document management field records with optional filtering
     */
    public function index(Request $request)
    {
        try {
            $query = DocumentManagementField::query();

            if ($request->filled('_createdby_editor_id')) {
                $query->where('_createdby_editor_id', $request->_createdby_editor_id);
            }

            if ($request->filled('_approvedby_editor_id')) {
                $query->where('_approvedby_editor_id', $request->_approvedby_editor_id);
            }

            $records = $query->orderByDesc('_date_added')
                             ->paginate(env('PAGINATE', 10));

            return response()->json([
                'status'  => true,
                'message' => $records->isEmpty()
                    ? 'No matching records found.'
                    : 'Document management fields retrieved successfully.',
                'data'    => $records,
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
     * Store a new document management field record
     */
    public function store(CreateDocumentManagementField $request)
    {
        DB::beginTransaction();

        try {
            $record = DocumentManagementField::create([
                '_createdby_editor_id'   => $request->_createdby_editor_id,
                '_date_added'            => $request->_date_added ?? now(),
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
                'message' => 'Document management field created successfully.',
                'data'    => $record,
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
