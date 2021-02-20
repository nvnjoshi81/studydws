<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends MY_Controller {
    public function __construct() { 
        parent:: __construct();  
        $this->load->model('Recommendations_model');
        $this->load->model('Customer_model');
        $this->load->model('Orders_model');
        $this->load->model('Studymaterial_model');
        $this->load->model('Videos_model');
        $this->load->model('States_model');
        $this->data['showbreadcrumb'] = true;
        $breadcrumb = array();
        $orders_status_array = $this->Orders_model->getOrders_status_array();
        $this->data['orders_status_array'] = $orders_status_array;
        $products=array();
        if(null == $this->session->userdata('purchases')){
        $products=array();
        }else{
        $products=$this->session->userdata('purchases');  
        }  
        //print_r($products);
        $studymaterial_array = array();
        if (isset($products) && count($products) > 0) {
            foreach ($products as $key => $value) { 
                if ($key == 2) {
                    $this->data['purchased_videos'][$key] = $value;
                } else if ($key == 3) {
                    $this->data['purchased_onlinetest'] = $value;
                } else if ($key == 1) {
                    $this->data['purchased_studymaterial'][$key] = $value;
                }
            }
        }
$customer_id=$this->session->userdata('customer_id'); 
if(isset($customer_id)&&$customer_id>0){
	//check
	$customer_id=$this->session->userdata('customer_id'); 
}else{
$customer_id=0;	
       if(0 == $this->session->userdata('customer_id')||" "==$customer_id){
        redirect(base_url('login'));
        }
}
		 $customerDetails = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
		 if(isset($customerDetails->email)){
		  $this->session->set_userdata('customer_email', $customerDetails->email);
		 }

    }

public function payUmoney_json(){

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0){
    //Request hash
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';   
    if(strcasecmp($contentType, 'application/json') == 0){
        $data = json_decode(file_get_contents('php://input'));
        $hash=hash('sha512', $data->key.'|'.$data->txnid.'|'.$data->amount.'|'.$data->pinfo.'|'.$data->fname.'|'.$data->email.'|||||'.$data->udf5.'||||||'.$data->salt);
        $json=array();
        $json['success'] = $hash;
        echo json_encode($json);
    
    } 
    exit(0);
}



}

    public function logout() {
		
		  $usertype=$this->session->userdata('userid');
		 
		        $this->session->unset_userdata('logged_in');
                $this->session->unset_userdata('customer_id');
                $this->session->unset_userdata('customer_name');
                $this->session->unset_userdata('customer_email');
                $this->session->unset_userdata('customer_fullname');
				$this->session->unset_userdata('ask_mobile');
                $this->session->unset_userdata('ask_mobile_verification');
                $this->session->unset_userdata('ask_mobile_no');
       if($this->session->userdata('loginFranId')>0){
			$this->session->unset_userdata('studentemail');
            $this->session->unset_userdata('loginFranId');
	        $dir_salesadmin=$this->config->item('dir_salesadmin');; 
	        redirect(base_url($dir_salesadmin.'/add_student'));
	  }else{
		if($usertype==1){
	    //Do not remove all session
		}else{
		$this->session->unset_userdata('userid');
		$this->session->sess_destroy();  
		}
	
	   }
        redirect(base_url());
    }
    
    public function library(){
        $this->data['content'] = 'customer/library';
        //$this->data['content'] = 'dashboard';        
        $this->data['page_title'] = 'My Account - Library - StudyAdda.com';
        $this->load->view('template', $this->data);
    }
    public function myvideos(){
        $this->data['content'] = 'customer/myvideos';
        $this->data['page_title'] = 'My Account - My videos Subscription - StudyAdda.com';
        $this->load->view('template', $this->data);
    }
    public function mystudypackages(){
        $this->data['content'] = 'customer/mystudypackages';
        $this->data['page_title'] = 'My Account - My Study Packages Subscription - StudyAdda.com';
        $this->load->view('template', $this->data);
    }
    public function mytestseries(){
        $this->data['content'] = 'customer/mytestseries';
        $this->data['page_title'] = 'My Account - My Test Series Subscription - StudyAdda.com';
        $this->load->view('template', $this->data);
    }
    
    
    public function index() {
        redirect('user/myaccount');
        $breadcrumb[] = array('text' => 'Dashboard', 'href' => base_url() . 'customer');
        $this->data['content'] = 'dashboard';
        $this->data['user_info'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));

        $default_address = $this->Customer_model->getDefaultAddress($this->session->userdata('customer_id'));
        if ($default_address) {
            $this->data['default_address'] = $default_address;
            $default_address_id = $default_address->id;
        } else {
            $this->data['default_address'] = null;
            $default_address_id = 0;
        }


        $this->data['user_address'] = $this->Customer_model->getAddresses($this->session->userdata('customer_id'), $default_address_id);
        $orders = $this->Orders_model->getMyOrders($this->session->userdata('customer_id'));
        $this->data['my_orders'] = $orders;
        $this->data['page_title'] = 'My Account - Dashboard - StudyAdda.com';
        $this->data['breadcrumb'] = $breadcrumb;
        //$this->Customer_model->getCustomerOrdersCount($this->session->userdata('customer_id'));
        $this->load->view('template', $this->data);
    }
    public function myaccount() {
        $breadcrumb[] = array('text' => 'Dashboard', 'href' => base_url() . 'customer');
        $breadcrumb[] = array('text' => 'Account Info', 'href' => '');
        $this->data['content'] = 'customer/myaccount';
        $this->data['user_info'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
        $this->data['page_title'] = 'My Account - Dashboard - StudyAdda.com';
        $this->data['breadcrumb'] = $breadcrumb;
        $this->load->view('template', $this->data);
    }
    public function addaddress() {
        $breadcrumb[] = array('text' => 'Dashboard', 'href' => base_url() . 'customer');
        $breadcrumb[] = array('text' => 'Addresses', 'href' => '');
        $this->data['content'] = 'customer/addaddress';
        $this->data['user_details'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
        $default_address = $this->Customer_model->getDefaultAddress($this->session->userdata('customer_id'));
        if ($default_address) {
            $this->data['user_info'] = $this->Customer_model->getAddresses($this->session->userdata('customer_id'), $default_address->id);
        }
        $states = $this->States_model->getStates();
        $this->data['states'] = $states;
        $this->data['default_address'] = $default_address;
        $this->data['title'] = 'My Account - New Address - Studyadda.com';
        $this->data['breadcrumb'] = $breadcrumb;
        $this->load->view('template', $this->data);
    }
    public function addresses() {
        $breadcrumb[] = array('text' => 'Dashboard', 'href' => base_url() . 'customer');
        $breadcrumb[] = array('text' => 'Addresses', 'href' => '');
        $this->data['content'] = 'customer/addresses';

        $this->data['user_details'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));

        $default_address = $this->Customer_model->getDefaultAddress($this->session->userdata('customer_id'));

        if (isset($default_address->id) && ($default_address->id > 0)) {
            $this->data['user_info'] = $this->Customer_model->getAddresses($this->session->userdata('customer_id'), $default_address->id);
        } else {
            $this->data['user_info'] = '';
        }

        $states = $this->States_model->getStates();
        $this->data['states'] = $states;

        $this->data['default_address'] = $default_address;
        $this->data['page_title'] = 'My Account - Addresses - Studyadda.com';
        $this->data['breadcrumb'] = $breadcrumb;
        $this->load->view('template', $this->data);
    }
    public function wishlist() {
        $breadcrumb[] = array('text' => 'Dashboard', 'href' => base_url() . 'customer');
        $breadcrumb[] = array('text' => 'Wishlist', 'href' => '');
        $this->data['content'] = 'customer/wishlist';
        $this->data['product_wishlist'] = $this->Customer_model->getWishlistItems($this->session->userdata('customer_id'));
        $this->data['page_title'] = 'My Account - Wishlist - Studyadda.com';
        $this->data['breadcrumb'] = $breadcrumb;
        $this->load->view('template', $this->data);
    }
    public function orders() {
        $this->load->library('pagination');
        $config = array();
        $config['per_page'] = 5;
        $config['base_url'] = base_url() . 'user/orders';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $this->Customer_model->getCustomerOrdersCount($this->session->userdata('customer_id'));
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';        //limit end
        $page = $this->uri->segment(3);
        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }

        $this->pagination->initialize($config);
        //
        $breadcrumb[] = array('text' => 'Dashboard', 'href' => base_url() . 'customer');
        $breadcrumb[] = array('text' => 'Orders', 'href' => '');
        $this->data['content'] = 'customer/orders';
        $this->data['user_info'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
        $orders = $this->Orders_model->getMyOrders($this->session->userdata('customer_id'), $config['per_page'], $limit_end);
        $this->data['my_orders'] = $orders;
        // query for the past orders from old order table // starts
        // $this->data['past_orders'] = $this->Orders_model->getPastorders($this->data['user_info']->legacy_id);
        // query for the past orders from old order table // ends
        $this->data['page_title'] = 'My Account - Orders';
        $this->data['breadcrumb'] = $breadcrumb;
        $this->load->view('template', $this->data);
    }
    public function pastorders() {
        $customer_details = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
        $config = array();
        $config['per_page'] = 5;
        $config['base_url'] = base_url() . 'user/pastorders';
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
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $this->pagination->initialize($config);
        $breadcrumb[] = array('text' => 'Dashboard', 'href' => base_url() . 'customer');
        $breadcrumb[] = array('text' => 'Orders', 'href' => '');
        $this->data['content'] = 'customer/pastorders';
        $this->data['page_title'] = 'My Account - Orders';
        $this->data['breadcrumb'] = $breadcrumb;
        $this->data['user_info'] = $customer_details;
        $this->data['past_orders'] = $this->Orders_model->getPastorders($customer_details->legacy_id, $config['per_page'], $limit_end);
        $this->load->view('template', $this->data);
    }
    public function orderdetails($id) {
        $order = $this->Orders_model->getOrderDetails($id);
        $breadcrumb[] = array('text' => 'Dashboard', 'href' => base_url() . 'customer');
        $breadcrumb[] = array('text' => 'Orders', 'href' => base_url() . 'customer/orders');
        $breadcrumb[] = array('text' => 'Order Details - ' . $order->order_no, 'href' => '');
        $this->data['content'] = 'customer/orderdetails';
        $this->data['user_info'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
        //$orders = $this->Orders_model->getMyOrders($this->session->userdata('customer_id'));
        //$this->data['my_orders'] = $orders;
        //$order=$this->Orders_model->getOrderDetails($id); 
        $this->data['shipping_addresses'] = $this->Customer_model->getShippingAddresses($order->shipping_id);
        $order_details = $this->Orders_model->getFullorderDetails($id);
        // print_r($order_details);
        // die();
        $this->data['order'] = $order;
        $this->data['breadcrumb'] = $breadcrumb;
        $this->data['order_details'] = $order_details;
        $this->load->view('template', $this->data);
    }
    public function updatecustomer() {
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $usertype = $this->input->post('usertype');
        $user_id = $this->input->post('user_id');
        $targate_exam = $this->input->post('targate_exam');
        if (count($targate_exam) < 1) {
            $this->session->set_flashdata('update_msg', 'Please Select Target Exam.');
			$dir_salesadmin=$this->config->item('dir_salesadmin');
            redirect($dir_salesadmin.'/add_student');
        }        
        //get Legacy info by user id
        $legacyInfoArray=$this->Customer_model->getCustomerLegacy($user_id);
        if(isset($legacyInfoArray->id)&&$legacyInfoArray->id>0){
            $legacy_id=$legacyInfoArray->id;
        }else{
            $legacy_id=0;
        }
        //get user info by userid
        $userInfo=$this->Customer_model->getCustomerDetails($user_id);
        $legacydata=array(
        'customer_id'=>$user_id,
        'mobile'=>$userInfo->mobile,
        'targate_exam'=>$userInfo->targate_exam,
        'usertype'=>$userInfo->usertype,
        'created_dt'=>time(),
        'modified_dt'=>time()
        );
       if($legacy_id>0){
       $this->Customer_model->editCustomerLegacy($legacydata,$legacy_id);
       }else{
       $this->Customer_model->addCustomerLegacy($legacydata);
       }
        //cmscustomers_legacy
        $targate_exam_string = '';
        $exam_string_combine = '';
        foreach ($targate_exam as $te) {
            $exam_string_combine .=$te . '_';
        }
        $targate_exam_string = substr($exam_string_combine, 0, -1);
        if ($email == '') {
            $userdata = array('firstname' => $firstname,
                'lastname' => $lastname,
                'targate_exam' => $targate_exam_string,
                'usertype'=>$usertype,
                'mobile'=>$mobile
            );
        } else {
            $userdata = array('firstname' => $firstname,
                'lastname' => $lastname,
                'targate_exam' => $targate_exam_string,
                'email' => $email,
                'usertype'=>$usertype,
                'mobile'=>$mobile
                );
        }
        $this->Customer_model->updatecustomerinfo($user_id, $userdata);
        $this->session->set_flashdata('update_msg', 'Your information has been updated successfully');
        redirect('customer/myaccount');
    }
    // public function pastorderdetails(){
    // $this->data['content'] = 'customer/oldorderdetails';
    // $this->load->view('template',$this->data);
    // }
    public function changePassword() {

        $current_password = $this->input->post('current_password');
        $password = $this->input->post('password');
        $user_id = $this->input->post('user_id');
        $passExist = $this->Customer_model->checkCurrentPassword($user_id, $current_password);
        if (($passExist == '') || ($passExist < 1)) {
            $this->session->set_flashdata('error_msg', 'Please Enter Correct Current Password.');
            redirect('customer');
        }
        if ($user_id == $this->session->userdata('customer_id')) {
            $passwordarray = array('password' => md5($password));
            $this->Customer_model->updatePassword($passwordarray, $user_id);
            $this->session->set_flashdata('update_msg', 'Password updated successfully');
        }
        redirect('/customer');
    }
    public function address($id) {
        $default_address = $this->Customer_model->getAddressDetail($id);

        if ($default_address && $default_address->customer_id == $this->session->userdata('customer_id')) {
            $states = $this->States_model->getStates();


            $cities = $this->States_model->cities($default_address->state);

            $data['states'] = $states;
            $data['cities'] = $cities;

            $data['default_address'] = $default_address;
            $this->load->view('customer/address', $data);
        } else {
            redirect('customer');
        }
    }
    public function setdefault($address_id) {
        $address = $this->Customer_model->getAddressDetail($address_id);
        if ($address && $address->customer_id == $this->session->userdata('customer_id')) {
            $default_address = $this->Customer_model->setDefault($address_id, $this->session->userdata('customer_id'));
            $this->session->set_flashdata('update_msg', 'This address has been set as your default address');
        } else {
            $this->session->set_flashdata('update_msg', 'Invalid Address');
        }
        redirect('/customer/addresses');
        //$data['default_address']=$default_address;
        //$this->load->view('customer/address',$data);
    }
    public function removeWishlist($id, $name) {
        $this->Customer_model->removeFromWishlist($id);
        $this->session->set_flashdata('update_msg', urldecode($name) . "&nbsp;" . 'has been removed from your wishlist');
        redirect('customer/wishlist');
    }
    public function customerReviews() {
        $user_id = $this->input->post('user_id');
        $product_id = $this->input->post('product_id');
        $product_name = $this->input->post('product_name');
        $customername = $this->input->post('customername');
        $title = $this->input->post('title');
        $summary = $this->input->post('summary');
        $ratings = $this->input->post('ratings');

        $review_array = array('user_id' => $user_id,
            'product_id' => $product_id,
            'username' => $customername,
            'userreviewtitle' => $title,
            'review' => $summary,
            'ratingstar' => $ratings,
            'status' => 0,
            'redate' => time());

        $review_array_data = $this->Customer_model->addReview($review_array);
        $redirect_url = 'product/' . $product_name . '/' . $product_id;
        $response = array('status' => 1);
        echo json_encode($response);
    }
    public function deleteAddress($id) {
        $this->Customer_model->deletemyaddress($id);
        $this->session->set_flashdata('update_msg', 'Your address has been delete successfully');
        redirect('customer/addresses');
    }
    public function checkmessageapi() {

        $userinfo = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));

        if ($userinfo->mobile != '') {
            $this->check_sendsms($userinfo->mobile);
            echo "Message has been sent.Please check on " . $userinfo->mobile;
        } else {
            echo "Mobile not save in db";
        }
    }
    public function updatemobile() {
        $user_id = $this->session->userdata('customer_id');
        $mobile = $this->input->post('mobileregi_otp');
        $array = array('mobile' => $mobile);
        $this->Customer_model->updatecustomerinfo($user_id, $array);
        $this->session->unset_userdata('ask_mobile');
        //$this->generateOtp();
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function verifyotp() {
        $user_id = $this->session->userdata('customer_id');
        $otp = $this->input->post('otp');
        $array = array('mobile_verified' => 1);
        if ($this->Customer_model->verifyotp($user_id, $otp)) {
            $this->session->unset_userdata('ask_mobile_verification');
            $this->Customer_model->updatecustomerinfo($user_id, $array);
            $this->session->set_userdata('mobileverified', 1);
        } else {
            $this->session->set_flashdata('otp', 'Invalid OTP.Please Enter Correct OTP');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    public function check_sendsms($usermobile) {
        $this->load->library('sms');
        $this->sms->send_sms($usermobile, 'Your message plan is working.');
    }
    public function generateOtp() {
        $user_id = $this->session->userdata('customer_id');
        $user = $this->Customer_model->getDetails($user_id);
        $generateotp = false;

        if ($user->otp != '' && $user->otp_expiry != '') {
            $is_otp_expiered = $user->otp_expiry - time();
            if ($is_otp_expiered <= 0) {
                $generateotp = true;
            } else {
                $generateotp = false;
            }
        } else {
            $generateotp = true;
        }

        if ($generateotp) {
            $otp = generateOTP();
            $otp_array = array('otp' => $otp, 'otp_expiry' => time() + 3600);
            $this->Customer_model->updatecustomerinfo($user_id, $otp_array);
            $this->load->library('sms');
            $this->sms->send_sms($user->mobile, 'OTP for Mobile verification for your account at www.studyadda.com is : ' . $otp . ' and is valid for only 1 hour');
            //sendEmail($user->email,'Verify Mobile','OTP for Mobile verification for your account at www.studyadda.com is : <b>' . $otp.'</b> and is valid for only 1 hour');
        }
    }
    /*
      $this->load->library('sms');
      $this->sms->send_sms('9425050403','StudyAdda Test Message');

      // Get the reply
      echo $this->sms->last_reply();
     */
    public function tests() {
        $this->load->model('Onlinetest_model');
        $this->load->library('pagination');
        $config = array();
        $config['per_page'] = 10;
        $config['base_url'] = base_url() . 'customer/tests';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $this->Onlinetest_model->getUserTestsCount($this->session->userdata('customer_id'));
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';        //limit end
        $page = $this->uri->segment(3);
        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $this->pagination->initialize($config);
        $usertests = $this->Onlinetest_model->getUserTests($this->session->userdata('customer_id'), $config['per_page'], $limit_end);
        $breadcrumb[] = array('text' => 'Dashboard', 'href' => base_url() . 'customer');
        $breadcrumb[] = array('text' => 'My Online Test Results', 'href' => '');
        $this->data['content'] = 'customer/tests';
        $this->data['user_info'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
        $this->data['page_title'] = 'My Online Tests - Dashboard - StudyAdda.com';
        $this->data['breadcrumb'] = $breadcrumb;
        $this->data['usertests'] = $usertests;
        $this->load->view('template', $this->data);
    }
    public function changeMobile() {
        $mobileNumber = $this->input->post('changeMobile');
        $user_id = $this->session->userdata('customer_id');
        $user = $this->Customer_model->getDetails($user_id);

        $mobile_array = array('mobile' => $mobileNumber);
        $this->Customer_model->updatecustomermobile($user_id, $mobile_array);

        $user = $this->Customer_model->getDetails($user_id);
        $userrmobile = $user->mobile;
        $this->session->set_userdata('ask_mobile_no', $userrmobile);
        /* Send SMS */
        $otp = generateOTP();
        $otp_array = array('otp' => $otp, 'otp_expiry' => time() + 3600);
        $this->Customer_model->updatecustomerinfo($user_id, $otp_array);
        $this->load->library('sms');
        $this->sms->send_sms($user->mobile, 'OTP for Mobile verification for your account at www.studyadda.com is : ' . $otp . ' and is valid for only 1 hour');

        redirect($_SERVER['HTTP_REFERER']);
    }
    public function recommendations() {
        $this->load->library('pagination');
        $config = array();
        $config['per_page'] = 5;
        $config['base_url'] = base_url() . 'customer/recommendations';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $this->Recommendations_model->getRecommendationsCount($this->session->userdata('customer_id'));
        $config['num_links'] = 20;
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
        //limit end
        $page = $this->uri->segment(3);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }

        $this->pagination->initialize($config);
        //
        $breadcrumb[] = array('text' => 'Dashboard', 'href' => base_url() . 'customer');
        $breadcrumb[] = array('text' => 'Orders', 'href' => '');
        $this->data['content'] = 'customer/recommendations';
        $this->data['user_info'] = $this->Customer_model->getCustomerDetails($this->session->userdata('customer_id'));
        $orders = $this->Recommendations_model->getMyRecommendations($this->session->userdata('customer_id'), $config['per_page'], $limit_end);
        $this->data['my_orders'] = $orders;
        // query for the past orders from old order table // starts
        // $this->data['past_orders'] = $this->Orders_model->getPastorders($this->data['user_info']->legacy_id);
        // query for the past orders from old order table // ends
        $this->data['page_title'] = 'My Account - Orders';
        $this->data['breadcrumb'] = $breadcrumb;
        $this->load->view('template', $this->data);
    }
}

?>
