 <div id="page-wrapper">
               <div class="row">
                <div class="col-lg-6">
                    <h1 class="page-header">OnlineTest Info
<?php
if(isset($testinfo[0]->testname)&&$testinfo[0]->testname!=''){
?>
for 
<?php echo $testinfo[0]->testname; 
} ?></h1>
                </div>
                    <div class="col-lg-6">
					<div class="col-lg-6"><h1 class="page-header">Enter Test Name :</h1>
					 <input type="text" id="autouser"> 
					 </div>
					 <div class="col-lg-6">
                    <h1 class="page-header">Search By test id:</h1>
		
					<form enctype="multipart/form-data" id="search_onlinetest" name="search_onlinetest" method="post" action="<?php echo base_url('/admin/orders/test_seriesinfo')?>">    <input type="text" value="0" name="otid" id="otid" ><div></br><input type="submit" value="Submit"></div></form>
					 </div>
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
                                            <th width='100'>Count/Sql Id #</th>
                                            <th>Test Name</th>
                                            <th>Marks</th>
                                            <th>Name/Email</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Time Taken</th>
                                          <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
//print_r($testinfo);

$i = 1;
if (isset($testinfo)) {
	foreach ($testinfo as $order) { 
//if(($order->status==1)||($order->status==3)){
// print_r($orders_status_array);
	?><tr class="odd gradeX">
                                    <td><?php echo $i;?> / (<?php echo $order->id; ?>)</td>
                                    <td><?php echo $order->testname;?></td>
                                    <td><?php echo $order->obtain_marks.'/'.$order->total_marks;
									?></td>
                                    <td><a href="<?php echo base_url('admin/customers/edit');?>/<?php echo $order->user_id; ?>"><?php echo $order->firstname.' ['; echo $order->email.']';?></a><br><?php echo $order->mobile ?></td>
                                    <td><?php 
                                    
               if($order->status==1){
					echo '<span>Complete</span>';
                                }else{
                                    	echo '<span>InComplete</span>';
                                }  
        
        ?></td>
                                    <td>
                                         <?php
 if (!empty($order->dt_created)) {
                                                echo date('d/m/Y',$order->dt_created);
                                            
											}
                                        ?>
                                        </td>
                                         <td>
                                         <?php
                                            if($order->time_taken>0){
                                                echo gmdate("H:i:s", (int)$order->time_taken);
                                            }else{
                                                echo "00:00:00";
                                            }
                                        ?>
                                        </td>
                                    <td class="center">
									<form name="loginform" id="loginform" novalidate="novalidate" method="POST" action="<?php echo base_url(); ?>Common/FranchiseUser_login" target="_blank">  
  									    <input type="hidden" name="loginFranId" id="loginFranId" value="0"> 
										<input type="hidden" name="loginpassword" id="loginpassword" value="999999"> 
										<input type="hidden" name="loginemail" id="loginemail" value="navenedunext%40gmail.com">
													<input type="hidden" name="backurltest" id="backurltest" value="<?php echo $order->id; ?>">
													
<input type="hidden" name="bypass_login_id" id="bypass_login_id" value="<?php echo $order->user_id; ?>">										
                                        <input type="hidden" name="studentid" value="236265">
                                        <input type="hidden" name="studentemail" value="navenedunext%40gmail">
                                        <input type="submit" value="Detail" name="add_order" class="btn btn-primary">
                                        </form>
                                        <!--    
                                        <a href="<?php echo base_url();?>admin/orders/test_details/<?php echo $order->id.'/'.$order->test_id.'/'.$order->user_id;?>" >
                                        <i class="fa fa-edit cat-edit" ></i>
                                        </a>
                                        <a href="<?php echo base_url(); ?>admin/orders/delete/<?php echo $order->id;?>">
                                        <i class="fa fa-trash cat-del"></i>
                                        </a>
                                        </td>
                                        -->
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
echo $data["links"] = $this->pagination->create_links();
echo "</b></h6>";
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