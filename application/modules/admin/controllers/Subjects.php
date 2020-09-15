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
