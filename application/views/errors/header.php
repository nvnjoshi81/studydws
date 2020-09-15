    <?php
     
    $dataPoints = array( 
    	array("y" => 3373.64, "label" => "Germany" ),
    	array("y" => 2435.94, "label" => "France" ),
    	array("y" => 1842.55, "label" => "China" ),
    	array("y" => 1828.55, "label" => "Russia" ),
    	array("y" => 1039.99, "label" => "Switzerland" ),
    	array("y" => 765.215, "label" => "Japan" ),
    	array("y" => 612.453, "label" => "Netherlands" )
    );
     
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
    <script>
    window.onload = function() {
     
    var chart = new CanvasJS.Chart("chartContainer", {
    	animationEnabled: true,
    	theme: "light2",
    	title:{
    		text: "Gold Reserves"
    	},
    	axisY: {
    		title: "Gold Reserves (in tonnes)"
    	},
    	data: [{
    		type: "column",
    		yValueFormatString: "#,##0.## tonnes",
    		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart.render();
     
    }
    </script>
    </head>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($title)?$title.' - Studyadda.com':'JEE Main, JEE Advanced, CBSE, NEET, IIT, free study packages, test papers, counselling, ask experts - Studyadda.com';?>
	</title>
    <meta name="description" content="<?php echo isset($title)?'Free '.$title:'StudyAdda offers free study packages for AIEEE, IIT-JEE, CAT, CBSE, CMAT, CTET and others. Get sample papers for all India entrance exams.'?>">
    <meta name="keywords" content="IIT, IIT-JEE, IIT-JEE 2011, AIEEE, CBSE BOARD, ICSE BOARD, NEET, Exam Alert, Expert Help, Career Counselling, Latest Educational News, Sample Papers, Test Papers, Study Packages, Projects, Results, Scholarship, Blog, My Community, Dictionary, Calculator, Free Study Packages for All type of Exams, Free IIT-JEE Study Packages, Total Free Study Packages for IIT-JEE, AIEEE Free Study Packages, IIT-JEE Study Packages, Free Study Packages of AIEEE, NEET Study Packages, Free NEET Study Packages, FREE Video Lectures">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" />
    
<meta property="og:title" content="<?php echo isset($title)?$title.' - Studyadda.com':'JEE Main, JEE Advanced, CBSE, NEET, IIT, free study packages, test papers, counselling, ask experts - Studyadda.com';?>" />
<meta property="og:description" content="<?php echo isset($title)?'Free '.$title:'StudyAdda offers free study packages for AIEEE, IIT-JEE, CAT, CBSE, CMAT, CTET and others. Get sample papers for all India entrance exams.'?>" />
<meta property="og:image" content="<?php echo get_assets('assets/frontend/images/logo_new.png');?>" />
<meta property="og:url" content="<?php echo base_url()?>"/>
<meta property="og:image:type" content="image/jpeg" /> 
<meta property="og:locale" content="en_GB" />
<meta property="og:locale:alternate" content="fr_FR" />
<meta property="og:locale:alternate" content="es_ES" />
<meta property="og:type" content="article" />


    <!-- Custom Fonts -->
    <link href="<?php echo get_assets('assets/frontend/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo get_assets('assets/frontend/css/bootstrap.min.css');?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo get_assets('assets/frontend/css/bootstrap-material-design.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_assets('assets/frontend/css/ripples.css');?>">
    <!-- Custom CSS -->
    <link href="<?php echo get_assets('assets/frontend/css/main.css');?>" rel="stylesheet">
    <link href="<?php echo get_assets('assets/frontend/css/toastr.min.css');?>" rel="stylesheet"/>
    <?php if(isset($styles) && count($styles) > 0){ 
        foreach($styles as $key=>$style){   
    ?>
        <link media="all" type="text/css" rel="stylesheet" href="<?php echo strpos($style,'http') !== false ? $style : base_url().$style;?>">
    <?php } 
    } 
    
    ?>
     <link rel="stylesheet" href="<?php echo get_assets('assets/css/prettyPhoto.css');?>" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
     <link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.min.css'); ?>"> 
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

<style type="text/css">
	.main {
		margin-left:30px;
		font-family:Verdana, Geneva, sans-serif, serif;
	}
	.text {
		float:left;
		width:180px;
	}
	.dv {
		margin-bottom:5px;
	}
</style>
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
          <span><img alt="" src="<?php echo get_assets('assets/frontend/images/tog_arrow.png');?>"></span>
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
                          <div class="col-lg-4">
                            <p class="text-center">
                              <span class="glyphicon glyphicon-user icon-size">
                              </span>
                            </p>
                          </div>
                          <div class="col-lg-8">
                            <p class="text-left">
                              <strong>
                                  <a  title="Studyadda-My Account" href="<?php echo base_url(); ?>user/myaccount"><?php echo $this->session->userdata('customer_fullname');?></a>
                              </strong>
                            </p>
                            <p class="text-left"><a  title="Studyadda-My Library" href="<?php echo base_url(); ?>user/library" >My Library</a></p><p>
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
        </div>
        <?php } ?>
    <!-- /.container -->
    <div style="padding-left: 94px;"><!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
<a class="a2a_button_facebook"></a>
<a class="a2a_button_whatsapp"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_button_twitter"></a>

</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END --></div>
      
  </nav>
  <!-- Navigation -->
  <nav class="navbar topnav" role="navigation">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <p class="topcontact">
          <span class="blink_me">
              <a href="tel:6261036004" title="6261036004"> <i class="fa fa-phone-square fa-2">
            </i>
              : +91 6261036004</a> 
          </span>
          <span>  
              <a href="mailto:info@studyadda.com" title="info@studyadda.com">
            <i class="fa fa-envelope-square fa-2">
            </i>
              : info@studyadda.com</a>
          </span>
        </p>
      </div>      
      <!-- Collect the nav links, forms, and other content for toggling pull-right-->
      <div class="collapse navbar-collapse nopadding" style="font-size:13px">
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
              
            <!--<li><a href="<?php echo base_url('amazing-facts')?>" title="Studyadda-amazing-facts">
            Amazing Facts
            </a>
            </li>-->
          
                  <!--
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
-->
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container -->
  </nav>
  <header>
    <!-- Header Carousel -->
    <div class="container header-top_box">
    
      <div class="col-lg-2 nopadding mob_no">
        <a href="<?php echo base_url();?>">
          <img alt="" width="134" height="74" src="<?php echo get_assets('assets/frontend/images/logo_new.png');?>" class="img-responsive img-center mainpadding">
        </a>
      </div>
      <div class="col-lg-7 mainpadding searchpanel">
          
          <div class="col-lg-12 text-center"  align="center">
              <div class="text-center" align="center">
                  <div align="center"> 
                  <a target="_blank" title="Purchase Courses" href="<?php echo base_url('purchase-courses') ?>"><button class="btn btn-raised btn-success"><i class="material-icons">shopping_cart</i>Purchase Courses</button></a><a target="_blank" title="Studyadda App" href="https://play.google.com/store/apps/details?id=com.studyaddaapp&pageId=none&rdid=com.studyaddaapp&pli=1"><button class="btn btn-raised btn-warning" style="background:black"><i class="material-icons">android</i>Download Android App </button></a></div>
                  
                 <!-- <div class="pull-right"> 
                  <a target="_blank" title="Studyadda App" href=""><img align="center" class="text-center"  hight="400px" width="400px" class="img-responsive" src="<?php echo base_url('/images/dewali.png') ?>" displaymode="Original" alt="Google Play" title="Google Play"></a></div>-->
          </div>
          </div>
          
          
          <?php 
          $showSearchTop='no';
          if($showSearchTop=='yes'){?>
      <form name="mainsearch" id="mainsearch" action="<?php echo base_url('search')?>"  >
        <div class="col-lg-12">
          <div class="input-group">
            <div class="form-group label-floating is-empty">
              
<label class="control-label" for="focusedInput1" >
Search.....
</label>

                        <input name="search_txt" id="search_txt" class="form-control" type="text">
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
                       </ul>
              </div>
      </form>
          <?php } ?>
          </div>
          <div class="col-xs-12 col-sm-12 col-lg-3 mainpadding  pull-right">             
              <div class="hidden-xs col-xs-12 col-sm-6 col-lg-12 nopadding">                
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
              <div class="col-xs-12 col-sm-6 col-lg-12 cartitems">
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
      <nav role="navigation" class="navbar mainnav notoggle navbar-full">
        <div class="container">      
          <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
           <div class="col-md-10 col-md-10"> <ul class="nav navbar-nav toggle_nav">
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
				  
			 if($ex->id=='72'){
				 ?><br><?php
			 }
              $exam_cnt++;
             // }
              }
              } ?>  
               </ul></div><div class="col-md-2 col-lg-2">
              <span class="pull-right feat_vid_box"><a title="Studyadda-Featured Videos" class="btn btn-sm btn-warning btn-raised" href="<?php echo base_url('featured-videos')?>">Demo Videos</a><span style="padding-left: 4px;">SHARE ON</span></span>  <div style="padding-left: 4px;"><!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
<a class="a2a_button_facebook"></a>
<a class="a2a_button_whatsapp"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_button_twitter" ></a>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END --></div></div>
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
    
    <style>         .chepter-text-color {
        color: #4caf50;
font-weight: 400 !important;
font-size: 12px;
padding: 10px 0;
    }
        .chepter-color {
        color: #ff5722;
font-weight: 400 !important;
font-size: 12px;
padding: 10px 0;
    }
    
    
    .glyphic_fontinfo{
                font-size:35px;
                } 

.offer{
	background:#fff; border:1px solid #ddd; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); margin: 15px 0; overflow:hidden;
}
.offer:hover {
    -webkit-transform: scale(1.1); 
    -moz-transform: scale(1.1); 
    -ms-transform: scale(1.1); 
    -o-transform: scale(1.1); 
    transform:rotate scale(1.1); 
    -webkit-transition: all 0.4s ease-in-out; 
-moz-transition: all 0.4s ease-in-out; 
-o-transition: all 0.4s ease-in-out;
transition: all 0.4s ease-in-out;
    }
.offer-radius{
	border-radius:7px;
}

.offer-success {	border-color: #5cb85c; }

.offer-success-oppo {	border-color: #ff5722; }



.offer-content{
	padding:0 9px 8px;
}

.shape{    
    border-style: solid; border-width: 0 55px 25px 0; float:right; height: 0px; width: 0px;
	-ms-transform:rotate(360deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(360deg); /* Safari and Chrome */
	transform:rotate(360deg);
        border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
}     

.shape-text{
	color:#fff; font-size:11px; font-weight:bold; position:relative; right:-40px; top:1px; white-space: nowrap;
	-ms-transform:rotate(30deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(30deg); /* Safari and Chrome */
	transform:rotate(30deg);
}
.offer-success .shape{
	border-color: transparent #5cb85c transparent transparent;
}
.shape-oppo{    
    border-style: solid; border-width: 0 55px 25px 0; float:right; height: 0px; width: 0px;
	-ms-transform:rotate(360deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(360deg); /* Safari and Chrome */
	transform:rotate(360deg);
        border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
}     

.shape-text-oppo{
	color:#fff; font-size:11px; font-weight:bold; position:relative; right:-40px; top:1px; white-space: nowrap;
	-ms-transform:rotate(30deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(30deg); /* Safari and Chrome */
	transform:rotate(30deg);
}
/*
.shape-oppo{    
    border-style: solid; border-width: 42px 42px 0 0; float:left; height: 26px; width: 19px;
	-ms-transform:rotate(180deg); // IE 9 
	-o-transform: rotate(180deg);  // Opera 10.5 
	-webkit-transform:rotate(180deg); // Safari and Chrome 
	transform:rotate(180deg);
        border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
       
}
  .shape-text-oppo{
	color:#fff; font-size:11px;
        font-weight:bold; 
        position:relative; 
        right:-40px;
        top:1px; 
        white-space: nowrap;
	-ms-transform:rotate(30deg); // IE 9 
	-o-transform: rotate(30deg);  // Opera 10.5 
	-webkit-transform:rotate(30deg); // Safari and Chrome 
	transform:rotate(30deg);
} */
.offer-success-oppo .shape-oppo{
	border-color: transparent #ff5722 transparent transparent;
}
   

@media (min-width: 487px) {
  .col-sm-6 {
    width: 50%;
  }
}
@media (min-width: 900px) {
  .col-md-4 {
    width: 33.33333333333333%;
  }
}

@media (min-width: 1200px) {
  .col-lg-3 {
    width: 25%;
  }
  }
</style>
  <?php
     
    $dataPoints = array( 
    	array("y" => 3373.64, "label" => "Germany" ),
    	array("y" => 2435.94, "label" => "France" ),
    	array("y" => 1842.55, "label" => "China" ),
    	array("y" => 1828.55, "label" => "Russia" ),
    	array("y" => 1039.99, "label" => "Switzerland" ),
    	array("y" => 765.215, "label" => "Japan" ),
    	array("y" => 612.453, "label" => "Netherlands" )
    );
     
    ?>
    
    <script>
    window.onload = function() {
     
    var chart = new CanvasJS.Chart("chartContainer", {
    	animationEnabled: true,
    	theme: "light2",
    	title:{
    		text: "Gold Reserves"
    	},
    	axisY: {
    		title: "Gold Reserves (in tonnes)"
    	},
    	data: [{
    		type: "column",
    		yValueFormatString: "#,##0.## tonnes",
    		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart.render();
     
    }
    </script>
  </header>
  <!-- Page Content -->