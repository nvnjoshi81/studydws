<?php
$segmentURL=$this->uri->segment(1);
$currentModuleName=$this->router->fetch_module();
$currentSegment=$this->uri->segment(1);
//add segment name to hide in bellow sagment arr
$sagmentArray=array('cart','search');
if(in_array($currentSegment,$sagmentArray)){
$showFooterlinks='no';
$showFooterJs='no';
}else{
$showFooterlinks='yes';
$showFooterJs='yes';
}

$hideumod=$sagmentArray=array('cart','login','purchase-courses','exams','search','study-packages');
if(in_array($currentSegment,$hideumod)){
	$hideumodany='no';
	
}else{
	$hideumodany='yes';	
}
if($showFooterlinks=='yes') { 

if($this->router->fetch_module() != 'customer') { ?>
    <div class="row bottom_vid_list">
        <div class="col-md-12">
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6" >
                <a href="<?php echo base_url('videos/jee-main-advanced/28') ?>" title="IIT JEE AIEEE Video Lectures">
                    <img width="176" height="151" class="img-responsive" src="<?php echo get_assets_cdn('assets/frontend/images/1.png') ?>">
                </a>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6" >
                <a href="<?php echo base_url('videos/neet/29') ?>" title="NEET Video Lectures">
                <img width="176" height="151" class="img-responsive" src="<?php echo get_assets_cdn('assets/frontend/images/2.png') ?>">
                </a>
            </div>
            
          
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                <a href="<?php echo base_url('videos/12th-class/22') ?>" title="12th Class Video Lectures">
                    <img width="176" height="151" class="img-responsive" src="<?php echo get_assets_cdn('assets/frontend/images/3.png') ?>">
                </a>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                <a href="<?php echo base_url('videos/11th-class/23') ?>" title="11th Class Video Lectures">
                    <img width="176" height="151" class="img-responsive" src="<?php echo get_assets_cdn('assets/frontend/images/4.png') ?>">
                </a>
            </div>
            
           
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                <a href="<?php echo base_url('videos/10th-class/24') ?>" title="10th Class Video Lectures">
                    <img width="176" height="151" class="img-responsive" src="<?php echo get_assets_cdn('assets/frontend/images/5.png') ?>">
                </a>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                <a href="<?php echo base_url('videos/9th-class/30') ?>" title="9th Class Video Lectures">
                    <img width="176" height="151" class="img-responsive" src="<?php echo get_assets_cdn('assets/frontend/images/6.png') ?>">
                </a>
            </div>
        </div>
    </div>
 <?php } ?>
<!-- Footer -->
<footer>
    <div class="container">
        <div class="row" style="margin:0; padding:0;">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <div class="widget">
                            <h5>
                                Contact
                            </h5>
                            <hr>
                            <div class="social">
                                <a href="https://www.facebook.com/studyaddahome" target="_blank" title="studyadda">
                                    <i class="fa fa-facebook facebook">
                                    </i>
                                </a>
                                <a href="https://twitter.com/studyadda" target="_blank" title="studyadda">
                                    <i class="fa fa-twitter twitter">
                                    </i>
                                </a>
                                <a href="https://www.youtube.com/user/sardanatutorials" target="_blank" title="studyadda">
                                    <i class="fa fa-youtube youtube">
                                    </i>
                                </a>
                                <a href="https://plus.google.com/109620474268204349998" target="_blank" title="studyadda">
                                    <i class="fa fa-google-plus google-plus">
                                    </i>
                                </a>
                            </div>
                            <hr>              
                            &nbsp; 
                            <div class="mailadd"> 
                                <a title="info@studyadda.com" href="mailto:info@studyadda.com"> info@studyadda.com
                                </a>
                            </div>
                            <hr>
                            <div class="payment-icons">
                                <i class="fa fa-cc-mastercard">

                                </i>
                                &nbsp;
                                <i class="fa fa-cc-paypal">

                                </i>
                                &nbsp;
                                <i class="fa fa-credit-card">
								
                                </i>
                                &nbsp;                
                            </div>
                            <div>
                                <span id="siteseal"><?php 
if(isset($segmentURL)){ ?><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=ZaKNwMsRcHb9ebxme98tGokfhTmZ68ufIBTasVZpNdIpSLGdQF2JHhAXmSTy"></script><?php } ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-10 foot_link">
                        <ul class="row col-xs-12  col-sm-4 col-md-2"><li><h5>JEE Main</h5></li>
                            <li><a href="<?php echo base_url('videos/jee-main-advanced/28') ?>" title="videos-jee-main-advanced">
                                    Videos
                                </a></li>
                                <li><a href="<?php echo base_url('ncert-solution/jee-main-advanced/28'); ?>" title="ncert-solution-jee-main-advanced">
                                    Ncert Solutions
                                </a></li>
                                <li></li><li><a href="<?php echo base_url('question-bank/jee-main-advanced/28'); ?>" title="question-bank-jee-main-advanced">
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('study-packages/jee-main-advanced/28') ?>" title="study-packages-jee-main-advanced">
                                    Study Packages
                                </a></li>
                                <li><a href="<?php echo base_url('notes/jee-main-advanced/28') ?>" title="notes-jee-main-advanced">
                                    Notes
                                </a></li>
                                <li><a href="<?php echo base_url('sample-papers/jee-main-advanced/28'); ?>" title="sample-papers-jee-main-advanced">
                                    Sample Papers
                                </a></li> <li><a href="<?php echo base_url('online-test/jee-main-advanced/28'); ?>" title="online-test-jee-main-advanced" >
                                    Online Test
                                </a></li>
                        </ul>

                        <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>NEET</h5></li><li> <a href="<?php echo base_url('videos/neet/29') ?>" title="videos-neet" >
                                    Videos
                                </a></li>
                                <li> <a href="<?php echo base_url('ncert-solution/neet/29'); ?>" title="ncert-solution-neet" >
                                    Ncert Solutions
                                </a></li>
                                <li> <a href="<?php echo base_url('question-bank/neet/29'); ?>" title="question-bank-neet" >
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('study-packages/neet/29') ?>" title="study-packages-neet" >
                                    Study Packages
                                </a></li>
                                <li><a href="<?php echo base_url('notes/neet/29') ?>" title="notes-neet" >
                                    Notes
                                </a></li>
                                <li><a href="<?php echo base_url('sample-papers/neet/29'); ?>" title="sample-papers-neet" >
                                    Sample Papers
                                </a></li> <li><a href="<?php echo base_url('online-test/neet-class/29'); ?>" title="online-test-neet" >
                                    Online Test
                                </a></li>
                        </ul>

                        <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>12th</h5></li><li> <a href="<?php echo base_url('videos/12th/22') ?>" title="videos-12th">
                                    Videos
                                </a></li>
                                <li><a href="<?php echo base_url('ncert-solution/12th/22'); ?>" title="ncert-solution-12th" >
                                    Ncert Solutions
                                </a></li>
                                <li><a href="<?php echo base_url('question-bank/12th/22'); ?>" title="question-bank-12th" >
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('study-packages/12th/22') ?>" title="study-packages-12th" >
                                    Study Packages
                                </a></li>
                                <li><a href="<?php echo base_url('notes/12th/22') ?>" title="notes-12th" >
                                    Notes
                                </a></li>
                                <li><a href="<?php echo base_url('sample-papers/12th/22'); ?>" title="sample-papers-12th" >
                                    Sample Papers
                                </a></li> <li><a href="<?php echo base_url('online-test/12th-class/22'); ?>" title="online-test-12th" >
                                    Online Test
                                </a></li>
                        </ul>


                        <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>11th</h5></li><li><a href="<?php echo base_url('videos/11th/23') ?>" title="videos-11th" >
                                    Videos
                                </a></li>
                                <li><a href="<?php echo base_url('ncert-solution/11th/23'); ?>" title="ncert-solution-11th" >
                                    Ncert Solutions
                                </a></li>
                                <li><a href="<?php echo base_url('question-bank/11th/23'); ?>" title="question-bank-11th" >
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('study-packages/11th/23') ?>" title="study-packages-11th" >
                                    Study Packages
                                </a></li>
                                <li><a href="<?php echo base_url('notes/11th/23') ?>" title="notes-11th" >
                                    Notes
                                </a></li>
                                <li><a href="<?php echo base_url('sample-papers/11th/23'); ?>" title="sample-papers-11th" >
                                    Sample Papers
                                </a></li> <li><a href="<?php echo base_url('online-test/11th-class/23'); ?>" title="online-test-11th" >
                                    Online Test
                                </a></li>
                        </ul>


                        <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>10th</h5></li><li><a href="<?php echo base_url('videos/10th/24') ?>" title="videos-10th" >
                                    Videos
                                </a></li>
                                <li><a href="<?php echo base_url('ncert-solution/10th/24'); ?>" title="ncert-solution-10th" >
                                    Ncert Solutions
                                </a></li>
                                <li><a href="<?php echo base_url('question-bank/10th/24'); ?>" title="question-bank-10th" >
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('study-packages/10th/24') ?>" title="study-packages-10th" >
                                    Study Packages
                                </a></li>
                                <li><a href="<?php echo base_url('notes/10th/24') ?>" title="notes-10th">
                                    Notes
                                </a></li>
                                <li> <a href="<?php echo base_url('sample-papers/10th/24'); ?>" title="sample-papers-10th" >
                                    Sample Papers
                                </a></li> <li><a href="<?php echo base_url('online-test/10th-class/24'); ?>" title="online-test-10th" >
                                    Online Test
                                </a></li>
                        </ul>
                        <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>9th</h5></li><li><a href="<?php echo base_url('videos/9th-class/30') ?>" title="videos-9th" >Videos
                                </a></li>
                                <li><a href="<?php echo base_url('ncert-solution/9th-class/30'); ?>" title="ncert-solution-9th" >Ncert Solutions
                                </a></li>
                                <li><a href="<?php echo base_url('question-bank/9th-class/30'); ?>" title="question-bank-9th" >Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('study-packages/9th-class/30') ?>" title="study-packages-9th" >Study Packages
                                </a></li>
                                <li><a href="<?php echo base_url('notes/9th-class/30') ?>" title="notes-9th" >Notes
                                </a></li>
                            <li><a href="<?php echo base_url('sample-papers/9th-class/30'); ?>" title="sample-papers-9th" >Sample Papers
                                </a></li> <li><a href="<?php echo base_url('online-test/9th-class/30'); ?>" title="online-test-9th" >
                                    Online Test
                                </a></li>
                        </ul>    
                         
                        <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>8th</h5></li>
                                <li><a href="<?php echo base_url('ncert-solution/8th/31'); ?>" title="studyadda"  title="ncert-solution-8th" >
                                    Ncert Solutions
                                </a></li>
                                <li><a href="<?php echo base_url('question-bank/8th/31'); ?>" title="question-bank-8th" >
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('study-packages/8th/31') ?>" title="study-packages-8th" >
                                    Study Packages
                                </a></li>
                                <li><a href="<?php echo base_url('notes/8th/31') ?>" title="notes-8th" >
                                    Notes
                                </a>
                                </li>
                            <li><a href="<?php echo base_url('sample-papers/8th/31'); ?>" title="sample-papers-8th" >
                                    Sample Papers
                                </a></li> <li><a href="<?php echo base_url('online-test/8th-class/31'); ?>" title="online-test-8th" >
                                    Online Test
                                </a></li><li><a href="#" title="8th" >&nbsp;
                                </a></li>
                        </ul>
                        
                        <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>7th</h5></li>
                                <li><a href="<?php echo base_url('ncert-solution/7th-class/38'); ?>" title="studyadda"  title="ncert-solution-7th" >
                                    Ncert Solutions
                                </a></li>
                                <li><a href="<?php echo base_url('question-bank/7th-class/38'); ?>" title="question-bank-7th" >
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('notes/7th-class/38') ?>" title="notes-7th" >
                                    Notes
                                </a>
                                </li>
                                
                                <li><a href="<?php echo base_url('study-packages/7th-class/38') ?>" title="study-packages-7th" >
                                    Study Packages
                                </a></li>
								
								
                                <li><a href="<?php echo base_url('sample-papers/7th-class/38') ?>" title="sample-papers-7th" >Sample Papers
                                </a></li><li><a href="<?php echo base_url('online-test/7th-class/38'); ?>" title="online-test-7th" >
                                    Online Test
                                </a></li>
                        </ul>
                        
                        <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>6th</h5></li>
                                <li><a href="<?php echo base_url('ncert-solution/6th-class/37'); ?>" title="studyadda"  title="ncert-solution-6th" >
                                    Ncert Solutions
                                </a></li>
                                <li><a href="<?php echo base_url('question-bank/6th-class/37'); ?>" title="question-bank-6th" >
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('notes/6th-class/37') ?>" title="notes-6th" >Notes</a>
                                </li>
                                
                                <li><a href="<?php echo base_url('study-packages/6th-class/37') ?>" title="study-packages-6th" >
                                    Study Packages
                                </a></li> <li><a href="<?php echo base_url('sample-papers/6th-class/37') ?>" title="sample-papers-6th" >Sample Papers
                                </a></li><li><a href="<?php echo base_url('online-test/6th-class/37'); ?>" title="online-test-6th" >
                                    Online Test
                                </a></li>
                        </ul>
                        
                        
                        <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>5th</h5></li>
                                <li><a href="<?php echo base_url('question-bank/5th-class/36'); ?>" title="question-bank-5th" >
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('notes/5th-class/36') ?>" title="notes-5th" >
                                    Notes
                                </a>
                                </li>
                                
                                <li><a href="<?php echo base_url('notes/5th-class/36') ?>" title="study-packages-5th" >
                                    Study Packages
                                </a></li><li><a href="<?php echo base_url('sample-papers/5th-class/36') ?>" title="sample-papers-5th" >Sample Papers
                                </a></li><li><a href="<?php echo base_url('online-test/5th-class/36'); ?>" title="online-test-5th" >
                                    Online Test
                                </a></li>
                        </ul>
                         <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>4th</h5></li>
                            
                                <li><a href="<?php echo base_url('question-bank/4th-class/35'); ?>" title="question-bank-4th" >
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('notes/4th-class/35') ?>" title="notes-4th" >
                                    Notes
                                </a>
                                </li>
                                
                                <li><a href="<?php echo base_url('study-packages/4th-class/35') ?>" title="study-packages-4th" >
                                    Study Packages
                                </a></li>                                <li><a href="<?php echo base_url('sample-papers/4th-class/35') ?>" title="sample-papers-4th" >Sample Papers</a></li><li><a href="<?php echo base_url('online-test/4th-class/35'); ?>" title="online-test-4th" >
                                    Online Test
                                </a></li>
                           
                        </ul>
                         <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>3rd</h5></li>                            
                                <li><a href="<?php echo base_url('question-bank/3rd-class/34'); ?>" title="question-bank-3rd" >
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('notes/3rd-class/34') ?>" title="notes-3rd" >
                                    Notes
                                </a>
                                </li>
								<li><a href="<?php echo base_url('study-packages/3rd-class/34') ?>" title="study-packages-3rd" >
                                Study Packages
                                </a>
                                </li>
                                <li><a href="<?php echo base_url('sample-papers/3rd-class/34') ?>" title="sample-papers-3rd">Sample Papers
                                </a></li>
								<li><a href="<?php echo base_url('online-test/3rd-class/34'); ?>" title="online-test-3rd" >
                                    Online Test
                                </a></li>
                        </ul>
                        
                        <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>2nd</h5></li>                            
                                <li><a href="<?php echo base_url('/question-bank/2nd-class/33'); ?>" title="question-bank-1st" >
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('notes/2nd-class/33') ?>" title="notes-1st" >
                                    Notes
                                </a>
                                </li> 
								<li><a href="<?php echo base_url('study-packages/2nd-class/33') ?>" title="study-packages2nd" >
                                Study Packages
                                </a>
                                </li>
                                <li><a href="<?php echo base_url('sample-papers/2nd-class/33') ?>" title="sample-papers-2nd" >Sample Papers
                                </a></li><li><a href="<?php echo base_url('online-test/2nd-class/33'); ?>" title="online-test-2nd" >
                                    Online Test
                                </a></li></ul>
                        <ul class="row col-xs-12 col-sm-4 col-md-2"><li><h5>1st</h5></li>   
                                <li><a href="<?php echo base_url('question-bank/1st-class/32'); ?>" title="question-bank-1st" >
                                    Question Bank
                                </a></li>
                                <li><a href="<?php echo base_url('notes/1st-class/32') ?>" title="notes-1st" >
                                    Notes
                                </a>
                                </li>
                                <li><a href="<?php echo base_url('study-packages/1st-class/32') ?>" title="study-packages-1st" >
                                    Study Packages
                                </a></li><li><a href="<?php echo base_url('sample-papers/1st-class/32') ?>" title="sample-papers-1st" >Sample Papers
                                </a></li>
								<li><a href="<?php echo base_url('online-test/1st-class/32'); ?>" title="online-test-1st" >
                                    Online Test
                                </a></li>
                        </ul>

                        <ul class="row col-xs-12  col-sm-4 col-md-2"><li><h5>Clat</h5></li>
                              
                                   <li><a href="<?php echo base_url('sample-papers/clat/73'); ?>" title="sample-papers-clat">
                                    Sample Papers
                                </a>
                                   </li>  <li><a href="<?php echo base_url('online-test/clat/73'); ?>" title="Online-Test-Clat">
                                Online Test
                                </a></li>
                        </ul>
                        
                       
                               <ul class="row col-xs-12  col-sm-4 col-md-2"><li><h5>Railways</h5></li>
                                       
                                   <li><a href="<?php echo base_url('sample-papers/railways/79'); ?>" title="sample-papers-Railways">
                                    Sample Papers
                                </a>
                                   </li>
                                     <li><a href="<?php echo base_url('study-packages/railways/79'); ?>" title="Study-Packages-Railways">
                                    Study Packages
                                </a>
                                   </li>
                                     <li><a href="<?php echo base_url('notes/railways/79'); ?>" title="Notes-Railways">
                                    Notes
                                </a>
                                   </li>
                                   <li><a href="<?php echo base_url('question-bank/railways/79'); ?>" title="question-bank-Railways">
                                    Question Bank
                                </a>
                                   </li>
                                   <li><a href="<?php echo base_url('online-test/railways/79'); ?>" title="Online-Test-Railways">
                                Online Test
                                </a></li>
                        </ul>
                        
          
                               <ul class="row col-xs-12  col-sm-4 col-md-2"><li><h5>UPSC</h5></li>
                                       
                                   <li><a href="<?php echo base_url('sample-papers/upsc/102'); ?>" title="sample-papers-upsc">
                                    Sample Papers
                                </a>
                                   </li>
                                     <li><a href="<?php echo base_url('study-packages/upsc/102'); ?>" title="Study-Packages-upsc">
                                    Study Packages
                                </a>
                                   </li>
                                     <li><a href="<?php echo base_url('notes/upsc/102'); ?>" title="Notes-upsc">
                                    Notes
                                </a>
                                   </li>
                                   <li><a href="<?php echo base_url('question-bank/upsc/102'); ?>" title="question-bank-Ssc">
                                    Question Bank
                                </a>
                                   </li>
                                  <li><a href="<?php echo base_url('online-test/upsc/102'); ?>" title="Online-Test-upsc">
                                Online Test
                                </a></li> 
                        </ul>
                              <ul class="row col-xs-12  col-sm-4 col-md-2"><li><h5>SSC</h5></li>
                                       
                                   <li><a href="<?php echo base_url('sample-papers/ssc/77'); ?>" title="sample-papers-Ssc">
                                    Sample Papers
                                </a>
                                   </li>
                                    <li><a href="<?php echo base_url('study-packages/ssc/77'); ?>" title="Study-Packages-Ssc">
                                   Study Packages
                                </a>
                                   </li>
								    <li><a href="<?php echo base_url('notes/ssc/77'); ?>" title="Notes-Ssc">
                                   Notes
                                </a>
                                   </li>
                                   <li><a href="<?php echo base_url('question-bank/77'); ?>" title="question-bank-Ssc">
                                    Question Bank
                                </a>
                                   </li>
                                   <li><a href="<?php echo base_url('online-test/ssc/77'); ?>" title="Online-Test-Ssc">
                                Online Test
                                </a></li>
                        </ul>
                              <ul class="row col-xs-12  col-sm-4 col-md-2"><li><h5>Banking</h5></li>
                               
                                   <li><a href="<?php echo base_url('sample-papers/banking/78'); ?>" title="sample-papers-Banking">
                                    Sample Papers
                                </a>
                                   </li>
                                     <li><a href="<?php echo base_url('study-packages/banking/78'); ?>" title="Study-Packages-Banking">
                                    Study Packages
                                </a>
                                   </li>
                                     <li><a href="<?php echo base_url('notes/banking/78'); ?>" title="Notes-Banking">
                                    Notes
                                </a>
                                   </li>
                                   <li><a href="<?php echo base_url('online-test/banking/78'); ?>" title="Online-Test-Banking">
                                Online Test
                                </a></li> 
                        </ul>
                    </div>
                </div>
                <hr>
                <!-- Copyright info -->
                <p class="copy">
                    Copyright &copy; 2007-2020 | 

                    <a href="<?php echo base_url() ?>">
                        https://www.studyadda.com
                    </a> 
                    <?php foreach ($this->config->item('toplinks') as $k => $v) {
                        if ($k != 'Exams') {
                            ?>

                            |  <a href="<?php echo base_url($v); ?>" title="<?php echo $k; ?> - studyadda.com">
        <?php echo $k; ?>
                            </a>

                        <?php }
                    }
                    ?>

                    | 
                    <a href="<?php echo base_url('articles') ?>"  title="studyadda articles" >
                        Articles
                    </a>
                   <!--|<a href="<?php //echo base_url('books') ?>"  title="studyadda articles" >
                        Books
                    </a>-->                    |  
                    <a href="<?php echo base_url('amazing-facts') ?>" title="studyadda amazing-facts" >
                        Amazing Facts
                    </a> | 
                    <a href="<?php echo base_url('free-videos') ?>" title="studyadda Free Videos" >
                        Free Videos
                    </a>

                </p>

                <p class="copy">
                    <a href="<?php echo base_url('contact-us') ?>" title="studyadda contact-us" >
                        Contact Us
                    </a>|                     
                    <a href="<?php echo base_url('jobs') ?>" title="studyadda jobs" >
                        Jobs
                    </a>| 
                    <a href="<?php echo base_url('about') ?>" title="studyadda about" >
                        About
                    </a>| 
                    <a href="<?php echo base_url('media') ?>" title="studyadda media" >
                        Media
                    </a>|
					<a href="<?php echo base_url('media/notify') ?>" title="studyadda media" >
                        Notification
                    </a>|  
                    <a href="<?php echo base_url('why-studyadda') ?>" title="studyadda why-studyadda" >
                        Why Studyadda?
                    </a>| 
                    <a href="<?php echo base_url('faq') ?>" title="Studyadda Lalit Sirdana Sir" >
                       FAQ
                    </a>| 
                    <a href="<?php echo base_url('lalit-sardana-sir') ?>" title="Studyadda Lalit Sirdana Sir" >
                       Lalit Sardana Sir
                    </a>|
                    <a href="<?php echo base_url('purchase-courses') ?>" title="Studyadda Purchase Courses" >
                       Purchase Courses
                    </a>|
                    <a href="<?php echo base_url('franchise') ?>" title="Studyadda franchise" >
                       Franchise
                    </a>| <a href="<?php echo base_url('privacy-policy') ?>" title="studyadda privacy-policy" >
                        Privacy Policy
                    </a>|
                    <a href="<?php echo base_url('refund-policy') ?>" title="Studyadda franchise" >
                       Refund Policy
                    </a>
                </p>
            </div>
        </div>
        <div class="clearfix">
        </div>
    </div>
</footer>
<!-- top arrow -->

<span class="totop animate">
    <a href="#">
        <i class="fa fa-chevron-up">
        </i>
    </a>
</span>   
<!-- /.container --> 
<?php }

if($showFooterJs=='yes'){
 ?>
<script src="<?php echo get_assets_cdn('assets/js/lightbox-plus-jquery.min.js'); ?>" ></script> 
<?php } ?>
<!-- jQuery -->
<script src="<?php echo get_assets_cdn('assets/frontend/js/jquery.js') ?>"></script>
<script src="<?php echo get_assets_cdn('assets/frontend/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo get_assets_cdn('assets/frontend/js/material.min.js'); ?>"></script>
<script src="<?php echo get_assets_cdn('assets/frontend/js/jquery.validator.min.js') ?>"></script>
<?php  if($showFooterJs=='yes'){ ?>
<script src="<?php echo get_assets_cdn('assets/frontend/js/isotope-docs.min.js') ?>"></script> 
<?php } ?>
<script src="<?php echo get_assets_cdn('assets/frontend/js/toastr.min.js') ?>"></script>

<script src="<?php echo get_assets_cdn('assets/frontend/js/jquery.lazyload.min.js') ?>"></script>
<script src="<?php echo get_assets_cdn('assets/frontend/js/common.min.js') ?>"></script>
<?php  if($showFooterJs=='yes'){  ?>
<script src="<?php echo get_assets_cdn('assets/js/prettyPhoto.js') ?>" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
<!--start Hide inspect element-->
<?php if($segmentURL=='videos'){ ?>
$(document).bind("contextmenu",function(e) {
 e.preventDefault();
});
$(document).keydown(function(e){
    if(e.which === 123){
       return false;
    }
});
<?php } ?>
<!--start Hide inspect element-->
			$(document).ready(function(){
				$("area[rel^='prettyPhoto']").prettyPhoto();
				
				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: true});
				$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
		
				$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

				$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
					changepicturecallback: function(){ _bsap.exec(); }
				});
			});
                        
			</script>

<script>
    
$(function() {
    $("img.lazy").lazyload();
});
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    if (isChrome) {
        $('#videoplayer_div').click(function () {
            if ($("#videoplayer").get(0).paused) {
                $("#videoplayer").get(0).play();
            } else {
                $("#videoplayer").get(0).pause();
            }
        });
    }
    $('#updatePass').click(function () {
        var confirm_password = $('#confirm_password').val();
        var password = $('#password').val();
        if ((password != '') && (confirm_password != password)) {
            alert('Password and Confierm Password Not Equal!');
            return false;
        }

    });
/*For All product Display*/
$('#btn1_showPackages').click(function(){
     $("#showVideo").hide();
     $("#showTest").hide();
     $("#showPackages").show()
});
$('#btn2_showVideo').click(function(){
     
     $("#showTest").hide();
     $("#showPackages").hide()
     $("#showVideo").show()
});
 $('#btn3_showTest').click(function(){
     
     $("#showPackages").hide()
     $("#showVideo").hide()
     $("#showTest").show()
});
</script>
<script>
    $(document).ready(function () {
        $.material.init();
        $(window).bind('scroll', function () {
            var navHeight = 110;
            ($(window).scrollTop() > navHeight) ? $('nav.mainnav').addClass('goToTop') : $('nav.mainnav').removeClass('goToTop');
        });
    });
</script>



<!-- Script to Activate the Carousel -->
<script>
   /* $('.carousel').carousel({
        interval: 5000 //changes the speed
    });
   


    }*/ function checkdvd() {
        if ($('input#dvdreq').is(':checked')) {
            $('#delivery_req').val(1);
        }
    }
</script>

<script>
    $(document).ready(function () {

        //Check to see if the window is top if not then display button
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.totop').fadeIn();
            } else {
                $('.totop').fadeOut();
            }
        });

        //Click event to scroll to top
        $('.totop').click(function () {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });

    });
     <?php if ($this->router->fetch_module() == 'customer') { ?>
        var active = false;
            $('.panel-collapse').collapse('show');
            $('.panel-title').attr('data-toggle', '');
            <?php } ?>
</script>
<?php
if (isset($scripts) && count($scripts) > 0) {
    foreach ($scripts as $key => $script) {
        ?>
        <script type="text/javascript" src="<?php echo strpos($script, 'http') !== false ? $script : $this->config->item('web_root') . $script; ?>"></script>

    <?php }
} ?>
<?php if ($this->router->fetch_module() == 'videos' && $this->router->fetch_method() == 'play' && $is_amazonvideo == true && $purchased === true) { ?>
    <script type="text/javascript">jwplayer.key = "p7Zhpk56OBkJSEwvXdwoZN72GmgESu8k4OMEOQ==";</script>
    <script type='text/javascript'>
        jwplayer('videoplayer_frm').setup({
            "flashplayer": base_url + '/assets/frontend/js/jwplayer/player.swf',
            "streamer": "rtmp://<?php echo $streamHostUrl; ?>/cfx/st",
            "file": "mp4:<?php echo $signedURL; ?>",
            "primary": "flash",
            "type": "rtmp",
            "image": "<?php echo $preview_image ?>",
            "width": "800",
            "height": "430",
            //"wmode":"transparent",
            "controlbar": {
                "position": "bottom"
            },
            "ga": {
                "idstring": "title",
                "trackingobject": "pageTracker",
            },
            "analytics": {
                "google": {
                    "custom": {
                        "enable": true,
                        "accountId": "UA-8672555-1",
                        "impressions": {
                            "linear": "testing video",
                            "nonLinear": "testing video",
                            "companion": "testing video"
                        }
                    }
                }
            },
            "logo": {
                "file": "<?php echo base_url('image') ?>",
                "link": "<?php echo base_url(); ?>",
                "position": 'top-right',
                "linktarget": "_blank",
                "hide": "false",
                "timeout": 5
            }

        });
        $(document).ready(function () {

            if (jwplayer('videoplayer_frm')) {
//alert($streamHostUrl+'--'+$signedURL);
                loadSignedUrl();
            }
    //jwplayer('video').play();
        });
        var trackcomplete=0;
        function loadSignedUrl(pos) {
            $.ajax({
                method: "POST",
                url: base_url + "/common/getsignedurl",
                data: "resource=<?php echo $resourceKey ?>",
                success: function (data) {
                    jwplayer('videoplayer_frm').load({
                        "streamer": "rtmp://<?php echo $streamHostUrl; ?>/cfx/st",
                        file: data
                    });
                    jwplayer('videoplayer_frm').play();
                    if(pos > 0){
                        jwplayer('videoplayer_frm').seek(pos);
                    }else{
                        if(trackcomplete==0){
                        $.post( base_url + "api/customer/videostart/<?php echo $this->session->userdata('customer_id')?>/<?php echo $video->id?>", function( data ) {
                            trackcomplete=data;
                        });
                    }
                    }
                    
                }
            });
        }
        if (jwplayer('videoplayer_frm')) {
            jwplayer('videoplayer_frm').onError(function () {
            var pos= jwplayer('videoplayer_frm').getPosition();
            loadSignedUrl(pos);
            });
            jwplayer('videoplayer_frm').onComplete(function () {
                
            $.post( base_url + "api/customer/videocomplete/"+trackcomplete, function( data ) {
                trackcomplete=0;
            });
            });
        }
    </script>

<?php } ?>   
<!-- Fix mozilla Issue - Install flash player www.studyadda.com/flashplayer24_xa_install.exe  OR https://admdownload.adobe.com/bin/live/flashplayer24_xa_install.exe
-->
<?php if (isset($loadMathJax)) { ?>
    <!--mathJax -->
    <script type="text/x-mathjax-config">
        //
        //  Do NOT use this page as a template for your own pages.  It includes 
        //  code that is needed for testing your site's installation of MathJax,
        //  and that should not be used in normal web pages.  Use sample.html as
        //  the example for how to call MathJax in your own pages.
        //
        MathJax.HTML.Cookie.Set("menu",{});
        MathJax.Hub.Config({
        extensions: ["tex2jax.js","TeX/AMSmath.js", "TeX/AMSsymbols.js"],
        jax: ["input/TeX","output/HTML-CSS"],
        "HTML-CSS": {
        availableFonts:[],
        styles: {".MathJax_Preview": {visibility: "hidden"},".MathJax_Display":{display:'inline'}}
        }
        });

        MathJax.Hub.Register.StartupHook("HTML-CSS Jax Ready",function () {
        MathJax.Hub.Insert(MathJax.InputJax.TeX.Definitions.macros,{
        cancel: ["Extension","cancel"],
        bcancel: ["Extension","cancel"],
        xcancel: ["Extension","cancel"],
        cancelto: ["Extension","cancel"]
        });
        var HTMLCSS = MathJax.OutputJax["HTML-CSS"];
        if (HTMLCSS && HTMLCSS.imgFonts) {document.getElementById("imageFonts").style.display = ""}

        var FONT = MathJax.OutputJax["HTML-CSS"].Font;
        FONT.loadError = function (font) {
        MathJax.Message.Set("Can't load web font TeX/"+font.directory,null,2000);
        document.getElementById("noWebFont").style.display = "";
        };
        FONT.firefoxFontError = function (font) {
        MathJax.Message.Set("Firefox can't load web fonts from a remote host",null,3000);
        document.getElementById("ffWebFont").style.display = "";
        };
        $("ul#filter li a").click(function(){
        var $grid = $('.grid').isotope({
        // options
        });
        var selText = $(this).text();
        var filter=$(this).attr('tag');

        $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
        $grid.isotope({ filter: '.'+filter });
        });
        });


    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/MathJax/MathJax.js"></script>
<?php } ?>

<script>
    /*$("ul#filter li a").click(function(){
     var $grid = $('.grid').isotope({
     // options
     });
     var selText = $(this).text();
     var filter=$(this).attr('tag');
     
     $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
     $grid.isotope({ filter: '.'+filter });
     });*/

</script>
<?php if (isset($is_youtubevideo) && $is_youtubevideo) { ?>
    <script>
        // Load the IFrame Player API code asynchronously.
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/player_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // Replace the 'ytplayer' element with an <iframe> and
        // YouTube player after the API code downloads.
        var player;
        function onYouTubePlayerAPIReady() {
            player = new YT.Player('ytplayer', {
                height: '430',
                width: '800',
                videoId: '<?php echo $video->video_url_code; ?>'
            });
        }
    </script>
<?php } ?>
<script>
    $(document).on('click', '#mloginbtn', function () {
        $('#mainlogin').show('slow');
        $('#mainsignup').hide('slow');
        $('#login_msg').html('');
        $('.error-notice').hide();
        return false;
    });
    $(document).on('click', '#msignupbtn', function () {
        $('#mainlogin').hide('slow');
        $('#mainsignup').show('slow');
        $('#login_msg').html('');
        $('.error-notice').hide();
        return false;
    });
<?php if ($this->session->userdata('ask_mobile') == 1) { ?>
        $(window).load(function () {
            $('#addmobile').modal({show: true, backdrop: 'static', keyboard: false});
        });
<?php } elseif ($this->session->userdata('ask_mobile_verification') == 1) { ?>
        $(window).load(function () {
            $('#otpverification').modal({show: true, backdrop: 'static', keyboard: false});
            $('#otpverification').on('shown.bs.modal', function (e) {

                $.ajax({
                    method: "GET",
                    url: base_url + "customer/welcome/generateOtp",
                    success: function (data) {

                    }
                });
                // do something...
            });
        });
<?php } ?>
<?php if ($this->session->userdata('mobileverified') == 1) { ?>
    $(window).load(function () {
            $('#otpverified').modal({show: true, backdrop: 'static', keyboard: false});
        });
        
<?php $this->session->unset_userdata('mobileverified'); } ?>
    $('body').on('shown.bs.modal', function (e) {
        $("#add_mobile_chk").validate({
            ignore: "",
            rules: {
                // Rules for validation


                mobileregi_otp: {
                    required: true,
                    /*minlength: 10,
                    maxlength: 10,*/
                    digits: true

                }
            },
            messages: {
                // messages for valided fields

                mobileregi_otp: {
                    required: "Please enter 10 digit mobile number.",
                    /*minlength: 'Please enter 10 digit mobile number.',
                    maxlength: 'Please enter 10 digit mobile number.',
                    */
                }
            }
        });
        $("#otp_verification").validate({
            ignore: "",
            rules: {
                // Rules for validation


                mobile: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                    digits: true

                }
            },
            messages: {
                // messages for valided fields

                mobile: {
                    required: "Please enter 6 digits OTP.",
                    minlength: 'Please enter 6 digits OTP.',
                    maxlength: 'Please enter 6 digits OTP.',
                }
            }
        });
    });
    function getCity() {
        var state_id = $('#state').val();
        $.ajax({
            type: "GET",
            url: base_url + "common/cities/" + state_id,
            //data:'email=' + $('#email').val() + '&password=' + $('#password').val(),
            //dataType: "json",
            success: function (response)
            {
                $('#city').html(response);
                //alert(response.toSource());
                /*if(response.success===false){ 
                 $('#err_msg').html(response.message).show();
                 }else{
                 window.location.href=base_url+'account';
                 }*/
            }
        });
    }

    $(document).ready(function () {
        if ($('.product-description').get(0)) {
            $('.product-description').shorten({
                moreText: 'read more',
                lessText: 'read less',
                showChars: 500,
            });
        }
    });
    $(document).ready(function () {
        $('#pinBoot').pinterest_grid({
            no_columns: 4,
            padding_x: 10,
            padding_y: 10,
            margin_bottom: 50,
            single_column_breakpoint: 700
        });
    });
    $("#mainsearch").submit(function (event) {
        var query = $("#search_txt").val();
        var type = $('input[name=search]:checked', '#mainsearch').val();
        var action = base_url + 'search/' + query + '/' + type;
        window.location.href = action;
        event.preventDefault();
    });
    
    function show_contant_count(boxId='#PopUpprd_count'){
        $(boxId).delay(500).css({"z-index": "99", "visibility": "visible", "opacity": "1", "transition": "all .5s linear"});
     setTimeout(function () {
        $(boxId).css("visibility", "hidden");
        }, 9000);
    }
    
    function hide_contant_count(boxId='PopUpprd_count'){
        $(boxId).css("visibility", "hidden");
    }

    function showmsg() {
        var seconds = 3;
        $('#sec').html(seconds);
        $('#PopUpMessage').delay(500).css({"z-index": "99", "visibility": "visible", "opacity": "1", "transition": "all .5s linear"});
        var redirect = setTimeout(function () {
            window.location.href = base_url + 'login';
            //$('#PopUpMessage').css("visibility", "hidden");
        }, 3000);

        var count = setInterval(function () {
            seconds--;
            $('#sec').html(seconds);
            if (seconds == 0) {
                clearInterval(count);
            }
        }, 1000);
        return false;
    }
</script>

<script language=JavaScript>

<?php
$fatchMoule=$this->router->fetch_module() ;
$currentpage='';
if($fatchMoule=='login'){ 
$currentpage='login';
}else{
$currentpage='other';
?>
	
var message="Right Click Disabled!";

function clickIE4(){
if (event.button==2){
alert(message);
return false;
}
}
function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
alert(message);
return false;
}
}
}
if(document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("alert(message);return false");
<?php } ?>
$(document).on('click','#report_error',function(){
    $('#error_box').toggle();
});
$(".scrollhtml").click(function() {
    $('html, body').animate({
        scrollTop: $("#freevideos_"+$(this).attr('id')).offset().top-100
    }, 1000);
    });
    function showaddress(){
        $('#other_addresses').show();
    }
</script>

<script type="text/javascript">
function chk_mob()
{
var a = document.change_mobile.changeMobile.value;
if(a=="")
{
alert("please Enter the Contact Number");
document.change_mobile.changeMobile.focus();
return false;
}
if(isNaN(a))
{
alert("Enter the valid Mobile Number(Like : 9566137117)");
document.change_mobile.changeMobile.focus();
return false;
}
if((a.length < 1) || (a.length > 10))
{
alert(" Your Mobile Number must be 1 to 10 Integers");
document.change_mobile.changeMobile.select();
return false;
}
}
</script>
<? } ?>
<div id="PopUpprd_count">
    <p style="font-family: 'Open Sans'; font-size: 14px; font-weight: 400; letter-spacing: 0px; color: #555f66; text-align: left;"><span id="panel_prd_popup"><a id="close_prd_popup" onclick="hide_contant_count('#PopUpprd_count')" href="#"><i class="fa fa-close" style="font-size:24px;color:red"></i></a><br></span>
    <?php 
    
    if($studymaterial_count>0){
       echo "New ".$studymaterial_count." Study Packages Recenly Uploaded!";
    }else if($video_count>0){
       echo "New ".$video_count." Videos Recenly Uploaded!";
    }   
    
    //echo "<br>LIMITED OFFER HURRY UP! OFFER AVAILABLE ON ALL MATERIAL TILL ".$MACRO_OFFER_DATE." ONLY!<br>";
    ?>  
    </p>
</div>  
<!-- let's call the following div as the POPUP FRAME -->
    <div id="popup_checkout" style="display:none" >
    <p style="width:180px; font-family: 'Open Sans'; font-size: 14px; font-weight: 400; letter-spacing: 0px; color: #555f66; text-align: left;"><span id="panel_prd_popup2"><a id="close_prd_popup2" onclick="hide_contant_count('#popup_checkout')" href="#"><i class="fa fa-close" style="font-size:24px;color:red"></i></a><br></span>
    Please Wait you are being redirected....
    <img width="32" height="32" style="width:80px" src="<?php echo base_url('assets/images/loading_spinner.gif') ?>" alt="Please Wait ...">
    </p>
</div>
        
<div id="PopUpMessage">
    <p>You need to login to perform this action.<br>You will be redirected in 
        <span id="sec">3</span> sec
        <span class="msg-gif">
        <img src="<?php echo base_url('assets/frontend/images/msg-gif.GIF') ?>" alt="spinner"/>
        </span>
    </p>
</div>   
<?php
if($show_new_contant_popup=='yes'){
    if($studymaterial_count>0||$video_count>0){
        ?>
<script>show_contant_count('#PopUpprd_count'); </script>
    <?php
    }
}  
if($this->uri->segment(2)=='confirm'){
    

?>
<script> show_contant_count('#popup_checkout'); </script>
<?php } ?>
<div class="modal fade" id="forgotpassword" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form action="" method="post" name="forgot_password" id="forgot_password">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Reset Password.</b></h4>
                </div>
                <div class="modal-body" id="forgetpass_content">
                    Email : <input class="form-control email_form" type="email" name="email" id="email">
                </div>
                <div class="modal-footer" id="forgetpass_content_button">
                    <button type="submit" class="btn btn-success">Send Password</button>
                    <button type="cancel" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!------forgot password pop up--->
<div class="modal fade" id="addmobile" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <form action="<?php echo base_url('customer/welcome/updatemobile') ?>" method="post" name="add_mobile" id="add_mobile">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><b>Add Mobile</b></h4>
                </div>
                <div class="modal-body">
                    Enter Mobile Number<input class="form-control email_form" type="text" min="10" max="10" name="mobileregi_otp" id="mobileregi_otp">
                </div>
                <div class="modal-footer" id="forgetpass_content_button"><button type="submit" class="btn btn-success text-right">Submit</button>
                </div><div id="forgetpass_content_button" class="">
                <a href="<?php echo base_url('user/logout');?>" class="btn btn-success text-left">Logout</a>
</div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="otpverification" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
       <div class="modal-content">
       <form action="<?php echo base_url('customer/welcome/verifyotp') ?>" method="post" name="otp_verification" id="otp_verification">
                  
                <div class="modal-header">

                    <h4 class="modal-title"><b>Enter OTP</b></h4>
                    <p>OTP has been sent to your mobile number <b><?php echo $this->session->userdata('ask_mobile_no'); ?></b> and is valid for one hour</p>
                    <?php if($this->session->flashdata('otp')){ ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('otp');?></div>
                    <?php } ?>
                </div>
                <div class="modal-body">
                    Enter One Time Password <input class="otp form-control email_form" type="" name="otp" id="otp">
                </div>
                <div class="modal-footer" id="forgetpass_content_button">
                    <button type="submit" class="btn btn-success">Submit</button>

                </div>   
        </form>
            </div>
<div class="modal-content">
    <form action="<?php echo base_url('customer/welcome/changeMobile') ?>" onsubmit="return chk_mob()" method="post" name="change_mobile" id="change_mobile">
         Change Mobile: <input type="text" name="changeMobile" id="changeMobile" value="" >
           <button type="submit" class="btn btn-success">Submit</button>
</form>
    
    <div class="modal-footer">
            <a class="btn btn-warning btn-raised btn-block" title="Studyadda-Logout" href="<?php echo base_url('customer/logout');?>">
                                Logout
            </a>
                </div> 
     
</div>
           
        
    </div>
</div>
<div class="modal fade" id="otpverified" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><b>Mobile Number Verified</b></h4>
                    
                </div>
                <div class="modal-body">
                    <div class="alert alert-success">
                    <p>Your mobile number <b><?php echo $this->session->userdata('ask_mobile_no'); ?></b> is verified.</p>
                    </div>
                </div>
                 <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>    
            </div>
    </div>
</div>
<?php if($showFooterJs=='yes'){ ?>
<script type="text/javascript">
    
    function showhide_featured(aId){ 
     
$("div.vidblock").children().css('display','none'); 
    $("#btn_"+aId).css('display', 'block');
    }
    
    function checkSingleQus(aId,aRight){ 
        //$('#ansblock').children('i').css('display','none'); 

//$( "span.ansblock" ).children().css('display','none'); 
        if(aRight==1){
            $("#ansright_"+aId).css('display', 'block');
            
        }else{
            $("#answrong_"+aId).css('display', 'block');
        }
		//$( "#resultArea" ).html('3');
		
    }
</script>
<script>
$(document).ready(function() {
   $(document).on('click','#vert',function(){
     $('#slide-bottom-popup').modal('show');
    });
});
$('body').on('shown.bs.modal', function (e) {
   $('.subscribe').hide();
$("#subscribe").validate({
    ignore: "",
    rules: {
        subscriber_email: {
            required: true,
            email: true,
            
        },
        subscriber_mobile: {
            required: true,
            minlength: 10,
            maxlength: 10,
            digits: true
        }
    },
    messages: {
        subscriber_email: {
            required: "Please enter your email.",
            email: "Please enter a valid email"
        },
        subscriber_mobile: {
                    required: "Please enter mobile number.",
                    minlength: 'Please enter 10 digit mobile number.',
                    maxlength: 'Please enter 10 digits mobile number.',
                    digits:'Please enter only numbers'
                }
    },
    submitHandler: function(a) {
        $.ajax({
            type: "POST",
            url: base_url + "api/customer/subscribe",
            data: $("#subscribe").serialize(),
            dataType: "json",
            success: function(b) {
                if (b.status === 0) {} else {
                    $("#subcontent").html('<div class="alert alert-success alert-dismissible" id="success-alert" role="alert"><strong>Thanks for showing interest.<br> Our team will get in touch with you.</strong></div>');
                    $("#subcontent_button").html('<button type="cancel" class="btn btn-danger" data-dismiss="modal">Close</button>')
                }
            }
        })
    }
});
});
$('body').on('hide.bs.modal', function (e) {
$('.subscribe').show();
});
/*if (navigator.geolocation) {
  alert('Geolocation is supported!');
}
else {
  alert('Geolocation is not supported for this Browser/OS version yet.');
}*/

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
 window.onload = function() {
          //For bloking location popup 
		  setCookie('havelocation','0',1);   
        if (navigator.geolocation && getCookie('havelocation')=='') {
          var startPos;
          var geoOptions = {
            enableHighAccuracy: true
          }

          var geoSuccess = function(position) {
            startPos = position;
            //document.getElementById('startLat').innerHTML = startPos.coords.latitude;
            //document.getElementById('startLon').innerHTML = startPos.coords.longitude;
           
            $.ajax({
                method: "POST",
                url: base_url + "/common/getlocation",
                data: "latitude="+startPos.coords.latitude+'&longitude='+startPos.coords.longitude,
                success: function (data) {
                     setCookie('havelocation','1',1);
                }
            });
          };
          var geoError = function(error) {
              setCookie('havelocation','0',1);
            //console.log('Error occurred. Error code: ' + error.code);
            // error.code can be:
            //   0: unknown error
            //   1: permission denied
            //   2: position unavailable (error response from location provider)
            //   3: timed out
          };

          navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions);
            }
    };
    
    function showbought_subject(examname = null, exam_id = 0, subjectname = null, subject_id = 0, chapter_name = null, chapter_id = 0){  
          $('html, body').animate({
        scrollTop: $('#container_top').offset().top - 20 //#DIV_ID is an example. Use the id of your destination on the page
    }, 'slow');
        var str='';
        if(exam_id >  0 && subject_id > 0){
            // GET Chapters
            $.ajax({
                url:base_url+"study-material/welcome/showbought_subject/"+examname+'/'+exam_id+'/'+subjectname+'/'+subject_id+'/'+chapter_name+'/'+chapter_id,  
                dataType:'json',
                success:function(response) {
                    //var selectbox=$("#chapter");
                    //$('#recent_orderdiv').hide() ;
                  $.each(response,function(index,item){
                       //productslist
if (item.productslist_html.length > 0) {
    
       str+=item.productslist_html;
        
}else{
    
       str+='<div class="col-xs-12 col-md-9 prod_list_exam"><div class="col-md-12 text-center bavl"><h2>No Information Found</h2</div></div>';
    
}

//if(item.productslist_count<=1){
   //$('div.no_download_info').effect("highlight", {}, 3000); 
//}

                  });
                  
                  
                  ////$('#showbught_result').empty() ;
                  
                   $('#showbught_result').html(str);
                }
            });
        }
    }


function showbought_videos(examname = null, exam_id = 0, subjectname = null, subject_id = 0, chapter_name = null, chapter_id = 0){  
          $('html, body').animate({
        scrollTop: $('#container_top').offset().top - 20 //#DIV_ID is an example. Use the id of your destination on the page
    }, 'slow');
        var str='';
        if(exam_id >  0 && subject_id > 0){
            // GET Chapters
            $.ajax({
                url:base_url+"videos/welcome/showbought_videos/"+examname+'/'+exam_id+'/'+subjectname+'/'+subject_id+'/'+chapter_name+'/'+chapter_id,  
                dataType:'json',
                success:function(response) {
                    //var selectbox=$("#chapter");
                    //$('#recent_orderdiv').hide() ;
                  $.each(response,function(index,item){
                       //productslist
if (item.productslist_html.length > 0) {
    
       str+=item.productslist_html;
        
}else{
    
       str+='<div class="col-xs-12 col-md-9 prod_list_exam"><div class="col-md-12 text-center bavl"><h2>No Information Found</h2</div></div>';
    
}

//if(item.productslist_count<=1){
   //$('div.no_download_info').effect("highlight", {}, 3000); 
//}

                  });
                  
                  
                  ////$('#showbught_result').empty() ;
                  
                   $('#showbught_result').html(str);
                }
            });
        }
    }
</script>          
 <script>
    lightbox.option({
      'resizeDuration': 1000,
      'wrapAround': true,
    });
   //http://lokeshdhakar.com/projects/lightbox2/
   
 //$("#accordion1").accordion({ collapsible : true, active : false});
 
</script> 
<?php } 

 if($boltpayu=='yes'){ 
?>
<!-- BOLT Production/Live //-->
<!--// script id="bolt" src="https://checkout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="e34524" bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script //-->

<script type="text/javascript"><!--
$('#payment_form').bind('load blur', function(){
	$.ajax({
          url: '<?php echo base_url('customer/payUmoney_json'); ?>',
          type: 'post',
          data: JSON.stringify({ 
            key: $('#key').val(),
			salt: $('#salt').val(),
			txnid: $('#txnid').val(),
			amount: $('#amount').val(),
		    pinfo: $('#pinfo').val(),
            fname: $('#fname').val(),
			email: $('#email').val(),
			mobile: $('#mobile').val(),
			udf5: $('#udf5').val()
          }),
		  contentType: "application/json",
          dataType: 'json',
          success: function(json) {
            if (json['error']) {
			 $('#alertinfo').html('<i class="fa fa-info-circle"></i>'+json['error']);
            }
			else if (json['success']) {	
				$('#hash').val(json['success']);
            }
          }
        }); 
});
//-->
</script>
<script type="text/javascript"><!--
function launchBOLT()
{
	bolt.launch({
	key: $('#key').val(),
	txnid: $('#txnid').val(), 
	hash: $('#hash').val(),
	amount: $('#amount').val(),
	firstname: $('#fname').val(),
	email: $('#email').val(),
	phone: $('#mobile').val(),
	productinfo: $('#pinfo').val(),
	udf5: $('#udf5').val(),
	surl : $('#surl').val(),
	furl: $('#surl').val(),
	cart_id: $('#cart_id').val(),
	mode: 'dropout'	
},{ responseHandler: function(BOLT){
	console.log( BOLT.response.txnStatus );		
	if(BOLT.response.txnStatus != 'CANCEL')
	{
		//Salt is passd here for demo purpose only. For practical use keep salt at server side only.
		var fr = '<form action=\"'+$('#surl').val()+'\" method=\"post\">' +
		'<input type=\"hidden\" name=\"key\" value=\"'+BOLT.response.key+'\" />' +
		'<input type=\"hidden\" name=\"salt\" value=\"'+$('#salt').val()+'\" />' +
		'<input type=\"hidden\" name=\"txnid\" value=\"'+BOLT.response.txnid+'\" />' +
		'<input type=\"hidden\" name=\"amount\" value=\"'+BOLT.response.amount+'\" />' +
		'<input type=\"hidden\" name=\"productinfo\" value=\"'+BOLT.response.productinfo+'\" />' +
		'<input type=\"hidden\" name=\"firstname\" value=\"'+BOLT.response.firstname+'\" />' +
		'<input type=\"hidden\" name=\"email\" value=\"'+BOLT.response.email+'\" />' +
		'<input type=\"hidden\" name=\"udf5\" value=\"'+BOLT.response.udf5+'\" />' +
		'<input type=\"hidden\" name=\"mihpayid\" value=\"'+BOLT.response.mihpayid+'\" />' +'<input type=\"hidden\" name=\"cart_id\" value=\"'+BOLT.response.cart_id+'\" />' +
		'<input type=\"hidden\" name=\"status\" value=\"'+BOLT.response.status+'\" />' +
		'<input type=\"hidden\" name=\"hash\" value=\"'+BOLT.response.hash+'\" />' +
		'</form>';
		var form = jQuery(fr);
		jQuery('body').append(form);								
		form.submit();
	}
},
	catchException: function(BOLT){
 		alert( BOLT.message );
	}
});
}
//--
</script>	

<?php 
}
if($hideumodany=='yes') {  
?>
<div id="google_translate_element"></div>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>
  window.addEventListener('load', function() {
    var setInt = setInterval(function() {
      if (jQuery('.form-box:contains("You are successfully registered")').is(":visible")) {
        ga('send', 'event', 'form', 'submit', 'sign up');
        clearInterval(setInt);
      }
    }, 1000)
  })
</script>
<?php } ?>

<script>
function addLikes(id,action,cid,ptyp) {
	$('.demo-table #tutorial-'+id+' li').each(function(index) {
		$(this).addClass('selected');
		$('#tutorial-'+id+' #rating').val((index+1));
		if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
			return false;	
		}
	});
	$.ajax({
	url: "<?php echo base_url('videos/welcome/likesave'); ?>",
	data:'id='+id+'&action='+action+'&cid='+cid+'&ptyp='+ptyp,
	type: "POST",
	beforeSend: function(){
		$('#tutorial-'+id+' .btn-likes').html("<img src='<?php echo base_url('assets/images/loaderIcon.gif')?>' />");
	},
	success: function(data){
	var likes = parseInt($('#likes-'+id).val());
	switch(action) {
		case "like":
		$('#tutorial-'+id+' .btn-likes').html('<input type="button" title="Unlike" class="unlike" onClick="addLikes('+id+',\'unlike\','+cid+','+ptyp+')" />');
		likes = likes+1;
		break;
		case "unlike":
		$('#tutorial-'+id+' .btn-likes').html('<input type="button" title="Like" class="like"  onClick="addLikes('+id+',\'like\','+cid+','+ptyp+')" />')
		likes = likes-1;
		break;
	}
	$('#likes-'+id).val(likes);
	if(likes>0) {
		$('#tutorial-'+id+' .label-likes').html(likes+" Like(s)");
	} else {
		$('#tutorial-'+id+' .label-likes').html('');
	}
	}
	});
}
</script>

<script src="<?php echo get_assets_cdn('assets/js/wow.min.js'); ?>" ></script> 
<script>
new WOW().init();
</script>

<script src="<?php echo get_assets_cdn('assets/js/wow.min.js'); ?>" ></script> 
<script>
new WOW().init();
</script>
<span class="subscribe animate hidden-xs">
    <div class="btn btn-raised btn-warning" id="vert">Free<br> Videos</div>
</span>
<input type="hidden" id="startLat"><input type="hidden" id="startLon">
<div role="dialog" id="slide-bottom-popup" class="modal fade in" data-keyboard="false" data-backdrop="false" style="padding-right: 14px;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form id="subscribe" name="subscribe" method="post" action="" novalidate="novalidate">
            <div class="modal-content" style="border:5px solid #4caf50;">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">×</button>
                    For free video lectures fill in the form below and we will get back to you.
                </div>
                <div id="subcontent" class="modal-body">
                    <div class="form-group1 form-group has-success label-floating is-empty">
                        <label class="control-label" for="exampleInputEmail"><em>*</em> Email Address:</label>
                        <input type="email" name="subscriber_email" class="form-control" id="subscriber_email">
                    </div>
                    <div class="form-group1 form-group has-success label-floating is-empty">
                        <label class="control-label" for="exampleInputMobile"><em>*</em> Mobile Number:</label>
                        <input type="text" name="subscriber_mobile" class="form-control" id="subscriber_mobile">
                    </div>                   
                </div>
                <div id="subcontent_button" class="modal-footer">
                    <button class="btn btn-success" type="submit">Submit</button>
                    <button data-dismiss="modal" class="btn btn-danger" type="cancel">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
