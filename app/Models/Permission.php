<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $table = "permissions";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $timestamps = false;
    public $incrementing = false;
    protected $hidden = ['pivot'];

    protected $guarded = [];

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'menu_has_permissions');
    }
}
