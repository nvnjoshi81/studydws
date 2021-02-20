<?php
$regex = <<<'END'
/
  (
    (?: [\x00-\x7F]               # single-byte sequences   0xxxxxxx
    |   [\xC0-\xDF][\x80-\xBF]    # double-byte sequences   110xxxxx 10xxxxxx
    |   [\xE0-\xEF][\x80-\xBF]{2} # triple-byte sequences   1110xxxx 10xxxxxx * 2
    |   [\xF0-\xF7][\x80-\xBF]{3} # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
    ){1,100}                      # ...one or more times
  )
| ( [\x80-\xBF] )                 # invalid byte in range 10000000 - 10111111
| ( [\xC0-\xFF] )                 # invalid byte in range 11000000 - 11111111
/x
END;
function utf8replacer($captures) {
  if ($captures[1] != "") {
    // Valid byte sequence. Return unmodified.
    return $captures[1];
  }
  elseif ($captures[2] != "") {
    // Invalid byte of the form 10xxxxxx.
    // Encode as 11000010 10xxxxxx.
    return "\xC2".$captures[2];
  }
  else {
    // Invalid byte of the form 11xxxxxx.
    // Encode as 11000011 10xxxxxx.
    return "\xC3".chr(ord($captures[3])-64);
  }
}
	  if(isset($qbdetails->language)&&$qbdetails->language=='hindi'){
$hindicss='class="hindifont"';
$hindicss_number_q='class="hindicss_number_q"';
$hindicss_number_a='class="hindicss_number_a"';
$hindicss_text='class="hindicss_text"';
}
?>

<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php //$this->load->view('common/breadcrumb');?>
     
      
      <!-- /. PAGE INNER  -->
      <div class="clearfix"></div>
      <section class="question_fluid"  data-js-module="filtering-demo">
     
          
          <?php 
          $sections_cnt=count($questiontypes); 
          if($sections_cnt>1){
          ?>
                  <div class="col-md-12 col-sm-12 ">  
        <div class="btn-group ques_mate_panel button-group  ">
          <?php foreach($questiontypes as $qtype){   ?>
             <button class="btn app_btn" data-filter=".<?php echo url_title($qtype->typename,'',TRUE)?>"><i class="material-icons">play_arrow</i><?php echo ucwords($qtype->typename);?></button>
          <?php } ?>
             <button class="btn app_btn" data-filter=".element-item"><i class="material-icons">play_arrow</i>All..</button>
          
        </div>
        </div>
          <?php } ?>  
        <!-- fluid pandl -->
        <!--<div class="col-md-12 col-sm-12">
         <div class="question_panel_lft">
          <h3 class="panel-title"><i class="material-icons">done</i> <?php //echo $qbdetails->name;?></h3>
        </div>-->
        <?php
		
			if(isset($questions)&&count($questions)>0){
		?>
         <div class="question_panel_lft">
                <ul class="grid">
            <?php $count=1;foreach($questions as $question){  ?>
                <li  class="element-item <?php echo url_title($question->type,'', TRUE)?>" >
                    <p> <a  href="#"><i class="material-icons">question_answer</i><?php echo $count;?>) <span  <?php echo $hindicss ; ?>><?php echo  custom_strip_tags($question->question);?></span></a></p>
                   
                <?php 
                $answers=$this->Questions_model->answers($question->id);
                if(count($answers) > 1){  
                    $correctAns=array();
                    $letters = range('A', 'Z');
                    $ac=0;
                    foreach($answers as $answer){
                        if(isset($question->type)){
                        $questions_type=$question->type;
                    }else{
                        $questions_type=NULL;
                    }
                        ?><p><?php echo $letters[$ac]?>) <?php if($questions_type=='Single Choice'){ ?><span><input onclick="checkSingleQus('<?php echo $answer->id; ?>','<?php echo $answer->is_correct; ?>')" type="radio" value="" name="q_opt" id="q_opt_<?php echo $answer->id; ?>"></span> <?php } ?>
						<span  <?php echo $hindicss ; ?>>
<?php						
						echo custom_strip_tags($answer->answer);   ?> 
						</span>						
						<span class="ansblock"> <i id="ansright_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:green;font-size: 22px; font-weight: bolder;  margin-bottom: 2px;" >done</i>
        <i id="answrong_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:red; font-size: 22px; font-weight: bolder; margin-bottom: 2px;" >clear</i> </span></p><?php
                         if($answer->is_correct==1){  
                        $correctAns[$answer->id]=$letters[$ac];
                        }
                    $ac++;
                    } ?>
                   
                <?php }
                ?>
                         <span class="pull-right view_ans"><a href="<?php echo base_url('question-bank').'/'.url_title($qbdetails->name,'-',TRUE).'-appapi_q'.$count.'/'.$qbdetails->id.'/'.$question->id;?>" >View Solution <i class="material-icons">play_arrow</i> </a></span>
						 
						 
         <!--onclick="showHideans(<?php //echo $count; ?>)" <div id="ansBlock_<?php //echo $count; ?>" style="display:none;">  
                        <?php 
                        //if(count($answers) > 1){ 
                           ?>
                  <div class="col-md-12">
                  <p class="ans_panel"><strong class="text-success">Correct Answer: </strong>
                  <?php //echo implode(' , ', $correctAns); ?></p>
                   <?php //foreach($answers as $answer){ ?>
                     <?php //echo $answer->is_correct==1 ? $correctAns[$answer->id]:''; ?>
                      
                      <?php //if($answer->description){ ?>
                          <p class="ans_panel"><strong class="text-success">Solution : </strong></p>
                          <?php // iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->description));
                          //echo custom_strip_tags($answer->description); 
                          ?>
                      <?php //}
                     // } ?>
                  </div>  
                      
                  <?php //}else{ ?>
                  <p class="ans_panel"><strong class="text-success">Answer: </strong> </p>
                    <p> <?php //foreach($answers as $answer){ ?>
                     <?php //echo  custom_strip_tags($answer->answer);?><br>
                      <?php// } ?>
                    </p>
                  <?php //} ?> 
                    </div>-->
              </li>
            <?php $count++;} ?>
              
            </ul>
          
          </div>  
 <?php }else{
	?>
				<div class="question_panel_lft">
          <h3 class="panel-title"><i class="material-icons">done</i>Vist Again We Are Uploading Content.!!</h3>
        </div>
				<?php
	 
 } ?>
        </div>
    
        
        <div class="clearfix"></div> 
     
        </div>-->
        
        
      </section>
    </div>
  </div>
</div>



