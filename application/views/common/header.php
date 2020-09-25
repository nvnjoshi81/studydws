<!DOCTYPE html>
<html lang="en">
<head>
<!--Google Code-->
<!-- Global site tag (gtag.js) - Google Ads: 634245748 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-634245748"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'AW-634245748');
</script>
<!-- BOLT Sandbox/test Payumoney //-->
<?php 
if($boltpayu=='yes'){ ?>
<script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js" bolt-
color="e34524" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
<?php } ?>
<!--End-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--
orignal <meta name="viewport" content="width=device-width, initial-scale=1">
  this meta viewport is required for BOLT //-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >
    <title><?php echo isset($title)?$title.' - Studyadda.com':'JEE Main, JEE Advanced, CBSE, NEET, IIT, free study packages, test papers, counselling, ask experts - Studyadda.com';?>
  </title>
    <meta name="description" content="<?php echo isset($title)?'Free '.$title:'StudyAdda offers free study packages for AIEEE, IIT-JEE, CAT, CBSE, CMAT, CTET and others. Get sample papers for all India entrance exams.'?>">
    <meta name="keywords" content="IIT, IIT-JEE, IIT-JEE 2011, AIEEE, CBSE BOARD, ICSE BOARD, NEET, Exam Alert, Expert Help, Career Counselling, Latest Educational News, Sample Papers, Test Papers, Study Packages, Projects, Results, Scholarship, Blog, My Community, Dictionary, Calculator, Free Study Packages for All type of Exams, Free IIT-JEE Study Packages, Total Free Study Packages for IIT-JEE, AIEEE Free Study Packages, IIT-JEE Study Packages, Free Study Packages of AIEEE, NEET Study Packages, Free NEET Study Packages, FREE Video Lectures">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" />
    
<meta property="og:title" content="<?php echo isset($title)?$title.' - Studyadda.com':'JEE Main, JEE Advanced, CBSE, NEET, IIT, free study packages, test papers, counselling, ask experts - Studyadda.com';?>" />
<meta property="og:description" content="<?php echo isset($title)?'Free '.$title:'StudyAdda offers free study packages for AIEEE, IIT-JEE, CAT, CBSE, CMAT, CTET and others. Get sample papers for all India entrance exams.'?>" />
<meta property="og:image" content="<?php //echo get_assets('assets/frontend/images/logo_new.png');?>" />
<meta property="og:url" content="<?php echo base_url()?>"/>
<meta property="og:image:type" content="image/jpeg" /> 
<meta property="og:locale" content="en_GB" />
<meta property="og:locale:alternate" content="fr_FR" />
<meta property="og:locale:alternate" content="es_ES" />
<meta property="og:type" content="article" />

<?php $this->load->view('common/header_css'); ?>
    <?php if(isset($styles) && count($styles) > 0){ 
        foreach($styles as $key=>$style){   
    ?>
        <link media="all" type="text/css" rel="stylesheet" href="<?php echo strpos($style,'http') !== false ? $style : base_url().$style;?>">
    <?php } 
    } 
    
    ?>
    <!-- Material Design fonts -->
 
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    [endif]-->
  
    <script>
        var base_url="<?php echo base_url();?>";
    </script>
    
    
    <script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-40859911-1', 'studyadda.com');
ga('send', 'pageview');

</script> 
</head>
<body class="mainwrapper"><!--<h1 style="color: #d73814;">The Site is down as we are performing important server maintenance, during which time the server will be unavailable for approximately 24 hours. Please hold off on any critical actions until we are finished.
 As always your feedback is appreciated.</h1>-->

  <!-- Navigation -->
  <!-- mobile taoggle panel -->
  
  <nav role="navigation" class="navbar mainnav opentoggle">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header togglepanel">
          
      <div class="mob_lft_logo pull-left"><a href="<?php echo  base_url(""); ?>"><img alt="" src="<?php echo get_assets('assets/frontend/images/logo_mob.png');?>" class="img-responsive img-center mainpadding"></a></div>
        <button data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class=" btn-raised navbar-toggle  pull-right mobbut" type="button">
          <span class="sr-only">
            Toggle navigation
          </span>
          <span class="glyphicon glyphicon-th-list"></span>
         <!-- <span class="icon-bar">
          </span>
          <span class="icon-bar">
          </span>
          <span class="icon-bar">
          </span>-->
        </button>
        
        <!-- Cart panel for mobile -->
        <div class="pull-right headercart cartpanel">
            <a class="carttext" href="<?php echo base_url('cart')?>">
            <span class="cart-count">
              <?php echo count($this->cart->contents());?>
            </span>
            <span>
              <img alt="" width="24" height="24" src="<?php echo get_assets('assets/frontend/images/cart.png');?>">
            </span>
            <p class="rs_img">
              <i class="fa fa-rupee">
              </i>
              <label class="cartprice">
                <?php echo $this->cart->total()>0?$this->cart->total():0;?>
              </label>
            </p>
          </a>
          
        </div>
        
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
        <ul class="nav navbar-nav toggle_nav">
          
          <?php foreach($mainexamcategories as $ex){ ?>
              <li>
               <?php echo "<a href='".base_url('exams/'.url_title($ex->name,'-',true).'/'.$ex->id)."' title='{$ex->name}' >{$ex->name}</a>"; ?>
              </li>
              <?php } ?>
              <?php foreach($this->config->item('toplinks') as $k=>$v){ if($k != 'Exams'){?>
              <li>
                  <a href="<?php echo base_url($v);?>" title="<?php echo $k;?> - studyadda.com">
                        <?php echo $k;?>
                </a>
              </li>
              <?php }} ?>
          
        </ul>
          
      </div>
      <!-- /.navbar-collapse -->
    </div>
      <!-- mobile user profile  -->
  <?php if($this->session->userdata('customer_id')){ ?>
  <div class="mobileuser">
    <ul class="nav navbar-nav">
                    <li class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle welcome" href="#">
                        <span class="glyphicon glyphicon-user">
                      </span>
                      &nbsp;
                      <strong>
                        <?php echo $this->session->userdata('customer_name');?>
                      </strong>
                      <span class="glyphicon glyphicon-chevron-down">
                      </span>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <div class="navbar-login">
                        <div class="row">
                         
                          <div class="col-lg-12">
                            <p class="text-left">
                              <strong>
                                  <a  title="Studyadda-My Account" href="<?php echo base_url(); ?>user/myaccount">My Profile</a>
                  
                  <a  title="Studyadda-My Library" href="<?php echo base_url(); ?>user/orders" >My Order</a>
                  
                              </strong>
                           <a  title="Studyadda-My Library" href="<?php echo base_url(); ?>user/library" >My Library</a></p><p>
                                <a  title="Studyadda-Logout" class="btn btn-warning btn-raised btn-block btn-xs btn-md btn-sm" href="<?php echo base_url('user/logout');?>">
                                Logout
                              </a>
                   <a title="Android Application" class="btn btn-sm btn-warning btn-raised mob_btn" title="Studyadda App" href="https://play.google.com/store/apps/details?id=com.studyaddaapp&pageId=none&rdid=com.studyaddaapp&pli=1"><i class="material-icons">android</i>Android Application</a>
                            </p>
                             </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                  </li>
                 </ul>
  </div>
  <?php }else{ ?>
    <!-- after login panel -->
        <div class="login_panel_mob">
        <a class="btn-xs btn btn-primary btn-raised  btn-sm" href="<?php echo base_url('login');?>" title="Studyadda-Login">
        Login
        </a>
        <a class="btn-xs btn btn-success btn-raised btn-sm" href="<?php echo base_url('login');?>" title="Studyadda-SignUp">
        Sign Up
        </a> 
        <a title="Featured Videos" class="btn btn-sm btn-warning btn-raised mob_btn" href="<?php echo base_url('featured-videos');?>">Demo Videos</a>     
      
	  <a style="" title="Android Application" class="btn btn-sm btn-warning btn-raised mob_btn" title="Studyadda App" href="https://play.google.com/store/apps/details?id=com.studyaddaapp&pageId=none&rdid=com.studyaddaapp&pli=1">
		  <i class="material-icons" style="font-size:12px;">android</i>
		  Android Application
	  </a>         
	  
      <a style="" title="Purchase Courses" class="btn btn-sm btn-primary btn-raised mob_btn" href="<?php echo base_url('purchase-courses');?>"><i class="material-icons" style="font-size:12px;">shopping_cart</i>Purchase Courses&nbsp;&nbsp;</a> </div>
        <?php } ?>
    <!-- /.container -->
  </nav>
  <!-- Navigation -->
  <nav class="navbar topnav" role="navigation">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
       <!-- <div class="topcontact col-lg-3 col-md-3 col-sm-2 col-xs-12">
              <a href="mailto:info@studyadda.com" title="info@studyadda.com">
            <i class="fa fa-envelope-square fa-2">: info@studyadda.com 
            </i>&nbsp;&nbsp;&nbsp;<i style="float:right" class="fa fa-share-alt fa-2 hidden-xs">: SHARE ON
            </i>
              </a>
        </div>
    <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 hidden-xs" style="float:left"> 
    //AddToAny BEGIN
    <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
<a class="a2a_button_facebook">&nbsp;&nbsp;</a>
<a class="a2a_button_whatsapp">&nbsp;&nbsp;</a>
<a class="a2a_button_twitter">&nbsp;&nbsp;</a>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
// AddToAny END 
</div>
-->
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 hidden-xs" style="color:black;">

  <a target="_blank" title="Studyadda App" href="https://play.google.com/store/apps/details?id=com.studyaddaapp&pageId=none&rdid=com.studyaddaapp&pli=1">
    <button class="btn-xs btn-raised btn-success"><i class="material-icons">android</i> Android Application </button>
  </a>
      
       <!--  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 hidden-xs" style="float:center" > -->                
                  <!--<a target="_blank" title="Purchase Courses" href="<?php echo base_url('purchase-courses') ?>"><button class="btn-xs btn-raised btn-warning"><i class="material-icons">shopping_cart</i>Purchase Courses</button></a>
          -->
            <!--</div>-->
      
  <a target="_blank" title="Demo Videos" href="<?php echo base_url('featured-videos'); ?>">
    <button class="btn-xs btn-raised btn-primary"><i class="material-icons">video_library</i>Demo Videos</button>
  </a>

</div>  

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 hidden-xs" style="float:center">             
              <div class="hidden-xs col-xs-12 col-sm-6 col-lg-6 col-md-6 nopadding">                
                  <!-- login and signup -->
                  <?php if($this->session->userdata('customer_id')){ ?> <div class="pull-right">
                    <a title="Studyadda-My Library" href="<?php echo base_url(); ?>user/library"><i class="material-icons">person</i><strong><?php echo $this->session->userdata('customer_name');?></strong>
                    </a>        
                  </div>
                  <!--
                  <ul class="nav navbar-nav navbar-right notoggle">
                    <li class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle welcome" href="#">
                        <span class="glyphicon glyphicon-user">
                      </span>
                      &nbsp;
                      <strong>
                      <?php echo $this->session->userdata('customer_name');?>
                      </strong>
                      <span class="glyphicon glyphicon-chevron-down">
                      </span>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <div class="navbar-login">
                        <div class="row">
                          <div class="col-lg-4">
                            <p class="text-center">
                              <span class="glyphicon glyphicon-user icon-size">
                              </span>
                            </p>
                          </div>
                          <div class="col-lg-8">
                            <p class="text-left">
                              <strong>
                                  <a href="<?php echo base_url(); ?>user/myaccount" title="My Account"><?php echo $this->session->userdata('customer_fullname');?></a>
                              </strong>
                            </p>
                            <p class="text-left"><a  title="Studyadda-My Library" href="<?php echo base_url(); ?>user/library">My library</a>
                            </p>  
                            
                            <p class="text-left"><a  title="Studyadda-My Library" href="<?php echo base_url(); ?>user/library">My library</a>
                            </p>  
                            <p>
                            <a  title="Studyadda-Logout" class="btn btn-warning btn-raised btn-block btn-xs btn-md btn-sm" href="<?php echo base_url('user/logout');?>">
                                Logout
                            </a>
                            </p>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                  </li>
                  </ul>-->
                  
                  <?php }else{ ?>
                  <!-- after login panel -->
                  <div class="pull-right">
                      <a  title="My Studyadda Account" href="<?php echo base_url('login');?>"><i class="material-icons">person</i>My Account
                  </a>                  
                  </div>
                  <?php } ?>
              </div>
              <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6 cartitems">
                <div class="pull-right headercart mobpanel">                  
                  <a class="carttext" href="<?php echo base_url('cart')?>">
                  <i class="fa fa-shopping-cart">
                  </i>
                  &nbsp;
                      <span class="cart-count"><?php echo count($this->cart->contents());?></span> Items - 
                    <i class="fa fa-rupee">
                    </i>
                      <span class="cartprice"><?php echo $this->cart->total()>0?$this->cart->total():0;?></span>
                  </a>
                </div>
              </div>
          </div>
</div>

      
      <!--<div class="collapse navbar-collapse nopadding" style="font-size:13px">
         <ul class="toplinks">
            <?php $tp_link=1; foreach($this->config->item('toplinks') as $k=>$v){ if($k != 'Exams'){ ?>
            <?php
            if($tp_link==2){
            ?>  
              <li>
                  <a style="color:#0b4905" href="<?php echo base_url($v);?>" title="<?php echo $k;?> - studyadda.com">
                        <?php echo $k;?>
                </a>
              </li>
            <?php
                
            }else{
            ?>
            <li>
            <a style="color:#0b4905" href="<?php echo base_url($v)?>" title="Studyadda <?php echo $k; ?>">
                        <?php //echo 'Test Series';?><?php echo $k;?>
            </a>
            </li>
            <?php   
            }
            $tp_link++;
            
            } }?>
              
           <li><a href="<?php echo base_url('amazing-facts')?>" title="Studyadda-amazing-facts">
            Amazing Facts
            </a>
            </li>
          
                
<li>
<a href=""  title="News- ">
News
</a>
</li>
<li>
<a href=""  title="Institutes - ">
Institutes
</a>
</li>

              </ul>
          </div>-->
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container -->
  </nav>
  <header class="wow slideInDown" data-wow-duration="1s" data-wow-delay="0s">
    <!-- Header Carousel -->
    <div class="container header-top_box">    
      <div class="col-lg-2 col-md-2 nopadding mob_no">
        <a href="<?php echo base_url();?>">
          <img alt="" width="134" height="74" src="<?php echo get_assets('assets/frontend/images/logo_new.png');?>" class="img-responsive img-center mainpadding">
        </a>
      </div>
      <div class="col-lg-4 col-md-4 mainpadding searchpanel">
          <?php 
          $showSearchTop='yes';
          if($showSearchTop=='yes'){?>
        <div class="col-lg-12">
<form name="mainsearch" id="mainsearch" action="<?php echo base_url('search')?>"  >
          <div class="input-group">
            <div class="form-group label-floating is-empty">
<label class="control-label" for="focusedInput1" >
Search.....
</label>                <input name="search_txt" id="search_txt" class="form-control" type="text">
                        <span class="material-input">
                        </span>
                      </div>
                      <span class="input-group-btn">
                          <button class=" btn-md btn btn-success btn-raised btn-lg searchgo" type="submit">
                          Go!
                        </button>
                      </span>
                  </div>
                  <ul class="nav nav-pills searchoptions">
                    <li class="radio">
                      <label>
                          <input type="radio" value="all" name="search" checked="">
                          
                          All
                        </label>
                        
                       </li>
                       <li class="radio">
                         <label>
                           <input type="radio" value="videos" name="search">
                           
                           Videos 
                           </label>
                         </li>
                         <li class="radio">
                           <label>
                             <input type="radio" value="study-packages" name="search">
                             
                             Study Packages 
                             </label>
                           </li>
                           <li class="radio">
                             <label>
                               <input type="radio" value="ncert-solution" name="search">
                               
                               NCERT Solutions 
                               </label>
                             </li>
                             <li class="radio">
                               <label>
                                 <input type="radio" value="question-bank" name="search">
                                 Questions 
                                 </label>
                               </li>
                               <li class="radio">
                                 <label>
                                   <input type="radio" value="sample-papers" name="search">
                                   Sample Papers 
                                   </label>
                                 </li>
                                 <li class="radio">
                                   <label>
                                     <input type="radio" value="notes" name="search"/>
                                     Notes
                                     </label>
                                    
                                   </li>
                                  <!-- <li class="radio">
                                     <label>
                                       <input type="radio"  value="onlinetests" name="search">
                                       
                                       Online Test 
                                     </li>-->
                       </ul>  </form>
              </div>
    
          <?php } ?>
          </div>


           <div class="col-xs-12 col-sm-12 col-lg-offset-3 col-lg-3 col-md-3 mainpadding  hidden-xs text-center">
     <a class="pur_course" target="_blank" title="Purchase Courses" href="<?php echo base_url('purchase-courses') ?>">
     <img  style="margin-top:2px;" src="<?php echo base_url('/assets/images/discount.png')?>"></a>
     </div>    
      </div>
      <nav role="navigation" class="navbar mainnav notoggle navbar-full">
        <div class="container">      
          <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
           <div class="col-md-12 col-md-12 col-sm-12 col-xs-6 wow slideInLeft" data-wow-delay="500ms"><ul class="nav navbar-nav toggle_nav">
              <?php $exam_cnt=1;
              $ts_lable_array=array('btn-default','btn-primary','btn-success','btn-info','btn-warning','btn-danger');
              foreach($mainexamcategories as $ex){ 
              if($ex->id!=80){       
              $ts_rand=rand(0,5);
              //if($ex->id<39){ 
              ?>
              <li style="padding:1px">
               <?php 
    echo "<a href='".base_url('exams/'.url_title($ex->name,'-',true).'/'.$ex->id)."'>".trim(str_replace('Class','',$ex->name))."</a>"; ?>
              </li>
              <?php
          
       if($ex->id=='110'){
         ?><br><?php
       }
              $exam_cnt++;
             // }
              }
              } ?>  
               </ul></div>
          </div>          
          </div>         
      </nav>
    <div id="msg_waiting" 
    style="display: none;  
    position:absolute;
    width:592px;
    height:512px; 
    left:99%; 
    top:70%;
    margin-left:-296px; 
    margin-top:-256px;">
        <span class="msg-gif">
        <img src="<?php echo base_url('assets/frontend/images/msg-gif.GIF') ?>" alt="spinner"/>
        </span>
     </div>
    <link rel="stylesheet" type="text/css" href="<?php echo get_assets('assets/css/effect.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_assets('assets/frontend/css/shape-oppo.css');?>">
     <link rel="stylesheet" type="text/css" href="<?php echo get_assets('assets/css/animate.css');?>">
  </header>  