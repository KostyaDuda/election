<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class p14 extends Model
{
    protected $fillable = ['protocol_id','type','party_id','candidat_id','state_id','count_voises','by_city','by_state'];

    public function getCandidat_by_protocol($id)
    {
      $find = Partybystate::where('id',$id)->first();
      $party = Party::where('id',$find->party_id)->first();
      return Candidat::where('party_id',$party->id)->get();
    }

    

    public function getParty()
    {
      $party = partybystate::where('id',$this->party_id)-first();
    }

    public function getCandidat_all($id)
    {
      return Candidat::where('party_id',$id)->get();
    }

    public function getCandidat()
    {
      return Candidat::where('id',$this->candidat_id)->first();
    }

    public function getDistrict()
    {

      return Protocol::where('id',$this->protocol_id)->first();
    }

}
