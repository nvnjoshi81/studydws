<?php if(count($classiit) > 0){ ?>
<div class="col-xs-12 col-md-6">
<!-- product slide -->
    <div id="classiit" class="carousel slide product_slide_panel" data-ride="carousel">
    <!-- Controls -->
    <div class="col-lg-12 nopadding">
        <div class="col-xs-9 col-sm-9 col-md-9 nopadding">
            <h3>IIT JEE Video Lectures</h3>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 nopadding ">
            <?php if(count($classiit) > 3){ ?>
            <!-- Controls -->
            <div class="controls pull-right arrow_hm_bot_slider">
                <a data-slide="prev" href="#classiit" class="left fa fa-chevron-left btn btn-sm"></a>
                <a data-slide="next" href="#classiit" class="right fa fa-chevron-right btn btn-sm"></a>
            </div>
            <?php } ?>
        </div>
    </div> 
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <div class="row">
            <?php 
            if((count($classiit)>0)&&($classiit[0]!='')){
            $count=0; $cc=1;foreach($classiit as $product){ ?>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="col-item">
                    <div class="photo"> <img src="<?php echo base_url('assets/frontend/images/ebooks.png')?>" class="img-responsive" alt="a" /> </div>
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
                       
                        <a href="<?php echo getProductLink($product);?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>
                    </div>
                    <div class="clearfix"> </div>
                    </div>
                </div>
            </div>
            <?php 
            $count++; 
            $cc++;
            if($count==3 && (count($classiit) >= $cc)){
                    echo '</div></div><div class="item"><div class="row">';
		$count=0;
            } 
           
            }            
            } ?>
         </div>
         </div>
    </div>
  </div>
  
</div>
<?php } ?>
<?php if(count($classaipmt) > 0){ ?>
<div class="col-xs-12 col-md-6">
<!-- product slide -->
    <div id="classaipmt" class="carousel slide product_slide_panel" data-ride="carousel">
    <!-- Controls -->
    <div class="col-lg-12 nopadding">
        <div class="col-xs-9 col-sm-9 col-md-9 nopadding">
            <h3>NEET Video Lectures</h3>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 nopadding">
            <?php if(count($classaipmt) > 3){ ?>
            <!-- Controls -->
            <div class="controls pull-right arrow_hm_bot_slider">
                <a data-slide="prev" href="#classaipmt" class="left fa fa-chevron-left btn btn-sm"></a>
                <a data-slide="next" href="#classaipmt" class="right fa fa-chevron-right btn btn-sm"></a>
            </div>
            <?php } ?>
        </div>
    </div> 
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <div class="row">
            <?php 
            if((count($classaipmt)>0)&&($classaipmt[0]!='')){
            $count=0; $cc=1;foreach($classaipmt as $product){ ?>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="col-item">
                    <div class="photo"> <img src="<?php echo base_url('assets/frontend/images/ebooks.png')?>" class="img-responsive" alt="a" /> </div>
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
                       <a href="<?php echo getProductLink($product);?>" class="btn-lg btn btn-raised btn-warning">Buy Now</a>
                    </div>
                    <div class="clearfix"> </div>
                    </div>
                </div>
            </div>
            <?php 
            $count++; 
            $cc++;
            if($count==3 && (count($classaipmt) >= $cc)){
                    echo '</div></div><div class="item"><div class="row">';
		$count=0;
            }
            }            
            } ?>
         </div>
         </div>
    </div>
  </div>
  
</div>
<?php } ?>
<?php if(count($class12) > 0){ ?>
<div class="col-xs-12 col-md-6">
<!-- product slide -->
    <div id="class12" class="carousel slide product_slide_panel" data-ride="carousel">
    <!-- Controls -->
    <div class="col-lg-12 nopadding">
        <div class="col-xs-9 col-sm-9 col-md-9 nopadding">
            <h3>Class 12th Video Lectures</h3>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 nopadding">
            <?php if(count($class12) > 3){ ?>
            <!-- Controls -->
            <div class="controls pull-right arrow_hm_bot_slider">
                <a data-slide="prev" href="#class12" class="left fa fa-chevron-left btn btn-sm"></a>
                <a data-slide="next" href="#class12" class="right fa fa-chevron-right btn btn-sm"></a>
            </div>
            <?php } ?>
        </div>
    </div> 
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <div class="row">
            <?php 
            if((count($class12)>0)&&($class12[0]!='')){
            $count=0; $cc=1;foreach($class12 as $product){ ?>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="col-item">
                    <div class="photo"> 
                    <?php 
                            echo getProductImage($product->image);
                            ?>
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
                        
                        <a href="<?php echo getProductLink($product);?>" class="btn-lg btn btn-raised btn-warning">Buy Now</a>
                    </div>
                    <div class="clearfix"> </div>
                    </div>
                </div>
            </div>
            <?php 
            $count++; 
            $cc++;
            if($count==3 && (count($class12) >= $cc)){
                    echo '</div></div><div class="item"><div class="row">';
		$count=0;
            } 
           
            }            
            } ?>
         </div>
         </div>
    </div>
  </div>
  
</div>
<?php } ?>
<?php if(count($class11) > 0){ ?>
<div class="col-xs-12 col-md-6">
<!-- product slide -->
    <div id="class11" class="carousel slide product_slide_panel" data-ride="carousel">
    <!-- Controls -->
    <div class="col-lg-12 nopadding">
        <div class="col-xs-9 col-sm-9 col-md-9 nopadding">
            <h3>Class 11th Video Lectures</h3>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 nopadding">
            <?php if(count($class12) > 3){ ?>
            <!-- Controls -->
            <div class="controls pull-right arrow_hm_bot_slider">
                <a data-slide="prev" href="#class11" class="left fa fa-chevron-left btn btn-sm"></a>
                <a data-slide="next" href="#class11" class="right fa fa-chevron-right btn btn-sm"></a>
            </div>
            <?php } ?>
        </div>
    </div> 
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <div class="row">
            <?php 
            if((count($class11)>0)&&($class11[0]!='')){
            $count=0; $cc=1;foreach($class11 as $product){ ?>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="col-item">
                    <div class="photo"> <img src="<?php echo base_url('assets/frontend/images/ebooks.png')?>" class="img-responsive" alt="a" /> </div>
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
                        
                        <a href="<?php echo getProductLink($product);?>" class="btn-lg btn btn-raised btn-warning">Buy Now</a>
                    </div>
                    <div class="clearfix"> </div>
                    </div>
                </div>
            </div>
            <?php 
            $count++; 
            $cc++;
            if($count==3 && (count($class11) >= $cc)){
                    echo '</div></div><div class="item"><div class="row">';
		$count=0;
            } 
           
            }            
            } ?>
         </div>
         </div>
    </div>
  </div>
  
</div>
<?php } ?>