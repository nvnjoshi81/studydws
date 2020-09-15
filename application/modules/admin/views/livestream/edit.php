<div id="page-wrapper">   
    <div class="row">
        <div class="col-lg-12">
            <h1>Edit Livestream</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
  
    <?php
            if ($this->session->flashdata('message')) {
                ?>
                <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?>
                </div>

                <?php
            }
            ?>
    <!-- /.row -->
    <div class="row">
        <form role="form" id="contact-form" class="contact-form" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/notification/submitedit'); ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">                        
                        <input name="id" value="<?php echo $mediaResult->id; ?>" type="hidden">
                        <input name="image" value="<?php echo $mediaResult->image; ?>" type="hidden">
                        <input name="image_big" value="<?php echo $mediaResult->image_big; ?>" type="hidden">
                        <input value="<?php echo $mediaResult->title; ?>" type="text" class="form-control" name="title" autocomplete="off" id="title" placeholder="Title">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea class="form-control textarea" rows="3" name="description" id="description" placeholder="Description"><?php echo $mediaResult->description; ?></textarea>
                    </div>
                </div>
            </div>
			
			
				<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                   <?php   
    $content_type_exam_id=$mediaResult->class_id;        
//echo generateSelectBox('category_disabled', $exams, 'id', 'name', 1 , 'class="form-control" disabled=disabled ',$content_type_exam_id); 
    ?> <input type="hidden" name="category"  id="category"  value="<?php echo $content_type_exam_id;  ?>" ><?php
    ?>  <label>Select Exam</label><?php
        
echo generateSelectBox('class_id', $exams, 'id', 'name', 1 , 'class="form-control"',$content_type_exam_id); 
        
?>
                       <input value="<?php echo $mediaResult->date; ?>" type="hidden" name="date">
                    </div>
                </div>
            </div>
      	   <div class="row">
                <div class="col-md-6">
                    <div class="form-group"><label>Content Type</label>
			<?php
			  
			//echo generateSelectBox('content_type', $cntarray, 'id', 'name', 1 , 'class="form-control"',$mediaResult->content_type); 
			
			echo generateSelectBox('content_type', $contentArray, 'id', 'name', 1 , 'class="form-control"',$mediaResult->content_type); 
			?>
			</div>
			</div>
			</div>	

<div class="row">
            <div class="col-md-6">
            <div class="form-group"><label>Notification Type</label>
<select name="noti_type" id="noti_type" class="form-control">
<option value="0">Select Type..</option>
<?php
if(isset($mediaResult->notitype)&&$mediaResult->notitype=='web'){
?>
<option value="web" selected>Web</option>
<?php	
}else{
?>
	<option value="web">Web</option>
<?php
}
if(isset($mediaResult->notitype)&&$mediaResult->notitype=='app'){
?>
<option value="app" selected>App</option>
<?php
}else{
	?>
	
<option value="app">App</option>
	<?php
}
?>


</select>
			</div>
			</div>
			</div>
			
			<div class="row">
                <div class="col-md-6">
                    <div class="form-group"><label>package id</label>
                        <input type="text" class="form-control" name="packageid" autocomplete="off" id="packageid" placeholder="packageid" value="<?php echo $mediaResult->packageid; ?>">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary pull-right">Edit Media</button>
                </div>
            </div>
        </form>
    </div>
  <div class="row">
<div class="col-lg-12">
                    
                    <div class="panel">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr><th width='50'>
                                                Id. 
                                            </th>
                                            <th>Title</th>
                                            <th>Notification</th>  
                                            <th>Class</th>
											<th>Content Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                <?php		
				
				function showClassname($exams,$classid){
$classname='NA';
				foreach($exams as $key=>$value){
		if($value->id==$classid){
				$classname=$value->name;
			    return $classname; 
				}
				}	
return $classname;					
				}
				
				
$i = 1;
if (isset($media)) {

	foreach ($media as $item) { 

	?>
        <tr class="odd gradeX">
                                    <td><?php echo $item->id;?> (<?php echo $item->notitype;?>)</td>
                                    <td><?php 
                                            echo $item->title;
                                           
                                        ?>
                                    </td>
                                        
                                    <td><?php
                                    
                                                echo $item->description;
                                          	?></td> 
                                    
                                    <td><?php
if(isset($item->class_id)&&$item->class_id>0){ 
 echo showClassname($exams,$item->class_id) ;
}else{
	echo 'NA';
}
												
                                          	?></td>
                                    <td><?php
                                    
                                                echo $item->content_type;
                                          	?></td>
                                     
                                    <td class="center">
                                        <a href="<?php echo base_url();?>admin/notification/edit/<?php echo $item->id;?>" >
                                            <i class="fa fa-edit cat-edit" ></i>
                                        </a>
                                        <a href="<?php echo base_url(); ?>admin/notification/delete/<?php echo $item->id;?>">
                                            <i class="fa fa-trash cat-del"></i>
                                        </a>
										    <a href="<?php echo base_url(); ?>admin/notification/notify/<?php echo $item->id;?>">
                                            <i>SEND</i>
                                        </a>
                                        
    
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
</div>

</div>
