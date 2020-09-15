<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model','User');
    }
    public function login(){
        
    }
    public function logout(){
        
    }
    public function dashboard(){
        
    }
}

