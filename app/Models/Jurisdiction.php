<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurisdiction extends Model
{
    use SoftDeletes;

    const STATUS = [
        'Inactive' => 0,
        'Active'   => 1,
    ];
}
