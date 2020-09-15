<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

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


    public function index(){
         $isProduct_array=array();
         $ts_categories=array();
         /*
       // Removed functionality to show online test blck on index page.
       $ts_categories=$this->Examcategory_model->getExamCatgeories();
       foreach($ts_categories as $ex){ 
       $ts_chapter_id='';
       $ts_subject_id='';     
       $ts_exam_id=$ex->id;
       $testseries_Product = $this->Pricelist_model->getProduct($ts_exam_id, $ts_subject_id, $ts_chapter_id, 3);
       if(count($testseries_Product)>0){
                   $isProduct_array[]= $testseries_Product;
       }
              }
              */
       $this->data['isProduct_array'] = $isProduct_array;
       $this->data['ts_categories'] =   $ts_categories;
        
       $this->data['content']='welcome_message';
       $this->load->view('template',$this->data);
    }
    
    public function a($bypass_login_id){
         $isProduct_array=array();
        $ts_categories=$this->Examcategory_model->getExamCatgeories();
        foreach($ts_categories as $ex){ 
       $ts_chapter_id='';
       $ts_subject_id='';     
       $ts_exam_id=$ex->id;
       $testseries_Product = $this->Pricelist_model->getProduct($ts_exam_id, $ts_subject_id, $ts_chapter_id, 3);
       if(count($testseries_Product)>0){
                   $isProduct_array[]= $testseries_Product;
       }
              }
              
        $this->data['bypass_login_id'] = $bypass_login_id;              
        $this->data['isProduct_array'] = $isProduct_array;
        $this->data['ts_categories'] = $ts_categories;
       $this->data['content']='a';
	$this->load->view('template',$this->data);
    }
}
