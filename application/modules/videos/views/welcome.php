<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb'); ?>
            <!-- New UI for Product Details -->
            <?php if ($isProduct) { ?>
                <div class="col-md-12">
                    <?php //$this->load->view('common/productdetailsnew'); ?>
                </div>
            <?php }  if (!$this->session->userdata('purchases') || !in_array_r($isProduct->id, $this->session->userdata('purchases'))) {
				$product_brought='no';
			}else{
				$product_brought='yes';
			}	
			
		/*For getting main product buy or not*/
		if(isset($mainPrdlist[0]->productlist_id)){
			$mainPrdId=$mainPrdlist[0]->productlist_id;
		}else{
			$mainPrdId=0;
			
		}
			 if (!$this->session->userdata('purchases') || !in_array_r($mainPrdId, $this->session->userdata('purchases'))) {
				$product_brought='no';
			}else{
				$product_brought='yes';
			}	
			
			
			?>
			<!--For Subject and chapter-->
			
    <div class="row">
        <div class="container" style="background-color: #f7f9fa;">
         
<?php if (!isset($selectedsubject) && isset($subjects_array)) { ?>                
                                <div class="col-sm-12 col-md-12 bro_subject" style="min-height:200px;">

                                        <div class="col-md-12 text-center"><h2 class="select_heading">Browse By Subjects</h2>
                                    <?php 
                                    $contant_avail='no';
                                    foreach ($subjects_array as $key => $value) {
                                        if ($value['count'] > 0) {
                                    $contant_avail='yes';
                                            ?>
											
											<div class="sub_btn">
											
                                            <a title="Video Lectures for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-sq-lg" type="button">
											<i class='fa fa-book fa-5x'></i>

<br>
            <?php echo $value['name']; ?>         <br/><span class="badge"><?php echo $value['count']; ?></span>
                                            </a> 
											</div>
                                        <?php }
}
if($contant_avail=='no'){

    ?><div class="col-md-12 text-center">No Information Found!</div><?php 
}
                                    ?>
                                        </div>
                                <?php } elseif (isset($chapters_array)&&$chapter_id<1) {
                                    $chapters__cont_avail='no';
                                    ?>
                                    <div class="col-md-12 text-center"><h2 class="select_heading">Browse By Chapters</h2>
                                        <?php foreach ($chapters_array as $key => $value) {
                                            if ($value['count'] > 0) {
                                                $chapters__cont_avail='yes';
                                                ?>
												
												<div class="sub_btn">

                                            <a title="Video Lectures for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-' , TRUE) . '/' . $selectedsubject->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn select_subject_btn btn btn-primary btn-raised btn-lg" type="button">
                                            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>
											</div>
                                    <?php }                                   
                                    }
                                     ?> 
                                    </div>
                                    <?php
                                    if($chapters__cont_avail=='no'){
                                        ?>
                                    <div class="col-md-12 text-center">No Information Found!</div>
                                        <?php
                                    }
                                ?>
                                           
                                </div>	
			
<?php } ?>
        </div>
		<?php 
		$segmet_two=$this->uri->segment(2);
		
		if(isset($segmet_two)&&$segmet_two!=''){ ?>
		<!--product in subject or chapter-->			
            <div class="clearfix"></div>
			<div class="col-md-12"><!--
                <div class="col-md-12 text-center"><h2>Available Video Series</h2></div>-->
                <div class="clearfix"></div>
                <div class="row"><?php
                if ($playlist){
                    $count = 1;
                    foreach ($playlist as $qb) {
						 $totalVideo=$this->Videos_model->getPlaylistVideosCount($qb->id);
						if(isset($totalVideo)&&$totalVideo>0){
						
                        if ($count == 9 && $this->uri->total_segments() == 1)
                            break;

                        if ($count > count($this->config->item('bgimages'))) {
                            $count = 1;
                        }
                        $index = $count - 1;
                         $vpUrl=generateContentLink('videos', $qb->exam, $qb->subject, $qb->chapter, $qb->name.'-relationid-'.$qb->v_relations_id, $qb->id); ?>
                <a class="lazy_recent_video" href="<?php echo $vpUrl; ?>">
                    
                    <div class="col-xs-6 col-sm-4 col-md-2">
                        <div class="col-item offer offer-success" style="height:140px;">                            
                            	<div class="shape">
					<div class="shape-text">
					<span class="glyphicon glyphicon  glyphicon-facetime-video"></span>		
					</div>
				</div>
                            <div>
                               
                                    <div class="offer-content">                 
                                        
                                        <h6 class="vid_prod_hed" title="<?php echo $qb->name; ?>"><?php echo $qb->name; ?></h6>       
                                    </div>
             
                                    <div class="separator btn_prod_ved">
<div class="price"><h5 class="chepter-text-color"><?php echo $totalVideo; ?> Videos</h5></div>
                                                          
                                    </div>
                                                            </div>
                        </div>
                    </div>
                </a>
                        <?php
					$count++;
					}
                    }
					
					$playlistCnt=count($playlist);
					if(isset($playlistCnt)&&$playlistCnt==1){
					
		redirect($vpUrl);
                die;	
					}
					
                }else{
                    ?>
                    
                <div class="col-md-12 text-center">No Information Found!</div>    
                    <?php
                }
                ?>
                </div>
            </div>
			<!--Product in Subject or chapter End-->
			<?php } ?>
    </div>
			<!--For Subject and chapter End..-->
		
            <div class="clearfix"></div>

			<?php
			if($product_brought=='no'||$this->uri->total_segments() == 1){ ?>
			<div class="col-md-12 col-lg-12">
                <?php			
				if ($exam_id == 0) {
		redirect('purchase-courses'); die;
				}else{
				$this->load->view('common/productslistnew'); 
				}
				?>
            </div>
            <div class="clearfix"></div>
			
			<?php }
			if($product_brought=='no'){ ?>
            <div class="col-md-12">
                            <div class="container">
                                <?php
                                if ($freevideos) {
                                    ?>
                                <div class="col-md-12 text-center"><h2><a href="<?php echo base_url('featured-videos')?>">Demo Video Lectures</a></h2></div>    
                                    <?php
                                    $count = 1;
                                    foreach ($freevideos as $video) {
                                        if ($count == 13 && $this->uri->total_segments() == 1)
                                            break;
                                        ?>
                                        <div class="outer col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                                            <div class="pic wel_vid"> 
                                                <a href="<?php echo base_url('videos/' . url_title($video->exam, '-', true) . '/' . url_title($video->subject ? $video->subject : 'all', '-', true) . '/' . url_title($video->chapter ? $video->chapter : 'all', '-', true) . '/' . url_title($video->playlist ? $video->playlist : 'all', '-', true) . '/' . url_title($video->title, '-', true) . '/' . $video->id) ?>" <?php if (!$this->session->userdata('customer_id')) {
                                            echo 'onclick="return showmsg();return false;"';
                                        } ?> title="<?php echo $video->title ?>">
                                                    <img class="img-responsive lazy" data-original="https://i.ytimg.com/vi/<?php echo $video->video_url_code ?>/mqdefault.jpg" src="/assets/frontend/images/index.png"/>
                                                    <p class="pic-caption bottom-to-top"> 
                                        <?php echo $video->title ?> <br> <i class="material-icons">play_arrow</i></p> 
                                                </a>
                                                <h5 class="vid_prod_hed"><?php echo $video->title ?></h5>
                                            </div>
                                        </div>
                                        <?php
                                        $count++;
                                    }
                                    ?>
                                        
                                <div class="col-md-12 "><span class="pull-right"><a href="<?php echo base_url('featured-videos') ?>">Browse All Free Videos</a></span></div>
                                        <?php
                                }
                                ?>
                            </div>
             </div>
            <div class="clearfix"></div>
            
			<?php } ?>
        </div>
    </div>
    

    <!-- End New UI for Product Details -->
    <!--<div class="col-md-3 col-sm-3">
<?php //$this->load->view('common/leftnav');  ?>
    </div>-->
 
                <hr>
            <!-- /. PAGE INNER  -->
        </div>
   
