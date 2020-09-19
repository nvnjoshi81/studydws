<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php //$this->load->view('common/breadcrumb');?>
     
      
      <!-- /. PAGE INNER  -->
      <div class="clearfix"></div>
      <section class="question_fluid"  data-js-module="filtering-demo">
     
          <?php  $sections_cnt=count($sections); 
          if($sections_cnt>1){
          ?>
                <div class="col-md-12 col-sm-12 ">
        <div class="btn-group ques_mate_panel filter-button-group button-group rht_sorting_panel">
          <?php /* class="btn-group-vertical"  */ ?>
              <?php 
             
          foreach( $sections as $section){  
              ?>
             <button class="btn app_btn" data-filter=".<?php echo url_title($section->section,'',TRUE)?>"><i class="material-icons">play_arrow</i><?php //echo $section->section;?>  <?php echo ucwords($section->section_name);?></button>
          <?php } ?>
             <button class="btn app_btn" data-filter=".element-item"><i class="material-icons">play_arrow</i>All</button>
          
        </div>               
        <div class="clearfix"></div>         
      </div> 
          <?php } ?> 
        <!-- fluid pandl -->
        <div class="col-md-12 col-sm-12">
         <?php /* ?>
		 <div class="question_panel_lft">
          <h3 class="panel-title">
          <i class="material-icons">done</i> 
          <?php echo $spdetails->name;?>
              <?php if(isset($linktostudypackage)){  ?>
          <span class="pull-right"><a href="<?php echo $linktostudypackage;?>" style="text-decoration: none;color:#FFFFFF;font-size:17px  ">[Download Complete Paper]</a></span>
                 <?php  }?></h3>
        </div><?php */?>
          <div class="question_panel_lft">
            <ul class="grid">
            <?php $count=1;foreach($questions as $question){  ?>
                <li  class="element-item <?php echo url_title($question->section,'', TRUE)?>" >
                    <p><a href="#"><i class="material-icons">question_answer</i><?php echo $count;?>) <?php echo  iconv('UTF-8', 'ASCII//TRANSLIT',custom_strip_tags($question->question));?> </a></p>
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
                        
                        ?><p><?php echo $letters[$ac]?>) <?php if($questions_type=='Single Choice'){ ?><span><input onclick="checkSingleQus('<?php echo $answer->id; ?>','<?php echo $answer->is_correct; ?>')" type="radio" value="" name="q_opt" id="q_opt_<?php echo $answer->id; ?>"></span> <?php } echo iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->answer));   ?><span class="ansblock"> <i id="ansright_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:green;font-size: 22px; font-weight: bolder;  margin-bottom: 2px;" >done</i>
        <i id="answrong_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:red; font-size: 22px; font-weight: bolder; margin-bottom: 2px;" >clear</i> </span></p><?php  if($answer->is_correct==1){  
                        $correctAns[$answer->id]=$letters[$ac];
                        }
                    $ac++;
                    
                    } ?>
                   
                <?php }
                ?>
                
                <!--Added _q to show question id on next page-->
                <span class="pull-right view_ans"><a href="<?php echo base_url('sample-papers').'/'.url_title($spdetails->name,'-',TRUE).'-appapi_q'.$count.'/'.$spdetails->id.'/'.$question->id; ?>">View Answer <i class="material-icons">play_arrow</i> </a></span> 
              </li>
            <?php $count++;} ?>              
            </ul> 
          </div>  
          <!-- next prev panel -->
        </div>
        <!-- right panel -->
      </section>
    </div>
  </div>
</div>



