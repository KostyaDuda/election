<?php

namespace App\Http\Controllers\Protocol;

use App\Protocol;
use App\Party;
use App\Mayor;
use App\pmayor;
use App\State;
use App\Partybystate;
use App\District;
use App\Candidat;
use App\p12;
use App\p14;
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
        $count_dis = District::all()->count();

        $protocols_city=Protocol::where('type','Місто')->orderby('district_id')->get();
        $count_city=Protocol::where('type','Місто')->count();

        $protocols_rayon_=Protocol::where('type','Район')->orderby('district_id')->get();
        $count_rayon_=Protocol::where('type','Район')->count();

        $protocols_oblast_=Protocol::where('type','Область')->orderby('district_id')->get();
        $count_oblast_=Protocol::where('type','Область')->count();

        $protocols_mayor_=Protocol::where('type','Мер')->orderby('district_id')->get();
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
            'count_mayor_',
            'count_dis'
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
            if($protocol->type == "Місто")
            {
                $district_ = $protocol->getDstrict();
                $state = State::Where('id',$district_->state_id)->first();
                $parties_ = Partybystate::where('state_id',$state->id)->where('type',$protocol->type)->get();
                foreach($parties_ as $party)
                {
                    $p12 = new p12;
                    $p12->protocol_id = $protocol->id;
                    $p12->party_id = $party->id;
                    $p12->state_id = $state->id;
                    p12::create($p12->toArray());
                    foreach($party->getCandidat_all($party->id) as $candidat)
                    {
                        $p14 = new p14;
                        $p14->protocol_id = $protocol->id;
                        $p14->party_id = $candidat->party_id;
                        $p14->candidat_id = $candidat->id;
                        $p14->state_id =  $state->id;
                        p14::create($p14->toArray());
                    }
                }
            }
            else if($protocol->type == "Область")
            {
                $district_ = $protocol->getDstrict();
                $parties_ = Partybystate::where('type',$protocol->type)->get();
                foreach($parties_ as $party)
                {
                    $p12 = new p12;
                    $p12->protocol_id = $protocol->id;
                    $p12->party_id = $party->id;
                    p12::create($p12->toArray());
                    foreach($party->getCandidat_all($party->id) as $candidat)
                    {
                        $p14 = new p14;
                        $p14->protocol_id = $protocol->id;
                        $p14->party_id = $candidat->party_id;
                        $p14->candidat_id = $candidat->id;
                        p14::create($p14->toArray());
                    }
                }
            }
            else if($protocol->type == "Район")
            {
                $district_ = $protocol->getDstrict();
                $parties_ = Partybystate::where('type',$protocol->type)->get();
                foreach($parties_ as $party)
                {
                    $p12 = new p12;
                    $p12->protocol_id = $protocol->id;
                    $p12->party_id = $party->id;
                    p12::create($p12->toArray());
                    foreach($party->getCandidat_all($party->id) as $candidat)
                    {
                        $p14 = new p14;
                        $p14->protocol_id = $protocol->id;
                        $p14->party_id = $candidat->party_id;
                        $p14->candidat_id = $candidat->id;
                        p14::create($p14->toArray());
                    }
                }
            }
            else if($protocol->type == "Мер")
            {
                $district_ = $protocol->getDstrict();
                $state = State::Where('id',$district_->state_id)->first();
                $mayors = Mayor::all();
                foreach($mayors as $mayor)
                {
                    $pmayor = new pmayor;
                    $pmayor->protocol_id = $protocol->id;
                    $pmayor->mayor_id = $mayor->id;
                    pmayor::create($pmayor->toArray());
                }
            }
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
        $p12 = p12::where('protocol_id',$protocol->id)->get();  
        $p14 = p14::where('protocol_id',$protocol->id)->get();  
        $mayors = pmayor::where('protocol_id',$protocol->id)->get();  
        return view('Protocol/show', compact('protocol','p12','p14','mayors'));
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
            if($protocol->type == "Мер")
            {
                $pmayor = pmayor::where('protocol_id',$protocol->id)->get();
                $pmayor_count = pmayor::where('protocol_id',$protocol->id)->count();

                $array_req = $request->all();

                $index = 0;
                $start = 15;
                $end = $start + $pmayor_count;

                $index_mayor_ = 0;
                foreach($array_req as $key => $req)
                {
                    if($index >= 15 && $index < $end)
                    {
                        $pmayor[$index_mayor_]->count_voises = $req;
                        $pmayor[$index_mayor_]->save();
                        $index_mayor_++;
                    }
                    $index++;
                }

            }
            else
            {
            $p12 = p12::where('protocol_id',$protocol->id)->get();
            $p14 = p14::where('protocol_id',$protocol->id)->get();
            $p12count = p12::where('protocol_id',$protocol->id)->count();
            $p14count = p14::where('protocol_id',$protocol->id)->count();

            $array_req = $request->all();

            $index = 0;
            $start = 15;
            $end = $start + $p12count;

            $index_p12_ = 0;
            foreach($array_req as $key => $req)
            {
                    if($index >= 15 && $index < $end)
                    {
                        $p12[$index_p12_]->count_voises = $req;
                    $p12[$index_p12_]->save();
                    $index_p12_++;
                    }
                    $index++;
            }

            $index = 0;
            $start = 15 + $p12count;
            $end = $start + $p12count;
            $index_p12_ = 0;
            foreach($array_req as $key => $req)
            {
                    if($index >= $start && $index < $end)
                    {
                        $p12[$index_p12_]->p13 = $req;
                    $p12[$index_p12_]->save();
                    $index_p12_++;
                    }
                    $index++;
            }

            $index = 0;
            $start = 15 + $p12count *2;
            
            $end = $start + $p14count;
            $index_p14_ = 0;
            foreach($array_req as $key => $req)
            {
                 if($index >= $start && $index < $end)
                 {
                     $p14[$index_p14_]->count_voises = $req;
                     $p14[$index_p14_]->save();
                     $index_p14_++;
                  }
                  $index++;
            }
            
        }
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
