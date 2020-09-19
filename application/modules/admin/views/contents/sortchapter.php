<script> 
function add_cont_validation(){
var content_type_dd =$('#content_type').val();
var content_type_name_dd =$('#content_type_name').val();
var questions_type_dd =$('#questions_type').val();
var exam_type_dd =$('#exam_type').val(); 
var exam_formula_id_dd = $('#exam_formula_id').val();
var exam_time_dd = $('#exam_time').val();
var alert_message ='';
var error_exist='no';
if(content_type_dd<1){
    error_exist='yes';
    alert_message +='Please select Content type.\n';
}

/*
if(questions_type_dd<1){
    error_exist='yes';
    alert_message +='Please select Question type.\n';
}
*/

if(content_type_name_dd=='Videos'){
    
    var video_name_dd =$('#video_name').val();
    var existing_playlist_id_dd=$('existing_playlist_id').val();
    var new_playlist_name_dd=$('new_playlist_name').val();

if((existing_playlist_id_dd=='')&&(new_playlist_name_dd=='')){
    error_exist='yes';
    alert_message +='Please Enter Playlist Name.\n';    
}
}

if(content_type_name_dd=='Online Tests'){
if(exam_type_dd==''){
    error_exist='yes';
    alert_message +='Please Enter Exam Type.\n';
    
}

if(exam_formula_id_dd<1){
    error_exist='yes';
    alert_message +='Please select Farmula Type.\n';
    
}

if(exam_time_dd<1){
    error_exist='yes';
    alert_message +='Please Enter Exam time.\n';
}
}
if(error_exist=='yes'){
    
if(alert_message!=''){
    
alert(alert_message);
    
}
return false;
}
}
    $(function() {
    $("[name=upload_type]").change(function(){
            $('.toHide').hide();
            $("#blk-"+$(this).val()).show('slow');
    });
 });
function add_relation_validation(){
var content_type_dd =$('#relation_content_type').val();
var exam_type_dd =$('#relation_exam').val(); 
if((content_type_dd>0)&&(exam_type_dd>0)){
return true;
}else{
alert('Please Enter Content type and Exam type.');
return false;
}
}
    $(function() {
    $("[name=upload_type]").change(function(){
            $('.toHide').hide();
            $("#blk-"+$(this).val()).show('slow');
    });
 });
 
</script> 
           <?php 
           
           $studypdf_path=$this->config->item('studypdf_path');
           $pdf_file_path=$_SERVER['DOCUMENT_ROOT'].$studypdf_path;
           
           ?>
<!--form add new categories-->
<?php

    $submit_button_text ='Submit';
    $form_url='admin/contents/sortchapter_submit';
?>
<form  enctype="multipart/form-data" id="add_category_form" method="post" 
       action="<?php echo base_url().$form_url; ?>" onsubmit="return add_cont_validation();" >
           <div class="col-lg-12 clr-bth">
		   
		  
     <?php
if (isset($maincontent->id))
	{
	if ($maincontent->id != NULL)
		{ ?>      
    <h2>Edit Contents</h2>
     <?php
		}
	}
  else
	{ ?>
    <h2>New Contents</h2>
     <?php
	}
?>  
<label>Sort Id-</label> <input type="text" name="chapter_sortid" id="chapter_sortid"  value="0" > 
</div>
         <div class="col-sm-12">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Select Content Type</label>
        <?php
        $maincontent_id=0;
        if (isset($maincontent->id))
        {
           $maincontent_id=$maincontent->id;         
        }
    $content_type_id=0;                 
    $price_table_id=0;                 
if (isset($pricelist_details->id))
        {
    $price_table_id=$pricelist_details->id;
        }
 
        if (isset($content_type->id))
        {

    $content_type_id=$content_type->id; 
            
echo generateSelectBox('content_type_disabled', $content_type_array, 'id', 'name', 1, 'class="form-control" disabled=disabled ',$content_type_id);  ?> 
    <input type="hidden" name="content_type" id="content_type"  value="<?php echo $content_type_id;  ?>" ><?php
       
	   }else{
   
echo generateSelectBox('content_type', $content_type_array, 'id', 'name', 1, 'class="form-control" onChange="resetSelect();showOptions($(this).find(\'option:selected\').text());"',$content_type_id); 
        }
?>
         <input type="hidden" name="module_id"  value="<?php echo $maincontent_id;  ?>" >
                    <input type="hidden" name="module_type_id"  value="<?php echo $content_type_id;  ?>" >
                    <input type="hidden" name="price_table_id"  value="<?php echo $price_table_id;  ?>" >
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                  
<?php               
    $content_type_exam_id=0;                 
if (isset($maincontent->exam_id))
        {
    $content_type_exam_id=$maincontent->exam_id;        
//echo generateSelectBox('category_disabled', $exams, 'id', 'name', 1 , 'class="form-control" disabled=disabled ',$content_type_exam_id); 
    ?> <input type="hidden" name="category"  id="category"  value="<?php echo $content_type_exam_id;  ?>" ><?php
    
        }else{
            ?>  <label>Select Exam</label><?php
        
echo generateSelectBox('category', $exams, 'id', 'name', 1 , 'class="form-control" onchange="getContent();"',$content_type_exam_id); 
        }
?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                   <?php
     $content_type_subject=0;                 
if (isset($maincontent->subject_id))
        {
    $content_type_subject=$maincontent->subject_id;
    //echo generateSelectBox('subject_disabled', $subjects, 'id', 'name', 1 , 'class="form-control" disabled=disabled', $content_type_subject);
     ?>       
    <input type="hidden" name="subject"   id="subject"  value="<?php echo $content_type_subject;  ?>" ><?php
        }else{
            ?> <label>Select Subject</label><?php
echo generateSelectBox('subject', $subjects, 'id', 'name', 1 , 'class="form-control" onchange="getContent();"', $content_type_subject);
        }
        ?>
        </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                  
                    <?php
$content_type_chapter_id=0;                 
if (isset($maincontent->chapter_id))
        {
    $content_type_chapter_id=$maincontent->chapter_id;
   // echo generateSelectBox('chapter_disabled', $chapters_arr, 'id', 'name', 1 , ' class="form-control" disabled=disabled',$content_type_chapter_id); 
     ?> <input type="hidden" name="chapter"  value="<?php echo $content_type_chapter_id;  ?>" ><?php
        }else{
        ?>  <label>Select Chapter</label><?php
echo generateSelectBox('chapter', $chapters_arr, 'id', 'name', 1 , ' class="form-control" onchange="getContent(1);"',$content_type_chapter_id); 
    }
        ?>
                    
    <?php if(isset($content_type_exam_id)){ ?>
    <input type="hidden" name="category_in_db"  value="<?php echo $content_type_exam_id; ?>" > 
    <?php  }  
    if(isset($content_type_subject)){  ?>
    <input type="hidden" name="subject_in_db"  value="<?php echo $content_type_subject; ?>" > 
     <?php }  
     if(isset($content_type_chapter_id)){  ?>
    <input type="hidden" name="chapter_in_db"  value="<?php echo $content_type_chapter_id; ?>" >
     <?php
          }
     ?>



                </div>
            </div>
			<br>
			<div><!--
			<?php //foreach($chapters_arr as $cName=>$cValue){}  ?>

    <input type="checkbox" name="check_list[]" value="value 1">-->
						</div>
			
			<input type="submit" value="<?php echo $submit_button_text; ?>">
			</form>
        </div> 