<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    //
    protected $fillable = ['number','name','date','party_id'];

    // public function getParty()
    // {
    //   return Party::find($this->party_id);
    // }

    // public function getState()
    // {
    //   return State::find($this->state_id);
    // }
    public function getParty_by_id($candidat)
    {
      $find = Partybystate::where('id',$candidat)->first();
      return Party::where('id',$find->party_id)->first();
    }

}
