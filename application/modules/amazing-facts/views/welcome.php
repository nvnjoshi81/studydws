<div id="wrapper">
    <div class="container">
        <div class="row">
         <div class="col-md-12">
<div class="col-xs-12 col-sm-12 col-md-7">
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo base_url()?>">
                <i class="glyphicon glyphicon-home"></i>
            </a>
        </li>
                      
        
        <?php 
        if (isset($category) && $category->name != '') { ?>
            <li><a href="<?php echo base_url('amazing-facts')?>">
                Amazing Facts
            </a>
            </li>
            <li class="active">
                <?php echo $category->name;?>
            </li>  
            <?php }else{ ?>
            <li class="active">
                Amazing Facts
            </li>   
           <?php }
        ?>             
        </ol>
 </div>
 
 
 </div>
    <!-- add panel start here -->
  <article class="row midsec">
      
   <div class="box_closed box_cloud" id="related-tags-section">
       <ul class="nav navbar-nav">
       <!--------------------------------- category container-------------------------------------->
       <?php foreach($articlecategories as $key=>$value){ ?> 
            <li>
                <a <?php echo isset($category) && $category->name==$value['name']?'class=""':'';?>href="<?php echo base_url()?>amazing-facts/<?php echo getDashedUrl($value['name']);?>/<?php echo $value['id'];?>"><?php echo $value['name'];?></a>
            </li>
        <?php } ?>
    
	</ul>
            <div class="clear"></div>
          </div>
    
    
    
      <!-- Add the extra clearfix for only the required viewport -->
      <aside class="hidden-xs hidden-sm hidden-md hidden-lg">left</aside>
 <!--     <article class="row commentWrapper midaddsec">
        <section class="hidden-xs hidden-sm col-md-12 col-lg-12">
        
                
          <div id="" class="ad728">
          
                    </div>
          <div class="ad200">
                    </div>
        
          
        </section>
     </article>-->
       <!-- mboiel screen -->
      <!--  <div class="responsive_google_ad">
          </div>-->
      <!-- mid -->
      <aside class="col-xs-12 col-sm-12 col-md-12 col-lg-12 lftforadd">
       
        <div class="heading-bar">
        	<h2>
            <?php 
$bg_text_css_array = array('bg_blue', 'bg_green', 'bg_orange', 'bg_mehroon', 'bg_yellow', 'bg_yellowdark');
            $bg_custom_image_array = array('mis', 'miscelleneous1', 'nature', 'miscelleneous2', 'univers2', 'miscelleneous3', 'theworld', 'Universe', 'world', 'mis1', 'mis2', 'mis3', 'mis4', 'nat1', 'nat2', 'nat3', 'uni1', 'uni2', 'uni3', 'uni4', 'w1', 'w2', 'w3', 'w4');
            if (isset($category_name) && $category_name != '') {
                echo $category_name;
            } else {
                echo "Amazing Facts";
            }
            ?>            
            </h2>
            <span class="h-line"></span>
        </div> 
       <div id="container" style="position:relative;">
        <section id="pinBoot">

         
         <?php
		  foreach($listings as $list){
		  
	
		 $cnt_css_name=mt_rand(0,5);
		 $cnt_img_name=mt_rand(0,23);
//bg_text_css_array define in ingenious.php
$bg_color_for_image = $bg_text_css_array[$cnt_css_name];
$bg_custom_image =$bg_custom_image_array[$cnt_img_name];

		  ?>
        <article class="white-panel">
            <img class="img-responsive" src="<?php echo "images/".$bg_custom_image; ?>.jpg" alt="">
            <h4><a href="#"><b><?php echo $list->name;?></b></a></h4>
            <p><?php echo custom_strip_tags($list->description);?></p>
        </article>
	
	
         <?php } ?>
            </section>
</div>    

        
      </aside>
      <!-- right -->
    <!--  <aside class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
    
                <div class="archive_right">
          <h3>Amazing Facts</h3>
          <ul  id="content-m" >
           <?php // foreach($articlecategories as $key=>$value){ ?> 
            <li>
                <a href="<?php// echo $this->config->item('web_root');?>amazing-facts/<?php // echo getDashedUrl($value['name']);?>/<?php echo $value['id'];?>"><?php echo $value['name'];?></a>
            </li>
        <?php // } ?>
             </ul>
        </div>     -->     
        <!---------------------------------Right  content  container--------------------------------------->
                <div class="clear"></div>
      </aside>
      
    </article>
  </div>
    </div>
</div>