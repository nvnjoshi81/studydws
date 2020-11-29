
<style>
    .glyphicon { margin-right:5px;}
.section-box h2 { margin-top:0px;}
.section-box h2 a { font-size:15px; }
.glyphicon-heart { color:#e74c3c;}
.glyphicon-comment { color:#27ae60;}
.separator { padding-right:5px;padding-left:5px; }
.section-box hr {margin-top: 0;margin-bottom: 5px;border: 0;border-top: 1px solid rgb(199, 199, 199);}
</style>

            <div class="well">
                <div class="row">
                    
                      <?php
                      $videos_likes = 0;
                      $videos_views = 0;
                      $videos_duration = 0;
                      $videos_counts =0;
                      
                      if(isset($videos_inform)){
                      foreach($videos_inform as $videos_info)
                      {
                          $v_views =$videos_info->views;
                          $videos_views = $videos_likes+$v_views ;
                          
                          $v_duration =$videos_info->video_duration;
                          $videos_duration = $videos_duration+$v_duration ;
                          
                          $videos_counts =$videos_counts+1;
                          
                      }
                      }
                      //video_duration                      
                      ?>                    
                    <div class="col-xs-12 col-sm-4 col-md-4 text-center">
                      <p class="detail_product_img">  <?php if($isProduct->type==1 && $isProduct->item_id > 0){ ?>
                          <img src="<?php echo base_url('upload/webreader/'.$file->filename.'/docs/'.$file->filename.'.pdf_1_thumb.jpg')?>" class="img-responsive"/>
                      <?php }else{
                            echo getProductImage($isProduct->image);
                      }
                            ?> 
                      </p>
                      <?php
                      if($this -> router -> fetch_module()=='videos'){
                      ?>
                      <div class="view_det_shop row">
                       <p><i class="material-icons">videocam</i> Lectures : <span> <strong><?php echo $videos_counts; ?></strong></span> </p>
                      <p><i class="material-icons">schedule</i> Duration : <span> <strong><?php echo $videos_duration; ?></strong></span> </p>
                      <p><i class="material-icons">remove_red_eye</i> Views : <span> <strong><?php echo $videos_views; ?></strong> </span> </p>
                      <p> <i class="material-icons">favorite</i> Likes : <span> <strong><?php echo $videos_likes; ?></strong> </span> </p>
                          </div> 
                      <?php } ?>
                      
                        </div>
                   
                    <div class="col-xs-12 col-sm-8 col-md-8 section-box">
                        <h2>
                            <?php echo $isProduct->modules_item_name;?> 
                        </h2>
                        <?php if($isProduct->price>0){?>
                        <ul class="price_details row">
                        <?php if($isProduct->discounted_price > 0){ ?>
                        <li class="act-price col-xs-12 col-sm-6 col-md-6"> <small>Actual Price :</small> 
                            
                            <del class="text-default"><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->price?></strong></del> </li>
                        <li class="youpay-price col-xs-12 col-sm-6 col-md-6"> <small>Offer Price:</small> 
                         <span class="text-warning"><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->discounted_price?></strong></span></li>
    <?php }else{ 
       ?><li class="youpay-price col-xs-12 col-sm-6 col-md-6"> 
                         <span class="text-warning"><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->price?></strong></span></li>
           <?php
    }
    ?></ul>           
                        <p class="buy_btn">
                            <?php if(!$this->session->userdata('purchases') || !in_array_r($isProduct->id,$this->session->userdata('purchases'))){ ?>
                            <button itemname="<?php echo $isProduct->modules_item_name;?>" 
                type="<?php echo $isProduct->type?>" 
                itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price:$isProduct->price?>" 
                itemid="<?php echo $isProduct->id?>"
                itemqty="1"
                offline='1'
                action_type="1"
                class="btn-md btn btn-raised btn-success addtocart"
                name="btnAddToCart">Buy Online</button>
                        <?php if($isProduct->offline_status==1){ ?>
                <button itemname="<?php echo $isProduct->modules_item_name;?>"  
                type="<?php echo $isProduct->type?>" 
                itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price:$isProduct->price?>"                 
                itemid="<?php echo $isProduct->id?>"
                itemqty="1"
                offline='0'
                action_type="1"
                class="btn-xs btn btn-raised btn-success addtocart"
                name="btnAddToCart">Buy Offline</button>
                <?php } ?>
                <?php } else{
                    ?>
                             <button 
                class="btn-xs btn btn-raised btn-success"
                name="btnAlreadyExist">You have already brought this product</button>
                        <?php
                    
                }?>
                        </p>
                        <?php }else{
                            ?>
                               
                 <button class="btn-md btn btn-raised btn-success">NOT FOR SALE</button>
 <?php
                        } ?>
                        <p class="product-description">
                            <?php echo $isProduct->description; ?> 
                        </p><span class="text-danger"><b>Note:<em color="red"># Amount paid is non refundable/non adjustable.<br>
# Course runs only on Android app.<br>
# Course validity is 31st March 2023.<br>
# All study content is copyrighted content of studyadda. Copying, reproducing is strictly prohibited.
<br>#Course amount Non-Refundable!</em></b></span>
                        
                </div>
            </div>
        </div>

