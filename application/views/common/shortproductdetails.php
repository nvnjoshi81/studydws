<?php
  $priceDisplay=$this->config->item('priceDisplay');
						
?>
<div class="row">
     <div class="col-xs-12 col-md-12">
         <h2><?php echo $file->displayname?$file->displayname:$file->filename;?></h2>
     </div>              
    <div class="col-xs-12 col-md-12">
        <?php 						if($priceDisplay=='yes'){ if($isProduct->price>0){ ?>
        <div class="col-md-5">
         <?php if ($isProduct->discounted_price > 0) { ?>
        <h3> Actual Price :
            <del class="text-default">
            <strong><i class="fa fa-inr"> </i> <?php echo $isProduct->price ?></strong>
            </del> 
        </h3>
        </div>
        <div class="col-md-5">
        <h3>Lockdown Offer:
            <span class="text-warning">
                <strong><i class="fa fa-inr"> </i> <?php echo $isProduct->discounted_price ?></strong>
            </span>
        </h3>
        <?php }else{ ?>
        <h3>
                <span class="text-warning"><strong><i class="fa fa-inr"> </i> <?php echo $isProduct->price ?></strong></span>
        </h3>
        <?php } ?>
        </div>
        <?php } } ?>
    <div class="col-xs-12 col-md-2">
        <?php   
        $user_purcheses=$this->session->userdata('purchases');
        if(isset($user_purcheses)){
           $pid_value=in_array_r($isProduct->id, $user_purcheses); 
        }
        
         if($isProduct->price>0){ 
        if (!$user_purcheses || !$pid_value) {         
             if(($isSubjectProductBrought>0)&&($this->session->userdata('customer_id')>0)&&in_array_r($isSubjectProductBrought, $user_purcheses)){            
           $itemdetail = $this->File_model->getStudyPackageDetails($isProduct->item_id);
            ?>
        <a href="<?php echo base_url('study-packages/download/'.encrypt($itemdetail->id.'.'.$this->session->userdata('customer_id')))?>" class="subjectbtn btn btn-primary btn-raised btn-lg">Download Now</a>
            <?php 
            }elseif(($isMainProductBrought>0)&&($this->session->userdata('customer_id')>0)&&in_array_r($isMainProductBrought, $user_purcheses)){             
            
            $itemdetail = $this->File_model->getStudyPackageDetails($isProduct->item_id);
            ?>
        <a href="<?php echo base_url('study-packages/download/'.encrypt($itemdetail->id.'.'.$this->session->userdata('customer_id')))?>" class="subjectbtn btn btn-primary btn-raised btn-lg" >Download Now</a>
                <?php
        }else{		
		
?>     
<a href="<?php echo base_url('purchase-courses#urlid_'.$exam_id)?>" class="subjectbtn btn btn-primary btn-raised btn-lg" >Buy To Download</a>


       <!--<button itemname="<?php echo $isProduct->modules_item_name; ?>" 
                        type="<?php echo $isProduct->type ?>" 
                        itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>" 
                        itemid="<?php echo $isProduct->id ?>"
                        itemqty="1" 
                        action_type="1"
                        offline='0'
                        class="btn-md btn btn-raised btn-warning addtocart"
                        name="btnAddToCart">Buy To Download</button>-->
        <?php 
		} ?>
        
        
                        <?php if ($isProduct->offline_status == 1) { ?>
                    <button itemname="<?php echo $isProduct->modules_item_name; ?>"  
                            type="<?php echo $isProduct->type ?>" 
                            itemprice="<?php echo $isProduct->discounted_price > 0 ? $isProduct->discounted_price : $isProduct->price ?>"                 
                            itemid="<?php echo $isProduct->id ?>"
                            itemqty="1"
                            action_type="1"
                            offline='1'
                            class="btn-xs btn btn-raised btn-warning addtocart"
                            name="btnAddToCart">Buy Offline</button>
                        <?php } ?>
                    <?php } else {
                      
                    
    if(!$user_purcheses || !$pid_value){
        $userBrought ='no'; 
    }else{
        $userBrought ='yes'; 
    }
    if($userBrought=='yes'){
        ?> <a target="_blank" href="<?php echo base_url('study-packages/download/'.encrypt($file->id.'.'.$this->session->userdata('customer_id')))?>"  class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
   <?php echo "Download Now";?>
                          </a><?php
    }
                    
                    }
                    
                    
                    
                     //File name can be show only for specific account for testing purpose.
                    $currentuserid= $this->session->userdata('customer_id');
                    
          if(isset($currentuserid)&&($currentuserid)=='71696'){
              
             
              $fnameshow='N.A.';      
              if(isset($file->id)){
                  $this->load->model('File_model');
               $file_detail = $this->File_model->detail($file->id); 
               $fnameshow=$file_detail->filename_one;
              }
          ?>
        <input type="hidden" value="<?php echo $fnameshow; ?>" > 
            <?php      
        }
                    
                    
         }else{
             ?>
                 
                 <button class="btn-md btn btn-raised btn-warning">NOT FOR SALE</button>
                     <?php
         }
         
                ?>
    </div>              
</div>       
</div>