<div id="wrapper">
    <div class="container" id="container_top">
        <div class="row">
            <?php if ($this->session->flashdata('update_msg')) { ?>
                <div class="alert alert-success alert-dismissible" id="success-alert" role="alert">
                    <strong><?php echo $this->session->flashdata('update_msg'); ?>
                    </strong>
                </div>
            <?php } ?>
            <?php if($this->session->flashdata('error_msg')) { ?>
            <div class="alert alert-danger alert-dismissible" id="success-alert" role="alert">
            <strong><?php echo $this->session->flashdata('error_msg'); ?></strong>
            </div>
            <?php } ?>
            <?php $this->load->view('customer/breadcrumb'); ?>
            <div class="col-md-3 col-sm-12 my_account"> 
            <?php $this->load->view('customer/menu'); ?>
            </div>            
            <div class="col-sm-12 col-md-9 dash_panel customer-packageModel" id="recent_orderdiv"><div id="showbught_result"></div>
        <div class="row">
            <!--Video Section Start-->
            <div class="col-lg-12 fixpack">
           <div class="panel-group" id="accordion1">               
        <div class="panel panel-default">     
             <div class="btn-warning" style="padding:10px 15px;">
              <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse2"><i class="material-icons">ondemand_video</i> &nbsp; My Video Subscription</a>
        </h4>
            </div>
      <div id="collapse2" class="panel-collapse collapse">
          <?php if (isset($purchased_videos) && count($purchased_videos) > 0) {
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
                                    
                                    ?><div class="panel-body"><a href="<?php echo $href; ?>" target="_blank"><?php echo $details->modules_item_name ?></a></div><?php
                                }
          }else{
              ?>
                  <div class="panel-body text-center text-success">You have not purchased any video.
                                    <p class="text-uppercase text-lg-center"><a href="<?php echo base_url().'videos';?>"><span class="label label-success">Buy Now</span></a></p></div>
<?php
          }
?>      
      </div> 
    </div>
  </div>
                </div> 
      </div>
            </div>
            </div>
            
            <!--<div id="showbught_result" class="my_account_right"></div>-->
    
        </div>
    </div>       