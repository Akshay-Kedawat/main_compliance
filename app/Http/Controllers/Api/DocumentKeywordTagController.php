<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DocumentKeywordTag\CreateDocumentKeywordTag;
use App\Models\DocumentKeywordTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentKeywordTagController extends Controller
{
        /**
     * List keyword tags with optional filters
     */
    public function index(Request $request)
    {
        try {
            $query = DocumentKeywordTag::query();

            if ($request->filled('_idt_keyword')) {
                $query->where('_idt_keyword', $request->_idt_keyword);
            }

            if ($request->filled('_idext_document')) {
                $query->where('_idext_document', $request->_idext_document);
            }

            $tags = $query->orderByDesc('_date_added')->paginate(env('PAGINATE', 10));

            return response()->json([
                'status'  => true,
                'message' => $tags->isEmpty()
                    ? 'No keyword tags found.'
                    : 'Keyword tags retrieved successfully.',
                'data'    => $tags,
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
     * Store a new keyword tag for a document
     */
    public function store(CreateDocumentKeywordTag $request)
    {
        DB::beginTransaction();

        try {
            $exists = DocumentKeywordTag::where('_idt_keyword', $request->_idt_keyword)
                ->where('_idext_document', $request->_idext_document)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status'  => false,
                    'message' => 'This keyword tag already exists for the document.',
                    'data'    => null,
                ], 409);
            }

            $tag = DocumentKeywordTag::create([
                '_idt_keyword'          => $request->_idt_keyword,
                '_idext_document'       => $request->_idext_document,
                '_crc32_checksum'       => $request->_crc32_checksum,
                '_createdby_editor_id'  => $request->_createdby_editor_id,
                '_date_added'           => now(),
                '_modifiedby_editor_id' => $request->_modifiedby_editor_id,
                '_date_modified'        => $request->_date_modified,
                '_approvedby_editor_id' => $request->_approvedby_editor_id,
                '_date_approved'        => $request->_date_approved,
                '_is_current_version'   => $request->_is_current_version ?? true,
                '_version_number'       => $request->_version_number ?? 1,
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Keyword tag added successfully.',
                'data'    => $tag,
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
