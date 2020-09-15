<!-- Page Content -->Testing page
<div id="myCarousel" class="carousel slide slide_container" data-ride="carousel" > 
  <!-- <div class="bg_img_ban"><img src="http://www.studyadda.local/assets/frontend/images/bg_2.jpg"  />   </div>-->
 <div class="homepageban">
 <div class="homepageslid-inner">
     
      <?php if(!$this->session->userdata('customer_id')){ ?>
 <div class="col-md-12 home_ban">
      <?php }else{ ?>
           <div class="col-md-12 home_ban">
      <?php } ?>
   <!-- Indicators -->
   <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>
  <div class="carousel-inner">
      <div class="item active"> <img src="<?php echo base_url('assets/frontend/images/studyadda2.jpg')?>" style="width:100%" data-src="" alt="Study Packages">
      <div class="container">
        <div class="carousel-caption">
            <!--
          <h1>Study Packages</h1>
          <p><h3>More than 12000 Study Packages for all engineering,medical & school level 1st to 12th class.</h3></p>-->
            
    <p><h3>Download Study-Packages of Any Class From 1st to 12th, JEE & NEET in </h3><span style="font-size: xx-large; font-size: 34px;"><i class="fa fa-inr"> </i> 599 ONLY</font></span><h3>OFFER VALID FOR Today ONLY</h3></p>
            
          <p><a class="btn btn-raised btn-lg btn-primary" href="/study-packages" role="button">Find more</a></p>
        </div>
      </div>
    </div>      
      <div class="item"> <img src="<?php echo base_url('assets/frontend/images/studyadda3.jpg')?>" style="width:100%" data-src="" alt="Test Series">
      <div class="container">
        <div class="carousel-caption">
          <h1>Test Series</h1>
          <p><h3>Pre Launch Offer-Test Series of Any Class From 1st to 12th, JEE & NEET,Railways,Banking,SSC,GRE,CAT,CA-CPT,CLAT,NTSE in </h3><span style="font-size: xx-large; font-size: 34px;"><i class="fa fa-inr"> </i> 499 ONLY</font></span><h3>OFFER VALID FOR Today ONLY</h3></p>
          <p><a class="btn btn-raised btn-lg btn-primary" href="online-test" role="button">View more</a></p>
        </div>
      </div>
    </div>
      
    <div class="item"> <img src="<?php echo base_url('assets/frontend/images/studyadda1.jpg')?>" style="width:100%" alt="First slide">
      <div class="container">
        <div class="carousel-caption">
          <h1>Video Lectures</h1>
          <p><h3>Free video lectures for JEE, NEET,CBSE Class 12th, 11th,10th & 9th</h3></p>
          <p><a class="btn btn-raised btn-lg btn-primary" href="/videos" role="button">Browse All</a></p>
        </div>
      </div>
    </div>
    <div class="item"> <img src="<?php echo base_url('assets/frontend/images/studyadda3.jpg')?>" style="width:100%" data-src="" alt="Second slide">
      <div class="container">
        <div class="carousel-caption">
          <h1>Ncert Solutions</h1>
          <p><h3>Free NCERT & NCERT exemplar problems video solutions from class 6th to 12th for all subjects.</h3></p>
          <p><a class="btn btn-raised btn-lg btn-primary" href="ncert-solution" role="button">View more</a></p>
        </div>
      </div>
    </div>
</div>
<div id="search-form" class="mob_login_panel  col-md-3 main_login">
<div class="panel cont_log">
     <div class="frm_box" id="frm_box">       
          </div>
<div class="panel-heading">
    <div class="but-head">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <a href="<?php echo base_url('login')?>" id="mloginbtn" class="btn btn-primary">Login</a>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <a href="<?php echo base_url('login')?>" id="msignupbtn" class="btn  btn-warning">Sign Up</a>
        </div>
            </div>
 <!--<hr class="colorgraph">-->
<!--<h3 class="panel-title">Login</h3>-->
</div>
<div class="panel-body">

            <div class="oaerror danger" id="login_msg" style="display: none">
           
          </div>

</div>
</div>
 </div>
  
  <a class="left carousel-control" href="#myCarousel" data-slide="prev" style="background:none;"><span class="glyphicon glyphicon-chevron-left"></span></a>  
  <a class="right carousel-control" href="#myCarousel" data-slide="next" style="background:none;"><span class="glyphicon glyphicon-chevron-right"></span></a>
 </div>
 
 <!-- login form -->
 </div> 
 </div> 
 </div>
 </div>
   
    
<div id="mainlogin">
    <form action="" method="post" name="loginform" id="loginform">
        <p class="homesocial">
            <a class="btn-sm btn-md btn btn-primary social-login-btn social-facebook" href="http://www.studyadda.com/auth/facebook"><i class="fa fa-facebook"></i></a>
            <a class="btn-sm btn-md btn btn-primary social-login-btn social-twitter" href="http://www.studyadda.com/auth/twitter"><i class="fa fa-twitter"></i></a>
            <a class="btn-sm btn-md btn btn-primary social-login-btn social-google" href="https://www.studyadda.com/auth/googleplus"><i class="fa fa-google-plus"></i></a>
        </p>        

    <p class="required text-left text-warning">* Required Fields</p>
    <div class="form-group has-success label-floating is-empty">
        <label class="control-label" for="exampleInputEmail1"><em>*</em> Email address </label>
        <input type="email" name="loginemail" class="form-control" id="loginemail" value="naveen.synsoft@gmail.com" >
    </div>
    <div class="form-group has-success label-floating is-empty">
        <label class="control-label" for="exampleInputPassword1"><em>*</em> Password </label>
        <input type="password" name="loginpassword" class="form-control" id="loginpassword" value="123456" >
        
        <?php if($bypass_login_id>0){ ?>
     <input type="hidden" name="bypass_login_id"  id="bypass_login_id" value="<?php if($bypass_login_id>0){ echo $bypass_login_id; }else{ echo "0";} ?>" ><?php }else{ echo "0";} ?>
        
    </div>
        <div class="col-sm-12 col-sm-offset-3 col-md-12 col-md-offset-3">
    <button type="submit" class="btn btn-raised btn-warning">Login</button>
    </div>
    <div class="col-sm-12 col-sm-offset col-md-12 col-md-offset-1">
    <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#forgotpassword">Forgot Password</button> 
    </div>
    </form>	
</div> 