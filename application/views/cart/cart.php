<?php
function getCallbackUrl()
{
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . 'response.php';
}

 if($this->cart->total_items() > 1){
	 
 }else{
	 //redirect('/');
}
//print_r($this->cart->contents());

/**** Use: ****/
  
  //$data[] = array(  
     // 'id' => 2011509,
      //'qty' => 7777,
     // 'name' => 'nvn',
	 // 'options'=>array('offline'=>0),
      //'rowid' => 'dhedu3k3mhdu2nvn'
  //);
  //$this->cart->update_all($data);
  /*
  OR
  
  $data = array(
       array(
           'rowid' => 'dlk2jkduvk2d',
           'name' => 'world'
       ),
       array(
           'rowid' => 'dklg3h211kd',
           'price' => 25.50
       )
  );*/
  
  //$this->cart->update_all($data);
  
 
?>
<div class="container">
  <div class="row">
    <?php if($this->session->flashdata('update_msg')){ ?>
    <div class="alert alert-success alert-dismissible" id="success-alert" role="alert"> <strong><?php echo $this->session->flashdata('update_msg'); ?></strong> </div>
    <?php } 
	$this->load->view('common/breadcrumb');
    ?>
    <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
        
         ?>
    <?php if($this->cart->total_items()>0){ ?>
   <form name="checkout" id="checkout" method="post" action="<?php echo base_url('cart/confirm')?>">
    <div class="col-sm-12 col-md-9">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12  col-md-12">
              <div class="cart_container cart_center">
                <div class="totel-box">
                  <h2>
                    <label class="cart-count"><?php echo count($this->cart->contents()); ?></label>
                    item(s) in your Cart <i class="material-icons">shopping_cart</i> </h2>
                  <div class="cartValue">Total Cart Value : <span><i class="fa fa-inr"></i></span><span class="cartprice"> <?php echo $this->cart->total();?></span></div>
                </div>
              </div>
            </div>
          </div>
           <div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="cart_container">
                <div class="table-responsive">
                  <table class="table table-hover" cellspacing="10" cellpadding="10">
                    <tbody>
                      <?php                      
                        $i = 1;
                        $showdvd=false;
                        foreach($this->cart->contents() as $items){ 
                        $type=$this->Products_model->getProductType($items['id']); if($type->name=='Videos') $showdvd=true;?>
                        <tr id="pro_<?php echo $items['rowid']; ?>" class="cartitems">
                        <td>
                                 <div class="image_box"><?php //echo show_thumb($product->image,200,200,'class="media-object" alt="'.$product->name.'"')class="image_box"
                                 
                                 if(isset($items['image_src'])&&$items['image_src']!=''){
                                   ?>
                                     <img height="150px" width="200px" src="<?php echo $items['image_src']; ?>" alt="<?php echo $items['name'];?>" class="img-rounded img-responsive">
                                       <?php  
                                 }else{
                                     ?>
    <div style="position: relative; text-align: center; color: Black;" >
                                <img height="150px" width="200px"  src="<?php echo base_url('assets/frontend/product_images/studypackage_blank.png'); ?>" alt="<?php echo $items['name'];?>" class="img-rounded img-responsive"> 
    
<!--
<span style="position: absolute;
    top: 52%;
    left: 1%;
    padding-left: 8px;
    padding-right: 8px;
    text-wrap: none;
    /*transform: translate(-50%, -50%);*/">
      <h5>
     <?php 
//echo $items['name'];    
     ?></h5>
  </span>
  -->
  </div>
                                <?php
                                 }
                                 ?>
                                  </div>
                        </td>
                        
                           <td>
                                <div class="prod_panel"><a class="bold_txt" href="#">
                                    <?php echo $items['name'];?></a>
                                </div>
                            </td> 
                            <!--
                            <td>
                                <div class="quantity"><span>Qty</span>
                                    <input class="form-control quantity" name="" id="<?php echo $items['rowid']; ?>" value="<?php echo $items['qty']; ?>">
                                 </div>
                              </td>-->
                            <td>
                                <div class="bold_txt">
                                    <b> <span><?php echo $items['options']['offline']==1?'Online':"Online"; ?></span></b>
                                    <div class="red"></div>
                                </div>
                            </td>
                            <td>
                                <div class="price_area"> <i class="fa fa-inr"></i>
                                <label id="pprice_<?php echo $items['rowid']; ?>"> <?php echo $items['qty']*$items['price'];?></label>
                                <div class="clear"></div>
                            <!--<span class="strike" ><?php //echo $items['price'];?></span><br>-->
                            <!--<div class="discount">37%</div>-->
                                </div>
                            </td>
                            <td>
                                <div class="remove clear">
                                <a href="#" alt="Remove Item" title="Remove Item" class="removeitem" product_id="<?php echo $items['id']; ?>" id="<?php echo $items['rowid']; ?>">
                                <i class="material-icons"> delete_forever </i>
                                </a>
                                </div>
                            </td>
                      </tr>
                 
                      <!------hidden order------->
                      <!---/hidden order---------->
                      <?php $i++;
                              } ?>
                     
                    </tbody>
                  </table>
                </div>
              </div>
              <!--    <div class="pull-right"> <button type="button" class="btn btn-warning updatecart">Update Cart</button></div>-->
            </div>
              
          </div>
          
        </div>
          
      </div>
      <?php if($showdvd){ ?>
       <!-- <div class="col-md-8 checkbox">
           <label>
            <input type="checkbox" name="dvdreq" id="dvdreq">
          </label>
           You want DVD's for the videos ?
          
     
           
            <p class="text-warning"><i>You will not have access to online videos if you opt for DVD's.</i></p>
        </div>-->
      <?php } ?>
       
       <div class="col-sm-12 col-md-3 btn_cont_shop"> <a href="<?php echo base_url('videos');?>" class="btn btn-success btn-raised">Continue Shopping</a> 
       </div>
       <?php if(!$this->session->userdata('customer_id')){ ?>
       <!--<div class="col-md-3 pull-right">
            <a href="<?php echo base_url().'guest'; ?>" class="btn btn-success btn-raised">Guest Checkout</a>
           </div>-->
       <?php } ?>
       
       <div class="row pull-right btn_cont_shop"> <div class="clearfix"></div>
      <div class="col-md-2 col-sm-12"> 
          <?php if($this->session->userdata('customer_id')){ ?>
          <?php if(isset($default_address)){ ?>
                <button type="submit" onclick="checkdvd();" class="btn btn-success btn-raised">Pay Now</button> 
          <?php }else{  ?>
                <!--<a href="<?php echo base_url('customer/addaddress')?>" class="btn btn-success btn-raised">Checkout</a>-->
                  <button type="submit" onclick="checkdvd();" class="btn btn-success btn-raised ">Pay Now</button>
          <?php } 
          }else{ ?>
                <a href="<?php echo base_url('login')?>" class="btn btn-success btn-raised">Pay Now</a>
          <?php } ?>
                
        <input type="hidden" name="delivery_req" id="delivery_req" value="0">
      </div>
    </div>
    </div>
    <!-- right panel -->
    
    <div class="col-sm-12 col-md-3 del_add_det">
        <?php
        $show_address='no';
        if($show_address=='yes'){
        
        if($this->session->userdata('customer_id')){ ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title">Delivery Address</h3>
                </div>
                <div class="panel-body">
                    <?php if($default_address){?>
                    <div class="col-md-12 addr custaddrselected">
                        <div class="col-sm-12 col-md-2">
                          <input type="radio" addresszip="<?php echo $default_address->zipcode; ?>" class="shipping_address" checked id="confirm_shipping_id<?php echo $default_address->id; ?>" name="confirm_shipping_id" value="<?php echo $default_address->id; ?>">
                        </div>
                        <div class="col-sm-12 col-md-10">
                          <address>
                             <?php echo $default_address->address_name; ?><br>
                             <?php echo $default_address->address; ?> <br>
                             <?php echo $default_address->city_name; ?><br>
                             <?php echo $default_address->state_name; ?><br>
                             <?php echo $default_address->mobile; ?><br>
                             <?php echo $default_address->zipcode; ?><br>
                          </address>
                        </div>
                    </div>
                    <?php } ?>
                     <?php if(isset($other_addresses)){ ?>
                    <div id="other_addresses" style="display:none">
                        <?php foreach($other_addresses as $default_address) { ?>
                            <div class="col-md-12 addr custaddrselected">
                        <div class="col-sm-12 col-md-2">
                          <input type="radio" addresszip="<?php echo $default_address->zipcode; ?>" class="shipping_address" id="confirm_shipping_id<?php echo $default_address->id; ?>" name="confirm_shipping_id" value="<?php echo $default_address->id; ?>">
                        </div>
                        <div class="col-sm-12 col-md-10">
                          <address>
                             <?php echo $default_address->address_name; ?><br>
                             <?php echo $default_address->address; ?> <br>
                             <?php echo $default_address->city_name; ?><br>
                             <?php echo $default_address->state_name; ?><br>
                             <?php echo $default_address->mobile; ?><br>
                             <?php echo $default_address->zipcode; ?><br>
                          </address>
                        </div>
                    </div>
                        <?php } ?>
                    </div>
                     <?php } ?>
                  <hr />
                <div class="subtotalpayment" style="font-size:12px;">
                <?php if(isset($other_addresses)){ ?>
                <a href="javascript:void(0);" onclick="showaddress();">View All Addresses</a>
                <?php } ?>
                <a class="pull-right" href="<?php echo base_url('customer/addresses');?>"> Add New Address</a>
                </div>
                </div>
          </div>
    <?php } } ?>
      <div class="panel panel-primary">
          <div align="center">
              <div class="pull-right">    
                       <h3 class="panel-title"><input name="agree_terms" value="yes" checked="checked" type="checkbox"> &nbsp; Agree with the <a target="_blank" href="<?php echo base_url('payment_terms');?>">terms &amp; conditions</a></h3>
            </div>
          <h3 class="panel-title"><button type="submit" onclick="checkdvd();" class="btn btn-success btn-raised  hidden-sm hidden-xs">Pay Now</button> </h3><h4><span class="active">You can pay using:</span></h4>
        </div>
        <div class="panel-body">            
                
            <ul class="nav nav-pills pament_m">
                 <?php 
          $loginFranId = $this->session->userdata('loginFranId');
          if(($loginFranId>0)||($this->session->userdata('customer_id')=='1')||($this->session->userdata('customer_id')=='2')){ ?>
            <li>
                <label>
                    <input type="radio" checked  name="paymentmethod" id="cod" value="1">
                    Cash On Delivery
                </label>  
				
				<label>
                    <input type="radio"  name="paymentmethod" id="onlinepayment" value="2">
                      <b>Online Payment(DEBIT CARD/ CREDIT CARD/ INTERNET BANKING/ PAYTM/ FREECHARGE/ IDEA MONEY/ JIO MONEY/ MOBIKWIK/ OXIGEN WALLET)</b> 
                </label>
            </li>
    <?php  }else{ ?>
            <li>
                <label>
                <input type="hidden"  name="paymentmethod" id="onlinepayment" value="2">
                <b>Online Payment DEBIT CARD / CREDIT CARD/INTERNET BANKING/ PAYTM/ FREECHARGE/ IDEA MONEY/ JIO MONEY/ MOBIKWIK/ OXIGEN WALLET)</b>                </label>
            </li>	
			<?php } ?>
			
			 </form>

<?php if($this->session->userdata('customer_id')=='71696'){  ?>			 
		<li> 
		<form name="checkoutpayu" id="checkoutpayu" method="post" action="<?php echo base_url('cart/confirm')?>"><div align="center">
              <div class="pull-right">  <h3 class="panel-title"><button type="submit" class="btn btn-success btn-raised  hidden-sm hidden-xs">Pay Now</button> </h3>
                <label>
                <input type="hidden"  name="onlyccpayu" id="onlyccpayu" value="4">
                <b>DEBIT CARD / CREDIT CARD</b>
				</label>
				<form>
            </li>
	<?php } ?>
            </ul>    
      </div>
      </div>
       
    </div>
    <?php 
         if($this->session->userdata('customer_id')=='71696'){ 
             ?>
    <div class="col-sm-12 col-md-3 del_add_det">
        <!--PayUmoney Payment Option-->
         <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title">Pay By Credit/Debit Card</h3>
                </div>
             <div class="panel-body">
                 
  
	<form action="<?php echo base_url('customer/payUmoney_json'); ?>" id="payment_form">
    <input type="hidden" id="udf5" name="udf5" value="BOLT_KIT_PHP7" />
    <input type="hidden" id="surl" name="surl" value="<?php echo getCallbackUrl(); ?>" />
    <div class="dv">
    <span class="text"><label>Merchant Key:</label></span>
    <span><input type="hidden" id="key" name="key" placeholder="Merchant Key" value="x6QXVRnC" /></span>
    </div>
    
    <div class="dv">
    <span class="text"><label>Merchant Salt:</label></span>
    <span><input type="hidden" id="salt" name="salt" placeholder="Merchant Salt" value="iOtJ1bviwf" /></span>
    </div>
    <div class="dv">
    <span class="text"><label>Transaction/Order ID:</label></span>
    <span><input type="hidden" id="txnid" name="txnid" placeholder="Transaction ID" value="<?php echo  "Txn" . rand(10000,99999999)?>" /></span>
    </div>
    
    <div class="dv">
    <span class="text"><label>Amount:</label></span>
    <span><input type="text" id="amount" name="amount" placeholder="Amount" value="<?php echo $this->cart->total(); ?>" /></span>    
    </div>
    
    <div class="dv">
    <span class="text"><label>Product Info:</label></span>
    <span><input type="text" id="pinfo" name="pinfo" placeholder="Product Info" value="P01,P02" /></span>
    </div>
    
    <div class="dv">
    <span class="text"><label>First Name:</label></span>
    <span><input type="text" id="fname" name="fname" placeholder="First Name" value="Naveen" /></span>
    </div>
    
    <div class="dv">
    <span class="text"><label>Email ID:</label></span>
    <span><input type="text" id="email" name="email" placeholder="Email ID" value="naveen.synsoft@gmail.com" /></span>
    </div>
    <div class="dv">
    <span class="text"><label>Mobile/Cell Number:</label></span>
    <span><input type="text" id="mobile" name="mobile" placeholder="Mobile/Cell Number" value="943434343434" /></span>
    </div>
    <div class="dv">
    <span class="text"><label>Hash:</label></span>
    <span><input type="text" id="hash" name="hash" placeholder="Hash" value="" /></span>
    </div>
    <div><input type="submit" value="Pay" onclick="launchBOLT(); return false;" /></div>
	</form>
             </div>
         </div>
    </div>
    <?php }
    
         }else{ ?>
    <div class="col-md-12">
      <div class="panel panel-default well">
          <div class="panel-body ">
              <h3 class="center">Your shopping cart is empty</h3>
              <p><a class="btn btn-success btn-raised btn-lg" href="<?php echo base_url()?>">
                    Continue Shopping
                  </a></p>
          </div>
      </div>
    </div>
    <?php } ?>
    <div class="clearfix"></div>
	
	<?php
	
	
         if($this->session->userdata('customer_id')=='71696'){
            //print_r($this->cart->contents());
         
		          echo $this->session->userdata('customer_id') .'session customer<br><br>';
				 				  
		 }
		  $segTwo=$this->uri->segment(2);
if(isset($segTwo)&&$segTwo=='buynow'){
?> <div class="container">
   <div class="row"style="padding-left:499px;"><h4>You are beaing redirected.Please Wait....</h4>
   <p><img height="150" width="200" src="<?php echo base_url('/assets/frontend/images/msg-gif.gif'); ?>" alt="<?php echo $items['name'];?>" class="img-rounded img-responsive"></p>
   </div>
   </div>
  <script>
    //document.getElementById('checkout').submit(); // SUBMIT FORM
	document.checkout.submit();
</script>
</div>
	<?php 
	
	} 
	?>
  </div>
</div>
