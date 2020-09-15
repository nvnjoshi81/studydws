<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php if ($this->session->flashdata('update_msg')) { ?>
                <div class="alert alert-success alert-dismissible" id="success-alert" role="alert">

                    <strong><?php echo $this->session->flashdata('update_msg'); ?></strong>
                </div>
            <?php } ?>
            <?php $this->load->view('customer/breadcrumb'); ?>
            <div class="col-md-3 col-sm-3 my_account"> 

                <?php $this->load->view('customer/menu'); ?>
            </div>
            <div class="col-sm-9 my_account_right">
                <div class="my-account"><div class="dashboard">

                        <div class="subline-title">
                            <h4>Recent Tests</h4>
                        </div>

                        <?php if ($usertests) { ?>
                            <div data-example-id="togglable-tabs" class="bs-example bs-example-tabs">

                                <div class="tab-content" id="myTabContent">
                                    <div aria-labelledby="home-tab" id="home" class="tab-pane fade in active" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Title</th>
                                                        <th>Score</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $cc = 1;
                                                    //print_r($usertests);
                                                    foreach ($usertests as $test) { ?>
                                                        <tr>
                                                            <td><?php echo $cc; ?></td>
                                                            <td><?php echo $test->name; ?></td>
                                                            <td><?php echo $test->obtain_marks ;  ?>/<?php echo $test->total_marks; ?></td>
                                                            <td><?php echo formatDate($test->dt_created); ?></td>
                                                            <td>
                                                                
                                                                <?php if($test->status==1){
                                                                    echo "Completed";
                                                                }else{
                                                                     echo "InCompleted";
                                                                }  ?></td>



                                                            <td><a href="<?php echo base_url('online-test/result/'.$test->id); ?>" target="_blank" ><i class="fa fa-external-link-square" aria-hidden="true"></i></a></td>
                                                        </tr>
    <?php $cc++;  } ?> 
        
                                                        <tr><td colspan="6"><?php echo '<div class="pagination" align="center">'.$this->pagination->create_links().'</div>'; ?>
                                                            </td></tr>
                                                        
                                                        
                                                </tbody>
                                            </table>
                                        </div>
    <?php echo '<div class="pagination" align="center"></div>'; ?>
                                    </div>



                                </div>
                            </div>
                        <?php
                        } else {
                            echo "<b>You had not attempted  any online test.<br> Click <a href='" . base_url('online-test') . "'>here</a> to test your skills.</b>";
                        }
                        ?>


                    </div></div>	</div>
        </div>

    </div>
</div>