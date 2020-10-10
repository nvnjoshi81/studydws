<!-- middle content-start -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-3 text-left">
            <h1 class="page-header">
                <?php

				if(isset($maincontent->formula_id)){
				$exam_formula_id=$maincontent->formula_id;
				}else{
				$exam_formula_id='';	
				}
                if (isset($maincontent->name)) {
                    echo $content_type->name . ' - ' . $maincontent->name;
                } else {
					
								echo 'rrrrrrrrrrrr'.$id; die;
			echo 'rrrrrrrrrrrr'; die;
                    $this->session->set_flashdata('message', 'Information not Available!');
                    redirect('admin/contents/add');
                    die();
                }
                ?>
            </h1>
            <?php
            if ($this->session->flashdata('message')) {
                ?>
                <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?>
                </div>

                <?php
            }
				//print_r($maincontent_name_array);
            ?>
        </div>
        
        <div class="col-lg-3 text-left">
            <h1 class="page-header"><?php
                if (isset($content_type->name) &&($content_type->name == 'Question Bank')) {
                    if ($main_exam_id > 0) {
                        ?>
                        <a href="#" data-target="#myModal_creat_studypackages" data-show="true" data-toggle="modal">Link Question Bank with Study packages</a>
                        <?php
                    }
                }
				?>
                        <a target="_blank" href="<?php echo base_url('printpdf.php?contentnumber='.$content_type->id.'&module_primery_id='.$maincontent->id.'&modulename='.urlencode($content_type->name));; ?>">Genrate PDF</a>
                        <?php
                ?>
				
				</h1>
        </div>
        <div class="col-lg-3 text-right">
            <h1 class="page-header"><?php
                if (isset($content_type->name) && ($content_type->name == 'Solved Papers') || ($content_type->name == 'Sample Papers') || ($content_type->name == 'Question Bank')) {
                    if ($main_exam_id > 0) {
                        ?>
                        <a href="#" data-target="#myModal_creat_onlinetest" data-show="true" data-toggle="modal">Create Onlinetest</a>
                        <?php
                    }
                }
                ?></h1>
        </div>

        <div class="col-lg-3 text-right">
            <h1 class="page-header">
                <?php
                if (isset($_SERVER['HTTP_REFERER'])){
                    ?>
                    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><< Back</a>
                    <?php
                } else {
                    ?>
                    <a href="/admin/contents/add"><< Back</a>
                    <?php
                }
                ?>
            </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <?php
        $this->load->view('add_module');
        $module_file_count = NULL;
        if (isset($module_file_details)) {
            $module_file_count = count($module_file_details);
        }

        $module_relation_count = NULL;
        if (isset($module_relation_details)) {
            $module_relation_count = count($module_relation_details);
        }
        ?>

        <div class="col-sm-6 well">
            <?php
            if ($content_type->name == 'Videos') {
                $showHidefilelist = 'style="display: none"';
                $delete_list_from_action = 'remove_multiple_videos';
                $form_action = 'remove_multiple_videos';
            } else {

                $showHidefilelist = 'style="display: block"';
                if ($content_type->name == 'Online Tests') {
                    $delete_list_from_action = 'remove_onlinetest_qus';
                    $form_action = 'remove_onlinetest_qus';
                } else {
                    $delete_list_from_action = 'alert_remove_multi_qus';
                    $form_action = 'remove_multi_qus';
                }
            }
            ?>
            <div id="Others" <?php echo $showHidefilelist; ?> >
                <div class="form-group">
            <?php if (isset($module_file_count) && ($module_file_count != NULL)) { ?>
                        <label>Uploaded File List</label>
                        <table class="table">
                            <thead>
                                <tr>  
                                    <th>#</th>
                                    <th>Display Name</th>
                                    <th>Flex Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody><?php
            $fid = 1;
            foreach ($module_file_details as $file_details) {
                ?>
                                    <tr class="success">
                                        <td><?php echo $fid; ?></td>
                                        <td><?php
                            if ($content_type->name == 'Videos') {
                                //echo $file_details->filename;
                            } else {
                        ?>
    <a href="/admin/contents/getFileInfo/<?php echo $file_details->file_id; ?>" data-target="#myModal_edit_displayname" data-show="true" data-toggle="modal"><?php echo $file_details->displayname; ?></a>

                    <?php }
                 ?>
                                        </td>
                                        <td><?php
                                            if ($content_type->name == 'Videos') {
                                                //echo $file_details->filename_one;
                                            } else {
                                                echo $file_details->filename;
                                            }
                                            ?></td>

                                        <td><?php
                                            if ($content_type->name == 'Videos') {
                                                //Video link
                                                ?>
                                                <?php
                                            } else {
                                                ?><a href="/admin/Content/remove_file_byid/<?php echo $file_details->file_id; ?>/<?php echo $maincontent->id; ?>/<?php echo $content_type->id; ?>" ><i class="fa fa-trash cat-del"></i></a><a href="/admin/contents/price/<?php echo $maincontent->id; ?>/<?php echo $content_type->id; ?>/<?php echo $file_details->file_id; ?>" data-target="#myModal" data-show="true" data-toggle="modal"><i class="fa fa-inr cat-edit"></i></a><a href="/admin/contents/getFileInfo/<?php echo $file_details->file_id; ?>" data-target="#myModal_edit_displayname" data-show="true" data-toggle="modal"><i class="fa fa-edit cat-edit"></i> </a>

                                                <?php
                                                if ($file_details->file_id > 1) {
                                                    
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>

        <?php
        $fid++;
    }
    ?>
                            </tbody>
                        </table> 
                            <?php } ?>
                </div>
            </div>

<?php
$maincontent_id = 0;
if (isset($maincontent->id)) {
    $maincontent_id = $maincontent->id;
}

$content_type_id = 0;
if (isset($content_type->id)) {
    $content_type_id = $content_type->id;
}


if (isset($content_type->name) && ($content_type->name == 'Videos')) {
    ?>

                <div id="edit_playlist">
                    <form  enctype="multipart/form-data" id="add_category_form" method="post" action="<?php echo base_url() . 'admin/contents/edit_submit'; ?>" >
                        <input type="hidden"  name="content_type"  id="content_type" value="<?php echo $content_type->id; ?>">

                        <input type="hidden" name="module_id"  value="<?php echo $maincontent_id; ?>" >
                        <input type="hidden" name="module_type_id"  value="<?php echo $content_type_id; ?>" >
                        <input type="hidden"  name="playlist_id"  id="playlist_id" value="<?php echo $array_existing_playlist_id[0]->id; ?>">

                        <h2>Edit Playlist </h2>
                        <input type="hidden"  name="video_upload_type"  id="video_upload_type" value="playlist">
                        <div class="form-group">
                            <label class="url">Playlist Name</label>
                            <input type="text" name="playlist_name" value="<?php echo $array_existing_playlist_id[0]->name; ?>"  id="playlist_name" required/>
                        </div>
                        <div class="form-group">
                            <label class="url">Description</label>
                            <textarea rows="2" cols="10" name="playlist_description"  id="playlist_description" ><?php echo $array_existing_playlist_id[0]->description; ?></textarea> 
                        </div>
                        <div class="form-group"><button type="submit" name="submit">Submit</button></div>          
                    </form> 

                </div>
<?php } ?>
            <hr>        <script>
$(document).ready(function(){
    $("#rel_link").click(function(){
        $("#rel_box").toggle();
    });
});
</script>

<div><a id="rel_link">Show/Hide Module Relation</a></div>
            <!--Show relation table entry -->
            <div>
                <div class="form-group" id="rel_box" style="display:none">
<?php
if (isset($module_relation_count) && ($module_relation_count != NULL)) {
    ?>
<label>Module Relation List</label>
<div  id="rel_tab">
                        <table class="table">
                            <thead>
                                <tr>  
                                    <th>#</th>
                                    <th>Module Id</th>
                                    <th>Exam Id</th>  
                                    <th>Subject Id</th>
                                    <th>Chapter Id</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php
    $rid = 1;
    $rn_id = 0;
    foreach ($module_relation_details as $relation_details) {
        ?>
                                    <tr class="success">
                                        <td><?php echo $rid; ?></td>
                                        <td><?php
                            echo $maincontent->name;
                            ?></td>
                                        <td><?php echo $relation_exam[$rn_id]; ?></td>
                                        <td><?php echo $relation_subject[$rn_id]; ?></td>
                                        <td><?php echo $relation_chapter[$rn_id]; ?></td>
                                        <td><a href="/admin/Contents/remove_relation_byid/<?php echo $relation_details->id; ?>/<?php echo $maincontent->id; ?>/<?php echo $content_type->id; ?>" ><i class="fa fa-trash cat-del"></i></a></td>
                                    </tr>

        <?php
        $rn_id++;
        $rid++;
    }
    ?>
                            </tbody>
                        </table> 
</div>
                            <?php } ?>
               
           
            <!--Show relation Form entry -->
            <div id="Others1">
                <form  enctype="multipart/form-data" id="add_category_form" method="post" action="<?php echo base_url(); ?>admin/contents/add_relation" onsubmit="return add_relation_validation();" >
                    <div class="form-group">

                        <label>Add Relation</label>


                        <div class="col-sm-12">

<?php
$price_table_id = 0;
if (isset($pricelist_details->id)) {
    $price_table_id = $pricelist_details->id;
}
?>
                            <input type="hidden" name="module_id"  value="<?php echo $maincontent_id; ?>" >
                            <input type="hidden" name="module_type_id"  value="<?php echo $content_type_id; ?>" >
                            <input type="hidden" name="price_table_id"  value="<?php echo $price_table_id; ?>" >
                            <input type="hidden" name="relation_content_type"  id="relation_content_type"  value="<?php echo $content_type_id; ?>" >
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select Exam</label>
<?php
$content_type_exam_id = 0;
if (isset($maincontent->exam_id)) {
    $content_type_exam_id = $maincontent->exam_id;
}

echo generateSelectBox('relation_exam', $exams, 'id', 'name', 1, 'class="form-control" onchange="getContent_relation();"', $content_type_exam_id);
?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select Subject</label>
<?php
$content_type_subject = 0;
if (isset($maincontent->subject_id)) {
    $content_type_subject = $maincontent->subject_id;
}
echo generateSelectBox('relation_subject', $subjects, 'id', 'name', 1, 'class="form-control" onchange="getContent_relation();"', $content_type_subject);
?>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Select Chapters</label>
                                    <div id="eschapters"></div>
                                </div>
                            </div>
                        </div> 

<?php $relation_submit_button_text = 'Add Relation'; ?>
                        <button type="submit" class="btn btn-primary"><?php echo $relation_submit_button_text; ?></button>

                    </div>
                </form>
            </div>
 </div>
        </div>  
    </div>
<?php if ($content_type->name != 'Videos-delete') { ?>
        <div class="row">
            <div class="panel col-lg-12">
                <!-- Default panel contents -->

                <div  id="panel_chang_id">
                    <h1>Edit Single Question Answer</h1>
                    <div class="panel-heading"><?php echo count($items) . ' ' . $heading; ?></div>
                </div>
                <div class="col-lg-12" id="contentdata">
                    <?php $selfassess_link=base_url('admin/contents/create_selfAssessment/' . $maincontent->id. '/' . $content_type_id . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id); ?>
                    <div class="panel">
                        <a href="<?php echo $selfassess_link; ?>" onclick="return confirm('Are you sure? Create this test as self assessment test.')">Create Self Assessment Test</a> (All question must be Type -> 1 FOR Very Short OR
Type -> 2 FOR Short OR
Type -> 3 FOR Long OR Type -> 10 FOR Fill in the blanks)
                    </div>
                    <div class="panel">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-
                                 responsive">

                                <form name="rm_multi_qus" id="rm_multi_qus" action="/admin/Contents/<?php echo $delete_list_from_action; ?>" method="POST">

                                    <input type="hidden" name="form_action" value="<?php echo $form_action; ?>">
                                    <input type="hidden" name="main_exam_id" value="<?php echo $main_exam_id; ?>"> 
                                    <input type="hidden" name="main_subject_id" value="<?php echo $main_subject_id; ?>">  
                                    <input type="hidden" name="main_chapter_id" value="<?php echo $main_chapter_id; ?>"> 

    <?php
    if (count($items) > 0) {
        ?>                 
                                        <button type="submit" name="submit_qus_list" id="submit_qus_list" value="rm_all_qus" onclick="return confirm('All question from this page will be deleted.Are you sure?')">Remove All Question</button>
                                        <?php
                                    }
                                      if ($content_type->name == 'Online Tests') {
                                          ?><a target="_blank" href="<?php echo base_url().'admin/contents/edit_onlinetest/' . $maincontent_id . '/' . $content_type_id . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id; ?>" ><button type="button">Add More Question</button></a>
                                      <?php } ?>

                                    <table class="table table-striped table-bordered 
                                           table-hover"  id="dataTables-example">
                                        <thead>
                                        <th width="5%">No.</th>
                                        <th width="5%">Question ID</th>
                                        <th width="60%"><?php echo $heading; ?></th> 
    <?php if(isset($added_chapters) && count($added_chapters) > 0){ ?>
                                        <th width="10%">Chapter</th> 
    <?php } ?>
                                        <th width="10%">Type<?php 
                                        if($content_type->name != 'Videos') {
                                        echo " /Section ";
                                        } ?>
                                        </th>              
                                        <th width="10%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
    <?php
    $cc = 1;
    $showol_form = 'yes';
   
    foreach ($items as $item) {
        ?>
        <tr>
        <?php
        $var_item_question_id = '';
		$var_qus_formulaid='';
        if ($content_type->name == 'Videos') {
            //Video link
            if (isset($item->video_id)) {
                $var_item_question_id = $item->video_id;
            }
        } else {

            if (isset($item->question_id)) {
                $var_item_question_id = $item->question_id;
            }
            if(isset($item->qus_formula_id)&&$item->qus_formula_id>0) {
                $var_qus_formulaid = $item->qus_formula_id;
            }else{
				$var_qus_formulaid=$exam_formula_id;
			}
            
            if (isset($item->details_id)) {
                $ol_details_id = $item->details_id;
            }
            
        }
        ?>
        <input type="hidden" name="inner_item_id[]" 
               value="<?php echo $var_item_question_id; ?>" >
        <?php
        $var_item_questionbank_id = '';
        if ($content_type->name == 'Videos') {
            //Video link 
            if (isset($item->videolist_id)) {
                $var_item_questionbank_id = $item->videolist_id;
            }
        } else {

            if (isset($item->questionbank_id)) {
                $var_item_questionbank_id = $item->questionbank_id;
            } else {
                $var_item_questionbank_id = $maincontent->id;
            }
        }
        ?>
                                            <input type="hidden" name="questionbank_id" value="<?php echo $var_item_questionbank_id; ?>" >

        <?php
        $var_content_type_id = '';
        if ($content_type->name == 'Videos') {
            //Video link
            $var_content_type_id = $content_type->id;
        } else {

            if (isset($content_type->id)) {
                $var_content_type_id = $content_type->id;
            }
        }
        ?>
                                            <input type="hidden" name="questionbank_type_id" value="<?php echo $var_content_type_id; ?>" >
                                            <?php
                                              $var_item_question = '';
                                              $var_video_file='';                                                                    $var_amazon_cloudfront='';
                                            if ($content_type->name == 'Videos') {
//Video link
                                                if (isset($item->title)) {
                                                    $var_item_question = $item->title;
                                                }
                                                //Amazon
                                               if (isset($item->video_source)&&($item->video_source=='amazon')) {
                                          $var_video_file=$item->amazonaws_link;                                                 $var_amazon_cloudfront=$item->amazon_cloudfront_domain;
                                                }
                                                //youtube
                                                if (isset($item->video_source)&&($item->video_source=='youtube')) {
                                                $var_video_file=$item->video_url_code;             
                                                }
                                            } else {
                                                if (isset($item->question)) {
                                                    $var_item_question = $item->question;
                                                } 
                                            }
                                            //Get video type
                                            ?>  
                                            <th width="5%"><?php echo $cc; ?></th>
                                            <td scope="row"><?php echo $var_item_question_id; /*Show/Hide status For video specially*/
			 if(isset($item->status)){
				 echo "<br>";
			 if($item->status=='1'){
				 echo "<font color='green'>Visible</font>";
			 }else{
				 echo "<font color='red'>NotVisible</font>";
			 }
			 }?></td>

                                            <td style="word-wrap: normal; width: 100px; background: lightblue; padding: 5px;">
<?php
$maincontent_language=$maincontent->language;

if(isset($maincontent_language)&&$maincontent_language=='hindi') {
    $hindicss='class="hindifont"';
    $hindicss_number_q='class="hindicss_number_q"';
    $hindicss_number_a='class="hindicss_number_a"';
    $hindicss_text='class="hindicss_text"';
}  

?>

<div <?php echo $hindicss; ?> >


                                                <?php 
											echo custom_strip_tags($var_item_question); ?>
                                            </div>
                                            <?php
										 $vidRelation=$this->Videos_model->getRelByVid($var_item_question_id,$maincontent->id);	
	$remoteFile="";		/*								if(isset($var_video_file)&&$var_video_file!=''){ }*/

$amznServerlnk = str_replace("https://s3-us-west-2.amazonaws.com/","https://www.studyadda.com/upload_files/",$item->amazonaws_link);

if(isset($item->androidapp_link)&&$item->androidapp_link!=''){
	$remoteFile="https://www.studyadda.com/upload_files/".$item->androidapp_link;
}
// Remote file url

// Open file
$handle = @fopen($remoteFile, 'r');

												
                                             if (isset($content_type->name) && ($content_type->name == 'Videos')) {  
                                             ?><br>Video=><?php                 
											if (isset($item->video_source)&&($item->video_source=='studyadda'||$item->video_source=='amazon')) { 
// Check if file exists
if(!$handle){ 
	?><a target="_blank" href="<?php echo $remoteFile; ?>" title="<?php echo '('.$var_video_file.') '.$var_amazon_cloudfront; ?>"><font color="red"> [NOT EXIST ON SERVER] </font><?
}else{
?><a target="_blank" href="<?php echo $remoteFile; ?>" title="<?php echo '('.$var_video_file.') '.$var_amazon_cloudfront; ?>"><font color="blue"> [EXIST] Click Here To Check</font><?php

}
//echo $item->androidapp_link; ?>
</a> <br>

<?php
 }else{ 
		if(isset($item->video_url_code)){
			echo '<font color="green">Youtube-'.$item->video_url_code.'.mp4</font>';
		$clicki=1;
			foreach($vidRelation as $vKey=>$vValue){
		echo '<br><a target="_blank" href="'.base_url("videos/1/2/3/".$maincontent->name."/vns/".$item->id).'">Click_'.$clicki.'</a>';	
		$clicki++;
		}
		}

											} } ?></td>
                                            




        <?php if (isset($added_chapters) && count($added_chapters) > 0) { ?>
                                                <td>
                                                    <select style="font-size: 12px" name="relatequestion" onchange="relateQuestion(<?php echo $var_item_question_id; ?>, this.value)">
                                                        <option value="0">Select Chapter</option>
            <?php foreach ($added_chapters as $k => $v) { ?>
                                                        <option <?php if ($k == $item->chapter_id) {
                    echo 'selected="selected"';
                } ?> value="<?php echo $k; ?>"><?php echo $v ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            <?php } ?>    
                                            <?php
                                         $var_item_type = '';
                                                $var_item_section = '';
                                                $var_section_name = '';
                                           if ($content_type->name == 'Videos') {
                                                //Video link
                                                //Video edit-delete area 
                                                if (isset($item->video_source)) {
                                                    $var_item_type = $item->video_source;
                                                }
                                                $path_edit_content = 'admin/content/editvideos/';
                                                $path_delete_content = 'admin/content/deletevideo/';
                                            } else {
                                                if (isset($item->type)) {
                                                    $var_item_type = $item->type;
                                                }

                                                if (isset($item->section)) {
                                                    $var_item_section = $item->section;
                                                }

                                                if (isset($item->section_name)) {
                                                    $var_section_name = $item->section_name;
                                                }
                                                $path_edit_content = 'admin/content/editcontent/';
                                                $path_delete_content = 'admin/contents/deletecontent/';
                                            }
                                            ?>
                                                <td><span  style="font-size: 9px"><?php 
												echo $var_item_type; 
												if($var_item_type=='youtube'&&isset($item->video_tag)){ 
												echo substr($item->video_tag, 0,11); 
												
												} 
											
												?></span> <?php if ($var_section_name != '') { ?>(<a title="<?php echo $var_section_name; ?>"><?php echo $var_item_section; ?></a>)<?php } ?></td>

                                            <td>
                                                <a href="<?php echo base_url() . $path_edit_content . $var_item_question_id; ?>/<?php echo $content_type->id; ?>/<?php echo $maincontent->id; ?>">
                                                    <i class="fa fa-edit cat-edit"></i>
                                                </a>
                                                <a href="<?php echo base_url() . $path_delete_content . $var_item_question_id; ?>/<?php echo $content_type->id; ?>/<?php echo $maincontent->id . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id; ?>"  onclick="return confirm('Question may be attached to other module like Online test or Solved Paper.Are you sure to delete now?')" >
                                                    <i class="fa fa-trash cat-del"></i>
                                                </a>
                                                <?php //echo $log->success ==1 ? 'True':'False'; 
                                                
                                               if ($content_type->name == 'Online Tests') {  ?><input disabled="disabled" type="text" value="<?php echo $item->marks; ?>" name="qusmarks" id="qusmarks_<?php echo $var_item_question_id; ?>" maxlength="4" size="4" onkeyup="editMarks('<?php echo $ol_details_id; ?>','<?php echo $var_item_question_id; ?>')">Marks <?php 
											       $formula_array=$this->Onlinetest_model->getolExamFormula();							   ?>
											   <div class="form-group">  <label>Question Formula</label><select name="qus_formula_id" id="qus_formula_id_<?php echo $var_item_question_id; ?>" class="form-control valid" onchange="updtQue_formula('<?php echo $ol_details_id; ?>','<?php echo $var_item_question_id; ?>', this.options[this.selectedIndex].value)">
	
	<option value="">Qus Formula</option>
	<?php
	foreach($formula_array as $fkey=>$fvalue){
	?>
	<?php if($var_qus_formulaid==$fvalue->online_exam_formula_id){ $fsel='selected="selected"'; }else{$fsel=''; } ?>
	<option <?php echo $fsel; ?> value="<?php echo $fvalue->online_exam_formula_id; ?>"><?php echo $fvalue->online_exam_formula_name; ?></option>
	
	<?php
	}
	?>
	</select>
     </div>
											   
	<?php }  ?>										   </td>

                                            </tr>
                                            <?php
                                            $cc++;
                                            if ((isset($item->typeid) && $item->typeid == 1) || (isset($item->typeid) && $item->typeid == 2) || (isset($item->typeid) && $item->typeid == 3)) {
                                                $showol_form = 'no';
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <?php } ?>
    <!-- /.panel-footer -->
</div>
<!-- /.panel .chat-panel -->

<!---middle-content---End-->
<!-- model box for online test-->
<div class="modal fade" id="myModal_creat_onlinetest" role="dialog">
    <?php
    $flag_formshowhide = 'block';
    ?>

    <div class="modal-dialog">

        <?php
        if ($content_type->name == 'Solved Papers') {

            $url_create_ot = base_url('admin/contents/solvedpaper_to_onlinetest/' . $this->uri->segment(4) . '/' . $this->uri->segment(5));
        }
        if ($content_type->name == 'Sample Papers') {
            $url_create_ot = base_url('admin/contents/samplepaper_to_onlinetest/' . $this->uri->segment(4) . '/' . $this->uri->segment(5));
        }

        if ($content_type->name == 'Question Bank') {
            $url_create_ot = base_url('admin/contents/questionbank_to_onlinetest/' . $this->uri->segment(4) . '/' . $this->uri->segment(5));
        }
        ?>
        <!-- Modal content-->
        <form action="<?php echo $url_create_ot; ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Online Test Details</b></h4>
<?php
if ($showol_form == 'no') {
    $flag_formshowhide = 'none';
    echo "You can not create Online test for this Module.";
}
?>
                </div>
                <div class="modal-body" style="display:<?php echo $flag_formshowhide; ?>" >
                    <!--<div class="form-group has-success label-floating is-empty">
                        <label class="control-label" for="name">Time</label>
                        <input class="form-control" type="time" name="time" required>
                    </div> -->
                    <input type="hidden" name="main_exam_id" value="<?php echo $main_exam_id; ?>"> 
                    <input type="hidden" name="main_subject_id" value="<?php echo $main_subject_id; ?>">  
                    <input type="hidden" name="main_chapter_id" value="<?php echo $main_chapter_id; ?>">  
                    <div class="form-group">
                    <label>Select Exam</label>
                    <?php
echo generateSelectBox('main_exam_id', $exams, 'id', 'name', 1 , 'class="form-control" onchange="getContent();"',$main_exam_id);  ?>
                    </div>                    
                    <div class="form-group">
                    <label>Select Subject</label>
                    <?php
                    echo generateSelectBox('main_subject_id', $subjects, 'id', 'name', 1 , 'class="form-control" onchange="getContent();"', $main_subject_id);  ?>
                    </div>
                    <div class="form-group">
                    <label>Select Chapter</label>
                    <?php
echo generateSelectBox('main_chapter_id', $chapters_arr, 'id', 'name', 1 , ' class="form-control" onchange="getContent(1);"',$main_chapter_id); ?>                 
                    </div>
                    <div class="form-group">   
                        <label>Temporary Section</label>
                        <input type="text" class="form-control" id="section" name="section" value="A">&nbsp;<label>Temporary Section Name</label><input type="text" class="form-control" id="section_name" name="section_name" value="">
                    </div>
                    <div class="form-group">   
                        <label>Test Name</label>
                        <input type="text" class="form-control" id="test_name" name="test_name" value="<?php echo $maincontent->name; ?>">
                    </div>

                    <div class="form-group">   
                        <label>Online Exam Time(In Seconds)</label>
                        <input type="text" class="form-control" id="exam_time" name="exam_time" value="">
                    </div>

                    <div class="form-group"><label>Online Exam Formula</label>
                        <?php 
                        $formula_id_for_exam='0';
    echo generateSelectBox('formula_id', $examformula_array, 'online_exam_formula_id', 'online_exam_formula_name', 1, 'class="form-control"',$formula_id_for_exam);
                        ?>
                    </div>
                    <div class="form-group"><label>Online Exam Category</label>
                        <?php 
                        $category_id_for_exam='0';
    echo generateSelectBox('olcategory_id', $olcategory_array, 'id', 'name', 1, 'class="form-control"',$category_id_for_exam);
                        ?>
                    </div>
                    
                    
                    <div class="form-group">  
                        <?php
                         if($content_type->name == 'Question Bank') {
                             $fullSelect='';
                             $partSelect='selected="selected"';
                         }else{
                             $fullSelect='selected="selected"';
                             $partSelect='';
                         }
                        ?>
                        <label>Type</label>
                        <select name="type" id="type" class="form-control valid">
                            <option value="Full" <?php echo $fullSelect; ?> >Full</option>
                            <option value="Part" <?php echo $partSelect; ?>>Part</option>
                        </select>
                    </div> 
                    <div class="form-group">  <label>Calculator</label>

                        <select name="calculater" id="calculater" class="form-control valid">
                            <option value="yes" selected="selected">Yes</option>
                            <option value="no">No</option>
                        </select>          


                    </div>

                    <div class="form-group has-success label-floating is-empty">
                        <label class="control-label" for="name">Instructions</label>
                        <textarea class="form-control" type="instructions" name="instructions"></textarea>
                    </div> 


                </div>
                <div class="modal-footer">
<?php if ($showol_form == 'yes') { ?>
                        <button type="submit" class="btn btn-raised btn-warning">Update</button>
                    <?php
                    } else {

                        echo "<font color='red'>NOTE:Question type should be Multiple Choice(5),Single Choice(6),Fill in the blanks(10) or Match the column(11) to create online test.</font>";
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    
                    
                     <table class="table table-hover">
    <thead>
      <tr>
        <th>Option</th>
        <th><?php echo count($items); ?> Questions</th>
        <th>Type</th>
      </tr>
    </thead>
    <tbody>
            <?php
            $pop_cnt=1;
            foreach ($items as $question) {
                $array_question_id=0;
                if (isset($question->question_id)) {
                $array_question_id = $question->question_id;
            }
            $var_item_section = '';
                            if (isset($question->section)) {
                            $var_item_section = $question->section;
                            }
                            $var_section_name = '';
                            if(isset($question->section_name)) {
                            $var_section_name = $question->section_name;
                            }
            $var_item_type = '';
                                                if (isset($question->type)) {
                                                    $var_item_type = $question->type;
                                                
}            
            
?><tr><td width="10%"><div>(<?php echo $pop_cnt; ?>) <input type="checkbox" checked="checked" name="otqus_array[]" value="<?php echo $array_question_id; ?>"></div></td><td width="10%" style="word-wrap: normal" ><div><?php echo custom_strip_tags($question->question); ?></div></td><td><?php if($var_item_section!=''){ echo $var_item_type.'('.$var_item_section.')/'; }; echo $var_section_name;?></td></tr><?php
            $pop_cnt++;
            
        }
            ?>    
    </tbody>
    </table>
                </div> 
            </div>
        </form>
    </div>
</div>

<!-- model box for Study Packages from question Bank-->
<div class="modal fade" id="myModal_creat_studypackages" role="dialog" >
         <?php
         $flag_formshowhide = 'block';
         ?>
    <div class="modal-dialog">
        <?php
        $url_create_ot = '';

        if ($content_type->name =='Question Bank') {
            $url_create_ot = base_url('admin/contents/add_submit');
        }
        ?>
        <!-- Modal content-->
        <form action="<?php echo  $url_create_ot; ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Study Packages Details</b></h4>
                </div>
            <div class="modal-body" style="display:<?php echo $flag_formshowhide; ?>" >
            <input type="hidden" name="category" value="<?php echo $main_exam_id; ?>"> 
            <input type="hidden" name="subject" value="<?php echo $main_subject_id; ?>">  
            <input type="hidden" name="chapter" value="<?php echo $main_chapter_id; ?>">      <input type="hidden" name="content_type" id="content_type"  value="<?php echo '1'; ?>" >
            <input type="hidden" name="merge_module_id_post" value="<?php echo $maincontent_id; ?>">
            <input type="hidden" name="merge_module_type_post" value="<?php echo $content_type_id; ?>">
            <input type="hidden" name="studypackage_feed" value="1">
              <input type="hidden" name="studypackage_feed_edit" value="1">
            <div class="form-group"> 
            <label>Contents Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php
                     if (isset($maincontent->name)) {
                         echo $maincontent->name;
                     }
                    ?>" >
            </div>
                <div class="form-group"> 
                <label>Price (* Required for Study Packages)</label>
                <input class="form-control" type="text" name="price" 
                    value="<?php
                     if (isset($pricelist_details->price)) {
                         echo $pricelist_details->price;
                     }
                     ?>" id="price"/> </div>
                <div class="form-group"> 
                    <label>Discounted Price</label>
                    <input class="form-control" type="text" name="discounted_price_others" 
                    value="<?php if(isset($pricelist_details->discounted_price)) {
                    echo $pricelist_details->discounted_price ; } ?>" 
                    id="discounted_price_others" />       
                </div>
<?php $single_qus_display = 'display:block'; ?>
                <div class="toHide"  
                     style="<?php echo $single_qus_display; ?>" id="blk-1"> 
                    <div  class="form-group">
                        <label class="url">Display File Name </label>
                        <input type="text"  
                               class="form-control" 
                               name="display_file_name" 
                               value=""  
                               id="display_file_name"/>    
                    </div>
                    <div  class="form-group">
                        <label class="url">Common File Name </label>
                        <input type="text"  
                               class="form-control" 
                               name="common_file_name" 
                               value=""  
                               id="common_file_name"/>    
                        <label 
                            class="url">OR</label>               
                    </div>
                    <div  id="single_q">
                        <div  class="form-group">
                            <label class="url">Flex Zip</label>
                            <input type="file" 
                                   name="zip_file" 
                                   value=""  
                                   id="zip_file"/>              
                        </div>
                        <div class="form-group">
                            <label class="url">PDF</label>
                            <input type="file" 
                                   name="pdf_file" 
                                   value=""  
                                   id="pdf_file"/>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-warning">Update</button>
                </div> 
            </div>
            </div> 
        </form>
    </div>
    
</div>
</div>