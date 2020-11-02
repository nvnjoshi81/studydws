<div id="wrapper">
    <div class="container">
            <div class="row">
                <?php $this->load->view('common/breadcrumb');?>
                    <?php 
					$sliderShow='no';
					if($sliderShow=='yes'){
					//echo $this->load->view('common/productslist');?>
                 <div class="col-lg-12">
                <div id="example5" class="slider-pro">
		<div class="sp-slides">
                     <?php if(isset($videolist)&&count($videolist)>0){ foreach($videolist as $video){ ?>
			<div class="sp-slide">
                            <?php if($this->session->userdata('customer_id')){ ?>
                            <a onclick="window.location.href='<?php echo base_url(implode('/', $url_segments).'/'.url_title($video->title,'-',true).'/'.$video->id)?>';" title="<?php echo $video->title?>'" href="<?php echo base_url(implode('/', $url_segments).'/'.url_title($video->title,'-',true).'/'.$video->id)?>" title="<?php echo $video->title?>">
                            <?php }else{ ?>
                                <a href="<?php echo base_url('login');?>" onclick="return showmsg();return false;">        
                            <?php } ?>
                                    <?php if($video->video_source=='youtube'){ ?> 
                                    <img class="sp-image" src="https://i.ytimg.com/vi/<?php echo $video->video_url_code?>/mqdefault.jpg"
					data-src="https://i.ytimg.com/vi/<?php echo $video->video_url_code?>/mqdefault.jpg"
					data-retina="https://i.ytimg.com/vi/<?php echo $video->video_url_code?>/mqdefault.jpg"/>
                                    <?php }else{ ?>
                                        <img title="<?php echo $video->video_image; ?>" class="sp-image" src="<?php echo show_thumb($video->video_image,845,405);?>"
					data-src="<?php echo show_thumb($video->video_image,845,405);?>"
					data-retina="<?php echo show_thumb($video->video_image,845,405);?>"/>
                                    <?php } ?>    
                                </a>
			</div>
                     <?php } }else{
                         ?><div class="sp-slide">No Video Found</div><?php
                     } ?>    
	        
		</div>

		<div class="sp-thumbnails">
                    
                    <?php if(isset($videolist)){ foreach($videolist as $video){ ?>
			<div class="sp-thumbnail">
				<div class="sp-thumbnail-image-container">
                                    <?php if($video->video_source=='youtube'){ ?>
                <img title="<?php echo $video->video_image; ?>" class="img-responsive" src="https://i.ytimg.com/vi/<?php echo $video->video_url_code?>/mqdefault.jpg"/>
                <?php }else{ 
				
				if($video->video_image==''){
					$emVidImg=$video->video_image;
				}else{
					$emVidImg='image_'.$video->id.'.jpg';
				}
				
				?>
					<img title="<?php echo $emVidImg; ?>" class="sp-thumbnail-image img-responsive" src="<?php echo show_thumb($emVidImg,250,250);?>"/>
                                        <?php } ?>
				</div>
				<div class="sp-thumbnail-text">
					<div class="sp-thumbnail-title"><?php echo $video->title?></div>
                                        <div class="sp-thumbnail-description"><p>&nbsp;</p></div>
				</div>
			</div>
                    <?php } } ?>
			
		</div>
    </div>
            </div>
              <? }
			  ?>    
            </div>
               
                  <!-- video gallery -->
    <div class="row vedio_bot_gal">
    <div class="col-lg-12 col-sm-12 col-md-12">
    <div class="row vid_list">
    <?php if($videolist){ foreach($videolist as $video){
if($video->video_source=='youtube'){ ?>
<!---YOUTUBE VIDEO START-->
    <div class="col-lg-3 col-xs-12 col-sm-3 col-md-3">
        <div class="pic wel_vid"> 
            <a href="<?php echo base_url(implode('/', $url_segments).'/'.  url_title($video->title,'-',true).'/'.$video->id)?>" <?php if(!$this->session->userdata('customer_id')){ echo 'onclick="return showmsg();return false;"';}?>  title="<?php echo $video->title?>" >
			    <img title="<?php echo $video->video_image; ?>" class="img-responsive" src="https://i.ytimg.com/vi/<?php echo $video->video_url_code?>/mqdefault.jpg"/>
                <?php  ?>
            <p class="pic-caption bottom-to-top"> 
            <?php echo $video->title; ?> <br> <i class="material-icons">play_arrow</i></p> 
             </a>
             <h5 class="vid_prod_hed"><?php echo $video->title?></h5>
        </div> 
    </div>
		<!--YOUTUBE VIDEO ENDS-->
    <?php }else{
	?>
 <!-- STUDYADDA VIDEO START  -->

 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-center">
  <a href="<?php echo base_url(implode('/', $url_segments).'/'.  url_title($video->title,'-',true).'/'.$video->id)?>" <?php if(!$this->session->userdata('customer_id')){ echo 'onclick="return showmsg();return false;"';}?>  title="<?php echo $video->title?>">

 <div class="video_thumb">
 <?php
 $singletinfo=$teacherInfo[$video->id];
 
 $singletinfo[0]->gender;
$tsuffix='';
if($singletinfo[0]->gender=="Male") {
	$tsuffix="Sir";
}
else if($singletinfo[0]->gender=="Female") {
	$tsuffix="Madam";
}


 $videoId[$video->id]; 
 //print_r($videoId[$video->id]);
 
 $singlevinfo = $videoId[$video->id];
 
 $title=$singlevinfo->title;
 $subject=$singlevinfo->subject;
 $chapter=$singlevinfo->chapter;
 $exam=$singlevinfo->exam;
 $taughtby=$singletinfo[0]->firstname." ".$singletinfo[0]->lastname." ".$tsuffix;
 $video_duration=$singlevinfo->video_duration;
 $video_size=$singlevinfo->video_size;
 
 ?>  

 <p><h2><b><span class="title"><?php echo $video->title; ?></span></b></h2></p>

   <p>
	<h2><b><?php echo "<span class='multicolortextsub sub'>".$subject."</span>"; ?>
   </b></h2>
   </p>
   
   <p>
   <h4><b><?php echo "<span class='multicolortextexam exam'>".$exam; ?>
   <?php 
   if($taughtby!="") {
	   echo "| <span class='multicolortextexam exam'>".ucwords($taughtby).''; 
   }
   else {
	   echo "<span class='multicolortextexam exam'></span>"; 
   }
	?></span>
   </b></h4>
   </p>
<h5  title="Duration and Size" >  
<?php

if(isset($video->video_duration)&&$video->video_duration!=''){
	$init = $video->video_duration;
$hours = floor($init / 3600);
$minutes = floor(($init / 60) % 60);
$seconds = $init % 60;
				?><i title="Video Duration" class="glyphicon glyphicon-hourglass">
                  </i>
			<font title="Video Duration" style="font-family:'Courier New';font-size:'initial'"><?php 

if($init>120){ 
echo gmdate("i:s", $video->video_duration); echo " Hours";	
				
			}else if($init<121){	
			
if($init<60){ 
				echo "$init Minutes";	
				}else{
				
echo gmdate("i:s", $video->video_duration); echo " Minutes";		
				}			
				
			}
			
//echo "$minutes:$seconds";
 ?></font><?php 
			}else if(isset($video->custom_video_duration)&&$video->custom_video_duration!=''){
				
$init = $video->custom_video_duration;
$hours = floor($init / 3600);
$minutes = floor(($init / 60) % 60);
$seconds = $init % 60;
if(isset($init)&&$init!=''){
				?>
			<font title="Video Duration" style="font-family:'Courier New'; font-size:'initial'"><i  title="Video Duration" class="glyphicon glyphicon-hourglass">
                  </i> <?php 
			//$hours
           if($init>121){ 
echo gmdate("i:s", $init); echo " Minutes";	
				
			}else if($init<122){	
			
if($init<60){ 
				echo "$init Minutes";	
				}else{
				
echo gmdate("i:s", $init); echo " Minutes";		
				}			
				
			}
			//echo  gmdate("H:i:s", $video->custom_video_duration); ?></font>
			<?php
			}
			}
			if(isset($video->video_size)&&$video->video_size!=''){
			?>
			<font title="Video Size" style="font-family:'Courier New'"> | <i title="Video Size" class="glyphicon glyphicon-scale"></i> <?php echo $video->video_size; ?></font><?php 
			}
?></h5>
<!--<div class="centered">Centered</div>-->
</div>
   
   <p class="pic-caption bottom-to-top">
            <?php echo $video->title; ?> <br> <i class="material-icons vdoplay">play_arrow</i></p> 
             </a>
             <h5 class="vid_prod_hed"><?php //echo $video->title?></h5>
			 
</div>          <!-- // video description -->
<?php 
	}
	} 
    }	
?>
 </div>
        <div class="row recentvideo">
                <?php 
      if((count($freevideos)>0)&&($freevideos !='')){
          ?>
      <div class="col-lg-12">
            <div class="col-md-9">
                <h3>
                    Watch Our Free Videos
                </h3>
            </div>
            <div class="col-sm-12 col-md-3">
                <!-- Controls -->
                <div class="controls pull-right ">
                    <a class="left fa fa-chevron-left btn btn-success" href="#carousel-example"
                        data-slide="prev"></a><a class="right fa fa-chevron-right btn btn-success" href="#carousel-example"
                            data-slide="next"></a>
                </div>
            </div>
        </div>
      <?php  } ?>
            
<div id="carousel-example" class="col-lg-12 carousel slide product_slide_panel" data-ride="carousel">
   <!-- Controls -->
   
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
      <div class="row">
      <?php 
      if((count($freevideos)>0)&&($freevideos !='')){
      $count=0; $all=1;foreach($freevideos as $product){ ?>
        
          <div class="col-sm-6 col-md-3 vid_hom_recent">
            <div class="col-item">
              <div class="photo">
                  <img src="https://i.ytimg.com/vi/<?php echo $product['source']?>/mqdefault.jpg"/>
                  
              </div>
              <div class="info">
                <div class="row">
                  <div class="price col-md-12">
                    <h5 class="vid_prod_hed"><?php echo $product['title']; ?></h5>
                    <h5 class="price-text-color"></h5>
                  </div>
                  <!--<div class="rating hidden-sm col-md-6"> <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star"> </i><i class="price-text-color fa fa-star"> </i><i class="price-text-color fa fa-star"> </i><i class="fa fa-star"></i> </div>-->
                </div>
                <div class="separator btn_prod_ved">
                    <?php
                     if($url_segments[5]!=''){
          $chaptername =  $url_segments[5];
          
         $var_relationid_array = explode('relationid-',$chaptername);
        
          if(isset($var_relationid_array[1])){
         $var_relationid=$var_relationid_array[1];
        }else{
            $var_relationid='';
        }
        }
        
        if($var_relationid>0){
            $playlist_url=url_title($product['playlist'].'-relationid-'.$var_relationid,'-',true);
        }else{
            $playlist_url=url_title($product['playlist'],'-',true);
        }
                    ?>
                   <a href="<?php echo base_url('videos/'.url_title($product['exam'],'-',true).'/'.url_title($product['subject']?$product['subject']:'all','-',true).'/'.url_title($product['chapter']?$product['chapter']:'all','-',true).'/'.$playlist_url.'/'.url_title($product['title'],'-',true).'/'.$product['id'])?>" class="btn btn-raised btn-warning ">Watch Now</a>
                </div>
                  
                <div class="clearfix"> </div>
              </div>
            </div>
          </div>
         <?php $count++ ;$all++;
		 if($count==4 && count($freevideos)>$all){
		 	echo '</div></div><div class="item"><div class="row">';
			$count=0;
		 }
		 } 
                 } ?>
         </div>
         </div>
      
    </div>
  </div>
 </div>
    </div>
    
    <!-- right panel -->
    <!--<div class="col-sm-12 col-md-3 rht260adv">
    <img src="<?php //echo base_url('assets/images/260adv.jpg')?>" />
  </div>-->
</div>
 
    </div>
    
    </div>