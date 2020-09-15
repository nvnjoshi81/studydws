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
    <div class="col-sm-9">
      <div class="my-account">
       <div class="subline-title">
			<h4>Address Book</h4>
		
		 
        
        <?php if($default_address){ ?>
        <div class="col-xs-12 col-sm-5 address_book_right">
          <div class="subline-title">
            <h5>DEFAULT ADDRESS </h5>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <div style="font-weight:bold;">Default Shipping Addresses</div>
            </div>
            <div class="panel-body">
              <address>
              <?php echo $default_address->address_name; ?><br>
              <?php echo $default_address->address; ?> <br>
              <?php echo $default_address->city_name; ?><br>
              <?php echo $default_address->state_name; ?><br>
              <?php echo $default_address->mobile; ?><br>
              <?php echo $default_address->zipcode; ?><br>
              </address>
              <div class="col-sm12 pull-right address-actions"> <a href="<?php echo base_url()?>customer/address/<?php echo $default_address->id?>" title="Edit Address" data-toggle="modal" data-target="#editAddress">Edit</a>
                <!--<a href="" title="Delete Address">Delete</a>-->
              </div>
            </div>
            <?php }?>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="address_book_right add_ress clearfix">
          <div class="subline-title">
            <h5>ADDITIONAL ADDRESSES ENTRIES</h5>
            <?php if($user_info){ ?>
            <?php foreach($user_info as $row){ ?>
            <div class="panel panel-default">
              <div class="panel-heading">
                <div style="font-weight:bold;">Address</div>
              </div>
              <div class="panel-body"> <?php echo $row->address_name; ?>
                <address>
                <?php echo $row->address ?><br>
                <?php echo $row->city_name; ?><br>
                <?php echo $row->state_name; ?><br>
                <?php echo $row->mobile; ?><br>
                <?php echo $row->zipcode; ?><br>
                </address>
                <div class="col-sm12 pull-right address-actions"> <a href="<?php echo base_url() ?>customer/welcome/setdefault/<?php echo $row->id; ?>" onClick="return confirm('Are you sure you want to set this address as a default address?')" title="Set this as default address">Set Default</a> | <a href="<?php echo base_url()?>customer/welcome/address/<?php echo $row->id?>" data-toggle="modal" data-target="#editAddress">Edit</a> | <a onclick="confirm('Are you sure you want to delete this address?')" href="<?php echo base_url()?>customer/welcome/deleteAddress/<?php echo $row->id?>">Delete</a>
                  <!--<a href="" title="Delete Address">Delete</a>-->
                </div>
              </div>
            </div>
            <?php }} else{
                ?>
            You have no additional addresses. Click on <a href="<?php echo base_url()?>customer/addaddress"><font color="#15760C" font-weight="500" >ADD ADDRESS</font></a> column and add your address;
				<?php } ?>
          </div>
        
        <?php if(!$default_address){ ?>
    
        <div class="address_book_right add_ress">
          <div class="panel panel-primary">
            <div class="panel-heading">Add New</div>
            <div class="panel-body">
              <div class="widget-content" id="akki" style="display:">
                <form method="post" action="" role="form" name="addAddress" id="addAddress">
                  <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('customer_id');?>">
                  <div class="form-group has-success label-floating is-empty">
                    <label class="" for="name">Full Name</label>
                    <input type="text" class="form-control" id="address_name" name="address_name" value="<?php echo $user_details->firstname.' '.$user_details->lastname; ?>">
                  </div>
                  <div class="form-group has-success label-floating is-empty">
                    <label class=""  for="ad1">Default Address:</label>
                    <input type="text" class="form-control" placeholder="Address1" id="address" name="address">
                  </div>
                  <div class="form-group has-success label-floating is-empty">
                    <label class=""  for="ad1">Address 2:</label>
                    <input type="text" class="form-control" placeholder="Address2" id="address2" name="address2">
                  </div>
                  <div class="form-group has-success label-floating is-empty">
                    <label class="" for="ad1">Pincode</label>
                    <input type="text" class="form-control" placeholder="Pincode" id="zipcode" name="zipcode">
                  </div>
                  <div class="form-group has-success label-floating is-empty">
                    <label class="" for="stare">State</label>
                    <select class="form-control" name="state_name" id="state" onchange="getCity()">
                      <?php foreach($states as $state){ ?>
                      <option value="<?php echo $state->id; ?>"><?php echo $state->state_name; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group has-success label-floating is-empty">
                    <label class="" for="city">City</label>
                    <select class="form-control" name="city" id="city">
                    </select>
                  </div>
                  <div class="form-group has-success label-floating is-empty">
                    <label class="" for="mob">Mobile No.</label>
                    <input type="text" placeholder="Mobile" class="form-control" id="mobile" name="mobile" value="<?php echo $user_details->mobile; ?>">
                    <input type="hidden" placeholder="Mobile" class="form-control" id="user_id" name="user_id" value="<?php echo $this->session->userdata['customer_id']; ?>">
                    <input type="hidden" placeholder="Mobile" class="form-control" id="country" name="country" value="1">
                  </div>
                  <button type="submit" class="btn btn-raised btn-warning">Save Address</button>
                  <!--<button type="buttom" class="btn btn-warning">Cancel</button>-->
                </form>
                <span class="pull-right"></span> </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      
      </div>
    </div>
  </div>
</div>
</div>
<!---------Edit address pop up------------->
<div class="modal fade" id="editAddress" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form action="<?php echo base_url() ?>api/customer/editAddress" name="editAddress" id="editAddress" method="post">
      <div class="modal-content"> </div>
    </form>
  </div>
</div>
<!---------Edit address pop up------------->
