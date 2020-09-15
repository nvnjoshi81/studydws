<?php
if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Media extends MY_Admincontroller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Media_model');
        $this->load->library('pagination');
       
    }

    public function index($page = 0) {
        /*         * *** pgination _categories***   */
        $config = array();
        $config["base_url"] = base_url() . "admin/media/index/";
        $config["total_rows"] = $this->Media_model->getMediaCount();
        $config["per_page"] = $this->config->item('records_per_page');
        $config["uri_segment"] = 4;
        $config["num_links"] = 5;
        $config['first_link'] = '&lsaquo; First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &rsaquo;';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        //$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;                

        $this->data["links"] = $this->pagination->create_links();
        $this->data['media'] = $this->Media_model->getcontent();
        
        
        $this->data['media_array'] = $this->Media_model->getmedia();      
        $this->data['content'] = 'media/index';
        $this->load->view('common/template', $this->data);
    }

    public function add() {
        $this->data['content'] = 'media/add';
        $this->load->view('common/template', $this->data);
    }

     public function submitadd() {
         
        $imagefolder_path = '/assets/images/';
          $title = $this->input->post('title');         
          $description = $this->input->post('description');          
          $date = $this->input->post('date');
          
         $imagename_big = media_image_upload($imagefolder_path,'mediaimage_big');       
        if($imagename_big=='failed'){
            $imagename_big='';
        }
         $media_data = array(
            'title' => $title,
            'description' => $description,
            'image' => $imagename,
            'image_big' => $imagename_big,
            'date' => $date
        );
         
        $this->Media_model->createMedia($media_data);         
        $this->session->set_flashdata("message","Information Added Successfully.");
        redirect('admin/media');
    }
    
     public function edit($media_id) {   
          /*         * *** pgination _categories***   */
        $config = array();
        $config["base_url"] = base_url() . "admin/media/index/";
        $config["total_rows"] = $this->Media_model->getMediaCount();
        $config["per_page"] = $this->config->item('records_per_page');
        $config["uri_segment"] = 4;
        $config["num_links"] = 5;
        $config['first_link'] = '&lsaquo; First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &rsaquo;';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        //$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;                

        $this->data["links"] = $this->pagination->create_links();
        $this->data['media'] = $this->Media_model->getcontent();
            $mediaResult = $this->Media_model->getMediaById($media_id);
            $this->data['mediaResult']=$mediaResult;
            $this->data['content'] = 'media/edit';
            $this->load->view('common/template', $this->data);         
     }
     
     public function submitedit(){
        $imagefolder_path = '/assets/images/';
         $id = $this->input->post('id'); 
          $title = $this->input->post('title');         
          $description = $this->input->post('description');          
          $date = $this->input->post('date');
          $image = $this->input->post('image');
          $image_big = $this->input->post('image_big');
          
         $imagename = media_image_upload($imagefolder_path,'mediaimage');       
       
         if($imagename=='failed'){
             $images=$image;
         }else{
             $images=$imagename;
         }
         
         //Big Image
         $imagename_big = media_image_upload($imagefolder_path,'mediaimage_big');       
       
         if($imagename_big=='failed'){
             $images_big=$image_big;
         }else{
             $images_big=$imagename_big;
         }
         
         
         
         $media_data = array(
            'title' => $title,
            'description' => $description,
            'image' => $images,
            'image_big' => $images_big,
            'date' => $date
        );         
        $this->Media_model->editMedia($media_data,$id);
        $this->session->set_flashdata("message","Information Updated Successfully.");
        redirect('admin/media/edit/'.$id);
         
     }
     
     public function delete($id){
          $this->Media_model->deleteMedia($id);
        $this->session->set_flashdata("message","Information Deleted Successfully.");
         redirect('admin/media');
     }
    

}

?>
