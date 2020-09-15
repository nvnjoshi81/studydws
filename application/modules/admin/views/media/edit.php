<div id="page-wrapper">   
    <div class="row">
        <div class="col-lg-12">
            <h1>Edit Media</h1>
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
        <form role="form" id="contact-form" class="contact-form" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/media/submitedit'); ?>">
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
                <div class="col-md-6">Ex:Sep 15, 2015
                    <div class="form-group">
                         <input value="<?php echo $mediaResult->date; ?>" type="text" class="form-control" name="date" autocomplete="off" id="date" placeholder="Date">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="briefing_doc">Select Image (Only JPG)</label>
                        <div class="col-md-4">
                            <input id="mediaimage" name="mediaimage" class="input-file" type="file">
                        </div>
                    </div>
                </div></div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="briefing_doc">Select Big Image (Only JPG)</label>
                        <div class="col-md-4">
                            <input id="mediaimage_big" name="mediaimage_big" class="input-file" type="file">
                        </div>
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
                                            <th>Image</th>
                                             <th>Image Big</th>
                                            <th>Date Added</th>
                                           
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                <?php
$i = 1;
if (isset($media)) {

	foreach ($media as $item) { 

	?>
        <tr class="odd gradeX">
                                    <td><?php echo $item->id;?></td>
                                    <td><?php 
                                            echo $item->title;
                                           
                                        ?>
                                    </td>
                                        
                                    <td><?php
                                    
                                                echo $item->image;
                                          	?></td> 
                                    
                                    <td><?php
                                    
                                                echo $item->image_big;
                                          	?></td>
                                    <td><?php
                                    
                                                echo $item->date;
                                          	?></td>
                                     
                                    <td class="center">
                                        
                                        <a href="<?php echo base_url();?>admin/media/edit/<?php echo $item->id;?>" >
                                            <i class="fa fa-edit cat-edit" ></i>
                                        </a>
                                     
                                        <a href="<?php echo base_url(); ?>admin/media/delete/<?php echo $item->id;?>">
                                            <i class="fa fa-trash cat-del"></i>
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
