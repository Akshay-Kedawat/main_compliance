<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DocumentKeywordTag extends Model
{
    protected $table = 'document_keyword_tags';

    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = null;

    protected $fillable = [
        '_idt_keyword',
        '_idext_document',
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
