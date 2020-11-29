<div class="sidebar-nav">
            <div class="col-md-12" >
        <nav class="nav-sidebar border">
            
            <ul class="nav row" style="background-color: #f9f9f9; padding: 10px;"> 
                <li class="nav-header"></li>
                <!--
                               <li class="col-xs-6 col-sm-12 col-md-12" <?php echo $this->router->fetch_method()=='index'?'class="active"':''?>><a  title="Dashboard" href="<?php echo base_url(); ?>user/my_studypackages"><i class="material-icons btn-success">dashboard</i> &nbsp; My Study Packages</a></li>
                                              <li class="col-xs-6 col-sm-12 col-md-12" <?php echo $this->router->fetch_method()=='index'?'class="active"':''?>><a  title="Dashboard" href="<?php echo base_url(); ?>user/my_videos"><i class="material-icons btn-success">dashboard</i> &nbsp; My Videos</a></li>
                                                             <li class="col-xs-6 col-sm-12 col-md-12" <?php echo $this->router->fetch_method()=='index'?'class="active"':''?>><a  title="Dashboard" href="<?php echo base_url(); ?>user/my_testseries"><i class="material-icons btn-success">dashboard</i> &nbsp; My Test Series</a></li>-->
                <li class="col-xs-6 col-sm-12 col-md-12" <?php echo $this->router->fetch_method()=='index'?'class="active"':''?>><a  title="Dashboard" href="<?php echo base_url(); ?>user/library"><i class="material-icons btn-success">dashboard</i> &nbsp; My Library</a></li>
                <li class="col-xs-6 col-sm-12 col-md-12"><a title="Account Info" href="<?php echo base_url(); ?>user/myaccount"><i class="material-icons btn-primary">account_box</i> &nbsp; My Profile</a></li>
                    <!--<li class="col-xs-6 col-sm-12 col-md-12"><a title="Add Address" href="<?php echo base_url(); ?>user/addaddress"><i class="material-icons">note_add</i>  &nbsp; Add Address</a></li>       <li class="col-xs-6 col-sm-12 col-md-12"><a title="Address Book" href="<?php echo base_url(); ?>user/addresses"><i class="material-icons btn-warning">receipt</i>  &nbsp; My Address</a></li>-->
         
                <li class="col-xs-6 col-sm-12 col-md-12"><a title="My Order" href="<?php echo base_url(); ?>user/orders"><i class="material-icons btn-default">grid_on</i> &nbsp;  My Orders</a></li>
                  <!--<li class="col-xs-6 col-sm-12 col-md-12"><a title="My Tests" href="<?php echo base_url(); ?>user/tests"><i class="material-icons">speaker_notes</i>  &nbsp; My Tests</a></li>
                <li class="col-xs-6 col-sm-12 col-md-12"><a title="My Recommendations" href="<?php echo base_url(); ?>user/recommendations"><i class="material-icons">speaker_notes</i>  &nbsp; My Recommendations</a></li>
                -->
                <li class="col-xs-6 col-sm-12 col-md-12"><a title="Change Password" href="#" data-toggle="modal" onclick="cleanInput()" data-target="#myModal"><i class="material-icons btn-primary">change_history</i>
				<?php
				$customer_email=$this->session->userdata('customer_email');
				if(isset($customer_email)&& $customer_email!=''){ 
                echo "&nbsp; Change Password"; 
				}
				?>
				  </a>
				  </li>
                <li class="nav-divider"></li>
                <li class="col-xs-6 col-sm-12 col-md-12"><a title="Logout" href="<?php echo base_url(); ?>user/logout"><i class="glyphicon glyphicon-off btn-danger"></i> &nbsp; Logout</a></li>
                
            </ul>
            </nav>
        	</div>
        </div> 
<script type="text/javascript" language="JavaScript">
   function cleanInput(){

    document.getElementById('current_password').value='';
       
   } 
</script>

<?php if($this->session->userdata('customer_id')){ ?>
	<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
	  <form action="<?php echo base_url() ?>customer/changePassword" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Hello <?php echo $this->session->userdata['customer_name']; ?></b></h4>
        </div>
        <div class="modal-body">
          <p><b>Enter New Password</b></p>
            <div class="form-group has-success label-floating is-empty">
                        <label class="control-label" for="name">Current Password</label>
                        <input value="" autocomplete="off" class="form-control" type="password" name="current_password" id="current_password"  required>
                     </div> 
           <div class="form-group has-success label-floating is-empty">
                        <label class="control-label" for="name">New Password</label>
                        <input class="form-control" type="password" name="password" id="password"  required>
                     </div> 
             <div class="form-group has-success label-floating is-empty">
                        <label class="control-label" for="name">Confirm Password</label>
                       <input class="form-control" type="password" name="confirm_password" id="confirm_password"  required>
                     </div>           
		  <input type="hidden" name="user_id" value="<?php echo $this->session->userdata['customer_id']; ?>">
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-raised btn-warning" id="updatePass">Update</button>
        </div>
      </div>
      </form>
    </div>
  </div>
	  <?php } ?>