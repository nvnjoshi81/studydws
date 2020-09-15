<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orders extends MY_Admincontroller {

        public function __construct(){
            parent::__construct();
            $this->load->model('Orders_model');
            $this->load->model('Onlinetest_model');
            $orders_status_array =$this->Orders_model->getOrders_status_array();
            $this->data['orders_status_array']= $orders_status_array;
        }
         public function index(){
            $this->load->library('pagination');
                $ordercol=$this->input->get('col');
                $order=$this->input->get('order');
                if(!$ordercol){
                    $ordercol='id';
                }if(!$order){
                    $order='desc';
                }
                /***** pgination _categories***   */
                $total=$this->Orders_model->getAllOrdersCount();
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
		$orders =$this->Orders_model->getsearchOrders($order_no); 
                }else{
		$orders =$this->Orders_model->getOrders($config["per_page"], $page,$ordercol,$order); 
                }
		$this->data['orders']=  $orders;      
                $this->data['content']='orders/index';
                               
                $this->load->view('common/template',$this->data);
        }
          public function searchorder(){
            $this->load->library('pagination');
                $ordercol=$this->input->get('col');
                $order=$this->input->get('order');
				$start_date=$this->input->post('start_date');
				$regiType=$this->input->post('regiType');
				 $start_date_string = strtotime($start_date);
				$end_date=$this->input->post('end_date');
                $end_date_string = strtotime($end_date);
                if($start_date_string == $end_date_string){
                    $end_date_string=$start_date_string+(3600*24);
                }
				
                if(!$ordercol){
                    $ordercol='id';
                }if(!$order){
                    $order='desc';
                }
                /***** pgination _categories***   */
			    $total=$this->Orders_model->ordersCountByDate($start_date_string,$end_date_string,$regiType);
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
		$orders =$this->Orders_model->getsearchOrders($order_no); 
                }elseif($regiType!=''){
		$orders =$this->Orders_model->getsearchOrdersByDate($start_date_string,$end_date_string,$regiType); 
                }else{
		$orders =$this->Orders_model->getOrders($config["per_page"], $page,$ordercol,$order); 
                }
		$this->data['orders']=  $orders;      
                $this->data['content']='orders/search_order';
                               
                $this->load->view('common/template',$this->data);
        }
             public function edit($oId){
                 $orders_products_array =$this->Orders_model->getFullorderDetails($oId);
                 $this->data['orders_products_array']=  $orders_products_array;
                 $this->data['oId']= $oId ;
                 $cmsorders_array =$this->Orders_model->getsearchOrders_byid($oId);
                 if(isset($cmsorders_array[0])){
                  $this->data['cmsorders_array']= $cmsorders_array[0];
                 }else{
                     $this->data['cmsorders_array']= NULL;
                 }
                  $order=$this->Orders_model->getOrderDetails($oId); 
				 // echo 'oId'.$oId;
				 // print_r($order);
                  $customer=$this->Orders_model->getCustomerDetails($order->user_id); 
                  $this->data['customer']= $customer;
                  $this->data['order']= $order;
                  $order_details = $this->Orders_model->getFullorderDetails($oId);
                  $this->data['order_details']= $order_details;
		 $this->data['shipping_addresses']=$this->Customer_model->getShippingAddresses($order->shipping_id);
		// echo $order->shipping_id.'.......';
                 $this->data['content']='orders/edit';
                 $this->load->view('common/template',$this->data);
            }
             
             public function deleteCanOrd($orderid,$userid,$status){
                 $cmsorders_array =$this->Orders_model->deleteCanOrd($orderid,$userid,$status);
                 $this->session->set_flashdata('message', 'Order Id.-'.$orderid.'.  DELETD!');
				redirect($_SERVER['HTTP_REFERER']);
             }
			 
			 
             public function deleteOrdPrd($orderid,$userid,$productid){
                 $cmsorders_array =$this->Orders_model->deleteOrdPrd($orderid,$userid,$productid);
                 $this->session->set_flashdata('message', 'productid Id.-'.$productid.'.  DELETD!');
				redirect($_SERVER['HTTP_REFERER']);
             }
			 
             
			 	 public function editOrdPrd($orderid,$userid,$productid){
						 if($orderid>0){						 
						      $orders_products_array =$this->Orders_model->getCustOrderprod($orderid,$userid,$productid);
						 }else{
							 $orders_products_array=array();
						 }
                $this->data['oId']=  $orderid;
                $this->data['orders_products_array']=  $orders_products_array;
				$this->data['content']='orders/editorderproduct';
                $this->load->view('common/template',$this->data);
			 }
			 
		 public function order_price_edit(){ 
						       $oId=$this->input->post('oId');
						       $odid=$this->input->post('odid');
                 $userid=$this->input->post('userid'); 
                 $productid=$this->input->post('productid');  
                 $orderproductprice =$this->input->post('orderproductprice');
				 $orderdetail_price_data = array(
			     'price' => $orderproductprice
		         );			 
				 
            $orders_status_array =$this->Orders_model->update_orderdetail_price($odid, $orderdetail_price_data); 
							 if($oId>0){						 
						      $orders_products_array =$this->Orders_model->getCustOrderprod($oId,$userid,$productid);
						 }else{
							 $orders_products_array=array();
						 }
                $this->data['oId']=  $orderid;
                $this->data['orders_products_array']=  $orders_products_array;
				$this->data['content']='orders/editorderproduct';
                $this->load->view('common/template',$this->data);
			 }
			 
			 	 
			 
			 
			 
			 
             public function order_status_edit(){
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
                $text_message_order = 'Your Order Number '.$oId.' has been updated. Please login to studyadda.com';
                
               $text_message_order .= '<br>Please Note :- You can View your course in <a href="'.base_url('login').'" >My Account</a> Section.';
               
                        $text_message_order .= '<br><br>Regards,<br>Team Studyadda';
                        
                sendEmail($customer_email,$text_subject_for_order_email,$text_message_order,$text_admin_email_main);
                
                /*Send Sms*/
                if(($_SERVER['HTTP_HOST'] != 'www.studyadda.local')&&($customer_mobile!='')){
            $this->load->library('sms');
            $this->sms->send_sms($customer_mobile, 'your order No# '. $oId .' at STUDYADDA is Completed.Please Login to your account to access your products.You can View your product from My Account Section.');
                
                }
                $this->session->set_flashdata('message', 'Order Status updated!');
                redirect('admin/orders/edit/'.$oId);
                
             }
              public function order_transfer(){
                $oId=$this->input->post('oId'); 
                $user_id=$this->input->post('user_id');
                $shipping_id= $this->Orders_model->getOrderShippingAddress($user_id);
                if(($shipping_id=='')||($shipping_id<1)){
                     //$this->session->set_flashdata('message', 'This Order can not be transfered.As user  '.$user_id.' dose not have shipping adress.');
                //redirect('admin/orders/edit/'.$oId); 
                    
                    $shipping_id=$this->input->post('shipping_id');;
                }
                
                $order_status_data = array(
			'user_id' => $user_id,
                        'shipping_id' => $shipping_id
		);
                 
		$this->Orders_model->transfer_order($oId,$order_status_data);
                $this->session->set_flashdata('message', 'Order transfered to user id.=>'.$user_id);
                redirect('admin/orders/edit/'.$oId);
              }
              
              public function test_series(){
                  
            $this->load->library('pagination');
                $ordercol=$this->input->get('col');
                $order=$this->input->get('order');
                if(!$ordercol){
                    $ordercol='id';
                }if(!$order){
                    $order='desc';
                }
                /***** pgination _categories***   */
                $total=$this->Onlinetest_model->getAllTestCount();
                $this->data['total']=$total;
                $config = array();
                $config["base_url"] = base_url() . "admin/orders/test_series/";
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
                
                $testinfo =$this->Onlinetest_model->getAllTest($config["per_page"], $page,$ordercol,$order); 
                $this->data['total']=$total;
		$this->data['testinfo']=  $testinfo;
                $this->data['content']='orders/test_attempt';
                $this->load->view('common/template',$this->data);
              } 
              public function ord_products($product_id,$product_name=''){
                       if($product_name==''){
                           $product_name='NA';
                       }
                       
                $this->load->library('pagination');
                /***** pgination _categories***   */
                $total_arr=$this->Orders_model->getAllProdOrdersCount($product_id);
                $total=$total_arr[0]->cnt;
                $this->data['total']=$total;
                $config = array();
                $config["base_url"] = base_url() . "admin/orders/ord_products/".$product_id."/".$product_name;
                $config["total_rows"] = $total;
                $config["per_page"] = $this->config->item('records_per_page');
                $config["uri_segment"] = 6;
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
                $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
                $this->data['page']=$page;
                $this->data['product_name']=urldecode($product_name);
                $this->data["links"] = $this->pagination->create_links();
                //null !== func()
                $orders =$this->Orders_model->getProdOrders($config["per_page"], $page,$product_id); 
		        $this->data['orders']=  $orders;      
                $this->data['content']='orders/product_order';
                $this->load->view('common/template',$this->data);
        }

		
		public function cs_orders($userid){
				$this->load->library('pagination');
                $ordercol=$this->input->get('col');
                if(!isset($ordercol)){
                    $ordercol='id';
                }if(!isset($order)){
                    $order='desc';
                }
                /***** pgination _categories***   */
				if($userid>0){
                $total=$this->Orders_model->getCsOrdersCount($userid);
                }else{
				die("User Id not found!");
				}

				$this->data['total']=$total;
                $config = array();
                $config["base_url"] = base_url() . "admin/orders/cs_orders/".$userid;
                $config["total_rows"] = $total;
                $config["per_page"] = $this->config->item('records_per_page');
                $config["uri_segment"] = 5;
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
                $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
                $this->data['page']=$page;
                $this->data['ordercol']=$ordercol;
                $this->data['order']=$order;
				$this->data['userid']=$userid;
				$this->data["links"] = $this->pagination->create_links();

                $orders =$this->Orders_model->getCsOrders($config["per_page"], $page,$userid); 
				$this->data['orders']=  $orders;     

                $this->data['content']='orders/customer_order';
                $this->load->view('common/template',$this->data);
				
				}
         
         
        public function searchOrd(){
			$start_date =$this->input->post('start_date');
                $end_date =$this->input->post('end_date');
                $start_date_string = strtotime($start_date);
                $end_date_string = strtotime($end_date);
                if($start_date_string == $end_date_string){
                    $end_date_string=$start_date_string+(3600*24);
                }
			
                $orders =$this->Orders_model->getsearchOrdersByDate(1,1,1); 
				$this->data['orders']=  $orders;
                $this->data['content']='orders/search_order';
                $this->load->view('common/template',$this->data);
				
		  }  
}

