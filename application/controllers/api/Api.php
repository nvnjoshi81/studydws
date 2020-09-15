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
class API extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->model('Cart_model');
        $this->load->helper('utility_functions');
        $this->load->model('Location_model');
  
    }

    public function index_post()
    {
       $methodName=$this->input->post('methodName');
       if($methodName=='login'){
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $login=$this->Customer_model->login($email,$password);
            $response=array();
        
            if($login){
                $this->session->set_userdata('logged_id',1);
                $this->session->set_userdata('customer_id',$login->id);
                $data=array('id'=>$login->id,'firstname'=>$login->firstname,'lastname'=>$login->lastname,'email'=>$login->email,'mobile'=>$login->mobile);
                $response=array('status'=>1,'data'=>$data);
            }else{
                $response=array('status'=>0,'error'=>'Invalid Email or Password');
            }
        
       
            // Set the response and exit
            $this->response($response, REST_Controller::HTTP_OK); 
            // OK (200) being the HTTP response code
       }
       if($methodName=='signup'){
            $firstname  =   $this->input->post('firstname');
            $lastname   =   $this->input->post('lastname');
            $email      =   $this->input->post('email');
            $mobile     =   $this->input->post('mobile');
            $password   =   $this->input->post('password');
            /*$dob        =   $this->input->post('dob');
            $city       =   $this->input->post('city');
            $state      =   $this->input->post('state');
            $zip        =   $this->input->post('zipcode');
            $address    =   $this->input->post('address');
            $address2   =   $this->input->post('address2');
            $address_name = $firstname.' '.$lastname;
            $country_id =   $this->input->post('country_id');*/
                
        $customerdata=array('firstname'=>$firstname,
                            'lastname'=>$lastname,
                            'email'=>$email,
                            'mobile'    =>$mobile,
                            'password'  =>sha1($password)
                            );
        $customerid=$this->Customer_model->register($customerdata);
        
        /*$addressdata=array('customer_id'=>$customerid,
                            'address_name'=>$address_name,
                            'address'=>$address,
                            'address2'=>$address2,
                            'city'=>$city,
                            'state'=>$state,
                            'country_id'=>$country_id,
                            'mobile'=>$mobile,
                            'zipcode'=>$zip,
                            'is_default'=>1);
        $addressid=$this->Customer_model->addAddress($addressdata);*/
        $response=array('status'=>1,'msg'=>'Customer Registered Successfully.');
        // Set the response and exit
        $this->response($response, REST_Controller::HTTP_OK); 
        // OK (200) being the HTTP response code
       }
      ############ wishlist ###########
			if($methodName=='add_to_wishlist'){
			   $member_id		=	$this->input->post('user_id');
			   $product_id  	=	$this->input->post('product_id');
			   $product_name	=	$this->input->post('product_name');
			   $wish = array('user_id'=>$member_id,
							 'product_id'=>$product_id,
							 'product_name'=>$product_name);
			   $wishlistdata = $this->Products_model->addToWishlist($wish);
			   if($wishlistdata)
			   {
				$this->response([
					   'status' => 1,
					   'data' => $wish
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				$this->response([
					   'status' => 0,
					   'error' => 'Error Processing Your Request'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
			   
			   
			}
			// remove from wishlist
            if($methodName=='remove_wishlist'){
			   $member_id		=	$this->input->post('user_id');
			   $product_id  	=	$this->input->post('product_id');
			  
			 
			   $status = $this->Products_model->removeFromWishlist($member_id,$product_id);
			   if($status)
			   {
				$this->response([
					   'status' => 1,
					   'data' => ''
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				$this->response([
					   'status' => 0,
					   'error' => 'Error Processing Your Request'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
			   
			   
			}
			//add order
			
			// add address
             if($methodName=='add_address'){
                 $customerid=$this->input->post('user_id');
                 $address_name=$this->input->post('address_name');
                 $address=$this->input->post('address');
                 $address2=$this->input->post('address2');
                 $city=$this->input->post('city');
                 $state=$this->input->post('state');
                 $country=$this->input->post('country');
                 $mobile=$this->input->post('mobile');
                 $zip=$this->input->post('zipcode');
                 $addressdata=array('customer_id'=>$customerid,
                            'address_name'=>$address_name,
                            'address'=>$address,
                            'address2'=>$address2,
                            'city_name'=>$city,
                            'state_name'=>$state,
                            'country_name'=>$country,
                            'mobile'=>$mobile,
                            'zipcode'=>$zip,
                            'is_default'=>0);
            $addressid=$this->Customer_model->addAddress($addressdata);
             /* Add mobile in customer table if not exist*/        
        $customerDet=$this->Customer_model->getCustomerDetails($customerid);
            if ($customerDet->mobile == '') {
        $userdata_mob = array('mobile' => $mobile);        
        $this->Customer_model->updatecustomerinfo($customerid, $userdata_mob);
            }
        /*End modbile in customer */
            
             if($addressid)
			   {
                 $addressdata['address_id']=$addressid;
				$this->response([
					   'status' => 1,
					   'data' => $addressdata
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				$this->response([
					   'status' => 0,
					   'error' => 'Error Processing Your Request'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
             }
			 // edit address 
			 if($methodName=='edit_address'){
                 $address_id=$this->input->post('address_id');
                 $address_name=$this->input->post('address_name');
                 $address=$this->input->post('address');
                 $city=$this->input->post('city');
                 $state=$this->input->post('state_name');
                 $mobile=$this->input->post('mobile');
                 $zip=$this->input->post('zipcode');
                 $addressdata=array('address_name'=>$address_name,
                            'address'=>$address,
                            'city_name'=>$city,
                            'state_name'=>$state,
                            'mobile'=>$mobile,
                            'zipcode'=>$zip
							);
         $response=array('status'=>1,$addressdata);
         $addressid=$this->Customer_model->editCustomerAddress($addressdata,$address_id);
            
        $customer_id=$this->session->userdata('customer_id');
         /* Add mobile in customer table if not exist*/        
        $customerDet=$this->Customer_model->getCustomerDetails($customer_id);
            if ($customerDet->mobile == '') {
        $userdata_mob = array('mobile' => $mobile);        
        $this->Customer_model->updatecustomerinfo($customerid, $userdata_mob);
            }
        /*End modbile in customer */
            
             if($addressid)
			   {
                 $addressdata['address_id']=$addressid;
				$this->response([
					   'status' => 1,
					   'data' => $addressdata
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				$this->response([
					   'status' => 0,
					   'error' => 'Error Processing Your Request'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
             }
			 // add to cart
            if($methodName=='add_to_cart'){
                
                $user_id=$this->input->post('user_id');
                $product_id=$this->input->post('product_id');
                $quantity=$this->input->post('quantity');
                $price=$this->input->post('price');
                $data=array('user_id'=>$user_id,
                        'product_id'=>$product_id,
                        'quantity'=>$quantity,
                        'price'=>$price);   
                $addtocart=$this->Customer_model->addToCart($user_id,$product_id,$quantity,$price);
				if($addtocart)
			   {
				$this->response([
					   'status' => 1,
					   'data' => $addtocart
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				$this->response([
					   'status' => 0,
					   'error' => 'Error Processing Your Request'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
                
            }
            if($methodName=='remove_item'){
                $user_id=$this->input->post('user_id');
                $product_id=$this->input->post('product_id');
                $cart_id=$this->input->post('cart_id');
                $removed=$this->Customer_model->removeCartItem($user_id,$cart_id,$product_id);
				$items = $this->Cart_model->getCartItems($cart_id);
				$items_array = array();
				if($items){
					foreach($items as $item){
						$items_array[] = $item;
					}
				}
               if($removed)
               {
                $this->response([
                       'status' => 1,
                       'data' => $items_array
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
               else
               {
                   // Set the response and exit
                $this->response([
                       'status' => 0,
                       'error' => 'Error Processing Your Request'
                   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
               }
            }
            if($methodName=='update_cart'){
                $user_id=$this->input->post('user_id');
                $product_id=$this->input->post('product_id');
                $quantity=$this->input->post('quantity');
                $cart_id=$this->input->post('cart_id');
                $price=$this->input->post('price');
                $updated=$this->Customer_model->updateCart($user_id,$cart_id,$product_id,$quantity,$price);
				$items = $this->Cart_model->getCartItems($cart_id);
				$items_array = array();
				if($items){
					foreach($items as $item){
						$items_array[] = $item;
					}
				}
               if($updated)
               {
                $this->response([
                       'status' => 1,
                       'data' => $items_array
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
               }
               else
               {
                   // Set the response and exit
                $this->response([
                       'status' => 0,
                       'error' => 'Error Processing Your Request'
                   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
               }
            }
    }
    public function index_get()
    {
       $methodName=$this->input->get('methodName');
       if($methodName=='category_list'){
       $id=$this->input->get('id');
       if(!$id){
           $id=0;
       }
       $p_categories=$this->Categories_model->getCategoryTreeAPI($id);

        

                  
            if ($p_categories)
            {
                // Set the response and exit
                $this->response([
                    'status' => 1,
                    'data' => $p_categories
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => 0,
                    'error' => 'No categories found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
       }
       if($methodName=='search_products'){
           $searchtext=$this->input->get('search_text');
           $products=$this->Products_model->searchProducts($searchtext);
           if ($products){
               foreach($products as $product){
                   if($product->available_qty > 1){
                       $stock='Yes';
                   }else{ $stock='No';}
                   $data[]=array('id'=>$product->id,
                           'prdName'=>$product->name,
                           'pro_image'=>$product->image,
                           'stock'=>$stock,
                           'mrprice'=>$product->price,
                           'brand'=>$product->mfg_by,
                           'stock_count'=>$product->available_qty
                           );
               }
                    // Set the response and exit
                    $this->response([
                        'status' => 1,
                        'data' => $data
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
                else
                {
                    // Set the response and exit
                    $this->response([
                        'status' => 0,
                        'error' => 'No products found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                }
       }
        if($methodName=='home_products'){
            $latest=array();
            $special=array();
            $featured=array();
            $products=$this->Products_model->getHomeProducts('latest');
            
            if ($products)
            {
                $parray=array();
                foreach($products as $product){
                   if($product->available_qty > 1){
                       $stock='Yes';
                   }else{ $stock='No';}
                   $data=array('pro_id'=>$product->id,
                           'pro_name'=>$product->name,
                           'pro_img_url'=>$product->image,
                           'stock'=>$stock,
                           'pro_price'=>$product->price,
                           'brand'=>$product->mfg_by,
                           'pro_qty'=>$product->available_qty
                           );
                   array_push($parray,$data);
               }
               $latest=array('category'=>'Latest Products','products'=>$parray);
            }
			$products=$this->Products_model->getHomeProducts('special');
            
            if ($products)
            {
                $parray=array();
                foreach($products as $product){
                   if($product->available_qty > 1){
                       $stock='Yes';
                   }else{ $stock='No';}
                   $data=array('pro_id'=>$product->id,
                           'pro_name'=>$product->name,
                           'pro_img_url'=>$product->image,
                           'stock'=>$stock,
                           'pro_price'=>$product->price,
                           'brand'=>$product->mfg_by,
                           'pro_qty'=>$product->available_qty
                           );
                   array_push($parray,$data);
               }
               $special=array('category'=>'Special Products','products'=>$parray);
            }
			$products=$this->Products_model->getHomeProducts('featured');
            
            if ($products)
            {
                $parray=array();
                foreach($products as $product){
                   if($product->available_qty > 1){
                       $stock='Yes';
                   }else{ $stock='No';}
                   $data=array('pro_id'=>$product->id,
                           'pro_name'=>$product->name,
                           'pro_img_url'=>$product->image,
                           'stock'=>$stock,
                           'pro_price'=>$product->price,
                           'brand'=>$product->mfg_by,
                           'pro_qty'=>$product->available_qty
                           );
                   array_push($parray,$data);
               }
               $featured=array('category'=>'Featured Products','products'=>$parray);
            }
           
                // Set the response and exit
                $this->response([
                    'status' => 1,
                    'data' => array($latest,$special,$featured)
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
           if($methodName=='product_detail'){
			$id=$this->input->get('id');
			$product=$this->Products_model->details($id);
            //print_r($product);
            $product_image=$this->Products_model->getProductImage($product[0]->id);
			if($product){
              $prarray=objectToArray($product);
              //print_r($prarray);
                $prarray[0]['pro_image_url']=$product_image;
               // print_r($prarray);
			   $this->response([
					   'status' => 1,
					   'data' => array('products'=>$prarray[0])
				   ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				   $this->response([
					   'status' => 0,
					   'error' => 'No products found'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
        }
        if($methodName=='get_all_products_by_category'){
            $category_id=$this->input->get('cate_id');
            $products=$this->Categories_model->getcatProducts($category_id);
            if($products){
			   $this->response([
					   'status' => 1,
					   'data' => array('products'=>$products)
				   ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				   $this->response([
					   'status' => 0,
					   'error' => 'No products found'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
            
        }
		############ zipcode ###########
		    if($methodName=='zipcode'){
            $zip=$this->input->get('zip_code');
            $zipallowed=$this->Categories_model->getZipcode($zip);
            if($zipallowed && $zipallowed->cod_pin == $zip && $zipallowed->cod_status=1){
			   $this->response([
					   'status' => 1,
					   'data' => $zipallowed
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				   $this->response([
					   'status' => 0,
					   'error' => 'Customers From Delhi,Faridabad,Gurgaon and Noida...Please Shop From shudhbuy.com '
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
            
        }
         if($methodName=='get_cart_items'){
                $user_id=$this->input->get('user_id');
                $cartItems=$this->Customer_model->getCartItems($user_id);
               if($cartItems)
			   {
				$this->response([
					   'status' => 1,
					   'data' => $cartItems
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				$this->response([
					   'status' => 0,
					   'error' => 'Error Processing Your Request'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
            }
			###### user #######
			if($methodName=='user_profile'){
                $user_id=$this->input->get('user_id');
                $user_info=$this->Customer_model->getUserInfo($user_id);
               if($user_info)
			   {
				$this->response([
					   'status' => 1,
					   'data' => $user_info
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				$this->response([
					   'status' => 0,
					   'error' => 'Error Processing Your Request'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
            }
			
			// get address
			if($methodName=='get_address'){
                $customer_id=$this->input->get('user_id');
                $user_address=$this->Customer_model->getAddresses($customer_id);
               if($user_address)
			   {
				$this->response([
					   'status' => 1,
					   'data' => $user_address
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				$this->response([
					   'status' => 0,
					   'error' => 'Error Processing Your Request'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
            }
			//  states
			
			if($methodName=='get_states'){
                $state=$this->Location_model->getState();
               if($state)
			   {
				$this->response([
					   'status' => 1,
					   'data' => $state
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				$this->response([
					   'status' => 0,
					   'error' => 'Error Processing Your Request'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
            }
			
			// get states by city
			if($methodName=='get_cities'){
				$state_name = $this->input->get('state_name');
                $cities=$this->Location_model->fetchCity($state_name);
               if($cities)
			   {
				$this->response([
					   'status' => 1,
					   'data' => $cities
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				$this->response([
					   'status' => 0,
					   'error' => 'Error Processing Your Request'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
            }
			// user info edit
			if($methodName=='edit_user_info'){
				$firstname = $this->input->post('firstname');
				$lastname = $this->input->post('lastname');
				$email = $this->input->post('email');
			    $mobile = $this->input->post('mobile');
				$user_id = $this->input->post('user_id');
				$userdata = array('firstname'=>$firstname,
								   'lastname'=>$lastname,
									'email'=>$email,
									'mobile'=>$mobile);
				$user_values = $this->Customer_model->updatecustomerinfo($user_id,$userdata);
               if($user_values)
			   {
				$this->response([
					   'status' => 1,
					   'data' => $user_values
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				$this->response([
					   'status' => 0,
					   'error' => 'Error Processing Your Request'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
            }
			// get wishlist
			if($methodName=='get_wishlist'){
				$customer_id = $this->input->get('customer_id');
                $wishlist_items=$this->Customer_model->getWishlistItems($customer_id);
               if($wishlist_items)
			   {
				$this->response([
					   'status' => 1,
					   'data' => $wishlist_items
					], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			   }
			   else
			   {
				   // Set the response and exit
				$this->response([
					   'status' => 0,
					   'error' => 'Error Processing Your Request'
				   ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			   }
            }
			// payment and order
			if($methodName=='payment_process'){
				$payment_mode = $this->input->post('payment_mode');
				$final_amount = $this->input->post('final_amount');
				$shipping_charges = $this->input->post('shipping_charges');
				$cod_charges = $this->input->post('cod_charges');
				$shipping_address_id = $this->input->post('shipping_address_id');
				//$user_id = $this->session->userdata('customer_id');
				$user_id = $this->input->post('user_id');
				$user_info = $this->Customer_model->getCustomerDetails($user_id);
				$cart_id = $this->input->post('cart_id');
				$order=$this->Customer_model->addOrder($user_id,$payment_mode,$final_amount,$shipping_charges,$cod_charges,$shipping_address_id);
				$order_id=$order['order_id'];
				$order_no=$order['order_no'];
				$order_details = $this->Cart_model->getOrderDetails($order_id);
				
                if($payment_mode==2){
				$user=$this->Customer_model->getCustomerDetails($user_id);
				//$user=$this->Customer_model->getAddresses($user_id);
				$merchantid	= 'PTNJLAVD';
				$order_no	=$order_no;   // NEED to replace this with unique order number in order table
				$totalbill	=$final_amount;
				$secureid	= 'ptnjlavd';
				$unit_id	=$user_id;
				$last_id_cod=$order_id;
				$cmp_phone	=$user->mobile;
				$cmp_email	=$user->email;
				$returnurl	='http://patanjali.satisfactionwebsolution.in/checkout/response';
				$str = ''.$merchantid.'|'.$order_no.'|NA|'.$totalbill.'|NA|NA|NA|INR|NA|R|'.$secureid.'|NA|NA|F|'.$unit_id.'|'.$last_id_cod.'|'.$cmp_phone.'|'.$cmp_email.'|NA|NA|NA|'.$returnurl.'';
				$checksum = hash_hmac('sha256',$str,'ySQTiTyjXwWK', false);
				$checksum = strtoupper($checksum);
				// @TO-DO : Send email to user for order submitted
				
				// @TO-DO : Send email to admin for order submitted
				$data['parameters']= $hiddenvalue=$str."|".$checksum;
				$this->load->view('checkout/processpayment',$data);
			}else{
			foreach ($this->cart->contents() as $item){
				 $this->Products_model->updateQuantity($item['id'],$item['qty']);
			}
			// @TO-DO : add payment mode condition and execute following code for cod.
			$this->Cart_model->removeCart($cart_id,$user_id);
			$this->cart->destroy();
			$message = 'Dear Sir/Madam,'.'<br>'.'Your Order Was Successfull, Below is your order number for further references.'.'<br>'.'Patanjali Ayurved Limited, Company TIN No. 05006754814'.'<br>'.'Your Order Number is'.'&nbsp;'.$order_no;
				$subject = 'Order Confirmation';
				$to = $user_info->email;
				$mobile_number = $user_info->mobile;
				$sms_message = "Your order has been placed successfully..Your order number is".$order_no;
				//send email
				sendEmail($to,$subject,$message);
				
				$this->sms->send_sms($mobile_number,$sms_message);
				
			
			}
               
            }
        }
      
    

}