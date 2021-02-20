 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Customers (<?php echo $total?>)</h1>
                </div>
                <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
         ?>  
                <div class="col-lg-12 searchFrm">
                   <form id="search_customer_form" name="form-inline search_customer_form" method="post" action="<?php
                   echo base_url(); ?>admin/customers/search_customer" > 
				   
                   <div class="form-group col-lg-4">
					   <label>Search By - Id</label>
					   <input type="text" id="customer_id" class="form-control" name="customer_id" value=""> 
				   </div>

                   <div class="form-group col-lg-4">
                       <label>OR Firstname</label>
                       <input type="text" id="cfname" class="form-control" name="customer_fnm" value=""> 
                   </div>

                   <div class="form-group col-lg-4">
                       <label>OR Lastname</label>
                       <input type="text" id="clname" class="form-control" name="customer_lnm" value="">  
                   </div>
				   
				   <div class="form-group col-lg-4">
    				    <label>OR Email </label>
    				   <input type="text" id="customer_email" class="form-control" name="customer_email" value="">
				   </div>
				   <div class="form-group col-lg-4">
				   <label>OR Mobile </label>
				   <input type="text" id="customer_mobile" class="form-control" name="customer_mobile" value="">
				   </div>
				   
                   <div class="form-group col-lg-4">
                    <label class="" style="visibility: hidden">Submit</label>
				   <button type="submit" class="btn btn-primary form-control">Submit</button>
                    </div>
				   </form>
                </div>
                <!-- /.col-lg-12 --> 

                <?php

                ?>


                <div class="col-lg-12 searchFrm">
                  <form id="search_customer_form" name="search_customer_form" method="post" action="<?php
                  echo base_url(); ?>admin/customers/customer_by_date" >

                    
                        
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
                                        <tr><th width='50'>
                                                Id. 
<?php if($ordercol=='id'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=id&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=id&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url('admin/customers/')?>?col=id&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?>
                                            </th>
                                            <th>Name<?php if($ordercol=='firstname'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=firstname&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=firstname&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url('admin/customers/')?>?col=firstname&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?></th>
                                             <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Reg. Date
                                                
                                            <?php if($ordercol=='created_dt'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=created_dt&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=created_dt&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url('admin/customers/')?>?col=created_dt&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?>
                                            </th>
                                            <th>Register From</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                <?php 
$i = 1;
if (isset($customers)) {
	foreach ($customers as $customer) { 
if($customer->is_app_registered=='1'&&(isset($customer->device_id)&&$customer->device_id!='')){
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
                                    <td><?php echo $customer->id;?></td>
                                    <td><?php echo $customer->firstname.' '.$customer->lastname;                                        ?>
                                    </td>
                                    <td><?php echo $customer->email?></td>
                                    <td><?php echo $customer->mobile?></td>
                                    <td><?php
                                            if (!empty($customer->created_dt)) {
                                                echo date('d/m/Y',$customer->created_dt);
                                            }
                                        ?> 
                                        </td>
                                        <td><?php
                                        echo $register_point;
                                        ?></td>
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
}
?>                          </tbody>
                                 <tfoot>
                                     <tr>
                                         <td colspan="6">
                                             <?php
echo "<h6><b>";
echo $this->pagination->create_links() . "</b></h6>";
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