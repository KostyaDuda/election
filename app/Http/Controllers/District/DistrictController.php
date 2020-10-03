<?php

namespace App\Http\Controllers\District;


use App\State;
use App\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistrictController extends Controller
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
        $districts=District::paginate(10);
        return view('District/index', compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staties=State::all();
        return view('District/create', compact('staties'));
    }

    public function create_(State $state_)
    {
        return view('District/createByState', compact('state_'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = District::where('id',$request->id)->count();
        if($check > 0)
        {
            return back()->withErrors([
                'message' => 'Така дільниця є в реєстрі'
            ]);
        }
        District::create($request->all());
        return redirect()->route('districts.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        $staties = State::all();
        return view('District/update',compact('district','staties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $district)
    {
        $check = District::where('id',$request->id)->count();
        if($check > 0 &&  $request->id != $district->id)
        {
            return back()->withErrors([
                'message' => 'Така дільниця є в реєстрі'
            ]);
        }
        $district->update($request->all());
        return redirect()->route('districts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        $district->delete();
        return redirect()->route('districts.index');
    }
}
