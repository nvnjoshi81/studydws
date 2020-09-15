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
if (isset($maincontent->id))
	{
    $form_url='admin/contents/edit_submit';
    $submit_button_text ='Add';
        }else{
    $submit_button_text ='Submit';
    $form_url='admin/contents/add_submit';
        }
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
        </div> <?php
        
       // print_r($module_file_details[0]);
                $flex_file_name='';
                $pdf_file_name='';
                $single_qus_display='display:none';
                $multiple_qus_display='';
                $single_question_upload_type='';
                $multiple_question_upload_type='checked'; 
                $common_file_name='';
                $others_display='style="display:block"';
                  if(isset($content_type->name)&&($content_type->name=='Videos')){
                  $single_question_upload_type='checked';
                  $multiple_question_upload_type='';
                  $single_qus_display='display:none';
                  $multiple_qus_display='display:none';
                  if(isset($module_file_details[0]->video_file_name)){
                  $common_file_name=$module_file_details[0]->video_file_name;
                  }$others_display='style="display:none"';
                  $for_video_section_display='style="display:block"';
                }else{
                    $for_video_section_display='style="display:none"';
                if(isset($module_file_details[0]->file_id)&&($module_file_details[0]->file_id>0&&(isset($module_file_details[0]->question_id)&&$module_file_details[0]->question_id==0))){
                $single_question_upload_type='checked';
                $multiple_question_upload_type='';
                $single_qus_display='';
                $multiple_qus_display='display:none';   
                $flex_file_name=$module_file_details[0]->filename;
                $pdf_file_name=$module_file_details[0]->filename_one;                 
                }
                if(isset($module_file_details[0]->filename)){
                $common_file_name=$module_file_details[0]->filename;
                }
		        $display_file_name=$module_file_details[0]->displayname;
                }
				
               ?>
<div class="col-sm-6 well">
           <?php
        if($content_type_id>0){
            $newdata='no';
        }else{
            $newdata='yes';
        }
        if($newdata=='yes'){
        ?>
        <label id='studypackage_feed_lable'  ><font color="red">Check this box to Create Study Packages with this Module</font>&nbsp;&nbsp;<input type="checkbox"  name="studypackage_feed"  id="studypackage_feed" value="1" ></label><br>Create Study Packages with<font color="red"> Question Bank,Solved Paper and Note/Article </font>only
        <?php } ?>
    <!--Other Section-->
    <div id="Others" <?php echo $others_display; ?> >
    <div class="form-group">
    <label>Upload Type</label><span class="new-list-spn" id="u_type_single"><input type="radio" name="upload_type"  id="upload_type_single"  value="1" <?php echo $single_question_upload_type;  ?> ><span>Single Question Upload</span></span>
        <span class="new-list-spn" id="u_type_multi">
            <input type="radio" name="upload_type" value="2" <?php echo $multiple_question_upload_type;  ?> id="upload_type_multiple" ><span>Multiple Question Upload</span></span>
    </div>
  <div class="form-group"> 
  <label>Contents Name   
            <?php if($newdata=='no'){ ?>
            <a href="/admin/contents/getContentsFileInfo/<?php echo $maincontent_id; ?>/<?php echo $content_type_id; ?>" data-target="#myModal_edit_contentsname" data-show="true" data-toggle="modal">Edit Name</a>
            <?php } ?>
        </label>
        <input type="text" class="form-control" id="name" name="name" value="<?php
if (isset($maincontent->name))
	{
	echo $maincontent->name;
	} ?>">
    </div>
        <div class="form-group"> 
      <label>Price (* Required for Study Packages)</label>
        <input class="form-control" type="text" name="price" value="<?php if(isset($pricelist_details->price)){ echo  $pricelist_details->price;  } ?>"  id="price"/> 
    </div>
    <div class="form-group"> 
    <label>Discounted Price</label>
    <input class="form-control" type="text" name="discounted_price_others" value="<?php if(isset($pricelist_details->discounted_price)){ echo  $pricelist_details->discounted_price;  } ?>"  id="discounted_price_others"/>       
    </div>
        <div class="form-group"> <label>Product Expiry Date</label>
                                <div class='input-group date' id='productLimitDate'>
                                    <input type='text' class="form-control" id="product_expiry_date"  name="product_expiry_date" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
        <?php
        $contents_name='';
        if($content_type_id>0){
        $contents_name=$content_type->name;
        $single_qus_display='display:none';  
        if($content_type->name=='Online Tests'){
        $single_qus_display='display:block'; 
		$display_file_name=$module_file_details[0]->displayname;
		}
        }else{
        //$single_qus_display='display:block'; 
        }
        ?>
    <input type="hidden" name="faction" value="0"  id="faction" />
    <div class="toHide"  style="<?php echo $single_qus_display; ?>" id="blk-1">
    <div  class="form-group">
           <label class="url">Display File Name </label>
           <input type="text"  class="form-control" name="display_file_name" value="<?php echo $display_file_name; ?>"  id="display_file_name"/>    
    </div> 
        <div  class="form-group">
        <label class="url">Common File Name </label>
        <input type="text"  class="form-control" name="common_file_name" value="<?php  echo $common_file_name; ?>"  id="common_file_name"/> 
        <?php   $pdf_file_path=str_replace('/', '-', $pdf_file_path); ?>
           <div>
               <span id="fileResultarea"></span><br>
               <button onclick="chekFileAvail('<?php echo $pdf_file_path; ?>','pdf')" type="button" class="btn btn-primary">Check PDF File</button>
               <?php 
               
               $pdf_file_path_replace = str_replace('-', '/', $pdf_file_path);
               $file_name_ext=$common_file_name.'.pdf';
               //echo $pdf_file_path_replace.$file_name_ext; 
               ?>
               <br>
        <?php if(isset($file_name_ext)&&$file_name_ext!=''){ 
        echo  $file_name_ext.' [';
        if (is_readable($pdf_file_path_replace.$file_name_ext)) {
        echo "<a href='".$pdf_file_path_replace.$file_name_ext."' target='_blank'>Open now</a> ";  
        }else{ 
            echo " File not available on server. ";
        }
        echo ']';
        } ?>
               
        </div>
    </div>
        <?php if($contents_name!='Online Tests'){ ?><label class="url">OR</label>  
        <div  id="single_q">
                <!--Comman PDf upload Area-->
  <div class="form-group">
      <label class="url">For Studypackages and Onlinetest</label>
        <label class="url">PDF (qus,ans and solution)</label>
        <input type="file" name="pdf_file" value=""  id="pdf_file"/>
        <?php if(isset($pdf_file_name)&&$pdf_file_name!=''){ 
        ?>
        <label class="url"><?php  echo $pdf_file_name; ?></label>
        <?php 
        echo  '['; 
        if (is_readable($pdf_file_path.$pdf_file_name)) {
        echo "<a href='".base_url().'upload/pdfs/'.$pdf_file_name."' target='_blank'>Open Now</a>";
        }else{ 
        echo " File not available on server. ";
        }
        echo ']';
        } 
        ?>
    </div>
<!-- Comman pdf upload area -->
    <div  class="form-group">
           <label class="url">Flex Zip</label>
           <input type="file" name="zip_file" value=""  id="zip_file"/>    
            <label class="url"><?php  echo $flex_file_name; ?></label>               
    </div>
        </div>
            <?php } ?>
 </div>

<div class="toHide"  style="<?php echo $multiple_qus_display; ?>" id="blk-2">
 <?php
 if(isset($content_type->name)&&($content_type->name=='Online Tests')){
    $style_display = 'style="display:block"';
 }else{
    $style_display = 'style="display:none"';
    
    $single_qus_display='display:none';
    ?>                
    <div class="form-group" id="qtype" style="display:block" >
        <label>Select Question Type</label>
        <?php
        
        if (isset($type_of_question))
        {
    $type_of_question=$type_of_question;
        }else{
    $type_of_question='';
        }
    echo generateSelectBox('questions_type', $questions_type, 'id', 'name', 1, 'class="form-control"',$type_of_question); ?>
    </div>
    <div>
         <label>Page Number</label>
        <input type="text" class="form-control" id="page_number" name="page_number" value="<?php
if (isset($items[0]->filter))
	{
	echo $items[0]->filter;
	} ?>" >
    </div>
    <div>
        <?php
        ?>
         <label>Years(For Solved Papers Only)</label>
        <input type="text" class="form-control" id="years" name="years" value="<?php
if (isset($maincontent->years))
	{
	echo $maincontent->years;
	} ?>" >
    </div>
        <?php
 }
 ?>
      <!--Online Exam Section-->
      <div id="ol_exam" <?php echo $style_display; ?> ><div><font color="red">Use above field for online test solution pdf downoad.</font></div>
             <div class="form-group">  <label>Online Exam Formula</label>
           <input type="hidden" name="content_type_name"   id="content_type_name"  value="<?php if(isset($content_type->name)){ echo $content_type->name; }  ?>" >          
    <?php
        if (isset($formula_id_for_exam))
        {
    $formula_id_for_exam=$formula_id_for_exam;
        }else{
    $formula_id_for_exam='0';
            
        } 
        
    echo generateSelectBox('exam_formula_id', $examformula_array, 'online_exam_formula_id', 'online_exam_formula_name', 1, 'class="form-control"',$formula_id_for_exam); ?>

     </div>
           <div class="form-group"><label>Online Exam Category</label>
                        <?php 
                        if (isset($category_id_for_exam))
        {
    $category_id_for_exam=$category_id_for_exam;
        }else{
    $category_id_for_exam='0';
            
        } 
                        
    echo generateSelectBox('olcategory_id', $olcategory_array, 'id', 'name', 1, 'class="form-control"',$category_id_for_exam);
                        ?>
                    </div>
          
    <div class="form-group">  <label>Calculator</label>
    <?php
        if (isset($show_calculater)&&$show_calculater=='no')
        {
         $formula_id_no="selected=selected";
      $formula_id_yes="";
      
        }else{
          
            $formula_id_no="";
    $formula_id_yes="selected=selected";
        
        } 
        ?>    
         <select class="form-control" id="exam_calculator" name="exam_calculator">
             <option <?php echo $formula_id_yes; ?> value="yes">Yes</option>
             <option <?php echo $formula_id_no; ?> value="no">No</option>
         </select> 
    </div>
    <div class="form-group">   
        <label>Online Exam Time(In Seconds)</label>
        <input type="text" class="form-control" id="exam_time" name="exam_time" value="<?php
if (isset($maincontent->time))
	{
	echo $maincontent->time;
	} ?>">
    </div>
	
	<?php  if(isset($content_type->name)&&($content_type->name=='Online Tests')){ ?>
      <div class="form-group">  
	  <?php
	  if(isset($maincontent->dt_start)&&$maincontent->dt_start>0){ $dt_start_normal = $maincontent->dt_start; $dt_start=date('YYYY-MM-DD', $dt_start_normal); }else{ $dt_start =''; }

	  if(isset($maincontent->dt_end)&&$maincontent->dt_end>0){ $dt_end_normal = $maincontent->dt_end; $dt_end=date('YYYY-MM-DD', $dt_end_normal); }else{ $dt_end =''; }	 
	  
	  if(isset($maincontent->dt_start)&&$maincontent->dt_start!=''){ $dt_start_db = $maincontent->dt_start;  }else{ $dt_start_db =0; }

	  if(isset($maincontent->dt_end)&&$maincontent->dt_end!=''){ $dt_end_db = $maincontent->dt_end;  }else{ $dt_end_db =0; }	 
	  ?>
	  
<label>Exam Start At</label>
<div class='input-group date col-xs-6' id='datetimepicker6' >
                                    <input type='text' class="form-control" name="dt_start" value="<?php echo date('Y-m-d', $dt_start_db); ?>"  id="dt_start" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span> 
                                </div> 		  
								<div class='col-xs-9' > 
								<div  class="col-xs-3">
								<?php 
			if($dt_start_db>0){
			$start_time = date('H:i:s', $dt_start_db); 
								
			$start_time_array=explode(':',$start_time);
							}
			$hrs_arr=$this->config->item('hrs');
			
			$min_arr=$this->config->item('min');
			
			$sec_arr=$this->config->item('sec');
		
								?>
									HRS
									<select name="dt_starthrs" id="dt_starthrs" class="form-control valid"> 
									<?php
										foreach($hrs_arr as $hkey=>$hvalue){
											
											if($start_time_array[0]==$hvalue){
												?>
												
				<option value="<?php echo $hkey; ?>" selected="selected"><?php echo $hvalue; ?></option>
												<?php
											}else{
				?>
				<option value="<?php echo $hkey; ?>"><?php echo $hvalue; ?></option>
				<?php
											}
			}
			?>
									</select>
									</div>
									<div  class="col-xs-3">		
									MIN
										<select name="dt_startmin" id="dt_startmin" class="form-control valid"> 
									<?php
										foreach($min_arr as $mkey=>$mvalue){
											if($start_time_array[1]==$mvalue){
												?>
				<option value="<?php echo $mkey; ?>" selected="selected"><?php echo $mvalue; ?></option>
												<?php
											}else{
				?>
				<option value="<?php echo $mkey; ?>"><?php echo $mvalue; ?></option>
				<?php
											}
				
			}
									
									?>
									</select>
									
									
									</div>
									<div  class="col-xs-3">		
									SEC
									<select name="dt_startsec" id="dt_startsec" class="form-control valid"> 
									<?php
										foreach($sec_arr as $skey=>$svalue){
											
											if($start_time_array[2]==$svalue){
												?>
												
				<option value="<?php echo $skey; ?>" selected="selected"><?php echo $svalue; ?></option>
												<?php
											}else{
				?>
				<option value="<?php echo $skey; ?>"><?php echo $svalue; ?></option>
				<?php
											}
				
			}
			?>
									</select>
									
									</div>
                                    <input type='hidden' class="form-control" name="dt_start_db" value="<?php echo $dt_start_db; ?>"/><br>
									</div>				
     								
     </div>
<br>
<br>	 <!--For Online Exam Only start-->

      <div class="form-group"><label>Exam End At</label>

       <div class='input-group date  col-xs-6' id='datetimepicker7'>
                                    <input type='text' class="form-control" name="dt_end" value="<?php echo date('Y-m-d', $dt_end_db); ?>"  id="dt_end" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>	
								<div class='col-xs-9' >
								
								<?php if($dt_end_db>0){ $end_time=date('H:i:s', $dt_end_db); 								
									$end_time_array=explode(':',$end_time);
								} ?>	
				<div  class="col-xs-3"> HRS
				
						<select name="dt_endhrs" id="dt_endhrs" class="form-control valid"> 
									<?php
										foreach($hrs_arr as $end_hkey=>$end_hvalue){
											
											if($end_time_array[0]==$end_hvalue){
												?>
												
				<option value="<?php echo $end_hkey; ?>" selected="selected"><?php echo $end_hvalue; ?></option>
												<?php
											}else{
				?>
				<option value="<?php echo $end_hkey; ?>"><?php echo $end_hvalue; ?></option>
				<?php
											}
				
			}
									
									?>
									</select>
				</div>	
								<div  class="col-xs-3">  
								        MIN
											<select name="dt_endmin" id="dt_endmin" class="form-control valid"> 
									<?php
										foreach($min_arr as $end_mkey=>$end_mvalue){
											
											if($end_time_array[1]==$end_mvalue){
												?>
												
				<option value="<?php echo $end_mkey; ?>" selected="selected"><?php echo $end_mvalue; ?></option>
												<?php
											}else{
				?>
				<option value="<?php echo $end_mkey; ?>"><?php echo $end_mvalue; ?></option>
				<?php
											}
				
			}
									?>
									</select>
										</div>		
								<div  class="col-xs-3">  
									    SEC
										
											<select name="dt_endsec" id="dt_endsec" class="form-control valid"> 
									<?php
										foreach($sec_arr as $end_skey=>$end_svalue){
											
											if($end_time_array[2]==$end_svalue){
												?>
												
				<option value="<?php echo $end_skey; ?>" selected="selected"><?php echo $end_svalue; ?></option>
												<?php
											}else{
				?>
				<option value="<?php echo $end_skey; ?>"><?php echo $end_svalue; ?></option>
				<?php
											}
				
			}
			?>
									</select>
										</div>
                                <input type='hidden' class="form-control" name="dt_end_db" value="<?php echo $dt_end_db; ?>"/><br>
</div>									
     </div>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker6').datetimepicker({format:'YYYY-MM-DD'});
        $('#datetimepicker7').datetimepicker({
            format:'YYYY-MM-DD',
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
            $('.datepicker').hide();
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
            $('.datepicker').hide();
        });
    });
</script>
	 <br><br><br>
	 <?php } ?>
<!--For Online Exam Only Start and Time End -->	 
      <div class="form-group"><label>Online Exam Type</label>
      <input class="form-control" type="text" name="exam_type" value="<?php if(isset($maincontent->type)){ echo  $maincontent->type;  } ?>" id="exam_type"/></div>
	 
     <div class="form-group">  <label>Online Exam Instruction</label>
       <!-- 
       <input class="form-control" type="text" name="exam_instructions" id="exam_instructions" value="<?php if(isset($maincontent->instructions)){ echo  $maincontent->instructions;  } ?>"/> 
       -->
       <textarea class="form-control"  name="exam_instructions" id="exam_instructions"><?php if(isset($maincontent->instructions)){ echo  $maincontent->instructions;  } ?>
       </textarea>
     </div>
        <div class="form-group">
        <a href="<?php echo base_url();?>upload_files/online_test_demo.zip">Download Sample for Multiple question</a>
       </div>
  <?php 
  $showQA_upload='no';
  if($showQA_upload=='yes'){ ?>
    <div class="form-group">
        <label class="url">Question PDF</label>
        <input type="file" name="qus_pdf" value=""  id="qus_pdf"/>
        
        <?php if(isset($maincontent->qus_pdf)&&$maincontent->qus_pdf!=''){ 
            ?><input type="hidden" name="db_qus_pdf" value="<?php echo $maincontent->qus_pdf; ?>" /><?php
            
            echo  $maincontent->qus_pdf.' ['; 
        
        if (is_readable($pdf_file_path.$maincontent->qus_pdf)) {
          echo "<a href='".base_url().'/upload/pdfs/'.$maincontent->qus_pdf."' target='_blank'>Open now</a> ";  
        }else{ 
            echo " File not available on server. ";
        }
        echo ']';
        } ?>
    </div>
    <div class="form-group">
        <label class="url">Answer PDF</label>
        <input type="file" name="ans_pdf" value=""  id="ans_pdf"/>
        <?php if(isset($maincontent->ans_pdf)&&$maincontent->ans_pdf!=''){ echo  $maincontent->ans_pdf.' ['; 
              ?><input type="hidden" name="db_ans_pdf" value="<?php echo $maincontent->ans_pdf; ?>" /><?php
      
        if (is_readable($pdf_file_path.$maincontent->ans_pdf)) {
          echo "  <a href='".base_url().'/upload/pdfs/'.$maincontent->ans_pdf."'>Open now</a> ";  
        }else{ 
            echo " File not available on server. ";
        }
        echo ']'; } ?>
    </div>
    <div class="form-group">
        <label class="url">Solution PDF </label>
        <input type="file" name="solution_pdf" value=""  id="solution_pdf"/>
        
        <?php if(isset($maincontent->solution_pdf)&&$maincontent->solution_pdf!=''){ 
             ?><input type="hidden" name="db_solution_pdf" value="<?php echo $maincontent->solution_pdf; ?>" /><?php
            echo  $maincontent->solution_pdf.' ['; 
        
        if (is_readable($pdf_file_path.$maincontent->solution_pdf)) { 
          echo "  <a href='".base_url().'/upload/pdfs/'.$maincontent->solution_pdf."'>Open now</a> ";  
        }else{ 
            echo " File not available on server. ";
        }
        echo ']';  } ?>
    </div>
          <?php } ?>
          <hr>NOTE:-MULTIPLE QUESTION WILL ADD QUESTION IN BELLOW LIST.ONLY UPLOAD ZIP <hr>
    </div>
    <div class="form-group">
        <label class="url">Multiple Question Zip</label>
        <input type="file" name="html_zip_file" value=""  id="html_zip_file"/>
    </div>
 </div>

 </div>
<!--Article section-->
<div id="Article" style="display:none">
<div class="form-group">
        <label class="url">Single Article Zip</label>
        <input type="file" name="article_zip_file" value=""  id="article_zip_file"/>            
    </div>
</div>


 <!--Video Section-->
 <div id="videos_section" <?php echo $for_video_section_display; ?> >
     <?php if(isset($maincontent->id)){ ?>
     <input type="hidden"  name="video_upload_type"  id="video_upload_type" value="1">
     <?php
     if(isset($module_file_details[0]->id)){
        $cmsvideos_table_id = $module_file_details[0]->id;
       $module_file_details_count = count($module_file_details);
        }else{
        $module_file_details_count =0; 
        $cmsvideos_table_id=0;
                
        }
     ?>
     <input type="hidden" name="cmsvideos_table_id"  value="<?php echo $cmsvideos_table_id;  ?>" >
    <?php
          
        $existing_playlist_id=0;      
        $existing_playlist_id = $maincontent->id;
        unset($module_file_details[0]);
    ?>
    <div>
     <input type="hidden" name="existing_playlist_id"  value="<?php echo $existing_playlist_id;  ?>" >
    </div>
      <?php
        $array_existing_playlist_id = array ('0' => (object) array ( 'id' => '0', 'name' => 'Playlist N.A. .'));        
        ?>
      <div id="playlistTables-example" style="display:none" ><label>Select Existing Playlist</label>
     <?php
         echo generateSelectBox('existing_playlist_id',$array_existing_playlist_id, 'id', 'name', 1, 'class="form-control"',$existing_playlist_id);
  if($existing_playlist_id==0){
     ?>
  <?php } ?>
     </div>
     <?php if(isset($maincontent->id)){ ?>
      
     <div>
        <label>Add New Video Information ( Total Video <?php echo $module_file_details_count; ?>)</label>
      </div>  
         <?php }?>
     
      <div>
        <label>Video Name</label>
        <input type="text" class="form-control" id="video_name" name="video_name" value="<?php
if (isset($module_file_details[0]->title))
	{
	echo $module_file_details[0]->title;
	} ?>" >
    </div>
 
  <div class="form-group"> 
      <label>Price</label>
        <input class="form-control" type="text" name="video_price" value="<?php if(isset($pricelist_details->price)){ echo  $pricelist_details->price;  } ?>"  id="video_price"/>       
    </div> 
 
     <div class="form-group"> 
      <label>Discounted Price</label>
        <input class="form-control" type="text" name="discounted_price" value="<?php if(isset($pricelist_details->discounted_price)){ echo  $pricelist_details->discounted_price;  } ?>"  id="discounted_price"/>       
    </div>
    <div class="form-group"> 
      <label>Product Expiry Date</label>
        <input class="form-control" type="text" name="product_expiry_date" value="<?php if(isset($pricelist_details->product_expiry_date)){ echo  $pricelist_details->product_expiry_date;  } ?>"  id="discounted_price"/>       
    </div> 
     <!--Video Section-->

    <div class="form-group">
        <label>Video Source</label>
        
        <?php
        if(isset($module_file_details[0]->video_source)){
        $video_source = $module_file_details[0]->video_source;
        }else{
        $video_source='studyadda';
                
        }
        
         echo generateSelectBox('video_source',$array_video_source, 'id', 'name', 0, 'class="form-control"',$video_source);
        ?>

    </div>
	<!--video link path for studyadda-->
	<div class="form-group">
    <label>App Full Video name</label>
	<input class="form-control" name="androidapp_link" name="androidapp_link" value="" type="text" >
    </div>
	
    <div class="form-group">
    <label>Video URL code (youtube)</label>
      <?php
      if(isset($module_file_details[0]->video_url_code)){
        $video_url_code = $module_file_details[0]->video_url_code;
        }else{
        $video_url_code='';
                
        }
    ?>
    <input type="text" class="form-control" id="video_url_code" name="video_url_code" value="<?php echo $video_url_code;?>">
    </div>
    <div class="form-group">
    <label>Featured Video</label>
   <?php
   if(isset($module_file_details[0]->is_featured)){
        $is_featured = $module_file_details[0]->is_featured;
        }else{
        $is_featured=0;
                
        }
  
         echo generateSelectBox('is_featured',$array_is_featured, 'id', 'name', 0, 'class="form-control"',$is_featured);
   ?>
    </div>
    <div class="form-group">
    <label>Video description</label>
    <?php
      if(isset($module_file_details[0]->description)){
        $description = $module_file_details[0]->description;
        }else{
        $description='';                
        }
    ?>    
    <input type="text" class="form-control" id="description" name="description" value="<?php echo $description; ?>">
    </div>
    <div class="form-group">
    <label>Video By (User Id)</label>
       <?php
        if(isset($module_file_details[0]->video_by)){
        $video_byid = $module_file_details[0]->video_by;
        }else{
        $video_byid=0;
        }
         echo generateSelectBox('video_by',$array_video_by, 'id', 'name', 0, 'class="form-control"',$video_byid);
		
	?>
    </div> 
    <div class="form-group">
    <label>Video Status</label>
      <?php
   if(isset($module_file_details[0]->status)){
        $status = $module_file_details[0]->status;
        }else{
        $status=1;                
        }
         echo generateSelectBox('status',$array_status, 'id', 'name', 0, 'class="form-control"',$status);
  
         ?>
    </div>
    <div class="form-group">
    <label>Video Tag</label>
       <?php
      if(isset($module_file_details[0]->video_tag)){
        $video_tag = $module_file_details[0]->video_tag;
        }else{
        $video_tag='';
                
        }
    ?>
    <input type="text" class="form-control" id="tags" name="video_tag" value="<?php echo $video_tag; ?>">
    </div>
    <div class="form-group">
    <label>Custom Video Duration</label>
       <?php
      if(isset($module_file_details[0]->custom_video_duration)){
        $custom_video_duration = $module_file_details[0]->custom_video_duration;
        }else{
        $custom_video_duration='';
                
        }
    ?>
    <input type="text" class="form-control" id="custom_video_duration" name="custom_video_duration" value="<?php echo $custom_video_duration; ?>">
    </div>
    <div class="form-group">
    <label>Video amazonaws Link</label>
       <?php
      if(isset($module_file_details[0]->amazonaws_link)){
        $amazonaws_link = $module_file_details[0]->amazonaws_link;
        }else{
        $amazonaws_link='';
        }
    ?>
    <input type="text" class="form-control" id="amazonaws_link" name="amazonaws_link" value="<?php echo $amazonaws_link; ?>">
    </div>   
    <div class="form-group">
    <label>Amazon Cloudfront Domain</label>
       <?php
      if(isset($module_file_details[0]->amazon_cloudfront_domain)){
        $amazon_cloudfront_domain = $module_file_details[0]->amazon_cloudfront_domain;
        }else{
        $amazon_cloudfront_domain='';
                
        }
    ?>
    <input type="text" class="form-control" id="amazon_cloudfront_domain" name="amazon_cloudfront_domain" value="<?php echo $amazon_cloudfront_domain; ?>">
    </div>
    <div  class="form-group">
           <label class="url">Video File Name </label>
      <?php
      if(isset($module_file_details[0]->video_file_name)){
        $common_file_name_video = $module_file_details[0]->video_file_name;
        }else{
        $common_file_name_video='';
        }
    ?>
           <input type="text"  class="form-control" name="common_file_name_video" value="<?php  echo $common_file_name_video; ?>"  id="common_file_name_video"/>    
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
      if(isset($module_file_details[0]->video_image )){
        $video_image = $module_file_details[0]->video_image ;
        }else{
        $video_image='';
        }
    ?>
        <div class="form-group">
        <label class="url">Upload Video Image</label>
        <input type="file" name="video_image" value="" id="video_image"/>
        <?php 
        if($video_image!=''){ ?>
         <input type="hidden" name="video_image_in_db" value="<?php echo $video_image; ?>" />
         <label class="url"><img src="<?php
echo base_url(); ?>/assets/videoimages/<?php  echo $video_image; ?>" width="25%" height="25%" ></label>
        <?php  } ?>
        </div> 
     <?php }else{
         ?>
        <input type="hidden"  name="video_upload_type"  id="video_upload_type" value="playlist">
        <div class="form-group">
        <label class="url">Playlist Name</label>
        <input type="text" name="playlist_name" value=""  id="playlist_name" required/>
        </div>
        <div class="form-group">
        <label class="url">Description</label>
         <textarea rows="2" cols="10" name="playlist_description"  id="playlist_description" ></textarea> 
        </div> <?php
     } ?>
 </div> 
 <div class="text-right"> 
 <button type="submit" class="btn btn-primary"><?php echo $submit_button_text; ?></button>
 </div> 
 </div>
</form>
<script type="text/javascript">
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
<script type="text/javascript">
    function showOptions(type){
        $('#u_type_single').show();
        $('#u_type_multi').show();
        $('input[name="content_type_name"]').val(type);
        $('#qtype').show(); 
        $('#ol_exam').hide();
        $('#videos_section').hide(); 
        if(type=='Article'){
            $('#Others').hide();
            $('#Article').show();
            $('#ol_exam').hide(); 
        }else{ 
            
            $('#Others').show();
            if((type=='Study Material')||(type=='Online Tests')){
            $('#blk-1').show();
            if((type=='Online Tests')){
            $('#blk-2').show();
        }else{
            $('#blk-2').hide();
        }
            $("#upload_type_single").attr('checked', 'NULL'); 
            $("#studypackage_feed").attr('checked', false);
       
            }else{
            $('#blk-1').hide();
            $('#blk-2').show();
            $("#upload_type_multiple").attr('checked', 'checked'); 
                
            }
            if(type=='Online Tests'){
            $('#u_type_single').hide();
            //$("#upload_type_single").removeAttr('checked');
            $("#upload_type_multple").attr('checked', 'checked');
            $('#qtype').hide();     
            $('#ol_exam').show();
            }else if(type=='Videos'){
               //$("#upload_type_multple").removeAttr('checked');
              // $("#upload_type_single").attr('checked', 'checked');
               $('#Others').hide(); 
               $('#videos_section').show(); 
            }
            $('#Article').hide();
        }
    }
    
    $('#studypackage_feed').click(
        function(){
            if($('input[name=studypackage_feed]').is(':checked')==true){
                $('#blk-1').show();
            }else{
                $('#blk-1').hide();
            }
        }
    );
    //Calender for product expiration date .
    $(function () {
        $('#productLimitDate').datetimepicker({format:'YYYY-MM-DD'});
    });
</script>