	<div class="text-center"><b><i><span class="text-primary">Study packages are available in soft (PDF format) copy only. After buying you will be able to read over any android device (Mobile, tab etc.)</span></i></b> 
                   <b><i><span class="text-primary">The number of Lectures in the package may differ from the numbers shown.The number of package may vary time to time. All study content is copyrighted content of studyadda. Copying, reproducing is strictly prohibited.</span></i></b><br>
					       <b><span class="text-primary">Note:<em color="red"># Amount paid is non refundable/non adjustable.<br>
# Course runs only on Android app.<br>
# Course validity is 31st March 2023.
<br>#Course amount Non-Refundable!</em></span></b>
						  </div><?php
$customer_id=$this->session->userdata('customer_id');
//$this->session->unset_userdata('loginFranId');
if(isset($franchiseInfo)&&$franchiseInfo!=NULL){
	$text_students='Students';
	if(isset($customer_id)&&($customer_id>0)){
		$text_students=$this->session->userdata('customer_fullname');
        }else{
		redirect(base_url('login'));
		}
	if(isset($franchiseInfo->company)){
	$franchCompany=$franchiseInfo->company;
	}else{
		$franchCompany=$franchiseInfo->first_name.' '.$franchiseInfo->last_name;
	}
		$franchiseExist='yes';
		
		$this->session->set_userdata('loginFranId',$franchiseInfo->id);
		$this->session->set_userdata('loginFranCompany',$franchCompany);
	}else{
		$franchCompany='studyadda';
		$franchiseExist='no';
}
?>

<div id="wrapper">


    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12"> 
			<div class="col-lg-9 col-xs-9 col-sm-9 col-md-9">
        <ol class="breadcrumb">
                <li>
                                            <a title="Studyadda" href="https://www.studyadda.com/">
                            <i class="glyphicon glyphicon-home"></i>                        </a>
                                    </li>
    <li class="active"><?php echo $franchCompany; ?></li>
                <li class="active">
                    Materials For Purchase                </li>
    
        </ol>
		 </div>
    </div>  
             <div class="col-md-12"> 
                 <?php
				 if($franchiseExist=='yes'){
				 ?>
				 <div class="col-lg-12 text-center" align="center"><div class="row well well-sm well-lg well-md text-success">Dear <?php echo $text_students; ?>,<br>

As you all know, Studyadda has always provided the best services for you all, we are back again with something very special for you. This time, Studyaddda has brought huge discounts on All Study Packages,Test Series and Videos Series. Here when you will purchase through our partner's page you will  get huge discounts on various products provided by Studyadda.com.You must log In to get the benefits.<br>So get started right away!
<?php if($customer_id==''||$customer_id<1){ ?>
<a href="<?php echo base_url('login') ;?>" class="btn btn-raised btn-success btn-lg btn-md btn-sm" role="button" aria-disabled="true">log In Now</a>
<?php } ?></div></div>
<?php } ?>
	      <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 text-center" align="center">                 	<div class="btn_select_course" style="display:block; position:relative; width:200px; margin:0 auto;">
                    <a href="" data-target="#" class="btn btn-raised dropdown-toggle btn-warning btn-lg" data-toggle="dropdown" aria-expanded="false">
                        Select Course
                        <span class="caret"></span>
                    </a><ul style="position:absolute; left:6%; top:100%" class="dropdown-menu">
                            <?php foreach($mainexamcategories as $ex){
                            ?>
                            <li>
							<?php //echo "<a href='".base_url('exams/'.url_title($ex->name,'-',true).'/'.$ex->id)."' title='{$ex->name}' >{$ex->name}</a>";  
							echo "<a href='#urlid_{$ex->id}' title='{$ex->name}' >{$ex->name}</a>";  
							?>
							</li>
            <?php 
        } ?>
</ul>
							</div>
                </div>
				<div class="Clearfix" style="margin-top: 1px;"><br><br><br></div>
                 <div class="col-lg-12 text-center" align="center">
              <div class="text-center" align="center">
                  <div align="center"> 
                  <!--<a title="Purchase Courses" id="btn1_showPackages" href="#">
                  <button class="btn btn-raised btn-success"><h3><center>All In One Courses</center></h3></button></a><a  title="Test Series" href="#" id="btn3_showTest"><button class="btn btn-raised btn-warning" ><h3><center>Test Series</center></h3></button></a>
               <a  title="Videos" href="#" id="btn2_showVideo"><button class="btn btn-raised btn-info" ><h3><center>Videos Series</center></h3></button></a>-->
                  </div>
          </div>
          </div>
            <br/>
      




<div  id="content_allprod">
    <div id="showPackages">
    
    <div class="col-xs-12 col-md-12 prod_list_exam">
<!-- Wrapper for slides -->
	<?php  $count = 0;
                foreach ($sp_productslist as $product) {
					
					if ($product->price > 0) {
                    $image = 'purchase-courses.png';
                    if (isset($product->image) && $product->image != '') {
                        $image = $product->image;
                    }
					if (isset($product->displayname) && ($product->displayname != '')) {
                                $product_name = $product->displayname;
                                            } else {
                                $product_name = $product->modules_item_name;
                                            }
if ($product->discounted_price > 0) {
	$packagesprice=$product->price;
		//$reduseprice=$packagesprice*10/100;									
		$reduseprice=$product->discounted_price;
		if($franchise_id>0){
			$packagesprice=round($packagesprice-$reduseprice);
		}else{
			$packagesprice=$product->price;
        }
}																			
	?>
	  <!-- dummy -->
	<!-- customize card -->
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	<div class="card card2">
	  <img width='80' height='80'id="base_image" src="<?php echo base_url('assets/images/weball_product/'.$image);?>" class="img-responsive lazy img-purchase"  alt="<?php echo $product_name; ?>" alt="<?php echo $product_name; ?>"  />
	
                             
		<div class="card-title">
			<?php echo $product_name; ?>
		</div>
		

<!-- modules -->
<hr class="card_divider1">
		<div class="card-body">
			<?php  
			if(isset($packagecnt_array)&&count($packagecnt_array)>0){
				$packagecnt=$packagecnt_array[$product->exam_id];
				$totalpackage_q=0;
			?>
			<div class="card-module text-capitalize text-center">
				<ul class="list-inline">
					<?php foreach($packagecnt as $keyval){ 	
					 if(isset($keyval->custom_total_package)&&$keyval->custom_total_package>0){ ?>
					<li class="list-group-item">
						<span><?php  if($keyval->module_type=='videos'){  echo $keyval->custom_total_question; }else{ echo $keyval->custom_total_package; 
						
						$totalpackage_q=$totalpackage_q+$keyval->custom_total_question;
						} ?> +</span>
						<?php  
						 if(isset($keyval->module_type)&&$keyval->module_type!=''){?>
						<a href="#"><?php
$moduletype_array=explode('-',$keyval->module_type);
echo ucfirst($moduletype_array[0]).' '.ucfirst($moduletype_array[1]);
						; ?></a>
						<?php } ?>
					</li>
					 <?php } 
					 } 
					 if($totalpackage_q>0){
					 ?>
					 
					 	<li class="list-group-item"><span><?php  echo $totalpackage_q;  ?> +</span><a href="#">Total Question</a></li>
					 <?php } ?>
			</ul>
			</div>
			<?php } ?>
		
<!-- // modules -->	


	<?php if($reduseprice>0){ ?>
		<div class="row show_price text-center">
			<a href="#">Actual Price <span class='actual_price'><?php echo $packagesprice; ?></span></a>
			<a href="#">Offer Price <?php echo $reduseprice; ?></a>
		</div>
	<?php }else{ ?>
			<div class="row show_price text-center">
			<a href="#">Offer Price <?php echo $packagesprice; ?></a>
		</div>
	<?php } ?>
	
			
		<div class="btn-group1 text-center">		
		<?php
			if ($product->price > 0) { 
			if (!$this->session->userdata('purchases') || !in_array_r($product->id, $this->session->userdata('purchases'))||$product_brought=='no') { ?>				
						<button style='margin-bottom:6px;' itemname="<?php echo $product->modules_item_name;?>" 
                        type="<?php echo $product->type ?>" 
                        itemprice="<?php echo $product->discounted_price > 0 ? $product->discounted_price : $product->price ?>" 
                        itemid="<?php echo $product->id ?>"
                        itemqty="1"
                        offline='0'
                        action_type="1"
                        class="btn btn-primary btn-sm addtocart cartleft"
                        name="btnAddToCart" onclick="return showmsg();return false;"><i class="material-icons">add_shopping_cart</i>Add To Cart</button>
						<button itemname="<?php echo $product->modules_item_name;?>" 
                        type="<?php echo $product->type ?>" 
                        itemprice="<?php echo $product->discounted_price > 0 ? $product->discounted_price : $product->price ?>" 
                        itemid="<?php echo $product->id ?>"
                        itemqty="1"
                        offline='1'
                        action_type="1" 
						redirect="buynow"
                        class="btn btn-primary btn-sm buyright"
                        name="btnAddToCart" onclick="return showmsg();return false;"><i class="material-icons">add_shopping_cart</i>&nbsp;Buy Now&nbsp;&nbsp;&nbsp;&nbsp;</button>
										
			<?php }else{
				?>
				 <button class="btn btn-primary"
                    name="btnAlreadyExist">You have already bought this course</button>
				
			<?php
			}
					   }else{
						   ?>
						   <button  class="btn btn-primary" name="btnAlreadyExist">Not For Sale</button>
						   <?php
					   }
			?>
		
		</div>
		
		
		</div>
		
	</div>
</div>
<!-- //customize card -->

 <!-- // dummy --><?php
					
					
					
					/*
					
<style>
.overlayPrice {
position: absolute;
top:50px;
right:51px;
}
@media(max-width:380px) {
.overlayPrice {
position: absolute;
top:50px;
right:51px;
}
	
}
@media(max-width:768px) {
	
.overlayPrice {
position: absolute;
top:50px;
right:51px;
}
}
@media(max-width:500px) {
.overlayPrice {
position: absolute;
top:50px;
right:51px;
}
}
@media(max-width:1280px) {
.overlayPrice {
position: absolute;
top:5px;
right:51px;
}
}

.bellowPrice{
	
	
}
					
</style>
					if ($product->price > 0) {
                    $image = 'purchase-courses.png';
                    if (isset($product->image) && $product->image != '') {
                        $image = $product->image;
                    }
					if (isset($product->displayname) && ($product->displayname != '')) {
                                $product_name = $product->displayname;
                                            } else {
                                $product_name = $product->modules_item_name;
                                            }
					?>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" id="urlid_<?php echo $product->exam_id; ?>">
<div class="card">
<div>
      <a href="<?php echo getProductLink($product, $type); ?>">
                                    <?php			
									if(isset($product->id)){
									$productlist_id=$product->id;
									}else{
									$productlist_id=NULL;	
									}
									
									//Path For web products image echo base_url('assets/frontend/product_images/'.$image)
                                ?>
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center"  style="position: relative; text-align: center;   color: black;">
  
                               <img id="base_image" src="<?php echo base_url('assets/images/'.$image);?>" class="img-responsive lazy card-img-top"  alt="<?php echo $product_name; ?>"  /> 
            
                                
							</div>
								</a>
								</div>
			<!-- add class 'overlayPrice' for image over text for price-->								


	<div class="col-sm-12 col-lg-12 col-md-12 col-sm-12">
    <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6">
	<?php if ($product->discounted_price > 0) {
	$packagesprice=$product->discounted_price;
			$reduseprice=$packagesprice*10/100;									
		if($franchise_id>0){
			$packagesprice=round($packagesprice-$reduseprice);
		}else{
			
			$packagesprice=$product->discounted_price;
		}									

?>
      <div class="act-price col-lg-12 col-md-12 col-sm-12 col-xs-12"> <font color="red" size="4">Actual Price :</font>
                    <del class="text-default" style="color:red" ><strong><i class="fa fa-inr"> <?php echo $product->price; ?></i> </strong></del>
					</div>
                <div class="youpay-price col-lg-12 col-md-12 col-sm-12 col-xs-12"> <font color="black" size="4">Offer Price:</font> 
                    <span class="text-default" style="color:black;" ><strong><i class="fa fa-inr"> <?php echo $packagesprice; ?></i> </strong></span></div>
					 <?php 
					 }else{
						  ?>
						   <div class="youpay-price col-lg-12 col-md-12 col-sm-12 col-xs-12"> <font color="black" size="4">Price:</font> 
                    <span class="text-default" style="color:black;" ><strong><i class="fa fa-inr"> </i> <?php echo $product->price; ?></strong></span></div>
						  <?php 
						   
					   }
					   
					   ?></div>
    <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6"> 
	<?php
			if ($product->price > 0) { 
			if (!$this->session->userdata('purchases') || !in_array_r($product->id, $this->session->userdata('purchases'))||$product_brought=='no') { ?>
					  <!--<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 hidden-lg hidden-md hidden-sm" style="margin-top: 1px;"><br></div> -->
					  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<button itemname="<?php echo $product->modules_item_name;?>" 
                        type="<?php echo $product->type ?>" 
                        itemprice="<?php echo $product->discounted_price > 0 ? $product->discounted_price : $product->price ?>" 
                        itemid="<?php echo $product->id ?>"
                        itemqty="1"
                        offline='0'
                        action_type="1"
                        class="btn-md btn-sm btn btn-raised btn-light addtocart"
                        name="btnAddToCart"><i class="material-icons">add_shopping_cart</i>Add To Cart</button>
						</div><div class="hidden-lg hidden-md " style="margin-top: 1px;"><br><br></div>
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						   <button itemname="<?php echo $product->modules_item_name;?>" 
                        type="<?php echo $product->type ?>" 
                        itemprice="<?php echo $product->discounted_price > 0 ? $product->discounted_price : $product->price ?>" 
                        itemid="<?php echo $product->id ?>"
                        itemqty="1"
                        offline='1'
                        action_type="1" 
						redirect="buynow"
                        class="btn-md btn-sm btn btn-raised btn-light addtocart"
                        name="btnAddToCart"><i class="material-icons">add_shopping_cart</i>&nbsp;Buy Now&nbsp;&nbsp;&nbsp;&nbsp;</button>
						</div>					
			<?php }else{
				?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" > <button class="btn-xs btn btn-raised btn-success"
                    name="btnAlreadyExist">You have already bought this course</button></div>
				
			<?php
			}
					   }else{
						   ?><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
						   <button  class="btn-xs btn btn-raised btn-success"
                    name="btnAlreadyExist">Not For Sale</button></div>
						   <?php
					   }
			?>
					</div>   
    </div>
</div></div>

					   <?php 
					   }
*/
					}   
					   } ?>
		
		
		</div></div></div>		 
		 
		 
		 
			
<?php
$this->load->helper('text');
?>
             <div  id="content_allprod">
    <div id="showPackages">
    <!--Study Packages Product List-->
    <?php 
	$displayoldview='no';
    if((count($sp_productslist) > 0) && $displayoldview=='yes') {
    ?>
    <div class="col-xs-12 col-md-12 prod_list_exam">
<!-- Wrapper for slides -->
<div class="Clearfix"></div> 
        <div class="row">
            <?php
            if ((count($sp_productslist) > 0) && ($sp_productslist[0] != '')) {
                $count = 0;
                foreach ($sp_productslist as $product) {
                    if ($product->price > 0) {
                    $image = 'assets/frontend/images/purchase-courses.png';
                    if (isset($product->app_image) && $product->app_image != '') {
                        $image = $product->app_image;
                    }
                    
					
					/* if ($product->price > 0) {
                    $image = '/assets/images/UPSC.png';
                    if (isset($product->app_image) && $product->app_image != '') {
                    $image = '/assets/images/'.$product->app_image;
                    }*/
   $type = 'study-packages';
                    ?>
                    <div class="col-xs-6 col-sm-4 col-md-2">
                        <div class="col-item">
                            <div class="photo prod_list_badge"> 
                                <a href="<?php echo getProductLink($product, $type); ?>">
                                    <?php			
									if(isset($product->id)){
									$productlist_id=$product->id;
									}else{
									$productlist_id=NULL;	
									}
                                ?>
                           
                                    <?php if ($product->type == 1 && $product->item_id > 0) { ?>
                                    <img src="<?php echo show_flex_thumb($product->filename, 300, 350);?>" class="img-responsive lazy" /> 
                                    <?php } else { ?>
                                        <img src="/assets/frontend/images/index.png" data-original="<?php
                                        if ($product->app_image != '') {
                                            echo show_product_thumb($image, 300, 350);
                                        } else {
                                            echo base_url($image);
                                        }
                                        ?>" class="img-responsive lazy" alt="Study Packages"  />
            <?php } ?>
                                </a>
                            </div>
                            <div class="info">
                                <div class="row">
                                    <div class="price col-xs-12 col-md-12" style="height:75px;">
                                        <?php if ($product->type == '2') {
                                            $prdhead_raw = character_limiter($product->modules_item_name, 50); 
                                        } else {
											if(isset($product->displayname)){
												$pdisplayname=$product->displayname;
											}else{
												$pdisplayname=NULL;
											}
                                            $prdhead_raw = character_limiter($pdisplayname ? $pdisplayname : $product->modules_item_name, 50);
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
            <?php if ($product->price > 0) { ?> 
                                    <div class="separator btn_prod_ved">
                                        <p class="buy_btn">
                                            <?php
            if (isset($product->displayname) && ($product->displayname != '')) {
                                $product_name = $product->displayname;
                                            } else {
                                $product_name = $product->modules_item_name;
                                            }
                                            
                                       $cnttimes=0;     if(!$this->session->userdata('purchases') || !in_array_r($productlist_id,$this->session->userdata('purchases'))){   //If main product Purchesed make sub product downloadeble
                                            if(($this->session->userdata('sub_purchases')=='yes')&&($product->type == '1')){
                                     ?>  <a href="<?php echo base_url('study-packages/download/'.encrypt($product->file_id.'.'.$this->session->userdata('customer_id')))?>" target="_blank">
                                         <?php if(isset($cnttimes)&&$cnttimes>0) {
                                             $textdownload='Download Again ('.$cnttimes.')';
                                         }else{
                                             $textdownload='Download now';
                                         }?>
                                         
                                                <button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist"><?php echo $textdownload; ?></button>
                                             </a><?php           
                                            }else{
                                                ?>
                                                <?php if ($product->price > 0) { ?>        
                                             <div class="price"><h5 class="price-text-color">&nbsp; <?php if ($product->discounted_price > 0) {
                                                    ?>
                                            <i class="fa fa-inr"> </i> 
                                            <del class="del_txt"> <?php echo $product->price ?></del> <?php
												$packagesprice=$product->discounted_price;
			$reduseprice=$packagesprice*10/100;									
		if($franchise_id>0){
			$packagesprice=round($packagesprice-$reduseprice);
		}else{
			
			$packagesprice=$product->discounted_price;
		}									
											
                                                    echo $packagesprice;
                                                } else {
                                                    echo $product->price;
                                                
												}
                                                ?> 
												</h5>
												</div>
            <?php } 
			if(isset($product->id)){
			$pist_id=$product->id;	
			}else{
			$pist_id='';
			}
			?>
                                                <button itemname="<?php echo $product_name; ?>" 
                                                        type="<?php echo $product->type ?>" 
                                                        itemprice="<?php echo $product->discounted_price > 0 ? $product->discounted_price : $product->price ?>" 
                                                        itemid="<?php echo $pist_id ?>"                                itemqty="1"
                                                        offline='0'
                                                        action_type="1"
                                                        class="btn-lg btn-md btn-sm  btn btn-raised btn-warning addtocart" name="btnAddToCart" onclick="return showmsg();return false;">Buy Now</button>
                                            <?php 
											} 
											} else {
                     
 $textdownload='Go To Downloads';
                                                 ?>  <div>&nbsp;</div>
                                            <a href="<?php echo getProductLink($product, $type); ?>" target="_blank">
                                            <button class="btn-lg btn-md btn-sm btn btn-raised btn-success" name="btnAlreadyExist"><?php echo $textdownload; ?></button>
                                            </a> 
                                                 <?php
                                                 }
                                            ?>
                                        </p> 
                                    </div>
                                <?php } else {
                                ?>
                                 <div class="separator btn_prod_ved">
                                 <br><br>
                            <button class="btn-md btn btn-raised btn-warning">Not For Sale</button>
                                       
                                 </div>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div> 
                    <?php
                     if(($count>0&&$count<11)&&($count%5==0)){
                        ?>
            <div class="Clearfix"></div>
                    <?php
                    }
                    $count++;
                }}
            }
            ?>
        </div>

    </div>
<?php } ?>
         </div>        
                         <div id="showVideo" style="display:none;"> 
                             <div class="clearfix"></div>
    <?php

if(count($videoproductslist) > 0) {
    ?>
    <div class="col-xs-12 col-md-12 prod_list_exam">
<!-- Wrapper for slides -->
<div class="Clearfix"></div> 
        <div class="row">
            <?php
            if ((count($videoproductslist) > 0) && ($videoproductslist[0] != '')) {
                $count = 0;
                foreach ($videoproductslist as $product) {
                    $image = 'assets/frontend/images/purchase-courses.png'; 
                    if (isset($product->image) && $product->image != '') {
                        $image = $product->image;
                    }
                    $type = 'videos';
                 ?>
                    <div class="col-xs-6 col-sm-4 col-md-2">
                        <div class="col-item">
                            <div class="photo prod_list_badge"> 
                                <a href="<?php echo getProductLink($product, $type); ?>">
                                    <?php 
                                   
							if(isset($product->displayname)){
								$displayname=$product->displayname;
							}else{
								$displayname='';
							}
							?>
                                    <?php if($product->type == 1 && $product->item_id > 0) { ?>
                                    <img src="<?php echo show_flex_thumb($product->filename, 300, 350);?>" class="img-responsive lazy" /> 
                                    <?php } else { ?>
                                        <img src="/assets/frontend/images/index.png" data-original="<?php
                                        if ($product->image != '') {
                                        echo show_product_thumb($image, 137,350,'ebooks160x140.png');
                                        } else {
                                        echo base_url($image);
                                        }
                                        ?>" class="img-responsive lazy" alt="Video Packages" title="<?php echo $displayname; ?>"  />
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
            <?php if ($product->price > 0) { ?> 
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
                                       
                                        } 
                                        }
                                    
                                       if(!$this->session->userdata('purchases') || !in_array_r($product->productlist_id,$this->session->userdata('purchases'))){   //If main product Purchesed make sub product downloadeble
 if ($product->price > 0) { ?> 
 <div class="price"><h5 class="price-text-color">&nbsp; <?php if ($product->discounted_price > 0) {
	 ?>
                                            <i class="fa fa-inr"> </i> 
                                            <del class="del_txt"> <?php echo $product->price ?></del> <?php
                                                    
													$videoprice=$product->discounted_price;
			$reduseprice=$videoprice*10/100;									
		if($franchise_id>0){
			$videoprice=round($videoprice-$reduseprice);
		}else{
			
			$videoprice=$product->discounted_price;
		}								
                                                    echo $videoprice;							
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
                                                        class="btn-md btn btn-raised btn-warning addtocart" name="btnAddToCart" onclick="return showmsg();return false;">Buy Now</button>
                                            <?php  } else {
                                                    ?>
                                               <div class="price"><h5 class="price-text-color"><br></h5>  </div><a href="<?php echo getProductLink($product, $type); ?>"><button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist">Watch Now</button></a>
                                            <?php }
                                            ?>
                                        </p> 
                                    </div>
                                <?php } else {
                                ?>
               <div class="separator btn_prod_ved">
                            <br><br>
                            <button class="btn-md btn btn-raised btn-warning">Not For Sale</button>
                                        
                                 </div>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div> 
                    <?php
                     if(($count>0&&$count<7)&&($count%6==0)){
                        ?><div class="Clearfix"></div>
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
</div>
<div id="showTest" style="display:none;">
           
                 <div class="clearfix"></div>
                 <!--Test Series Product List-->  
                     <?php 
    if(count($ts_productslist) > 0) {
    ?>
    <div class="col-xs-12 col-md-12 prod_list_exam">        
<!-- Wrapper for slides -->
<div class="Clearfix"></div> 
        <div class="row">
            <?php
            if ((count($ts_productslist) > 0) && ($ts_productslist[0] != '')) {
                $count = 0;
                foreach ($ts_productslist as $product) {
                    $image = base_url('assets/frontend/images/purchase-courses.png');
                    if (isset($product->app_image) && $product->app_image != '') {
                        $image=show_product_thumb($product->app_image, 300, 350);
                    }
                        $type = 'online-test';
                    ?>
                    <div class="col-xs-6 col-sm-4 col-md-2">
                        <div class="col-item">
                            <div class="photo prod_list_badge"> 
                                <a href="<?php echo getProductLink($product, $type); ?>">
                               <img src="<?php echo $image; ?>" alt="Online Test"  />
                                </a>
                            </div>
                            <div class="info">
                                <div class="row">
                                    <div class="price col-xs-12 col-md-12" style="height:75px;">
                                        <?php 
										if(isset($product->displayname)){
											$displayname=$product->displayname;
										}else{
											$displayname='';
										}
										
										if ($product->type == '2') {
                                            $prdhead_raw = character_limiter($product->modules_item_name, 50); 
                                        } else {
                                            $prdhead_raw = character_limiter($displayname ? $displayname : $product->modules_item_name, 50); 
                                            }
                                           $margincss='';
                                           $prdhead_cnt=strlen($prdhead_raw);
                                           if($prdhead_cnt>50){
                                               $prdhead=substr($prdhead_raw,0,50);
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
            <?php if ($product->price > 0) { ?> 
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
                                        
                                        } 
                                        }
                                    
                                     //if (!$this->session->userdata('purchases') || !in_array_r($product->productlist_id, $pproducts)) {
                                       if(!$this->session->userdata('purchases') || !in_array_r($product->id,$this->session->userdata('purchases'))){   //If main product Purchesed make sub product downloadeble
                                        
                                            if(($this->session->userdata('sub_purchases')=='yes')&&($product->type == '1')){
                                     ?>  <a href="<?php echo getProductLink($product, $type); ?>" target="_blank">
                                         <?php 
$textdownload='Go To Test';
                                         ?>                                        
                                                <button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist"><?php echo $textdownload; ?></button>
                                             </a><?php           
                                            }else{
                                                ?>
                                                <?php if ($product->price > 0) { ?>        
                                             <div class="price"><h5 class="price-text-color">&nbsp; <?php if ($product->discounted_price > 0) {
                                                    ?>
                                            <i class="fa fa-inr"> </i> 
                                            <del class="del_txt"> <?php echo $product->price ?></del> <?php																	$oltesteprice=$product->discounted_price;
			$reduseprice=$oltesteprice*10/100;									
		if($franchise_id>0){
			$oltesteprice=round($oltesteprice-$reduseprice);
		}else{
			
			$oltesteprice=$product->discounted_price;
		}									
                                                    echo $oltesteprice;
                                                
												} else {
                                                    echo $product->price;
                                                }
                                                ?> </h5>  </div>
            <?php } ?>
                                                <button itemname="<?php echo $product_name; ?>" 
                                                        type="<?php echo $product->type ?>" 
                                                        itemprice="<?php echo $product->discounted_price > 0 ? $product->discounted_price : $product->price ?>" 
                                                        itemid="<?php echo $product->id ?>" itemqty="1"
                                                        offline='0'
                                                        action_type="1"
                                                        class="btn-md btn-lg btn-sm btn btn-raised btn-warning addtocart" name="btnAddToCart" onclick="return showmsg();return false;">Buy Now</button>
                                            <?php } } else {
												$textdownload='Go To Test';
						                  ?>
                                           <div class="price"><h5 class="price-text-color">&nbsp;                                             </h5>  </div> <a href="<?php echo getProductLink($product, $type); ?>" target="_blank">
                                            <button class="btn-md btn-lg btn-sm btn btn-raised btn-success" name="btnAlreadyExist"><?php echo $textdownload; ?></button>
                                            </a> 
                                            <?php }
                                            ?>
                                        </p> 
                                    </div>
                                <?php } else {
                                ?>
                  <div class="separator btn_prod_ved">
                            <br><br>
                            <button class="btn-md btn-lg btn-sm btn btn-raised btn-warning">Not For Sale</button>
                                        
                                 </div>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div> 
                    <?php
                     if(($count>0&&$count<11)&&($count%5==0)){
                        ?><div class="Clearfix"></div>
                    <?php
                    }
                    $count++;
                }
            }
            ?>
        </div>

    </div>
<?php } ?>
      </div>   
             </div>
             </div>
        </div>
    </div>
</div>
            