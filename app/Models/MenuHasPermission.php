<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuHasPermission extends Model
{
    protected $table = "menu_has_permissions";
    protected $primaryKey = ['menu_id', 'permission_id'];
    protected $keyType = "string";
    public $timestamps = false;
    public $incrementing = false;
}
