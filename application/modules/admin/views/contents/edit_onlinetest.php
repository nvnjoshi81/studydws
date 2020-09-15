<!-- middle content-start -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6 text-left">
            <h1 class="page-header">
                <?php
                if (isset($maincontent->name)) {
                echo $content_type->name . ' - ' . $maincontent->name;
                } else {
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
            ?>
        </div>
        <div class="col-lg-3 text-right">
            <h1 class="page-header">
                <?php
                if (isset($_SERVER['HTTP_REFERER'])) {
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
        $content_type_id=0; 
        $content_type_exam_id=0;
        ?>
            <div class="col-sm-12">
                <input type="hidden" value="<?php echo $maincontent->id; ?>" id="ot_id" name="ot_id">
                
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Select Content Type</label>
        <?php
        $contentobj=array();
        foreach($content_type_array as $content){
            
            if($content->id=='3'||$content->id=='7'||$content->id=='6'||$content->id=='10'){
          $contentobj[]= (object)['id'=>$content->id,'name'=>$content->name];     
            }
            }
        
echo generateSelectBox('content_type', $contentobj, 'id', 'name', 1, 'class="form-control" onChange="resetSelect();showOptions($(this).find(\'option:selected\').text());"',$content_type_id); 
?>
                </div>
            </div>
            <div class="col-sm-3">
<div class="form-group">
 <label>Select Exam</label><?php
echo generateSelectBox('category', $exams, 'id', 'name', 1 , 'class="form-control" onchange="viewContent();"',$content_type_exam_id);
?>              </div>
            </div>
            </div>
        <?php
        //$this->load->view('add_module');
        $module_file_count = NULL;
        if (isset($module_file_details)) {
            $module_file_count = count($module_file_details);
        }

        $module_relation_count = NULL;
        if (isset($module_relation_details)) {
            $module_relation_count = count($module_relation_details);
        }
        ?>
        <div class="row">
            <div class="panel col-lg-12">
                <!-- Default panel contents -->
                <div  id="panel_chang_id">
                    <h1>Question Bank Listing</h1>
                    <div class="panel-heading"></div>
                </div>
                <div class="col-lg-12" id="contentdata">
                    <div class="panel">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                
                                     <table class="table table-striped table-bordered 
                                           table-hover"  id="dataTables-example">
                                        <thead>
                                         <th>ID.</th>
                                    <th>Sql Id</th> 
                                    <th>Name</th>           
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Chapter</th>
                                    <th>&nbsp;</th>
                                    <th>Action</th>
                                     </thead>
                                     <tbody></tbody>
                                     </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Question Area-->
                
                <div  id="panel_chang_id_qa">
                    <h1>Select Question For Online Test</h1>
                    <div class="panel-heading">Total question: <span id="totalquestion_span" >0</span><input type="hidden" id="totalquestion" value=""></div>
                </div>
                <div class="col-lg-12" id="contentdata_qa">
                    <div class="panel">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                
                                     <table class="table table-striped table-bordered 
                                           table-hover"  id="dataTables_qa">
                                        <thead>
                                         <th>ID.</th>
                                    <th>Sql Id</th> 
                                    <th>Name</th>           
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Chapter</th>
                                    <th>&nbsp;</th>
                                    <th>Action</th>
                                     </thead>
                                     <tbody></tbody>
                                     </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
            </div>

        </div> 
    <!-- /.panel-footer -->
</div>
<!-- /.panel .chat-panel -->

<!---middle-content---End-->
<!-- model box-->
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
                    <div class="form-group">  <label>Type</label>
                        <select name="type" id="type" class="form-control valid">
                            <option value="Full" selected="selected">Full</option>
                            <option value="Part">Part</option>
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
        <th>Email</th>
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
            
            
            ?><tr><td><div>(<?php echo $pop_cnt; ?>) <input type="checkbox" checked="checked" name="otqus_array[]" value="<?php echo $array_question_id; ?>"></div></td><td><div><?php echo custom_strip_tags($question->question); ?></div></td><td><?php if($var_item_section!=''){ echo $var_item_type.'('.$var_item_section.')/'; }; echo $var_section_name;?></td></tr><?php
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