<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb'); ?>
        </div>

        <!-- video gallery -->
        <?php if (isset($exam)) { ?>              
            <div class="row vedio_bot_gal">
                <div class="col-sm-12 col-md-9" >
                    <?php if ($videolistfiltered) {
                        foreach ($videolistfiltered as $key => $value) { ?>

                            <?php if ($key == 'default') { ?>
                                <h2 id="freevideos_<?php echo $key ?>">Free Videos for <?php echo $exam->name ?></h2>
                            <?php } else { ?>
                                <h2 id="freevideos_<?php echo $key ?>">Free Videos for <?php echo $exam->name . ' ' . $key ?></h2>
                                <?php } ?>
                            <div class="row vid_list">
            <?php foreach ($value as $k => $video) { ?>


                                    <div class="col-xs-12 col-sm-6 col-md-4 ">

                                        <div class="pic wel_vid"> 
                                            <a href="<?php echo base_url('videos/' . url_title($video->exam, '-', true) . '/' . url_title($video->subject ? $video->subject : 'all', '-', true) . '/' . url_title($video->chapter ? $video->chapter : 'all', '-', true) . '/' . url_title($video->playlist ? $video->playlist : 'all', '-', true) . '/' . url_title($video->title, '-', true) . '/' . $video->id) ?>" <?php if (!$this->session->userdata('customer_id')) {
                    echo 'onclick="return showmsg();return false;"';
                } ?> title="<?php echo $video->title ?>">
                                                <img class="img-responsive lazy" data-original="https://i.ytimg.com/vi/<?php echo $video->video_url_code ?>/mqdefault.jpg" src="/assets/frontend/images/index.png"/>
                                                <p class="pic-caption bottom-to-top"> 
                <?php echo $video->title ?> <br> <i class="material-icons">play_arrow</i></p> 
                                            </a>
                                            <h5 class="vid_prod_hed"><?php echo $video->title ?></h5>
                                        </div> 

                                    </div>
            <?php } ?>
</div>
<?php }
    } ?>
                </div>
                <!-- right panel -->
                <div class="col-sm-12 col-md-3 rht260adv">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="padding:1px !important">
                            <h4> <i class="material-icons">book</i> Subjects</h4>
                        </div>
                        <div class="panel-body">
                            <?php foreach ($videolistfiltered as $key => $value) { ?>
                                <div class="col-sm-12">
                                    <h4>
                                        <a title="Free videos for <?php echo $exam->name;
                                echo $key != 'default' ? $key : '' ?>" class="scrollhtml" id="<?php echo $key ?>"><?php echo $key == 'default' ? 'Main' : $key ?></a>
                                    </h4>
                                </div>
    <?php } ?>
                        </div></div>
                    <br>

                    <img src="<?php echo base_url('assets/images/260adv.jpg') ?>" />
                </div>
            </div>
        <div class="col-md-12">
                <div class="col-md-12 text-center"><h2>Recent Free Videos </h2></div>
    <?php if ($videolistfiltered) {
        foreach ($videolistfiltered as $key => $value) { ?>
                        <div class="row vid_list">
            <?php foreach ($value as $k => $video) { ?>


                                <div class="col-xs-12 col-sm-6 col-md-4 ">

                                    <div class="pic wel_vid"> 
                                        <a href="<?php echo base_url('videos/' . url_title($video->exam, '-', true) . '/' . url_title($video->subject ? $video->subject : 'all', '-', true) . '/' . url_title($video->chapter ? $video->chapter : 'all', '-', true) . '/' . url_title($video->playlist ? $video->playlist : 'all', '-', true) . '/' . url_title($video->title, '-', true) . '/' . $video->id) ?>" <?php if (!$this->session->userdata('customer_id')) {
                    echo 'onclick="return showmsg();return false;"';
                } ?> title="<?php echo $video->title ?>">
                                            <img class="img-responsive lazy" data-original="https://i.ytimg.com/vi/<?php echo $video->video_url_code ?>/mqdefault.jpg" src="/assets/frontend/images/index.png"/>
                                            <p class="pic-caption bottom-to-top"> 
                <?php echo $video->title ?> <br> <i class="material-icons">play_arrow</i></p> 
                                        </a>
                                        <h5 class="vid_prod_hed"><?php echo $video->title ?></h5>
                                    </div> 

                                </div>
                        <?php } ?>
                        </div>
        <?php }
    } ?>
            </div>
<?php } else { ?>
            
         <div class="col-md-12">
             <?php 
             if(count($mainexams)>1){
             $vCount=0;
             foreach($mainexams as $key=>$value){ 
                 $vCount=count($mainexams_videos[$value]);
                 if($vCount>0){
                 $mexam=$this->Categories_model->getCategoryDetails($value);?> 
                <div class="col-md-12">
                    <h2 class="freevid_hd">
                        <a href="<?php echo base_url('free-videos/'.url_title($mexam->name,'-',true).'/'.$value) ?>">
                            <?php echo $mexam->name;?> Free Video Lectures
                        </a>
                    </h2>
                    <hr style="margin:0; margin-top:5px; padding:0;" />
                </div>
                <?php
                    $count = 1;
                    foreach ($mainexams_videos[$value] as $video) { ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                        <div class="pic wel_vid"> 
                                            <a href="<?php echo base_url('videos/' . url_title($video->exam, '-', true) . '/' . url_title($video->subject ? $video->subject : 'all', '-', true) . '/' . url_title($video->chapter ? $video->chapter : 'all', '-', true) . '/' . url_title($video->playlist ? $video->playlist : 'all', '-', true) . '/' . url_title($video->title, '-', true) . '/' . $video->id) ?>" <?php if (!$this->session->userdata('customer_id')) {
                    echo 'onclick="return showmsg();return false;"';} ?> title="<?php echo $video->title ?>">
                                                <img class="img-responsive lazy" data-original="https://i.ytimg.com/vi/<?php echo $video->video_url_code ?>/mqdefault.jpg" src="/assets/frontend/images/index.png"/>
                                                <p class="pic-caption bottom-to-top"> 
                <?php echo $video->title ?> <br> <i class="material-icons">play_arrow</i></p> 
                                            </a>
                                            <h5 class="vid_prod_hed"><?php echo $video->title ?></h5>
                                        </div> 

                                    </div>
                    <?php }
                  ?> <div class="pull-right"><a href="<?php echo base_url('free-videos/'.url_title($mexam->name,'-',true).'/'.$value) ?>" class="btn btn-success btn-lg btn-raised">View More</a></div><?php
             }
             
                                            }
}else{
       ?>
           
           
           
             <div class="row vid_list">


                                    <div class="col-xs-12 col-sm-6 col-md-4 ">
                                        
                                       Free Video Not Found!
                                    </div>
             </div>
           
           <?php 
        
        
    } 
                ?>
            
         </div>
            
<?php } ?>
    </div>

</div>