<?php 
class Cart_model extends CI_Model{
	
	function getCustomerCart($user_id)
	{
        $this->db->where('user_id',$user_id);
	$result=$this->db->get('cmscart');
        return $result->row();
        
	}
        
        function getFrCustCart($user_id){
        $this->db->select('uc.id,,uc.user_id,uc.cart_items,uc.cart_price,ci.quantity as qty, ci.cart_id,ci.product_id,ci.quantity,ci.price,p.modules_item_name as name,p.image');
        $result=$this->db->from('cmscart AS uc');
        $this->db->join('cmscart_items AS ci','uc.id = ci.cart_id','left');
        $this->db->join('cmspricelist AS p','p.id = ci.product_id','left');
	$this->db->where('uc.user_id',$user_id);
        $query = $this->db->get();        
        //echo $this->db->last_query();
	return $query->result();
        
        }

		
	
	function getCartPricelistId($getCartPricelistId){
        $this->db->select('DISTINCT(uc.user_id) as user_id,uc.id,uc.cart_items,uc.cart_price,ci.quantity as qty, ci.cart_id,ci.product_id,ci.quantity,ci.price,p.modules_item_name as name,p.image');
        $result=$this->db->from('cmscart AS uc');
        $this->db->join('cmscart_items AS ci','uc.id = ci.cart_id','left');
        $this->db->join('cmspricelist AS p','p.id = ci.product_id','left');
	$this->db->where('ci.product_id',$getCartPricelistId);
        $query = $this->db->get();        
        //echo $this->db->last_query();
	return $query->result();
        
        }

		function getCartItems($cart_id)
	{
		$this->db->select('id,cart_id,product_id,quantity,price,type,offline,modules_item_id,image_name,image_src,item_id,dt_created,dt_modified,start_time,end_time,end_date,status');
		$this->db->from('cmscart_items');
		$this->db->where('cart_id', $cart_id); 
		$query = $this->db->get();
		return $query->result();
	}
	public function removeCartItems($cart_id){
		$this->db->where('cart_id', $cart_id); 
		$this->db->delete('cmscart_items');
	}
	public function removeCart($cart_id,$user_id){
		$this->removeCartItems($cart_id);
		$this->db->where('user_id',$user_id);
		$this->db->where('id', $cart_id);
		$this->db->delete('cmscart');
	}
        public function appgetpriclistItems($itemid){
		$this->db->select('id');
		$this->db->from('cmspricelist');
		$this->db->where('price>0'); 
		$this->db->where('id',$itemid);
		$query = $this->db->get();
                //echo $this->db->last_query();
		return $query->num_rows();
	}
	public function getpriclistItems($itemid){
		$this->db->select('id');
		$this->db->from('cmspricelist');
		$this->db->where('item_id>0'); 
		$this->db->where('price>0'); 
		$this->db->where('id',$itemid);
		$query = $this->db->get();
                //echo $this->db->last_query();
		return $query->num_rows();
	}
        	public function getpriclistCount($itemid){
		$this->db->select('id');
		$this->db->from('cmspricelist'); 
		$this->db->where('price>0'); 
		$this->db->where('id',$itemid);
		$query = $this->db->get();
                //echo $this->db->last_query();
		return $query->num_rows();
	}
        
        public function priclistItems($itemid){
		$this->db->select('id,item_id,type,modules_item_id,image,app_image,price,discounted_price');
		$this->db->from('cmspricelist');
		$this->db->where('id',$itemid);
		$query = $this->db->get();
                //echo $this->db->last_query();
		return $query->result();
	}
        
        
}
?>