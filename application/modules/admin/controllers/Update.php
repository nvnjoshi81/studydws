<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Update extends MY_Admincontroller {

        public function __construct()
        {
            parent::__construct();
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] !== true){
                redirect(base_url().'admin/login');
            }
            $this->load->model('Update_model');
            
            $this->load->model('Admin_model');
        }
        
         public function admin_password()
        { 
                $date = time();
                $password = $this->input->post('password');
                $confirm_password = $this->input->post('confirm_password');
                if($confirm_password!=$password){
                $this->session->set_flashdata('update_msg', 'Both Pasword should be same.');
		redirect('admin/dashboard'); 
                die();
                }                
		$user_id = $this->input->post('user_id');
		$passwordarray = array('password'=>sha1($password),'dt_modified'=>$date);
		$this->Admin_model->updateUser($user_id,$passwordarray);
		$this->session->set_flashdata('update_msg', 'Password updated successfully');
		redirect('admin/dashboard');
             
        }
       
}

?>
