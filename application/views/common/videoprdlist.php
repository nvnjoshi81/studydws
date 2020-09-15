    <div class="row vid_list"><h3>This video series is available in following courses</h3>
    <?php if(count($mproducts)){ foreach($mproducts as $key=>$product){ if($product){ ?> 
        
        <div class="col-xs-12 col-sm-6 col-md-4" style="padding-bottom: 10px">
     <div class="col-item">
         <div class="photo">
              <?php if($product->type==1 && $product->item_id > 0){ ?>
                  <img src="<?php echo base_url('upload/webreader/'.$product->filename.'/docs/'.$product->filename.'.pdf_1_thumb.jpg')?>" class="img-responsive"/>
                  <?php }else{ 
                      echo getProductImage($product->image);
                      ?>
                  <?php } ?>
         </div>
                    <div class="info">
                    <div class="row">
                        <div class="price col-xs-12 col-md-12">
                            <h5 class="vid_prod_hed"><?php echo $product->modules_item_name; ?></h5>
                            <h5 class="price-text-color">&nbsp; <?php if($product->discounted_price > 0){ ?>
                            <i class="fa fa-inr"> </i>  
                            <del class="del_txt"> <?php echo $product->price?></del> 
                            <?php echo $product->discounted_price;
                            }else{
                                echo $product->price;
                            }
                            ?> 
                            </h5>
                        </div>
                    <!--<div class="rating hidden-sm col-md-6"> <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star"> </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star"> </i><i class="fa fa-star"></i> </div>-->
                        
                    </div>
                    <div class="separator btn_prod_ved">
                       <!--
                        <a href="<?php echo getProductLink($product);?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>
                        
                        
                        -->
                            <button itemname="<?php //echo $product->modules_item_name; ?>" 
                        type="<?php //echo $product->type ?>" 
                        itemprice="<?php //echo $product->discounted_price > 0 ? $product->discounted_price : $product->price ?>" 
                        itemid="<?php //echo $product->id ?>"
                        itemqty="1"
                        offline='0'
                        action_type="1"
                        class="btn-md btn btn-raised btn-warning addtocart"
                        name="btnAddToCart">Buy Online</button>
                        
                        
                    </div>
                    <div class="clearfix"> </div>
                    </div>
                </div>
     </div> 
    <?php } } }?> 
     
     
    
    </div>