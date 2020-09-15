<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mergesection extends MY_Admincontroller {
    public function __construct(){
        parent::__construct();
        
        $this->load->model('Tags_model'); 
        $this->load->model('Content_model');
        $this->load->model('Chapters_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->load->model('Examcategory_model');
        $this->load->model('Subjects_model');
        $this->data['content_type_array'] = $this->Content_model->getContentType();
        $exams = $this->Examcategory_model->getAdminExamCatgeories();
        $this->data['exams_array'] = $exams;
        $this->data['subjects_array'] = $this->Subjects_model->getSubjects();
        $this->data['chapters_array'] = $this->Chapters_model->getChapters();
        $content_type_id =$this->uri->segment(5); 
        $this->data['content_type_id'] ='';
        $this->data['content_type_exam_id'] ='';
        $this->data['content_type_subject'] ='';
        $this->data['content_type_chapter_id'] ='';
                
                
    }
    public function index(){
        /***** pgination _categories***   */
        $config = array();
        $config["base_url"] = base_url() . "admin/tags/index/";
        $config["total_rows"] = $this->Tags_model->getTagsCount();
        $config["per_page"] = $this->config->item('records_per_page');
        $config["uri_segment"] = 4;
        $config["num_links"] = 5;
        $config['first_link']='&lsaquo; First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link']='Last &rsaquo;';
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
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $this->data["links"] = $this->pagination->create_links();
        $this->data['tags']=$this->Tags_model->getTags($config["per_page"], $page);         
        $this->data['content']='tags/index';
        $this->load->view('common/template',$this->data);
    } 
    
    public function merge(){
        $this->data['content']='mergesection/merge';
        $this->load->view('common/template',$this->data);
    }
    
    public function save_merge(){
        //print_r($this->input->post());
        $moduleId=$this->input->post('getModuleId');
        $moduleType=$this->input->post('getModuleType');
        $related_moduleId=$this->input->post('related_moduleId');
        $relatedModuleType=$this->input->post('related_moduleType');
        $mergeDelete=$this->input->post('mergeDelete');
		$modules_item_id_array=$this->input->post('modules_item_id');
		
         $this->load->model('Mergesection_model');
         
              //echo $moduleId,'-',$moduleType,'-',$related_moduleId,'-',$relatedModuleType,'-',$mergeDelete; 
           // die;
        if(isset($mergeDelete) && $mergeDelete == 'Yes'){
            
               //$this->Mergesection_model->delete_merge_section($moduleId,$moduleType,$related_moduleId,$relatedModuleType);
             $this->session->set_flashdata('message',"Please check Information NOT Deleted.");
        
        }else{
        //$get_fileidArray=$this->Mergesection_model->get_fileid_by_studymaterial($related_moduleId);
		
		 if(isset($modules_item_id_array)&&count($modules_item_id_array)>0){
			 
			foreach($modules_item_id_array as $filekey=>$fileval){
			 
			$data=array(
            'module_id'=>$moduleId,
            'module_type'=>$moduleType,
            'related_module_id'=>$related_moduleId[$fileval],
            'related_module_type'=>$relatedModuleType,
			'related_file_id'=>$fileval,
			'created_at'=>date('d-m-yy'),
        );  
          $this->Mergesection_model->merge_module($data);
			
		
			
			} 
			$errmsg="Information submited.";
		 }else{
	 $errmsg="Please check Information NOT submited.";
			
		}
		
            $this->session->set_flashdata('message',$errmsg);
	 
        }  
            redirect('admin/mergesection/merge/' . $moduleId . '/' . $moduleType);
        
    }
  
      
          public function save_merge_lastlevel($moduleId,$moduleType,$related_moduleId,$relatedModuleType,$last_levelId){
              $this->load->model('Mergesection_model');
            $data=array(
            'module_id'=>$moduleId,
            'module_type'=>$moduleType,
            'related_module_id'=>$related_moduleId,
            'related_module_type'=>$relatedModuleType,
            'related_file_id'=>$last_levelId
        );
        
            $this->Mergesection_model->merge_module($data);
            
            $this->session->set_flashdata('message',"Information submited.");
              redirect('admin/mergesection/merge/' . $moduleId . '/' . $moduleType);
        
          }
          
              public function delete_merge($moduleId,$moduleType,$related_moduleId,$relatedModuleType,$last_levelId){
           $this->load->model('Mergesection_model'); 
            $this->Mergesection_model->delete_merge_section($moduleId,$moduleType,$related_moduleId,$relatedModuleType,$last_levelId);
      }
    
    
}
