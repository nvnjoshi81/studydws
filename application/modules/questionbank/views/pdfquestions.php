<style> 
    /*.question_panel_pdf{} .question_panel_pdf ul{list-style-type:none;margin:1;padding:1;}*/

.question_panel_pdf h3 {
    padding: 1px;
    background: #ff5722;
    font-size: 18px;
    color: #fff;
    font-weight: 600
}.question_panel_pdf h3 i {
    color: #fff;
    font-size: 21px
}
.question_panel_pdf .view_ans i {
    color: #f60;
    margin: 0;
    padding: 0
}

.question_panel_pdf ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    min-height: 500px;
    max-height: 900px;
}

.question_panel_pdf ul li {
    list-style-type: none;
    border-bottom: solid 1px #009688;
    padding: 10px 0;
    margin: 0;
    display: block;
    font-weight: 700;
    width: 100%;
    position: static!important;
}


.question_panel_pdf ul li:last-child {
    border-bottom: 0
}

.question_panel_pdf ul li i {
    color: #4caf50;
    font-size: 18px;
    margin: 0 10px 0 0
}

.question_panel_pdf ul li p {
    font-weight: 400;
    font-size: 17px
}

.question_panel_pdf ul li p a {
    color: #000;
    font-weight: 400
}




</style>
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
?>	
<div id="contentpd" style="font-size:21px;">
<div id="wrapper">
    <form action="https://pdfcrowd.com/url_to_pdf/?pdf_name=studyadda.pdf" name="dwnpage" id="dwnpage">
    <input type="submit" name="pdfdownload" value="Download PDF" class="btn btn-raised btn-success btn-sm btn-md">
    </form>
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
                  <div class="col-md-12 col-sm-12 col-lg-12">  
        <div class="btn-group ques_mate_panel button-group  ">
          <?php foreach($questiontypes as $qtype){   ?>
             <button class="btn btn-raised btn-success" data-filter=".<?php echo url_title($qtype->typename,'',TRUE)?>"><i class="material-icons">play_arrow</i><?php echo ucwords($qtype->typename);?></button>
          <?php } ?>
             <button class="btn btn-raised btn-success " data-filter=".element-item"><i class="material-icons">play_arrow</i>All..</button>
          
        </div>
        </div>
          <?php } ?>  
        <!-- fluid pandl -->
        <div class="col-md-12 col-sm-12 col-lg-12">
         <div class="question_panel_pdf">
          <h3 class="panel-title"><?php echo $qbdetails->name;?></h3>
        </div>
        
         <div class="question_panel_pdf">
                <ul class="grid">
            <?php $count=1;foreach($questions as $question){  
            ?>
                <li  class="element-item <?php echo url_title($question->type,'', TRUE)?>" >
                    <p> <a href="#"><?php echo $count;?>) <?php echo  iconv('UTF-8', 'ASCII//TRANSLIT',custom_strip_tags($question->question));?> </a></p>
                   
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
                        ?><p><?php echo $letters[$ac]?>) <?php echo iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->answer));   ?> <span class="ansblock"> <i id="ansright_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:green;font-size: 22px; font-weight: bolder;  margin-bottom: 2px;" >done</i>
        <i id="answrong_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:red; font-size: 22px; font-weight: bolder; margin-bottom: 2px;" >clear</i> </span></p><?php
                         if($answer->is_correct==1){  
                        $correctAns[$answer->id]=$letters[$ac];
                        }
                    $ac++;
                    } ?>
                   
                <?php }
                ?>
          <div id="ansBlock_<?php echo $count; ?>">  
                        <?php 
                        if(count($answers) > 1){ 
                           ?>
                  <div class="col-md-12">
                  <p class="ans_panel"><strong class="text-success">Correct Answer: </strong>
                  <?php echo implode(' , ', $correctAns); ?></p>
                   <?php foreach($answers as $answer){ ?>
                     <?php //echo $answer->is_correct==1 ? $correctAns[$answer->id]:''; ?>
                      
                      <?php if(isset($answer->description)&&$answer->description!=''){ 
						  
						  $haystack = custom_strip_tags($answer->description);
$needle   = "Not Available";

if( strpos( $haystack, $needle ) !== false) {
}else{
						  ?>
                          <p class="ans_panel"><strong class="text-success">Solution : </strong></p>
                          <?php // iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->description));
                          echo custom_strip_tags($answer->description); 
}
                          ?>
                      <?php }
                      } ?>
                  </div>  
                      
                  <?php }else{ ?>
                  <p class="ans_panel"><strong class="text-success">Answer: </strong> </p>
                    <p> <?php foreach($answers as $answer){ ?>
                     <?php echo  custom_strip_tags($answer->answer);?><br>
                      <?php } ?>
                    </p>
                  <?php } ?> 
                    </div>
              </li>
            <?php  $count++;} ?>
              
            </ul>
          
          </div>  

        </div>
    
        
        <div class="clearfix"></div> 
    
        
      </section>
    </div>
  </div>
</div>
</div>

<script>
            //document.getElementById("dwnpage").submit();
</script>
