<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    protected $table = "menus";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = false;
    public $incrementing = true;
    protected $hidden = ['pivot'];
    protected $guarded = [];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->using(RoleHasMenu::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(UserHasMenu::class);
    }
}
