 <?php ?>
  <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Change Password</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                <?php if(isset($this->session->userdata('msg'))){ ?>
                    <div class="alert alert-success" role="alert"><?php echo $this->session->userdata('msg');unset($_SESSION['msg']);?></div>
                <?php } ?>
<form class="set-form" id="passform" action="<?php echo base_url(); ?>admin/updatepass" method="post" >
    <div class="form-group">
    <?php
       //echo $settings_detail->site_name;
        foreach ($settings_detail as $key=>$value)
             {
   //print_r($value);
            } ?>
        <label>New Password</label>
        <input type="password" class="form-control" name="npassword" id="npassword" value="" autocomplete="off">
    </div>
   
    <div class="form-group">
        <label>Confirm New Password</label>
         <input type="password" class="form-control" name="cpassword" id="cpassword" value="" autocomplete="off">
    </div>
    <input type="hidden" name="userid" value="<?php echo $this->session->userdata('userid');?>"/>
    <button type="submit" class="btn btn-primary" name="submit">Update Password</button>
</form>
                </div>

                <!-- /.col-lg-12 -->
            </div>
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
        
<script type="text/javascript">
    
    $().ready(function() {
        // validate the comment form when it is submitted
        
        // validate signup form on keyup and submit
        $("#passform").validate({
            rules: {
              
                npassword: {
                    required: true,
                    minlength: 5
                },
                cpassword: {
                    required: true,
                    minlength: 5,
                    equalTo: "#npassword"
                }
            },
            messages: {
               
                npassword: {
                    required: "Please provide a new password",
                    minlength: "Your password must be at least 5 characters long"
                },
                cpassword: {
                    required: "Please confirm password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },
            }
        });
    });
</script>