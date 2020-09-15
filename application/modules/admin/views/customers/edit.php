 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-4">
                   <h1>Edit Account Information</h1> <?php //print_r($user_info);
         if($this->session->flashdata('update_msg')){
        ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('update_msg'); 
			 if(isset($user_info->email)){ echo ' for '.$user_info->email; }else{ echo $user_info->firstname; }  ?> </div>
            <?php 
         }
         ?>
                </div>
                <div class="col-lg-2">
				<a href="<?php echo base_url(); ?>admin/orders/cs_orders/<?php echo $user_info->id; ?>" target="_blank">
				<h1 class="page-header">Orders</h1>
				</a>
				<?php if(isset($user_info->id)){ ?>
				<a href="<?php echo base_url(); ?>admin/customers/set_password/<?php echo $user_info->id; ?>">
				<h1 class="page-header rusure">Set Password</h1>
				</a>
				<?php } ?>
				</div>

				<div class="col-lg-2">
				
				<a href="<?php echo base_url(); ?>admin/customers/admincart/<?php echo $user_info->id; ?>">
				<h1 class="page-header">Shopping Cart</h1>
				</a>
				<a href="<?php echo base_url(); ?>admin/customers/index">
				<h1 class="page-header">Back</h1>
				</a>
				</div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            <div class="col-lg-6">
                    <div class="panel">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
    <div class="my-account">
    
		<div class="subline-title">
			<h4>Account Information</h4>
		</div>
		<?php if($user_info) {?>
		 <form role="form" action="<?php echo base_url(); ?>admin/customers/updatecustomer" name="update_customer_info" id="update_customer_info" method="post">

				 <div class="form-group has-success label-floating is-empty">
					<label class="control-label" for="usr">First-Name :<em>*</em></label>
  <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $user_info->firstname; ?>">
               <span class="material-input"></span>
				</div>
				 <div class="form-group has-success label-floating is-empty">
					<label class="control-label" for="usr">Last-Name :<em>*</em></label>
  <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $user_info->lastname; ?>">
  	
               <span class="material-input"></span>
				</div>
                
				<div class="form-group has-success label-floating is-empty">
					<label class="control-label"  for="email"> Email address:<em>*</em></label>
						<input type="email" name="email" class="form-control" id="email" value="<?php echo $user_info->email; ?>">
                   
               <span class="material-input"></span>
				</div>
				
				<div class="form-group has-success label-floating is-empty">
					<label class="control-label"  for="mobile"> Mobile:<em>*</em></label>
						<input type="text" name="mobile" class="form-control" id="mobile" value="<?php echo $user_info->mobile; ?>"><br>latest otp<?php echo $user_info->otp;?>
              
               <span class="material-input"></span>
				</div>
                     <div class="form-group has-success label-floating is-empty">
					<label class="control-label"  for="mobile_verified"> Mobile Verified:<em>*</em></label>
                                        <?php 
                                        $getYesNo_array = getYesNo_array();
                                       echo generateSelectBox('mobile_verified',$getYesNo_array, 'id', 'value', 0, 'class="form-control"',$user_info->mobile_verified);
                                        ?>
               <span class="material-input"></span>
				</div>
                     <div class="form-group has-success label-floating is-empty">
					<label class="control-label"  for="wallet_balance"> Wallet Balance:<em>*</em></label>
						<input type="text" name="wallet_balance" class="form-control" id="wallet_balance" value="<?php echo $user_info->wallet_balance; ?>">
              
               <span class="material-input"></span>
				</div>
                     
                     <div class="form-group has-success label-floating is-empty">
					<label class="control-label"  for="status"> Status:<em>*</em></label>
					<?php 
                                        $getYesNo_array = getYesNo_array();
                                       echo generateSelectBox('status',$getYesNo_array, 'id', 'value', 0, 'class="form-control"',$user_info->status);
                                        ?>
               <span class="material-input"></span>
				</div>
				<div class="form-group has-success label-floating is-empty">
					<label class="control-label"  for="user_key">User Key:<em>Leave Blank for new mobile</em></label>
						<input type="text" name="user_key" class="form-control" id="user_key" value="<?php echo $user_info->user_key; ?>"><br>
						
						<?php echo 'Is Social:'.$user_info->is_social; ?>
              
               <span class="material-input"></span>
				</div>
				<div class="form-group has-success label-floating is-empty">
					<label class="control-label"  for="device_id">Device Id:<em>Leave Blank for new mobile</em></label>
						<input type="text" name="device_id" class="form-control" id="device_id" value="<?php echo $user_info->device_id; ?>">
              
               <span class="material-input"></span>
				</div>
				
				<div class="form-group has-success label-floating is-empty">
					<label class="control-label"  for="device_id">School Id:<em>sardana international-1</em></label>
						<input type="text" name="schoolid" class="form-control" id="schoolid" value="<?php echo $user_info->schoolid; ?>">
              
               <span class="material-input"></span>
				</div>
				<div class="form-group has-success label-floating is-empty">
					<label class="control-label"  for="wallet_balance"> VIA:<em></em></label>
						<?php
if($user_info->is_app_registered==1){
	echo 'APP';
}else{
	echo 'Web';
}
						 ?>
               <span class="material-input"></span>
				</div>
                     
                     
				<input type="hidden" name="user_id" value="<?php echo $user_info->id; ?>">
  <!-- <button type="submit" class="btn btn-default">Submit</button>-->
  <div class="required-buttons">
        <p class="required">* Required Fields</p>
        <button class="btn btn-raised btn-warning" type="submit"><span><span>Save</span></span></button></p>
    </div>
				</form>
			
		<?php } ?>
			
			</div>
                            </div>
                            <!-- /.table-responsive -->
                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                </div>  
                <div class="col-lg-6">
                    
                    
                     <div class="panel">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
    <div class="subline-title">
            <h5>ADDITIONAL ADDRESSES ENTRIES</h5>
            <?php 
            if($user_info_default_address){ ?>
            <?php  ?>
            <div class="panel panel-default">
              <div class="panel-heading">
                <div style="font-weight:bold;">Address</div>
              </div>
              <div class="panel-body"> <?php echo $user_info_default_address->address_name; ?>
                <address>
                <?php echo $user_info_default_address->address ?><br>
                <?php echo $user_info_default_address->city_name; ?><br>
                <?php echo $user_info_default_address->state_name; ?><br>
                <?php echo $user_info_default_address->mobile; ?><br>
                <?php echo $user_info_default_address->zipcode; ?><br>
              </div>
            </div>
            <?php 
            
            } else{
					echo "User do not have additional addresses.";
				} ?>
          </div>
                            </div>
                            
            <?php if(isset($user_info->targate_exam)&&$user_info->targate_exam!=''){ ?>            
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <label class=""  for="email">Target Exam:</label>
                                        <?php 
			
				 $targate_exam_string=$user_info->targate_exam;
                          $targate_exam_array=explode('_', $targate_exam_string);
                          if(isset($targate_exam_array[0])&&$targate_exam_array[0]!=''){
                                        foreach($mainexamcategories as $t_exam){
                                            $t_exam_id= $t_exam->id;
                                            $t_exam_name= $t_exam->name;
                                            $checked_exam='';
                                        if(in_array($t_exam_id,$targate_exam_array)){
                                            $checked_exam='checked="checked"';
											?>
											 <input type="checkbox" name="targate_exam[]" disabled='disabled' id="targate_exam_<?php echo $t_exam_id; ?>" value="<?php echo $t_exam_id; ?>"  <?php echo $checked_exam; ?>>     
											<?php echo $t_exam_name.'&nbsp;';
                                        }
                                        ?>
                                        <?php
                                        }
   }
                                        ?>
               <span class="material-input"></span>
            </div>   
			<?php } ?>
                </div>
                     </div>
                </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>