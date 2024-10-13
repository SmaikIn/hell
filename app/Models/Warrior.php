<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warrior extends Model
{
    protected $fillable = [
        'name',
        'role_id',
        'group_id'
    ];

    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
