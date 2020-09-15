<link rel="stylesheet" href="<?php echo get_assets('assets/css/prettyPhoto.css');?>" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
     <link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.min.css'); ?>"> 
 <link href="<?php echo get_assets('assets/css/light/lightgallery.css');?>"  rel="stylesheet">

		<style type="text/css" media="screen">
			* { margin: 0; padding: 0; }
							
			.wide {
				border-bottom: 1px #000 solid;
				width: 4000px;
			}
			
			.fleft { float: left; margin: 0 20px 0 0; }
			
			.cboth { clear: both; }
			
			#main {
				background: #fff;
				margin: 0 auto;
				padding: 30px;
				width: 1000px;
			}
		</style>
<!-- sliderman.js -->
<div id="wrapper">
    <div class="container">
        <div class="row">
    <?php $this->load->view('common/breadcrumb');?>
 
    <div class="container">
    <div class="row">
        <p><h3>In Media</h3></p>
    </div>
</div>
          <!-- Page Content -->
<div id="myCarousel" class="carousel slide slide_container" data-ride="carousel" > 
  <!-- <div class="bg_img_ban"><img src="http://www.studyadda.local/assets/frontend/images/bg_2.jpg"  />   </div>-->
 <div class="homepageban">     
 <div class="homepageslid-inner">
  <div class="col-md-12 home_ban">
  <div class="carousel-inner">  
    
      	<ul class="gallery clearfix">
			  <?php
        $cnt=0; 
       foreach($media_array as $media){ 
                if($media->image!=''){
                 ?><div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">	
                     <li style="display: inline;"><a href="<?php echo  base_url(); ?>assets/images/<?php echo $media->image_big; ?>" rel="prettyPhoto[gallery1]"><img src="<?php echo  base_url(); ?>assets/images/<?php echo $media->image; ?>" width="200" height="200" alt="" /></a></li>
                    </div><?php
$cnt++;
       }
       
       }
       ?>
     </ul>
 </div>
 </div>
 
 <!-- login form -->
 </div> 
 </div> 
 </div>
   
        
    <!-- 
<section>
    <h3>A Four Image Set</h3>
       <div class="row">
  <?php
  
   foreach($media_array as $media){ 
                if($media->image!=''){ 
?>
      	<div class="col-md-4 col-sm-4 col-xs-6">  <a class="example-image-link" href="<?php echo  base_url(); ?>assets/images/<?php echo $media->image; ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" src="<?php echo  base_url(); ?>assets/images/<?php echo $media->image; ?>" alt=""/></a>
        </div>
    
   <?php } } ?>
       </div>
  </section>
      -->
  <!-- /container -->

</div>
</div>
</div>

<!--
			<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$("area[rel^='prettyPhoto']").prettyPhoto();
				
				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:90000, autoplay_slideshow: false});
				$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:900000, hideflash: true});
		
				$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

				$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
					changepicturecallback: function(){ _bsap.exec(); }
				});
			});
			</script>
                        -->