<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        "title",
        "duration",
        "description",
        "url",
    ];

    public function groups()
    {
        return $this->belongsToMany('App\group');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }



}
