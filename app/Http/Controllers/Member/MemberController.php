<?php

namespace App\Http\Controllers\Member;

use App\Member;
use App\Present;
use App\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public $error_array= [];
    public $list_member =[];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members=Member::paginate(20);
        return view('Member/index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $presents=Present::all();
        return view('Member/create', compact('presents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = District::where('id',$request->district_id)->count();
        if($check == 0)
        {
            return back()->withErrors([
                'message' => 'Такої дільниці немає в реєстрі'
            ]);
        }
        $member = new Member;
        if($member->getPresentById($request->present_id)->priority != null)
        {
               $member->district_id = $request->district_id;
               $member->name = $request->name ;
               $member->position= $request->position;
               $member->date= $request->date;
               $member->district_id= $request->district_id;
               $member->number= $request->number;
               $member->present_id= $request->present_id;
               $member->priority= "Обов'язковий";
        }
        else
        {

            $member->district_id = $request->district_id;
            $member->name = $request->name ;
            $member->position= $request->position;
            $member->date= $request->date;
            $member->district_id= $request->district_id;
            $member->number= $request->number;
            $member->present_id= $request->present_id;
            $member->priority= "Жеребкування";
        }

        Member::create($member->toArray());
        return redirect()->route('members.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        $presents=Present::all();
        return view('Member/update', compact('member','presents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $check = District::where('id',$request->district_id)->count();
        if($check == 0)
        {
            return back()->withErrors([
                'message' => 'Такої дільниці немає в реєстрі'
            ]);
        }
        if($member->getPresentById($request->present_id)->priority != null)
        {
               $member->district_id = $request->district_id;
               $member->name = $request->name ;
               $member->position= $request->position;
               $member->date= $request->date;
               $member->district_id= $request->district_id;
               $member->number= $request->number;
               $member->present_id= $request->present_id;
               $member->priority= "Обов'язковий";
        }
        else
        {

            $member->district_id = $request->district_id;
            $member->name = $request->name ;
            $member->position= $request->position;
            $member->date= $request->date;
            $member->district_id= $request->district_id;
            $member->number= $request->number;
            $member->present_id= $request->present_id;
            $member->priority= "Жеребкування";
        }
        $member->update($request->all());
        return redirect()->route('members.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index');
    }

    public function upload()
    {
        $presents=Present::all();
        return view('Member/upload', compact('presents'));
    }

    public function search(Request $request)
    {
        $members = Member::where('name','like','%'.$request->name.'%')->get();
        return view('Member/search', compact('members'));
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
       $number = [];
       $name = [];
       $date = [];
       $district_id=[];
        foreach($phpWord->getSections() as $section)
        {

            $array = $section->getElements();
            foreach($array as $e)
            {
                if((get_class($e) === 'PhpOffice\PhpWord\Element\Table'))
                {      
                    $member = new Member;
                    $rows = $e->getRows();
                    foreach($rows as $row)
                    {  
                        $member = new Member;
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
                                           if($key == 0){array_push($district_id, $text->getText());}
                                           if($key == 1){array_push($name, $text->getText());}
                                           if($key == 2){array_push($date, $text->getText());}  
                                           if($key == 3){array_push($number, $text->getText());} 
                                    }
                                }
                            }   
                        }

                        $str = implode( "", $date );
                         $str2 = explode( '.', $str);
                         $member->district_id = json_decode(implode("", $district_id));
                         $member->number = implode(" ", $number );
                         $member->name = implode(" ", $name );
                         $member->date = $this->loop($str2);
                         $member->present_id = $request->present_id;
                         $member->position = "Член ДВК";
                         if($member->getPresentById($request->present_id)->priority != null)
                            {
                                   $member->priority= "Обов'язковий";
                            }
                            else
                            {
                                $member->priority= "Жеребкування";
                            }
                         array_push($this->list_member, $member);
                         $this->check($member);
                        
                        //  $str = implode( "", $date );
                        //  $str2 = explode( '.', $str);
                        //  $candidat->number = $number;
                        //  $candidat->name = implode( " ", $name );
                        //  $candidat->date = $this->loop($str2);
                        //  $candidat->party_id = $request->party_id;
                        //  array_push($this->list_candidat, $candidat);
                        //  $this->check($candidat);
                         $number = [];
                         $name = [];
                         $date = [];
                         $district_id = [];   
                        
                    }
                }
            }
         }
          if(count($this->error_array) == 0)
          {
            foreach($this->list_member as $list)
            {
               Member::create($list->toArray());
            }
            return redirect()->route('members.index');
          }
          else
          {
           return view('Candidat/error')->with('error_array', $this->error_array);
          }

    }
    public function erors(Array $error_array)
    {
        return view('Member/eror', compact('error_array'));
    }

    public function check(Member $member)
    {
        if(!$this->check_date($member->date))
        {
            array_push($this->error_array,'Невірний формат дати народження або пусте значення дати народження '.$member->number.' '.$member->name.' '.$member->date);
        }
        if(!$this->check_name($member->name))
        {
            array_push($this->error_array,'Невірно вказано імя прізвище по-батькові '.$member->number.' '.$member->name.' '.$member->date.' ');
        }
        if(!$this->check_number($member->number))
        {
            array_push($this->error_array,'Пусте значення Номера '.$member->number.' '.$member->name.' '.$member->date.' ');
        }
        
        if(count($this->error_array) == 0)
        {
            return 0;
        }
    }
    public function check_date($date)
    {
        $str = explode( '/', $date);
        if($date == null)
        {
            return false;
        }
        else if( $str[0]== "" || $str[1]== "" || $str[2]== "")
        {
            return false;
        }
        else if(is_numeric($str[0]) && is_numeric($str[1]) && is_numeric($str[2]))
        {
            return checkdate( $str[1], $str[2], $str[0]);;
        }
        else
        {
            return false;
        }
        
    }

    public function check_name($name)
    {
        $str = explode( ' ', $name);
        if($name == "")
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

        if($number ="")
        {
            return false;
        }
        else{return true;}
         
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
    }

    public function exportword()
    {

        $phpWord = new PhpWord();

        $districts=District::all();
        dd($districts);
       // $newSection = $wordTest->addSection();
 
       // $desc1 = "The Portfolio details is a very useful feature of the web page. You can establish your archived details and the works to the entire web community. It was outlined to bring in extra clients, get you selected based on this details.";
 
        //$newSection->addText($desc1, array('name' => 'Tahoma', 'size' => 15, 'color' => 'red'));
        $section = $phpWord->addSection();
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => 'd2d2d2', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('bgColor' => 'DDDDDD');
        $fancyTableCellStyle = array('valign' => 'center');

        $text = "some text";
        $PHPWord->addFontStyle('r2Style', array('bold'=>false, 'italic'=>false, 'size'=>12));
    $PHPWord->addParagraphStyle('p2Style', array('align'=>'center', 'spaceAfter'=>100));
$section->addText($text, 'r2Style', 'p2Style');

        $fancyTableFontStyle = array('bold' => true);
        // $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        // $table = $section->addTable($fancyTableStyleName);
        // $table->addRow(900);
        // $table->addCell(2000, $fancyTableCellStyle)->addText('ID', $fancyTableFontStyle);
        // $table->addCell(2000, $fancyTableCellStyle)->addText('Name', $fancyTableFontStyle);
        // $table->addCell(2000, $fancyTableCellStyle)->addText('Date', $fancyTableFontStyle);
        $section = $phpWord->addSection();
        foreach($districts as $district){
            $section->addText("$district->name");
         }
        // foreach($str as $st){
        //      $table->addRow();
        //      $table->addCell(2000)->addText("{$st->id}");
        //      $table->addCell(2000)->addText("{$st->name}");
        //      $table->addCell(2000)->addText("{$st->date}");
        //   }
          $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
            try {
                    $objectWriter->save(storage_path('TestWordFile.docx'));
                } catch (Exception $e) {
            }
 
        return response()->download(storage_path('TestWordFile.docx'));   
        // $head = ['id','name','date'];
        // $word = new PhpWord;
        // foreach($head as h);

        // $word = new PhpWord;
        // $str=Test::find(1);
        // $TemplateProcessor = new TemplateProcessor('templates/word.docx');
        // $TemplateProcessor->setValue('id',$str->id);
        // $TemplateProcessor->setValue('name',$str->name);
        // $TemplateProcessor->setValue('date',$str->date);
        // $filename = $str->name;
        // $TemplateProcessor->saveAs($filename.'.docx');
        // return response()->download($filename.'.docx')->deleteFileAfterSend(true); 
    }

}

