<style type="text/css">
.form-group {
	display: inline-block;
	height: auto;
	margin: 10px 0;
	width: 100%;
}

input, select {
	border:none !important;
	outline:none !important;
	border:none !important;
	border-bottom:1px solid green !important;
}

input:focus, select:focus {
	border:none !important;
	outline:none !important;
	border:none !important;
	border-bottom:1px solid green !important;
}

.reg, .updt {
	border:1px solid green;
	border-radius:15px;
}
</style>
<?php //print_r($teachervyid); ?>

 <div id="page-wrapper">
            <div class="row">
                				
                  <div class="col-lg-10">

								<?php if(isset($teachervyid->id)&&$teachervyid->id>0){ 
								
								$formaction='edit_teacher';
								}else {
								$formaction='reg_teacher';
									}								
									?>
                  <!--
				  <form id="" name="" method="post" action="<?php //echo base_url(); ?>admin/customers/reg_teacher" >
				  -->
							<form id="" name="" method="post" action="<?php echo base_url(); ?>admin/customers/<?php echo $formaction; ?>" >
                    <div class="container">
					<div class="row">
						<a href="<?php echo base_url(); ?>admin/customers/teacher_list">Teacher</a>
					</div>
					
						<div class="row">
<!-- teachers registration form -->					
					
					<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 reg">
					<h1 class="text-center">Teacher Registration Form</h1>
					
						<div class="form-group">
							<label class="control-label col-sm-3">Teacher Id</label>
								<div class="col-sm-9">
									<input type="text" pattern="[0-9]{4,8}" title="Minimun Four and Maximum Eight digit code only" class="form-control" name="tid" placeholder="Enter Teacher Id" value="<?php echo $teachervyid->teacher_id; ?>" required>
								</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-sm-3">First Name</label>
							
								<div class="col-sm-9">
									<input type="text" class="form-control" name="fnm" placeholder="Enter First Name" value="<?php echo $teachervyid->firstname; ?>" required>
								</div>
								
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3">Last Name</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="lnm" placeholder="Enter Last Name" value="<?php echo $teachervyid->lastname; ?>" required>
								</div>								
						</div>
					
						<div class="form-group">
							<label class="control-label col-sm-3">Gender</label>

<?php
	
	$current_gender = $teachervyid->gender;	
							
    //$gen = array("male"=>"Male", "female"=>"Female");
	
		if($current_gender=="Male") { ?>
			<div class="col-sm-1">
									<input type="radio" name="gender" value="Male" checked> Male
								</div>								
								
								<div class="col-sm-offset-1 col-sm-7">
									<input type="radio" name="gender" value="Female"> Female
								</div>
		<?php }
		
		else if($current_gender=="Female") { ?>
			<div class="col-sm-1">
									<input type="radio" name="gender" value="Male"> Male
								</div>								
								
								<div class="col-sm-offset-1 col-sm-7">
									<input type="radio" name="gender" value="Female" checked> Female
								</div>
		<?php }
		
		else { ?>
			<div class="col-sm-1">
									<input type="radio" name="gender" value="Male"> Male
								</div>								
								
								<div class="col-sm-offset-1 col-sm-7">
									<input type="radio" name="gender" value="Female"> Female
								</div>
		<?php } ?>

						</div>

					
						<div class="form-group">
							<div class="col-sm-3">
							<label class="control-label">Select Designation</label>
							</div>
							
							<div class="col-sm-9">
							<select class="form-control" name="designation">
								
								<option value="">Select Designation</option>
								
		<?php

		$current_des = $teachervyid->designation;	
							
        $des = array("pgtphysics"=>"PGT Physics", "pgtmathematics"=>"PGT Mathematics", "tgtmathematics"=>"TGT Mathematics", "tgthindi"=>"TGT Hindi", "tgtscience"=>"TGT Science");
        foreach($des as $key=>$des1){
		
		if($current_des==$key) {
				echo $selection="selected";	
			}
			else {			
				echo $selection="";		
			}		

		
		
			?>
			<option value="<?php echo $key;?>"  <?php echo $selection;?> ><?php echo $des1;?> </option>
			
			<?php
		}
		?>
		
		
					
								
							</select>
							</div>
						</div>

		
						<div class="form-group">
							<label class="control-label col-sm-3">Email</label>
							<div class="col-sm-9">
								<input type="email" name="t_email" placeholder="Enter Email" class="form-control" value="<?php echo $teachervyid->email; ?>">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3">Mobile</label>
							<div class="col-sm-9">
								<input type="text" name="t_mob" placeholder="Enter Mobile" value="<?php echo $teachervyid->mob; ?>"  pattern="[0-9]{10}" title="Ten digit only (mobile no)" class="form-control">
							</div>
						</div>
												
						<div class="form-group text-center">
							<input type="hidden" name="t_id" value="<?php echo $teachervyid->id; ?>">
<?php
if(isset($teachervyid->id)&&$teachervyid->id>0)	{
	$btn_value = "Update";
}						
else {
	$btn_value = "Register";
}
?>
							<input type="submit" name="register" value="<?php echo $btn_value; ?>" class="btn btn-lg btn-success">
							<input type="reset" name="" value="Reset" class="btn btn-lg btn-danger">
						</div>
						
					
						</div>

					</div>
<!-- // teachers registration form -->
                    
                    </div> 
					</div>
                      
                  </form>
                  
                </div>
				
				<hr>
				
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
					<caption class="text-center"><h1>Teacher Detail</h1></caption>
						<thead>	
							<tr>
								<th>Teacher Id</th>
								<th>First name</th>
								<th>Last name</th>
								<th>Gender</th>
								<th>Designation</th>
								<th>Email</th>
								<th>Mobile</th>
								<th>Action</th>
							</tr>
						</thead>
						
						<tbody>
						
						
						<?php 
							
				//print_r($teacher);
				
				foreach ($teacher as $row) { 
				//echo $row->firstname;
				?>
					
						<tr>
							<td><?php echo $row->teacher_id; ?></td>
							<td><?php echo $row->firstname; ?></td>
							<td><?php echo $row->lastname; ?></td>
							<td><?php echo $row->gender; ?></td>
							<td><?php echo $row->designation; ?></td>
							<td><?php echo $row->email; ?></td>
							<td><?php echo $row->mob; ?></td>
							<td class="text-center">
								<a class="btn btn-primary" href="<?php echo base_url(); ?>admin/customers/teacher_list/<?php echo $row->id; ?>">Edit</a>
							</td>
						</tr>
				<?php
				}
								
				?>
				
						</tbody>
					</table>
					</div>
					</div>
				</div>
                
				<hr>
             
            </div>
            <!-- /.row -->
            
        <!-- /#page-wrapper -->

    </div>