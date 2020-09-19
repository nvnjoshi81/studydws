<style>
.email_form{
width:50%;
}
</style>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb');?>

 <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
?>      
<!--
                    <div class="col-xs-12 col-md-6 col-lg-6" id="register">
                       
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Create New Account</h3>
                            </div>
                            <div class="panel-body">
                                <form role="form" action="<?php echo base_url(); ?>api/customer/register" method="post" id="registerform">



                                    <p>Register with us for future convenience:</p>
                                    <div class="form-group has-success label-floating is-empty">
                                        <label class="control-label" for="usr"><em>*</em>
First Name </label>
                                        <input type="text" name="firstname" class="form-control" id="firstname">
                                    </div>

                                    <div class="form-group has-success label-floating is-empty">
                                        <label class="control-label" for="usr"><em>*</em>
Last Name </label>
                                        <input type="text" name="lastname" class="form-control" id="lastname">
                                    </div>

                                    <div class="form-group has-success label-floating is-empty">
                                        <label class="control-label" for="email"><em>*</em>
Email </label>
                                        <input type="email" name="email" class="form-control" id="email">
                                    </div>

                                    <div class="form-group has-success label-floating is-empty">
                                        <label class="control-label" for="email"><em>*</em> Password </label>
                                        <input type="password" name="password" class="form-control" id="password">
                                    </div>
                                    <div class="form-group has-success label-floating is-empty">
                                        <label class="control-label" for="email"><em>*</em> Confirm Password </label>
                                        <input type="password" name="cpassword" class="form-control" id="cpassword">
                                    </div>
                                    <div class="form-group has-success label-floating is-empty">
                                        <label class="control-label" for="number"><em>*</em> Mobile </label>
                                        <input type="text" name="mobile" class="form-control" id="mobile">
                                    </div>
                                    
                                    <button type="submit" class="btn btn-raised btn-warning">Continue</button>
                                </form>
                            </div>
                        </div>


                    </div>

                    <div class="col-xs-12 col-md-6 col-lg-6"id="login">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Login</h3>
                                </div>
                                <div class="panel-body">
                                    <form action="" method="post" name="loginform" id="loginform">
                        <?php if($redirect){
echo "<input type='hidden' name='redirect' value='1' id='redirect'>";
echo "<input type='hidden' name='redirect_url' value='".$redirect_url."' id='redirect_url'>";
} ?>
                                    <div class="alert alert-danger alert-dismissible" id="login_msg" role="alert" style="display:none">
                                    </div>

                                    <p>Already registered? Please log in below</p>
                                    <p class="required text-right text-warning">* Required Fields</p>

                                    <div class="form-group has-success label-floating is-empty">
                                        <label class="control-label" for="exampleInputEmail1"><em>*</em> Email address :</label>
                                        <input type="email" name="loginemail" class="form-control" id="loginemail">
                                    </div>
                                    <div class="form-group has-success label-floating is-empty">
                                        <label class="control-label" for="exampleInputPassword1"><em>*</em> Password :</label>
                                        <input type="password" name="loginpassword" class="form-control" id="loginpassword">
                                    </div>

                                    <button type="submit" class="btn btn-raised btn-warning">Login</button>
                                    <button type="button" class="btn btn-raised btn-warning" data-toggle="modal" data-target="#forgotpassword">Forgot Password</button>
                                     </form>
                                </div>
                            </div>
                        </div>
                        -->
                        <div class="col-sm-5">
                        	
                        	<div class="form-box">
	                        	<div class="form-top">
	                        		<div class="form-top-left">
                                                <h3>Existing User Login</h3>
	                            		<p>Enter Email and password to log on:<a class="text-success hidden-lg hidden-md" href="<?php echo base_url('login#newl'); ?>">[NEW USER? Register Now.]</a></p>
	                        		</div>
                                           
	                        		<div class="form-top-right">
	                        		<i class="fa fa-key"></i>
	                        		</div>
	                            </div>
                                     <div class="alert alert-danger alert-dismissible" id="login_msg" role="alert" style="display:none">
			 </div>
	                            <div class="form-bottom">
				                    <form action="" method="post" name="loginform" id="loginform">
                        <?php if($redirect){
    echo "<input type='hidden' name='redirect' value='1' id='redirect'>";
                        echo "<input type='hidden' name='redirect_url' value='".$redirect_url."' id='redirect_url'>"; } ?>
				                    	<div class="form-group1 form-group has-success label-floating is-empty">
                                                            <label class="control-label" for="exampleInputEmail1"><em>*</em> Email :</label>
                                                            <input type="email" name="loginemail" class="form-control" id="loginemail">
                                                        </div>
                                                        <div class="form-group1 form-group has-success label-floating is-empty">
                                                            <label class="control-label" for="exampleInputPassword1"><em>*</em> Password :</label>
                                                            <input type="password" name="loginpassword" class="form-control" id="loginpassword">
                                                        </div>
				                        <button class="btn btn-raised btn-info" type="submit">Sign in!</button>
                                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#forgotpassword">Forgot Password</button>
				                    </form>
			                    </div>
		                    </div>
		                
		                	<div class="social-login" id="newl">
	                        	<h3>...or login with:</h3>
	                        	<div class="social-login-buttons">
		                        	<a href="<?php echo base_url('auth/facebook')?>" class="btn-link-1 btn-link-1-facebook">
		                        		<i class="fa fa-facebook"></i> Facebook
		                        	</a>
		                        	<a href="<?php echo base_url('auth/twitter')?>" class="btn-link-1 btn-link-1-twitter">
		                        		<i class="fa fa-twitter"></i> Twitter
		                        	</a>
		                        	<a href="<?php echo base_url('auth/googleplus')?>" class="btn-link-1 btn-link-1-google-plus">
		                        		<i class="fa fa-google-plus"></i> Google Plus
		                        	</a>
	                        	</div>
	                        </div>
	                        
                        </div>	
                        
                        <div class="hidden-xs col-sm-1 middle-border"></div>
                        <div class="col-sm-1"><br></div>
                        
                        <div class="col-sm-5" >
                        	<?php   if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }  ?>
                        	<div class="form-box" id="frm_box">
                        		<div class="form-top">
	                        		<div class="form-top-left">
	                        			<h3>New User Register Now</h3>
	                            		<p>Fill the form below to get instant access:</p>
	                        		</div>
	                        		<div class="form-top-right">
	                        			<i class="fa fa-pencil"></i>
	                        		</div>
	                            </div>
	                            <div class="form-bottom frm_box">
				    <form role="form" action="<?php echo base_url(); ?>api/customer/register" method="post" id="registerform">
				     <div class="form-group1 form-group has-success label-floating is-empty">
                                        <label class="control-label" for="usr"><em>*</em>
Name </label>
                                        <input type="text" name="firstname" class="form-control" id="firstname">
                                    </div>
                                    <div class="form-group1 form-group has-success label-floating is-empty">
                                        <label class="control-label" for="email"><em>*</em>
Email </label>
                                        <input type="email" name="email" class="form-control" id="email">
                                    </div>

                                    <div class="form-group1 form-group has-success label-floating is-empty">
                                        <label class="control-label" for="email"><em>*</em> Password </label>
                                        <input type="password" name="password" class="form-control" id="password">
                                    </div>
                                    <div class="form-group1 form-group has-success label-floating is-empty">
                                        <label class="control-label" for="email"><em>*</em> Confirm Password </label>
                                        <input type="password" name="cpassword" class="form-control" id="cpassword">
                                    </div>
                                    <div class="form-group1 form-group has-success label-floating is-empty">
                                        <label class="control-label" for="number"><em>*</em> Mobile </label>
                                        <input type="text" name="mobile" class="form-control" id="mobile">
                                   <?php
                                   /*Check whather user is from Android App or Website */
                                   
                                     $isWebView = false;
if((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false)){
    $isWebView = true;
}elseif(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
    $isWebView = true;
}

if(!$isWebView){ 
    // Normal Browser
    //echo "aa";
    $is_social_value=0;
}else{
    
    $is_social_value=2;
    // Android or iOS Webview
    
     //echo "ww";
}
                                   
                                   /*End check whater user*/
                                   
                                   
                                    $random_number = rand(999,9999);
                                    $this->session->set_userdata("regi_session",$random_number);
                                    $regi_session_value= $random_number;
                                   ?>
                                   <input type="hidden"  name="regi_session_input" value="<?php echo $regi_session_value; ?>">
                                   <input type="hidden"  name="is_social_value" value="<?php echo $is_social_value; ?>">
                                   </div>
				                        <button class="btn btn-raised btn-info" type="submit">Sign me up!</button>
                                                    </form>
													
                                     <div class="alert alert-danger alert-dismissible" id="err_msg" role="alert" style="display:none">
			 </div>
			                    </div>
                        	</div>
                        	
                        </div>
                 

                </div>
                
            </div>

        
</div>

