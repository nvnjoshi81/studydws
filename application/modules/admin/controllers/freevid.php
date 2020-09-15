<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Freevid extends MY_Admincontroller {

        public function __construct()
        {
            parent::__construct();          
        $this->load->database();
        }
        public function index()
        {   $this->load->model('Freevideo_model');
            $this->data['content']='freevid/index';
            $videolist=$this->Freevideo_model->getVideolist();
            $this->data['video_id']=$videolist->video_id;
            $this->load->view('common/template',$this->data);
        }
           
        public function addfreevideo(){
         
           $this->load->model('Freevideo_model');
           $fvideo  =  $this->input->post('fvideo');
           $this->Freevideo_model->saveVideo($fvideo);
           $this->session->set_flashdata('message', 'Playlist Id Saved Successfully.');
            redirect('/admin/freevid');
        }
        
}