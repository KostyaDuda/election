<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    protected $fillable = ['district_id','type','status','p1','p2','p3','p4','p5','p6','p7','p8','p9','p10','p11'];

    public function getDstrict()
    {
      return District::find($this->district_id);
    }
}