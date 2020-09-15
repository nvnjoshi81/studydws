<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_relation extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
        function __construct() {
            parent::__construct();
        }

/*INSTRUCTION for mapping 2 modules (Like Ncert Solution to Studymaterial Example link -
 https://www.studyadda.com/ncert-solution/8th-class/science/cell-structure-
and-functions/8th-science-cell-structure-and-functions/271 )
 *sample xml upload file is avialble at www.studyadda.com/assets/excel/Mapping Sample Study Package to Solved Paper.xlsx
 * change module_type in bellow $data array to 9 if u want to merge ncert solution or change to 10 to merge solved paper.
 * URL to uplaod xlsx file without extention - http://www.studyadda.local/Import_relation/index/filename 
 *  */
    public function index($filename,$module_type,$related_module_type){
        //$related_module_type studymaterial id .i.e. 1
        $this->load->library('excel');
        $this->load->model('Mergesection_model');
        //$filename= 'studypackage_to_solved_mapinglist';
        if(($filename=='')||($filename==null)){
          echo "Please Add File name After URL without extension.";
          die;
        }
        $file = $this->input->server('DOCUMENT_ROOT').'/assets/excel/'.$filename.'.xlsx';
        if($filename && file_exists($file)){
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        foreach ($cell_collection as $cell) {
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
            //header will/should be in row 1 only. of course this can be modified to suit your need.
            if ($row == 1) {
                $header[$row][$column] = $data_value;
            } else {
                $arr_data[$row][$column] = $data_value;
            }
        }
         foreach ($arr_data as $key => $value) {
         $arr_data_custom[$value['A']]=$value['B'];
         }
        
        $total_amount = 0;
        $videolistname='';
        if(count($arr_data_custom)>1){
        foreach ($arr_data_custom as $key => $value) {
            //$chapter_relation=array('Study_Package'=>$value['A'],'NCERT'=>$value['B']);
        $this->load->model('Mergesection_model');
        if($key>0){   
            $studymaterial_details = $this->Mergesection_model->get_studymaterial_by_file_id($key);    
            /*
             9 for Ncert Solution module_type
            10 for Solved Paper module_type
             1 for Studymatrial related_module_type
            */
            $currentdate=date("d/m/Y");
            $data=array(
            'module_id'=>$value,
            'module_type'=>$module_type,
            'related_module_id'=>$studymaterial_details[0]->studymaterial_id,
            'related_module_type'=>$related_module_type, 
            'related_file_id'=>$key,
            'created_at'=>$currentdate
        ); 
            $this->Mergesection_model->merge_module($data);
                   echo "File Uploaded!";  
        }
        }
        }else{
          echo "Check File Formate or File is Empty.";  
        }
        //unlink($file);
        }else{
            echo 'File Missing';
        }
        
    }
}
