<?php
$sdl = $article->language;
if(isset($sdl)&&$sdl=='hindi') {
	$hindicss='class="hindifont"';
	$hindicss_number_q='class="hindicss_number_q"';
	$hindicss_number_a='class="hindicss_number_a"';
	$hindicss_text='class="hindicss_text"';
}
?>
<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php $this->load->view('common/breadcrumb');?>
       <!--<div class="col-md-9 articledetails"></div>-->
      <div class="col-md-9">
        <div class="panel panel-success">
          <!--<div class="panel-heading">
            <h2><?php //echo $article->title;?></h2>
          </div>-->
          <div class="rev_article"><p class="col-md-12"><?php echo $article->title;?></p>
          <p class="col-md-5"><strong>Category : </strong><?php echo $article->exam; ?></p>
          </div>
          <div <?php echo $hindicss; ?> class="panel-body ">
            <p><?php echo $article->description;?></p>
          </div>
        </div>
            <div class="art_nxt_prev">
        <?php

        if($previouspost){
              if($previouspost->title!=''){
                        $title_text=$previouspost->title;
                    }else{
                       $title_text_str=$previouspost->description;  
                       $title_text_refine=strip_tags($title_text_str);
                       
                       $title_text_refine=substr($title_text_refine,0,11);
                       
                       if(strlen($title_text_refine)>0){
                           $title_text=$title_text_refine.'...';
                       }else{
                         $title_text=$previouspost->name;  
                       }
                    }
                    
					
					 if(isset($previouspost->chapter)&&($previouspost->chapter!='')){
			   
			   $prev_chapter=$previouspost->chapter;
		   }else{
			   $prev_chapter='allchapter';
		   }
		   if(isset($previouspost->subject)&&($previouspost->subject!='')){
			   
			   $prev_subject=$previouspost->subject;
		   }else{
			   $prev_subject='allsubject';
		   }
            ?>
            <div class="pull-left"><a href="<?php echo base_url('notes/'.url_title($previouspost->exam,'-',true).'/'.url_title($prev_subject,'-',true).'/'.url_title($prev_chapter,'-',true).'/'.url_title($title_text,'-',true).'/'.$previouspost->id)?>" class="btn btn-warning"><i class="material-icons">keyboard_arrow_left</i><?php echo $title_text?></a></div>
        <?php }
        if($nextpost){ 
                       if($nextpost->title!=''){
                        $title_text=$nextpost->title;
                    }else{
                       $title_text_str=$nextpost->description;  
                       $title_text_refine=strip_tags($title_text_str);
                       $title_text_refine=substr($title_text_refine,0,11);
                       if(strlen($title_text_refine)>0){
                        $title_text=$title_text_refine.'...';
                       }else{
                         $title_text=$nextpost->name;  
                       }
                    }
					
					
					 if(isset($nextpost->chapter)&&($nextpost->chapter!='')){
			   
			   $next_chapter=$nextpost->chapter;
		   }else{
			   $next_chapter='allchapter';
		   }
		   if(isset($nextpost->subject)&&($nextpost->subject!='')){
			   
			   $next_subject=$nextpost->subject;
		   }else{
			   $next_subject='allsubject';
		   }
					
                    ?>
            <div class="pull-right"><a href="<?php echo base_url('notes/'.url_title($nextpost->exam,'-',true).'/'.url_title($next_subject,'-',true).'/'.url_title($next_chapter,'-',true).'/'.url_title($title_text,'-',true).'/'.$nextpost->id)?>" class="btn btn-warning"><?php echo $title_text?> <i class="material-icons">keyboard_arrow_right</i></a></div>
        <?php } ?>
        </div>
      </div>
      <div class="col-md-3">
        <div class="panel panel-primary rht_status_mat">
          <div class="panel-heading">
            <h4>Other Topics</h4>
          </div>
          <div class="panel-body">
            <ul>
                <?php
                //print_r($related);
                foreach($related as $related_article){
                   //print_r($related_article); die();
                ?>
                <li><i class="material-icons">play_arrow</i> 
                    <?php if($check){ ?> 
                    <a href="<?php echo generateContentLink('notes',$related_article->exam,$related_article->subject,$related_article->chapter,$related_article->title,$related_article->id); ?>" ><?php echo $related_article->title; ?></a> </li>
                    <?php }else{ ?>
                    <a href="<?php echo generateContentLink('notes',$related_article->name,$related_article->subject,$related_article->chapter,$related_article->title,$related_article->id); ?>" ><?php echo $related_article->title; ?></a> </li>
                    <?php } ?>
                <?php
                }
                ?>
            </ul>
          </div>
        </div>
         <!--For Releted Studymaterial -->
         <div class="clearfix"></div>
         <div class="panel panel-primary rht_status_mat">
        <?php 
		if(isset($linktostudypackage)){ ?> 
        <div class="col-xs-12 col-sm-12 col-md-12 rht_pdf_box">
            <div class="col-item">
              <div class="photo"> 
                   <?php 
                
             if (file_exists($filepath.$file->filename.'/docs/'.$file->filename.'.pdf_1.jpg')) {
                $imagePath = base_url($filepath.$file->filename.'/docs/'.$file->filename.'.pdf_1.jpg');
                }else{                    
                $imagePath = base_url('assets/frontend/images/ebooks.png');  
                }
                ?>
                  <a title="Download PDF" href="<?php echo $linktostudypackage;?>" style="text-decoration: none;color:#fff">
               
              <img src="<?php echo $imagePath; ?>" data-original="<?php echo $imagePath; ?>" class="img-responsive" alt="studyadda" style="display: block;" />
                  </a>    
              </div>
              <div class="info">
                <div class="row">
                  <div class="price col-xs-12 col-md-12">
                    <h5 class="vid_prod_hed"><?php echo $file->displayname?$file->displayname:$file->filename; ?></h5>
                      <!-- <h5 class="price-text-color">&nbsp; <?php if($isProduct->discounted_price > 0){ 
        ?>
      <i class="fa fa-inr"> </i> <del class="del_txt"> <?php echo $isProduct->price?></del> <?php echo $isProduct->discounted_price;
    }else{
        echo $isProduct->price;
    }
    ?> </h5>-->
                </div>
                 </div>
                <div class="separator btn_prod_ved">
                <!--<a href="<?php echo $linktostudypackage?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>-->
                <a href="<?php echo base_url('purchase-courses'); ?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>
                </div>
                <div class="clearfix"> </div>
              </div>
            </div>
          </div>
        <?php } ?>
            
         </div>   
      </div>
    </div>
  </div>
</div>
