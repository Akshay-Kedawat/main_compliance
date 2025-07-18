<?php

namespace App\Http\Requests\Api\DocumentManagementField;

use Illuminate\Foundation\Http\FormRequest;

class CreateDocumentManagementField extends FormRequest
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
            '_createdby_editor_id'   => 'nullable|integer',
            '_date_added'            => 'nullable|date',
            '_modifiedby_editor_id'  => 'nullable|integer',
            '_date_modified'         => 'nullable|date',
            '_approvedby_editor_id'  => 'nullable|integer',
            '_date_approved'         => 'nullable|date',
            '_is_current_version'    => 'boolean',
            '_version_number'        => 'integer|min:1',
        ];
    }
}
