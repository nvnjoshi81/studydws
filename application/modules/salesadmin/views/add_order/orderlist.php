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
                  <h4 class="card-title">Your Orders</h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
             <div class="col-lg-12">
                    
                    <div class="panel">
                        
                        <!-- /.panel-heading -->
                        <div class="table-responsive">
                            <div class="dataTable_wrapper">
							    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead class="text-primary">
                                 <th>
                                                Order Id/Number 
                                            <?php if($ordercol=='id'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=id&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=id&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url($folder_admin.'/Add_Order/orderlist/')?>?col=id&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?>
                                            </th>
                                            <th>Student Name<?php if($ordercol=='firstname'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=firstname&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=firstname&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url($folder_admin.'/Add_Order/orderlist/')?>?col=firstname&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?></th>
                                             <th>status</th>
                                            <th>Student Mobile</th>
                                            <th>Reg. Date
                                                
                                            <?php 
											if($ordercol=='created_dt'){ 
                                            if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=created_dt&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=created_dt&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url($folder_admin.'/Add_Order/orderlist/')?>?col=created_dt&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?>
                                            </th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                    <tbody>
<?php

if(isset($ord->is_social)){
	$is_social=$ord->is_social;
}else{
	$is_social='0';
	
}

$i = 1;
if ((isset($orders))&&(count($orders)>0)) {
	foreach ($orders as $ord) { 
if($is_social==0){
    $register_point = "studyadda";
}else{
if($is_social==2){   
    $register_point = "Android App"; 
}else{ 
    if($ord->fbid!=''){
        $register_point = "Facebook"; 
    }else  if($ord->twitterid!=''){
        $register_point = "Twitter"; 
    }else if($ord->googleplusid!=''){
     $register_point = "Gmail";
    }else{
     $register_point = "Other";
    }
}
    }
// print_r($chapters);
	?>
       <tr class="odd gradeX">
                                    <td><?php echo $ord->order_no;?>(<?php echo $ord->id;?>)</td>
                                    <td>
									<a href="#<?php //echo base_url($folder_admin.'/Add_Student/edit/'.$ord->user_id)?>"><?php echo $ord->firstname.' '.$ord->lastname;?> (<?php echo $ord->email; ?>)
                                    </a></td>
                                    <td><?php 
									echo $ord_status_array[$ord->status]->value;?></td>
                                    <td><?php echo $ord->mobile;?></td>
                                    <td>
									<?php
                                    if(!empty($ord->created_dt)) {
                                    echo date('d/m/Y',$ord->created_dt);
                                    }
                                    ?> 
                                    </td>
                                        <td>INR <?php echo $ord->final_amount;?></td>
									       <td class="center">
                                        <?php //$ferEncodeUrl=base_url().$folder_admin.'/add_order/productlist'; 
										
										$linkToUserAcc=base_url().'Common/FranchiseUser_login';
										?>
                                        <a href="<?php echo base_url($folder_admin.'/Add_Order/orderview/'.$ord->id)?>"><i class="fa fa-sort pull-right"></i>View</a>
                                    </td>
       </tr>
                <?php
                $i++;
    }
}else{
	?> <tr>
	<td colspan='4'>No Order Available.
	      </td>
       </tr>
	<?php
	
}
?>                          </tbody>
                                 <tfoot>
                                     <tr>
                                         <td colspan="7">
<?php
echo "<h6><b>";
echo $this->pagination->create_links() . "";
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