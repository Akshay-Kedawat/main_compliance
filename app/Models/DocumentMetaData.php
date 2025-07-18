<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentMetaData extends Model
{
    protected $table = 'document_meta_data';

    protected $fillable = [
        '_idext_document',
        '_type_document',
        '_type_subdivision',
        '_local_identifier',
        '_sortable_identifier',
        '_date_document',
        '_date_publication',
        '_number',
        '_year',
        '_date_latest_update',
        '_latest_update',
        '_legal_value',
        '_in_force',
        '_publisher',
        '_jurisdiction_federal',
        '_jurisdiction_regional',
        '_jurisdiction_local',
        '_first_date_entry_in_force',
        '_date_no_longer_in_force',
        '_crc32_pipeline_checksum',
        'response_json'
    ];
}
