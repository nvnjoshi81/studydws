<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb'); ?>
            <!--<div class="col-md-3 col-sm-3">
                <?php //$this->load->view('common/leftnav'); ?>
            </div>
            -->
            <div class="col-md-12 col-sm-12">
                 <?php if($isProduct){ 
                  $this->load->view('common/productdetails');
                     } ?>
                <div id="page-inner">
                    <div class="module_panel row">  

                        <!-- content panel start here -->
                        <!-- left panel -->
                        <div class="col-sm-12 col-md-12">
                            <div class="ncert_cont col-sm-12 col-md-6">
                                <?php 
                                $count = 1;
                                foreach ($solutions_array as $key => $value) { ?>
                                    <ul class="nav">
                                        <h3 class="text-success">
                                            <i class="material-icons">update</i>
                                            <a href="<?php echo base_url('books/' . url_title($value['name'], '-', true) . '/' . $key) ?>">
    <?php echo $value['name'] ?> E-Books
                                            </a>
                                        </h3>
    <?php foreach ($value['subjects'] as $k => $v) { ?>
                                            <li>
                                                <a href="<?php echo base_url('books/' . url_title($value['name'], '-', true) . '/' . $key . '/' . url_title($v['name'], '-', true) . '/' . $k) ?>">
                                                    E-Books for <?php echo $value['name'] ?> <?php echo $v['name'] ?>
                                                </a>
                                            </li>
    <?php } ?> 

                                    </ul>
                                    <?php if ($count == round(count($solutions_array) / 2, 0, PHP_ROUND_HALF_EVEN)) {
                                        echo '</div><div class="ncert_cont col-sm-12 col-md-6">';
                                        $count = 1;
                                    } ?>

                                <?php $count++;
                            } ?>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
<?php if ($this->uri->total_segments() == 1) { ?>
<!-- adv rht panel -->
<?php } ?>
                            <!-- Most Viewed 
                            <div class="row">
                            <div class="col-md-12 col-sm-12 mostview">
                            <h2><i class="material-icons">question_answer</i> Most Viewed Question Banks </h2>
                            <table class="table table-striped table-hover ">
                           <tr>
                             <td class="text-primary"><i class="material-icons">wallpaper</i></td>
                             <td>Column headingIf a physical quantity has magnitudeand direction both, then it does not always imply that it is a vector. For itto be a vector the third condition of obeying laws of vector algebra has to besatisfied.</th>
                             <td><a href="#"><i class="material-icons">thumb_up</i> <br />Like</a></td>
                             <td><a href="#"><i class="material-icons">view_module</i> <br />Views</a></td>
                           </tr>
                           </table>
                             
                            </div>
                            </div>-->
                            <!-- Recent Questions -->
                            <div class="row recent_ques"> 
                                    <?php $this->load->view('common/productslist'); ?>
                                <div class="col-sm-12 col-md-12">
                                    <h3><i class="material-icons">folder</i> E-Books</h3>
                                    <?php
                                    if ($books) {
                                        $count = 1;
                                        foreach ($books as $qb) {
                                            if ($count == 10 && $this->uri->total_segments() == 1)
                                                break;
                                            ?>  
                                            <div class="list-group">
                                                <div class="list-group-item">
                                                    <div class="row-action-primary atop">
                                                        <i class="material-icons">folder</i>
                                                    </div>
                                                    <div class="row-content">
                                                        <div class="least-content"><?php echo rand(900, 20000)?> <i class="material-icons">thumb_up</i></div>
                                                        <h4 class="list-group-item-heading">
                                                            <a href="<?php echo generateContentLink('books', $qb->exam, $qb->subject, $qb->chapter, $qb->name, $qb->id); ?>">
        <?php echo $qb->name; ?>
                                                            </a>
                                                        </h4>

                      <!--<p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus.</p>-->

                                                    </div>
                                                </div>
                                                <div class="list-group-separator"></div>
                                            </div>
        <?php
        $count++;
    }
}
?>
                        </div>


                            </div>
                        </div>

                        <!-- right panel -->
                       <!-- <div class="col-sm-12 col-md-3 rht_status_mat">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4> <i class="material-icons">book</i>Statistics</h4>
                                </div>
                                <div class="panel-body">
                                    <ul>
                                        <li><i class="material-icons">&#xE037;</i> <a href="#"><span class="text-warning"><?php echo count($studymaterials); ?></span> Study Material</a> </li>
                                        <li><i class="material-icons">&#xE037;</i><a href="#"> <span class="text-warning"><?php echo count($files); ?></span> Files</a> </li>
                                    </ul>
                                </div>
                           
                            </div>

                            <div class="rightadvertisepanel">
                                <img src="<?php echo base_url(''); ?>/assets/images/150adv.jpg" alt="adversite" />
                            </div>
                        </div> 

                    </div>-->




                </div> 


            </div>
            <!-- /. PAGE INNER  -->
        </div>
    </div>
</div>
</div>