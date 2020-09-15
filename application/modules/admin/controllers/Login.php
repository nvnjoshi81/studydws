<?php
class Login extends CI_Controller
{
   public function __construct()
  {
	       parent::__construct();
               $this->load->library('form_validation');
               $this->load->helper(array('form'));
               //$this->load->model('settings_db');
               $this->load->model('user_model');
               
               
  }

  public function index()
	{   
	      $data['content']='login/login';
              $this->load->view('common/login/template',$data);

	}
public function login_check() {
                  $email=$this->input->post('email');
                  $password=$this->input->post('password');
                  $logdata=array('ipaddress'=>$_SERVER['REMOTE_ADDR'],'logintime'=>time(),'email'=>$email);

                  $result=$this->user_model->login_admin($email,$password);
                          if($result){
                           $newdata = array(                            
                            'password'      =>  $password,
                            'userid'        =>  $result->id,
                            'first_name'    =>  $result->first_name,
                            'last_name'     =>  $result->last_name,
                            'usertype'   =>  $result->type,
                            'logged_in' => TRUE
                             );
                           $logdata['success']=1;
                           $logdata['userid']=$result->id;                           
                           $this->user_model->updatelog($logdata);
                         $this->session->set_userdata($newdata);
                         //  foreach($newdata as $key=>$value){
                         //      $_SESSION[$key]=$value;
                         //  }
                          $ajaxResponseStatus['success']='true';
                           redirect('/admin/dashboard');
                            }else{
                              $logdata['success']=0;
                              $logdata['userid']=0;
                               $this->user_model->updatelog($logdata);
                                $data['msg']= "<h4><b>Incorrect Email Or Password</b></h4>"; 
                                $data['content']='login/login';
                                $this->load->view('common/login/template',$data);
                           }

             }
  
}

?>
