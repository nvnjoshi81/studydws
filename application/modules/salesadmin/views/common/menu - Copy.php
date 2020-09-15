<div id="wrapper">
<nav class="navbar-static-top" role="navigation" style="margin-bottom: 0">
        <!-- Navigation -->
        <?php    $dir_salesadmin=$this->config->item('dir_salesadmin'); ?>
  <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                      <ul class="nav" id="side-menu">
                        <li>
                        <a href="<?php echo base_url().$dir_salesadmin;?>/dashboard"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a> 
                        </li>
                        <li>
                        <a href="<?php echo base_url().$dir_salesadmin;?>/<?php echo 'add_order'?>"><i class="fa fa-bar-chart fa-fw"></i><?php echo 'Create Order';?>
                        </a>
                        </li>
                    </ul>
                </div>
      <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        </div><!---wrapper end--->

