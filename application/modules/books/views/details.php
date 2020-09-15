<div id="wrapper">
    <div class="container">
            <div class="row">
                <?php $this->load->view('common/breadcrumb');?>
            
            </div>
                
                  <!-- video gallery -->
    <div class="row vedio_bot_gal">
    <div class="col-sm-12 col-md-9">
         <?php 
                 if($isProduct){ 
                  //echo "This is product area.";
                  $this->load->view('common/productdetails');
                  } 
                     ?>
    <div class="row vid_list">
    <?php   
    
    if($files){ foreach($files as $file){ $pro=$this->Pricelist_model->getItemPrice($file->id,1);

    ?>
    <div class="col-xs-12 col-sm-4 col-md-3 pdflistpanel">
            <div class="col-item">
            <div class="photo"> 
               <?php if(isset($pro)){
               ?>
                <a href="<?php echo getProductLink($pro,'books');?>">
            <?php }else{
                ?>
                    <a href="<?php echo base_url('books/show/'.  url_title($file->displayname?$file->displayname:$file->filename,'-',true).'/'.$file->id)?>">
                        <?php
            }
            ?>
                        
                        
                               <?php 
                if(file_exists('upload/webreader/'.$file->filename.'/docs/'.$file->filename.'.pdf_1_thumb.jpg')){
                $imagePath = base_url('upload/webreader/'.$file->filename.'/docs/'.$file->filename.'.pdf_1_thumb.jpg');
                }else{                    
                $imagePath = base_url('assets/frontend/images/ebooks.png');  
                }
                ?>
                  
                        <img alt="<?php echo $file->filename; ?>" src="<?php echo $imagePath; ?>" class="img-responsive"/>     
                
            </a>
            </div>
              <div class="info">
                <div class="row">
                  <div class="price col-xs-12 col-md-12">

                    <h5 class="vid_prod_hed"><?php echo str_replace('_',' ',$file->displayname?$file->displayname:$file->filename)?></h5>
<?php if($file->price>0){ ?>
                    <h5 class="price-text-color">&nbsp;<i class="fa fa-inr"> </i> <del class="del_txt"> <?php echo $file->price?></del> <?php echo $file->discounted_price?> </h5>
<?php } ?>
                  </div>
                 </div>
                <div class="separator btn_prod_ved">
                   <?php if($file->price > 0){
                ?>
          <!-- <a href="<?php echo base_url('books/show/'.  url_title($file->displayname?$file->displayname:$file->filename,'-',true).'/'.$file->id)?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>
            -->
                       <p class="buy_btn">
            <?php if (!$this->session->userdata('purchases') || !in_array_r($file->id, $this->session->userdata('purchases'))) { ?>
                                            <button itemname="<?php echo str_replace('_',' ',$file->displayname?$file->displayname:$file->filename)?>" 
                                                    type="<?php echo $file->type ?>" 
                                                    itemprice="<?php echo $file->discounted_price > 0 ? $file->discounted_price : $file->price ?>" 
                                                    itemid="<?php echo $file->pricelist_id ?>"
                                                    itemqty="1"
                                                    offline='0'
                                                    action_type="1"
                                                    class="btn-md btn btn-raised btn-warning addtocart"
                                                    name="btnAddToCart">Buy Now</button>
                                            <?php } else {
                                                ?>
                                            <button 
                                                class="btn-xs btn btn-raised btn-warning"
                                                name="btnAlreadyExist">You have already brought this product.
                                            </button>
            <?php }
            ?>
            </p>
                                                  
                <?php  } ?>
                </div>

                <div class="clearfix"> </div>
              </div>
            </div>
          </div>
    <?php } } ?>
    </div>
    </div>
    <!-- right panel -->
    <div class="col-sm-12 col-md-3">
     <div class="col-sm-12 col-md-3 rht260adv">
        <img src="<?php echo base_url('assets/images/260adv_2.jpg')?>" />
      </div>
    </div>        
    <!--For multiple Questions -->
                <!--  
                     <div class="question_panel_lft">
            <ul class="grid">
            <?php $count=1;foreach($questions as $question){  ?>
                <li  class="element-item <?php echo url_title($question->type,'', TRUE)?>" >
                    <p> <a  href="#"><i class="material-icons">question_answer</i><?php echo $count;?>) <?php echo  iconv('UTF-8', 'ASCII//TRANSLIT',custom_strip_tags($question->question));?> </a></p>
                <?php $answers=$this->Questions_model->answers($question->id);
                if(count($answers) > 1){ 
                    $letters = range('A', 'Z');
                    $ac=0;
                    foreach($answers as $answer){
                        ?><p><?php echo $letters[$ac]?>) <?php echo iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->answer));   ?></p><?php
                    $ac++;
                    
                    } ?>
                   
                <?php }
                ?>
                
                <span class="pull-right view_ans"><a href="<?php echo base_url('books').'/'.url_title($smdetails->name,'-',TRUE).'/'.$smdetails->id.'/'.$question->id; ?>">View Answer <i class="material-icons">play_arrow</i> </a></span>
              </li>
            <?php $count++;} ?>
              
            </ul>
            
          
          </div> 
    -->
                  
                  
    </div>
    
  
    </div>
</div>

