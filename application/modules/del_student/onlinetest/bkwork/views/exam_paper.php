<style>
 .btn span.glyphicon {    			
	opacity: 0;	 display:inline;			
}
.btn.active span.glyphicon {				
	opacity: 1;	 display:inline;			
}
span[aria-label]:after {
  opacity:0;
  content: attr(aria-label);
  padding: 4px 8px;
  position: absolute;
  right: 0;
  top: 120%;
  white-space: nowrap;
  z-index: 20;
  background: #edffb3;
  transition: opacity 0.5s;
  pointer-events:none;
}

span[aria-label]:hover:after {
  opacity:1;
  transition-delay:1.5s;
}
</style>
<?php
          $pqrs_array=array('P','Q','R','S','T','U','V','W','X','Y','Z');
		  $abcd_array=array('1','A','B','C','D','E','F','G','H','I','J','K');
$timestamp = time();
$usertest_id =$this->session->userdata('usertest_id');
$total_time=$this->session->userdata('total_time');
$diff = $total_time ; // <-Time of countdown in seconds.  ie. 3600 = 1 hr. or 86400 = 1 day.

//MODIFICATION BELOW THIS LINE IS NOT REQUIRED.
$hld_diff = $diff;
$time_spent = $this->session->userdata('ts');
if(isset($time_spent)) {
	$slice = ($timestamp - $time_spent);	
	$diff = $diff - $slice;
}

if(!isset($time_spent) || $diff > $hld_diff || $diff < 0 ) {
	$diff = $hld_diff;
        $this->session->set_userdata('ts', $timestamp); 
}

//Below is demonstration of output.  Seconds could be passed to Javascript.
$diff; //$diff holds seconds less than 3600 (1 hour);

$hours = floor($diff / 3600) . ' : ';
$diff = $diff % 3600;
$minutes = floor($diff / 60) . ' : ';
$diff = $diff % 60;
$seconds = $diff;

$exam_id=0;
$subject_id=0;
$chapter_id=0;
$onlinetest_id=0;
    if(isset($onlinetestinfo->exam_id)){
            $exam_id = $onlinetestinfo->exam_id;
    }
    if(isset($onlinetestinfo->subject_id)){
            $subject_id = $onlinetestinfo->subject_id;
    }
    if(isset($onlinetestinfo->chapter_id)){
            $chapter_id = $onlinetestinfo->chapter_id;
    }
    if(isset($onlinetestinfo->id)){
            $onlinetest_id = $onlinetestinfo->id;
    }
  $total_question_count = count($question_answer_array);  
?>
<div id="wrapper">
    <div class="container">
        <div class="row">
    <div class="col-md-12 col-sm-12">
            <div id="page-inner">
                <div class="module_panel row">                  
                  <!-- content panel start here -->
				  
				  
                  <!--Website View change Start-->
                  
                  <div class="col-sm-12 col-md-9" id="message_timeblock1" style="font-size:20px;font-weight:bolder;display:none; float: right;
    padding: 10px;" class="text-right text-warning" >
                      <div class="text-right text-warning"><span style="cursor:pointer;" onclick="changeAnsView(0)"><font color="green">Change View</font></span></div></div>
					  
					  <!--View Change-->
					  <div style="background-color:#f7931e" >
                     <div class="col-sm-12 col-md-9" id="message_timeblock" style="font-size:20px;font-weight:bolder;display:none;">
                      <div class="text-right text-warning"><span style="cursor:pointer;" onclick="timeshowhide(0)"><font color="green">Click To Show Time</font></span></div></div>
                  <div class="col-sm-12 col-md-9" id="parent_timeblock" >
				   <span  aria-label="Click Here To Hide Time"><!--onmouseover='showTxtClick()'-->
				  
                      <div  id="strclock" style="font-size:20px;font-weight:bolder;" class="text-right text-warning">Times Up!</div></span></div>
					  
					  </div>
                  <!-- left panel -->
                  <div class="col-sm-12 col-md-9">
                      <div class="panel panel-success" id="qa_submit_block">
					  
        <input type="hidden" name="crntQid" id="crntQid" value="0">
					  
        <input type="hidden" name="perclick_time_spent" id="perclick_time_spent" value="">
        <input type="hidden" name="current_time_spent" id="current_time_spent" value="">
        <input type="hidden" name="usertest_id" id="usertest_id" value="<?php echo $usertest_id; ?>">
        <input type="hidden" name="total_time" id="total_time" value="<?php echo $total_time; ?>">
        <input type="hidden" name="test_id" id="test_id" value="<?php echo $test_id; ?>">
        <input type="hidden" name="right_answer_marks" id="right_answer_marks" value="<?php echo $right_answer_marks; ?>">
        <input type="hidden" name="wrong_answer_marks" id="wrong_answer_marks" value="<?php echo $wrong_answer_marks; ?>">
        <input type="hidden" name="total_question" id="total_question" value="<?php echo $total_question; ?>">  
                 <?php 
                
                            $q_style_display='style="display:none"';
                            $a_style_display='style="display:nne"';
                            if(is_array($question_answer_array)){                          
                    for($question_count=1;$total_question_count>=$question_count;$question_count++){
                                if($question_count==1){
                                    $q_style_display='style="display:block"';
                                }else{
                                    $q_style_display='style="display:none"';  
                                }
                                $question_id =$question_answer_array[$question_count]['question_id'];
                                $qus_marks=$question_answer_array[$question_count]['qus_marks'];
                                $type =$question_answer_array[$question_count]['type'];
                                $current_question_id = $question_answer_array[$question_count]['question_id'];
                               $onlinetest_id = $onlinetest_id;
                               $answer_extra= $question_answer_array[$question_count]['answer_extra']; ?>
                      <div class="panel-body question_answer_body" id="panel-body-<?php echo $question_count; ?>" <?php echo $q_style_display; ?> >
                          <div class="row panel-heading nta-head">
    <div class="text-left col-md-12 col-sm-12">
        <div class="mr-2"><?php if(isset($question_answer_array[$question_count]['section'])){ ?><h5>&nbsp;<?php echo $question_answer_array[$question_count]['section_name']; 
		$section_dispv=$question_answer_array[$question_count]['section'];
		$section_disp=$section_dispv[0];
		echo '&nbsp;('.$section_disp.')'; 
					?> 
					</h5><?php }  ?>
					</div>
    </div>
</div>
                    <div class="ques_panel_exam">
                          <?php echo $question_count.") ".clear_html_text($question_answer_array[$question_count]['question']); 
						  ?>
                          </div>
                          <div class='row'></div>  <div class='row'></div>
                          <?php
                           $answer_array = $question_answer_array[$question_count]['answer_array'];
                           $answerid_array = $question_answer_array[$question_count]['answerid_array'];
                           
                           if(isset($question_answer_array[$question_count]['type_extra'])){
                               $mtb_answer_string = $question_answer_array[$question_count]['type_extra'];            
                               $mtb_answer_array =explode(',',$mtb_answer_string);
                               $mtb_answer_count = count($mtb_answer_array);
                           }else{
                               
                               $mtb_answer_array=NULL;
                               $mtb_answer_count=0;
                           }
                          ?>
                          <div id="panel-answer" class="user_ans">
                     
                          <?php 
                          $answer_count=1;
                          if(isset($answer_array[$question_id])){
                          $answer_option_count = count($answer_array[$question_id]);
                          }else{
                          $answer_option_count = 0;    
                          }
                          $flag_show_slider='no';
                          $cleare_status='';
                          if($answer_option_count>0){
                       for($answer_count=1;$answer_option_count>=$answer_count;$answer_count++){
                              if($type==$var_single_choice){$cleare_status="none";
                                  ?>
                              <table  class="table table-hover user_ans">
                                  <tr class="row">
                                   <td class="col-xs-12 col-sm-8 col-md-10 text-left" >
                              <?php echo ' ' .$answer_count.')&nbsp;'.$answer_array[$question_id][ $answer_count ].' '; 
                              ?>  
                                  </td>
                                  <td class="col-xs-12 col-sm-4 col-md-2 text-right">
                                      <input onclick="opt_clicked('<?php echo $question_id?>','show');" type="radio" id="single_select_<?php echo $question_id.'_'.$answer_count; ?>" name="single_select_<?php echo $question_id; ?>" value="<?php echo $answerid_array[$question_id][$answer_count]; ?>"></td>
                                 </tr>
                            </table>
                            <?php 
                            $cleare_status="none";
                             }elseif($type==$var_grid_single_choice){
$single_gridans=$answerid_array[$question_id][$answer_count];
								 $sgrid_strlen=strlen($single_gridans);				if($sgrid_strlen>1){
									 $single_gridans=$single_gridans[0];
								 }				 
					?>
<!--Single Grid answer start-->
<div style="display:inline;" class='user_ans'>
			<label class="btn btn-default" style="width:2px;border-style: groove;">  <input onclick="opt_clicked('<?php echo $question_id?>','show');" type="radio" id="grid_single_select_<?php echo $question_id.'_'.$answer_count; ?>" name="grid_single_select_<?php echo $question_id; ?>" value="<?php echo $answerid_array[$question_id][$answer_count]; ?>">&nbsp;    
			<?php echo $single_gridans; ?>&nbsp;
				<span class="glyphicon glyphicon-ok"></span>
			</label>
				</div>			
			<!-- Single Grid end-->		
					<?php
					 $cleare_status="none";
					}elseif($type==$var_multiple_choice){
	?>  <table  class="table table-hover user_ans">
                                  <tr class="row"><td class="col-xs-12 col-sm-8 col-md-8 text-left">
                              <?php echo ''.$answer_count.')&nbsp;'.$answer_array[$question_id][$answer_count]; 
                              ?>
                              </td><td class="col-xs-12 col-sm-4 col-md-4 text-right"><input onclick="opt_clicked('<?php echo $question_id?>','show');"  type="checkbox" id="option_choice_<?php echo $question_id.'_'.$answer_count; ?>" name="option_choice_<?php echo $question_id; ?>" value="<?php echo $answerid_array[$question_id][$answer_count]; ?>" ></td>
                            </tr></table>
                          <?php
                          $cleare_status="none";
                              }else if($type==$var_grid_multiple_choice){		 $optionans=$answer_array[$question_id][$answer_count];
								 $optans_strlen=strlen($optionans);
								 if($optans_strlen>1){
									 $optionans=$optionans[0];
								 }
?>
	<!--Grid answer-->
<div class="btn-group" style="display:inline;" data-toggle="buttons">
			<label class="btn btn-default" style="width:2px;border-style: groove;">
				<input onclick="opt_clicked('<?php echo $question_id?>','show');"  type="checkbox" id="option_choice_<?php echo $question_id.'_'.$answer_count; ?>" name="option_choice_<?php echo $question_id; ?>" value="<?php echo $answerid_array[$question_id][$answer_count]; ?>" >
				<?php
				echo $answer_array[$question_id][$answer_count]; 
				?>
				<span class="glyphicon glyphicon-ok"></span>
			</label>
				</div>			
			<!--Grid end--> 
<?php

		    $cleare_status="none";						  
							  }else if($type==$var_fill_in_the_blanks){
								  $qCalc=$question_answer_array[$question_count]['calculator'];
                                  if($onlinetestinfo->assessment_type=='self'){ $flag_show_slider='yes'; 
                                  }
								  ?>         
                             <table  class="table table-hover user_ans">
                                <tr class="row">
                                <td class="col-xs-12 col-sm-3 text-left ans_textarea">
                              <?php if($flag_show_slider=='yes'){ 
							  echo 'Correct Answer-' ; 
							  }else{
								  echo 'Answer Fill in the blank-';
								  }
                              ?>
                                  </td>
                              <td class="col-xs-12 col-sm-9 text-left ans_textarea"> 
							  <?php
							  
							   if($qCalc>0){
								$fib_disable='disabled=disabled';
								$iType='type="text"';
								}else{
								$iType='type="text"';
								$fib_disable='';
								}
							  ?>
							  <input <?php echo $fib_disable; ?> onclick="opt_clicked('<?php echo $question_id; ?>','show');" 
							    <?php echo $iType;?>
							  name="text_fill_blanks_<?php echo $question_id; ?>" <?php    if($flag_show_slider=='yes'){ ?> value="<?php  echo $answer_array[$question_id][$answer_count] ;?>"<?php }else{ ?> value=''  <?php } ?> id="text_fill_blanks_<?php echo $question_id; ?>"  type="text" style="width: 44%; min-height:5px;
 padding: 2px 4px;
 margin: 2px 2px;">
							  <?php
							  if($qCalc>0){
								$this->load->view('calculater');
								}
								?>
							  </td>
                                  </tr>
                             </table>
                            <?php 
                            $cleare_status="none";
                                }else if($type==$var_match_the_column){
                                    ?>
                                <table  class="table table-hover user_ans">
                                   <tr class="row">
                                    <td class="col-sm-4text-left">
                        <?php 
						
															if(isset($abcd_array[$answer_count])){
											
											echo $abcd_array[$answer_count].')&nbsp;'; 
											}else{
												
				echo ''.$answer_count.')&nbsp;';							
											}
						echo $answer_array[$question_id][$answer_count].''; 
                              ?>
                                    </td>
                                    <td class="col-sm-8 text-right">  
                                        <?php                                                 
                                        for($mtb_cnt=0; $mtb_answer_count>$mtb_cnt;$mtb_cnt++){
                                            echo $mtb_answer_array[$mtb_cnt];                                   $answer_extra_array=explode(',',$answer_extra);
                                            for($i=0;$i<count($answer_extra_array);$i++){ 
											if(isset($pqrs_array[$i])){
											echo $pqrs_array[$i].')&nbsp;'; }
                                                ?><input onclick="opt_clicked('<?php echo $question_id?>','show');" type="checkbox" id="option_choice_mtb_<?php echo $question_id.'_'.$answer_count.'_'.$i; ?>" name="option_choice_mtb_<?php echo $question_id.'_'.$answer_count; ?>" value="<?php echo $answer_extra_array[$i]; ?>" >
                                        <?php echo ' '.$answer_extra_array[$i].' '; } } ?>
                                    </td>
                                    </tr>
                                </table>
                                        <?php $cleare_status="none";
                                }
                              }
                          }
                          if($qus_marks>0){
                              $right_answer_marks=$qus_marks;
                          }
                          ?>
                          <input type="hidden" id="questio_marks_<?php echo $question_id ; ?>" value="<?php echo $right_answer_marks; ?>">
                          </div>
                          <div class="btn_set row">
                         <?php if($question_count>1){
                         ?>
                          <!--
                          <span class="input-grp-btn btn_online_exam">
                          <a class="btn-md btn btn-success btn-raised btn-lg" href="#" onclick="previous_submit(<?php echo $question_count; ?>);">Previous</a>
                          </span>  
                          -->
                          <?php  } ?>
                          <?php 
                          if($total_question_count>$question_count){
                          ?>
                        <span class="input-grp-btn btn_online_exam">
                              <a class="btn-md btn-sm btn-lg btn btn-success btn-raised" href="#" onclick="next_submit(<?php echo $question_count; ?>,'<?php echo $type; ?>',<?php echo $current_question_id ; ?>,<?php echo $onlinetest_id; ?>,<?php echo $usertest_id; ?>,<?php echo $answer_option_count ; ?>,'<?php echo $mtb_answer_count ; ?>','review_submit');" title="Mark for Review and go to Next Question" >Mark To Review</a>
                        </span>  
                        <span class="input-grp-btn btn_online_exam">
                              <a class="btn-md btn-sm btn-lg btn btn-success btn-raised " href="#" onclick="next_submit(<?php echo $question_count; ?>,'<?php echo $type; ?>',<?php echo $current_question_id ; ?>,<?php echo $onlinetest_id; ?>,<?php echo $usertest_id; ?>,<?php echo $answer_option_count ; ?>,'<?php echo $mtb_answer_count ; ?>','next_submit');"  title="Save and go to Next Question">Next</a>
                      </span> 
                                 
                    <?php  }else{   ?> 
                              <span class="input-grp-btn">
                              <a class="btn-md btn-sm btn btn-success btn-raised btn-lg" href="#" onclick="next_submit(<?php echo $question_count; ?>,'<?php echo $type; ?>',<?php echo $current_question_id ; ?>,<?php echo $onlinetest_id; ?>,<?php echo $usertest_id; ?>,<?php echo $answer_option_count ; ?>,'<?php echo $mtb_answer_count ; ?>','review_paper_submit');" title="Mark for Review and Submit Online Exam" >Mark To Review</a> <!--review_paper_submit next_paper_submit-->
                  </span> 
                  <span class="input-grp-btn">
                  <a class="btn-md btn-sm btn btn-success btn-raised btn-lg" href="#" onclick="next_submit(<?php echo $question_count; ?>,'<?php echo $type; ?>',<?php echo $current_question_id ; ?>,<?php echo $onlinetest_id; ?>,<?php echo $usertest_id; ?>,<?php echo $answer_option_count ; ?>,'<?php echo $mtb_answer_count ; ?>','next_paper_submit');"  title="Save and go to Next Question">Save</a>
                  </span>
                            <?php
                                
                            } ?>
							<span style="padding-left: 25px;" class="input-grp-btn btn_online_exam" onclick="opt_clicked('<?php echo $current_question_id; ?>','hide')" >
                             <span style="display:<?php echo $cleare_status; ?>" id="span_clear_btn_<?php echo $current_question_id; ?>" >
                                      <a id="clear_btn" class="btn-md btn-sm btn btn-success btn-raised btn-lg" href="#" onclick="clear_response('<?php echo $current_question_id; ?>','<?php echo $mtb_answer_count ; ?>','<?php echo $type; ?>','<?php echo $usertest_id; ?>');" title="Clear Response or Answer Online Exam" >Clear Response</a> </span>
                        </span>
							
                          </div>
                          
                          </div>
                            <?php 
                            } 
                              
                            /* Slider area*/
                            if($flag_show_slider=='yes'){
                          ?>
                              <div id="slideblock">
                                  <div class="slidecontainer" id="slidecontainer">
<p>Drag the slider to set mark for your answer.</p>
    <input type="range" min="1" max="<?php echo $right_answer_marks; ?>" value="1" class="slider" id="numberRange">
  <input type="hidden"  value="1"  id="selfmarks" name="selfmarks">
  <p>Self Assessment Marks: <span id="selfnumber"></span></p>
</div>    </div> 
                          <?php }     
                    }?>
                       
            </div>
             <div class="m_small_advertisepanel"><img alt="adversite" src="<?php echo base_url('assets/images/ole_adv.jpg')?>"></div> 
            </div>
                  <!-- right panel -->
                 <div class="col-sm-12 col-md-3 rht_status_mat">
                    <div class="panel panel-primary static_body">
                	<div class="panel-heading">
                            <h4> <i class="material-icons">book</i>Questions Panel</h4>
                        </div>
                	<div class="panel-body">
                            <?php
                            $section_a_count=1;
                            $section_b_count=1;
                            $section_c_count=1;                            
                            $section_d_count=1;                            
                            $section_e_count=1;
                            $section_f_count=1;
                            if(is_array($question_answer_array)){                                
                            for($static_count=1;$total_question_count>=$static_count;$static_count++){
                            if(($question_answer_array[$static_count]['section']=='A')&&($section_a_count==1)){
                            $section_a_count++;
                                 ?> 
                            
                            <div class="panel panel-info rht_stat_section"><a href="#" onclick="static_clicked(<?php echo $static_count; ?>);" ><h5>&nbsp;<?php echo $question_answer_array[$static_count]['section_name'].' ('.$question_answer_array[$static_count]['section'].')'; ?></h5></a></div>
                            <?php } 
                            
                            if(($question_answer_array[$static_count]['section']=='B')&&($section_b_count==1)){
                                $section_b_count++;
                                 ?> 
                            
                            <div class="panel panel-info rht_stat_section"><a href="#" onclick="static_clicked(<?php echo $static_count; ?>);" > <h5>&nbsp;<?php echo $question_answer_array[$static_count]['section_name'].' ('.$question_answer_array[$static_count]['section'].')'; ?> </h5></a></div>
                            <?php }  
                            if(($question_answer_array[$static_count]['section']=='C')&&($section_c_count==1)){
                                $section_c_count++;
                                 ?>
                            <div class="panel panel-info rht_stat_section"> <a href="#" onclick="static_clicked(<?php echo $static_count; ?>);" ><h5>&nbsp;<?php echo $question_answer_array[$static_count]['section_name'].' ('.$question_answer_array[$static_count]['section'].')'; ?> 
                                </h5></a></div>
                            <?php 
                            }
                            if(($question_answer_array[$static_count]['section']=='D')&&($section_d_count==1)){
                                $section_d_count++;
                                 ?>
                            <div class="panel panel-info rht_stat_section"> <a href="#" onclick="static_clicked(<?php echo $static_count; ?>);" ><h5>&nbsp;<?php echo $question_answer_array[$static_count]['section_name'].' ('.$question_answer_array[$static_count]['section'].')'; ?> 
                                </h5></a></div>
                            <?php 
                            }
                            if(($question_answer_array[$static_count]['section']=='E')&&($section_e_count==1)){
                                $section_e_count++;
                                 ?>
                            <div class="panel panel-info rht_stat_section"> <a href="#" onclick="static_clicked(<?php echo $static_count; ?>);" ><h5>&nbsp;<?php echo $question_answer_array[$static_count]['section_name'].' ('.$question_answer_array[$static_count]['section'].')'; ?> 
                                </h5></a></div>
                            <?php 
                            }
                            ?>
                            <a href="#" onclick="static_clicked(<?php echo $static_count; ?>,<?php echo $question_answer_array[$static_count]['question_id']; ?>);" > 
                                <span class="badge"  id="static_link_<?php echo $question_answer_array[$static_count]['question_id']; ?>" >
                          <?php echo $static_count ; ?>
                        </span></a>
                            <?php
                             }
                             }
                             ?>
                        </div>
                    </div>
                     <!--Calculator Section-->
                          <div style="display:none" class="panel-primary calculator_body" id="calculator_body" > <div class="panel-heading">Calculator</div> 
                              <span><?php    //$this->data['content']='calculater';
        $this->load->view('calculater'); ?></span>
                          </div>
                      <!--Instruction Section-->
                          <div style="display:none" class="panel-primary instruction_body" id="instruction_body" > <div class="panel-heading">Instruction</div> 
                              <span><?php   echo $instruction_detail; ?></span>
                          </div>
                     
                </div>
                </div> 
    </div>
             <!-- /. PAGE INNER  -->
 </div>
</div>
</div>
</div>
<script>
    
    function static_clicked(question_count,qid=0){
        var question_count;
		 document.getElementById('crntQid').value=qid;
        $('.question_answer_body').hide();
        $("#panel-body-"+question_count).show();   
        $(".btn_set").show();
    }
    
    function show_complete_paper(){
        $('.instruction_body').hide();
        $('.calculator_body').hide();
        $(".btn_set").toggle();
        $('.static_body').show();
        $('.question_answer_body').toggle();
    }
    
    function show_instruction(){
        $('.static_body').hide();
        $('.calculator_body').hide();
        $('.instruction_body').show('slow');
    }
    function show_calculator(){
        $('.static_body').hide();
        $('.instruction_body').hide();
        $('.calculator_body').show('slow');
        //$('.question_answer_body').show();
    }
    function only_paper_submit(usertest_id){
        var time_remainig = document.getElementById('current_time_spent').value;  
        var total_time= document.getElementById('total_time').value;  
        var test_id = document.getElementById('test_id').value;
        var wrong_answer_marks = document.getElementById('wrong_answer_marks').value;
        var right_answer_marks = document.getElementById('right_answer_marks').value;
        var total_question = document.getElementById('total_question').value;
        // Enter exam time in cmsusertest
        $.post(base_url+"onlinetest/start/submit_paper",
    {
        time_remainig: time_remainig,
        usertest_id: usertest_id,
        test_id: test_id,
        right_answer_marks:right_answer_marks,
        wrong_answer_marks:wrong_answer_marks,
        total_time:total_time,
        total_question:total_question
        
    },
    function(data, status){
       var r = confirm("Are you sure to Submit Test. After submiting the test this page will be closed and you will be taken to Result page.");
        if (r == true) {
            window.opener.location.reload(false);
            window.top.close();
        } 
    });
    }
    //for per question click 
    var totalSeconds = 0;
    function next_submit(question_count,qtype,qid,test_id,usertest_id,answer_total,ans_id,qaction){
	var users_answer_mtb='Test';
    //for perquestion click
        totalSeconds = 0;        
        //var exam_obj ={qus_type:qtype}; 
        var question_count;
        var question_count_plus=question_count+1;
        var textbox_val;
        var users_answer='';
        var single_select_qid ="single_select_"+qid;
		var grid_single_select_qid ="grid_single_select_"+qid;
        var option_choice_single_value ="option_choice_"+qid ;
        var grid_option_choice_single_value ="grid_option_choice_"+qid ;
		var option_choice_mtb_value ="";
        var text_fill_blanks_value ="text_fill_blanks_"+qid;
        var user_marks=0;
        var right_question_marks=<?php echo $right_answer_marks; ?>;
        var question_marks_id ="questio_marks_"+qid;
		  document.getElementById('crntQid').value=qid;
        var final_question_marks =0;
           if(qtype=='<?php  echo $var_single_choice; ?>'){  
            //users_answer = $("input[name='option_choice_qid']:checked").val();
            if((qaction=='review_submit')){
            $("input[name="+single_select_qid+"]").removeAttr("checked");
            }else{
            users_answer = $("input[name='"+single_select_qid+"']:checked").val(); 
            }
           }   
/*Grid single select */
           if(qtype=='<?php  echo $var_grid_single_choice; ?>'){ 
            if((qaction=='review_submit')){
            $("input[name="+grid_single_select_qid+"]").removeAttr("checked");
            }else{
            users_answer = $("input[name='"+grid_single_select_qid+"']:checked").val(); 
            }
           }    
		   
        if(qtype==('<?php  echo $var_multiple_choice; ?>')){
            
        if((qaction=='review_submit')){
        
             $("input[name="+option_choice_single_value+"]:checkbox").prop("checked",false);
        }else{
        var multiple_choice_array = [];

            $.each($("input[name='"+option_choice_single_value+"']:checked"), function(){            
                var multi_array_entry = $(this).val();
                multi_array_entry = multi_array_entry.trim();    
                multiple_choice_array.push(multi_array_entry);

            });
            users_answer = multiple_choice_array;
        }
    }  
/*grid multiple select*/
  if(qtype==('<?php  echo $var_grid_multiple_choice; ?>')){
            
        if((qaction=='review_submit')){
        
             $("input[name="+grid_option_choice_single_value+"]:checkbox").prop("checked",false);
        }else{
        var multiple_choice_array = [];

            $.each($("input[name='"+grid_option_choice_single_value+"']:checked"), function(){            
                var multi_array_entry = $(this).val();
                multi_array_entry = multi_array_entry.trim();    
                multiple_choice_array.push(multi_array_entry);

            });
            users_answer = multiple_choice_array;
        }
    } 
/*End single select*/

	
        if(qtype=='<?php  echo $var_match_the_column; ?>'){ 
            
         if((qaction=='review_submit')){
             var option_choice_mtb_nm;   
        for(var imc=0;5>=imc;imc++){
            option_choice_mtb_nm ="option_choice_mtb_"+qid+"_"+imc;
            $("input[name="+option_choice_mtb_nm+"]").removeAttr("checked");
       }
         
        }else{   
            var mtb_final_array = [];
            var j=-1;
            for(var i=0;answer_total>=i;i++){
            var mtb_array = [];
            option_choice_mtb_value =  "option_choice_mtb_"+qid+"_"+i; 
            $.each($("input[name='"+option_choice_mtb_value+"']"), function(){  
            if(this.checked==true){
               var mtb_array_entry = $(this).val();
                mtb_array_entry = mtb_array_entry.trim();
            mtb_array.push(mtb_array_entry);
            }else{
            //mtb_array.push(0);
            }
            });
             //mtb_final_array.push(mtb_array);
            if(mtb_array.length>0){
                mtb_final_array[j]=mtb_array;
            }
                j++;
        }
           users_answer=mtb_final_array;
           
        }
        }
        if(qtype=='<?php  echo $var_fill_in_the_blanks; ?>'){
            
        var question_marks = $("#"+question_marks_id).val();
        if(question_marks>0){
            final_question_marks=question_marks;
        }else{
            final_question_marks=right_question_marks;
        }
             user_marks=$("#selfmarks").val();
            
        if((qaction=='review_submit')){
        $('#text_fill_blanks_'+qid).val('');
        }else{
        users_answer = $("#"+text_fill_blanks_value).val();
        }
        }      
        if((qaction=='review_submit')||(qaction=='review_paper_submit')){
            
        $("#static_link_"+qid).removeClass("badge-info");
        $("#static_link_"+qid).removeClass("badge-success"); 
        $("#static_link_"+qid).addClass("badge-warning");  
        }else if((qaction=='next_submit')||(qaction=='next_paper_submit')){
        if(users_answer === undefined||users_answer==''){ 
        //nothin to do
        
        //$("#static_link_"+qid).removeClass("badge-warning");
        $("#static_link_"+qid).removeClass("badge-success");
        if($( "#static_link_"+qid).hasClass( "badge-warning" )){
        $("#static_link_"+qid).addClass("badge-warning");
    }else{
       $("#static_link_"+qid).addClass("badge-info"); 
    }
        }else{
        //Check for answer checked or not 
        $("#static_link_"+qid).removeClass("badge-info");
        $("#static_link_"+qid).removeClass("badge-warning");
        $("#static_link_"+qid).addClass("badge-success");
        }
    
    }
    
    //Enter question information
    var perclick_time_spent = document.getElementById("perclick_time_spent").value;
    
    $.post(base_url+"onlinetest/start/save_qus",
    {
        qtype: qtype,
        qid: qid,
        users_answer: users_answer,
        test_id: test_id,
        usertest_id: usertest_id,
        qaction:qaction,
        perclick_time_spent:perclick_time_spent,
        question_marks:final_question_marks,
        user_marks:user_marks
        
    },
    function(data, status){
        var data = JSON.parse(data);
    });
    // Last question Submission;
    if((qaction=='review_paper_submit')||(qaction=='next_paper_submit')){
        /*As per requirment we are not submit paper now from last question*/
        var nextselect = $("input[name='"+question_count_plus+"']:checked").val(); 
        $("#panel-body-"+question_count).show();  
        $("#qa_submit_block"+question_count).show();
        /*End Submit paper from last question*/
        
        
      /*  
        var time_remainig = document.getElementById('current_time_spent').value;
        var total_time= document.getElementById('total_time').value;
        $("#panel-body-"+question_count_plus).show();  
        $("#qa_submit_block"+question_count_plus).show();
        var wrong_answer_marks = document.getElementById('wrong_answer_marks').value;
        var right_answer_marks = document.getElementById('right_answer_marks').value;
        var total_question = document.getElementById('total_question').value;
        
        // Enter exam time in cmsusertest
           $.post(base_url+"onlinetest/start/submit_paper",
    {
        time_remainig: time_remainig,
        usertest_id: usertest_id,
        test_id: test_id,
        right_answer_marks:right_answer_marks,
        wrong_answer_marks:wrong_answer_marks,
        total_time:total_time,
        total_question:total_question
        
    },
    function(data, status){
       var r = confirm("Are you sure to Submit Test. After submiting the test this page will be closed and you will be taken to Result page.");
        if (r == true) {
            window.opener.location.reload(false);
            window.top.close();
        }
    });
    */
    }else{
        var nextselect = $("input[name='"+question_count_plus+"']:checked").val(); 
        
        $("#panel-body-"+question_count).hide();
        $("#panel-body-"+question_count_plus).show();  
        $("#qa_submit_block"+question_count_plus).show();
    }    
    }
    function previous_submit(question_count){
        var question_count;
        var question_count_minus=question_count-1;
        $("#panel-body-"+question_count).hide();
        $("#panel-body-"+question_count_minus).show(); 
    }
    
    function clear_response(qus_id,ans_id,type,exam_id){
		  document.getElementById('crntQid').value=qus_id;
        if(type==('<?php  echo $var_single_choice; ?>')){  
        var single_select_nm ="single_select_"+qus_id; 
        $("input[name="+single_select_nm+"]").removeAttr("checked");
        }
		
		/*Single grid cleare*/
		if(type==('<?php  echo $var_grid_single_choice; ?>')){  
        var grid_single_select_nm ="grid_single_select_"+qus_id; 
        $("input[name="+grid_single_select_nm+"]").removeAttr("checked");
        }
        
        if(type==('<?php  echo $var_multiple_choice; ?>')){ 
            var option_choice_nm ="option_choice_"+qus_id;  //$('input:checkbox').removeAttr('checked');
             $("input[name="+option_choice_nm+"]:checkbox").prop("checked",false);
        }
		/*Multiple grid cleare*/
		
		  if(type==('<?php  echo $var_grid_multiple_choice; ?>')){ 
            var option_choice_nm ="option_choice_"+qus_id;  //$('input:checkbox').removeAttr('checked');
             $("input[name="+option_choice_nm+"]:checkbox").prop("checked",false);
        }
        if(type=='<?php  echo $var_fill_in_the_blanks; ?>'){  
            $('#text_fill_blanks_'+qus_id).val('');
        }
        if(type=='<?php  echo $var_match_the_column; ?>'){ 
        var option_choice_mtb_nm;   
        for(var imc=0;5>=imc;imc++){
            option_choice_mtb_nm ="option_choice_mtb_"+qus_id+"_"+imc;
            $("input[name="+option_choice_mtb_nm+"]").removeAttr("checked");
       }
       }
       
        $.post(base_url+"onlinetest/start/cleare_answer",
    {
        qus_id: qus_id,
        exam_id: exam_id
    },
    function(data, status){
       //Nothind to do
        //static_link_12654
    $("#static_link_"+qus_id).removeClass("badge-warning");
    $("#static_link_"+qus_id).removeClass("badge-success");
    });
    }
    </script>
 <script type="text/javascript">
 var hour = <?php echo floor($hours); ?>;
 var min = <?php  echo floor($minutes); ?>;
 var sec = <?php  echo floor($seconds); ?>

function countdown() {
 if(sec <= 0 && min > 0) {
  sec = 60;
  min -= 1;
 }
 else if(min <= 0 && sec <= 0) {
  min = 0;
  sec = 0;
 }
 else {
  sec -= 1;
 }
 
 if(min <= 0 && hour > 0) {
  min = 60;
  hour -= 1;
 }
 
 var pat = /^[0-9]{1}$/;
 sec = (pat.test(sec) == true) ? '0'+sec : sec;
 min = (pat.test(min) == true) ? '0'+min : min;
 hour = (pat.test(hour) == true) ? '0'+hour : hour;
 if((hour<1)&&(min<1)&&(sec<1)){
 sec = 00;
 min = 00;
 hour = 00;
          var time_remainig = document.getElementById('current_time_spent').value;
          var usertest_id =document.getElementById('usertest_id').value;
          var total_time= document.getElementById('total_time').value;
          var test_id = document.getElementById('test_id').value;
          var wrong_answer_marks = document.getElementById('wrong_answer_marks').value;
          var right_answer_marks = document.getElementById('right_answer_marks').value;
          var total_question = document.getElementById('total_question').value;
        
          // Enter exam time in cmsusertest
        $.post(base_url+"onlinetest/start/submit_paper",
    {
        time_remainig: time_remainig,
        usertest_id: usertest_id,
        test_id:test_id,
        right_answer_marks:right_answer_marks,
        wrong_answer_marks:wrong_answer_marks,
        total_time:total_time,
        total_question:total_question
        
    },
    function(data, status){
            window.opener.location.reload(false);
            window.top.close();
    });
 }
 document.getElementById('current_time_spent').value= hour+":"+min+":"+sec;
 document.getElementById('strclock').innerHTML ="<span style='cursor:pointer; colore:green;' onclick='timeshowhide(1)'><span   id='txtClick' style='display:none;' >Click To Hide </span>Time: "+ hour+":"+min+":"+sec+"</span>";
 setTimeout("countdown()",1000);
 }
 countdown();

</script>
<script type="text/javascript">
        
    //for per question click
        //var minutesLabel = document.getElementById("minutes_perqus");
        var secondsLabel = document.getElementById("perclick_time_spent");
       
        setInterval(setTime, 1000);
var totalSeconds=0;
        function setTime()
        {
            ++totalSeconds;
            //secondsLabel.innerHTML = pad(totalSeconds%60);
            secondsLabel.value = pad(parseInt(totalSeconds/60))+':'+pad(totalSeconds%60);
        }

        function pad(val)
        {
            var valString = val + "";
            if(valString.length < 2)
            {
                return "0" + valString;
            }
            else
            {
                return valString;
            }
        }
   
   
   
    function opt_clicked(qid,status){
		  document.getElementById('crntQid').value=qid;
        if(status=='hide'){
    document.getElementById("span_clear_btn_"+qid).style.display='none';
    }else if(status=='show'){
    document.getElementById("span_clear_btn_"+qid).style.display='block';
        
    }
    }
    
</script>
<!--For range slider self assessment functionality -->
<script>
<?php 
if($flag_show_slider=='yes'){ 
?>
var slider = document.getElementById("numberRange");
var output = document.getElementById("selfnumber");
var selfmarks = document.getElementById("selfmarks"); 
output.innerHTML = slider.value;
//selfmarks.value=sider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
  selfmarks.value=this.value;
}
<?php } ?>
function timeshowhide(tm=0){
    if(tm==1){
        //hide
       
        document.getElementById("parent_timeblock").style.display = "none";
        
        document.getElementById("message_timeblock").style.display = "block";
    }else{
        //show
        //document.getElementById("parent_timeblock").innerHTML ='';
        document.getElementById("parent_timeblock").style.display = "block";
        document.getElementById("message_timeblock").style.display = "none";
        
    }
    
}


function changeAnsView(tm=0){
    if(tm==1){
        //hide
       
        document.getElementById("stdView").style.display = "none";
        
        document.getElementById("otherView").style.display = "block";
    }else{
        //show
        
        document.getElementById("stdView").style.display = "block";
        document.getElementById("otherView").style.display = "none";
        
    }
    
}

 function showTxtClick(){
    document.getElementById("txtClick").style.display = "block";
 }
 
 function calcEnter(){
	 var cloutpt=$("#calInfoOutPut").val();
	  var cloutpt_len=cloutpt.substring(0, cloutpt.length - 1);
 	/*save calculator value to input box*/
	//#calInfoOutPut
    $('#text_fill_blanks_<?php echo $question_id; ?>').val(cloutpt); 
	// <-- reverse your selectors here 
 }
</script>
<script>
					function changeCSS(cssFile, cssLinkIndex) {
    var oldlink = document.getElementsByTagName("link").item(cssLinkIndex);

    var newlink = document.createElement("link");
    newlink.setAttribute("rel", "stylesheet");
    newlink.setAttribute("type", "text/css");
    newlink.setAttribute("href", cssFile);

    document.getElementsByTagName("head").item(0).replaceChild(newlink, oldlink);
}
					</script>

<style>
    .green{
        background-color:  #00CE6F
    }
    
    .blue{
        background-color:  #0081C2 
    }
</style>