<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php $this->load->view('common/breadcrumb');?>
      <!--<div class="col-md-3 col-sm-3"> 
          <?php //echo $this->load->view('common/leftnav');?> 
      </div>
      -->
        <div class="col-md-12 col-sm-12"> 
          <?php 
          
                 if($isProduct){ 
                  //echo "This is product area.";
                  $this->load->view('common/productdetailsnew');
                  } 
                  
                 if($isProduct_array){ 
          $this->load->view('common/product_testseries'); 
                 } ?>
        <div id="page-inner" class="exam_page_cont">
          <!-- /. ROW  -->
          <div class="row">
              <?php if(isset($productslist) && count($productslist) > 0){ 
                  $this->load->view('common/productslistnew');
              }else{
                  echo "We are uploading more Video/Packages.Please keep visiting Studyadda.com.";
              ?>
              <br> <br>  <br> 
              <?php
              }
              ?>
              <?php 
              if(count($qb) > 0){ ?>
              <div class="clearfix"></div>
            <div class="col-md-6 col-sm-6">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h4 class="col-sm-12 col-md-7"><?php echo $qb_package; ?> Question Banks</h4>
                  <span class="col-md-5 text-right nopadding">(<?php echo $qb_questions?> Questions)</span> <div class="clearfix"></div> </div>
                <div class="panel-body">
                  <ul>
                    <?php $cc=0; foreach($qb as $qbdata){ ?>
                      <li>
                          <i class="material-icons icon_bullet">question_answer</i> <a title="<?php echo $qbdata->name; ?>" href="<?php echo generateContentLink('question-bank',$qbdata->exam,$qbdata->subject,$qbdata->chapter,$qbdata->name,$qbdata->id);?>">
                      <?php 
                                
                                    echo $qbdata->name;
                                
                                ?> Question Bank</a>
                      </li>
                    <?php $cc++;
                            //if($cc==10) break;                            
                            } ?>
                  </ul>
                </div>
                  <div class="panel-footer"> <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; <a title="Question Banks" href="<?php echo base_url('question-bank/'.$path)?>">View All</a> </div>
              </div>
            </div>
              <?php }?>
              <?php if(count($sp) > 0){ ?>
            <div class="col-md-6 col-sm-6">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h4 class="col-sm-12 col-md-7"><?php echo $sp_package; ?> Sample Papers</h4>
                  <span class="col-md-5 text-right nopadding"> (<?php echo $sp_questions?> Questions)</span> <div class="clearfix"></div> </div>
                <div class="panel-body">
                  <ul>
                    <?php $cc=0; foreach($sp as $spdata){ ?>
                    <li>
                        <i class="material-icons icon_bullet">picture_as_pdf</i> <a  title="<?php echo $spdata->name; ?>" href="<?php echo generateContentLink('sample-papers',$spdata->exam,$spdata->subject,$spdata->chapter,$spdata->name,$spdata->id);?>">
                      <?php 
                                
                                    echo str_pad($spdata->name,  strlen($spdata->name)+1," ",STR_PAD_LEFT);;
                                
                                    ?></a>
                    </li>
                    <?php $cc++;
                            //if($cc==10) break;                            
                            } ?>
                  </ul>
                </div>
                  <div class="panel-footer"> <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; <a title="Sample Papers" href="<?php echo base_url('sample-papers/'.$path)?>">View All</a></div>
              </div>
            </div>
              <?php } ?>
              <?php if(count($vid) > 0){ ?>
            <div class=" col-sm-6 col-md-6">
              <div class="panel panel-warning">
                <div class="panel-heading">
                  <h4 class="col-md-7 col-sm-12"><?php echo $video_package; ?> Video Lecture Series</h4>
                  <span class="col-md-5 text-right nopadding"><?php echo $videos_questions; ?> Videos</span> <div class="clearfix"></div> </div>
                <div class="panel-body">
                  <ul>
                    <?php $cc=0; foreach($vid as $playlist){ ?>
                    <li>
                        <i class="material-icons icon_bullet">videocam</i>  <a title="<?php echo $playlist->name; ?>" href="<?php echo generateContentLink('videos',$playlist->exam,$playlist->subject,$playlist->chapter,$playlist->name,$playlist->id);?>">
                        <?php echo $playlist->name?>
                        </a></li>
                    <?php $cc++;
                            //if($cc==10) break;                            
                            } ?>
                    
                  </ul>
                </div>
                  <div class="panel-footer"> <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; <a  title="Video" href="<?php echo base_url('videos/'.$path)?>">View All</a></div>
              </div>
            </div>
              <?php } ?>
              <?php if(isset($ot) && count($ot) > 0){ ?>
            <!--<div class=" col-sm-6 col-md-6">
              <div class="panel panel-danger">
                <div class="panel-heading">
                  <h4 class="col-sm-12 col-md-7"><?php echo $ot_package; ?> Online Tests</h4>
                  <span class="col-md-5 text-right nopadding"><?php echo count($ot_questions)?> Questions</span> <div class="clearfix"></div> </div>
                <div class="panel-body">
                  <ul>
                    <?php $cc=0; foreach($ot as $test){ ?>
                    <li>
                        <i class="material-icons icon_bullet">computer</i><a href="<?php echo generateContentLink('online-test',$test->exam,$test->subject,$test->chapter,$test->name,$test->id);?>">
                        <?php echo $test->name?>
                        </a></li>
                    <?php $cc++;
                            //if($cc==10) break;                            
                            } ?>
                    
                  </ul>
                </div>
                <div class="panel-footer"> 
                    <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; 
                    <a href="<?php echo base_url('online-test/'.$path)?>">View All</a></div>
              </div>
            </div>-->
              <?php } ?>
              <?php if(count($sm) > 0){ ?>
              <div class="col-md-6 col-sm-6">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h4 class="col-sm-12 col-md-7"><?php echo $stpac_package; ?> Study Packages</h4>
                  <span class="col-md-5 text-right nopadding"><?php echo $stpac_questions?> Files</span> <div class="clearfix"></div> </div>
                <div class="panel-body">
                  <ul>
                    <?php $cc=0; foreach($sm as $list){ ?>
                    <li>
                        <i class="material-icons icon_bullet">import_contacts</i> <a title="<?php echo $list->name; ?>" href="<?php echo generate_stmt_ContentLink('study-packages',$list->exam,$list->subject,$list->chapter,$list->name,$list->id);?>"><?php echo $list->name?></a></li>
                    <?php $cc++;
                            //if($cc==10) break;                            
                            } ?>
                    
                  </ul>
                </div>
                <div class="panel-footer"> 
                    <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; 
                    <a title="Study Packages" href="<?php echo base_url('study-packages/'.$path)?>">View All</a></div>
              </div>
            </div>
              <?php } ?>
            <?php if(count($solvedp) > 0){ ?>
            <div class="col-md-6 col-sm-6">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h4 class="col-sm-12 col-md-7"><?php echo $solpap_package; ?> Solved Papers</h4>
                  <span class="col-md-5 text-right nopadding"> (<?php echo $solpap_questions?> Questions)</span> <div class="clearfix"></div> </div>
                <div class="panel-body">
                  <ul>
                    <?php $cc=0; foreach($solvedp as $spdata){ ?>
                    <li>
                        <i class="material-icons icon_bullet">picture_as_pdf</i> <a  title="<?php echo $spdata->name; ?>" href="<?php echo generateContentLink('solved-papers',$spdata->exam,$spdata->subject,$spdata->chapter,$spdata->name,$spdata->id);?>">
                      <?php 
                                
                                    echo str_pad($spdata->name,  strlen($spdata->name)+1," ",STR_PAD_LEFT);;
                                
                                    ?></a>
                    </li>
                    <?php $cc++;
                            //if($cc==10) break;                            
                            } ?>
                  </ul>
                </div>
                  <div class="panel-footer"> <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; <a title="Solved Papers" href="<?php echo base_url('solved-papers/'.$path)?>">View All</a></div>
              </div>
            </div>
              <?php } ?>
              <?php if(count($ar) > 0){ ?>
              <div class="col-md-6 col-sm-6">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h4 class="col-sm-12 col-md-7"><?php echo $notes_package; ?> Notes</h4>
                   <span class="col-md-5 text-right nopadding"> <!--(<?php //echo $notes_questions; ?> Questions--></span> <div class="clearfix"></div></div>
                <div class="panel-body">
                  <ul>
                    <?php $cc=0; foreach($ar as $list){ ?>
                    <li>
                        <i class="material-icons icon_bullet">speaker_notes</i>  <a title="<?php echo $list->title?>" href="<?php echo generateContentLink('notes',$list->exam,$list->subject,$list->chapter,$list->title,$list->id);?>">
                        <?php echo $list->title?>
                        </a></li>
                    <?php $cc++;
                            //if($cc==10) break;                            
                            } ?>
                    
                  </ul>
                </div>
                <div class="panel-footer"> 
                    <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; 
                    <a title="Notes" href="<?php echo base_url('notes/'.$path)?>">View All</a></div>
              </div>
            </div>
              <?php } ?>
              <?php if(count($ncert) > 0){ ?>
              <div class=" col-sm-6 col-md-6">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h4 class="col-sm-12 col-md-7">Ncert Solutions for <?php echo $ns_package; ?> Chapters</h4><span class="col-md-5 text-right nopadding"> (<?php echo $ns_questions; ?> Questions)</span>
                  <div class="clearfix"></div> </div>
                <div class="panel-body">
                  <ul>
                    <?php $cc=0; foreach($ncert as $list){ ?>
                    <li>
                        <i class="material-icons icon_bullet">speaker_notes</i>  <a title="<?php echo $list->name?>" href="<?php echo generateContentLink('ncert-solution',$list->exam,$list->subject,$list->chapter,$list->name,$list->id);?>">
                        <?php echo $list->name?>
                        </a></li>
                    <?php $cc++;
                            //if($cc==10) break;                            
                            } ?>                    
                  </ul>
                </div>
                <div class="panel-footer"> 
                    <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; 
                    <a title="Ncert Solutions" href="<?php echo base_url('ncert-solution/'.$path)?>">View All</a></div>
              </div>
            </div>
              <?php } ?>
          </div>
        </div>
            
            
      <div class="row">
                   
          <?php if($qb_package>0){ ?>
    <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
    <div class="col-md-4 text-center">
        <p class="detail_product_img">  
            <img width="100px" height="100px" src="<?php echo show_product_thumb('question_bank.png', 100, 100); ?>" alt="Question Bank" class="img-rounded img-responsive"> 
        </p>
    </div>
    <div class="col-md-8 section-box">
        <h4>
           Question Bank
        </h4>
        <div class="view_det_shop row">
            
        <?php if($qb_package>0){ ?>
                               <i class="material-icons">check</i> Total Question Banks  : <span> <strong><?php echo $qb_package; ?>+</strong></span>
        <?php } if($qb_questions>0){ ?><br>
                               <i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $qb_questions; ?></strong> </span>
                               <?php } ?>
                                
       </div> 
    </div>
              </div>
          
          <?php } if($sp_package>0){ ?>
      <!--Sample Papers-->    
              <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
    <div class="col-md-4 text-center">
        <p class="detail_product_img">  <img  width="100px" height="100px" src="<?php echo show_product_thumb('sample_papers.png', 100, 100); ?>" alt="Sample Papers" class="img-rounded img-responsive"> 
        </p>
    </div>
    <div class="col-md-8 section-box">
        <h4>
           Sample Papers
        </h4>
        <div class="view_det_shop row">
            
        <?php if($sp_package>0){ ?>
                               <i class="material-icons">check</i> Total Sample Papers: <span> <strong><?php echo $sp_package; ?>+</strong></span>
        <?php } if($sp_questions>0){ ?><br>
                               <i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $sp_questions; ?></strong> </span>
                               <?php } ?>
                                
       </div> 
    </div>
              </div>
      <?php } ?>

          
          <?php if($video_package>0){ ?>
          <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
          <!--  Video Lecture Series-->
    <div class="col-md-4 text-center">
        <p class="detail_product_img">  <img  width="100px" height="100px" src="<?php echo show_product_thumb('video_lecture_series.png', 100, 100); ?>" alt="Video Lecture Series" class="img-rounded img-responsive"> 
        </p>
    </div>
    <div class="col-md-8 section-box">
        <h4>
           Video Lecture Series
        </h4>
        <div class="view_det_shop row">
            
        <?php if($video_package>0){ ?>
                               <i class="material-icons">check</i> Total Lecture Series : <span> <strong><?php echo $video_package; ?>+</strong></span>
        <?php } if($videos_questions>0){ ?><br>
                               <i class="material-icons">check</i> Total Videos : <span> <strong><?php echo $videos_questions; ?></strong> </span>
                               <?php } ?>
                                
       </div> 
    </div>
          </div><div class="clearfix"> </div>
          <?php } if($ot_package>0){ ?>
      <!--Online Test-->    
              <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
    <div class="col-md-4 text-center">
        <p class="detail_product_img">  <img  width="100px" height="100px" src="<?php echo show_product_thumb('online_test.png', 100, 100);?>" alt="online test" class="img-rounded img-responsive"> 
        </p>
    </div>
    <div class="col-md-8 section-box">
        <h4>
           Online Test
        </h4>
        <div class="view_det_shop row">
            
        <?php if($ot_package>0){ ?>
                               <i class="material-icons">check</i> Total Online Test: <span> <strong><?php echo $ot_package; ?>+</strong></span>
        <?php } if($ot_questions>0){ ?><br>
                               <i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $ot_questions; ?></strong> </span>
                               <?php } ?>
                                
       </div> 
    </div>
              </div>
      <?php } ?>
     
          <?php if($stpac_package>0){ ?>
          <!-- Study Packages-->
              <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
    <div class="col-md-4 text-center">
        <p class="detail_product_img">  <img  width="100px" height="100px" src="<?php echo show_product_thumb('study_packages.png', 100, 100); ?>" alt="Study Packages" class="img-rounded img-responsive"> 
        </p>
    </div>
    <div class="col-md-8 section-box">
        <h4>
            Study Packages
        </h4>
        <div class="view_det_shop row">
            
        <?php if($stpac_package>0){ ?>
                               <i class="material-icons">check</i> Total Study packages :<span> <strong><?php echo $stpac_package; ?>+</strong></span>
        <?php } if($stpac_questions>0){ ?><br>
                               <!--<i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $stpac_questions; ?></strong> </span>-->
                               <?php } ?>
                                
       </div> 
    </div>
              </div>  
          <?php  } if($solpap_package>0){ ?>
      <!--Solved Papers-->    
              <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
    <div class="col-md-4 text-center">
        <p class="detail_product_img">  <img  width="100px" height="100px" src="<?php echo show_product_thumb('solved_papers.png', 100, 100); ?>" alt="Solved Papers" class="img-rounded img-responsive"> 
        </p>
    </div>
    <div class="col-md-8 section-box">
        <h4>
           Solved Papers
        </h4>
        <div class="view_det_shop row">
            
        <?php if($solpap_package>0){ ?>
                               <i class="material-icons">check</i> Total Solved Papers: <span> <strong><?php echo $solpap_package; ?>+</strong></span>
        <?php } if($solpap_questions>0){ ?><br>
                               <i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $solpap_questions; ?></strong> </span>
                               <?php } ?>
                                
       </div> 
    </div>
              </div>
      <?php } ?>
<div class="clearfix"> </div>
                      
          <?php if($notes_package>0){ ?>
      
      <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
          <!-- Notes-->
    <div class="col-md-4 text-center">
        <p class="detail_product_img">  <img  width="100px" height="100px" src="<?php echo show_product_thumb('notes.png', 100, 100); ?>" alt="Notes" class="img-rounded img-responsive"> 
        </p>
    </div>
    <div class="col-md-8 section-box">
        <h4>
            Notes
        </h4>
        <div class="view_det_shop row">
            
        <?php if($notes_package>0){ ?>
                               <i class="material-icons">check</i> Total Notes :<span> <strong><?php echo $notes_package; ?>+</strong></span>
        <?php } if($notes_questions>0){ ?><br>
                               <!--<i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $stpac_questions; ?></strong> </span>-->
                               <?php } ?>
                                
       </div> 
    </div>
      </div>
      <!--Ncert Solutions -->    
          <?php } if($ns_package>0){ ?>
      <div class="col-xm-6 col-md-4 col-sm-6 col-md-6">
    <div class="col-md-4 text-center">
        <p class="detail_product_img">  <img   width="100px" height="100px" src="<?php echo show_product_thumb('ncert_solutions.png', 100, 100); ?>" alt="Ncert Solutions" class="img-rounded img-responsive"> 
        </p>
    </div>
    <div class="col-md-8 section-box">
        <h4>
           NCERT Solutions
        </h4>
        <div class="view_det_shop row">
            
        <?php if($ns_package>0){ ?>
                               <i class="material-icons">check</i> Total NCERT Chapters : <span> <strong><?php echo $ns_package; ?>+</strong></span>
        <?php } if($ns_questions>0){ ?><br>
                               <i class="material-icons">check</i> Total Questions : <span> <strong><?php echo $ns_questions; ?></strong> </span>
                               <?php } ?>
                                
       </div> 
    </div>
      </div>
      <?php  } ?>
</div>
      </div>
      <!-- /. PAGE INNER  -->
    </div>
  </div>
</div>
