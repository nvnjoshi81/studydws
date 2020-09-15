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
<div id="wrapper"><form action="https://pdfcrowd.com/url_to_pdf/?pdf_name=studyadda.pdf" name="dwnpage" id="dwnpage">
    <input type="submit" name="pdfdownload" value="Download PDF" class="btn btn-raised btn-success btn-sm btn-md">
    </form>
  <div class="container">
    <div class="row">
      <!-- /. PAGE INNER  -->
      <div class="clearfix"></div>
      <section class="question_fluid"  data-js-module="filtering-demo">
        <!-- fluid pandl -->
        <div class="col-md-12 col-sm-12">
         <div class="question_panel_pdf">
          <h3 class="panel-title">
          <i class="material-icons">done</i> 
          <?php echo $spdetails->name;?>
              </h3>
        </div>
            <div class="question_panel_pdf" style="">
            <ul class="grid">
            <?php 
            $count=1;foreach($questions as $question){  ?>
    <li  class="element-item <?php echo url_title($question->section,'', TRUE)?>" >
    <p><a href="#"><?php echo $count;?>) <?php echo  iconv('UTF-8', 'ASCII//TRANSLIT',custom_strip_tags($question->question));?> </a>
    </p>
                <?php $answers=$this->Questions_model->answers($question->id);
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
                        ?>
    <p><?php echo $letters[$ac]?>) <?php echo iconv('UTF-8', 'ASCII//TRANSLIT', custom_strip_tags($answer->answer));   ?>
                        </p><?php
           if($answer->is_correct==1){  
                        $correctAns[$answer->id]=$letters[$ac];
                        }
                    $ac++;
                    
                    } ?>
                   
                <?php }
                ?>
                
                <!--Added _q to show question id on same page-->
             
                      <div>  
                        <?php 
                        if(count($answers) > 1){ 
                           ?>
                  <div class="col-md-12">
                  <p class="ans_panel"><strong class="text-success">Correct Answer: </strong>
                  <?php echo implode(' , ', $correctAns); ?></p>
                   <?php foreach($answers as $answer){ 
                       ?>
                      
                    <?php if(isset($answer->description)&&$answer->description!=''){ 
						  
	$haystack = custom_strip_tags($answer->description);
$needle   = "Not Available";

if( strpos( $haystack, $needle ) !== false) {
}else{
						  ?>
                          <p class="ans_panel"><strong class="text-success">Solution : </strong></p>
                          <?php 
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



