<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pmayor extends Model
{
    protected $fillable = ['protocol_id','mayor_id','count_voises'];

    public function getMayor()
    {
      return Mayor::where('id',$this->mayor_id)->first();
    }
}
