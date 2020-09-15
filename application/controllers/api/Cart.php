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
class Cart extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->model('Shipping_model');
        //$this->load->model('Products_model');
        $this->load->model('Cart_model');
        $this->load->model('File_model');       
  
	$this->data['boltpayu'] = 'yes';
    }

    public function additem_post()
    {
        $this->cart->product_name_rules = '\d\D';
        $product_id=$this->input->post('id');
        $product_qty=$this->input->post('qty');
        $product_pricepost=$this->input->post('price');
		
        $product_name=$this->input->post('name');
        $offline=$this->input->post('offline');
		
		    $loginFranId=$this->session->userdata('loginFranId');
			if(isset($loginFranId)&&$loginFranId>0){
		$franchiseid=$this->session->userdata('loginFranId');
			}else{
        $franchiseid=$this->input->post('franchiseid');
			}
        //$type=$this->input->post('type');
        $usrid=$this->input->post('usrid');
        
        // check if added item is exist in cmspricelist table 
        $pricelist_info = $this->Cart_model->priclistItems($product_id);        
        
         /*//$pricelist_count = $this->Cart_model->getpriclistItems($product_id);
          //if(($pricelist_count=='')||($pricelist_count<1)){
            //$this->session->set_flashdata('message', 'There is some problem with the product you are trying to Buy.Please try again after some time.');
        //redirect(base_url('cart'));  
         // }
        */
        $imgsrc=NULL;
        if($pricelist_info[0]->image!=''){
          $imgsrc=base_url('/assets/frontend/product_images/'.$pricelist_info[0]->image);
        }else{
        if($pricelist_info[0]->type==1){
            $itemdetail_std = $this->File_model->getStudyPackageDetails($pricelist_info[0]->item_id);  
            if(isset($itemdetail_std)){
               $imgsrc=base_url('upload/webreader/'.$itemdetail_std->filename.'/docs/'.$itemdetail_std->filename_one.'_1_thumb.jpg'); 
            }
        }
        }
        $imagename=NULL;
        if(isset($pricelist_info[0]->image)&&$pricelist_info[0]->image!=''){
            $imagename=$pricelist_info[0]->image;
        }
		if(isset($pricelist_info[0]->discounted_price)&&$pricelist_info[0]->discounted_price>0){
        $product_priceTemp=$pricelist_info[0]->discounted_price;
        }elseif(isset($pricelist_info[0]->price)&&$pricelist_info[0]->price>0){
		$product_priceTemp=$pricelist_info[0]->price;
        }else{
		$product_priceTemp=$product_pricepost;
		}
		
		/*Give Descount if student through franchise*/
		
		$reduseprice=$product_priceTemp*10/100;
		
		if($franchiseid>0){
			$product_price=round($product_priceTemp-$reduseprice);
		}else{
			$product_price=$product_priceTemp;
		}	
		
		
        $msg='';
	if(!search_array($product_id, $this->cart->contents())){
        $item=array('id'=>$product_id,'qty'=>$product_qty,'price'=>$product_price,'name'=>$product_name,'item_id'=>$pricelist_info[0]->item_id,'franchiseid'=>$franchiseid,'options'=>array('offline'=>$offline));
	/*
         * 'modules_item_id'=>$pricelist_info[0]->modules_item_id,'image_name'=>$imagename,'image_src'=>$imgsrc,
         */	
        $this->cart->insert($item);
        
        }else{
            $msg='Item already in cart.';
        }	
        
	//$minicartcontent=$this->getMiniCart();
        //$response=array('minicartcontent'=>$minicartcontent,'items'=>count($this->cart->contents()),'total'=>$this->cart->total());
        $response=array('items'=>count($this->cart->contents()),'total'=>$this->cart->total(),'msg'=>$msg);
        if(isset($usrid)&&$usrid>0){
            $studentid=$usrid;
        }else{
            $studentid=$this->session->userdata('customer_id');
        }
        if(isset($studentid)&&$studentid>0){
           $this->usercart($studentid);
        }
        // Set the response and exit
        $this->response($response, REST_Controller::HTTP_OK); 
        // OK (200) being the HTTP response code  
    }
	public function getMiniCart(){
		$minicartcontent=null;
            foreach($this->cart->contents() as $items){
            $product = $this->Products_model->getProductDetails($items['id']); 
            $minicartcontent.='<div class="col-md-12 nopadding" id="pro_'.$items['rowid'].'">
            <div class="col-md-5 nopadding1">
                <a href="">'.show_thumb($product->image,200,200,'class="media-object" alt="'.$product->name.'"').'</a>
            </div>
            <div class="col-md-7 nopadding1">
                <h4 class="media-heading"><a href="">'.$items['name'].'</a></h4>
                <span>
				'.$items['price'].'&nbsp;'.'x'.'&nbsp;'.$items['qty'].'&nbsp;<span class="sprice">'. $this->config->item('currency').$items['qty']*$items['price'].'</span></span><a href="#" alt="Remove Item" title="Remove Item" class="removeitem" product_id="'.$items['id'].'" id="'.$items['rowid'].'"> <span class="glyphicon glyphicon-trash"></span></a><br></div>
        </div><br>';
			 } 
			$minicartcontent.='<br>
			<div align="right"><a class="btn btn-success" href="'.base_url().'checkout">Checkout</a></div>
		</div>';
		return $minicartcontent;
		}

    public function removeitem_post(){
        $rowid=$this->input->post('id');
        $this->cart->remove($rowid);
        $response=array('items'=>count($this->cart->contents()),'total'=>$this->cart->total());
        // Set the response and exit
        if($this->session->userdata('customer_id')){
           $this->usercart($this->session->userdata('customer_id'));
        }
        $this->response($response, REST_Controller::HTTP_OK); 
        // OK (200) being the HTTP response code
    }
    public function updateitem_post(){
        $rowid=$this->input->post('rowid');
        $qty=$this->input->post('qty');
        $data= array(
               'rowid' => $rowid,
               'qty'   => $qty
        );
        $this->cart->update($data);
        $cart_contents=$this->cart->contents();
        $updatedprice=$qty*$cart_contents[$rowid]['price'];
        $response=array('items'=>count($this->cart->contents()),'total'=>$this->cart->total(),'updatedprice'=>$updatedprice);
        // Set the response and exit
        if($this->session->userdata('customer_id')){
           $this->usercart($this->session->userdata('customer_id'));
        }
        $this->response($response, REST_Controller::HTTP_OK); 
        // OK (200) being the HTTP response code
    }
    
    public function usercart($user_id) {        
        $this->Customer_model->emptyCart($user_id);
        foreach ($this->cart->contents() as $item){           
             $addtocart=$this->Customer_model->addToCart($user_id,$item['id'],$item['qty'],$item['price'],$item['options']['offline']);  
             //$item['item_id'],$item['type'],$item['modules_item_id'],$item['image_name'],$item['image_src']
        }
    }
	public function userwishlist_post(){
		$id=$this->input->post('id');
		$product_name=$this->input->post('name');
		$user_id = $this->session->userdata('customer_id');
		$this->Customer_model->addToWishlist($user_id,$id,$product_name);
		
	}
	public function getshiping_get()
	{
		$weight=0;
		foreach($this->cart->contents() as $item){
			$weight+=$item['qty']*$item['weight'];
		}
                if($this->cart->total()>0){
		$totalamount=$this->cart->total();
                }else{
                $totalamount=0;    
                }
		$shipping_charges = $this->Shipping_model->getShippingCharge($weight,$totalamount);		
		$response=array('status'=>1,'charges'=>(int)$shipping_charges);
		$this->response($response, REST_Controller::HTTP_OK);
	}
}
