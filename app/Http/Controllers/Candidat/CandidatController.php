<?php

namespace App\Http\Controllers\Candidat;

use App\Candidat;
use App\Partybystate;
use App\State;
use App\Party;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CandidatController extends Controller
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
        $candidats=Candidat::all();
        return view('Candidat/index', compact('candidats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $partiesbystates=Partybystate::all();
        return view('Candidat/create', compact('partiesbystates'));
    }

    public function upload()
    {
        $staties=State::all();
        $parties=Party::all();
        return view('Candidat/upload', compact('staties','parties'));
    }

    public function read_file(Request $request)
    {
        // $phpWord = new PhpWord();

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $filename = time().'.'.$filename; 
        $file->storeAS('public',$filename);   

        $path = $file->storeAS('public',$filename);   

        echo $path;

        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
        $phpWord = $objReader->load($path);
        return "read succesful";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Candidat::create($request->all());
        return redirect()->route('candidats.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Candidat  $candidat
     * @return \Illuminate\Http\Response
     */
    public function show(Candidat $candidat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Candidat  $candidat
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidat $candidat)
    {
        $partiesbystates = Partybystate::all();
        return view('Candidat/update', compact('candidat','partiesbystates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Candidat  $candidat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidat $candidat)
    {
        $candidat->update($request->all());
        return redirect()->route('candidats.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Candidat  $candidat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidat $candidat)
    {
        //
    }
}
