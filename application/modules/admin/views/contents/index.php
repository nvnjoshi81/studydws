<div id="page-wrapper" class="row">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add products</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <form name="pricelistform" id="pricelistform" action="<?php echo base_url('admin/contents/addPrice')?>" method="post">
        <div class="col-sm-12">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Select Content Type</label>
                    <?php echo generateSelectBox('content_type',$content_type,'id','name',1,'class="form-control" onChange="resetSelect();"');?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Select Exam</label>
                    <?php echo generateSelectBox('category',$exams,'id','name',1,'class="form-control" onchange="getContent();"');?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Select Subject</label>
                    <?php echo generateSelectBox('subject',$subjects,'id','name',1,'class="form-control" onchange="getContent();"');?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Select Chapter</label>
                    <?php echo generateSelectBox('chapter','','id','name',1,'class="form-control" onchange="getContent(1);"');?>
                </div>
            </div>
        </div>
        <div class="col-lg-12" id="pricedata" style="display: none;">
            <input type="text" name="price" value=""  id="price"/>
            <input type='hidden' name='faction' id='faction' value='0'/>
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
        </form>
        <div class="col-lg-12" id="contentdata" style="display: none;">
            <div class="panel">
            <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper table-responsive">
                        <table id="dataTables-example" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID.</th>
                                    <th>Name</th>                                    
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
