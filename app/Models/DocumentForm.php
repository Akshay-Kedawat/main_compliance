<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class documentForm extends Model
{
    protected $table = 'document_forms';
    protected $primaryKey = '_idext_document';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];
}
