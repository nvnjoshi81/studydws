<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Add_Order extends MY_Salescontroller {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Customer_model');
            $this->load->model('Videos_model');
            $this->load->model('Pricelist_model');
            $this->load->model('Cart_model');
            $this->load->model('Products_model');
			$this->load->model('Orders_model');
			$this->load->library('sms');
            $dir_salesadmin=$this->folder_admin=$this->config->item('dir_salesadmin');
            $this->dir_salesadmin=$dir_salesadmin;
        }
		
        public function index(){
            $dir_salesadmin=$this->dir_salesadmin;     $usertype=$this->session->userdata('usertype');   
            $this->load->library('pagination');
                $ordercol=$this->input->get('col');
                $order=$this->input->get('order');
                if(!$ordercol){
                    $ordercol='id';
                }if(!$order){
                    $order='desc';
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
		$customers =$this->Customer_model->getFrCustomers($config["per_page"], $page,$ordercol,$order,$usertype,$franchiseid); 
		$this->data['customers']=  $customers;      
                $this->data['content']='add_order/index';
                $this->load->view('common/template',$this->data);
        }
     
	 
	 
	 public function orderlist(){
		 $usertype=$this->session->userdata('usertype');
        $dir_salesadmin=$this->dir_salesadmin;
		$franchiseid=$this->session->userdata('userid');
        $this->load->library('pagination');
                $ordercol=$this->input->get('col');
                $order=$this->input->get('order');
                if(!$ordercol){
                    $ordercol='id';
                }if(!$order){
                    $order='desc';
                }
                /***** pgination _categories***   */
                $total=$this->Orders_model->getAllOrdersCount($franchiseid);
				$this->data['total']=$total;
                $config = array();
                $config["base_url"] = base_url() . "admin/orders/index/";
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
                //null !== func()
                if(null !==$this->input->post('order_no')){
                    $order_no=$this->input->post('order_no');
                }else{
                    $order_no='';
                }
                if($order_no>0){
		$orders =$this->Orders_model->getsearchOrders($order_no,$franchiseid); 
                }else{
		$orders =$this->Orders_model->getOrders($config["per_page"], $page,$ordercol,$order,$franchiseid); 
                }
		$ord_status_array =$this->Orders_model->getOrders_status_array();
        $this->data['ord_status_array']= $ord_status_array;
		$this->data['orders']=  $orders;  
        $this->data['content']='add_order/orderlist';
        $this->load->view('common/template',$this->data);
        }
		
		public function examlist(){
		 $usertype=$this->session->userdata('usertype');
        $dir_salesadmin=$this->dir_salesadmin;
		$franchiseid=$this->session->userdata('userid');
        $this->load->library('pagination');
                $ordercol=$this->input->get('col');
                $order=$this->input->get('order');
                if(!$ordercol){
                    $ordercol='id';
                }if(!$order){
                    $order='desc';
                }
                /***** pgination _categories***   */
                $total=$this->Orders_model->getAllOrdersCount($franchiseid);
				$this->data['total']=$total;
                $config = array();
                $config["base_url"] = base_url() . "admin/orders/index/";
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
                //null !== func()
                if(null !==$this->input->post('user_id')){
                    $order_no=$this->input->post('order_no');
                }else{
                    $order_no='';
                }
                if($order_no>0){
		$orders =$this->Orders_model->getsearchOrders($order_no,$franchiseid); 
                }else{
		$orders =$this->Orders_model->getOrders($config["per_page"], $page,$ordercol,$order,$franchiseid); 
                }
		$this->data['content']='examtestlist';
        $this->load->view('common/template',$this->data);
			
		}
		public function orderview($orderid){
			$usertype=$this->session->userdata('usertype');
			$franchiseid=$this->session->userdata('userid');;
			$orderDetails=$this->Orders_model->getComplitorderDetails($orderid,$franchiseid);
			$customer=$this->Customer_model->getCustomerDetails($orderDetails[0]->user_id);
			$this->data['shipping_addresses']=$this->Customer_model->getShippingAddresses($orderDetails[0]->shipping_id);
			$this->data['orders_id']=$orderid;
			$this->data['orderDetails']=$orderDetails;
			$this->data['customer']=$customer; 
			$ord_status_array =$this->Orders_model->getOrders_status_array();
            $this->data['ord_status_array']= $ord_status_array;
			$this->data['orders_status_array']=$orderDetails;			
		$this->data['content']='add_order/orderview';
		$this->load->view('common/template',$this->data);	
		}
		
		
        
             public function order_status_edit(){
				 $dir_salesadmin=$this->dir_salesadmin;
                 $oId=$this->input->post('oId'); 
                 $customer_mobile=$this->input->post('customer_mobile'); 
                 $customer_email=$this->input->post('customer_email');  
                 $order_status =$this->input->post('order_status');
                 $order_status_data = array(
			     'status' => $order_status
		         );
                 
            $orders_status_array =$this->Orders_model->getOrders_status_array();  
              $text_order_status =strip_tags($orders_status_array[$order_status]->value);
		$this->Orders_model->update_order_status($oId,$order_status_data,$customer_email);
                $text_admin_email_main = $this->config->item('text_admin_email_main');
                $text_website_name = $this->config->item('text_website_name');
                $text_subject_for_order_email = $this->config->item('text_subject_for_order_email');  
                $text_message_order = 'Your Order Number '.$oId.' has been updated.Please login to studyadda.com';
                
               $text_message_order .= '<br>Please Note :- You can View/Download your product from <a href="'.base_url().'/customer" >My Account</a> Section.';
               
                        $text_message_order .= '<br><br>Regards,<br>Team Studyadda';
                        
                sendEmail($customer_email,$text_subject_for_order_email,$text_message_order,$text_admin_email_main);
                
                /*Send Sms*/
                if(($_SERVER['HTTP_HOST'] != 'www.studyadda.local')&&($customer_mobile!='')){
                
            $this->load->library('sms');
            $this->sms->send_sms($customer_mobile, 'your order No# '. $oId .' at STUDYADDA is Completed.Please Login to your account to access your products.You can View/Download your product from My Account Section.');
                
                }
                $this->session->set_flashdata('update_msg', 'Order Status updated!');
                redirect(base_url().$dir_salesadmin.'/Add_Order/orderview/'.$oId);
                
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
        
                redirect($dir_salesadmin."/add_order/index/");
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
        
        /********************************************************/
           public function edit($customer_id){
            $this->data['user_info'] = $this->Customer_model->getCustomerDetails($customer_id);
	    $default_address = $this->Customer_model->getDefaultAddress($customer_id);
            $this->data['user_info_default_address']=$default_address;
            if(isset($default_address->id)&&($default_address->id>0)){
            $this->data['user_info_address'] = $this->Customer_model->getAddresses($customer_id,$default_address->id);
            }else{
            $this->data['user_info_address']='';  
            }
            $this->data['content']='customers/edit';
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
		 $usertype=$this->session->userdata('usertype');
                $dir_salesadmin=$this->dir_salesadmin;  
                $franchiseid=$this->session->userdata('userid');
                $customer_id =$this->input->post('customer_id');
				$customer_mobile=$this->input->post('customer_mobile');
                $customer_email =$this->input->post('customer_email');
				$searchschool_id =$this->input->post('searchschool_id');
				$studentschool =$this->Customer_model->studentschool($franchiseid);
                $this->data['total']=1;
                $this->data['ordercol']='id';
                $config = array();
                $config["base_url"] = base_url() .$dir_salesadmin. "/add_order/index/";
                $customers =$this->Customer_model->getFrCustDetails_byparam($customer_id,$customer_email,$customer_mobile,$usertype,$franchiseid,$searchschool_id);  
                $this->data['studentschool']=  $studentschool;  
				$this->data['customers']=  $customers;      
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
