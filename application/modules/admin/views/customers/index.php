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
                <div class="col-lg-12">
                   <form id="search_customer_form" name="search_customer_form" method="post" action="<?php
                   echo base_url(); ?>admin/customers/search_customer" > Search By Id <input id="customer_id" name="customer_id" value=""> OR Email <input id="customer_email" name="customer_email" value="">OR Mobile <input id="customer_mobile" name="customer_mobile" value=""><button type="submit" class="btn btn-primary">Submit</button></form>
                </div>
                <!-- /.col-lg-12 --> 
                <div class="col-lg-12">
                  <form id="search_customer_form" name="search_customer_form" method="post" action="<?php
                  echo base_url(); ?>admin/customers/customer_by_date" >

                    <div class="container">
                        <div class='col-md-5'>
                            <div class="form-group">From Date 
                                <div class='input-group date' id='datetimepicker6'>
                                    <input type='text' class="form-control" id="start_date"  name="start_date" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-5'>
                            <div class="form-group">To Date
                                <div class='input-group date' id='datetimepicker7'>
                                    <input type='text' class="form-control" id="end_date" name="end_date"  />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>Ex-2016-09-14 (Lesser to Greater )
                        </div>
                        <div class="col-md-5">
    <div class="form-group">
        <label>Type</label>
        <span class="new-list-spn"><input type="radio" name="regiType" value="web"> <span>Web</span></span>
        <span class="new-list-spn"><input type="radio" name="regiType" value="app"> <span>App</span></span>
        <span class="new-list-spn"><input type="radio" name="regiType" value="all" selected="selected"> <span>All</span></span>
    </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
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