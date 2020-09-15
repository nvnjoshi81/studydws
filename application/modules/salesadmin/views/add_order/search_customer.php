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
                  <h4 class="card-title ">Customers</h4>
                  <p class="card-category">Customers registered by only you</p>
                </div>
                <div class="card-body">
		    <div class="row">
                <div class="col-lg-12">
				<div class="row">
				
				
				
				
                   <form id="search_customer_form" name="search_customer_form" method="post" action="<?php
                   echo base_url().$folder_admin; ?>/Add_Order/search_customer" >
				   	<div class="row">
				<div class="col-md-3">Search By Id <input id="customer_id" name="customer_id" value=""></div>
				<div class="col-md-3">
				OR Email <input id="customer_email" name="customer_email" value=""> </div>
				<div class="col-md-3">OR Mobile  <input id="customer_mobile" name="customer_mobile" value=""></div>
				<div class="col-md-3"><?php
				if(isset($studentschool)){ ?><select name="searchschool_id" id="searchschool_id" class="form-control valid">
					  <option value="0">Select School</option>
					<?php foreach($studentschool as $schoolname){   
						
					?>
					  <option value="<?php echo $schoolname->id; ?>" ><?php echo $schoolname->school_name; ?></option>
					<?php
					} 
					?>
</select>
				<?php } ?></div>
				</div>
				   
				   <button type="submit" class="btn btn-primary">Submit</button></form>
                </div>
                <!-- /.col-lg-12 -->
				</div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    
                    <div class="panel">
                        
                        <!-- /.panel-heading -->
					    <div class="table-responsive">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                  <thead class="text-primary">
                                                    <tr><td colspan="6">
                                                    <?php if (count($customers)>0) { 
                                                    if(isset($start_date)&&isset($end_date)){
                                                                ?>
                                                    <a href="<?php echo base_url($folder_admin."/Add_Odmin/create_customer_xls/".$start_date."/".$end_date); ?>">Download Result</a>
                                                                <?php }
                                                                }
                                                                ?>
                                                        </td>
                                                    </tr>
                                                </thead>
                 <thead>
                                        <tr>
                                            <th width='25'>Number</th>
                                            <th width='25'>Id.</th>
                                            <th>Name</th>
                                             <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Reg. Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                                <thead>
                                                    <tr><td colspan="6">Total Count- <?php echo count($customers); ?></td></tr>
                                                </thead>
                <?php
$i = 1;
if(count($customers)>0) {
	foreach ($customers as $customer) {

	?>
                                    <tr class="odd gradeX">
                                    <td><?php echo $i ; ?>)</td>
                                    <td><?php echo $customer->id;?></td>
                                    <td><?php echo $customer->firstname.' '.$customer->lastname; ?></td>
                                    <td><?php echo $customer->email?></td>
                                    <td><?php echo $customer->mobile?></td>
                                    <td><?php
                                            if (!empty($customer->created_dt)) {
                                                echo date('d/m/Y',$customer->created_dt);
                                            }
                                        ?> 
                                    </td>
                                      <td class="center">
                                        <?php //$ferEncodeUrl=base_url().$folder_admin.'/add_order/productlist'; 
										
										$linkToUserAcc=base_url().'Common/FranchiseUser_login';
										?>
                                        <form name="loginform" id="loginform" novalidate="novalidate" method="POST" action="<?php echo $linkToUserAcc ;?>" target="_blank">  
  									    <input type="hidden" name="loginFranId" id="loginFranId" value="<?php echo $franchiseid=$this->session->userdata('userid'); ?>"> 
										<input type="hidden" name="loginpassword" id="loginpassword" value="999999"> 
										<input type="hidden" name="loginemail" id="loginemail" value="<?php echo urlencode($customer->email);?>">
<input type="hidden" name="bypass_login_id" id="bypass_login_id" value="<?php echo urlencode($customer->id);?>">										
                                        <input type="hidden" name="studentid" value="<?php echo urlencode($customer->id);?>" >
                                        <input type="hidden" name="studentemail" value="<?php echo urlencode($customer->email);?>" >
                                        <input type="submit" value="Add Order" name="add_order" class="btn btn-primary">
                                        </form>
                                    </td>
</tr>
    <?php
     $i++;
    }
}else{
    ?>
<tr class="odd gradeX"><td colspan="6" >Customer Not Found!</td></tr>
        <?php
    
}
?>                          
                                        
                                 </tbody>
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
</div>
</div>
</div>
</div>
</div>