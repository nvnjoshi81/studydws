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
<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php $this->load->view('common/breadcrumb');?>
      <!-- /. PAGE INNER  -->
      <div class="clearfix"></div>
      <section class="question_fluid"  data-js-module="filtering-demo">
          <?php  $sections_cnt=count($questiontypes);  
          if($sections_cnt>1){
          ?> 
		  <!--btn-group-vertical-->
        <div class="col-md-12 col-sm-12 ">  <div class="btn-group ques_mate_panel filter-button-group button-group rht_sorting_panel">
          <?php foreach($questiontypes as $qtype){   ?>
        <button class="btn btn-raised btn-success" data-filter=".page_<?php echo url_title($qtype->typeid,'',TRUE)?>"><i class="material-icons">play_arrow</i>Page <?php echo $qtype->typeid;?></button>
          <?php } ?>
          <?php if(count($exmeplar_questions) > 1){ ?>
        <button class="btn btn-raised btn-success " data-filter=".page_exemplar"><i class="material-icons">play_arrow</i>Exemplar</button> 
        <?php } ?>
        <?php if(count($questiontypes) > 1){ ?>
        <button class="btn btn-raised btn-success " data-filter=".element-item"><i class="material-icons">play_arrow</i>All</button>
             <?php } ?>
                      </div></div>
          <?php } 
		  $leftColmd='12';
		  $noexamcolumn='col-xs-4 col-sm-4 col-md-4';		
		    if(count($questions)>1){
			$noexamcolumn='';
			if(isset($linktostudypackage)){
			$leftColmd='3';
			$qleftColmd='9';
			}else{
			$leftColmd=''; 		
			$qleftColmd='12';
			}
		  ?>
        <!-- fluid pandl -->
        <div class="col-md-<?php echo $qleftColmd; ?>">
         <div class="question_panel_lft">
             <h3 class="panel-title"><i class="material-icons">done</i> <?php echo $soldetails->name;?>          
             </h3>
        </div>
          <div class="question_panel_lft">
            <ul class="grid">
            <?php $count=1;foreach($questions as $question){  ?>
                <li  class="element-item page_<?php echo $question->filter;?>" >
                    <p> <a  href="#"><i class="material-icons">question_answer</i><?php echo $count;?>) <?php //echo  iconv('UTF-8', 'ASCII//TRANSLIT',custom_strip_tags($question->question));
                    echo custom_strip_tags($question->question); 
                    ?> </a></p>
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
                        ?><p><?php echo $letters[$ac]?>) <?php if($questions_type=='Single Choice'){ ?><span><input onclick="checkSingleQus('<?php echo $answer->id; ?>','<?php echo $answer->is_correct; ?>')" type="radio" value="" name="q_opt" id="q_opt_<?php echo $answer->id; ?>"></span> <?php } echo custom_strip_tags($answer->answer); ?><span class="ansblock"> <i id="ansright_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:green;font-size: 22px; font-weight: bolder;  margin-bottom: 2px;" >done</i>
        <i id="answrong_<?php echo $answer->id; ?>" class="material-icons" style="display:none;color:red; font-size: 22px; font-weight: bolder; margin-bottom: 2px;" >clear</i> </span></p><?php
                    $ac++;
                    
                    }  
                    
                    }
                ?>
                <!--Added _q to show question id on next page-->
                <span class="pull-right view_ans"><a href="<?php echo base_url('ncert-solution').'/'.url_title($soldetails->name,'-',TRUE).'_q'.$count.'/'.$soldetails->id.'/'.$question->id?>">View Answer <i class="material-icons">play_arrow</i> </a></span>
              </li>
            <?php $count++;} ?>
              <?php if(count($exmeplar_questions) > 0){ 
                    foreach($exmeplar_questions as $question){?>
                    <li  class="element-item page_exemplar" >
                        <p> <a  href="#"><i class="material-icons">question_answer</i><?php echo $count;?>) <?php echo  iconv('UTF-8', 'ASCII//TRANSLIT',custom_strip_tags($question->question));?> </a></p>
                        <span class="pull-right view_ans"><a href="<?php echo base_url('ncert-solution').'/'.url_title($soldetails->name,'-',TRUE).'_q'.$count.'/'.$soldetails->id.'/'.$question->id?>">View Answer <i class="material-icons">play_arrow</i> </a></span>
                    </li>
                    <?php $count++; } } ?>
              
            </ul> 
          </div>
            <!-- next prev panel -->
        </div>
		<?php } ?>
        <!-- right panel -->
        <div class="col-md-<?php echo $leftColmd; ?>"> 
		<?php  
		// str_rot13() example
		
		$showVidAdd='no';
		if($showVidAdd=='yes'){ 
       $random_video_array= array(0=>base_url('assets/frontend/images/studyadda_adverd.mp4'),1=>base_url('assets/frontend/images/studyadda_adverd.mp4'));
       $random_video_link =rand(0,1);
      ?>
            <div class="btn-group-vertical ques_mate_panel filter-button-group button-group rht_sorting_panel">
            <div class="our_vid_player" id="videoplayer_div">
                <video width="100%" height="auto" autoplay="" controls="" id="videoplayer">
                    <source type="video/mp4" src="<?php echo $random_video_array[$random_video_link];  ?>"></source>
                </video>
            </div>
        </div>
		<?php  } ?>
        <div class="clearfix"></div>
            <?php 
			//print_r($linktostudypackage);
			
			if(isset($linktostudypackage)){ ?> 
        <div class="col-xs-12 col-sm-12 col-md-12 rht_pdf_box">
		<!--For loop product-->
		<?php
		
			foreach($linktostudypackage as $dspkey=>$dispval){
				$producturl=base_url('exams/'.$url_segments[2].'/'.$dispval[4]->exam_id);				
				$productlist_id = $dispval[3]->product_id
		?>
		
            <div class="col-item <? echo $noexamcolumn; ?>">
              <div class="photo"> 
              <?php 
               $imagePath = base_url('assets/frontend/images/ebooks.png');  
                ?>
              <a title="Download PDF" href="<?php echo $producturl;?>" style="text-decoration: none;color:#fff">               
              <img src="<?php echo $imagePath; ?>" data-original="<?php echo $imagePath; ?>" class="img-responsive" alt="studyadda" style="display: block;" />
                  </a>    
              </div>
              <div class="info">
                <div class="row">
                  <div class="price col-xs-12 col-md-12">
                    <h5 class="vid_prod_hed"><?php echo $dispval[4]->displayname; ?></h5>
                      <!-- <h5 class="price-text-color">&nbsp; <?php if($dispval[4]->displayname > 0){ 
        ?>
      <i class="fa fa-inr"> </i> <del class="del_txt"> <?php //echo $dispval[4]->price?></del> <?php //echo $dispval[4]->discounted_price;
    }else{
        //echo $dispval[4]->price;
    }
    ?> </h5>-->
                </div>
                 </div>
                <div class="separator btn_prod_ved">
				<?php 
$customer_id=$this->session->userdata('customer_id');
				    if(!$this->session->userdata('purchases') || !in_array_r($productlist_id,$this->session->userdata('purchases'))){
				?>				
					
					<?php 
					/*Testing Link - https://studyadda.com/ncert-solution/12th-class/chemistry/the-solid-state/12th-chemistry-the-solid-state/400*/
					if($dispval[3]->offline_status=='1'&&$customer_id>0){
							?>
						<a href="<?php echo base_url('study-packages/download/'.encrypt($product->file_id.'.'.$this->session->userdata('customer_id')))?>" target="_blank">
                                         <?php  $textdownload='Download now'; ?><button class="btn-lg btn-sm btn-md btn btn-raised btn-success" name="btnAlreadyExist"><?php echo $textdownload; ?></button>
                                             </a>
<?php
}else{
	?>
<!--
  <a href="<?php //echo $producturl;?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>
-->

                <a href="<?php echo base_url('purchase-courses'); ?>" class="btn-md btn btn-raised btn-warning">Buy Now</a>
	<?php
}
}else{
?>
						<a href="<?php echo base_url('study-packages/download/'.encrypt($product->file_id.'.'.$this->session->userdata('customer_id')))?>" target="_blank">
                                         <?php if(isset($cnttimes)&&$cnttimes>0) {
                                             $textdownload='Download Again ('.$cnttimes.')';
                                         }else{
                                             $textdownload='Download now';
                                         }?>
                                         
                                                <button class="btn-lg btn-sm btn-md btn btn-raised btn-success" name="btnAlreadyExist"><?php echo $textdownload; ?></button>
                                             </a>
						<?php
						
					}?>
                </div>
                <div class="clearfix"> </div>
              </div>
            </div>
			<? } ?>

<!--Loop Product End-->			
		 </div>
        <?php } 
		?>
        <div class="clearfix"></div>
            <?php if(isset($related_playlists)){ ?>
            <div class="panel panel-warning">
            <div class="panel-heading">
            <h4>NCERT Video Solutions</h4>            
            <div class="clearfix"></div>
            </div>
                <div class="panel-body " style="padding:5px;">
            <?php 
            foreach($related_playlists as $key=>$value){                
            ?>
            <?php foreach($value as $k=>$v){ 
                $vrelation=$this->Videos_model->getRelations($v->id);
                $link=array();
                $link[]='videos';
                if($vrelation[0]->exam){
                    $link[]=url_title($vrelation[0]->exam,'-',true);
                }
                if($vrelation[0]->subject){
                    $link[]=url_title($vrelation[0]->subject,'-',true);
                }
                if($vrelation[0]->chapter){
                    $link[]=url_title($vrelation[0]->chapter,'-',true);
                }
                if($vrelation[0]->playlist){
                    $link[]=url_title($vrelation[0]->playlist,'-',true);
                }
                $link[]=url_title($v->title,'-',true);
                $link[]=$v->id;
                ?>
                    <a class="video_thumb_list" href="<?php echo base_url(implode('/',$link));?>">    
                <div class="col-xs-2  col-md-4 vid_th_img nopadding">
                    <?php if($v->video_source=='youtube'){ ?>
                    <img class="thumbnail img-responsive" height="100" width="100" src="https://i.ytimg.com/vi/<?php echo $v->video_url_code?>/mqdefault.jpg"/>
                    <?php }else{ ?>
                    <img class="thumbnail img-responsive" src="<?php echo show_thumb($v->video_image,100,100);?>">
                    <?php } ?>
                </div>
                <div  class="col-xs-10 col-md-8">
                    <?php echo $v->title;?>
                </div>
                <div class="clearfix"></div>
                    </a>
                <?php } ?>
            <?php } ?>
            
                </div>
            </div>
            <?php } ?>
        
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



