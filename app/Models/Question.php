<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    const TYPE = [
        'single-choice'   => 'single-choice',
        'multiple-choice' => 'multiple-choice',
        'short-answer'    => 'text',
        'true-false'      => 'boolean',
    ];
}
