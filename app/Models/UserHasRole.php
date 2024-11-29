<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserHasRole extends Pivot
{
    protected $table = "user_has_roles";
    protected $primaryKey = ['user_id', 'role_id'];
    protected $keyType = "string";
    public $timestamps = false;
    public $incrementing = false;
    protected $hidden = ['pivot'];
}
