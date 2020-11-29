<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php //$this->load->view('common/breadcrumb');
	  	  if(isset($qbdetails->language)&&$qbdetails->language=='hindi'){
$hindicss='class="hindifont"';
$hindicss_number_q='class="hindicss_number_q"';
$hindicss_number_a='class="hindicss_number_a"';
$hindicss_text='class="hindicss_text"';
$languagevar='hindi';
}else  if(isset($spdetails->language)&&$spdetails->language=='hindi'){
$hindicss='class="hindifont"';
$hindicss_number_q='class="hindicss_number_q"';
$hindicss_number_a='class="hindicss_number_a"';
$hindicss_text='class="hindicss_text"';
$languagevar='hindi';
}else if(isset($soldetails->language)&&$soldetails->language=='hindi') {
	$hindicss='class="hindifont"';
	$hindicss_number_q='class="hindicss_number_q"';
	$hindicss_number_a='class="hindicss_number_a"';
	$hindicss_text='class="hindicss_text"';
	$languagevar='hindi';
}elseif(isset($soldetails->language)&&$soldetails->language=='hindi'){

$hindicss='class="hindifont"';
	$hindicss_number_q='class="hindicss_number_q"';
	$hindicss_number_a='class="hindicss_number_a"';
	$hindicss_text='class="hindicss_text"';
	$languagevar='hindi';
	
}else {
	$hindicss='';
	$hindicss_number_q='';
	$hindicss_number_a='';
	$hindicss_text='';	
	$languagevar='english';
}

	  ?>
      <!-- /. PAGE INNER  -->
      <div class="clearfix"></div>
      <section class="question_fluid"  data-js-module="filtering-demo">     
        <!-- fluid pandl -->
        <div class="col-md-10 col-sm-10">
        <div class="panel panel-default">
 
        <div class="details_ques_ans panel-body">
            <ul>
              <li>
                  
                <h1 class="questionheading" > 
                    <i class="material-icons">question_answer</i> 
                        <?php 
						if((isset($qcount))&&($qcount>0)){
                        echo $qcount.') ';
						} ?>
						
						<div><?php
                        if(isset($question->instructions_id ) && $question->instructions_id >  0){
                            $this->load->model("Instructions_model",'instruction');
                            $instruction=$this->instruction->getInstructionDetail($question->instructions_id);
                            ?><p><?php 
                            echo custom_strip_tags($instruction->description);
                            ?></p><?php
                        }
						 if($languagevar=='hindi'){
						?>
						<span <?php echo $hindicss ; ?>><?php	 
                        echo $question->question;
						?></span>
						 <?php }else{
						?><span><?php	 
                        echo custom_strip_tags($question->question);
						?>
						</span>
						<?php
						 }
						?>
						</div>
                            <?php 
                            $correctAns=array();
                            if(count($answers) > 1){ 
                                $letters = range('A','Z');
                                $ac=0;
                        foreach($answers as $answer){ 
                            if($answer->is_correct==1){ 
                                $correctAns[$answer->id]=$letters[$ac];
                            }?>
                            <p><?php echo $letters[$ac]?>) 
							
							<?php if($languagevar=='hindi'){
?>
<span  <?php echo $hindicss ; ?>><?php 
                            echo $answer->answer; 
                            ?></span>
							<?php
							}else{ 
							?>
							<span><?php //echo iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->answer));
                            echo custom_strip_tags($answer->answer); 
                            ?></span>
							<?php } ?>
							
							</p>
                        <?php  $ac++; } ?>
                        <?php } ?>
                </h1>          
                  <?php if(count($answers) > 1){ ?>
                  <div class="col-md-12">
                  <p class="ans_panel"><strong class="text-success">Correct Answer: </strong>
				  <?php
				 $impcorrect = implode(' , ', $correctAns);
				  ?>
				  <span  <?php //echo $hindicss ; ?>>
                  <?php echo $impcorrect; ?></span></p>
                   <?php foreach($answers as $answer){ ?>
                     <?php //echo $answer->is_correct==1 ? $correctAns[$answer->id]:''; ?>
                      
                      <?php
					    $countdes= count($answer->description); 
if(isset($answer->description)){					  
					  if($answer->description==''||$countdes<1||$answer->description=='Not Available'){
						  $SolutionDesc=NULL;
					  }else{
						  $SolutionDesc=$answer->description;
					  }
					
					}else{
						$SolutionDesc=NULL;
					}
					  
					  if($SolutionDesc!=NULL){ 
					  ?>
                          <p class="ans_panel"><strong class="text-success">Solution : </strong></p>
						  <?php 
						  if($languagevar=='hindi'){
							  ?>
						<span  <?php echo $hindicss ; ?>>
                          <?php echo $answer->description; 
                          ?></span>
							  <?php
						  }else{
						  ?>
						  <span>
                          <?php // iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->description));
                          echo custom_strip_tags($answer->description); 
                          ?>
						  </span>
						  
                      <?php } 
					  }     
                      } ?>
                  </div>
                  <?php }else{ ?>
                  <p class="ans_panel"><strong class="text-success">Answer: </strong> </p>
                    <p> <?php foreach($answers as $answer){ ?>
					
					<?php if($languagevar=='hindi'){ ?>
					
					<span  <?php echo $hindicss ; ?>>
                     <?php echo  $answer->answer;?></span><br>
					 
					<?php }else{
						?>
					<span>
                     <?php echo  custom_strip_tags($answer->answer);?></span><br>
					 
					<?php
					} 
				    } ?>
                    </p>
                  <?php } ?>                
              </li>  
            </ul>
			<div>
			<?php 
			if($appcustid>0){ ?>
            <div class="col-md-12" id="report_error">
                <span class="pull-right view_ans">
                    <a href="javascript:void(0);">
                        <i class="material-icons">warning</i> Report Error
                    </a>
                </span>
            </div>
            <div class="pull-right col-md-12" id="error_box" style="display:none">
                <form id="error_report" name="error_report">
                    <input type="hidden" name="user_id" value="<?php echo $appcustid?$appcustid:'0'?>">
                    <input type="hidden" name="question_id" value="<?php echo $question->id?>">
                    <div class="form-group">
				<label class="required" >Select Error Type </label>
                                <ul class="nav nav-pills searchoptions">
                    <li class="radio">
                    <label>
                        <input type="radio" value="Incomplete Question" name="error" checked="">
                        Incomplete Question
                        </label>
                        
                       </li>
                       <li class="radio">
                         <label>
                           <input type="radio" value="Irrelevant Question" name="error">
                           
                           Irrelevant Question 
                           </label>
                         </li>
                         <li class="radio">
                           <label>
                             <input type="radio" value="Wrong Answer" name="error">
                             Wrong Answer
                             </label>
                           </li>
                           
                       </ul>
                               
                    </div>
			<div class="form-group">
				<label class="required" >Comment </label>
                                <textarea name="comment" class="form-control" id="comment" required=""></textarea>
			</div>
                    <button type="submit" class="btn btn-warning btn-raised">Submit</button>
                </form>
            </div>
			<?php } ?>
</div>      


	  </div>
        </div>
       <!-- next prev panel -->
         <div class="pagingpanel">
          <ul class="pager">
          <?php 
		 
		 
		 if(isset($applinkurl_prev)&&$applinkurl_prev!=''){
			$linkurl=$applinkurl_prev;  
		  }else if(isset($linkurl_prev)&&$linkurl_prev!=''){
			$linkurl=$linkurl_prev;  
		  }  
		  if($previousquestion){ ?>
                <li class="btn btn-raised btn-warning"><a href="<?php echo $linkurl;?>/<?php echo $previousquestion->question_id ?>">Previous</a></li>
          <?php }
		  if(isset($applinkurl_next)&&$applinkurl_next!=''){
			$linkurl=$applinkurl_next;  
		  }else if(isset($linkurl_next)&&$linkurl_next!=''){
		  $linkurl=$linkurl_next;
		  }
		  if($nextquestion){ ?>
                <li class="btn btn-raised btn-warning"><a class="withripple" href="<?php echo $linkurl;?>/<?php echo $nextquestion->question_id ?>">Next</a></li>
          <?php } ?>
</ul>
        </div> 
        </div>
  <!-- right panel -->
        <div class="col-md-2 col-sm-2">
		<?php if(isset($allquesgrid)&&(count($allquesgrid)>0)){ ?>
            <div class="rightadvertisepanel">
                <p class="btn btn-raised btn-success">More Questions</p>
        <?php 
        $count=1; 
		foreach($allquesgrid as $question){  ?>
        <span class="badge" style="padding: 4px">
				<a class="" href="<?php echo base_url('ncert-solution').'/'.url_title($soldetails->name.'-appapi_q'.$count,'-',TRUE).'/'.$soldetails->id.'/'.$question->id?>" ><?php echo $count;?>
				</a>
        </span>
		<?php 
		$count++;
  }         
  ?>
            </div>
            <?php } ?>
            <?php 
$url_array = explode('/', $_SERVER['REQUEST_URI']); ?>
             <div class="btn-group-vertical ques_mate_panel filter-button-group button-group rht_sorting_panel">
            <?php if(isset($linktostudypackage)){ ?>
                <span class="pull-right"><a title="Download PDF" 
				href="<?php echo $linktostudypackage;?>" style="text-decoration: none;color:#fff">
            <?php   
             if (file_exists($filepath.$filename.'/docs/'.$filename.'.pdf_1_thumb.jpg')) {
                $imagePath = base_url($filepath.$filename.'/docs/'.$filename.'.pdf_1_thumb.jpg');
                }else{
                $imagePath = base_url('assets/frontend/images/ebooks.png');  
                }
                ?>
                        
                <img class="img-responsive" src="<?php echo $imagePath ; ?>">
                        
                        </a>
                </span>
            <?php } ?>
            </div>
   
         
      </div> 
        <div class="clearfix"></div> 
      </section>
    </div>
  </div>
</div>
