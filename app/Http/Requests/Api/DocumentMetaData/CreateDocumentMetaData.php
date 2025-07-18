<?php

namespace App\Http\Requests\Api\DocumentMetaData;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateDocumentMetaData extends FormRequest
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
            '_type_document'             => 'required',
            '_type_subdivision'          => 'required',
            '_local_identifier'          => 'required',
            '_sortable_identifier'       => 'required',
            '_date_document'             => 'required|date:y-m-d',
            '_date_publication'          => 'required|date:y-m-d',
            '_number'                    => 'required',
            '_year'                      => 'required|integer',
            '_date_latest_update'        => 'required|date',
            '_latest_update'             => 'required',
            '_legal_value'               => 'required',
            '_in_force'                  => 'required',
            '_publisher'                 => 'required',
            '_jurisdiction_federal'      => 'required',
            '_jurisdiction_regional'     => 'required',
            '_jurisdiction_local'        => 'required',
            '_first_date_entry_in_force' => 'required|date:y-m-d',
            '_date_no_longer_in_force'   => 'required|date',																	
            '_crc32_pipeline_checksum'   => 'required|integer',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'  => false,
            'message' => $validator->errors()->first(),
            'data'    => (object)[]
        ]));
    }
}
