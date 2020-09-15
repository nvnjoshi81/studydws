<div id="wrapper">
<div class="container">
            <div class="row">
            <?php 
            if ($this->session->flashdata('address_message')) {
                ?>
                <div class="alert alert-success alert-dismissible"> <?php echo $this->session->flashdata('address_message'); 
                ?>
                </div>
                <?php
            }
            if($this->session->flashdata('update_msg')){  if($this->session->userdata('redirect_to_cart')=='yes'){
                $this->session->set_userdata('redirect_to_cart', '');
                redirect('cart');
                
            }?>
			<div class="alert alert-success alert-dismissible" id="success-alert" role="alert">
			<strong><?php echo $this->session->flashdata('update_msg'); ?></strong>
			</div>
			<?php } ?> 
                <?php
            if ($this->session->flashdata('message')) {
                ?>
                <div class="alert alert-success alert-dismissible"> <?php echo $this->session->flashdata('message'); 
                ?>
                </div>
                <?php
            }
            ?>
            <?php $this->load->view('customer/breadcrumb');?>
            <div class="col-xs-12 col-md-3 col-sm-3 my_account"> 
   
    <?php $this->load->view('customer/menu'); ?>
    
    </div>  
    <div class="col-xs-12 col-sm-9">
    <div class="my-account">
    <div class="subline-title">
			<h4>Add New Address</h4>
		</div>
		 
		
					<div class="col-sm-12 col-md-6">
						<div class="widget-content" id="akki" style="display:">
                  <form method="post" action="" role="form" name="addAddress" id="addAddress">
                      <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('customer_id');?>">
                      <div class="form-group has-success label-floating is-empty">
                        <label class=" " for="name">Full Name</label>
                        <input type="text" placeholder="Full Name" class="form-control" id="address_name" name="address_name" value="<?php echo $user_details->firstname.' '.$user_details->lastname; ?>">
                     </div>
                      <div class="form-group has-success label-floating is-empty">
                        <label class=" " for="ad1">Default Address:</label>
                        <input type="text" class="form-control" placeholder="Address1" id="address" name="address">
                     </div>
                      <div class="form-group has-success label-floating is-empty">
                        <label class=" " for="ad1">Address 2:</label>
                        <input type="text" class="form-control" placeholder="Address2" id="address2" name="address2">
                     </div>
                     <div class="form-group has-success label-floating is-empty">
                        <label class=" " for="ad1">Pincode</label>
                        <input type="text" class="form-control" placeholder="Pincode" id="zipcode" name="zipcode">
                     </div>
                      <div class="form-group has-success label-floating is-empty">
                        <label class=" " for="stare">State</label>
                        <select class="form-control" name="state_name" id="state" onchange="getCity()">
                            <option value="">Please Select</option>
                           <?php foreach($states as $state){ ?>
                           <option value="<?php echo $state->id; ?>"><?php echo $state->state_name; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                     <div class="form-group has-success label-floating is-empty">
                        <label class=" " for="city">City</label>
                        <select class="form-control" name="city" id="city">
                        </select>
                     </div>
                      <div class="form-group has-success label-floating is-empty">
                        <label class=" " for="mob">Mobile No.</label>
                        <input type="text" placeholder="Mobile" class="form-control" id="mobile" name="mobile" value="<?php echo $user_details->mobile; ?>">
                        <input type="hidden" placeholder="Mobile" class="form-control" id="user_id" name="user_id" value="<?php echo $this->session->userdata['customer_id']; ?>">
                        <input type="hidden" placeholder="Mobile" class="form-control" id="country" name="country" value="1">
                     </div>
                     <button type="submit" class="btn btn-raised btn-warning">Save Address</button>
                     <!--<button type="buttom" class="btn btn-warning">Cancel</button>-->
                  </form>
                   <span class="pull-right"></span>
               </div>
					</div>
                    
                    <div class="col-sm-12 col-md-6">
                    <p>
                    <img alt="adversite" src="/assets/images/610adv.jpg" class="img-responsive"></p>
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
      <div class="modal-content">
        
      </div>
      </form>
    </div>
  </div>
		<!---------Edit address pop up------------->


 