<?php echo validation_errors(''); ?>
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
     <div class="col-sm-12">
         <div class="col-sm-3">
                <div class="form-group">
        <label>Select Exam</label>   
        <?php
            echo generateSelectBox('content_type', $content_type_array, 'id', 'name', 1, 'class="form-control"',$content_type_id); 
        ?> </div>
                </div>
          
        <div class="col-sm-3">
                <div class="form-group">
        <label>Select Exam</label>   
        <?php
           echo generateSelectBox('category', $exams_array, 'id', 'name', 1 , 'class="form-control" onchange="mergeSection();"',$content_type_exam_id); 
        ?> </div>
                </div><div class="col-sm-3">
                <div class="form-group"><label>Select Subject</label><?php   
           echo generateSelectBox('subject', $subjects_array, 'id', 'name', 1 , 'class="form-control" onchange="mergeSection();"', $content_type_subject);
       ?> </div>
                </div><div class="col-sm-3">
                <div class="form-group"><label>Select Chapter</label><?php
           echo generateSelectBox('chapter', $chapters_array, 'id', 'name', 1 , ' class="form-control" onchange="mergeSection(1);"',$content_type_chapter_id);
       ?> </div>
                </div>
</div>
  <div class="col-lg-12" id="contentdata" style="display: none;">
            <div class="panel">
            <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper table-responsive">
                        <form name="mergeForm" id="mergeForm" action="<?php echo base_url(); ?>admin/mergesection/save_merge" method="POST">
                        <table id="dataTables-example" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID.</th>                                                                     
                                    <th>Action</th>
                                </tr>
                            </thead>
                           
                            <tbody>
                            </tbody>
                        </table>
                        </form>  
                    </div>
                </div>
                    <!-- /.panel -->
            </div>
                <!-- /.col-lg-6 -->
        </div>
    <!--Display Last level Information-->
    <div class="col-lg-12" id="contentdata-last" style="display: none;">
            <div class="panel">
            <!-- /.panel-heading -->
                <div class="panel-body-last">
                    <div class="dataTable_wrapper table-responsive">
                      
                        <table id="dataTables-example-last" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID.</th>
                                    <th>Question</th> 
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
