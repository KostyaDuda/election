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
use Illuminate\Support\Facades\DB;

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
                    $p12->type = $protocol->type;
                    p12::create($p12->toArray());
                    foreach($party->getCandidat_all($party->id) as $candidat)
                    {
                        $p14 = new p14;
                        $p14->protocol_id = $protocol->id;
                        $p14->party_id = $candidat->party_id;
                        $p14->candidat_id = $candidat->id;
                        $p14->state_id =  $state->id;
                        $p14->type = $protocol->type;
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
                    $p12->type = $protocol->type;
                    p12::create($p12->toArray());
                    foreach($party->getCandidat_all($party->id) as $candidat)
                    {
                        $p14 = new p14;
                        $p14->protocol_id = $protocol->id;
                        $p14->party_id = $candidat->party_id;
                        $p14->candidat_id = $candidat->id;
                        $p14->type = $protocol->type;
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
                    $p12->type = $protocol->type;
                    p12::create($p12->toArray());
                    foreach($party->getCandidat_all($party->id) as $candidat)
                    {
                        $p14 = new p14;
                        $p14->protocol_id = $protocol->id;
                        $p14->party_id = $candidat->party_id;
                        $p14->candidat_id = $candidat->id;
                        $p14->type = $protocol->type;
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
        $district_state = District::where('id',$request->district_id)->first();
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
            $protocol->state_id = $district_state->state_id;
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

    public function rate()
    {
        $states = State::all();
        $types = [
            "Місто",
            "Область",
            "Район",
            "Мер"
        ];
        return view('Protocol/rate', compact('states','types'));
    }

    public function rate_list($type)
    {
        //dd($type);
        $list_p = [];
        $p1sum = DB::table('protocols')
                ->select('p1', 
                DB::raw('SUM(p1) as p1sum'))
                ->groupBy('type')->where('type',$type)->sum('p1');
        array_push($list_p,$p1sum);
        $p2sum = DB::table('protocols')
                ->select('p2', 
                DB::raw('SUM(p2) as p2sum'))
                ->groupBy('type')->where('type',$type)->sum('p2');
        array_push($list_p,$p2sum);

        $p3sum = DB::table('protocols')
                ->select('p3', 
                DB::raw('SUM(p3) as p3sum'))
                ->groupBy('type')->where('type',$type)->sum('p3');
                array_push($list_p,$p3sum);
        $p4sum = DB::table('protocols')
                ->select('p4', 
                DB::raw('SUM(p4) as p4sum'))
                ->groupBy('type')->where('type',$type)->sum('p4');
        array_push($list_p,$p4sum);

        $p5sum = DB::table('protocols')
                ->select('p5', 
                DB::raw('SUM(p5) as p5sum'))
                ->groupBy('type')->where('type',$type)->sum('p5');
        array_push($list_p,$p5sum);

        $p6sum = DB::table('protocols')
                ->select('p6', 
                DB::raw('SUM(p6) as p6sum'))
                ->groupBy('type')->where('type',$type)->sum('p6');
        array_push($list_p,$p6sum);

        $p7sum = DB::table('protocols')
                ->select('p7', 
                DB::raw('SUM(p7) as p7sum'))
                ->groupBy('type')->where('type',$type)->sum('p7');
        array_push($list_p,$p7sum);

        $p8sum = DB::table('protocols')
                ->select('p8', 
                DB::raw('SUM(p8) as p8sum'))
                ->groupBy('type')->where('type',$type)->sum('p8');
        array_push($list_p,$p8sum);

        $p9sum = DB::table('protocols')
                ->select('p9', 
                DB::raw('SUM(p9) as p9sum'))
                ->groupBy('type')->where('type',$type)->sum('p9');
        array_push($list_p,$p9sum);

        $p10sum = DB::table('protocols')
        ->select('p10', 
        DB::raw('SUM(p10) as p10sum'))
        ->groupBy('type')->where('type',$type)->sum('p10');
        array_push($list_p,$p10sum);

        $p11sum = DB::table('protocols')
        ->select('p11', 
        DB::raw('SUM(p11) as p11sum'))
        ->groupBy('type')->where('type',$type)->sum('p11');
        array_push($list_p,$p11sum);

        if($type == "Мер")
        {
            $pmayor = pmayor::groupBy('mayor_id')
        ->selectRaw('mayor_id, sum(count_voises) as count_voises')->get(); 
        
        }
        else
        {
            $p12 = p12::groupBy('party_id')
            ->selectRaw('sum(count_voises) as count_voises, party_id')->where('type',$type)
            ->get();
            
            $p13 = p12::groupBy('party_id')
            ->selectRaw('sum(p13) as p13_count, party_id')->where('type',$type)
            ->get();
    
            $p14 = p14::groupBy('candidat_id','party_id')
            ->selectRaw('sum(count_voises) as count_voises, party_id, candidat_id')->where('type',$type)
            ->get();
        }

        return view('Protocol/rate_list',compact('list_p','type','p12','p13','p14','pmayor'));
    }

    public function rate_state($state_id)
    {
        //dd($type);
        $list_p = [];
        $p1sum = DB::table('protocols')
                ->select('p1', 
                DB::raw('SUM(p1) as p1sum'))
                ->groupBy('type')->where('state_id',$state_id)->where('type',"Місто")->sum('p1');

        array_push($list_p,$p1sum);
        $p2sum = DB::table('protocols')
                ->select('p2', 
                DB::raw('SUM(p2) as p2sum'))
                ->groupBy('type')->where('state_id',$state_id)->where('type',"Місто")->sum('p2');
        array_push($list_p,$p2sum);

        $p3sum = DB::table('protocols')
                ->select('p3', 
                DB::raw('SUM(p3) as p3sum'))
                ->groupBy('type')->where('state_id',$state_id)->where('type',"Місто")->sum('p3');
                array_push($list_p,$p3sum);
        $p4sum = DB::table('protocols')
                ->select('p4', 
                DB::raw('SUM(p4) as p4sum'))
                ->groupBy('type')->where('state_id',$state_id)->where('type',"Місто")->sum('p4');
        array_push($list_p,$p4sum);

        $p5sum = DB::table('protocols')
                ->select('p5', 
                DB::raw('SUM(p5) as p5sum'))
                ->groupBy('type')->where('state_id',$state_id)->where('type',"Місто")->sum('p5');
        array_push($list_p,$p5sum);

        $p6sum = DB::table('protocols')
                ->select('p6', 
                DB::raw('SUM(p6) as p6sum'))
                ->groupBy('type')->where('state_id',$state_id)->where('type',"Місто")->sum('p6');
        array_push($list_p,$p6sum);

        $p7sum = DB::table('protocols')
                ->select('p7', 
                DB::raw('SUM(p7) as p7sum'))
                ->groupBy('type')->where('state_id',$state_id)->where('type',"Місто")->sum('p7');
        array_push($list_p,$p7sum);

        $p8sum = DB::table('protocols')
                ->select('p8', 
                DB::raw('SUM(p8) as p8sum'))
                ->groupBy('type')->where('state_id',$state_id)->where('type',"Місто")->sum('p8');
        array_push($list_p,$p8sum);

        $p9sum = DB::table('protocols')
                ->select('p9', 
                DB::raw('SUM(p9) as p9sum'))
                ->groupBy('type')->where('state_id',$state_id)->where('type',"Місто")->sum('p9');
        array_push($list_p,$p9sum);

        $p10sum = DB::table('protocols')
        ->select('p10', 
        DB::raw('SUM(p10) as p10sum'))
        ->groupBy('type')->where('state_id',$state_id)->where('type',"Місто")->sum('p10');
        array_push($list_p,$p10sum);

        $p11sum = DB::table('protocols')
        ->select('p11', 
        DB::raw('SUM(p11) as p11sum'))
        ->groupBy('type')->where('state_id',$state_id)->where('type',"Місто")->sum('p11');
        array_push($list_p,$p11sum);


    
            $p12 = p12::groupBy('party_id')
            ->selectRaw('sum(count_voises) as count_voises, party_id')->where('state_id',$state_id)->where('type',"Місто")
            ->get();
            
            $p13 = p12::groupBy('party_id')
            ->selectRaw('sum(p13) as p13_count, party_id')->where('state_id',$state_id)->where('type',"Місто")
            ->get();

    
            $p14 = p14::groupBy('candidat_id','party_id')
            ->selectRaw('sum(count_voises) as count_voises, party_id, candidat_id')->where('state_id',$state_id)->where('type',"Місто")
            ->get();
      
        $state = State::where('id',$state_id)->first();
        return view('Protocol/rate_state',compact('list_p','state','p12','p13','p14','pmayor'));
    }

}
