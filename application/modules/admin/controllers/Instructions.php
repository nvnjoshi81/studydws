<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Instructions extends MY_Admincontroller {

        public function __construct()
        {
            parent::__construct();            
            $this->load->library("pagination");
            $this->load->library('form_validation');
            $this->load->helper(array('form', 'url'));            
            $this->load->model('Content_model');  
            $this->load->model('Instructions_model');           
            $this->data['content_type_array']=$this->Content_model->getContentType();
            $this->data['instructions_list']=$this->Instructions_model->getInstruction(); 
       
            }
        
        public function index($page=0)
        {   
                /***** pgination _categories***   */
                $config = array();
                $config["base_url"] = base_url() . "admin/instructions/index/";
                $config["total_rows"] = $this->Instructions_model->getInstructionsCount();
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
                $this->data["links"] = $this->pagination->create_links();        
                $this->data['content']='instructions/index';
                               
                $this->load->view('common/template',$this->data);
        }
        

public function add()
	{
	$this->form_validation->set_rules('content_type', 'content_type', 'required');

	// $this->form_validation->set_rules('description', 'description','required');

	if ($this->form_validation->run() == FALSE)
		{
		$this->session->set_flashdata('message', $add_content_type->name . 'Content Type is required!');
		redirect('admin/instructions/index');
		}
	  else
		{
		$zipfolder_path = '/upload_pdf/';
		$zip_field_name_html = 'zip_file';
		$extractfolder_path_html = '/upload/html_folder/';
		if (($_FILES['zip_file']['size'] > 0) && $_FILES['zip_file']['name'] != '')
			{
			/*Multiple Upload section for Instruction*/
			/* Upload questions zip section */
			$extract_file_name = upload_extract_file($zipfolder_path, $extractfolder_path_html, $zip_field_name_html, $extract = 'yes');

			// fatch question answer from uploaded html folder

			$html_folder_name_path = $extractfolder_path_html . $extract_file_name;
			$text_question_answer = get_content_array_by_zip($html_folder_name_path, $extractfolder_path_html);
			$content_question_answer = clear_html_text($text_question_answer);
			}

		/*zip Upload section for Article*/
		if (isset($extract_file_name) && ($extract_file_name != ''))
			{
			$description_text = $content_question_answer;
			}
		  else
			{
			$description_text = $this->input->post('description');
			}

		$this->data = array(
			'description' => $description_text,
			'content_type' => $this->input->post('content_type')
		);
		if ($this->input->post("update"))
			{
			$update_id = $this->input->post("update");
			$this->Instructions_model->updateInstruction($update_id, $this->data);
			$this->session->set_flashdata('message', 'Instruction Updated!');
			}
		  else
			{
			$result = $this->Instructions_model->addInstruction($this->data);
			$this->session->set_flashdata('message', 'Instruction Added!');
			}

		redirect('admin/instructions/index');
		}
	}

        public function edit($id){
            /*    edit categories */             
            $result=$this->Instructions_model->getInstructionDetail($id);
            //print_r($result); die;
            $this->data['instructions']=$result;
            $this->data['content']='instructions/index';
            $this->load->view('common/template',$this->data);
                            
        }
        
        public function delete($id)
        {
                $this->Instructions_model->deleteInstruction($id);
                $this->session->set_flashdata('message', 'Instruction Deleted!');
                redirect('admin/instructions/index');
        }

    
}
?>
