<!-- middle content-start -->
<div id="page-wrapper">
   <div class="row">
      <div class="col-lg-6 text-left">
         <h1 class="page-header">Video ID : <?php echo $video_id;?></h1>
         <?php 
         if($this->session->flashdata('message')){
             ?>
                 <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
         ?>
      </div>
       <div class="col-lg-6 text-right">
           <h1 class="page-header"><?php if(isset($_SERVER['HTTP_REFERER'])){ ?><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><< Back</a><?php  } ?></h1>
      </div>
      <!-- /.col-lg-12 -->
   </div>
   <!-- /.row -->
   <div class="row">
      <div class="panel panel-default">
          <form method="post" action="<?php echo base_url('admin/content/updatevideos_info/'.$video_id.'/'.$module_type_id.'/'.$module_id);?>" enctype="multipart/form-data" onsubmit="return edit_cont_validation();">
            <!--Video Section-->
 <div id="videos_section" >
     
     <input type="hidden"  name="video_upload_type"  id="video_upload_type" value="1">  

     <?php
     if(isset($video_id)){
        $cmsvideos_table_id = $video_id;
       $module_file_details_count = count($question);
        }else{
        $module_file_details_count =0; 
        $cmsvideos_table_id=0;
             
        } 
        if(isset($price_array->id)){
            $priceid =$price_array->id;
        }else{
           $priceid =''; 
        }
        
     ?>
    <input type="hidden" name="price_id"  value="<?php echo $priceid;  ?>" >
    <input type="hidden" name="id"  value="<?php echo $cmsvideos_table_id;  ?>" >
    <input type="hidden" name="module_id"  value="<?php echo $module_id;  ?>" >
    <input type="hidden" name="module_type_id"  value="<?php echo $module_type_id;  ?>" >
    <div>
        <label>Video Name</label>
        <input type="text" class="form-control" id="video_name" name="video_name" value="<?php
if (isset($question->title))
	{
	echo $question->title;
	} ?>" >
    </div>
	<!--
    <div class="form-group"> 
    <label>Price</label>
    <input class="form-control" type="text" name="video_price" value="<?php 
	//if(isset($price_array->price)){	echo  $price_array->price;  } ?>" 
	id="video_price"/>       
    </div>
    <div class="form-group"> 
    <label>Discounted Price</label>
    <input class="form-control" type="text" name="discounted_price" value="<?php 
	//if(isset($price_array->discounted_price)){ echo  $price_array->discounted_price;  } ?>"  id="discounted_video_price"/>       
    </div> 
          //Video Section
		  -->

    <div class="form-group">
        <label>Video Source</label>
        
        <?php
        if(isset($question->video_source)){
        $video_source = $question->video_source;
        }else{
        $video_source=0;
                
        }
        
         echo generateSelectBox('video_source',$array_video_source, 'id', 'name', 0, 'class="form-control"',$video_source);
        ?>

    </div>
    <div class="form-group">
    <label>Video URL code (youtube)</label>
      <?php
      if(isset($question->video_url_code)){
        $video_url_code = $question->video_url_code;
        }else{
        $video_url_code='';
                
        }
    ?>
    <input type="text" class="form-control" id="video_url_code" name="video_url_code" value="<?php echo $video_url_code;?>">
    </div>
    <div class="form-group">
    <label>Featured Video</label>
   <?php
   if(isset($question->is_featured)){
        $is_featured = $question->is_featured;
        }else{
        $is_featured=0;
                
        }
  
         echo generateSelectBox('is_featured',$array_is_featured, 'id', 'name', 0, 'class="form-control"',$is_featured);
   ?>
    </div>
    <div class="form-group">
    <label>Video description</label>

    <?php
      if(isset($question->description)){
        $description = $question->description;
        }else{
        $description='';
                
        }
		
    ?>
    
    <input type="text" class="form-control" id="description" name="description" value="<?php echo $description; ?>">
    </div>
    <div class="form-group">
    <label>Video By (User Id)</label>
<select name="video_by" class="form-control" required='required' >
    <option value="">Select Teacher Id</option>
       <?php
        if(isset($question->video_by)){
        $video_byid = $question->video_by;
        }else{
        $video_byid=0;
        }
        $videoby = (array)$array_video_by;
        foreach ($videoby as $key=>$videovalue) {
            //print_r($videovalue);
            $videovalue->id;            
            $videovalue->name;
            $videovalue->gender;
			
			if($video_byid ==$videovalue->id){
			$selection='selected="selected"';
			}else{
			$selection='';	
			}
            if($videovalue->gender == "Male") {
                 $prefix = "Sir";
            }           
            if($videovalue->gender == "Female") {
                $prefix = "Madam";
            }

            $disp_val = $videovalue->name." ".$prefix." - ".$videovalue->id;

            ?>
            <option value="<?php echo $videovalue->id; ?>" <?php echo $selection; ?> ><?php echo $disp_val; ?></option>
        <?php
    }
?>
    </select>
       <?php
	  
    ?>

    </div> 
    <div class="form-group">
    <label>Video Status</label>
      <?php
   if(isset($question->status)){
        $status = $question->status;
        }else{
        $status=0;                
        }
         echo generateSelectBox('status',$array_status, 'id', 'name', 0, 'class="form-control"',$status);
         ?>
    </div>
    <div class="form-group">
    <label>Video Tag</label>
       <?php
      if(isset($question->video_tag)){
        $video_tag = $question->video_tag;
        }else{
        $video_tag='';
                
        }
    ?>
    <input type="text" class="form-control" id="tags" name="video_tag" value="<?php echo $video_tag; ?>">
    </div>
    <div class="form-group">
    <label>Custom Video Duration</label>
       <?php
      if(isset($question->custom_video_duration)){
        $custom_video_duration = $question->custom_video_duration;
        }else{
        $custom_video_duration='';
                
        }
    ?>
    <input type="text" class="form-control" id="custom_video_duration" name="custom_video_duration" value="<?php echo $custom_video_duration; ?>">
    </div>
	<div class="form-group">
    <label>App Full Video name</label>
	<input class="form-control" name="androidapp_link" name="androidapp_link" value="<?php echo $question->androidapp_link; ?>" id="androidapp_linkid" type="text" >
    </div>
	
	
    <div class="form-group">
    <label>Video amazonaws Link</label>
       <?php
      if(isset($question->amazonaws_link)){
        $amazonaws_link = $question->amazonaws_link;
        }else{
        $amazonaws_link='';
                
        }
    ?>
    <input type="text" class="form-control" id="amazonaws_link" name="amazonaws_link" value="<?php echo $amazonaws_link; ?>">
    </div>   
    <div class="form-group">
    <label>Amazon Cloudfront Domain</label>
       <?php
      if(isset($question->amazon_cloudfront_domain)){
        $amazon_cloudfront_domain = $question->amazon_cloudfront_domain;
        }else{
        $amazon_cloudfront_domain='';
                
        }
    ?>
    <input type="text" class="form-control" id="amazon_cloudfront_domain" name="amazon_cloudfront_domain" value="<?php echo $amazon_cloudfront_domain; ?>">
    </div>
    <div  class="form-group">
           <label class="url">Video File Name </label>
      <?php
      if(isset($question->video_file_name)){
        $common_file_name = $question->video_file_name;
        }else{
        $common_file_name='';
        }
    ?>
           <input type="text"  class="form-control" name="common_file_name" value="<?php  echo $common_file_name; ?>"  id="common_file_name"/>    
            <label class="url">OR</label>               
    </div>
    <div class="form-group">
        <label class="url">Upload Video</label>
        <input type="file" name="video_file" value=""  id="video_file"/>
        
         <?php 
        if($common_file_name!=''){ ?>
        <input type="hidden" name="video_file_in_db" value="<?php echo $common_file_name; ?>" />
         <label class="url"><?php echo $common_file_name; ?></label>
        <?php  } ?>
        </div>
      
    <?php
      if(isset($question->video_image )){
        $video_image = $question->video_image ;
        }else{
        $video_image='';
        }
    
    ?>
        <div class="form-group">
        <label class="url">Upload Video Image</label>
        <input type="file" name="video_image" value=""  id="video_image"/>
        <?php 
        if($video_image!=''){ ?>
         <input type="hidden" name="video_image_in_db" value="<?php echo $video_image; ?>" />
         <label class="url"><img src="<?php echo show_thumb($video_image,250,250);?>" width="25%" height="25%" ></label>
        <?php  } ?>
        </div>     
 </div> 
            
 <button type="submit" class="btn btn-primary">Submit</button>
          </form>
         
      </div>
      
</div>
</div>
<script type="text/javascript">
function edit_cont_validation(){
var alert_message ='';
var error_exist='no';
  var video_name_dd =$('#video_name').val();
	var androidapp_linkid_dd =$('#androidapp_linkid').val();
	

if(video_name_dd==''){
    error_exist='yes';
    alert_message +='Please Enter Video Name.\n';    
}

if (!(/^\S{3,}$/.test(androidapp_linkid_dd))) {
	error_exist='yes';
    alert_message +='Space not allowed in App Full Video name!\n';  
}


if(error_exist=='yes'){    
if(alert_message!=''){
alert(alert_message);
}
return false;
}
}

  tinymce.init({
    selector: 'textarea',
    inline: false,
    height: 500,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools '
  ],
  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  filemanager_title:"Responsive Filemanager",
    external_filemanager_path:"/filemanager/",
    external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
  content_css: [
    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
    '//www.tinymce.com/css/codepen.min.css'
  ],
  automatic_uploads: true,
  relative_urls: false
  });
  </script>
<script>
    CKEDITOR.replace( 'question');
    CKEDITOR.replace( 'description');
</script>
<!-- /.panel .chat-panel -->
<!---middle-content---End-->