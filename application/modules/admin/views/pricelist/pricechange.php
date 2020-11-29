<?php
foreach($get_price_by_month as $key=>$val) {
	//print_r($val[0]->price);
	//echo "<br>";
	//print_r($val[0]->discounted_price);
	//echo "<br>";
}
?>
<script>
$(document).ready(function(){
	$("#set_val_date").hide();
	$("#set_val_day").hide();
	
  $("#dt").click(function(){
    $("#set_val_date").show();
	$("#set_val_day").hide();
  });
  
  $("#dy").click(function(){
    $("#set_val_day").show();
	$("#set_val_date").hide();
  });
});
</script>

<div id="page-wrapper" class="container" style="width:80%;">
    <div class="row">	
			<h1 class="page-header text-capitalize">set validity for product</h1>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 searchFrm">
			
	<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12 text-capitalize">
        <label>set validity for product by - </label>
    
        <div class="form-control" style="border:none">

			<div id="dt" cl>
				<label class="radio-inline"> <input type="radio" name="regiType" value="web"> Date</label>
			</div>
			
			<div id="dy">
				<label class="radio-inline"> <input type="radio" name="regiType" value="web"> Day</label>
			</div>

       </div>
	   
    </div>
	
	<br>
		
		<div class="col-lg-9 col-md-3 col-sm-9 col-xs-12">
		<form id="set_val_date" name="search_customer_form" method="post" action="<?php echo base_url(); ?>admin/customers/set_validity">


			<div class="form-group col-lg-5">
					<label>Date </label>
					<div class='input-group date' id='datetimepicker6'>
						<input type='text' class="form-control" id="start_date"  name="current_date" placeholder="Ex-2016-09-14" required />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div> 

			<div class="form-group col-lg-3">
				<label class="" style="visibility: hidden">Submit</label>
				<button type="submit" class="btn btn-primary form-control">Submit</button>
			</div>

		  
		</form>
		
		
		
		<form id="set_val_day" name="search_customer_form" method="post" action="<?php echo base_url(); ?>admin/customers/set_validity">


			<div class="form-group col-lg-5">
                        <label>Day</label>                    
                    <input type="number" id="cfname" class="form-control" name="current_day" value="" min="1" max="" title="Please enter a digit only" required> 
                    </div> 

			<div class="form-group col-lg-3">
				<label class="" style="visibility: hidden">Submit</label>
				<button type="submit" class="btn btn-primary form-control">Submit</button>
			</div>

		  
		</form>
		</div>


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
	
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
	<form name="pricelistform" id="pricelistform" action="<?php echo base_url('admin/pricelist/pricechange')?>" method="post" enctype="multipart/form-data">
	<div class="table-responsive">
		<table class="table">
		<caption><h1 class="text-center">Bulk Price List</h1></caption>
<?php
	$sub_price_array=$this->config->item('sub_price');
	$yr = $sub_price_array[3];
	$yr = $yr/12;
?>
		<thead>
		<tr class="alert alert-info">
			<th class="text-center">Sr.</th>
			<th class="text-center">Product Name</th>
			<th class="text-center">Price</th>
			<th class="text-center"><?php echo $sub_price_array[0]; ?></th>
			<th class="text-center"><?php echo $sub_price_array[1]." Months"; ?></th>
			<th class="text-center"><?php echo $sub_price_array[2]." Months"; ?></th>
			<th class="text-center"><?php echo $yr." year"; ?></th>
		</tr>
		</thead>
		<tbody>
		<?php 
		   if(isset($productlist)){
			   $show_count=1;
			   	   $arr_price_count=0;
			   foreach($productlist as $pid=>$pval){
				   if(($pval->exam_id>0)&&($pval->subject_id==0)&&($pval->item_id==0)){
			   ?>
			   
		<tr>
			<td>
				<?php echo $show_count; $show_count++; ?>
			</td>
			<td>
				<input type="text" class="form-control" required="true" name="modules_item_name[]" value="<?php echo $pval->modules_item_name; ?>"  id="modules_item_name">
				<b><center>
				<?php echo $pval->id; ?>
				<input type='hidden' id='faction_pricelist_id' name="faction_pricelist_id[]"  value='<?php echo $pval->id; ?>'/>
				</center></b>
			</td>
			<td>
				<label class="control-label">Original Actual</label>
				<input class="form-control" required="true"  type="text" name="price[]" value="<?php echo $pval->price; ?>"  id="price"/>				
				<label class="control-label">Original Discount</label>
				<input class="form-control" required="true"  type="text" name="discounted_price[]" value="<?php echo $pval->discounted_price; ?>"  id="discounted_price"/>
			</td>
			<td>
				<label class="control-label">Date Actual</label>
				
				<?php 
				
				 if(isset($get_price_by_month[$arr_price_count][0])){
				   $coloum_zero=$get_price_by_month[$arr_price_count][0];
				   }else{
					$coloum_zero=0;   
				   }		
				?>
				
				<input class="form-control"  type="text" name="price_dt[]" value="<?php echo $coloum_zero->price; ?>"  id="price"/>
				
				<input class="form-control"  type="hidden" name="datevalue[]" value="<?php echo $sub_price_array[0]; ?>"  id="datevalue"/>

				
				<label class="control-label">Date Discount</label>
				<input class="form-control"  type="text" name="discounted_price_dt[]" value="<?php echo $coloum_zero->discounted_price; ?>"  id="discounted_price"/>
			</td>
			<td>
				<label class="control-label">Month 1 Actual</label>
				<?php
				if(isset($get_price_by_month[$arr_price_count][1])){
				   $coloum_one=$get_price_by_month[$arr_price_count][1];
				   }else{
					$coloum_one=0;   
				   }
				?>
				<input class="form-control" type="text" name="price_3m[]" value="<?php echo $coloum_one->price; ?>"  id="price"/>	
				
				<input class="form-control" type="hidden" name="monthone[]" value="<?php echo $sub_price_array[1]; ?>"  id="monthone"/>			
				<label class="control-label">Month 1 Discount</label>
				<input class="form-control" type="text" name="discounted_price_3m[]" value="<?php echo $coloum_one->discounted_price; ?>"  id="discounted_price"/>
			</td>
			<td>
				<label class="control-label">Month 2 Actual</label>
				<?php
				if(isset($get_price_by_month[$arr_price_count][2])){
				   $coloum_two=$get_price_by_month[$arr_price_count][2];
				   }else{
					$coloum_two=0;   
				   }
				?>
				<input class="form-control" type="text" name="price_6m[]" value="<?php echo $coloum_two->price; ?>"  id="price"/>
				
				<input class="form-control"   type="hidden" name="monthtwo[]" value="<?php echo $sub_price_array[2]; ?>"  id="monthtwo"/>		
		
				<label class="control-label">Moonth 2 Discount</label>
				<input class="form-control" type="text" name="discounted_price_6m[]" value="<?php echo $coloum_two->discounted_price; ?>"  id="discounted_price"/>
			</td>
			<td>
				<label class="control-label">Month 3 Actual</label>
				<?php
				if(isset($get_price_by_month[$arr_price_count][3])){
				   $coloum_three=$get_price_by_month[$arr_price_count][3];
				   }else{
					$coloum_three=0;   
				   }
				?>
				<input class="form-control" type="text" name="price_1y[]" value="<?php echo $coloum_three->price; ?>"  id="price"/>

<input class="form-control"   type="hidden" name="monththree[]" value="<?php echo $sub_price_array[3]; ?>"  id="monththree"/>					
				<label class="control-label">Month 3 Discount</label>
				<input class="form-control" type="text" name="discounted_price_1y[]" value="<?php echo $coloum_three->discounted_price; ?>"  id="discounted_price"/>
			</td>
		</tr>
		
	
		
		<!-- without table -->
       
           
           
                         
			   <?php 
			   } 
			   $arr_price_count++;
			   } 
			   }
			   ?>
 <tr>
				<td colspan="7" class="text-center">
				<input type='hidden' name='faction' id='faction' value='<?php echo $pval->id; ?>'/>
				
					<button class="btn btn-primary btn-lg" type="submit">Save Price</button>
				
			</td>
			</tr>			   
</tbody>
		<!-- // without table -->
		
        </table>
	</div>
	</form>
</div>
</div>