<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb'); ?>

            <div class="col-md-9 col-sm-9 search_det">
                
                    <?php
                     $showMore =1;
                     $result_limit = 10;
                     $any_result_found='no';
                     
                    if($video_results_count > 0 && ($type=='all' || $type=='videos')){
                        
                     $any_result_found='yes';
                        if($type=='videos'){
                          $result_limit = count($video_results);
                           echo  $links;
                        } 
                        ?>
                    <div class="list-group">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Video (<?php echo $video_results_count; ?>)</h3>
                        </div>
                        <div class="panel-body">
                            <?php $count=1;foreach($video_results as $item){ 
                                if($count<=$result_limit){
                                ?>
                            <div class="list-group-item">
                                <a href="<?php echo base_url('videos/'.url_title($item->exam,'-',true).'/'.url_title($item->subject,'-',true).'/'.url_title($item->chapter,'-',true).'/'.url_title($item->playlist,'-',true).'/'.url_title($item->title,'-',true).'/'.$item->videoid)?>">  
                                    <div class="row-picture">
                                        <img class="circle" src="<?php echo show_thumb($item->image,250,250);?>" alt="icon">
                                    </div>
                                    <div class="row-content">

                                        <h4 class="list-group-item-heading"><?php echo $item->title?></h4>

                                        <p class="list-group-item-text">&nbsp;</p>

                                    </div>
                                </a>
                            </div>
                            <?php 
                            if($count < count($video_results)){
                                echo ' <div class="list-group-separator"></div> ';
                                
                            }
                            }else{
                               if($showMore ==1){
                                ?>
                            <a target="_blank " href="<?php echo base_url('search/'.$search.'/videos')?>"><span class="badge pull-right">MORE...</span></a>
                                <?php
                                $showMore++; 
                               }
                            }
                            $count++; 
                            
                            } 
                           
                            ?>
                            
                           
                        </div>
                    </div>
                        </div> 
                    <?php  } ?>
                
                <?php $showMore =1; if($studymaterial_results_count > 0 && ($type=='all' || $type=='study-packages')){ 
                    $any_result_found='yes';
                    if($type=='study-packages'){
                          $result_limit = count($studymaterial_results);    
                          echo  $links;
                    }
                    ?>
                <div class="list-group">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Study Packages (<?php echo $studymaterial_results_count; ?>)
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php $count=1;foreach($studymaterial_results as $item){
                                if($count<=$result_limit){ ?>
                            <div class="list-group-item">
                                <a href="<?php echo base_url('study-packages/'.url_title($item->exam,'-',true).'/'.url_title($item->subject,'-',true).'/'.url_title($item->chapter,'-',true).'/'.url_title($item->name,'-',true).'/'.$item->id)?>">  
                                    <div class="row-picture">
                                        <img class="circle" src="<?php echo base_url('assets/frontend/images/pdf_icons.png')?>" alt="icon">
                                    </div>
                                    <div class="row-content">

                                        <h4 class="list-group-item-heading"><?php echo $item->name?></h4>

                                        <p class="list-group-item-text">&nbsp;</p>

                                    </div>
                                </a>
                            </div>
                            <?php 
                            if($count < count($studymaterial_results)){
                                echo ' <div class="list-group-separator"></div> ';
                            }
                                }else{
                               if( $showMore ==1){
                                ?>
                            <a target="_blank " href="<?php echo base_url('search/'.$search.'/study-packages')?>"><span class="badge pull-right">MORE...</span></a>
                                <?php
                                $showMore++; 
                               }
                            }
                            $count++; } ?>
                            
                           
                        </div>
                    </div>
                        </div>
                <?php } ?>
                <?php $showMore =1; if($article_results_count > 0 && ($type=='all' || $type=='notes')){ 
                    $any_result_found='yes';
                    if($type=='notes'){
                          $result_limit = count($article_results);    
                          echo  $links;
                    }
                        ?>
                <div class="list-group">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Notes  (<?php echo $article_results_count; ?>)
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php $count=1;foreach($article_results as $item){
                                if($count<=$result_limit){ ?>
                            <div class="list-group-item">
                                <a href="<?php echo base_url('notes/'.url_title($item->exam,'-',true).'/'.url_title($item->subject,'-',true).'/'.url_title($item->chapter,'-',true).'/'.url_title($item->title,'-',true).'/'.$item->id)?>">  
                                    <div class="row-picture">
                                        <img class="circle" src="<?php echo base_url('assets/frontend/images/txt.jpeg')?>" alt="icon">
                                    </div>
                                    <div class="row-content">

                                        <h4 class="list-group-item-heading"><?php echo $item->title.'('. $item->exam .')'?></h4>

                                        <p class="list-group-item-text">&nbsp;</p>

                                    </div>
                                </a>
                            </div>
                            <?php 
                            if($count < count($article_results)){
                                echo ' <div class="list-group-separator"></div> ';
                            }
                                }else{
                               if( $showMore ==1){
                                ?>
                            <a target="_blank " href="<?php echo base_url('search/'.$search.'/notes')?>"><span class="badge pull-right">MORE...</span></a>
                                <?php
                                $showMore++; 
                               }
                            }
                            $count++; } ?>
                            
                           
                        </div>
                    </div>
                        </div>
                <?php } ?>
                <?php $showMore =1; if($ncertsolutions_results_count > 0 && ($type=='all' || $type=='ncert-solution')){ 
                    $any_result_found='yes';
                    if($type=='ncert-solution'){
                          $result_limit = count($ncertsolutions_results);   
                          echo  $links; 
                    }
                        ?>
                <div class="list-group">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                NCERT Solutions (<?php echo $ncertsolutions_results_count; ?>)
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php $count=1;foreach($ncertsolutions_results as $item){
                                if($count<=$result_limit){ ?>
                            <div class="list-group-item">
                                <a href="<?php echo base_url('ncert-solution/'.url_title($item->exam,'-',true).'/'.url_title($item->subject,'-',true).'/'.url_title($item->chapter,'-',true).'/'.url_title($item->name,'-',true).'/'.$item->id)?>">  
                                    <div class="row-picture">
                                        <img class="circle" src="<?php echo base_url('assets/frontend/images/ncert.png')?>" alt="icon">
                                    </div>
                                    <div class="row-content">

                                        <h4 class="list-group-item-heading"><?php echo $item->name;?></h4>

                                        <p class="list-group-item-text">&nbsp;</p>

                                    </div>
                                </a>
                            </div>
                            <?php 
                            if($count < count($ncertsolutions_results)){
                                echo ' <div class="list-group-separator"></div> ';
                            }
                                }else{
                               if( $showMore ==1){
                                ?>
                            <a target="_blank " href="<?php echo base_url('search/'.$search.'/ncert-solution')?>"><span class="badge pull-right">MORE...</span></a>
                                <?php
                                $showMore++; 
                               }
                            }
                            $count++; } ?>
                            
                           
                        </div>
                    </div>
                        </div>
                <?php } ?>
                <?php $showMore =1; 
                if($question_results_count > 0 && ($type=='all' || $type=='question-bank')){
                    $any_result_found='yes';
                    if($type=='question_bank'){
                          $result_limit = count($question_results);   
                          echo  $links;
                        } 
                        ?>
                <div class="list-group">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Questions (<?php echo $question_results_count; ?>)
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php $count=1;foreach($question_results as $item){ 
                                if($count<=$result_limit){ ?>
                            <div class="list-group-item">
                                <a href="<?php echo base_url('question-bank/'.url_title($item->exam,'-',true).'/'.url_title($item->subject,'-',true).'/'.url_title($item->chapter,'-',true).'/'.$item->id)?>">  
                                    <div class="row-picture">
                                        <img class="circle" src="<?php echo base_url('assets/frontend/images/Question.png')?>" alt="icon">
                                    </div>
                                    <div class="row-content">

                                        <h4 class="list-group-item-heading"><?php echo $item->name;?></h4>

                                        <p class="list-group-item-text">&nbsp;</p>

                                    </div>
                                </a>
                            </div>
                            <?php 
                            if($count < count($question_results)){
                                echo ' <div class="list-group-separator"></div> ';
                            }
                                }else{
                               if( $showMore ==1){
                                ?>
                            <a target="_blank " href="<?php echo base_url('search/'.$search.'/question-bank')?>"><span class="badge pull-right">MORE...</span></a>
                                <?php
                                $showMore++; 
                               }
                            }
                            $count++; } ?>
                            
                           
                        </div>
                    </div>
                        </div>
                <?php } ?>
                <?php $showMore =1; if($samplepapers_results_count > 0 && ($type=='all' || $type=='samplepapers')){
                  $any_result_found='yes';  
                    if($type=='samplepapers'){
                          $result_limit = count($samplepapers_results);  
                          echo  $links;   
                        }
                        ?>
                <div class="list-group">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Sample Papers (<?php echo $samplepapers_results_count; ?>)
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php $count=1;foreach($samplepapers_results as $item){ 
                                if($count<=$result_limit){ ?>
                            <div class="list-group-item">
                                <a href="<?php echo base_url('sample-papers/'.url_title($item->exam,'-',true).'/'.url_title($item->subject,'-',true).'/'.url_title($item->chapter,'-',true).'/'.url_title($item->name,'-',true).'/'.$item->id)?>">  
                                    <div class="row-picture">
                                        <img class="circle" src="<?php echo base_url('assets/frontend/images/pdf_icons.png')?>" alt="icon">
                                    </div>
                                    <div class="row-content">

                                        <h4 class="list-group-item-heading"><?php echo $item->name;?></h4>

                                        <p class="list-group-item-text">&nbsp;</p>

                                    </div>
                                </a>
                            </div>
                            <?php 
                            if($count < count($samplepapers_results)){
                                echo ' <div class="list-group-separator"></div> ';
                            }
                                }else{
                               if( $showMore ==1){
                                ?>
                            <a target="_blank " href="<?php echo base_url('search/'.$search.'/sample-papers')?>"><span class="badge pull-right">MORE...</span></a>
                                <?php
                                $showMore++; 
                               }
                            }
                            $count++; 
                            
                               } 
                               ?>
                        </div>
                    </div>
                        </div>
                <?php } 
                //Solved papers search
                
                $showMore =1; if($solvedpapers_results_count > 0 && ($type=='all' || $type=='solved-papers')){
                  $any_result_found='yes';  
                    if($type=='solved-papers'){
                          $result_limit = count($solvedpapers_results);  
                          echo  $links;   
                        }
                        ?>
                <div class="list-group">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Solved Papers (<?php echo $solvedpapers_results_count; ?>)
                            </h3>
                        </div>
                        <div class="panel-body">
                            <?php $count=1;foreach($solvedpapers_results as $item){ 
                                if($count<=$result_limit){ ?>
                            <div class="list-group-item">
                                <a href="<?php echo base_url('solved-papers/'.url_title($item->exam,'-',true).'/'.url_title($item->subject,'-',true).'/'.url_title($item->chapter,'-',true).'/'.url_title($item->name,'-',true).'/'.$item->id)?>">  
                                    <div class="row-picture">
                                        <img class="circle" src="<?php echo base_url('assets/frontend/images/pdf_icons.png')?>" alt="icon">
                                    </div>
                                    <div class="row-content">

                                        <h4 class="list-group-item-heading"><?php echo $item->name;?></h4>

                                        <p class="list-group-item-text">&nbsp;</p>

                                    </div>
                                </a>
                            </div>
                            <?php 
                            if($count < count($solvedpapers_results)){
                                echo ' <div class="list-group-separator"></div> ';
                            }
                                }else{
                               if( $showMore ==1){
                                ?>
                            <a target="_blank " href="<?php echo base_url('search/'.$search.'/solved-papers')?>"><span class="badge pull-right">MORE...</span></a>
                                <?php
                                $showMore++; 
                               }
                            }
                            $count++; 
                            
                               } 
                               ?>
                        </div>
                    </div>
                        </div>
                <?php } 
                if($any_result_found=='no'){
                    ?>
                 <div class="list-group">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <?php 
                                    
                                    echo "<span>No result found for ".urldecode($this->uri->segment(2))." !";
                               ?>
                            </h3>
                        </div>
                    </div>
                     
                     <div class="serve-top">
				 <div class="col-sm-6 col-md-6 serve-icons">
					<div class="s-sub ">
						<div class="col-md-2 icon text-warning">
						<i class="glyphicon glyphicon-globe"></i>
						</div>
						<div class="col-md-10 serve-text">
                                                <h3><a href="https://www.studyadda.com/notes">Notes
                                                </a></h3>
						<p>Theory &amp; Concepts Notes For JEE, NEET &amp; CBSE</p>
                                                <p>Short-Cuts &amp; Formulae For JEE, NEET &amp; CBSE</p> 
                                                <p>All Notes In Easy To Understand Language</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
					 <div class="s-sub ">
						<div class="col-md-2 icon text-primary">
						  <i class="glyphicon glyphicon-film"></i>
						</div>
						<div class="col-md-10 serve-text">
					     <h3><a href="https://www.studyadda.com/videos">Video Lectures</a></h3>
						 <p>More Than 3000 Video Lectures</p>
                                                 <p>Video Lectures By Lalit Sardana Sir &amp; Shweta Sardana Madam</p>
                                                 <p>Videos For IIT, Medical &amp; CBSE</p>

						</div>
					     <div class="clearfix"> </div>	
					 </div>
					 <div class="s-sub">
						<div class="col-md-2 icon text-success">
						  <i class="glyphicon glyphicon-briefcase"></i>
						</div>
						<div class="col-md-10 serve-text">
						 <h3><a href="https://www.studyadda.com/study-packages">Study Packages</a></h3>
						 <p>More Than 12000 Study Packages</p>
                                                 <p>Study Packages Of 1.5 Lakh Pages</p>
                                                 <p>For All Engineering &amp; Medical Exams</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
                                     <div class="s-sub">
						<div class="col-md-2 icon text-primary">
						  <i class="glyphicon glyphicon-certificate"></i>
						</div>
						<div class="col-md-10 serve-text">
						 <h3><a href="https://www.studyadda.com/solved-papers">Solved Papers</a></h3>
						 <p>Solved Papers Of 9th &amp; 10th CBSE CCE</p>
                                                 <p>12th CBSE Past Years Solved Papers</p>
                                                 <p>Solved papers Of More Than 50 Engineering &amp; Medical Exams</p>
                                                 <p>Also IIT-JEE &amp; NEET Solved Papers</p>
                                                 <p>Chapterwise &amp; Yearwise Solved Papers</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
                                     <div class="s-sub">
						<div class="col-md-2 icon text-danger">
						  <i class="glyphicon glyphicon-edit"></i>
						</div>
						<div class="col-md-10 serve-text">
						  <h3><a href="https://www.studyadda.com/onlinetest">Online Tests</a></h3>
						 <p>More Than 200 Online Tests</p>
                                                 <p>Chapterwise, Topicwise &amp; Subjectwise Tests</p>
                                                 <p>Comprehensive Analytical Reports</p>
                                                 <p>Topicwise &amp; Conceptwise Online Tests</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
				 </div>
				 <div class="col-sm-6 col-md-6 serve-icons">
					<div class="s-sub">
						<div class="col-md-2 icon text-success">
						  <i class="glyphicon glyphicon-screenshot"></i>
						</div>
						<div class="col-md-10 serve-text">
						<h3><a href="https://www.studyadda.com/ncert-solution">NCERT Solutions</a></h3>
						<p>NCERT Books Solutions For 6th To 12th</p>
                                                <p>NCERT Answers By Renowned Experts</p>
                                                <p>All NCERT Solutions Absolutely FREE</p>
                                                <p>Also Includes NCERT Exemplar Solutions</p>
                                                <p>All Subjects NCERT Solutions From 6th To 12th</p>
                                                </div>
					     <div class="clearfix"> </div>	
					 </div>
					 <div class="s-sub">
						<div class="col-md-2 icon text-danger">
						  <i class="glyphicon glyphicon-edit"></i>
						</div>
						<div class="col-md-10 serve-text">
						  <h3><a href="https://www.studyadda.com/articles">Articles</a></h3>
						  <p>More Than 5000 Articles On Popular Topics</p>
                                                  <p>Post Your Own Essays &amp; Articles</p>
                                                  <p>Only Portal To Find School Based Articles</p>
                                                  <p>Various Science &amp; Other Subjects Projects</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
                                     <div class="s-sub">
						<div class="col-md-2 icon text-success">
						  <i class="glyphicon glyphicon-folder-open"></i>
						</div>
						<div class="col-md-10 serve-text">
						  <h3><a href="https://www.studyadda.com/sample-papers">Sample Papers</a></h3>
						 <p>Sample Papers For CBSE CCE 9th &amp; 10th</p>
                                                 <p>Mock Papers For CBSE 11th &amp; 12th</p>
                                                 <p>Practice Papers For JEE &amp; NEET</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
                                        <div class="s-sub">
						<div class="col-md-2 icon text-primary">
						  <i class="glyphicon glyphicon-book"></i>
						</div>
						<div class="col-md-10 serve-text">
						  <h3><a href="https://www.studyadda.com/question-bank">Question Bank</a></h3>
						 <p>More Than 5 Lakh Questions</p>
                                                 <p>All Type Of Questions</p>
                                                 <p>Questions For School Level &amp; Competitive Exams</p>
                                                 <p>Topicwise &amp; Conceptwise Questions</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div> 
                                     <div class="s-sub">
						<div class="col-md-2 icon text-success">
						  <i class="glyphicon glyphicon-send"></i>
						</div>
						<div class="col-md-10 serve-text">
						  <h3><a href="https://www.studyadda.com/amazing-facts">Amazing Facts</a></h3>
						 <p>More Than 7 Lakh all Type Of Facts</p>  
                                                 <p>Facts For School Level &amp; Competitive Exams</p>
                                                 <p>Topicwise &amp; Conceptwise Facts</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
				 </div>
				 <div class="clearfix"> </div>		
	          </div>
                     
                 </div>
                <?php } 
                ?>
                
            </div>
            <div class="col-md-3 col-sm-3">
                <ul class="nav nav-pills nav-stacked search_rht_nav bs-component panel">
                    <li class="<?php echo $type=='all'?'btn-success':'btn-default'?>">
                        <a href="<?php echo base_url('search?query='.$search.'&search=all')?>">All
                            <span class="badge pull-right">
                        <?php echo $totalresults;?>
                            </span>
                        </a>
                    </li>
                    <li class="<?php echo $type=='videos'?'btn-success':'btn-default'?>"><a href="<?php echo base_url('search/'.$search.'/videos')?>">Videos<span class="badge pull-right"><?php echo $video_results_count;?></span></a></li>
                    <li class="<?php echo $type=='study-packages'?'btn-success':'btn-default'?>"><a href="<?php echo base_url('search/'.$search.'/study-packages')?>">Study Packages <span class="badge pull-right"><?php echo $studymaterial_results_count;?></span></a></li>
                    <li class="<?php echo $type=='notes'?'btn-success':'btn-default'?>"><a href="<?php echo base_url('search/'.$search.'/notes')?>">Notes <span class="badge pull-right"><?php echo $article_results_count;?></span></a></li>
                    <li class="<?php echo $type=='ncert-solution'?'btn-success':'btn-default'?>"><a href="<?php echo base_url('search/'.$search.'/ncert-solution')?>">NCERT Solutions <span class="badge pull-right"><?php echo $ncertsolutions_results_count;?></span></a></li>
                    <li class="<?php echo $type=='question-bank'?'btn-success':'btn-default'?>"><a href="<?php echo base_url('search/'.$search.'/question-bank')?>">Questions <span class="badge pull-right"><?php echo $question_results_count;?></span></a></li>
                    <li class="<?php echo $type=='sample-papers'?'btn-success':'btn-default'?>"><a href="<?php echo base_url('search/'.$search.'/sample-papers')?>">Sample Papers <span class="badge pull-right"><?php echo $samplepapers_results_count;?></span></a></li>
                    <li class="<?php echo $type=='solved-papers'?'btn-success':'btn-default'?>"><a href="<?php echo base_url('search/'.$search.'/solved-papers')?>">Solved Papers <span class="badge pull-right"><?php echo $solvedpapers_results_count;?></span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>