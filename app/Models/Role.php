<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use HasFactory;

    const ROLE_NAME = [
        'admin'          => 'Admin',
        'legal-reviewer' => 'Legal-Reviewer',
        'data-scientist' => 'Data-Scientist',
        'viewer'         => 'Viewer',
    ];
    const ROLE_TYPE = [
        'Primary'     => 1,
        'Not Primary' => 0
    ];
}
