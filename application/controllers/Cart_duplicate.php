<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Customer_model','customers');
        $this->load->model('Cart_model');
        $this->load->library('sms');
    }
    public function index() {
        $this->load->model('Products_model');
        if($this->session->userdata('customer_id')){
            $defaultaddress = $this->Customer_model->getDefaultAddress($this->session->userdata('customer_id'));
            $this->data['default_address'] = $defaultaddress?$defaultaddress:null;
            $otheraddress=$this->Customer_model->getAddresses($this->session->userdata('customer_id'),$defaultaddress?$defaultaddress->id:0);
            
            if($otheraddress){
                $this->data['other_addresses']=$otheraddress;
            }
        }
        if(isset($this->data['default_address'])&&$this->data['default_address']==null){   $this->session->set_userdata('redirect_to_cart', '');
        //$this->session->set_userdata('redirect_to_cart', 'yes');
       // $this->session->set_flashdata('address_message', 'Please Add Shipping Address first to Place Order!');  
        }
        $this->data['content']='cart/cart';
        $this->load->view('template',$this->data);
    }
    public function confirm() {
        if(!$this->session->userdata('customer_id')){
            
        $this->session->set_userdata('redirecturl',base_url('cart/confirm'));
        redirect(base_url('login'));
        }
        $session_customer_id = $this->session->userdata('customer_id');
   
        $shipping_address_id_bysession =$this->Customer_model->getAddresses($session_customer_id);
        
        if($this->cart->total_items() == 0) redirect('/');
        $payment_mode = $this->input->post('paymentmethod');
        $shipping_address_id = $this->input->post('confirm_shipping_id');
        if(($shipping_address_id=='')||($shipping_address_id<1)){
            if($shipping_address_id_bysession){
            $shipping_address_id =$shipping_address_id_bysession[0]->id;
            }
        }
        
        
       $customer_info=  $this->Customer_model->getCustomerDetails($session_customer_id);
        if(!isset($shipping_address_id)){
            $this->session->set_userdata('redirect_to_cart', '');
              //$this->session->set_userdata('redirect_to_cart', 'yes');
            //$this->session->set_flashdata('message', 'Please Update Shipping Address first to Place Order!');
            //redirect('customer/addaddress');
            
        $dummy_address_array = array('customer_id' => $session_customer_id,
            'address_name' => $customer_info->firstname,
            'address' => '01,Forest Colony sivil line  ',
            'city' =>'1151',
            'city_name' =>'Dewas',
            'state' =>'22',
            'state_name' =>'Madhya Pradesh',
            'country_id'=>'1',
            'country_name'=>'INDIA',
            'zipcode'=>'455001',
            'is_default'=>'1',
            'mobile' => $customer_info->mobile);
      $shipping_address_id = $this->Customer_model->addAddress($dummy_address_array);        
      if($shipping_address_id<1||$shipping_address_id==''){
        $shipping_address_id=4;  
      }
      
        }
        $this->data['shipping_charges'] = 0;	
        $customer_cart = $this->Cart_model->getCustomerCart($this->session->userdata('customer_id'));
	$this->data['cart_in_db'] = $customer_cart;
        $this->data['shipping_id']=$shipping_address_id;
	$shipping_address = $this->Customer_model->getAddressDetail($shipping_address_id);
	$this->data['shipping_address'] = $shipping_address;
	$this->data['payment_mode'] = $payment_mode;
	
        /********************************************************************/
        $this->data['content']='cart/confirm';
        $this->session->unset_userdata('redirecturl');
        $this->load->view('template',$this->data);
    }
    public function process(){
        /********Hard * Coded * For * Now**************************************************/
	$payment_mode = $this->input->post('paymentmethod');
        /**********************************************************************************/
        $delivery_req  = $this->input->post('delivery_req');
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
        $shipping_address_id = $this->input->post('shipping_address_id');
	$user_id = $this->session->userdata('customer_id');
	$user_info = $this->Customer_model->getCustomerDetails($user_id);
	$cart_id = $this->input->post('cart_id');
        $agree_terms = $this->input->post('agree_terms');
        if(isset($agree_terms)&&$agree_terms=='yes'){
            $agree_terms_value='yes';
        }else{
            $agree_terms_value='no'; 
        }
        $mobile_number=$user_info->mobile;
	$cart_items = $this->Cart_model->getCartItems($cart_id);
   
        if(($user_id=='')||($user_id<1)){
        $this->session->set_flashdata('message', 'You has been logout.Please login again!');
        redirect(base_url('login'));
        }
        
        if((count($cart_items)=='')||(count($cart_items)<1)){
        $this->session->set_flashdata('message', 'Your cart is empty.Please Add product in the cart.');
        redirect(base_url('cart'));
        }
        
        //echo count($cart_items).'------';die;
             
        // check if added item is exist in cmspricelist table 
        $cartinfo = $this->Cart_model->getCustomerCart($user_id);
        $cart_items = $this->Cart_model->getCartItems($cartinfo->id);
        
        foreach ($cart_items as $items){
           $itemid = $items->product_id;
           
          $pricelist_count = $this->Cart_model->getpriclistItems($itemid);
          if(($pricelist_count=='')||($pricelist_count<1)){
            $this->session->set_flashdata('message', 'There is some problem in product you have added to cart.Please delete some product and try again.');
        //redirect(base_url('cart'));  
          }
          
        }
        $this->session->set_userdata('cart_id',$cart_id);                
        $order=$this->Customer_model->addOrder($user_id,$payment_mode,$final_amount,$shipping_charges,$cod_charges,$shipping_address_id,$agree_terms_value);
        $order_id=$order['order_id'];
        $order_no=$order['order_no'];
        // Check if payment option is online 
        /*1 For cash on delevery, 2 For CCAvenue, 3 For Paytm*/
        
        
        if($payment_mode==3){
         $this->session->set_flashdata('message', 'Paytm is not activated now.Please select Online Payment option now.');
         redirect('/cart'); die;
            $this->load->helper('paytm_helper'); 
            $paytm=$this->config->item('paytm');
            $checkSum = "";
            $paramList = array();
            // Create an array having all required parameters for creating checksum.
            $paramList["MID"] = $paytm['PAYTM_MERCHANT_MID'];
            $paramList["ORDER_ID"] = $order_no;
            $paramList["CUST_ID"] = $user_id;
            $paramList["INDUSTRY_TYPE_ID"] = 'Retail';//$INDUSTRY_TYPE_ID;
            $paramList["CHANNEL_ID"] = 'WEB';//$CHANNEL_ID;
            $paramList["TXN_AMOUNT"] = $final_amount;
            $paramList["WEBSITE"] = $paytm['PAYTM_MERCHANT_WEBSITE'];
            $checkSum = getChecksumFromArray($paramList,$paytm['PAYTM_MERCHANT_KEY']);
            $paramList["CHECKSUMHASH"]=$checkSum;
            $data["PAYTM_TXN_URL"]=$paytm['PAYTM_TXN_URL'];
            $data["parameters"]=$paramList;
            $this->load->view('cart/processpaytm',$data);
        }elseif($payment_mode==2){
            //CCAVENUE
            $shipping_address=  $this->Customer_model->getAddressDetail($shipping_address_id);            
            $this->config->load('ccavenue');
            $this->load->helper('ccavenue');
            $user=$this->Customer_model->getCustomerDetails($user_id);
            $this->data['action']=$this->config->item('action');
            $workingkey=$this->config->item('workingkey');
            $checksum = getCheckSum($this->config->item('Merchant_Id'),$final_amount,$order_no ,$this->config->item('Redirect_Url'),$workingkey);
            $form_array=array('Merchant_Id'=>$this->config->item('Merchant_Id'),
                            'Redirect_Url'=>$this->config->item('Redirect_Url'),
                            'Amount'=>$final_amount,
                            'Order_Id'=>$order_no,
                            'Checksum'=>$checksum,
                            'billing_cust_name'=>$shipping_address->address_name,
                            'billing_cust_address'=>$shipping_address->address.' '.$shipping_address->address2,
                            'billing_cust_country'=>'INDIA',
                            'billing_cust_state'=>$shipping_address->state_name,
                            'billing_cust_tel'=>$user->mobile,
                            'billing_cust_email'=>$user->email,
                            'delivery_cust_name'=>$shipping_address->address_name,
                            'delivery_cust_address'=>$shipping_address->address.' '.$shipping_address->address2,
                            'delivery_cust_country'=>'INDIA',
                            'delivery_cust_state'=>$shipping_address->state_name,
                            'delivery_cust_tel'=>$user->mobile,
                            'delivery_cust_notes'=>'',
                            'Merchant_Param'=>$user_id.'_'.$order_id,
                            'billing_cust_city'=>$shipping_address->city_name,
                            'billing_zip_code'=>$shipping_address->zipcode,
                            'delivery_cust_city'=>$shipping_address->city_name,
                            'delivery_zip_code'=>$shipping_address->zipcode);
            $this->data['parameters']=$form_array;
            
            $this->load->view('cart/processpayment',$this->data);
        }elseif($payment_mode==1){
                    //COD
         if($this->session->userdata('customer_id')!='71696'){
             //COD Activate for one testing account only
             $this->session->set_flashdata('message', 'This method is not activated now.Please select Online Payment option now.');
         redirect('/cart'); die;
         }               
            foreach ($this->cart->contents() as $item){
                //$this->Products_model->updateQuantity($item['id'],$item['qty']);
            }            
            $this->Customer_model->ediCod_Orderstatus($order_id);
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
            redirect('/customer');
        }else{
            
         $this->session->set_flashdata('message', 'Please Select Atleast One Payment Method.');
         redirect('/cart');   
        }
    }
    public function response(){
        $this->config->load('ccavenue');
        $this->load->helper('ccavenue');
        //$this->load->model('Transactions_model');
	$user_id = $this->session->userdata('customer_id');
	$user_info = $this->Customer_model->getCustomerDetails($user_id);
        
	$mobile_number = $user_info->mobile;
        $txn_number=0;
	if($this->input->post('AuthDesc')){
            $checksum=$this->input->post('Checksum');
            $authstatus=$this->input->post('AuthDesc');
            $order_no=$this->input->post('Order_Id');
            $userorder=$this->input->post('Merchant_Param');
            $userorder_array=explode('_',$userorder);
            $order_id=$userorder_array[1];
            $amount=$this->input->post('Amount');
            $cart_id = $this->session->userdata('cart_id');
            $workingkey=$this->config->item('workingkey');
            $merchant_id=$this->config->item('Merchant_Id');
            $verifyChecksum = verifyChecksum($merchant_id,$order_no,$amount,$authstatus,$checksum,$workingkey);
            if($verifyChecksum== "true" && ($authstatus=='Y' || $authstatus =='B')){  		// Success - Successful Transaction 
                if($authstatus=='Y'){ $payment=1;                     
            $this->sms->send_sms($mobile_number, 'your order No# '. $order_no .' at STUDYADDA is Completed.Please Login to your account to access your products.You can View/Download your product from My Account Section.');
                }
                if($authstatus=='B'){$payment=0;}
               $order = $this->Customer_model->updateOrder($order_id,$order_no,1,$txn_number,$payment);
                
                $this->Cart_model->removeCart($cart_id,$user_id);
                $this->cart->destroy();
		// @TO-DO : Send email to user for payment recieved for order submitted
		$message = 'Dear Sir/Madam,'.'<br>'.'Your Transaction Was Successfull, Below is your order number for further references.'.'<br>'.'Studyadda.com'.'<br>'.'Your Order Number is'.'&nbsp;'.$order_no.'.<br>You can find video link or PDF link in <a href="'.base_url().'customer">My Account Dashboard</a> Section.We recommend that Please check studyadda My Account dashboard after Payment.We can activate the download link only after payment is successful and Order Status is completed.'.'<br><br>Thanks,<br>Team Studyadda';
		$subject = 'Order Confirmation';
		$to = $user_info->email;
		//$sms_message = "Your order has been placed successfully.Your order number is".$order_no;
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
		// @TO-DO : Send email to admin for payment recieved for order submitted
		// @TO-DO : Update order table and deduct the quantity for inventory
                $this->session->set_flashdata('update_msg','Order #'.$order_no.' placed successfully.');
                //$this->Transactions_model->add($data);
                //redirect('/customer/orderdetails/'.$order_id);
                
                redirect('/customer');
                
            }elseif($authstatus	=='N'){ 	//0399 - Invalid Authentication at Bank - Cancel Transaction
                $this->Customer_model->cancelOrder($order_id,$order_no,0,$txn_number);
                //$this->Cart_model->removeCart($cart_id,$user_id);
		//$this->cart->destroy();
		$message = 'Dear Sir/Madam,'.'<br>'.'Your order#'.$order_no.' was not processed because of failed transaction.<br><br>Thanks,<br>Team Studyadda ';
		$subject = 'Order failure';
		$to = $user_info->email;
		$mobile_number = $user_info->mobile;
		$sms_message = 'Your order#'.$order_no.' was not processed because of failed transaction';
		//send email
		sendEmail($to,$subject,$message);
		//$this->load->library('sms');
		//$this->sms->send_sms($mobile_number,$sms_message);
                $this->session->set_flashdata('update_msg','Paymet for Order #'.$order_no.' failed.');
                //$this->Transactions_model->add($data);
                redirect('/customer');
				
            }
	}
    }
}

