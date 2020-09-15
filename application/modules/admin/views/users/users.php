<script>
    
   $(document).ready(function() {
        /*$('#dataTables-example').DataTable({
                responsive: true
        });*/
   
    
    $(".new-acc").click(function(){
    $(".new-acc-form").slideToggle();
});
 });
 
</script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">User's list</h2>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            <div class="col-sm-12">
            <a href="#" class="btn btn-success pull-right new-acc">New Account</a>
           <!---news user form here-->
           <form class="new-acc-form"  id="add_users" method="post" action="<?php echo base_url();?>admin/user/add_user">
            <div class="form-group">
        <label>Company Name</label>
        <input type="text" class="form-control" name="companyname" id="companyname" >
    </div>
               
               <div class="form-group">
        <label>First Name</label>
        <input type="text" class="form-control" name="firstname" id="firstname" >
    </div>
    <div class="form-group">
        <label>Last Name</label>
        <input type="text" class="form-control" name="lastname" id="lastname">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control"  name="email" id="email" >
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control"  name="password" id="password" >
    </div>
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" class="form-control" name="confirm_password" id="confirm_password" >
    </div>
    <!--<button type="submit" class="btn btn-primary" name="submit">New Account</button>-->
    <input type="submit" name="submit" class="btn btn-primary" value="New Account"/>
</form>
</div>
                <div class="col-lg-12 clr-bth">
                
                    <div class="panel panel-default">
                   
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Active</th>
                                            <th>Date Created</th>
                                            <th>Delete</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; if(isset($users)){ 
                                                  foreach($users as $row){
                                              ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row->firstname; ?>&nbsp;<?php echo $row->lastname; ?></td>
                                            <td><?php echo $row->email; ?></td>
                                            <td><?php if(($row->verified)==0){
                                                                 echo "No";
                                                                  $id=$row->id;
                                                              ?>
                                                <a href="<?php echo base_url().'admin/user/active/'.$id ?>">Active</a>
                                                <?php
                                                         } else {
                                                             echo "Yes"; 
                                                             $id=$row->id;
                                                             ?>
                                                <a href="<?php echo base_url().'admin/user/deactive/'.$id ?>">Deactive</a>
                                                <?php
                                                         }
                                                   ?>
                                            </td>
                                            <td><?php echo date('d/m/Y',$row->dt_created); ?></td>
                                            <td>
                                                <a href="<?php echo base_url().'admin/user/deleteuser/'.$id ?>">Delete</a>
                                            </td>
                                        </tr>
                          
                                      <?php $i++; }  }?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                 <?php echo "<h6>".$links."</h6>";?>
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