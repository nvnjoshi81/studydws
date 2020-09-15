<div id="page-wrapper" class="row">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add products</h1>
             <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
         ?>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
           <?php
       $this->load->view('add_module');
       ?>
</div>
  <div class="col-lg-12" id="contentdata" style="display: none;">
<p>If you not enter price for study Material packages will not display in bellow list.</p>
            <div class="panel">
            <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper table-responsive">
                        <table id="dataTables-example" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID.</th>
                                    <th>Sql Id</th> 
                                    <th>Name</th>           
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Chapter</th>
                                    <th>&nbsp;</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                    <!-- /.panel -->
            </div>
                <!-- /.col-lg-6 -->
        </div>
    </div>
</div>
