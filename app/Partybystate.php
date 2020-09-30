<?php

namespace App;
use App\Party;
use App\State;
use Illuminate\Database\Eloquent\Model;

class Partybystate extends Model
{
    //
    protected $fillable = ['type','party_id','state_id'];

    public function getParty()
    {
      return Party::find($this->party_id);
    }

    public function getState()
    {
        return State::find($this->state_id);
    }

    public function getParty_by_id(Candidat $candidat)
    {
      $find = Partybystate::where('id',$candidat->party_id)->first();
      return Party::where('party_id',$find->id);
    }

    // public function getState()
    // {
    //     return State::find($this->state_id);
    // }

}
