<?php

namespace App\Http\Controllers\State;

use App\State;
use App\District;
use App\Partybystate;
use App\Party;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StateController extends Controller
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
        $states=State::all();
        return view('State/index',compact('states'));
    }

    public function candidats_(State $state)
    {

        $parties=Partybystate::where('state_id',$state->id)->get();
        return view('State/candidats',compact('parties','state'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('State/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        State::create($request->all());
        return redirect()->route('states.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        $districts = District::where('state_id',$state->id)->get();
        $count=District::where('state_id',$state->id)->count();
        dd($districts);
        return view('State/show', compact('state','districts','count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        return view('State/update',compact('state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        $state->update($request->all());
        return redirect()->route('states.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
            $state->delete();
            return redirect()->route('states.index');
    }
    public function destroy_all(State $state)
    {
        $districts = District::where('state_id',$state->id)->get();
        foreach($districts as $district)
        {
            $district->delete();
        }
        return redirect()->route('states.index');
    }
}
