<div id="wrapper">
<div class="container">
            <div class="row">
            <?php if($this->session->flashdata('update_msg')){ ?>
			<div class="alert alert-success alert-dismissible" id="success-alert" role="alert">
			<strong><?php echo $this->session->flashdata('update_msg'); ?>
			</strong>
			</div>
			<?php } ?>
            <?php $this->load->view('customer/breadcrumb');?>
            <div class="col-md-3 col-sm-3 my_account"> 
   
    <?php $this->load->view('customer/menu'); ?>
    </div>      
    <div id="showbught_result" class="my_account_right"></div>
    <div class="col-sm-9 my_account_right" id="recent_orderdiv">
        <div class="my-account">
            <div class="dashboard">
                <div class="clearfix"> </div>
    <div class="subline-title">
			<h4>Recent orders</h4>
    </div>
    <div class="subline-title">
        <span>Note - You can <a href="<?php echo base_url('user/library'); ?>"><b>View Or Download</b></a> your study material from Dashboard.We recommend that Please check My Account dashboard after successful payment as we can activate the link only after payment is successful and Order Status is completed.&nbsp;<a class="text-danger" title="View Download" href="<?php echo base_url('user/library'); ?>"><i class="material-icons">system_update_alt</i>View/Download</a></span></div>
<?php if($my_orders){ ?>
<div data-example-id="togglable-tabs" class="bs-example bs-example-tabs">
    <div class="tab-content" id="myTabContent">
      <div aria-labelledby="home-tab" id="home" class="tab-pane fade in active" role="tabpanel">
      <div class="table-responsive"><table class="table table-hover">
    <thead>
      <tr>
        <th>Orders #</th>
        <th>Date</th>
        <!--<th>Ship to</th>-->
        <th>Order total</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
	<?php foreach($my_orders as $orders){ ?>
      <tr>
        <td><?php echo $orders->order_no; ?></td>
        <td><?php echo formatDate($orders->created_dt); ?></td>
        <!--<td><?php //echo $orders->address_name; ?></td>-->
        <td><i class="fa fa-inr"></i> <?php echo $orders->final_amount; ?></td>
		<td><?php foreach($orders_status_array as $order_status){
               if($orders->status==$order_status->id){
					echo $order_status->value;
				}  
                 }
		?></td>
		
        <td><a href="<?php echo base_url(); ?>customer/orderdetails/<?php echo $orders->id; ?>"><i class="fa fa-external-link-square" aria-hidden="true"></i></a></td>
      </tr>
	<?php } ?>
    </tbody>
  </table>
  </div>
  <?php echo '<div class="pagination" align="center">'.$this->pagination->create_links().'</div>'; ?>
      </div>
      
    </div>
  </div>
<?php }else{ 
echo "<b>You had not placed any order yet</b>";
}
?>
</div> 
        </div>	
    </div></div>
           
        </div>
</div>