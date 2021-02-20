<?php

if(isset($spdetails->language)&&$spdetails->language=='hindi') {
    $hindicss='class="hindifont"';
    $hindicss_number_q='class="hindicss_number_q"';
    $hindicss_number_a='class="hindicss_number_a"';
    $hindicss_text='class="hindicss_text"';
}  
?>

<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php $this->load->view('common/breadcrumb'); ?>
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
           
			
      </div> 
        <!-- fluid pandl -->
        <div class="col-md-9 col-sm-12">
         <div class="question_panel_lft">
          <h3 class="panel-title"><i class="material-icons">done</i> <?php echo $spdetails->name;?></h3>
        </div>
          <div class="question_panel_lft">
            <ul class="grid">
            <?php $count=1;foreach($questions as $question){  ?>
            <li class="element-item <?php echo url_title($question->section,'', TRUE)?>" >
                <p><div <?php echo $hindicss_number_q ;?> ><i class="material-icons">question_answer</i><?php echo $count;?>)</div> <div <?php echo $hindicss.' '.$hindicss_text ;?> ><?php //echo  iconv('UTF-8', 'ASCII//TRANSLIT',custom_strip_tags($question->question));
				
				  echo custom_strip_tags($question->question); 
				
				?></div></p>
                <?php $answers=$this->Questions_model->answers($question->id);
                if(count($answers) > 1){ 
                        if(isset($question->type)){
                        $questions_type=$question->type;
                    }else{
                        $questions_type=NULL;
                    }
                    $letters = range('A', 'Z');
                    $ac=0;
                    foreach($answers as $answer){
                    ?><p>
					<div style="clear:both; float:left; margin-right:15px; margin-top:8px;">
					<?php echo $letters[$ac]?>) <?php if($questions_type=='Single Choice'){ ?><span><input onclick="checkSingleQus('<?php echo $answer->id; ?>','<?php echo $answer->is_correct; ?>')" type="radio" value="" name="q_opt" id="q_opt_<?php echo $answer->id; ?>"></span> 
					<?php } 
					?>
					</div>
					<div <?php echo $hindicss; ?>">
					<?php
					//echo iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->answer)); 	
echo custom_strip_tags($answer->answer); 
					?>
					</div>
					<span class="ansblock"> <i id="ansright_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:green;font-size: 22px; font-weight: bolder;  margin-bottom: 2px;" >done</i>
        <i id="answrong_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:red; font-size: 22px; font-weight: bolder; margin-bottom: 2px;" >clear</i> </span></p><?php
                    $ac++;
                    } 
                    ?>
              <?php 
              }
              ?>
                <!--Added _q to show question id on next page-->
                <span class="pull-right view_ans"><a target="_blank" href="<?php echo base_url('solved-papers').'/'.url_title($spdetails->name,'-',TRUE).'_q'.$count.'/'.$spdetails->id.'/'.$question->id;?>">View Answer <i class="material-icons">play_arrow</i> </a></span>
              </li>
            <?php $count++; } ?>
            </ul>
          </div> 
          <!-- next prev panel -->
        </div>
        <div class="col-md-3 col-sm-12">
        <div class="clearfix"></div>
        <?php 
		$linktostudypackage=base_url('purchase-courses');
		
		if(isset($linktostudypackage)){ ?>
        <div class="panel panel-primary rht_status_mat">
        <div class="panel-heading">
        <h4>Study Package</h4>
        </div>
            <div class="col-item">
            <div class="photo"> 
            <?php
                if(file_exists($filepath.$file->filename.'/docs/'.$file->filename.'.pdf_1_thumb.jpg')){
                $imagePath = base_url($filepath.$file->filename.'/docs/'.$file->filename.'.pdf_1_thumb.jpg');
                }else{                    
                $imagePath = base_url('assets/frontend/images/ebooks.png');  
                }
                ?>
                <a title="Download PDF" href="<?php echo $linktostudypackage;?>" style="text-decoration: none;color:#fff">
              <img src="<?php echo $imagePath; ?>" data-original="<?php echo $imagePath; ?>" class="img-responsive" alt="studyadda" style="display: block;" />
                </a>    
              </div>
              <div class="info">
                <div class="row">
                  <div class="price col-xs-12 col-md-12">
                  <h5 class="vid_prod_hed"><?php echo $file->displayname?$file->displayname:$file->filename; ?></h5>
                     <h5 class="price-text-color">&nbsp; 
                         <?php if($isProduct->discounted_price > 0){ ?>
      <?php //echo $isProduct->price?> <?php //echo $isProduct->discounted_price;
    }else{
        //echo $isProduct->price;
    }
    ?> </h5>
                </div>
                 </div>
                <div class="separator btn_prod_ved">
                    <a href="<?php echo $linktostudypackage?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>
                </div>
                <div class="clearfix"> </div>
              </div>
            </div>
          </div>
        <?php } ?>
        </div>
        
        
      </section>
    </div>
       <p>&nbsp;&nbsp;&nbsp;</p>
        <div class="clearfix"></div> 
  </div>
</div>



