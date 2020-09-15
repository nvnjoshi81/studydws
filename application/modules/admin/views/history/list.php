

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">History</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            


          
                <div class="col-lg-12">
            
                    <div class="panel panel-default">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr><th>#.</th>
                                            <th>User </th>
                                            <th>IP Address </th>
                                            <th>Video/File</th>
                                            <th>Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                <?php $i=$index;
                if(isset($histories)) {
                foreach($histories as $history){ ?>
                    <tr class="odd gradeX">
                        <td><?php echo $i; ?></td>
                        <td><a href="<?php echo base_url('admin/customers/edit/'.$history->user_id)?>"><?php echo $history->firstname;?></a></td>
                        <td><?php echo $history->ip_address?></td>
                        <td><?php if(isset($history->fileid)) { echo $history->fileid; }else{  echo $history->video_id;} ?></td>
                        <td><?php echo $history->dt_created?></td>
                        
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