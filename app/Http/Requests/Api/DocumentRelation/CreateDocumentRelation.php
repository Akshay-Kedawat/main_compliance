<?php

namespace App\Http\Requests\Api\DocumentRelation;

use Illuminate\Foundation\Http\FormRequest;

class CreateDocumentRelation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '_source_idext_document'   => 'required|string|max:100',
            '_target_idext_document'   => 'required|string|max:100|different:_source_idext_document',
            '_id_document_xref_type'   => 'required|integer',
            '_date_source'             => 'nullable|date',
            '_date_target'             => 'nullable|date',
            '_rel_direction'           => 'nullable|integer',
            '_crc32_checksum'          => 'nullable|integer',
            '_createdby_editor_id'     => 'nullable|integer',
            '_modifiedby_editor_id'    => 'nullable|integer',
            '_approvedby_editor_id'    => 'nullable|integer',
            '_date_modified'           => 'nullable|date',
            '_date_approved'           => 'nullable|date',
            '_is_current_version'      => 'boolean',
            '_version_number'          => 'integer|min:1',
        ];
    }
}
