<div id="page-wrapper">
	<div class="row text-center alert alert-danger">
		<h2>Success Order List by App</h2>
	</div>
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="page-header">Orders (<?php echo $total; ?>)</h1>
                </div>
                <div class="col-lg-6">
                          <form  enctype="multipart/form-data" id="search_order" name="search_order" method="post" action="<?php
echo base_url(); ?>/admin/orders">                              
                               <div class="col-lg-12 clr-bth">
    <div class="form-group">
        <label>Order No:&nbsp;</label><span class="new-list-spn"><input type="text" name="order_no" id="order_no" value="" ><span>(Enter order no. like : 1523707258)</span>
    </div>
 <div class="col-lg-6"> <button type="submit" class="btn btn-primary">Submit</button>  </div> 
 
 <div class="col-lg-3"><a href="<?php echo base_url(); ?>admin/orders/searchord"><h1 class="page-header">Search Orders</h1></a></div>
 <div class="col-lg-3"><a href="<?php echo base_url(); ?>admin/orders"><h1 class="page-header">Order List</h1></a></div>
         </div>   
                          </form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<!-- search bar -->
			<div class="row">
			<h4 class="alert alert-success" style="letter-spacing:1px">
			<?php
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			if(!$start_date=="" && !$end_date=="")
			{
					echo $time_period = "Orders from ".$start_date. " to " .$end_date;
			}
			?>
			
			</h4>
			         <div class="col-lg-12">
                  <form id="search_customer_form" name="search_customer_form" method="POST" action="<?php echo base_url(); ?>admin/orders/success_order" >
                  
					<div class="col-lg-12 col-md-12">
                        <div class='col-lg-4 col-md-4'>
                            <div class="form-group">
							<label>From Date </label>
                                <div class='input-group date' id='datetimepicker6'>
                                    <input type='text' class="form-control" id="start_date"  name="start_date" required />
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
                                    <input type='text' class="form-control" id="end_date" name="end_date"  required/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div> 
						
	
	<?php //print_r($orders_status_array); ?>
		<div class='col-lg-2 col-md-2'>
			<label class="control-label" style="visibility:hidden">button</label>			
			<button type="submit" class="btn btn-primary form-control">Submit</button>
		</div>
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
			<!-- // search bar -->
            <div class="row">
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
                                            <th>Email</th>
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
if (isset($orders)) {
	foreach ($orders as $order) { 
//if(($order->status==1)||($order->status==3)){
// print_r($orders_status_array);
	?><tr class="odd gradeX">
                                    <td><?php echo $order->id;?> (<?php echo $order->order_no; ?>)</td>
                                    <td>
									<a target="_blank" href="<?php echo base_url(); ?>/admin/customers/edit/<?php echo $order->user_id; ?>">
									<?php echo $order->firstname.' '.$order->lastname;?>
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
                 }?></td>
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