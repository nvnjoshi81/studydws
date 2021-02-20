 <div id="page-wrapper">
 
 
 
	<div class="row">
		<div class="col-lg-12 text-center">
			<h2 class="alert alert-success">Add New Product<h2>
		</div>
		
		<div class="col-lg-offset-1 col-lg-6 col-md-offset-6 col-md-6 col-sm-6 col-xs-6">
		<?php
		$ord_product_type=array('complimantry','paid')
		
		?>
		<form method="post" action="<?php echo base_url(); ?>admin/orders/edit_ordprd_type">
			<div class="form-group">
			
			<input type="hidden" name="orderId" value="<?php echo $orderid; ?>">
				<input type="hidden" name="orderproduct_id" value="<?php echo $orderproduct_id; ?>">
				<input type="hidden" name="orderId" value="<?php echo $orderId; ?>">
				<div class="col-md-12 col-sm-12 col-xs-12"><label>Edit Order Type</label>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
			<select class="form-control" name="opid_type" required>
						<option value="">Select Type</option>
					<?php
						foreach($ord_product_type as $valk=>$val) {
						?>												
						<option value="<?php echo $val; ?>">
							<?php echo $val; ?>
						</option>
						
						<?php }
					?>
					</select>
</div>	
			</div>
			<div class="form-group alert-info text-center">
			<button type="submit" class="btn btn-primary">Add Product</button>
			</div>
		</form>
		</div>
	</div>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
            <div class="row">
                <div class="col-lg-6">
                   <h1>Student Shopping Cart</h1> <?php 
         if($this->session->flashdata('update_msg')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('update_msg'); ?> </div>
            <?php 
         }
         ?>
                </div>

				
                <div class="col-lg-6">
				<a href="<?php echo base_url(); ?>/admin/pricelist">
				<h1 class="page-header">Back</h1>
				</a>
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
    <div class="subline-title">
            <h5>Product In Cart</h5>

   <?php 
					if(isset($user_info->targate_exam)&&$user_info->targate_exam!=''){
					?>
					  <div class="panel panel-default">
              <div class="panel-heading">
				<div style="font-weight:bold;"><?php echo 'Targate Exam:' ; ?>
			    </div>
              </div>
			  </div>


            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <label class=""  for="email">Target Exam:</label>
                                        <?php 
			
				 $targate_exam_string=$user_info->targate_exam;
                          $targate_exam_array=explode('_', $targate_exam_string);
                          if(isset($targate_exam_array[0])&&$targate_exam_array[0]!=''){
                                        foreach($mainexamcategories as $t_exam){
                                            $t_exam_id= $t_exam->id;
                                            $t_exam_name= $t_exam->name;
                                            $checked_exam='';
                                        if(in_array($t_exam_id,$targate_exam_array)){
                                            $checked_exam='checked="checked"';
											?>
											 <input type="checkbox" name="targate_exam[]" disabled='disabled' id="targate_exam_<?php echo $t_exam_id; ?>" value="<?php echo $t_exam_id; ?>"  <?php echo $checked_exam; ?>>     
											<?php echo $t_exam_name.'&nbsp;';
                                        }
                                        ?>
                                                              <?php
                                        }
   }
                                        ?>
               <span class="material-input"></span>
            </div>  

<?php

					}
					?>


            <?php 

            if(isset($user_productCart)){ ?>
            <?php  ?>
            <div class="panel panel-default">
              <div class="panel-heading">
				<div style="font-weight:bold;"><?php echo 'Total item:'.$user_productCart[0]->cart_items ; ?></div>
              </div>
<div class="panel-body"> 
<div class="table-responsive">
                  <table class="table table-hover" cellspacing="10" cellpadding="10">
                    <tbody>
<?php
foreach($user_productCart as $shopkey=>$shopvalue ){
?>
   <tr class="cartitems">
   <td><a target="_blank" href="<?php echo base_url(); ?>/admin/customers/edit/<?php echo $shopvalue->user_id; ?>"><?php echo $shopvalue->user_id ?></a>
   </td>
   <td><?php echo $shopvalue->name ?></td>
   <td><?php echo $shopvalue->price; ?></td>
</tr>
<?php
}
?>
<tr class="cartitems">
   <td style="font-weight:bold;">Total Price:</td>
   <td>
       <div style="font-weight:bold;"><?php echo $user_productCart[0]->cart_price; ?></div>
	   </td>
</tr>
			
				
</tbody>
</table>
</div>
</div>
            </div>
            <?php 
            
            } else{
					echo "Shopping Cart is empty!";
				} ?>
          </div>
                            </div>
                            
                                
                </div>
                     </div>
                </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>