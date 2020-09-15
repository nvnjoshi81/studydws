<!-- middle content-start -->

      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Edit Profile</h4>
                  <p class="card-category">Complete your profile</p>
                </div>
				<?php
if(isset($getAdminUser)){
?>
                <div class="card-body">
				<form>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Company </label>
                          <input type="text" class="form-control" disabled value="<?php  if(isset($getAdminUser->company)){ echo $getAdminUser->company; } ?>" >
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email address</label>
                          <input type="email" class="form-control" disabled value="<?php  if(isset($getAdminUser->email)){ echo $getAdminUser->email; } ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Fist Name</label>
                          <input type="text" class="form-control" disabled value="<?php if(isset($getAdminUser->first_name)){ echo $getAdminUser->first_name;} ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Last Name</label>
                          <input type="text" class="form-control" disabled value="<?php  if(isset($getAdminUser->last_name)){ echo $getAdminUser->last_name; } ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Adress</label>
                          <input type="text" class="form-control" disabled value="<?php if(isset($getAdminUser->address)){ echo $getAdminUser->address;} ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">City</label>
                          <input type="text" class="form-control" disabled value="<?php if(isset($getAdminUser->city)){ echo $getAdminUser->city;} ?>">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">State</label>
                          <input type="text" class="form-control" disabled value="<?php if(isset($getAdminUser->state)){ echo $getAdminUser->state;} ?>">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Postal Code</label>
                          <input type="text" class="form-control" disabled value="<?php if(isset($getAdminUser->postcode)){ echo $getAdminUser->postcode;} ?>">
                        </div>
                      </div>
                    </div>
					<!--
                    <button type="submit" class="btn btn-primary pull-right">Update Profile</button>-->
                    <div class="clearfix"></div>
                  </form>
                </div>
				<?php }else{
					echo 'No information Found!';
					
				}?>
              </div>
            </div>
            </div>
          </div>
        </div>
      