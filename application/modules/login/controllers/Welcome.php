<?php 
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends MY_Controller {
    public function __construct() {
        parent:: __construct();        
	$this->data['showbreadcrumb']=true;
	$breadcrumb=array();		
    }
    public function index(){
	$this->load->helper('captcha');
        $this->load->helper('string');
        if ($this->session->userdata('customer_id')) {
            redirect('/customer');
        }
        // echo $_SERVER['HTTP_REFERER'];
        if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER'] != base_url().
                'customer/login')) {
            $this->data['redirect'] = 1;
            $this->data['redirect_url'] = $_SERVER['HTTP_REFERER'];
        } else {
            $this->data['redirect'] = 0;
        }
        if( $this->session->userdata('redirecturl')){
            $this->data['redirect'] = 1;
            $this->data['redirect_url'] = $this->session->userdata('redirecturl');
        }
        $random_string = random_string('numeric', 4);
        $this->session->set_userdata('verification_code', $random_string);
        $vals = array(
            'word' => $random_string,
            'img_path' => './captcha/',
            'img_url' => base_url().
            'captcha/',
            //'font_path'    => './system/fonts/texb.ttf',
            'img_width' => '150',
            'img_height' => 30,
            'expiration' => 3600
        );


        $cap = create_captcha($vals);


        $this->data['veri_image'] = $cap;

        $this->data['content'] = 'index';
        //$this->data['page_meta_keywords'] = $this->config->item('page_meta_keywords');
        //$this->data['page_meta_description'] = $this->config->item('page_meta_description');
        //$this->data['page_title'] = 'Online Shopping: Shop Online for Food, Herbal cosmetics, Juices, Ayurvedic medicines, Books, CD, DVD - Patanjaliayurved.net';
        $this->load->view('template', $this->data);
    }
}