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
       $this->data['folder_admin']=$this->config->item('dir_salesadmin');
       $this->folder_admin=$this->config->item('dir_salesadmin');
  }

  public function index()
	{
	      $data['content']='login/login';
              $this->load->view('common/login/template',$data);
	}
	
public function login_check() {
                           $folder_admin=$this->folder_admin;
                  $email=$this->input->post('email');
                  $password=$this->input->post('password');
				  
				   if(isset($email)&&isset($password)){
                  $logdata=array('ipaddress'=>$_SERVER['REMOTE_ADDR'],'logintime'=>time(),'email'=>$email);
				  }else{ 
				       $this->session->set_flashdata('msg', 'Enter Email or Password.');
                  redirect('/'.$folder_admin.'/logout'); 
				  }
                  $logdata=array('ipaddress'=>$_SERVER['REMOTE_ADDR'],'logintime'=>time(),'email'=>$email);
                  $result=$this->user_model->login_admin($email,$password);
				          if($result){
                           $newdata = array(  
                            'password'      =>  $password,
                            'userid'        =>  $result->id,
                            'first_name'    =>  $result->first_name,
                            'last_name'     =>  $result->last_name,
                            'company'   =>     $result->company, 
                            'postcode'   =>     $result->postcode,'usertype'   =>     $result->type);
                           if(isset($result->type)){
                            $usertype=$result->type;   
                           }else{
                               $usertype=NULL;
                           }
                           
                           if($usertype==3||$usertype==4){
							   //Franchise and school can enter only
							   if($usertype==3){
					$newdata['saleslogged_in']=TRUE;$newdata['schoollogged_in']=FALSE;
                               }else if($usertype==4){  
					$newdata['schoollogged_in']=TRUE;$newdata['saleslogged_in']=FALSE;
							   }else{
					$newdata['saleslogged_in']=FALSE;
					$newdata['schoollogged_in']=FALSE;
							   } 
        }else{
			  $this->session->set_flashdata('msg', 'Only register admin can login or email not found!'); 
		   redirect('/'.$folder_admin.'/login'); 
		}
                           $logdata['success']=1;
                           $logdata['userid']=$result->id; 
                           $this->user_model->updatelog($logdata);
                         $this->session->set_userdata($newdata);
                         //  foreach($newdata as $key=>$value){
                         //      $_SESSION[$key]=$value;
                         //  }
                          $ajaxResponseStatus['success']='true';  
						  $this->session->set_flashdata('msg', 'Welcome Admin.');
                          redirect('/'.$this->folder_admin.'/dashboard');
                           }else{
                              $logdata['success']=0;
                              $logdata['userid']=0;
                               $this->user_model->updatelog($logdata);
							   $msvar="<h4><b>Incorrect Email Or Password</b></h4>"; 
                                $data['msg']= $msvar;
                                $data['content']='login/login'; 
								$this->session->set_flashdata('msg', $msvar);
                                $this->load->view('common/login/template',$data);
                           }
             }
			 
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/'.$this->folder_admin.'/login');
	}
			 
  
}

?>
