<div id="wrapper">
<nav class="navbar-static-top" role="navigation" style="margin-bottom: 0">
        <!-- Navigation -->
        
  <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                      <ul class="nav" id="side-menu">
                        <!--
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div> 
                        </li>
                        -->
                        <li>
                           <a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a> 
                        </li>
                        <?php foreach($menuitems as $item){ ?>
                        <?php if($this->session->userdata('usertype') == 1 || in_array($item->id, $this->session->userdata('loggedinmodperms'))){?>
                        <li>
                            <a href="<?php echo base_url();?>admin/<?php echo $item->slug?>"><i class="fa <?php echo $item->icon?> fa-fw"></i> <?php echo $item->title;?></a>
                        </li>
                        <?php 
                        }
                        } 
                        ?>
						<li>
                        <a href="<?php echo base_url();?>admin/listings/current_affairs"><i class="fa fa-list-alt fa-fw"></i>Current Affairs</a>
                        </li>
                        <li>
                           <a href="<?php echo base_url();?>admin/media"><i class="fa fa-image fa-fw"></i>Media</a> 
                        </li>
						<li>
                           <a href="<?php echo base_url();?>admin/notification"><i class="fa fa-image fa-fw"></i>Notification</a> 
                        </li>
                        <li>
                           <a href="<?php echo base_url();?>admin/email_promotion"><i class="fa fa-image fa-fw"></i>Email Promotion</a> 
                        </li>
                        <li>
                           <a href="<?php echo base_url();?>admin/orders/test_series"><i class="fa fa-image fa-fw"></i>Test Series</a> 
                        </li>
                        <li>
                           <a href="<?php echo base_url();?>admin/olexam_category/index"><i class="fa fa-image fa-fw"></i>Test Series Category</a> 
                        </li>        <li>
                           <a href="<?php echo base_url();?>admin/contents/sortlist"><i class="fa fa-image fa-fw"></i>Chapter Sorting</a> 
                        </li>
                        
                       <!--   <li>
                          <a href="<?php echo base_url();?>admin/user"><i class="fa fa-user fa-fw"></i> Users<span class="fa arrow"></span></a>-->
                            <!--<ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.html">Morris.js Charts</a>
                                </li>
                            </ul>-->
                            <!-- /.nav-second-level 
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>admin/categories"><i class="fa fa-tags fa-fw"></i>Manage Categories</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>admin/listings"><i class="fa fa-list-alt fa-fw"></i>Manage Listings</a>
                        </li>
                         <li>
                            <a href="<?php echo base_url();?>admin/content"><i class="fa fa-cogs fa-fw"></i> Manage Content Type</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>admin/subjects"><i class="fa fa-folder-open fa-fw"></i>Manage Subjects</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>admin/chapters"><i class="fa fa-book fa-fw"></i>Manage Chapters</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>admin/topics"><i class="fa fa-file fa-fw"></i>Manage Topics</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>admin/users"><i class="fa fa-users fa-fw"></i>Manage Users</a>
                        </li>-->
                    </ul>
                </div>
      

<div class="sidebar-nav navbar-collapse">
<ul class="nav">
    <li class="sidebar-search">Type -> 1  FOR Very Short</li>
    <li class="sidebar-search">Type -> 2  FOR Short</li>
    <li class="sidebar-search">Type -> 3  FOR Long</li>
    <li class="sidebar-search">Type -> 5  FOR Multiple Choice</li> 
    <li class="sidebar-search">Type -> 6  FOR Single Choice</li> 
    <li class="sidebar-search">Type -> 10 FOR Fill in the blanks</li> 
    <li class="sidebar-search">Type -> 11 FOR Match the column</li>
    <li class="sidebar-search">Type -> 12 FOR Exempler</li>
    <li class="sidebar-search">Type -> 13 FOR Value Based</li>
	<li class="sidebar-search">Type -> 14 FOR Grid Single Choice</li>
	<li class="sidebar-search">Type -> 15 FOR Grid Multiple Choice</li>
	<li class="sidebar-search"><a href="<?php echo base_url('upload_files/onlinetest_demo.zip');?>">Download Demo Zip</a><br><a href="<?php echo base_url('upload_files/onlinetest_demo.docx');?>">Download Demo DOC</a></li>
</ul>
</div>

<div class="sidebar-nav navbar-collapse">
<ul class="nav">
    <li class="sidebar-search">Module Info</li>
    <li class="sidebar-search">"8"->Article</li>
    <li class="sidebar-search">"4"->Books</li>
    <li class="sidebar-search">"9"->Ncert Solution</li>
    <li class="sidebar-search">"5"->Notes</li>
    <li class="sidebar-search">"3"->Online Tests</li>
    <li class="sidebar-search">"7"->Question Bank</li>
    <li class="sidebar-search">"6"->Sample Papers</li>
    <li class="sidebar-search">"10"->Solved Papers</li>
    <li class="sidebar-search">"1"->Study Material</li>
    <li class="sidebar-search">"2"->Videos</li>
</ul>
</div>



                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        </div><!---wrapper end--->

