<style>
.email_form{
	width:50%;
}
</style>

<div class="modal fade" id="forgotpassword" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
	  <form action="" method="post" name="forgot_password" id="forgot_password">
      <div class="modal-content">
			<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Reset Password.</b></h4>
        </div>
        <div class="modal-body" id="forgetpass_content">
			Email : <input class="form-control email_form" type="" name="email" id="email">
        </div>
        <div class="modal-footer" id="forgetpass_content_button">
          <button type="submit" class="btn btn-success">Send Password</button>
          <button type="cancel" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
      </form>
    </div>
  </div>
  <!------forgot password pop up--->
 
<div class="container">
    <div class="row">
    <div class="col-md-12">
		<div class="step-title">
			<h2>My Account</h2>
		</div>
		</div>
		<div class="col-md-4" id="register">
        <h3 class="main_title">Create New Account</h3>
			<form role="form" action="<?php echo base_url(); ?>api/customer/register" method="post" id="registerform">
				
				
				<label>Register and save time!</label>
				<p>Register with us for future convenience:</p>
				<div class="form-group">
					<label class="required" for="usr"><em>*</em>
                    First Name : </label>
						<input type="text" name="firstname" class="form-control" placeholder="First name" id="firstname">
				</div>
                
                <div class="form-group">
					<label class="required" for="usr"><em>*</em>
                    Last Name : </label>
						<input type="text" name="lastname" class="form-control" placeholder="Last name" id="lastname">
				</div>
                
				<div class="form-group">
					<label class="required" for="email"><em>*</em> Email :</label>
						<input type="email" name="email" class="form-control" id="email" placeholder="email">
				</div>
				<div class="form-group">
					<label class="required" for="email"><em>*</em> Password :</label>
						<input type="password" name="password" class="form-control" id="password" placeholder="password">
				</div>
                <div class="form-group">
					<label class="required" for="email"><em>*</em> Confirm Password :</label>
						<input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="password">
				</div>
				<div class="form-group">
					<label class="required" for="number"><em>*</em> Mobile :</label>
						<input type="text" name="mobile" placeholder="Mobile" class="form-control" id="mobile">
				</div>
				<!--<div class="form-group">
					<label class="required" for="comment"> <em>*</em> Billing Address :</label>
						<textarea name="address_name"  placeholder="Billing Address" class="form-control" rows="5" id="address_name"></textarea>
				</div>
				<div class="form-group">
					<label class="required" for="sel1"><em>*</em> State :</label>
					<select name="state" class="form-control" id="state">
							<option value="">Select State</option>
							<option value="Andaman Nicobar">Andaman Nicobar</option>					
							<option value="Andhra Pradesh">Andhra Pradesh</option>							<option value="Arunachal Pradesh">Arunachal Pradesh</option>						<option value="Assam">Assam</option>									
							<option value="Bihar">Bihar</option>									
							<option value="Chandigarh">Chandigarh</option>									
							<option value="Chhattisgarh">Chhattisgarh</option>									
							<option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>	
					</select>
				</div>
				<div class="form-group">
					<label class="required" for="sel1"><em>*</em> City :</label>
						<select class="form-control" name="city" id="city">
							<option>City</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
						</select>
				</div>
				<div class="form-group">
					<label class="required" for="usr"><em>*</em> Pincode :</label>
					<input type="text" placeholder="Pincode" name="zipcode" class="form-control" id="zipcode">
				</div>
				<div class="radio">
					<label><input type="radio" name="optradio">Ship to this address</label>
				</div>
				<div class="radio">
					<label><input type="radio" name="optradio">Ship to different address</label>
				</div>
				<div class="checkbox">
					<label><input type="checkbox"> Accept Terms & Conditions</label>
				</div>-->
				<button type="submit" class="btn btn-warning">Continue</button>
			</form>
		</div>
		<form action="" method="post" name="loginform" id="loginform">
		<?php if($redirect){
					echo "<input type='hidden' name='redirect' value='1' id='redirect'>";
					echo "<input type='hidden' name='redirect_url' value='".$redirect_url."' id='redirect_url'>";
				} ?>
		<div class="col-md-4" id="login">
			<h3 class="main_title">Login</h3>
			<div class="alert alert-danger alert-dismissible" id="login_msg" role="alert" style="display:none">
			 </div>
			<label>Already registered?</label>
			<p >Please log in below</p>
			<p class="required">* Required Fields</p>
			 
			<div class="form-group">
				<label class="required" for="exampleInputEmail1"><em>*</em> Email address :</label>
				<input type="email" name="loginemail" class="form-control" id="loginemail" placeholder="Email">
			</div>
			<div class="form-group">
				<label class="required" for="exampleInputPassword1"><em>*</em> Password :</label>
				<input type="password" name="loginpassword" class="form-control" id="loginpassword" placeholder="Password">
			</div>
			<div class="form-group">
				<label class="required" for="exampleInputPassword1"><em>*</em> Image Verification :</label>
				<br>
				<?php echo $veri_image['image'];?>
				<input type="text" name="verification" class="form-control" id="verification" placeholder="Verification Code">
			</div>
				<button type="submit" class="btn btn-warning">Login</button>
				<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#forgotpassword">Forgot Password</button> 
			</div>
		</form>
		<div class="col-md-4"></div>
		
	</div>
			<?php  // include "components/widgets/related-products.php" ?>
</div>