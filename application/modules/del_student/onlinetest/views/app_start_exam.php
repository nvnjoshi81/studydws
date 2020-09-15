<?php
if (($customer_id == '') || ($customer_id < 1)) {
        $this->session->set_userdata('customer_id', $customer_id);
        $customer_id=$this->session->userdata('customer_id');
        }        
        $this->session->unset_userdata('exam_id');
        $this->session->unset_userdata('subject_id');
        $this->session->unset_userdata('chapter_id');
        $this->session->unset_userdata('total_time');
        $this->session->unset_userdata('current_user_id');
        $this->session->unset_userdata('current_exam_timestamp');
        $this->session->unset_userdata('ts'); 
        $usertest_session_value=$this->session->userdata('usertest_id');
        $onlinetest_id=$this->session->userdata('onlinetest_id');
        if(isset($usertest_session_value)){
            if(isset($usertest_info[0]->id)){
            $resultUrl=base_url('apponline-test/examname/all/all/testname/'.$onlinetest_id.'/'.$customer_id);
            
        $this->session->unset_userdata('onlinetest_id');
        $this->session->unset_userdata('usertest_id');
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
    //print_r($onlinetestinfo);
    
$timeresult = secondsToTime($onlinetestinfo->time); 
        $testname_array=explode('-', $testname);
            $testname_string=implode(' ', $testname_array);
            $showtestname = ucwords($testname_string);
            
     
?>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="heading-bar"><h2><?php echo $showtestname; ?></h2></div>
             <?php
             //$this->load->view('common/breadcrumb');?>
    <div class="col-md-12 col-sm-12 onlinetestbody">
            <div id="page-inner">
                <div class="module_panel row">  
                <div class="col-sm-8 col-md-8">                
                <!-- content panel start here -->
                <div class="col-sm-12 col-md-12 online_btn_test">
                <div class="col-sm-6 col-md-6">
              <?php             
        $customer_id = $appcid;
        if(!isset($customer_id)&&($customer_id=='')){
            ?>
                    <span class="ts-btn">
              <a href="<?php echo base_url('login')?>" >
                  <button type="button" class=" btn-md btn btn-success btn-raised btn-lg searchgo">Login to Start Test</button>
              </a>
              </span>
        <?php  }else{
           ?>
<a href="<?php echo base_url('apponline-test/'.$exam_id.'/'.$subject_id.'/'.$chapter_id.'/'.$onlinetest_id.'/'.$total_time.'/'.$total_question.'/'.$formula_id.'/'.$customer_id)?>" >
                  <button type="button" class=" btn-md btn btn-success btn-raised btn-lg searchgo">Start Test</button>
              </a>
        <?php
        }
        ?>
        </div>
        <div class="col-sm-6 col-md-6 text-right"> <label class="btn btn-sm btn-primary btn-simple" id="0">
               <font size='3px'>Total Time -<?php echo $timeresult['h'].':'.$timeresult['m'].':'.$timeresult['s']; ?>
               </font>
               <!--Test Type -<?php //echo $onlinetestinfo->type; ?>-->
                      </label>
                    </div>
                      
        </div>  
                  <div class="col-sm-12 col-md-12 instruct_panel">
                  <?php if(isset($onlinetestinfo->instructions)&&$onlinetestinfo->instructions!=''){ ?>
                  <div class="panel panel-success">
                	<div class="panel-heading">
                 	 <h4><i class="material-icons">folder</i>Instructions </h4>
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
      <li>The clock is set at the server. The countdown timer in the top right corner of screen will display the remaining time available for you to complete the exam. When the timer reaches zero, test will automatically get submitted, you will not be required to end or submit your exam. In case you finish exam before the timer reaches zero you can choose to press submit button to end the exam.
</li>
<li>In case your test is paused when you lose internet connectivity or power off you need to log in again and start fresh test.
</li>
<li>Please note all questions will appear in English language only.
</li>
<li>The Question Palette displayed on the right side of screen will show the status of each question using one of the following symbols:<br>
<span class="badge" id="static_link_245473">Q.No.
                                                </span>
You have not visited the question yet.<br>
<span class="badge badge-info" id="static_link_245477">Q.No.
                                               </span>
You have not answered the question.<br>
<span class="badge badge-success" id="static_link_245474">Q.No.
                                               </span>
You have answered the question.<br>
<span class="badge badge-warning" id="static_link_245475">Q.No.
                                              </span>
You have marked the question for review.
</li>
<li>The marked for review status for a question simply indicates that you would like to look at that question again. If a question is answered and marked for review, your answer for that question will be considered in the evaluation after you submit the exam or the timer reaches zero.</li>
    </ul>  
      </div>
    </div>
  </div>
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
    <!--
    <li>To answer a question, do the following:<ul>
    <li>        
    </li>
    <li>        
    </li></ul>       
    </li>-->
</ul>
      </div>
    </div>
  </div>
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
                         }else{
                             echo "<p>Instructions not available!</p>";
                             
                         }
                         ?>
      </div>
    </div>
  </div>
</div>
                        
                        
                        
                        
                        
                        
                        
                        
                	</div>
                  </div>
                <?php
                      } 
?> 
</div> 
                  
                 <?php if(isset($customer_id)&&($customer_id!='')){ ?> 
                  <div class="col-sm-12 col-md-12">
                  <div class="panel panel-success">
                  <div class="panel-heading">
                 	 <h4><i class="material-icons">folder</i> Test Attempted By Me </h4>
                     </div>
                     <ul class="row startexampanel">
<?php 

foreach($usertest_info as $testvalue){
   // echo "<li class='col-xs-12 col-sm-6 col-md-6'><i class='material-icons'>update</i>  <a href='".base_url('online-test/result/'.$testvalue->id)."' >".$testvalue->name."</a></li>";
    echo "<li class='col-xs-12 col-sm-6 col-md-6'><i class='material-icons'>update</i>  <a href='".base_url('apponline-test/userresult/'.$testvalue->id)."' >".$testvalue->name."</a></li>";
}
?>
                  </ul>                  </div>
                  </div>   
                 <?php } ?>  
                  </div> 
                </div> 
    </div>
             <!-- /. PAGE INNER  -->
            </div>
</div>
</div>
</div>
