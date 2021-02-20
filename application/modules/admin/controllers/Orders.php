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
		
		
			// code by Mahesh 
			/* Add product */
		public function add_product($orderid,$customerid) {
			
			$product_name= $this->Orders_model->get_product();
			
			$this->data['orderid']=$orderid;
			
			$this->data['customerid']=$customerid;
			
			$this->data['product_name']=$product_name;
			
			$this->data['content']='orders/add_product';
						   
			$this->load->view('common/template',$this->data);
		}
	public function add_new_product() {
			$orderId = $this->input->post('orderId');
			
			$customerid=$this->input->post('customerid');
			
			$product_id_array = $this->input->post('product_id');
			
		
		$product_id_count=count($product_id_array); 
		if(isset($product_id_array)&&$product_id_count>0){
		foreach($product_id_array as $pkey=>$pval){
			$product_id=$pval;
			$get_product_detail= $this->Orders_model->get_product_detail($product_id);
		
			$get_end_dt = $this->Orders_model->getOrderItems($orderId);
			
			$end_dt = $get_end_dt[0]->end_date;
			
			$type = $get_product_detail[0]->type;
			
			$price = $get_product_detail[0]->price;
			
			$discount_price = $get_product_detail[0]->discounted_price;
			
			$new_product =  array('order_id'=>$orderId,
			'product_id'=>$product_id,
			'quantity'=>'1',
			'price'=>$price,
			'discounted_price'=>$discount_price,
			'type'=>$type,
			'paytype'=>'complimantry_paid',
			'end_date'=>$end_dt);
			$this->Orders_model->add_product($new_product);
		}
    echo "<script>alert('Product Added Successfully!');</script>";	
	}else{
	echo "<script>alert('Please Select Value!!');</script>";
	}
	
	$this->Orders_model->update_pro_qty($orderId);
	$this->session->set_flashdata('message', 'Information Saved successfully!');
	redirect('admin/orders/edit/'.$orderId);
	
	}
	//bulk
	public function bulkadd_new_product() {  
		$orderId_array = $this->input->post('bulkProdOrd');
		
		foreach($orderId_array as $oidkey=>$oidval){
		$orderId=$oidval;
		$product_id_array = $this->input->post('product_id');
		
		$product_id_count=count($product_id_array);
		
		if(isset($product_id_array)&&$product_id_count>0){
		$product_id_array = $this->input->post('product_id');
		$product_id_count=count($product_id_array);
		foreach($product_id_array as $pkey=>$pval){
			$product_id=$pval;
			$get_product_detail= $this->Orders_model->get_product_detail($product_id);
			$get_end_dt = $this->Orders_model->getOrderItems($orderId);
			$end_dt = $get_end_dt[0]->end_date;			
			$type = $get_product_detail[0]->type;			
			$price = $get_product_detail[0]->price;
			$user_id=$get_end_dt[0]->user_id;
			$discount_price = $get_product_detail[0]->discounted_price;
			$new_product =  array('order_id'=>$orderId,
			'product_id'=>$product_id,
			'quantity'=>'1',
			'price'=>$price,
			'discounted_price'=>$discount_price,
			'type'=>$type,
			'paytype'=>'complimantry_paid',
			'end_date'=>$end_dt);
			
			$getInfobyProduct = $this->Orders_model->getInfobyProduct($user_id,$product_id,$orderId);
			
			if(count($getInfobyProduct)>0){
				$this->session->set_flashdata('message', $product_id.' Already Exist!');
			}else{
			$this->Orders_model->add_product($new_product);
			}				
		}
			
} 
 $this->session->set_flashdata('message', 'Added Product in Order!');
 
		//print_r($product_id_array); 
		}
redirect('admin/orders/success_order');
		}
	
			public function edit_ordprd_type() {
			$orderproduct_id = $this->input->post('orderproduct_id');
			$orderId= $this->input->post('orderId');
			$opid_type = $this->input->post('opid_type');
			
			$typearray=array(
			'paytype'=>$opid_type
			);					
			$this->Orders_model->update_orderdetail_price($orderproduct_id,$typearray);		 die;
if(isset($orderId)&&$orderId>0){			
			redirect('admin/orders/edit/'.$orderId);
}else{
	redirect('admin/customers/prdcustcart/'.$orderproduct_id);
	
}
}
/*
public function orders_productsearch() {
		//$product_name= $this->Orders_model->get_product();
		$this->data['content']='orders/orders_productsearch';
		$this->load->view('common/template',$this->data);
		}
*/
			
public function success_orderproduct($col_get='ordercount',$order_get='asc',$start_date_get='',$end_date_get='',$regiType_get='all') {
	
    $col_get=$this->input->get('col');	
	$order_get=$this->input->get('order');
	$start_date_get=$this->input->get('start_date');
	$end_date_get=$this->input->get('end_date');
	
	$regiType_get=$this->input->get('regiType');
			  
				$this->load->library('pagination');
				if(isset($col_get)&&$col_get!==''){
				$ordercol=$col_get;
				}else{
                $ordercol=$this->input->get('col');
				}
				
				if(isset($order_get)&&$order_get!==''){
				$order=$order_get;
				}else{
                $order=$this->input->get('order');
				}
				
if(isset($start_date_get)&&$start_date_get!==''){
				//$start_date=$start_date_get;
				 $start_date=$this->input->get('start_date');
				}else{
                $start_date=$this->input->post('start_date');
				}
if(isset($end_date_get)&&$end_date_get!==''){
				$end_date=$end_date_get;
				}else{
				$end_date=$this->input->post('end_date');
				}
			
		if(isset($regiType_get)&&$regiType_get!=''){
		$regiType_val=$regiType_get;	
		}else{
		$regiType_val=$this->input->post('regiType');	
		}
				
				$start_date_string = strtotime($start_date);
				
				
				$end_date_string = strtotime($end_date);
				
				
				if($start_date_string == $end_date_string){
				//$end_date_string=$start_date_string+(3600*48);
				}
                if(!$ordercol){
                    $ordercol='id';
                }if(!$order){
                    $order='desc';
                }
                /***** pgination _categories***   */
                $total=$this->Orders_model->getAllSuccessOrdersCount();
                
                $config = array();
                $config["base_url"] = base_url() . "admin/orders/success_order/";
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
				$this->data['ordercol']=$ordercol;
                $this->data['order']=$order;
                //null !== func()
				
                if(null !==$this->input->post('order_no')){
                    $order_no=$this->input->post('order_no');
                }else{
                    $order_no='';
                }
                if($order_no>0){

				
				}elseif(!$start_date_string=='' && !$end_date_string==''){
/* for search success orders by date */
		$orderstatus=1;
		
		
		if(isset($regiType_val)&&$regiType_val!=''){
		$regiType=$regiType_val;
		}else{
			$regiType_val_get=$_REQUEST['regiType'];
			if(isset($regiType_val_get)&&$regiType_val_get!=''){
				$regiType=$regiType_val_get;
			}else{
		$regiType='all';
			}
		}
		
$product_id=$this->input->post('product_id');
if(isset($product_id)&&$product_id>0){
	
	$product_id=$this->input->post('product_id');
}else{
	$product_id=$this->input->get('product_id');
}

$product_name_all= $this->Orders_model->get_product_type();

foreach($product_name_all as $allprdkey=>$allprdvalue){
$product_id=$allprdvalue->id;
$productname=$allprdvalue->modules_item_name;
if(isset($product_id)&&$product_id>0){
		$productorder_array =$this->Orders_model->getsearchOrdersByDate($start_date_string,$end_date_string,$regiType,$orderstatus,$product_id,$config["per_page"], $page,'id',$order);
$ordercnt= count($productorder_array);
$orders[]=array($product_id,$productname,$ordercnt);
}
}
if($ordercol=='productname'){
if($order=='asc'){
		usort($orders, function($a, $b) {
	  return $a[1] <=> $b[1];
});
}else{

usort($orders, function($a, $b) {
	 if($a['1']==$b['1']) return 0;
    return $a['1'] < $b['1']?1:-1;
});
}
}else{
if($order=='asc'){
usort($orders, function($a, $b) {
	  return $a[2] <=> $b[2];
});

}else{
usort($orders, function($a, $b) {
	 if($a['2']==$b['2']) return 0;
    return $a['2'] < $b['2']?1:-1;
});
}
}


		$config["per_page"] = $ordercnt;
		$config["total_rows"] = $ordercnt;
		  }
foreach($orders as $odkey => $odvalue){
	
	if(isset($odvalue->app_order)&&$odvalue->app_order==1){
		$app_order_array[]=$odvalue->app_order;
		
	}else{
		$web_order_array[]=$odvalue->app_order;
	}
	$odvalue_id=$odvalue->id;
	$orderdetails_all= $this->Orders_model->getFullorderDetails($odvalue_id);
	
	foreach($orderdetails_all as $allkey => $allvalue){
	if($allvalue->paytype=='complimantry_paid'){	
	$paytypeArray[$odvalue_id] = $allvalue->paytype;
	}
	}
}
$this->data['paytypeArray']=  $paytypeArray;
$this->data['web_order_array']=  $web_order_array;
$this->data['app_order_array']=  $app_order_array;
				$this->data['product_name_all']=  $product_name_all;
		$product_name= $this->Orders_model->get_studypackage();
			$this->data['product_name']=  $product_name;
			$this->data['product_id']=  $product_id;
			$this->data['start_date']=$start_date;
		$this->data['end_date']=$end_date;		
		$this->data['regiType']=$regiType;		
		$this->data['product_id']=$product_id;
		$this->data['total']=$ordercnt;
		$this->data['orders']=  $orders;
        $this->data['content']='orders/success_orderproduct';
        $this->load->view('common/template',$this->data);
		}
		/* -- success order --*/
		public function success_order($productid_get=0,$start_date_get=0,$end_date_get=0,$regiType_get=0){
                $this->load->library('pagination');
                $ordercol=$this->input->get('col');
                $order=$this->input->get('order');				
				$start_date_post=$this->input->post('start_date');
				if(isset($start_date_post)&&$start_date_post!=''){
				$start_date=$this->input->post('start_date');
				}if(isset($start_date_get)&&$start_date_get>0){
				$start_date=$start_date_get;	
				}else{
					$start_date=$this->input->get('start_date');	
				}
		$regiType_val_post=$this->input->post('regiType');
		if(isset($regiType_val_post)&&$regiType_val_post!=''){
		$regiType_val=$this->input->post('regiType');	
		}if(isset($regiType_val)&&$regiType_val>0){
				$regiType_val=$regiType_get;
		}else{
		$regiType_val=$this->input->get('regiType');
		}
		
		$end_date_post=$this->input->post('end_date');
		
		if(isset($end_date_post)&&$end_date_post!=''){
				$end_date=$this->input->post('end_date');	
				}if(isset($end_date_get)&&$end_date_get!=0){
				$end_date=$end_date_get;	
				}else{
				$end_date=$this->input->get('end_date');
				}
				
$product_id=$this->input->post('product_id');
if(isset($product_id)&&$product_id>0){
	
	$product_id=$this->input->post('product_id');
}else{
	$product_id=$productid_get;
}
$start_date_string = strtotime($start_date);
$end_date_string = strtotime($end_date);
if($start_date_string == $end_date_string){
//$end_date_string=$start_date_string+(3600*48);
}
                if(!$ordercol){
                    $ordercol='id';
                }if(!$order){
                    $order='desc';
                }
				/*****pgination categories****/
                $total=$this->Orders_model->getAllSuccessOrdersCount();
                $config = array();
                $config["base_url"] = base_url() . "admin/orders/success_order/";
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
				$this->data['ordercol']=$ordercol;
                $this->data['order']=$order;
                //null !== func()
                if(null !==$this->input->post('order_no')){
                    $order_no=$this->input->post('order_no');
                }else{
                    $order_no='';
                }
                if($order_no>0){
		$orders =$this->Orders_model->getsearchOrders($order_no); 
                $ordercnt= count($orders);
		$this->data['total']=$ordercnt;
				
				}elseif(!$start_date_string=='' && !$end_date_string==''){
        /* for search success orders by date */
		$orderstatus=1;
		if(isset($regiType_val)&&$regiType_val!=''){
		$regiType=$regiType_val;
		}else{
		$regiType_val_get=$_REQUEST['regiType'];
		if(isset($regiType_val_get)&&$regiType_val_get!=''){
		$regiType=$regiType_val_get;
		}else{
		$regiType='all';
		}
		}
	$orders =$this->Orders_model->getsearchOrdersByDate($start_date_string,$end_date_string,$regiType,$orderstatus,$product_id,$config["per_page"], $page,$ordercol,$order); 
		$ordercnt= count($orders);
		$config["per_page"]   =   $ordercnt;
		$config["total_rows"] =   $ordercnt;
		}else{
		$this->data['total']  =   $total;	
        $config["total_rows"] =   $total;
        $config["per_page"] = $this->config->item('records_per_page');					
				$this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                $this->data['page']=$page;
                $this->data['ordercol']=$ordercol;
                $this->data['order']=$order;
             $this->data["links"] = $this->pagination->create_links();
		$orders =$this->Orders_model->getSuccessOrders($config["per_page"], $page,$ordercol,$order); 
                }
foreach($orders as $odkey => $odvalue){
	
	if(isset($odvalue->app_order)&&$odvalue->app_order==1){
		$app_order_array[]=$odvalue->app_order;
		
	}else{
		$web_order_array[]=$odvalue->app_order;
	}
	$odvalue_id=$odvalue->id;
	$orderdetails_all= $this->Orders_model->getFullorderDetails($odvalue_id);
	
	foreach($orderdetails_all as $allkey => $allvalue){
	if($allvalue->paytype=='complimantry_paid'){	
	$paytypeArray[$odvalue_id] = $allvalue->paytype;
	}
	}
}
$this->data['paytypeArray']=  $paytypeArray;
$this->data['web_order_array']=  $web_order_array;
$this->data['app_order_array']=  $app_order_array;

$product_name_all= $this->Orders_model->get_product();				$this->data['product_name_all']=  $product_name_all;
		$product_name= $this->Orders_model->get_studypackage();
			$this->data['product_name']=  $product_name;
			$this->data['product_id']=  $product_id;
			$this->data['start_date']=$start_date;
		$this->data['end_date']=$end_date;		
		$this->data['regiType']=$regiType;		
		$this->data['product_id']=$product_id;
		$this->data['total']=$ordercnt;
			$this->data['orders']=  $orders;
            $this->data['content']='orders/success_order';
                               
                $this->load->view('common/template',$this->data);
        }
		/* -- // success order --*/
		
          public function searchorder(){
            $this->load->library('pagination');
                $ordercol=$this->input->get('col');
                $order=$this->input->get('order');
				$start_date=$this->input->post('start_date');
				$regiType=$this->input->post('regiType');				
				$orderstatus=$this->input->post('status');				
				$start_date_string = strtotime($start_date);
				$end_date=$this->input->post('end_date');
                $end_date_string = strtotime($end_date);
                if($start_date_string == $end_date_string){
                $end_date_string=$start_date_string+(3600*48);
}
                if(!$ordercol){
                    $ordercol='id';
                }if(!$order){
                    $order='desc';
                }
                /***** pagination _categories***   */
			    $total=$this->Orders_model->ordersCountByDate($start_date_string,$end_date_string,$regiType,$orderstatus);
				
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
		$orders =$this->Orders_model->getsearchOrders($order_no,$orderstatus); 
                }
				elseif($regiType!=''){
		$orders =$this->Orders_model->getsearchOrdersByDate($start_date_string,$end_date_string,$regiType,$orderstatus); 
                }
				else{
		$orders =$this->Orders_model->getOrders($config["per_page"], $page,$ordercol,$order,$orderstatus); 
                }
		$this->data['orders']=  $orders;
        $totalorder=count($orders);
		$this->data['totalorder']=  $totalorder;
		$this->data['start_date_string']=  $start_date_string;
		$this->data['end_date_string']=  $end_date_string;
		$this->data['regiType']=  $regiType;
                $this->data['content']='orders/search_order';
                               
                $this->load->view('common/template',$this->data);
        }
             public function edit($oId){
				 
				 if(isset($oId)&&$oId>0){
					 $orders_products_array =$this->Orders_model->getFullorderDetails($oId);
					  }else{
					 die('Please Enter Order Id!');
				 }
				 
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
			 
			 
             public function deleteOrdPrd($orderid,$userid,$productid,$orderprod_id){
                 $cmsorders_array =$this->Orders_model->deleteOrdPrd($orderid,$userid,$productid,$orderprod_id);
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
							   $paytype=$this->input->post('paytype');
							   ;
                 $userid=$this->input->post('userid'); 
                 $productid=$this->input->post('productid');  
                 $orderproductprice =$this->input->post('orderproductprice');
				 $orderdetail_price_data = array(
			     'price' => $orderproductprice,
			     'paytype' => $paytype
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
        public function test_seriesinfo($getotestid=0,$sortord_name='asc',$sortord_type='name'){
			$postotestid=$this->input->post('otid');
			if(isset($getotestid)&&$getotestid>0){
			$otestid=$getotestid;
			}elseif(isset($postotestid)&&$postotestid>0){
			$otestid=$postotestid;
			}else{
		    $otestid=0;
			}
		$testdetail =$this->Onlinetest_model->detail($otestid); 
        //$this->data['total']=$total;
		$this->data['testdetail']=  $testdetail;
		$testinfo =$this->Onlinetest_model->getoTestUser($otestid,$sortord_name,$sortord_type); 
		$this->data['testinfo']=  $testinfo;
		$this->data['sortord_name']=  $sortord_name;
		$this->data['sortord_otest']=  $sortord_name;
		$this->data['otestid']=  $otestid;		
		$this->data['sortord_type']=  $sortord_type;
        $this->data['content']='orders/test_seriesinfo';
        $this->load->view('common/template',$this->data);
				}
				
				
				
  public function olExamList(){
    // POST data
    $postData = $this->input->post();

    // get data
    $data = $this->Onlinetest_model->olExamUsers($postData);

    echo json_encode($data);
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

                /***** pagination _categories***   */
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
		  	
public function download_xl_order($getstart,$getend){
	ini_set('default_socket_timeout', 6000);
		 ini_set('max_execution_time', 6000);
		if(isset($getstart)){
			$start_date=$getstart;
		}else{
			$start_date='25-12-2020';
		}
		
		if(isset($getend)){
			$end_date=$getend;
		}else{
			$end_date='26-12-2020';
		}
//$start_date='2020/09/25';
//$end_date='2020/12/26';


$start_date = DateTime::createFromFormat(
    'd-m-Y H:i:s',
    '31-08-2020 11:59:59',
    new DateTimeZone('IST')
);

$end_date = DateTime::createFromFormat(
    'd-m-Y H:i:s',
    '01-09-2020 11:59:59',
    new DateTimeZone('IST')
);

$start_timestamp =  $start_date->getTimestamp();

$end_timestamp = $end_date->getTimestamp();
	//echo $start_timestamp.'--'.$end_timestamp; die;	//$start_datefee_download=urldecode($start_datefee_download);
		//$end_datefee_downlaod=urldecode($end_datefee_downlaod);
		//$start_timestamp='1598922061'; 01/sept/2020
		
		$filename = 'studyadda_'.date('Ymd').'.csv'; 
		//header("Content-Description: File Transfer"); 
		//header("Content-Disposition: attachment; filename=$filename"); 
		//header("Content-Type: application/csv;");	
		
		ob_clean();
		 ini_set('default_socket_timeout', 6000);
		 ini_set('max_execution_time', 6000);
		header('HTTP/1.1 200 OK');
        header('Cache-Control: no-cache, must-revalidate');
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$filename");
		
		$file = fopen('php://output','w');
		$headerdt = array("Start date - ".$start_datefee_download,"End date - ".$end_datefee_downlaod);
		
		//fputcsv($file, $headerdt);	
		
		$header = array("S.No.","Data","App User","Web User","Total User","sales");	
		fputcsv($file, $header);	
		//118 
		for ($x = 1; $x < 118; $x++) {
		$next_timestamp=strtotime('+'.$x.' days', $start_timestamp);
		$end_timestampend=strtotime('+'.$x.' days', $end_timestamp);
		
		$currentdate=date('d/m/Y', $next_timestamp);
        $currentdate_end=date('d/m/Y', $end_timestampend);		
		//$student_list = $this->Orders_model->getOnline_student($next_timestamp);
		
		$appstudent_list = $this->Orders_model->getOnline_student($next_timestamp,$end_timestampend,$usertype='1');
		
		$webstudent_list = $this->Orders_model->getOnline_student($next_timestamp,$end_timestampend,$usertype='0');
		//$totalusr=count($student_list);
		$apptotalusr=count($appstudent_list);
        $webtotalusr=count($webstudent_list);
$cnt=$x;
		$totalusr=$apptotalusr+$webtotalusr;
		$student_Infoarray = array($x,$currentdate,$apptotalusr,$webtotalusr,$totalusr,'0');
		
		fputcsv($file,$student_Infoarray); 
		}
		
		/*
					
			foreach($transection_list as $key=>$student_fee){
		foreach($transection_list as $key=>$student_fee){
		if($student_fee->balance>0){
		$class_array = $this->Student_model->get_student_class($student_fee->student_id);
		$stu_class = $class_array[0]->class_name;
		$annualamtarr = $this->Studentfees_model->getannualfee($student_fee->student_id);
		$annualfee=$annualamtarr[0]->annualamt;
		
		
		$student_feearray = array($student_fee->student_id,$student_fee->student_name,$student_fee->father_name,$stu_class,$annualfee,$student_fee->installment_amount,$student_fee->received_amount,$student_fee->balance,$student_fee->students_mobile,$student_fee->fathers_mobile,$student_fee->mothers_mobile);
		
		
		fputcsv($file,$student_feearray); 
			}
		}
			}
		*/
		
		
		fclose($file); 
		exit;
	}
	
public function show_xl_custorder($getstart,$getend){
	ini_set('default_socket_timeout', 6000);
	ini_set('max_execution_time', 6000);
	if(isset($getstart)){
			$start_date_get=$getstart.' 01:01:00';
		}else{
			$start_date_get='30-11-2020'.' 01:01:00';
		}
		
		if(isset($getstart)&&$getstart!=''){
		//nothing to do
		}else{
		die('insert start date!');
		}
		
		if(isset($getend)&&$getend!=''){
			$x=$getend;
		}else{
			$x=1;
		}
		if(isset($getend)){
			$end_date_get=$getend.' 11:59:59';
		}else{
			$end_date_get='27-12-2020'.' 11:59:59';
		}
		
		
//$start_date='2020/09/25';
//$end_date='2020/12/26';


$start_date = DateTime::createFromFormat(
    'd-m-Y H:i:s',
    $start_date_get,
    new DateTimeZone('IST')
);


$start_timestamp =  $start_date->getTimestamp();

		$filename = 'studyadda_dec_'.date('Ymd').'.csv'; 
		 ob_clean();
		 ini_set('default_socket_timeout', 6000);
		 ini_set('max_execution_time', 6000);
		header('HTTP/1.1 200 OK');
        header('Cache-Control: no-cache, must-revalidate');
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$filename");
		
		$file = fopen('php://output','w');
		$headerdt = array("Start date - ".$start_datefee_download,"End date - ".$end_datefee_downlaod);
		
		fputcsv($file, $headerdt);	
		$headerdt = array("Start date - ".$start_datefee_download,"End date - ".$end_datefee_downlaod);
			
		
		$header = array("Name","Contact Number","1st Login Date","Payment Made (Yes/ No)","Payment Date (If Payment Made)","Course Selected","useruid");

		fputcsv($file, $header);		
		//118 
		$next_timestamp=$start_timestamp;
		$end_timestampend=strtotime('+'.$x.' days', $start_timestamp);
		
		$currentdate=date('d/m/Y', $next_timestamp);
        $currentdate_end=date('d/m/Y', $end_timestampend);		
	
		$appstudent_list = $this->Orders_model->getOnline_student($next_timestamp,$end_timestampend,'');
		
		
foreach($appstudent_list as $stkey=>$stvalue){
	$fullname='';
if(isset($stvalue->firstname)){
	$fullname .=$stvalue->firstname;
}
if(isset($stvalue->lastname)){
	$fullname .=$stvalue->lastname;
}

if(isset($stvalue->mobile)){
	$mobile =$stvalue->mobile;
}else{
	$mobile ='NA';
}
if(isset($stvalue->targate_exam)){
    $this->load->model('Examcategory_model');
	$targate_exam =$stvalue->targate_exam;
	$examatrray=explode('_',$targate_exam);
	$catname ='';
	if(count($examatrray)>0){ 
		foreach($examatrray as $exk=>$exv){
			$exnamearrayval=$this->Examcategory_model->getExamCatgeoryById($exv);
			$catname.=$exnamearrayval[0]->name.',';
		}
	}else{
		$exnamearrayval=$this->Examcategory_model->getExamCatgeoryById($targate_exam);
		$catname =$exnamearrayval[0]->name;
	}
}else{
	$targate_exam ='NA';
}
	
if(isset($stvalue->id)){
	$studentid = $stvalue->id;
	$cs_orderArray_check = $this->Orders_model->getOrderDetailsbyCid($studentid);
	if(isset($cs_orderArray_check)&&count($cs_orderArray_check)>0){
$cs_orderArray=$cs_orderArray_check;	
	}else{
	$cs_orderArray=array();
	}
}else{
	$studentid =0;
	$cs_orderArray=array();
}
$ostatus=0;
$ostatusname='NO';
$ocreated_dt ='NA';
foreach($cs_orderArray as $ordkey=>$ordVal){
	
$oprice=$ordVal->price;
$ostatus=$ordVal->status;
if(isset($ordVal->orderdate)){
	$ocreated_dt =date('d/m/Y', $ordVal->orderdate);
}else{
	$ocreated_dt ='NA';
}
$ostatusname='NO';
//Cancelled
if($ostatus==1){
$ostatusname='Yes';
//Success
break;
}	
}

if(isset($stvalue->created_dt)){
	//$created_dt =$stvalue->created_dt;	
	$created_dt =date('d/m/Y', $stvalue->created_dt);
}else{
	$created_dt ='NA';
}
  $studentname=$fullname;
		$logindate=$created_dt;
		$contactnumber=$mobile;
		$paymentmade=$ostatusname;
		$paymentdate=$ocreated_dt;
		$courseselected=$targate_exam;
		$student_Infoarray = array($studentname,$logindate,$contactnumber,$paymentmade,$paymentdate,$catname,$studentid);
	    fputcsv($file,$student_Infoarray); 
		}
		
		fclose($file); 
		exit;
	}
	

  	
public function download_xl_custorder($getstart,$getend){
	    ini_set('default_socket_timeout', 6000);
		ini_set('max_execution_time', 6000);
		if(isset($getstart)){
			$start_date=$getstart;
		}else{
			$start_date='30-11-2020';
		}
		
		if(isset($getend)){
			$end_date=$getend;
		}else{
			$end_date='27-12-2020';
		}
//$start_date='2020/09/25';
//$end_date='2020/12/26';


$start_date = DateTime::createFromFormat(
    'd-m-Y H:i:s',
    '30-11-2020 11:59:59',
    new DateTimeZone('IST')
);

$end_date = DateTime::createFromFormat(
    'd-m-Y H:i:s',
    '27-12-2020 11:59:59',
    new DateTimeZone('IST')
);

$start_timestamp =  $start_date->getTimestamp();

$end_timestamp = $end_date->getTimestamp();
	//echo $start_timestamp.'--'.$end_timestamp; die;	
	
		$filename = 'studyadda_dec_'.date('Ymd').'.csv'; 
		
		
		ob_clean();
		 ini_set('default_socket_timeout', 6000);
		 ini_set('max_execution_time', 6000);
		header('HTTP/1.1 200 OK');
        header('Cache-Control: no-cache, must-revalidate');
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$filename");
		
		$file = fopen('php://output','w');
		$headerdt = array("Start date - ".$start_datefee_download,"End date - ".$end_datefee_downlaod);
		
		fputcsv($file, $headerdt);	
		
		$header = array("S.No.","Name","Contact Number","1st Login Date","Payment Made (Yes/ No)","Payment Date (If Payment Made)","Course Selected","useruid");
		fputcsv($file, $header);	
		//118 
		for ($x = 1; $x < 26; $x++) {
		$next_timestamp=strtotime('+'.$x.' days', $start_timestamp);
		$end_timestampend=strtotime('+'.$x.' days', $end_timestamp);
		
		$currentdate=date('d/m/Y', $next_timestamp);
        $currentdate_end=date('d/m/Y', $end_timestampend);		
		//$student_list = $this->Orders_model->getOnline_student($next_timestamp);
		
		//$appstudent_list = $this->Orders_model->getOnline_student($next_timestamp,$end_timestampend,'');
		$appstudent_list = $this->Orders_model->getOnline_student($next_timestamp,$end_timestampend,'');
foreach($appstudent_list as $stkey=>$stvalue){
	$fullname='';
if(isset($stvalue->firstname)){
	$fullname .=$stvalue->firstname;
}
if(isset($stvalue->lastname)){
	$fullname .=$stvalue->lastname;
}

if(isset($stvalue->mobile)){
	$mobile =$stvalue->mobile;
}else{
	$mobile ='NA';
}
if(isset($stvalue->targate_exam)){
	$targate_exam =$stvalue->targate_exam;
}else{
	$targate_exam ='NA';
}
	
if(isset($stvalue->id)){
	$studentid = $stvalue->id;
	$cs_orderArray = $this->Orders_model->getOrderDetailsbyCid($studentid);
	if(isset($cs_orderArray)&&count($cs_orderArray)>0){
		
	}else{
	$cs_orderArray=array();
	}
}else{
	$studentid =0;
	$cs_orderArray=array();
}

foreach($cs_orderArray as $ordkey=>$ordVal){
$oprice=$ordVal->price;
$ostatus=$ordVal->status;
if(isset($ordVal->orderdate)){
	$ocreated_dt =date('d/m/Y', $ordVal->orderdate);
}else{
	$ocreated_dt ='NA';
}
$ostatusname='NO';
//Cancelled
if($ostatus==1){
$ostatusname='Yes';

//Success
break;
}	
}


if(isset($stvalue->created_dt)){
	//$created_dt =$stvalue->created_dt;
	
	$created_dt =date('d/m/Y', $stvalue->created_dt);
}else{
	$created_dt ='NA';
}
  $studentname=$fullname;
		$logindate=$created_dt;
		$contactnumber=$mobile;
		$paymentmade=$ostatusname;
		$paymentdate=$ocreated_dt;
		$courseselected=$targate_exam;
		$student_Infoarray = array($x,$studentname,$logindate,$contactnumber,$paymentmade,$paymentdate,$courseselected,$studentid);
		fputcsv($file,$student_Infoarray); 
		}
		}
		fclose($file); 
		exit;
	}
	
}

