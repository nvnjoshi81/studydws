<div id="wrapper">
    <div class="container">
        <div class="row">
          <?php $this->load->view('common/breadcrumb');?>
 
    <div class="container">
    <div class="row">
        <p><h3>Copyrights of images and content for theguardian.</h3></p>
    </div>
<?php 
 putenv('PATH=' . getenv('PATH') . ':/usr/bin/gs');
$pathtoimage=dirname($_SERVER['SCRIPT_FILENAME']).'/assets/frontend/product_images/life_processes.pdf';
//$pathtoimage='https://studyadda.com/assets/frontend/product_images/life_processes.pdf';
//'https://studyadda.com/assets/frontend/product_images/life_processes.pdf';
//$_SERVER['DOCUMENT_ROOT'].
//echo $pathtoimage;
$im = new Imagick();
$im->setResolution(300, 300);     //set the resolution of the resulting jpg
$im->readImage($pathtoimage.'[0]');    //[0] for the first page
$im->setImageFormat('jpg');
header('Content-Type: image/jpeg');
echo $im;
?>
</div>

</div>
</div>
</div>
<style>
    .jasgrid{padding:0;}
.box-item {
    float: left;
    opacity: 1;
    overflow: hidden;
    position: relative;
}

.box-item img {
    width: 100%;
}
.box-item a,span{color:#FFF;}

.box-item .box-post span.meta {
    font-family:  sans-serif;
    font-size: 12px;
    color: #fff;
    margin-top: 15px;
    display: block;
}

.box-item .box-post span.meta span {
    margin-right: 15px;
}

.box-item .box-post {
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0) 100%);
    padding: 30px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.box-item .box-post h1.post-title {
   font-size:10pt;
}
    
</style>