<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php //$this->load->view('common/breadcrumb'); ?>
        <!-- /. PAGE INNER  -->
      <div class="clearfix"></div>
      <section class="question_fluid"  data-js-module="filtering-demo">
             <!-- Top panel btn-group-vertical-->
        <div class="col-md-12 col-sm-12 ">
        <div class=" ques_mate_panel filter-button-group button-group rht_sorting_panel">
            
          <?php 
          $sections_cnt=count($sections);  
          if($sections_cnt>1){
          foreach( $sections as $section){  
              $section_string = str_replace('&nbsp;','',trim($section->section_name)); ?>    
             <button class="btn btn-raised btn-success" data-filter=".<?php echo url_title($section->section,'',TRUE)?>"><i class="material-icons">play_arrow</i><?php echo $section_string;?></button>
          <?php } ?>
             <button class="btn btn-raised btn-success " data-filter=".element-item"><i class="material-icons">play_arrow</i>All</button>
          <?php } ?>
        </div>
            <br>
             <div class="clearfix"></div>
            <!--<div class="col-xs-12 col-sm-12 col-md-12 rht_exam_select ">
                <?php
                $modulename=$this->uri->segment(2);
                $moduleid=$class_id;
                $linktotestseries=base_url('online-test'.$modulename.'/'.$moduleid);
                ?>
                <div class="btn-group col-xs-6 col-sm-6 col-md-6">
                    <a href="<?php echo $linktotestseries;?>" class="btn btn-raised dropdown-toggle btn-primary">
                     Online Test
                    </a>
                </div>
                <?php if(isset($linktostudypackage)){ ?>
            <div class="btn-group col-xs-6 col-sm-6 col-md-6">              
                    <a href="<?php echo $linktostudypackage;?>" class="btn btn-raised btn-warning btn-primary">
                        Download PDF
                       
                    </a>   <h5 class="price-text-color">&nbsp; 
                         <?php if($isProduct->discounted_price > 0){ ?>
      <i class="fa fa-inr"> </i> <del class="del_txt"> <?php echo $isProduct->price?></del> <?php echo $isProduct->discounted_price;
    }else{
        echo $isProduct->price;
    }
    ?> </h5>
                </div>
                <?php } ?>
        
        </div>-->
             <div class="clearfix"></div>
      </div> 
        <!-- fluid pandl -->
        <div class="col-md-12 col-sm-12">
          <div class="question_panel_lft">
            <ul class="grid">
            <?php $count=1;foreach($questions as $question){  ?>
                <li  class="element-item <?php echo url_title($question->section,'', TRUE)?>" >
                    <p><i class="material-icons">question_answer</i><?php echo $count;?>) <?php echo  iconv('UTF-8', 'ASCII//TRANSLIT',custom_strip_tags($question->question));?> </p>
                <?php $answers=$this->Questions_model->answers($question->id);
                if(count($answers) > 1){ 
                    
                        if(isset($question->type)){
                        $questions_type=$question->type;
                    }else{
                        $questions_type=NULL;
                    }
                    $correctAns=array();
                    $letters = range('A', 'Z');
                    $ac=0;
                    foreach($answers as $answer){
                    ?><p><?php echo $letters[$ac]?>) <?php if($questions_type=='Single Choice'){ ?><span><input onclick="checkSingleQus('<?php echo $answer->id; ?>','<?php echo $answer->is_correct; ?>')" type="radio" value="" name="q_opt" id="q_opt_<?php echo $answer->id; ?>"></span> <?php } echo iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->answer)); ?><span class="ansblock"> <i id="ansright_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:green;font-size: 22px; font-weight: bolder;  margin-bottom: 2px;" >done</i>
        <i id="answrong_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:red; font-size: 22px; font-weight: bolder; margin-bottom: 2px;" >clear</i> </span></p><?php          if($answer->is_correct==1){ 
                        $correctAns[$answer->id]=$letters[$ac];
                    }
                    $ac++;
                    } 
                    ?>
              <?php 
              }
              ?>
                <!--Added _q to show question id on next page-->
                <span class="pull-right view_ans"><a onclick="showHideans(<?php echo $count; ?>)" <?php //echo base_url('solved-papers').'/'.url_title($spdetails->name,'-',TRUE).'_q'.$count.'/'.$spdetails->id.'/'.$question->id;?>>View Answer <i class="material-icons">play_arrow</i></a>
                </span>
                <div id="ansBlock_<?php echo $count; ?>" style="display:none;"> 
                <?php  if(count($answers) > 1){ 
                           ?>
                  <div class="col-md-12">
                  <p class="ans_panel"><strong class="text-success">Correct Answer: </strong>
                  <?php echo implode(' , ', $correctAns); ?></p>
                   <?php foreach($answers as $answer){ ?>
                     <?php //echo $answer->is_correct==1 ? $correctAns[$answer->id]:''; ?>
                      
                      <?php if($answer->description){ ?>
                          <p class="ans_panel"><strong class="text-success">Solution : </strong></p>
                          <?php // iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->description));
                          echo custom_strip_tags($answer->description); 
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
                  <?php } 
                  ?>
                    </div>
              </li>
            <?php $count++; } ?>
            </ul>
          </div> 
          <!-- next prev panel -->
        </div>
      </section>
    </div>
       <p>&nbsp;&nbsp;&nbsp;</p>
        <div class="clearfix"></div> 
  </div>
</div>



