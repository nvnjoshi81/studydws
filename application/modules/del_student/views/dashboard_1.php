<style>
.blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {  
  50% { opacity: 0.0; }
}
</style>
<div class="container">
            <div class="row">
            
            
            <div class="col-md-3 my_account"> 
   
    <?php $this->load->view('customer/menu'); ?>



    
    
    </div>
            
            
            
            
            <div class="col-sm-9 my_account_right">
			<?php if($this->session->flashdata('update_msg')){ ?>
			<div class="alert alert-success alert-dismissible" id="success-alert" role="alert">
			  
			  <strong><?php echo $this->session->flashdata('update_msg'); ?></strong>
			</div>
			<?php } ?>
        <div class="my-account"><div class="dashboard">
    <div class="page-title">
        <h1>My Dashboard</h1>
    </div>
    <div class="welcome-msg">
    <p><strong>Hello, <?php if($user_info){ echo $user_info->firstname; ?>&nbsp;<?php echo $user_info->lastname; }?>!</strong></p>
    <p>From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.</p>
</div>

<div class="box-account box-info">
        <div class="box-head">
       
         <p>
         <span aria-hidden="true" class="glyphicon glyphicon-user"></span><strong>Account Information</strong>  </p>
        </div>
                        <div class="row">
    <div class="col-xs-6">
        <div class="box">
            <div class="box-title">
                <h3>Contact Information</h3>
                <a href="<?php echo base_url(); ?>customer/myaccount">Edit</a>
            </div>
			
            <div class="box-content">
			<?php if($user_info) { ?>
                <p>
                    <b><?php echo $user_info->firstname; ?>&nbsp;<?php echo $user_info->lastname; ?></b><br>
                    <b><?php echo $user_info->email; ?></b><br>
                </p>
			<?php } ?>
            </div>
        </div>
    </div>
        <div class="col-xs-6">
        <div class="box">
            <div class="box-title">
                <h3>Newsletters</h3>
                <a href="#">Edit</a>
            </div>
            <div class="box-content">
                <p>
                                            You are currently not subscribed to any newsletter.                                    </p>
            </div>
        </div>
                    </div>
    </div>
    
    
        <div class="row">
    <div class="col-xs-12">
        <div class="box-title">
            <h3>Address Book</h3>
            <a href="<?php echo base_url() ?>customer/addresses">
			<?php if($default_address){ ?>
			Manage Addresses
			<?php } else {?>
			<span class="blink_me">Add New Address</span>
			<?php } ?>
			</a>
        </div>
        <div class="box-content">
            <div class="col-xs-6">
               
			<div class="panel panel-default">
				<div class="panel-heading">
						<div style="font-weight:bold;">Default Shipping Addresses</div>
						
				</div>
				
					<div class="panel-body">
						<address>
						<?php if($default_address){ ?>
						<?php echo $default_address->address_name; ?><br>
						<?php echo $default_address->address; ?> <br>
						<?php echo $default_address->city_name; ?><br>
						<?php echo $default_address->state_name; ?><br>
						<?php echo $default_address->mobile; ?><br>
						<?php echo $default_address->zipcode; ?><br>
						<?php } else{ echo "<b>Add your address</b>"; }?>
						</address>
                    
                    </div>
				
			</div>
            </div>
            <div class="col-xs-6">
                
				<?php foreach($user_address as $row){ ?>
				<div class="panel panel-default">
				<div class="panel-heading">
						<div style="font-weight:bold;">Additional Address</div>
						
				</div>
					
					<div class="panel-body">
					<?php echo $row->address_name; ?>
                    <address>
                    <b><?php echo $row->address ?></b><br>
					
                    <?php echo $row->city_name; ?><br>
					<?php echo $row->state_name; ?><br>
					<?php echo $row->mobile; ?><br>
					<?php echo $row->zipcode; ?><br>
                    </address>
					</div>
                   
                   <?php } ?>
			</div>
			
			</div>
        </div>
    </div>
</div>
    </div>
<!---------------------->
<div class="box-account box-info">
        <div class="box-head">
       
         <p>
         <span aria-hidden="true" class="glyphicon glyphicon-list-alt"></span><strong>Recent Order</strong><a  class="pull-right" href="<?php echo base_url(); ?>customer/orders">
		 <?php if($my_orders){ ?>
		 View all
		 <?php } ?>
		 </a></p>
        </div>
         <?php if($my_orders){ ?>          
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
      <?php foreach($my_orders as $orders){ ?>
      <tr>
        <td><?php echo $orders->order_no; ?></td>
        <td><?php echo date('d-m-Y h:i A',$orders->created_dt); ?></td>
        <td><?php echo $orders->address_name; ?></td>
        <td><?php echo $orders->final_amount; ?></td>
		<?php if($orders->status==0){ ?>
        <td>Pending</td>
		<?php } elseif($orders->status==1){?>
		<td>Completed</td>
		<?php } else {?>
		<td>Cancelled</td>
		<?php } ?>
        <td><a href="<?php echo base_url(); ?>customer/orderdetails/<?php echo $orders->id; ?>">View Order</a></td>
      </tr>
	<?php } ?>
    </tbody>
  </table>
		 <?php } else{ echo "<b>You have not placed any order yet</b>"; }?>
        
    </div>



        
        </div></div>	</div>
            
            
            
            
            
            
      
                
            </div>
            
           
        </div>
		