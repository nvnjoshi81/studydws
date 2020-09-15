<div id="wrapper">
    <div class="container" id="container_top">
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
            <div class="col-sm-12 col-md-9 dash_panel customer-packageModel" id="recent_orderdiv"> <div id="showbught_result"></div>
                <div class="row">
        <div class="col-lg-12 fixpack">
           <div class="panel-group" id="accordion1">
            <div class="panel panel-default">
        <div class="btn-success" style="padding:10px 15px;">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree"><i class="material-icons">assignment_returned</i> &nbsp; My Study Packages Subscription</a>
                    </h4> 
        </div>
                <div id="collapseThree" class="panel-collapse collapse">
                    
                    <?php if (isset($purchased_studymaterial) && count($purchased_studymaterial) > 0) {               
                   $hrefbuy_fullpackages=''; 
             ?>    <div class="panel-body"><?php
                                foreach ($purchased_studymaterial as $k => $v) {                                $i_cnt=1;
                                    $content = '';
                                    foreach ($v as $k1 => $v1) {
                                        if ($k == 1) {
                                            $content = 'study-packages';
                                        }
                                        $href = base_url($content);
                                        $content_fullpackages=base_url($content);
                                        $details = $this->Pricelist_model->getDetails($v1);
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
            $chaptersubjects = $this->Examcategory_model->getExamChapters($exam_id);
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
                /*End Get subject list*/                          
                                        $name = $details->modules_item_name;  
                                        if($details->modules_item_id == 0 && $details->item_id == 0) {
$hrefbuy_fullpackage = $content_fullpackages.'/' . url_title($details->exam, '-', true) . '/' . $details->exam_id;
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
                                            $hrefbuy_fullpackage = $content_fullpackages.'/' . url_title($itemdetail->exam, '-', true) . '/' . $itemdetail->exam_id;
                                        }                                        
                                        ?>  

                        <div class="panel-group" id="accordion_<?php echo $i_cnt; ?>">
                            <div class="panel panel-default">
                                        <?php if(isset($itemdetail)){
                                              if($details->item_id<1){ 
                                                ?>
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                              <a data-toggle="collapse" data-parent="#accordion_<?php echo $i_cnt; ?>" href="#collapseThreeOne_<?php echo $i_cnt; ?>"><?php echo $name; ?>
                                        </a><?php  /*If subject id is grater than zero means user brought subject*/
                                        if($details->subject_id>0){ ?><a href="<?php echo $hrefbuy_fullpackage; ?>" style="color:green" target="_blank">Buy Complete Course<i class="material-icons">arrow_forward</i></a><?php } ?></h4>
                                </div> 
                                <div id="collapseThreeOne_<?php echo $i_cnt; ?>" class="panel-collapse collapse in">
                                     <?php 
     $examarray= explode('/',$href); 
     $examarray_count=count($examarray);
     $url_examid =$examarray[$examarray_count-1];
     $url_examname =$examarray[$examarray_count-2];
     $mainExamName=$examarray[4];
     $mainExamid=$examarray[5];
     /*If subject id is grater than zero means user brought subject*/
     if($details->subject_id>0){
         /*User brought subject only*/ foreach($purchased_data_array as $pkey=>$pvalue){
                                    if($details->subject_id==$pvalue['id']){
     ?>
                                    <div class="panel-body"><a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree" class="collapsed" aria-expanded="false"><?php echo $pkey;  ?></a>
                                    </div>
                                    <div class="well well-sm text-center my-5"><?php 
                                        foreach($purchased_data_array[$pkey]['chapters'] as $chaptArr){                
                              ?>	
  <label class="btn btn-success active"  onclick="showbought_subject('<?php echo url_title($mainExamName); ?>',<?php echo $mainExamid; ?>,'<?php echo url_title($pkey); ?>',<?php echo $pvalue['id']; ?>,'<?php echo url_title($chaptArr[1]); ?>','<?php echo $chaptArr[0] ?>')">
    <button class="btn btn-sm btn-outline-secondary" type="button"><?php  echo $chaptArr[1]; ?></button>
  </label>

                                  <?php       
                                       
                                       }
                                    
                                    ?></div>
                                    <?php }
                                        
                                        }
     }else{
         /*User brought complete package*/ 
         foreach($purchased_data_array as $pkey=>$pvalue){
                                    
     ?>
                                    <div class="panel-body"><a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree" class="collapsed" aria-expanded="false"><?php echo $pkey;  ?></a></div>
                                    <div class="well well-sm text-center my-5"><?php 
                                        foreach($purchased_data_array[$pkey]['chapters'] as $chaptArr){                
                              ?>	
  <label class="btn btn-success active"  onclick="showbought_subject('<?php echo url_title($url_examname); ?>',<?php echo $url_examid; ?>,'<?php echo url_title($pkey); ?>',<?php echo $pvalue['id']; ?>,'<?php echo url_title($chaptArr[1]); ?>','<?php echo $chaptArr[0] ?>')">
    <button class="btn btn-sm btn-outline-secondary" type="button"><?php  echo $chaptArr[1]; ?></button>
  </label>

                                  <?php       
                                       
                                       }
                                    
                                    ?></div>
                                    <?php 
                                        
                                   
                                    
                                        }
     }
     
                                    ?>
                                </div>
                                            <?php  
                                              }  else{
                                                ?>
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a data-toggle="collapse" data-parent="#accordion_<?php echo $i_cnt; ?>" href="#collapseThreeOne_<?php echo $i_cnt; ?>"><?php echo $name ?>
                                        </a><?php  /*If user brought pdf only*/
                                        if($details->subject_id>0){ ?><a href="<?php echo $hrefbuy_fullpackage; ?>" style="color:green" target="_blank">Buy Complete Course<i class="material-icons">arrow_forward</i></a><?php } ?></h4>
                                </div>
                                
                                <div id="collapseThreeOne_<?php echo $i_cnt; ?>" class="panel-collapse collapse in"><div class="panel-body"><a href="<?php echo base_url('study-packages/download/'.encrypt($itemdetail->id.'.'.$this->session->userdata('customer_id')))?>" target="_blank">Download Now</a></div></div>

 <?php   
                                              }
                                        }else{
                                            ?>
                                <div class="panel-heading">
                                   <h4 class="panel-title">
                                   <a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree" class="collapsed" aria-expanded="false" data-toggle="collapse" data-parent="#accordion_<?php echo $i_cnt; ?>" href="#collapseThreeOne_<?php echo $i_cnt; ?>"><?php echo $name ?><!--<i class="material-icons">arrow_forward</i>-->
                                        </a></h4>
                                </div>
                                <div id="collapseThreeOne_<?php echo $i_cnt; ?>" class="panel-collapse collapse in">
     <?php 
     $examarray= explode('/',$href); 
     $examarray_count=count($examarray);
     $url_examid =$examarray[$examarray_count-3];
     $url_examname =$examarray[$examarray_count-4];
    foreach($purchased_data_array as $pkey=>$pvalue){
     //$subjecturl = $href.'/'.url_title($pkey, '-', true).'/'.$pvalue['id'];
     ?>
                            <div class="panel-body" onclick="showbought_subject('<?php echo url_title($url_examname); ?>',<?php echo $url_examid; ?>,'<?php echo url_title($pkey); ?>',<?php echo $pvalue['id']; ?>)"><a><?php echo $pkey; ?></a>
                            </div>
                            <?php } ?>
                            </div><?php 
                                          }
                                          ?>   
                            </div>
    <?php
        ?>
        
       </div>
        
          <?php   $i_cnt++;
          }
         
          }
              ?></div> <?php
                
          }else{
             ?>  <div class="panel-body">You have not purchased any study package.</div><?php 
              
          }
          
        ?>          
                </div>
            </div>
        </div>  
        </div> 
      </div>
            </div>
            </div>
            <!--<div id="showbught_result" class="my_account_right"></div>-->
        </div>
    </div>       