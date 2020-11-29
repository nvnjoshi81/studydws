<?php 
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Customer_model','customers');
        $this->load->model('Cart_model');
        $this->load->library('sms');
		
	$this->data['boltpayu'] = 'yes';
		
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
        if(isset($this->data['default_address'])&&$this->data['default_address']==null){   
			$this->session->set_userdata('redirect_to_cart', '');
        //$this->session->set_userdata('redirect_to_cart', 'yes');
       // $this->session->set_flashdata('address_message', 'Please Add Shipping Address first to Place Order!');  
        }
        $this->data['content']='cart/cart';
        $this->load->view('template',$this->data);
    }
		
    public function buynow() {
		
		  $customer_cart = $this->Cart_model->getCustomerCart($this->session->userdata('customer_id'));
	$this->data['cart_in_db'] = $customer_cart;
	      $this->load->model('Products_model');
        if($this->session->userdata('customer_id')){
            $defaultaddress = $this->Customer_model->getDefaultAddress($this->session->userdata('customer_id'));
            $this->data['default_address'] = $defaultaddress?$defaultaddress:null;
            $otheraddress=$this->Customer_model->getAddresses($this->session->userdata('customer_id'),$defaultaddress?$defaultaddress->id:0);
            
            if($otheraddress){
                $this->data['other_addresses']=$otheraddress;
            }
        }
        if(isset($this->data['default_address'])&&$this->data['default_address']==null){   
			$this->session->set_userdata('redirect_to_cart', '');
        //$this->session->set_userdata('redirect_to_cart', 'yes');
       // $this->session->set_flashdata('address_message', 'Please Add Shipping Address first to Place Order!');  
        }
        $this->data['content']='cart/cart';
        $this->load->view('template',$this->data);
	}
	
	
    public function confirm() { 
	$session_customer_id = $this->session->userdata('customer_id');
		if(isset($session_customer_id)&&$session_customer_id>0){
		   $session_customer_id = $this->session->userdata('customer_id');	
		}else{
        $this->session->set_userdata('redirecturl',base_url('cart/confirm'));		
        redirect(base_url('login'));
		$session_customer_id=0;
        }
        
   
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
            'address' => '01,Forest Colony sivil line',
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
	  $shipping_charges=0;
	  $cod_charges=0;
	  $agree_terms_value='yes';
	    $this->data['shipping_charges'] = $shipping_charges;	
        $customer_cart = $this->Cart_model->getCustomerCart($this->session->userdata('customer_id'));
	$this->data['cart_in_db'] = $customer_cart;
    $this->data['shipping_id']=$shipping_address_id;
	
	$shipping_address = $this->Customer_model->getAddressDetail($shipping_address_id);
	$this->data['shipping_address'] = $shipping_address;
	   $payment_mode_three = $this->input->post('onlyccpayu'); 
	   $datamobile=$customer_info->mobile; 
	$this->data['mobile'] = $datamobile;

//For  Bolt payment payumoney

	/********************************************************************/
	if(isset($payment_mode_three)&&$payment_mode_three=='4'){		
	$this->data['payment_mode'] = $payment_mode_three;
	/*hash geration payu*/
      $cart_id = $customer_cart->id;
	$dataamount=$this->cart->total();
	  $order=$this->Customer_model->addOrder($session_customer_id,$payment_mode_three,$dataamount,$shipping_charges,$cod_charges,$shipping_address_id,$agree_terms_value);
      $order_id=$order['order_id'];
      $order_no=$order['order_no'];
	$datakey='x6QXVRnC';	
	$datatxnid=$order_id;
	$datapinfo=$cart_id;
	$datafname=$customer_info->firstname;
	$dataemail=$customer_info->email;
	$dataudf5='BOLT_KIT_PHP7';
	$datasalt='iOtJ1bviwf';
	
	$hashpayu=hash('sha512', $datakey.'|'.$datatxnid.'|'.$dataamount.'|'.$datapinfo.'|'.$datafname.'|'.$dataemail.'|||||'.$dataudf5.'||||||'.$datasalt);
	
	
	/*End hash gen*/
	
	$this->data['hash'] = $hashpayu;
	$this->data['key'] = $datakey;
	
	$this->data['txnid'] = $order_id;
	$this->data['amount'] = $dataamount;
	$this->data['pinfo'] = $datapinfo;
	$this->data['fname'] = $datafname;
	$this->data['email'] = $dataemail;
	
	$this->data['salt'] = $datasalt;
	$this->data['order_no']=$order_no;
	$this->data['udf5']=$dataudf5;
	$this->data['cart_id']=$cart_id;
	
		$this->data['agree_terms'] = $agree_terms_value;
	
        $this->data['content']='cart/confirm_pay';
        $this->session->unset_userdata('redirecturl');
        $this->load->view('template',$this->data);
	}else{
		
	$this->data['payment_mode'] = $payment_mode;
        $this->data['content']='cart/confirm';
        $this->session->unset_userdata('redirecturl');
        $this->load->view('template',$this->data);
	}
    }
    
    public function app_process($cart_total,$shipping_address_id,$customer_id,$agree_terms='yes'){
    $payment_mode = 2;
    /******************************************************************************/
        $final_amount_post = $cart_total;   
        $shipping_address_id = $shipping_address_id;
	$shipping_charges_post = 0;
	$user_id = $customer_id;
        $agree_terms = $agree_terms;
        if(($user_id=='')||($user_id<1)){
        die('You has been logout.Please login again!');
        }
	if(isset($shipping_charges_post)&&$shipping_charges_post>0){
        $shipping_charges=abs($shipping_charges_post);
        $final_amount_post=abs($final_amount_post);
        $final_amount=$final_amount_post+$shipping_charges;
        }else{
            $shipping_charges=0;
            $final_amount=abs($final_amount_post);
        }
	$cod_charges = 0;//$this->input->post('cod_charges');
        $user_info = $this->Customer_model->getCustomerDetails($user_id);
        /*Start Get Shipping Info*/
        if(!isset($shipping_address_id)){
        $dummy_address_array = array('customer_id' => $user_id,
            'address_name' => $user_info->firstname,
            'address' => '01,Forest Colony sivil line  ',
            'city' =>'1151',
            'city_name' =>'Dewas',
            'state' =>'22',
            'state_name' =>'Madhya Pradesh',
            'country_id'=>'1',
            'country_name'=>'INDIA',
            'zipcode'=>'455001',
            'is_default'=>'1',
            'mobile' => $user_info->mobile);
      $shipping_address_id = $this->Customer_model->addAddress($dummy_address_array);        
      if($shipping_address_id<1||$shipping_address_id==''){
        $shipping_address_id=4;  
      }
      
      }
      $customer_cart = $this->Cart_model->getCustomerCart($user_id);
      $cart_id = $customer_cart->id;
      $cart_price=$customer_cart->cart_price;
	  if($cart_price!=$final_amount){
          ?><a href='<?php echo base_url("cart"); ?>' >Go To Cart</a><br>
          <?php
          die('Your total price does not match with your shopping cart price.Please empty your cart and purchase again.');
      }
        /*End Get Shipping Info*/
        if(isset($agree_terms)&&$agree_terms=='yes'){
            $agree_terms_value='yes';
        }else{
            $agree_terms_value='no'; 
        }
        $mobile_number=$user_info->mobile;
	$cart_items = $this->Cart_model->getCartItems($cart_id);
   if((count($cart_items)=='')||(count($cart_items)<1)){
        die('Your cart is empty.Please Add product in the cart.');
        }
        
             
        // check if added item is exist in cmspricelist table 
        $cartinfo = $this->Cart_model->getCustomerCart($user_id);
        $cart_items = $this->Cart_model->getCartItems($cartinfo->id);
       
        foreach ($cart_items as $items){
          $itemid = $items->product_id;
          $pricelist_count = $this->Cart_model->appgetpriclistItems($itemid);
          if(($pricelist_count=='')||($pricelist_count<1)){
            die('There is some problem in product you have added to cart.Please delete some product and try again.');  
          }
          
        }
        // Check if payment option is online 
        /*1 For cash on delevery, 2 For CCAvenue, 3 For Paytm*/       
        if($payment_mode==2){
            //ccavenue                
        $order=$this->Customer_model->addOrder($user_id,$payment_mode,$final_amount,$shipping_charges,$cod_charges,$shipping_address_id,$agree_terms_value);
        $order_id=$order['order_id'];
        $order_no=$order['order_no'];
            //CCAVENUE
            $shipping_address=  $this->Customer_model->getAddressDetail($shipping_address_id);            
            $this->config->load('ccavenue');
            $this->load->helper('ccavenue');
            $user=$this->Customer_model->getCustomerDetails($user_id);
            $this->data['action']=$this->config->item('action');
            $workingkey=$this->config->item('workingkey');
            $merchant_id=$this->config->item('Merchant_Id');
            $checksum = getCheckSum($merchant_id,$final_amount,$order_no ,$this->config->item('Redirect_Url'),$workingkey);
$url=$this->config->item('Redirect_Url'); 
$billing_cust_name=$shipping_address->address_name;
$billing_cust_address=$shipping_address->address.' '.$shipping_address->address2;
$billing_cust_country='INDIA';
$billing_cust_state=$shipping_address->state_name;
$billing_city=$shipping_address->city_name;
$billing_zip=$shipping_address->zipcode;
$billing_cust_tel=$user->mobile;
$billing_cust_email=$user->email;
$delivery_cust_name=$shipping_address->address_name;
$delivery_cust_address=$shipping_address->address.' '.$shipping_address->address2;
$delivery_cust_country='INDIA';
$delivery_cust_state=$shipping_address->state_name;
$delivery_city=$shipping_address->city_name;
$delivery_zip=$shipping_address->zipcode;
$delivery_cust_tel=$user->mobile;
$delivery_cust_notes='';
            
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
            $this->data['merchant_parameters']=$merchant_id;
            $this->data['final_amount']=$final_amount;
            $this->data['order_no']=$order_no;
            
            $this->load->view('cart/processpayment',$this->data);
        }else{
         die('Please Select Atleast One Payment Method.');   
        }
    }
    
    public function process(){
/**Hard * Coded * For * Now*************************** ***********************/
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
        // Check if payment option is online 
        /*1 For cash on delevery, 2 For CCAvenue, 3 For Paytm, 4 for payyoumoney*/  
        if($payment_mode==3){
            //paytm
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
        }elseif($payment_mode==4){
			/*PayuMoney start*/
			$postdata = $_POST;
$msg = '';
if (isset($postdata ['key'])) {
	$key				=   $postdata['key'];
	$salt				=   $postdata['salt'];
	$txnid 				= 	$postdata['txnid'];
	$order_no 			= 	$postdata['order_no'];
	$amount      		= 	$postdata['amount'];
	$productInfo  		= 	$postdata['productinfo'];
	$firstname    		= 	$postdata['firstname'];
	$email        		=	$postdata['email'];
	$udf5				=   $postdata['udf5'];
	$mihpayid			=	$postdata['mihpayid'];
	$status				= 	$postdata['status'];
	$resphash				= 	$postdata['hash'];
	//Calculate response hash to verify	
	$keyString 	  		=  	$key.'|'.$txnid.'|'.$amount.'|'.$productInfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'|||||';
	$keyArray 	  		= 	explode("|",$keyString);
	$reverseKeyArray 	= 	array_reverse($keyArray);
	$reverseKeyString	=	implode("|",$reverseKeyArray);
	$CalcHashString 	= 	strtolower(hash('sha512', $salt.'|'.$status.'|'.$reverseKeyString));
	
	
	if ($status == 'success'  && $resphash == $CalcHashString) {
		$msg = "Transaction Successful and Hash Verified...";
		//Do success order processing here...
		
		//order status Coplete/success
	$orderstatus=1;
	
	$paymentstatus=1;
	}
	else {
		//tampered or failed
		$msg = "Payment failed for Hash not verified...";
		//order status cancelled
	$orderstatus=2;
	$paymentstatus=0;
	} 
	$order_id=$txnid;	
	$order_no=$order_no;
	$order_no=$order_no;
	$txn_number=$mihpayid;
	$order = $this->Customer_model->updateOrder($order_id,$order_no,$paymentstatus,$txn_number,$orderstatus);
                $this->Cart_model->removeCart($cart_id,$user_id);
                $this->cart->destroy();
	     
         $this->session->set_flashdata('message', $msg);
         redirect('/cart');   
}
			/*PayuMoney End*/
		}elseif($payment_mode==2){
			/*CCAvenue for web start*/
        $this->session->set_userdata('cart_id',$cart_id);                
        $order=$this->Customer_model->addOrder($user_id,$payment_mode,$final_amount,$shipping_charges,$cod_charges,$shipping_address_id,$agree_terms_value);
        $order_id=$order['order_id'];
        $order_no=$order['order_no'];
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
			  $loginFranId = $this->session->userdata('loginFranId');
                    //COD
					if($loginFranId>0){
						//need to add message
					}else{
         if($this->session->userdata('customer_id')!='71696'){
             //COD Activate for one testing account only
             $this->session->set_flashdata('message', 'This method is not activated now.Please select Online Payment option now.');
         redirect('/cart'); die;
         }
					}
         
         
        $this->session->set_userdata('cart_id',$cart_id);                
        $order=$this->Customer_model->addOrder($user_id,$payment_mode,$final_amount,$shipping_charges,$cod_charges,$shipping_address_id,$agree_terms_value);
        $order_id=$order['order_id'];
        $order_no=$order['order_no'];
            foreach ($this->cart->contents() as $item){
                //$this->Products_model->updateQuantity($item['id'],$item['qty']);
            }            
            $this->Customer_model->ediCod_Orderstatus($order_id,1);
            // @TO-DO : add payment mode condition and execute following code for cod.
            $this->Cart_model->removeCart($cart_id,$user_id);
            $this->cart->destroy();
            
            
             $this->sms->send_sms($mobile_number, 'your order No# '. $order_no .' at STUDYADDA is Completed.Please Login to your account to access your products.You can View/Download your product from My Account Section.'); 
             $message = 'Dear Sir/Madam,'.'<br>'.'Your Order Was Successfull, Below is your order number for further references.'.'<br>'.'Your Order Number is'.'&nbsp;'.$order_no.'<br>For Technical Support<br>06267349244';
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
  $message .= '<br>Thanks,<br>Team Studyadda';
            //send email
            sendEmail($to,$subject,$message);
            //$this->sms->send_sms($mobile_number,$sms_message);   
            
            $this->session->set_flashdata('update_msg','Your order has been placed successfully');
            redirect('/user/orders');
        }else{
            
         $this->session->set_flashdata('message', 'Please Select Atleast One Payment Method.');
         redirect('/cart');   
        }
    }
	
	public function response(){ 
	//error_reporting(1); error_reporting(E_ALL);
        
		ob_start();
		
		?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=AW-634245748">
		
		  </script>
		  
		  <script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-40859911-1', 'studyadda.com');
ga('send', 'pageview');
	ga('require', 'ecommerce');		
		</script>
		<?php
        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        $this->config->load('ccavenue');
        $this->load->helper('ccavenue');
        //$this->load->model('Transactions_model');
            $userorder=$this->input->post('Merchant_Param');
            if(isset($userorder)){
            $userorder_array=explode('_',$userorder);
            }else{
            $userorder_array=NULL;   
            }
            if(isset($userorder_array[0])){
            $user_id=$userorder_array[0];
            }else{
	$user_id = $this->session->userdata('customer_id');
            }
            $user_info = $this->Customer_model->getCustomerDetails($user_id);
        $mobile_number = $user_info->mobile;
        $txn_number=0;
	if($this->input->post('AuthDesc')){
            $checksum=$this->input->post('Checksum');
            $authstatus=$this->input->post('AuthDesc');
            $order_no=$this->input->post('Order_Id');
            $order_id=$userorder_array[1];
            $amount=$this->input->post('Amount');
            $cart_id = $this->session->userdata('cart_id');
            $workingkey=$this->config->item('workingkey');
            $merchant_id=$this->config->item('Merchant_Id');
            $verifyChecksum = verifyChecksum($merchant_id,$order_no,$amount,$authstatus,$checksum,$workingkey);
            //$verifyChecksum== "true" && 
            if(($authstatus=='Y' || $authstatus =='B')){  		// Success - Successful Transaction 
                if($authstatus=='Y'){ $payment=1;                     
            $this->sms->send_sms($mobile_number, 'your order No# '. $order_no .' at STUDYADDA is Completed.Please Login to your account to access your products.You can View/Download your product from My Account Section.');
                }
                if($authstatus=='B'){$payment=0;}
               $order = $this->Customer_model->updateOrder($order_id,$order_no,1,$txn_number,$payment);
                $this->Cart_model->removeCart($cart_id,$user_id);
                $this->cart->destroy();
		// @TO-DO : Send email to user for payment recieved for order submitted
		$message = 'Dear Sir/Madam,'.'<br>'.'Your Transaction Was Successfull, Below is your order number for further references.'.'<br>'.'Studyadda.com'.'<br>'.'Your Order Number is'.'&nbsp;'.$order_no.'.<br>You can find video link or PDF link in <a href="'.base_url().'customer">My Account Dashboard</a> Section.We recommend that Please check studyadda My Account dashboard after Payment.We can activate the download link only after payment is successful and Order Status is completed.'.'<br><br>Thanks,<br>Team Studyadda<br>Technical Support<br>06267349244';
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
				?>
				<script>
ga('ecommerce:addItem', {
  'id': '<?php echo $order_no; ?>',                     // Transaction ID. Required.
  'name': '<?php echo $order['order_details_array'][$i]->modules_item_name; ?>',    // Product name. Required.
  'sku': '<?php echo $order['order_details_array'][$i]->product_id; ?>',                 // SKU/code.
  'category': 'OnlineMaterials',         // Category or variation.
  'price': <?php echo $order['order_details_array'][$i]->price; ?>,                 // Unit price.
  'quantity': 1                   // Quantity.
});
</script>
<?php
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
 
$msg='';
$break_host_array=substr($_SERVER['HTTP_HOST'],-3);
if($break_host_array=='cal'){ 
$msg='Mail Not Sent.';     
}else{
$msg='Mail Sent.';		//send email
sendEmail($to,$subject,$message);
}
		//$this->sms->send_sms($mobile_number,$sms_message);
		// @TO-DO : Send email to admin for payment recieved for order submitted
		// @TO-DO : Update order table and deduct the quantity for inventory
                $this->session->set_flashdata('update_msg','Order #'.$order_no.' placed successfully.');
                //$this->Transactions_model->add($data);
                //redirect('/customer/orderdetails/'.$order_id);
                
                //redirect('/customer');
                ?>
                <a href='<?php echo base_url("user/orders"); ?>' ><button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist">Click Here To Continue</button></a>
				<!-- Footer section-->
<?php
 /*Google Code for save transection*/
 
    if($payment==1){
		?>
		<!--Google Code-->
<!-- Global site tag (gtag.js) - Google Ads: 634245748 -->
<script>
			
ga('ecommerce:addTransaction', {
  'id': '<?php echo $order_no; ?>',                     // Transaction ID. Required.
  'affiliation': 'Studyadda',   // Affiliation or store name.
  'revenue': <?php echo $order['final_amount']; ?>,               // Grand Total.
  'shipping': '0',                  // Shipping.
  'tax': '0'                     // Tax.
});
ga('ecommerce:send');
</script>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'AW-634245748');
</script>

<!--End-->
		
<!-- Event snippet for Purchase conversion page -->
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-634245748/tbQiCOH76dABEPSkt64C',
      'value': <?php echo $order['final_amount']; ?>,
      'currency': 'INR',
      'transaction_id': ''
  });
</script>
<?php
		   }
  /*End for google transection*/  				
					
				
 sleep(5) ;
                //$this->data['status']='success';                           
                //$this->load->view('cart/appsuccess',$this->data); 
if($_SERVER['HTTP_X_REQUESTED_WITH']== 'com.studyaddaapp') {
    // && stripos($ua,'mobile') !== false) {
	header('Location:'.base_url("cart/appsuccess"));
	exit();
}
                
            }elseif($authstatus	=='N'){ 	//0399 - Invalid Authentication at Bank - Cancel Transaction
                $this->Customer_model->cancelOrder($order_id,$order_no,0,$txn_number);
                //$this->Cart_model->removeCart($cart_id,$user_id);
		//$this->cart->destroy();
		$message = 'Dear Sir/Madam,'.'<br>'.'Your order#'.$order_no.' was not processed because of failed transaction.<br><br>Thanks,<br>Team Studyadda<br>Technical Support<br>06267349244 ';
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
                //redirect('/customer');
				?><a href='<?php echo base_url("user/orders"); ?>' ><button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist">Click Here To Go To Studyadda.com</button></a>
				<?php      
                                if($_SERVER['HTTP_X_REQUESTED_WITH']== 'com.studyaddaapp') { // && stripos($ua,'mobile') !== false) {
                                    redirect('/cart/appfailed');
}
				
            } 
           //    $this->session->set_flashdata('update_msg','There is some technical issue.Please try again.');
            ?>
           
                <?php 
              
       
            
        }else{
             $this->session->set_flashdata('message', 'Please check your order status or contact info@studyadda.com.');
         redirect('/cart'); 
        }
    }
    
    public function appsuccess(){
 $this->data['status']='success';                           
                $this->load->view('cart/appsuccess',$this->data); 
}
 public function appfailed(){             
 $this->data['status']='success';                           
                $this->load->view('cart/appfailed',$this->data); 
   }
 public function std_appfailed(){             
 $this->data['status']='success';                           
                $this->load->view('cart/std_appfailed',$this->data); 
   }
   public function  std_appsuccess(){
 $this->data['status']='success';                           
                $this->load->view('cart/std_appsuccess',$this->data); 
}

   
   public function std_app_process($cart_total,$shipping_address_id,$customer_id,$agree_terms='yes'){
    $payment_mode = 2;
    /******************************************************************************/
        $final_amount_post = $cart_total;   
        $shipping_address_id = $shipping_address_id;
	$shipping_charges_post = 0;
	$user_id = $customer_id;
        $agree_terms = $agree_terms;
        if(($user_id=='')||($user_id<1)){
        die('You has been logout.Please login again!');
        }
	if(isset($shipping_charges_post)&&$shipping_charges_post>0){
        $shipping_charges=abs($shipping_charges_post);
        $final_amount_post=abs($final_amount_post);
        $final_amount=$final_amount_post+$shipping_charges;
        }else{
            $shipping_charges=0;
            $final_amount=abs($final_amount_post);
        }
	$cod_charges = 0;//$this->input->post('cod_charges');
        $user_info = $this->Customer_model->getCustomerDetails($user_id);
        /*Start Get Shipping Info*/
        if(!isset($shipping_address_id)){
        $dummy_address_array = array('customer_id' => $user_id,
            'address_name' => $user_info->firstname,
            'address' => '01,Forest Colony sivil line  ',
            'city' =>'1151',
            'city_name' =>'Dewas',
            'state' =>'22',
            'state_name' =>'Madhya Pradesh',
            'country_id'=>'1',
            'country_name'=>'INDIA',
            'zipcode'=>'455001',
            'is_default'=>'1',
            'mobile' => $user_info->mobile);
      $shipping_address_id = $this->Customer_model->addAddress($dummy_address_array);        
      if($shipping_address_id<1||$shipping_address_id==''){
        $shipping_address_id=4;  
      }
      
      }
      $customer_cart = $this->Cart_model->getCustomerCart($user_id);
      $cart_id = $customer_cart->id;
      $cart_price=$customer_cart->cart_price;
	  if($cart_price!=$final_amount){
          ?><a href='<?php echo base_url("cart"); ?>' >Go To Cart</a><br>
          <?php
          die('Your total price does not match with your shopping cart price.Please empty your cart and purchase again.');
      }
        /*End Get Shipping Info*/
        if(isset($agree_terms)&&$agree_terms=='yes'){
            $agree_terms_value='yes';
        }else{
            $agree_terms_value='no'; 
        }
        $mobile_number=$user_info->mobile;
	$cart_items = $this->Cart_model->getCartItems($cart_id);
   if((count($cart_items)=='')||(count($cart_items)<1)){
        die('Your cart is empty.Please Add product in the cart.');
        }
        
             
        // check if added item is exist in cmspricelist table 
        $cartinfo = $this->Cart_model->getCustomerCart($user_id);
        $cart_items = $this->Cart_model->getCartItems($cartinfo->id);
       
        foreach ($cart_items as $items){
           $itemid = $items->product_id;
           
          $pricelist_count = $this->Cart_model->appgetpriclistItems($itemid);
          if(($pricelist_count=='')||($pricelist_count<1)){
            die('There is some problem in product you have added to cart.Please delete some product and try again.');  
          }
          
        }
        // Check if payment option is online 
        /*1 For cash on delevery, 2 For CCAvenue, 3 For Paytm*/       
        if($payment_mode==2){
            //ccavenue                
        $order=$this->Customer_model->addOrder($user_id,$payment_mode,$final_amount,$shipping_charges,$cod_charges,$shipping_address_id,$agree_terms_value);
        $order_id=$order['order_id'];
        $order_no=$order['order_no'];
            //CCAVENUE
            $shipping_address=  $this->Customer_model->getAddressDetail($shipping_address_id);            
            $this->config->load('std_ccavenue');
            $this->load->helper('std_ccavenue');
            $user=$this->Customer_model->getCustomerDetails($user_id);
            $this->data['action']=$this->config->item('action');
            $workingkey=$this->config->item('workingkey');
            $merchant_id=$this->config->item('Merchant_Id');
            $checksum = getCheckSum($merchant_id,$final_amount,$order_no ,$this->config->item('Redirect_Url'),$workingkey);
$url=$this->config->item('Redirect_Url'); 
$billing_cust_name=$shipping_address->address_name;
$billing_cust_address=$shipping_address->address.' '.$shipping_address->address2;
$billing_cust_country='INDIA';
$billing_cust_state=$shipping_address->state_name;
$billing_city=$shipping_address->city_name;
$billing_zip=$shipping_address->zipcode;
$billing_cust_tel=$user->mobile;
$billing_cust_email=$user->email;
$delivery_cust_name=$shipping_address->address_name;
$delivery_cust_address=$shipping_address->address.' '.$shipping_address->address2;
$delivery_cust_country='INDIA';
$delivery_cust_state=$shipping_address->state_name;
$delivery_city=$shipping_address->city_name;
$delivery_zip=$shipping_address->zipcode;
$delivery_cust_tel=$user->mobile;
$delivery_cust_notes='';
            
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
            $this->data['merchant_parameters']=$merchant_id;
            $this->data['final_amount']=$final_amount;
            $this->data['order_no']=$order_no;
            
            $this->load->view('cart/processpayment',$this->data);
        }else{
         die('Please Select Atleast One Payment Method.');   
        }
    }
	
	public function std_response(){ //error_reporting(1); error_reporting(E_ALL);
        ob_start();		
        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        $this->config->load('std_ccavenue');
        $this->load->helper('std_ccavenue');
        //$this->load->model('Transactions_model');
            $userorder=$this->input->post('Merchant_Param');
            if(isset($userorder)){
            $userorder_array=explode('_',$userorder);
            }else{
            $userorder_array=NULL;   
            }
            if(isset($userorder_array[0])){
            $user_id=$userorder_array[0];
            }else{
	$user_id = $this->session->userdata('customer_id');
            }
            $user_info = $this->Customer_model->getCustomerDetails($user_id);
        $mobile_number = $user_info->mobile;
        $txn_number=0;
	if($this->input->post('AuthDesc')){
            $checksum=$this->input->post('Checksum');
            $authstatus=$this->input->post('AuthDesc');
            $order_no=$this->input->post('Order_Id');
            $order_id=$userorder_array[1];
            $amount=$this->input->post('Amount');
            $cart_id = $this->session->userdata('cart_id');
            echo $workingkey=$this->config->item('workingkey');
            echo $merchant_id=$this->config->item('Merchant_Id'); die;
            $verifyChecksum = verifyChecksum($merchant_id,$order_no,$amount,$authstatus,$checksum,$workingkey);
            //$verifyChecksum== "true" && 
            if(($authstatus=='Y' || $authstatus =='B')){  		// Success - Successful Transaction 
                if($authstatus=='Y'){ $payment=1;                     
            $this->sms->send_sms($mobile_number, 'your order No# '. $order_no .' at STUDYADDA is Completed.Please Login to your account to access your products.You can View/Download your product from My Account Section.');
                }
                if($authstatus=='B'){$payment=0;}
               $order = $this->Customer_model->updateOrder($order_id,$order_no,1,$txn_number,$payment);
                $this->Cart_model->removeCart($cart_id,$user_id);
                $this->cart->destroy();
		// @TO-DO : Send email to user for payment recieved for order submitted
		$message = 'Dear Sir/Madam,'.'<br>'.'Your Transaction Was Successfull, Below is your order number for further references.'.'<br>'.'Studyadda.com'.'<br>'.'Your Order Number is'.'&nbsp;'.$order_no.'.<br>You can find video link or PDF link in <a href="'.base_url().'customer">My Account Dashboard</a> Section.We recommend that Please check studyadda My Account dashboard after Payment.We can activate the download link only after payment is successful and Order Status is completed.'.'<br><br>Thanks,<br>Team Studyadda<br>Technical Support<br>06267349244';
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
$msg='';
$break_host_array=substr($_SERVER['HTTP_HOST'],-3);
if($break_host_array=='cal'){ 
$msg='Mail Not Sent.';     
}else{
$msg='Mail Sent.';		//send email
sendEmail($to,$subject,$message);
}
		//$this->sms->send_sms($mobile_number,$sms_message);
		// @TO-DO : Send email to admin for payment recieved for order submitted
		// @TO-DO : Update order table and deduct the quantity for inventory
                $this->session->set_flashdata('update_msg','Order #'.$order_no.' placed successfully.');
                //$this->Transactions_model->add($data);
                //redirect('/customer/orderdetails/'.$order_id);
                
                //redirect('/customer');
                ?>
                <a href='<?php echo base_url("user/orders"); ?>' ><button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist">Click Here To Continue</button></a><?php
                //$this->data['status']='success';                           
                //$this->load->view('cart/appsuccess',$this->data); 
if($_SERVER['HTTP_X_REQUESTED_WITH']== 'com.studyaddaapp') {
    // && stripos($ua,'mobile') !== false) {
	header('Location:'.base_url("cart/std_appsuccess"));
	exit();
}
                
            }elseif($authstatus	=='N'){ 	//0399 - Invalid Authentication at Bank - Cancel Transaction
                $this->Customer_model->cancelOrder($order_id,$order_no,0,$txn_number);
                //$this->Cart_model->removeCart($cart_id,$user_id);
		//$this->cart->destroy();
		$message = 'Dear Sir/Madam,'.'<br>'.'Your order#'.$order_no.' was not processed because of failed transaction.<br><br>Thanks,<br>Team Studyadda<br>Technical Support<br>06267349244';
		$subject = 'Order failure';
		$to = $user_info->email;
		$mobile_number = $user_info->mobile;
		$sms_message = 'Your order#'.$order_no.' was not processed because of failed transaction.<br>Technical Support<br>06267349244';
		//send email
		sendEmail($to,$subject,$message);
		//$this->load->library('sms');
		//$this->sms->send_sms($mobile_number,$sms_message);
                $this->session->set_flashdata('update_msg','Paymet for Order #'.$order_no.' failed.');
                //$this->Transactions_model->add($data);
                //redirect('/customer');
				?><a href='<?php echo base_url("user/orders"); ?>' ><button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist">Click Here To Go To Studyadda.com</button></a>
				<?php      
                                if($_SERVER['HTTP_X_REQUESTED_WITH']== 'com.studyaddaapp') { // && stripos($ua,'mobile') !== false) {
                                    redirect('/cart/std_appfailed');
}
				
            } 
           //    $this->session->set_flashdata('update_msg','There is some technical issue.Please try again.');
            ?>           
                <?php             
        }else{
             $this->session->set_flashdata('message', 'Please check your order status or contact info@studyadda.com.');
         redirect('/cart'); 
        }
    }
    
}

?>