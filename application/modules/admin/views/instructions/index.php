<script>
var d;    
$(document).ready(function() {
       
    /* $('#dataTables-example').DataTable(function(){
             responsive: true
     });
    */ 
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
		d.submitCat.value ="New Instructions";
		document.getElementById("form-tab").innerHTML ="New Instructions";
		show("formCat");
		location.href = "#formCat";
		$('form#category').attr('action', 'instructions/add');
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
		d.submitCat.value ="Edit Instructions";
		document.getElementById("form-tab").innerHTML ="Edit Instructions";
		show("formCat");
		location.href = "#formCat";
		$('form#category').attr('action', 'instructions/add_instructions');
	}	
   function deleteCategory(category){
		if (confirm('Delete Category "'+document.getElementById('name-'+category).innerHTML+'"?'))
		window.location = "instructions/delete/"+category;
	}
        
     function filtercategory(cid){
         //alert(cid);
         // url: base_url+'categories/getsubcategories/'+catid,
          window.location = 'instructions/filter/'+cid;
         }       
        
</script>
<?php if(!empty($instructions)){ ?>
<script>
$(document).ready(function() {
    
    $(".new-cat-form").slideToggle();
  
});
</script>
 <?php   }?>
<?php echo validation_errors(''); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-6">
                    <?php if(isset($instructions->id)) { if($instructions->id!=NULL){ ?>      
    <h2>Edit Instructions</h2>
     <?php } } else{ ?>
    <h2>New Instructions</h2>
     <?php } ?>
                </div>
                 <div class="col-sm-6">
                <?php
            if(isset($instructions->id)) { 

                }else{
                ?>
            <a href="#" class="btn btn-success pull-right new-acc">New Instruction</a>
                <?php 
                }
        ?></div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">           
        <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
         ?>
<div class="col-lg-12 clr-bth">
<!--form add new categories-->
<?php 
  //print_r($result); ?>

<form class="new-cat-form"  id="add_category_form" method="post" action="<?php echo base_url(); ?>admin/instructions/add"  enctype="multipart/form-data">
     <?php
     
        if (isset($instructions->description))
        {
        $instructions_text=$instructions->description;
       }else{
          $instructions_text=''; 
       }
     
     ?>
     <div class="form-group">
        <label>Content Type</label>
        <?php
         if (isset($instructions->content_type))
        {
        $content_type_id=$instructions->content_type;
       }else{
          $content_type_id=0; 
       }
    echo generateSelectBox('content_type', $content_type_array, 'id', 'name', 1, 'class="form-control" onChange="resetSelect();showOptions($(this).find(\'option:selected\').text());"',$content_type_id); 
        ?>
    </div>
    <div class="form-group">
          <label class="url">Upload Instructions Description</label>
           <input type="file" name="zip_file" value=""  id="zip_file"/> 
    </div>
    <p><font size="4" color="blue">OR</font><p>
    <div class="form-group">
        <label>Instructions Description</label>
       <textarea name="description"   id="question" class="form-control"><?php echo $instructions_text ;?></textarea>
    </div>
   
   <input type="hidden" name="update" id="update" value="<?php if(isset($instructions->id)) { echo $instructions->id; } ?>">  
     <?php if(isset($instructions->id)) {if($instructions->id!=NULL){ ?>
     <button type="submit" class="btn btn-primary">Update</button>
     <?php } } else  { ?>
    <button type="submit" class="btn btn-primary">Add</button>
     <?php }  ?>
</form>
                </div>
          
                <div class="col-lg-12">
            
                    <div class="panel panel-default">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr><th>Sql Id</th>
                                            <th>Instruction Description</th>
                                            <th>Content Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                <?php $i=1;
                if(isset($instructions_list)) {
                  foreach($instructions_list as $intlist){ ?>
		
                                        
                                <tr class="odd gradeX">
                                    <td><?php if(isset($intlist->id)) { echo $intlist->id;}; ?></td>
                                    <td><?php if(isset($intlist->description)) { echo $intlist->description;}?></td>
                                    <td><?php if(isset($intlist->content_type)) { echo $intlist->content_type; } ?></td>
                                    <td class="center">
                                        
                                        <a href="<?php echo base_url(); ?>admin/instructions/edit/<?php echo $intlist->id; ?>" ><i class="fa fa-edit cat-edit" ></i></a>
                                   
                                        <a href="<?php echo base_url(); ?>admin/instructions/delete/<?php echo $intlist->id;?>"><i class="fa fa-trash cat-del"></i></a>
                                     
                                              
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
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    <script type="text/javascript">
  tinymce.init({
    selector: 'textarea',
    inline: false,
    height: 280,
    width:1000, 
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools '
  ],
  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  filemanager_title:"Responsive Filemanager",
    external_filemanager_path:"/filemanager/",
    external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
  content_css: [
    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
    '//www.tinymce.com/css/codepen.min.css'
  ],
  automatic_uploads: true,
  relative_urls: false
  });
  </script>