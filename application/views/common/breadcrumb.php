<?php
$segments = $this->uri->total_segments();
$currentSegment=$this->uri->segment(1);
$mainlinks = $this->config->item('toplinks');
$breadcrumb['<i class="glyphicon glyphicon-home"></i>'] = base_url();
$word_free_toshow = '';
if (array_search($this->uri->segment(1), $mainlinks) =='Ncert Solutions') {
    $word_free_toshow = 'Free';
}
if ($segments == 1) {
    if (array_search($this->uri->segment(1), $mainlinks)) {
        $breadcrumb[$word_free_toshow . ' ' . array_search($this->uri->segment(1), $mainlinks)] = '';
    } else {
        if ($this->uri->segment(1) == 'featured-videos') {
            $breadcrumb['Featured Videos'] = '';
        }
        if ($this->uri->segment(1) == 'cart') {
            $breadcrumb['Checkout'] = '';
        }
        if ($this->uri->segment(1) == 'login') {
            $breadcrumb['My Account'] = '';
        }
        if ($this->uri->segment(1) == 'search') {
            $breadcrumb['Search'] = '';
        }
        if ($this->uri->segment(1) == 'amazing-facts') {
            $breadcrumb['Amazing Facts'] = '';
        }
        if ($this->uri->segment(1) == 'contact-us') {
            $breadcrumb['Contact Us'] = '';
        }
        if ($this->uri->segment(1) == 'jobs') {
            $breadcrumb['Jobs'] = '';
        }

        if ($this->uri->segment(1) == 'privacy-policy') {

            $breadcrumb['Privacy Policy'] = '';
        }
		 if ($this->uri->segment(1) == 'refund-policy') {

            $breadcrumb['Refund Policy'] = '';
        }
        if ($this->uri->segment(1) == 'about') {

            $breadcrumb['About'] = '';
        }
        if ($this->uri->segment(1) == 'payment_terms') {

            $breadcrumb['Terms and Condition'] = '';
        }
        
         if ($this->uri->segment(1) == 'lalitsardana') {

            $breadcrumb['Lalit Sardana'] = '';
        }
        if ($this->uri->segment(1) == 'purchase-courses') {

            $breadcrumb['Materials For Purchase'] = '';
        }
        if ($this->uri->segment(1) == 'media') {

            $breadcrumb['Media'] = '';
        }
        if ($this->uri->segment(1) == 'why-studyadda') {

            $breadcrumb['Why Studyadda'] = '';
        }
        if ($this->uri->segment(1) == 'articles') {

            $breadcrumb['Articles'] = '';
        }
        if ($this->uri->segment(1) == 'current-affairs') {

            $breadcrumb['Current Affairs'] = '';
        }
        
        if ($this->uri->segment(1) == 'online-test') {
            $breadcrumb['Test Series'] = '';
        }
		 
        if ($this->uri->segment(1) == 'online-test-result') {
            $breadcrumb['Test Series Result'] = '';
        }
		if ($this->uri->segment(1) == 'faq') {
            $breadcrumb['FAQ'] = '';
        }
        
         if ($this->uri->segment(1) == 'franchise') {
            $breadcrumb['Franchise'] = '';
        }
        
        if ($this->uri->segment(1) == 'guest') {
            $breadcrumb['Guest Checkout'] = '';
        }
        
        if ($this->uri->segment(1) == 'franchise_welcome') {
            $breadcrumb['Franchise Application'] = '';
        }
        
    }
} else {
if ($this->uri->segment(1) == 'online-test') {
    $breadcrumb['Online Test'] =  base_url('online-test');
        
}
if ($this->uri->segment(1) == 'online-test-result') {
    $breadcrumb['Online Test Result'] =  base_url('online-test');
        
}
    if (array_search($this->uri->segment(1), $mainlinks)) {
        $breadcrumb[$word_free_toshow . ' ' . array_search($this->uri->segment(1), $mainlinks)] = base_url($this->uri->segment(1));
    }
    if (isset($selectedexam)) {
        $breadcrumb[addSuffix($selectedexam->name, 'Class')] = base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id);
    }
    if (isset($selectedsubject)) {
        $breadcrumb[$selectedsubject->name] = base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-', true) . '/' . $selectedsubject->id);
    }
    if (isset($selectedchapter)) {
        $breadcrumb[$selectedchapter->name] = base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-', true) . '/' . $selectedsubject->id . '/' . url_title($selectedchapter->name, '-', true) . '/' . $selectedchapter->id);
    }
    if ($this->uri->segment(1) == 'articles') {
        $breadcrumb['Articles'] = base_url('articles');
        if ($this->uri->segment(2) == 'archives') {
            $dateObj = DateTime::createFromFormat('!m', $this->uri->segment('4'));
            $monthName = $dateObj->format('F'); // March
            $breadcrumb['Archives ' . $monthName . ' ' . $this->uri->segment('3')] = '';
        } else {
            if ($category) {
                $breadcrumb[$category->name] = base_url('articles/' . url_title($category->name, '-', true) . '/' . $category->id);
            }
            if ($segments == 4 && is_int($this->uri->segment(3) !== 1)) {
                $breadcrumb[$postdetails->title] = '';
            }
        }
    }
    
    if ($this->uri->segment(1) == 'current-affairs') {
        $breadcrumb['Current Affairs'] = base_url('current-affairs');

        if ($this->uri->segment(2) == 'archives') {
            $dateObj = DateTime::createFromFormat('!m', $this->uri->segment('4'));
            $monthName = $dateObj->format('F'); // March
            $breadcrumb['Current Affairs ' . $monthName . ' ' . $this->uri->segment('3')] = '';
        } else {
            if ($category) {
                $breadcrumb[$category->name] = base_url('current-affairs/' . url_title($category->name, '-', true) . '/' . $category->id);
            }
            if ($segments == 4 && is_int($this->uri->segment(3) !== 1)) {
                $breadcrumb[$postdetails->title] = '';
            }
        }
    }
    
    if ($this->uri->segment(1) == 'search') {

        $breadcrumb['Search'] = '';
        
    }
    if ($this->uri->segment(1) == 'online-test') {
        if(isset($usertest_result_info->name)){
       $testname = $usertest_result_info->name;
        }
        if(isset($testname)&&($testname!='' )){ 
            $testname_array=explode('-', $testname);
            $testname_string=implode(' ', $testname_array);
            $showtestname = ucfirst($testname_string);
            }else{
            $showtestname= '';
            }
            
       if($this->uri->segment(2)!='result'){
        if (!isset($selectedexam)) {
            $breadcrumb[ucfirst($this->uri->segment(2))] = base_url('online-test'); 
        }
        
        if (!isset($selectedsubject)) {
            if(!is_numeric($this->uri->segment(3))&&($this->uri->segment(3)!='')){
            $breadcrumb[ucfirst($this->uri->segment(3))] = base_url('online-test');  
            }
        }
        if (!isset($selectedchapter)) {
            $segValue=$this->uri->segment(4);
            if(($segValue!='')&&!is_numeric($this->uri->segment(4))){
           if($segValue!='subject'){
           $breadcrumb[ucfirst($this->uri->segment(4))] = base_url('online-test'); 
           
           }
            }
        }
       }
                                //$breadcrumb['Online Test'] = '';
                               //$breadcrumb[ucfirst($this->uri->segment(2))] = base_url('online-test'); 
                                if(!$showtestname==''){
                                $breadcrumb[$showtestname] = '';
                                }
                            } 
}
if (isset($relation)) {
    if ($relation->exam_id > 0) {
        $breadcrumb[addSuffix($relation->exam, 'Class')] = base_url($this->uri->segment(1) . '/' . url_title($relation->exam, '-', true) . '/' . $relation->exam_id);
    }
    if ($relation->subject_id > 0) {
        $breadcrumb[$relation->subject] = base_url($this->uri->segment(1) . '/' . url_title($relation->exam, '-', true) . '/' . $relation->exam_id . '/' . url_title($relation->subject, '-', true) . '/' . $relation->subject_id);
    }
    if ($relation->chapter_id > 0) {
        $breadcrumb[$relation->chapter] = base_url($this->uri->segment(1) . '/' . url_title($relation->exam, '-', true) . '/' . $relation->exam_id . '/' . url_title($relation->subject, '-', true) . '/' . $relation->subject_id . '/' . url_title($relation->chapter, '-', true) . '/' . $relation->chapter_id);
    }
    if (isset($relation->name)) {
        $breadcrumb[$relation->name] = '';
    }
    if (isset($relation->title)) {
        $breadcrumb[$relation->title] = '';
    }
}
     if ($this->router->fetch_method() == 'confirm') {
            $breadcrumb['Checkout'] = '';
        }
               
if ($this->router->fetch_method() == 'freevideos') {
    if($segments==1){
    $breadcrumb['Free Video Lectures'] = '';
    }else{
    $breadcrumb['Free Video Lectures'] = base_url('free-videos');
    $breadcrumb[$exam->name] = '';
    }
}
//$this->session->set_userdata('breadcrumb',$breadcrumb);
?>
<div class="col-md-12">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="<?php echo ($this->router->fetch_method() != 'question' && $this->router->fetch_module() != 'articles') ? 'col-xs-12 col-sm-12 col-md-7 mobnone' : 'col-md-12' ?>">
        <ol class="breadcrumb">
            <?php $count = 1;
            foreach ($breadcrumb as $key => $value) { ?>

                <li <?php echo $count == count($breadcrumb) ? 'class="active"' : '' ?>>
                    <?php if ($count < count($breadcrumb)) { ?>
                        <a title="Studyadda" href="<?php echo $value != '' ? $value : '#' ?>">
                            <?php echo $key; ?>
                        </a>
                    <?php } else {
                        echo $key;
                    } ?>
                </li>
    <?php $count++;
} ?>

        </ol>
    </div>
	</div>

      
	   <?php if ($this->router->fetch_method() != 'question' && $this->router->fetch_module() != 'articles'&& $this->uri->segment(1) != 'featured-videos'&& $this->uri->segment(1) != 'current-affairs'&& $this->uri->segment(1) != 'articles') {  ?>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 rht_exam_select hidden-xs">
     <div class="lang_tran col-lg-4 col-md-4 col-sm-12 col-xs-12" style="display:block; margin-top:10px;">
	 
	 <?php
	 $hideumod=array('cart','login','purchase-courses','exams','search','study-packages','videos','featured-videos');
	
if(in_array($currentSegment,$hideumod)){
	$hideumodany='no';
	
}else{
	$hideumodany='yes';	
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
<?php
	 } 
?>
</div>		

    <?php
	$restrict_modularray=array('videos');
    if (isset($module_name)&&(!in_array($module_name,$restrict_modularray))) {
//if($module_name=='exams'){ 
        ?>            
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 btn-group">
                    <a href="" data-target="#" class="btn btn-raised dropdown-toggle btn-warning" data-toggle="dropdown" aria-expanded="false">
                        Select Content
                        <span class="caret"></span>
                    </a><ul class="dropdown-menu">
                            <?php foreach ($this->config->item('toplinks') as $k => $v) {
                                if ($k != 'Exams') { ?>
                                <li><a href="<?php
                                    if (isset($selectedchapter)) {
                                        echo base_url($v . '/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-', true) . '/' . $selectedsubject->id . '/' . url_title($selectedchapter->name, '-', true) . '/' . $selectedchapter->id);
                                    } elseif (isset($selectedsubject)) {
                                        echo base_url($v . '/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id . '/' . url_title($selectedsubject->name, '-', true) . '/' . $selectedsubject->id);
                                    } elseif (isset($selectedexam)) {
                                        echo base_url($v . '/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id);
                                    }else{
                                        echo base_url($v);
                                    }
                                    ?>"><?php echo $k; ?></a></li>
            <?php }
        } ?>
</ul>
                </div>
<?php //}else{ 
if($this->uri->segment(1) == 'featured-videos'||$this->uri->segment(1) == 'videos'){
	
}else{
        if(!isset($selectedexam)){
        ?>
                <div class="btn-group">              
                    <a href="" data-target="#" class="btn btn-raised dropdown-toggle btn-primary" data-toggle="dropdown" aria-expanded="false">
                        Select Exam
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($mainexamcategories as $ex) { ?>
                            <li>
            <?php echo "<a href='" . base_url($this->uri->segment(1) . '/' . url_title($ex->name, '-', true) . '/' . $ex->id) . "'>{$ex->name}</a>"; ?>
                            </li>
                <?php } ?>

                    </ul>
                </div>
            <?php //}
        }else{ 
if(isset($subjects_array)&&count($subjects_array)>0){
	//Show subject in which containt avilable only.
?>

            <div class="btn-group">              
                    <a href="" data-target="#" class="btn btn-raised dropdown-toggle btn-primary" data-toggle="dropdown" aria-expanded="false">
                        Select Subjects
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach($subjects_array as $key=>$value){
				if($value['count']>0){

				
				?>
                            <li>
            <?php echo "<a href='" . base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id.'/'. url_title($key, '-', true).'/'.$key) . "'>{$value['name']}</a>"; ?>
                            </li>
                <?php 
					}
				} 
				?>

                    </ul>
                </div>

<?php
	
}elseif((count($subject_chapters))>0){
			?>
            <div class="btn-group">              
                    <a href="" data-target="#" class="btn btn-raised dropdown-toggle btn-primary" data-toggle="dropdown" aria-expanded="false">
                        Select Subjects
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach($subject_chapters as $key=>$value){ ?>
                            <li>
            <?php echo "<a href='" . base_url($this->uri->segment(1) . '/' . url_title($selectedexam->name, '-', true) . '/' . $selectedexam->id.'/'. url_title($key, '-', true).'/'.$value['id']) . "'>{$key}</a>"; ?>
                            </li>
                <?php } ?>

                    </ul>
                </div>
        <?php }
					
	
					}
}
}
        ?>

        </div>
        <?php } ?>
</div>
<div class="clearfix"></div>
<div class="col-md-12">
<?php 
if(isset($this->session->userdata['customer_id'])&&$this->session->userdata['customer_id']>0){
$customer_id=$this->session->userdata['customer_id'];
 if(isset($usertest_info)&&count($usertest_info)>0){
$callmd10='col-md-10';
 }else{
$callmd10='';	 
 }
}else{
$callmd10='';
$customer_id=0;	
}
?>
<div class="heading-bar <?php echo $callmd10; ?>">
                <?php if ($this->router->fetch_method() != 'question') { ?>
            <h1><?php } else { ?><h2><?php
                }
                if (isset($h1title)) {
                    echo $h1title;
                } else {
                    if ($segments == 1) {
                        if (array_search($this->uri->segment(1), $mainlinks)) {
                            $breadcrumb[array_search($this->uri->segment(1), $mainlinks)] = '';
                        } else {
                            if ($this->uri->segment(1) == 'cart') {
                                echo 'Checkout';
                            }
                            if ($this->uri->segment(1) == 'login') {
                                echo 'My Account';
                            }
                            if ($this->router->fetch_class() == 'search') {
                                echo 'Search';
                                echo $searchtxt;
                            }

                            if ($this->uri->segment(1) == 'contact-us') {
                                echo 'Contact Us';
                            }
                            if ($this->uri->segment(1) == 'jobs') {

                                echo "Jobs";
                            }
                            if ($this->uri->segment(1) == 'privacy-policy') {

                                echo 'Privacy Policy';
                            }
                            if ($this->uri->segment(1) == 'about') {

                                echo 'About';
                            }
                            if ($this->uri->segment(1) == 'media') {

                                echo 'Media';
                            }
                            if ($this->uri->segment(1) == 'why-studyadda') {

                                echo 'Why Studyadda?';
                            }
                            if ($this->uri->segment(1) == 'articles') {

                                echo 'Articles';
                            }
                            if ($this->uri->segment(1) == 'faq') {

                                echo 'FAQ';
                            }
                             if ($this->uri->segment(1) == 'guest') {

                                echo 'Guest Checkout';
                            }
                        }
                    } else {
                        $count = 1;
                        foreach ($breadcrumb as $key => $value) {
                            ?>

                            <?php if ($count > 2) { ?>


                                <?php echo $key; ?>


                            <?php } ?>

                            <?php
                            $count++;
                        }
                       
                        if ($this->router->fetch_module() == 'exams') {
                            echo 'Online Coaching';
                        }
                        if ($this->router->fetch_module() == 'samplepapers') {
                            echo 'Sample Paper';
                        }
                        if ($this->router->fetch_module() == 'studymaterial') {
                            echo 'Study Packages';
                        }
                        if ($this->router->fetch_module() == 'solvedpapers') {
                            echo 'Solved Papers';
                        }
                        if ($this->router->fetch_module() == 'videos' && $this->router->fetch_method() != 'freevideos') {
                            echo 'Online Videos';
                        }
                        if ($this->router->fetch_module() == 'questionbank') {
                            echo 'Question Bank';
                        }
                            if ($this->router->fetch_method() == 'freevideos') {
                           
                            if($segments==1){
                                echo 'Free Video Lectures';
                            }else{
                                echo 'Free Video Lectures for ' . $exam->name;
                            }
                            
                        }
                        if ($this->router->fetch_class() == 'search') {
                                echo 'Search';
                                echo $searchtxt;
                            }
                    }
                }
                ?> 
            <?php if ($this->router->fetch_method() != 'question') { ?> </h1><?php
            } else {
                if (isset($spdetails)) {
                    echo $spdetails->name;
                }
                if (isset($qbdetails)) {
                    echo $qbdetails->name;
                }
                ?></h2><?php } ?>
        <span class="h-line"></span>
    </div>
<?php
if (($this->uri->segment(1) == 'online-test')&&($customer_id>0)) {
	  if(isset($usertest_info)&&count($usertest_info)>0){
		?>			  
	<div class="col-md-2">
    <a class="btn btn-lg btn-md btn-success btn-raised pull-right" href="<?php echo base_url('online-test-result/allexam-result/'.$customer_id) ?>">
                                        Result
                                        </a> <span class="h-line"></span>
										</div>
<?php
} 
}
?>
</div>
