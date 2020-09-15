<!DOCTYPE html>
<html lang="en">
<head>
<!--https://github.com/creativetimofficial/material-dashboard-->
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/images/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Franchise Admin Studyadda</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--Fonts and icons-->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="<?php echo base_url(); ?>/assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo base_url(); ?>/assets/css/demo_salse.css" rel="stylesheet" />
  <?php    $dir_salesadmin=$this->config->item('dir_salesadmin'); ?>
  </head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="<?php echo base_url(); ?>assets/images/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo">
        <a href="http://www.studyadda.com" class="simple-text logo-normal">
        <img alt="" src="<?php echo base_url(); ?>/assets/frontend/images/logo_new.png" class="img-responsive img-center mainpadding" width="134" height="74">
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="<?php echo base_url().$dir_salesadmin;?>/dashboard" >
              <i class="material-icons">dashboard</i>
              <p>Franchise Dashboard</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?php echo base_url().$dir_salesadmin;?>/<?php echo 'Add_Student'?>">
              <i class="material-icons">person</i>
              <p>Create Student</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?php echo base_url().$dir_salesadmin;?>/<?php echo 'Add_Order'?>">
              <i class="material-icons">add_shopping_cart</i>
              <p>Create Order</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?php echo base_url().$dir_salesadmin;?>/Add_Order/orderlist">
              <i class="material-icons">content_paste</i>
              <p>Order List</p>
            </a>
          </li>
		  <li class="nav-item ">
            <a class="nav-link" target="_blank" href="<?php echo base_url('purchase-courses/'.url_title($this->session->userdata('company')).'/'.$this->session->userdata('userid'));?>">
              <i class="material-icons">link</i>
              <p>Promo Link</p>
            </a>
          </li>
		  
		  <!--
          <li class="nav-item ">
            <a class="nav-link" href="./all_material.html">
              <i class="material-icons">library_books</i>
              <p>All Material</p>
            </a>
          </li>-->
        <!--
		<li class="nav-item ">
            <a class="nav-link" href="./map.html">
              <i class="material-icons">location_ons</i>
              <p>Maps</p>
            </a>
        </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?php echo base_url().$dir_salesadmin;?>/notifications">
              <i class="material-icons">notifications</i>
              <p>Notifications</p>
            </a>
          </li>-->
        </ul>
      </div>
    </div>
	  <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#"> <?php  echo "Welcome ".  $this->session->userdata('first_name').'&nbsp;'. $this->session->userdata('last_name');?></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <!--<form class="navbar-form">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form> -->
			
			
            <ul class="navbar-nav">
			<!--
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">
                    Stats
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="<?php echo base_url(); ?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <span class="notification">5</span>
                  <p class="d-lg-none d-md-block">
                    Some Actions
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Mike John responded to your email</a>
                  <a class="dropdown-item" href="#">You have 5 new tasks</a>
                  <a class="dropdown-item" href="#">You're now friend with Andrew</a>
                  <a class="dropdown-item" href="#">Another Notification</a>
                  <a class="dropdown-item" href="#">Another One</a>
                </div>
              </li>-->    
			  
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="<?php echo base_url().$dir_salesadmin;?>/<?php echo 'dashboard/myprofile'?>">Profile</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?php echo base_url().$dir_salesadmin;?>/<?php echo 'logout'?>">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
	  
	  <script>
        var base_url="<?php echo base_url();?>";
    </script>
      <!-- End Navbar -->
<?php 
/*
	  ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	*/
	?>