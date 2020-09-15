<?php //echo validation_errors(''); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Franchise Please Sign In</h3>
                    </div>
					    <?php if($this->session->flashdata('msg')){ ?>
			<div class="alert alert-success alert-dismissible" id="success-alert" role="alert">
			  
			  <strong><?php echo $this->session->flashdata('msg'); ?></strong>
			</div>
			<?php } ?>
					
                    <div class="panel-body">
                  <div id="error-msg"></div>
                    <div id="log-success-msg"></div>
                    <?php  if(isset($msg)) { echo $msg; }
                   
                    $folder_admin=$this->config->item('dir_salesadmin'); 
                    
                    ?>
                        <form role="form" method="post"  id="admin-login" action="<?php echo base_url().$folder_admin; ?>/login/login_check">
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
                               <input type="submit" name="submit" value="Login" class="btn btn-lg btn-info btn-block" />

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>