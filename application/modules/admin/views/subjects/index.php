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
<?php
if (!empty($result)) {
?>
<script>
$(document).ready(function() {
    
    $(".new-cat-form").slideToggle();
  
});
</script>
 <?php
}
?>
<?php
echo validation_errors('');
?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Subjects</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            <a href="#" class="btn btn-success pull-right new-acc">New Subject</a>
            </div>

<div class="row">
<form class=""  id="add_category_form" method="post" action="<?php echo base_url();?>admin/subjects/add">
    <?php
    if (isset($result->id)) {
        if ($result->id != NULL) {
    ?>      
    <h2>Edit Subject</h2>
     <?php
        }
    } else {
    ?>
        <h2>New Subject</h2>
     <?php } ?>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
   <div class="form-group">
        <label>Subject Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php if (isset($result->name)) { echo $result->name; }?>">
    </div>
    <div class="form-group">
        <label>Order</label>
        <input type="text" class="form-control"  id="order" name="order" value="<?php if (isset($result->order)) { echo $result->order;}?>">
    </div>
   <div class="form-group">
        <label>Meta Description</label>
        <textarea rows="5" class="form-control" name="description"><?php if (isset($result->description)) { echo $result->description;}?></textarea>
    </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">	
    <div class="form-group">
        <label>Meta Keywords</label>
        <textarea rows="5" class="form-control" name="keywords"><?php if (isset($result->description)) { echo $result->keywords;}?></textarea>
    </div>
       <div class="form-group">
        <label>Tag Line</label>
        <textarea rows="5" class="form-control" name="tagline"><?php if (isset($result->description)) { echo $result->tagline;}?></textarea>
    </div>
</div>      
       
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
     <input type="hidden" name="update" id="update" value="<?php if (isset($result->id)) { echo $result->id;}
?>">  
     <?php
if (isset($result->id)) {
    if ($result->id != NULL) {
?>
    <button type="submit" class="btn btn-primary">Update</button>
     <?php
    }
} else {
?>
   <button type="submit" class="btn btn-primary">Add Subject</button>
     <?php
}
?>
</div>
</form>
</div>
          <br><br>
                <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr><th class="text-center">No.</th>
                                            <th class="text-center">Subject</th>
                                            <th class="text-center">Order</th>
                                            
                                            <th class="text-center">Action</th>
											<th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                <?php
$i = 1;
if (isset($subjects)) {
    foreach ($subjects as $subject) { ?>
       
                                        
                                <tr class="odd gradeX">
                                    <td class="text-center"><?php echo $i;?></td>
                                    <td><?php if (isset($subject->name)) {
                                            echo $subject->name;
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center"><?php
                                            if (isset($subject->order)) {
                                                echo $subject->order;
                                            }
                                        ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        
                                        <a href="<?php echo base_url();?>admin/subjects/edit/<?php echo $subject->id;?>" >
                                            <i class="fa fa-edit cat-edit" ></i>
                                        </a>
                                     
                                        <a href="<?php
        echo base_url();
?>admin/subjects/delete/<?php
        echo $subject->id;
?>"><i class="fa fa-trash cat-del"></i></a>
                                        
    <div style="display:none;" id="name-<?php echo $subject->id;?>">
        <?php echo $subject->name;?>
    </div>
    <div style="display:none;" id="desc-<?php echo $subject->id;?>">
        <?php echo $subject->description;?>
    </div>
</td>

<td class="text-center">
<a href="<?php echo base_url(); ?>admin/subjects/sub_subjects/<?php echo $subject->id; ?>" class="btn btn-primary alert-info">Add Sub-Subjects</a>
</td>
</tr>
                <?php
        $i++;
    }
}
?>                          
                                        
                                 </tbody>
                                     <tr>
                                         <td colspan="6">
                                             <?php
echo "<h6><b>";
echo $data["links"] = $this->pagination->create_links() . "</b></h6>";
?>
                                        </td>
                                     </tr>
                               </table>
                            </div>
            </div>
            <!-- /.row -->
    </div>
    <!-- /#wrapper --> 