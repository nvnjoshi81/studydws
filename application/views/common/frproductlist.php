<?php
$this->load->helper('text');
//echo $studentid.'..rrr..'.$studentemail;
if(isset($frCustomerCart)){
$countCart=count($frCustomerCart);
}else{
	$countCart=0;
}
 if($countCart>0){ ?>
    <div class="col-sm-12 col-md-9">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12  col-md-12">
              <div class="cart_container cart_center">
                <div class="totel-box">
                  <h2>
                    <label class="cart-count"><?php echo $countCart;?></label>
                    item(s)for <a class="bold_txt" href="#"><?php echo  urldecode($studentemail); ?>  <i class="fa fa-shopping-cart"></i></a></h2>
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
                            //print_r($frCustomerCart); die;                  
                        $i = 1;
                        $showdvd=false;
                        for($ip=0;count($frCustomerCart)>$ip;$ip++){
                            $catList=$frCustomerCart[$ip];
                        $type=$this->Products_model->getProductType($catList->id); ?>
                        <tr id="pro_" class="cartitems">
                        <td>
                                 <div class="image_box"><div style="position: relative; text-align: center; color: Black;" >
                                <img height="50px" width="50px"  src="<?php echo base_url('assets/frontend/product_images/studypackage_blank.png'); ?>" alt="<?php echo $catList->name;?>" class="img-rounded img-responsive"> </div>
                                  </div>
                        </td>
                        
                           <td>
                                <div class="prod_panel"><a class="bold_txt" href="#">
                                    <?php echo $catList->name;?></a>
                                </div>
                            </td>                          
                            <td>
                                <div class="bold_txt">
                                    <b> <span><?php //echo $frCustomerCart->options['offline']==1?'Online':"Online"; ?></span></b>
                                    <div class="red"></div>
                                </div>
                            </td>
                            <td>
                                <div class="price_area"> <i class="fa fa-inr"></i>
                                <label id="pprice_<?php //echo $items['rowid']; ?>"> <?php echo $catList->qty*$catList->price;?></label>
                                <div class="clear"></div>
                                </div>
                            </td>
                            <td>
                                <div class="remove clear">
                                <a href="#" alt="Remove Item" title="Remove Item" class="removeitem" product_id="<?php echo $catList->id; ?>" id="<?php //echo $items['rowid']; ?>">
                                <i class="fa fa-times-circle"></i> 
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
       <div class="col-sm-12 col-md-3 btn_cont_shop"> 
           
            <?php $ferEncodeUrl=base_url().$folder_admin.'/add_order/frOrderprocess'; ?>
                                        <form name="frOrder" id="frOrder" method="POST" action="<?php echo $ferEncodeUrl ;?>" >                   
                                        <input type="hidden" name="studentid" value="<?php echo urlencode($studentid);?>" >
                                        <input type="hidden" name="studentemail" value="<?php echo urlencode($studentemail);?>" >
                                        <input type="submit" class="btn btn-success btn-raised" value="Create Order" name="create_order">
                                        </form>
                  <div class="cartValue">Total Amount : <span><i class="fa fa-inr"></i></span><span class="cartprice"> <?php echo $this->cart->total();?></span></div>
       </div>
       <div class="row pull-right btn_cont_shop"> <div class="clearfix"></div>
      <div class="col-md-2 col-sm-12"> 
        
      </div>
    </div>
    </div>
<?php
 }
if (isset($productslist)&&count($productslist) > 0) {
    $heading_video_exam='';
    $heading_studymaterial_exam='';
    $heading_exam=''; 
    $showAllUrl='';
         foreach ($productslist as $product_heading) { 
                        if ($product_heading->type == '2') {
                            $heading_video_exam='Video Lectures';
                            $showAllUrl=base_url('videos/'.$this->uri->segment(2).'/'.$this->uri->segment(3));
                        }
                        if ($product_heading->type == '1') {
                            $heading_studymaterial_exam='Study Packages';
                            $showAllUrl=base_url('study-packages/'.$this->uri->segment(2).'/'.$this->uri->segment(3));
                        }
                       // echo $heading_video_exam.'---'.$heading_studymaterial_exam.'=='.$product_heading->type; die;
                        if($heading_video_exam!=''&&$heading_studymaterial_exam!=''){
                            $heading_exam ='Videos and Study Packages';
                        }elseif ($heading_video_exam!='') {
                
                            $heading_exam='Video Lectures';
                        }elseif ($heading_studymaterial_exam!='') {                
                            $heading_exam='Study Packages';            
                        }
         }
    ?>
    <div class="col-xs-12 col-md-12 prod_list_exam">
        <div class="col-md-12 text-center bavl"><h2> 
         <?php 
         $testHeading='Recent ';
         if($this->uri->total_segments()==3){
            $testHeading='Recent '; 
         }
        echo  $heading_exam ;
?>
</h2></div>
        <!-- product slide -->

        <!-- Controls -->

        <!-- Wrapper for slides -->

</div>
        <div class="row">
            <?php
            if ((count($productslist) > 0) && ($productslist[0] != '')) {
                $count = 0;
                foreach ($productslist as $product) {
                    $image = 'assets/frontend/images/ebooks.png';
                    if (isset($product->image) && $product->image != '') {
                        $image = $product->image;
                    }
                    $type = '';
                    if ($this->uri->segment(1) == 'exams') {
                        if ($product->type == '2') {
                            $type = strtolower('videos');
                        }
                        if ($product->type == '1') {
                            $type = strtolower('study-packages');
                        }
                    } else {
                        $type = $this->uri->segment(1);
                    }
                    ?>
            <div class="col-xs-6 col-sm-4 col-md-3">
                        <div class="thumbnail">
                                <div class="row">
                                    <div class="price col-xs-12 col-md-12">
                                        <?php if ($product->type == '2') {
                                            ?> <h5 class="vid_prod_hed"><?php echo character_limiter($product->modules_item_name, 50); ?></h5>

                                        <?php } else {
                                            ?>
                                            <h5 class="vid_prod_hed"><?php echo character_limiter($product->displayname ? $product->displayname : $product->modules_item_name, 50); ?></h5>
                                        <?php }
                                        ?>
                                           
                                    </div>
                                </div>
            <?php if ($product->price > 0) { ?> 
                                    <div class="separator btn_prod_ved">

                                        <p class="buy_btn">
                                            <?php
                                            if (isset($product->displayname) && ($product->displayname != '')) {
                                                $product_name = $product->displayname;
                                            } else {

                                                $product_name = $product->modules_item_name;
                                            }
                             
                                                ?>
                                                <?php if ($product->price > 0) { ?>        
                                             <div class="price"><h5 class="price-text-color">&nbsp; <?php if ($product->discounted_price > 0) {
                                                    ?>
                                            <i class="fa fa-inr"> </i> 
                                            <del class="del_txt"> <?php echo $product->price ?></del> <?php
                                                    echo $product->discounted_price;
                                                } else {
                                                    echo $product->price;
                                                }
                                                ?> </h5>  </div>
            <?php } ?>   <?php $addToCartUrl=base_url().$folder_admin.'/add_order/addToCart'; ?>
                                        <form name="frOrder" id="frOrder" method="POST" action="<?php echo $addToCartUrl ;?>" >
                                                <button itemname="<?php echo $product_name; ?>" 
                                                        type="<?php echo $product->type ?>" 
                                                        itemprice="<?php echo $product->discounted_price > 0 ? $product->discounted_price : $product->price ?>"                                                         
														itemid="<?php echo $product->productlist_id ?>"                                     itemqty="1"
                                                        offline='0'
                                                        action_type="1" 
														usrid="<?php echo $studentid ; ?>"
                                                        class="btn-md btn btn-raised btn-warning addtocart" name="btnAddToCart">Buy Now</button>
														</form>
                                            <?php  
                                            
                                            ?>
                                        </p>
                                    </div>
                                <?php } else {
                                    ?>
                                    <button class="btn-md btn btn-raised btn-warning">NOT FOR SALE</button>
                                <?php }
                                ?>
                                <div class="clearfix"> </div>
                            </div>
                    </div>
                    <?php
                    $count++;
                }
            }
            ?>
        </div>

    </div>


<?php } 

 ?>