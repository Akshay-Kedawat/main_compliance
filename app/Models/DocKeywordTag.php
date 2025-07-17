<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocKeywordTag extends Model
{
    protected $table = 'doc_keyword_tags';
    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = null;
    protected $guarded = [];
}
