<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php if ($this->session->flashdata('update_msg')) { ?>
                <div class="alert alert-success alert-dismissible" id="success-alert" role="alert">
                    <strong><?php echo $this->session->flashdata('update_msg'); ?></strong>
                </div>
            <?php } ?>
            
              <?php if ($this->session->flashdata('error_msg')) { ?>
                <div class="alert alert-danger alert-dismissible" id="success-alert" role="alert">
                <strong><?php echo $this->session->flashdata('error_msg'); ?></strong>
                </div>
            <?php } ?>
            <?php $this->load->view('customer/breadcrumb'); ?>
            <div class="col-md-3 col-sm-12 my_account"> 
                <?php $this->load->view('customer/menu'); ?>
            </div>
            
            
            <div id="showbught_result" class="my_account_right"></div>

            <div class="col-sm-12 col-md-9 dash_panel customer-packageModel" id="recent_orderdiv">
                 
                <!--
                <div class="subline-title">
        <span>Note-The link will be activated after payment is successful and Order Status is completed.  </span>
    </div>-->
     <div class="subline-title">
         <h1>My Subscriptions</h1>
    </div>
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">My Study Packages Subscription</a></li>
                    <li role="presentation"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">My Videos Subscription</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="profile"><?php if (isset($purchased_studymaterial) && count($purchased_studymaterial) > 0) {
                            ?><div class="col-md-12 col-item"><?php
                                
                                foreach ($purchased_studymaterial as $k => $v) {                                   
                                    $content = '';
                                    foreach ($v as $k1 => $v1) {
                                         ?><div class='col-xs-12 col-sm-6 col-md-4 photo text-center'><?php 
                                        //$content=$this->Content_model->getContentTypeDetail($v);
                                        if ($k == 1) {
                                            $content = 'study-packages';
                                        }
                                        $href = base_url($content);
                                        $details = $this->Pricelist_model->getDetails($v1);
                                      
                                        
                                        $name = $details->modules_item_name;  
                                        if($details->modules_item_id == 0 && $details->item_id == 0) {

                                            $href.= '/' . url_title($details->exam, '-', true) . '/' . $details->exam_id;
                                            if ($details->subject_id > 0) {
                                                $href.= '/' . url_title($details->subject, '-', true) . '/' . $details->subject_id;
                                            }
                                            if ($details->chapter_id > 0) {
                                                $href.= '/' . url_title($details->chapter, '-', true) . '/' . $details->chapter_id;
                                            }
                                            
                                        } elseif ($details->modules_item_id > 0 && $details->item_id == 0) {
                                            $href.= '/' . url_title($details->exam, '-', true);
                                            if ($details->subject_id > 0) {
                                                $href.= '/' . url_title($details->subject, '-', true);
                                            }
                                            if ($details->chapter_id > 0) {
                                                $href.= '/' . url_title($details->chapter, '-', true);
                                            }
                                            
                                            $href = '/' . url_title($details->modules_item_name, '-', true) . '/' . $details->modules_item_id;
                                        } elseif ($details->item_id > 0) {
                                            $this->load->model('File_model');
                                            $itemdetail = $this->File_model->getStudyPackageDetails($details->item_id);
                                            $name = $itemdetail->displayname ? $itemdetail->displayname : $itemdetail->filename;
                                            $href.= '/' . url_title($itemdetail->exam, '-', true);
                                            if ($itemdetail->chapter) {
                                                $href.= '/' . url_title($itemdetail->chapter, '-', true);
                                            } else {
                                                $href.='/all';
                                            }
                                            if ($itemdetail->subject) {
                                                $href.= '/' . url_title($itemdetail->subject, '-', true);
                                            } else {
                                                $href.='/all';
                                            }
                                            $href.='/' . url_title($itemdetail->name, '-', true);
                                            $href.='/' . url_title($itemdetail->filename, '-', true) . '/' . $itemdetail->id;
                                        }
                                        
                                        if(isset($itemdetail)){
                                           
                                        ?>
                                        <a href="<?php echo $href; ?>" title="<?php echo $name ?>">
                                            <img class="img-responsive" src="<?php echo base_url('upload/webreader/'.$itemdetail->filename.'/docs/'.$itemdetail->filename_one.'_1_thumb.jpg')?>" style="width: 60%;">
                                            <div class="customer-bookTitle"><?php echo $name ?></div>
                                        </a>
                                             
                                             <p>
                                              <?php 
                                             if($details->item_id<1){ 
                                              ?> <a type="button" class="subjectbtn btn btn-primary btn-raised btn-lg" href="<?php echo $href; ?>" target="_blank">View/Download</a>
                                             <?php }else{ ?>
                                                                                                  <a type="button" class="subjectbtn btn btn-primary btn-raised btn-lg" href="<?php echo base_url('study-packages/download/'.encrypt($itemdetail->id.'.'.$this->session->userdata('customer_id')))?>" target="_blank">Download Now</a>     <?php
                                             } ?>
                                                 
                                             </p><?php }else{ ?>
                                             
                                            <div style="position: relative;
    text-align: center;
    color: Black;">
       
                                                <a href="<?php echo $href; ?>" title="<?php echo $name ?>"><img src="<?php echo base_url('assets/frontend/product_images/studypackage_blank.png'); ?>" alt="bootsnipp" class="img-rounded img-responsive"></a>
  <span style="position: absolute;
    top: 52%;
    left: 1%;
    padding-left: 8px;
    padding-right: 8px;
    /*transform: translate(-50%, -50%);*/">
      <h3>
     <?php 
echo $details->modules_item_name;    
     ?></h3>
  </span>
      </div>                                
        <a href="<?php echo $href; ?>" title="<?php echo $name ?>">
        <div class="customer-bookTitle"><?php echo $name ?></div>
        </a>                                             
        <p>
        <a type="button" class="subjectbtn btn btn-primary btn-raised btn-lg" href="<?php echo $href; ?>" target="_blank">View/Download</a>
        </p>
                                    <?php } ?>
                                    </div>
                                        <?php  
                                         }
                                         }
                                ?></div><?php
                                } else {
                                ?>
                                <div class="col-md-12 text-center text-danger">
                                <p class="text-uppercase text-lg-center">You have not purchased any study package.</p>
                                 
                                    <p class="text-uppercase text-lg-center"><a href="<?php echo base_url().'/exam';?>"><span class="label label-success">Buy Now</span></a></p></div>    
                                <?php }
                            ?></div>
                        <div role="tabpanel" class="tab-pane" id="home"><?php if (isset($purchased_videos) && count($purchased_videos) > 0) {
                    ?><div class="col-md-12 col-item"><?php
                                foreach ($purchased_videos as $k => $v) {
                                    $href = base_url('videos');
                                    $details = $this->Pricelist_model->getDetails($v);   //print_r($details);
                                   
                                     $name = $details->modules_item_name; 
                                    
                                    if ($details->modules_item_id == 0 && $details->item_id == 0) {

                                        $href.= '/' . url_title($details->exam, '-', true) . '/' . $details->exam_id;
                                        if ($details->chapter_id > 0) {
                                            $href.= '/' . url_title($details->chapter, '-', true) . '/' . $details->chapter_id;
                                        }
                                        if ($details->subject_id > 0) {
                                            $href.= '/' . url_title($details->subject, '-', true) . '/' . $details->subject_id;
                                        }
                                    }
                                    if ($details->modules_item_id > 0) {
                                        $href.= '/' . url_title($details->exam, '-', true);
                                        if ($details->chapter_id > 0) {
                                            $href.= '/' . url_title($details->chapter, '-', true);
                                        }
                                        if ($details->subject_id > 0) {
                                            $href.= '/' . url_title($details->subject, '-', true);
                                        }
                                        $href = '/' . url_title($details->modules_item_name, '-', true) . '/' . $details->modules_item_id;
                                    }
                                    ?><div class='col-xs-12 col-sm-6 col-md-4 photo text-center'>
                                        <a href="<?php echo $href; ?>" title="<?php echo $name ?>">
                                            <?php echo getProductImage($details->image); ?>
                                            <div class="customer-bookTitle"><?php echo $details->modules_item_name ?></div>
                                        </a>
                                             
                                         <p>
                                                 <a type="button" class="subjectbtn btn btn-primary btn-raised btn-lg" href="<?php echo $href; ?>" target="_blank">View</a>
                                             </p>
                                        
                                    </div><?php
                                    }
                                    ?></div><?php } else {
                                    ?>
                                <div class="col-md-12 text-center text-success"><p class="text-uppercase text-lg-center">You have not purchased any video.</p>
                                
                                    <p class="text-uppercase text-lg-center"><a href="<?php echo base_url().'/videos';?>"><span class="label label-success">Buy Now</span></a></p>
                                
                                
                                </div>
                                <?php
                            }
                            ?></div>

                    </div>
                </div>
            </div>
        </div>
    </div>