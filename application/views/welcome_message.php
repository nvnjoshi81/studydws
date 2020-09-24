<!-- Page Content -->
<!-- slider section -->
<div id="myCarousel" class="carousel slide slide_container" data-ride="carousel" > 
  <!-- <div class="bg_img_ban"><img src="http://www.studyadda.local/assets/frontend/images/bg_2.jpg"  />   </div>-->
 <div class="homepageban">
 <div class="homepageslid-inner">
     
      <?php if(!$this->session->userdata('customer_id')){ ?>
 <div class="col-md-12 home_ban">
      <?php }else{ ?>
           <div class="col-md-12 home_ban">
      <?php } ?>
   <!-- Indicators -->
   <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>
  <div class="carousel-inner">
      <div class="item active"> <img width="1326" height="483" src="<?php echo base_url('assets/frontend/images/studyadda2.jpg')?>" style="width:100%" data-src="" alt="Study Packages">
      <div class="container">
        <div class="carousel-caption">
        <!--
        <h1>Study Packages</h1>
          <p><h3>More than 12000 Study Packages for all engineering,medical & school level 1st to 12th class.</h3>
        </p>
        -->            
        <p><h3>Download Study-Packages of Any Class From 1st to 12th, JEE & NEET in </h3><span style="font-size: xx-large; font-size: 34px;"><i class="fa fa-inr"> </i> 3999 ONLY</font></span>
        </p>
          <p><a class="btn btn-raised btn-lg btn-primary" href="/study-packages" role="button">Find more</a>
          </p>
        </div>
      </div>
    </div>      
      <div class="item"> <img width="1326" height="483" src="<?php echo base_url('assets/frontend/images/studyadda3.jpg')?>" style="width:100%" data-src="" alt="Test Series">
      <div class="container">
        <div class="carousel-caption slide2">
          <h1>Test Series</h1>
          <p><h3>Pre Launch Offer-Test Series of Any Class From 1st to 12th, JEE & NEET,Railways,Banking,SSC,GRE,CAT,CA-CPT,CLAT,NTSE in </h3><span style="font-size: xx-large; font-size: 34px;"><i class="fa fa-inr"> </i>3999 ONLY</font></span></p>
          <p><a class="btn btn-raised btn-lg btn-primary" href="<?php echo base_url('online-test')?>" role="button">View more</a></p>
        </div>
      </div>
    </div>
      
    <div class="item"> <img width="1326" height="483" src="<?php echo base_url('assets/frontend/images/studyadda1.jpg')?>" style="width:100%" alt="First slide">
      <div class="container">
        <div class="carousel-caption">
          <h1>Video Lectures</h1>
          <p><h3>Free video lectures for JEE, NEET,CBSE Class 12th, 11th,10th & 9th</h3></p>
          <p><a class="btn btn-raised btn-lg btn-primary" href="/videos" role="button">Browse All</a></p>
        </div>
      </div>
    </div>
    <div class="item"> <img width="1326" height="483" src="<?php echo base_url('assets/frontend/images/studyadda3.jpg')?>" style="width:100%" data-src="" alt="Second slide">
      <div class="container">
        <div class="carousel-caption">
          <h1>Ncert Solutions</h1>
          <p><h3>Free NCERT & NCERT exemplar problems video solutions from class 6th to 12th for all subjects.</h3></p>
          <p><a class="btn btn-raised btn-lg btn-primary" href="ncert-solution" role="button">View more</a></p>
        </div>
      </div>
    </div>
</div>
   <?php if(!$this->session->userdata('customer_id')){ ?>
<div id="search-form" class="mob_login_panel  col-md-3 main_login">
<div class="panel cont_log">
     <div class="frm_box" id="frm_box">       
          </div>
<div class="panel-heading">
    <div class="but-head">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <a href="<?php echo base_url('login')?>" id="mloginbtn" class="btn btn-primary">Login</a>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <a href="<?php echo base_url('login')?>" class="btn  btn-warning">Sign Up</a>
        </div>
            </div>
 <!--id="msignupbtn" <hr class="colorgraph">-->
<!--<h3 class="panel-title">Login</h3>-->
</div>
<div class="panel-body">
          <div class="oaerror danger" id="login_msg" style="display: none">
           
          </div> 
<div id="mainlogin">
    <form action="" method="post" name="loginform" id="loginform">
        <p class="homesocial">
            <a class="btn-sm btn-md btn btn-primary social-login-btn social-facebook" href="<?php echo base_url('auth/facebook')?>"><i class="fa fa-facebook"></i></a>
            <a class="btn-sm btn-md btn btn-primary social-login-btn social-google" href="<?php echo base_url('auth/googleplus')?>"><i class="fa fa-google-plus"></i>
			</a>
        </p>
    <p class="required text-left text-warning">* Required Fields</p>
    <div class="form-group has-success label-floating is-empty">
        <label class="control-label" for="exampleInputEmail1"><em>*</em> Email address </label>
        <input type="email" name="loginemail" class="form-control" id="loginemail" >
    </div>
    <div class="form-group has-success label-floating is-empty">
        <label class="control-label" for="exampleInputPassword1"><em>*</em> Password </label>
        <input type="password" name="loginpassword" class="form-control" id="loginpassword" >
    </div>
        <div class="col-sm-12 col-sm-offset-3 col-md-12 col-md-offset-3">
    <button type="submit" class="btn btn-raised btn-warning">Login</button>
    </div>
    <div class="col-sm-12 col-sm-offset col-md-12 col-md-offset-1">
    <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#forgotpassword">Forgot Password</button> 
    </div>
    </form>	
</div> 
<div id="mainsignup" >
    <form role="form" action="<?php echo base_url(); ?>api/customer/register" method="post" id="registerform">
        <div class="form-group has-success label-floating is-empty"  style="padding-bottom:3px !important ;margin:15px !important;">
<label class="control-label" for="usr"><em>*</em>
First Name </label>
<input type="text" name="firstname" class="form-control"  id="firstname">
</div>
<div class="form-group has-success label-floating is-empty" style="padding-bottom:3px !important ;margin:15px !important;">
<label class="control-label" for="email"><em>*</em>
Email </label>
<input type="email" name="email" class="form-control" id="email">
</div>

<div class="form-group has-success label-floating is-empty" style="padding-bottom:3px !important ;margin:15px !important;">
<label class="control-label" for="email"><em>*</em> Password </label>
<input type="password" name="password" class="form-control" id="password" >
</div>
<div class="form-group has-success label-floating is-empty" style="padding-bottom:3px !important ;margin:18px !important;">
<label class="control-label" for="email"><em>*</em> Confirm Password </label>
<input type="password" name="cpassword" class="form-control" id="cpassword" >
</div>
<div class="form-group has-success label-floating is-empty" style="padding-bottom:3px !important ;margin:15px !important;">
<label class="control-label" for="mobile"><em>*</em> Mobile </label>
<input type="text" id="mobile" class="form-control" name="mobile">
</div>    
<div class="form-group has-success label-floating is-empty" style="padding-bottom:3px !important ;margin:15px !important;">
<label class="control-label" for="mobile"><em>*</em> Course </label>
<select name="category" id="category" class="form-control">
<option value="0">Select..</option><option value="24">10th Class</option><option value="23">11th Class</option><option value="22">12th Class</option><option value="32">1st Class</option><option value="33">2nd Class</option><option value="34">3rd Class</option><option value="35">4th Class</option><option value="36">5th Class</option><option value="37">6th Class</option><option value="38">7th Class</option><option value="31">8th Class</option><option value="30">9th Class</option><option value="41">AFMC</option><option value="55">AIIMS</option><option value="42">AMU Medical</option><option value="78">Banking</option><option value="56">BCECE Engineering</option><option value="64">BCECE Medical</option><option value="60">BHU PMT</option><option value="43">BVP Medical</option><option value="74">CA-CPT</option><option value="75">CAT</option><option value="63">CEE Kerala Engineering</option><option value="65">CET Karnataka Engineering</option><option value="44">CET Karnataka Medical</option><option value="71">Chhattisgarh PMT</option><option value="73">CLAT</option><option value="45">CMC Medical</option><option value="62">DUMET Medical</option><option value="46">EAMCET Medical</option><option value="76">GRE</option><option value="47">Haryana PMT</option><option value="68">J &amp; K CET Engineering</option><option value="61">J &amp; K CET Medical</option><option value="54">JAMIA MILLIA ISLAMIA</option><option value="70">JCECE Engineering</option><option value="67">JCECE Medical</option><option value="28">JEE Main &amp; Advanced</option><option value="48">JIPMER</option><option value="58">Manipal Engineering</option><option value="59">Manipal Medical</option><option value="49">MGIMS ­ WARDHA</option><option value="40">MP PMT</option><option value="29">NEET</option><option value="72">NTSE</option><option value="80">Other Exam</option><option value="66">Punjab Medical</option><option value="79">Railways</option><option value="69">RAJASTHAN ­ PET</option><option value="50">RAJASTHAN ­ PMT</option><option value="77">SSC</option><option value="102">UPSC</option><option value="51">Uttarakhand PMT</option><option value="57">VIT Engineering</option><option value="52">VMMC</option><option value="53">WB JEE Medical</option></select>
</div>
      

  <?php
        /*Check whather user is from Android App or Website */
                                   
                                     $isWebView = false;
if((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false)){
    $isWebView = true;
}elseif(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
    $isWebView = true;
}

if(!$isWebView){ 
    // Normal Browser
    //echo "aa";
    $is_social_value=0;
}else{
    
    $is_social_value=2;
    // Android or iOS Webview
    
     //echo "ww";
}
                                   
        /*End check whater user*/
       $random_number = rand(999,9999);
        $this->session->set_userdata("regi_session",$random_number);
        $regi_session_value= $random_number;
        ?>
        
        <input type="hidden"  name="regi_session_input" value="<?php echo $regi_session_value; ?>">
             <input type="hidden"  name="is_social_value" value="<?php echo $is_social_value; ?>">
<button type="submit" class="btn btn-raised btn-warning">Sign Up</button>
    </form>
</div>
</div>
</div>
 </div>
 <?php } ?>
  
  <a class="left carousel-control" href="#myCarousel" data-slide="prev" style="background:none;"><span class="glyphicon glyphicon-chevron-left"></span></a>  
  <a class="right carousel-control" href="#myCarousel" data-slide="next" style="background:none;"><span class="glyphicon glyphicon-chevron-right"></span></a>
 </div>
 
 <!-- login form -->
 </div> 
 </div> 
 </div>
 </div>
<!-- // slider section -->



<div class="container cont_body">
        
    <div class="clearfix"></div>
    
    <?php $showOl_class='no';
    if($showOl_class=='yes'){  ?>
<div class="col-lg-12">
                <h2 class="page-header"><a href="<?php echo base_url('online-test')?>">Test Series</a></h2>
            </div>
<div class="panel panel-default">
<ul class="nav nav-pills">
   <?php 
            $ts_lable_array=array('btn-default','btn-primary','btn-success','btn-info','btn-warning','btn-danger');
            $ts_cnt=0;
                  foreach($ts_categories as $tc_ex){ 
                      $ts_rand=rand(0,5);
                      ?>
               <?php echo "<li><a class='btn btn-raised btn-lg ".$ts_lable_array[$ts_rand]."' href='".base_url('exams/'.url_title($tc_ex->name,'-',true).'/'.$tc_ex->id)."'>".trim(str_replace('Class','',$tc_ex->name))."</a></li>"; ?>
            
              <?php
              ++$ts_cnt;
              }
              ?>
</ul>
    </div>
<div class="clearfix"></div>

<?php
if((isset($isProduct_array))&&(count($isProduct_array)>0)){
$this->load->view('common/product_list_testseries'); 
}
    }
    
?>
    <div class="clearfix"></div>
<?php 
$advideo_show='no';
if($advideo_show=='yes'){ ?>
        <div class="row our_free_video">
            <div class="col-lg-12">
                <h2 class="page-header"><a href="<?php echo base_url('free-videos')?>">Our Free Videos</a></h2>
            </div>
            <div class="col-md-6 vid_title text-center homeimg">
                <div class="col-lg-12">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url('free-videos/jee-main-and-advanced/28')?>" alt="IIT JEE Free Video Lectures" title="IIT JEE Free Video Lectures">  
                        <img width="177" height="152" src="<?php echo base_url('assets/frontend/images/1s.png')?>" alt="IIT JEE Free Video Lectures" class="img-responsive">IIT JEE Free Video Lectures</a>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url('free-videos/neet/29')?>" alt="NEET Free Video Lectures" title="NEET Free Video Lectures">
                        <img width="177" height="152" src="<?php echo base_url('assets/frontend/images/3s.png')?>" alt="NEET Free Video Lectures" class="img-responsive">NEET Free Video Lectures</a>
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url('free-videos/12th-class/22')?>" alt="12th Class Free Video Lectures" title="12th Class Free Video Lectures">
                        <img width="177" height="152" src="<?php echo base_url('assets/frontend/images/2s.png')?>" alt="12th Class Free Video Lectures" class="img-responsive">12th Class Free Video Lectures</a>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <a href="<?php echo base_url('free-videos/11th-class/23')?>" alt="11th Class Free Video Lectures" title="11th Class Free Video Lectures">
                        <img width="177" height="152" src="<?php echo base_url('assets/frontend/images/4s.png')?>" alt="11th Class Free Video Lectures" class="img-responsive">11th Class Free Video Lectures</a>
                </div>
                </div>
            </div>
                
                
            
            <?php
            $random_video_array= array(0=>base_url('assets/frontend/images/studyadda_adverd.mp4'),1=>base_url('assets/frontend/images/studyadda_adverd.mp4'));
            $random_video_link =rand(0,1);
            ?>
            <div class="col-md-6 our_vid_player" id="videoplayer_div">
                <video width="100%" height="auto" autoplay="" controls="" id="videoplayer">
                    <source type="video/mp4" src="<?php echo $random_video_array[$random_video_link];  ?>"></source>
                </video>
            </div>
        </div>

      <?php  } ?>
		  <!---728x90--->
               
    <?php
$show_index_contant='yes';
if($show_index_contant=='yes'){ ?>
		      <div class="serve-top">
				 <div class="col-sm-6 col-md-6 serve-icons">
					<div class="s-sub rcorners2">
						<div class="col-md-2 icon text-danger">
						<i class="glyphicon glyphicon-info-sign"></i>
						</div>
						<div class="col-md-10 serve-text">
                                              <h3>
                                    <a href="<?php echo base_url('notes')?>">Notes</a>
                                              </h3>
						<p>Theory, Short-Cuts, Formulae & Concepts Notes for Exams.</p>
            <p>All Notes In Easy To Understand Language.</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
					 <div class="s-sub rcorners2">
						<div class="col-md-2 icon text-success">
					  <i class="glyphicon glyphicon-facetime-video"></i>
						</div>
						<div class="col-md-10 serve-text">
					     <h3><a href="<?php echo base_url('videos')?>">Video Lectures</a></h3>
                                                 <p>Live & Recorded Video Lectures By Experienced Eminent Faculties.</p>
                                                 <p>More Than 20,000 Video Lectures.</p>

						</div>
					     <div class="clearfix"> </div>	
					 </div>
					 <div class="s-sub rcorners2">
						<div class="col-md-2 icon text-danger">
						  <i class="glyphicon glyphicon-folder-open"></i>
						</div>
						<div class="col-md-10 serve-text">
						 <h3><a href="<?php echo base_url('study-packages')?>">Study Packages</a></h3>
                                                 <p>More Than 50,000 Study Packages Covering Notes, Question Banks, Sample Papers, Solved Papers.</p>
                                                 <p>Study Packages of More Than 5 Lakh Pages.</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
                                     <div class="s-sub rcorners2">
						<div class="col-md-2 icon text-success">
						  <i class="glyphicon glyphicon-edit"></i>
						</div>
						<div class="col-md-10 serve-text">
						 <h3><a href="<?php echo base_url('solved-papers')?>">Solved Papers</a></h3>
						 <p>Past Year Solved Papers Of All Exams.</p>
                                                 <p>Chapter wise, Topic wise & Year wise Solved Papers.</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
                                     <div class="s-sub rcorners2">
						<div class="col-md-2 icon text-danger">
						  <i class="glyphicon glyphicon-hourglass"></i>
						</div>
						<div class="col-md-10 serve-text">
						  <h3><a href="<?php echo base_url('online-test')?>">Online Tests</a></h3>
						 <p>More Than 5000 Online Tests Along with Comprehensive Analytical Reports.</p>
                                                 <p>Chapter wise, Concept wise Topic wise & Subject wise Tests.</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
				 </div>
				 <div class="col-sm-6 col-md-6 serve-icons">
					<div class="s-sub rcorners2">
						<div class="col-md-2 icon text-success">
						  <i class="glyphicon glyphicon-book"></i>
						</div>
						<div class="col-md-10 serve-text">
						<h3><a href="<?php echo base_url('ncert-solution')?>">NCERT Corner</a></h3>
						<p>NCERT & Exemplar Books Solutions & Summary.</p>
                                                <p>NCERT Answers by Renowned Experts.</p>
                                                <p>Olympiad Videos, Study Packages, Sample & Solved Papers.</p>
                                                <p>Support For Each & Every Olympiad Held In India.</p>
                                                </div>
					     <div class="clearfix"> </div>	
					 </div>
					 <div class="s-sub rcorners2">
						<div class="col-md-2 icon text-danger">
						  <i class="glyphicon glyphicon-globe"></i>
						</div>
						<div class="col-md-10 serve-text">
						  <h3><a href="<?php echo base_url('articles')?>">Articles</a></h3>
						  <p>More Than 5000 Articles On Popular Topics</p>
                                                  <p>Post Your Own Essays & Articles</p>
                                                  <p>Only Portal To Find School Based Articles</p>
                                                  <p>Various Science & Other Subjects Projects</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
                                     <div class="s-sub rcorners2">
						<div class="col-md-2 icon text-success">
						  <i class="glyphicon glyphicon-list-alt"></i>
						</div>
						<div class="col-md-10 serve-text">
						  <h3><a href="<?php echo base_url('sample-papers')?>">Sample Papers</a></h3>
						 <p>Sample/ Mock / Guess / Practice Papers For All Exams.</p>
                                                 <p>More Than 100 Practice Papers Of Many Exams.</p>                                                 
						</div>
					     <div class="clearfix"> </div>	
					 </div>
                                        <div class="s-sub rcorners2">
						<div class="col-md-2 icon text-danger">
						<i class="glyphicon glyphicon-file"></i>
						</div>
						<div class="col-md-10 serve-text">
						  <h3><a href="<?php echo base_url('question-bank')?>">Question Bank</a></h3>
                                                 <p>More Than 20 Lakh Questions Of All Types.</p>
                                                 <p>Also Includes Topic wise & Concept wise Questions</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div> 
                                     <div class="s-sub rcorners2">
						<div class="col-md-2 icon text-success">
						  <i class="glyphicon glyphicon-send"></i>
						</div>
						<div class="col-md-10 serve-text">
						  <h3><a href="<?php echo base_url('amazing-facts')?>">Amazing Facts</a></h3>
						 <p>More Than 7 Lakh Type Of Facts</p>  
                                                 <p>Facts For School Level & Competitive Exams</p>
                                                 <p>Topicwise & Conceptwise Facts</p>
						</div>
					     <div class="clearfix"> </div>	
					 </div>
				 </div>
				 <div class="clearfix"> </div>		
	          </div>
<?php  }
?>
    </div>