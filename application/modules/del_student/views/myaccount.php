<div id="wrapper">
<div class="container">
            <div class="row">
            <?php if($this->session->flashdata('update_msg')){ ?>
	<div class="alert alert-success alert-dismissible" id="success-alert" role="alert">			  
	<strong><?php echo $this->session->flashdata('update_msg'); ?></strong>
	</div>
			<?php } ?>
    <?php $this->load->view('customer/breadcrumb');?>
    <div class="col-md-3 col-sm-3 my_account"> 
    <?php $this->load->view('customer/menu'); ?>
    </div>
    <div class="col-sm-9 col-md-9 my_account_right">
	<div class="row my-account">
            <?php 
                          $targate_exam_string=$user_info->targate_exam;
                          $targate_exam_array=explode('_', $targate_exam_string);
                          if(isset($targate_exam_array[0])&&$targate_exam_array[0]==''){
                          ?>
            <div style="padding-bottom:7px"><span class="alert alert-danger">Please select the exam you are Targeting for!</span></div>
                          <?php  } ?>
		<div class="subline-title">                 
			<h4>Profile Information</h4>
		</div>
	<?php if($user_info) { ?>
            
	<form role="form" action="<?php echo base_url(); ?>customer/updatecustomer" name="update_customer_info" id="update_customer_info" method="post">
            
            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <label class=""  for="email">Target Exam:</label>
                                        <?php 
                                        foreach($mainexamcategories as $t_exam){
                                            $t_exam_id= $t_exam->id;
                                            $t_exam_name= $t_exam->name;
                                            $checked_exam='';
                                        if(in_array($t_exam_id,$targate_exam_array)){
                                            $checked_exam='checked="checked"';
                                        }
                                        ?>
                                        <input type="checkbox" name="targate_exam[]" id="targate_exam_<?php echo $t_exam_id; ?>" value="<?php echo $t_exam_id; ?>"  <?php echo $checked_exam; ?> >                      <?php
                                            echo $t_exam_name.'&nbsp;';
                                        }
                                        ?>
               <span class="material-input"></span>
            </div>  
        
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label class="text-body" for="firstname">First-Name :<em>*</em></label>
  <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $user_info->firstname; ?>">
  		<!--<span class="help-block">Please enter a first name</span>-->
                <span class="material-input"></span>
        </div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <label class="" for="lastname">Last-Name :<em>*</em></label>
  <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $user_info->lastname; ?>">
                <span class="material-input"></span>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
            <?php 
            $selectStudent='';
            $selectTeacher='';
            $selectParent='';
            
            if(isset($user_info->usertype)&&$user_info->usertype=='student'){
            $selectStudent='checked="checked"';
            } 
            if(isset($user_info->usertype)&&$user_info->usertype=='teacher'){
            $selectTeacher='checked="checked"';  
            } 
            if(isset($user_info->usertype)&&$user_info->usertype=='parent'){
            $selectParent='checked="checked"';
            } 
            if($selectStudent==''&&$selectTeacher==''&&$selectParent==''){
            $selectStudent='checked="checked"';
            }
            ?>
            <label for="usertype">I Am :<em>*</em></label><br>&nbsp;
            <input type="radio" name="usertype" value="student" <?php echo $selectStudent; ?> >&nbsp;Student&nbsp;|&nbsp;<input type="radio" name="usertype" value="teacher" <?php echo $selectTeacher; ?>>&nbsp;Teacher&nbsp;|&nbsp;<input type="radio" name="usertype" value="parent" <?php echo $selectParent; ?> >&nbsp;Parent
            <span class="material-input"></span>
        </div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">            
            <label class=""  for="mobile"> Mobile:</label>
             <input type="text" class="form-control" name="mobile" id="mobile" value="<?php echo $user_info->mobile; ?>">
                <span class="material-input"></span>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
        <label class=""  for="email"> Email: <em>*</em></label>
					<?php 
                                        if(isset($user_info->email)&&$user_info->email!=''){
                                        echo $user_info->email;
                                        ?>
                                        <input type="hidden" name="email" value="<?php echo $user_info->email; ?>">
                                        <?php
                                        }else{
                                            ?><input type="text" class="form-control" name="email" id="email" value="<?php echo $user_info->email; ?>" required="">
                                        <?php
                                        }
                                        ?>
               <span class="material-input"></span>
        </div>
        <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
             <p class="required">* Required Fields</p>
        <button class="btn btn-raised btn-warning" type="submit"><span><span>Save</span></span></button><input type="hidden" name="user_id" value="<?php echo $user_info->id; ?>">
        </div>
        <div class="clearfix"></div>
    </form>
    <?php } ?>
    <div class="clearfix"></div>

    <br /><br />
	</div>
    </div>
            </div>
        </div>
</div>      