
 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Orders <?php if($product_name!=''){ echo "For ".$product_name;}?> (<?php echo $total?>)</h1>
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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width='100'>Order #</th>
                                            <th>Customer Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Amount <i class="fa fa-inr"></i></th>
                                            <th>Date</th>
                                            <th>Guest</th>
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
                                    <td><a target="_blank" href="<?php echo base_url(); ?>/admin/customers/edit/<?php echo $order->user_id; ?>"><?php echo $order->firstname.' '.$order->lastname;?></a></td>
                                    <td><?php echo $order->email?><br><?php echo $order->mobile ?></td>
                                    <td><?php foreach($orders_status_array as $order_status){
                  
                 
               if($order->status==$order_status->id){
					echo '<span>'.$order_status->value.'</span>';
				}  
                 }?></td>
                                    <td><i class="fa fa-inr"></i><?php echo $order->price;?></td>
                                    <td>
                                         <?php
                                            if (!empty($order->created_dt)) {
                                                echo date('d/m/Y',$order->created_dt);
                                            }
                                        ?>
                                        </td>
                                         <td>
                                         <?php
                                           echo ucfirst($order->guest);
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
?>                          </tbody>
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