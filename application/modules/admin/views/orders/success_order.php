<div id="page-wrapper">
			<!-- search bar -->
			<?php  
			//$start_date=$this->input->post('start_date');
			//$end_date=$this->input->post('end_date');
			?>
		<div class="row">
		<!--Menue bar-->
		
		<div class="col-lg-12">
		<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
	   <a class="navbar-brand" href="<?php echo base_url('admin/orders');?>">All Orders</a>
    </div>
    <ul class="nav navbar-nav">
     <li><a href="<?php echo base_url('admin/orders/success_orderproduct');?>">Product Ordered</a></li></li>
      <li><a href="<?php echo base_url('admin/orders/searchord');?>">Search By Date</a></li>   <li><a href="<?php echo base_url('admin/orders/success_order');?>">All Success order</a>
	  </li>
    </ul>
  </div>
</nav>
		</div>
		
		<div class="col-lg-12">
        <form id="search_customer_form" name="search_customer_form" method="POST" action="<?php echo base_url(); ?>admin/orders/success_order">
				<div class="col-lg-12 col-md-12">
                <div class='col-lg-4 col-md-4'>
					<?php 
					if(isset($product_name)){?>
		<label>Select Product</label>
				<select class="form-control" name="product_id">
						<option value="">Product Orders</option>
					<?php
					$sectionpname[$product_id]='';
						foreach($product_name as $val) {	
						$pid = $val->id;
						$name = $val->modules_item_name;
						$price = $val->price;
						$disprice = $val->discounted_price;
						if($product_id==$val->id){ 
						$sectionp='selected=selected';
						$sectionpname[$product_id]=$val->modules_item_name;
						}else{
						$sectionp='';	
						}
						?><option <?php echo $sectionp; ?> value="<?php echo $val->id; ?>">
				<?php echo $val->modules_item_name; ?>
						</option>
						
						<?php }
					?>
					</select><?php } ?>
					
					</div>
					
                        <div class='col-lg-4 col-md-4'>
                            <div class="form-group">
							<label>From Date </label>
                                <div class='input-group date' id='datetimepicker6'>
                                    <input type='text' class="form-control" id="start_date"  name="start_date" required value="<?php echo $start_date; ?>" />
                                  <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class='col-lg-4 col-md-4'>
                            <div class="form-group">
							<label>To Date</label> Ex-2022-09-14
                                <div class='input-group date' id='datetimepicker7'>
                                    <input type='text' class="form-control" id="end_date" name="end_date"  required value="<?php echo $end_date; ?>" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div> 
						<div class='col-lg-4 col-md-4'>
						<div class="form-group">
        <label class="control-label">Type</label>
			<div class="form-control">
				<span class="new-list-spn"><input type="radio" name="regiType" value="web"> <span>Web</span></span>
				<span class="new-list-spn"><input type="radio" name="regiType" value="app"> <span>App</span></span>
				<span class="new-list-spn"><input type="radio" name="regiType" value="all" checked="checked"> <span>All</span></span>
			</div>
    </div>
						</div>
						
						
								<div class='col-lg-3 col-md-3'>
			<label class="control-label" style="visibility:hidden">button</label>			
			<button type="submit" class="btn btn-primary form-control">Submit</button>
		</div>
			  <div class='col-lg-5 col-md-5'>
		  <h4 class="alert alert-success" style="letter-spacing:1px">
			<?php
			
			$web_order_count=count($web_order_array);
			$app_order_count=count($app_order_array);
				if($total>=0) {
	echo "Total Order <font color='red'>".$total."</font>&nbsp;";  
	}	
	echo "Web Order <font color='red'>".$web_order_count."</font>&nbsp;&nbsp;"; 
	echo "App Order <font color='red'>".$app_order_count."</font>"; 
	
	
			if(!$start_date=="" && !$end_date=="")
			{
			echo " From <font color='red'> ".$start_date."  To " . $end_date."</font><br>";
			}
			?>
			<?php
if(isset($sectionpname[$product_id])&&$sectionpname[$product_id]!=''){
	echo " For - <font color='red'>".$sectionpname[$product_id]."</font> "; 
}

?>
		</h4>

				</div>		
	
	<?php //print_r($orders_status_array); ?>

        </div>
		<div class='col-lg-4 col-md-4'>
		
		
					<?php 



					//echo "Total Order <font color='red'>".$totalorder."</font> "; 
					//echo " from <font color='red'>" . date("Y-m-d", $start_date_string)."  To  ".date("Y-m-d", $end_date_string)."</font>"; ?>
					</div>
					
                      
                  </form></div>
				  
				  
				  
			
				  
				  
				  
				  
                    <script type="text/javascript">
    $(function () {
        $('#datetimepicker6').datetimepicker({format:'YYYY-MM-DD'});
        $('#datetimepicker7').datetimepicker({
            format:'YYYY-MM-DD',
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
            $('.datepicker').hide();
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
             $('.datepicker').hide();
        });
        
    });
</script>
    </div>
<div class="row">
<?php
if($product_id>0&&count($orders)>0){ 
//edit Order product start
?>
<div class="col-lg-12 col-md-12">	
<form id="editorderform" name="editorderform" method="POST" action="<?php echo base_url(); ?>admin/orders/bulkadd_new_product">
<div class="form-group">
<label>
<span onclick="hsp_list()">Click Me To (HIDE/SHOW)Product List Box</span>
</label>	
<div id="hsproductlist">		
			<input type="hidden" name="orderId" value="<?php echo $orderid; ?>">
				<input type="hidden" name="customerid" value="<?php echo $customerid; ?>">
				<div class="col-md-12 col-sm-12 col-xs-12"><label>Select Product</label>
				</div>
	<?php
	foreach($product_name_all as $val) {	
	?>
	<div class="col-md-4 col-sm-4 col-xs-4">
	<input type="checkbox" name="product_id[]" value="<?php echo $val->id; ?>">&nbsp;<?php echo $val->modules_item_name; 
	?>
	</div>
	<?php
	}
	?>
			<div class="form-group alert-info text-center">
			<button type="submit" class="btn btn-primary">Add Product</button>
				</div>
			</div>

				
			</div>
				</div>
		<?php
		//End edit Order product start
	}
	
	?>
	</div>
	
	
			<!-- // search bar -->
            <div class="row">
               <div class="col-lg-12">                    
                    <div class="panel">          <input type="checkbox" onClick="toggle(this)" /> Select All<br/>             
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th width='50'>
                                                Order # 
                                            <?php if($ordercol=='id'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo base_url('admin/orders/success_order/?col=id&order=asc&start_date='.$start_date.'&end_date='.$end_date.'&regiType='.$regiType.'&product_id='.$product_id);?>"><br><i class="fa fa-sort-desc pull-right"></i>DESC</a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=id&order=desc"><br><i class="fa fa-sort-asc pull-right"></i>ASC</a>
                                               <?php }
                                            }else{
												?>
                                                <a href="<?php echo base_url('admin/orders/success_order/?col=id&order=asc&start_date='.$start_date.'&end_date='.$end_date.'&regiType='.$regiType.'&product_id='.$product_id);?>">DESC<i class="fa fa-sort pull-right"></i></a>
                                           <?php }?>
                                            </th>
                                            <th>Customer Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>
											
											Amount <i class="fa fa-inr"></i>	
											<?php if($ordercol=='final_amount'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo base_url('admin/orders/success_order/?col=final_amount&order=asc&start_date='.$start_date.'&end_date='.$end_date.'&regiType='.$regiType.'&product_id='.$product_id);?>"><br><i class="fa fa-sort-desc pull-right"></i>DESC</a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=final_amount&order=desc"><br><i class="fa fa-sort-asc pull-right"></i>ASC</a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url('admin/orders/success_order/?col=final_amount&order=asc&start_date='.$start_date.'&end_date='.$end_date.'&regiType='.$regiType.'&product_id='.$product_id);?>"><i class="fa fa-sort pull-right"></i>DESC</a>
                                           <?php }?>
										</th>
                                            <th>Date
<?php if($ordercol=='created_dt'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo base_url('admin/orders/success_order/?col=created_dt&order=asc&start_date='.$start_date.'&end_date='.$start_date.'&regiType='.$regiType.'&product_id='.$product_id);?>"><br><i class="fa fa-sort-desc pull-right"></i>DESC</a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=created_dt&order=desc"><br><i class="fa fa-sort-asc pull-right"></i>ASC</a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url('admin/orders/success_order/?col=created_dt&order=asc&start_date='.$start_date.'&end_date='.$start_date.'&regiType='.$regiType.'&product_id='.$product_id);?>">DESC<i class="fa fa-sort pull-right"></i></a>
                                           <?php }?></th>
                                            <th>Via</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php

$i = 1;
if (isset($orders)) {
	foreach ($orders as $order) {
if($order->schoolid!=1){		
//if(($order->status==1)||($order->status==3)){
// print_r($orders_status_array);
	?>
<tr class="odd gradeX">
                                    <td><input type="checkbox" value="<?php echo $order->id;?>" name="bulkProdOrd[]" id="bpa_<?php echo $order->id;?>" >&nbsp;<?php echo $order->id;?> (<?php echo $order->order_no; ?>)</td>
                                    <td>
									<a target="_blank" href="<?php echo base_url(); ?>/admin/customers/edit/<?php echo $order->user_id; ?>">
									<?php echo $order->firstname.' '.$order->lastname;
									
									if(isset($order->schoolid)&&($order->schoolid==1)){
					echo '<br>&nbsp;School: SPS/SIS' ;
				 }
									?>
									</a>
									</td>
                                    <td><?php 
									if(isset( $order->email)){
									echo $order->email;
									}?><br><?php echo $order->mobile ?></td>
                                    <td><?php foreach($orders_status_array as $order_status){
               if($order->status==$order_status->id){
					echo '<span>'.$order_status->value.'</span>';
				}  
                 }
				 if(isset($paytypeArray[$order->id])&&$paytypeArray[$order->id]!=''){
				 echo "<br><font color='red'>".$paytypeArray[$order->id]."</font>";
				 }
				 
				 
				 ?></td>
                                    <td><i class="fa fa-inr"></i><?php echo $order->order_price;?></td>
                                    <td>
                                         <?php
                                            if (!empty($order->created_dt)) {
                                                echo date('d/m/Y',$order->created_dt);
                                            }
                                        ?>
                                        </td>
                                         <td>
                                         <?php
                                if($order->app_order==1){
			echo 'APP';								 
										 }else{
									echo 'WEB';		 
										 }
                                        ?>
                                        </td>
                                    <td class="center">
                                        
                                        <a href="<?php echo base_url();?>admin/orders/edit/<?php echo $order->id;?>" >
                                            <i class="fa fa-edit cat-edit" ></i>
                                        </a>
                                     
                                        <a href="<?php echo base_url(); ?>admin/orders/deleteCanOrd/<?php echo $order->id.'/'.$order->user_id.'/'.$order->status;?>">
                                            <i class="fa fa-trash cat-del"></i>
                                        </a>                                        
   
</td>
</tr>
                <?php
        $i++;
//}
	}
    }
}
?>                          
                                        
                                 </tbody>
                                 <tfoot>
                                     <tr>
                                         <td colspan="6">
                                             <?php
echo "<h6><b>";
echo $data["links"] = $this->pagination->create_links() . "</b></h6>";
?>
                                        </td>
                                     </tr>
                                 </tfoot>
								 <?php
								 	if($product_id>0&&count($orders)>0){ 
								 ?>
								 </form>
									<?php } ?>
                               </table>
                            </div>
                            <!-- /.table-responsive -->
                            
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
	<script language="JavaScript">


function hsp_list() {
  var x = document.getElementById("hsproductlist");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function toggle(source) {
  checkboxes = document.getElementsByName('bulkProdOrd[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>