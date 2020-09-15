<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Featuredvid extends MY_Admincontroller {

        public function __construct()
        {
            parent::__construct();          
        $this->load->database();
        }
        public function index()
        {   $this->load->model('Fvideo_model');
            $this->data['content']='featuredvid/index';
            $videolist=$this->Fvideo_model->getVideolist();
            $this->data['video_id']=$videolist->video_id;
            $this->load->view('common/template',$this->data);
        }
           
        public function addfvideo(){
         
           $this->load->model('Fvideo_model');
           $fvideo  =  $this->input->post('fvideo');
           $this->Fvideo_model->saveVideo($fvideo);
           $this->session->set_flashdata('message', 'Video Id Saved Successfully.');

            redirect('/admin/featuredvid');
        }
        
}