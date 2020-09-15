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
                    <h1 class="page-header">Chapters (<?php echo $total;?>)</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="row">
                <div class="col-sm-9">
                    <div id="search-name" class="col-sm-6">
                    <form method="post" action="<?php echo base_url('admin/chapters/search')?>">
            
               
                    <div class="input-group custom-search-form">
                        <input type="text" placeholder="Search..." class="form-control" name="search">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                        
                  </form>
                    </div>      
                    <!--Search By Id-->
                    <div id="search-name" class="col-sm-3" >
                       <form method="post" action="<?php echo base_url('admin/chapters/search')?>">
            
               
                    <div class="input-group custom-search-form">
                        <input type="text" placeholder="Search by Id" class="form-control" name="searchid">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default" name="submit_search">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                        
        </form> 
             </div>       
                </div>
            <div class="col-sm-3">
            <a href="#" class="btn btn-success pull-right new-acc">New Chapter</a>
            </div>
            </div>            
<div class="col-lg-12 clr-bth">


<form class="new-cat-form"  id="add_category_form" method="post" action="<?php echo base_url();?>admin/chapters/add">
  

    <div class="col-sm-12">
        
      <?php
    if (isset($result->id)) {
        if ($result->id != NULL) {
    ?>      
    <h2>Edit Chapter</h2>
     <?php
        }
    } else {
    ?>
        <h2>New Chapter</h2>
     <?php } ?>
        <div class="col-sm-6">
         <div class="form-group">
             <label>Select Classes/Exams</label>
             <select name="class[]" id="class"  multiple="multiple" class="form-control">
                 
                 <?php foreach($exams as $exam){ 
                    if(count($chapter_classes) > 0 && in_array($exam->id, $chapter_classes)){
                        $selected='selected="selected"';
                    }else{
                        $selected='';
                    }
                 ?>
                 <option value="<?php echo $exam->id?>"  <?php echo $selected;?>><?php echo $exam->name?></option>
                 <?php } ?>
             </select>
         </div>
        </div>
<div class="col-sm-6">
            <div class="form-group">
                <label>Select Subject</label>
             <select name="subject[]" id="subject" multiple class="form-control">
                 
                 <?php foreach($subjects as $subject){ 
                 if(count($chapter_subjects) > 0 && in_array($subject->id, $chapter_subjects)){
                        $selected='selected="selected"';
                    }else{
                        $selected='';
                    }    
                 ?>
                 <option value="<?php echo $subject->id?>" <?php echo $selected;?>><?php echo $subject->name?></option>
                 <?php } ?>
             </select>
         </div>
          </div>
        </div>
   <div class="form-group">
        <label>Chapter Name</label>
        <input onkeydown="getChapter();" onblur="getChapter();" type="text" class="form-control" id="name" name="name" value="<?php if (isset($result->name)) { echo $result->name; }?>">
        <br><div id="suggestion" class="alert alert-warning" style="display:none"></div>
    </div>
    <div class="form-group">
        <label>Order</label><a target="_blank" href="<?php echo base_url("admin/contents/sortlist");?>"> Click here to set order </a>
		<?php if (isset($result->order)) { 
		$chapterOrder = $result->order;
		}else{
		$chapterOrder=0;
		}
		?>
		
        <input type="hidden" class="form-control"  id="order" name="order" value="<?php echo $chapterOrder ; ?>">
    </div>
   <div class="form-group">
        <label>Meta Description</label>
        <textarea rows="5" class="form-control" name="description"><?php if (isset($result->description)) { echo $result->description;}?></textarea>
    </div>
    <div class="form-group">
        <label>Meta Keywords</label>
        <textarea rows="5" class="form-control" name="keywords"><?php if (isset($result->description)) { echo $result->keywords;}?></textarea>
    </div>
       <div class="form-group">
        <label>Tag Line</label>
        <textarea rows="5" class="form-control" name="tagline"><?php if (isset($result->description)) { echo $result->tagline;}?></textarea>
    </div>
       
       
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
   <button type="submit" class="btn btn-primary">Add</button>
     <?php
}
?>
</form>
                </div>
          
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
                                                <a href="<?php echo base_url('admin/chapters/')?>?col=id&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?>
                                            </th>
                                            <th>Chapter<?php if($ordercol=='name'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=name&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=name&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url('admin/chapters/')?>?col=name&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?></th>
                                             <th>Class</th>
                                            <th>Subject</th>
                                            <th>Order</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                <?php
$i = 1;
if (isset($chapters)) {

	foreach ($chapters as $chapter) { 

// print_r($chapters);
	?>
       
                                        
                                <tr class="odd gradeX">
                                    <td><?php echo $chapter['id'];?></td>
                                    <td><?php if (isset($chapter['name'])) {
                                            echo $chapter['name'];
                                            }
                                        ?>
                                    </td>
                                 
                                        
                                    <td><?php
                                    if (isset($chapter['classes'])) {
                                                echo $chapter['classes'];
                                            }
									?></td>
                                    <td><?php
                                    if (isset($chapter['subjects'])) {
                                                echo $chapter['subjects'];
                                            }
									?></td>
                                       <td><?php
                                            if (isset($chapter['order'])) {
                                                echo $chapter['order'];
                                            }
                                        ?> 
                                        
                                        </td>
                                    <td class="center">
                                        
                                        <a href="<?php echo base_url();?>admin/chapters/edit/<?php echo $chapter['id'];?>" >
                                            <i class="fa fa-edit cat-edit" ></i>
                                        </a>
                                     
                                        <a href="<?php echo base_url(); ?>admin/chapters/delete/<?php echo $chapter['id'];?>">
                                            <i class="fa fa-trash cat-del"></i>
                                        </a>
                                        
    <div style="display:none;" id="name-<?php echo $chapter['id'];?>">
        <?php echo $chapter['name'];?>
    </div>
    <div style="display:none;" id="desc-<?php echo $chapter['id'];?>">
        <?php echo $chapter['description'];?>
    </div>
</td>
</tr>
                <?php
        $i++;

    }
}
?>                          
                                        
                                 </tbody>
                                 <tfoot>
                                     <tr>
                                         <td colspan="6">
                                             <?php
echo "<h6><b>";
echo $data["links"] = $this->pagination->create_links() . "</b></h6>";
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
    <!-- /#wrapper --> 
    <script type="text/javascript">
    $(document).ready(function() {
        $('#class').multiselect();
        $('#subject').multiselect();
        
    });
    function getChapter(){
        var name=$('#name').val();
        $('#suggestion').html('');
        if(name.length >2 ){
        $.ajax({
                url:base_url+"admin/chapters/getChapterByName/"+name,  
                dataType:'json',
                success:function(response) {
                if(response.length > 0){
                    $.each( response, function( key, value ) {
                        var html=$('#suggestion').html();
                        if(html == ''){
                            $('#suggestion').html(value.name);
                        }else{
                            $('#suggestion').html(html+"<br>"+value.name );
                        }
                         $('#suggestion').show();
                    });
                }else{
                     $('#suggestion').hide();
                }
            }
        });
    }
    }
</script>