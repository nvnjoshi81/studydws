<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php $this->load->view('common/breadcrumb');
	  	  if(isset($qbdetails->language)&&$qbdetails->language=='hindi'){
$hindicss='class="hindifont"';
$hindicss_number_q='class="hindicss_number_q"';
$hindicss_number_a='class="hindicss_number_a"';
$hindicss_text='class="hindicss_text"';
}
	  ?>
      <!-- /. PAGE INNER  -->
      <div class="clearfix"></div>
      <section class="question_fluid"  data-js-module="filtering-demo">     
        <!-- fluid pandl -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
 
        <div class="details_ques_ans panel-body">
            <ul>
              <li>
                  
                <h1 class="questionheading" > 
                    <i class="material-icons">question_answer</i> 
                        <span <?php echo $hindicss_number_q; ?>><?php 
						if((isset($qcount))&&($qcount>0)){
                        echo $qcount.') ';
						}
						?></span><span  <?php echo $hindicss ; ?>  <?php echo $hindicss_text ; ?> ><?php
                        if(isset($question->instructions_id ) && $question->instructions_id >  0){
                            $this->load->model("Instructions_model",'instruction');
                            $instruction=$this->instruction->getInstructionDetail($question->instructions_id);
                            ?><p><?php 
                            echo custom_strip_tags($instruction->description);
                            ?></p><?php
                        }
                        echo custom_strip_tags($question->question)?>
                            </span><?php 
                            $correctAns=array();
                            if(count($answers) > 1){ 
                                $letters = range('A','Z');
                                $ac=0;
                            ?>
                        <?php 
                        foreach($answers as $answer){ 
                            if($answer->is_correct==1){ 
                                $correctAns[$answer->id]=$letters[$ac];
                            }?>
                            <p>  <span><?php echo $letters[$ac]?>)</span>   <span <?php echo $hindicss; ?> ><?php //echo iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->answer));
                            echo custom_strip_tags($answer->answer); 
                            ?></span></p>
                        <?php  $ac++; } ?>
                        <?php } ?>
                </h1>
            <!--Start Slider -->
            <?php $showsm_slider='no'; 
            if(($showsm_slider=='yes')){  ?>  
                  <div class="mid_advertise"> <div class="clearfix"></div>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active" align="center">
      <img src="<?php echo base_url('assets/images/sm-slider/pk_slide_1.jpg') ?>" alt="Studyadda">
    </div>

    <div class="item" align="center">
      <img src="<?php echo base_url('assets/images/sm-slider/pk_slide_2.jpg') ?>" alt="Studyadda">
    </div>

    <div class="item" align="center">
      <img src="<?php echo base_url('assets/images/sm-slider/pk_slide_3.jpg') ?>" alt="Studyadda">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>   
            <div class="clearfix"><br><br></div>     </div>
        <?php } ?>    <!--End Slider -->
        <!--
        <img src="<?php echo base_url('');?>/assets/images/930adv.jpg" alt="dgd" />
            -->      
             
                  <?php if(count($answers) > 1){ ?>
                  <div class="col-md-12">
                  <p class="ans_panel"><strong class="text-success">Correct Answer: </strong>
                  <?php echo implode(' , ', $correctAns); ?></p>
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
						  <span <?php echo $hindicss; ?> >
                          <?php // iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->description));
                          echo custom_strip_tags($answer->description); 
                          ?></span>
                      <?php }      
                      } ?>
                  </div>  
                      
                  <?php }else{ ?>
                  <p class="ans_panel"><strong class="text-success">Answer: </strong> </p>
                    <p> <?php foreach($answers as $answer){ ?> <span <?php echo $hindicss; ?> >
                     <?php echo  custom_strip_tags($answer->answer);?><br>
                      <?php } ?></span>
                    </p>
                  <?php } ?>                
              </li>  
            </ul>
            <div class="col-md-12" id="report_error">
                <span class="pull-right view_ans">
                    <?php if($this->session->userdata('customer_id')){ ?>
                        <a href="javascript:void(0);">
                    <?php }else{ ?>
                        <a href="<?php echo base_url('login');?>" onclick="return showmsg();return false;">
                    <?php } ?>
                        <i class="material-icons">warning</i> Report Error
                    </a>
                </span>
            </div>
            <div class="pull-right col-md-12" id="error_box" style="display:none">
                <form id="error_report" name="error_report">
                    <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('customer_id')?$this->session->userdata('customer_id'):'0'?>">
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
        </div>
        </div>
       <!-- next prev panel -->
         <div class="pagingpanel">
          <ul class="pager">
          <?php 
		 
		if(isset($linkurl_prev)&&$linkurl_prev!=''){
			$linkurl=$linkurl_prev;  
		  }  
		  if($previousquestion){ ?>
                <li class="btn btn-raised btn-warning"><a href="<?php echo $linkurl;?>/<?php echo $previousquestion->question_id ?>">Previous</a></li>
          <?php }
 if(isset($linkurl_next)&&$linkurl_next!=''){
			  
		  $linkurl=$linkurl_next;
		  }
		  if($nextquestion){ ?>
                <li class="btn btn-raised btn-warning"><a class="withripple" href="<?php echo $linkurl;?>/<?php echo $nextquestion->question_id ?>">Next</a></li>
          <?php } ?>
</ul>
        </div> 
        </div>
        <?php 
              $showVidAdd='no';
    if($showVidAdd=='yes'){  ?>
  <!-- right panel -->
        <div class="col-md-2 col-sm-2">
            <?php 

$url_array = explode('/', $_SERVER['REQUEST_URI']);
if($url_array[1]=='ncert-solution'){            
            ?>
              <div class="btn-group-vertical ques_mate_panel filter-button-group button-group rht_sorting_panel">
        <?php
            $random_video_array= array(0=>base_url('assets/frontend/images/studyadda_adverd.mp4'),1=>base_url('assets/frontend/images/studyadda_adverd.mp4'));
            $random_video_link =rand(0,1);
            ?>
            <div class="our_vid_player" id="videoplayer_div">
                <video width="100%" height="auto" autoplay="" controls="" id="videoplayer">
                    <source type="video/mp4" src="<?php echo $random_video_array[$random_video_link];  ?>"></source>
                </video>
            </div>
        </div>
            
            <?php }?>
            <?php if(isset($linktostudypackage)){ ?>
             <div class="btn-group-vertical ques_mate_panel filter-button-group button-group rht_sorting_panel">
                <span class="pull-right"><a title="Download PDF" href="<?php echo $linktostudypackage;?>" style="text-decoration: none;color:#fff">
                  <?php 
                        
             if (file_exists($filepath.$filename.'/docs/'.$filename.'.pdf_1_thumb.jpg')) {
                $imagePath = base_url($filepath.$filename.'/docs/'.$filename.'.pdf_1_thumb.jpg');
                }else{
                $imagePath = base_url('assets/frontend/images/ebooks.png');  
                }
                ?>      
                <img class="img-responsive" src="<?php echo $imagePath ; ?>">
                </a>
                </span>  </div>
            <?php } ?>
          
            <?php if(isset($allquesgrid)&&(count($allquesgrid)>0)){ ?>
            <div class="rightadvertisepanel">
                <p class="btn btn-raised btn-success">More Questions</p>
        <?php 
        $count=1;foreach($allquesgrid as $question){  ?>
              
                <span class="badge" style="padding: 4px"><a class="" href="<?php echo base_url('ncert-solution').'/'.url_title($soldetails->name.'_q'.$count,'-',TRUE).'/'.$soldetails->id.'/'.$question->id?>" ><?php echo $count;?></a>
  </span><?php $count++; }
            
            ?>
            </div>
            <?php } ?>
         <!-- adv rht panel -->
      </div> 
          <?php } ?>
        <div class="clearfix"></div> 
        <!-- Related panel -->
        <!--<div class="panel panel-success relatedques">
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
