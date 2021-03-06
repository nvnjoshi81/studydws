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
if(isset($soldetails->language)&&$soldetails->language=='hindi') {
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
          <?php  $sections_cnt=count($questiontypes);  
          if($sections_cnt>1){
          ?> <!--btn-group-vertical-->
                  <div class="col-md-12 col-sm-12 "><div class="btn-group ques_mate_panel filter-button-group button-group rht_sorting_panel">
          <?php foreach($questiontypes as $qtype){   ?>
             <button class="btn app_btn" data-filter=".page_<?php echo url_title($qtype->typeid,'',TRUE)?>"><i class="material-icons">play_arrow</i>Page <?php echo $qtype->typeid;?></button>
          <?php } ?>
          <?php if(count($exmeplar_questions) > 1){ ?>
             <button class="btn app_btn" data-filter=".page_exemplar"><i class="material-icons">play_arrow</i>Exemplar</button> 
          <?php } ?>
               <?php if(count($questiontypes) > 1){ ?>
             <button class="btn app_btn" data-filter=".element-item"><i class="material-icons">play_arrow</i>All</button>
             <?php } ?>
                      </div></div>
          <?php } ?>
        <!-- fluid pandl -->
        <div class="col-md-12">
         <!--<div class="question_panel_lft">
             <h3 class="panel-title"><i class="material-icons">done</i> <?php echo $soldetails->name;?>
                 <?php if(isset($linktostudypackage)){ ?>
                 <span><a href="<?php echo $linktostudypackage;?>" style="text-decoration: none;color:#15760C;font-size:17px  ">[Download Complete Solution]</a></span>
                 <?php } ?>
             </h3>
        </div>
		-->
          <div class="question_panel_lft">
            <ul class="grid">
            <?php $count=1;foreach($questions as $question){  ?>
                <li  class="element-item page_<?php echo $question->filter;?>" >
                    <<p> <div <?php echo $hindicss_number_q ;?> ><a  href="#"><i class="material-icons">question_answer</i><?php echo $count;?>) </div> <div <?php echo $hindicss.' '.$hindicss_text ;?> > <?php //echo  iconv('UTF-8', 'ASCII//TRANSLIT',custom_strip_tags($question->question));
                    echo custom_strip_tags($question->question); 
                    ?> </a></div></p>
                <?php $answers=$this->Questions_model->answers($question->id);
                if(count($answers) > 1){ 
                    $letters = range('A', 'Z');
                    $ac=0;
                    foreach($answers as $answer){
                        
                        if(isset($question->type)){
                        $questions_type=$question->type;
                    }else{
                        $questions_type=NULL;
                    }
                        ?><p><?php echo $letters[$ac]?>) <?php if($questions_type=='Single Choice'){ ?><span><input onclick="checkSingleQus('<?php echo $answer->id; ?>','<?php echo $answer->is_correct; ?>')" type="radio" value="" name="q_opt" id="q_opt_<?php echo $answer->id; ?>"></span> <?php }  echo custom_strip_tags($answer->answer); ?><span class="ansblock"> <i id="ansright_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:green;font-size: 22px; font-weight: bolder;  margin-bottom: 2px;" >done</i>
        <i id="answrong_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:red; font-size: 22px; font-weight: bolder; margin-bottom: 2px;" >clear</i> </span></p><?php  if($answer->is_correct==1){  
                        $correctAns[$answer->id]=$letters[$ac];
                        }
                    $ac++;
                    }  
                    } 
                ?>
                <!--Added _q to show question id on next page-->
                <span class="pull-right view_ans"><a href="<?php echo base_url('ncert-solution').'/'.url_title($soldetails->name,'-',TRUE).'-appapi_q'.$count.'_'.$urlcustid.'/'.$soldetails->id.'/'.$question->id; ?>" >View Answer<i class="material-icons">play_arrow</i> </a></span>
		
              </li>
            <?php $count++;} ?>
              <?php if(count($exmeplar_questions) > 0){ 
                    foreach($exmeplar_questions as $question){?>
                    <li  class="element-item page_exemplar" >
                        <p> <a  href="#"><i class="material-icons">question_answer</i><?php echo $count;?>) <?php echo custom_strip_tags($question->question);?> </a></p>
                        <span class="pull-right view_ans"><a href="<?php echo base_url('ncert-solution').'/'.url_title($soldetails->name,'-',TRUE).'-appapi_q'.$count.'/'.$soldetails->id.'/'.$question->id; ?>">View Answer <i class="material-icons">play_arrow</i> </a></span>
                    </li>
                    <?php $count++; } } ?>
            </ul> 
          </div>
            <!-- next prev panel -->
        </div>
        <div class="clearfix"></div> 
 </section>
    </div>
  </div>
</div>



