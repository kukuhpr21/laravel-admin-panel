<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleHasMenuHasPermission extends Model
{
    protected $table = "role_has_menu_has_permission";
    protected $primaryKey = ['role_id', 'menu_id', 'permission_id'];
    protected $keyType = "string";
    public $timestamps = false;
    public $incrementing = false;
    protected $hidden = ['pivot'];
}
