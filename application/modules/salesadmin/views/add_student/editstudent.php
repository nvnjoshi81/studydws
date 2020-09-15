<div class="content">
    <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
		 $firstname=$this->session->userdata('firstname');
		 if(isset($firstname)){
		 $firstname=$this->session->userdata('firstname');
		 }else{
		$firstname=$user_info->firstname;	 
		 }
		 $lastname=$this->session->userdata('lastname');
if(isset($lastname)){
		 $lastname=$this->session->userdata('lastname');
		 }else{
		$lastname=$user_info->lastname;	 
		 }
		 $studentclass=$this->session->userdata('studentclass');		 
if(isset($studentclass)){
		 $studentclass=$this->session->userdata('studentclass');
		 }else{
			 $targate_exam_array=explode(',',$user_info->targate_exam);
		if(count($targate_exam_array)>0){
		$studentclass=$targate_exam_array[0];
		}else{
		$studentclass=$user_info->targate_exam;
		}		
		}  
$emailstudent=$this->session->userdata('emailstudent');
if(isset($emailstudent)){
		 $emailstudent=$this->session->userdata('emailstudent');
		 }else{
		$emailstudent=$user_info->email;	 
		 }
		 $mobilestudent=$this->session->userdata('mobilestudent');
if(isset($mobilestudent)){
		 $mobilestudent=$this->session->userdata('mobilestudent');
		 }else{
		$mobilestudent=$user_info->mobile;	 
		 }
		 $postcodestu=$this->session->userdata('postcodestu');		 
if(isset($postcodestu)){
		 $postcodestu=$this->session->userdata('postcodestu');
		 }else{
		$postcodestu=NULL;	 
		 }
$address_student=$this->session->userdata('address_student');		 
if(isset($address_student)){
		 $address_student=$this->session->userdata('address_student');
		 }else{
		$address_student=NULL;	 
		 } 
$studentschool_id=$this->session->userdata('studentschool_id');		 	 
if(isset($studentschool_id)){
		 $studentschool_id=$this->session->userdata('studentschool_id');
		 }else{
		 $studentschool_id==$user_info->schoolid;	 
		 } 
		 
        ?> 
		<div class="container-fluid">
          <div class="row">
		  <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <p class="card-category">Customers will be registered for your franchise only</p>
                </div>
                <div class="card-body">
			<div class="row">
			<div class="col-lg-12">
			      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div>
                 <p class="required text-left text-warning">* Required Fields</p>
                </div>
                <div class="card-body">
                  <form name="infostudent" id="infostudent" action="<?php echo base_url().$folder_admin; ?>/Add_Student/addStudent" method="POST">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">First Name<small class="required text-left text-warning">*</small></label>
                          <input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Last Name<small class="required text-left text-warning">*</small></label>
                          <input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>"class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-3">
                      <div class="form-group">
					  <select name="studentclass" id="studentclass" class="form-control valid">
					  <option value="0">Select Class</option>
					<?php foreach($mainexamcategories as $classid=>$classname){
						$selectCls=NULL;
						if($studentclass==$classname->id){
							$selectCls='selected=selected';
						}
					?>
					  <option value="<?php echo $classname->id; ?>" <?php echo $selectCls; ?> ><?php echo $classname->name; ?></option>
					<?php
					} 
					?>
</select>
					  </div>
                      </div>
                    </div>
					
					<div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email Address<small class="required text-left text-warning">*</small></label>
                          <input type="email" id="emailstudent" name="emailstudent" value="<?php echo $emailstudent; ?>"class="form-control"  required autocomplete="off" value="">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Mobile<small class="required text-left text-warning">*</small><small> (Ex.6261036004)</small></label>
                          <input type="tel"  pattern="[0-9]{10}" id="mobilestudent" name="mobilestudent" value="<?php echo $mobilestudent; ?>" class="form-control" required>
                        </div>
                      </div>
					  <div class="col-md-3">
                      <div class="form-group">
					  <select name="studentschool_id" id="studentschool_id" class="form-control valid">
					  <option value="0">Select School</option>
					<?php foreach($studentschool as $schoolname){   
						$selectScl=NULL;
						if($studentschool_id==$schoolname->id){
							$selectScl='selected=selected';
						}
					?>
					  <option value="<?php echo $schoolname->id; ?>" <?php echo $selectScl; ?> ><?php echo $schoolname->school_name; ?></option>
					<?php
					} 
					?>
</select>
					  </div>
                      </div>
                    </div>
					<div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Password<small class="required text-left text-warning">*</small></label>
                          <input type="password"  id="passstudent"  name="passstudent"  class="form-control" 
						  autocorrect="off"
						  required autocomplete="off" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Confirm Password<small class="required text-left text-warning">*</small></label>
                          <input type="password" id="repassstudent"  name="repassstudent" class="form-control" autocorrect="off"
						  required autocomplete="off" value="">
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
						  			  <select name="countrystu" id="countrystu" class="form-control valid" onchange="getCity()">
					  <option value="0">Select State</option>
					<?php foreach($states as $statesid=>$statesname){
					?>
					  <option value="<?php echo $statesname->id; ?>"><?php echo $statesname->state_name; ?></option>
					<?php
					} 
					?>
</select>
                        </div>
                      </div>
					  
					  <div class="col-md-4">
                        <div class="form-group">
						<select class="form-control" name="citystudent" id="citystudent"><option value="0">Select City</option>
                        </select>
						
						  			 <!-- <select name="citystudent" id="citystudent" class="form-control valid">
					  <option value="0">Select City</option>
					<?php /* foreach($cities as $cityid=>$cityname){
					?>
					  <option value="<?php echo $cityname->id; ?>"><?php echo $cityname->city_name; ?></option>
					<?php
					} */
					?>
</select>-->
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Postal Code</label>
                          <input type="text" id="postcodestu" name="postcodestu" value="<?php echo $postcodestu; ?>"  class="form-control">
                        </div>
                      </div>
                    </div>
					<div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Address</label>
                          <input type="text" id="address_student" name="address_student" value="<?php echo $address_student; ?>"  class="form-control">
                        </div>
                      </div>
                    </div>WE ARE WORKING FOR THIS FUNCTION<!--
                    <button type="submit" class="btn btn-primary pull-right">Update Student</button>-->
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
       
        </div>
      </div>
			</div>
			<!-- /.col-lg-12 --> 
			<?php
			//Remove session values.
			$this->session->unset_userdata('firstname');
			$this->session->unset_userdata('lastname');
			$this->session->unset_userdata('studentclass');
			$this->session->unset_userdata('emailstudent');	
			$this->session->unset_userdata('mobilestudent');
			$this->session->unset_userdata('postcodestu');
			$this->session->unset_userdata('address_student');
			$this->session->unset_userdata('studentschool');
			?>
</div>
<div class="row">            
			<div class="col-lg-12">
            <script type="text/javascript">
    $(function () {
        $('#datetimepicker6').datetimepicker({format:'YYYY-MM-DD'});
        $('#datetimepicker7').datetimepicker({
            format:'YYYY-MM-DD',
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
            $('.datepicker').hide();
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
             $('.datepicker').hide();
        });
        
    });
</script>
                </div>
</div>
    </div>   