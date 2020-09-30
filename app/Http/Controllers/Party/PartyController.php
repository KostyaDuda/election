<?php

namespace App\Http\Controllers\Party;

use App\Party;
use App\Partybystate;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $parties=Party::all();
        return view('Party/index',compact('parties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Party/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $states=State::all();
          Party::create($request->all());
          $party = Party::where('name',$request->name)->first();
          $types = ['Місто','Район','Область'];
        foreach($types as $type)
        {
          if($type == 'Місто')
          {
             foreach($states as $state)
             {
                 $pbs = new Partybystate;
                 $pbs->type = $type;
                 $pbs->party_id = $party->id;
                 $pbs->state_id = $state->id;
                 Partybystate::create($pbs->toArray()); 
             }
          }
          else
          {
              $pbs = new Partybystate;
              $pbs->type = $type;
              $pbs->party_id = $party->id;
              $pbs->state_id = null;
              Partybystate::create($pbs->toArray()); 
          }
        }
        return redirect()->route('parties.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function show(Party $party)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function edit(Party $party)
    {
        return view('Party/update',compact('party'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Party $party)
    {
        $states=State::all();
        $party->update($request->all());
        $party_new = Party::where('name',$request->name)->first();
        $parties = Partybystate::where('party_id',$party_new->id)->get();
        foreach($parties as $party_)
        {
            $party_->delete();    
        }

        if($request->type == 'Місто')
          {
             foreach($states as $state)
             {
                 $pbs = new Partybystate;
                 $pbs->party_id = $party->id;
                 $pbs->state_id = $state->id;
                 Partybystate::create($pbs->toArray()); 
             }
          }
          else
          {
              $pbs = new Partybystate;
              $pbs->party_id = $party->id;
              $pbs->state_id = null;
              Partybystate::create($pbs->toArray()); 
          }

        return redirect()->route('parties.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party $party)
    {
        $parties = Partybystate::where('party_id',$party->id)->get();
        foreach($parties as $party_)
        {
            $party_->delete();    
        }
        $party->delete();
        return redirect()->route('parties.index');
    }
}
