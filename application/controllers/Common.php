<?php 
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
class Common extends Modulecontroller {
    public function __construct() {
    parent::__construct();
    }
    public function FranchiseUser_login() {  
        $bypass_login_id = $this->input->post('bypass_login_id');
		$backurltest = $this->input->post('backurltest');
        $email = $this->input->post('loginemail');
        $loginpassword = $this->input->post('loginpassword');
        $studentemail = $this->input->post('studentemail');
        $studentid = $this->input->post('studentid');
        $loginpassword = $this->input->post('loginpassword');
		$loginFranId = $this->input->post('loginFranId');
		
                $this->session->unset_userdata('studentemail');
                $this->session->unset_userdata('loginFranId');
                $this->session->unset_userdata('logged_in');
                $this->session->unset_userdata('customer_id');
                $this->session->unset_userdata('customer_name');
                $this->session->unset_userdata('customer_fullname');

        //if($verification != $this->session->userdata('verification_code')){
        //    $response=array('status'=>0,'error'=>'Invalid verification code');
        //}else{
      
        if(isset($bypass_login_id)&&($bypass_login_id>0)){
             $login = $this->Customer_model->bypass_login_id($bypass_login_id);
        }else{
        	$this->session->set_flashdata('message', 'Something Went wrong.Please Try Again.');
			$dir_salesadmin=$this->config->item('dir_salesadmin');
            redirect($dir_salesadmin.'/add_student');
        }
        $response = array();
		if ($login) {
            if ($login->status == 0) {
				
			$this->session->set_flashdata('message', 'Your Email Is Not Verified! We have sent varification link on '.$email.' .Please check spam folder also.');
			$dir_salesadmin=$this->config->item('dir_salesadmin');
            redirect($dir_salesadmin.'/add_student');
			} else {

     //send verification mail again
       $message = 'This account '.$email.' has been logged in by franchise id-'.$loginFranId;
       $subject = "Student Account Loged in by Franchise Id ".$loginFranId;
        //send email
       if(isset($email)){
        //Do not send mail from local host
           if(isset($_SERVER['REMOTE_ADDR'])&&($_SERVER['REMOTE_ADDR']=='127.0.0.1')){
           $mailflag=0;
           }else{
           //sendEmail($email, $subject, $message);
           $mailflag=1;    
           }
       }            


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
                $this->load->model('Cart_model');
				$this->session->set_userdata('logged_in', 1);
                $this->session->set_userdata('customer_id', $login->id);
                $this->session->set_userdata('customer_name', $login->firstname);
                $this->session->set_userdata('customer_fullname', $login->firstname . ' ' . $login->lastname);
				$this->session->set_userdata('studentemail',$studentemail);
                $this->session->set_userdata('loginFranId',$loginFranId);
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

                    if (count($citems) > 0)
                        $this->cart->insert($citems);
                }

                if ($this->cart->total_items() > 0) {
                    $this->Customer_model->emptyCart($login->id);

                    foreach ($this->cart->contents() as $citem) {

                        $addtocart = $this->Customer_model->addToCart($login->id, $citem['id'], $citem['qty'], $citem['price'], $citem['options']['offline']);
                    }
                }
				
				if(isset($backurltest)&&$backurltest>0){
			$forceredirect='online-test/result/'.$backurltest;
			}elseif(isset($redirect)&&$redirect!=''){
            $forceredirect=$redirect;
			}else{
			$forceredirect='purchase-courses';
			}
				
				
                $resarray = array('customer_id' => $login->id, 'redirect' =>$forceredirect);
            logdata($login);
            $this->session->set_flashdata('message', 'You Are logedin with franchise acccount.');
			$dir_salesadmin=$this->config->item('dir_salesadmin');
			
			redirect($forceredirect);
			die;
			
			}
        } else {
            $response = array('status' => 0, 'error' => 'Invalid Email or Password');
        }
        // }
        $this->response($response, REST_Controller::HTTP_OK);
    }
    public function getpdfimage() {
    $studypdf_path=$_SERVER['DOCUMENT_ROOT'].$this->config->item('studypdf_path');
    $im = new imagick(studypdf_path.'1._Motion.pdf[0]');
    $im->setImageFormat('jpg');
    header('Content-Type: image/jpeg');
    echo $im;
    }
    public function getsignedurl() {
        $resourceKey=$this->input->post('resource');
        $sUrl=getSignedURL(urldecode($resourceKey),3);
        echo $sUrl;
    }
    public function verify($verification_code){
        $this->load->model('Customer_model');
        $code=  decrypt($verification_code);
        $pos=strpos($code,'.');
        $id=substr($code,0,$pos);
        $email=substr($code,$pos+1);
        $verification_data=  explode('.', $code);
        if($this->Customer_model->verify($id,$email,$verification_code)){
            $this->data['content']='customer/verified';
        }else{
            $this->data['content']='customer/unverified';
        }     
        $this->load->view('template',$this->data);
    }
    public function about(){
		$cache_minutes=$this->config->item('cache_minutes');
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->data['content']='about';
        $this->load->view('template',$this->data);
    }
     public function payment_terms(){
		 $cache_minutes=$this->config->item('cache_minutes');
		 if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->data['content']='payment_terms';
        $this->load->view('template',$this->data);
    }
    public function sitemap(){
		$cache_minutes=$this->config->item('cache_minutes');
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->data['content']='sitemap';
        $this->load->view('template',$this->data);
    }
    public function jobs(){
		$cache_minutes=$this->config->item('cache_minutes');
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->data['content']='jobs';
        $this->load->view('template',$this->data);
    }
      public function jobs_info(){ 
	  $cache_minutes=$this->config->item('cache_minutes');
	  if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->load->model('Contact_model');
        $email ='studyadda@gmail.com';
        $firstname = $this->input->post('guestname');
        $useremail = $this->input->post('enteremail');        
                  $preferredCity='none';
                  $investmentCapacity='none';
                  $academicProfile='none'; 
                  $mobile='0000000000';
        $type = $this->input->post('type');
        $working_as=$this->input->post('workingas');
        $address=$this->input->post('youraddress');
        $background=$this->input->post('other');
        $contactComment=$this->input->post('contactComment');        
        $redirct_to ='';
        if($type=='jobs'){
        $redirct_to ='jobs';
        $mobile = $this->input->post('contact');    
        }
        if($type=='contact'){
        $redirct_to ='contact-us';  
        $mobile = $this->input->post('contact');  
        }
        if($type=='franchise'){
           $mobile = $this->input->post('fcontact');
           $redirct_to='franchise_welcome';
           if($address==''){
           $this->session->set_flashdata('message', 'Please Enter Address!');
           redirect($redirct_to);
        }

$franchise_num1=$this->session->userdata('franchise_num1');
$franchise_num2=$this->session->userdata('franchise_num2');

$fc_total = $this->input->post('franchise_captcha_total');
$this->session->unset_userdata('franchise_num1');
$this->session->unset_userdata('franchise_num2');
if($fc_total>0){
$f_formtotal=$franchise_num1+$franchise_num2;

if($f_formtotal!=$fc_total){
           $this->session->set_flashdata('message', 'Please Enter Correct Sum Of Numbers!');
           redirect($redirct_to);

}

}else{
           $this->session->set_flashdata('message', 'Please Enter Sum Of Numbers!');
           redirect($redirct_to);

}

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
       }elseif($type=='franchise'){
        $type='franchise';  
        $subject = $firstname." Contacted you through franchise section";
        $redirect_url='franchise_welcome';
        $preferredCity=$this->input->post('preferredCity');
        $investmentCapacity=$this->input->post('investmentCapacity');
        $academicProfile=$this->input->post('academicProfile');
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
                  'comment'=>$contactComment,
                  'preferredCity'=>$preferredCity,
                  'investmentCapacity'=>$investmentCapacity,
                  'academicProfile'=>$academicProfile,
			'created_dt' => $date, 
                        'filename' => $file_name,
                        'address'=>$address,    
                        'other'=>$background,
                        'workingas'=>$working_as, 
			'type' => $type
		);
		$this->Contact_model->saveContact($contact_data); 
                sendEmail($to, $subject, $message,$file_name);
                $this->session->set_flashdata('message', 'Your Application has been submitted!We will contact you soon.');
		redirect($redirect_url);
                die;
    }
    
     public function whystudyadda(){
		 $cache_minutes=$this->config->item('cache_minutes');
		 if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->data['content']='whystudyadda';
        $this->load->view('template',$this->data);
    }    
      public function test(){
		  $cache_minutes=$this->config->item('cache_minutes');
        if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
		$this->data['content']='test';
        $this->load->view('template',$this->data);
    }
      public function contact(){
		  $cache_minutes=$this->config->item('cache_minutes');
        if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
		$this->data['content']='contact';
        $this->load->view('template',$this->data);
    }
      public function privacy(){
		  $cache_minutes=$this->config->item('cache_minutes');
		  if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->data['content']='privacy';
        $this->load->view('template_mid',$this->data);
    }
	
      public function refund(){
		  $cache_minutes=$this->config->item('cache_minutes');
		  if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->data['content']='refund';
        $this->load->view('template',$this->data);
    }
	
    public function franchise_regi(){
        $this->data['content']='franchise_regi';
        $this->load->view('template',$this->data);
    }
     public function lalitsardana(){
		 $cache_minutes=$this->config->item('cache_minutes');
		 if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->data['content']='lalitsardana';
        $this->load->view('template',$this->data);
    }
    public function allproduct($franchise_name=NULL,$franchise_id=0){
		
		$this->load->model('Admin_model');
        $this->data['content']='allproduct';
        //$vd_productslist = $this->Pricelist_model->getAllProducts(0, 0, 0, 2,0,'');
        $this->data['videoproductslist']=$vd_productslist;
              /*Display All exam product on page*/
       $ts_categories=array();
       $isProduct_array=array();
       $sp_Product=array();
       $ts_categories=$this->Examcategory_model->getExamCatgeories();
       foreach($ts_categories as $ex){ 
       $sp_chapter_id='';
       $sp_subject_id='';     
       $sp_exam_id=$ex->id;
       $sp_Product = $this->Pricelist_model->getProduct($sp_exam_id, $sp_subject_id, $sp_chapter_id, 1);
       if(count($sp_Product)>0){
        $isProduct_array[]= $sp_Product;
		
	   //Get package count
	   
       $packagecnt = $this->Pricelist_model->pkgCount_byExam($sp_exam_id);
		$packagecnt_array[$sp_exam_id]= $packagecnt;
		
		}
        }
               $this->data['sp_productslist']=$isProduct_array;
        /*End Display all packge*/
        /* Display All test series product on page*/
                 $isProduct_array=array();
                 $testseries_Product=array();
       foreach($ts_categories as $ex){ 
       $ts_chapter_id=0;
       $ts_subject_id=0;     
       $ts_exam_id=$ex->id;
       //$testseries_Product = $this->Pricelist_model->getProduct($ts_exam_id, $ts_subject_id, $ts_chapter_id, 3);
       if(isset($testseries_Product)){
       if(count($testseries_Product)>0){
                   $isProduct_array[]= $testseries_Product;
       }
       }
       }
	   if($franchise_id>0){
	    $franchiseInfo=$this->Admin_model->getAdminUser($franchise_id);
		$franchiseInfoCount=count($franchiseInfo);
		if($franchiseInfoCount>0){
		$this->data['franchiseInfo']=$franchiseInfo;	
		}else{
		$this->data['franchiseInfo']=NULL;
		}
	   }
        $this->data['packagecnt_array']=$packagecnt_array;
		$this->data['franchise_id']=$franchise_id;
	    $this->data['ts_productslist']=$isProduct_array;
        $this->load->view('template',$this->data);
    }
    public function cities($state_id){
		$cache_minutes=$this->config->item('cache_minutes');
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->load->model('States_model');
        $cities=$this->States_model->cities($state_id);
        $html='';
        $html.='<option value="">Please Select</option>';
        foreach($cities as $city){
        $html.='<option value="'.$city->id.'">'.$city->city_name.'</option>';
        }
        echo  $html;
    }
     public function  download($file_key){	
?><?php 
if($this->session->userdata('customer_id')&&$this->session->userdata('customer_id')=='71696'){


}else{
	?><p style='color:red'>Studypackages Are Available At Android App Only!</p><?php
	die();
}

        $this->load->model('File_model');
         $file_key =  decrypt($file_key);
         $var_file = explode('.',$file_key);

		 
         if(array_key_exists(1,$var_file)&&$var_file[1]==$this->session->userdata('customer_id')){
         $file_detail = $this->File_model->detail($var_file[0]); 
         $this->load->helper('download'); 
         $this->db->insert('cmsdownloadhistory',array('user_id'=>$this->session->userdata('customer_id'),'fileid'=>$var_file[0],'dt_created'=>date('Y-m-d h:i:s'),'ip_address'=>$this->input->ip_address()));
         if(isset($file_detail->filepath_one)&&$file_detail->filepath_one!=''){
         $existingPath=$file_detail->filename_one;
         }
	
         if (isset($existingPath)&&file_exists($this->input->server('DOCUMENT_ROOT') . $existingPath.$file_detail->filename_one)) {
         $yExist='found';
         }else if (file_exists($this->input->server('DOCUMENT_ROOT') . '/upload/pdfs/'.$file_detail->filename_one)) { 
         $yExist='found';
         $existingPath='/upload/pdfs/';
         }else{
         $yExist='notfound';
         $existingPath='notfound';
         }
         if (($yExist=='found')&&file_exists($this->input->server('DOCUMENT_ROOT') .$existingPath.$file_detail->filename_one)&&$file_detail->filename_one!='') {
?><a href="<?php echo $existingPath.$file_detail->filename_one; ?>">download</a><?php die;
			 
         force_download($this->input->server('DOCUMENT_ROOT') . $existingPath.$file_detail->filename_one, NULL);
         }else{
           echo "File not Found!";  
         }
         }else{
             echo "Unauthorized access!"; ;
         }
         //File name can be show only for specific account for testing purpose.
          $currentuserid= $this->session->userdata('customer_id');
          if(isset($currentuserid)&&($currentuserid!='')){
			  //71696
              $fnameshow='N.A.';
              if(isset($var_file[0])){
              $file_detail = $this->File_model->detail($var_file[0]);
              $fnameshow=$file_detail->filename_one;
              $displayname=$file_detail->displayname;
              $id=$file_detail->id;
              }
        ?>
       <input type="hidden" value="<?php echo $fnameshow; ?>">
        
       <input type="hidden" value="<?php echo $displayname; ?>" id="<?php echo $id; ?>"> 
        
        
        <?php      
        }
         //echo $this->input->server('DOCUMENT_ROOT') . '/upload/pdfs/'.$file_detail->filename_one;
     }
     
     /*Download Online test Question , Answer and Solution PDF File*/
      public function  duplidownload_olsolution($file_key){}
	  
	  
	  
      public function  download_olsolution($file_key){
         $file_key =  decrypt($file_key);
         $var_file = explode('c-h-e-c-k',$file_key); 
         if(array_key_exists(1,$var_file)&&$var_file[1]==$this->session->userdata('customer_id')){
            
        $existingPath='/upload/pdfs/';
        $file_detail = $var_file[0];
		
		if(isset($file_detail)&&$file_detail!=''){
		if(file_exists($this->input->server('DOCUMENT_ROOT') . $existingPath.$file_detail)) {
         $yExist='found';
         }else if (file_exists($this->input->server('DOCUMENT_ROOT') . '/upload/pdfs/'.$file_detail)) { 
         $yExist='found';
         $existingPath='/upload/pdfs/';
         }
		 
		}else{
         $yExist='notfound';
         $existingPath='notfound';
         }   
		 
         $this->load->helper('download'); 
         //echo $yExist.$existingPath.$file_detail;
         if (($yExist=='found')&&file_exists(FCPATH. $existingPath.$file_detail)&&($file_detail!='')) {         
         force_download($this->input->server('DOCUMENT_ROOT') . $existingPath.$file_detail, NULL);
		 
		// echo $yExist.$file_detail.'[E]';
		 
         }else{
           echo "File not Found!";  
         }
         }
         }
    public function getlocation(){
        $latitude=$this->input->post('latitude');
        $longitude=$this->input->post('longitude');
        $user_id=0;
        if($this->session->userdata('customer_id')){
            $user_id=$this->session->userdata('customer_id');
        }
		/*
        $this->db->insert('cmslocations',array('latitude'=>$latitude,'longitude'=>$longitude,'address'=>'NULL','user_id'=>$user_id));*/
       // echo '';die();
    }
    
    public function faq(){
		$cache_minutes=$this->config->item('cache_minutes');
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->data['content']='faq';
        $this->load->view('template',$this->data);
    }
	
    public function meating (){
        $this->data['content']='meating';
        $this->load->view('template',$this->data);
    }
	
    
    public function franchise(){
		$cache_minutes=$this->config->item('cache_minutes');
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->data['content']='franchise';
        $this->load->view('template',$this->data);
    }
    
public function codetestnvn(){ 

echo 'CHECK CODE'; die;

/*SELECT 
    email, COUNT(email)
FROM
    contacts
GROUP BY 
    email
HAVING 
    COUNT(email) > 1;*/

	
$duplicmscustomers = array(
  array('email' => 'aayushinagar5@gmail.com','COUNT(email)' => '3'),
  array('email' => 'abhi@gmail.com','COUNT(email)' => '2'),
  array('email' => 'addytiwari2@gmail.com','COUNT(email)' => '4'),
  array('email' => 'archanabhardwaj571@gmail.com','COUNT(email)' => '2'),
  array('email' => 'avinashmak99@gmail.com','COUNT(email)' => '3'),
  array('email' => 'bhardwajsuraj44@gmail.com','COUNT(email)' => '2'),
  array('email' => 'bmobile566@gmail.com','COUNT(email)' => '2'),
  array('email' => 'digitaldamu@gmail.com','COUNT(email)' => '2'),
  array('email' => 'guddpdsf@gmail.com','COUNT(email)' => '2'),
  array('email' => 'hanzal645@gmail.com','COUNT(email)' => '2'),
  array('email' => 'hemaantsharma4@icloud.com','COUNT(email)' => '2'),
  array('email' => 'kartikay1022001@gmail.com','COUNT(email)' => '2'),
  array('email' => 'mdshonu6@gmail.com','COUNT(email)' => '6'),
  array('email' => 'msonber64@gmail.com','COUNT(email)' => '2'),
  array('email' => 'nirmal.lnmiit1@gmail.com','COUNT(email)' => '2'),
  array('email' => 'nuthanavya@gmail.com','COUNT(email)' => '2'),
  array('email' => 'ommakode@gmail.com','COUNT(email)' => '2'),
  array('email' => 'patelneeraj379@gmail.com','COUNT(email)' => '2'),
  array('email' => 'prasunprakash70@gmail.com','COUNT(email)' => '2'),
  array('email' => 'raj557337@gimal.com','COUNT(email)' => '2'),
  array('email' => 'rajpatil2507@gmail.com','COUNT(email)' => '2'),
  array('email' => 'ranjan.niwas11@gmail.com','COUNT(email)' => '3'),
  array('email' => 'ranvijaykumarpradhan@gmail.com','COUNT(email)' => '2'),
  array('email' => 'raunakbasotia@gmail.com','COUNT(email)' => '2'),
  array('email' => 'raymahumera12@gmail.com','COUNT(email)' => '2'),
  array('email' => 'reddyrsaidi@gmail.com','COUNT(email)' => '2'),
  array('email' => 'rohitthakur1942000@gmail.com','COUNT(email)' => '2'),
  array('email' => 'sarojkumar.sahoo1998@outlookl.com','COUNT(email)' => '2'),
  array('email' => 'sar_7@live.in','COUNT(email)' => '2'),
  array('email' => 'satyam1332@gmail.com','COUNT(email)' => '2'),
  array('email' => 'satyamkthakur20@gmail.com','COUNT(email)' => '3'),
  array('email' => 'sauravrao1998@gmail.com','COUNT(email)' => '2'),
  array('email' => 'sharma.ajay@ambujacement.com','COUNT(email)' => '2'),
  array('email' => 'singh.rakeshkumar04@gmail.com','COUNT(email)' => '2'),
  array('email' => 'smile9gandhi@gmail.com','COUNT(email)' => '3'),
  array('email' => 'subhasis.chemistry@gmail.com','COUNT(email)' => '2'),
  array('email' => 'sushanta2570@gmail.com','COUNT(email)' => '2'),
  array('email' => 'upadhayaymanas@gmail.com','COUNT(email)' => '2'),
  array('email' => 'vishvamberd@gmail.com_delete','COUNT(email)' => '2')
);

//order status 1 success
$di=1;
foreach($duplicmscustomers as $dkey => $svalue){
	if($svalue['email']!=''){
            
        $this->db->select('id,email,is_social,order_success,password,fbid,twitterid,googleplusid,user_key,device_id,legacy_id,mobile');
        $this->db->from('cmscustomers');
        $this->db->where('email=',$svalue['email']);
	$query=$this->db->get();
        $resultcid=$query->result(); 

echo $di.'('.$svalue['COUNT(email)'].')->'; die;
if($svalue['COUNT(email)']==2){
foreach($resultcid as $cidkey => $cidvalue){

	
echo $svalue['email'].'-'.$cidvalue->id.'<br><br><br>';
       $this->db->select('id,email,is_social,order_success,password,fbid,twitterid,googleplusid,user_key,device_id,legacy_id,mobile');
       $this->db->from('cmscustomers');
       $this->db->where('email=',$cidvalue->email);
       $this->db->where('id!=',$cidvalue->id);
	$query_nonord=$this->db->get();
        //echo $this->db->last_query();
     $result_nonord=$query_nonord->result(); 
        
        if(count($result_nonord)>0){
    $result_nonordArray=$result_nonord[0];
}else{
    $result_nonordArray=$result_nonord;
}
        
        print_r($result_nonordArray);

echo '-above db result For update below update array-';

$datafarra=array();

if($cidvalue->password==''){
if($result_nonordArray->password!=''){
    $datafarra['password']=$result_nonordArray->password;    
}else{
    $datafarra['password']='e10adc3949ba59abbe56e057f20f883e';
}
}

if($cidvalue->fbid==''){
    if($result_nonordArray->fbid!=''){
    $datafarra['fbid']=$result_nonordArray->fbid;    
    }
}


if($cidvalue->mobile==''){
    if($result_nonordArray->mobile!=''){
    $datafarra['mobile']=$result_nonordArray->mobile;    
    }
}


if($cidvalue->twitterid==''){
    if($result_nonordArray->twitterid!=''){
    $datafarra['twitterid']=$result_nonordArray->twitterid;    
    }
}

if($cidvalue->googleplusid==''){
    if($result_nonordArray->googleplusid!=''){
    $datafarra['googleplusid']=$result_nonordArray->googleplusid;    
    }
}


if($cidvalue->user_key==''){
    if($result_nonordArray->user_key!=''){
    $datafarra['user_key']=$result_nonordArray->user_key;    
    }
}


if($cidvalue->device_id==''){
    if($result_nonordArray->device_id!=''){
    $datafarra['device_id']=$result_nonordArray->device_id;    
    }
}


if(count($datafarra)>0){
//$this->db->where('id',$cidvalue->id);
//$this->db->update('cmscustomers',$datafarra); 
}

echo '-- fine tune to dupli_DB--'; echo $result_nonordArray->id.'<br>:';

$emailupdate=array('email'=>'dupli_'.$result_nonordArray->email);
if(count($emailupdate)>0){
		//$this->db->where('id',$result_nonordArray->id);
		//$this->db->update('cmscustomers',$emailupdate);
}

break;
}
	}
}


$di++;
}


	die('End pages..yyyyyyyyyyyyyyyyyy.');

	 //$this->db->query('SELECT email,COUNT(email) FROM cmscustomers GROUP BY email HAVING COUNT(email) > 1');
	  $this->db->select('id,email,COUNT(email)');
        $this->db->from('cmscustomers');
        $this->db->where('email!=','');
		 $this->db->group_by('email');
		 $this->db->having("COUNT(email) > 1", null, false);
       $query=$this->db->get();
       //echo $this->db->last_query();
       $result=$query->result(); 
     $i=1; 
foreach($result as $key=>$value){
echo $i.' '.$value->email.'<br>';



$this->db->select('id,status');
        $this->db->from('cmsorders');
        $this->db->where('user_id',$value->id);
        $ordquery=$this->db->get();
        $ordresult=$ordquery->result();
	  //print_r($ordresult); 

if(count($ordresult)>0){
echo 'Order hai<br>';
}else{
echo 'Nahi hai<br>';
$data=array('email'=>email);

		$this->db->where('id',$value->id);
		$this->db->update('cmscustomers',$data);   


}


$i++;
}

	   echo '...................';
	   // $this->data['content']='franchise';
        //$this->load->view('template',$this->data);
    }
	
	
	    /*Duplicate mobile chaeck for Unique field*/
	 
public function dupliMobCheck_nvn(){ 

//ini_set('max_execution_time', '300');
die("Check code");
$this->db->select('id,mobile_legacy,COUNT(mobile_legacy) as lgscnt');
        $this->db->from('cmscustomers');
		 $this->db->group_by('mobile_legacy');
		 $this->db->having("COUNT(mobile_legacy) > 1", null, false);
		 //$this->db->where("mobile_legacy",'9999999999');
		 
       $query=$this->db->get();
       //echo $this->db->last_query();
	  $numrws= $query->num_rows();
    
	  $result=$query->result(); 
     $i=1; 
foreach($result as $key=>$value){
echo $i.' '.$value->mobile_legacy.'<br>';


$this->db->select('id,mobile_legacy');
        $this->db->from('cmscustomers');
		 $this->db->where("mobile_legacy",$value->mobile_legacy);
		 
       $querymbl=$this->db->get();
       //echo $this->db->last_query();
	  $numrwsmbl= $querymbl->num_rows();
    
	  $resultmbl=$querymbl->result(); 
	  
	  
$nmnbl=1;
foreach($resultmbl as $keymbl=>$valuembl){
$this->db->select('id,status');
        $this->db->from('cmsorders');
        $this->db->where('user_id',$valuembl->id);
        $ordquery=$this->db->get();
        $ordresult=$ordquery->result();
	  //print_r($ordresult); 

if(count($ordresult)>0){
echo 'Order hai('.$valuembl->id.')<br>';
$datamb=array('order_success'=>'mbl','mobile_legacy'=>$valuembl->id);
//$this->db->where('id',$valuembl->id);
		//$this->db->update('cmscustomers',$datamb);  
}else{
echo 'Nahi hai('.$valuembl->id.')<br>';
$data=array('mobile_legacy'=>$valuembl->id);
if($nmnbl>1){
		//$this->db->where('id',$valuembl->id);
		//$this->db->update('cmscustomers',$data);   
}

$nmnbl=$nmnbl+1;
}
} 

$i++;
}

die($i.'only check mobile_legacy..');

	
//order status 1 success
$di=1;
foreach($duplicmscustomers as $dkey => $svalue){
	if($svalue['email']!=''){
            
        $this->db->select('id,email,is_social,order_success,mobile');
        $this->db->from('cmscustomers');
        $this->db->where('email=',$svalue['email']);
	$query=$this->db->get();
        $resultcid=$query->result(); 

echo $di.'('.$svalue['COUNT(email)'].')->'; die;
if($svalue['COUNT(email)']==2){
foreach($resultcid as $cidkey => $cidvalue){

	
echo $svalue['email'].'-'.$cidvalue->id.'<br><br><br>';
       $this->db->select('id,email,is_social,order_success,password,fbid,twitterid,googleplusid,user_key,device_id,legacy_id,mobile');
       $this->db->from('cmscustomers');
       $this->db->where('email=',$cidvalue->email);
       $this->db->where('id!=',$cidvalue->id);
	$query_nonord=$this->db->get();
        //echo $this->db->last_query();
     $result_nonord=$query_nonord->result(); 
        
        if(count($result_nonord)>0){
    $result_nonordArray=$result_nonord[0];
}else{
    $result_nonordArray=$result_nonord;
}
        
        print_r($result_nonordArray);

echo '-above db result For update below update array-';

$datafarra=array();

if($cidvalue->mobile==''){
    if($result_nonordArray->mobile!=''){
    $datafarra['mobile']=$result_nonordArray->mobile;    
    }
}
}


if(count($datafarra)>0){
//$this->db->where('id',$cidvalue->id);
//$this->db->update('cmscustomers',$datafarra); 
}

echo '-- fine tune to dupli_DB--'; echo $result_nonordArray->id.'<br>:';

$emailupdate=array('email'=>'dupli_'.$result_nonordArray->email);
if(count($emailupdate)>0){
		//$this->db->where('id',$result_nonordArray->id);
		//$this->db->update('cmscustomers',$emailupdate);
}

break;
}
	}
}
$di++;
}
}

