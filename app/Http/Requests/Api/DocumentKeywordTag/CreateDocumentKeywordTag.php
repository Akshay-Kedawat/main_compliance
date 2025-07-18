<?php

namespace App\Http\Requests\Api\DocumentKeywordTag;

use Illuminate\Foundation\Http\FormRequest;

class CreateDocumentKeywordTag extends FormRequest
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
            '_idt_keyword'          => 'required|string|max:100',
            '_idext_document'       => 'required|string|max:100|different:_idt_keyword',
            '_crc32_checksum'       => 'nullable|integer',
            '_createdby_editor_id'  => 'nullable|integer',
            '_modifiedby_editor_id' => 'nullable|integer',
            '_approvedby_editor_id' => 'nullable|integer',
            '_date_modified'        => 'nullable|date',
            '_date_approved'        => 'nullable|date',
            '_is_current_version'   => 'boolean',
            '_version_number'       => 'integer|min:1',
        ];
    }
}
