<?php

class History extends MY_Admincontroller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('History_model');
        $this->load->library("pagination");
        $this->load->helper(array('form', 'url'));
    }

    public function index($type) {

        $config = array();
        $config["base_url"] = base_url() . "admin/history/index/".$type.'/';
        $config["total_rows"] = $this->History_model->count($type);
        $config["per_page"] = $this->config->item('records_per_page');
        ;
        $config["uri_segment"] = 5;
        $config["num_links"] = 5;

        $config['first_link'] = '&lsaquo; First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &rsaquo;';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $histories = $this->History_model->all($type, $config["per_page"], $page);
        $this->data["links"] = $this->pagination->create_links();
        $this->data['histories'] = $histories;
        $this->data['index']=($page< 1?$page:$page-1)*$config['per_page']+1;
        $this->data['content'] = 'history/list';
        $this->load->view('common/template', $this->data);
    }

}

?>
