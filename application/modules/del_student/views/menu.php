<div class="sidebar-nav">
            <div class="col-md-12" >
               
                <?php 
                
                
                $show_subscription='yes';
                    
         if($show_subscription=='yes'&&($this->uri->segment(2)==''||$this->uri->segment(2)=='orders')){ 
//       https://codepen.io/marklsanders/pen/OPZXXv
                ?>
            <div class="panel-group" id="accordion1">
            <div class="panel panel-default">
                <div class="btn-success" style="padding:10px 15px;">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree"><i class="material-icons">assignment_returned</i> &nbsp; My Study Packages Subscription</a>
                    </h4> 
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                    
                    <?php 
                
             if (isset($purchased_studymaterial) && count($purchased_studymaterial) > 0) { 
             ?>    <div class="panel-body"><?php
                                foreach ($purchased_studymaterial as $k => $v) {                                $i_cnt=1;
                                    $content = '';
                                    foreach ($v as $k1 => $v1) {
                                        if ($k == 1) {
                                            $content = 'study-packages';
                                        }
                                        
                                        $href = base_url($content);
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
                                        ?>  

                        <div class="panel-group" id="accordion_<?php echo $i_cnt; ?>">
                            <div class="panel panel-default">
                                        <?php  if(isset($itemdetail)){
                                              if($details->item_id<1){ 
                                                ?>
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion_<?php echo $i_cnt; ?>" href="#collapseThreeOne_<?php echo $i_cnt; ?>"><?php echo $name ?><!--<i class="material-icons">arrow_forward</i>-->
                                        </a></h4>
                                </div> 
                                <div id="collapseThreeOne_<?php echo $i_cnt; ?>" class="panel-collapse collapse in">
                                     <?php 
     $examarray= explode('/',$href); 
     $examarray_count=count($examarray);
     $url_examid =$examarray[$examarray_count-1];
     $url_examname =$examarray[$examarray_count-2];
                                    foreach($purchased_data_array as $pkey=>$pvalue){
     //$subjecturl = $href.'/'.url_title($pkey, '-', true).'/'.$pvalue['id'];
     ?>
                                    <div class="panel-body" onclick="showbought_subject('<?php echo $url_examname; ?>',<?php echo $url_examid; ?>,'<?php echo $pkey; ?>',<?php echo $pvalue['id']; ?>)"><a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree" class="collapsed" aria-expanded="false"><?php echo $pkey; ?></a></div>
                                    <?php } ?>
                                </div>
                                            <?php  
                                              }  else{
                                                ?>
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                     <a data-toggle="collapse" data-parent="#accordion_<?php echo $i_cnt; ?>" href="#collapseThreeOne_<?php echo $i_cnt; ?>"><?php echo $name ?><!--<i class="material-icons">arrow_forward</i>-->
                                        </a</h4>
                                </div>
                                
                                <div id="collapseThreeOne_<?php echo $i_cnt; ?>" class="panel-collapse collapse in"><div class="panel-body"><a href="<?php echo base_url('study-packages/download/'.encrypt($itemdetail->id.'.'.$this->session->userdata('customer_id')))?>" target="_blank">Download Now</a></div></div>

 <?php   
                                        }
                                        }else{
                                            ?>
                                <div class="panel-heading">
                                   <h4 class="panel-title">
                                   <a href="#collapseThree" class="collapsed" aria-expanded="false" data-toggle="collapse" data-parent="#accordion_<?php echo $i_cnt; ?>" href="#collapseThreeOne_<?php echo $i_cnt; ?>"><?php echo $name ?><!--<i class="material-icons">arrow_forward</i>-->
                                        </a></h4>
                                </div>
                                <div id="collapseThreeOne_<?php echo $i_cnt; ?>" class="panel-collapse collapse in">
                                  <?php 
     $examarray= explode('/',$href); 
     $examarray_count=count($examarray);
     if($examarray_count==8){         
     $url_examid =$examarray[$examarray_count-3];
     $url_examname =$examarray[$examarray_count-4];
     }else{
     $url_examid =$examarray[$examarray_count-1];
     $url_examname =$examarray[$examarray_count-2];
     }
     foreach($purchased_data_array as $pkey=>$pvalue){
     //$subjecturl = $href.'/'.url_title($pkey, '-', true).'/'.$pvalue['id'];
     ?>
    <div class="panel-body" onclick="showbought_subject('<?php echo $url_examname; ?>',<?php echo $url_examid; ?>,'<?php echo $pkey; ?>',<?php echo $pvalue['id']; ?>)"><a data-toggle="collapse" data-parent="#accordion1" class="collapsed" aria-expanded="false" data-toggle="collapse"><?php echo $pkey; ?></a></div>
                                    <?php } ?>
                                </div><?php 
                                        }
?>   </div>
    <?php
        ?>
        
       </div>
       <?php   $i_cnt++;
          }
          }
          ?></div> <?php
                
          }else{
             ?>  
                    
                    <div class="panel-body text-center text-success">You have not purchased any study package.
                    <p class="text-uppercase text-lg-center"><a href="<?php echo base_url().'study-packages';?>"><span class="label label-success">Buy Now</span></a></p></div>
             <?php 
              
          }
          ?>
                    
                </div>
                
            </div>

        </div>  
                <!--Video Section Start-->
                
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
                                     $href = base_url('videos');
                                    $details = $this->Pricelist_model->getDetails($v);   //print_r($details);
                                   
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
                                }
          }else{
              ?>
                  <div class="panel-body text-center text-success">You have not purchased any video.
                                    <p class="text-uppercase text-lg-center"><a href="<?php echo base_url().'/videos';?>"><span class="label label-success">Buy Now</span></a></p></div>
                   
<?php
          }
?>      
      </div> 
    </div>
  </div>
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
                                    $details = $this->Pricelist_model->getDetails($v);   //print_r($details);
                                   
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
                                }
          }else{
          ?>
          <div class="panel-body text-center text-success">You have not purchased any Test Series.
                                    <p class="text-uppercase text-lg-center"><a href="<?php echo base_url().'/online-test';?>"><span class="label label-success">Buy Now</span></a></p></div>                                <?php } ?>
      </div>
      </div>
      </div>
      <?php } ?>        
                
        <nav class="nav-sidebar">
            <ul class="nav row"> 
                <li class="nav-header"></li>
                <li class="col-xs-6 col-sm-12 col-md-12" <?php echo $this->router->fetch_method()=='index'?'class="active"':''?>><a  title="Dashboard" href="<?php echo base_url(); ?>customer"><i class="material-icons btn-success">dashboard</i> &nbsp; My Library</a></li>
                <li class="col-xs-6 col-sm-12 col-md-12"><a title="Account Info" href="<?php echo base_url(); ?>customer/myaccount"><i class="material-icons btn-primary">account_box</i> &nbsp; My Profile</a></li>
                    <!--<li class="col-xs-6 col-sm-12 col-md-12"><a title="Add Address" href="<?php echo base_url(); ?>customer/addaddress"><i class="material-icons">note_add</i>  &nbsp; Add Address</a></li>-->
                <li class="col-xs-6 col-sm-12 col-md-12"><a title="Address Book" href="<?php echo base_url(); ?>customer/addresses"><i class="material-icons btn-warning">receipt</i>  &nbsp; My Address</a></li>
                <li class="col-xs-6 col-sm-12 col-md-12"><a title="My Order" href="<?php echo base_url(); ?>customer/orders"><i class="material-icons btn-default">grid_on</i> &nbsp;  My Orders</a></li>
                  <!--<li class="col-xs-6 col-sm-12 col-md-12"><a title="My Tests" href="<?php echo base_url(); ?>customer/tests"><i class="material-icons">speaker_notes</i>  &nbsp; My Tests</a></li>
                <li class="col-xs-6 col-sm-12 col-md-12"><a title="My Recommendations" href="<?php echo base_url(); ?>customer/recommendations"><i class="material-icons">speaker_notes</i>  &nbsp; My Recommendations</a></li>
                  -->
                <li class="col-xs-6 col-sm-12 col-md-12"><a title="Change Password" href="#" data-toggle="modal" onclick="cleanInput()" data-target="#myModal"><i class="material-icons btn-primary">change_history</i>  &nbsp; Change Password</a></li>
                <li class="nav-divider"></li>
                <li class="col-xs-6 col-sm-12 col-md-12"><a title="Logout" href="<?php echo base_url(); ?>customer/logout"><i class="glyphicon glyphicon-off btn-danger"></i> &nbsp; Logout</a></li>
                
            </ul>
            </nav>
        	</div>
        </div> 
<script type="text/javascript" language="JavaScript">
   function cleanInput(){

    document.getElementById('current_password').value='';
       
   } 
</script>

<?php if($this->session->userdata('customer_id')){ ?>
	<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
	  <form action="<?php echo base_url() ?>customer/changePassword" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Hello <?php echo $this->session->userdata['customer_name']; ?></b></h4>
        </div>
        <div class="modal-body">
          <p><b>Enter New Password</b></p>
            <div class="form-group has-success label-floating is-empty">
                        <label class="control-label" for="name">Current Password</label>
                        <input value="" autocomplete="off" class="form-control" type="password" name="current_password" id="current_password"  required>
                     </div> 
           <div class="form-group has-success label-floating is-empty">
                        <label class="control-label" for="name">New Password</label>
                        <input class="form-control" type="password" name="password" id="password"  required>
                     </div> 
             <div class="form-group has-success label-floating is-empty">
                        <label class="control-label" for="name">Confirm Password</label>
                       <input class="form-control" type="password" name="confirm_password" id="confirm_password"  required>
                     </div>           
		  <input type="hidden" name="user_id" value="<?php echo $this->session->userdata['customer_id']; ?>">
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-raised btn-warning" id="updatePass">Update</button>
        </div>
      </div>
      </form>
    </div>
  </div>
	  <?php } ?>