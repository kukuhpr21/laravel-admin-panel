<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Status extends Model
{
    protected $table = "statuses";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $timestamps = false;
    public $incrementing = false;

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
