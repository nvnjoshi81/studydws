<div class="container">
            <div class="row">
            
            
            <div class="col-md-3 my_account"> 
   
    <?php $this->load->view('customer/menu'); ?>



    
    
    
    
    </div>
            
            
            
            
            <div class="col-sm-9 my_account_right">
        <div class="my-account"><div class="dashboard">
    <div class="page-title">
        <h1>Order History</h1>
    </div>
    
<!--<div class="box-account">
 <div class="col-sm-4"><label>Items (s)</label></div>    <div class="col-sm-3 pull-right">
  <div class="form-inline">show&nbsp;&nbsp;<select class="form-control">
                    <option>1</option><option>2</option>
                    </select>&nbsp;&nbsp;per page</div>
  
</div>
<table class="table table-hover">
    <thead>
      <tr>
        <th>Order #</th>
        <th>Date</th>
        <th>Ship to</th>
        <th>Order total</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
	
    </tbody>
  </table>

<div class="col-sm-4"><label>Items (s)</label></div>    <div class="col-sm-3 pull-right">
  <div class="form-inline">show&nbsp;&nbsp;<select class="form-control">
                    <option>1</option><option>2</option>
                    </select>&nbsp;&nbsp;per page</div>
  
</div>
</div>-->
<?php if($past_orders) {?>
<div data-example-id="togglable-tabs" class="bs-example bs-example-tabs">
    <ul role="tablist" class="nav nav-tabs" id="myTabs">
      <li class="active" role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="home-tab" href="#profile">Past orders</a></li>
      
    </ul>
    <div class="tab-content" id="myTabContent">
      
      <div aria-labelledby="profile-tab" id="profile" class="tab-pane fade in active" role="tabpanel">
			<table class="table table-hover">
    <thead>
      <tr>
        <th>Order #</th>
        <th>Date</th>
        <th>Ship to</th>
        <th>Order total</th>
        <th>Status</th>
        <!--<th>Action</th>-->
      </tr>
    </thead>
    <tbody>
		<?php foreach($past_orders as $oldorders){ ?>
		<tr>
			<td><?php echo $oldorders->order_no; ?></td>
			<td><?php echo $oldorders->order_date; ?></td>
			<td><?php echo $user_info->firstname; ?></td>
			<td><?php echo $this->config->item('currency').$oldorders->totalbill; ?></td>
			<?php if($oldorders->order_status==0){ ?>
			<td><?php echo "Pending"; ?></td>
			<?php } else{?>
			<td><?php echo "Completed"; ?></td>
			<?php } ?>
			<!--<td><a href="<?php echo base_url() ?>customer/pastorderdetails/<?php echo $oldorders->order_no; ?>">View Details</a></td>-->
		</tr>
		<?php } ?>
    </tbody>
  </table>
  <?php echo '<div class="pagination" align="center">'.$this->pagination->create_links().'</div>'; ?>    
      </div>
      
   
    </div>
  </div>
<?php } else{ echo "You have no past orders"; }?>

        
        </div></div>	</div>
            
        
            
            
            
            
      
                
            </div>
           
        </div>
    