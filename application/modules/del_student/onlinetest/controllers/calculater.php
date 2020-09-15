<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Start extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Onlinetest_model');
        //$this->output->enable_profiler(TRUE);
        }
  
}