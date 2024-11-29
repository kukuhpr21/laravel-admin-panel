<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserHasMenu extends Pivot
{
    protected $table = "user_has_menus";
    protected $primaryKey = ['user_id', 'menu_id'];
    protected $keyType = "string";
    public $timestamps = false;
    public $incrementing = false;
    protected $hidden = ['pivot'];
}
