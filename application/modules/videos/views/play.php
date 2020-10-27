	<style>
body{width:610;}
.demo-table {width: 100%;border-spacing: initial;margin: 20px 0px;word-break: break-word;table-layout: auto;line-height:1.8em;color:#333;}
.demo-table th {background: #81CBFD;padding: 5px;text-align: left;color:#FFF;}
.demo-table td {border-bottom: #f0f0f0 1px solid;background-color: #ffffff;padding: 5px;}
.demo-table td div.feed_title{text-decoration: none;color:#40CD22;font-weight:bold;}
.demo-table ul{margin:0;padding:0;}
.demo-table li{cursor:pointer;list-style-type: none;display: inline-block;color: #F0F0F0;text-shadow: 0 0 1px #666666;font-size:20px;}
.demo-table .highlight, .demo-table .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
.btn-likes {float:left; padding: 0px 5px;cursor:pointer;}
.btn-likes input[type="button"]{width:20px;height:20px;border:0;cursor:pointer;}
.like {background:url('<?php echo base_url('assets/images/'.'like.png')?>')}
.unlike {background:url('<?php echo base_url('assets/images/'.'unlike.png')?>')}
.label-likes {font-size:12px;color:#2F529B;height:20px;}
.desc {clear:both;color:#999;}

</style>
<div id="wrapper">
    <div class="container">
            <div class="row">
                <?php $this->load->view('common/breadcrumb');?>
                <div class="lftgalpenal col-xs-12 col-sm-9 col-md-9 col-lg-9">   
                    <?php 
                    $ua=getBrowser();
if(isset($ua['name'])){
$yourbrowser =  $ua['name'];
}else{ 
  $yourbrowser='NA' ; 
}


if($is_amazonvideo==true||$is_androidvideo==true){
    if(!$purchased){
			?><h3>This video is not free.<br>You need to purchase in order to view</h3><?php
		}else{
			
	if(($is_androidvideo==true)){
		if(isset($androidapp_link)&&$androidapp_link!=''){
	$remoteFile="https://www.studyadda.com/upload_files/".$androidapp_link;
}
// Remote file url
$handle = @fopen($remoteFile, 'r');
		if(!$handle){
			$andlink_exist='no';
		}else{
			
			$andlink_exist='yes';
		}	
	}		
			
			
if(($androidapp_link!=''&&$andlink_exist=='yes')){
			
?>
<video style="height: auto; width: 100%; max-width: 100%;" controls controlsList="nodownload" id="lockdown_sol">
  <source src="<?php echo base_url('upload_files/'.$androidapp_link) ;?>" type="video/mp4">
  <source src="movie.ogg" type="video/ogg">
Your browser does not support the video tag.
</video>


   <div class="col-sm-12 col-md-12">
   <div><h4><font style="font-family:'Courier New';font-size:'initial'"><?php echo $video->title.' | '; ?><?php echo $video->name.' | '; ?><?php echo $video->chapter.' | '; ?><?php echo $video->subject.' | '; ?><?php echo $video->exam; ?></font>
   
   </h4>
   <h5>  
<?php

if(isset($video->video_duration)&&$video->video_duration!=''){
	$init = $video->video_duration;
$hours = floor($init / 3600);
$minutes = floor(($init / 60) % 60);
$seconds = $init % 60;
				?>
			<font style="font-family:'Courier New';font-size:'initial'"><i title="Video Duration" class="glyphicon glyphicon-hourglass">
                  </i><?php 

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
				?>
			<font style="font-family:'Courier New'; font-size:'initial'"><i title="Video Duration" class="glyphicon glyphicon-hourglass">
                  </i><?php 
			//$hours
           if($init>120){ 
echo gmdate("i:s", $video->video_duration); echo " Hours";	
				
			}else if($init<121){	
			
if($init<60){ 
				echo "$init Minutes";	
				}else{
				
echo gmdate("i:s", $video->video_duration); echo " Minutes";		
				}			
				
			}
			//echo  gmdate("H:i:s", $video->custom_video_duration); ?></font>
			<?php
			}
			if(isset($video->video_size)&&$video->video_size!=''){
			?>
			<font style="font-family:'Courier New'"> | <i title="Video Size" class="glyphicon glyphicon-scale"></i> <?php echo $video->video_size; ?></font><?php 
			}
?></h5>
   </div>
</div>
<?php
}else if($resourceKey!=''&&$streamHostUrl!=''){
	//echo $yourbrowser.'=--------'; die;
	if($yourbrowser !='Mozilla Firefox'){
			echo "<div class='alert alert-warning'>
  <strong>Warning!</strong> Video Could not be played.<p> Please Use Mozilla Firefox . 
Your browser does not support the video tag.";

if($androidapp_link==''){
			echo "Error Code - DB_ENT_NOT_EX";
			}else if($andlink_exist='no'){
			echo "Error Code - FILE_ENT_NOT_EX";	
			}else{
			echo "Error Code - ENTRYEXIST_MOZILLAFIX";	
			}

"</p></div>"; ?>
		  <div>
		<!--
                        <img width="800px" height="430px" src="<?php //echo base_url('/assets/images/mozilla_message.png')?>" class="img-responsive">
		-->
                    </div>
		<?php
	}else{
		?>
    <div id="videoplayer_frm">
                        <div class="vid_txt"><h3>This video is not free.<br>You need to purchase in order to view</h3></div>
			<?php echo !$purchased?'<img src="'.$preview_image.'"/>':''?>
                        </div>
		<?php
	}
}else{
	?>
	<div class='alert alert-warning'>
  <strong>Warning!</strong>
   Error Code - ENTRYFAILUAR!</div>
	<?php
}
}
?>
<?php }elseif($is_youtubevideo){ ?>
                <div id="ytplayer" style="height: 510px; width: 100%; max-width: 100%;" ></div>
                    <?php } ?>
                       <?php if($yourbrowser =='Mozilla Firefox'){ ?> 
                <div><a title="Problem In Video Display?" href="#" data-toggle="modal" data-target="#messageFlash"><i class="material-icons"></i>Problem In Video Display?</a></div>
                       <?php } ?>
                
   <div class="col-sm-12 col-md-12">
  <?php $customer_id=$this->session->userdata('customer_id');
	$count=abs($tutorial["likes"]);
	
if(isset($customer_id)&&$customer_id>0){
	?>
	<div class="likesection">
	<table class="demo-table">
<tr>
<td valign="top">
<div id="tutorial-<?php echo $tutorial["id"]; ?>">
<input type="hidden" id="likes-<?php echo $tutorial["id"]; ?>" value="<?php echo $count; ?>">
<?php
$str_like = "like";
if(!empty($count)) {
$str_like = "unlike";
}
$modtype=2;
?>
<div class="btn-likes"><input type="button" title="<?php echo ucwords($str_like); ?>" class="<?php echo $str_like; ?>" onClick="addLikes('<?php echo $tutorial["id"]; ?>','<?php echo $str_like; ?>','<?php echo $customer_id; ?>','<?php echo $modtype; ?>')" />
</div>
<div class="label-likes">
<span align="center"><?php if(!empty($count)) { echo $count . " Like(s)"; } ?>&nbsp;<font style="text-align: center; font-size:22px; margin-left:400px">Comments</font></span>
</div>
<div class="col-xs-12 col-md-12 col-lg-12">
<?php 
if(isset($video->id)&&$video->id>0)
{
	$post_id=$video->id;
}else{
	$post_id=0;
}
if(isset($commentlist)&&count($commentlist)>0){
	
	$cmnt_css='col-xs-6 col-md-6 col-lg-6';
}else{
	$cmnt_css='col-xs-12 col-md-12 col-lg-12';
}
?>
<div class="container <?php echo $cmnt_css; ?>">
   <form method="POST" id="comment_form" action="<?php echo base_url('videos/welcome/commentsave');?>">
    <div class="form-group" style="border: 2px solid green; padding: 10px; border-bottom-right-radius: 25px;">
     <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Write Comments About The Video..." rows="3" required></textarea>
    </div>
    <div class="form-group">
     <input type="hidden" name="post_type" id="post_type" value="2" />
     <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
     <input type="submit" name="submit" id="submit" class="subjectbtn btn btn-primary btn-raised btn-lg"
	 value="Submit" />
    </div>
   </form>
   <span id="comment_message"></span>
   <br />
   <div id="display_comment"></div>
  </div><!--Start Comment section -->   
<?php
if(isset($commentlist)&&count($commentlist)>0){ ?>
   <div class="panel-group col-xs-6 col-md-6 col-lg-6 " id="faqAccordion">
        <div class="panel panel-default"><h3 class="videohed"><i class="material-icons">video_library</i>
                        Comment for <?php echo $video->title; ?> video</h3>
	 <?php  
foreach($commentlist as $vc){ ?>
            <div class="panel-heading accordion-toggle question-toggle" data-toggle="collapse" data-parent="#faqAccordion" data-target="#question0" aria-expanded="true"> 
            <h4 class="panel-title">
                    <a href="#" class="ing">By <?php echo $vc->com_name ; ?></a><span><?php if(isset($vc->date)){ 
					echo ' on '.date("F j, Y, g:i a",$vc->date); 
					} ?></span>
              </h4>
            </div>
            <div id="question0" class="panel-collapse collapse in" style="" aria-expanded="true">
                <div class="panel-body">
                    <p><?php if($vc->status=='0'){ echo $vc->com_dis; }else{ echo 'Your Comment will be displayed after moderation!'; }  ?></p>
                </div> 
            </div>
<?php } ?>
        </div>
    </div>
  <?php 
} 
} 
?></div>
</div>
</td>
</tr>
</table>
	</div>
      

</div>
<!--more video-->
<?php //$this->load->view('common/videoprdlist'); ?>
        
    <div class="row vid_list">
    <?php if(count($mproducts)&&(!$purchased)){ 
        ?>
        <h3>This video series is available in following courses</h3>
        <?php
        foreach($mproducts as $key=>$product){ 
        if($product){ ?> 
        
        <div class="col-xs-12 col-sm-6 col-md-4" style="padding-bottom: 10px">
     <div class="col-item">
         <div class="photo">
              <?php if($product->type==1 && $product->item_id > 0){ ?>
                  <img src="<?php echo base_url('upload/webreader/'.$product->filename.'/docs/'.$product->filename.'.pdf_1_thumb.jpg')?>" class="img-responsive"/>
                  <?php }else{ 
                      echo getProductImage($product->image);
                      ?>
                  <?php } ?>
         </div>
                    <div class="info">
                    <div class="row">
                        <div class="price col-xs-12 col-md-12">
                            <h5 class="vid_prod_hed"><?php echo $product->modules_item_name; ?></h5>
                            <h5 class="price-text-color">&nbsp; <?php if($product->discounted_price > 0){ ?>
                            <i class="fa fa-inr"> </i>  
                            <del class="del_txt"> <?php echo $product->price?></del> 
                            <?php echo $product->discounted_price;
                            }else{
                                echo $product->price;
                            }
                            ?> 
                            </h5>
                        </div>
                    <!--<div class="rating hidden-sm col-md-6"> <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star"> </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star"> </i><i class="fa fa-star"></i> </div>-->
                        
                    </div>
                    <div class="separator btn_prod_ved">
                       <?php if (!$this->session->userdata('purchases') || !in_array_r($product->id, $this->session->userdata('purchases'))) { 
                        ?>
                        <a href="<?php echo getProductLink($product);?>" class="btn-md btn-sm btn-xs btn btn-raised btn-warning">Buy Now</a>
                       <?php   
                       }else{ ?>
                        <a class="btn-md btn-sm btn-xs btn btn-raised btn-success">You have already bought this course</a>                        
                       <?php } ?>                      
                        
                        <!--
                        <button itemname="<?php //echo $product->modules_item_name; ?>" 
                        type="<?php //echo $product->type ?>" 
                        itemprice="<?php //echo $product->discounted_price > 0 ? $product->discounted_price : $product->price ?>" 
                        itemid="<?php //echo $product->id ?>"
                        itemqty="1"
                        offline='0'
                        action_type="1"
                        class="btn-md btn btn-raised btn-warning addtocart"
                        name="btnAddToCart">Buy Online</button>
						-->
                        
                        
                    </div>
                    <div class="clearfix"> </div>
                    </div>
                </div>
     </div> 
    <?php } } } 
	
?>
	
    </div>

<!--recentvideo videos-->
  <div class="row recentvideo">
            
            <?php  
            if((count($freevideos)>0)&&($freevideos !='')){ ?>
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
            <?php  
            } 
            //Display studypackages product.
            //$this->load->view('common/productslistnew');
            ?>
            
  <!-- product slide -->
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
                  <!--<div class="rating hidden-sm col-md-6"> <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star"> </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star"> </i><i class="fa fa-star"></i> </div>-->
                </div>
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
                <div class="separator btn_prod_ved">
                        <a href="<?php echo base_url('videos/'.url_title($product['exam'],'-',true).'/'.url_title($product['subject']!=''?$product['subject']:'all','-',true).'/'.url_title($product['chapter']!=''?$product['chapter']:'all','-',true).'/'.$playlist_url.'/'.url_title($product['title'],'-',true).'/'.$product['id'])?>" class="btn btn-raised btn-warning ">Watch Now</a>
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
		 } } ?>
         </div>
         </div>
    </div>
  </div>
</div>
</div>
    <!-- right panel -->
    <div class="col-sm-12 col-md-3 rht260adv">
                    <h3 class="videohed"><i class="material-icons">video_library</i>
                        More Videos form this chapter<p><span><?php echo $videolist?count($videolist):'0'?> videos</span></p></h3>
                    <div class="row height_for_scroll">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scrolheightimgthumb">
                    <?php if($videolist){ foreach($videolist as $video){ ?>
                    <div class="rhtthumbcol"> 
                    <a  href="<?php echo base_url(implode('/', $url_segments).'/'.url_title($video->title,'-',true).'/'.$video->id)?>">
                        <div class="col-xs-3 col-sm-12 col-md-3 col-lg-3 first vedioleftimg"> 
                            <?php if($video->video_source=='youtube'){ ?> 
                            <img class="img-responsive" src="https://i.ytimg.com/vi/<?php echo $video->video_url_code?>/mqdefault.jpg"/>
                            <?php }else{ ?>
                                <img src="<?php echo show_thumb($video->video_image,250,250);?>" class="img-responsive"> 
                            <?php } ?>
                        </div>
                    <div class="rhtimgthumb col-xs-9 col-sm-12 col-md-9 col-lg-9">
                      <h5><?php echo $video->title?></h5>
                        <p> <!--<span class="deatil_side pull-left">Views : 52</span> <span class="deatil_side pull-right">Duration : 00:39:55</span>--></p>
                     </div>
                     </a>  
                    </div>
                    <?php } }?>
                     </div>
                    </div>
                 
      </div>
    </div>
    </div>
</div>
<!-- Modal -->
<div id="messageFlash" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Instruction</h4>
      </div>
      <div class="modal-body">
          <p>For Mozilla - <a target="_blannk" href="https://get.adobe.com/flashplayer/">Click here to Install Flash Player</a></p>
           <p>For Chrome - Allow sites to run Flash</p>
           <p><ul><li>Go to Setting from top Right Corner.</li>
           <li>Go to Advanced setting then click on Content settings.</li>
           <li>Select Flash and Allow sites to run Flash.</li>
           </ul</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>window.onload = function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'mov_bbb.mp4', true);
    xhr.responseType = 'blob'; //important
    xhr.onload = function(e) {
        if (this.status == 200) {
            console.log("loaded");
            var blob = this.response;
            var video = document.getElementById('locckdown_sol');
            video.oncanplaythrough = function() {
                console.log("Can play through video without stopping");
                URL.revokeObjectURL(this.src);
            };
            video.src = URL.createObjectURL(blob);
            video.load();
        }
    };
    xhr.send();
}</script>