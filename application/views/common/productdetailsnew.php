<div class="Clearfix"></div> 
<?php 
$product_brought='no';
$subscription_expiry=$isProduct->subscription_expiry;
if($subscription_expiry>1){
	$validity=(int)$subscription_expiry;
}else{
	$validity=1;
}
 if ($isProduct->price > 0) { 
    $varblockNone='hideValidity';
    if (!$this->session->userdata('purchases') || !in_array_r($isProduct->id, $this->session->userdata('purchases'))) {
                                
                            }else{
                                if($isProduct->type==1){
                                $varblockNone='showValidity';
                       //If main product is brought we can enable download all products.
                                //WE do not display product if user has alredy puchased
                           }   
    }
     ?>

        <?php 
			$isProductid=$isProduct->id; 
							$customer_id=$this->session->userdata('customer_id');
							if(isset($customer_id)&&$customer_id>0){
									$order_result=$this->Orders_model->getOrders_customerproduct($customer_id,$isProductid); 	
		/*For getting main product buy or not*/
		if(isset($mainPrdlist[0]->productlist_id)){
			$mainPrdId=$mainPrdlist[0]->productlist_id;
		}else{
			$mainPrdId=$isProductid;
		}

		$order_result=$this->Orders_model->getOrders_customerproduct($customer_id,$mainPrdId);
		}else{
		$order_result=NULL;
		}
							
					if(isset($order_result->id)&&($order_result->id>0))
                   {
$product_brought='yes';
				   }else{					   
$product_brought='no';
				   }
				   
            if(isset($orderInfo)&&$product_brought=='yes'){ 
			$validity_years='+'.$validity.' years';
            $orderdate=$orderInfo->created_dt;
            $newTimestamp = strtotime($validity_years, $orderdate);
                ?><div class="row">
        <div class="alert alert-info">
            <span class="copy">You have purchased this Course on <strong><?php echo date('d/M/Y', $orderdate); ?></strong>.Course will not be available after <strong><?php echo date('d/M/Y', $newTimestamp);  ?></strong>.<strong><a href="<?php echo base_url('user/orderdetails/'.$orderInfo->id)?>" title="Studyadda Order - <?php echo $orderInfo->order_no ; ?>">View Order</a></strong> 
        </span></div>  <div class="clearfix"></div></div>
        <?php 
        }
        ?>

<div class="row">
    <?php
	
	if(isset($product_brought)&&$product_brought!='yes'){ 
    $this->session->set_userdata('sub_purchases','no');
    $videos_likes = 0;
    $videos_views = 0;
    $videos_duration = 0;
    $videos_counts = 0;
    if (isset($videos_inform)) {
        foreach ($videos_inform as $videos_info) {
            $v_views = $videos_info->views;
            $videos_views = $videos_likes + $v_views;
            $v_duration = $videos_info->video_duration;
            $videos_duration = $videos_duration + $v_duration;
            $videos_counts = $videos_counts + 1;
        }
    }
	
	
	if ($isProduct->discounted_price > 0) {
	$packagesprice=$isProduct->price;
		//$reduseprice=$packagesprice*10/100;									
		$reduseprice=$isProduct->discounted_price;
		if($franchise_id>0){
			$packagesprice=round($packagesprice-$reduseprice);
		}else{
			$packagesprice=$isProduct->price;
        }
}
	
	if($isProduct->image!=''&& file_exists($this->input->server('DOCUMENT_ROOT').'/assets/images/weball_product/'.$isProduct->image)){

	?> 


     <div id="content_allprod">
    <div id="showPackages">
	

	<!-- customize card -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="card card1">
		
		<img src="<?php echo base_url('assets/images/weball_product/'.$isProduct->image);?>" alt="<?php echo $isProduct->modules_item_name; ?>" class="img-responsive img-purchase1">
		
		<div class="card-title">
			<?php echo $isProduct->modules_item_name; ?>
		</div>
						  
	<?php if($reduseprice>0){ ?>
		<div class="show_price">
			<a href="#">Actual Price <span class='actul_price'><?php echo $packagesprice; ?></span></a>
			<a href="#">Offer Price <?php echo $reduseprice; ?></a>
		</div>
	<?php }else{ ?>
			<div class="show_price">
			<a href="#">Offer Price <?php echo $packagesprice; ?></a>
		</div>
	<?php } ?>
		
		
		
		<div class="btn-group1 text-center">
		    <?php 
			if (!$this->session->userdata('purchases') || !in_array_r($isProduct->id, $this->session->userdata('purchases'))||$product_brought=='no') { ?>
                <button  style='margin-bottom:6px;' itemname="<?php echo $isProduct->modules_item_name;?>" 
                        type="<?php echo $isProduct->type ?>" 
                        itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>" 
                        itemid="<?php echo $isProduct->id ?>"
                        itemqty="1"
                        offline='0'
                        action_type="1"
                        class="btn btn-primary cartleft addtocart"
                        name="btnAddToCart"><i class="material-icons">add_shopping_cart</i>Add To Cart</button><br>
						<!--For Buy now Action redirect="buynow" and offline='1'-->
						     <button itemname="<?php echo $isProduct->modules_item_name;?>" 
                        type="<?php echo $isProduct->type ?>" 
                        itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>" 
                        itemid="<?php echo $isProduct->id ?>"
                        itemqty="1"
                        offline='1'
                        action_type="1"
						redirect="buynow"					
                        class="btn btn-primary buyright addtocart"
                        name="btnAddToCart"><i class="material-icons">payment</i>&nbsp;&nbsp;&nbsp;&nbsp;Buy Now&nbsp;</button>
						
                        <?php if ($isProduct->offline_status == 1) { ?>
                    <button itemname="<?php echo $isProduct->modules_item_name; ?>"  
                            type="<?php echo $isProduct->type ?>" 
                            itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>"itemid="<?php echo $isProduct->id ?>"
                            itemqty="1"
                            offline='1'
                            action_type="1"
                            class="btn btn-primary cartleft addtocart"
                            name="btnAddToCart"><i class="material-icons">add_shopping_cart</i>Buy Offline</button>
                        <?php }                       
                        } else {			   
					   if($isProduct->type==1)
                   {
						 //If main product is brought we can enable download all products.
					
                       $this->session->set_userdata('sub_purchases','yes');
					
                           }else{
							    $this->session->set_userdata('sub_purchases','no');
						   }
                        ?>
                <button  class="btn btn-primary cartleft"
                    name="btnAlreadyExist">You have already bought this course</button>
                    <?php } 
                ?>
        </div>
		
			
		<hr class="card_divider1">
		<div class="card-body">
			
			<?php  
			if(isset($packagecnt_array)&&count($packagecnt_array)>0){
				$packagecnt=$packagecnt_array[$examid];
			?>				
			<div class="card-module text-capitalize text-center">
				<ul class="list-inline">
					<?php foreach($packagecnt as $keyval){ 	
					 if(isset($keyval->custom_total_package)&&$keyval->custom_total_package>0){ ?>
					<li class="list-group-item">
						<span><?php echo $keyval->custom_total_package; ?> +</span>
						<?php  
						 if(isset($keyval->module_type)&&$keyval->module_type!=''){?>
						<a href="#"><?php
$moduletype_array=explode('-',$keyval->module_type);
echo ucfirst($moduletype_array[0]).' '.ucfirst($moduletype_array[1]);
						; ?></a>
						<?php } ?>
					</li>
					 <?php } } ?>
			</ul>
			</div>
			<?php } ?>
			
			
			<hr class="card_divider2">		
		
		</div>
		
	</div>
</div></div>
</div>
<!-- //customize card -->






<?php $oldhide='no'; 
if($oldhide=='yes'){?>
	
<div class="row" id="floatingprice">
<div class="col-xs-12 col-md-12 text-center"  style="position: relative;
  text-align: center;
  color: white;">
  <img src="<?php echo base_url('assets/frontend/product_images/'.$isProduct->image); ?>" alt="studyadda" class="img-rounded img-responsive"> </div>
  <div class="top-right" style="position: absolute;
  top: 50px;
  right: 75px;">
<?php 
if($isProduct->price>0){ 
//buy now-
?>
<ul class="price_details row">
            <?php if ($isProduct->discounted_price > 0) { ?>
                <li class="act-price"> <font color="white" size="3" style="font-weight: bold;">Actual Price:</font>
                    <del class="text-default" style="color:white" ><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->price; ?></strong></del> <font color="white" size="3">+</font></li><br>
                <li class="youpay-price"> <font style="font-weight: bold;" color="white" size="3">Offer Price:&nbsp;&nbsp;&nbsp;</font> 
                    <span class="text-default" style="color:white;" ><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->discounted_price; ?></strong></span></li>
            <?php } else {
                ?><li class="youpay-price"> 
                    <span class="text-default" style="color:white;"><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->price; ?></strong></span></li>
            <?php
            }
            ?>
  <li>
<p class="buy_btn">
            <?php 
			if (!$this->session->userdata('purchases') || !in_array_r($isProduct->id, $this->session->userdata('purchases'))||$product_brought=='no') { ?>
                <button itemname="<?php echo $isProduct->modules_item_name;?>" 
                        type="<?php echo $isProduct->type ?>" 
                        itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>" 
                        itemid="<?php echo $isProduct->id ?>"
                        itemqty="1"
                        offline='0'
                        action_type="1"
                        class="btn-lg btn-sm  btn-md btn btn-raised btn-default addtocart"
                        name="btnAddToCart"><i class="material-icons">add_shopping_cart</i>Add To Cart</button><br>
						<!--For Buy now Action redirect="buynow" and offline='1'-->
						     <button itemname="<?php echo $isProduct->modules_item_name;?>" 
                        type="<?php echo $isProduct->type ?>" 
                        itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>" 
                        itemid="<?php echo $isProduct->id ?>"
                        itemqty="1"
                        offline='1'
                        action_type="1"
						redirect="buynow"					
                        class="btn-lg btn-sm  btn-md btn btn-raised btn-default addtocart"
                        name="btnAddToCart"><i class="material-icons">payment</i>&nbsp;&nbsp;&nbsp;&nbsp;Buy Now&nbsp;</button>
						
                        <?php if ($isProduct->offline_status == 1) { ?>
                    <button itemname="<?php echo $isProduct->modules_item_name; ?>"  
                            type="<?php echo $isProduct->type ?>" 
                            itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>"itemid="<?php echo $isProduct->id ?>"
                            itemqty="1"
                            offline='1'
                            action_type="1"
                            class="btn-xs btn btn-raised btn-warning addtocart"
                            name="btnAddToCart"><i class="material-icons">add_shopping_cart</i>Buy Offline</button>
                        <?php }                       
                        } else {			   
					   if($isProduct->type==1)
                   {
						 //If main product is brought we can enable download all products.
					
                       $this->session->set_userdata('sub_purchases','yes');
					
                           }else{
							    $this->session->set_userdata('sub_purchases','no');
						   }
                        ?>
                <button  class="btn-lg btn-sm  btn-md btn btn-raised btn-default "
                    name="btnAlreadyExist">You have already bought this course</button>
                    <?php } 
                ?>
        </p></li>
			</ul>
<?php

}else{
	//price not set
}

?>  </div>
</div>
	<!--DYNAMIC SECTION-->
	<?php
	}}
 }else{
	 
	if($product_brought=='no'){
    ?>                    
    <div class="col-xs-12 col-md-3 text-center">
        <p class="detail_product_img"> 
 <?php if ($isProduct->type == 1 && $isProduct->item_id > 0) { ?>
                <img src="<?php echo base_url('upload/webreader/' . $file->filename . '/docs/' . $file->filename . '.pdf_1_thumb.jpg') ?>" class="img-responsive"/>
<?php
} else {
        if($this->router->fetch_module()=='study-material'||$this->router->fetch_module()=='exams'){
        //echo getProductImage('studypackage_blank.png');
         ?>
		 
<div style="position: relative;
    text-align: center;
    color: Black;">
  <img src="<?php echo base_url('assets/frontend/product_images/studypackage_blank.png'); ?>" alt="studyadda" class="img-rounded img-responsive"> 
  <span style="position: absolute;
    top: 52%;
    left: 1%;
    padding-left: 8px;
    padding-right: 8px;"><h3><?php 
   

echo $isProduct->modules_item_name;
    
     ?></h3></span>
      </div>
            <?php
        }else{
            echo getProductImage($isProduct->image);          
        
        }
}
?> 
        </p>

    </div>
    <div class="col-xs-12 col-md-9 section-box">
        <h2>
            <?php echo $isProduct->modules_item_name; ?> 
        </h2>
      
        <?php 
        if($isProduct->price>0){ ?>
  <div class="col-md-8">
<ul class="price_details row">
            <?php if ($isProduct->discounted_price > 0) { ?>
                <li class="act-price col-xs-12 col-sm-6 col-md-6"> <small>Actual Price :</small> 
                    <del class="text-default"><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->price ?></strong></del> +</li>
                <li class="youpay-price col-xs-12 col-sm-6 col-md-6"> <small>Offer Price:</small> 
                    <span class="text-warning"><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->discounted_price ?></strong></span></li>
            <?php } else {
                ?><li class="youpay-price col-xs-12 col-sm-6 col-md-6"> 
                    <span class="text-warning"><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->price ?></strong></span></li>
            <?php
            }
            ?></ul>
  </div>
  
  <div class="col-md-4">
<p class="buy_btn">
            <?php 
			if (!$this->session->userdata('purchases') || !in_array_r($isProduct->id, $this->session->userdata('purchases'))||$product_brought=='no') { ?>
                <button itemname="<?php echo $isProduct->modules_item_name;?>" 
                        type="<?php echo $isProduct->type ?>" 
                        itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>" 
                        itemid="<?php echo $isProduct->id ?>"
                        itemqty="1"
                        offline='0'
                        action_type="1"
                        class="btn-lg btn-sm  btn-md btn btn-raised btn-warning addtocart"
                        name="btnAddToCart">Buy Now</button>
                        <?php if ($isProduct->offline_status == 1) { ?>
                    <button itemname="<?php echo $isProduct->modules_item_name; ?>"  
                            type="<?php echo $isProduct->type ?>" 
                            itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>"                 
                            itemid="<?php echo $isProduct->id ?>"
                            itemqty="1"
                            offline='1'
                            action_type="1"
                            class="btn-xs btn btn-raised btn-warning addtocart"
                            name="btnAddToCart">Buy Offline</button>
                        <?php }
                        if ($isProduct->discounted_price > 0) {  ?>
    <!--<span class="text-danger" style="font-size:18px; font-weight: 300 "><b>Offer valid <?php echo $MACRO_OFFER_DATE; ?> Only.</b></span>-->
                        <?php } 
                        
                        } else {			   
					   if($isProduct->type==1)
                   {
						 //If main product is brought we can enable download all products.
					
                       $this->session->set_userdata('sub_purchases','yes');
					
                           }else{
							    $this->session->set_userdata('sub_purchases','no');
						   }
                        ?>
                <button  class="btn-xs btn btn-raised btn-success"
                    name="btnAlreadyExist">You have already bought this course</button>
                    <?php } 
                ?>
        </p></div>
        <?php }else{
            ?>
                 <button class="btn-md btn-lg btn-sm  btn btn-raised btn-warning">NOT FOR SALE
                 </button>
                <?php
            
        }
        ?><?php
        if($isProduct->description!=''){
        ?>
               
        <p class="product-description">
<?php echo $isProduct->description; 

?> 
        </p>
        <?php
        }
        if ($this->router->fetch_module() == 'videos') {
            ?>
            <div class="view_det_shop row">
               <?php if($isProduct->no_of_dvds!=''&&($exam_id!=30&&$exam_id!=24)){ ?>
                <i class="material-icons">check</i> DVD's  : <span> <strong><?php echo $isProduct->no_of_dvds; ?></strong></span>
               <?php } 
                if($isProduct->lecture_duration){ ?><i class="material-icons">schedule</i> Lectures Duration: <span> <strong><?php echo  $isProduct->lecture_duration; ?></strong></span> <?php } 
                if($isProduct->no_of_lectures!=''){ ?>
                <i class="material-icons">remove_red_eye</i> Number of Lectures : <span> <strong><?php echo $isProduct->no_of_lectures; ?>+</strong> </span>
                <?php  } 
                if($isProduct->subscription_expiry!=''){
?>
                 <i class="material-icons">update</i> Subscription Validity : <span> <strong><?php echo $isProduct->subscription_expiry; ?> Year(s)</strong> </span> 
                <?php }  if($isProduct->no_of_subscribers!=''){ ?>
                 <i class="material-icons">people</i> Total Subscribers : <span> <strong><?php echo $isProduct->no_of_subscribers; ?></strong> </span> 
                <?php } ?>
            </div> 
        <?php }
        
        if($this->router->fetch_module()=='study-material'||$this->router->fetch_module()=='exams'){
        ?>  <div class="view_det_shop row">
                <?php if($isProduct->no_of_lectures>0){ ?>                
              <i class="material-icons">remove_red_eye</i>Number of Packages : <span> <strong><?php echo $isProduct->no_of_lectures; ?>+</strong> </span>
                 <i class="material-icons">update</i>Subscription Validity : <span> <strong><?php echo $isProduct->subscription_expiry; ?> Year(s)</strong> </span> 
                <?php } 
                 ?>
            </div>                       
        <?php
        }
        ?>
        <!--<hr/>
        <div class="row rating-desc">
            <div class="col-md-12">
                <span class="glyphicon glyphicon-heart"></span><span class="glyphicon glyphicon-heart">
                </span><span class="glyphicon glyphicon-heart"></span><span class="glyphicon glyphicon-heart">
                </span><span class="glyphicon glyphicon-heart"></span>(36)<span class="separator">|</span>
                <span class="glyphicon glyphicon-comment"></span>(100 Comments)
            </div>
        </div>
    </div>-->
        <p>
            <span class="text-danger"><b>Note:
 <em color="red">Discount is available till 08 July 2020 only! Course amount Non-Refundable!</em></b></span>
        <ul>
            <?php 
        if($this->router->fetch_module() == 'videos') {
             ?>
                          <li><b><i><span class="text-primary">The number of DVD's and Lectures in the package may differ from the numbers shown.</span></i></b></li>
                          <li><b><i><span class="text-primary">To all the subscribers of video courses of Lalit sardana Sir & Shweta Sardana Madam study packages, Sample Papers, Solved Papers of relevant target exam will be provided by studyadda as a complementary.</span></i></b></li> 
          <?php  }else{ ?>
                <li><b><i><span class="text-primary">The number of package may vary time to time.</span></i></b></li> 
                <li><b><i><span class="text-primary">Study packages are available in soft (PDF format) copy only. After buying you will be able to read over any android device (Mobile, tab etc.)</span></i></b></li>   
       <?php } ?>
        </ul>           
        </p>
    </div>

 <?php } } ?> </div>
<?php } ?>