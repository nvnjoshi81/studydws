<div id="page-wrapper" class="row">   
    
    <?php
            if ($this->session->flashdata('message')) {
                ?>
                <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?>
                </div>

                <?php
            }
            ?>
   
            <!-- /.row -->
			<?php 
			 //if(isset($cron)&&$cron=='yes'){ 
			 ?> <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add Free video</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
    <div class="row col-sm-6 col-lg-6 col-md-6">
        <form name="fvideoform" id="fvideoform" action="<?php echo base_url('admin/freevid/addfreevideo')?>" method="post" enctype="multipart/form-data">
        <div class="col-sm-6">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Enter Playlist Id (Comma Separated)</label>                   
  <textarea rows="4" cols="50" name="fvideo" id="fvideo"><?php echo $video_id; ?></textarea>
                
                </div>
            </div>
                   
            <div class="col-sm-12 pull-right">
                <div class="form-group">    
                <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>
        </div>       
        </form>
    </div>
	<?php //} if(isset($cron)&&$cron=='yes'){
		?> <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Cron Update</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
	 <div class="row col-sm-6 col-lg-6 col-md-6">
	 
	 <p>PLEASE DO NOT RUN BOTH CRON FILE SIMULTANEOUSLY </p>
	 <ul class="list-group">
  <li class="list-group-item"> <a target="_blank" class="btn btn-primary" href="https://www.studyadda.com/exams/welcome/cron_update_packagecnt_byexamid" role="button">Package Count</a> Exam Wise Package Count</li>
   <!-- <li class="list-group-item"> <a target="_blank" class="btn btn-primary" href="https://www.studyadda.com/exams/welcome/cron_update_packagecount" role="button">All Package Count</a></li>
<li class="list-group-item"> <a target="_blank" class="btn btn-primary" href="https://www.studyadda.com/exams/welcome/cron_update_packagecnt_bysubjectid" role="button">Subject Package Count</a></li>-->
</ul>
	 
	 <ul class="list-group">
  <li class="list-group-item"><a target="_blank" class="btn btn-success" href="https://www.studyadda.com/videos/welcome/updateVideoAttr" role="button">Video Size</a> For video size and duration</li>
  
   <li class="list-group-item"><a target="_blank" class="btn btn-danger" href="https://www.studyadda.com/exams/welcome/cron_update_orderstatus" role="button">Order Update</a> For Paytm payment check.If transection id blank cancel the order</li>
</ul>
 
	 </div>
	 <?php //}  
	 ?>
        
    </div>
