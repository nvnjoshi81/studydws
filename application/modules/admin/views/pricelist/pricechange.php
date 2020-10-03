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
			
	<div class="form-group col-lg-3 col-xs-12 text-capitalize">
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
		
		<div class="col-lg-9">
		<form id="set_val_date" name="search_customer_form" method="post" action="<?php echo base_url(); ?>admin/customers/set_validity">


			<div class="form-group col-lg-5">
					<label>Date </label>
					<div class='input-group date' id='datetimepicker6'>
						<input type='text' class="form-control" id="start_date"  name="start_date" placeholder="Ex-2016-09-14" required />
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
                    <input type="number" id="cfname" class="form-control" name="cfname" value="" min="1" max="31" title="Please enter a value that is no more than 31" required> 
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
		
	
	
        <div class="col-lg-12">
            <h1 class="page-header">Bulk Price List</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <div class="col-sm-12">
            <!--<div class="col-sm-3">
                <div class="form-group">
                    <label>Select Content Type</label>
                    <?php //echo generateSelectBox('content_type',$content_type,'id','name',1,'class="form-control" onChange="resetSelect();"');?>
                </div>
            </div>-->
            
           <form name="pricelistform" id="pricelistform" action="<?php echo base_url('admin/pricelist/pricechange')?>" method="post" enctype="multipart/form-data">   
            <div class="col-lg-12 alert alert-success" id="pricedata">
           <?php 
		   if(isset($productlist)){
			   $show_count=1;
			   foreach($productlist as $pid=>$pval){
				   if(($pval->exam_id>0)&&($pval->subject_id==0)&&($pval->item_id==0)){
				   
			   ?>
                  <div class="col-sm-12">
			<div class="col-sm-2">
                <div class="form-group">
                    <label><?php echo $show_count; $show_count++; ?></label>
                </div>
            </div>	  
				  
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Product Name</label>        
                    <input required="true" name="modules_item_name[]" value="<?php echo $pval->modules_item_name; ?>"  id="modules_item_name">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Product Price</label>
                    <input required="true"  type="text" name="price[]" value="<?php echo $pval->price; ?>"  id="price"/></div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                <label>Discounted Price</label>
                <input required="true"  type="text" name="discounted_price[]" value="<?php echo $pval->discounted_price; ?>"  id="discounted_price"/>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                <label>SQL ID&nbsp;<?php echo $pval->id; ?></label>
<input type='hidden' id='faction_pricelist_id' name="faction_pricelist_id[]"  value='<?php echo $pval->id; ?>'/>	
                </div>
            </div>			
		</div>        
			   <?php 
			   }
			   } 
			   }
			   ?>				  
               </div>   
            <input type='hidden' name='faction' id='faction' value='<?php echo $pval->id; ?>'/>
            <div class="col-sm-6 pull-left">
                <div class="form-group">    
                <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>       
            
            <div class="col-lg-12"></div>
        </div>
        </div>
        </form>
		</div>
</div>
