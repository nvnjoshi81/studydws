<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Admin Users</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <div class="col-sm-12">
            <a href="<?php echo base_url()?>admin/adminusers/add" class="btn btn-primary pull-right new-acc">Add New User</a>
        </div>
        <div class="col-lg-12">
            
                    <div class="panel">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                             <?php if(isset($adminusers)  && count($adminusers) > 0) { ?>
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr><th>ID.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                <?php $i=1;
               
                  foreach($adminusers as $user){?>
		
                                        
                                <tr class="odd gradeX">
                                    <td><?php echo $user->id; ?></td>
                                    <td><?php  echo $user->first_name.' '.$user->last_name;?></td>
                                    <td><?php  echo $user->email;  ?></td>
                                    <td class="center">
                                    <a href="<?php echo base_url(); ?>admin/adminusers/edit/<?php echo $user->id; ?>" ><i class="fa fa-edit cat-edit" ></i></a>
                                    <a href="<?php echo base_url(); ?>admin/adminusers/delete/<?php echo $user->id;?>"><i class="fa fa-trash cat-del"></i></a>
                                    
                                    </td>
                                </tr>
                <?php  $i++; }  ?>                           
                                        
                                 </tbody>
                                 
                               </table>
                            </div>
                            <!-- /.table-responsive -->
                             <?php } ?>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
    </div>
</div>