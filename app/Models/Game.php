<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name',
        'publisher',
        'image',
        'status',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function getStatusColorAttribute()
    {
        return $this->status == 'active' ? 'green' : 'red';
    }
}
