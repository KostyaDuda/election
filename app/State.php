<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name','number'];

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
