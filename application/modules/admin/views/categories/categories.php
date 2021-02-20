<script>
var d;    
$(document).ready(function() {
       
    /* $('#dataTables-example').DataTable(function(){
             responsive: true
     });*/ 
    $(".new-acc").click(function(){
       
    $(".new-cat-form").slideToggle();
  });
});
function newCategory(){
		d = document.category;
		d.cid.value = "";
		d.cname.value = "";
		d.corder.value = "";
		d.cparent.value = "";
		d.cdesc.value = "";
		//d.cprice.value = "0";
		d.action.value ="new";
		d.submitCat.value ="New Category";
		document.getElementById("form-tab").innerHTML ="New Category";
		show("formCat");
		location.href = "#formCat";
		$('form#category').attr('action', 'categories/add');
	}	
function editCategory(cid, corder,cparent,cprice){
alert("ok");

	        d = document.category;
		d.cid.value = cid;
		d.cname.value = document.getElementById('name-'+cid).innerHTML;
		d.corder.value = corder;
		d.cparent.value = cparent;
		d.cdesc.value = document.getElementById('desc-'+cid).innerHTML;//cdesc;
		alert(d.cdesc.value);

        //d.cprice.value = cprice;
		d.action.value ="edit";
		d.submitCat.value ="Edit Category";
		document.getElementById("form-tab").innerHTML ="Edit Category";
		show("formCat");
		location.href = "#formCat";
		$('form#category').attr('action', 'categories/add_categories');
	}	
   function deleteCategory(category){
		if (confirm('Delete Category "'+document.getElementById('name-'+category).innerHTML+'"?'))
		window.location = "categories/delete/"+category;
	}
        
     function filtercategory(cid){
         //alert(cid);
         // url: base_url+'categories/getsubcategories/'+catid,
          window.location = 'categories/filter/'+cid;
         }       
        
</script>
<?php if(!empty($result)){ ?>
<script>
$(document).ready(function() {
    
    $(".new-cat-form").slideToggle();
  
});
</script>
 <?php   }?>
<?php echo validation_errors(''); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Categories</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
          <div class="row">
         <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            <div class="input-group">
                 <form class="filter-form" method="post" action="<?php echo base_url(); ?>admin/categories/filter"  >
          <select name="cid" id="cid"class="form-control" >
                <option value=0>All</option>
                <?php foreach($allcategories as $cl) { 
				?>
  <option value="<?php echo $cl["id"] ?>"><?php echo $cl["name"]; ?></option>
<?php } ?>
                </select>
                <span class="input-group-btn">
                    <button type="submit"  class="btn btn-default">Filter</button>
                </span></form>
            </div>
        </div>
         <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            <div class="input-group">
                 <form class="filter-form" method="post" action="<?php echo base_url(); ?>admin/categories/search_filter"  >
                     <input type="text" name="catename" id="catename" class="form-control" >
                <span class="input-group-btn">
                    <button type="submit"  class="btn btn-default">Search</button>
                </span></form>
            </div>
        </div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
		<a href="#" class="btn btn-success new-acc">New Categories</a>
		</div>
        </div>


<div class="row">
<form class=""  id="add_category_form" method="post" action="<?php echo base_url(); ?>admin/categories/add_categories">
     <?php if(isset($result[0]->id)) { if($result[0]->id!=NULL){ ?>      
    
     <?php } } else{ ?>
    <h2>New Category</h2>
     <?php }   ?>
<h2>Edit Category</h2>
<!--form add new categories-->
<?php 
  //print_r($result); ?>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="form-group">
        <label>Category Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($result[0]->name)) { echo $result[0]->name; } ?>">
    </div>
	   <div class="form-group">
        <label>Hindi Category Name</label>
        <input type="text" class="form-control" id="catname" name="catname" value="<?php if(isset($resulthindi[0]->name)) { echo $resulthindi[0]->name; } ?>">
    </div>
    <div class="form-group">
        <label>Order</label>
        <input type="text" class="form-control"  id="order" name="order" value="<?php if(isset($result[0]->order)) { echo $result[0]->order; } ?>">
    </div>
    <div class="form-group">
	<?php 
	if(isset($result[0]->parent_id)){
	$lavelParentid=$result[0]->parent_id;
	}else{
	$lavelParentid=0;
	}
	?>
        <label>Parent</label>
        <select class="form-control" name="cparent" id="cparent"><option value=0>Top Level</option>
<?php
foreach($allcategories as $cl) { 
if($lavelParentid==$cl["id"]){
	$selction='selected=selected';
}else{
	$selction='';
}
?>
  <option value="<?php echo $cl["id"] ?>" <?php echo $selction ;?>><?php  echo $cl["name"]; ?></option>
<?php } ?>
</select>
	</div>
	
	<div class="form-group">
        <label>Meta Description</label>
        <textarea rows="5" class="form-control" name="description"><?php if(isset($result[0]->description)) { echo $result[0]->description; } ?></textarea>
    </div>
	
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
       <div class="form-group">
        <label>Meta Keywords</label>
        <textarea rows="5" class="form-control" name="keywords"><?php if(isset($result[0]->description)) { echo $result[0]->keywords; } ?></textarea>
    </div>
       <div class="form-group">
        <label>Tag Line</label>
        <textarea rows="5" class="form-control" name="tagline"><?php if(isset($result[0]->description)) { echo $result[0]->tagline; } ?></textarea>
    </div>
        
       <div class="form-group">
        <label>Link to Page</label>
        <input type="text" name="link" value="<?php if(isset($result[0]->link)) { echo $result[0]->link; } ?>">
    </div>
</div>
     <input type="hidden" class="form-control" name="update" id="update" value="<?php if(isset($result[0]->id)) { echo $result[0]->id; } ?>">  
     <?php if(isset($result[0]->id)) {if($result[0]->id!=NULL){ ?>
     <button type="submit" class="btn btn-primary">Edit Category</button>
     <?php } } else  { ?>
    <button type="submit" class="btn btn-primary">New Category</button>
     <?php }  ?>
</form>
</div>				
<!-- /.row -->

	<!-- display sub category -->
	<div class="row">
	</div>
	<!-- // display sub category -->

<!-- extra -->
<div class="row">
	<div class="col-lg-12">
            
                    <div class="panel panel-default">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr><th>No.</th>
                                            <th>SQL Id.</th>
                                            <th>Categories</th>
                                            <th>Order</th>
                                            <th>Parent</th>
                                            <th>Action</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    
                <?php $i=1;
                
                if(isset($tocategories)) {
                  foreach($tocategories as $category){?>
		<?php 
              
			if($category->parent_id  >0){
                                                                        
				$p_category=$this->categories_model->getPrentName($category->parent_id);
                			                $parent_category=$p_category[0]->name;
			}else{
				$parent_category='Parent';
			}
						
						
						?>  
                                 <tbody>       
                                <tr class="odd gradeX">
                                    <td><?php echo $i.''; ?></td>
                                    <td><?php echo ''.$category->id.''; ?></td>
                                    <td><?php if(isset($category->name)) { echo $category->name;}?></td>
                                    <td><?php if(isset($category->order)) { echo $category->order; } ?></td>
                                    <td><?php echo $parent_category;?></td>
                                    <td class="center">
                                        <!--<a href="#" onclick="editCategory('<?php echo $category->id;?>', '<?php echo $category->order;?>','<?php echo $category->parent_id;?>','0');return false;"><i class="fa fa-edit cat-edit"></i></a>-->
                                        <a href="<?php echo base_url(); ?>admin/categories/edit_categories/<?php echo $category->id; ?>" ><i class="fa fa-edit cat-edit" ></i></a>
                                       <!-- <a href="#" onclick="deleteCategory('<?php //echo $category->id;?>');return false;"><i class="fa fa-trash cat-del"></i></a>-->
                                        <a href="<?php echo base_url(); ?>admin/categories/delete/<?php echo $category->id;?>"><i class="fa fa-trash cat-del"></i></a>
                                        <a href="<?php echo base_url(); ?>admin/categories/content/<?php echo $category->id;?>"><i class="fa fa-cogs cat-edit"></i></a>
                                        <div style="display:none;" id="name-<?php echo $category->id;?>"><?php echo $category->name;?></div>
		                        <div style="display:none;" id="desc-<?php echo $category->id;?>"><?php echo $category->description;?></div>
                                    </td>
									<td class="text-center">
									<a href="<?php echo base_url(); ?>admin/categories/sub_categories/<?php echo $category->id; ?>" class="alert-warning">Add Sub-Category</a>
									</td>
                                </tr>
                <?php  $i++; }  } ?>                           
                                        
                                 </tbody>
                                 <tfoot>
                                     <tr>
                                         <td colspan="6">
                                             <?php  echo "<h6><b>";
                                                    echo $data["links"] = $this->pagination->create_links()."</b></h6>";?>
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
</div>
<!-- /#page-wrapper -->