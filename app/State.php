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

    public function candidats()
    {
        return $this->hasMany(Candidat::class);
    }

    public function getState_by_id($id)
    {
        return State::Where('id',$id);
    }
}
