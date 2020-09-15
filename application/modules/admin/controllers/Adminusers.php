<?php
class Adminusers extends MY_Admincontroller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Categories_model'); 
        $usertype=$this->session->userdata['usertype'];
        if($usertype!=1){
           redirect('/admin/logout');  
        }
    }
    public function index() {
		//echo '<'. sha1('now100M');
        $this->data['adminusers']=$this->Admin_model->getAdminUsers();
        $this->data['content']='users/adminusers';
        $this->load->view('common/template',$this->data);
    }
    public function add() {
        $this->data['categories']=$this->Categories_model->getCategories(0);
        $this->data['content']='users/addadminuser';
        $this->load->view('common/template',$this->data);
    }
    public function edit($id) {
        $this->data['categories']=$this->Categories_model->getCategories(0);
        $userpermissions=$this->Admin_model->getUserPermissions($id);
        $mod=array();
        $cat=array();
        foreach($userpermissions as $perms){
            if($perms->type=='mod'){
                $mod[]=$perms->item_id;
            }elseif($perms->type=='cat'){
                $cat[]=$perms->item_id;
            }
            
        }
        $this->data['mod']=  $mod;
        $this->data['cat']= $cat;
        $this->data['adminuser']=$this->Admin_model->getAdminUser($id);
        $this->data['content']='users/addadminuser';
        $this->load->view('common/template',$this->data);
    }
    public function adduser() {
       $first_name  =   $this->input->post('first_name');
       $last_name   =   $this->input->post('last_name');
       $email       =   $this->input->post('email');
       $moduleperms =   $this->input->post('moduleperms');  
       $categoryperms = $this->input->post('categoryperms');
       $password    =   $this->input->post('password');//generatePassword(8);
       $type        =   $this->input->post('type');
       $data        =   array(  'first_name'=>$first_name,
                                'last_name'=>$last_name,
                                'email'=>$email,
                                'password'=>sha1($password),
                                'type'=>$type);
       $id=$this->Admin_model->createUser($data);
       foreach($moduleperms as $key=>$value){
           $mperms=array('user_id'=>$id,'item_id'=>$value,'type'=>'mod');
           $this->Admin_model->userPermissions($mperms);
       }
       foreach($categoryperms as $key1=>$value1){
           $cperms=array('user_id'=>$id,'item_id'=>$value1,'type'=>'cat');
           $this->Admin_model->userPermissions($cperms);
       }
       $message="Dear {$first_name},<br>Your password for Studyadda Admin Panel is <b>{$password}</b><br>";
       $message.="Click <a href='".base_url()."admin'>here</a> to login";
       echo $message;
       //sendEmail($email,'Account Created',$message);
       //redirect('/admin/adminusers');
    }
     public function updateuser() {
       $user_id     =   $this->input->post('user_id');
       $first_name  =   $this->input->post('first_name');
       $last_name   =   $this->input->post('last_name');
       $email       =   $this->input->post('email');
       $moduleperms =   $this->input->post('moduleperms');  
       $categoryperms = $this->input->post('categoryperms');
       //$password    =   $this->input->post('password');//generatePassword(8);
       //$type        =   $this->input->post('type');
       $data        =   array(  'first_name'=>$first_name,
                                'last_name'=>$last_name,
                                'email'=>$email);
       $this->Admin_model->updateUser($user_id,$data);
       $this->Admin_model->flushPermissions($user_id);
       foreach($moduleperms as $key=>$value){
           $mperms=array('user_id'=>$user_id,'item_id'=>$value,'type'=>'mod');
           $this->Admin_model->userPermissions($mperms);
       }
       foreach($categoryperms as $key1=>$value1){
           $cperms=array('user_id'=>$user_id,'item_id'=>$value1,'type'=>'cat');
           $this->Admin_model->userPermissions($cperms);
       }
       redirect('/admin/adminusers/edit/'.$user_id);
    }
    
    public function delete($id) {
        $this->Admin_model->deleteUser($id);
        redirect('/admin/adminusers');
    }
}


