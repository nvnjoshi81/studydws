<?php
if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Livestream extends MY_Admincontroller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Livestream_model');
        $this->load->library('pagination');
		
		
		    $cntarray[0]=   (object) array('id'=>'video','name' => 'Video');		
			
			$cntarray[1]=   (object) array('id' => 'study_package','name' => 'Study Package');
			
			$cntarray[2]=   (object) array('id' => 'test_series','name' => 'Test Series');	
			
			$cntarray[3]=   (object) array('id' => 'notes','name' => 'Notes');			
			
			$cntarray[4]=   (object) array('id' => 'solved_paper','name' => 'Solved Paper');
			
			$cntarray[5]=   (object) array('id' => 'question_bank','name' => 'Question Bank');
			
			$cntarray[6]=   (object) array('id' => 'ncert_solution','name' => 'Ncert Solution');
       
        $this->data['contentArray'] = $cntarray;
    }

    public function index($page = 0) {
        /*         * *** pgination _categories***   */
        $config = array();
        $config["base_url"] = base_url() . "admin/livestream/index/";
        $config["total_rows"] = $this->Livestream_model->getMediaCount();
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
        $this->data['media'] = $this->Livestream_model->getcontent();
		$this->load->model('Examcategory_model');
        $this->data['media_array'] = $this->Livestream_model->getmedia();      
        $this->data['content'] = 'livestream/index';
        $this->load->view('common/template', $this->data);
    }

    public function add() { 
		$exams = $this->Examcategory_model->getAdminExamCatgeories();
        $this->data['exams'] = $exams;
        $this->data['content'] = 'livestream/add';
        $this->load->view('common/template', $this->data);
    }

     public function submitadd() {
         
          $imagefolder_path = '/assets/images/';
          $title = $this->input->post('title');         
          $description = $this->input->post('description');       
          $class_id = $this->input->post('class_id');	          
          $date = $this->input->post('date');
          $noti_type= $this->input->post('noti_type');		  
if(isset($date)&&$date!=''){
	 $date = $this->input->post('date');
}else{
	$date = date("F j, Y"); 
}		  
          $content_type = $this->input->post('content_type');		            
          $packageid = $this->input->post('packageid');
		
         $media_data = array(
            'title' => $title,
            'description' => $description,
			'class_id' => $class_id,
            'content_type' => $content_type,
            'packageid' => $packageid,
			'notitype'=>$noti_type,
            'date' => $date
        );
         
        $this->Livestream_model->createMedia($media_data);         
        $this->session->set_flashdata("message","Information Added Successfully.");
        redirect('admin/notification');
    }
    
     public function edit($media_id) {   
          /*         * *** pgination _categories***   */
        $config = array();
        $config["base_url"] = base_url() . "admin/livestream/index/";
        $config["total_rows"] = $this->Livestream_model->getMediaCount();
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

		$exams = $this->Examcategory_model->getAdminExamCatgeories();
        $this->data['exams'] = $exams;
        $this->data["links"] = $this->pagination->create_links();
        $this->data['media'] = $this->Livestream_model->getcontent();
            $mediaResult = $this->Livestream_model->getMediaById($media_id);
            $this->data['mediaResult']=$mediaResult;
            $this->data['content'] = 'livestream/edit';
            $this->load->view('common/template', $this->data);         
     }
     public function submitedit(){
          $imagefolder_path = '/assets/images/';
          $id = $this->input->post('id'); 
          $title = $this->input->post('title');         
          $description = $this->input->post('description');          
          $date = $this->input->post('date');
		  $class_id = $this->input->post('class_id');		  
		  $noti_type = $this->input->post('noti_type');
		  
		  
		  if(isset($date)&&$date!=''){
	 $date = $this->input->post('date');
}else{
	$date = date("F j, Y");
}	
          $content_type = $this->input->post('content_type');
          $packageid = $this->input->post('packageid');          
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
            'class_id' => $class_id,            
            'content_type' => $content_type,
            'packageid' => $packageid,
			'notitype'=>$noti_type,
            'date' => $date
        ); 
        $this->Livestream_model->editMedia($media_data,$id);
        $this->session->set_flashdata("message","Information Updated Successfully.");
        redirect('admin/livestream/edit/'.$id);
         
     }
     
     public function delete($id){
        $this->Livestream_model->deleteMedia($id);
        $this->session->set_flashdata("message","Information Deleted Successfully.");
        redirect('admin/notification');
     }
	 
     public function notify($id){
        $mediaResult = $this->Livestream_model->getMediaById($id);		
		$selectedclass=$mediaResult->class_id;
		if(isset($selectedclass)&&$selectedclass>0){
		$selectedclass=$mediaResult->class_id;
		}else{
		$selectedclass=0;
		}
		
		if(isset($mediaResult->title)){
		$title=$mediaResult->title;		
				}else{
					$title='Hello';
				}
				if(isset($mediaResult->description)){
		$description=$mediaResult->description;
				}else{
		$description='student';
				}
		$notifyInfoArray = $this->Livestream_model->getStudentByClassId($selectedclass);
		if(is_array($notifyInfoArray)){
		foreach($notifyInfoArray as $fireid){
		$url=base_url()."notify/?regId=".$fireid."&title=".$title."&message=".$description."&push_type=individual";

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 $contents = curl_exec($ch);
 //echo $contents;
		sleep(3); die;
		}
		die;
        $this->session->set_flashdata("message","Information Sent Successfully.");
		}else{
			
        $this->session->set_flashdata("message","Information Not Found!");
		}
		
		
		
        //$this->Livestream_model->notify($id);
         redirect('admin/notification');
     }
	 
	 
    

}

?>
