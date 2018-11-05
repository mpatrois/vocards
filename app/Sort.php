<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sort extends Model
{
    protected $fillable = [
        "closed",
        "min",
        "max"
    ];

    protected $casts = [
        'closed' => 'boolean',
    ];

    public function groups()
    {
        return $this->hasMany('App\Group');
    }
}

