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
    public $error_array= [];
    public $list_candidat =[];
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
        $candidats=Candidat::paginate(10);
        return view('Candidat/index', compact('candidats'));
    }

    public function candidat_($type)
    {
        $parties=Partybystate::where('type',$type)->get();
        return view('Candidat/candidat_',compact('parties','type'));
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
        $partiesbystates=Partybystate::all();
        return view('Candidat/upload', compact('staties','partiesbystates'));
    }

    public function search(Request $request)
    {
        $candidats = Candidat::where('name','like','%'.$request->name.'%')->get();
        return view('Candidat/search', compact('candidats'));
    }

    public function read_file(Request $request)
    {
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $filename = time().'.'.$filename; 
        $file->storeAS('public',$filename);   

        $path = $file->storeAS('storage',$filename);   
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
       $phpWord = $objReader->load($path);
       $number = "";
       $name = [];
       $date = [];
        foreach($phpWord->getSections() as $section)
        {

            $array = $section->getElements();
            foreach($array as $e)
            {
                if((get_class($e) === 'PhpOffice\PhpWord\Element\Table'))
                {      
                    $candidat = new Candidat;
                    $rows = $e->getRows();
                    foreach($rows as $row)
                    {  
                        $candidat = new Candidat;
                        $cells = $row->getCells();
                        foreach($cells as $key => $cell)
                        {
                            $cellelems= $cell->getElements();
                            foreach($cellelems as  $cellelem)
                            {
                                if(get_class($cellelem) === 'PhpOffice\PhpWord\Element\TextRun')
                                {   
                                    foreach($cellelem->getElements() as $text)
                                    { 
                                           if($key == 0){$number = $text->getText();}
                                           if($key == 1){array_push($name, $text->getText());}
                                           if($key == 2){array_push($date, $text->getText());}  
                                    }
                                }
                            }   
                        }
                         $str = implode( "", $date );
                         $str2 = explode( '.', $str);
                         $candidat->number = $number;
                         $candidat->name = implode( " ", $name );
                         $candidat->date = $this->loop($str2);
                         $candidat->party_id = $request->party_id;
                         array_push($this->list_candidat, $candidat);
                         $this->check($candidat);
                         $name =[];
                         $number = "";
                         $date = [];
                         $id=0;    
                        
                    }
                }
            }
         }
          if(count($this->error_array) == 0)
          {
            foreach($this->list_candidat as $list)
            {
               Candidat::create($list->toArray());
            }
            return redirect()->route('candidats.index');
          }
          else
          {
            return view('Candidat/error')->with('error_array', $this->error_array);
          }

    }
    public function erors(Array $error_array)
    {
        return view('Candidat/eror', compact('error_array'));
    }

    public function check(Candidat $candidat)
    {
        if(!$this->check_date($candidat->date))
        {
            array_push($this->error_array,'Невірний формат дати народження або пусте значення дати народження '.$candidat->number.' '.$candidat->name.' '.$candidat->date);
        }
        if(!$this->check_name($candidat->name))
        {
            array_push($this->error_array,'Невірно вказано імя прізвище по-батькові '.$candidat->number.' '.$candidat->name.' '.$candidat->date.' ');
        }
        if(!$this->check_number($candidat->number))
        {
            array_push($this->error_array,'Пусте значення Номера '.$candidat->number.' '.$candidat->name.' '.$candidat->date.' ');
        }
        
        if(count($this->error_array) == 0)
        {
            return 0;
        }
    }
    public function check_date($date)
    {
        $str = explode( '/', $date);
        if($date == null || $date == "" ||  $date == " ")
        {
            return false;
        }
        else if (count($str) < 3)
        {
            return false;
        }
        else if( $str[0]== "" || $str[1]== "" || $str[2]== "")
        {
            return false;
        }
        else
        {
            return checkdate( $str[1], $str[2], $str[0]);
        }
        
    }

    public function check_name($name)
    {
        $str = explode( ' ', $name);
        if($name == "" || $name == null )
        {
            return false;    
        }
        ///////////////////////////////////////////////////////
        // else if(count($str) != 3)
        // {
        //    return false;
        // }
        else {return true; }
        
    }

    public function check_number($number)
    {
        if($number == "" || $number == null )
        {
           return false;
        }
        else
        {
            return true;
        }
    }


    public function loop($str)
    {
        if($str[0] == "")
        {
            return null;
        }
        else
        {
          $tmp = $str[0];
          $str[0] = $str[2];
          $str[2] = $tmp;
         $ready = implode( "/", $str );
         return $ready;
        }
     //    dd($ready);

         
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
        $candidat->delete();
        return redirect()->route('candidats.index');
    }
}
