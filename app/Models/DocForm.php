<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocForm extends Model
{
    protected $table = 'doc_forms';
    protected $primaryKey = '_idext_document';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];
}
