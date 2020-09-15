<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends MY_Controller {
    public function __construct() {
        parent:: __construct();
         $this->load->model('Meating_model');
    }
    public function index(){       
    $this->data['content']='welcome';               
	$this->load->view('template',$this->data);
    }
    
}
?>
