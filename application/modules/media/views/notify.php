
<!-- notify ALTER TABLE `<table_name>` CHANGE `<field_name>` `<field_name>` VARCHAR(100) 
CHARSET utf8 COLLATE utf8_general_ci DEFAULT '' NOT NULL; -->
<div id="wrapper">
    <div class="container">
        <div class="row">
    <?php //$this->load->view('common/breadcrumb');?>
 
    <div class="container">
    <div class="row">
        <p><h3>Notification</h3></p>
    </div>
	  <div class="col-md-12 home_ban">
  <div class="carousel-inner">  
    	
		<?php if($detail_id>0){ 
		$des_cnt=strlen($noti_list->description);
		?>
  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">	
  <div class="panel panel-default">
  <div class="panel-heading"><b><?php echo $noti_list->title; ?></b><b style="float:right;"><?php  
  if(isset($noti_list->date)&&$noti_list->date!=''){
	  echo $noti_list->date;
  }else{
	  echo  date("F j, Y");;
  }	  ?></b></div>
  <div class="panel-body">
  <?php 
    echo $noti_list->description;	
	?>
  </div>
</div>
                   </div>
					<?php
				}else{
        $cnt=0; 
       foreach($noti_list as $media){ 
                if($media->title!=''){
		$des_cnt=strlen($media->description);
                 ?>
       <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">				   
				   <div class="panel panel-default">
				    <div class="panel-heading">
                 <h4 class="panel-title">
                    <a href="<?php echo base_url('media/notify/0/0/'.$media->id);?>" class="ing"><b><?php echo $media->title; ?></b><b style="float:right;"><?php  
  if(isset($media->date)&&$media->date!=''){
	  echo $media->date;
  }else{
	  echo  date("F j, Y");;
  }	  ?></b></a>
              </h4></div>
 <div class="panel-body"><?php 
if($des_cnt>50){
echo substr($media->description,0,-50);  
echo ".....";
}else{
echo $media->description;	
} ?></div>
            </div>
        </div>
			<?php	 
				
$cnt++;
       }
       
       } }
       ?>
 </div>
 </div>
</div>
       