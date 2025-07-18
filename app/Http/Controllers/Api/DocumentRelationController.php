<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DocumentRelation\CreateDocumentRelation;
use App\Models\DocumentRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentRelationController extends Controller
{
    /**
     * List document relations with optional filtering
     */
    public function index(Request $request)
    {
        try {
            $query = DocumentRelation::query();

            if ($request->filled('_source_idext_document')) {
                $query->where('_source_idext_document', $request->_source_idext_document);
            }

            if ($request->filled('_target_idext_document')) {
                $query->where('_target_idext_document', $request->_target_idext_document);
            }

            $relations = $query->orderByDesc('_date_added')
                               ->paginate(env('PAGINATE', 10));

            return response()->json([
                'status'  => true,
                'message' => $relations->isEmpty()
                    ? 'No matching document relations found.'
                    : 'Document relations retrieved successfully.',
                'data'    => $relations,
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
     * Store a new document relation
     */
    public function store(CreateDocumentRelation $request)
    {
        DB::beginTransaction();

        try {
            // Check for duplicate key (composite primary)
            $exists = DocumentRelation::where('_source_idext_document', $request->_source_idext_document)
                ->where('_target_idext_document', $request->_target_idext_document)
                ->where('_id_document_xref_type', $request->_id_document_xref_type)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status'  => false,
                    'message' => 'This document relation already exists.',
                    'data'    => null,
                ], 409);
            }

            $relation = DocumentRelation::create([
                '_source_idext_document' => $request->_source_idext_document,
                '_target_idext_document' => $request->_target_idext_document,
                '_id_document_xref_type' => $request->_id_document_xref_type,
                '_date_source'           => $request->_date_source,
                '_date_target'           => $request->_date_target,
                '_rel_direction'         => $request->_rel_direction,
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
                'message' => 'Document relation created successfully.',
                'data'    => $relation,
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
