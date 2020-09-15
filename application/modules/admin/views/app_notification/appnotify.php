<div id="page-wrapper">
    <div class="row">
                <div class="col-lg-12">
                    <h1 >Notification Contents<span class="pull-right"></span></h1>
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
                                        <tr>
                                        </tr>
                                    </thead>
                              
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