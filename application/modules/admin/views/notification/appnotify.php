<div id="page-wrapper">
    <div class="row">
                <div class="col-lg-12">
                    <h1 >Notification Contents<span class="pull-right"><a class="btn btn-primary" href="<?php echo base_url('admin/notification/add');?>">Add New</a></span></h1>
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
                                    
                                                echo $item->class_id;
                                          	?></td>
                                    <td><?php
                                    
                                                echo $item->packageid;
                                          	?></td>
                                     
                                    <td class="center">
                                        
                                        <a href="<?php echo base_url();?>admin/notification/edit/<?php echo $item->id;?>" >
                                            <i class="fa fa-edit cat-edit" ></i>
                                        </a>
                                     
                                        <a href="<?php echo base_url(); ?>admin/notification/delete/<?php echo $item->id;?>">
                                            <i class="fa fa-trash cat-del"></i>
                                        </a>
										
                                        <a href="<?php echo base_url('service_app/sendbulk_notification.php'); ?>
										<?php echo $item->id;?>">
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