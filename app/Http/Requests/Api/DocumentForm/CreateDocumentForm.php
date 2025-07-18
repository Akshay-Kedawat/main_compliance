<?php

namespace App\Http\Requests\Api\DocumentForm;

use Illuminate\Foundation\Http\FormRequest;

class CreateDocumentForm extends FormRequest
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
            '_idext_document'        => 'required|string|max:100|unique:document_forms,_idext_document',
            '_form_descriptor'       => 'nullable|string|max:50',
            '_url'                   => 'required|url|max:512',
            '_content_format'        => 'nullable|string|max:50',
            '_language'              => 'required|string|max:5',
            '_crc32_checksum'        => 'nullable|integer',
            '_createdby_editor_id'   => 'nullable|integer',
            '_modifiedby_editor_id'  => 'nullable|integer',
            '_approvedby_editor_id'  => 'nullable|integer',
            '_date_modified'         => 'nullable|date',
            '_date_approved'         => 'nullable|date',
            '_is_current_version'    => 'boolean',
            '_version_number'        => 'integer|min:1',
        ];
    }
}
