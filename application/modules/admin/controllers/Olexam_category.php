<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Olexam_category extends MY_Admincontroller {

        public function __construct()
        {
           parent::__construct();
            $this->load->library("pagination");
            $this->load->library('form_validation');
            $this->load->helper(array('form', 'url'));
            $this->load->model('Olexam_category_model'); 
        }
        
        public function index($page=0)
        {   
             /***** pgination _categories***   */
                $config = array();
                $config["base_url"] = base_url() . "admin/Olexam_category/index/";
                $config["total_rows"] = $this->Olexam_category_model->getCategoryCount();
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
                $this->data['subjects']=$this->Olexam_category_model->getCategories();      
                $this->data['content']='olexam_category/index';
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
			'keywords' => $this->input->post('keywords')
		);
		if ($this->input->post("update")) {
			$update_id = $this->input->post("update");
			$this->Olexam_category_model->updateCategory($this->data, $update_id);
			//echo "<h3>Category Updated</h3>";
		}
		else {
			echo $result = $this->Olexam_category_model->addCategory($this->data);
			//echo "<h3>Category Added</h3>";

			//    redirect('admin/categories');

		}

		redirect('admin/Olexam_category');//$this->index();
	}

	 redirect('admin/Olexam_category');
	//   $this->loade->view("categories");

    }
    public function edit($id){
	
	$subject = $this->Olexam_category_model->getCategory($id);
	$this->data['result'] = $subject;
	$this->data['content'] = 'olexam_category/index';
	$this->load->view('common/template', $this->data);
    }
    
    public function delete($id){
        $this->Olexam_category_model->deleteCategory($id);
        redirect('admin/Olexam_category');
    }
    
    public function byexam($exam_id) {
        $subjects=$this->Olexam_category_model->getCategoryByExam($exam_id);
        echo json_encode($subjects);
    }
}
?>
