<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Subjects extends MY_Admincontroller {

        public function __construct()
        {
            parent::__construct();
            $this->load->library("pagination");
            $this->load->library('form_validation');
            $this->load->helper(array('form', 'url'));
            $this->load->model('Subjects_model'); 
        }
        public function index($page=0)
        {   
                /***** pgination _categories***   */
                $config = array();
                $config["base_url"] = base_url() . "admin/subjects/index/";
                $config["total_rows"] = $this->Subjects_model->getSubjectsCount();
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
                //$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                $this->data["links"] = $this->pagination->create_links();
                $this->data['subjects']=$this->Subjects_model->getSubjects();         
                $this->data['content']='subjects/index';
                $this->load->view('common/template',$this->data);
        }
		
	// code by Mahesh 
	public function sub_subjects($id) {
		
		$this->data['subjects']=$this->Subjects_model->getSubject($id);
		
		$parentId=$this->input->post('parentId');
		
		if($this->input->post('add_sub_subject')) {
			$name=$this->input->post('name');
			$parentId=$this->input->post('parentId');
			$order=$this->input->post('order');
			$description=$this->input->post('description');
			$keywords=$this->input->post('keywords');
			$tagline=$this->input->post('tagline');
			
			$current_dt = date('Y-m-d h:i:sa');
			
			$data = array('name'=>$name,
			'parent_id'=>$parentId,
			'order'=>$order,
			'created'=>$current_dt,
			'description'=>$description,
			'keywords'=>$keywords,
			'tagline'=>$tagline);
			
			$this->Subjects_model->add_sub_subject($data);
			echo "<script>alert('Subject Addded Successfully!');</script>";
	
		}	
		
		$sub_subjects = $this->Subjects_model->get_sub_subject($id); 
		
		$this->data['sub_subjects']=$sub_subjects;
		
		$this->data['content']='subjects/sub_subjects';
		$this->load->view('common/template',$this->data);
	}
	
	public function edit_sub_subjects($id) {
		
		$sub_subjects = $this->Subjects_model->getSubject($id);
		
		$this->data['sub_subjects']=$sub_subjects;
		
		if($this->input->post('edit_sub_subject')) {
			
			$name=$this->input->post('name');
			$parentId=$this->input->post('parentId');
			$order=$this->input->post('order');
			$description=$this->input->post('description');
			$keywords=$this->input->post('keywords');
			$tagline=$this->input->post('tagline');
			$current_dt = date('Y-m-d h:i:sa');
			
			$data = array('name'=>$name,
			'order'=>$order,
			'dt_modified'=>$current_dt,
			'description'=>$description,
			'keywords'=>$keywords,
			'tagline'=>$tagline);
			
			$this->Subjects_model->update_sub_subjects($id,$data);
			echo "<script>alert('Subject Updated Successfully!');</script>";
			redirect('admin/subjects/sub_subjects/'.$parentId);
		}
		
		$this->data['content']='subjects/edit_sub_subjects';
		
		$this->load->view('common/template',$this->data);
	}
	
	
        public function add(){
	$this->form_validation->set_rules('name', 'Name', 'required');
	// $this->form_validation->set_rules('description', 'description','required');
	if ($this->form_validation->run() == FALSE) {
		$this->index();
	}
	else {
		$this->data = array(
			'name' => $this->input->post('name') ,
			'order' => $this->input->post('order') ,
			'description' => $this->input->post('description') ,
			'keywords' => $this->input->post('keywords') ,
			'tagline' => $this->input->post('tagline')
		);
		if ($this->input->post("update")) {
			$update_id = $this->input->post("update");
			$this->Subjects_model->updateSubject($this->data, $update_id);
			echo "<h3>Subject Updated</h3>";
		}
		else {
			echo $result = $this->Subjects_model->addSubject($this->data);
			echo "<h3>Subject Added</h3>";
			//    redirect('admin/categories');

		}

		redirect('admin/subjects');//$this->index();
	}

	 
	//   $this->loade->view("categories");

    }
    public function edit($id){
	
	$subject = $this->Subjects_model->getSubject($id);
	$this->data['result'] = $subject;
	$this->data['content'] = 'subjects/index';
	$this->load->view('common/template', $this->data);
    }
    
    public function delete($id){
        $this->Subjects_model->deleteSubject($id);
        redirect('admin/subjects');
    }
    
    public function byexam($exam_id) {
        $subjects=$this->Subjects_model->getSubjectsByExam($exam_id);
        echo json_encode($subjects);
    }
}

?>
