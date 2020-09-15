   <?php //echo validation_errors(''); 
   
   
   $break_host_array=substr($_SERVER['HTTP_HOST'],-3);
if($break_host_array=='cal'){
    $bodycss='';
    $bodydisplay='';
}else{
  $bodycss='bg-danger';
    $bodydisplay='display:none;';  
}
   ?>
       
    <div class="container <?php echo $bodycss;?>" >
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"  >Please Sign <a  onclick='relationMod("show")';>In</h3>
                    </div>
                    <div class="panel-body" id='rele-section' style='<?php echo $bodydisplay; ?>'>
                  <div id="error-msg"></div>
                    <div id="log-success-msg"></div>
                    <?php  if(isset($msg)) { echo $msg; }?>
                        <form role="form" method="post"  id="admin-login" action="<?php echo base_url(); ?>admin/login/login_check">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email"  id="aemail" type="text" value="" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password"  id="apassword" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                               <!-- <a href="<?php echo base_url(); ?>admin/login" class="btn btn-lg btn-success btn-block">Login</a>-->
                           
							  <input type="submit" name="submit" value="<?php if($bodycss==''){ echo 'Localhost'; }else{ echo 'This is live Site'; }?>" class="btn btn-lg btn-success btn-block" />

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script type="text/javascript">
function relationMod(parm){
	if(parm=='show'){
document.getElementById("rele-section").style.display = "block";
	}else{
document.getElementById("rele-section").style.display = "none";
	}
}
</script>