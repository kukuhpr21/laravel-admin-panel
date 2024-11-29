<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleHasMenu extends Pivot
{
    protected $table = "role_has_menus";
    protected $primaryKey = ['role_id', 'menu_id'];
    protected $keyType = "string";
    public $timestamps = false;
    public $incrementing = false;
    protected $hidden = ['pivot'];
}
