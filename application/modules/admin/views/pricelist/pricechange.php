<div id="page-wrapper" class="row">
    <div class="row">
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
