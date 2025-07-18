<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DocumentRelation extends Model
{
    // use SoftDeletes;

    protected $table = 'document_relations';

    // Composite primary key - manually handle uniqueness
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        '_source_idext_document',
        '_target_idext_document',
        '_id_document_xref_type',
        '_date_source',
        '_date_target',
        '_rel_direction',
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
}
