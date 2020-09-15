<div id="page-wrapper">
     <div class="row">
        <div class="col-lg-12">
                <h1 class="page-header">Total Email (<?php echo $totalEmail; ?>)</h1>
        </div>
         <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
         ?> 
             
            <div class="col-lg-12">
                   <form id="send_bulk_email" name="send_bulk_email" method="post" action="<?php
                   echo base_url(); ?>admin/email_promotion/sendMail" > 
                   <button type="submit" class="btn btn-primary">Submit</button>
                   </form>
            </div>
         
     </div>
 </div>