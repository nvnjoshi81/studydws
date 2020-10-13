<?php
$sdl = $article->language=="hindi";
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
      <?php //$this->load->view('common/breadcrumb');?>
       <!--<div class="col-md-9 articledetails">-->
      
      <div class="col-md-12">
        <div>
            <div class="p-3 mb-2 bg-success text-white">
            <h3><?php echo $article->title;?></h3>
        </div>
        <div class="rev_article">
        <!--<p class="col-md-5"><strong>Category : </strong><?php echo $article->exam; ?></p>-->

			<div <?php echo $hindicss; ?> class="panel-body ">
            <p><?php echo $article->description;?></p>
          </div>
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
                    
            ?>
            <div class="pull-left"><a href="<?php echo base_url('appnotes/'.url_title($previouspost->exam,'-',true).'/'.url_title($previouspost->subject,'-',true).'/'.url_title($previouspost->chapter,'-',true).'/'.url_title($title_text,'-',true).'/'.$previouspost->id)?>" class="btn btn-warning"><i class="material-icons">keyboard_arrow_left</i><?php echo $title_text?></a></div>
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
                    
                    ?>
            <div class="pull-right"><a href="<?php echo base_url('appnotes/'.url_title($nextpost->exam,'-',true).'/'.url_title($nextpost->subject,'-',true).'/'.url_title($nextpost->chapter,'-',true).'/'.url_title($title_text,'-',true).'/'.$nextpost->id)?>" class="btn btn-warning"><?php echo $title_text?> <i class="material-icons">keyboard_arrow_right</i></a></div>
        <?php } ?>
        </div>
      </div>
      
    </div>
  </div>
</div>
