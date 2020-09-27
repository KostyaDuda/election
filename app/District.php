<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['id','state_id','type','adress'];
    
    // public function state_()
    // {
    //   return $this->belongsTo(State::class);
    // }

    public function getState()
    {
      return State::find($this->state_id);
    }

}

