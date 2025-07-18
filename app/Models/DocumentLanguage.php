<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentLanguage extends Model
{

    protected $fillable = [
        '_idext_document',
        '_language',
        '_title',
        '_title_alternative',
        '_title_short',
        '_crc32_checksum',
        'response_json',
    ];
}
