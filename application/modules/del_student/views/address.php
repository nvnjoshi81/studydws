<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Hello <?php echo $this->session->userdata['customer_name']; ?></b></h4>
        </div>
        <div class="modal-body">
          <div class="panel panel-default">
				<div class="panel-heading">
						<div style="font-weight:bold;"><i class="material-icons">account_circle</i>  Edit Shipping Addresses</div>
						
				</div>
				
					<div class="panel-body">
					<address>
					<input class="form-control" name="address_name" id="address_name" value="<?php echo $default_address->address_name; ?>" required><br>
					<input class="form-control" name="address" id="address" value="<?php echo $default_address->address; ?>" required> <br>
					<select class="form-control" name="state_name" id="state" onchange="getCity()">
                           <?php foreach($states as $key=>$state){  ?>
                           <option value="<?php echo $state->id; ?>" <?php echo $state->id==$default_address->state?'selected="selected"':'';?>><?php echo $state->state_name; ?></option>
                           <?php } ?>
                        </select><br>
					<select class="form-control" name="city" id="city">
					 <?php foreach($cities as $city){ ?>
                           <option value="<?php echo $city->id; ?>" <?php echo $city->city_name==$default_address->city_name?'selected="selected"':'';?>><?php echo $city->city_name; ?></option>
                           <?php } ?>
                     </select><br>
					<input class="form-control" name="mobile" id="mobile" value="<?php echo $default_address->mobile; ?>" required><br>
					<input class="form-control" name="zipcode" id="zipcode" value="<?php echo $default_address->zipcode; ?>" required><br>
					<input type="hidden" name="address_id" value="<?php echo $default_address->id;?>">
					</address>
					</div>
					</div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
          <button type="cancel" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>