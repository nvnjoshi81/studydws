<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Add_Student extends MY_Salescontroller {
        public function __construct()
        {
			
            parent::__construct();
            $this->load->model('Customer_model');
            $this->load->model('Videos_model');
            $this->load->model('Pricelist_model');
            $this->load->model('Cart_model');
			$this->load->model('Onlinetest_model');
            $this->load->model('Products_model');
			$this->load->model('States_model');
			$this->load->model('Categories_model');
            $this->load->library('sms');
            $this->load->library('encrypt');
            $dir_salesadmin=$this->folder_admin=$this->config->item('dir_salesadmin');
            $this->dir_salesadmin=$dir_salesadmin;
        }
        public function index(){
			$dir_salesadmin=$this->dir_salesadmin;$this->load->library('pagination');
                $ordercol=$this->input->get('col');
                $order=$this->input->get('order');
                if(!$ordercol){
                    $ordercol='firstname';
                }if(!$order){
                    $order='asc';
                }
                /***** pgination _categories***   */
                $total=$this->Customer_model->getAllFrCustomersCount();
                $this->data['total']=$total;
                $config = array();
                $config["base_url"] = base_url() . $dir_salesadmin."/Add_Order/index/";
                $config["total_rows"] = $total;
                $config["per_page"] = $this->config->item('records_per_page');
                $config["uri_segment"] = 4;
                $config["num_links"] = 5;
                $config['first_link']='&lsaquo; First';
                $config['first_tag_open'] = '<li>';
                $config['first_tag_close'] = '</li>';
                $config['last_link']='Last &rsaquo;';
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
                $config['reuse_query_string'] = true;
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                $this->data['page']=$page;
                $this->data['ordercol']=$ordercol;
                $this->data['order']=$order;
                $this->data["links"] = $this->pagination->create_links();
                $franchiseid=$this->session->userdata('userid');
				//user admin type franchise is 3
		$admintype=$this->session->userdata('usertype');
		$customers =$this->Customer_model->getFrCustomers($config["per_page"], $page,$ordercol,$order,$admintype,$franchiseid); 
		$this->data['customers']=  $customers;
        $states = $this->States_model->getStates();
        $this->data['states'] = $states;
        $cities = $this->States_model->cities();
        $this->data['cities'] = $cities;
		$studentschool =$this->Customer_model->studentschool($franchiseid);
		$this->data['studentschool'] = $studentschool;
                $this->data['content']='add_student/index';
                $this->load->view('common/template',$this->data);
        }
		
		
	  public function dresultxl($studentid,$testid){
			
$usertest_info = $this->Onlinetest_model->get_testinfo_byid($testid); 
$attemptsInxl=$this->Onlinetest_model->getAttempts($usertest_info->test_id,$studentid);
		
			   //load our new PHPExcel library
$this->load->library('excel');
//activate worksheet number 1
$this->excel->setActiveSheetIndex(0);
//name the worksheet
$this->excel->getActiveSheet()->setTitle('All Test Result');

$this->excel->getActiveSheet()->setCellValue('A1', '#');
$this->excel->getActiveSheet()->setCellValue('B1', 'Correct Ans');
$this->excel->getActiveSheet()->setCellValue('C1', 'Incorrect Ans');
$this->excel->getActiveSheet()->setCellValue('D1', 'Reviewed Qus');
$this->excel->getActiveSheet()->setCellValue('E1', 'Not Attempted');
$this->excel->getActiveSheet()->setCellValue('F1', 'Total Qus');
$this->excel->getActiveSheet()->setCellValue('G1', 'Time Taken(Min)');
$this->excel->getActiveSheet()->setCellValue('H1', 'Score');
$this->excel->getActiveSheet()->setCellValue('I1', 'Obtain Marks');
$this->excel->getActiveSheet()->setCellValue('J1', 'Date');
$i=2;

  foreach($attemptsInxl as $allrow){
	  //Solution for Division by zero.
                            if($allrow->obtain_marks>0){
                            $percentage=($allrow->obtain_marks / $allrow->total_marks)*100;
                            }else{
                            $percentage=NULL;    
                            }
   
    $this->excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(8);
         $this->excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(8);
          $this->excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(8);
           $this->excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(8);
            $this->excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setSize(8);
             $this->excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setSize(8);
              $this->excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(8);
               $this->excel->getActiveSheet()->getStyle('H'.$i)->getFont()->setSize(8);               
                $this->excel->getActiveSheet()->getStyle('I'.$i)->getFont()->setSize(8);               
                 $this->excel->getActiveSheet()->getStyle('J'.$i)->getFont()->setSize(8);
			$numcnt=$i-1;	 
               //set cell A1 content with some text
$this->excel->getActiveSheet()->setCellValue('A'.$i, $numcnt);
$this->excel->getActiveSheet()->setCellValue('B'.$i, $allrow->correct_ans);
$this->excel->getActiveSheet()->setCellValue('C'.$i, $allrow->incorrect_ans);
$this->excel->getActiveSheet()->setCellValue('D'.$i,$allrow->reviewed_qus);

							$not_att_qus=abs($allrow->not_attampted_qus);
							$att_ques=abs($allrow->attampted_ques); 
							$review_qus=abs($allrow->reviewed_qus);
							if(isset($not_att_qus)&&$not_att_qus>0){
								$row_notatt_q=$not_att_qus;
							}else{
								$row_notatt_q=0;
							}
							if(isset($review_qus)&&$review_qus>0){
								$row_reviewed_qus=$review_qus;
							}else{
								$row_reviewed_qus=0;
							}
							
							$total_not_attq=$row_notatt_q-$row_reviewed_qus;

$this->excel->getActiveSheet()->setCellValue('E'.$i, $total_not_attq);

$this->excel->getActiveSheet()->setCellValue('F'.$i, $allrow->total_qus);
$round_time_taken=round($allrow->time_taken / 60, 1);
$this->excel->getActiveSheet()->setCellValue('G'.$i, $round_time_taken);
$round_per=round($percentage,2);
$this->excel->getActiveSheet()->setCellValue('H'.$i, $round_per);
$tmarks=$allrow->obtain_marks.'/'.$allrow->total_marks;
$this->excel->getActiveSheet()->setCellValue('I'.$i, $tmarks);

$this->excel->getActiveSheet()->setCellValue('J'.$i, date('d-m-Y',$allrow->dt_created));

$this->excel->getActiveSheet()->setCellValue('K'.$i,'p');
$i++;
}

$filename=$studentid.'_'.$testid.'_result.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
             
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output'); 
     }
		
public function showResult($studentid,$testid=0) {
if($testid>0){	
$usertest_info = $this->Onlinetest_model->get_testinfo_byid($testid);
	
		$attempts=$this->Onlinetest_model->getAttempts($usertest_info->test_id,$studentid);
		$this->data['attempts']=$attempts; 
		}else{
		$attempts=array();
		$usertest_info=array();
		}
		$franchiseid=$this->session->userdata('userid');
		$dir_salesadmin=$this->dir_salesadmin;
			   $this->data['ordercol']='id';
			   $this->data['order']='asc';
			   $this->data['studentid']=$studentid;
			   $this->data['usertest_info'] = $this->Onlinetest_model->get_testinfo_by_customer($studentid);
			   
			   if(isset($testid)&&$testid>0){
				   
			   }
                $this->data['content']='add_student/student_result';
                $this->load->view('common/template',$this->data);	
		
		}
		public function addStudent() {
        $franchiseid=$this->session->userdata('userid');
		$dir_salesadmin=$this->dir_salesadmin;
		$firstname = $this->input->post('firstname');
		$lastname = $this->input->post('lastname');
		$studentschool_id=$this->input->post('studentschool_id');
        $studentclass = $this->input->post('studentclass');
        $email = $this->input->post('emailstudent');
        $password = $this->input->post('passstudent');
        $repassstudent=$this->input->post('repassstudent');
		$mobile = $this->input->post('mobilestudent');
		$targate_exam=$this->input->post('studentclass');
		$postcodestu=$this->input->post('postcodestu');
		$address_student = $this->input->post('address_student');
					$citystudent = $this->input->post('citystudent');
					$countrystu = $this->input->post('countrystu');
		//Add session values.
		
if(isset($firstname)&&$firstname!=''){
		$this->session->set_userdata('firstname', $firstname);
		}
		if(isset($lastname)&&$lastname!=''){
		$this->session->set_userdata('lastname', $lastname);
		}
		if(isset($studentclass)&&$studentclass!=''){
		$this->session->set_userdata('studentclass', $studentclass);
		}
		if(isset($studentschool_id)&&$studentschool_id!=''){
		$this->session->set_userdata('studentschool_id', $studentschool_id);
		}
		if(isset($email)&&$email!=''){
		$this->session->set_userdata('emailstudent', $email);
		}
if(isset($mobile)&&$mobile!=''){
		$this->session->set_userdata('mobilestudent', $mobile);
		}
if(isset($postcodestu)&&$postcodestu!=''){
		$this->session->set_userdata('postcodestu', $postcodestu);
		}		
		if(isset($address_student)&&$address_student!=''){
		$this->session->set_userdata('address_student', $address_student);
		}	
		$mobile= str_replace("-","",$mobile);  
        if ($email=='') {
            $this->session->set_flashdata('message','Email Is Required!');     
            redirect($dir_salesadmin.'/Add_Student');
        }
        if($password==''){
		$this->session->set_flashdata('message','Password or confirm password is blank.');redirect($dir_salesadmin.'/Add_Student');
		}elseif($repassstudent!=$password){
		$this->session->set_flashdata('message','Password and confirm password are not same or blank.');     
        redirect($dir_salesadmin.'/Add_Student');
		}
		
        if ($mobile=='') {
            $this->session->set_flashdata('message','Mobile Is Required!');     
        redirect($dir_salesadmin.'/Add_Student');
		}else{
        if (($mobile!='')&&(!is_numeric($mobile))) {
            $this->session->set_flashdata('message','Mobile Number Should be Numeric Only!');     
        redirect($dir_salesadmin.'/Add_Student');
		}
        }
		$emailExist='';
		
        $checkemail_data = $this->Customer_model->checkemail($email);
		
		if($checkemail_data==false){
		$emailExist='yes';	
			
		}
		if (($emailExist!='')&&($emailExist=='yes')) {
        $this->session->set_flashdata('message','This Email is already registered.Please use different email addresses on your account!');     
        redirect($dir_salesadmin.'/Add_Student');
		}
        
        $is_social_value = $this->input->post('is_social_value');

        if(isset($is_social_value)&&$is_social_value==3){
            $is_social_status=3;
        }else{
            $is_social_status=3;
        }
		
		 $lastname=$lastname ? $lastname : '';
         $address_name=$firstname.' '.$lastname;
		 //user admin type franchise is 3
			

$admintype=$this->session->userdata('usertype');
		$customerinfo = array(
		    'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => md5($password),
			'mobile' => $mobile ? $mobile : '',
			'status' => '1',
            'mobile_verified'=>'1',
			'targate_exam'=>$targate_exam,
			'schoolid'=>$studentschool_id,
			'usertype'=>$admintype,
            'is_social'=>$is_social_status,
            'created_dt' => time()
 );
        $emailStr = strlen($email);
        $regi_session_input = $this->input->post('regi_session_input');
        $regi_session_value = $this->session->userdata("regi_session");
//To prevent cross scripting checking with session value.
            $customer_id = $this->Customer_model->register($customerinfo);
        if($customer_id) {
		$franchiseinfo = array(
		'customer_id' => $customer_id,
            'franchise_id' => $franchiseid,
            'created_dt' => time()
			);
					
			$this->Customer_model->addfranchise($franchiseinfo);
		$cinfo_address = array('customer_id' => $customer_id,
            'address' => $address_student ,
			'address_name' => $address_name ,
            'city' => $citystudent,
			'city_name' =>'',
            'state' => $countrystu,
            'state_name' => '',
			'country_id'=>'1',
			'country_name'=>'INDIA',
            'zipcode' => $postcodestu,
            'mobile'=>$mobile);
			
			$this->Customer_model->addAddress($cinfo_address);
			
            $verification_code = $this->encrypt->encode($customer_id . '.' . $email);
            $this->db->where('id', $customer_id);
            $this->db->update('cmscustomers', array('verification_code' => $verification_code));
            $response = array('status' => 1, 'msg' => 'Customer Registered Successfully.');
            
			$message = 'Your account has been created.Click <a href="' . base_url('login') . '">HERE</a> to login.<br>Click <a href="' . base_url('account/verify/' . $verification_code) . '">here</a> to verify your email.<br>Verification Link : ' . base_url('account/verify/' . $verification_code);
            $subject = "StudyAdda Account Created";
            $to = $email;
            $mobile_number = $mobile;
            $sms_message = 'Hello sir/madam. Thankyou for registering with us.We ensure you for the best service and the best education experience. Regards - StudyAdda.com';
            sendEmail($to, $subject, $message);
            $this->sms->send_sms($mobile_number,$sms_message);
            // Set the response and exit
            // OK (200) being the HTTP response code
			
		$this->session->set_flashdata('message','Student has been added Successfully.');     
        redirect($dir_salesadmin.'/Add_Student');
        } else {
		$this->session->set_flashdata('message','Please try again.There was error processing your request.');     
        redirect($dir_salesadmin.'/Add_Student');
        }
    }

        public function productlist(){
              $dir_salesadmin=$this->dir_salesadmin;  
            $studentid=$this->input->post('studentid');
            
            if((null!==$this->input->post('studentid'))&&$this->input->post('studentid')>0){
               $studentid = $this->input->post('studentid');
            }else{
                redirect($dir_salesadmin."/Add_Order/index/");
            }
            $studentemail=$this->input->post('studentemail');
            $exam_id=0; $subject_id=0; $chapter_id=0;
            
        $isProduct = $this->Pricelist_model->getProduct($exam_id, $subject_id, $chapter_id, 2);
        $product_id=0;
        if($isProduct){
        $product_id=$isProduct->id;
        }
        $productslist = $this->Pricelist_model->getAllProducts($exam_id, $subject_id, $chapter_id, 2,0,$product_id);
        $this->data['exam_id']=$exam_id;
        $this->data['subject_id']=$subject_id;
        $this->data['chapter_id']=$chapter_id; 
        $this->data['isProduct'] = $isProduct;
        $this->data['productslist'] = $productslist;
        $this->data['studentid']=$studentid;
        $this->data['studentemail']=$studentemail;
        $frCustomerCart=$this->Cart_model->getFrCustCart($studentid);
        $this->data['frCustomerCart']=$frCustomerCart;
        $this->data['content']='add_order/productlist';
            $this->load->view('common/template',$this->data);
        }
        
        
         public function frOrderprocess(){
        $dir_salesadmin=$this->dir_salesadmin;  
        $studentemail=$this->input->post('studentemail');    
	$user_id =$this->input->post('studentid');
        $frCustomerCart=$this->Cart_model->getFrCustCart($user_id);
	$user_info = $this->Customer_model->getCustomerDetails($user_id);
        $this->data['studentid']=$user_id;
        $this->data['studentemail']=$studentemail;
        $payment_mode = 'frPay';
        /**********************************************************************************/
        //$delivery_req  = $this->input->post('delivery_req');
	$final_amount_post = $this->cart->total();   
	$shipping_charges_post = $this->input->post('shipping_charges');
        if($shipping_charges_post>0){
        $shipping_charges=abs($shipping_charges_post);
        $final_amount_post=abs($final_amount_post);
        $final_amount=$final_amount_post+$shipping_charges;
        }else{
            $shipping_charges=0;
            $final_amount=abs($final_amount_post);
        }
	$cod_charges = 0;//$this->input->post('cod_charges');
        $defaultAddr=$this->Customer_model->getDefaultAddress($user_id);
        $shipping_address_id = $defaultAddr->id;
	$cart_id = $frCustomerCart[0]->cart_id;
        $agree_terms = 'yes';
        if(isset($agree_terms)&&$agree_terms=='yes'){
            $agree_terms_value='yes';
        }else{
            $agree_terms_value='no'; 
        }
       
        $mobile_number=$user_info->mobile;
	$cart_items = $this->Cart_model->getCartItems($cart_id);
   
        if(($user_id=='')||($user_id<1)){
        $this->session->set_flashdata('message', 'Student Id not found.Please login again!');
        
                redirect($dir_salesadmin."/Add_Order/index/");
        }
        
        if((count($cart_items)=='')||(count($cart_items)<1)){
        $this->session->set_flashdata('message', 'Your have not added product for student.Please Add product in the cart.');
        redirect($dir_salesadmin."/Add_Order/index/");
        }
  
        // check if added item is exist in cmspricelist table 
        foreach ($cart_items as $items){
           $itemid = $items->product_id;
          $pricelist_count = $this->Cart_model->getpriclistCount($itemid);        
          if(($pricelist_count=='')||($pricelist_count<1)){
            $this->session->set_flashdata('message', 'There is some problem in product you have added to cart.Please delete some product and try again.');
           redirect($dir_salesadmin."/Add_Order/index/");
          }
        }
        // Check if payment option is online 
        /*1 For cash on delevery, 2 For CCAvenue, 3 For Paytm*/       
      
        if($payment_mode==3){
            //paytm
        }elseif($payment_mode==2){
        //CCAenue
        }elseif($payment_mode=='frPay'){
                    //COD
            /*
         if($this->session->userdata('customer_id')!='71696'){
             //COD Activate for one testing account only
             $this->session->set_flashdata('message', 'This method is not activated now.Please select Online Payment option now.');
         redirect('/cart'); die;
         }
         */
         
        $this->session->set_userdata('frCart_id',$cart_id);                
        $order=$this->Customer_model->addOrder($user_id,$payment_mode,$final_amount,$shipping_charges,$cod_charges,$shipping_address_id,$agree_terms_value);
        $order_id=$order['order_id'];
        $order_no=$order['order_no'];
            //foreach ($this->cart->contents() as $item){
                //$this->Products_model->updateQuantity($item['id'],$item['qty']);
            //}            
            $this->Customer_model->ediCod_Orderstatus($order_id,1);
            // @TO-DO : add payment mode condition and execute following code for cod.
            $this->Cart_model->removeCart($cart_id,$user_id);
            $this->cart->destroy();
            
             $this->sms->send_sms($mobile_number, 'your order No# '. $order_no .' at STUDYADDA is Completed.Please Login to your account to access your products.You can View/Download your product from My Account Section.'); 
             $message = 'Dear Sir/Madam,'.'<br>'.'Your Order Was Successfull, Below is your order number for further references.'.'<br>'.'Your Order Number is'.'&nbsp;'.$order_no;
            $subject = 'Order Confirmation-'.$mobile_number;
            $to = $user_info->email;
            $mobile_number = $user_info->mobile;
           // $sms_message = 'Hello Mr/Mrs/Ms'.$user_info->firstname.' ,this is a confirmation message from patanjaliayurved.net.Your order has been placed successfully.Order No : '.$order_no;
           // 
    $product_list='';
            for($i=0;count($order['order_details_array'])>$i;$i++){
                if($order['offline']==0){
                  $Offline='Offline';  
                }else{
                  $Offline='Online'; 
                }
                
            $product_list .='<tr>
		 <td>'.$order['order_details_array'][$i]->modules_item_name.'</td>
		 
		 <td>'.$Offline.'</td>
		 <td><i class="fa fa-inr">'.$order['order_details_array'][$i]->price.'</i></td>
                </tr>';
            }

            
    $message .= '<div style="min-height: 0.01%;
    overflow-x: auto;"><table style="margin-bottom: 20px;
    max-width: 100%;
    width: 100%;" border="1">    
    <thead>
      <tr>
        <th>Product Name</th>
		<th>Mode</th>
        <th>Amount</th>       
      </tr>
    </thead>
    <tbody>	
		'.$product_list.'<tr align="left">
		  <th>Total</th>
		  
		  <th>'.$order['order_qty'].'</th>
		  <th><i class="fa fa-inr"></i>'.$order['order_price'].'</th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			
			<th align="left">Extra charges</th>
			<th align="left"><i class="fa fa-inr"></i> '.$order['shipping_charges'].'</th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			
			<th>&nbsp;</th>
			<th align="left"><i class="fa fa-inr"></i>'.$order['final_amount'].'</th>
		</tr>
    </tbody>
  </table></div>';
            //send email
            sendEmail($to,$subject,$message);
            //$this->sms->send_sms($mobile_number,$sms_message);   
            
            $this->session->set_flashdata('update_msg','Your order has been placed successfully');
            redirect($dir_salesadmin."/Add_Order/orderlist");
        }else{
            
         $this->session->set_flashdata('message', 'Please Select Atleast One Payment Method.');
         redirect($dir_salesadmin."/Add_Order/index/");   
        }      
        //echo count($cart_items).'------';die;
                echo $cart_id.".....".$user_id;
        
        print_r($cart_items);
        print_r($defaultAddr);
        die;
    }
        
        
           public function edit($customer_id){
            $this->data['user_info'] = $this->Customer_model->getCustomerDetails($customer_id);
	    $default_address = $this->Customer_model->getDefaultAddress($customer_id);
            $this->data['user_info_default_address']=$default_address;
            if(isset($default_address->id)&&($default_address->id>0)){
            $this->data['user_info_address'] = $this->Customer_model->getAddresses($customer_id,$default_address->id);
            }else{
            $this->data['user_info_address']='';  
            }
			$this->data['content']='add_student/editstudent';
            $this->load->view('common/template',$this->data);
        }
        public function updatecustomer(){
		$firstname = $this->input->post('firstname');
		$lastname = $this->input->post('lastname');
		$email = $this->input->post('email');
		$mobile = $this->input->post('mobile');		 
                 $mobile_verified = $this->input->post('mobile_verified');
                 $wallet_balance = $this->input->post('wallet_balance');
                 $status = $this->input->post('status');
                 $user_id = $this->input->post('user_id');
                 $modified_by_id = $this->session->userdata("userid");
                 $date = time();
		 $userdata = array('firstname'=>$firstname,
						   'lastname'=>$lastname,
							'email'=>$email,
							'mobile'=>$mobile,
							'mobile_verified'=>$mobile_verified,
							'wallet_balance'=>$wallet_balance,
							'status'=>$status,
                                                        'modified_by'=>$modified_by_id,
                                                        'modified_dt'=>$date );
		 $this->Customer_model->updatecustomerinfo($user_id,$userdata);
		 $this->session->set_flashdata('update_msg','Your information has been updated successfully');
		 redirect('admin/customers/edit/'.$user_id);
	 }
         
         
         public function search_customer(){             
                $dir_salesadmin=$this->dir_salesadmin;  
                $franchiseid=$this->session->userdata('userid');
                $customer_id =$this->input->post('searchschool_id');  $searchschool_id =$this->input->post('searchschool_id');
                $customer_email =$this->input->post('customer_email');
				$customer_mobile =$this->input->post('customer_mobile');
                $this->data['total']=1;
                $this->data['ordercol']='id';
                $config = array();
				$studentschool =$this->Customer_model->studentschool($franchiseid);
                $config["base_url"] = base_url() .$dir_salesadmin. "/add_order/index/";
                $customers =$this->Customer_model->getCustomerDetails_byparam($customer_id,$customer_email,'',$searchschool_id);  
                $this->data['customers']=  $customers;
				$this->data['studentschool']=$studentschool;			
                $this->data['content']='add_order/search_customer';
                $this->load->view('common/template',$this->data);
        }
           
         public function customer_by_date(){
      
                $start_date =$this->input->post('start_date');
                $end_date =$this->input->post('end_date');
                $start_date_string = strtotime($start_date);
                $end_date_string = strtotime($end_date);
                if($start_date_string == $end_date_string){
                    $end_date_string=$start_date_string+(3600*24);
                }
                //echo date('m-d-Y',$start_date_string);
                //echo date('m-d-Y',$end_date_string);
                $this->data['total']=1;
                $this->data['ordercol']='id';
                $this->data['start_date']=$start_date;
                $this->data['end_date']=$end_date;
                $config = array();
                $config["base_url"] = base_url() . "admin/customers/index/";
                
                if(($start_date=='')||($end_date=='')){
                 $this->session->set_flashdata('message','Please enter both date.');
                 redirect(base_url('admin/customers'));
             $this->data['customers']= NULL ;  
             }else{
             $customers =$this->Customer_model->getCustomer_bydate($start_date_string,$end_date_string); 
             //$customers_downlaod =$this->Customer_model->getCustomer_xls_downlaod($start_date_string,$end_date_string); 
             $this->data['customers']=  $customers;  
             }           
             
                $this->data['content']='customers/search_customer';
                $this->load->view('common/template',$this->data);
                
        }
        
        public function create_customer_xls($start_date,$end_date){
                $start_date_string = strtotime($start_date);
                $end_date_string = strtotime($end_date);
                 if($start_date_string == $end_date_string){
                    $end_date_string=$start_date_string+(3600*24);
                }
                $customers_downlaod =$this->Customer_model->getCustomer_xls_downlaod($start_date_string,$end_date_string); 
        }
          public function subscriber_search(){ 
              $start_date =$this->input->post('start_date');
                $end_date =$this->input->post('end_date');
                if($start_date == $end_date){
                    
                $start_date_string = $start_date.' 00:00:00';
                    $end_date_string=$start_date.' 00:00:00';
                }else{
                       
                $start_date_string = $start_date.' 00:00:00';
                $end_date_string = $end_date.' 00:00:00';
                }
               // print_r($this->input->post()); die;
                 $config = array();
                 
                $this->data['start_date']=$start_date;
                $this->data['end_date']=$end_date;
                $config["base_url"] = base_url() . "admin/customers/index/";
                if(($start_date=='')||($end_date=='')){
                 $this->session->set_flashdata('message','Please enter both date.');
                 //redirect(base_url('admin/subscriber_search'));
             $this->data['customers']= NULL ;  
             }else{
             $customers =$this->Customer_model->getSubscriber_bydate($start_date_string,$end_date_string); 
             $this->data['customers']=  $customers;  
             }           
             
                $this->data['content']='customers/subscriber_search';
                $this->load->view('common/template',$this->data);
          }
           public function create_subscriber_xls($start_date,$end_date){
                if($start_date == $end_date){
                    
                $start_date_string = $start_date.' 00:00:00';
                    $end_date_string=$start_date.' 00:00:00';
                }else{
                       
                $start_date_string = $start_date.' 00:00:00';
                $end_date_string = $end_date.' 00:00:00';
                }           
                $customers_downlaod =$this->Customer_model->getSubscriber_xls_downlaod($start_date_string,$end_date_string); 
        }
          
         
}
