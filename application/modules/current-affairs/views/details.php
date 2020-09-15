<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php $this->load->view('common/breadcrumb');?>
      
       <div class="col-md-9 articledetails">
        <div class="panel panel-success">
          <div class="panel-heading">
            <h2><?php echo $postdetails->title?></h2>
          </div>
          <div class="panel-body">
            <p><strong>Category : </strong> <i>
            <a title="<?php echo $category->name;?>" href="<?php echo base_url(MODULE_NAME_CF)?>/<?php echo url_title($category->name,'-',true).'/'.$category->id;?>"><?php echo $category->name;?>
           </a>
                </i><?php //echo $postdetails->views?></p>
            <p><?php echo $postdetails->description;?></p>
          </div>
        </div>
        <div class="art_nxt_prev">
            <?php if($previouspost){
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
            <div class="pull-left">
                <a href="<?php echo base_url(MODULE_NAME_CF.'/'.url_title($previouspost->name,'-',true).'/'.url_title($title_text,'-',true).'/'.$previouspost->id) ?>" class="btn btn-warning">
                    <i class="material-icons">keyboard_arrow_left</i>
                    <?php echo $title_text;?>
                </a>
            </div>
            
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
            <div class="pull-right">
                <a href="<?php echo base_url(MODULE_NAME_CF.'/'.url_title($nextpost->name,'-',true).'/'.url_title($title_text,'-',true).'/'.$nextpost->id) ?>" class="btn btn-warning"> 
                    <?php echo $title_text;?>
                    <i class="material-icons">keyboard_arrow_right</i>
                </a>
            </div>
               
            <?php } ?>
          
          
        </div>
      </div>
        <div class="col-md-3">
        <?php $this->load->view('rightcol');?>
        </div>
    </div>
  </div>
</div>



