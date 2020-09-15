<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Topics extends MY_Admincontroller {
    public function __construct(){
        parent::__construct();
        
        $this->load->model('Topics_model');
        $this->load->model('Chapters_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->data['chapters']=$this->Chapters_model->getChapters();
    }
    public function index(){
        /***** pgination _categories***   */
        $config = array();
        $config["base_url"] = base_url() . "admin/topic/index/";
        $config["total_rows"] = $this->Topics_model->getTopicsCount();
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
        $this->data['topics']=$this->Topics_model->getTopics($config["per_page"], $page);         
        $this->data['content']='topics/index';
        $this->load->view('common/template',$this->data);
    } 
    public function add(){
        
          $this->form_validation->set_rules('name', 'Name','required');
          $this->form_validation->set_rules('chapter_id', 'Chapter','required');
          
          //$this->form_validation->set_rules('description', 'description','required');
          if ($this->form_validation->run() == FALSE){
              $this->index();

            }else{
            
         $data = array(
            'name' => $this->input->post('name'),
            'chapter_id'=>  $this->input->post('chapter_id'),
            'order' => $this->input->post('order'));
            if($this->input->post("update")){
                  $update_id=$this->input->post("update");
                  $this->Topics_model->updateTopic($update_id,$data);
                  echo "<h3>Topic Updated</h3>";
             }else{
             echo  $result = $this->Topics_model->addTopic($data);
               
            echo "<h3>Topic Added</h3>";
        //    redirect('admin/categories');
             }
        
            $this->index();
          }
         
        }
        public function edit($id){
            /*    edit categories */             
            $result=$this->Topics_model->getTopic($id);
            //print_r($result); die;
            $this->data['result']=$result;
            $this->data['content']='topics/index';
            $this->load->view('common/template',$this->data);
                            
        }
}
