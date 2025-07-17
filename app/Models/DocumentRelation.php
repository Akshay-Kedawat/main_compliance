<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class documentRelation extends Model
{
    protected $table = 'document_relations';
    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = null;
    protected $guarded = [];
}
