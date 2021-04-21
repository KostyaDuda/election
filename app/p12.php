<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class p12 extends Model
{
    protected $fillable = ['protocol_id','type','state_id','party_id','count_voises','by_city','by_state'];
    public function getParty_by_protocol()
    {
      $find = Partybystate::where('id',$this->party_id)->first();
      return Party::where('id',$find->party_id)->first();
    }
}
