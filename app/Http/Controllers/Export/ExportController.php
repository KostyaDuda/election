<?php

namespace App\Http\Controllers\Export;

use App\District;
use App\Personal;
use App\Member;
use App\Present;
use App\State;
use App\p12;
use App\p14;
use App\pmayor;
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
            'marginTop' => 500,
            'marginBottom' => 0,
            'colsSpace' => 1,
            'gutter' => 1,
            'marginRight' => 500,
            'marginLeft' => 500,
            'space' => array('line' => 1000)
        );
        $phpWord->setDefaultParagraphStyle(
            array(
                'align'      => 'both',
                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
                'spacing'    => 120,
                'spaceAfter'=>0,
                'lineHeight'=>1.0
                )
            );
        //$phpWord->addParagraphStyle('P-listStyle', array('spaceAfter'=>0,'lineHeight'=>1.0));
        foreach($districts as $district)
        { 
        $section = $phpWord->addSection($sectionStyle);
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER , 'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,'spaceAfter'=>0,'lineHeight'=>1.0);
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
            'marginTop' => 500,
            'marginBottom' => 0,
            'colsSpace' => 1,
            'gutter' => 1,
            'marginRight' => 500,
            'marginLeft' => 500,
            'space' => array('line' => 1000)
        );
        $phpWord->setDefaultParagraphStyle(
            array(
                'align'      => 'both',
                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
                'spacing'    => 120,
                'spaceAfter'=>0,
                'lineHeight'=>1.0
                )
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
        $table->addCell(2000, $fancyTableCellStyle)->addText('Доданий', $fancyTableFontStyle);
        
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
             $table->addCell(2000)->addText("{$member->created_at}");
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
        $table->addCell(2000, $fancyTableCellStyle)->addText('Доданий', $fancyTableFontStyle);
        
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
             $table->addCell(2000)->addText("{$member->created_at}");
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

        //$dublicates = Member::groupBy('name')->havingRaw('count(*)', '>', 1)->get();
        $array_list = [];
        $array_search =[];
        $dublicates = DB::table('members')->select('name', DB::raw('count(*) as c'))->groupBy('name')->havingRaw('Count(c) > ?', [1])->get();

        foreach($dublicates as $dublicat)
        {
            array_push($array_list,$dublicat->name);
        }

        foreach($array_list as $list)
        {   
            array_push($array_search, Member::where('name',$list)->get());
        }

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
        $table->addCell(2000, $fancyTableCellStyle)->addText('Доданий', $fancyTableFontStyle);
    
      //$members = DB::table('mebers')->groupBy('name')->having(DB::raw('count(*)'), '>', 1);
 
 
        foreach($array_search as $list){
            foreach($list as $l)
            {       
            $table->addRow();
            $table->addCell(2000)->addText("{$l->district_id}");
            $table->addCell(2000)->addText("{$l->name}");
            $table->addCell(2000)->addText("{$l->position}");
            $table->addCell(2000)->addText("{$l->date}");
            $table->addCell(2000)->addText("{$l->number}");
            $table->addCell(2000)->addText("{$l->getPresent()->name}");
            $table->addCell(2000)->addText("{$l->priority}");
            $table->addCell(2000)->addText("{$l->created_at}");
        }
         }

         $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
         try {
             $name = time().'dublicatu.docx';
                 $objectWriter->save(storage_path($name));
             } catch (Exception $e) {
         }

     return response()->download(storage_path($name));
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

        $sectionStyle = array(
            'marginTop' => 500,
            'marginBottom' => 500,
            'marginRight' => 500,
            'marginLeft' => 500,
        );
        $textstyle = array('space' => array('line' => 100000));
        $phpWord->setDefaultParagraphStyle(
            array(
                'align'      => 'both',
                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
                'spacing'    => 120,
                'spaceAfter'=>0,
                'lineHeight'=>1.0
                )
            );
        $section = $phpWord->addSection($sectionStyle);
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('bgColor' => 'DDDDDD');
        $fancyTableCellStyle = array('valign' => 'center','cellMarginTop' => 100, 'cellMarginRight' => 100, 'cellMarginBottom' => 100,'cellMarginLeft' => 100);

        $headerstyle = array('align' => 'center','size' => '24');

        $fancyTableFontStyle = array('bold' => true,'space' => array('line' => 0));
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
        $table->addCell(2000, $fancyTableCellStyle)->addText('Доданий', $fancyTableFontStyle);
        $index =0;
        $members_main = Member::where('district_id',$district->id)->where('priority',"Обов'язковий")->orderby('present_id')->get();

        foreach($members_main as $key => $member){
             $table->addRow();
             $index = $key+1;
             $table->addCell(2000)->addText("{$index}",$textstyle);
             $table->addCell(2000)->addText("{$member->district_id}",$textstyle);
             $table->addCell(2000)->addText("{$member->name}",$textstyle);
             $table->addCell(2000)->addText("{$member->position}",$textstyle);
             $table->addCell(2000)->addText("{$member->date}",$textstyle);
             $table->addCell(2000)->addText("{$member->number}",$textstyle);
             $table->addCell(2000)->addText("{$member->getPresent()->name}",$textstyle);
             $table->addCell(2000)->addText("{$member->priority}",$textstyle);
             $table->addCell(2000)->addText("{$member->created_at}");
          }
          $index++;
          $members_other = Member::where('district_id',$district->id)->where('priority',"Жеребкування")->orderby('name')->get();
          $count = Member::where('district_id',$district->id)->where('priority',"Обов'язковий")->orderby('present_id')->count();
          foreach($members_other as $key => $member){
            $table->addRow();
            $table->addCell(2000)->addText("{$index}",$textstyle);
            $table->addCell(2000)->addText("{$member->district_id}",$textstyle);
            $table->addCell(2000)->addText("{$member->name}",$textstyle);
            $table->addCell(2000)->addText("{$member->position}",$textstyle);
            $table->addCell(2000)->addText("{$member->date}",$textstyle);
            $table->addCell(2000)->addText("{$member->number}",$textstyle);
            $table->addCell(2000)->addText("{$member->getPresent()->name}",$textstyle);
            $table->addCell(2000)->addText("{$member->priority}",$textstyle);
            $index++;
         }
          $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $name = $district->id.'.docx';
                    $objectWriter->save(storage_path($name));
                } catch (Exception $e) {
            }
 
        return response()->download(storage_path($name));   
    }

    public function export_by_presents(Present $present)
    {
        $phpWord = new PhpWord();
        $members;
        $districts=District::all();
        if($present->name == "Слуга Народу" 
        || $present->name == "Батьківщина" 
        || $present->name == "ОПОЗИЦІЙНА ПЛАТФОРМА – ЗА ЖИТТЯ"
        || $present->name == "Європейська Солідарність" 
        || $present->name == "За Майбутнє")
        {
            $array_id = Present::where('name',$present->name)->get();
            $members = Member::whereBetween('present_id',[$array_id[0]->id,$array_id[1]->id])->get();

        }
        else
        {
        $members = Member::where('present_id',$present->id)->get();
        }
        $section = $phpWord->addSection();
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER , 'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED);
        $fancyTableFirstRowStyle = array('bgColor' => 'ffffff');
        $fancyTableCellStyle = array('valign' => 'center');

        $headerstyle = array('align' => 'center','size' => '24');


        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
   
        $table = $section->addText($present->name, $headerstyle);
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
        $table->addCell(2000, $fancyTableCellStyle)->addText('Доданий', $fancyTableFontStyle);
        
      

        foreach($members as $key => $member){
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
             $table->addCell(2000)->addText("{$member->created_at}");
          }
        
          $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $name = time().'cklad_dvk'.$present->name.'.docx';
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
            'marginTop' => 500,
            'marginBottom' => 0,
            'colsSpace' => 1,
            'gutter' => 1,
            'marginRight' => 500,
            'marginLeft' => 500,
            'space' => array('line' => 1000)
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

    public function protocol($type)
    {
        $phpWord = new PhpWord();
        $sectionStyle = array(
            'marginTop' => 500,
            'marginBottom' => 0,
            'colsSpace' => 1,
            'gutter' => 1,
            'marginRight' => 500,
            'marginLeft' => 500,
            'space' => array('line' => 1000)
        );

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

 
        $section = $phpWord->addSection($sectionStyle);
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER , 'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED);
        $fancyTableFirstRowStyle = array('bgColor' => 'ffffff');
        $fancyTableCellStyle = array('valign' => 'center');

        $headerstyle = array('align' => 'center','size' => '24');


        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
          
        $table = $section->addText("Протоклол ТВК Виборчого типу: ".$type, $headerstyle);
        $table = $section->addTable($fancyTableStyleName);
        
        $table->addRow(900);
        $table->addCell(2000, $fancyTableCellStyle)->addText('#', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Назва пункту', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Значення', $fancyTableFontStyle);
        $table->addRow();
        $table->addCell(2000)->addText("1");
        $table->addCell(2000)->addText("Кількість виборчих бюлетенів одержаних дільничною вибрчою комісією");
        $table->addCell(2000)->addText("{$list_p[0]}");
        $table->addRow();
        $table->addCell(2000)->addText("2");
        $table->addCell(2000)->addText("Кількість невикористаних виборчих бюлетнів, погашених дільничною вибрчою комісією");
        $table->addCell(2000)->addText("{$list_p[1]}");
        $table->addRow();
        $table->addCell(2000)->addText("3");
        $table->addCell(2000)->addText("Кількість виборців, включених до списку виборців на виборчій дільниці (на момент закінчення голосування)");
        $table->addCell(2000)->addText("{$list_p[2]}");
        $table->addRow();
        $table->addCell(2000)->addText("4");
        $table->addCell(2000)->addText("Кількість виборців, внесених на виборчій дільниці до витягу із списку виборців для голосування за місцем перебування");
        $table->addCell(2000)->addText("{$list_p[3]}");
        $table->addRow();
        $table->addCell(2000)->addText("5");
        $table->addCell(2000)->addText("Кількість виборців, які отримали виборчі бюлетені у приміщенні для голосування");
        $table->addCell(2000)->addText("{$list_p[4]}");
        $table->addRow();
        $table->addCell(2000)->addText("6");
        $table->addCell(2000)->addText("Кількість виборців, які отримали виборчі бюлетені за місцем перебування");
        $table->addCell(2000)->addText("{$list_p[5]}");
        $table->addRow();
        $table->addCell(2000)->addText("7");
        $table->addCell(2000)->addText("Загальна кількість виборців, які отримали виборчі бюлетені");
        $table->addCell(2000)->addText("{$list_p[6]}");
        $table->addRow();
        $table->addCell(2000)->addText("8");
        $table->addCell(2000)->addText("Кількість виборчих бюлетенів, що не підлягають врахуванню");
        $table->addCell(2000)->addText("{$list_p[7]}");
        $table->addRow();
        $table->addCell(2000)->addText("9");
        $table->addCell(2000)->addText("Кількість виборців, які взяли участь у голосуванні на виборчій дільниці ");
        $table->addCell(2000)->addText("{$list_p[8]}");
        $table->addRow();
        $table->addCell(2000)->addText("10");
        $table->addCell(2000)->addText("Кількість виборчих бюлетенів, визнаних недійсними  ");
        $table->addCell(2000)->addText("{$list_p[9]}");
        $table->addRow();
        $table->addCell(2000)->addText("11");
        $table->addCell(2000)->addText("Сумарна кількість голосів виборців, які підтримали територіальні виборчі списки усіх місцевих організацій політичних партій");
        $table->addCell(2000)->addText("{$list_p[10]}");

        if($type == "Мер")
        {
            $pmayor = pmayor::groupBy('mayor_id')
            ->selectRaw('mayor_id, sum(count_voises) as count_voises')->get();

            $table = $section->addText("12.", $headerstyle);
            $table2 = $section->addTable($fancyTableStyleName);
        
            $table2->addRow(900);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('№', $fancyTableFontStyle);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('Прізвище', $fancyTableFontStyle);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('Імя', $fancyTableFontStyle);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('По Батькові', $fancyTableFontStyle);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('Кількість голосів виборців, які підтримали мера', $fancyTableFontStyle);
        
      

        foreach($pmayor as $key => $mayor){
             $table2->addRow();
             $index = $key+1;
             $table2->addCell(2000)->addText("{$index}");
             $table2->addCell(2000)->addText("{$mayor->getMayor()->second_name}");
             $table2->addCell(2000)->addText("{$mayor->getMayor()->first_name}");
             $table2->addCell(2000)->addText("{$mayor->getMayor()->father_name}");
             $table2->addCell(2000)->addText("{$mayor->count_voises}");
          }


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

            $table = $section->addText("12.", $headerstyle);
            $table2 = $section->addTable($fancyTableStyleName);
        
            $table2->addRow(900);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('№', $fancyTableFontStyle);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('Назва місцевої організації політичної партії', $fancyTableFontStyle);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('Кількість голосів виборців, 
        які підтримали територіальний виборчий список місцевої організації політичної партії
        (цифрами)', $fancyTableFontStyle);  

        foreach($p12 as $key => $p){
             $table2->addRow();
             $index = $key+1;
             $table2->addCell(2000)->addText("{$index}");
             $table2->addCell(2000)->addText("{$p->getParty_by_protocol()->name}");
             $table2->addCell(2000)->addText("{$p->count_voises}");
          }

          $table = $section->addText("13.", $headerstyle);
            $table2 = $section->addTable($fancyTableStyleName);
        
            $table2->addRow(900);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('№', $fancyTableFontStyle);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('Назва місцевої організації політичної партії', $fancyTableFontStyle);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('Кількість голосів виборців,
        які підтримали весь територіальний виборчий список кандидатів у депутати від  місцевої організації політичної партії, 
        не підтримавши окремого кандидата в депутати', $fancyTableFontStyle);  

        foreach($p13 as $key => $p){
             $table2->addRow();
             $index = $key+1;
             $table2->addCell(2000)->addText("{$index}");
             $table2->addCell(2000)->addText("{$p->getParty_by_protocol()->name}");
             $table2->addCell(2000)->addText("{$p->p13_count}");
          }


          $table = $section->addText("14.", $headerstyle);
            $table2 = $section->addTable($fancyTableStyleName);
        
              

        foreach($p12 as $key => $p){
            $table = $section->addText($p->getParty_by_protocol()->name, $headerstyle);
            $table2 = $section->addTable($fancyTableStyleName);
            $table2->addRow(900);

            $table2->addCell(2000, $fancyTableCellStyle)->addText('№', $fancyTableFontStyle);
             $table2->addCell(2000, $fancyTableCellStyle)->addText('ПІБ', $fancyTableFontStyle);
             $table2->addCell(2000, $fancyTableCellStyle)->addText('Кількість голосів', $fancyTableFontStyle);
             foreach($p14 as $key => $candidat){
                if($candidat->party_id == $p->party_id)
                {
                $table2->addRow();
                $index = $key+1;
                $table2->addCell(2000)->addText("{$candidat->getCandidat()->number}");
                $table2->addCell(2000)->addText("{$candidat->getCandidat()->name}");
                $table2->addCell(2000)->addText("{$candidat->count_voises}");
                }
             }
          }


        }

          $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $name = 'tvk'.$type.'.docx';
                    $objectWriter->save(storage_path($name));
                } catch (Exception $e) {
            }
 
        return response()->download(storage_path($name));
    }

    public function protocol_state($state_id)
    {
        $state = State::where('id',$state_id)->first();
        $phpWord = new PhpWord();
        $sectionStyle = array(
            'marginTop' => 500,
            'marginBottom' => 0,
            'colsSpace' => 1,
            'gutter' => 1,
            'marginRight' => 500,
            'marginLeft' => 500,
            'space' => array('line' => 1000)
        );

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
        

 
        $section = $phpWord->addSection($sectionStyle);
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER , 'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED);
        $fancyTableFirstRowStyle = array('bgColor' => 'ffffff');
        $fancyTableCellStyle = array('valign' => 'center');

        $headerstyle = array('align' => 'center','size' => '24');


        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
          
        $table = $section->addText("Протоклол ТВК Виборчого Округу: ".$state->name, $headerstyle);
        $table = $section->addTable($fancyTableStyleName);
        
        $table->addRow(900);
        $table->addCell(2000, $fancyTableCellStyle)->addText('#', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Назва пункту', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Значення', $fancyTableFontStyle);
        $table->addRow();
        $table->addCell(2000)->addText("1");
        $table->addCell(2000)->addText("Кількість виборчих бюлетенів одержаних дільничною вибрчою комісією");
        $table->addCell(2000)->addText("{$list_p[0]}");
        $table->addRow();
        $table->addCell(2000)->addText("2");
        $table->addCell(2000)->addText("Кількість невикористаних виборчих бюлетнів, погашених дільничною вибрчою комісією");
        $table->addCell(2000)->addText("{$list_p[1]}");
        $table->addRow();
        $table->addCell(2000)->addText("3");
        $table->addCell(2000)->addText("Кількість виборців, включених до списку виборців на виборчій дільниці (на момент закінчення голосування)");
        $table->addCell(2000)->addText("{$list_p[2]}");
        $table->addRow();
        $table->addCell(2000)->addText("4");
        $table->addCell(2000)->addText("Кількість виборців, внесених на виборчій дільниці до витягу із списку виборців для голосування за місцем перебування");
        $table->addCell(2000)->addText("{$list_p[3]}");
        $table->addRow();
        $table->addCell(2000)->addText("5");
        $table->addCell(2000)->addText("Кількість виборців, які отримали виборчі бюлетені у приміщенні для голосування");
        $table->addCell(2000)->addText("{$list_p[4]}");
        $table->addRow();
        $table->addCell(2000)->addText("6");
        $table->addCell(2000)->addText("Кількість виборців, які отримали виборчі бюлетені за місцем перебування");
        $table->addCell(2000)->addText("{$list_p[5]}");
        $table->addRow();
        $table->addCell(2000)->addText("7");
        $table->addCell(2000)->addText("Загальна кількість виборців, які отримали виборчі бюлетені");
        $table->addCell(2000)->addText("{$list_p[6]}");
        $table->addRow();
        $table->addCell(2000)->addText("8");
        $table->addCell(2000)->addText("Кількість виборчих бюлетенів, що не підлягають врахуванню");
        $table->addCell(2000)->addText("{$list_p[7]}");
        $table->addRow();
        $table->addCell(2000)->addText("9");
        $table->addCell(2000)->addText("Кількість виборців, які взяли участь у голосуванні на виборчій дільниці ");
        $table->addCell(2000)->addText("{$list_p[8]}");
        $table->addRow();
        $table->addCell(2000)->addText("10");
        $table->addCell(2000)->addText("Кількість виборчих бюлетенів, визнаних недійсними  ");
        $table->addCell(2000)->addText("{$list_p[9]}");
        $table->addRow();
        $table->addCell(2000)->addText("11");
        $table->addCell(2000)->addText("Сумарна кількість голосів виборців, які підтримали територіальні виборчі списки усіх місцевих організацій політичних партій");
        $table->addCell(2000)->addText("{$list_p[10]}");

       
      
        $p12 = p12::groupBy('party_id')
        ->selectRaw('sum(count_voises) as count_voises, party_id')->where('state_id',$state_id)->where('type',"Місто")
        ->get();
        
        $p13 = p12::groupBy('party_id')
        ->selectRaw('sum(p13) as p13_count, party_id')->where('state_id',$state_id)->where('type',"Місто")
        ->get();


        $p14 = p14::groupBy('candidat_id','party_id')
        ->selectRaw('sum(count_voises) as count_voises, party_id, candidat_id')->where('state_id',$state_id)->where('type',"Місто")
        ->get();

            $table = $section->addText("12.", $headerstyle);
            $table2 = $section->addTable($fancyTableStyleName);
        
            $table2->addRow(900);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('№', $fancyTableFontStyle);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('Назва місцевої організації політичної партії', $fancyTableFontStyle);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('Кількість голосів виборців, 
        які підтримали територіальний виборчий список місцевої організації політичної партії
        (цифрами)', $fancyTableFontStyle);  

        foreach($p12 as $key => $p){
             $table2->addRow();
             $index = $key+1;
             $table2->addCell(2000)->addText("{$index}");
             $table2->addCell(2000)->addText("{$p->getParty_by_protocol()->name}");
             $table2->addCell(2000)->addText("{$p->count_voises}");
          }

          $table = $section->addText("13.", $headerstyle);
            $table2 = $section->addTable($fancyTableStyleName);
        
            $table2->addRow(900);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('№', $fancyTableFontStyle);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('Назва місцевої організації політичної партії', $fancyTableFontStyle);
        $table2->addCell(2000, $fancyTableCellStyle)->addText('Кількість голосів виборців,
        які підтримали весь територіальний виборчий список кандидатів у депутати від  місцевої організації політичної партії, 
        не підтримавши окремого кандидата в депутати', $fancyTableFontStyle);  

        foreach($p13 as $key => $p){
             $table2->addRow();
             $index = $key+1;
             $table2->addCell(2000)->addText("{$index}");
             $table2->addCell(2000)->addText("{$p->getParty_by_protocol()->name}");
             $table2->addCell(2000)->addText("{$p->p13_count}");
          }


          $table = $section->addText("14.", $headerstyle);
            $table2 = $section->addTable($fancyTableStyleName);
        
              

        foreach($p12 as $key => $p){
            $table = $section->addText($p->getParty_by_protocol()->name, $headerstyle);
            $table2 = $section->addTable($fancyTableStyleName);
            $table2->addRow(900);

            $table2->addCell(2000, $fancyTableCellStyle)->addText('№', $fancyTableFontStyle);
             $table2->addCell(2000, $fancyTableCellStyle)->addText('ПІБ', $fancyTableFontStyle);
             $table2->addCell(2000, $fancyTableCellStyle)->addText('Кількість голосів', $fancyTableFontStyle);
             foreach($p14 as $key => $candidat){
                if($candidat->party_id == $p->party_id)
                {
                $table2->addRow();
                $index = $key+1;
                $table2->addCell(2000)->addText("{$candidat->getCandidat()->number}");
                $table2->addCell(2000)->addText("{$candidat->getCandidat()->name}");
                $table2->addCell(2000)->addText("{$candidat->count_voises}");
                }
             }
          }


        

          $objectWriter = IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $name = 'tvk'.'Місто'.'.docx';
                    $objectWriter->save(storage_path($name));
                } catch (Exception $e) {
            }
 
        return response()->download(storage_path($name));
    }

}
