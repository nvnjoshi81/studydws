<?php
        $this->session->unset_userdata('exam_id');
        $this->session->unset_userdata('subject_id');
        $this->session->unset_userdata('chapter_id');
        $this->session->unset_userdata('onlinetest_id');
        $this->session->unset_userdata('total_time');
        $this->session->unset_userdata('current_user_id');
        $this->session->unset_userdata('current_exam_timestamp');
        $this->session->unset_userdata('ts'); 
        $usertest_session_value=$this->session->userdata('usertest_id');
        if(isset($usertest_session_value)){
        $this->session->unset_userdata('usertest_id');
            if(isset($usertest_info[0]->id)){
            $resultUrl=base_url('online-test/result/'.$usertest_info[0]->id);
            redirect($resultUrl);            
            }
        }
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
    if(isset($onlinetestinfo->time)){
            $total_time = $onlinetestinfo->time;
    }
    if(isset($onlinetestinfo->formula_id)){
            $formula_id = $onlinetestinfo->formula_id;
}
$timeresult =secondsToTime($onlinetestinfo->time); 
?>
<div id="wrapper">
    <div class="container">
        <div class="row">
             <?php
             $this->load->view('common/breadcrumb');?>
    <div class="col-md-12 col-sm-12 onlinetestbody">
            <div id="page-inner">
                <div class="module_panel row">  
                <div class="col-sm-12 col-md-9">
				<!-- content panel start here -->
                  <div class="col-sm-12 col-md-12 online_btn_test">
                  <div class="col-sm-6 col-md-6">
              <?php             
        $customer_id = $this->session->userdata('customer_id');
        if(!isset($customer_id)&&($customer_id=='')){
            ?>       
              <span class="ts-btn">
              <a href="<?php echo base_url('login')?>" >
                  <button type="button" class=" btn-md btn btn-success btn-raised btn-lg searchgo">Login to Start Test</button>
              </a>
              </span>
        <?php  
		}else{
        ?>
              <span>
                          <a href="#proceed_test" type="submit" class=" btn-md btn btn-success btn-raised btn-lg searchgo">Start Test<i class="material-icons">arrow_downward</i>  </a>
              </span>  
               <?php
        }
        ?>
        </div>
                    <div class="col-sm-6 col-md-6 text-right"> <label class="btn btn-sm btn-primary btn-simple" id="0">
					<?php
					if(isset( $timeresult['h'])&& $timeresult['h']>0){
						$hrsTomin=60* intval($timeresult['h']);
					}else{
						$hrsTomin=0;
					}
						if(isset( $timeresult['m'])&& $timeresult['m']>0){
							$minsTomin=intval($timeresult['m']);
						}else{
							$minsTomin=0;
						}
						
						
						if(isset( $timeresult['s'])&& $timeresult['s']>0){
							$secTomin=intval($timeresult['s'])/60;
						}else{
							$secTomin=0;
						}
						$durationInMin=$hrsTomin+$minsTomin+$secTomin;
					?>
					
               <font size='3px'>Exam Duration  - <?php echo $timeresult['h'].' HRS : '.$timeresult['m'].' MIN ';
			   if(isset($timeresult['s'])&&$timeresult['s']>0){
			   echo ': '.$timeresult['s'].' SEC';
			   } 
			   ?><br>(<em>In Minutes - <?php echo intval($durationInMin);?> MIN </em>)
               </font>
              <!--Test Type -<?php ///echo $onlinetestinfo->type; ?>-->
                      </label>
                    </div>
        </div>  
                  <div class="col-sm-12 col-md-12 instruct_panel">
                  <div class="panel panel-success" style="background-cplor:#f7931e;">
                	<div class="panel-heading" style="background-color:#f7931e;">
                 	 <h4>INSTRUCTION</h4><em>Please read the instructions carefully</em>
                     </div>
                    <div class="panel-body">
                        
                        <div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header bg-info" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          General Instructions:
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
    <ul>
      <li>Total duration and maximum marks of this exam is mentioned in Exam specific instructions.</li>
      <li>The clock will be set at the server. The countdown timer in the top right corner of screen will display the remaining time available for you to complete the examination. When the timer reaches zero, the examination will end by itself. You will not be required to end or submit your examination.In case you finish exam before the timer reaches zero you can choose to press submit button to end the exam.
</li>
<li>In case your test is paused when you lose internet connectivity or power off you need to log in again and start fresh test.
</li>


<li>
                                        The Questions Palette displayed on the right side of screen will show the status of each question using one of the following symbols:
                                        <ol>
                                            <li><span class="badge">Q.No.
                                                </span> You have not visited the question yet.<br><br></li>
                                            <li><span class="badge badge-info">Q.No.
                                               </span> You have not answered the question.<br><br></li>
                                            <li><span class="badge badge-success">Q.No.
                                               </span> You have answered the question.<br><br></li>
                                            <li><span class="badge badge-warning">Q.No.
                                               </span> You have NOT answered the question, but have marked the question for review.<br><br></li>
                                            <!--<li><img src="/assets/quiz/img/QuizIcons/Logo5.png"> The question(s) "Answered and Marked for Review" will be considered for evalution.<br><br></li>-->
                                        </ol>
                                    </li>

<li>Please note all questions will appear in English language only.
</li>
<li>The marked for review status for a question simply indicates that you would like to look at that question again. If a question is answered and marked for review, your answer for that question will be considered in the evaluation after you submit the exam or the timer reaches zero.</li>
    </ul>  
      </div>
    </div>
  </div>
  <div id="proceed_test"><!--Point for start test scroll--></div>
    <?php if(isset($onlinetestinfo->instructions)&&$onlinetestinfo->instructions!=''){ ?>
  <div class="card">
    <div class="card-header bg-info" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Exam specific Instructions
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
       <?php 
         if(isset($onlinetestinfo->instructions)){
                             
        echo "<p>".$onlinetestinfo->instructions."</p>";
                    }
                         ?>
      </div>
    </div>
  </div>
     <?php
                      }else{
						
                    echo "<p>Instructions not available!</p>";
                             
                         }
?> 
  <div class="card">
    <div class="card-header bg-info" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
         Navigating:
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body"><b>Navigating to a Question :</b><br>
          <br>
          <ul>
              <li>To select your answer, click on the button of one of the options.</li>
              <li>To deselect(unattempt) your chosen answer, click on the 'Clear Response' button
              </li>
              <li>To change your chosen answer, click on another option.</li>
              <li>To move to next question, click on the next button.</li>
              <li>To mark the question for review, click on the Mark for Review and Next button.
              </li>
              <li>If an answer is selected for a question that is 'Marked To Review', that answer will NOT be considered in the evaluation even if it is not marked as 'Save & Next', at the time of final submission
              </li>
          </ul>
<br><br>
<b>Answering a Question :</b><br>
<ul><li>You can view all the questions by clicking on the 'Show Question Paper' button on the top.    </li>
<li>Procedure for answering a multiple choice type question:
<ul>
<li>To select you answer, click on the button of one of the options.</li>
<li>To deselect your chosen answer, click on the button of the chosen option again or click on the Clear Response button.
</li>
<li>To change your chosen answer, click on the button of another option.
</li>
<li>To save your answer, you MUST click on the Save & Next button.
</li>
<li>To mark the question for review, click on the Mark for Review & Next button.
</li>
<li>To change your answer to a question that has already been answered, first select that question for answering and then follow the procedure for answering that type of question.
</li>
</ul>
</li>
</ul>

      </div>
    </div>
  </div>        
</div>
</div>
 <?php
			   if(isset($customer_id)&&($customer_id>0)){
				   ?>
<ul style="list-style: none">
<form action="/online-test/start" id="startoltest" name="startoltest" method="POST" target="_blank">
<li><input type="checkbox" id="en_ch" value="0" checked=checked>
I have read and understood the instructions. All computer hardware allotted to me are in proper working condition. I declare that I am not in possession of / not wearing / not carrying any prohibited gadget like mobile phone, bluetooth devices etc. /any prohibited material with me into the Examination Hall.I agree that in case of not adhering to the instructions, I shall be liable to be debarred from this Test and/or to disciplinary action, which may include ban from future Tests / Examinations
</li>
<li>
              <input  type="hidden" name="exam_id"     value="<?php echo $exam_id; ?>">
              <input  type="hidden" name="subject_id"    value="<?php echo $subject_id; ?>">
              <input  type="hidden" name="chapter_id"    value="<?php echo $chapter_id; ?>">
              <input  type="hidden" name="onlinetest_id" value="<?php echo $onlinetest_id; ?>">
              <input  type="hidden" name="total_time"    value="<?php echo $total_time; ?>" >
              <input  type="hidden" name="total_question" value="<?php echo $total_question; ?>" >
              <input type="hidden" name="formula_id"      value="<?php echo $formula_id; ?>">
              <span>
                          <button type="submit" class="btn btn-warning btn- btn-raised btn-lg searchgo">Start Test</button>
              </span>    
               </form></li>

			   </ul> <?php } ?>
</div>
             
</div> 
                  
                 <?php if(isset($customer_id)&&($customer_id!='')){ ?> 
                  <div class="col-sm-12 col-md-12">
                  <div class="panel panel-success">
                  <div class="panel-heading">
                 	 <h4><i class="material-icons">history</i>Recent Test Results</h4>
                     </div>
                     <ul class="row startexampanel">
<?php 

foreach($usertest_info as $testvalue){
    echo "<li class='col-xs-12 col-sm-6 col-md-6'><i class='material-icons'>update</i>  <a href='".base_url('online-test/result/'.$testvalue->id)."' >".$testvalue->name."</a></li>";
    
}
?>
                  </ul>                  </div>
                  </div>   
                 <?php } ?>  
                  </div> 
<div class="col-sm-12 col-md-3">  
                  <!-- right panel -->
                 <!--<div class="rht_status_mat">
                    <div class="panel panel-primary">
                	<div class="panel-heading">
                            <h4> <i class="material-icons">book</i>Statistics</h4>
                        </div>
                	<div class="panel-body">
                            <ul>
                                <li><i class="material-icons">&#xE037;</i> <a href="#"><span class="text-warning"></span>Total Time -<?php echo $timeresult['h'].':'.$timeresult['m'].':'.$timeresult['s']; ?></a> </li>
                                <li><i class="material-icons">&#xE037;</i><a href="#"> <span class="text-warning"></span>Test Type -<?php echo $onlinetestinfo->type; ?></a></li>
                            </ul>
                        </div>
                    </div>
                    -->
                    <div class="hidden-xs hidden-sm right_advertisepanel"><img alt="adversite" src="<?php echo base_url('assets/images/150adv_2.jpg')?>">
                    </div>
                     
                </div>
                </div> 
    </div>
             <!-- /. PAGE INNER  -->
            </div>
</div>
</div>
</div>
