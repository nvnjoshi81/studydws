<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb'); 
        if (!isset($selectedexam)) { 
if((isset($isProduct_array))&&(count($isProduct_array)>0)){
    ?> <div class="clearfix"></div>
        <?php
//$this->load->view('common/product_list_packages'); 
//$this->load->view('common/product_list_packages'); 

		redirect('purchase-courses'); die;
}
}
//<!--Start Slider -->

            $showsm_slider='no'; 
            if(($showsm_slider=='yes')&&($exam_id<1||$exam_id=='')){  ?>
            <div><img width="100%" height="350px" src="<?php echo base_url('assets/images/studyadda_packge.jpg') ?>" alt="Studyadda"></div>
            <div class="clearfix"><br></div>
            <?php } 
            if(($showsm_slider=='yes')&&($exam_id<1||$exam_id=='')){  ?>   
            <div class="clearfix"></div>
                  <div class="mid_advertise">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active" align="center">
      <img src="<?php echo base_url('assets/images/sm-slider/pk_slide_1.jpg') ?>" alt="Studyadda">
    </div>

    <div class="item" align="center">
      <img src="<?php echo base_url('assets/images/sm-slider/pk_slide_2.jpg') ?>" alt="Studyadda">
    </div>

    <div class="item" align="center">
      <img src="<?php echo base_url('assets/images/sm-slider/pk_slide_3.jpg') ?>" alt="Studyadda">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>   </div>
            <div class="clearfix"><br><br></div>
        <?php } ?>    <!--End Slider -->
            <?php 
            if($isProduct&&$this->uri->segment(2)!='') { ?>
             
                    <?php //$this->load->view('common/productdetailsnew'); ?>
                
            <?php } ?>
            
       <div class="clearfix"></div>    
            <div class="col-sm-12 col-md-12">
                <?php   if((!isset($selectedexam))&&(count($solutions_array)>0)){ 
                   ?>
                    <div class="col-sm-12 col-md-12"><h2>All Study Packages</h2></div>   
                   <?php 
                    
                }?>
                <div class="ncert_cont col-sm-12 col-md-6">
                    <?php $count = 1; 
                    
                    if(count($solutions_array)>0){                        
                    foreach ($solutions_array as $key => $value) { ?>
                        <?php 
                        if (!isset($selectedsubject)) { ?>
                            <ul class="nav">
                                <?php if (!isset($selectedexam)) { ?>
                                    <h3 class="text-success">
                                        <i class="material-icons">update</i>
                                        <a href="<?php echo base_url('study-packages/' . url_title($value['name'], '-', true) . '/' . $key) ?>">
                                            <?php echo $value['name'] ?> Study Packages
                                        </a>
                                    </h3>
                                <?php  foreach ($value['subjects'] as $k => $v) {
                                    if (!isset($selectedsubject)) {
                                        ?>
                                        <li>
                                            <a href="<?php echo base_url('study-packages/' . url_title($value['name'], '-', true) . '/' . $key . '/' . url_title($v['name'], '-', true) . '/' . $k) ?>">Study Packages for <?php echo $value['name'] ?> <?php echo $v['name'] ?>
                                            </a>
                                        </li>
        <?php 
               }
        }
        ?> 

                            </ul>
                            <?php //if ($count == round(count($solutions_array) / 2, 0, PHP_ROUND_HALF_EVEN)) {
                            if($count==2){
                                echo '</div><div class="ncert_cont col-sm-12 col-md-6">';
                                $count = 1;
                            } ?>

        <?php $count++;
    }
    
     }
} 
}
?>
                </div>
     <div class="clearfix"></div>
                <div id="page-inner" class="exam_page_cont">
                    <!-- /. ROW  -->
                  <div class="row"> 
    <?php
$bookclass = array('btn-default', 'btn-primary', 'btn-warning', 'btn-info', 'btn-danger');     
            if($this->uri->total_segments() > 1){
               if (!isset($selectedsubject) && isset($subjects_array)) {
                   
                   ?>
                            <!--Showing Subject Start-->
                                <div class="col-md-12 text-center bavl">
                                    <h2 class="select_heading">Select Subject</h2>      
                                </div>     
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>
                                    <?php
                                    $containt_avail='no';
                                    foreach ($subjects_array as $key => $value) {
                                        if ($value['count'] > 0) { 
                                            $bookclass_cnt = rand(0, 3);
                                            $containt_avail='yes';
                                    ?>
                                                <a style="text-transform:none" title="Study Packages for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class='btn btn-sq-lg <?php echo $bookclass[$bookclass_cnt]; ?>'><i class='fa fa-book fa-5x'></i><br/><?php echo ucfirst($value['name']); ?><br><span>(<?php echo $value['count']; echo ucfirst(' Packages ');?> )</span> </a>  
<?php }
                                    }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--End Showing Subject -->   
                    <?php
               } elseif (isset($chapters_array) && count($chapters_array) > 0) {  
                   if($chapter_id == 0){    
?>
                                <div class="clearfix"></div>
                                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"  >
                                        <h2>Select Chapter</h2> 
                                                <?php
                                    $containt_avail='no'; 
                                     foreach ($chapters_array as $key => $value) {
                                            if ($value['count'] > 0) { 
                                                ?>
                                            <a title="Study Packages for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-' , TRUE) . '/' . $selectedsubject->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn select_subject_btn btn btn-primary btn-raised btn-lg" type="button">
                                                <?php echo $value['name']; ?> 
                                <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>
                                    <?php }
                                }
                                    ?>  
                                </div>
<?php } }         
      }     
      ?> </div>
            </div>
            </div>
        <?php   ?>
       
            
       <div class="clearfix"></div>    
            <div class="col-md-12">
                <?php 
                
                $this->load->view('common/productslistnew');
                  
                $this->session->set_userdata('sub_purchases','no');
                ?>
            </div>
            <?php 
          
            $showBrows='no';
            if($showBrows=='yes'&&$chapter_id == 0){ ?>
           <div class="clearfix"></div>
            <div class="col-md-12">
                <div class="col-md-12 text-center"><h2>Browse Study Packages</h2></div>
                <div class="clearfix"></div>
                <?php
                if ($studymaterials) {
                    $count = 1;
                    foreach ($studymaterials as $qb) {
                        if($qb->chapter_id>0){
                        if ($count == 13 && $this->uri->total_segments() == 1)
                            break;

                        if ($count > count($this->config->item('bgimages'))) {
                            $count = 1;
                        }
                        $index = $count - 1;
                        ?>
                        <a href="<?php echo base_url('study-packages/'.url_title($qb->exam,'-',true).'/'.$qb->exam_id.'/'.url_title($qb->subject,'-',true).'/'.$qb->subject_id.'/'.url_title($qb->chapter,'-',true).'/'.$qb->chapter_id); ?>">
                        <div class="outer col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                            
                            <div class="container1" style="background-size: 100% 100%; background-repeat: no-repeat;background-image: url('/assets/frontend/images/<?php echo $this->config->item('bgimages')[$count - 1] ?>');">
                                <div class="content">
                                    <!--<a href="<?php //echo generateContentLink('study-packages', $qb->exam, $qb->subject, $qb->chapter, $qb->name, $qb->id); ?>">-->
                                        <?php //echo $qb->name; ?>
                                    
                                        <?php echo $qb->chapter; ?>
                                </div>
                            </div>                              
                        </div>
                        </a>
                        <?php
                        $count++;
                    }}
                }else{
                    ?>
                <div class="col-md-12 text-center">No Information Found!</div>
                     <?php
                }
                ?>
            </div>
            <?php }else{ ?>
            <!--<div class="col-md-12">
                <div class="col-md-12 text-center"><h2>Available Study Packages</h2></div>
                <div class="clearfix"></div>
                <?php
               
                    $count = 1;
                    foreach ($allfiles as $key=>$value) {
                        foreach($value as $file){
                        ?>
                <div class="col-xs-12 col-sm-4 col-md-3 pdflistpanel">
                                <div class="col-item">
                                    <div class="photo"> 
                                        <a href="<?php echo base_url('study-packages/'.url_title($selectedexam->name,'-',true).'/'.  url_title($selectedsubject->name,'-',true).'/'.  url_title($selectedchapter->name,'-',true).'/'.  url_title($key,'-',true).'/' . url_title($file->displayname ? $file->displayname : $file->filename, '-', true) . '/' . $file->file_id) ?>" title="<?php echo $file->displayname ? $file->displayname : $file->filename ?>">
                                            <img src="<?php echo base_url('upload/webreader/' . $file->filename . '/docs/' . $file->filename . '.pdf_1_thumb.jpg') ?>">
                                        </a>
                                    </div>
                                    <div class="info">
                                        <div class="row">
                                            <div class="price col-xs-12 col-md-12">

                                                <h5 class="vid_prod_hed"><?php echo str_replace('_', ' ', $file->displayname ? $file->displayname : $file->filename) ?></h5>

                                                <h5 class="price-text-color">&nbsp;       <i class="fa fa-inr"> </i> <del class="del_txt"> <?php echo $file->price ?></del> <?php echo $file->discounted_price ?> </h5>
                                            </div>
                                              
                                        </div>
                                        <div class="separator btn_prod_ved">
                                            <?php if ($file->price > 0) {
                                                ?>
                                                <a href="<?php echo base_url('study-packages/'.url_title($selectedexam->name,'-',true).'/'.  url_title($selectedsubject->name,'-',true).'/'.  url_title($selectedchapter->name,'-',true).'/'.  url_title($key,'-',true).'/' . url_title($file->displayname ? $file->displayname : $file->filename, '-', true) . '/' . $file->file_id) ?>" title="<?php echo $file->displayname ? $file->displayname : $file->filename ?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>
                                            <?php } ?>
                                        </div>

                                        <div class="clearfix"> </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        $count++;
                    }
                    }
                
                ?>
            </div>-->
            <?php } 
                $showBrows='no';
            if(($showBrows=='yes')&&$this->uri->total_segments() > 1){ ?>
            
            
       <div class="clearfix"></div>    <div class="row">
        <div class="container">
          <div class="row">
        <div class="container" style="background-color: #f7f9fa;">
         
<?php if (!isset($selectedsubject) && isset($subjects_array)) { ?>                
                                <div class="col-sm-12 col-md-12 bro_subject" style="min-height:200px;">

                                        <div class="col-md-12 text-center"><h2>Browse By Subjects</h2>
                                    <?php 
                                    $containt_avail='no';
                                    foreach ($subjects_array as $key => $value) {
                                        if ($value['count'] > 0) {
                                    $containt_avail='yes';
                                    ?>
                                            <a title="Study Packages for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>   


                                        <?php }
                                    }
                                    
                                    if($containt_avail=='no'){
                                        ?><span>No Information Found!</span><?php
                                    }
                                    ?>
                                        </div></div>
                                <?php } elseif (isset($chapters_array) && count($chapters_array) > 0) { 
                                    ?>               <div class="col-sm-12 col-md-12 bro_subject" style="min-height:200px;">
                                    <div class="col-md-12 text-center">
                                        <h2>Browse By Chapters</h2>
                                        <?php foreach ($chapters_array as $key => $value) {
                                            if ($value['count'] > 0) {
                                                ?>
                                            <a title="Study Packages for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-' , TRUE) . '/' . $selectedsubject->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
                                            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>
                                    <?php }
                                }
                                ?>
                                 </div>  </div>         
                              
                                <?php  } ?>
        </div>
    </div>


                        
        </div>
    </div>
            <?php } ?>
            
    </div></div>
</div>