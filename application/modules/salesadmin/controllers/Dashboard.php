<?php
class Dashboard extends MY_Salescontroller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Customer_model');   
        $this->load->model('Orders_model');  
        $this->load->model('Admin_model');
		
    }
    public function index(){
        //$logs=$this->user_model->getlog();
        //$this->data['logs']=$logs;
        $franchiseid=$this->session->userdata('userid');
$usertype=$this->session->userdata('usertype');       
	   $orders_count=$this->Orders_model->franchise_totalorder($franchiseid,1);
		$alltotal_order=$this->Orders_model->franchise_totalorder($franchiseid);
        $this->data['total_order']=$orders_count;
        $earnings=$this->Orders_model->total_earnings($franchiseid);
        $this->data['total_revenue']=$earnings->order_price;
        $customers_count=$this->Orders_model->monthlysales($usertype,$franchiseid);
        $this->data['monthly_sales']=$customers_count;
		$franchise_student=$this->Customer_model->franchise_users($usertype,$franchiseid);
		$this->data['dir_salesadmin']=$this->config->item('dir_salesadmin');
        $this->data['franchise_student']=$franchise_student; 
		$this->data['alltotal_order']=$alltotal_order;
        $this->data['content']='dashboard/dashboard'; 
        $this->load->view('common/template',$this->data);
    }
	
    public function myprofile(){
        //$logs=$this->user_model->getlog();
        //$this->data['logs']=$logs;
		$franchiseid=$this->session->userdata('userid');
		$getAdminUser=$this->Admin_model->getAdminUser($franchiseid);	
        $franchiseid=$this->session->userdata('userid');		 
		$this->data['getAdminUser']=$getAdminUser;		
        $this->data['content']='dashboard/myprofile'; 
        $this->load->view('common/template',$this->data);
    }
}
?>