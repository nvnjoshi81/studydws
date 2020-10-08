<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="page-header">Orders Result<?php if(isset($totalorder)){
						
						echo 'Total:'.$totalorder;
					}?></h1>
                </div>
				
 <div class="col-lg-3"><a href="<?php echo base_url(); ?>admin/orders"><h1 class="page-header">All Order List</h1></a></div>
				
 <div class="col-lg-3"><a href="<?php echo base_url(); ?>admin/orders"><h1 class="page-header">Order List</h1></a></div>
				<!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
			
			         <div class="col-lg-12">
                  <form id="search_customer_form" name="search_customer_form" method="POST" action="<?php echo base_url(); ?>admin/orders/searchorder" >
                  
					<div class="col-lg-12 col-md-12">
                        <div class='col-lg-3 col-md-3'>
                            <div class="form-group">From Date 
                                <div class='input-group date' id='datetimepicker6'>
                                    <input type='text' class="form-control" id="start_date"  name="start_date" />
                                  <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class='col-lg-3 col-md-3'>
                            <div class="form-group">To Date Ex-2022-09-14
                                <div class='input-group date' id='datetimepicker7'>
                                    <input type='text' class="form-control" id="end_date" name="end_date"  />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div> 
						<div class='col-lg-3 col-md-3'>
                        <div class="form-group">
        <label class="control-label">Type</label>
			<div class="form-control">
				<span class="new-list-spn"><input type="radio" name="regiType" value="web"> <span>Web</span></span>
				<span class="new-list-spn"><input type="radio" name="regiType" value="app"> <span>App</span></span>
				<span class="new-list-spn"><input type="radio" name="regiType" value="all" checked="checked"> <span>All</span></span>
			</div>
    </div>
	</div>
	
	<?php //print_r($orders_status_array); ?>
	
	<div class="col-lg-3 col-md-3 col-xs-12">
		<div class="form-group">
			<label class="control-label">Status</label>
			<select class="form-control" name="status">
			<option value="">All</option>
			<?php 
	foreach ($orders_status_array as $key=>$status_val) {
		$status_val->value;
		?>
		<option value="<?php echo $key; ?>"><?php echo $status_val->value; ?></option>
	<?php }
	?>
			</select>
		</div>						
	</div>
                    </div>
					 
					<div class='col-lg-12 col-md-12'>
					<div class='col-lg-3 col-md-3'>
					<button type="submit" class="btn btn-primary">Submit</button>
					</div>
					<div class='col-lg-4 col-md-4'>
					<?php 
if($totalorder<1) {
	echo "";
}
if($totalorder>=1) {
	echo "Total Order <font color='red'>".$totalorder."</font> "; 
					echo " from <font color='red'>" . date("Y-m-d", $start_date_string)."  To  ".date("Y-m-d", $end_date_string)."</font>";
}

					//echo "Total Order <font color='red'>".$totalorder."</font> "; 
					//echo " from <font color='red'>" . date("Y-m-d", $start_date_string)."  To  ".date("Y-m-d", $end_date_string)."</font>"; ?>
					</div>
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
                
               <div class="col-lg-12">
                    
                    <div class="panel">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width='100'>Order #</th>
                                            <th>Customer Name</th>
                                            <th>Products Ordered</th>
                                            <th>Status</th>
                                            <th>Amount <i class="fa fa-inr"></i></th>
                                            <th>Date</th>
                                            <th>Via</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$i = 1;
$subi=0;
$stt=0;
if (isset($orders)) {
	foreach ($orders as $order) {
		
		//if(($order->status==1)||($order->status==3)){
// print_r($orders_status_array);

		if($order->status==1) {
			$c_stt = $stt++;
		}
		
		if($order->app_order==1) {
			$subi++;
		}
		?>
		<div class="row">
		<?php 
		if($i==$totalorder) {
			$totalorder;
			$c_stt;
			$cancel = $totalorder - $c_stt;
		 ?>
		<div class="col-lg-6">
		<ul class="list-group list-inline text-left">
			<li class="list-group-item hidden"></li>
			<li class="list-group-item"><?php echo "Total Order - <b>".$totalorder."</b>"; ?></li>
			<li class="list-group-item"><?php echo "Sucess Order - <b>".$c_stt."</b>"; ?></li>
			<li class="list-group-item"><?php echo "Cancelled Order - <b>".$cancel."</b>"; ?></li>
		</ul>
		</div>
		
		<?php }
		if($i==$totalorder) {			
			$totalorder;
			$subi;
			$web = $totalorder-$subi;
			?>
			<div class="col-lg-6">
			<ul class="list-group list-inline text-right">
				<li class="list-group-item"><?php echo "Total Order - <b>".$totalorder."</b>"; ?></li>
				<li class="list-group-item"><?php echo "Ordered by App - <b>".$subi."</b>"; ?></li>
				<li class="list-group-item"><?php echo "Ordered by Web - <b>".$web."</b>"; ?></li>
				<li class="list-group-item hidden"></li>
			</ul>
			</div>
			
			
			
		<?php }

	?>
	</div>
	<tr class="odd gradeX">
                                    <td><?php echo '('.$i.') <br>OID-'.$order->id;?> (<?php echo $order->order_no; ?>)</td>
                                    <td><a target="_blank" href="<?php echo base_url(); ?>/admin/customers/edit/<?php echo $order->user_id; ?>"><?php echo $order->firstname.' '.$order->lastname;?></a><br><?php 
									if(isset( $order->email)){
									echo $order->email;
									}?><br><?php echo $order->mobile ?></td>
                                    <td><?php echo $order->order_items ?>
									
									</td>
                                    <td><?php foreach($orders_status_array as $order_status){
                  
                 
                if($order->status==$order_status->id){
				echo '<span>'.$order_status->value.'</span>';
				}  
                 }?></td>
                                    <td><i class="fa fa-inr"></i><?php echo $order->order_price;?></td>
                                    <td>
                                         <?php
                                            if (!empty($order->created_dt)) {
                                                echo date('d/m/Y',$order->created_dt);
                                            }
											 if (!empty($order->validity_dt)) {
												 if($order->validity_dt>0){
                                                echo "<br>validity-".date('d/m/Y',$order->validity_dt);
												 }else{
													 
													 echo '0';
												 }
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
											
										 <a href="<?php echo base_url(); ?>admin/orders/cs_orders/<?php echo $order->user_id;?>">
                                            <i class="fa fa-align-justify" title="All Orders" ></i>
                                        </a>
</td>
</tr>
                <?php
        $i++;
//}
    }
}
?>                          </tbody>
                                 <tfoot>
                                     <tr>
                                         <td colspan="6">
                                             <?php
echo "<h6><b>";
//echo $data["links"] = $this->pagination->create_links() . "</b></h6>";
?>
                                        </td>
                                     </tr>
                                 </tfoot>
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