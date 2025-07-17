<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class documentKeywordTag extends Model
{
    protected $table = 'document_keyword_tags';
    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = null;
    protected $guarded = [];
}
