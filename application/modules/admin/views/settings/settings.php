 <?php ?>
  <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Settings</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
<form class="set-form" action="<?php echo base_url(); ?>admin/do_upload" method="post" enctype="multipart/form-data">
    <div class="form-group">
    <?php
       //echo $settings_detail->site_name;
        foreach ($settings_detail as $key=>$value)
             {
   //print_r($value);
            } ?>
        <label>Site Name</label>
        <input type="text" class="form-control" name="site_name" 
         value="<?php  if(isset($settings_detail->site_name))
         { echo $settings_detail->site_name; } ?>">
    </div>
    <div class="form-group">
        <label>Site URL</label>
        <input type="text" class="form-control" name="site_url"
        value="<?php if(isset($settings_detail->site_url)){ echo $settings_detail->site_url;} ?>">
    </div>
    <div class="form-group">
        <label>Site Logo</label>
        <div class="upload-logo-div">
        
       <!--- <img src="<?php echo base_url();?>assets/images/logo.jpg" width="150" height="auto" class="upload-logo"/>-->
        <?php if(isset($settings_detail->site_logo)) {?>

      <img src="<?php echo base_url(); ?>/assets/images/<?php  if(isset($settings_detail->site_logo))
         {echo $settings_detail->site_logo; }?>" alt="LOGO IMAGE" width="100" height="42">
               <?php }else{?>
    <img src="<?php echo base_url();?>assets/images/logo.jpg" width="150" height="auto" class="upload-logo"/>
        <?php }?>
        <a href="#" class="btn btn-success">Change</a>
        </div>
         <div class="upload-logo-field">
        <input type="file" class="form-control">


        <span class="input-group-btn">
                    <button type="button" class="btn btn-default">Upload</button>
                </span>
        </div>
        <input type="file" name="site_logo" value="">
    </div>
    <div class="form-group">
        <label>Site Description</label>
        <textarea rows="5" class="form-control" name="site_description">
        <?php  if(isset($settings_detail->site_description))
         {echo $settings_detail->site_description ; }?></textarea>
    </div>
    <input type="hidden" name="" value="<?php if(isset($settings_detail->id)){ 
    echo $settings_detail->id ; } ?>"/>
    <button type="submit" class="btn btn-primary" name="submit">Save Settings</button>
</form>
                </div>

                <!-- /.col-lg-12 -->
            </div>
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
        
