<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $fillable = ['name'];
    public function warriors(): HasMany
    {
        return $this->hasMany(Warrior::class);
    }
}
