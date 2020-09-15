<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php if ($this->session->flashdata('update_msg')) { ?>
                <div class="alert alert-success alert-dismissible" id="success-alert" role="alert">
                    <strong><?php echo $this->session->flashdata('update_msg'); ?>
                    </strong>
                </div>
            <?php } ?>
            <?php if($this->session->flashdata('error_msg')) { ?>
            <div class="alert alert-danger alert-dismissible" id="success-alert" role="alert">
            <strong><?php echo $this->session->flashdata('error_msg'); ?></strong>
            </div>
            <?php } ?>
            <?php $this->load->view('customer/breadcrumb'); ?>
            <div class="col-md-3 col-sm-12 my_account"> 
            <?php $this->load->view('customer/menu'); ?>
            </div>            
            <div class="col-sm-12 col-md-9 dash_panel customer-packageModel" id="recent_orderdiv">
        <div class="row">
        <div class="col-lg-4 fixpack">
        <div class="panel-group" id="accordion1">
            <div class="panel panel-default">
                <div class="btn-success" style="padding:10px 15px;">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree"><i class="material-icons">assignment_returned</i> &nbsp; My Study Packages Subscription</a>
                    </h4> 
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
    <?php                                
             $saprat_package=array(); 
             if (isset($purchased_studymaterial) && count($purchased_studymaterial) > 0) { 
             ?>    <div class="panel-body"><?php
                    foreach ($purchased_studymaterial as $k => $v) {
						$i_cnt=1;
                                    $content = '';
                                    foreach ($v as $k1 => $v1) {
                                        if ($k == 1) {
                                        $content = 'study-packages';
                                        }

        $href = base_url($content);
					if(is_array($v1)){
					$details=NULL;
										}else{
                                        $details = $this->Pricelist_model->getDetails($v1);
                                        }
/*Get Subject list*/
                                        if(isset($details->subject_id)){
                                        $exam_id=$details->exam_id;
                                        }else{
                                        $exam_id=0;    
                                        }
                                        if(isset($details->subject_id)){
                                        $subject_id=$details->subject_id ;
                                        }else{
                                        $subject_id=0;    
                                        }
            if(isset($exam_id)){
            $purchased_data_array = array();
            $subjects_array = array();
            $chapters_array = array();
            $chaptersubjects = $this->Examcategory_model->getExamSubChapters($exam_id,$subject_id);
            if (count($chaptersubjects) > 0) {
                foreach ($chaptersubjects as $record) {
                    if (!in_array($record->sname, $subjects_array)) {
                    $subjects_array[$record->sid] = array('name' => $record->sname);
                    }
                    if ($subject_id > 0 && $subject_id == $record->sid) {
                        $sm = $this->Studymaterial_model->getStudyMaterialCount($exam_id, $record->sid, $record->cid);
                        if (!in_array($record->cname, $chapters_array)) {

                            $chapters_array[$record->cid] = array('name' => $record->cname, 'count' => count($sm));
                        } else {
                            $chapters_array[$record->cid]['count'] = count($sm);
                        }
                    }
                    //echo $record->sname.'....'.$record->cname.'<br>';
                    if (array_key_exists($record->sname, $purchased_data_array)) {
                        //$purchased_data_array[$record->name][]
                        array_push($purchased_data_array[$record->sname]['chapters'], array($record->cid, $record->cname));
                    } else {
                        $purchased_data_array[$record->sname]['id'] = $record->sid;
                        if (isset($purchased_data_array[$record->sname]['chapters'])) {
                            array_push($purchased_data_array[$record->sname]['chapters'], array($record->cid, $record->cname));
                        } else {
                            $purchased_data_array[$record->sname]['chapters'][0] = array($record->cid, $record->cname);
                        }
                    }
                }
            }
            }
            //print_r($purchased_data_array);
                /*End Get subject list*/  
                                        $name = $details->modules_item_name;  
                                        if($details->modules_item_id == 0 && $details->item_id == 0) {

                                            $href.= '/' . url_title($details->exam, '-', true) . '/' . $details->exam_id;
                                            if ($details->subject_id > 0) {
                                                $href.= '/' . url_title($details->subject, '-', true) . '/' . $details->subject_id;
                                            }
                                            if ($details->chapter_id > 0) {
                                                $href.= '/' . url_title($details->chapter, '-', true) . '/' . $details->chapter_id;
                                            }
                                     
                                                  
                                        } elseif ($details->modules_item_id > 0 && $details->item_id == 0) { 
                                            $href.= '/' . url_title($details->exam, '-', true);
                                            if ($details->subject_id > 0) {
                                                $href.= '/' . url_title($details->subject, '-', true);
                                            }
                                            if ($details->chapter_id > 0) {
                                                $href.= '/' . url_title($details->chapter, '-', true);
                                            }
                                            
                                            $href = '/' . url_title($details->modules_item_name, '-', true) . '/' . $details->modules_item_id;
                                             
                                        } elseif ($details->item_id > 0) {
                                            $this->load->model('File_model');
                                            $itemdetail = $this->File_model->getStudyPackageDetails($details->item_id);
                                            $name = $itemdetail->displayname ? $itemdetail->displayname : $itemdetail->filename;
                                            $href.= '/' . url_title($itemdetail->exam, '-', true);
                                            if ($itemdetail->chapter) {
                                                $href.= '/' . url_title($itemdetail->chapter, '-', true);
                                            } else {
                                                $href.='/all';
                                            }
                                            if ($itemdetail->subject) {
                                                $href.= '/' . url_title($itemdetail->subject, '-', true);
                                            } else {
                                                $href.='/all';
                                            }
                                            $href.='/' . url_title($itemdetail->name, '-', true);
                                            $href.='/' . url_title($itemdetail->filename, '-', true) . '/' . $itemdetail->id; 
                                        }                        
                                       if(isset($itemdetail)){
                                              if($details->item_id<1){ 
                                                ?>    <div class="panel-group" id="accordion_<?php echo $i_cnt; ?>">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion_<?php echo $i_cnt; ?>" href="#collapseThreeOne_<?php echo $i_cnt; ?>"><?php echo $name ?><!--<i class="material-icons">arrow_forward</i>-->
                                        </a></h4>
                                </div> 
                                <div id="collapseThreeOne_<?php echo $i_cnt; ?>" class="panel-collapse collapse in">
    <?php 
     $examarray= explode('/',$href); 
     $examarray_count=count($examarray);
     $url_examid =$examarray[5];
     $url_examname =url_title($examarray[4]);  
    foreach($purchased_data_array as $pkey=>$pvalue){
     //$subjecturl = $href.'/'.url_title($pkey, '-', true).'/'.$pvalue['id'];
     $subjecturl=base_url('study-packages').'/'.$url_examname.'/'.$url_examid.'/'.url_title($pkey,'-',TRUE).'/'. $pvalue['id'];
     ?>
                                    <?php /*onclick="showbought_subject('<?php echo $url_examname; ?>',<?php echo $url_examid; ?>,'<?php echo $pkey; ?>',<?php echo $pvalue['id']; ?>)"*/ ?>
                                    <div class="panel-body mainpacages"><a href="<?php echo $subjecturl; ?>" target="_blank"><?php echo $pkey; ?></a></div>
                                    <!--<a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree" class="collapsed" aria-expanded="false"></a>-->
                                    <?php } ?>
                                </div></div>
       </div>
                                            <?php  
                                              }  else { 
                                              $saprat_package[]=array($itemdetail->id,$name);
                                                ?>
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a data-toggle="collapse" data-parent="#accordion_<?php echo $i_cnt; ?>" href="#collapseThreeOne_<?php echo $i_cnt; ?>"><?php echo $name ?>
                                     </a>
                                    </h4>
                                </div>
                                <div id="collapseThreeOne_<?php echo $i_cnt; ?>" class="panel-collapse collapse in"><div class="panel-body"><a href="<?php echo base_url('study-packages/download/'.encrypt($itemdetail->id.'.'.$this->session->userdata('customer_id')))?>" target="_blank">Download Now</a></div></div>

 <?php   
                                              
                                              }
                                         }else{
                                                                              ?>    <div class="panel-group" id="accordion_<?php echo $i_cnt; ?>">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                   <h4 class="panel-title">
                                   <a href="#collapseThree" class="collapsed" aria-expanded="false" data-toggle="collapse" data-parent="#accordion_<?php echo $i_cnt; ?>" href="#collapseThreeOne_<?php echo $i_cnt; ?>"><?php echo $name ?><i class="material-icons">arrow_forward</i>
                                        </a></h4>
                                </div>
                                <div id="collapseThreeOne_<?php echo $i_cnt; ?>" class="panel-collapse collapse in">
                                  <?php 
     $examarray= explode('/',$href); 
     $examarray_count=count($examarray);
     if($examarray_count==8){         
     $url_examid =$examarray[$examarray_count-3];
     $url_examname =url_title($examarray[$examarray_count-4]);
     $url_subjectid =$examarray[$examarray_count-1];
     $url_subjectname =url_title($examarray[$examarray_count-2]);
     }else{
     $url_examid =$examarray[$examarray_count-1];
     $url_examname =url_title($examarray[$examarray_count-2]);
      $url_subjectid =0;
     $url_subjectname =0;
     }
	 foreach($purchased_data_array as $pkey=>$pvalue){ 
		 if(($url_subjectid==$pvalue['id'])&&(strtolower(url_title($url_subjectname))==strtolower(url_title($pkey)))){
     $subjecturl = $href;
         }else{
     $subjecturl = $href.'/'.url_title($pkey, '-', true).'/'.$pvalue['id'];
         }         
     $sm_arr = $this->Studymaterial_model->getStudyMaterialCount($exam_id, $pvalue['id'], 0);
              $sm_c=count($sm_arr);
              if($sm_c>0){
     ?>
        <div class="panel-body" onclick="showbought_subject('<?php echo $url_examname; ?>',<?php echo $url_examid; ?>,'<?php echo $pkey; ?>',<?php echo $pvalue['id']; ?>)">
        <a href="<?php echo $subjecturl; ?>"><?php echo $pkey?></a>
        </div>
            <!--data-toggle="collapse" data-parent="#accordion1" class="collapsed" aria-expanded="false" data-toggle="collapse"-->
                                    
     <?php 
     
              } 
     
     } ?>                       </div>
                                    </div>
       </div>
<?php 
}
?>   
<?php   $i_cnt++;
          }
          }
          ?>
		  </div> <?php
                
          }else{
             ?>  
            <div class="panel-body text-center text-success">You have not purchased any study package.
                    <p class="text-uppercase text-lg-center"><a href="<?php echo base_url().'study-packages';?>"><span class="label label-success">Buy Now</span></a></p>
             </div>
             <?php 
              
          }
          ?>
                    
                </div>
                
            </div>

        </div>  </div> 
            <!--Video Section Start-->
            <div class="col-lg-4 fixpack">
           <div class="panel-group">               
        <div class="panel panel-default">     
             <div class="btn-warning" style="padding:10px 15px;">
              <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse2"><i class="material-icons">ondemand_video</i> &nbsp; My Video Subscription</a>
        </h4>
            </div>
      <div id="collapse2" class="panel-collapse collapse">
          <?php if (isset($purchased_videos) && count($purchased_videos) > 0) {
			
                                foreach ($purchased_videos as $k => $v) {
                                    
               foreach ($v as $k1 => $v1) {
								   $href = base_url('videos');
if(is_array($v1)){
										$details=NULL;
										}else{
										$details = $this->Pricelist_model->getDetails($v1);  
										}
                                   
                                     $name = $details->modules_item_name; 
                                    
                                    if ($details->modules_item_id == 0 && $details->item_id == 0) {

                                        $href.= '/' . url_title($details->exam, '-', true) . '/' . $details->exam_id;
                                        if ($details->chapter_id > 0) {
                                            $href.= '/' . url_title($details->chapter, '-', true) . '/' . $details->chapter_id;
                                        }
                                        if ($details->subject_id > 0) {
                                            $href.= '/' . url_title($details->subject, '-', true) . '/' . $details->subject_id;
                                        }
                                    }
                                    if ($details->modules_item_id > 0) {
                                        $href.= '/' . url_title($details->exam, '-', true);
                                        if ($details->chapter_id > 0) {
                                            $href.= '/' . url_title($details->chapter, '-', true);
                                        }
                                        if ($details->subject_id > 0) {
                                            $href.= '/' . url_title($details->subject, '-', true);
                                        }
                                        $href = '/' . url_title($details->modules_item_name, '-', true) . '/' . $details->modules_item_id;
                                    }
                                    
                                    ?><div class="panel-body"><a href="<?php echo $href; ?>" target="_blank"><?php echo $details->modules_item_name ?></a></div><?php
                                }}
          }else{
              ?>
                  <div class="panel-body text-center text-success">You have not purchased any video.
                                    <p class="text-uppercase text-lg-center"><a href="<?php echo base_url().'videos';?>"><span class="label label-success">Buy Now</span></a></p></div>
<?php
          }
?>      
      </div> 
    </div>
  </div>
  
                </div> 
                   <div class="col-lg-4 fixpack">
                       <!--Test Series-->
      <div class="panel-group">               
      <div class="panel panel-default">     
       <div class="btn-primary" style="padding:10px 15px;">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse3"><i class="material-icons">speaker_notes</i> &nbsp; My Test Series Subscription</a>
        </h4>
        </div>
      <div id="collapse3" class="panel-collapse collapse">          
          <?php
     
          if (isset($purchased_onlinetest) && count($purchased_onlinetest) > 0) {
          foreach ($purchased_onlinetest as $k => $v) {
                                     $href = base_url('online-test');
                                     if(!is_array($v)){
                                      $v=array($v);   
                                     }
									    foreach ($v as $k1 => $v1) {
							if(is_array($v1)){
											$details=NULL;
										}else{
                                    $details = $this->Pricelist_model->getDetails($v1);   //print_r($details);
										}
                                     $name = $details->modules_item_name; 
                                    
                                    if ($details->modules_item_id == 0 && $details->item_id == 0) {

                                        $href.= '/' . url_title($details->exam, '-', true) . '/' . $details->exam_id;
                                        if ($details->chapter_id > 0) {
                                            $href.= '/' . url_title($details->chapter, '-', true) . '/' . $details->chapter_id;
                                        }
                                        if ($details->subject_id > 0) {
                                            $href.= '/' . url_title($details->subject, '-', true) . '/' . $details->subject_id;
                                        }
                                    }
                                    if ($details->modules_item_id > 0) {
                                        $href.= '/' . url_title($details->exam, '-', true);
                                        if ($details->chapter_id > 0) {
                                            $href.= '/' . url_title($details->chapter, '-', true);
                                        }
                                        if ($details->subject_id > 0) {
                                            $href.= '/' . url_title($details->subject, '-', true);
                                        }
                                        $href = '/' . url_title($details->modules_item_name, '-', true) . '/' . $details->modules_item_id;
                                    }
                                    
                                    ?><div class="panel-body"><a href="<?php echo $href; ?>" target="_blank"><?php echo $details->modules_item_name ?></a></div>
                                <?php
                                }}
          }else{
          ?>
          <div class="panel-body text-center text-success">You have not purchased any Test Series.
                                    <p class="text-uppercase text-lg-center"><a href="<?php echo base_url().'online-test';?>"><span class="label label-success">Buy Now</span></a></p></div>                                <?php } ?>
      </div>
      </div>
      </div>
                    </div> 
      </div>
            </div>
            <?php 
            $showsaprate='no'; 
            if($showsaprate=='yes'){ 
                if(count($saprat_package)>1){ ?>
            <div class="row">
    <div class="col-sm-12 col-md-12">    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/shelf_files/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/shelf_files/mainbook.css">
    <script src="<?php echo base_url(); ?>assets/shelf_files/ga.js"></script><script src="<?php echo base_url(); ?>shelf_files/modernizr-2.js"></script>       
        <div class="shelf owned col-sm-12 col-md-12">
            <ul class="books clearfix">
                <?php
                
                foreach($saprat_package as $k=>$v){
                $rnd_nm=rand(1,5);
?><div class="col-sm-12 col-md-4">
                <li id="html5webdesigners" class="book col-sm-12 col-md-4">
                    <div class="containerbook"><img class="front" src="<?php echo base_url(); ?>assets/shelf_files/bookapart-<?php echo $rnd_nm; ?>.jpg" alt="<?php echo $v[1]; ?>"><span class="centered"><h3><?php echo $v[1]; ?></h3><a href="<?php echo base_url('study-packages/download/'.encrypt($v[0].'.'.$this->session->userdata('customer_id')))?>" target="_blank" ><button type="button" class="btn">Download Now</button></a></span>
                    </div>
                    <div class="back">
                        <div class="p10 centered" style="position: absolute;top: 25px;right: 16px;">
                            <div class="rating star-4">
                                <ol>
                                    <li><a href="<?php echo base_url('study-packages/download/'.encrypt($v[0].'.'.$this->session->userdata('customer_id')))?>" target="_blank" >Download</a>
                                    </li>
                                </ol>
                            </div>
                         
                        </div>
                    </div>
                </li>
</div>
                <?php }  ?>
            </ul>
        </div>
    </div>  </div>
            <?php
            }}
            ?>
        </div>
            <!--<div id="showbught_result" class="my_account_right"></div>-->
    </div>
</div>       