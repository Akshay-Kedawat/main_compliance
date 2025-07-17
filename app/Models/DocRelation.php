<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocRelation extends Model
{
    protected $table = 'doc_relations';
    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = null;
    protected $guarded = [];
}
