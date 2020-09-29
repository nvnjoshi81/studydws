<div id="wrapper">
    <div class="container">
        <div class="row">
          <?php 
          if($this->session->flashdata('massage')){
             ?>
             <div class="alert alert-success">
                 <?php echo $this->session->flashdata('massage') ?> 
             </div>
            <?php 
         }
         $this->load->view('common/breadcrumb');
         ?>
		   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
			
			 <?php
			 
			 foreach($isProduct_array as $isPrName){
			  $testarray=array(22,23,28,29,77,78,79,30,24,72,73,31,38,37,36,35,34,33,32,102,105);
         if(in_array($isPrName->exam_id,$testarray)){  
 $testexam1='online-test/'.url_title($isPrName->exam, '-', true) . '/' . $isPrName->exam_id;    
?>


<a class="buy_btn btn-primary btn btn-sm btn-md btn-lg  btn-raised select_subject_btn" href="<?php echo base_url($testexam1);?>">
 

<?php 
echo substr($isPrName->modules_item_name,0,-11);
?>
  </a>

  
<?php }} ?>
</div>
	<?php if($exam_id>0){
	?>
	<div class="col-md-12 col-sm-12">
	<?php 
	//echo $this->load->view('common/single_testseries'); 
	?>
	</div>
	<?php
             $subjectHasTest=array();
             $cateblock_display='no';
             if(isset($catWise_test)&&(count($catWise_test)>0)){
             ?>  <div class="col-md-12 col-sm-12 prod_list_exam exam_page_cont ">
			<div class="row">
			<?php
         	foreach($catWise_test as $catname=>$catinfoArray){
                if(isset($catinfoArray)&&(count($catinfoArray)>0)){
                 ?>
             <div class="col-md-4 col-sm-4">
              <div class="panel panel-success">
                <div class="panel-heading">
                     <h4>Test Series for <?php echo $catname; ?></h4> </div>
                 <div>
                  <ul>
                    <?php $cc=0; foreach($catinfoArray as $catinfo){ ?>
                    <li>
                        <i class="material-icons icon_bullet">picture_as_pdf</i>
                              <a href="<?php echo generateContentLink_custom('online-test',$catinfo->exam,$catinfo->subject,$catinfo->chapter,$catinfo->name,$catinfo->exam_id,$catinfo->subject_id,$catinfo->chapter_id,$catinfo->id);?>">
                                  <?php echo $catinfo->name; //echo ' ['.ucwords($catinfo->subject).']';?>
                              </a>
                    </li>
                    <?php $subjectHasTest[$catinfo->subject_id]=$catinfo->subject;
                    $examid= $catinfo->exam_id;
                    $examname=$catinfo->exam;
                    $cc++;                         
                            } ?>
                  </ul>
                </div>
               
              </div>
            </div><?php 
                     $cateblock_display='yes';
                    }
                 } ?>
            </div></div>
                     <?php
             }
         ?>
        <div class="col-md-12 col-sm-12 prod_list_exam exam_page_cont" >
            <?php if($cateblock_display=='no'){ 
			?>
                    <div class="clearfix"></div>
                    <div class="row">  
                    <?php 
            if(isset($qb_test)&&count($qb_test)>0){ ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4>Chapter Wise Test Series</h4>
                </div>
            </div>
                    <?php
                    $qb_section=array();
                    foreach($qb_test as $qbdata_array){
                     $qb_section[$qbdata_array->subject][]=$qbdata_array;   
                    }
                    //print_r($qb_section);
                    
                    foreach($qb_section as $key => $qbdata_arr){ if(isset($key)&&$key!=''){
                        ?>        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card">
            <div class="card-body">
                  <div class="panel panel-primary">
                <div class="panel-heading">
              <h4 class="card-title"><?php echo ucwords($key); ?> Test Series</h4>
                </div>
				</div>
              <ul>
                      <?php 
                      
                      foreach($qbdata_arr as $qbdata){
						  if(isset($qbdata->subject)&&$qbdata->subject!='all'){
                          ?>
                    <li class="card-text">
                        <i class="material-icons icon_bullet">picture_as_pdf</i>
                              <a href="<?php echo generateContentLink_custom('online-test',$qbdata->exam,$qbdata->subject,$qbdata->chapter,$qbdata->name,$qbdata->exam_id,$qbdata->subject_id,$qbdata->chapter_id,$qbdata->id);?>">
                            <?php
                            $testname = explode('Test on',$qbdata->name);
                           // echo $testname[0];
                                 if(isset($testname[1])){       
                                 echo $testname[1];
                                 }else{
                                 echo $qbdata->name;   
                                 }
                                  ?>
                              </a>
                    </li>
					  <?php   } } ?>
                      </ul>      </div>           
          </div>			
        </div> 
                            <?php
			} }
                    
                     ?>
                                 <?php } ?>
            
                          </div>  
                         <div class="row">
            <?php if(isset($sp_test)&&count($sp_test)>0){ ?>
            <div class="col-md-6 col-sm-6">
              <div class="panel panel-success">
                <div class="panel-heading">
                     <h4>Mock Papers Test Series</h4> </div>
                 <div>
                  <ul>
                    <?php 
					$currenttime=time();
					
					$cc=0; foreach($sp_test as $spdata){ 
					
					?>
                    <li>
                        <i class="material-icons icon_bullet">picture_as_pdf</i>
                              <a href="<?php echo generateContentLink_custom('online-test',$spdata->exam,$spdata->subject,$spdata->chapter,$spdata->name,$spdata->exam_id,$spdata->subject_id,$spdata->chapter_id,$spdata->id);?>">
                                  <?php if(($spdata->assessment_type==4)&&($currenttime > $spdata->dt_start)&&($currenttime < $spdata->dt_end)){ ?><span style="font-size: 18px;line-height: 24%;font-family: Modak;color:red;"><?php echo $spdata->name;?>[Test Ends At: <?php echo date("d-m-Y h:i",$spdata->dt_end); ?>]</span><?php  }else{ echo $spdata->name; } ?>
                              </a>
                    </li>
                    <?php
                    
                    $examid= $spdata->exam_id;
                    $examname=$spdata->exam;
                   $subjectHasTest[$spdata->subject_id]=$spdata->subject;
                    $cc++;
                            //if($cc==10) break;                            
                            } ?>
                  </ul>
                </div>
                  <!--<div class="panel-footer"> <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; <a title="Question Banks" href="<?php //echo base_url('question-bank/'.$path)?>">View All</a> </div>-->
              </div>
            </div>
                         <?php }else{
                         ?>
            <!-- <div class="col-md-4 col-sm-4">
              <div class="panel panel-success">
                <div class="panel-heading">
                     <h4>Mock Papers Test Series</h4> </div>
                 <div>
                  <ul>
                      <li>Test Paper will be available soon....</li>
                  </ul>
                 </div>
                  </div>
            </div> -->
                <?php        
                    }
                ?>   
                          <?php 
            if(isset($solpap_test)&&count($solpap_test)>0){ ?>
            <div class="col-md-6 col-sm-6">
              <div class="panel panel-success">
                <div class="panel-heading">
              <h4>Solved Papers Test Series</h4></div>
                 <div>
                  <ul>
                    <?php $cc=0; foreach($solpap_test as $solpapdata){ ?>
                    <li>
                        <i class="material-icons icon_bullet">picture_as_pdf</i>
                              <a href="<?php echo generateContentLink_custom('online-test',$solpapdata->exam,$solpapdata->subject,$solpapdata->chapter,$solpapdata->name,$solpapdata->exam_id,$solpapdata->subject_id,$solpapdata->chapter_id,$solpapdata->id);?>">
                                  <?php echo $solpapdata->name; ;?>
                              </a>
                    </li>
                    <?php   
                    $examid   = $solpapdata->exam_id;
                    $examname = $solpapdata->exam;
                    
                    $subjectHasTest[$solpapdata->subject_id]=$solpapdata->subject;
                    $cc++;
                            //if($cc==10) break;                            
                            } ?>
                  </ul>
                </div>
              </div>
            </div>
                                     <?php }else{
                         ?>
            <!-- <div class="col-md-4 col-sm-4">
              <div class="panel panel-success">
                <div class="panel-heading">
                     <h4>Solved Papers Test Series</h4></div>
                 <div>
                  <ul>
                      <li>Test Paper will be available soon....</li>
                  </ul>
                 </div>
                  </div>
            </div>
            -->
                <?php        
                    }
                ?>   
           </div>
                     
            </div>
            
            <?php
         }
                   
             ?>
                 
            <div id="page-inner">
                <div class="module_panel row">                  
                  <!-- content panel start here -->
                  <!-- left panel -->
                  <div class="col-sm-12 col-md-12">
                          <div class="btn-group btn-group-justified">
                          <?php         
                          foreach ($subjectHasTest as $key => $value){
 ?><a class="btn btn-primary" href="<?php echo  base_url('online-test/'.clean($examname).'/'.$examid.'/'.clean($value).'/'.$key);?>" ><?php echo $value?></a>                          
  <?php } ?>
</div>
                  </div>
                </div>
            </div>
                 <?php
         
            $showtest_list='no';
            if($showtest_list=='yes'){
            ?>        
            <div id="page-inner">
                <div class="module_panel row">                  
                  <!-- content panel start here -->
                  <!-- left panel -->
                  <div class="col-sm-12 col-md-12">
                    <!-- Recent Questions -->
                    <div class="row recent_ques">                  
                    <div class="col-sm-12 col-md-12">
                     <h3><i class="material-icons">folder</i> <?php if($exam_id<1){ ?>Recent<?php } ?> Select Test</h3>
                    <?php 
                    if($exam_id>0){
                    if($onlinetest){ 
                    $count=1; 
                    foreach($onlinetest as $ot){ 
                    if($count==50 && $this->uri->total_segments() ==1) break;
                    ?>  
                    <div class="list-group">
                      <div class="list-group-item">
                        <div class="row-action-primary atop">
                          <i class="material-icons">folder</i>
                        </div>
                        <div class="row-content">
                          <div class="least-content"><!--300--> <i class="material-icons">thumb_up</i></div>
                          <h4 class="list-group-item-heading">                              
                              <a href="<?php echo generateContentLink_custom('online-test',$ot->exam,$ot->subject,$ot->chapter,$ot->name,$ot->exam_id,$ot->subject_id,$ot->chapter_id,$ot->id);?>">
                                  <?php echo $ot->name;?>
                              </a>
                          </h4>
                    </div>
                      </div>
                      <div class="list-group-separator"></div>
                      </div>
                     <?php $count++; } ?>
                     <div>           <?php
                            
if(($exam_id>0)&&($chapter_id==0)){
echo "<h6><b>".$this->pagination->create_links() . "</b></h6>";
}
?></div>
                         
                         <?php }else{
                    ?>
                    <div class="list-group">
                        <div class="list-group-item">
                            <h4 class="list-group-item-heading">No Test Available.</h4>
                        </div>
                    </div>
                    <?php
                     }  }else{ 
                         
                        ?>
                            
                                     <div class="ncert_cont col-sm-12 col-md-6">
                                         <ul class="nav">
                                <?php  ?>
                                    <h3 class="text-success">
                                        <i class="material-icons">update</i>
                                        <a href="<?php echo base_url('online-test/jee-main-advanced/28') ?>">
                                            <?php  ?>JEE Main & Advanced
                                        </a>
                                    </h3>
                                <?php 
                                
                                foreach($onlinetest_jeemain as $ot_jee){ 
                                        ?>
                                        <li>
                                               <a href="<?php echo generateContentLink_custom('online-test',$ot_jee->exam,$ot_jee->subject,$ot_jee->chapter,$ot_jee->name,$ot_jee->exam_id,$ot_jee->subject_id,$ot_jee->chapter_id,$ot_jee->id);?>">
                                  <?php echo $ot_jee->name;?>
                              </a>
                                        </li> 
                                <?php } ?> 

                            </ul>
                                     </div>
                     
                     
                     
                            <div class="ncert_cont col-sm-12 col-md-6" id="NEET">
                                         <ul class="nav">
                                <?php  ?>
                                    <h3 class="text-success">
                                        <i class="material-icons">update</i>
                                        <a href="<?php echo base_url('online-test/neet/29') ?>"><?php  ?>NEET
                                        </a>
                                    </h3>
                                <?php 
                                
                                foreach($onlinetest_neet as $ot_neet){ 
                                        ?>
                                        <li>
                                               <a href="<?php echo generateContentLink_custom('online-test',$ot_neet->exam,$ot_neet->subject,$ot_neet->chapter,$ot_neet->name,$ot_neet->exam_id,$ot_neet->subject_id,$ot_neet->chapter_id,$ot_neet->id);?>">
                                  <?php echo $ot_neet->name;?>
                              </a>
                                        </li> 
                                <?php } ?> 

                            </ul>
                                     </div>
                            
                            <?php
                    
                    }?>
                     </div>
               </div>
                  </div>
                  <!-- right panel -->
                <!-- <div class="col-sm-12 col-md-3 rht_status_mat">
                    <div class="panel panel-primary">
                	<div class="panel-heading">
                            <h4> <i class="material-icons">book</i>Statistics</h4>
                        </div>
                	<div class="panel-body">
                            <ul>
                                <li><i class="material-icons">&#xE037;</i> <a href="#"><span class="text-warning"><?php echo count($onlinetest);?></span> Online Test</a> </li>
                                <li><i class="material-icons">&#xE037;</i><a href="#"> <span class="text-warning"><?php echo count($onlinetestquestions);?></span> Questions</a> </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="right_advertisepanel"><img alt="Studyadda" src="<?php echo base_url('assets/images/150adv_2.jpg')?>"></div>
                     
                </div>-->
                </div> 
    </div>
             <!-- /. PAGE INNER  -->
            <?php } ?>
            </div>
         <?php }else{
  	 ?>
    <div class="col-md-12 col-sm-12">
	<?php 
	
		redirect('purchase-courses'); die;
	//echo  $this->load->view('common/product_list_testseries'); ?>
	</div>
         <?php  } ?>
</div>
</div>
</div>
