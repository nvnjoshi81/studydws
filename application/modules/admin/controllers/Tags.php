<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tags extends MY_Admincontroller {
    public function __construct(){
        parent::__construct();
        
        $this->load->model('Tags_model');
        $this->load->model('Chapters_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->data['chapters']=$this->Chapters_model->getChapters();
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
    public function add(){
        
          $this->form_validation->set_rules('name', 'Name','required');
          $this->form_validation->set_rules('chapter_id', 'Chapter','required');
          
          //$this->form_validation->set_rules('description', 'description','required');
          if ($this->form_validation->run() == FALSE){
              $this->index();

            }else{
            
            
                 $name=$this->input->post('name');
            if($this->input->post("update")){
               
                $data = array(
                'name' => $name,
                'chapter_id'=>  $this->input->post('chapter_id'),
                'order' => $this->input->post('order'));
                  $update_id=$this->input->post("update");
                  $this->Tags_model->updateTag($update_id,$data);
                  echo "<h3>Tag Updated</h3>";
             }else{
                 if(strpos($name, ',')){
                    $name=  explode(',',$name);
                }else{
                    $name[]=$name;
                }
                foreach($name as $key=>$value){
                    $data = array(
                'name' => $value,
                'chapter_id'=>  $this->input->post('chapter_id'),
                'order' => $this->input->post('order'));
                $result = $this->Tags_model->addTag($data);
                }
              
               
            $this->session->set_flashdata('adminmessage','Tags added successfully');
        //    redirect('admin/categories');
             }
        
           redirect('admin/tags');
          }
         
        }
        public function edit($id){
            /*    edit categories */             
            $result=$this->Tags_model->getTag($id);
            //print_r($result); die;
            $this->data['result']=$result;
            $this->data['content']='tags/index';
            $this->load->view('common/template',$this->data);
                            
        }
        public function delete($id) {
            $this->load->model('Tags_model','tags');
            $this->tags->deleteTag($id);
            redirect('/admin/tags');
        }
}
