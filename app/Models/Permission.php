<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "permissions";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $timestamps = false;
    public $incrementing = false;
}
