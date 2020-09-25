<?php
$this->load->helper('text');
if($this->session->userdata('customer_id')=='127063'&&$this->uri->segment(3)=='28'&&$this->uri->segment(5)=='2'){
$this->session->set_userdata('sub_purchases','yes');
}
if (count($productslist) > 0&& ($productslist[0] != '')) {

		     
    ?>
    <div class="col-xs-12 col-md-12 prod_list_exam">
        <div class="col-md-12 text-center bavl"><h2 class="select_heading"> 
         <?php 
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
         $heading_exam='Study Packages';  
		 }
         }
         $testHeading='Recent ';
         if($this->uri->total_segments()==3){
            $testHeading='Recent '; 
         }
         
        if ($this->uri->segment(1) == 'exams') { ?>
    <a href="<?php echo $showAllUrl ;?>"  title="Click here for More >>" target="_blank"><?php 
    if(isset($urlChapter_name)&&($urlChapter_name!=NULL)){ 
         echo $heading_exam.' of '.$urlChapter_name ; 
    }else{
    
    echo $testHeading.$heading_exam ; 
    
    } ?></a>
        <?php
        
         if($stpac_package>0){ 
            echo "<font size='3 px'>(";
            echo $stpac_package." Study Packages";
            
            if($stpac_questions>0){
                //echo " and ".$stpac_questions." Files" ;
            }
            
            echo ")</font>"; }
            ?>
             <?php  }else{
                 
                 ?>
        <?php 
        if($chapter_id<1||$chapter_id==''){
        echo $this->uri->segment(1) == 'videos' ? 'Available Video Courses' :  $testHeading.' Study Packages';
        }
        ?>
<?php
} 
?>
</h2></div>
        <!-- product slide -->

        <!-- Controls -->

        <!-- Wrapper for slides -->
<div class="Clearfix"></div> 
        <div class="row">
            <?php
            if ((count($productslist) > 0) && ($productslist[0] != '')) {
                $count = 0;
                foreach ($productslist as $product) {
                    $image = 'assets/frontend/images/books.png';
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
                    
           /*         if($this->session->userdata('customer_id')=='71696'){
                        echo '---->'.$type.'='.$product->type.'<----';
                        print_r($product);
                        }
         */
		 
                    ?>
                    <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                        <div class="col-item">
                            <div class="photo prod_list_badge"> 
                                <a href="<?php echo getProductLink($product, $type,$this->uri->segment(3)); ?>">
                                    <?php if ($product->type == 1 && $product->item_id > 0) { ?>
                                    <img src="<?php echo show_flex_thumb($product->filename, 300, 350);?>" class="img-responsive lazy" /> <?php //echo base_url('upload/webreader/' . $product->filename . '/docs/' . $product->filename . '.pdf_1_thumb.jpg') ?>
                                    <?php } else { ?>
                                        <img src="/assets/frontend/images/index.png" data-original="<?php
                                        if ($product->image != '') {
                                               echo  show_product_thumb($image, 300, 350);
                                        } else {
                                              echo  show_product_thumb($image, 300, 350);
                                        }
                                        ?>" class="img-responsive lazy" alt="Video Packages"  />
            <?php } ?>
                                </a>
                            </div>
                            <div class="info">
                                <div class="row">
                                    <div class="price col-xs-12 col-md-12" style="height:75px;">
                                        <?php if ($product->type == '2') {
                                            $prdhead_raw = character_limiter($product->modules_item_name, 50); 
                                        } else {
                                            $prdhead_raw = character_limiter($product->displayname ? $product->displayname : $product->modules_item_name, 50); 
                                            }
                                            $margincss='';
                                           $prdhead_cnt=strlen($prdhead_raw);
                                           if($prdhead_cnt>50){
                                               $prdhead=substr($prdhead_raw,0,50).'...';
                                           } else{
                                               if($prdhead_cnt<30){
                                               $margincss="style='margin-top:0px'";
                                               }
                                               $prdhead=$prdhead_raw;
                                           }
                                        ?>
                                        <h5 class="vid_prod_hed" <?php echo $margincss; ?> title="<?php echo $prdhead_raw; ?>"><?php echo $prdhead;?></h5>       
                                    </div>
                                </div>
            <?php  if ($product->price > 0) { ?> 
                                    <div class="separator btn_prod_ved">
                                        <p class="buy_btn">
                                            <?php
                                            if (isset($product->displayname) && ($product->displayname != '')) {
                                                $product_name = $product->displayname;
                                            } else {
                                                $product_name = $product->modules_item_name;
                                            }
                                            
                                       $cnttimes=0;     
                                        if(isset($downloadHistory)){
                                        $datadwnload=$downloadHistory[$product->file_id]; 
                                       
                                        if(isset($datadwnload)&&count($datadwnload)>0){
                                            $cnttimes=count($datadwnload);
                                        ?>
                                        <!--<span class="text-primary"><?php //echo 'Downloaded ('.$cnttimes.')'; ?></span>-->
                                        <?php   
                                        } 
                                        }
                                    
                                     //if (!$this->session->userdata('purchases') || !in_array_r($product->productlist_id, $pproducts)) {
                                       if(!$this->session->userdata('purchases') || !in_array_r($product->productlist_id,$this->session->userdata('purchases'))){   //If main product Purchesed make sub product downloadeble
                                        
                                            if(($this->session->userdata('sub_purchases')=='yes')&&($product->type == '1')){
                                     ?>  <a href="<?php echo base_url('study-packages/download/'.encrypt($product->file_id.'.'.$this->session->userdata('customer_id')))?>" target="_blank">
                                         <?php if(isset($cnttimes)&&$cnttimes>0) {
                                             $textdownload='Download Again ('.$cnttimes.')';
                                         }else{
                                             $textdownload='Download now';
                                         }?>
                                         
                                                <button class="btn-lg btn-sm btn-md btn btn-raised btn-success" name="btnAlreadyExist"><?php echo $textdownload; ?></button>
                                             </a><?php           
                                            }else{
                                                ?>
                                                <?php   $priceDisplay=$this->config->item('priceDisplay');
												if ($product->price > 0) {
													if($priceDisplay=='yes'){  ?>        
                                             <div class="price"><h5 class="price-text-color">&nbsp; <?php if ($product->discounted_price > 0) {
                                                    ?>
                                            <i class="fa fa-inr"> </i> 
                                            <del class="del_txt"> <?php echo $product->price ?></del> <?php
                                                    echo $product->discounted_price;
                                                } else {
                                                    echo $product->price;
                                                }
                                                ?> </h5>
												</div>
            <?php }}

 if($product->type == '2') {
	 
	 $exam_id=$product->exam_id;
 }else{
	 $exam_id=$examid;
 }
	?>										
<a href="<?php echo base_url('purchase-courses#urlid_'.$exam_id)?>" class="subjectbtn btn btn-warning  btn-raised btn-lg">Buy Now</a>
												<!--<button itemname="<?php echo $product_name; ?>" 
                                                        type="<?php echo $product->type ?>" 
                                                        itemprice="<?php echo $product->discounted_price > 0 ? $product->discounted_price : $product->price ?>" 
                                                        itemid="<?php echo $product->productlist_id ?>"                                       itemqty="1"
                                                        offline='0'
                                                        action_type="1"
                                                        class="btn-md btn btn-raised btn-warning addtocart" name="btnAddToCart">Buy Now</button>-->
                                            <?php } } else {
                                                    ?>
                                                <?php
                                                if($product->type == '2') { ?><a href="<?php echo getProductLink($product, $type); ?>"><button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist">Watch Now</button></a>
                                                <?php 
                                                }else{ 
                                         if(isset($cnttimes)&&$cnttimes>0) {
                                             $textdownload='Download Again ('.$cnttimes.')';
                                         }else{
                                             $textdownload='Download now';
                                         }
                                                    ?>
                                            <a href="<?php echo base_url('study-packages/download/'.encrypt($product->file_id.'.'.$this->session->userdata('customer_id')))?>" target="_blank">
                                            <button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist"><?php echo $textdownload.$cnttimes; ?></button>
                                            </a> 
                                                 <?php
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
                            </div>
                        </div>
                    </div> 
                    <?php
                     if(($count%8==0)){
                        ?><div 
class="Clearfix"><?php   echo '<p>&nbsp;&nbsp;&nbsp;</p>';$count=0;
                     ?></div>
                    <?php
                    }
                    $count++;
			
                }
            }
            ?>
        </div>

    </div>


<?php } 

 ?>