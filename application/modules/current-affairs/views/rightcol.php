<div class="rht_status_mat center-block">
    <?php 
    ?>
    
    
        <!--------------------------------- ad start-------------------------------------->
        
        <!--------------------trending news start--------------------------->
        <!--<h2>Latest News </h2><div class="box"><div class="latest_news_cntr" id=""><a><img src="images/students_image.jpg" alt="" width="100%" /></a><a class="heading">
            DU foreign students facing language problem </a></div><div class="latest_news_cntr" id=""><a><img src="images/students_image.jpg" alt="" width="100%"  /></a><a class="heading">
            DU foreign students facing language problem </a></div></div>-->
        <!---------------------------------latest news end-------------------------------------->
        
        <?php if(isset($childcategories) && count($childcategories) >0){ ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4><?php echo $category->name?></h4>
            </div>
            <div class="panel-body">
                <ul>
                    <?php foreach($childcategories as $key=>$value){ ?> 
                    <li>
                        <a href="<?php echo base_url(MODULE_NAME_CF);?>/<?php echo getDashedUrl($value['name']);?>/<?php echo $value['id'];?>"><?php echo $value['name'];?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <br>
        <?php } ?>
        <div class="clearfix"></div>
        <?php if(isset($articlecategories) && count($articlecategories) >0){  ?>
        
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4><?php echo MODULE_NAME_HEADING_CF; ?> Categories</h4>
            </div>
            <div class="panel-body">
                <ul id="content-n">
                    <?php foreach($articlecategories as $key=>$value){ ?> 
                    <li>
                        <a href="<?php echo base_url(MODULE_NAME_CF)?>/<?php echo getDashedUrl($value['name']);?>/<?php echo $value['id'];?>"><?php echo $value['name'];?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php  } ?>
        <br>
        <?php  if(isset($archives) && count($archives) >0){  ?>
        <div class="panel panel-primary ">
            <div class="panel-heading">
                <h4>Archive</h4>
            </div>
            <div class="panel-body archives">
                <ul id="content-m">
                    <?php foreach($archives as $ls){ ?>
                    <li>
                        <a href="<?php echo base_url(MODULE_NAME_CF);?>/archives/<?php echo $ls->year.'/'.date('m', strtotime($ls->month));?>">
                        <?php echo $ls->month.' '.$ls->year.'(<b>'.$ls->postcount.'</b>)'?> 
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php } ?>
          <br>
       
        <?php   if(isset($trending) && count($trending) >0){  ?> 
        <div class="panel panel-primary">
            <div class="panel-heading">
            <h4>Trending <?php echo MODULE_NAME_HEADING_CF; ?></h4>
            </div>
            <div class="panel-body">
            <ul id="content-o">
                <?php foreach($trending as $ls){
                    if($ls->title!=''){
                        $title_text=$ls->title;
                    }else{
                       $title_text_str=$ls->description;  
                       $title_text_refine=strip_tags($title_text_str);
                       
                       $title_text_refine=substr($title_text_refine,0,31);
                       
                       if(strlen($title_text_refine)>0){
                           $title_text=$title_text_refine.'...';
                       }else{
                         $title_text=$ls->name;  
                       }
                    }
                    
                    ?>
                <li>
                    <a href="<?php echo base_url(MODULE_NAME_CF);?>/<?php echo getDashedUrl($ls->name).'/'.getDashedUrl($title_text).'/'.$ls->id?>">
                    <?php echo $title_text;?>
                    </a>
                </li>
                <?php } ?>
            </ul>
                </div>
        </div>
        
        <?php } ?>

    
</div>

<!-- old content -->