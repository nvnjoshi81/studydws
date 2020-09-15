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
                    <h1 class="page-header">Topics</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <?php if(!isset($result)){ ?>
            <div class="col-sm-12">
            <a href="#" class="btn btn-success pull-right new-acc">New Topic</a>
            <form class="filter-form" method="post" action="<?php echo base_url(); ?>admin/topics/filter"  >
         <div class="row">
         <div class="col-xs-5">
            <div class="input-group">
                <select name="cid" id="cid"class="form-control" >
                <option value=0>All</option>
                <?php foreach($chapters as $cl) { ?>
  <option value="<?php echo $cl->id ?>"><?php echo  $cl->name; ?></option>
<?php } ?>
                </select>
                <span class="input-group-btn">
                    <button type="submit"  class="btn btn-default">Filter</button>
                </span>
            </div>
        </div>
        </div>
</form>
</div>
                <?php } ?>

<div class="col-lg-12 clr-bth">
<!--form add new categories-->
<?php   //print_r($result); ?>

<form class="new-cat-form"  id="add_category_form" method="post" action="<?php echo base_url(); ?>admin/topics/add">
     <?php if(isset($result) && !isset($topic)) { 
         if($result->id!=NULL){ ?>      
            <h2>Edit Topic</h2>
     <?php } 
     
         } else{ ?>
    <h2>New Topic</h2>
     <?php }   ?>
    <div class="form-group">
             <label>Select Chapter</label>
             <select name="chapter_id" id="chapter_id" class="form-control">
                 
                 <?php foreach($chapters as $chapter){ 
                 if(isset($result) && $result->chapter_id == $chapter->id){
                        $selected='selected="selected"';
                    }else{
                        $selected='';
                    }    
                 ?>
                 <option value="<?php echo $chapter->id?>" <?php echo $selected;?>><?php echo $chapter->name?></option>
                 <?php } ?>
             </select>
         </div>
    <div class="form-group">
        <label>Topic Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($result->name)) { echo $result->name; } ?>">
    </div>
    <div class="form-group">
        <label>Order</label>
        <input type="text" class="form-control"  id="order" name="order" value="<?php if(isset($result->order)) { echo $result->order; } ?>">
    </div>
    



    <div class="form-group">
        <label>Meta Description</label>
        <textarea rows="5" class="form-control" name="description"><?php if(isset($result->description)) { echo $result->description; } ?></textarea>
    </div>
       <div class="form-group">
        <label>Meta Keywords</label>
        <textarea rows="5" class="form-control" name="keywords"><?php if(isset($result->description)) { echo $result->keywords; } ?></textarea>
    </div>
       <div class="form-group">
        <label>Tag Line</label>
        <textarea rows="5" class="form-control" name="tagline"><?php if(isset($result->description)) { echo $result->tagline; } ?></textarea>
    </div>
        
   
     <input type="hidden" name="update" id="update" value="<?php if(isset($result->id)) { echo $result->id; } ?>">  
     <?php if(isset($result->id)) {if($result->id!=NULL){ ?>
     <button type="submit" class="btn btn-primary">Update</button>
     <?php } } else  { ?>
    <button type="submit" class="btn btn-primary">Add</button>
     <?php }  ?>
</form>
</div>
               
        <?php  if(isset($topics)) { ?>
                <div class="col-lg-12">
            
                    <div class="panel">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr><th>No.</th>
                                            <th>Topic</th>
                                            <th>Chapter</th>
                                            <th>Order</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                <?php $i=1;
                
                  foreach($topics as $topic){?>
		         
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php if(isset($topic->name)) { echo $topic->name;}?></td>
                                    <td><?php echo 'Chapter';?></td>
                                    <td><?php if(isset($topic->order)) { echo $topic->order; } ?></td>
                                    <td class="center">
                                       
                                        <a href="<?php echo base_url(); ?>admin/topics/edit/<?php echo $topic->id; ?>" ><i class="fa fa-edit cat-edit" ></i></a>
                                        <a href="<?php echo base_url(); ?>admin/topics/delete/<?php echo $topic->id;?>"><i class="fa fa-trash cat-del"></i></a>
                                        
                                        
                                    </td>
                                </tr>
                <?php  $i++; }   ?>                           
                                        
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
        <?php } ?>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#chapter_id').multiselect({
            enableFiltering: true,
            includeSelectAllOption: false,
            maxHeight: 300,
           
             buttonWidth: '300px'
        });
    });
</script>
    