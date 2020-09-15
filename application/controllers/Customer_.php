<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller {
	
	 public function __construct() {
        parent:: __construct();
		$this->load->model('Customer_model');
		$this->load->model('Orders_model');
		$this->load->model('Products_model');
		//$this->load->model('Location_model');
		$this->data['showbreadcrumb']=true;
		$breadcrumb=array();
		
	 }
	 public function login()
	 {
		 $this->load->helper('captcha');
		 $this->load->helper('string');
		 if($this->session->userdata('logged_id')){
			redirect('customer');
		}
		// echo $_SERVER['HTTP_REFERER'];
		if (isset($_SERVER['HTTP_REFERER'])&& ($_SERVER['HTTP_REFERER']!=base_url().'customer/login')) {
			$this->data['redirect'] = 1;
			$this->data['redirect_url']=$_SERVER['HTTP_REFERER'];
		}else{
			$this->data['redirect'] = 0;
		}
		$random_string = random_string('numeric', 4);
		$this->session->set_userdata('verification_code',$random_string);
		$vals = array(
		    'word'   => $random_string,
		    'img_path'  => './captcha/',
		    'img_url'   => base_url() . 'captcha/',
		    //'font_path'    => './system/fonts/texb.ttf',
		    'img_width'    => '150',
		    'img_height' => 30,
		    'expiration' => 3600
		    );

		
		$cap = create_captcha($vals);
		
		
		$this->data['veri_image']=$cap;

		 $this->data['content'] = 'customer/login';
         $this->data['page_meta_keywords']=$this->config->item('page_meta_keywords');
        $this->data['page_meta_description']=$this->config->item('page_meta_description');
        $this->data['page_title']='Online Shopping: Shop Online for Food, Herbal cosmetics, Juices, Ayurvedic medicines, Books, CD, DVD - Patanjaliayurved.net';
		 $this->load->view('template',$this->data);
	 }
	 public function logout()
	 {
		$this->session->sess_destroy();
		redirect(base_url());
		
	 }
	 public function myaccount(){
		  $breadcrumb[]=array('text'=>'Dashboard','href'=>base_url().'customer');
		  $breadcrumb[]=array('text'=>'Account Info','href'=>'');
		  $this->data['content'] = 'customer/myaccount';
		  $this->data['user_info'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
                  $this->data['page_title']='My Account - Dashboard - Studyadda.com';
		  $this->data['breadcrumb']=$breadcrumb;
		  $this->load->view('template',$this->data);
	 }
	//
	public function addaddress()
	 {
		  $breadcrumb[]=array('text'=>'Dashboard','href'=>base_url().'customer');
		  $breadcrumb[]=array('text'=>'Addresses','href'=>'');
		  $this->data['content'] = 'customer/addaddress';
		  
		   $this->data['user_details'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
		  $default_address = $this->Customer_model->getDefaultAddress($this->session->userdata('customer_id'));
		  $this->data['user_info'] = $this->Customer_model->getAddresses($this->session->userdata('customer_id'),$default_address->id);
		  $location = $this->Location_model->getState();
		  $this->data['location'] = $location;
		  $this->data['default_address'] = $default_address;
          $this->data['page_title']='My Account - New Address - Patanjaliayurved.net';
		  $this->data['breadcrumb']=$breadcrumb;
		  $this->load->view('template',$this->data);
	 }
	//
	 public function addresses()
	 {
		  $breadcrumb[]=array('text'=>'Dashboard','href'=>base_url().'customer');
		  $breadcrumb[]=array('text'=>'Addresses','href'=>'');
		  $this->data['content'] = 'customer/addresses';
		  
		   $this->data['user_details'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
		  $default_address = $this->Customer_model->getDefaultAddress($this->session->userdata('customer_id'));
		  $this->data['user_info'] = $this->Customer_model->getAddresses($this->session->userdata('customer_id'),$default_address->id);
		  $location = $this->Location_model->getState();
		  $this->data['location'] = $location;
		  $this->data['default_address'] = $default_address;
          $this->data['page_title']='My Account - Addresses - Patanjaliayurved.net';
		  $this->data['breadcrumb']=$breadcrumb;
		  $this->load->view('template',$this->data);
	 }
	 public function wishlist()
	 {
		  $breadcrumb[]=array('text'=>'Dashboard','href'=>base_url().'customer');
		  $breadcrumb[]=array('text'=>'Wishlist','href'=>'');
		  $this->data['content'] = 'customer/wishlist';
		  $this->data['product_wishlist'] = $this->Customer_model->getWishlistItems($this->session->userdata('customer_id'));
          $this->data['page_title']='My Account - Wishlist - Patanjaliayurved.net';
		  $this->data['breadcrumb']=$breadcrumb;
		  $this->load->view('template',$this->data);
	 }
	 public function orders()
	 {
		  $config = array();
          $config['per_page'] = 5;
          $config['base_url'] = base_url().'customer/orders';
          $config['use_page_numbers'] = TRUE;
		  $config['total_rows'] = $this->Customer_model->getCustomerOrdersCount($this->session->userdata('customer_id'));
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        } 
       
        $this->pagination->initialize($config);
		//
		  $breadcrumb[]=array('text'=>'Dashboard','href'=>base_url().'customer');
		  $breadcrumb[]=array('text'=>'Orders','href'=>'');
		  $this->data['content'] = 'customer/orders';
		  $this->data['user_info'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
		  $orders = $this->Orders_model->getMyOrders($this->session->userdata('customer_id'),$config['per_page'],$limit_end);
		  $this->data['my_orders'] = $orders;
		  // query for the past orders from old order table // starts
		  // $this->data['past_orders'] = $this->Orders_model->getPastorders($this->data['user_info']->legacy_id);
		  // query for the past orders from old order table // ends
		  $this->data['page_title']='My Account - Orders - Patanjaliayurved.net';
		  $this->data['breadcrumb']=$breadcrumb;
		  $this->load->view('template',$this->data);
	 }
	 //
	 public function pastorders()
	 {
		  $customer_details = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
		  $config = array();
          $config['per_page'] = 5;
          $config['base_url'] = base_url().'customer/pastorders';
          $config['use_page_numbers'] = TRUE;
		  $config['total_rows'] = $this->Orders_model->getPastOrdersCount($customer_details->legacy_id);
          $config['num_links'] = 20;
          $config['full_tag_open'] = '<ul>';
          $config['full_tag_close'] = '</ul>';
          $config['num_tag_open'] = '<li>';
          $config['num_tag_close'] = '</li>';
          $config['cur_tag_open'] = '<li class="active"><a>';
          $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        } 
       
        $this->pagination->initialize($config);
		  $breadcrumb[]=array('text'=>'Dashboard','href'=>base_url().'customer');
		  $breadcrumb[]=array('text'=>'Orders','href'=>'');
		  $this->data['content'] = 'customer/pastorders';
		  $this->data['page_title']='My Account - Orders - Patanjaliayurved.net';
		  $this->data['breadcrumb']=$breadcrumb;
		  $this->data['user_info'] = $customer_details;
		  $this->data['past_orders'] = $this->Orders_model->getPastorders($customer_details->legacy_id,$config['per_page'],$limit_end);
		  $this->load->view('template',$this->data);
	 }
	 //
	 public function orderdetails($id){
		 $order=$this->Orders_model->getOrderDetails($id); 
		 $breadcrumb[]=array('text'=>'Dashboard','href'=>base_url().'customer');
		 $breadcrumb[]=array('text'=>'Orders','href'=>base_url().'customer/orders');
		 $breadcrumb[]=array('text'=>'Order Details - '.$order->order_no,'href'=>'');
		 $this->data['content'] = 'customer/orderdetails';
		 $this->data['user_info'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
		  //$orders = $this->Orders_model->getMyOrders($this->session->userdata('customer_id'));
		  //$this->data['my_orders'] = $orders;
		 //$order=$this->Orders_model->getOrderDetails($id); 
		 $this->data['shipping_addresses']=$this->Customer_model->getShippingAddresses($order->shipping_id);
		 $order_details = $this->Orders_model->getFullorderDetails($id);
		 // print_r($order_details);
		 // die();
		 
		 
		 $this->data['order'] = $order;
		 $this->data['breadcrumb']=$breadcrumb;
		 $this->data['order_details'] = $order_details;
		 $this->load->view('template',$this->data);
	 }
	 //
	  public function index()
	 {
		 $breadcrumb[]=array('text'=>'Dashboard','href'=>base_url().'customer');
		  
		 $this->data['content'] = 'customer/dashboard';
		  $this->data['user_info'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
		  
		  $default_address = $this->Customer_model->getDefaultAddress($this->session->userdata('customer_id'));
		  if($default_address){
			$this->data['default_address'] = $default_address;
			$default_address_id=$default_address->id;
		  }else{
		    $this->data['default_address']=null;
			$default_address_id=0;  
		  }
		  
		  $this->data['user_address'] = $this->Customer_model->getAddresses($this->session->userdata('customer_id'),$default_address_id);
		  $orders = $this->Orders_model->getMyOrders($this->session->userdata('customer_id'));
		  $this->data['my_orders'] = $orders;
		  $this->data['page_title']='My Account - Dashboard - Patanjaliayurved.net';
		  $this->data['breadcrumb']=$breadcrumb;
		  //$this->Customer_model->getCustomerOrdersCount($this->session->userdata('customer_id'));
		  $this->load->view('template',$this->data);
	 }
	 public function updatecustomer(){
		 $firstname = $this->input->post('firstname');
		 $lastname = $this->input->post('lastname');
		 $email = $this->input->post('email');
		 $mobile = $this->input->post('mobile');
		 $user_id = $this->input->post('user_id');
		 $userdata = array('firstname'=>$firstname,
						   'lastname'=>$lastname,
							'email'=>$email,
							'mobile'=>$mobile);
		 $this->Customer_model->updatecustomerinfo($user_id,$userdata);
		 $this->session->set_flashdata('update_msg','Your information has been updated successfully');
		 redirect('customer/myaccount');
	 }
	 // public function pastorderdetails(){
		 // $this->data['content'] = 'customer/oldorderdetails';
		 // $this->load->view('template',$this->data);
	 // }
	 public function changePassword(){
		$password = $this->input->post('password');
		$user_id = $this->input->post('user_id');
		$passwordarray = array('password'=>sha1($password));
		$this->Customer_model->updatePassword($passwordarray,$user_id);
		$this->session->set_flashdata('update_msg', 'Password updated successfully');
		redirect('/customer');
	 }
	 public function address($id){
		 $default_address=$this->Customer_model->getAddressDetail($id);
		 $location = $this->Location_model->getState();
		 $city = $this->Location_model->fetchCity($default_address->state_name,'resultset');
		 
		 $data['cities'] = $city;
		 $data['location'] = $location;
		 $data['default_address']=$default_address;
		 $this->load->view('customer/address',$data);
	 }
	 public function setdefault($address_id){
		 $default_address=$this->Customer_model->setDefault($address_id,$this->session->userdata('customer_id'));
		 $this->session->set_flashdata('update_msg','This address has been set as your default address');
		 redirect('/customer/addresses');
		 //$data['default_address']=$default_address;
		 //$this->load->view('customer/address',$data);
	 }
	 public function removeWishlist($id,$name){
		 $this->Customer_model->removeFromWishlist($id);
		 $this->session->set_flashdata('update_msg', urldecode($name)."&nbsp;".'has been removed from your wishlist');
		redirect('customer/wishlist');
	 }
	 public function customerReviews(){
		 $user_id = $this->input->post('user_id');
		 $product_id = $this->input->post('product_id');
		 $product_name = $this->input->post('product_name');
		 $customername = $this->input->post('customername');
		 $title = $this->input->post('title');
		 $summary = $this->input->post('summary');
		 $ratings = $this->input->post('ratings');
		
		 $review_array = array('user_id'=>$user_id,
							   'product_id'=>$product_id,
							   'username'=>$customername,
							   'userreviewtitle'=>$title,
							   'review'=>$summary,
							   'ratingstar'=>$ratings,
							   'status'=>0,
							   'redate'=>time());
							   
		$review_array_data = $this->Customer_model->addReview($review_array);
		$redirect_url = 'product/'.$product_name.'/'.$product_id;
		$response = array('status'=>1);
		echo json_encode($response);
	 }
	 public function deleteAddress($id){
		 $this->Customer_model->deletemyaddress($id);
		 $this->session->set_flashdata('update_msg','Your address has been delete successfully');
		 redirect('customer/addresses');
	 }
}
?>
