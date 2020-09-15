<?php 
foreach($isProduct_array as $isPrdTest){
if($exam_id==$isPrdTest->exam_id){
	$subscription_expiry=$isPrdTest->subscription_expiry;
if($subscription_expiry>1){
	$validity=(int)$subscription_expiry;
}else{
	$validity=1;
}	
$isProdTestid=$isPrdTest->id;
							$customer_id=$this->session->userdata('customer_id');
							$order_result=$this->Orders_model->getOrders_customerproduct($customer_id,$isProdTestid);

					if(isset($order_result->id)&&($order_result->id>0))
                   {
$product_brought='yes';
				   }else{
$product_brought='no';
				   }
				   $orderInfo=$order_result;
				      if(isset($orderInfo)&&$product_brought=='yes'){ 
			$validity_years='+'.$validity.' years';
            $orderdate=$orderInfo->created_dt;
            $newTimestamp = strtotime($validity_years, $orderdate);
                ?>
        <div class="alert alert-info">
            <span class="copy">You have purchased this Course on <strong><?php echo date('d/M/Y', $orderdate); ?></strong>.Course  will not be available after <strong><?php echo date('d/M/Y', $newTimestamp);  ?></strong>.<strong><a href="<?php echo base_url('user/orderdetails/'.$orderInfo->id)?>" title="Studyadda Order - <?php echo $orderInfo->order_no ; ?>">View Order</a></strong> 
        </span></div>
        <?php 
       
}else{ 
?> 
<div class="row well well-sm well-lg">    <div class="col-xs-12 col-md-3 text-center">
    <p class="detail_product_img" >    
    <div style="position: relative; text-align: center;color: Black;">
  <img src="<?php echo base_url('assets/frontend/product_images/testseries_blank.png'); ?>" alt="bootsnipp" class="img-rounded img-responsive"> 
  <span style="position: absolute;top: 52%;left: 1%;padding-left: 8px;padding-right: 8px;/*transform: translate(-50%, -50%);*/ "><h3><?php 
echo $isPrdTest->modules_item_name;
     ?></h3></span>
      </div>
      </p> 
    </div>
    <div class="col-xs-12 col-md-9 section-box">
        <h2>
            <?php echo $isPrdTest->modules_item_name; ?> 
        </h2>
        <?php if($isPrdTest->price>0){?>

<ul class="price_details row">
            <?php if ($isPrdTest->discounted_price > 0) { ?>
                <li class="act-price col-xs-12 col-sm-6 col-md-6"> <small>Actual Price :</small> 

                    <del class="text-default"><strong><i class="fa fa-inr"> </i> <?php echo $isPrdTest->price ?></strong></del> +</li>
                <li class="youpay-price col-xs-12 col-sm-6 col-md-6"> <small>You Pay :</small> 
                    <span class="text-warning"><strong><i class="fa fa-inr"> </i> <?php echo $isPrdTest->discounted_price ?></strong></span></li>
            <?php } else {
                ?><li class="youpay-price col-xs-12 col-sm-6 col-md-6"> 
                    <span class="text-warning"><strong><i class="fa fa-inr"> </i> <?php echo $isPrdTest->price ?></strong></span></li>
            <?php
            }
            ?>
</ul>
<p class="buy_btn">
            <?php if (!$this->session->userdata('purchases') || !in_array_r($isPrdTest->id, $this->session->userdata('purchases'))) { ?>
                <button itemname="<?php echo $isPrdTest->modules_item_name; ?>" 
                        type="<?php echo $isPrdTest->type ?>" 
                        itemprice="<?php echo $isPrdTest->discounted_price > 0 ? $isPrdTest->discounted_price : $isPrdTest->price ?>" 
                        itemid="<?php echo $isPrdTest->id ?>"
                        itemqty="1"
                        offline='0'
                        action_type="1"
                        class="btn-md btn btn-raised btn-warning addtocart"
                        name="btnAddToCart">Buy Now</button>
                        <?php if ($isPrdTest->offline_status == 1) { ?>
                    <button itemname="<?php echo $isPrdTest->modules_item_name; ?>"  
                            type="<?php echo $isPrdTest->type ?>" 
                            itemprice="<?php echo $isPrdTest->discounted_price > 0 ? $isPrdTest->discounted_price : $isPrdTest->price ?>"                 
                            itemid="<?php echo $isPrdTest->id ?>"
                            itemqty="1"
                            offline='1'
                            action_type="1"
                            class="btn-xs btn btn-raised btn-warning addtocart"
                            name="btnAddToCart">Buy Offline</button>
                        <?php }
                        if ($isPrdTest->discounted_price > 0) {  ?>
    <!--<span class="text-danger" style="font-size:18px; font-weight: 300 "><b>Offer valid <?php echo $MACRO_OFFER_DATE; ?> Only.</b></span>-->
                        <?php }
                        }else{
                          ?>
<button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist">You Have Already Bought This Test Series</button><?php  
                        }                            
                             
        $testarray=array(22,23,28,29,77,78,79,30,24,72,73,31,38,37,36,35,34,33,32,102);
         if(in_array($isPrdTest->exam_id,$testarray)){    
                       $testexam='online-test/'.url_title($isPrdTest->exam, '-', true) . '/' . $isPrdTest->exam_id;    
                        ?>
                <a href="<?php echo base_url($testexam); ?>">
                <button 
                    class="btn-md btn btn-raised btn-success"
                    name="btnAlreadyExist">Start Test Series</button>
                </a>   <?php  
        }
        ?>
        </p>
        <?php 
        }else{
        ?>
                 <button class="btn-md btn btn-raised btn-warning">NOT FOR SALE
                 </button>
                <?php
        } 
        if($isPrdTest->description!=''){
        ?>        
        <p class="product-description">
        <?php echo $isPrdTest->description; ?>      
        </p>
        <?php
        }
        ?>
        <div class="view_det_shop row">
                <?php if($isPrdTest->no_of_lectures>0){ ?>                
                <i class="material-icons">remove_red_eye</i>Number of Test Papers : <span> <strong><?php echo $isPrdTest->no_of_lectures; ?>+</strong> </span>
                 <i class="material-icons">update</i>Subscription Validity : <span> <strong><?php echo $isPrdTest->subscription_expiry; ?> Year(s)</strong> </span> 
                <?php } 
                 ?>
        </div> 
        <p><span class="text-danger"><b>Note:</b></span>
        <ul>
        <li><b><i><span class="text-primary">The number of Test Papers may vary time to time.</span></i></b></li> 
        <li ><b><i><span class="text-primary">
Test series is available in online format only. After buying you can attempt any test any number of times.After attending any test you will be able to analyse complete paper along with its answers key & solutions.A large number of analytical tools are also provided at the end of test.</span></i></b></li>      
        </ul>    
        </p>
    </div>
</div>

<?php 
} 
}
} ?>