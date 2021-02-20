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
            <div class="col-sm-9 my_account_right">
                <div class="my-account">
                <div class="subline-title">
			<h4>Order Details</h4>
		</div>
        
		  <div class="dashboard">
			<div class="box-account box-info">
        
    <div class="table-responsive">          
    <table class="table">

    <tbody>
        <?php //foreach($my_orders as $orders){ ?>
        <tr>
            <td colspan="2"><strong>Order # : <?php echo $order->order_no; ?>  | Order Date : <?php echo formatDate($order->created_dt); ?></strong>
			<?php 
			if(isset($order->paytmorderid)&&$order->paytmorderid!=''){
				 ?>
			<br><strong>| Paytm TXN Id : <?php echo $order->txn_number; 
			?>
			</strong>
			<?php
			}
		
			if(isset($order->paytmorderid)&&$order->paytmorderid!=''){
			?>	<br><strong>
			| Paytm Order Id : <?php echo $order->paytmorderid;?></strong>
			<?php } ?>	
            </td>
            
            <td>
                 <b>Order Status</b> : <?php  foreach($orders_status_array as $order_status){
                  
                 
               if($order->status==$order_status->id){
					echo $order_status->value;
				}  
                 }
                 
            ?>
            </td>
            <td><button onclick="window.print();" class="label label-success">Print</button></td>
        </tr>
        <?php //} ?>
       <!-- <tr>
            <td><strong>Order Information</strong></td>
            <td><strong>Shipping Address</strong></td>
            <td>&nbsp;</td>
            <td><strong>Charges</strong></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><address>
		<?php if($shipping_addresses){ ?>
		<?php echo $shipping_addresses->address_name; ?><br>
		<?php echo $shipping_addresses->address; ?> <br>
		<?php echo $shipping_addresses->city_name; ?><br>
		<?php echo $shipping_addresses->state_name; ?><br>
		<?php echo $shipping_addresses->mobile; ?><br>
		<?php echo $shipping_addresses->zipcode; ?><br>
		<?php } ?>
		</address>
            </td>
            <td>Shipping charges
                <br>
                
                <br>
                <br>Extra charges</td>
            <td>
                <i class="fa fa-inr"></i> <?php echo $order->shipping_charges; ?>
                <br>
                
               
                <br><br>
                <i class="fa fa-inr"></i> <?php echo ($order->shipping_charges + $order->cod_charges); ?>
            </td>
        </tr>
-->
    </tbody>
</table>
    </div>  
        
    </div>

<br>
<label>Items Ordered</label>
<div class="box-account box-info">
        
    <div class="table-responsive">              
    <table class="table ">
    
    <thead>
      <tr>
        <th>Product Name</th>
	<!--	<th>Price</th>-->
		<th>Mode</th>
        <th>Amount</th>
        <!--<th>Subtotal</th>-->
       
      </tr>
    </thead>
    <tbody>
	
	<?php 
	$total_purchase_price=0;
	$total_purchase_qty=0;
	foreach($order_details as $myorders){ 
		$total_purchase_price+=$myorders->product_price;
		$total_purchase_qty+=$myorders->quantity;
              
	?>
		<tr>
		 <td><?php echo $myorders->name; ?></td>
		 
		 <td><?php echo $myorders->offline==0?'Online':'Online'; ?></td>
		 <td><i class="fa fa-inr"></i> <?php echo $myorders->product_price; ?></td>
		 <!--<td>&#8377; 7,000</td>-->
                </tr> 
	<?php } ?>
		<tr>
		  <th>Total</th>
		  
		  <th><?php echo $total_purchase_qty; ?></th>
		  <th><i class="fa fa-inr"></i> <?php echo $total_purchase_price; ?></th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			
			<th>Extra charges</th>
			<th><i class="fa fa-inr"></i> <?php echo  ($order->shipping_charges + $order->cod_charges); ?></th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			
			<th>&nbsp;</th>
			<th><i class="fa fa-inr"></i> <?php echo ($order->shipping_charges + $order->cod_charges + $total_purchase_price); ?></th>
		</tr>
    </tbody>
  </table>
    </div>
        
    </div>



        
				</div>
			</div>	
		</div>
            
            
            
            
            
            
      
                
            </div>
           
        </div>
    