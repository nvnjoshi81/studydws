<?php 
//print_r($isProduct_array);
foreach($isProduct_array as $isProduct){	
?>
<div class="row well well-sm well-lg">                   
    <div class="col-xs-12 col-md-3 text-center">
    <p class="detail_product_img" >    
    <div style="position: relative; text-align: center;color: Black;">
           <a href="<?php echo base_url('study-packages/' . '/' . url_title($isProduct->exam, '-', true) . '/' . $isProduct->exam_id) ?>#page-inner">
  <img src="<?php echo base_url('assets/frontend/product_images/studypackage_blank.png'); ?>" alt="studypackags" class="img-rounded img-responsive"> 
                                            </a>
        
  <span style="position: absolute;top: 52%;left: 1%;padding-left: 8px;padding-right: 8px; /*transform: translate(-50%, -50%);*/ "><h3><?php 
echo $isProduct->modules_item_name;
     ?></h3></span>
      </div>
      </p> 
    </div>
    <div class="col-xs-12 col-md-9 section-box">
        <h2>
            <?php echo $isProduct->modules_item_name; ?> 
        </h2>
        <?php if($isProduct->price>0){?>

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
<p class="buy_btn">
            <?php if (!$this->session->userdata('purchases') || !in_array_r($isProduct->id, $this->session->userdata('purchases'))) { ?>
                <button itemname="<?php echo $isProduct->modules_item_name; ?>" 
                        type="<?php echo $isProduct->type ?>" 
                        itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>" 
                        itemid="<?php echo $isProduct->id ?>"
                        itemqty="1"
                        offline='0'
                        action_type="1"
                        class="btn-lg btn-sm  btn-md btn btn-raised btn-success addtocart"
                        name="btnAddToCart">Buy Now</button>
                        <?php if ($isProduct->offline_status == 1) { ?>
                    <button itemname="<?php echo $isProduct->modules_item_name; ?>"  
                            type="<?php echo $isProduct->type ?>" 
                            itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>"itemid="<?php echo $isProduct->id ?>"
                            itemqty="1"
                            offline='1'
                            action_type="1"
                            class="btn-xs btn btn-raised btn-success addtocart"
                            name="btnAddToCart">Buy Offline</button>
                        <?php }
                        if ($isProduct->discounted_price > 0) {  ?>
    <!--<span class="text-danger" style="font-size:18px; font-weight: 300 "><b>Offer valid <?php echo $MACRO_OFFER_DATE; ?> Only.</b></span>-->
                        <?php }
                        }else{
                          ?>
    <a href="<?php echo base_url('study-packages/' . url_title($isProduct->exam, '-', true) . '/' . $isProduct->exam_id) ?>" title="studyadda" >
<button class="btn-lg btn-sm btn-md btn btn-raised btn-success" name="btnAlreadyExist">You have already bought this Package.</button></a><?php  
                        }
        ?>
        </p>
        <?php 
        }else{
        ?>
                 <button class="btn-lg btn-sm  btn-md btn btn-raised btn-success">NOT FOR SALE
                 </button>
                <?php
        } 
        if($isProduct->description!=''){
        ?>        
        <p class="product-description">
        <?php echo $isProduct->description; ?>      
        </p>
        <?php
        }
        ?>
        <div class="view_det_shop row">
                <?php if($isProduct->no_of_lectures>0){ ?>                
                <i class="material-icons">remove_red_eye</i>Number of Packages : <span> <strong><?php echo $isProduct->no_of_lectures; ?>+</strong> </span>
                 <i class="material-icons">update</i>Subscription Validity : <span> <strong><?php echo $isProduct->subscription_expiry; ?> Year(s)</strong> </span> 
                <?php } 
                 ?>
        </div>
        <p><span class="text-danger"><b>Note:<em color="red">Discount is available till 08 July 2020 only! Course amount Non-Refundable!</em></b></span>
        <ul>
        <li><b><i><span class="text-primary">The number of package may vary time to time.</span></i></b></li> 
                <li><b><i><span class="text-primary">Study packages are available in soft (PDF format) copy only. After buying you will be able to read over any android device (Mobile, tab etc.)</span></i></b></li>      
        </ul>           
        </p>
    </div>
</div>

<?php } ?>