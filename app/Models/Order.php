<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
