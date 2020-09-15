<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php $this->load->view('common/breadcrumb');?>
       <!--<div class="col-md-9 articledetails">-->
      
      <div class="col-md-9">
        <div class="panel panel-success">
          <div class="panel-heading">
            <h2><?php echo $article->title;?></h2>
          </div>
          <div class="rev_article">
            <p class="col-md-5"><strong>Category : </strong><?php echo $article->exam; ?></p>
            <p class="col-md-7 pull-right text-right"><?php //echo custom_date($article->dt_created); ?></i></p>
          </div>
          <div class="panel-body">
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
                    
            ?>
            <div class="pull-left"><a href="<?php echo base_url('notes/'.url_title($previouspost->exam,'-',true).'/'.url_title($previouspost->subject,'-',true).'/'.url_title($previouspost->chapter,'-',true).'/'.url_title($title_text,'-',true).'/'.$previouspost->id)?>" class="btn btn-warning"><i class="material-icons">keyboard_arrow_left</i><?php echo $title_text?></a></div>
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
            <div class="pull-right"><a href="<?php echo base_url('notes/'.url_title($nextpost->exam,'-',true).'/'.url_title($nextpost->subject,'-',true).'/'.url_title($nextpost->chapter,'-',true).'/'.url_title($title_text,'-',true).'/'.$nextpost->id)?>" class="btn btn-warning"><?php echo $title_text?> <i class="material-icons">keyboard_arrow_right</i></a></div>
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
      </div>
    </div>
  </div>
</div>
