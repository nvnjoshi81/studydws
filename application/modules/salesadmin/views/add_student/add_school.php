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
		$firstname=NULL;	 
		 }
		 $lastname=$this->session->userdata('lastname');
if(isset($lastname)){
		 $lastname=$this->session->userdata('lastname');
		 }else{
		$lastname=NULL;	 
		 }
		 $studentclass=$this->session->userdata('studentclass');		 
if(isset($studentclass)){
		 $studentclass=$this->session->userdata('studentclass');
		 }else{
		$studentclass=NULL;	 
		 } 
$emailstudent=$this->session->userdata('emailstudent');
if(isset($emailstudent)){
		 $emailstudent=$this->session->userdata('emailstudent');
		 }else{
		$emailstudent=NULL;	 
		 }
		 $mobilestudent=$this->session->userdata('mobilestudent');
if(isset($mobilestudent)){
		 $mobilestudent=$this->session->userdata('mobilestudent');
		 }else{
		$mobilestudent=NULL;	 
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
		 $studentschool_id=NULL;	 
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
            <div class="col-md-9">
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
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Create Student</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card card-profile">
                 <div class="card-header card-header-primary">
                  <h4 class="card-title">Search Student</h4>
				  </div>
                <div class="card-body">
                 	
                <div class="col-lg-12">
                   <form id="search_customer_form" name="search_customer_form" method="post" action="<?php echo base_url().$folder_admin; ?>/Add_Order/search_customer" >
				   <ul  style="list-style-type:none;">
				   <li>Enter  Mobile<br><small>Ex.6261036004</small> <input type="text" id="customer_mobile" name="customer_mobile" value="" type="tel"  pattern="[0-9]{10}" class="form-control"></li>
				   <li>OR Email <input type="email" id="customer_email" name="customer_email" value="" type="email" class="form-control"></li> 
				   <li>OR School Id 					  <select name="searchschool_id" id="searchschool_id" class="form-control valid">
					  <option value="0">Select School</option>
					<?php foreach($studentschool as $schoolname){   
						
					?>
					  <option value="<?php echo $schoolname->id; ?>" ><?php echo $schoolname->school_name; ?></option>
					<?php
					} 
					?>
</select></li> 
				   <li><button type="submit" class="btn btn-primary">Submit</button></li>
				   </ul>
				   </form>
                </div>
                </div>
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
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    
                    <div class="panel">
                        
                        <!-- /.panel-heading -->
                        <div class="table-responsive">
                            <div class="dataTable_wrapper">
							    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead class="text-primary">
                                 <th>
                                                Id. 
                                            <?php if($ordercol=='id'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=id&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=id&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url($folder_admin.'/Add_Order/')?>?col=id&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?>
                                            </th>
                                            <th>Name<?php if($ordercol=='firstname'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=firstname&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=firstname&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url($folder_admin.'/Add_Order/')?>?col=firstname&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?></th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Reg. Date
                                                
                                            <?php if($ordercol=='created_dt'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=created_dt&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=created_dt&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url($folder_admin.'/Add_Order/')?>?col=created_dt&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?>
                                            </th>
                                            <th>Targated Exam</th>
                                            <th>Action</th>
                                    <tbody>
<?php
$i = 1;
if (isset($customers)) {
	foreach ($customers as $customer) { 
if($customer->is_social==3){
    $register_point = "franchise";
}else{
if($customer->is_social==2){   
    $register_point = "Android App"; 
}else{ 
    if($customer->fbid!=''){
        $register_point = "Facebook"; 
    }else  if($customer->twitterid!=''){
        $register_point = "Twitter"; 
    }else if($customer->googleplusid!=''){
     $register_point = "Gmail";
    }else{
     $register_point = "Other";
    }
}
    }
	
// print_r($chapters);
	?>
       <tr class="odd gradeX">
                                    <td><?php echo $customer->id;?></td>
                                    <td><?php echo $customer->firstname.' '.$customer->lastname; ?>
                                    </td>
                                    <td><?php echo $customer->email;?></td>
                                    <td><?php echo $customer->mobile;?></td>
                                    <td><?php
                                            if (!empty($customer->created_dt)) {
                                                echo date('d/m/Y',$customer->created_dt);
                                            }
                                        ?> 
                                    </td>
                                        <td><?php
										if(isset($customer->targate_exam)&&$customer->targate_exam!=''){
										$texam_string=$customer->targate_exam;
										$texam_array=explode(',',$texam_string);
		$cntr=0;
$examname_value='';
foreach($texam_array as $texam_id){
	$examname_array=$this->Categories_model->getCategoryDetails($texam_id);
	if(count($texam_array)>1){
		if($cntr==0){
			$examname_value .='';	
		}else{
$examname_value .=', ';	
		}
}
$examname_value .=$examname_array->name;
$cntr++;
}
						
										
										echo $examname_value;
                                        }else{
											echo 'N.A.';
										}
										?></td>
                                    <td class="center">
                                        <?php //$ferEncodeUrl=base_url().$folder_admin.'/add_order/productlist'; 
										
										$linkToUserAcc=base_url().'Common/FranchiseUser_login';
										?>
                                        <form name="loginform" id="loginform" novalidate="novalidate" method="POST" action="<?php echo $linkToUserAcc ;?>" target="_blank">  
  									    <input type="hidden" name="loginFranId" id="loginFranId" value="<?php echo $franchiseid=$this->session->userdata('userid'); ?>"> 
										<input type="hidden" name="loginpassword" id="loginpassword" value="999999"> 
										<input type="hidden" name="loginemail" id="loginemail" value="<?php echo urlencode($customer->email);?>">
<input type="hidden" name="bypass_login_id" id="bypass_login_id" value="<?php echo urlencode($customer->id);?>">										
                                        <input type="hidden" name="studentid" value="<?php echo urlencode($customer->id);?>" >
                                        <input type="hidden" name="studentemail" value="<?php echo urlencode($customer->email);?>" >
                                        <input type="submit" value="Add Order" name="add_order" class="btn btn-primary">
                                        </form>
                                    </td>
       </tr>
                <?php
                $i++;
    }
}
?>                          </tbody>
                                 <tfoot>
                                     <tr>
                                         <td colspan="7">
<?php
echo "<h6><b>";
echo $this->pagination->create_links() . "</b></h6>";
?>
                                        </td>
                                     </tr>
                                 </tfoot>
                               </table>
                            </div>
                            <!-- /.table-responsive -->                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>   