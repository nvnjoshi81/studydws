<?php 
class User extends MY_Admincontroller
{

public function __construct()
	 {
		  parent::__construct();
               $this->load->helper('url');
               $this->load->library('session');
               $this->load->model('user_model');
               $this->load->library("pagination");
               $this->load->helper(array('form', 'url'));
               
    }
    public function index($page=0)
  {
   
    $config = array();
    $config["base_url"] = base_url() . "admin/user/index/";
    $config["total_rows"] = $this->user_model->getUserCount();
    $config["per_page"] = $this->config->item('records_per_page');;
    $config["uri_segment"] = 4;
    $config["num_links"] = 5;
    
    //$config['full_tag_open'] = '<a>';
    //$config['full_tag_close'] = '</a>';
    $config['prev_tag_open'] = '<a>';
    $config['next_link'] = '<button>Next</button>';
    $config['prev_link'] = '<button>previus</button>';
    $config['prev_tag_close'] = '</a>';
    $this->pagination->initialize($config);
    $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
    $users=$this->user_model->getUsers(null,$config["per_page"], $page);
    $data["links"] = $this->pagination->create_links();
    $data['users']=$users;
    
    
   
    $data['content']='users/users';
    $this->load->view('common/template',$data);
  }

   public function add_user(){
        $companyname=$this->input->post('companyname');
       $firstname=$this->input->post('firstname');
       $lastname=$this->input->post('lastname');
       $email=$this->input->post('email');
       $password=$this->input->post('password');
       $confirm_password=$this->input->post('confirm_password');
       $date = time();
      $data = array(
            'companyname' => $companyname,
            'firstname' => $firstname,
                  'lastname' => $lastname,
                  'email' => $email,
                  'password' => md5($password),
                  'dt_created' =>$date,
                  'dt_modified' => $date
           );
     // print_r($data); die;
          $this->load->model('user_model');
       $this->user_model->add_newaccount($data);
        redirect(base_url().'admin/user');
   }
   
   public function active($id){
          $config = array();
          $config["base_url"] = base_url() . "admin/user/active/id";
          $active_status=1;
          $update_data =array(
                 'verified'=>$active_status
                   );
            $this->user_model->update_active($id,$update_data); 
            redirect(base_url().'admin/user/');
   }
   public function deactive($id){
          $config = array();
          $config["base_url"] = base_url() . "admin/user/deactive/id";
          $active_status=0;
          $update_data =array(
                 'verified'=>$active_status
                   );
            $this->user_model->update_active($id,$update_data); 
            redirect(base_url().'admin/user/');
   }
   
   public function deleteuser($id){
          $config = array();
          $config["base_url"] = base_url() . "admin/user/deleteuser/id";
            $this->user_model->deleteuser($id); 
            redirect(base_url().'admin/user/');
   }

}
?>
