 <style>
        .ifrmepanel{
			max-width:1400px !important;
			width:100% !important;
			height:800px !important;
			margin:0 auto !important;
		}
</style>
<div id="wrapper">
    <div class="container">
            <div class="row">
                <?php $this->load->view('common/breadcrumb');  ?>
                  <div class="clearfix"></div>
                  <div class="vediobody container">
                 <?php
                 
 if($isProduct){
     $this->load->view('common/shortproductdetails');
 }                

                 ?>
                  <div class="well_flip">
                    <div class="lftgalpenal col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
					<input type="hidden" <?php  echo "The file study $file->filename does not exist on server."; ?> >
                      <?php 
                     
                 /*  
                  * 
                  * 
                  * 
                  * 
                  *  $imagePath='/home/studywhm/public_html/upload/pdfs/'.$file->filename.'.pdf';
                      $imagick = new \Imagick(realpath($imagePath));
    $imagick->setbackgroundcolor('rgb(64, 64, 64)');
    $imagick->thumbnailImage(100, 100, true, true);
    header("Content-Type: image/jpg");
    echo $imagick->getImageBlob();
    
                  *    $im = new imagick('/home/studywhm/public_html/upload/pdfs/'.$file->filename.'.pdf[0]');
$im->setImageFormat('jpg');
header('Content-Type: image/jpeg');
echo $im;
               */       /*
                 if(isset($file->filename)){
                 $filename = 'upload/webreader/'.$file->filename.'/index.html';

if (file_exists($filename)) {
      ?>
                         <!--<iframe src="<?php echo base_url('upload/webreader/'.$file->filename)?>" class="ifrmepanel"> </iframe>-->
      <?php
} else {
    ?>
    <div class="well_flip">
        <input type="hidden"  <?php    
    echo "The file study$file->filename does not exist on server.";    
    ?>>
    </div>
        <?php    
}
}else{
                     
    echo "Information Not Found!";
                     
} */
                 ?>       
                   
                    
</div>
  </div>
                   
</div> </div>
                
                  <!-- video gallery -->
    <div class="row vedio_bot_gal">
    <div class="col-sm-12 col-md-9">
    <!--<div class="row vid_list">
     
     <div class="col-xs-12 col-sm-6 col-md-4">
     <div class="well_vid"> 
     <img src="<?php echo base_url('assets/frontend/images/ved1.jpg')?>" class="img-responsive" />
      </div>
     </div> 
     
     
     <div class="col-xs-12 col-sm-6 col-md-4">
     <div class="well_vid"> 
      <img src="<?php echo base_url('assets/frontend/images/ved1.jpg')?>" class="img-responsive" />
      </div>
     </div> 
     
     <div class="col-xs-12 col-sm-6 col-md-4">
     <div class="well_vid"> 
      <img src="<?php echo base_url('assets/frontend/images/ved1.jpg')?>" class="img-responsive" />
      </div>
     </div> 
     
     <div class="col-xs-12 col-sm-6 col-md-4">
     <div class="well_vid"> 
      <img src="<?php echo base_url('assets/frontend/images/ved1.jpg')?>" class="img-responsive" />
      </div>
     </div> 
    
    
    
    </div>-->
    </div> 
    
    <!--  right panel 
    <div class="col-sm-12 col-md-3">
		<div class="col-sm-12 col-md-3 rht260adv">
        <img src="<?php echo base_url('assets/images/260adv.jpg')?>" />
      </div>    </div>-->
    
    </div>
                
    </div>
    
  
    </div>
</div>

