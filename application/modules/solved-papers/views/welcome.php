<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb'); ?>
            <div class="col-sm-12 col-md-12">
                      <div class="ncert_cont col-sm-12 col-md-6">
                    <?php
                    $count=1;foreach($solutions_array as $key=>$value){ ?>
                    <?php if(!isset($selectedsubject)){ ?>
                   <ul class="nav">
                       <?php if(!isset($selectedexam)){ ?>
                   <h3 class="text-success">
                       <i class="material-icons">update</i>
                        <a href="<?php echo base_url('solved-papers/'.url_title($value['name'],'-',true).'/'.$key)?>">
                          <?php echo $value['name']?> Solved Paper
                        </a>
                   </h3>
                       <?php  } 
                       foreach($value['subjects'] as $k=>$v){ 
                        if(!isset($selectedsubject)){   ?>
                   <li>
                       <a href="<?php echo base_url('solved-papers/'.url_title($value['name'],'-',true).'/'.$key.'/'.url_title($v['name'],'-',true).'/'.$k)?>">
                           Solved Papers for <?php echo $value['name']?> <?php echo $v['name']?>
                       </a>
                   </li>
                   <?php } }?> 
                  
                   </ul>
                   <?php if($count==2){
                                echo '</div><div class="ncert_cont col-sm-12 col-md-6">';
                                $count = 1;
                            }?>
                 
                    <?php $count++; } }?>
                      </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12 text-center"><h2 class="select_heading">Recent Solved Papers</h2></div>
                <?php
                    if($solvedpapers){ $count=1;foreach($solvedpapers as $qb){
                    if($count==10 && $this->uri->total_segments() ==1) break;
                    $count = 1;
                   
                        if ($count == 9 && $this->uri->total_segments() == 1)
                            break;

                        if ($count > count($this->config->item('bgimages'))) {
                            $count = 1;
                        }
                        $index = $count - 1;
                        ?>
                        <div class="col-xs-6 col-sm-4 col-md-2">
                        <a href="<?php echo generateContentLink('solved-papers',$qb->exam,$qb->subject,$qb->chapter,$qb->name,$qb->id);?>">
                        <div class="col-item offer offer-success" style="height:130px;"> 
                            <div class="shape">
					<div class="shape-text">
						<span  class="glyphicon glyphicon  glyphicon-edit"></span>
					</div>
                                
				</div>
                            <div>
                                
                                      <div class="offer-content">
                                        
                                        <?php     $prdname_cnt=strlen($qb->name);
                 
                $prdhead_cnt=$prdname_cnt;
        
                                           if($prdhead_cnt>35){
                                               $prdhead= substr($qb->name,0,35).'..';//'<h5 style="color:#000">'.$qb->chapter.'</h5>';
                                           } else{
                                                $prdhead= $qb->name ;
                                           
                                           }
                                           
                                        ?>
                                        
                                              
                                        <h6 class="vid_prod_hed" title="<?php    echo $qb->name; ?>"><?php    echo $prdhead; ?></h6>      
                                    </div>
                                
                                
                                           <div class="separator btn_prod_ved">
<div class="price"><h6 class="chepter-color"><?php $prdchap_cnt=strlen($qb->exam); 
if($prdchap_cnt>30){
    $showexam = substr($qb->exam,0,30); 
    
}else{
    $showexam = $qb->exam; 
} ?> <?php echo $showexam;?></h6></div>
                                    </div>
                                    
                                   
                                
                            </div>
                            </div></a>  
                        </div>
                        <?php
                        $count++;
                    }
                }
                ?>
            </div>
            
            
            
       <div class="clearfix"></div>    
            
            <?php if($this->uri->total_segments() > 1){?>
            <div class="row">
        <div class="container">
         
<?php if (!isset($selectedsubject) && isset($subjects_array) && $borwsebysubjects > 0) { ?>                
            <div class="col-sm-12 col-md-12 bro_subject" style="min-height:200px;">

                                    <div class="col-md-12 text-center"><h2>Browse By Subjects</h2>
                                    <?php foreach ($subjects_array as $key => $value) {
                                        if ($value['count'] > 0) {
                                            ?>
                                            <a title="Solved Papers for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>   


                                        <?php }
                                    }
                                    ?>
                                        </div></div>
                                <?php } elseif (isset($chapters_array) && count($chapters_array) > 0) { ?>
            <div class="col-sm-12 col-md-12 bro_subject" style="min-height:200px;">
                                    <div class="col-md-12 text-center"><h2>Browse By Chapters</h2>
                                        <?php foreach ($chapters_array as $key => $value) {
                                            if ($value['count'] > 0) {
                                                ?>

                                            <a title="Solved Papers for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-' , TRUE) . '/' . $selectedsubject->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
                                            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>



                                    <?php }
                                }
                                ?>
                                 </div>           
                                </div>

<?php } ?>

                        
        </div>
    </div>
            <?php } ?>
            
        </div>
    
    </div>   
    </div>

    <!-- End New UI for Product Details -->
    <!--<div class="col-md-3 col-sm-3">
<?php //$this->load->view('common/leftnav');  ?>
    </div>-->
   <!-- <div class="row">
        <div class="container" style="background-color: #f7f9fa;">
         
<?php if (!isset($selectedsubject) && isset($subjects_array)) { ?>                
                                <div class="col-sm-12 col-md-12 bro_subject" style="min-height:200px;">

                                    <div class="col-md-12 text-center"><h2>Browse By Subjects</h2>
                                    <?php foreach ($subjects_array as $key => $value) {
                                        if ($value['count'] > 0) {
                                            ?>
                                            <a title="Video Lectures for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>   


                                        <?php }
                                    }
                                    ?>
                                        </div>
                                <?php } elseif (isset($chapters_array)) { ?>
                                    <div class="col-md-12 text-center"><h2>Browse By Chapters</h2>
                                        <?php foreach ($chapters_array as $key => $value) {
                                            if ($value['count'] > 0) {
                                                ?>

                                            <a title="Video Lectures for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-' , TRUE) . '/' . $selectedsubject->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
                                            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>



                                    <?php }
                                }
                                ?>
                                 </div>           
                                </div>

<?php } ?>

                        
        </div>
    </div>-->
                        

          
            <!-- /. PAGE INNER  -->
