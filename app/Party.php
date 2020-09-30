<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = ['name'];

    public function candidats()
    {
        return $this->hasMany(Candidat::class);
    }

    public function getParty_by_id($id)
    {
        return Party::Where('id',$id);
    }
}
