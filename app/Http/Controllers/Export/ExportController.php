<?php

namespace App\Http\Controllers\Export;

use App\District;
use App\Personal;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\DB;


class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function export_all()
    {
        $phpWord = new PhpWord();
        $districts=District::all();
        $sectionStyle = array(
            'marginTop' => 0,
            'marginBottom' => 0,
            'colsNum' => 1,
            'space' => array('line' => 300)
        );
        foreach($districts as $district)
        { 
        $section = $phpWord->addSection($sectionStyle);
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER , 'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED);
        $fancyTableFirstRowStyle = array('bgColor' => 'ffffff');
        $fancyTableCellStyle = array('valign' => 'center');

        $headerstyle = array('align' => 'center','size' => '24');

        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
           
        $table = $section->addText($district->id, $headerstyle);
        $table = $section->addTable($fancyTableStyleName);
        
        $table->addRow(900);
        $table->addCell(2000, $fancyTableCellStyle)->addText('№', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ДВК', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ПІБ', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Посада', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ДН', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Телефон', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Партійність', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Ж/О', $fancyTableFontStyle);
        
        $members_main = Member::where('district_id',$district->id)->where('priority',"Обов'язковий")->orderby('present_id')->get();

        foreach($members_main as $key => $member){
             $table->addRow();
             $index = $key+1;
             $table->addCell(2000)->addText("{$index}");
             $table->addCell(2000)->addText("{$member->district_id}");
             $table->addCell(2000)->addText("{$member->name}");
             $table->addCell(2000)->addText("{$member->position}");
             $table->addCell(2000)->addText("{$member->date}");
             $table->addCell(2000)->addText("{$member->number}");
             $table->addCell(2000)->addText("{$member->getPresent()->name}");
             $table->addCell(2000)->addText("{$member->priority}");
          }

          $members_other = Member::where('district_id',$district->id)->where('priority',"Жеребкування")->orderby('name')->get();
          $count = Member::where('district_id',$district->id)->where('priority',"Обов'язковий")->orderby('present_id')->count();
          $index = $count;
          foreach($members_other as $key => $member){
            $table->addRow();
            $index = $key+1;
            $table->addCell(2000)->addText("{$index}");
            $table->addCell(2000)->addText("{$member->district_id}");
            $table->addCell(2000)->addText("{$member->name}");
            $table->addCell(2000)->addText("{$member->position}");
            $table->addCell(2000)->addText("{$member->date}");
            $table->addCell(2000)->addText("{$member->number}");
            $table->addCell(2000)->addText("{$member->getPresent()->name}");
            $table->addCell(2000)->addText("{$member->priority}");
         }
        }
          $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $name = time().'jerebkuvania_cklad.docx';
                    $objectWriter->save(storage_path($name));
                } catch (Exception $e) {
            }
 
        return response()->download(storage_path($name));   
    }
    public function export_all_()
    {
        $phpWord = new PhpWord();
        $districts=District::all();
        $sectionStyle = array(
            'marginTop' => 0,
            'marginBottom' => 0,
            'colsNum' => 1,
            'space' => array('line' => 300)
        );
        foreach($districts as $district)
        {  
        $section = $phpWord->addSection($sectionStyle);
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER , 'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED);
        $fancyTableFirstRowStyle = array('bgColor' => 'ffffff');
        $fancyTableCellStyle = array('valign' => 'center');

        $headerstyle = array('align' => 'center','size' => '24');


        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
          
        $table = $section->addText($district->id, $headerstyle);
        $table = $section->addTable($fancyTableStyleName);
        
        $table->addRow(900);
        $table->addCell(2000, $fancyTableCellStyle)->addText('№', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ДВК', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ПІБ', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Посада', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ДН', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Телефон', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Партійність', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Ж/О', $fancyTableFontStyle);
        
        $members_main = Member::where('district_id',$district->id)->orderby('position')->get();

        foreach($members_main as $key => $member){
             $table->addRow();
             $index = $key+1;
             $table->addCell(2000)->addText("{$index}");
             $table->addCell(2000)->addText("{$member->district_id}");
             $table->addCell(2000)->addText("{$member->name}");
             $table->addCell(2000)->addText("{$member->position}");
             $table->addCell(2000)->addText("{$member->date}");
             $table->addCell(2000)->addText("{$member->number}");
             $table->addCell(2000)->addText("{$member->getPresent()->name}");
             $table->addCell(2000)->addText("{$member->priority}");
          }
        }
          $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $name = time().'cklad_dvk.docx';
                    $objectWriter->save(storage_path($name));
                } catch (Exception $e) {
            }
 
        return response()->download(storage_path($name));  
    }

    public function mains()
    {
        $phpWord = new PhpWord();
        $districts=District::all();


        $section = $phpWord->addSection();
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER , 'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED);
        $fancyTableFirstRowStyle = array('bgColor' => 'ffffff');
        $fancyTableCellStyle = array('valign' => 'center');

        $headerstyle = array('align' => 'center','size' => '24');


        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        foreach($districts as $district)
        {    
        $table = $section->addText($district->id, $headerstyle);
        $table = $section->addTable($fancyTableStyleName);
        
        $table->addRow(900);
        $table->addCell(2000, $fancyTableCellStyle)->addText('№', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ДВК', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ПІБ', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Посада', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ДН', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Телефон', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Партійність', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Ж/О', $fancyTableFontStyle);
        
        $members_main = Member::where('district_id',$district->id)->where('position','!=',"Член")->where('position','!=',"Член ДВК")->orderby('position')->get();

        foreach($members_main as $key => $member){
             $table->addRow();
             $index = $key+1;
             $table->addCell(2000)->addText("{$index}");
             $table->addCell(2000)->addText("{$member->district_id}");
             $table->addCell(2000)->addText("{$member->name}");
             $table->addCell(2000)->addText("{$member->position}");
             $table->addCell(2000)->addText("{$member->date}");
             $table->addCell(2000)->addText("{$member->number}");
             $table->addCell(2000)->addText("{$member->getPresent()->name}");
             $table->addCell(2000)->addText("{$member->priority}");
          }
        }
          $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $name = time().'kirovny_cklad.docx';
                    $objectWriter->save(storage_path($name));
                } catch (Exception $e) {
            }
 
        return response()->download(storage_path($name));  
    }
    public function check_count()
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER , 'cellMargin'  => 80, 'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED);
        $fancyTableFirstRowStyle = array('bgColor' => 'ffffff');
        $fancyTableCellStyle = array('valign' => 'center');

        $headerstyle = array('align' => 'center','size' => '24');

        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
   
        $table = $section->addTable($fancyTableStyleName);
        
        $table->addRow(900);
        $table->addCell(2000, $fancyTableCellStyle)->addText('№ Дільниці', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Тип', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Кількість Людей', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('', $fancyTableFontStyle);

        $districts=District::all();
       
        foreach($districts as $district)
        {
            $members_count = Member::where('district_id',$district->id)->count();
            if(!$this->check_many($district->type,$members_count))
            {
                $table->addRow();
                $table->addCell(2000)->addText("{$district->id}");
                $table->addCell(2000)->addText("{$district->type}");
                $table->addCell(2000)->addText("{$members_count}");
                $table->addCell(2000)->addText("Перебор");

            }
            if(!$this->check_less($district->type,$members_count))
            {
                $table->addRow();
                $table->addCell(2000)->addText("{$district->id}");
                $table->addCell(2000)->addText("{$district->type}");
                $table->addCell(2000)->addText("{$members_count}");
                $table->addCell(2000)->addText("Недобор");

            }
        }
        $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $name = time().'perevirka_dilnyuts.docx';
                    $objectWriter->save(storage_path($name));
                } catch (Exception $e) {
            }
 
        return response()->download(storage_path($name));
    }


    public function check_many($type,$count)
    {
        
        if($type == 'Велика' && $count > 18 )
        {
            return false;
        }
        else if($type == 'Середня' && $count >16 )
        {
            return false;
        }
        else if($type == 'Мала' && $count >14 )
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public function dublicaties()
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('bgColor' => 'ffffff');
        $fancyTableCellStyle = array('valign' => 'center');

        $headerstyle = array('align' => 'center','size' => '48');

        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
   
        $table = $section->addTable($fancyTableStyleName);
        
        $table->addRow(900);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ДВК', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ПІБ', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Посада', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ДН', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Телефон', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Партійність', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Ж/О', $fancyTableFontStyle);

    
      $members = DB::table('mebers')->groupBy('name')->having(DB::raw('count(*)'), '>', 1);

 
        foreach($member as $member){
            $table->addRow();
            $index = $key+1;
            $table->addCell(2000)->addText("{$member->district_id}");
            $table->addCell(2000)->addText("{$member->name}");
            $table->addCell(2000)->addText("{$member->position}");
            $table->addCell(2000)->addText("{$member->date}");
            $table->addCell(2000)->addText("{$member->number}");
            $table->addCell(2000)->addText("{$member->getPresent()->name}");
            $table->addCell(2000)->addText("{$member->priority}");
         }


    }

    public function kvoty()
    {
        $kvotis = DB::table('members')->select('presents.name', DB::raw('COUNT(presents.name) as count'))
            ->join('presents', 'members.present_id', '=', 'presents.id')->groupBy('presents.name')->get();

            $phpWord = new PhpWord();
            $section = $phpWord->addSection();
            $fancyTableStyleName = 'Fancy Table';
            $fancyTableStyle = array('borderSize' => 2, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
            $fancyTableFirstRowStyle = array('bgColor' => 'ffffff');
            $fancyTableCellStyle = array('valign' => 'center');
    
            $headerstyle = array('align' => 'center','size' => '48');
    
            $fancyTableFontStyle = array('bold' => true);
            $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
       
            $table = $section->addTable($fancyTableStyleName);
            
            $table->addRow(900);
            $table->addCell(2000, $fancyTableCellStyle)->addText('Парітя', $fancyTableFontStyle);
            $table->addCell(2000, $fancyTableCellStyle)->addText('Кількість Людей', $fancyTableFontStyle);
    
     
            foreach($kvotis as $kvoty){
                $table->addRow();
                $table->addCell(2000)->addText("{$kvoty->name}");
                $table->addCell(2000)->addText("{$kvoty->count}");
             }

             $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $name = time().'kvota.docx';
                    $objectWriter->save(storage_path($name));
                } catch (Exception $e) {
            }
 
        return response()->download(storage_path($name));
        
    }

    public function check_less($type,$count)
    {
        
        if($type == 'Велика' && $count < 18 )
        {
            return false;
        }
        else if($type == 'Середня' && $count < 16 )
        {
            return false;
        }
        else if($type == 'Мала' && $count < 14 )
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public function export_one(District $district)
    {
        $phpWord = new PhpWord();
        $districts=District::all();
        
        $section = $phpWord->addSection();
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => 'd2d2d2', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('bgColor' => 'DDDDDD');
        $fancyTableCellStyle = array('valign' => 'center');

        $headerstyle = array('align' => 'center','size' => '48');

        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
   
        $table = $section->addText($district->id, $headerstyle);
        $table = $section->addTable($fancyTableStyleName);
        
        $table->addRow(900);
        $table->addCell(2000, $fancyTableCellStyle)->addText('№', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ДВК', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ПІБ', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Посада', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ДН', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Телефон', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Партійність', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Ж/О', $fancyTableFontStyle);
        $index =0;
        $members_main = Member::where('district_id',$district->id)->where('priority',"Обов'язковий")->orderby('present_id')->get();

        foreach($members_main as $key => $member){
             $table->addRow();
             $index = $key+1;
             $table->addCell(2000)->addText("{$index}");
             $table->addCell(2000)->addText("{$member->district_id}");
             $table->addCell(2000)->addText("{$member->name}");
             $table->addCell(2000)->addText("{$member->position}");
             $table->addCell(2000)->addText("{$member->date}");
             $table->addCell(2000)->addText("{$member->number}");
             $table->addCell(2000)->addText("{$member->getPresent()->name}");
             $table->addCell(2000)->addText("{$member->priority}");
          }
          $index++;
          $members_other = Member::where('district_id',$district->id)->where('priority',"Жеребкування")->orderby('name')->get();
          $count = Member::where('district_id',$district->id)->where('priority',"Обов'язковий")->orderby('present_id')->count();
          foreach($members_other as $key => $member){
            $table->addRow();
            $table->addCell(2000)->addText("{$index}");
            $table->addCell(2000)->addText("{$member->district_id}");
            $table->addCell(2000)->addText("{$member->name}");
            $table->addCell(2000)->addText("{$member->position}");
            $table->addCell(2000)->addText("{$member->date}");
            $table->addCell(2000)->addText("{$member->number}");
            $table->addCell(2000)->addText("{$member->getPresent()->name}");
            $table->addCell(2000)->addText("{$member->priority}");
            $index++;
         }
          $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $name = time().'TestWordFile.docx';
                    $objectWriter->save(storage_path($name));
                } catch (Exception $e) {
            }
 
        return response()->download(storage_path($name));   
    }

    public function export_personals_(Personal $personal)
    {
        $phpWord = new PhpWord();
        $districts = District::where('personal_id',$personal->id)->get();
        $sectionStyle = array(
            'marginTop' => 0,
            'marginBottom' => 0,
            'colsNum' => 1,
            'space' => array('line' => 300)
        );
        foreach($districts as $district)
        {  
        $section = $phpWord->addSection($sectionStyle);
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER , 'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED);
        $fancyTableFirstRowStyle = array('bgColor' => 'ffffff');
        $fancyTableCellStyle = array('valign' => 'center');

        $headerstyle = array('align' => 'center','size' => '24');


        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
          
        $table = $section->addText($district->id, $headerstyle);
        $table = $section->addTable($fancyTableStyleName);
        
        $table->addRow(900);
        $table->addCell(2000, $fancyTableCellStyle)->addText('№', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ДВК', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ПІБ', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Посада', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('ДН', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Телефон', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Партійність', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Ж/О', $fancyTableFontStyle);
        
        $members_main = Member::where('district_id',$district->id)->orderby('position')->get();

        foreach($members_main as $key => $member){
             $table->addRow();
             $index = $key+1;
             $table->addCell(2000)->addText("{$index}");
             $table->addCell(2000)->addText("{$member->district_id}");
             $table->addCell(2000)->addText("{$member->name}");
             $table->addCell(2000)->addText("{$member->position}");
             $table->addCell(2000)->addText("{$member->date}");
             $table->addCell(2000)->addText("{$member->number}");
             $table->addCell(2000)->addText("{$member->getPresent()->name}");
             $table->addCell(2000)->addText("{$member->priority}");
          }
        }
          $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $name = time().'personal_cklad_dvk.docx';
                    $objectWriter->save(storage_path($name));
                } catch (Exception $e) {
            }
 
        return response()->download(storage_path($name));  
    }
}
