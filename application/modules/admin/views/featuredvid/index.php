<div id="page-wrapper" class="row">   
    
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
            <h1 class="page-header">Add Featured video</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <form name="fvideoform" id="fvideoform" action="<?php echo base_url('admin/featuredvid/addfvideo')?>" method="post" enctype="multipart/form-data">
        <div class="col-sm-12">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Enter video Id (Comma Separated)</label>                   
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
        
    </div>
