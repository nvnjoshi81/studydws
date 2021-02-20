<?php
ob_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends Modulecontroller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Onlinetest_model');
        $this->load->model('File_model');
        $this->load->model('Orders_model');	   
		$this->load->model('Subjects_model');     
		$this->load->model('Chapters_model');
        $this->load->helper('utility_functions');
    }
	
    public function index($examname = null, $exam_id = 0, $subjectname = null, $subject_id = 0, $chapter_name = null, $chapter_id = 0) {
		
	   $customer_id = $this->session->userdata('customer_id');
       $isProduct_array=array();
       $ts_categories=$this->Examcategory_model->getExamCatgeories();
       foreach($ts_categories as $ex){ 
       $ts_chapter_id='';
       $ts_subject_id='';     
       $ts_exam_id=$ex->id;
       $testseries_Product = $this->Pricelist_model->getProduct($ts_exam_id, $ts_subject_id, $ts_chapter_id, 3);
       if(isset($testseries_Product)){
       if(count($testseries_Product)>0){
       $isProduct_array[]= $testseries_Product;
       }
       }
       }
       
        $this->data['isProduct_array'] = $isProduct_array;
        $total_segments=$this->uri->total_segments()+1;
        $this->load->library('pagination');
        $examdata = array();
        if ($examname == null) {
            $title = getTitle('Online Test', $this->data['examcategories']);

            $titleStr[] = $title;
        } else {
            $titleStr[] = 'Online Test for';
        }
        if ($exam_id > 0) {
            $exam = $this->Categories_model->getCategoryDetails($exam_id);
            $this->data['selectedexam'] = $exam;
            $titleStr[] = addSuffix($exam->name, 'Class');
        }
        if ($subject_id > 0) {
            
            $this->data['selectedsubject'] = $this->Subjects_model->getSubject($subject_id);
            $titleStr[] = $this->data['selectedsubject']->name;
        }
        if ($chapter_id > 0) {
            $this->data['selectedchapter'] = $this->Chapters_model->getChapter($chapter_id);
            $titleStr[] = $this->data['selectedchapter']->name;
        }
        if ($exam_id) {
            $data_array = array();
            $chaptersubjects = $this->Examcategory_model->getExamChapters($exam_id);
            if(isset($chaptersubjects)){
            if (count($chaptersubjects) > 0) {
                foreach ($chaptersubjects as $record) {
                    if (array_key_exists($record->sname, $data_array)) {
                        //$data_array[$record->name][]
                        array_push($data_array[$record->sname]['chapters'], array($record->cid, $record->cname));
                    } else {
                        $data_array[$record->sname]['id'] = $record->sid;
                        if (isset($data_array[$record->sname]['chapters'])) {
                            array_push($data_array[$record->sname]['chapters'], array($record->cid, $record->cname));
                        } else {
                            $data_array[$record->sname]['chapters'][0] = array($record->cid, $record->cname);
                        }
                    }
                }
        } }
            $this->data['subject_chapters'] = $data_array;
        }        
        /***** pgination _categories***   */
         $onlinetest_array = $this->Onlinetest_model->getOnlineTests($exam_id, $subject_id, $chapter_id);
         if(isset($chaptersubjects)){
           $total=count($onlinetest_array);
         }else{
           $total=0;  
         }
               
         $this->data['total']=$total;
         $config = array();
                
                $showperpage=$this->config->item('records_per_page');
                 if (($exam_id > 0)&&($subject_id == 0)&&($chapter_id == 0)) {
                $config["base_url"] = base_url() . "online-test/exam/".$exam_id;
                 }else{
                     $showperpage= 100;
                 }
                 
                 if (($exam_id > 0)&&($subject_id > 0)&&($chapter_id == 0)) {
                $config["base_url"] = base_url() . "online-test/exam/".$exam_id."/subject/".$subject_id;
                 }
                 
                $config["total_rows"] = $total;
                $config["per_page"] = $showperpage;
                $config["uri_segment"] = $total_segments;
                $config["num_links"] = 5;
                $config['first_link']='&lsaquo; First';
                $config['first_tag_open'] = '<li>';
                $config['first_tag_close'] = '</li>';
                $config['last_link']='Last &rsaquo;';
                $config['last_tag_open'] = '<li>';
                $config['last_tag_close'] = '</li>';
                $config['full_tag_open'] = '<ul class="pagination">';
                $config['full_tag_close'] = '</ul>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = '<li class="active"><a>';
                $config['cur_tag_close'] = '</a></li>';
                $config['next_tag_open'] = '<li>';
                $config['next_tag_close'] = '</li>';
                $config['prev_tag_open'] = '<li>';
                $config['prev_tag_close'] = '</li>';
                $config['reuse_query_string'] = true;
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                $this->data['page']=$page;
        $this->data["links"] = $this->pagination->create_links();
        $onlinetest = $this->Onlinetest_model->getOnlineTests($exam_id, $subject_id, $chapter_id,$config["per_page"], $page);
        $this->data['onlinetest'] = $onlinetest;
        /*Start get test list by module id like qb,sp and solved papers*/
        $solved_paper_moduleid=10;
        $sample_paper_moduleid=6;
        $quation_bank_moduleid=7;
        $sp_test=$this->Onlinetest_model->getOnlineTests_bymodule($exam_id, $subject_id, $chapter_id,$sample_paper_moduleid);
		if(count($sp_test)<1||$sp_test==null){
        $sp_test=$this->Onlinetest_model->getOnlineTests_bymodule($exam_id, $subject_id, $chapter_id);
		}
        $solpap_test=$this->Onlinetest_model->getOnlineTests_bymodule($exam_id, $subject_id, $chapter_id,$solved_paper_moduleid);
        $notin_moduleid=10;
		$qb_test=$this->Onlinetest_model->getOnlineTests_bymodule($exam_id, $subject_id, $chapter_id,$quation_bank_moduleid,$notin_moduleid);
        /*Get category based online exam*/
        $Ot_categoryArry=$this->Onlinetest_model->getolExamCategory($exam_id);
        $all_testdata=array();
        if(isset($Ot_categoryArry)){
            foreach($Ot_categoryArry as $Ot_category){
        $exCategory_id = $Ot_category->id;
        $exCategory_name = $Ot_category->name;
        $cat_basedTest_array=$this->Onlinetest_model->OnlineTests_byCategory($exam_id, $subject_id, $chapter_id,$exCategory_id);
        $all_testdata[$exCategory_name]= $cat_basedTest_array;
            }
        }
        if(isset($all_testdata)){
        if(count($all_testdata)>0){
            $this->data['catWise_test']=$all_testdata;
        }
        }else{
            $this->data['catWise_test']=NULL;
        }
         
        /*End Get Category based */
        
        $this->data['sp_test']=$sp_test;
        $this->data['solpap_test']=$solpap_test;
        $this->data['qb_test']=$qb_test;
        
        /*End Get test by module id*/
         $onlinetest_jeemain = $this->Onlinetest_model->getOnlineTests(28, '', '',$config["per_page"], 0);
        $this->data['onlinetest_jeemain'] = $onlinetest_jeemain;        
        
         $onlinetest_neet = $this->Onlinetest_model->getOnlineTests(29, $subject_id, $chapter_id,$config["per_page"], 0);
        $this->data['onlinetest_neet'] = $onlinetest_neet;
        
        $onlinetestquestions = $this->Onlinetest_model->getQuestionCount($exam_id, $subject_id, $chapter_id);
        $this->data['title'] = implode(' ', $titleStr);
        $this->data['h1title'] = implode(' ', $titleStr);
        $this->data['onlinetestquestions'] = $onlinetestquestions;
        $this->data['exam_id'] = $exam_id;
        $this->data['subject_id'] = $subject_id;
        $this->data['chapter_id'] = $chapter_id;
        $this->data['examdata'] = $examdata;
	    $this->data['usertest_info'] = $this->Onlinetest_model->get_testinfo_by_customer($customer_id);
        $this->data['content'] = 'welcome';
        $this->load->view('template', $this->data);
    }
     public function exampaper($exam_id = 0, $page_id = 0) { 
         $examname = null; $subjectname = null; $subject_id = 0; $chapter_name = null; $chapter_id = 0;
         $this->load->library('pagination');
        $examdata = array();
        
        $total_segments=$this->uri->total_segments();
        if ($examname == null) {
            $title = getTitle('Online Test', $this->data['examcategories']);

            $titleStr[] = $title;
        } else {
            $titleStr[] = 'Online Test for';
        }
        if ($exam_id > 0) {
            $exam = $this->Categories_model->getCategoryDetails($exam_id);
            $this->data['selectedexam'] = $exam;
            $titleStr[] = addSuffix($exam->name, 'Class');
        }
        if ($subject_id > 0) {
            $this->data['selectedsubject'] = $this->Subjects_model->getSubject($subject_id);
            $titleStr[] = $this->data['selectedsubject']->name;
        }
        if ($chapter_id > 0) {
            $this->data['selectedchapter'] = $this->Chapters_model->getChapter($chapter_id);
            $titleStr[] = $this->data['selectedchapter']->name;
        }
        if ($exam_id) {
            $data_array = array();
            $chaptersubjects = $this->Examcategory_model->getExamChapters($exam_id);
            if (isset($chaptersubjects)&&(count($chaptersubjects) > 0)) {
                foreach ($chaptersubjects as $record) {
                    if (array_key_exists($record->sname, $data_array)) {
                        //$data_array[$record->name][]
                        array_push($data_array[$record->sname]['chapters'], array($record->cid, $record->cname));
                    } else {
                        $data_array[$record->sname]['id'] = $record->sid;
                        if (isset($data_array[$record->sname]['chapters'])) {
                            array_push($data_array[$record->sname]['chapters'], array($record->cid, $record->cname));
                        } else {
                            $data_array[$record->sname]['chapters'][0] = array($record->cid, $record->cname);
                        }
                    }
                }
            }
            $this->data['subject_chapters'] = $data_array;
        }
        /***** pgination categories***   */
         $onlinetest_array = $this->Onlinetest_model->getOnlineTests($exam_id, $subject_id, $chapter_id);
         if(isset($onlinetest_array)){
         $total=count($onlinetest_array);
         }else{
             $total=0;
         }  
         $this->data['total']=$total;
                $config = array();
                $config["base_url"] = base_url() ."online-test/exam/".$exam_id;
                $config["total_rows"] = $total;
                $config["per_page"] = $this->config->item('records_per_page');
                $config["uri_segment"] = $total_segments;
                $config["num_links"] = 5;
                $config['first_link']='&lsaquo; First';
                $config['first_tag_open'] = '<li>';
                $config['first_tag_close'] = '</li>';
                $config['last_link']='Last &rsaquo;';
                $config['last_tag_open'] = '<li>';
                $config['last_tag_close'] = '</li>';
                $config['full_tag_open'] = '<ul class="pagination">';
                $config['full_tag_close'] = '</ul>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = '<li class="active"><a>';
                $config['cur_tag_close'] = '</a></li>';
                $config['next_tag_open'] = '<li>';
                $config['next_tag_close'] = '</li>';
                $config['prev_tag_open'] = '<li>';
                $config['prev_tag_close'] = '</li>';
                $config['reuse_query_string'] = true;
                $this->pagination->initialize($config);
                $page = ($page_id) ? $page_id : 0;
                $this->data['page']=$page;
        $this->data["links"] = $this->pagination->create_links();
        $onlinetest = $this->Onlinetest_model->getOnlineTests($exam_id, $subject_id, $chapter_id,$config["per_page"], $page);
        $this->data['onlinetest'] = $onlinetest;
        $onlinetestquestions = $this->Onlinetest_model->getQuestionCount($exam_id, $subject_id, $chapter_id);
        $this->data['title'] = implode(' ', $titleStr);
        $this->data['h1title'] = implode(' ', $titleStr);
        $this->data['onlinetestquestions'] = $onlinetestquestions;
        $this->data['exam_id'] = $exam_id;
        $this->data['subject_id'] = $subject_id;
        $this->data['chapter_id'] = $chapter_id;
        $this->data['examdata'] = $examdata;
        $this->data['content'] = 'welcome';
        $this->load->view('template', $this->data);
    }
    
    public function subjectpaper($exam_id = 0,$subject_id=0,$page_id = 0){
        
        $examname = null; $subjectname = null; $chapter_name = null; $chapter_id = 0;
         $this->load->library('pagination');
        $examdata = array();
        
        $total_segments=$this->uri->total_segments();
        if ($examname == null) {
            $title = getTitle('Online Test', $this->data['examcategories']);

            $titleStr[] = $title;
        } else {
            $titleStr[] = 'Online Test for';
        }
        if ($exam_id > 0) {
            $exam = $this->Categories_model->getCategoryDetails($exam_id);
            $this->data['selectedexam'] = $exam;
            $titleStr[] = addSuffix($exam->name, 'Class');
        }
        if ($subject_id > 0) {
           
            $this->data['selectedsubject'] = $this->Subjects_model->getSubject($subject_id);
            $titleStr[] = $this->data['selectedsubject']->name;
        }
        if ($chapter_id > 0) {
            
            $this->data['selectedchapter'] = $this->Chapters_model->getChapter($chapter_id);
            $titleStr[] = $this->data['selectedchapter']->name;
        }
        if ($exam_id) {
            $data_array = array();
            $chaptersubjects = $this->Examcategory_model->getExamChapters($exam_id);
            
         if(isset($chaptersubjects)){
            if (count($chaptersubjects) > 0) {
                foreach ($chaptersubjects as $record) {
                    if (array_key_exists($record->sname, $data_array)) {
                        //$data_array[$record->name][]
                        array_push($data_array[$record->sname]['chapters'], array($record->cid, $record->cname));
                    } else {
                        $data_array[$record->sname]['id'] = $record->sid;
                        if (isset($data_array[$record->sname]['chapters'])) {
                            array_push($data_array[$record->sname]['chapters'], array($record->cid, $record->cname));
                        } else {
                            $data_array[$record->sname]['chapters'][0] = array($record->cid, $record->cname);
                        }
                    }
                }
        } 
        
                        }
            $this->data['subject_chapters'] = $data_array;
        }
        
         /***** pgination _categories***   */
         $onlinetest_array = $this->Onlinetest_model->getOnlineTests($exam_id, $subject_id, $chapter_id);
         
         if(isset($total)){
                $total=count($onlinetest_array);
         }else{
             $total=0;
         }
                $this->data['total']=$total;
                $config = array();
                $config["base_url"] = base_url() . "online-test/exam/".$exam_id."/subject/".$subject_id;
                $config["total_rows"] = $total;
                $config["per_page"] = $this->config->item('records_per_page');
                $config["uri_segment"] = $total_segments;
                $config["num_links"] = 5;
                $config['first_link']='&lsaquo; First';
                $config['first_tag_open'] = '<li>';
                $config['first_tag_close'] = '</li>';
                $config['last_link']='Last &rsaquo;';
                $config['last_tag_open'] = '<li>';
                $config['last_tag_close'] = '</li>';
                $config['full_tag_open'] = '<ul class="pagination">';
                $config['full_tag_close'] = '</ul>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = '<li class="active"><a>';
                $config['cur_tag_close'] = '</a></li>';
                $config['next_tag_open'] = '<li>';
                $config['next_tag_close'] = '</li>';
                $config['prev_tag_open'] = '<li>';
                $config['prev_tag_close'] = '</li>';
                $config['reuse_query_string'] = true;
                $this->pagination->initialize($config);
                $page = ($page_id) ? $page_id : 0;
                $this->data['page']=$page;
        $this->data["links"] = $this->pagination->create_links();
        $onlinetest = $this->Onlinetest_model->getOnlineTests($exam_id, $subject_id, $chapter_id,$config["per_page"], $page);
        $this->data['onlinetest'] = $onlinetest;
        $onlinetestquestions = $this->Onlinetest_model->getQuestionCount($exam_id, $subject_id, $chapter_id);
        $this->data['title'] = implode(' ', $titleStr);
        $this->data['h1title'] = implode(' ', $titleStr);
        $this->data['onlinetestquestions'] = $onlinetestquestions;
        $this->data['exam_id'] = $exam_id;
        $this->data['subject_id'] = $subject_id;
        $this->data['chapter_id'] = $chapter_id;
        $this->data['examdata'] = $examdata;
        $this->data['content'] = 'welcome';
        $this->load->view('template', $this->data);
    
    }
	 public function start_exam($examname, $subjectname, $chaptername, $testname, $examid) {
	$customer_id = $this->session->userdata('customer_id');
	if(isset($examname)&&$examname=='resumetest'){
	if(isset($subjectname)&&$subjectname!=''){
		$subjectname_resume=explode('usertestid-',$subjectname);
		$resume_usertestid=$subjectname_resume[1];
		 }
 $this->data['resume_usertestid'] = $resume_usertestid;	
		 
		 $resumetestinfo=$this->Onlinetest_model->get_testinfo_byid($resume_usertestid);
		 $time_remaining=$resumetestinfo->time_remaining;
		 $resume_exam_id=$resumetestinfo->exam_id;
		 }else{
$this->data['resume_usertestid'] = 0;	

$this->data['time_remaining'] = 0;

		 }
		
        $this->data['examname'] = $examname;
        $this->data['subjectname'] = $subjectname;
        $this->data['chaptername'] = $chaptername;
        $this->data['testname'] = $testname;
        $onlinetestinfo = $this->Onlinetest_model->detail($examid);
        $onlinequestioninfo = $this->Onlinetest_model->getolQuestion($examid);
        $this->data['usertest_info'] = $this->Onlinetest_model->get_testinfo_by_customer($customer_id);
		 $examname_replaced=str_replace("-"," ",$examname);
		
        $catid_byname=$this->Categories_model->getCategoriesbyname($examname_replaced);

		$catidbyname=$catid_byname[0]->id;
	    if(isset($catidbyname)&&$catidbyname>0){
		$exam_id = $catidbyname;
		}elseif(isset($onlinetestinfo->exam_id)&&$onlinetestinfo->exam_id>0){
        $exam_id = $onlinetestinfo->exam_id;
       }else{
        $exam_id=$resume_exam_id;  
       }
	   
    $isProduct = $this->Pricelist_model->getProduct($exam_id, '', '', 3);
       /*Get Info for produt block Start*/
             $isProduct_array=array();    
       if(count($isProduct)>0){
                   $isProduct_array[]= $isProduct;
       }
        $this->data['isProduct_array'] = $isProduct_array;
    /*Get info for product block end*/
        $this->data['isProduct'] = $isProduct;
        if(isset($onlinequestioninfo)){
        $this->data['total_question'] = count($onlinequestioninfo);
        }else{
        $this->data['total_question'] = 0;
        }
		 $this->data['exam_id'] = $exam_id;
		$this->data['time_remaining'] = $time_remaining;
        $this->data['onlinetestinfo'] = $onlinetestinfo;
        $this->data['content'] = 'start_exam';
        $this->load->view('template', $this->data);
    }
	
	 public function all_result($username,$userid) {
        $customer_id = $this->session->userdata('customer_id');
		$this->data['username'] = $username;
        //$onlinetestinfo = $this->Onlinetest_model->detail($customer_id);
        //$onlinequestioninfo = $this->Onlinetest_model->getolQuestion($customer_id);
        $this->data['usertest_info'] = $this->Onlinetest_model->get_testinfo_by_customer($customer_id);
		
				
/*<!--All india/Group wise ranking-->*/
$userGroup=$this->Onlinetest_model->getUserGroup($customer_id);
$existInGroup=array();
$usersOfGroup=array();
if(isset($userGroup[0])&&count($userGroup[0])>0){  
	if(isset($userGroup[0]->groupid)&&$userGroup[0]->groupid>0){
		$groupid=$userGroup[0]->groupid;
	}else{
		$groupid=0;
	}
$usersOfGroup=$this->Onlinetest_model->getUsersOfGroup($groupid);
}
	$this->data['userGroup']=$userGroup;
	$this->data['usersOfGroup']=$usersOfGroup;	
/*<!--End All india/Group wise ranking-->*/
		
		
		
        $this->data['content'] = 'resultlist';
        $this->load->view('template', $this->data);
	 }
	 
	 
	 public function androidall_result($username,$userid) {
        $customer_id = $this->session->userdata('customer_id');
		$this->data['username'] = $username;
        //$onlinetestinfo = $this->Onlinetest_model->detail($customer_id);
        //$onlinequestioninfo = $this->Onlinetest_model->getolQuestion($customer_id);
        $this->data['usertest_info'] = $this->Onlinetest_model->get_testinfo_by_customer($customer_id);
		
				
/*<!--All india/Group wise ranking-->*/
$userGroup=$this->Onlinetest_model->getUserGroup($customer_id);
$existInGroup=array();
$usersOfGroup=array();
if(isset($userGroup[0])&&count($userGroup[0])>0){  
	if(isset($userGroup[0]->groupid)&&$userGroup[0]->groupid>0){
		$groupid=$userGroup[0]->groupid;
	}else{
		$groupid=0;
	}
$usersOfGroup=$this->Onlinetest_model->getUsersOfGroup($groupid);
}
	$this->data['userGroup']=$userGroup;
	$this->data['usersOfGroup']=$usersOfGroup;	
/*<!--End All india/Group wise ranking-->*/
		
		
		
        $this->data['content'] = 'app_resultlist';
        $this->load->view('template_mid', $this->data);
	 }
	 
public function androidstart_exam($examname, $subjectname, $chaptername, $testname, $appcid, $testid) {
$onlinetest_id=$testid;
$urlcust_array=explode('-encid-',$appcid);
			if(isset($urlcust_array[1])){
				$urlcustid=base64_decode($urlcust_array[1]);
			}else{
				$urlcustid=0;
			}
			 if (($urlcustid == '') || ($urlcustid < 1)) {
                redirect('apponline-test/androidusernotfound');
            }
        $this->data['examname'] = $examname;
        $this->data['subjectname'] = $subjectname;
        $this->data['chaptername'] = $chaptername;
        $this->data['testname'] = $testname;		
		//echo 'EXAM NAME->'.$examname.'<-->TESTNAME->'.$testname;
		$examname_replaced=str_replace("-"," ",$examname);
		
        $catid_byname=$this->Categories_model->getCategoriesbyname($examname_replaced);

		$catidbyname=$catid_byname[0]->id;
	    if(isset($catidbyname)&&$catidbyname>0){
		$exam_id = $catidbyname;
		}elseif(isset($onlinetestinfo->exam_id)&&$onlinetestinfo->exam_id>0){
        $exam_id = $onlinetestinfo->exam_id;
       }
				
        $this->data['appcid'] = $appcid;
		$this->data['onlinetest_id'] =$onlinetest_id;
        $this->data['customer_id'] = $urlcustid;
        $onlinetestinfo = $this->Onlinetest_model->detail_with_relation($testid);
        $onlinequestioninfo = $this->Onlinetest_model->getolQuestion($testid);
        $this->data['usertest_info'] = $this->Onlinetest_model->get_testinfo_by_customer($urlcustid);
		
    if(isset($onlinetestinfo->exam_id)){
      $exam_id = $onlinetestinfo->exam_id;
    }else{
      $exam_id=0;  
    }
	
    $isProduct = $this->Pricelist_model->getProduct($exam_id, '', '', 3);
       /*Get Info for produt block Start*/
       $isProduct_array=array();    
       if(count($isProduct)>0){
       $isProduct_array[]= $isProduct;
       }
        $this->data['isProduct_array'] = $isProduct_array;
    /*Get info for product block end*/
        $this->data['isProduct'] = $isProduct;
        if(isset($onlinequestioninfo)){
        $this->data['total_question'] = count($onlinequestioninfo);
        }else{
        $this->data['total_question'] = 0;
        }
        $this->data['onlinetestinfo'] = $onlinetestinfo;
        $this->data['content'] = 'app_start_exam';
        $this->load->view('template_mid', $this->data);
    }
	
	public function attempt_history($testid,$chart_type='bar') {
		
    $user_id = $this->session->userdata('customer_id');
	$usertest_info = $this->Onlinetest_model->get_testinfo_byid($testid);
	if(isset($usertest_info->test_id)&&$usertest_info->test_id>0){
     $onlinetest_id=$usertest_info->test_id;
     }
	$attempts_all=$this->Onlinetest_model->getAttempts($onlinetest_id,$user_id);
$atmpt=1;
$onlinetest_info=$this->Onlinetest_model->detail_with_relation($onlinetest_id);
$timeVar=$onlinetest_info->time;
$time = round($timeVar / 60, 1);
$formula_id=$onlinetest_info->formula_id; 
 $formula_array=$this->Onlinetest_model->formula_detail($formula_id);
 $instruction=$onlinetest_info->instructions;
 $name=$onlinetest_info->name;
$type=$onlinetest_info->type;
$exam_id=$onlinetest_info->exam_id;
$examInfo = $this->Examcategory_model->getExamCatgeoryById($exam_id);
$subject_id=$onlinetest_info->subject_id;   
$subjectsInfo=$this->Subjects_model->getSubject($subject_id);
$chapter_id=$onlinetest_info->chapter_id;
$chaptersInfo=$this->Chapters_model->getChapter($chapter_id);
$calculater=$onlinetest_info->calculater;
$total_qus=$usertest_info->total_qus;
foreach($attempts_all as $marksval ){
	$dataPoints[]= array("y" => $marksval->obtain_marks, "label" => $atmpt." Attempt");
	if($atmpt>11){
		break;
	}
	$atmpt++;	
}
$this->data['testid'] = $testid;
$this->data['name'] = $name;
$this->data['calculater'] = $calculater;
$this->data['chaptersInfo'] = $chaptersInfo;
$this->data['subjectsInfo'] = $subjectsInfo;
$this->data['examInfo'] = $examInfo[0];
$this->data['instruction'] = $instruction;
$this->data['usertest_info'] = $usertest_info;
$this->data['total_qus'] = $total_qus;
	$this->data['time'] = $time;
	$this->data['chart_type'] = $chart_type;
	if($chart_type=='bar'){
	$this->data['graphasset'] = 'bar_graph';
	}elseif($chart_type=='line'){
	$this->data['graphasset'] = 'line_graph';
	}else{
	$this->data['graphasset'] = 'bar_graph';
	}
	$this->data['formula_array'] = $formula_array;
	$this->data['dataPoints'] = $dataPoints;
	$this->data['content'] = 'attempt_history';
    $this->load->view('template_headeronly', $this->data);
	}
	 
	public function androidattempt_history($testid,$chart_type='bar') {
    $user_id = $this->session->userdata('customer_id');
	$usertest_info = $this->Onlinetest_model->get_testinfo_byid($testid);
	if(isset($usertest_info->test_id)&&$usertest_info->test_id>0){
     $onlinetest_id=$usertest_info->test_id;
     }
	$attempts_all=$this->Onlinetest_model->getAttempts($onlinetest_id,$user_id);
$atmpt=1;
$onlinetest_info=$this->Onlinetest_model->detail_with_relation($onlinetest_id);
$timeVar=$onlinetest_info->time;
$time = round($timeVar / 60, 1);
$formula_id=$onlinetest_info->formula_id; 
 $formula_array=$this->Onlinetest_model->formula_detail($formula_id);
 $instruction=$onlinetest_info->instructions;
 $name=$onlinetest_info->name;
$type=$onlinetest_info->type;
$exam_id=$onlinetest_info->exam_id;
$examInfo = $this->Examcategory_model->getExamCatgeoryById($exam_id);
$subject_id=$onlinetest_info->subject_id;   
$subjectsInfo=$this->Subjects_model->getSubject($subject_id);
$chapter_id=$onlinetest_info->chapter_id;
$chaptersInfo=$this->Chapters_model->getChapter($chapter_id);
$calculater=$onlinetest_info->calculater;
$total_qus=$usertest_info->total_qus;
foreach($attempts_all as $marksval ){
	$dataPoints[]= array("y" => $marksval->obtain_marks, "label" => $atmpt." Attempt");
	if($atmpt>11){
		break;
	}
	$atmpt++;	
}
$this->data['testid'] = $testid;
$this->data['name'] = $name;
$this->data['calculater'] = $calculater;
$this->data['chaptersInfo'] = $chaptersInfo;
$this->data['subjectsInfo'] = $subjectsInfo;
$this->data['examInfo'] = $examInfo[0];
$this->data['instruction'] = $instruction;
$this->data['usertest_info'] = $usertest_info;
$this->data['total_qus'] = $total_qus;
	$this->data['time'] = $time;
	$this->data['chart_type'] = $chart_type;
	if($chart_type=='bar'){
	$this->data['graphasset'] = 'bar_graph';
	}elseif($chart_type=='line'){
	$this->data['graphasset'] = 'line_graph';
	}else{
	$this->data['graphasset'] = 'bar_graph';
	}
	$this->data['formula_array'] = $formula_array;
	$this->data['dataPoints'] = $dataPoints;
	$this->data['content'] = 'app_attempt_history';
    $this->load->view('template_mid', $this->data);
	}
	
    public function androidotpdf($testid) {
	$this->data['content'] = 'app_filedownload';
    $this->load->view('template_mid', $this->data);	
	}
	 
	
    public function test_result($testid) {
        $this->load->model('Questions_model');
        $usertest_info = $this->Onlinetest_model->get_testinfo_byid($testid);
		$onlinetest_id=0;
		
$exam_id=0;
$subject_id=0;
$chapter_id=0;       
	   if(isset($usertest_info->test_id)&&$usertest_info->test_id>0){
            $onlinetest_id=$usertest_info->test_id;
        }
		
        if(isset($usertest_info->exam_id)&&$usertest_info->exam_id>0){
            $exam_id=$usertest_info->exam_id;
        }
		
        if(isset($usertest_info->subject_id)&&$usertest_info->subject_id>0){
            $subject_id=$usertest_info->subject_id;
        }
        if(isset($usertest_info->chapter_id)&&$usertest_info->chapter_id>0){
            $chapter_id=$usertest_info->chapter_id;
        }
		
        $onlinetest_info=$this->Onlinetest_model->detail_with_relation($onlinetest_id,$exam_id,$subject_id,$chapter_id);
		
		/*Get PDF file infornmation */
        $ot_filedetail = $this->File_model->detail($onlinetest_info->file_id);
        
        $user_id=$usertest_info->user_id; //
		
		$customer_info=$this->Customer_model->getCustomerDetails($user_id);
        if($this->session->userdata('customer_id') != $user_id){
            redirect('/customer');
        }
		$attempts=$this->Onlinetest_model->getAttempts($usertest_info->test_id,$user_id); 
		
        $sections=array();
        $this->data['attempts']=$attempts;  
        $this->data['ot_filedetail']=$ot_filedetail; 
        if (isset($usertest_info)) { 
		/*Get All questions from test id and user id 28-12-2019*/
			  $usertest_detail = $this->Onlinetest_model->get_testdetail_byid($testid);
			
			$mMarks=0;
			foreach($usertest_detail as $infoatt){
				$usertestid=$infoatt->usertestid;
				$question_id=$infoatt->question_id;
				if($usertestid>0&&$question_id>0){
				 $formulaChk=$this->Onlinetest_model->get_qusformula($usertestid,$question_id);
				}else{
					$formulaChk=array();
				}
				
				if(count($formulaChk)>0){ 
				$formulaArray=$formulaChk;
				}else{
					
					if(isset($onlinetest_info->formula_id)&&$onlinetest_info->formula_id>0){
				$formulaArray=$this->Onlinetest_model->formula_detail($onlinetest_info->formula_id);
				}else{
				$formulaArray=NULL;
					}				
				}
				
				if(isset($formulaArray->question_id)&&$formulaArray->question_id==$question_id){
					//Apply qus formula (formula attached for each question)
					if($infoatt->is_correct='1'){
						$mMarks+=$formulaArray->right_answer_marks;
					}elseif(($infoatt->is_correct='0')){
						if($formulaArray->calculator>0&&$formulaArray->type=='10'){
						//Do not apply minus marking
						}else{
						$mMarks-=$formulaArray->wrong_answer_marks;
						}
						}
					
				}else{
					//Apply paper formula
					if($infoatt->is_correct='1'){
						$mMarks+=$formulaArray->right_answer_marks;
					}elseif(($infoatt->is_correct='0')){
						$mMarks-=$formulaArray->wrong_answer_marks;
					}
				}
				$mMarks_array[]=$mMarks;
					}
			/*Get End*/
			//print_r($mMarks_array);
			//echo 'nn';
			//die;
            $onlinequestioninfo = $this->Onlinetest_model->getolQuestion($usertest_info->test_id);
			
        if(isset($onlinequestioninfo)){
            $this->data['totalquestions']=count($onlinequestioninfo);
        }else{
            $this->data['totalquestions']=0;
        }
            $total_qus_cnt = 0;
            $attempted_qus_cnt = 0;
            $correct_question = 0;
            $qcount=0;
			
			$singlch_correct=1;
			$singlch_incorrect=1;
			
			$multich_correct=1;
			$multich_incorrect=1;
			
			$mtc_correct=1;
			$mtc_incorrect=1;
			
			$fitb_correct=1;
			$fitb_incorrect=1;
			
            //foreach ($usertest_detail as $usertest_val) {
						//print_r($onlinequestioninfo);
            foreach ($onlinequestioninfo as $usertest_val) {
				
                $useranswer_data=$this->Onlinetest_model->getUserAnswerData($testid,$usertest_val->question_id); 
				$answers=$this->Questions_model->answers($usertest_val->question_id);
                $quesdetails=(array)$usertest_val;
                $quesdetails['timetaken']=0;
                $quesdetails['answered_correctly']=0;
                $quesdetails['answers']=$answers;
                if(array_key_exists($usertest_val->section_name, $sections)){
                    $sections[$usertest_val->section_name]['questions'][$qcount]=$quesdetails;       
                }else{
                    $sections[$usertest_val->section_name]['questions'][$qcount]=$quesdetails;
                    $sections[$usertest_val->section_name]['timetaken']=0;
                    $sections[$usertest_val->section_name]['attempted']=0;
                    $sections[$usertest_val->section_name]['not_attempted']=0;
                    $sections[$usertest_val->section_name]['correct']=0;
                    $sections[$usertest_val->section_name]['incorrect']=0;
                }
				//set value for user answer if nothing is found it will be 0 wrong/right or mark to review
	            if($useranswer_data && $useranswer_data->users_answer != ''&&$useranswer_data->is_correct!=2) {
                   
                    $attempted_qus_cnt++;
					
                    $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=0;
                    //$sections[$usertest_val->section_name]['attempted']=$sections[$usertest_val->section_name]['attempted']+1;
                }else{ //$sections[$usertest_val->section_name]['not_attempted']=$sections[$usertest_val->section_name]['not_attempted']+1;
                    $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=2;
                }
				if(isset($useranswer_data)&&$useranswer_data->users_answer!=''){
                    $timetaken=$useranswer_data->perclick_time_spent;
                    
                    sscanf($timetaken, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $sections[$usertest_val->section_name]['timetaken']= $sections[$usertest_val->section_name]['timetaken']+$time_seconds;
                $var_single_choice = $this->config->item('var_single_choice');
                $var_grid_single_choice = $this->config->item('var_grid_single_choice');
                $var_multiple_choice = $this->config->item('var_multiple_choice');
				$var_grid_multiple_choice = $this->config->item('var_grid_multiple_choice');
                $var_fill_in_the_blanks = $this->config->item('var_fill_in_the_blanks');
                $var_match_the_column = $this->config->item('var_match_the_column');
                //CHECK For radeo button single choice 
				if(($usertest_val->type ==$var_single_choice)||($usertest_val->type == $var_grid_single_choice)) {
                   
                    if ( (trim($useranswer_data->users_answer) == trim($useranswer_data->correct_answer)) && ($useranswer_data->users_answer != '') && ($useranswer_data->correct_answer != '')) {
                        $correct_question++;	
                        $sections[$usertest_val->section_name]['correct']=$sections[$usertest_val->section_name]['correct']+1;
						
						/*$sections[$usertest_val->section_name]['correct']=$singlch_correct;
                        */
						$sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
						$singlch_correct++;
					
					}else{
						/*	$sections[$usertest_val->section_name]['incorrect']+1;
						*/
					
						$flagCrctAns=0;
						if($useranswer_data->users_answer==2){
							//ans is mark to review
						$flagCrctAns=2;	
						}else{
							
						$sections[$usertest_val->section_name]['incorrect']=$sections[$usertest_val->section_name]['incorrect']+1;
							//ans is wrong
							$flagCrctAns=0;
						}
						
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=$flagCrctAns;
						$singlch_incorrect++;
                    }
					
                    $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                      $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                      $a_opt='A';
                      $user_ans_array=array();
                      foreach($answers as $ans){
                          $userans_id=trim($useranswer_data->users_answer);
						  if($useranswer_data->question_type=='Single Choice'){ if($ans->id==$userans_id){
                    $user_answers_array=$this->Questions_model->answers_byid($userans_id);
					
                    $user_ans_array[$a_opt] = $user_answers_array[0]->answer ;  
                       }else{
					$user_ans_array[$a_opt] = '';
}  
						} 
                      $a_opt++;     
                      }
                      
                      $sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;   
                }
				
				
				     //CHECK For radeo button Grid single choice 
				if($usertest_val->type == $var_grid_single_choice) {
					
					
                    if ( (trim($useranswer_data->users_answer) == trim($useranswer_data->correct_answer)) && ($useranswer_data->users_answer != '') && ($useranswer_data->correct_answer != '')) {
                        $correct_question++;	
                        /*$sections[$usertest_val->section_name]['correct']+1;
						*/
						$sections[$usertest_val->section_name]['correct']=$singlch_correct;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
						$singlch_correct++;
					
					}else{
						/*	$sections[$usertest_val->section_name]['incorrect']+1;
						*/
						$sections[$usertest_val->section_name]['incorrect']=$singlch_incorrect;
						$flagCrctAns=0;
						if($useranswer_data->users_answer==2){
							//ans is mark to review
						$flagCrctAns=2;	
						}else{
							//ans is wrong
							$flagCrctAns=0;
						}
						
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=$flagCrctAns;
						$singlch_incorrect++;
                    }
					
                    $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                      $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                      $a_opt='A';
                      $user_ans_array=array();
					
					
					
					 
						  /*For Grid Single choice*/
						  if($useranswer_data->question_type=='Grid Single Choice'){ if($ans->id==$userans_id){
                    $user_answers_array=$this->Questions_model->answers_byid($userans_id);
					
                    $user_ans_array[$a_opt] = $user_answers_array[0]->answer ;  
                       }else{
					$user_ans_array[$a_opt] = '';
//work remaining							 
							  
						  }  
						}
					
					    $sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;  
				}
				
                //CHECK For checkbox Multiple choice
                if (($usertest_val->type == $var_multiple_choice)) {
                    /*Check use of unserialize-
					$users_answer_clean_array = unserialize($useranswer_data->users_answer);
					*/
                    $users_answer_clean_array = $useranswer_data->users_answer;
                    if(isset($users_answer_clean_array)&&count($users_answer_clean_array)>0){
                        $users_answer_array=$users_answer_clean_array;
                    }else{
                        $users_answer_array=array();
                    }
                    
					/*Check use of unserialize-
					$correct_answer_array = unserialize($useranswer_data->correct_answer);
					*/
					$correct_answer_array = $useranswer_data->correct_answer;
                    if (is_array($users_answer_array)) {
                        $users_answer_comma_separated = implode("|", $users_answer_array);
                    } else {
                        $users_answer_comma_separated = $users_answer_array;
                    }
                    if (is_array($correct_answer_array)) {
                        $correct_answer_comma_separated = implode("|", $correct_answer_array);
                    } else {
                        $correct_answer_comma_separated = $correct_answer_array;
                    }
                    if ((trim($users_answer_comma_separated) == trim($correct_answer_comma_separated)) && ($users_answer_comma_separated != '') && ($correct_answer_comma_separated != '')) {
                        $correct_question++;
                        $sections[$usertest_val->section_name]['correct']=$multich_correct;/*$sections[$usertest_val->section_name]['correct']+1;*/
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
						$multich_correct++;
                    }else{
                        $sections[$usertest_val->section_name]['incorrect']=$multich_incorrect;/*$sections[$usertest_val->section_name]['incorrect']+1;*/
						
						$flagCrctAns=0;
						if($useranswer_data->users_answer==2){
							//ans is mark to review
						$flagCrctAns=2;	
						}else{
							//ans is wrong
							$flagCrctAns=0;
						}
						$sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=$flagCrctAns;
						$multich_incorrect++;
                    }
                    $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                     $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                      $a_opt='A';
                      $user_ans_array=array();
					  if(!is_array($users_answer_array)){
						  $users_answer_array=array();
					  }
					  
                      foreach($answers as $ans){     
                    if( in_array($ans->id, $users_answer_array)){
                    $userans_id=$ans->id;    
                    $user_answers_array=$this->Questions_model->answers_byid($userans_id);
                    $user_ans_array[$a_opt] = $user_answers_array[0]->answer ;
                    //$user_ans_array[$a_opt] = '' ;
                         }
                      $a_opt++;     
                      }                      
                      
                    $sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;
                }
				
				 if (($usertest_val->type ==$var_grid_multiple_choice)) {
					 /*Work remaining*/
					 
				 }
				
				/*For Grid Multiple choice*/

                //CHECK For Fill in the blanks
                if ($usertest_val->type == $var_fill_in_the_blanks) {
                    if ((trim($useranswer_data->users_answer) == trim($useranswer_data->correct_answer)) && ($useranswer_data->users_answer != '') && ($useranswer_data->correct_answer != '')) {
                        $correct_question++;
                        $sections[$usertest_val->section_name]['correct']=$fitb_correct;	/*$sections[$usertest_val->section_name]['correct']+1;*/						
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
						$fitb_correct++;
                    }else{
                        $sections[$usertest_val->section_name]['incorrect']=$fitb_incorrect; 
						/*$sections[$usertest_val->section_name]['incorrect']+1;*/
						
						$flagCrctAns=0;
						if($useranswer_data->users_answer==2){
							//ans is mark to review
						$flagCrctAns=2;	
						}else{
							//ans is wrong
							$flagCrctAns=0;
						}
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=$flagCrctAns;
						$fitb_incorrect++;
                    }
                     $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                       $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                      
                      $a_opt='A';
                      $user_ans_array=array();                      
                      foreach($answers as $ans){
                          $userans_id=trim($useranswer_data->users_answer);
                           $test_answer=trim($ans->answer);
                    $user_ans_array[$a_opt] = $userans_id ;                     
                           $a_opt++;     
                      }
                      $sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;   
                }
				
                //CHECK For Match The Column
                if ($usertest_val->type == $var_match_the_column) {
                    $flag_diff = 'no';$users_answer_array = unserialize($useranswer_data->users_answer);
                    $correct_answer_array = unserialize($useranswer_data->correct_answer);
                    if(isset($correct_answer_array)){
                    $correct_answer_count = count($correct_answer_array);
                    }else{
                      $correct_answer_count=0;  
                    }
                    for ($in = 0; $correct_answer_count > $in; $in++) {
                        $count_user_inner = 0;
                        $count_correct_inner = 0;
                        if (isset($correct_answer_array[$in])) {
                            $count_correct_inner = count($correct_answer_array[$in]);
                        }
                        if (isset($users_answer_array[$in])) {
                            $count_user_inner = count($users_answer_array[$in]);
                        }
                        if ($count_correct_inner == $count_user_inner) {
                            /* $result_diffrence = array_diff($correct_answer_array[$in], $users_answer_array[$in]);
                             * */
                            if(is_array($correct_answer_array[$in])){
                            $implode_correct = implode('|', $correct_answer_array[$in]);
                            }else{
                            $implode_correct = $correct_answer_array[$in];
                            }
                            if(is_array($users_answer_array[$in])){
                            $implode_user = implode('|', $users_answer_array[$in]);
                            }else{
                            $implode_user = $users_answer_array[$in];
                            }
                            if (trim($implode_correct) == trim($implode_user)) {
                                $result_diffrence = 0;
                            } else {
                                $result_diffrence = 1;
                            }
                        } else {
                            $result_diffrence = 1;
                        }
                        if ($result_diffrence > 0) {
                            $flag_diff = 'yes';
                        }
                    }
                
                    if ($flag_diff == 'no') {
                        $correct_question++;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
                        $sections[$usertest_val->section_name]['correct']=$mtc_correct;/*$sections[$usertest_val->section_name]['correct']+1;*/
						$mtc_correct++;
                    }else{
                        $sections[$usertest_val->section_name]['incorrect']=$mtc_incorrect;/*$sections[$usertest_val->section_name]['incorrect']+1;*/
						
						
						$flagCrctAns=0;
						if($useranswer_data->users_answer==2){
							//ans is mark to review
						$flagCrctAns=2;	
						}else{
							//ans is wrong
							$flagCrctAns=0;
						}
						
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=$flagCrctAns;
						$mtc_incorrect++;
                    }
                    
                    if(is_array($correct_answer_array)){
                        $implode_user_var=$correct_answer_array;
                    }else{
                        $implode_user_var=array();
                    }
                    
                    $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                       $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                       
                       $a_opt='A';
                      $user_ans_array=array();
                      $imp=0;
                      foreach($answers as $ans){     
                   //$implode_user_var
                   //$userans_id=$ans->id;    
                   //$user_answers_array=$this->Questions_model->answers_byid($userans_id);
                    if(isset($implode_user_var[$imp])){
                        $cheked_option=$implode_user_var[$imp];
                    }else{
                        
                        $cheked_option='';
                    }
                          
                    $user_ans_array[$a_opt] = $ans->answer.' -> '.$cheked_option ;
                    
                      $a_opt++;  
                      $imp++;
                      }                      
                      
                    $sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;
                    
                }
				
                }else{
                    $sections[$usertest_val->section_name]['not_attempted']=$sections[$usertest_val->section_name]['not_attempted']+1;
                }
                $total_qus_cnt++;
                $qcount++;
            }

            $exam_formula = $usertest_info->formula_id;
            $right_answer_marks = $usertest_info->right_answer_marks;
            $wrong_answer_marks = $usertest_info->wrong_answer_marks;
            $question_markedfor_review = $total_qus_cnt - $attempted_qus_cnt;
            $not_attampted_qus = $usertest_info->total_qus - ($attempted_qus_cnt);
            $total_marks = $usertest_info->total_qus * $right_answer_marks;
            $wrong_question = ($total_qus_cnt - $question_markedfor_review) - $correct_question;
            $final_result = ($right_answer_marks * $correct_question) - ($wrong_answer_marks * $wrong_question);

            }
            if(isset($onlinetest_info->exam_id)){
                $exam_id=$onlinetest_info->exam_id;
            }else{
                $exam_id=0;
            }	
        if($exam_id>0){
       $isProduct = $this->Pricelist_model->getProduct($exam_id, 0, 0, 1);
	   /*Get Info for produt block Start*/
       $isProduct_array=array(); 
       $products_id=0;
       if(isset($isProduct)){
       if(count($isProduct)>0){
       $isProduct_array[]= $isProduct;
	   if(isset($isProduct->id)){
       $products_id=$isProduct->id;
       }
       }
	   }else{  
        $isProduct = $this->Pricelist_model->getProduct($exam_id, 0, 0, 3);
	   if(isset($isProduct)){
       if(count($isProduct)>0){
       $isProduct_array[]= $isProduct;
	   if(isset($isProduct->id)){
        $products_id_two=$isProduct->id;
       }
       }
	   }else{ 
	   $isProduct_array[]=NULL;   
	   }
       }
	   }else{
		$isProduct=array();	
		} 
	   
	   /*Get Info for produt block Start*/
       $isProduct_array=array(); 
       if(isset($isProduct)){
       if(count($isProduct)>0){
       $isProduct_array[]= $isProduct;
                    }
					}else{
                     $isProduct_array[]=NULL;   
                    }
       $examname=$onlinetest_info->name;
       if(isset($isProduct->modules_item_name)){
       $examname=$isProduct->modules_item_name;
       }
	
/*<!--All india/Group wise ranking-->*/
$userGroup=$this->Onlinetest_model->getUserGroup($user_id);


$existInGroup=array();
$usersOfGroup=array();
if(isset($userGroup[0])&&count($userGroup[0])>0){  
	if(isset($userGroup[0]->groupid)&&$userGroup[0]->groupid>0){
		$groupid=$userGroup[0]->groupid;
	}else{
		$groupid=0;
	}
	
$usersOfGroup=$this->Onlinetest_model->getUsersOfGroup($groupid);
//echo $userGroup[0]->groupid;	
foreach($usersOfGroup as $groupvalue){ 
	$groupUserId=$groupvalue->userid;
	if(isset($groupUserId)&&$groupUserId>0){ 
	$resultOfGroup=$this->Onlinetest_model->getGroupAttempts($onlinetest_id,$groupUserId);
	$totalInGroup[]=$resultOfGroup;
	}else{
	$totalInGroup=array();
	}
}
foreach($totalInGroup as $grpKey=>$grpValue){
							if(count($grpValue)>0){	
							$grpValueObj=$grpValue;
								if(isset($grpValueObj->lastname)){
								$fullname=$grpValueObj->firstname.' '.$grpValueObj->lastname;
								}else{
								$fullname=$grpValueObj->firstname;
								}
								$existInGroup[]=array('user_id'=>$grpValueObj->user_id,'fullname'=>$fullname,'obtain_marks'=>$grpValueObj->obtain_marks,
								'total_marks'=>$grpValueObj->total_marks,
								'time_taken'=>$grpValueObj->time_taken,
								'time_remaining'=>$grpValueObj->time_remaining,
								'formula_id'=>$grpValueObj->formula_id,
								'right_answer_marks'=>$grpValueObj->right_answer_marks,
								'wrong_answer_marks'=>$grpValueObj->wrong_answer_marks,
								'reviewed_qus'=>$grpValueObj->reviewed_qus,
								'attampted_ques'=>$grpValueObj->attampted_ques,
								'not_attampted_qus'=>$grpValueObj->not_attampted_qus,
								'total_qus'=>$grpValueObj->total_qus,
								'total_time'=>$grpValueObj->total_time,
								'correct_ans'=>$grpValueObj->correct_ans,
								'incorrect_ans'=>$grpValueObj->incorrect_ans,
								'dt_created'=>$grpValueObj->dt_created,
								'start_time'=>$grpValueObj->start_time,
								'end_time'=>$grpValueObj->end_time);

}
}
sortBy('obtain_marks',$existInGroup,'desc');
}
/*Start Test info for retest*/
$examInfo = $this->Examcategory_model->getExamCatgeoryById($exam_id);
$subject_id=$onlinetest_info->subject_id;   
$subjectsInfo=$this->Subjects_model->getSubject($subject_id);
$chapter_id=$onlinetest_info->chapter_id;
$chaptersInfo=$this->Chapters_model->getChapter($chapter_id);

$this->data['chaptersInfo'] = $chaptersInfo;
$this->data['subjectsInfo'] = $subjectsInfo;
$this->data['examInfo'] = $examInfo[0];
/*Ends Test info for retest*/
$cust = $this->session->userdata('customer_id');
$products=$this->Customer_model->getCustomerProucts($cust);
	if($products){
    foreach($products as $key=>$product){
    $subject_id=0;
    $exam_id=0;
    if(isset($product->exam_id)){
    $exam_id=$product->exam_id;
    }
$get_allproduct=$this->Pricelist_model->checkExamProduct_All($exam_id,'ALL');
$allp1=$get_allproduct[0];
$allp2=$get_allproduct[1];
$allp3=$get_allproduct[2];
$purchased[$allp1->type][]=$allp1->id;
$purchased[$allp2->type][]=$allp2->id;
$purchased[$allp2->type][]=$allp3->id; 
                }
               }
	    $this->data['purchased']=$purchased; 
	    $this->data['testid']=$testid;
        $this->data['isProduct_array'] = $isProduct_array;$this->data['exam_id'] = $exam_id; 
		$this->data['customer_info'] = $customer_info;$this->data['examname'] = $examname;       
        $this->data['isProduct']=$isProduct;
        $this->data['onlinetest_info']=$onlinetest_info;
        $this->data['usertest_result_info'] = $usertest_info;
        $this->data['sections'] = $sections;
        $this->data['loadMathJax']='yes';
        $this->data['existInGroup'] = $existInGroup;
		$this->data['usersOfGroup'] = $usersOfGroup;
		$this->data['content'] = 'test_result';
        $this->load->view('template', $this->data);
    }
    
    public function question_detail($testid,$question_id){
        $this->data['content'] = 'question_detail';
        $this->data['loadMathJax']='yes';
        $this->load->view('template', $this->data);
        
    }

}
