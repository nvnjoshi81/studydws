<div class="content">
    <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
        ?>          <div class="container-fluid">
          <div class="row">
		  <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Customers (<?php echo $total?>)</h4>
                  <p class="card-category">Customers registered by only you</p>
                </div>
                <div class="card-body">
			<div class="row">
                <div class="col-lg-12">
                   <form id="search_customer_form" name="search_customer_form" method="post" action="<?php echo base_url().$folder_admin; ?>/Add_Order/search_customer" > Search By Id <input id="customer_id" name="customer_id" value=""> OR Email <input id="customer_email" name="customer_email" value=""><button type="submit" class="btn btn-primary">Submit</button></form>
                </div>
                <!-- /.col-lg-12 --> 
</div>
<div class="row">            
			<div class="col-lg-12">
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
                        <div class="table-responsive">
                            <div class="dataTable_wrapper">
							    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead class="text-primary">
                                 <th>
                                                Id. 
                                            <?php if($ordercol=='id'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=id&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=id&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url($folder_admin.'/Add_Order/')?>?col=id&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?>
                                            </th>
                                            <th>Name<?php if($ordercol=='firstname'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=firstname&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=firstname&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url($folder_admin.'/Add_Order/')?>?col=firstname&order=asc"><i class="fa fa-sort pull-right"></i></a>
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
                                                <a href="<?php echo base_url($folder_admin.'/Add_Order/')?>?col=created_dt&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?>
                                            </th>
                                            <th>Targated Exam</th>
                                            <th>Action</th>
                                    <tbody>
                <?php
$i = 1;
if (isset($customers)) {
	foreach ($customers as $customer) { 
if($customer->is_social==0){
    $register_point = "studyadda";
}else{
if($customer->is_social==2){   
    $register_point = "Android App"; 
}else{ 
    if($customer->fbid!=''){
        $register_point = "Facebook"; 
    }else  if($customer->twitterid!=''){
        $register_point = "Twitter"; 
    }else if($customer->googleplusid!=''){
     $register_point = "Gmail";
    }else{
     $register_point = "Other";
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
										if(isset($customer->targate_exam)&&$customer->targate_exam!=''){
										$texam_string=$customer->targate_exam;
										$texam_array=explode(',',$texam_string);
		$cntr=0;
$examname_value='';
foreach($texam_array as $texam_id){
	$examname_array=$this->Categories_model->getCategoryDetails($texam_id);
	if(count($texam_array)>1){
		if($cntr==0){
			$examname_value .='';	
		}else{
$examname_value .=', ';	
		}
}
$examname_value .=$examname_array->name;
$cntr++;
}
						
										
										echo $examname_value;
                                        }else{
											echo 'N.A.';
										}
										?></td>
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
}
?>                          </tbody>
                                 <tfoot>
                                     <tr>
                                         <td colspan="7">
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