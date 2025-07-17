<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function regulation()
    {
        return $this->belongsTo(Regulation::class, 'regulation_id', 'id');
    }
}
