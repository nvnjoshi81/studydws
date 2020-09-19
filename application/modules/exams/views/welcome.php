<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb'); 
			?>
            <div class="col-md-12 col-sm-12"> 
                <?php
				$segment_chpterseven =  $this->uri->segment(7);
                $totalsolvedp=0;
                if ($isProduct) {
				                    
					//echo "This is product area.";
//if($subject_id==''||$subject_id<1){                   
				   $this->load->view('common/productdetailsnew'); //}
}
				if($isProduct_array){
                // $this->load->view('common/product_testseries');
                }
                    if (isset($videoproductslist) && count($videoproductslist) > 0) {
                        ?><div class="clearfix"></div>  
                        <div class="row">
                                        
                        <?php
                        //$this->load->view('common/videoproductslist');
                        ?> 
                        </div>
                            <?php
                        }                          
                ?>
				<div class="clearfix"></div>
				<div id="page-inner" class=" container exam_page_cont">
                    <!-- /. ROW  -->
                    <div class="row">
                        <?php
                        $bookclass = array('bg-default','bg-primary','bg-warning','bg-info','bg-danger'); 
                        $outer_spcnt=0; 
                        if ($this->uri->segment(4) == '' && $this->uri->segment(3) != '') {
                            //print_r($subject_chapters);
                            if (isset($subject_chapters) && count($subject_chapters) > 0) {
                                ?>
                                <!--Showing Subject Start-->
                                <div class="container">
    <div class="page-header text-center">
        <h3>Select Subject</h3>
    </div> <!--class="row pack_sub"-->
    <div class="serve-top">
                                        
             <?php
   //print_r($subject_chapters);
            $totalsolvedp=count($solvedp);
            //$totalsp=count($sp);
             foreach ($subject_chapters as $subjectlist_key =>$subjectlist_value) {
                 $showSub='no'; 
            if (count($subject_chapters[$subjectlist_key]) > 0) {
            foreach($subjectArray_package[$subjectlist_value['id']] as $p_value){
         if($p_value->total_package>1){
             $showSub='yes';
             break;
         }
         }
        }
		$subimage_array=array();
		foreach($allsubject as $key=>$value){
			$subimage_array[$value->id]=$value->imagename;
		}
        ?>
		<?php
        //echo $showSub.'---'.$subjectlist_key;
             $bookclass_cnt= rand(0,3);
             if (count($subject_chapters[$subjectlist_key]) > 0 && $showSub=='yes') { ?>                         
        <div class="col-sm-3 col-md-3 serve-icons">
            <!--class="col-xs-6 col-md-3 col-sm-6 rcorners2"--> 
            	<div class="s-sub rcorners2">
                                    <?php echo "<a title='".$subjectlist_key."' href='" . base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', true). '/' . $selectedexam->id . '/' . url_title($subjectlist_key, '-',true) . '/' . $subjectlist_value['id']) . "'>"; 
									
									$imagepath=$subimage_array[$subjectlist_value['id']];
									
									if(isset($subimage_array[$subjectlist_value['id']])&&$subimage_array[$subjectlist_value['id']]!=''){
									$imagepath=$subimage_array[$subjectlist_value['id']];
									}else{
									$imagepath='assets/subject_image/gen-knowl.png';
									}									
									?>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                        <?php  
                        if(strlen($subjectlist_key)>40){
                        $subjectName=substr($subjectlist_key,0,40).'..';
                         }else{
                             $subjectName=$subjectlist_key;
                         }
if($selectedexam->id==32&&$subjectlist_value['id']==5){
$subjectName=str_replace("science","EVS","science");
}	 
//echo "<i class='fa fa-book fa-4x text-warning'></i>";
                             ?>                                     <img class="img-responsive" width="50px" height="30px" src="<?php echo base_url($imagepath);?>">
        
                            </div>  
                                        <div class="col-md-8 col-sm-8 col-xs-8">
										<?php  
										echo "<h4 class='text-primary' >{$subjectName} </h4>"; 
										?> 
                                        </div>
                                    <div class="col-md-12">
                                <div class="view_det_shop">
                                    <?php 
                                  
                        if(isset($subjectArray_package[$subjectlist_value['id']])){
                      
     foreach($subjectArray_package[$subjectlist_value['id']] as $pvalue){
         if($pvalue->total_package>1){
             $moduleName=str_replace('-',' ',$pvalue->module_type);
         ?>
             <i class="fa fa-check" aria-hidden="true"></i> Total <?php echo ucfirst($moduleName); ?>  : <span> <strong><?php echo $pvalue->total_package; ?>+</strong></span><br>
        <?php
             
         $obj_totalpack =$pvalue->total_package;
            if($moduleName=='solved papers'){
            //$outer_spcnt = intval($outer_spcnt) + intval($obj_totalpack); 
                 
            }
         }
     }
     
 }
   ?>
                                </div> 
                            </div>
                         
       <?php echo "</a>"; ?> 
        </div>
                        </div>
                               
             <?php }
             
                         } 
    } 
    /*Added two new subject solved paper and sample paper*/
      if($outer_spcnt>0){
                    $outer_spcnt=$outer_spcnt;
                 }else{
                    $outer_spcnt= $totalsolvedp; 
                 }  
?>  
</div> </div>
    
    <div class="container">
  	<div class="row col-list center-block">
	<?php 
	if(count($solvedp)>0){ ?>
		<div class="col-md-6 col-sm-4 col-lg-4  btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'solved-papers/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id); ?>"> <img class="img-responsive" src="<?php echo base_url('assets/images/free-solved-papers.png'); ?>" /></a>
			</div>
			</div>
	<?php } if(count($sp)>0){ ?>
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			   <a href="<?php echo base_url( 'sample-papers/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/free-sample-paper.png'); ?>" /></a>
			</div>
			</div>
				<?php } if(count($qb)  >0){ ?>
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'question-bank/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/free-questions-bank.png'); ?>" /></a>
			</div>
			</div>
				<?php } if(count($notes)>0){ ?>
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'notes/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/free-notes.png'); ?>" /></a>
			</div>
			</div>
				<?php } if(count($sm)>0){ ?>
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'study-packages/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/study-packages.png'); ?>" /></a>
			</div>
			</div>
				<?php } if(count($vid)>0){ ?>
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'videos/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/video.png'); ?>" /></a>
			</div>
			</div>
				<?php } if(count($ot)>0){ ?>
			<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'online-test/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/testseries.png'); ?>" /></a>
			</div>
			</div>
				<?php } if(count($ncert) >0){ ?>
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'ncert-solution/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/ncertsol.png'); ?>" /></a>
			</div>
			</div>
			
			<?php } ?>
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php //echo base_url("free-videos");
				 echo base_url("featured-videos"); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/freevideo.png'); ?>" /></a>
			</div>
			</div>
			
	</div>
	  <?php
if ($segment_chpterseven>0) { ?>
          <hr>
  	<div class="row col-list center-block">
                                          <?php 
if(isset($totalsp)&&$totalsp>0){
    ?>
		<div class="col-md-6 col-sm-6 col-lg-6 t1 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
				<span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
				<h2><a href="<?php echo base_url( 'sample-papers/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id); ?>" title="<?php echo $selectedexam->name ; ?>Sample Papers" class="black">Sample Papers <strong><?php echo $totalsp; ?>+</strong></span></a></h2>
			</div>			
		</div>
            
                        <?php } ?>
            <!-- solved paper-->
            
                                        <?php 
if(isset($outer_spcnt)&&$outer_spcnt>0){
    
    ?>     
		<div class="col-md-6 t2 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
				<span class="glyphicon glyphicon-book" aria-hidden="true"></span>
				        <h2> <a href="<?php echo base_url( 'solved-papers/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id); ?>" title="<?php echo $selectedexam->name ; ?>Solved Papers" class="black">Solved Papers <strong><?php echo $outer_spcnt; ?>+</strong></a>                           </h2>
			</div>
                        </div><?php } ?>
	</div> 
						<? } ?>
</div>               
    
            
       <div class="clearfix"></div>    
    <?php
    //<!--End Showing Subject -->
}
?><?php
if ($this->uri->segment(6) == '' && $this->uri->segment(4) != '') {
    $subjectid = $selectedsubject->id;
    $subjectname = $selectedsubject->name;
    //$chepter_array = $subject_chapters[$subjectname];
   // $availableChapters = $chepter_array['chapters'];
    if (isset($chapters_array) && count($chapters_array) > 0) {
        ?> 
        <!--Showing Chapters Start-->
                                <div class="col-md-12">
                                <!--<div class="col-md-6">-->
                                <div class="col-md-12 text-center bavl">
                                <h2>Select Chapter</h2>      
                                </div>
        <?php
        foreach ($chapters_array as $chapterlist_key => $chapterlist_value) {
		if ($chapterlist_value['count'] > 0) {
        $short_chptername = str_split($chapterlist_value['name'],59);
        ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="box_shadow">
		<a href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id . '/' . url_title($subjectname, '-', true) . '/' . $subjectid . '/' . url_title($chapterlist_value['name'], '-', true) . '/' . $chapterlist_key); ?>">
			<div class="offer offer1 offer-success col-item" style="height:110px;">
				<div class="shape">
					<div class="shape-text">
						<span class="glyphicon glyphicon glyphicon-th"></span>
						</div>
				</div>
				<div class="offer-content">
					<h3 class="vid_prod_hed prod_hed1">
						 <?php echo $short_chptername[0]; ?>
					</h3>
				</div>
			</div></a>
			</div>
		</div>
<?php								}
}
?></div>
		<!--End Showing Chapters-->
<?php
    }?>
	<!--Chpater Page Icon-->
	  
  	<div class="row col-list center-block">
	<?php if(count($solvedp)>0){ ?> 
		<div class="col-md-6 col-sm-4 col-lg-4  btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'solved-papers/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id.'/'.url_title($subjectname, '-', true).'/'.$subjectid); ?>"> <img class="img-responsive" src="<?php echo base_url('assets/images/free-solved-papers.png'); ?>" /></a>
			</div>
			</div>
	<?php } if(count($sp)>0){ ?> 
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			   <a href="<?php echo base_url( 'sample-papers/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id.'/'.url_title($subjectname, '-', true).'/'.$subjectid); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/free-sample-paper.png'); ?>" /></a>
			</div>
			</div>
	<?php } if(count($qb)>0){ ?> 
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'question-bank/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id.'/'.url_title($subjectname, '-', true).'/'.$subjectid); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/free-questions-bank.png'); ?>" /></a>
			</div>
			</div>
	<?php } if(count($notes)>0){ ?>
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'notes/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id.'/'.url_title($subjectname, '-', true).'/'.$subjectid); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/free-notes.png'); ?>" /></a>
			</div>
			</div>
	<?php } if(count($sm)>0){ ?>
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'study-packages/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id.'/'.url_title($subjectname, '-', true).'/'.$subjectid); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/study-packages.png'); ?>" /></a>
			</div>
			</div>
	<?php } if(count($vid)>0){ ?>
				
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'videos/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id.'/'.url_title($subjectname, '-', true).'/'.$subjectid); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/video.png'); ?>" /></a>
			</div>
			</div>
	<?php } if(count($ol)>0){ ?>
			<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'online-test/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id.'/'.url_title($subjectname, '-', true).'/'.$subjectid); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/testseries.png'); ?>" /></a>
			</div>
			</div>
			<?php } if((count($ncert)) >0){ ?>
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php echo base_url( 'ncert-solution/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id.'/'.url_title($subjectname, '-', true).'/'.$subjectid); ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/ncertsol.png'); ?>" /></a>
			</div>
			</div>
			<?php  } ?>
			
		<div class="col-md-6 col-sm-4 col-lg-4 btn-sm btn-xs btn-sm btn-md">
			<div class="col-head text-center">
			     <a href="<?php //echo base_url("free-videos");
echo base_url("featured-videos")

				 ?>"><img class="img-responsive" src="<?php echo base_url('assets/images/freevideo.png'); ?>" /></a>
			</div>
			</div>
			
			
	</div>
	  
          <hr>
	<!--Chapter Page Icon End-->
	
	<?php
}
?>
                    <div class="clearfix"></div>
                    </div>
					
				
				
				<?php 
if ($segment_chpterseven>0) {  ?>
 <!--Video content subject vise -->
                <div class="clearfix"></div>
				<div class="row">
                <?php if(isset($urlChapter_name)&&($urlChapter_name!=NULL)){
                   $videolist_cnt = count($videolist);

                   if($videolist_cnt>0){ 
                    ?><div class="col-md-12">
                <?php
                if(isset($videolist)){         
                ?>
				<div class="col-md-12 text-center"><h2><?php echo 'Videos for '.$urlChapter_name; ?></h2></div>
                <div class="clearfix"></div>
              <div class="row vid_list">
                    
                    <?php 
                    $cururi_segments = $this->uri->segment_array();
                    
                     $url_segments[]='videos';
                    if(isset($cururi_segments[2])){
                        $url_segments[]=$cururi_segments[2];
                    }else{
                        $url_segments[]='examname';
                    }
                    
                    if(isset($cururi_segments[4])){
                        $url_segments[]=$cururi_segments[4];
                    }else{
                        $url_segments[]='subname';
                    }
                    
                           if(isset($cururi_segments[6])){
                        $url_segments[]=$cururi_segments[6];
                    }else{
                        $url_segments[]='chapname';
                    }
                    $vcount=1; 
                    foreach($videolist as $video){
                    if(isset($cururi_segments[6])){
                        $chapter_segments=$cururi_segments[6].'-relationid-'.$v_relations_id;
                    }else{
                        $chapter_segments='vidtital'.'-relationid-'.$v_relations_id;
                    }
                    ?>
                  <div class="col-xs-12 col-sm-2 col-md-2">
        <div class="col-item offer offer-success" style="height:160px;"> 
            <a href="<?php echo base_url(implode('/', $url_segments).'/'.$chapter_segments.'/'. url_title($video->title,'-',true).'/'.$video->id)?>" <?php if(!$this->session->userdata('customer_id')){ echo 'onclick="return showmsg();return false;"';}?>  title="<?php echo $video->title?>">
                <?php if($video->video_source=='youtube'){ ?>
                <img class="img-responsive" src="https://i.ytimg.com/vi/<?php echo $video->video_url_code?>/mqdefault.jpg"/>
                <?php }else{ ?>
            <img class="img-responsive" src="<?php echo show_thumb($video->video_image,250,250);?>">
                <?php } ?>
                 <div class="separator btn_prod_ved">
<div class="separator btn_prod_ved"><button class="btn-md btn btn-raised btn-success" name="btnAlreadyExist">Watch Now</button></div>
            </div>  
             </a> 
        </div> 
    </div>
    <?php }  ?>
			
	</div>
	<?php
	$vcount++;
	}
	?>
	</div>
	<?php
    }
    }else{ 
                if ($examPlaylist) {
					?> <div class="col-md-12"><div class="col-md-12 text-center"><h2><?php  echo 'Available Videos'; ?></h2></div>
                <div class="clearfix"></div><?php
                    $count = 1;
                    foreach ($examPlaylist as $qb_plylist) {
                        if ($count == 9 && $this->uri->total_segments() == 1)
                            break;

                        if ($count > count($this->config->item('bgimages'))) {
                            $count = 1;
                        }
                        $index = $count - 1;
                        ?>
                <a class="lazy_recent_video" href="<?php echo generateContentLink('videos', $qb_plylist->exam, $qb_plylist->subject, $qb_plylist->chapter, $qb_plylist->name.'-relationid-'.$qb_plylist->v_relations_id, $qb_plylist->id); ?>">
                <!-- style="background-size: 100% 100%; background-repeat: no-repeat;background-image: url('/assets/frontend/images/<?php //echo $this->config->item('bgimages')[$count - 1] ?>');" -->
                    <div class="col-xs-6 col-sm-4 col-md-2">
                        <div class="col-item offer offer-success" style="height:140px;">                            
                            	<div class="shape">
					<div class="shape-text">
					<span class="glyphicon glyphicon  glyphicon-facetime-video"></span>		
					</div>
				</div>
                            <div>
                               
                                    <div class="offer-content"><h6 class="vid_prod_hed" title="<?php echo $qb_plylist->name; ?>"><?php echo $qb_plylist->name; ?></h6>       
                                    </div>
             
                                    <div class="separator btn_prod_ved">
<div class="price"><h5 class="chepter-text-color"><?php echo $this->Videos_model->getPlaylistVideosCount($qb_plylist->id); ?> Videos</h5></div>
                                    </div>
                                                            </div>
                        </div>
                    </div>
                </a>
                        <?php
                        $count++;
                    }
            
?></div>
<?php
}
}
?>
</div>
                <!--End Video content-->
          <div class="clearfix"></div>
<?php  
if (isset($productslist) && count($productslist) > 0) {
    ?><div class="row">
        <?php
                        //$this->load->view('common/productslistnew');
						
                        $this->load->view('common/exam_studypackage');
					
					} 
 $this->session->set_userdata('sub_purchases','no');
                    ?>
    </div>
 <div class="clearfix"></div>
 
 <!--Online Test for chapter page start-->
    <?php
	
	 if (isset($ot)&&count($ot)) {
                    ?>
                    <div class="col-sm-12 col-md-12">
                        <div class="col-md-12 text-center bavl"><h2><a href="<?php echo $question_bankUrl; ?>"> <?php  if(isset($urlChapter_name)&&($urlChapter_name!=NULL)){ 
                    echo 'Online Test of '.$urlChapter_name; 
                                    }else{
                    echo 'Recent Online Test';                  
                                    }
                                    ?></a><?php 
         if($qb_package>0){ 
            echo " <font size='3 px'>(";
            echo $qb_package." Online Test";
            
            if($qb_questions>1){
                echo " and ".$qb_questions." Online Test" ;
            }
            
            echo ")</font>"; } ?></h2></div>
                <div class="clearfix"></div> 
                    <?php
                    $this->load->view('common/exam_onlinetest');
                    ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                }
                ?>
 <!--Online Test for chapter page start-->
 
                    <?php
                if (isset($questionbanks)&&count($questionbanks)) {
                       $question_bankUrl=base_url('question-bank/'.$this->uri->segment(2).'/'.$this->uri->segment(3));
                    ?>
                    <div class="col-sm-12 col-md-12">
                        <div class="col-md-12 text-center bavl"><h2><a href="<?php echo $question_bankUrl; ?>"> <?php  if(isset($urlChapter_name)&&($urlChapter_name!=NULL)){ 
                    echo 'Question Banks of '.$urlChapter_name; 
                                    }else{
                    echo 'Recent Question Banks';                  
                                    }
                                    ?></a><?php 
         if($qb_package>0){ 
            echo " <font size='3 px'>(";
            echo $qb_package." Question Banks";
            
            if($qb_questions>1){
                echo " and ".$qb_questions." Questions" ;
            }
            
            echo ")</font>"; } ?></h2></div>
                <div class="clearfix"></div> 
                    <?php
                    $this->load->view('common/exam_questionbanklist');
                    ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                }
    ?> <!--NOTES for chapter page start--><?php
                if (isset($notes)&&count($notes)) {
                       $question_bankUrl=base_url('notes/'.$this->uri->segment(2).'/'.$this->uri->segment(3));
                    ?>
                    <div class="col-sm-12 col-md-12">
                        <div class="col-md-12 text-center bavl"><h2><a href="<?php echo $question_bankUrl; ?>">
                                    <?php  if(isset($urlChapter_name)&&($urlChapter_name!=NULL)){ echo 'Notes of '.$urlChapter_name; 
                                    }else{
                      echo 'Recent Notes';                
                                    }
                                    ?></a>
									<?php 
         if($notes_package>0){ 
            echo " <font size='3 px'>(";
           echo $notes_package." Notes";
            
            if($notes_questions>1){
                echo " and ".$notes_questions." Questions" ;
            }
            
            echo ")</font>"; } ?></h2></div>
                <div class="clearfix"></div> 
                    <?php
                    $this->load->view('common/exam_noteslist');
                    ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                }
                    ?>
          <?php } 
		  ?>  <!--NOTES for chapter page start-->     
                    <div class="row">  
<?php  


if ($segment_chpterseven>0) {
	
	 if (count($solvedp) > 0) { ?>
                            <div class="col-md-6 col-sm-6" style="float:left;">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class="col-sm-12 col-md-7"><?php echo $solpap_package; ?> Solved Papers</h4>
                                        <span class="col-md-5 text-right nopadding"> <?php if($solpap_questions!=''&&$solpap_questions>1){ ?>(<?php echo $solpap_questions; ?> Questions)<?php } ?></span> <div class="clearfix"></div> </div>
                                    <div class="panel-body">
                                        <ul>
                                            <?php $cc = 0;
                                            foreach ($solvedp as $spdata) { ?>
                                                <li>
                                                    <i class="material-icons icon_bullet">picture_as_pdf</i> <a  title="<?php echo $spdata->name; ?>" href="<?php echo generateContentLink('solved-papers', $spdata->exam, $spdata->subject, $spdata->chapter, $spdata->name, $spdata->id); ?>">
        <?php
        echo str_pad($spdata->name, strlen($spdata->name) + 1, " ", STR_PAD_LEFT);
        ;
        ?></a>
                                                </li>
                                <?php
                                $cc++;
                                //if($cc==10) break;                            
                            }
                            ?>
                                        </ul>
                                    </div>
                                    <div class="panel-footer"> 
                                      <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; <a title="Solved Papers" href="<?php echo base_url('solved-papers/' . $path) ?>">View All</a></div>
                                </div>
                            </div>
                                                <?php } 
												
												
												//NCERT Solutions
												if (count($ncert) > 0) { ?>
                            <div class=" col-sm-6 col-md-6">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h4 class="col-sm-12 col-md-7">Ncert Corner <?php if($ns_package!=''&&$ns_package>0){ ?> for <?php echo $ns_package; ?> Chapters<?php } ?></h4><span class="col-md-5 text-right nopadding"><?php if($ns_questions!=''&&$ns_questions>1){ ?> (<?php echo $ns_questions; ?> Questions)<?php } ?></span>
                                        <div class="clearfix"></div> </div>
                                    <div class="panel-body">
                                        <ul>
                            <?php $cc = 0;
                            foreach ($ncert as $list) { ?>
                                                <li>
                                                    <i class="material-icons icon_bullet">speaker_notes</i>  <a title="<?php echo $list->name ?>" href="<?php echo generateContentLink('ncert-solution', $list->exam, $list->subject, $list->chapter, $list->name, $list->id); ?>">
        <?php echo $list->name ?>
                                                    </a></li>
        <?php
        $cc++;
        //if($cc==10) break;                            
    }
    ?>                    
                                        </ul>
                                    </div>
                                    <div class="panel-footer"> 
                                        <i class="glyphicon glyphicon-eye-open"> </i> 
                                        &nbsp; 
                                        <a title="Ncert Solutions" href="<?php echo base_url('ncert-solution/' . $path) ?>">View All</a></div>
                                </div>
                            </div>
<?php }
	//NOTES
	 if (count($ar) > 0) { ?> 
                            <div class="col-md-6 col-sm-6">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="col-sm-12 col-md-7"><?php echo $notes_package; ?> Notes</h4>
                                         <span class="col-md-5 text-right nopadding"> <!--(<?php //echo $notes_questions;  ?> Questions--></span> <div class="clearfix"></div></div>
                                    <div class="panel-body">
                                        <ul>
    <?php $cc = 0;
    foreach ($ar as $list) { 
           
		   if(isset($list->chapter)&&($list->chapter!='')){
			   
			   $list_chapter=$list->chapter;
		   }else{
			   $list_chapter='allchapter';
		   }
		   if(isset($list->subject)&&($list->subject!='')){
			   
			   $list_subject=$list->subject;
		   }else{
			   $list_subject='allsubject';
		   }
		   
		   ?>                                     <li>
                                                    <i class="material-icons icon_bullet">speaker_notes</i>  <a title="<?php echo $list->title ?>" href="<?php echo generateContentLink('notes', $list->exam, $list->subject, $list_chapter, $list->title, $list->id); ?>">
                                <?php echo $list->title ?>
                                                    </a></li>
                                <?php
                                $cc++;
                                //if($cc==10) break;                            
                            }
                            ?>
</ul>
                                    </div>
                                    <div class="panel-footer"> 
                                     <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; 
                                        <a title="Notes" href="<?php echo base_url('notes/' . $path) ?>">View All</a></div>
                                </div>
                            </div>
                                        <?php } 
	
	
if (count($qb) > 0) { ?>
                           
                            <div class="col-md-6 col-sm-6">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h4 class="col-sm-12 col-md-7"><?php echo $qb_package; ?> Question Banks</h4>
                                        <span class="col-md-5 text-right nopadding"><?php if($qb_questions!=''&&$qb_questions>1){ ?>(<?php echo $qb_questions ?> Questions)<?php } ?></span> <div class="clearfix"></div> </div>
                                    <div class="panel-body">
                                        <ul>
    <?php $cc = 0;

    foreach ($qb as $qbdata) { 
	 ?>
                                                <li>
                                                    <i class="material-icons icon_bullet">question_answer</i> <a title="<?php echo $qbdata->name; ?>" href="<?php echo generateContentLink('question-bank', $qbdata->exam, $qbdata->subject, $qbdata->chapter, $qbdata->name, $qbdata->id); ?>">
        <?php
        echo $qbdata->name;
        ?> Question Bank</a>
                                                </li>
                                                        <?php
                                                        $cc++;
                                                        //if($cc==10) break;                            
                                                    }
                                                    ?>
                                        </ul>
                                    </div>
                                    <div class="panel-footer"> <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; <a title="Question Banks" href="<?php echo base_url('question-bank/' . $path) ?>">View All</a> </div>
                                </div>
                            </div>
<?php } 

 if ($ns_package > 0) { ?>  <!--Ncert Solutions -->   
                        <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
                            <div class="col-md-4 text-center">
                                   <p class="detail_product_img">  
                                <span class="glyphicon glyphicon-book glyphic_fontinfo text-success"></span></p>
                            </div>
                            <div class="col-md-8 section-box">
                                <h4>
                                    NCERT Solutions
                                </h4>
                                <div class="view_det_shop row">

    <?php if ($ns_package > 0) { ?>
                                        <i class="material-icons">check</i> Total NCERT Chapters : <span> <strong><?php echo $ns_package; ?>+</strong></span>
    <?php } if ($ns_questions > 1) { ?><br>
                                        <i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $ns_questions; ?></strong> </span>
    <?php } ?>

                                </div> 
                            </div>
                        </div>
<?php }
?>
                        <?php if (count($sp) > 0) { ?>
                            <div class="col-md-6 col-sm-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class="col-sm-12 col-md-7"><?php echo $sp_package; ?> Sample Papers</h4>
                                        <span class="col-md-5 text-right nopadding"><?php if($sp_questions!=''&&$sp_questions>1){ ?> (<?php echo $sp_questions ?> Questions)<?php } ?></span> <div class="clearfix"></div> </div>
                                    <div class="panel-body">
                                        <ul>
    <?php $cc = 0;
    foreach ($sp as $spdata) { ?>
                                                <li>
                                                    <i class="material-icons icon_bullet">picture_as_pdf</i> <a  title="<?php echo $spdata->name; ?>" href="<?php echo generateContentLink('sample-papers', $spdata->exam, $spdata->subject, $spdata->chapter, $spdata->name, $spdata->id); ?>">
                                                        <?php
                                                        echo str_pad($spdata->name, strlen($spdata->name) + 1, " ", STR_PAD_LEFT);
                                                        ;
                                                        ?></a>
                                                </li>
                                                        <?php
                                                        $cc++;
                                                        //if($cc==10) break;                            
                                                    }
                                                    ?>
                                        </ul>
                                    </div>
                                    <div class="panel-footer"> <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; <a title="Sample Papers" href="<?php echo base_url('sample-papers/' . $path) ?>">View All</a></div>
                                </div>
                            </div>
                        <?php } ?>  
                        <?php if (count($vid) > 0) { ?>
                            <div class=" col-sm-6 col-md-6">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h4 class="col-md-7 col-sm-12"><?php echo $video_package; ?> Video Lecture Series</h4>
                                        <span class="col-md-5 text-right nopadding"><?php if($videos_questions!=''&&$videos_questions>1){ ?>(<?php echo $videos_questions; ?> Videos<?php } ?>)</span> <div class="clearfix"></div> </div>
                                    <div class="panel-body">
                                        <ul>
                                            <?php $cc = 0;
                                            foreach ($vid as $playlist) { ?>
                                                <li>
                                                    <i class="material-icons icon_bullet">videocam</i>  <a title="<?php echo $playlist->name; ?>" href="<?php echo generateContentLink('videos', $playlist->exam, $playlist->subject, $playlist->chapter, $playlist->name . '-relationid-' . $playlist->v_relations_id, $playlist->id); ?>">
                                                <?php echo $playlist->name ?>
                                                    </a></li>
                                                <?php
                                                $cc++;
                                                //if($cc==10) break;                            
                                            }
                                            ?>

                                        </ul>
                                    </div>
                                    <div class="panel-footer"> <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; <a  title="Video" href="<?php echo base_url('videos/' . $path) ?>">View All</a></div>
                                </div>
                            </div>
<?php } ?>

<?php if (count($sm) > 0&&$stpac_package!='') { ?>
                            <div class="col-md-6 col-sm-6">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="col-sm-12 col-md-7"><?php echo $stpac_package; ?> Study Packages</h4>
                                        <span class="col-md-5 text-right nopadding"><?php //echo $stpac_questions.' Files' ?></span> <div class="clearfix"></div> </div>
                                    <div class="panel-body">
                                        <ul>
    <?php $cc = 0;
    foreach ($sm as $list) { ?>
                                                <li>
                                                    <i class="material-icons icon_bullet">import_contacts</i> <a title="<?php echo $list->name; ?>" href="<?php echo generate_stmt_ContentLink('study-packages', $list->exam, $list->subject, $list->chapter, $list->name, $list->id); ?>"><?php echo $list->name ?></a></li>
        <?php
        $cc++;
        //if($cc==10) break;                            
    }
    ?>

                                        </ul>
                                    </div>
                                    <div class="panel-footer"> 
                                        <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; 
                                        <a title="Study Packages" href="<?php echo base_url('study-packages/' . $path) ?>">View All</a></div>
                                </div>
                            </div>
                                        <?php } ?>

                                       
                    
					<?php } ?>
					
					
					</div>
                </div>
            <?php 
			//if ($this->uri->segment(6) == '' && $this->uri->segment(4) != '')
				//We do not show module counting on pages now. so $allpack_cnt array Passed to blank.
$allpack_cnt='no';
if($allpack_cnt=='yes'){
			if ($this->uri->segment(1) != '') {  ?> 
           <div class="row">
                        <?php if ($qb_package > 0) { ?>
                        <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
                            <div class="col-md-4 text-center">
                                  <p class="detail_product_img">  
                                <span class="glyphicon glyphicon-file text-success glyphic_fontinfo"></span></p>
                            </div>
                            <div class="col-md-8 section-box">
                                <h4>
                                    Question Bank
                                </h4>
                                <div class="view_det_shop row">

    <?php if ($qb_package > 0) { ?>
                                        <i class="material-icons">check</i> Total Question Banks  : <span> <strong><?php echo $qb_package; ?>+</strong></span>
    <?php } if ($qb_questions > 1) { ?><br>
                                        <i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $qb_questions; ?></strong> </span>
    <?php } ?>

                                </div> 
                            </div>
                        </div>

                                <?php } 
                                
                                if ($ot_package > 0) { ?>
                        <!--Online Test-->    
                        <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
                            <div class="col-md-4 text-center">
                                   <p class="detail_product_img">  
                                <span class="glyphicon glyphicon-hourglass text-success glyphic_fontinfo"></span></p>
                            </div>
                            <div class="col-md-8 section-box">
                                <h4>
                                    Online Test
                                </h4>
                                <div class="view_det_shop row">

    <?php if ($ot_package > 0) { ?>
                                        <i class="material-icons">check</i> Total Online Test: <span> <strong><?php echo $ot_package; ?>+</strong></span>
    <?php } if ($ot_questions > 1) { ?><br>
                                        <i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $ot_questions; ?></strong> </span>
    <?php } ?>

                                </div> 
                            </div>
                        </div>
                                <?php } 
                                
                                if ($sp_package > 0) { ?>
                        <!--Sample Papers-->    
                        <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
                            <div class="col-md-4 text-center">
                                 <p class="detail_product_img">  
                                <span class="glyphicon glyphicon-list-alt text-success glyphic_fontinfo"></span></p>
                            </div>
                            <div class="col-md-8 section-box">
                                <h4>
                                    Sample Papers
                                </h4>
                                <div class="view_det_shop row">

    <?php if ($sp_package > 0) { ?>
                                        <i class="material-icons">check</i> Total Sample Papers: <span> <strong><?php echo $sp_package; ?>+</strong></span>
    <?php } if ($sp_questions > 1) { ?><br>
                                        <i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $sp_questions; ?></strong> </span>
    <?php } ?>

                                </div> 
                            </div>
                        </div>
                                <?php }
                              ?><div class="clearfix"> </div><?php  
                                if ($stpac_package > 10) { ?>
                        <!-- Study Packages-->
                        <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
                            <div class="col-md-4 text-center">
                               <p class="detail_product_img">  
                                <span class="glyphicon glyphicon-folder-open glyphic_fontinfo text-danger"></span></p>
                            </div>
                            <div class="col-md-8 section-box">
                                <h4>
                                    Study Packages
                                </h4>
                                <div class="view_det_shop row">

    <?php if ($stpac_package > 10) { ?>
                                        <i class="material-icons">check</i> Total Study packages :<span> <strong><?php echo $stpac_package; ?>+</strong></span>
    <?php } if ($stpac_questions > 1) { ?><br>
                                        <!--<i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $stpac_questions; ?></strong> </span>-->
                                    <?php } ?>

                                </div> 
                            </div>
                        </div>  
                                <?php }  if ($notes_package > 0) { ?>

                        <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
                            <!-- Notes-->
                            <div class="col-md-4 text-center">
                                   <p class="detail_product_img">  
                                <span class="glyphicon glyphicon-info-sign glyphic_fontinfo text-danger"></span></p>
                            </div>
                            <div class="col-md-8 section-box">
                                <h4>
                                    Notes
                                </h4>
                                <div class="view_det_shop row">

    <?php if ($notes_package > 0) { ?>
                                        <i class="material-icons">check</i> Total Notes :<span> <strong><?php echo $notes_package; ?>+</strong></span>
    <?php } if ($notes_questions > 1) { ?><br>
                                        <!--<i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $stpac_questions; ?></strong> </span>-->
                                    <?php } ?>

                                </div> 
                            </div> <!--notes -->  
                        </div>
                       
<?php } ?>


                                <?php if ($video_package > 0) { ?>
                        <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
                            <!--  Video Lecture Series-->
                            <div class="col-md-4 text-center">
                                <p class="detail_product_img">  
                                <span class="glyphicon glyphicon-facetime-video glyphic_fontinfo text-danger"></span></p>
                            </div>
                            <div class="col-md-8 section-box">
                                <h4>
                                    Video Lecture Series
                                </h4>
                                <div class="view_det_shop row">

    <?php if ($video_package > 0) { ?>
                                        <i class="material-icons">check</i> Total Lecture Series : <span> <strong><?php echo $video_package; ?>+</strong></span>
    <?php } if ($videos_questions > 1) { ?><br>
                                        <i class="material-icons">check</i> Total Videos : <span> <strong><?php echo $videos_questions; ?></strong> </span>
                                    <?php } ?>

                                </div> 
                            </div>
                        </div>
                                <?php } ?><div class="clearfix"> </div>

                                <?php  if ($solpap_package > 0) { ?>
                        <!--Solved Papers-->    
                        <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
                            <div class="col-md-4 text-center">
                                <p class="detail_product_img">  
                                <span class="glyphicon glyphicon-edit glyphic_fontinfo text-success"></span></p>
                            </div>
                            <div class="col-md-8 section-box">
                                <h4>
                                    Solved Papers
                                </h4>
                                <div class="view_det_shop row">

    <?php if ($solpap_package > 0) { ?>
                                        <i class="material-icons">check</i> Total Solved Papers: <span> <strong><?php echo $solpap_package; ?>+</strong></span>
    <?php } if ($solpap_questions > 1) { ?><br>
                                        <i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $solpap_questions; ?></strong> </span>
    <?php } ?>

                                </div> 
                            </div>
                        </div>
                                <?php } ?>
                        
                </div>
<?php  } } ?>           
		   </div>
            <!-- /. PAGE INNER  -->
        </div>
    </div>
</div>
