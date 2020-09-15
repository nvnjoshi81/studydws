<div id="page-wrapper" class="row">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Chapter Sorting</h1>
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
       $this->load->view('sortchapter');
       ?>
</div>
</div>
