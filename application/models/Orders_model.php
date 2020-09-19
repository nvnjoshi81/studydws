<?php
class Orders_model extends CI_Model {

    function entercity() {
        $this->db->select('*');
        $this->db->from('tbl_location');
        $query = $this->db->get();
        return $query->result();
    }

    function getOrders($limit_start = null, $limit_end = null,$ordercol=NULL,$order=NULL,$franchid=0) {
        if ($limit_start || $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
        $this->db->select('A.*,B.firstname,B.email,B.lastname,B.mobile,C.address,C.address_name');
        $this->db->from('cmsorders A');
        $this->db->join('cmscustomers B', 'A.user_id=B.id');
        $this->db->join('cmscustomer_addresses C', 'A.shipping_id=C.id');
        $this->db->order_by('A.id', 'desc');
		if($franchid>0){
		 $this->db->where('A.created_by', $franchid);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function getOrders_customerproduct($customerid,$productid) {
        $this->db->select('A.*,B.product_id');
        $this->db->from('cmsorders A');
        $this->db->join('cmsorder_details B', 'A.id=B.order_id');
        $this->db->order_by('A.id', 'desc');
		 $this->db->where('A.user_id', $customerid); 
		 $this->db->where('A.status',1);
         $this->db->where('B.product_id', $productid);
        $query = $this->db->get();
		 //echo $this->db->last_query();
        return $query->row();
    }
	
		
    function getCustOrderprod($orderid,$customerid,$productid) {
        $this->db->select('A.*,B.product_id,B.price,B.id as odid');
        $this->db->from('cmsorders A');
        $this->db->join('cmsorder_details B', 'A.id=B.order_id');
        $this->db->order_by('A.id', 'desc');
		 $this->db->where('A.user_id', $customerid); 
		 $this->db->where('A.id',$orderid);
         $this->db->where('B.product_id', $productid);
        $query = $this->db->get();
		 //echo $this->db->last_query();
		$orders_products_array=$query->row();
        return $orders_products_array;
		}
    
    function getProdOrders($limit_start = null, $limit_end = null,$product_id){
        if ($limit_start || $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
        $this->db->select('A.*,B.price,B.product_id,C.email,C.firstname,C.lastname,C.mobile');
        $this->db->from('cmsorders A');
        $this->db->where('B.product_id',$product_id);
        $this->db->where('A.status',1);
        $this->db->join('cmsorder_details B', 'A.id=B.order_id');
        $this->db->join('cmscustomers C', 'A.user_id=C.id');
        $this->db->order_by('A.id', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
        
    }
        function getsearchOrders($order_no,$franchid=0) {
		$this->db->select('A.*,B.firstname,B.lastname,B.email,B.mobile,C.address,C.address_name');
        $this->db->from('cmsorders A');
        $this->db->join('cmscustomers B', 'A.user_id=B.id');
        $this->db->join('cmscustomer_addresses C', 'A.shipping_id=C.id');
        $this->db->order_by('A.id', 'desc');
		if($franchid>0){
		 $this->db->where('A.created_by', $franchid);
        }
        $this->db->where('A.order_no', $order_no);
        $query = $this->db->get();
        return $query->result();
    }

        function getCsOrders($limit_start = null, $limit_end = null,$userid) {

			if ($limit_start || $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
		$this->db->select('A.*,B.firstname,B.lastname,B.email,B.mobile,C.address,C.address_name');
        $this->db->from('cmsorders A');
        $this->db->join('cmscustomers B','A.user_id=B.id');
        $this->db->join('cmscustomer_addresses C', 'A.shipping_id=C.id');
        $this->db->order_by('A.id', 'desc');
        $this->db->where('A.user_id', $userid);
        $query = $this->db->get();
        return $query->result();
    }
//$config["per_page"], $page,$ordercol,$userid
        function getCsOrdersCount($userid) {
		$this->db->select('A.*,B.firstname,B.lastname,B.email,B.mobile,C.address,C.address_name');
        $this->db->from('cmsorders A');
        $this->db->join('cmscustomers B', 'A.user_id=B.id');
        $this->db->join('cmscustomer_addresses C', 'A.shipping_id=C.id');
        $this->db->order_by('A.id', 'desc');
        $this->db->where('A.user_id', $userid);
        $query = $this->db->get();
        return $query->num_rows(); 
    }

function getsearchOrders_byid($order_id) {

        $this->db->select('A.*,B.firstname,B.lastname,B.mobile,B.email,C.address,C.address_name');
        $this->db->from('cmsorders A');
        $this->db->join('cmscustomers B', 'A.user_id=B.id');
        $this->db->join('cmscustomer_addresses C', 'A.shipping_id=C.id');
        $this->db->order_by('A.id', 'desc');
        $this->db->where('A.id', $order_id);
        $query = $this->db->get();
        return $query->result();
    }

    function getsearchOrdersByDate($fdate, $tdate,$orderby='all') {
        $this->db->select('A.*,B.firstname,B.lastname,B.email,B.mobile,C.address,C.address_name,A.app_order');
        $this->db->from('cmsorders A');
        $this->db->join('cmscustomers B', 'A.user_id=B.id');
        $this->db->join('cmscustomer_addresses C', 'A.shipping_id=C.id');
        $this->db->order_by('A.id', 'desc');
		if($orderby=='app'){
        $this->db->where('A.app_order',1);
		}
		if($orderby=='web'){
        $this->db->where('A.app_order',0);
		}
        $this->db->where('A.created_dt >=', $fdate);
        $this->db->where('A.created_dt <=', $tdate + 86439);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function getOrderDetails($id) {
        $this->db->select('*');
        $this->db->from('cmsorders');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getOrders_status() {
        $this->db->select('*');
        $this->db->from('cmsorders_status');
        $query = $this->db->get();
        return $query->row();
    }

    #########

    function getFullorderDetails($id) {
        $this->db->select('A.product_id,B.id,A.price as product_price,A.offline as offline,A.quantity,B.modules_item_name as name,B.price,B.discounted_price,B.type');
        $this->db->from('cmsorder_details A');
        $this->db->join('cmspricelist B', 'A.product_id=B.id');
        $this->db->where('A.order_id', $id);
        $order_details = $this->db->get();
        //echo $this->db->last_query();
        return $order_details->result();
    }
    
    #########
// For Order and order detail info
    function getComplitorderDetails($id,$franchid=0) {
        $this->db->select('A.product_id,B.id,A.price as product_price,A.offline as offline,A.quantity,B.modules_item_name as name,B.price,B.discounted_price,B.type,O.shipping_id,O.user_id,O.status,O.order_no,O.created_dt');
        $this->db->from('cmsorder_details A');
        $this->db->join('cmspricelist B', 'A.product_id=B.id');
        $this->db->join('cmsorders O', 'A.order_id=O.id');
		if($franchid>0){
		 $this->db->where('O.created_by', $franchid);
        }
		$this->db->where('A.order_id', $id);
        $order_details = $this->db->get();
        //echo $this->db->last_query();
        return $order_details->result();
    }
    #########
    function cust_last_order($customer_id){        
        $this->db->select('A.order_no,A.created_dt,A.final_amount,A.id,A.status');
        $this->db->from('cmsorders A');
        $this->db->where('A.user_id', $customer_id);
        $this->db->order_by('A.id', 'desc');
        $this->db->limit(0, 1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    
    #########

    function getMyOrders($customer_id, $limit_start = null, $limit_end = null) {
        if ($limit_start || $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
        $this->db->select('A.order_no,A.created_dt,A.final_amount,A.id,A.status,B.address_name');
        $this->db->from('cmsorders A');
        $this->db->join('cmscustomer_addresses B','A.shipping_id=B.id');
        $this->db->where('A.user_id', $customer_id);
        $this->db->order_by('A.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    #########
	
	
    function getOrdersproducts($customer_id, $limit_start = null, $limit_end = null) {
        if ($limit_start || $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
        $this->db->select('A.order_no,A.created_dt,A.final_amount,A.id,A.status,B.product_id');
        $this->db->from('cmsorders A');
        $this->db->join('cmsorder_details B','A.id=B.order_id');
        $this->db->where('A.user_id', $customer_id);
        $this->db->order_by('A.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

####################


    public function getAllOrdersCount($franchid=0) {
	if($franchid>0){
	$query = $this->db->query('SELECT * FROM cmsorders where created_by='.$franchid);
    return $query->num_rows();
	}else{    
    return $this->db->count_all('cmsorders');
    }
	}
	
	public function ordersCountByDate($start_date=0,$end_date=0,$orderby='all') {

        $this->db->select('id');
        $this->db->from('cmsorders');
        if($start_date==null){
            $start_date= strtotime(date('Y-m-d'))-(7*24*3600);
        }
		
            $this->db->where('created_dt > ',$start_date);
			
        if($end_date !=null){
            $this->db->where('created_dt <= ',$end_date);
        }
		
		
	if($orderby=='app'){
        $this->db->where('app_order',1);
		}
		if($orderby=='web'){
        $this->db->where('app_order',0);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
        return $query->num_rows();
	
	}
    
    public function getAllProdOrdersCount($pid) {
        $this->db->select('count(O.id) as cnt');
        $this->db->from('cmsorder_details A');
        $this->db->join('cmspricelist B', 'A.product_id=B.id');
        $this->db->join('cmsorders O', 'A.order_id=O.id');
        $this->db->where('A.product_id', $pid);
        $this->db->where('O.status',1);
        $order_details = $this->db->get();
        //echo $this->db->last_query();
        return $order_details->result();
    }

    public function getAllSearchOrdersCount($order_no) {
        $this->db->where('order_no', $order_no);
        $rs = $this->db->get('cmsorders');
        return $rs->num_rows();
    }

    #########

    public function updateDocket($order_id, $dataarray) {
        $this->db->where('id', $order_id);
        $this->db->update('cmsorders', $dataarray);
    }

    public function getPastOrdersCount($id) {
        $this->db->where('orderid', $id);
        $this->db->group_by('order_no');
        $rs = $this->db->get('order_tbl');
        return $rs->num_rows();
    }

    public function getPastorders($legacy_id, $limit_start = null, $limit_end = null) {
        if ($limit_start || $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
        $this->db->select('*');
        $this->db->from('order_tbl');
        $this->db->where('orderid', $legacy_id);
        $this->db->group_by('order_no');
        $this->db->order_by('order_date', 'desc');
        $past_orders = $this->db->get();
        return $past_orders->result();
    }

    public function getOrderNumber($order_no) {
        $this->db->select('order_no');
        $this->db->from('cmsorders');
        $this->db->where('order_no', $order_no);
        $order_no = $this->db->get();
        return $order_no->row();
    }

    // webadmin cancellation
    public function getOrderItems($order_id) {
        $this->db->select('*');
        $this->db->where('order_id', $order_id);
        $items = $this->db->get('cmsorder_details');
        return $items->result();
    }

    public function getOrderCount($from = null, $to = null) {
        if (empty($from) && empty($to)) {
            $this->db->where('created_dt >=', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
            $result = $this->db->get('cmsorders');
            return $result->num_rows();
        }
    }

    public function getSalesCount($from = null, $to = null) {
        if (empty($from) && empty($to)) {
            $this->db->select_sum('order_price');
            $this->db->where('created_dt >=', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
            $result = $this->db->get('cmsorders');
            $row = $result->row();
            return $row->order_price;
        }
    }

    public function getOrders_status_array() {

        $orders_status_array = array(
            '0' => (object) array('id' => '0', 'value' => '<span class="label label-info">Pending</span>'),
            '1' => (object) array('id' => '1', 'value' => '<span class="label label-success">Completed</span>'),
            '2' => (object) array('id' => '2', 'value' => '<span class="label label-danger">Cancelled</span>'),
            '3' => (object) array('id' => '3', 'value' => '<span class="label label-warning">Processing</span>')
        );
        return $orders_status_array;
    }
    public function update_orderdetail_price($id, $data) {

        $this->db->update('cmsorder_details', $data, array('id' => $id));
    }
    public function update_order_status($id, $data) {

        $this->db->update('cmsorders', $data, array('id' => $id));
    }

    public function transfer_order($orderid, $data) {

        $this->db->update('cmsorders', $data, array('id' => $orderid));
    }

    public function getOrderShippingAddress($customer_id) {
        $this->db->select('id');
        $this->db->from('cmscustomer_addresses');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('is_default', '1');
        $result = $this->db->get();
        $row = $result->row();
        return $row->id;
    }


    public function deleteCanOrd($orderid,$userid,$status='') {
	if($orderid>0&&($status==2||$status==0)){
		
	$this->db->where('user_id', $userid);	
	$this->db->where('id', $orderid); 
	$this->db->delete('cmsorders');
	
    $this->db->where('order_id', $orderid); 
	$this->db->delete('cmsorder_details');
	}else{
		die("Completed Order can not be deleted!");
		
	}
	
	}
	
	
    public function deleteOrdPrd($orderid,$userid,$productid) {
	if($orderid>0&&$userid>0&&$productid>0){
		
		        $this->db->select('id');
        $this->db->from('cmsorders');
       
            $this->db->where('id',$orderid);
			
            $this->db->where('user_id',$userid);
		$query = $this->db->get();
		//echo $this->db->last_query();
        $numroword=$query->num_rows();
	if($numroword>0){
		
		$orderarray=$query->row();
		$orderid=$orderarray->id;
		if($orderid==$orderid){
    $this->db->where('product_id', $productid);
    $this->db->where('order_id', $orderid); 
		$this->db->delete('cmsorder_details');
		}
	}
	
	}else{
		die("This Order product can not be deleted!");
		
	}
	
	}

    public function getCustomerDetails($user_id) {
        $this->db->select('*');
        $this->db->from('cmscustomers');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function orderbydate($start_date = null, $end_date = null,$franchiseid=0){
        $this->db->select('id');
        $this->db->from('cmsorders');
        if($start_date==null){
            $start_date= strtotime(date('Y-m-d'))-(7*24*3600);
            $this->db->where('created_dt > ',$start_date);
        }
        if($end_date !=null){
            $this->db->where('created_dt <= ',$end_date);
        }
		$query = $this->db->get();
		//echo $this->db->last_query();
        return $query->num_rows();
    }
    public function franchise_orderbydate($start_date = null, $end_date = null,$usertype=0,$franchiseid=0){
        $this->db->select('id');
        $this->db->from('cmsorders');
        if($start_date==null){
            $start_date= strtotime(date('Y-m-d'))-(7*24*3600);
            $this->db->where('created_dt > ',$start_date);
        }
        if($end_date !=null){
            $this->db->where('created_dt <= ',$end_date);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
	  public function franchise_totalorder($franchiseid=0,$status=''){
		   $this->db->select('id');
        $this->db->from('cmsorders'); 
	if($franchiseid>0){
        $this->db->where('created_by',$franchiseid);
	  }
	if($status>0){
        $this->db->where('status',$status);
	  }  
	  $query = $this->db->get();
        return $query->num_rows();
	  }
	

	public function monthlysales($start_date = null, $end_date = null,$usertype=0,$franchiseid=0){
   
    }
	
    
    public function total_earnings($franchiseid=0){
        $this->db->select_sum('order_price');
        $this->db->from('cmsorders');
		if($franchiseid>0){
        $this->db->where('created_by',$franchiseid);
		}
		$this->db->where('status','1');
        $query = $this->db->get();
        return $query->row();
    }
    
    public function sm_count_by_date($order_dt){
        $this->db->select('id');
        $this->db->from('cmsstudymaterial');
        $this->db->where('dt_created>', $order_dt);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function video_count_by_date($order_dt){
        $this->db->select('id');
        $this->db->from('cmsvideos');
        $this->db->where('dt_created>',$order_dt);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->num_rows();
    }

}

?>