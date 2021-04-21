<?php

namespace App;
use App\Party;
use App\Partybystate;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    protected $fillable = ['district_id','state_id','type','status','p1','p2','p3','p4','p5','p6','p7','p8','p9','p10','p11','act'];

    public function getDstrict()
    {
      return District::find($this->district_id);
    }

    public function getParty_by_id()
    {
      $find = Partybystate::where('id',$this->party_id)->first();
      return Party::where('party_id',$find->id)->first();
    }

}
