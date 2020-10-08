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
}  ?>
<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php $this->load->view('common/breadcrumb');?>
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
             <button class="btn btn-raised btn-success" data-filter=".<?php echo url_title($qtype->typename,'',TRUE)?>"><i class="material-icons">play_arrow</i><?php echo ucwords($qtype->typename);?></button>
          <?php } ?>
             <button class="btn btn-raised btn-success " data-filter=".element-item"><i class="material-icons">play_arrow</i>All..</button>
          
        </div>
        </div>
          <?php } ?>  
        <!-- fluid pandl -->
        <div class="col-md-10 col-sm-9">
        <div class="question_panel_lft">
        <h3 class="panel-title"><i class="material-icons">done</i> <?php echo $qbdetails->name;?></h3>
		<span><?php  $qcnt=count($questions); echo 'Total Question - '; echo $qcnt; ?>
		</span>
        </div>
        
         <div class="question_panel_lft">
           <!--<div class="mid_advertise"><img src="<?php echo base_url('');?>/assets/images/930adv.jpg" alt="Question Bank" /></div> -->
                <ul class="grid">
            <?php $count=1;foreach($questions as $question){  ?>
                <li  class="element-item <?php echo url_title($question->type,'', TRUE)?>" >
                    <p><a href="#"><div <?php echo $hindicss_number_q ;?> ><i class="material-icons">question_answer</i><?php echo $count;?>)</div> <div <?php echo $hindicss.' '.$hindicss_text ;?> ><?php echo  iconv('UTF-8', 'ASCII//TRANSLIT',custom_strip_tags($question->question));?> </div></a></p>
                   
                <?php $answers=$this->Questions_model->answers($question->id);
                if(count($answers) > 1){ 
                    $letters = range('A', 'Z');
                    $ac=0;
                    $ac_no=1;
                    foreach($answers as $answer){
                    ?>
                   <p> <div <?php echo $hindicss_number_a ;?>><?php echo $letters[$ac]?>)</div><div <?php echo $hindicss.' '.$hindicss_text ;?>><?php  
                    if(isset($question->type)){
                        $questions_type=$question->type;
                    }else{
                        $questions_type=NULL;
                    }
                    if($questions_type=='Single Choice'){ ?><span><input onclick="checkSingleQus('<?php echo $answer->id; ?>','<?php echo $answer->is_correct; ?>')" type="radio" value="" name="q_opt" id="q_opt_<?php echo $answer->id; ?>"></span> <?php } echo iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->answer)); ?>
       <span class="ansblock"> <i id="ansright_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:green;font-size: 22px; font-weight: bolder;  margin-bottom: 2px;" >done</i>
        <i id="answrong_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:red; font-size: 22px; font-weight: bolder; margin-bottom: 2px;" >clear</i> </span>
                        </div></p><?php
                        $ac_no++;
                    $ac++;
                    } ?>
                   
                <?php }
                ?>
                
                <!--Added _q to show question id on next page-->
                        <span class="pull-right view_ans"><a target="_blank" href="<?php echo base_url('question-bank').'/'.url_title($qbdetails->name,'-',TRUE).'_q'.$count.'/'.$qbdetails->id.'/'.$question->id?>">View Solution <i class="material-icons">play_arrow</i> </a></span>
              </li>
            <?php $count++;} ?>
              
            </ul>
          
          </div>  
        </div>
        <!-- right panel -->
        <div class="col-md-2 col-sm-3">
        <!--For Download qb-->
        <?php 
        if($showQB_dwn=='YES'){ ?>
        <div class="panel panel-primary rht_status_mat">
            <?php 
            $sequrecode=$qbdetails->id.'_st@ad_'.$qbdetails->id;
            $sequrecode =  encrypt($sequrecode);
            ?>
            <a title="Download Now" target="_blank" href="<?php echo base_url('pdfquestion-bank').'/qbpdf/thirdparty/temp/secure/'.$sequrecode; ?>" ><button class="btn btn-raised btn-success btn-sm btn-md"><i class="material-icons">assignment_returned</i>Download Now</button></a>
        </div>
        <?php } ?> 
        <?php if(isset($linktostudypackage)){ ?>
		<!--For Related Studymaterial -->
        <div class="panel panel-primary rht_status_mat"> 
        <div class="panel-heading">
        <h4>Study Package</h4>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 rht_pdf_box">
            <div class="col-item">
              <div class="photo"> 
            <?php 
             if (file_exists($filepath.$file->filename.'/docs/'.$file->filename.'.pdf_1.jpg')) {
               $imagePath = base_url($filepath.$file->filename.'/docs/'.$file->filename.'.pdf_1.jpg');
                }else{                    
                $imagePath = base_url('assets/frontend/images/ebooks.png');  
                }
                ?>
                <a title="Download PDF" href="<?php echo $linktostudypackage;?>" style="text-decoration: none; color:#fff">
                <img src="<?php echo $imagePath; ?>" data-original="<?php echo $imagePath; ?>" class="img-responsive" alt="studyadda" style="display: block;" />
                </a>    
              </div>
              <div class="info">
                <div class="row">
                  <div class="price col-xs-12 col-md-12">
                    <h5 class="vid_prod_hed"><?php echo $file->displayname?$file->displayname:$file->filename; ?></h5>
                       <!--<h5 class="price-text-color">&nbsp; <?php if($isProduct->discounted_price > 0){ 
        ?>
    <i class="fa fa-inr"> </i> <del class="del_txt"> <?php //echo $isProduct->price?></del> 
	<?php 
	//echo $isProduct->discounted_price;
    }else{
  //echo $isProduct->price;
    }
    ?> </h5>-->
                </div>
                 </div>
                <div class="separator btn_prod_ved">
                    <a href="<?php echo $linktostudypackage?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>
                </div>
                <div class="clearfix"> </div>
              </div>
            </div>
          </div>
        </div>   
		<?php }else{ ?>

        <div class="clearfix"></div>
       <div class="col-xs-12 col-sm-12 col-md-12 rht_pdf_box">
            <div class="col-item">
             <div class="info">
                <div class="row">
                  <div class="price col-xs-12 col-md-12">
                    <h5 class="vid_prod_hed">Download Complete Course</h5>
                </div>
                 </div>
                <div class="separator btn_prod_ved">
                    <a href="<?php echo base_url('purchase-courses'); ?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>
                </div>
                <div class="clearfix"> </div>
              </div>

            </div>
          </div>
        <?php } ?>
        <div class="clearfix"></div>
      </div> 
        
        <div class="clearfix"></div> 
        <!-- Related panel 
        <div class="panel panel-success relatedques">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Related Question</strong></h3>
          </div>
          <div class="panel-body">
            <a href="#">Very Short</a> | <a href="#">Short</a> | <a href="#">All</a>
          </div>
        </div>-->
        
        
      </section>
    </div>
  </div>
</div>



