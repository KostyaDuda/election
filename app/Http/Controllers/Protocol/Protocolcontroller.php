<?php

namespace App\Http\Controllers\Protocol;

use App\Protocol;
use App\Party;
use App\Mayor;
use App\State;
use App\Partybystate;
use App\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Protocolcontroller extends Controller
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
        $count = Protocol::where('status',1)->count();

        $protocols_city=Protocol::where('type','Місто')->get();
        $count_city=Protocol::where('type','Місто')->count();

        $protocols_rayon_=Protocol::where('type','Район')->get();
        $count_rayon_=Protocol::where('type','Район')->count();

        $protocols_oblast_=Protocol::where('type','Область')->get();
        $count_oblast_=Protocol::where('type','Область')->count();

        $protocols_mayor_=Protocol::where('type','Мер')->get();
        $count_mayor_=Protocol::where('type','Мер')->count();

        return view('Protocol/index',compact(
            'protocols_city',
            'protocols_rayon_',
            'protocols_oblast_',
            'protocols_mayor_',
            'count',
            'count_city',
            'count_rayon_',
            'count_oblast_',
            'count_mayor_'
    ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Protocol/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $district_check = District::where('id',$request->district_id)->count();
        $protocol_check = Protocol::where('district_id',$request->district_id)->where('type',$request->type)->count();
        if($district_check == 0)
        {
            return back()->withErrors([
                'message' => 'Такої дільниця немає в реєстрі'
            ]);
        }
        else if($protocol_check > 0)
        {
            return back()->withErrors([
                'message' => 'Протокол з даною дільницею вже внесений'
            ]);
        }
        else
        {
            Protocol::create($request->all());
            $protocol = Protocol::where('district_id',$request->district_id)->where('type',$request->type)->first();
            return redirect()->route('protocols.edit',$protocol);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function show(Protocol $protocol)
    {
            //$districts = District::where('state_id',$state->id)->get();
            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function edit(Protocol $protocol)
    {
        $district_;
        $state;
        $parties_;
        if($protocol->type == "Місто")
        {
            $district_ = $protocol->getDstrict();
            $state = State::Where('id',$district_->state_id)->first();
            $parties_ = Partybystate::where('state_id',$state->id)->where('type',$protocol->type)->get();
        }
        else if($protocol->type == "Область")
        {
            $district_ = $protocol->getDstrict();
            $state = State::Where('id',$district_->state_id)->first();
            $parties_ = Partybystate::where('type',$protocol->type)->get();
        }
        else if($protocol->type == "Район")
        {
            $district_ = $protocol->getDstrict();
            $state = State::Where('id',$district_->state_id)->first();
            $parties_ = Partybystate::where('type',$protocol->type)->get();
        }
        else if($protocol->type == "Мер")
        {
            $district_ = $protocol->getDstrict();
            $state = State::Where('id',$district_->state_id)->first();
            $parties_ = Mayor::all();
        }
        
        return view('Protocol/show', compact('protocol','parties','parties_'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Protocol $protocol)
    {
        $district_check = District::where('id',$request->district_id)->count();
        if($district_check == 0)
        {
            return back()->withErrors([
                'message' => 'Такої дільниця немає в реєстрі'
            ]);
        }
        else
        {
            $protocol->status = 1;
            $protocol->update($request->all());
            return redirect()->route('protocols.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Protocol $protocol)
    {
        //
    }

}
