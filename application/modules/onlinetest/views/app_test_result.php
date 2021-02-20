<?php
/*For My Solution in Android App*/
    if(!isset($isProduct->id)){           
           $products_id='';
       }else{
           $products_id=$isProduct->id;
       }
if(isset($usertest_result_info)&&count($usertest_result_info)>0){
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
$qus_pdf=$onlinetest_info->qus_pdf;
$ans_pdf=$onlinetest_info->ans_pdf;
$solution_pdf=$onlinetest_info->solution_pdf;
}
?>
<style>
    .error-notice {
  //margin: 5px 5px; /* Making sure to keep some distance from all side */
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
.app_word_wrap{
    word-wrap: inherit;
}
</style>
<script type="text/javascript" src="//www.google.com/jsapi"></script>
        <div class="row">
            <?php //$this->load->view('common/breadcrumb'); 

$pdf_file_path=$_SERVER['DOCUMENT_ROOT'].'/upload/pdfs/';
            ?>
<div class="col-md-6 col-lg-12 col-sm-3 app_word_wrap">
                <div>
                    <?php 
					if(count($sections)>1){
					foreach($sections as $key=>$value){ ?>
                    <div>
                        <h4><?php echo $key;?></h4>
                        <?php $cc=1;foreach($value['questions'] as $key1=>$value1){ ?>
                        <div class="oaerror <?php if($value1['answered_correctly']==1){ echo 'success'; }elseif($value1['answered_correctly']==2){ echo 'success';}elseif($value1['answered_correctly']==0){ echo 'success';}?>">
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
                    <p>&nbsp;</p>
                        <?php if(isset($answer->description)&&$answer->description!=''){ ?>
                        <p <?php echo $textSuccess; ?> >EXPLANATION:</p><div><?php echo $answer->description; ?></div>
                        <?php } $t++;} ?>
                        </div>
                        <?php $cc++;} ?>
                    </div>
                    <?php }} ?>
                </div>
   </div>
            
        </div>
</div>