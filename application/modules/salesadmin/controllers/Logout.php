<?php
class Logout extends CI_Controller
{
   public function __construct()
  {
	parent::__construct();
             
  }

  public function index()
	{   
	      $this->session->sess_destroy();
              
      $sales_admin_path=$this->config->item('dir_salesadmin');
              redirect('/'.$sales_admin_path.'/login');
         }
}

?>
