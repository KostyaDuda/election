<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['name','date','adress','number','position','district_id','present_id','priority'];

    public function getPresent()
    {
      return Present::find($this->present_id);
    }

    public function getPresentById($id)
    {
      return Present::find($id);
    }
}
