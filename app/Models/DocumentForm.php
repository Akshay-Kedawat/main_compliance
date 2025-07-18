<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class documentForm extends Model
{

    // use SoftDeletes;

    protected $table = 'document_forms';

    protected $primaryKey = '_idext_document';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        '_idext_document',
        '_form_descriptor',
        '_url',
        '_content_format',
        '_language',
        '_crc32_checksum',
        '_createdby_editor_id',
        '_date_added',
        '_modifiedby_editor_id',
        '_date_modified',
        '_approvedby_editor_id',
        '_date_approved',
        '_is_current_version',
        '_version_number',
    ];

    public $timestamps = false; // since you're manually handling date fields
}
