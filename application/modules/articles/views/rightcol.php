<div class="rht_status_mat center-block">
    
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
                        <a href="<?php echo base_url();?>articles/<?php echo getDashedUrl($value['name']);?>/<?php echo $value['id'];?>"><?php echo $value['name'];?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <br>
        <?php } ?>
        <div class="clearfix"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Articles Categories</h4>
            </div>
            <div class="panel-body">
                <ul id="content-n">
                    <?php foreach($articlecategories as $key=>$value){ ?> 
                    <li>
                        <a href="<?php echo base_url()?>articles/<?php echo getDashedUrl($value['name']);?>/<?php echo $value['id'];?>"><?php echo $value['name'];?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <br>
        <div class="panel panel-primary ">
            <div class="panel-heading">
                <h4>Archive</h4>
            </div>
            <div class="panel-body archives">
                <ul id="content-m">
                    <?php foreach($archives as $ls){ ?>
                    <li>
                        <a href="<?php echo base_url();?>articles/archives/<?php echo $ls->year.'/'.date('m', strtotime($ls->month));?>">
                        <?php echo $ls->month.' '.$ls->year.'(<b>'.$ls->postcount.'</b>)'?> 
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
          <br>
        <div class="panel panel-primary">
            <div class="panel-heading">
            <h4>Trending Articles</h4>
            </div>
            <div class="panel-body">
            <ul id="content-o">
                <?php foreach($trending as $ls){ ?>
                <li>
                    <a href="<?php echo base_url();?>articles/<?php echo getDashedUrl($ls->name).'/'.getDashedUrl($ls->title).'/'.$ls->id?>">
                    <?php echo $ls->title;?>
                    </a>
                </li>
                <?php } ?>
            </ul>
                </div>
        </div>

    
</div>

<!-- old content -->