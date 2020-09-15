<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Questions extends MY_Admincontroller {

        public function __construct()
        {
            parent::__construct();
          
            $this->load->library("pagination");
            $this->load->library('form_validation');
            $this->load->helper(array('form', 'url'));
            $this->load->model('Questions_model');
        }
        public function index(){
            $this->data['content']='common/search';
            $this->data['searchtype']='questions';
            $this->load->view('common/template',$this->data); 
        }
        public function search(){
            //$this->data['scripts']=array('/MathJax/MathJax.js');
            $id=$this->input->post('search');
            $question=$this->Questions_model->detail($id);
            $this->data['question']=$question;
            if($question){
                $answers=$this->Questions_model->answers($question->id);
                $this->data['answers']=$answers;
            }
            $this->data['content']='common/search';
            $this->data['searchtype']='questions';
            $this->load->view('common/template',$this->data); 
        }
        
        public function relate($question_id,$chapter_id){
            $this->Questions_model->relate($question_id,$chapter_id);
            echo json_encode(array('success'=>1));
        }
}