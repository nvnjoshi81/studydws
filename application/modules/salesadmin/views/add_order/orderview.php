<!-- middle content-start -->
<div class="content">
     <?php if($this->session->flashdata('update_msg')){ ?>
	<div class="alert alert-success alert-dismissible" id="success-alert" role="alert">
	<strong><?php echo $this->session->flashdata('update_msg'); ?></strong>
    </div>
	<?php } ?>
        <div class="container-fluid">
          <div class="row">
		  <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary"> 
				<div class="col-lg-12 col-sm-12 col-md-12"> 
				  <h4 class="card-title">Orders</h4>
                  <p class="card-category">Order Details</p> 
				  </div>
                </div>
                <div class="card-body">
		    <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <!-- /.panel-heading -->
					    <div class="table-responsive" id="print1">
                            <div class="dataTable_wrapper">
<?php			
$i = 1;
$totalprice=0;
if(count($orderDetails)>0) {
	?>
	 <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                 <thead>				 
				 <tr><font size="3" face="verdana" color="green">

	Order Date# <?php                                

     if(!empty($orderDetails[0]->created_dt)) {
   echo date('d/m/Y',$orderDetails[0]->created_dt); }
                 ?> ||  
					Order Number#  <?php echo $orderDetails[0]->order_no;?> 
                                  || Order Status# <?php 
									echo $ord_status_array[$orderDetails[0]->status]->value;?></font>&nbsp;<a style="float: right;" href="#" onClick="printContent('print1');"  class="">Print Receipt</a>
				 </tr>
                                        <tr>
                                            <th width='5'>#</th>     
											
                                            <th width='50'>Product Name</th>
                                        
<th width='15'>Product Type</th>											 <th width='35'>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
	<?php
	$totalP=0;
	$totalDiscP=0;
	foreach ($orderDetails as $products) {
$totalprice=$totalprice+$products->discounted_price;
	?>
                                    <tr class="odd gradeX">
                                    <td><?php echo $i ; ?>
									</td>
                                    <td><?php echo $products->name; 
									?>
									</td>
									<td><?php 
									if($products->type==3){ echo "Online Test"
									;					
									}else if($products->type==2){
										echo "Video Lecture";
									}elseif($products->type==1){
										echo "Study Package"; 
									}else{
										echo "Study Material";
									}
									?></td>
                                    <td>Price:
									 <strike>INR <?php echo $products->price;
									 ?></strike>
									 <br>
									 Discounted Price:
									 INR 
									<?php echo $products->discounted_price; 
									?>
									</td>
</tr>
    <?php
     $i++;
	 
	 $totalP +=$totalP+$products->price;
	 
	 $totalDiscP +=$totalDiscP+$products->discounted_price;
	 
    }
	$dir_salesadmin=$this->folder_admin=$this->config->item('dir_salesadmin');
	?>
	 </table>
  <table  border="1" class="table table-striped table-bordered table-hover" id="dataTables-example"><tr class="odd gradeX"><h4>	
&nbsp;Billing Details</h4></tr>
  <tr class="odd gradeX">
  <td class="col-lg-8 col-sm-8 col-md-8"><address>
		<?php if(isset($shipping_addresses)){ ?>
    <a target="_blank" href="<?php //echo base_url(); ?>/admin/customers/edit/<?php //echo $order->user_id; ?>">
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
                
                
		</address></td>
  <td class="col-lg-4 col-sm-4 col-md-4">
  <?php
  $orgDiscount=$totalP-$totalDiscP;
  /*franchise discount amount*/
  $franchDiscount=$totalDiscP*10/100;
  ?>
	<table>
							<tr>
							<td>Amount:</td><td>
							<?php 
							$gsttotalP=$totalP*18/100;
							$finalTotalP=$totalP-$gsttotalP;
							echo  $finalTotalP;
							?>
									</td>
									</tr>
							
							<tr>
							<td>Tax on Amount(18.00%):</td><td>
							<?php 
							echo $gsttotalP;
							?>
									</td>
									</tr>
									<tr><td>Discount: </td><td>
									<?php echo '-'.$orgDiscount; 
									?>
									</td>
									</tr>
									<tr><td>Franchise Discount:</td><td>
									<?php echo '-'.$franchDiscount; 
									?>
									</td>
									</tr>
									<tr><td><font face="verdana" color="green" size="2">Net Payble:</font></td><td>
									<?php 
									$totaldiscount=$orgDiscount+$franchDiscount;
									$netPayble=$finalTotalP-$totaldiscount;
									?>
	<font face="verdana" color="green" size="2">INR <?php echo $netPayble+$gsttotalP; ?></font>
									</td>
									</tr>
									</table></td></tr>
	
	 </tbody>
                               </table>
	<?php
}else{
    ?>
<tr class="odd gradeX"><td colspan="6" >Order Not Found!</td></tr>
        <?php
    
}
?>       </div>                      
             
                            <!-- /.table-responsive -->
                            
                        <!-- /.panel-body -->
                    </div>        
         <tr class="odd gradeX"><td colspan="3" >
	<div class="col-sm-6 well">
  <form  enctype="multipart/form-data" id="add_category_form" method="post" action="<?php echo base_url().$dir_salesadmin; ?>/Add_Order/order_status_edit">
      <input type="hidden" name="oId" value="<?php echo $orders_id; ?>">
      
      <input type="hidden" name="customer_email" value="<?php echo $customer->email; ?>">
      <input type="hidden" name="customer_mobile" value="<?php echo $customer->mobile; ?>">
      <?php
	    if(isset($products->status)){
            $order_status_id=$products->status;
           }else{
            $order_status_id='';
           }
	  ?>
    
           <div class="col-lg-12 clr-bth">
    <div class="form-group">
    <label>Update Order Status:&nbsp;</label><span class="new-list-spn"><?php echo generateSelectBox('order_status', $ord_status_array, 'id', 'value', 0, 'class="form-control"',$order_status_id); ; ?></span>
    </div>
      <button type="submit" class="btn btn-primary">Submit</button>          
         </div>       
  </form>

                    
</div>
	</td></tr>                                           
                        
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
	</div>
</div>
</div>
</div>
</div>
</div><script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>