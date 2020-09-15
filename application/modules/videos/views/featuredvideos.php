<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php //$this->load->view('common/breadcrumb'); ?><br>
        </div>

        <!-- video gallery -->
           
            <div class="row vedio_bot_gal">
                <div class="col-sm-12 col-md-12" >
                    <?php if ($videos) { ?><div class="row vid_list"> 
                    <?php
                    $free_video_arr=array();
                    $video_content_array= array();
                    foreach ($videos as $key => $video) { 
                    $video_content_array['exam']=$video->exam;   
                    $video_content_array['exam_id']=$video->exam_id; 
$video_content_array['subject']=$video->subject;
$video_content_array['subject_id']=$video->subject_id;
                    
$video_content_array['chapter']=$video->chapter;
                    
$video_content_array['title']=$video->title;
                    
$video_content_array['id']=$video->id;
                    
$video_content_array['name']=$video->name;
                    
$video_content_array['video_url_code']=$video->video_url_code;
                    $free_video_arr[$video_content_array['exam']][]=$video_content_array; 
					
                    $free_video_subject[$video_content_array['exam_id']][$video_content_array['subject_id']]=$video_content_array['subject']; 
                              $video_exam_arr[$video->exam_id]=$video->exam; 
                    
                    }
                    ?>
                           <div class="col-lg-12 text-center" align="center"> 
                            <?php
                            foreach($video_exam_arr as $video_exam_id =>$video_exam_name){ 
							

						   if(isset($tempCont)&&$tempCont=='subject'){  
						  ?>
						  <a href="<?php echo base_url('featured-videos'); ?>" ><!--feat_vid_box-->
							
                                <button  class="btn-success"><center>All Free Videos</center></button></a>
						  <?php
						  }else{
							?>
							<a onclick="showhide_featured('<?php echo $video_exam_id; ?>');" title="<?php echo $video_exam_name; ?>" href="#"><!--feat_vid_box-->
							
                                <button  class="btn-success"><center><?php echo $video_exam_name ; ?></center></button></a>
						  <?php }
						  } ?>
          </div>
            <br />
            <div class="vidblock"><?php
            $vidcnt=0;
                    foreach($free_video_arr as $classKey => $classValue){
                        if($vidcnt==0){
                            $vidprop='block';
                        }else{
                            $vidprop='none';
                        }
                        ?>
            <div id="btn_<?php echo $classValue[0]['exam_id']; ?>" style="display:<?php echo $vidprop; ?>;">
			
			<div class="clearfix"></div>
                           <div class="col-lg-12 col-md-12 text-center" align="center"  style="padding-top: 15px;">
						   <?php 
						   
						   $frVid_subject=$free_video_subject[$classValue[0]['exam_id']];
						   foreach($frVid_subject as $frsubKey=>$frSub){
						   
						   if(isset($tempCont)&&$tempCont=='subject'){ 
			$showSubname='yes';
			}else{ if($frsubKey>0){
			?>
						   <a href="<?php echo base_url('featured-videos-sub/'.$classValue[0]['exam_id'].'/'.$frsubKey);?>" class=""><!--feat_vid_box-->
                                <button  class="btn-warning"><center><?php echo $frSub ; ?></center></button></a><?php
			$showSubname='no'; }
			}
						   ?>
							<?php 
						   } 
						   
						   ?>
								</div>
			<div class="clearfix" ></div>
					
                    <div class="heading-bar" >
                        <h2><a title="<?php echo $classKey ; ?> Video Lectures" href="<?php echo base_url('videos/' . url_title($classKey, '-', true).'/'.$classValue[0]['exam_id']); ?>" target="_blank"><?php echo $classKey ; if($showSubname=='yes'){ echo ' '.$frSub;} ?></a>
                            </h2>
                    </div>
                        <?php
                        foreach($classValue  as $videoKey => $video){
                        if(isset($video['name'])){
        $namevideo = url_title($video['name'] ? $video['name'] : 'all', '-', true);               
                        }else{
        $namevideo='';                    
                        }
                        ?>
                   <div class="col-xs-12 col-sm-6 col-md-4 ">
                                        <div class="pic wel_vid"> 
                                            <a href="<?php echo base_url('videos/' . url_title($video['exam'], '-', true) . '/' . url_title($video['subject'] ? $video['subject'] : 'all', '-', true) . '/' . url_title($video['chapter']? $video['chapter'] : 'all', '-', true) . '/' . $namevideo . '/' . url_title($video['title'], '-', true) . '/' . $video['id']) ?>" <?php if (!$this->session->userdata('customer_id')) {
                    echo 'onclick="return showmsg();return false;"';
                } ?> title="<?php echo $video['title'] ?>">
                                        <img class="img-responsive" src="https://i.ytimg.com/vi/<?php echo $video['video_url_code'] ?>/mqdefault.jpg"/>
                                                <p class="pic-caption bottom-to-top"> 
                <?php echo $video['title'] ?> <br> <i class="material-icons">play_arrow</i></p> 
                                            </a>
                                            <h5 class="vid_prod_hed"><?php echo $video['title'];  ?></h5>
                                        </div> 
                            </div>
                  <?php
                        }
                        ?>
            </div>  
            <div class="clearfix"></div>
                        
                        <?php $vidcnt++;
                    }
                    
           ?>
            </div></div><?php 
    } ?>
                </div>
                <!-- right panel -->
                
            </div>
        

    </div>

</div>
<script>
function showhide_subject(exid,sbid) { exit();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("subject_result").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "videos/welcome/featuredSubject", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("exid="+sbid+"&sbid="+sbid);
}
</script>