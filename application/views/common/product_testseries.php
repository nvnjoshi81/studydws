<?php   $priceDisplay=$this->config->item('priceDisplay');
//print_r($isProduct_array);
foreach($isProduct_array as $isProduct){
?>
<div class="row well well-sm well-lg">                   
    <div class="col-xs-12 col-md-3 text-center">
    <p class="detail_product_img" >    
    <div style="position: relative; text-align: center;color: Black;">
  <img src="<?php echo base_url('assets/frontend/product_images/testseries_blank.png'); ?>" alt="bootsnipp" class="img-rounded img-responsive"> 
  <span style="position: absolute;top: 52%;left: 1%;padding-left: 8px;padding-right: 8px;
        /*transform: translate(-50%, -50%);*/ "><h3><?php 
echo $isProduct->modules_item_name;
     ?></h3></span>
      </div>
      </p> 
    </div>
    <div class="col-xs-12 col-md-9 section-box">
        <h2>
            <?php echo $isProduct->modules_item_name; ?> 
        </h2>
        <?php  if($priceDisplay=='yes'){ if($isProduct->price>0){ 
        ?><div class="col-md-7">
<ul class="price_details row">
            <?php if ($isProduct->discounted_price > 0) {    ?>
                <li class="act-price col-xs-12 col-sm-6 col-md-6"> <small>Actual Price :</small> 
<del class="text-default"><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->price ?></strong></del> +</li>
                <li class="youpay-price col-xs-12 col-sm-6 col-md-6"> <small>Offer Price:</small> 
                    <span class="text-warning"><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->discounted_price ?></strong></span></li>
            <?php } else {
                ?><li class="youpay-price col-xs-12 col-sm-6 col-md-6"> 
                    <span class="text-warning"><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->price ?></strong></span></li>
            <?php
            }
            ?></ul></div>
        <div class="col-md-5">
<p class="buy_btn">
            <?php if (!$this->session->userdata('purchases') || !in_array_r($isProduct->id, $this->session->userdata('purchases'))) { ?>
                <button itemname="<?php echo $isProduct->modules_item_name; ?>" 
                        type="<?php echo $isProduct->type ?>" 
                        itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>" 
                        itemid="<?php echo $isProduct->id ?>"
                        itemqty="1"
                        offline='0'
                        action_type="1"
                        class="btn-md btn btn-raised btn-warning addtocart"
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
                        
                        } else{
                          ?><button 
                    class="btn-md btn btn-raised btn-success"
                    name="btnAlreadyExist">You Have Already Bought This Test Series</button><?php  
                        }    
                        
                        $testarray=array(22,23,28,29,77,78,79,30,24,72,73,31,38,37,36,35,34,33,32,102);
         if(in_array($isProduct->exam_id,$testarray)){               
                       $testexam='online-test/'.url_title($isProduct->exam, '-', true) . '/' . $isProduct->exam_id;    
                        ?>
              <a href="<?php echo base_url($testexam); ?>">
                <button 
                    class="btn-md btn btn-raised btn-success"
                    name="btnAlreadyExist">Start Test Series</button>
                </a>   <?php
        }
                ?>
        </p>
          </div>  
        <?php }else{
            ?>
                 <button class="btn-md btn btn-raised btn-warning">NOT FOR SALE
                 </button>
                <?php
        }  
}
        ?>
            <div class="view_det_shop row col-md-12"><?php
        if($isProduct->description!=''){
        ?>        
        <p class="product-description">
<?php echo $isProduct->description; 
?>  </p>
        <?php
        }
        ?></div>
            <div class="view_det_shop row col-md-12">
                <?php if($isProduct->no_of_lectures>0){ ?>                
                <i class="material-icons">remove_red_eye</i>Number of Test Papers : <span> <strong><?php echo $isProduct->no_of_lectures; ?>+</strong> </span>
                 <i class="material-icons">update</i>Subscription Validity : <span> <strong><?php echo $isProduct->subscription_expiry; ?> Year(s)</strong> </span> 
                <?php } 
                 ?>
            </div> <div class="col-md-12">
        <p>
            <span class="text-danger"><b>Note:<em color="red">Discount is available till 08 July 2020 only!Course amount Non-Refundable!</em></b></span>
        <ul>
        <li>
            <b>
            <i>
                <span class="text-primary">The number of Test Papers may vary time to time.
                </span>
            </i>
            </b>
        </li> 
        <li><b><i><span class="text-primary">
Test series is available in online format only. After buying you can attempt any test any number of times.After attending any test you will be able to analyse complete paper along with its answers key & solutions.A large number of analytical tools are also provided at the end of test.</span></i></b></li>      
        </ul>           
        </p></div>
    </div>
</div>

<?php } ?>