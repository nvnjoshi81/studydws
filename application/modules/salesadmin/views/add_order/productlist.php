<!-- middle content-start -->
<div class="content">
     <?php if($this->session->flashdata('update_msg')){ ?>
	<div class="alert alert-success alert-dismissible" id="success-alert" role="alert">
			<strong><?php echo $this->session->flashdata('update_msg'); ?></strong>
    </div>
	<?php } ?>
        <div class="container-fluid">
          <div class="row">
		  <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Order</h4>
                  <p class="card-category">Customers Order with all status</p>
                </div>
                <div class="card-body">
				
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    
                    <div class="panel">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
              <div class="col-md-12">
                <?php $this->load->view('common/frproductlist'); ?>
            </div>
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
    </div>
    </div>
    </div>
    </div>
    </div>