<?php

namespace App;
use App\Party;
use App\State;
use Illuminate\Database\Eloquent\Model;

class Partybystate extends Model
{
    //
    protected $fillable = ['party_id','state_id'];

}
