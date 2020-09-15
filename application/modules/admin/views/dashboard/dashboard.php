
        <!-- middle content-start -->
        
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
                    
                    <?php if($this->session->flashdata('update_msg')){ ?>
			<div class="alert alert-success alert-dismissible" id="success-alert" role="alert">
			  
			  <strong><?php echo $this->session->flashdata('update_msg'); ?></strong>
			</div>
			<?php } ?>
            </div>
            <!-- /.row -->
            <div class="row">
           
           
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $orders?></div>
                                    <div>Last 7 days orders</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url(); ?>admin/orders">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $customers;?></div>
                                    <div>Users Today !</div>
                                </div>
                            </div>
                        </div>
                           <a href="<?php echo base_url(); ?>admin/customers">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-youtube-play fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $whistory;?></div>
                                    <div>Watch History!</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url('admin/history/1')?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-download fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $downloads?></div>
                                    <div>Downloads !</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url('admin/history/2')?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div> 
                <!--<div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-rupee fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php //echo moneyFormatIndia($earnings);?></div>
                                    <div>Total Sales !</div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>-->
            </div>

                         <!-- <div class="panel-footer">
                           <div class="input-group">
                                <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                                <span class="input-group-btn">
                                    <button class="btn btn-warning btn-sm" id="btn-chat">
                                        Send
                                    </button>
                                </span>
                            </div> 
                        </div> -->
                        <!-- /.panel-footer -->
                    </div>
                    <!-- /.panel .chat-panel -->
                



        <!---middle-content---End-->