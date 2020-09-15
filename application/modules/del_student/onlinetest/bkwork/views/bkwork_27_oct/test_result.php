<?php
    if(!isset($isProduct->id)){
           
           $products_id='';
       }else{
           $products_id=$isProduct->id;
       }
	   
	   $schoolid=$customer_info->schoolid;
       $showResult='yes';
       if(!$this->session->userdata('purchases') || !in_array_r($products_id,$this->session->userdata('purchases'))){
	   $showResult='no';
	   }
	   if($schoolid==1){
		  $showResult='yes'; 
	   }
       if($showResult=='no'){
                 ?>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb'); 
            ?>
            <div class="clearfix"></div>
            <!-- row well well-sm well-lg-->
    <div class="viewDownMsg">                   
    <div class="col-xs-12 col-md-12 text-center">
            <span class="ts-btn">
            <h3>In Order to view and download Result, Question paper, Answers-key, Solution and Analytical Reports <a href="<?php echo base_url('exams/'.url_title($examname,'-',TRUE).'/'.$exam_id)?>" ><button type="button" class=" btn-md btn btn-success btn-raised btn-lg">You Need To Buy This Series </button></a>.</h3>
              </span> 
    </div>
    </div>
                  <?php
                  /*
              if($isProduct_array){ 
          $this->load->view('common/product_testseries'); 
                 } else{ 
                     ?>
            <span class="ts-btn">
                             <a href="<?php echo base_url('exams/'.url_title($examname,'-',TRUE).'/'.$exam_id)?>" ><button type="button" class=" btn-md btn btn-success btn-raised btn-lg">You Need To Buy This Series </button></a>
             
              </span>    
                 <?php } */
            ?>
                
                 </div>
</div>
</div>   
            <?php
             }else{
$total_marks = $usertest_result_info->total_marks;
$obtain_marks = $usertest_result_info->obtain_marks;
$attampted_ques = $usertest_result_info->attampted_ques;
$not_attampted_qus = $usertest_result_info->not_attampted_qus;
$total_qus = $usertest_result_info->total_qus;
$correct_ans = $usertest_result_info->correct_ans;
$incorrect_ans = $usertest_result_info->incorrect_ans;
if ($usertest_result_info->time_remaining > 0) {
    $time_remaining = $usertest_result_info->time_remaining;
} else {
    $time_remaining = 0;
}
$time_taken = $usertest_result_info->time_taken;
$total_time = $usertest_result_info->total_time;
$reviewed_qus = $usertest_result_info->reviewed_qus;
$exam_date = $usertest_result_info->dt_created;
$testname = $usertest_result_info->name;
?>
<style>
  .error-notice {
  margin: 5px 5px; /* Making sure to keep some distance from all side */
}

.oaerror {
    width:100% !important;
}
.danger {
  border-left-color: #d9534f; /* Left side border color */
  background-color: rgba(217, 83, 79, 0.1); /* Same color as the left border with reduced alpha to 0.1 */
}

.danger strong {
  color:  #d9534f;
}

.warning {
  border-left-color: #f0ad4e;
  background-color: rgba(240, 173, 78, 0.1);
}

.warning strong {
  color: #f0ad4e;
}

.info {
  border-left-color: #5bc0de;
  background-color: rgba(91, 192, 222, 0.1);
}

.info strong {
  color: #5bc0de;
}

.success {
  border-left-color: #2b542c;
  background-color: rgba(43, 84, 44, 0.1);
}

.success strong {
  color: #2b542c;
}
h2 {
  text-align: center;
}

table caption {
	padding: .5em 0;
}

@media screen and (max-width: 767px) {
  table caption {
    border-bottom: 1px solid #ddd;
  }
}

.p {
  text-align: center;
  padding-top: 140px;
  font-size: 14px;
}
</style>
<script type="text/javascript" src="//www.google.com/jsapi"></script>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb'); 
$qus_pdf=$onlinetest_info->qus_pdf;
$ans_pdf=$onlinetest_info->ans_pdf;
$solution_pdf=$onlinetest_info->solution_pdf;
$pdf_file_path=$_SERVER['DOCUMENT_ROOT'].'/upload/pdfs/';

            ?>
            <div class="col-md-12 col-lg-12">
                
<?php 

if(isset($ot_filedetail->filename_one)&&$ot_filedetail->filename_one!=''){
    $common_pdf=$ot_filedetail->filename_one;
    $pdf_file_path_common=$ot_filedetail->filepath_one;
    ?><div class="panel panel-default" style="text-align : center;">
<ul class="nav nav-pills">
<?php 
$qus_pdf_count=strlen($common_pdf); 
if (($qus_pdf_count>4)&&is_readable(FCPATH.$pdf_file_path_common.$common_pdf)) {
               echo "<li><a class='btn btn-raised btn-lg btn-warning' href='".base_url('online-test/getresult/'.encrypt($common_pdf.'c-h-e-c-k'.$this->session->userdata('customer_id')))."' target='_blank'>Download Solution File</a></li>";
}
} 
?>
</ul>
</div><br>
<?php
if(($qus_pdf!=='')||($ans_pdf!=='')||($solution_pdf!=='')){ ?>
                
<div class="panel panel-default" style="text-align : center;">
<ul class="nav nav-pills">
<?php 
$qus_pdf_count=strlen($qus_pdf);
if (($qus_pdf_count>4)&&is_readable($pdf_file_path.$qus_pdf)) {
               echo "<li><a class='btn btn-raised btn-lg btn-warning' href='".base_url('online-test/getresult/'.encrypt($qus_pdf.'c-h-e-c-k'.$this->session->userdata('customer_id')))."' target='_blank'>Download Question File</a></li>";
}
$ans_pdf_count=strlen($ans_pdf);
 if (($ans_pdf_count>4)&&is_readable($pdf_file_path.$ans_pdf)) {              
               echo "<li><a class='btn btn-raised btn-lg btn-success'href='".base_url('online-test/getresult/'.encrypt($ans_pdf.'c-h-e-c-k'.$this->session->userdata('customer_id')))."' target='_blank'>Download Answer File</a></li>";
 }
$solution_pdf_count=strlen($solution_pdf);
 if (($solution_pdf_count>4)&&is_readable($pdf_file_path.$solution_pdf)) {
               echo "<li><a class='btn btn-raised btn-lg btn-info' href='".base_url('online-test/getresult/'.encrypt($solution_pdf.'c-h-e-c-k'.$this->session->userdata('customer_id')))."' target='_blank'>Download Solution File</a></li>";
 }
?>          
</ul>
</div><br>
<?php } 

 if(isset($existInGroup)&&count($existInGroup)>0){
?>
<div class="clearfix"></div>      
            <ul class="nav nav-tabs" role="tablist" ><li><h3><font color="white">Group Rank</font></h4></li>
			</ul>
<div class="clearfix"></div>   
<!--All india/Group wise ranking-->
<div class="panel panel-default" style="text-align : center;">
<ul class="nav nav-pills">

<table class="table table-responsive">
  <thead>
    <tr>
      <th scope="col">Rank <?php $studCount=count($usersOfGroup); 
	  if($studCount>0){
	  //echo 'Out Of '.$studCount;
	  }	  
	  
	  ?></th>
      <th scope="col">Student Name</th>
      <th scope="col">Obtain/Total Marks</th>
      <th scope="col">Time Taken(Min)</th> 
	  <th scope="col">Test Date</th> 
    </tr>
  </thead>
  <tbody>
<?php
$count=1;
//usort($array, 'sortByWeight');
							foreach($existInGroup as $groupKey=>$groupValue){
							if(count($groupValue)>0){
							$groupValueObj=$groupValue;
?>
    <tr <?php  if($count==1){  ?>class='oaerror success' <?php } ?>>
      <th scope="row"><?php  echo $count; if($count==1){  ?><i class="fa fa-trophy warning fa-7x" width="40px" height="40px"></i><?php } ?></th> 
      <th><?php echo $groupValueObj['fullname']; ?></th>
      <th><?php echo $groupValueObj['obtain_marks'].'/'.$groupValueObj['total_marks'];?></th>
      <th>
<?php 
if(isset($groupValueObj['time_taken'])&&$groupValueObj['time_taken']>0){
echo round($groupValueObj['time_taken'] / 60, 1); 
}else{
	echo '00:00';
}
?>
	  </th>
      <th><?php echo date('d-m-Y',$groupValueObj['dt_created']); ?></th>
    </tr>
<?php	
													
							$count++;
							}
							}
							?>


	  </tbody>
	  </table>
</div><br>
<!--End All india/Group wise ranking-->
<?php } ?>
<div class="clearfix"></div>      
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#overall" aria-controls="overall" role="tab" data-toggle="tab">
                        All Attempts
                    </a>
                </li>
                <li role="presentation">
                    <a href="#solution" aria-controls="solution" role="tab" data-toggle="tab">
                        Solution
                    </a>
                </li>
                <li role="presentation">
                    <a href="#student_result" aria-controls="student_result" role="tab" data-toggle="tab">
                        Your Answers
                    </a>
                </li>

            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="overall">
                    <div class="table-responsive">
                    <table class="table table-hover table-responsive">
                        <thead> 
                            <tr>
                                <td colspan="8" class="overAllScore">
                                    <h4>All Attempts</h4>
                                </td> <td colspan="8" class="overAllScore">
                                    <h4><a href="<?php echo base_url('online-test/attempts/'.$testid); ?>">Show Attempts in Chart<i class="material-icons">
bar_chart
</i></a></h4>
                                </td>
                            </tr>
                            <tr> 
                                <th>#</th> 
                                <th>Correct Ans</th> 
                                <th>Incorrect Ans</th> 
                                <th>Not Attempted</th> 
                                <th>Time Taken(Min)</th> 
                                <th>Score</th> 
								<th>Obtain Marks</th>
                                <th>Date</th> 
                                <th>Change</th> 
                            </tr> 
                        </thead>
                        <tbody>
                        <?php
						
                        $cc = 1; // Traverse result and generate report
                        $previous_score = 0;
                        foreach($attempts as $allrow) {
                            
                            //Solution for Division by zero.
                            if($allrow->obtain_marks>0){
                            $percentage=($allrow->obtain_marks / $allrow->total_marks)*100;
                            }else{
                            $percentage=NULL;    
                            }
                            $change = $previous_score - $percentage;
                        ?>
                        <tr>
                            <th><?php echo $cc; ?></th> 
                            <td><?php echo $allrow->correct_ans; ?></td> 
                            <td><?php echo $allrow->incorrect_ans; ?></td> 
                            <td><?php echo $allrow->not_attampted_qus; ?></td> 
                            <td><?php echo round($allrow->time_taken / 60, 1); ?></td> 
                            <td><?php echo round($percentage,2); ?>%</td> 
							<td><?php echo $allrow->obtain_marks.'/'.$allrow->total_marks; ?></td>
                            <td><?php echo date('d-m-Y',$allrow->dt_created); ?></td> 
                            <td><a href="<?php echo base_url('online-test/result/'.$allrow->id); ?>">
                            <?php if ($cc == 1) { ?>
                                <i class="fa fa-minus"></i>
                            <?php } else {
                                if ($change < 0) { ?>
                                <span style="color:green">
                                <i class="fa fa-arrow-up"></i>
                                <?php echo round(abs($change),2); ?>
                                </span>
                                <?php } elseif ($change > 0) { ?>
                                <span style="color:red">
                                    <i class="fa fa-arrow-down"></i>
                                    <?php echo round(abs($change),2); ?>
                                </span>
                                <?php } elseif ($change == 0) { ?>
                                <span style="color:orange">
                                <i class="fa fa-arrows-h"></i>
                                No Change
                                </span>	
                                <?php  }   }  ?> Click Here</a>
                            </td> 
                        </tr>
                        <?php
                        $previous_score = $percentage;
                        $cc++;
                        } ?>
                    </tbody>
                </table>
            </div>
		        <div class="col-md-12" style="border: 1px solid #ccc;">    
                <div class="col-xs-12 col-md-4 nopadding">
                <script type="text/javascript">
                    google.load("visualization", "1", {packages: ["corechart"]});
                    google.setOnLoadCallback(drawChart);
                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['Questios', 'Count'],
                        ['Correct', <?php echo $correct_ans; ?>],
                        ['Incorrect',<?php echo $incorrect_ans; ?>],
                        ['Not Attempted', <?php echo $not_attampted_qus; ?>]
                    ]);
                    var options = {
                        title: 'Overall Summary',
                        'width': 320,
                        'height': 371,
                        legend: {position: 'top', alignment: 'start'},
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                        chart.draw(data, options);
                        }
                </script>
                <div id="piechart"></div>
                </div>
                <div class="col-md-12 col-md-8 nopadding"  style="min-height: 375px;border-left:solid 1px #ccc;">
                    <div class="row  col-md-12">
                        <div class="col-sm-4">
                            <h4><p class="overAllScore">Overall Score  :  <?php
                            //Solution for dividion by zero.
                            if($obtain_marks>0){
                            echo round(($obtain_marks/$total_marks)*100,2); }else{
							echo '0';
							}
                            ?>%
                                
                                </p></h4>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            
                        </div><!--
                        <div class="col-sm-4"><p class="overAllRank">03/214</p><p>Rank</p></div>
                        <div class="col-sm-4"><p class="overAllPercentile">00,00%</p><p>Percentile</p></div>-->
                    </div>
                    <div class="row col-md-12">
                        <div class="col-xs-10 col-xs-offset-1">
                            <div class="row">
                                <div class="col-sm-4">
                                    <p>CORRECT ANSWERS</p>
                                </div>
                                <div class="col-sm-7">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $correct_ans; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalquestions;?>" style="width: <?php echo ($correct_ans/$totalquestions)*100; ?>%">
                                    <span class="sr-only"><?php echo ($correct_ans/$totalquestions)*100; ?>% Complete (success)</span>
                                    </div>
                                    </div>
                                   
                                </div>
                                <div class="col-sm-1">
                                    <p><?php echo $correct_ans; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><p>INCORRECT ANSWERS</p></div>        
                                    <div class="col-sm-7">
                                        <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $incorrect_ans; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalquestions;?>" style="width: <?php echo ($incorrect_ans/$totalquestions)*100; ?>%">
                                    <span class="sr-only"><?php echo ($incorrect_ans/$totalquestions)*100; ?>% Complete (success)</span>
                                    </div>
                                    </div>          
                                    </div>
                                    <div class="col-sm-1">
                                        <p><?php echo $incorrect_ans; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><p>NOT ATTEMPTED</p></div>        
                                <div class="col-sm-7">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $not_attampted_qus; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalquestions;?>" style="width: <?php echo ($not_attampted_qus/$totalquestions)*100; ?>%">
                                    <span class="sr-only"><?php echo ($not_attampted_qus/$totalquestions)*100; ?>% Complete (success)</span>
                                    </div>
                                    </div>           
                                </div>
                                <div class="col-sm-1">
                                    <p><?php echo $not_attampted_qus; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><p>TIME TAKEN</p></div>        
                                <div class="col-sm-7">
									<?php
									
									if(isset($usertest_result_info->time_taken)&&$usertest_result_info->time_taken>0){
									$result_time_taken=$usertest_result_info->time_taken;	
									}else{
									$result_time_taken=1;	
									}
									
									if(isset($usertest_result_info->time_remaining)&&$usertest_result_info->time_remaining>0){
									$result_time_remaining=$usertest_result_info->time_remaining;	
									}else{
									$result_time_remaining=1;	
									}
									?>
                                   <div class="progress">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $result_time_taken; ?>" aria-valuemin="0" aria-valuemax="<?php echo $result_time_taken+$result_time_remaining;?>" style="width: <?php echo ($result_time_taken/($result_time_taken+$result_time_remaining))*100; ?>%">
                                    <span class="sr-only"><?php echo ($result_time_taken/($result_time_taken+$result_time_remaining))*100; ?>% Complete (success)</span>
                                    <span class="sr-only"><?php echo ($result_time_taken/($result_time_taken+$result_time_remaining))*100; ?>% Complete (success)</span>
                                    </div>
                                    </div>     
                                </div>
                                <div class="col-sm-1">
                                <p>
                                <?php
                                    $seconds_taken_to_compleet_exam = (int)$time_taken;
                                    echo gmdate('H:i:s', $seconds_taken_to_compleet_exam);
                                ?>
                                </p>
                                </div>
                            </div>
                            <p>&nbsp;</p>
                            <div class="row" style="font-weight: bold;">
                    <div class="col-sm-6 summary">
                        <p class="timeTaken">
                            TOTAL TIME = <span><?php
                            echo gmdate("H:i:s",$total_time); //$exam_alloted_exam_time; ?>
                            </span> 
                        </p>
                    </div>
                    <div class="col-sm-6 summary">
                        <p>TOTAL QUESTIONS = <span class="highlight"><?php echo $total_qus; ?>
                                                            </span>
                        </p>
                    </div>
                    </div>
                        </div>
                    </div>	 
                        <?php $exam_alloted_exam_time = $total_time/60;
						?>
                </div>
                </div>
                    <p>&nbsp;</p>
                    <div class="col-md-12 text-center" style="border: 1px solid #ccc; " >
                        <?php 
                        //print_r($sections);
                        $cc=0;foreach($sections as$k=>$v){ ?>
                        <?php $secion_total=$v['correct']+$v['incorrect']+$v['not_attempted'];
                        $total_marks=$secion_total*$usertest_result_info->right_answer_marks;
                        $right_answer_marks = $usertest_result_info->right_answer_marks;
                        $wrong_answer_marks = $usertest_result_info->wrong_answer_marks;
                        $score = ($right_answer_marks * $v['correct']) - ($wrong_answer_marks * $v['incorrect']);
                        ?>
                        <div class="col-md-4 text-center" style="padding-top: 10px;<?php if($cc==1){ echo 'border-left: 1px solid #ccc;border-right: 1px solid #ccc;';}?>">
                            <b><div class="col-xs-8"><p><?php echo $k; ?></p></div>
                            <div class="col-xs-4">
                                <p class="subjectScoreValue text-center">Score : 
                                <?php   
                                    //echo ($score/$total_marks)*100;
                                    echo $score;
                                ?>
                                </p>
                                
                            </div>
                            <div class="col-md-12 text-center">
                                <div id="section_<?php  echo strtolower($k)?>" class="text-center"></div>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="col-sm-4 nopadding">
                                    <p>Correct Answers</p>
                                </div>
                                <div class="col-sm-6 nopadding">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $v['correct']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $secion_total;?>" style="width: <?php echo ($v['correct']/$secion_total)*100; ?>%">
                                            <span class="sr-only"><?php echo ($v['correct']/$secion_total)*100; ?>% Complete (success)</span>
                                        </div>
                                    </div>                                   
                                </div>
                                <div class="col-sm-1 nopadding pull-right">
                                    <p><?php echo $v['correct']; ?></p>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="col-sm-4 nopadding">
                                    <p>Incorrect Answers</p>
                                </div>
                                <div class="col-sm-6 nopadding">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $v['incorrect']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $secion_total;?>" style="width: <?php echo ($v['incorrect']/$secion_total)*100; ?>%">
                                            <span class="sr-only"><?php echo ($v['incorrect']/$secion_total)*100; ?>% Complete (success)</span>
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="col-sm-1 nopadding pull-right">
                                    <p><?php echo $v['incorrect']; ?></p>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="col-sm-4 nopadding">
                                    <p>Not Attempted</p>
                                </div>
                                <div class="col-sm-6 nopadding">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $v['not_attempted']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $secion_total;?>" style="width: <?php echo ($v['not_attempted']/$secion_total)*100; ?>%">
                                            <span class="sr-only"><?php echo ($v['not_attempted']/$secion_total)*100; ?>% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1 nopadding pull-right">
                                    <p><?php echo $v['not_attempted']; ?></p>
                                </div>
                            </div>
                            <div class="col-md-12 " style="border-top:1px solid #ccc; padding: 20px;">
                                <div class="col-sm-6">
                                    Total Questions 
                                </div>
                                <div class="col-sm-6">
                                    <?php echo count($v['questions']);?> 
                                </div>
                            </div>
                            <div class="col-md-12" style="border-top:1px solid #ccc;padding: 20px;">
                                <div class="col-sm-6">
                                    Time Taken 
                                </div>
                                <div class="col-sm-6">
                                    <?php echo gmdate("H:i:s", (int)$v['timetaken']);?> 
                                </div>
                            </div>    
                           </b>
                       
                        </div>
                    
                
                        <script type="text/javascript">

                                                google.setOnLoadCallback(drawChart<?php echo strtolower($k) ?>);
                                                function drawChart<?php echo  strtolower($k); ?>() {

                                                    var data = google.visualization.arrayToDataTable([
                                                        ['Questios', 'Count'],
                                                        ['Correct', <?php echo $v['correct']; ?>],
                                                        ['Incorrect',<?php echo $v['incorrect'] ?>],
                                                        ['Not Attempted',<?php echo $v['not_attempted'] ?>]
                                                    ]);

                                                    var options = {
                                                        'width': 260,
                                                        'height': 350,
                                                        legend: {position: 'top', alignment: 'start'},
                                                    };

                                                    var chart = new google.visualization.PieChart(document.getElementById('section_<?php echo strtolower($k);?>'));

                                                    chart.draw(data, options);
                                                }
                                            </script>
                        <?php $cc++; } ?>
                    </div>
                </div>
             
                <div role="tabpanel" class="tab-pane" id="solution">
                    <?php foreach($sections as $key=>$value){ ?>
                    <div class="col-md-12">
                        <h4><?php echo $key;?></h4>
                        <?php $cc=1;foreach($value['questions'] as $key1=>$value1){ ?>
                        <div class="oaerror <?php if($value1['answered_correctly']==1){ echo 'success'; }elseif($value1['answered_correctly']==2){ echo 'warning';}elseif($value1['answered_correctly']==0){ echo 'danger';}?>">
                            <strong><?php echo $cc;?>) &nbsp;</strong>
                            
                                <?php echo $value1['question'];?>
                            <p>&nbsp;</p>
                            <p>Answers: </p>
                            <?php $t='A';foreach($value1['answers'] as $answer){ 
                                
                              if($answer->is_correct==1){
                                  $textSuccess ='class="text text-success"'; 
                              }else{ 
                                  $textSuccess =''; 
                              }
                                ?>
                            <p <?php echo $textSuccess; ?> >
                     <B><?php echo $t;?>) &nbsp;</B><?php echo $answer->answer?>
                    </p>
                        <?php if(isset($answer->description)&&$answer->description!=''){ ?>
                        <p <?php echo $textSuccess; ?>>
						</p><br><div>EXPLANATION:-<?php echo $answer->description; ?></div>
                        <?php } $t++;} ?>
                        </div>
                        <?php $cc++;} ?>
                    </div>
                    <?php } ?>
                </div>
                
                <div role="tabpanel" class="tab-pane" id="student_result">
                    <h2>Your Answers</h2>

<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">
        <table summary="This table shows Your Assesment on Test Given." class="table table-bordered table-hover">
          <!--
          <caption class="text-center">An example of a responsive table based on</caption>
          -->
          <?php
//print_r($sections); ?>
          <thead>
            <tr>
              <th>Question Number</th>
              <th>Correct Answer</th>
              <th>Your Answer</th>
              <th>Time Taken</th>
              <th>Question Type</th>
            </tr>
          </thead>
        
              <?php
              $sec_q=1;
              foreach($sections as $key=>$value){ 
              ?>
            <tbody> 
                  
            <tr>
                        <td colspan="5"> <h4><?php echo $key;?></h4></td>
            </tr>
                <?php
                   $ucc=1;
                   foreach($value['questions'] as $key1=>$value1){
                ?>
            <tr class="oaerror <?php if($value1['answered_correctly']==1){ echo 'success'; }elseif($value1['answered_correctly']==2){ echo 'warning';}elseif($value1['answered_correctly']==0){ echo 'danger';}?>">
                <td><!--<a href="<?php //echo base_url('online-test').'/question_detail/'.$testid.'/'.$value1['question_id']?>"></a>-->Question <?php echo $ucc.')' .$value1['question']; ?></td>
              <td><?php $t='A';foreach($value1['answers'] as $answer){ 
                   if($answer->is_correct==1){
                  ?>
                            <p>
                            <div <?php if($answer->is_correct==1){ echo 'class="text text-success"';}?>><strong><?php echo $t;?>) &nbsp;</strong><?php  echo $answer->answer;  ?> </div>
                        </p>
                   <?php } $t++;}
                            ?></td>
              <td><?php 
			  
              if(isset($value1['your_answer'])){
              foreach($value1['your_answer'] as $ansnumber=>$useranswer){
                  ?><p>
                            <div>
                            <strong><?php echo $ansnumber;?>) &nbsp;</strong><?php echo $useranswer?></div>
                        </p>
                   <?php  }
              }else{
                  echo "NA";
              }
                           
//echo $answer->your_answer
              ?>
              </td>
              <td><?php      if(isset($value1['per_qus_time'])){ echo $value1['per_qus_time']; } else{ echo "NA"; } ?></td>
              <td><?php       if(isset($value1['question_type'])){ echo $value1['question_type']; } else{ echo "NA"; }?></td>
            </tr>
            
                   <?php   $ucc++;}
                    ?>  </tbody><?php
                  
                  $sec_q++; } ?>
          
          <!--<tfoot>
            <tr>
              <td colspan="5" class="text-center">Data retrieved from <a href="http://www.infoplease.com/ipa/A0855611.html" target="_blank">infoplease</a> and <a href="http://www.worldometers.info/world-population/population-by-country/" target="_blank">worldometers</a>.</td>
            </tr>
          </tfoot>
          -->
        </table>
      </div>
      <!--end of .table-responsive-->
    </div>
  </div>
</div>

<!--<p class="p">Demo by George Martsoukos. <a href="http://www.sitepoint.com/responsive-data-tables-comprehensive-list-solutions" target="_blank">See article</a>.</p>
-->
                </div>
  </div>


                
            </div>
            
        </div>
    </div>
</div>
</div>
             <?php } ?>