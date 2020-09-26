<div id="wrapper">
    <div class="container">
        <div class="row">
    <?php $this->load->view('common/breadcrumb');?>
    <div class="col-md-12 col-sm-12">
            <div id="page-inner">
                <div class="module_panel row">                  
                  <!-- content panel start here -->
                  <!-- left panel -->
                  <div class="col-sm-12 col-md-12">
                      <div class="ncert_cont col-sm-12 col-md-6">
                     <?php $count = 1;
                    foreach ($solutions_array as $key => $value) { ?>
                        <?php if (!isset($selectedsubject)) { ?>
                        
                                <?php if (!isset($selectedexam)) { ?>
                                        <ul class="nav"><h3 class="text-success">
                                        <i class="material-icons">update</i>
                                        <a href="<?php echo base_url('question-bank/' . url_title($value['name'], '-', true) . '/' . $key) ?>">
                                            <?php echo $value['name'] ?> Question Bank
                                        </a>
                                    </h3> 
                                        <?php
                                        foreach ($value['subjects'] as $k => $v) {
                                    if (!isset($selectedsubject)) {
                                        ?>
                                        <li>
                                            <a href="<?php echo base_url('question-bank/' . url_title($value['name'], '-', true) . '/' . $key . '/' . url_title($v['name'], '-', true) . '/' . $k) ?>">
                                               Question Bank for <?php echo $value['name'] ?> <?php echo $v['name'] ?>
                                            </a>
                                        </li>
            <?php }
        }
                                        ?>
                                        
                                        </ul>
                                <?php } ?> 

                           
            <?php
                            
                            if($count==2){
                                echo '</div><div class="ncert_cont col-sm-12 col-md-6">';
                                $count = 1;
                            } ?>

        <?php $count++;
    }
}          ?> </div>
    <?php
    //Show on class and subject page     
    ?>
<?php if (!isset($selectedsubject) && isset($subjects_array)) {  
                            
  $bookclass = array('btn-default', 'btn-primary', 'btn-warning', 'btn-info', 'btn-danger'); 
    
    ?>  <!--Showing Subject Start-->
                                <div class="col-md-12 text-center bavl">
                                    <h2 class="select_heading">Select Subject</h2>      
                                </div>     
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <p class="text-center">
                            <?php 
                            
                           foreach ($subjects_array as $key => $value) {
                                        if ($value['count'] > 0) {
                                            $bookclass_cnt = rand(0, 3);
                                            ?>
                                            <a title="Question Bank for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class='btn btn-sq-lg <?php echo $bookclass[$bookclass_cnt]; ?>'><i class='fa fa-book fa-5x'></i><br>
            <?php echo $value['name']; ?><br/>
                                        <span>(<?php echo $value['count']; ?> Question Banks)</span>
                                            </a> 
                                    <?php 
                                        }
                                    }
                          
        ?>
               </p>
                                        </div>
                                    </div>
                                </div>
                                <!--End Showing Subject --> 
<?php } elseif (isset($chapters_array) && count($chapters_array) > 0) { 
    if($chapter_id==0){ ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                        <h2 class="select_heading">Select Chapter</h2>
                                        <?php foreach ($chapters_array as $key => $value) {
                                            if ($value['count'] > 0) {
                                                ?>
                                            <a title="Question Bank for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-' , TRUE) . '/' . $selectedsubject->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn select_subject_btn btn btn-primary btn-raised btn-lg" type="button">
                                            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>
                                    <?php }
                                }
                                ?>
                                 </div>      
<?php 
}
} ?>
                                
                  </div>
                  <div class="col-sm-12 col-md-12">
                    <!-- Recent Questions -->
                    <div class="row recent_ques">
                <?php
                //show on chapter page
               
                if (isset($questionbanks)&&$questionbanks) {
                    ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                        <?php if($chapter_id==0||$chapter_id==''){ ?>
                    <div class="col-md-12 text-center"><h2 class="select_heading">Recent Question Banks</h2></div>
                        <?php } ?>
                <div class="clearfix"></div> 
                    <?php
                    $this->load->view('common/exam_questionbanklist');
                    ?>
                </div>
                    <?php
               } 
              
                $showBrows='no';
                if($showBrows=='yes'){
                ?>
             <div class="container" style="background-color: #f7f9fa;">
         
<?php if (!isset($selectedsubject) && isset($subjects_array)) { ?>                
                                <div class="col-sm-12 col-md-12 bro_subject" style="min-height:200px;">

                                        <div class="col-md-12 text-center">
                                        <h2>Browse By Subjects</h2>
                                    <?php foreach ($subjects_array as $key => $value) {
                                        if ($value['count'] > 0) {
                                            ?>
                                            <a title="Question Bank for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
            <?php echo $value['name']; ?>
                                        <span class="badge"><?php echo $value['count']; ?></span>
                                            </a> 
                                    <?php 
                                        }
                                    }
                                    ?>
                                    </div>
                                <?php } elseif (isset($chapters_array) && count($chapters_array) > 0) { ?>
                                    <div class="col-md-12 text-center">
                                        <h2>Browse By Chapters</h2>
                                        <?php foreach ($chapters_array as $key => $value) {
                                            if ($value['count'] > 0) {
                                                ?>
                                            <a title="Question Bank for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-' , TRUE) . '/' . $selectedsubject->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
                                            <?php echo $value['name']; ?> <span class="badge"><?php echo $value['count']; ?></span>
                                            </a>
                                    <?php }
                                }
                                ?>
                                 </div>           
                                </div>
<?php } ?>
        </div> 
                        <?php } ?>
              </div>
                  </div>
                  </div>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
</div>
</div>
</div>