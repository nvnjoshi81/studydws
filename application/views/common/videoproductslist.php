<?php
$productslist=$videoproductslist;
$this->load->helper('text');
if (count($productslist) > 0) {
    $heading_video_exam='';
    $heading_studymaterial_exam='';
    $heading_exam='';    
    $showAllUrl='';
    
         foreach ($productslist as $product_heading) {             
             if ($this->uri->segment(1) == 'exams') {
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
         }
    ?>

    <div class="col-xs-12 col-md-12 prod_list_exam">
        <div class="col-md-12 text-center bavl"><h2> 
         <?php 
        if ($this->uri->segment(1) == 'exams') {
            ?>
<a href="<?php echo $showAllUrl ;?>" target="_blank">Available <?php echo $heading_exam ; ?>    </a>
        <?php
        
        if($video_package>0){ 
            echo "<font size='3 px'>(";
            echo $video_package." Video Lecture Series";
            if($videos_questions>0){
                echo " and ".$videos_questions." Videos" ;
            }
            echo ")</font>"; } ?> 
             <?php  }else{
                 ?>
        Available test  <?php echo $this->uri->segment(1) == 'videos' ? 'Video Lectures' : 'Study Packages' ?>
<?php
} 
?>
</h2></div>
        <!-- product slide -->

        <!-- Controls -->

        <!-- Wrapper for slides -->

        <div class="row" style="margin:0;">
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
                        if ($product->type == 'Videos') {
                            $type = strtolower($product->type);
                        }
                        if ($product->type == 'Study Material') {
                            $type = 'study-packages';
                        }
                    } else {
                        $type = $this->uri->segment(1);
                    }
                    ?>
                    <div class="col-xs-6 col-sm-4 col-md-3 col-item prod_list_margin">
                        <div>
                            
                            <div class="photo prod_list_badge"> 
                                <a href="<?php echo getProductLink($product, $type); ?>">
                                    <?php 
                                    if(!$this->session->userdata('purchases') || !in_array_r($product->productlist_id,$this->session->userdata('purchases'))){  ?>
                            <?php }else{
                                ?>
                            <span class="label label-success prod_list_badge_inner"><?php 
                                                if($product->type == '2') { echo "Purchased"; }else{ echo "Downloaded"; } ?></span><?php
                            } ?>
                                    <?php if ($product->type == 1 && $product->item_id > 0) { ?>
                                  <img style="width:60%;" src="<?php echo show_flex_thumb($product->filename, 300, 350); //echo base_url('upload/webreader/' . $product->filename . '/docs/' . $product->filename . '.pdf_1_thumb.jpg') ?>" class="img-responsive lazy"/>
                                    <?php } else { ?>
                                        <img src="/assets/frontend/images/index.png" data-original="<?php
                                        if ($product->image != '') {
                                            echo show_product_thumb($image, 300, 350);
                                        } else {
                                            echo base_url($image);
                                        }
                                        ?>" class="img-responsive lazy" alnowt="a" />
            <?php } ?>
                                </a>
                            </div>
                            <div class="info">
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
                                     //if (!$this->session->userdata('purchases') || !in_array_r($product->productlist_id, $pproducts)) {
                                       if(!$this->session->userdata('purchases') || !in_array_r($product->productlist_id,$this->session->userdata('purchases'))){   //If main product Purchesed make sub product downloadeble
                                            if(($this->session->userdata('sub_purchases')=='yes')&&($product->type == '1')){
                                     ?>  <a href="<?php echo base_url('study-packages/download/'.encrypt($product->file_id.'.'.$this->session->userdata('customer_id')))?>" target="_blank">
                                                <button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist">Download Now</button>
                                             </a><?php           
                                            }else{
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
            <?php } ?>
                                                <button itemname="<?php echo $product_name; ?>" 
                                                        type="<?php echo $product->type ?>" 
                                                        itemprice="<?php echo $product->discounted_price > 0 ? $product->discounted_price : $product->price ?>" 
                                                        itemid="<?php echo $product->productlist_id ?>"                                       itemqty="1"
                                                        offline='0'
                                                        action_type="1"
                                                        class="btn-md btn btn-raised btn-warning addtocart" name="btnAddToCart">Buy Now</button>
                                            <?php } } else {
                                                    ?>
                                                <?php
                                                if($product->type == '2') { ?><a href="<?php echo getProductLink($product, $type); ?>"><button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist">Watch Now</button></a>
                                                <?php 
                                                }else{
                                                    ?>
                                            <a href="<?php echo base_url('study-packages/download/'.encrypt($product->file_id.'.'.$this->session->userdata('customer_id')))?>" target="_blank">
                                            <button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist">Download Now</button>
                                             </a> <?php
                                                 } ?>
                                            <?php }
                                            
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