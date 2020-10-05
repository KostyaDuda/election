<?php

namespace App\Http\Controllers\Present;

use App\Present;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PresentController extends Controller
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
        $presents=Present::all();
        return view('Presents/index',compact('presents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Presents/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Present::create($request->all());
        return redirect()->route('presents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function show(Present $present)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function edit(Present $present)
    {
        return view('Presents/update',compact('present'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Present $present)
    {
        $present->update($request->all());
        return redirect()->route('presents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function destroy(Present $present)
    {
        $present->delete();
        return redirect()->route('presents.index');
    }
}
