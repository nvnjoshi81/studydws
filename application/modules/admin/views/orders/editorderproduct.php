 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Orders</h1>    
            <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
         ?>
                </div>
             
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">  
                <div class="col-lg-12">
                    <div class="panel">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                              <div class="col-lg-12 clr-bth">
  
<?php 
           if(isset($orders_products_array->status)){
            $order_status_id=$orders_products_array->status;
               
           }else{
               $order_status_id='';
           }
           if(isset($orders_products_array->price)){
            $orderp_price=$orders_products_array->price;
               
           }else{
               $orderp_price='';
           }
		   
		   
           if(isset($orders_products_array->paytype)){
            $paytype=$orders_products_array->paytype;
               
           }else{
            $paytype='';
           }
		   
		   
		   
		   if(isset($orders_products_array->odid)){
            $odid=$orders_products_array->odid;
               
           }else{
               $odid='';
           }
           
		   
           if(isset($orders_products_array->id)){
            $orders_id=$orders_products_array->id;
            $customer_email=$orders_products_array->email;   
           }else{
            $orders_id=$oId;
            $customer_email='';
           }
		   
		   
		   
		      if(isset($orders_products_array->product_id)){
            $productid=$orders_products_array->product_id;
               
           }else{
               $productid='';
           }
           
		      if(isset($orders_products_array->user_id)){
            $userid=$orders_products_array->user_id;
               
           }else{
               $userid='';
           }
           
  ?>
<?php 
if(($orders_id>0)){ ?>
<div class="col-sm-12 well">
  <form  enctype="multipart/form-data" id="add_category_form" method="post" action="<?php
echo base_url(); ?>/admin/orders/order_price_edit">
    
      <input type="hidden" name="oId" value="<?php echo $orders_id; ?>">
	  <input type="hidden" name="odid" value="<?php echo $odid; ?>">
	  
      <input type="hidden" name="userid" value="<?php echo $userid; ?>">
      <input type="hidden" name="productid" value="<?php echo $productid; ?>">
   
    <div class="col-lg-4 clr-bth">
 	    <div class="form-group" >
        <label>Order Product Price&nbsp;</label><span class="new-list-spn"><input type="text" name="orderproductprice" id="orderproductprice" value="<?php echo $orderp_price; ?>" ></span>
    </div>
	
        <label>Pay Type&nbsp;</label>
	<div class="form-group">
	<?php 
	$order_paytype=$this->config->item('order_paytype');
	if(isset($order_paytype)){
	?>
		<span class="new-list-spn">
		<select name="paytype" id="paytype">
		<?php foreach($order_paytype as $ordkey=>$ordval ){ 
		
		if($ordval==$paytype){
		$selected='selected=selected';	
		}else{
		$selected='';
		}
		?>
		<option <?php echo $selected; ?> value="<?php echo $ordval ; ?>"><?php echo ucfirst($ordval) ; ?>
		</option>
		<?php } ?>
		</select>
		</span>
	<?php } ?>
    </div>
	 </div> 
  <div class="col-lg-6 col-md-6 col-sm-6 clr-bth">
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
<style>#errmsg
{
color: red;
}</style>
