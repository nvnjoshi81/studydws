

<ul>
    <?php if($this->session->userdata('customer_id')){ ?>
    <li> <a href="<?php echo base_url('customer/account');?>">My Account</a></li>
    <li> <a href="<?php echo base_url('customer/logout');?>">Logout</a></li>
    <?php }else{ ?>
    <li> <a href="<?php echo base_url('login');?>">Login</a></li>
    <li> <a href="<?php echo base_url('signup');?>">Sign Up</a></li>
    <?php } ?>
    
    <li>
        <a href="<?php echo base_url('cart')?>"><?php echo count($this->cart->contents());?> Items in cart  (Rs. <?php echo $this->cart->total()>0?$this->cart->total():0;?>)</a>
    </li>
</ul>
<ul>
<?php 
foreach($mainexamcategories as $ex){
    echo "<li><a href='".base_url('exams/'.clean($ex->name).'/'.$ex->id)."'>{$ex->name}</a></li>";
}
?>
</ul>
<html>
<head>
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta content="text/html; charset=utf-8" http-equiv="content-type">
<title>Latest Articles and information on JEE Main,Advanced,NEET</title>
<meta content="To know about Latest news and information on JEE Main, JEE Advanced, NEET  always be in touch of studyadda.com" name="description">
<meta content="To know about Latest news and information on JEE Main, JEE Advanced, NEET  always be in touch of studyadda.com" name="keywords">


<meta content="width=device-width, target-densityDpi=device-dpi" name="viewport">
<link href="<?php echo $this->config->item('web_root');?>favicon.ico" rel="shortcut icon">
<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="<?php echo $this->config->item('web_root');?>study_css/bootstrap.min.css">
<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!--    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 <![endif]-->
 
 
 <link media="all" type="text/css" rel="stylesheet" href="<?php echo $this->config->item('web_root');?>study_css/ci_stylegi.css">
<!-- Css Files Start -->
<link type="text/css" href="<?php echo $this->config->item('web_root');?>study_css/style.css" rel="stylesheet">
<!--<link  rel="stylesheet" href="bs.css" type="text/css" />-->
<!-- Bootstrap Css -->
<link href="<?php echo $this->config->item('web_root');?>study_css/main-slider.css" type="text/css" rel="stylesheet">
<!-- Main Slider Css -->
<!--[if lte IE 10]><link rel="stylesheet" type="text/css" href="css/customIE.css" /><![endif]-->
<link type="text/css" href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">
<!-- Font Awesome Css -->
<link type="text/css" href="<?php echo $this->config->item('web_root');?>study_css/font-awesome-ie7.css" rel="stylesheet">
<!-- Booklet Css -->
<link media="screen, projection, tv" type="text/css" href="<?php echo $this->config->item('web_root');?>study_css/jquery.booklet.latest.css" rel="stylesheet">

<noscript>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('web_root');?>study_css/noJS.css"/>
</noscript>


<link media="all" type="text/css" rel="stylesheet" href="<?php echo $this->config->item('web_root');?>style/jquery-ui-1.8.18.custom.css"><!--
<link href="<?php echo $this->config->item('web_root');?>style/studyadda.reset.css" rel="stylesheet" type="text/css" media="all" />-->
<link media="all" type="text/css" rel="stylesheet" href="<?php echo $this->config->item('web_root');?>style/studyadda.core.css">
<link media="all" type="text/css" rel="stylesheet" href="<?php echo $this->config->item('web_root');?>style/studyadda.home.css">

 
<link media="all" type="text/css" rel="stylesheet" href="<?php echo $this->config->item('web_root');?>style/studyadda.course.css">
<!--<link rel="stylesheet" href="style/jquery.scrollbars.css">-->
<link href="<?php echo $this->config->item('web_root');?>study_css/style_scrol.css" rel="stylesheet">

<link href="<?php echo $this->config->item('web_root');?>study_css/amazon_style.css" rel="stylesheet">
<!-- custom scrollbar stylesheet -->
<link href="<?php echo $this->config->item('web_root');?>study_css/jquery.mCustomScrollbar.css" rel="stylesheet">
<!-- second header -->
<!--<link href="style/jquery.bxslider.css" rel="stylesheet" type="text/css" media="all" /> -->

<link href="<?php echo $this->config->item('web_root');?>study_css/style_infinite.css" type="text/css" rel="stylesheet">
<?php if(isset($styles) && count($styles) > 0){ 
    foreach($styles as $key=>$style){   
?>
<link media="all" type="text/css" rel="stylesheet" href="<?php echo strpos($style,'http') !== false ? $style : $this->config->item('web_root').$style;?>">
<?php } } ?>
<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
<!-- 
 <link href="/studymaterial/style/studyadda.exam.css" rel="stylesheet" type="text/css" media="all" />
<link href="/studymaterial/style/studyadda.video.css" rel="stylesheet" type="text/css" media="all" />
<link href="/articles/style_inline.css" rel="stylesheet" type="text/css" media="all" />-->
  
 
</head>
<body>
<section class="container-fluid marginlftrhtnone">
<div class="toponlinegif ">
  <figure class="logonew"><a title="studyadda.com" target="_blank" href="<?php echo $this->config->item('web_root');?>online-test"><img alt="" class="img-responsive" src="<?php echo $this->config->item('web_root');?>study_images/G1.gif"></a></figure>
</div>
<div class="butnowpanel "> <a target="_blank" title="Video Lectures" href="<?php echo $this->config->item('web_root');?>videos/buy_now.php"> Buy <br>
  Now </a> </div>
<header class="mainheaderpanel">
  <div class="head_top">
    <div class="container">
      <div class="row"> 
        <!--<section class="col-md-12 col-sm-12 col-md-3 col-lg-3">
<ul class="top-nav">
  <li><a href="" class="active" >Home</a></li>
</ul>
</section>-->
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 smallscreen">
          <div class="call-us top-bar-block"> <span> [ +91 9179031042 ] </span> <span> [  info@studyadda.com ] </span> </div>
        </div>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 bigscreen">
          <div class="call-us top-bar-block"> <i class="icon-phone"></i> <span> [ Call us at : +91 9179031042 ] </span> </div>
          <div class="mail-us top-bar-block"> <i class="icon-email"></i> <span> [  E-mail: info@studyadda.com ] </span> </div>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
          <div class="head_top_link pull-right">
              <ul>
             <?php 
if(isset($_SESSION['user_id'])){

$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
              <li>Welcome! <span>[ <a title="Community- Studyadda.com" href="<?php echo $this->config->item('web_root').'shop/study_edit_profile' ; ?>" target="_blank"><?php echo $_SESSION['user_name'];  ?> </a> ]</span></li>
<li><a href="<?php echo $this->config->item('web_root').'logout' ; ?>?url=<?php echo $url;?>" title="Logout -Studyadda.com">Logout</a></li>
              <li>|</li>
              <?php }else{ ?>
              <li>Welcome <span>Guest !</span> <a href="#"  data-toggle="modal" data-target="#myModal" title="Login- Studyadda.com"  id="header_quick_login">Login</a></li>
              <li>|</li>
              <?php //echo WEB_URL_WITH_HTTP.FILENAME_REGISTRATION ; ?>
              <li><a title="Sign Up- Studyadda.com" href="#" data-toggle="modal" data-target="#myModal" id="header_quick_signup" >Sign Up</a> </li>
              <?php } 
			  
	      if(isset($_SESSION['user_id'])){?>
              <li><a href="<?php echo $this->config->item('web_root').'shop/user_home';?>">My Account</a></li>
              <li>|</li>
              <li><a  href="<?php echo $this->config->item('web_root').'online-test'.'/online_result.php'; ?>">Online Exam Results
              </a></li>
              <li>|</li>
<?php
if(isset($otpConfirmed) && $otpConfirmed=='no'){ ?>
               <li>
<a href="#" data-toggle="modal" data-target="#myModal_otp" title="Mobile Number Verification- studyadda.com" id="mobile_otp">
 Mobile Verification
</a></li> <li>|</li>
  <?php } ?>            
              <li><a href="<?php echo $this->config->item('web_root').'shop';?>">My Cart</a></li>
              <?php } ?>
              </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  
  <!-- End Top Nav Bar -->
  <div class="topsecond">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
          <figure class="logonew"><a title="studyadda.com" href="<?php echo $this->config->item('web_root');?>"><img alt="" src="<?php echo $this->config->item('web_root');?>study_images/logo_new.png"></a></figure>
          <input type="hidden" value="index.php">
        </div>
        <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7 searchfrm">
          <form method="get" action="<?php echo $this->config->item('web_root');?>search" id="searchform">
            <input type="text" placeholder="Search At Studyadda" id="search" name="q" autocomplete="off" title="" class="form-control" value="">
            <button class="btn btn-success" id="searchsubmit" type="submit" title="Search">SEARCH</button>   
            <div class="checkboxpanel"> 
                        <ul>
            <li><span>
              <input type="radio" checked="checked" value="all" name="search_type">
              </span>All
              </li>
              <li><span>
              <input type="radio" value="video" name="search_type">
              </span> Video
              </li>
				
               <li>
               <span>
              <input type="radio" value="study_package" name="search_type">
              </span> Study Package
              </li>
              <li>
              <span>
              <input type="radio" value="board_study_package" name="search_type">
              </span> Board Package
              </li>
              <li>
              <span>
              <input type="radio" value="expert_question" name="search_type">
              </span> Expert Question
              </li>
              <li>
              <span>
              <input type="radio" value="blog" name="search_type">
              </span> Blog
              </li>
              
              <li>
              <span>
              <input type="radio" value="articles" name="search_type">
              </span> Articles
              </li>
              
              <li>
              <span>
              <input type="radio" value="news" name="search_type">
              </span> News
              </li>
              </ul>
              </div>
           </form>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
        <?php $this->load->view('common/minicart');?>
        </div>
        <div class="clearfix"></div>
        <section class="col-md-12 col-sm-12 col-md-9 col-lg-9 col-md-push-3 head_search_panel ">
          <div class="row"> 
            <!--<div class="col-md-12 col-sm-12 col-md-5 col-lg-5">
            <div class="g-plusone" data-annotation="inline" data-width="100%"></div>
            Place this tag after the last plusone tag 
            <script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
          </div>-->
            <div class="col-md-12 col-sm-12 col-md-12 col-lg-7">
              <iframe frameborder="0" style="border:none; width:100%; height:25px; float:right; text-align:right; " scrolling="no" src="http://www.facebook.com/plugins/like.php?href=http://www.facebook.com/studyaddahome"></iframe>
            </div>
            <!-- </div --> 
          </div>
        </section>
      </div>
    </div>
  </div>
</header>
<section class="mainnavhd">
  <nav class="navbar-default navbar-static-top" id="nav" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li title=""><a title="Home- studyadda.com" href="<?php echo $this->config->item('web_root');?>">Home</a></li>
          <!--
            <li><a href="<?php echo $this->config->item('web_root');?>books/"  title="Books - studyadda.com" >Books</a></li>-->
          <li> <a title="Videos - studyadda.com" href="<?php echo $this->config->item('web_root');?>videos/">Videos</a> </li>
          <!--class="dropdown-toggle"-->
          <li class="dropdown yamm-fullwidth"> <a data-toggle="dropdown" href="<?php echo $this->config->item('web_root');?>studymaterial" aria-expanded="false">Study Material<b class="caret"></b> </a>
            <ul class="dropdown-menu row container widhtcont">
                            <li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a href="<?php echo $this->config->item('web_root');?>study-material/10th-cbse/5" title="10th CBSE- studyadda.com">10th CBSE</a></li>
                            <li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a href="<?php echo $this->config->item('web_root');?>study-material/9th-cbse/15" title="9th CBSE- studyadda.com">9th CBSE</a></li>
                            <li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a href="<?php echo $this->config->item('web_root');?>study-material/aipmt/3" title="NEET- studyadda.com">NEET</a></li>
                            <li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a href="<?php echo $this->config->item('web_root');?>study-material/jee-main/59" title="JEE Main- studyadda.com">JEE Main</a></li>
                            <li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a href="<?php echo $this->config->item('web_root');?>study-material/jee-main-advanced/1" title="JEE Main &amp; Advanced- studyadda.com">JEE Main &amp; Advanced</a></li>
                            <li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a href="<?php echo $this->config->item('web_root');?>study-material/ncert-textbooks/11" title="NCERT Textbooks- studyadda.com">NCERT Textbooks</a></li>
                          </ul>
            <div class="clearfix"></div>
          </li>
          <li><a title="Institutes - studyadda.com" href="<?php echo $this->config->item('web_root');?>online-test/">Online Test</a></li>
          <li><a title="Books- studyadda.com" href="<?php echo $this->config->item('web_root');?>books/">Books</a></li>
          <!-- class="dropdown-toggle"-->
          <li class="dropdown yamm-fullwidth"> <a data-toggle="dropdown" href="<?php echo $this->config->item('web_root');?>courses/">Courses<b class="caret"></b> </a>
            <ul class="dropdown-menu row container widhtcont">
              <li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a title="NEET" alt="NEET" href="<?php echo $this->config->item('web_root');?>courses/aipmt/8">NEET</a></li><li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a title="JEE Advanced(IIT-JEE)" alt="JEE Advanced(IIT-JEE)" href="<?php echo $this->config->item('web_root');?>courses/jee-advanced-iit-jee/7">JEE Advanced(IIT-JEE)</a></li><li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a title="JEE Main(AIEEE)" alt="JEE Main(AIEEE)" href="<?php echo $this->config->item('web_root');?>courses/jee-main-aieee/6">JEE Main(AIEEE)</a></li><li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a title="12th Class" alt="12th Class" href="<?php echo $this->config->item('web_root');?>courses/12th-class/5">12th Class</a></li><li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a title="9th Class" alt="9th Class" href="<?php echo $this->config->item('web_root');?>courses/9th-class/3">9th Class</a></li><li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a title="11th Class" alt="11th Class" href="<?php echo $this->config->item('web_root');?>courses/11th-class/2">11th Class</a></li><li class="col-xm-12 col-sm-4 col-md-4 col-lg-3"> <a title="10th Class" alt="10th Class" href="<?php echo $this->config->item('web_root');?>courses/10th-class/1">10th Class</a></li>            </ul>
            <div class="clearfix"></div>
          </li>
          <li><a title="Ncert Solutions- studyadda.com" href="<?php echo $this->config->item('web_root');?>ncert-solution/">Ncert Solutions</a></li>
          <li><a title="Notes - studyadda.com" href="<?php echo $this->config->item('web_root');?>notes/">Notes</a></li>
          <li><a title="Sample Papers - studyadda.com" href="<?php echo $this->config->item('web_root');?>sample-papers/">Sample Papers</a></li>
          <li><a title="Solved Papers - studyadda.com" href="<?php echo $this->config->item('web_root');?>solved-papers/">Solved Papers</a></li>
          <li><a title="Questions Bank- studyadda.com" href="<?php echo $this->config->item('web_root');?>questions-bank/">Questions Bank</a></li>
          <li><a title="Articles- studyadda.com" href="<?php echo $this->config->item('web_root');?>articles/">Articles</a></li>
          <li><a title="Ask- studyadda.com" href="<?php echo $this->config->item('web_root');?>ask/">Ask</a></li>
          <!--<li><a href=""  title="News- ">News</a></li>
            <li><a href=""  title="Institutes - ">Institutes</a></li>-->
        </ul>
      </div>
      <!--/.nav-collapse --> 
    </div>
  </nav>
</section>
<?php ;
//print_r($_SESSION);

$bg_text_css_array=array('bg_blue','bg_green','bg_orange','bg_mehroon','bg_yellow','bg_yellowdark');
?>
<div class="clear"></div>