<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb'); ?>
           <!-- <div class="col-md-3 col-sm-3">
                <?php //$this->load->view('common/leftnav'); ?>
            </div>-->
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
                            <ul class="nav">
                                <?php if (!isset($selectedexam)) { ?>
                                    <h3 class="text-success">
                                        <i class="material-icons">update</i>
                                        <a href="<?php echo base_url('notes/' . url_title($value['name'], '-', true) . '/' . $key) ?>">
                                            <?php echo $value['name'] ?> Notes
                                        </a>
                                    </h3>
                                <?php } foreach ($value['subjects'] as $k => $v) {
                                    if (!isset($selectedsubject)) {
                                        ?>
                                        <li>
                                            <a href="<?php echo base_url('notes/' . url_title($value['name'], '-', true) . '/' . $key . '/' . url_title($v['name'], '-', true) . '/' . $k) ?>">
                                               Notes for <?php echo $value['name'] ?> <?php echo $v['name'] ?>
                                            </a>
                                        </li>
            <?php }
        } ?> 

                            </ul>
                            <?php //if ($count == round(count($solutions_array) / 2, 0, PHP_ROUND_HALF_EVEN)) {
                            if($count==2){
                                echo '</div><div class="ncert_cont col-sm-12 col-md-6">';
                                $count = 1;
                            } ?>

        <?php $count++;
    }
} ?>
                            </div>
                        </div>
                    

<div class="col-md-12">
                <div class="col-md-12 text-center"><h2>Recent Notes</h2></div>
                <div class="clearfix"></div>
                <?php
                if ($notes) {
                    $count = 1;
                     foreach ($notes as $qb) {
                        if ($count == 9 && $this->uri->total_segments() == 1)
                            break;

                        if ($count > count($this->config->item('bgimages'))) {
                            $count = 1;
                        }
                        $index = $count - 1;
                        ?>
                <a href="<?php echo generateContentLink('notes', $qb->exam, $qb->subject, $qb->chapter, $qb->title, $qb->id); ?>">
                        <div class="outer col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                            
                            <div class="container1" style="background-size: 100% 100%; background-repeat: no-repeat;background-image: url('/assets/frontend/images/<?php echo $this->config->item('bgimages')[$count - 1] ?>');">
                                <div class="content">
                                    
        <?php echo $qb->title; ?>
                                                           
                                </div>
                            </div>
                                
                        </div> </a>
                        <?php
                        $count++;
                    }
                }
                ?>
            </div>


                            <!-- Recent Questions -->
                            
                       </div>
                </div> 
            </div>
           <div class="row">
        <div class="container" style="background-color: #f7f9fa;">
         
<?php if (!isset($selectedsubject) && isset($subjects_array)) { ?>                
                                <div class="col-sm-12 col-md-12 bro_subject" style="min-height:200px;">

                                        <div class="col-md-12 text-center"><h2>Browse By Subjects</h2>
                                    <?php foreach ($subjects_array as $key => $value) {
                                        if ($value['count'] > 0) {
                                            ?>
                                            <a title="Notes for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
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

                                            <a title="Notes for <?php echo $value['name']; ?>" href="<?php echo base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', TRUE) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-' , TRUE) . '/' . $selectedsubject->id . '/' . url_title($value['name'], '-', TRUE) . '/' . $key) ?>" class="subjectbtn btn btn-primary btn-raised btn-lg" type="button">
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
            <!-- /. PAGE INNER  -->
        </div>
    </div>
</div>
