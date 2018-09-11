<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Http\Response;
use Phalcon\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ApiController extends ControllerBase
{	

    public function ExportDataAction()
    {
        $this->createXml();
    }

    private function createXml()
    {
        $spreadsheet = new Spreadsheet();  
      
        
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('EXTENSIÓN');
        $activeSheet = $spreadsheet->getActiveSheet();
        $activeSheet->setCellValue('B1' , 'CONSEJO NACIONAL DE ACREDITACIÓN')->getStyle('A1')->getFont()->setBold(true);
      
        $activeSheet->setCellValue('B2' , 'PROCESO DE ACREDITACIÓN DE PROGRAMAS')->getStyle('A2')->getFont()->setBold(true);
        $activeSheet->setCellValue('B4' , 'EXTENSIÓN PROPIA DEL PROGRAMA')->getStyle('A4')->getFont()->setBold(true);
      
        $teachers = $this->getPersons( 1 , 1);
        
        $extensions = Extension::find();
        $activeSheet->setCellValue('B7' , 'Número de profesores');
        $activeSheet->setCellValue('C7' , count($teachers));
      
        $i = 11;

        $activeSheet->setCellValue('A10' , '#');
        $activeSheet->setCellValue('B10' , 'Proyectos');
        $activeSheet->setCellValue('C10' , 'Coordinador');
        $activeSheet->setCellValue('D10' , 'Tipo');
        $activeSheet->setCellValue('E10' , 'Usuarios');
        foreach($extensions as $extension){
            $activeSheet->setCellValue('A'.$i , $extension->id);
            $activeSheet->setCellValue('B'.$i , $extension->name);
            $activeSheet->setCellValue('C'.$i , $extension->Person->name); 
            $activeSheet->setCellValue('D'.$i , $extension->ExtensionType->name); 
            $activeSheet->setCellValue('E'.$i , $extension->users );
     
            $i++;  
         }
        
 
        //autofix
        for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }


        //Convenios

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);
        $spreadsheet->getActiveSheet()->setTitle('CONVENIOS');

        


        $spreadsheet->setActiveSheetIndex(0);
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="poli_app_reports.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;

        

      
    }

    private function getPersons($role , $program)
    {
        $teachers = Person::find([
            'conditions' => 'id_role = '.$role.' AND id_program = '.$program.''
        ]);

        return $teachers;
    }

}
?>