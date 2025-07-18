<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentManagementField extends Model
{
    protected $table = 'document_management_fields';

    public $timestamps = false; // since we are using custom datetime fields
    public $incrementing = true; // assuming there is an auto-increment id (if not, you can change this)

    protected $fillable = [
        '_createdby_editor_id',
        '_date_added',
        '_modifiedby_editor_id',
        '_date_modified',
        '_approvedby_editor_id',
        '_date_approved',
        '_is_current_version',
        '_version_number',
    ];
}
