 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Customers</h1>
                </div>
                <div class="col-lg-12 searchFrm">
                
                <form id="search_customer_form" name="search_customer_form" method="post" action="<?php echo base_url(); ?>admin/customers/search_customer">
                    
                    <div class="form-group col-lg-4">
                        <label>Search By - Id</label>
                        <input id="customer_id" class="form-control" name="customer_id" value=""> 
                    </div>

                    <div class="form-group col-lg-4">
                        <label>OR First Name</label>                    
                    <input id="cfname" class="form-control" name="cfname" value=""> 
                    </div>


                    <div class="form-group col-lg-4">
                       <label>OR Lastname</label>
                    <input id="clname" class="form-control" name="clname" value=""> 
                    </div>


                    <div class="form-group col-lg-4">
                        <label>OR Email </label> 
                    <input id="customer_email" class="form-control" name="customer_email" value="">
                    </div>

                    <div class="form-group col-lg-4">
                   <label>OR Mobile </label> 
                    <input id="customer_mobile" class="form-control" ame="customer_mobile" value="">
                    </div>

                <div class="form-group col-lg-4">
                    <label class="" style="visibility: hidden">Submit</label>
                   <button type="submit" class="btn btn-primary form-control">Submit</button>
                    </div>

                </form>

                </div>
                <!-- /.col-lg-12 -->
                  <div class="col-lg-12 searchFrm">
                  <form id="search_customer_form" name="search_customer_form" method="post" action="<?php echo base_url(); ?>admin/customers/customer_by_date">

                    
                        <div class="form-group col-lg-3">
                                <label>From Date </label>
                                <div class='input-group date' id='datetimepicker6'>
                                    <input type='text' class="form-control" id="start_date"  name="start_date" placeholder="Ex-2016-09-14" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>

                        <div class="form-group col-lg-3">
                                <label>To Date</label>
                                <div class='input-group date' id='datetimepicker7'>
                                    <input type='text' class="form-control" id="end_date" name="end_date"  placeholder="Ex-2016-09-14"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div> 

    <div class="form-group col-lg-3">
        <label>Type</label>
    
        <div class="form-control">
         <label class="radio-inline"> <input type="radio" name="regiType" value="web"> Web</label>
       
        <label class="radio-inline"><input type="radio" name="regiType" value="app"> App</label>

        <label class="radio-inline"><input type="radio" name="regiType" value="all" selected="selected"> All</label>
       </div>
    </div>

                        <div class="form-group col-lg-3">
                            <label class="" style="visibility: hidden">Submit</label>
                            <button type="submit" class="btn btn-primary form-control">Submit</button>
                        </div>
					
                      
                  </form>


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
                                                    <tr><td colspan="6"> 
                                                            
                                         <?php if (count($customers)>0) { 
                                   if(isset($start_date)&&isset($end_date)){
                                                                ?>
                                                            <a href="<?php echo base_url("admin/customers/create_customer_xls/".$start_date."/".$end_date); ?>">Download Result</a>
                                                                <?php }
                                                                }
                                                                ?>
                                                        </td></tr>
                                                </thead>
                 <thead>
                                        <tr>
                                            <th width='25'>Number</th>
                                            <th width='25'>Id.</th>
                                            <th>Name</th>
                                             <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Reg. Date</th>
                                            <th>Register From</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                                <thead>
                                                    <tr><td colspan="6">Total Count- <?php echo count($customers); ?></td></tr>
                                                </thead>
                <?php
$i = 1;
if (count($customers)>0) {
//print_r($customers);
	foreach ($customers as $customer) { 
if($customer->is_app_registered=='1'&&$customer->device_id!=''){
    $register_point = "App";
}else{
if($customer->is_social==0){   
    $register_point = "Web Form"; 
}else{ 
    if($customer->fbid!=''){
        $register_point = "Web Facebook"; 
    }else  if($customer->twitterid!=''){
        $register_point = "Web Twitter"; 
    }else if($customer->googleplusid!=''){
     $register_point = "Web Gmail";
    }else{
     $register_point = "Web Other";
    }
}
    }
// print_r($chapters);
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
                                        <td><?php echo $register_point; ?></td>
                                    <td class="center">
                                        
                                        <a href="<?php echo base_url();?>admin/customers/edit/<?php echo $customer->id;?>" >
                                            <i class="fa fa-edit cat-edit" ></i>
                                        </a>
                                     
                                        <a href="<?php echo base_url(); ?>admin/customers/delete/<?php echo $customer->id;?>">
                                            <i class="fa fa-trash cat-del"></i>
                                        </a>
                                        
                                        <a target="_blank" href="<?php
echo base_url('Welcome/a/'.$customer->id); ?>"><i class="fa fa-edit cat-del"></i></a>
                                        
   
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