 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-9">
                    <h1 class="page-header">Orders</h1>    
            <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
         ?>
                </div>
                <div class="col-lg-3"><a href="<?php echo base_url(); ?>admin/orders"><h1 class="page-header">Back to List</h1></a>
				<a href="<?php echo base_url(); ?>admin/orders/cs_orders/<?php echo $order->user_id;
				?>" target="_blank"><h1 class="page-header">All Orders <?php 
				if(isset($shipping_addresses->address_name)){
					echo ' of '.$shipping_addresses->address_name;
				}
					?></h1></a></div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                          
<?php


//print_r($orders_products_array);
//Array ( [0] => stdClass Object ( [product_price] => 5400 [quantity] => 1 [name] => All JEE Physics Videos [price] => 6300 ) ) 
?>
                
                <div class="col-lg-12" >
                
                <div class="box-account box-info">
        
                   
    <table class="table ">

    <tbody>
        <?php //foreach($my_orders as $orders){ ?>
        <tr>
            <td colspan="2"><strong>Order # : <?php echo $order->order_no; ?>  | Order Date : <?php echo formatDate($order->created_dt); ?></strong>
            </td>
            
            <td>
                 <b>Order Status</b> : <?php 
                 
                 //print_r($orders_status_array);
                 
                 foreach($orders_status_array as $order_status){
                  
                 
               if($order->status==$order_status->id){
					echo '<span>'.$order_status->value.'</span>';
				}  
                 }
                 
                                
                                ?>
            </td>
            <td>&nbsp;<!--<a href="#">Reorder</a>--></td>
        </tr>
        <?php //} ?>
        <tr>
            <td><strong>Order Information</strong></td>
            <td><strong>Shipping Address</strong></td>
            <td>&nbsp;</td>
            <td><strong>Charges</strong></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><address>
		<?php if($shipping_addresses){ ?>
    <a target="_blank" href="<?php echo base_url(); ?>/admin/customers/edit/<?php echo $order->user_id; ?>">
		<?php echo $shipping_addresses->address_name; ?></a><br>
		<?php echo $shipping_addresses->address; ?> <br>
		<?php echo $shipping_addresses->city_name; ?><br>
		<?php echo $shipping_addresses->state_name; ?><br>
		<?php echo $shipping_addresses->mobile; ?><br>
		<?php echo $shipping_addresses->zipcode; ?><br>
		<?php }
                ?>
                <?php if($customer->mobile!=''){ echo "Mobile-".$customer->mobile; } ?><br>                
                <?php if($customer->email!=''){ echo "Email-".$customer->email; } ?><br>
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

    </tbody>
</table>
    
        
    </div></div>
                
                
                <div class="col-lg-12">
                    
                    <div class="panel">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                              <div class="col-lg-12 clr-bth">
           
<div class="col-sm-6 well">
  <label>Items Ordered</label>
<div class="box-account box-info">        
                   
    <table class="table ">
    
    <thead>
      <tr>
        <th>Product Name</th>
		<th>Price</th>
		<th>Qty</th>
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
		 <td><a target="_blank" href="<?php echo base_url('admin/customers/prdcustcart/'.$myorders->product_id); ?>"><?php echo $myorders->name; ?></a></td>		 
		 <td><i class="fa fa-inr"></i> <?php 
                  echo get_orgprice($myorders->price,$myorders->discounted_price); ?></td>
		 <td><?php echo $myorders->quantity; ?></td>
		 <td><i class="fa fa-inr"></i>  <a target="_blank" href="<?php echo base_url(); ?>admin/orders/editOrdPrd/<?php echo $order->id.'/'.$order->user_id.'/'.$myorders->product_id;?>"><?php echo $myorders->product_price;  ?></a>&nbsp;
										 <a href="<?php echo base_url(); ?>admin/orders/deleteOrdPrd/<?php echo $order->id.'/'.$order->user_id.'/'.$myorders->product_id;?>">
                                            <i class="fa fa-trash cat-del"></i>
                                        </a><?php  ?></td>
		 <!--<td>&#8377; 7,000</td>-->
                </tr> 
	<?php } ?>
		<tr>
		  <th>Total</th>
		  <th></th>
		  <th><?php echo $total_purchase_qty; ?></th>
		  <th><i class="fa fa-inr"></i> <?php echo $total_purchase_price; ?></th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>Extra charges</th>
			<th><i class="fa fa-inr"></i> <?php echo  ($order->shipping_charges + $order->cod_charges); ?></th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><i class="fa fa-inr"></i> <?php echo ($order->shipping_charges + $order->cod_charges + $total_purchase_price); ?></th>
		</tr>
    </tbody>
  </table>
    </div>
    <a target="_blank" href="<?php echo base_url('Welcome/a/'.$order->user_id); ?>">View User's Order</a>		
	<?php
	$orderid = $order->id;
	$customerid = $order->user_id;
	?>
	
	<a target="_blank" href="<?php echo base_url(); ?>admin/orders/add_product/<?php echo $orderid.'/'.$customerid; ?>" class="pull-right btn btn-primary alert-info">Add Product</a>
</div>
<?php 

          
           if(isset($cmsorders_array->status)){
            $order_status_id=$cmsorders_array->status;
               
           }else{
               $order_status_id='';
           }
           
           if(isset($cmsorders_array->id)){
            $orders_id=$cmsorders_array->id;
            $customer_email=$cmsorders_array->email;   
           }else{
               $orders_id=$oId;
               $customer_email='';
           }
           
  ?>
<?php if(($orders_id>0)){ ?>
<div class="col-sm-6 well">
  <form  enctype="multipart/form-data" id="add_category_form" method="post" action="<?php
echo base_url(); ?>/admin/orders/order_status_edit" onsubmit="return add_cont_validation();" >
    
      <input type="hidden" name="oId" value="<?php echo $orders_id; ?>">
      
      <input type="hidden" name="customer_email" value="<?php echo $customer_email; ?>">
      <input type="hidden" name="customer_mobile" value="<?php echo $customer->mobile; ?>">
      
    
    <div class="col-lg-12 clr-bth">
    <div class="form-group">
    <label>Update Order Status:&nbsp;</label><span class="new-list-spn"><?php echo generateSelectBox('order_status', $orders_status_array, 'id', 'value', 0, 'class="form-control"',$order_status_id); ; ?></span>
    </div>
    <!--
	<div class="form-group">
    <label>Orders Comments:&nbsp;</label><span class="new-list-spn"><textarea cols="57" rows="6"></textarea>
	</span>
    </div>
    -->
    <button type="submit" class="btn btn-primary">Submit</button>          
         </div>       
  </form>           
</div>                         
<div class="col-sm-6 well"><h3>Transfer Order</h3>
    <form id="trans_order_form" name="trans_order_form" method="post" action="<?php
echo base_url(); ?>/admin/orders/order_transfer" >
        <?php
        $shipping_id = $order->shipping_id;
        ?>
        <input type="hidden" name="shipping_id" value="<?php echo $shipping_id; ?>">
      <input type="hidden" name="oId" value="<?php echo $orders_id; ?>"> 
           <div class="col-lg-12 clr-bth" style="display:none;">
               <div class="form-group">
			   <label id="errmsg"></label></div>
    <div class="form-group" >
        <label>Transfer Order To:&nbsp;</label><span class="new-list-spn"><input type="text" name="user_id" id="user_id" value="<?php echo $order->user_id; ?>" ><br>(Enter Customer Id)</span>
    </div>

      <button type="submit" class="btn btn-primary">Submit</button>          
         </div>       
  </form> 
    
</div>
<?php } ?>
                            <!-- /.table-responsive Happy-->
                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
                <script>
$(document).ready(function () {
  //called when key is pressed in textbox
  $("#user_id").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Enter Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});
</script>
<style>#errmsg
{
color: red;
}</style>
