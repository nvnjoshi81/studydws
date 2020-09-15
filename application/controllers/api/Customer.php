<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Customer extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->model('Cart_model');
        $this->load->model('States_model');
        $this->load->library('encrypt');
    }

    public function login_post() {
        $bypass_login_id = $this->input->post('bypass_login_id');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $redirect = $this->input->post('redirect');
        $rediurl = $this->input->post('rediurl');
        $verification = $this->input->post('verification');

        //if($verification != $this->session->userdata('verification_code')){
        //    $response=array('status'=>0,'error'=>'Invalid verification code');
        //}else{
       
        if(isset($bypass_login_id)&&($bypass_login_id>0)){
             $login = $this->Customer_model->bypass_login_id($bypass_login_id);
        }else{
        $login = $this->Customer_model->login($email, $password);
        }
        $response = array();
        if ($login) {
            if ($login->status == 0) {
                $codeArray=$this->Customer_model->get_varification_code($email);
                
                $verification_code=$codeArray[0]->verification_code;
                if(isset($verification_code)&&$verification_code!=''){
                    //send verification mail again
                    $message = 'Your account has been created. Click <a href="' . base_url('account/verify/' . $verification_code) . '">here</a> to verify your email.<br>Verification Link : ' . base_url('account/verify/' . $verification_code);
       $subject = "StudyAdda Account  Created";
        //send email
       if(isset($email)){
        //Do not send mail from local host
           if(isset($_SERVER['REMOTE_ADDR'])&&($_SERVER['REMOTE_ADDR']=='127.0.0.1')){
           $mailflag=0;
           }else{
           sendEmail($email, $subject, $message);
           $mailflag=1;    
           }
       }
            }
                $response = array('status' => 0, 'error' => 'Your Email Is Not Verified! We have sent varification link on '.$email.' .Please check spam folder also.');
            } else {

                $this->Customer_model->update_last_activity($email, $login->last_activity);

                if ($login->mobile == '') {
                    $this->session->set_userdata('ask_mobile', 1);
                }
                if ($login->mobile_verified == 0) {
                    //Use below line to activate otp
                   // $this->session->set_userdata('ask_mobile_verification', 1);
                    $this->session->set_userdata('ask_mobile_verification', 0);
                    $this->session->set_userdata('ask_mobile_no', $login->mobile);
                }
                $this->cart->product_name_rules = '\d\D';
                $this->load->model('Questionbank_model');
                $this->load->model('Samplepapers_model');
                $this->load->model('Content_model');
                $this->load->model('Pricelist_model');
                $this->session->set_userdata('logged_in', 1);
                $this->session->set_userdata('customer_id', $login->id);
                $this->session->set_userdata('customer_name', $login->firstname);
                $this->session->set_userdata('customer_fullname', $login->firstname . ' ' . $login->lastname);
                $customer_cart = $this->Cart_model->getCustomerCart($login->id);
                $citems = array();
                if ($customer_cart) {
                    $cartitems = $this->Cart_model->getCartItems($customer_cart->id);
                    if ($cartitems) {
                        foreach ($cartitems as $item) {
                            $product = $this->Pricelist_model->getDetails($item->product_id);
                            //To check if product already exist in DB
                            $name = null;
if(!search_array($item->product_id, $this->cart->contents())){
                            $citems[] = array('id' => $item->product_id, 'qty' => $item->quantity, 'price' => $product->discounted_price > 0 ? $product->discounted_price : $product->price, 'name' => $product->modules_item_name, 'options' => array('offline' => $item->offline));
}
                    }
                    }

                if(count($citems) > 0)
                $this->cart->insert($citems);
                }

                if ($this->cart->total_items() > 0) {
                    $this->Customer_model->emptyCart($login->id);

                    foreach ($this->cart->contents() as $citem) {

                        $addtocart = $this->Customer_model->addToCart($login->id, $citem['id'], $citem['qty'], $citem['price'], $citem['options']['offline']);
                    }
                }
                $resarray = array('customer_id' => $login->id, 'redirect' =>$redirect);
                if ($rediurl) {
                    $resarray['rediurl'] = $rediurl;
                }
                logdata($login);
                $response = array('status' => 1, 'data' => $resarray);
            }
        } else {
            $response = array('status' => 0, 'error' => 'Invalid Email or Password');
        }
        // }
        $this->response($response, REST_Controller::HTTP_OK);
    }


    public function logout_get() {
        
    }
    
     function showdata_post(){
      //test for post from a html form
   $username=$this->input->post('username');   
  }
    
    public function guest_post(){
       
        $firstname = $this->input->post('firstname'); 
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $address_one = $this->input->post('address_one');
        $pincode = $this->input->post('pincode');
        $city = $this->input->post('city');
        $state = $this->input->post('state');
        $statedetails = $this->States_model->statedetails($state);
        $citydetails = $this->States_model->citydetails($city);
        $state_name = $statedetails->state_name;
        $city_name = $citydetails->city_name;
        $guestinfo = array('firstname' => $firstname,
            'email' => $email,
            'mobile' => $mobile,
            'password' =>'',
            'status' =>'1',
            'is_social' =>'0',
            'mobile_verified'=>'1',
            'guest'=>'yes',
            'created_dt' => time());
          $guest_insert_id = $this->Customer_model->register($guestinfo);
        
        $guestinfo = array('customer_id' => $guest_insert_id,
            'address_name' => $firstname,
            'address' => $address_one,
            'city' =>$city,
            'city_name' =>$city_name,
            'state' =>$state,
            'state_name' =>$state_name,
            'country_id'=>'1',
            'country_name'=>'INDIA',
            'zipcode'=>$pincode,
            'is_default'=>'1',
            'mobile' => $mobile);
        $addressid = $this->Customer_model->addAddress($guestinfo);
        $customer_data=$this->Customer_model->getUserInfo($guest_insert_id);
        
        // Add Session
                $this->session->set_userdata('ask_mobile_verification', 0);
                $this->session->set_userdata('ask_mobile_no', $customer_data->mobile);
                $this->cart->product_name_rules = '\d\D';
                $this->load->model('Questionbank_model');
                $this->load->model('Samplepapers_model');
                $this->load->model('Content_model');
                $this->load->model('Pricelist_model');
                $this->session->set_userdata('logged_in', 1);
                $this->session->set_userdata('isGuest', 'yes');
                $this->session->set_userdata('customer_id', $customer_data->id);
                $this->session->set_userdata('customer_name', $customer_data->firstname);
                $this->session->set_userdata('customer_fullname', $customer_data->firstname . ' ' . $customer_data->lastname);
           // add Informationn DB and cart object
                $customer_cart = $this->Cart_model->getCustomerCart($customer_data->id);
                $citems = array();
                if ($customer_cart) {
                    $cartitems = $this->Cart_model->getCartItems($customer_cart->id);
                    if ($cartitems) {
                        foreach ($cartitems as $item) {
                        $product = $this->Pricelist_model->getDetails($item->product_id);
                        //To check if product already exist in DB
                        $name = null;
if(!search_array($item->product_id, $this->cart->contents())){
                        $citems[] = array('id' => $item->product_id, 'qty' => $item->quantity, 'price' => $product->discounted_price > 0 ? $product->discounted_price : $product->price, 'name' => $product->modules_item_name, 'options' => array('offline' => $item->offline));
}
                    }
                    }

                    if (count($citems) > 0)
                        $this->cart->insert($citems);
                }

                if ($this->cart->total_items() > 0) {
                    $this->Customer_model->emptyCart($customer_data->id);
                    foreach ($this->cart->contents() as $citem) {
                        $addtocart = $this->Customer_model->addToCart($customer_data->id, $citem['id'], $citem['qty'], $citem['price'], $citem['options']['offline']);
                    }
                }
                
                $response = array('status' => 1, 'data' => $addtocart);
               $this->response($response, REST_Controller::HTTP_OK);
        
    }
    
    public function register_post() {
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $mobile = $this->input->post('mobile');
        $mobile= str_replace("-","",$mobile);  
        if ($email=='') {
            $this->session->set_flashdata('message','Email Is Required!');     
            redirect('/login');
        }
        
         if ($mobile=='') {
            $this->session->set_flashdata('message','Mobile Is Required!');     
            redirect('/login');
        }else{
        if (($mobile!='')&&(!is_numeric($mobile))) {
            $this->session->set_flashdata('message','Mobile Number Should be Numeric Only!');    
            redirect('/login');
        }else{
			$chkMob=$this->Customer_model->checkmobile($mobile);
			if(!$chkMob){
		    $this->session->set_flashdata('message','Mobile Number Already Registred!');    
               $response = array('status' => 0, 'msg' => 'There was error processing your request.', 'message'=>'Mobile Already Registred!.');
        
        $this->response($response, REST_Controller::HTTP_OK);
			}
        }
        }
		
        $is_social_value = $this->input->post('is_social_value');

        if(isset($is_social_value)&&$is_social_value==2){
            $is_social_status=2;
        }else{
            $is_social_status=0;
        }
        $address_name = $this->input->post('address_name');
        $customerinfo = array('firstname' => $firstname,
            'lastname' => $lastname ? $lastname : '',
            'email' => $email,
            'password' => md5($password),
            'created_dt' => time(),
            'mobile' => $mobile ? $mobile : '',
            'mobile_verified'=>'1',
            'is_social'=>$is_social_status);

        $emailStr = strlen($email);
        $regi_session_input = $this->input->post('regi_session_input');
        //$regi_session_value = $this->session->userdata("regi_session");
//To prevent cross scripting checking with session value.
        //if($regi_session_input == $regi_session_value) {
            $customer_data = $this->Customer_model->register($customerinfo);
       // }
        //$this->session->set_userdata("regi_session", '');
        //$this->session->unset_userdata('regi_session');
        //$this->session->set_userdata('logged_in',1);
        //$this->session->set_userdata('customer_id',$customer_data);
        //$this->session->set_userdata('customer_name',$firstname);

        /* if($this->cart->total_items() > 0){
          //$this->Customer_model->emptyCart($login->id);
          foreach ($this->cart->contents() as $item){
          $addtocart=$this->Customer_model->addToCart($customer_data,$item['id'],$item['qty'],$item['price']);
          }
          } */
		  
		$this->session->set_userdata('logged_in',1);
        $this->session->set_userdata('customer_id',$customer_data);
        $this->session->set_userdata('customer_name',$firstname);
        $this->session->set_userdata('customer_fullname',$firstname);
        if ($customer_data) {
            $verification_code = $this->encrypt->encode($customer_data . '.' . $email);
            $this->db->where('id', $customer_data);
            $this->db->update('cmscustomers', array('verification_code' => $verification_code));
            $response = array('status' => 1, 'msg' => 'Customer Registered Successfully.');
            $message = 'Your account has been created. Click <a href="' . base_url('account/verify/' . $verification_code) . '">here</a> to verify your email.<br>Verification Link : ' . base_url('account/verify/' . $verification_code);
            $subject = "StudyAdda Account Created";
            $to = $email;
            //$mobile_number = $mobile;
            //$sms_message = 'Hello sir/madam. Thankyou for registering with us.We ensure you for the best service and the best shopping experience. Regards - Patanjali';
			
$break_host_array=substr($_SERVER['HTTP_HOST'],-3);
if($break_host_array=='cal'){
	//no need to saind email from local
}else{
            sendEmail($to, $subject, $message);
}
            //$this->sms->send_sms($mobile_number,$sms_message);
            // Set the response and exit
            // OK (200) being the HTTP response code
        } else {
            $response = array('status' => 0, 'msg' => 'There was error processing your request.', 'message'=>'Please try again.There was error processing your request.');
        }
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function address_post() {
        $customerid = $this->input->post('user_id');
        $address_name = $this->input->post('address_name');
        $address = $this->input->post('address');
        $address2 = $this->input->post('address2');
        $city = $this->input->post('city');
        $state = $this->input->post('state_name');
        $country_id = $this->input->post('country');
        $mobile = $this->input->post('mobile');
        $zip = $this->input->post('zipcode');
        $statedetails = $this->States_model->statedetails($state);
        $citydetails = $this->States_model->citydetails($city);
        $addressdata = array('customer_id' => $customerid,
            'address_name' => $address_name,
            'address' => $address,
            'address2' => $address2,
            'city' => $city,
            'state' => $state,
            'state_name' => $statedetails->state_name,
            'city_name' => $citydetails->city_name,
            'country_id' => $country_id,
            'mobile' => $mobile,
            'zipcode' => $zip,
            'is_default' => 0);

        $addressid = $this->Customer_model->addAddress($addressdata);
        
        /* Add mobile in customer table if not exist*/        
        $customerDet=$this->Customer_model->getCustomerDetails($customerid);
            if ($customerDet->mobile == '') {
        $userdata_mob = array('mobile' => $mobile);        
        $this->Customer_model->updatecustomerinfo($customerid, $userdata_mob);
            }
        /*End modbile in customer */
        $this->session->set_flashdata('update_msg', 'Your address has been added successfully');
        $response = array('status' => 1, 'data' => $addressdata);
        //redirect('checkout');
        // Set the response and exit
        $this->response($response, REST_Controller::HTTP_OK);
        // OK (200) being the HTTP response code
    }

    public function editAddress_post() {
        $address_id = $this->input->post('address_id');
        $address_name = $this->input->post('address_name');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $state = $this->input->post('state_name');
        $mobile = $this->input->post('mobile');
        $zip = $this->input->post('zipcode');
        $statedetails = $this->States_model->statedetails($state);
        $citydetails = $this->States_model->citydetails($city);
        $addressdata = array('address_name' => $address_name,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'state_name' => $statedetails->state_name,
            'city_name' => $citydetails->city_name,
            'mobile' => $mobile,
            'zipcode' => $zip
        );
        $response = array('status' => 1, $addressdata);
        $addressid = $this->Customer_model->editCustomerAddress($addressdata, $address_id);
        $this->session->set_flashdata('update_msg', 'Your address has been updated successfully');
        redirect('/customer/addresses');
        // Set the response and exit
        $this->response($response, REST_Controller::HTTP_OK);
        // OK (200) being the HTTP response code
    }

    public function checkemail_get() {
        $email = $this->input->get('email');
        $status = $this->Customer_model->checkemail($email);
        if ($status) {
            $response = array('status' => 1);
        } else {
            $response = array('status' => 0, 'msg' => 'Email already exists');
        }
        $this->response($response, REST_Controller::HTTP_OK);
    }
	
	public function checkmobile_get() {
        $mobile = $this->input->get('mobile');
        $status = $this->Customer_model->checkmobile($mobile);
        if ($status) {
            $response = array('status' => 1);
        } else {
            $response = array('status' => 0, 'msg' => 'Mobile already exists');
        }
        $this->response($response, REST_Controller::HTTP_OK);
    }
	public function checkmobile_DEL() {
        //$mobile = $this->input->get('mobile');
        //$status = $this->Customer_model->checkmobile($mobile);
      // return $status; 
    }

    public function checkSubscribedEmail_get() {
        $email = $this->input->get('email');
        $status = $this->Customer_model->checkSubscribedEmail($email);
        if ($status) {
            $response = array('status' => 1);
        } else {
            $response = array('status' => 0, 'msg' => 'Email already exists');
        }
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function checkdelivery_get() {
        $zipcode = $this->input->get('zip');
        $status = $this->Customer_model->checkZip($zipcode);
        if ($status[0]->cod_status == 1) {
            $response = array('status' => 1);
        } else {
            $response = array('status' => 0, 'msg' => 'Delivery to this zip code is not available.');
        }
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function forgotPassword_post() {
        $email = $this->input->post('email');
        $password = generatePassword();
        // mail to user
        // mail to user
        $forgotpasswordarray = array('password' => md5($password));
        $forgotpasswordvalue = $this->Customer_model->resetPassword($email, $forgotpasswordarray);
        $message = 'Dear sir/madam, your new password is ' . $password . ' . Now you can login to studyadda.com by using this password and you can change your password after logging in. Thankyou';
        $subject = 'Reset password';
        $to = $email;
        //send email
		$break_host_array=substr($_SERVER['HTTP_HOST'],-3);
if($break_host_array=='cal'){
	//no need to saind email from local
}else{
        sendEmail($to, $subject, $message);
}
        // if($status[0]->cod_status==1){
        // $response=array('status'=>1);
        // }else{
        // $response=array('status'=>0,'msg'=>'Delivery to this zip code is not available.');
        // }
        $response = array('status' => 1);
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function checkcaptcha_post() {
        $verification = $this->input->post('verification');
        if ($verification != $this->session->userdata('verification_code')) {
            $response = array('status' => 'false', 'error' => 'Invalid verification code');
        } else {
            $response = array('status' => 'true');
        }
        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function reporterror_post() {
        $this->load->model('Reporterrors_model');
        $user_id = $this->input->post('customer_id');
        if (!$user_id) {
            $user_id = 0;
        }
        $comment = $this->input->post('comment');
        $question_id = $this->input->post('question_id');
        $error = $this->input->post('error');
        $data = array('user_id' => $user_id, 'question_id' => $question_id, 'error' => $error, 'comment' => $comment);
        $response = array();
        if ($this->Reporterrors_model->add($data)) {
            $response = array('status' => 1, 'message' => 'Thanks for your feedback, We will check the question');
        } else {
            $response = array('status' => 0, 'message' => 'There was error processing your request.');
        }
        $this->response($response, REST_Controller::HTTP_OK);
    }
    
    
    public function contactinfo_post(){
        
          $this->load->model('Contact_model');
        $email ='studyadda@gmail.com';
        $firstname = $this->input->post('guestname');
        $useremail = $this->input->post('enteremail');
        $mobile = $this->input->post('contact');
        $type = $this->input->post('type');
        $redirct_to ='';
        if($type=='jobs'){
        $redirct_to ='jobs';    
        }if($type=='contact'){
        $redirct_to ='contact-us';    
        }
        
        if($firstname==''){
            $this->session->set_flashdata('message', 'Please Enter Name!');
            redirect($redirct_to);
        }
        
        if($useremail==''){
            $this->session->set_flashdata('message', 'Please Enter Email!');
            redirect($redirct_to);
        }
        
        if($mobile==''){
            $this->session->set_flashdata('message', 'Please Enter Mobile!');
            redirect($redirct_to);
        }
        
        
       if($type=='jobs'){
        $type='jobs';
        $subject = $firstname." Contacted you through job section";
        $redirect_url='jobs';
       }elseif($type=='contact'){
         $type='contact';  
         $subject = $firstname." Contacted you through contact section";
         $redirect_url='contact-us';
       }else{
           $type='other';
           $subject = $firstname." Contacted you.";
           $redirect_url='';
       }
        $date = time();
            $message = 'Name:- '.$firstname.'<br>Email:- '.$useremail.'<br>Mobile:- '.$mobile.'<br>';
            
          
            $to = $email;
            //$mobile_number = $mobile;
            //$sms_message = 'Hello sir/madam. Thankyou for registering with us.We ensure you for the best service and the best shopping experience. Regards - Patanjali';
            
		$file_folder_path = '/upload/contact_file/';
                $file_field_name = 'inputFile';
                $extract='no';
                if(isset($_FILES[$file_field_name]['name'])&&($_FILES[$file_field_name]['name']!='')){
                     $file_name = upload_extract_file($file_folder_path, $file_folder_path, $file_field_name, $extract = 'no');
                      
                 }else{
                     $file_name = 'studyadda';
                     
                 } 
              $contact_data = array(
			'firstname' => $firstname,
			'email' => $useremail,
			'mobile' => $mobile,
			'created_dt' => $date, 
                        'filename' => $file_name,
			'type' => $type
		);
		$insert_id= $this->Contact_model->saveContact($contact_data); 
                //sendEmail($to, $subject, $message,$file_name);
                
                  if ($insert_id) {
            $response = array('status' => 1, 'message' => 'Your Application has been submited.');
        } else {
            $response = array('status' => 0, 'message' => 'There was error in processing your request.');
        }
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function subscribe_post() {
        $this->load->model('Subscribers_model', 'subscribers');
        $response = array();
        $today = date('Y-m-d');
        $email = $this->input->post('subscriber_email');
        $mobile = $this->input->post('subscriber_mobile');
        $data = array('email' => $email, 'mobile' => $mobile, 'date' => $today);
        $id = $this->subscribers->add($data);
        if ($id) {
            $response = array('status' => 1);
        } else {
            $response = array('status' => 0);
        }
        $this->response($response, REST_Controller::HTTP_OK);
    }
    public function videostart_post($user_id,$video_id){
        $data=array('user_id'=>$user_id,'video_id'=>$video_id,'start_time'=>date('Y-m-d h:i:s'),'ip_address'=>$this->input->ip_address());
        $this->db->insert('cmsvideohistory',$data);
        $this->response($this->db->insert_id(),REST_Controller::HTTP_OK);
    }
    public function videocomplete_post($trackid){
        $data=array('end_time'=>date('Y-m-d h:i:s'));
        $this->db->where('id', $trackid);
        $this->db->update('cmsvideohistory',$data);
        $this->response(0,REST_Controller::HTTP_OK);
    }
   

}
