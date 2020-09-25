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
                 
                   <?php $count++; }} ?>
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
                                            <a title="NCERT Solutions for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn select_subject_btn btn btn-primary btn-raised btn-lg" type="button">
            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>   


                                        <?php }
                                    }
                                    ?>
                                        </div>
                                <?php } elseif (isset($chapters_array) && count($chapters_array) > 0) { 
								
								$totalseg=$this->uri->total_segments();
								if($totalseg<7){
								?>
                                    <div class="col-md-12 text-center"><h2>Browse By Chapters</h2>
                                        <?php foreach ($chapters_array as $key => $value) {
                                            if ($value['count'] > 0) {
                                                ?>
                                            <a title="NCERT Solutions for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-' , TRUE) . '/' . $selectedsubject->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn select_subject_btn btn btn-primary btn-raised btn-lg" type="button">
                                            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>
                                    <?php }
                                }
                                ?>
                                 </div>   

			<?php } } ?>

                        
        </div>
    </div>
            <?php } ?>
        </div>
		 <div class="clearfix"></div>      
            <div class="col-md-12">
                <div class="col-md-12 text-center"><h2>Recent NCERT Solutions</h2></div>
                <?php
				
				//print_r($ncertsolutions);
                if($ncertsolutions){ $count=1;foreach($ncertsolutions as $qb){
					/*WE want to send all associated file to question answer page*/
					if($idredirect>0){
					$qbid=$idredirect;	
					}else{
						
					$qbid=$qb->id;
					}
                ?>
                <div class="col-xs-6 col-sm-4 col-md-2">
                         <a href="<?php echo generateContentLink('ncert-solution',$qb->exam,$qb->subject,$qb->chapter,$qb->name,$qbid);?>">
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
                                               $prdhead= substr($qb->name,0,55).'..';
                                           } else{
                                                $prdhead= $qb->name ;
                                           
                                           }
                                        ?>    
                                        <h6 class="vid_prod_hed" title="<?php    echo $qb->name; ?>"><?php echo $prdhead; ?></h6>      
                                    </div>
                             </div>
                            </div></a>  
                        </div> 
                        <?php
                    }
                }
                ?>
           </div>
       <div class="clearfix"></div>   
	   <?php 
	   $showvideosection='no';
	   if($showvideosection=='yes'){ ?>
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
            
  <?php } ?>              
    
</div>
</div>
</div>
    