   <?php if(count($productslist) > 0){ ?>
<div class="col-xs-12 col-md-12 prod_list_exam">
  <?php if(isset($selectedexam)) {?>  <h3><i class="material-icons">question_answer</i> Available Video Courses & Study Packages </h3><?php } ?>
  <!-- product slide -->
  <div id="carousel-example" class="carousel slide product_slide_panel" data-ride="carousel">
   <!-- Controls -->
   <?php if(count($productslist) > 4){ ?>
                <div class="controls hidden-xs next_pre_panel">
                    <a class="left pull-left" href="#carousel-example" data-slide="prev"><i class="material-icons">keyboard_arrow_left</i></a>
                    <a class="right pull-right" href="#carousel-example" data-slide="next"><i class="material-icons">keyboard_arrow_right</i>	</a>
                </div>
   <?php } ?>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
      <div class="row">
      <?php 
      if((count($productslist)>0)&&($productslist[0]!='')){
      $count=0; foreach($productslist as $product){
         
          $type='';
          if($this->uri->segment(1) =='exams'){
              if($product->type=='Videos'){
                  $type=  strtolower($product->type);
              }
              if($product->type=='Study Material'){
                  $type=  'study-packages';
              }
          
          }else{
              $type=$this->uri->segment(1);
          }
          ?>
        
          <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="col-item">
              <div class="photo"> 
                  <?php if($product->type==1 && $product->item_id > 0){ ?>
                  
                  
                  <?php 
                if(file_exists('upload/webreader/'.$file->filename.'/docs/'.$file->filename.'.pdf_1_thumb.jpg')){
                $imagePath = base_url('upload/webreader/'.$file->filename.'/docs/'.$file->filename.'.pdf_1_thumb.jpg');
                }else{                    
                $imagePath = base_url('assets/frontend/images/ebooks.png');  
                }
                ?>
                  
                 <img src="<?php echo $imagePath; ?>" class="img-responsive"/>     
                  <?php }else{ 
                      echo getProductImage($product->image);
                      ?>
                  <?php } ?>
              </div>
              <div class="info">
                <div class="row">
                  <div class="price col-xs-12 col-md-12">
                    <h5 class="vid_prod_hed"><?php echo $product->modules_item_name; ?></h5>
                    <h5 class="price-text-color">&nbsp; <?php if($product->discounted_price > 0){ 
        ?>
      <i class="fa fa-inr"> </i> <del class="del_txt"> <?php echo $product->price?></del> <?php echo $product->discounted_price;
    }else{
        echo $product->price;
    }
    ?> </h5>
                </div>
               </div>
                <div class="separator btn_prod_ved">
                    
                    <a href="<?php echo getProductLink($product,$type);?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>
                      
                </div>
                <div class="clearfix"> </div>
              </div>
            </div>
          </div>
         <?php $count++ ;
		 if($count==4 && count($productslist)>$count){
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