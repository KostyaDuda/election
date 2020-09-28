<?php

namespace App\Http\Controllers\Mayor;

use App\Mayor;
use App\Party;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MayorController extends Controller
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
        $mayors=Mayor::all();
        return view('Mayor/index',compact('mayors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Mayor/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Mayor::create($request->all());
        return redirect()->route('mayors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mayor  $mayor
     * @return \Illuminate\Http\Response
     */
    public function show(Mayor $mayor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mayor  $mayor
     * @return \Illuminate\Http\Response
     */
    public function edit(Mayor $mayor)
    {
        $parties=Party::all();
        return view('Mayor/update',compact('mayor','parties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mayor  $mayor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mayor $mayor)
    {
        $mayor->update($request->all());
        return redirect()->route('mayors.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mayor  $mayor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mayor $mayor)
    {
        $mayor->delete();
        return redirect()->route('mayors.index');
    }
}
