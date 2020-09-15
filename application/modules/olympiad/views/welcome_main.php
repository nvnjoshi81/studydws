<div id="wrapper">
    <div class="container">
        <div class="row">
        <?php $this->load->view('common/breadcrumb'); ?>
        <div class="col-sm-12 col-md-12">
            <div class="ncert_cont col-sm-12 col-md-6">
                   <!-- ncert subject paper panel -->
                   <?php $count=1;foreach($solutions_array as $key=>$value){ ?>
                   <?php if(!isset($selectedsubject)){ ?>
                   <ul class="nav">
                       <?php if(!isset($selectedexam)){ ?>
                   <h3 class="text-success">                       
                       <i class="material-icons">update</i>
                       <a href="<?php echo base_url('ncert-solution/'.url_title($value['name'],'-',true).'/'.$key)?>">
                          <?php echo $value['name']?> Free NCERT Solutions 
                       </a>
                   </h3>
                       <?php } ?>
                   <?php  foreach($value['subjects'] as $k=>$v){ 
                    if(!isset($selectedsubject)){   
                    ?>
                   <li>
                       <a href="<?php echo base_url('ncert-solution/'.url_title($value['name'],'-',true).'/'.$key.'/'.url_title($v['name'],'-',true).'/'.$k)?>">
                          Free NCERT Solutions for <?php echo $value['name']?> <?php echo $v['name']?>
                       </a>
                   </li>
                    <?php 
                    }
                    
                    } ?> 
                  
                   </ul>
                   <?php if($count== round(count($solutions_array)/2,0,PHP_ROUND_HALF_EVEN)){ echo '</div><div class="ncert_cont col-sm-12 col-md-6">'; $count=1;}?>
                 
                   <?php $count++; }} ?>
                      </div>
            <div class="col-md-12">
                <!--<div class="col-md-12 text-center"><h2>NCERT Study Packages</h2></div>-->
                <?php 
    
    if($rstudypackage){ foreach($rstudypackage as $key=>$files){ 
        foreach($files as $k=>$file){
        $details=$this->File_model->getStudyPackageDetails($file->id);
                $url=  generateContentLink('study-packages', $details->exam, $details->subject, $details->chapter, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
    //print_r($file);?>
    <div class="col-xs-12 col-sm-4 col-md-3 pdflistpanel">
            <div class="col-item">
              <div class="photo"> 
                     <a href="<?php echo $url;?>" title="<?php echo $details->displayname?$details->displayname:$details->filename?>">
            <img src="<?php echo base_url('upload/webreader/'.$file->filename.'/docs/'.$file->filename.'.pdf_1_thumb.jpg')?>">
            </a>
                                </div>
              <div class="info">
                <div class="row">
                  <div class="price col-xs-12 col-md-12">
                      <h5 class="vid_prod_hed"><?php echo $details->displayname?$details->displayname:$details->filename?></h5>
                    <h5 class="price-text-color">&nbsp;       <i class="fa fa-inr"> </i> <del class="del_txt"> <?php echo $file->price?></del> <?php echo $file->discounted_price?> </h5>
                </div>
                  <!--<div class="rating hidden-sm col-md-6"> <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star"> </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star"> </i><i class="fa fa-star"></i> </div>-->
                </div>
                <div class="separator btn_prod_ved">
                    
                   <?php if($file->price > 0){
                ?>
           <a href="<?php echo base_url('study-packages/show/'.  url_title($file->filename,'-',true).'/'.$file->file_id)?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>
            <?php  } ?>
                </div>
                
              </div>
            </div>
          </div>
          

    <?php } } }?>
            </div>            
            <div class="col-md-12">
            <!--<div class="col-md-6">-->
                <div class="col-md-12 text-center"><h2>Recent NCERT Solutions</h2></div>
                <?php
                    if($ncertsolutions){ $count=1;foreach($ncertsolutions as $qb){
                    if($count==10 && $this->uri->total_segments() ==1) break;
                    $count = 1;
                   
                        if ($count == 9 && $this->uri->total_segments() == 1)
                            //break;

                        if ($count > count($this->config->item('bgimages'))) {
                            $count = 1;
                        }
                        $index = $count - 1;
                        ?><a href="<?php echo generateContentLink('ncert-solution',$qb->exam,$qb->subject,$qb->chapter,$qb->name,$qb->id);?>">                                     
                        
                          <div class="col-xs-6 col-sm-4 col-md-2">
                         <a href="<?php echo generateContentLink('ncert-solution',$qb->exam,$qb->subject,$qb->chapter,$qb->name,$qb->id);?>">
                        <div class="col-item offer offer-success" style="height:80px;"> 
                            <div class="shape">
					<div class="shape-text">
						<span  class="glyphicon glyphicon  glyphicon-book"></span>
					</div>
                                
				</div>
                            <div>
                                
                                      <div class="offer-content">
                                        
                                        <?php     $prdname_cnt=strlen($qb->name);
                 
                $prdhead_cnt=$prdname_cnt;
        
                                           if($prdhead_cnt>50){
                                               $prdhead= substr($qb->name,0,55).'..';//'<h5 style="color:#000">'.$qb->chapter.'</h5>';
                                           } else{
                                                $prdhead= $qb->name ;
                                           
                                           }
                                        ?>    
                                        <h6 class="vid_prod_hed" title="<?php    echo $qb->name; ?>"><?php echo $prdhead; ?></h6>      
                                    </div>
                             </div>
                            </div></a>  
                        </div> 
                       </a> 
                        <?php
                        $count++;
                    }
                }
                ?>
           <!-- </div>
             <div class="col-md-6">
             <div class="col-md-12 text-center"><h2>NCERT Video Solutions</h2></div>
                <?php
                if (isset($rvideos)) {
                    $count = 1;
                    foreach ($rvideos as $qb) {
                        if ($count == 9 && $this->uri->total_segments() == 1)
                            break;

                        if ($count > count($this->config->item('bgimages'))) {
                            $count = 1;
                        }
                        $index = $count - 1;
                        ?>
                        <div class="outer col-lg-6 col-md-6 col-sm-6 col-xs-12 ncert_solu_box">
                            <div class="container1 round_box_color"  style="background-size: 100% 100%; background-repeat: no-repeat;background-image: url('/assets/frontend/images/<?php echo $this->config->item('bgimages')[$count - 1] ?>');">
                                <div class="content">
                                    <a href="<?php echo generateContentLink('videos', $qb->exam, $qb->subject, $qb->chapter, $qb->name, $qb->id); ?>"><?php echo $qb->name; ?></a><p class="videocount"><?php echo $this->Videos_model->getPlaylistVideosCount($qb->id); ?> Videos</p>
                                </div>
                            </div>
                        </div>
                 <div class="clearfix"></div>
                        <?php
                        $count++;
                    }
                }
                ?>
             </div>-->
        </div>
            
            
           
            <div class="row our_free_video">
            <div class="col-lg-12">
                <h2 class="page-header"><a href="<?php echo base_url('free-videos')?>">Our Free Videos</a></h2>
            </div>
            <div class="col-md-6 vid_title text-center homeimg">
                <div class="col-lg-12">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url('free-videos/jee-main-and-advanced/28')?>" alt="IIT JEE Free Video Lectures" title="IIT JEE Free Video Lectures">  
                        <img width="177" height="152" src="<?php echo base_url('assets/frontend/images/1s.png')?>" alt="IIT JEE Free Video Lectures" class="img-responsive">IIT JEE Free Video Lectures</a>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url('free-videos/neet/29')?>" alt="NEET Free Video Lectures" title="NEET Free Video Lectures">
                        <img width="177" height="152" src="<?php echo base_url('assets/frontend/images/3s.png')?>" alt="NEET Free Video Lectures" class="img-responsive">NEET Free Video Lectures</a>
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url('free-videos/12th-class/22')?>" alt="12th Class Free Video Lectures" title="12th Class Free Video Lectures">
                        <img width="177" height="152" src="<?php echo base_url('assets/frontend/images/2s.png')?>" alt="12th Class Free Video Lectures" class="img-responsive">12th Class Free Video Lectures</a>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url('free-videos/11th-class/23')?>" alt="11th Class Free Video Lectures" title="11th Class Free Video Lectures">
                        <img width="177" height="152" src="<?php echo base_url('assets/frontend/images/4s.png')?>" alt="11th Class Free Video Lectures" class="img-responsive">11th Class Free Video Lectures</a>
                </div>
                </div>
            </div>
                
                
            
            <?php
            $random_video_array= array(0=>base_url('assets/frontend/images/studyadda_adverd.mp4'),1=>base_url('assets/frontend/images/studyadda_adverd.mp4'));
            $random_video_link =rand(0,1);
            ?>
            <div class="col-md-6 our_vid_player" id="videoplayer_div">
                <video width="100%" height="auto" autoplay="" controls="" id="videoplayer">
                    <source type="video/mp4" src="<?php echo $random_video_array[$random_video_link];  ?>"></source>
                </video>
            </div>
        </div>  
            
            
            
       <div class="clearfix"></div>    
            
            <?php if($this->uri->total_segments() > 1){?>
            <div class="row">
        <div class="container" style="background-color: #f7f9fa;">
       
<?php if (!isset($selectedsubject) && isset($subjects_array) && $borwsebysubjects > 0) { ?>                
                                <div class="col-sm-12 col-md-12 bro_subject" style="min-height:200px;">

                                    <div class="col-md-12 text-center"><h2>Browse By Subjects</h2>
                                    <?php foreach ($subjects_array as $key => $value) {
                                        if ($value['count'] > 0) {
                                            ?>
                                            <a title="NCERT Solutions for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>   


                                        <?php }
                                    }
                                    ?>
                                        </div>
                                <?php } elseif (isset($chapters_array) && count($chapters_array) > 0) { ?>
                                   <!-- <div class="col-md-12 text-center"><h2>Browse By Chapters</h2>
                                        <?php foreach ($chapters_array as $key => $value) {
                                            if ($value['count'] > 0) {
                                                ?>

                                            <a title="NCERT Solutions for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-' , TRUE) . '/' . $selectedsubject->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
                                            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>



                                    <?php }
                                }
                                ?>
                                 </div>  -->        
                                </div>

<?php } ?>

                        
        </div>
    </div>
            <?php } ?>
        </div>
        
    
</div>
</div>
</div>
    