<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends Modulecontroller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Solvedpapers_model');
        $this->load->model('Chapters_model');
    }
    public function index($examname=null,$exam_id=0,$subjectname=null,$subject_id=0,$chapter_name=null,$chapter_id=0){
        $order_by=null;
        $examdata=array();
        if($examname==null){
            $title=getTitle('Solved Papers',$this->data['examcategories']);
            
            $titleStr[]=$title;
        }else{
            $titleStr[]='Solved Papers for';
        }
        if($exam_id > 0){
            $exam=  $this->Categories_model->getCategoryDetails($exam_id);
            $this->data['selectedexam']=$exam;
            $titleStr[]=addSuffix($exam->name,'Class');
        }
        if($subject_id > 0){
            $this->load->model('Subjects_model');
            $this->data['selectedsubject']=$this->Subjects_model->getSubject($subject_id);
            $titleStr[]=$this->data['selectedsubject']->name;
        }
        if($chapter_id > 0){
            
            $this->data['selectedchapter']=$this->Chapters_model->getChapter($chapter_id);
            $titleStr[]=$this->data['selectedchapter']->name;
        }
        if($exam_id){
            $order_by='years';
            $data_array=array();
            $chaptersubjects=  $this->Examcategory_model->getExamChapters($exam_id);
            $subjects_array = array();
            $chapters_array = array();
            if(count($chaptersubjects) > 0){
                foreach($chaptersubjects as $record){
                    if (!in_array($record->sname, $subjects_array)) {
                        $subjects_array[$record->sid] = array('name' => $record->sname);
                    }
                    if ($subject_id > 0 && $subject_id == $record->sid) {
                        $videos = $this->Solvedpapers_model->getSolvedPapersCount($exam_id, $record->sid, $record->cid);
                        if (!in_array($record->cname, $chapters_array)) {

                            $chapters_array[$record->cid] = array('name' => $record->cname, 'count' => count($videos));
                        } else {
                            $chapters_array[$record->cid]['count'] = count($videos);
                        }
                    }
                    if(array_key_exists($record->sname, $data_array)){
                        //$data_array[$record->name][]
                        array_push($data_array[$record->sname]['chapters'],array($record->cid,$record->cname));
                    }else{
                        $data_array[$record->sname]['id']=$record->sid;
                        if(isset($data_array[$record->sname]['chapters'])){
                            array_push($data_array[$record->sname]['chapters'],array($record->cid,$record->cname));
                        }else{
                            $data_array[$record->sname]['chapters'][0]=array($record->cid,$record->cname);
                        }
                    }
                }
            }
        $this->data['subject_chapters']=$data_array;
        $hasvideosinsubjects=0;
        if (count($subjects_array) > 0) {
                foreach ($subjects_array as $key => $value) {
                    
                    $solvedpapers = $this->Solvedpapers_model->getSolvedPapersCount($exam_id, $key, 0);
                    $hasvideosinsubjects+=count($solvedpapers);
                    $subjects_array[$key]['count'] = count($solvedpapers);
                }
            }
            $this->data['subjects_array'] = $subjects_array;

            $this->data['chapters_array'] = $chapters_array;
            $this->data['borwsebysubjects']=$hasvideosinsubjects;
        }
        $solvedpapers=$this->Solvedpapers_model->getSolvedPapers($exam_id,$subject_id,$chapter_id,$order_by);
        $this->data['solvedpapers']=$solvedpapers;
        //$questions=$this->Solvedpapers_model->getQuestionCount($exam_id,$subject_id,$chapter_id);
        $this->data['title']= implode(' ',$titleStr);
        $this->data['h1title']= implode(' ',$titleStr);
        //$this->data['questions']=$questions;
        $this->data['exam_id']=$exam_id;
        $this->data['subject_id']=$subject_id;
        $this->data['chapter_id']=$chapter_id;
        $this->data['examdata']=$examdata;
        $this->data['content']='welcome';
        $data=$this->Solvedpapers_model->getSolvedpapersList($exam_id,$subject_id);
       
        $solutions_array=array();
        foreach($data as $result){
           
            if(!array_key_exists($result->exam_id, $solutions_array)){
                $solutions_array[$result->exam_id]=array('name'=>$result->exam,'subjects'=>array());
            }
            if(!array_key_exists($result->subject_id, $solutions_array[$result->exam_id]['subjects']) && $result->subject_id > 0){
                $solutions_array[$result->exam_id]['subjects'][$result->subject_id]=array('id'=>$result->subject_id,'name'=>$result->subject);
            }
        }
        $this->data['solutions_array']=$solutions_array;
	$this->load->view('template',$this->data);
        
    }
    public function details($spname,$spid){
        $segments = $this->uri->total_segments();
        //Start Get StudyPackageDetail
        $this->load->model('Mergesection_model');
        $relatedfiles=$this->Mergesection_model->getRelatedModule($spid,10,1);
        if(count($relatedfiles) == 1){
            $this->load->model('Studymaterial_model');
            $file_price_info = $this->Studymaterial_model->getinfo_formerge($relatedfiles[0]->related_module_id);
             if($relatedfiles[0]->related_file_id > 0){
                $this->load->model('File_model');
                $details=$this->File_model->getStudyPackageDetails($relatedfiles[0]->related_file_id);
                $isProduct = $this->Pricelist_model->getItemPrice($relatedfiles[0]->related_file_id,1);
             if(isset($details->subject)){
				  $solved_subjectInfo=$details->subject;
			  }else{
			  $solved_subjectInfo='all';
			  }
			  
			  if(isset($details->chapter)){
			  $solved_chapteInfo=$details->chapter;
			  }else{
			  $solved_chapteInfo='all';
			  }
                $url=  generateContentLink('study-packages', $details->exam, $solved_subjectInfo, $solved_chapteInfo, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
                $this->data['file']=$details;
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
                $this->data['isProduct']=$isProduct;
            }else{

				if(isset($relation[0]->subject)){
				  $solved_subjectInfo=$relation[0]->subject;
			  }else{
			  $solved_subjectInfo='all';
			  }
			  
			  if(isset($relation[0]->chapter)){
				  $solved_chapteInfo=$relation[0]->chapter;
			  }else{
			  $solved_chapteInfo='all';
			  }
                $details=$this->Studymaterial_model->detail($relatedfiles[0]->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($relatedfiles[0]->related_module_id);                                 
                $url=  generateContentLink('study-packages', $relation[0]->exam, $solved_subjectInfo, $solved_chapteInfo, $details->name, $details->id);
               
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            
            $this->data['file_price_info']=$file_price_info[0];
            /*Get flax paper details*/
            $this->data['linktostudypackage']=$url;
        }
        //End Get StudyPackage Detail
        
        //update View Count
        $this->Pricelist_model->update_viewcount($spid,'cmssolvedpapers');
        $section=null;
        $section_by_segment=null;
        $chapter_id=null;
        if($segments == 4){ // Vieweing From exam
            
        }
        
        if(($segments == 6)||($segments == 5)){ // Vieweing From Chapter
			 $section_by_segment=$this->uri->segment(3);
            if($section_by_segment=='physics'){ $section='A';}
            if($section_by_segment=='chemistry'){ $section='B';}
            if($section_by_segment=='mathematics'){ $section='C';}
            $chapter_name=  $this->uri->segment(4);
            $chapter=$this->Chapters_model->getChapterBySlug($chapter_name);
            $chapter_id=$chapter->id;
        }
        $this->load->model('Questions_model');
        $spdetails=$this->Solvedpapers_model->detail($spid);
        $relation=$this->Solvedpapers_model->getRelations($spid);
        $section_by_segment=str_replace("-"," ",$section_by_segment);
        $questions_result=$this->Solvedpapers_model->getQuestions_new($spid,$section_by_segment,$chapter_id);
        if(count($questions_result)>0){
		$questions=$questions_result;
		}else{
		$questions=$this->Solvedpapers_model->getQuestions_new($spid,$section_by_segment,'');
        }
        // This can be replaced with chapters when viewing paper from subjects link
        $sections=$this->Solvedpapers_model->getSectionsForQue_new($spid,$section_by_segment,$chapter_id); 
        $this->data['sections']=$sections;
        $this->data['relation']=$relation[0];
        $questiontypes=  $this->Solvedpapers_model->questionTypes($spid);
        $title=generateTitle('Solved papers for',$relation[0],$spdetails->name);
        $this->data['title']=$title;
        $this->data['h1title']=$title;
        $this->data['spdetails']=$spdetails;
        $this->data['questiontypes']=$questiontypes;
        $this->data['questions']=$questions;

        $this->data['content']='questions';
        $this->data['loadMathJax']='YES';
	$this->load->view('template',$this->data);
    }
    
    
    public function androiddetails($spname,$spid){
        $segments = $this->uri->total_segments();
        //Start Get StudyPackageDetail
        $this->load->model('Mergesection_model');
        $relatedfiles=$this->Mergesection_model->getRelatedModule($spid,10,1);
        if(count($relatedfiles) == 1){
            $this->load->model('Studymaterial_model');
            $file_price_info = $this->Studymaterial_model->getinfo_formerge($relatedfiles[0]->related_module_id);
            
             if($relatedfiles[0]->related_file_id > 0){
                $this->load->model('File_model');
                $details=$this->File_model->getStudyPackageDetails($relatedfiles[0]->related_file_id);
                $isProduct = $this->Pricelist_model->getItemPrice($relatedfiles[0]->related_file_id,1);
              if(isset($details->subject)){
				  $solved_subjectInfo=$details->subject;
			  }else{
			  $solved_subjectInfo='all';
			  }
			  
			  if(isset($details->chapter)){
				  $solved_chapteInfo=$details->chapter;
			  }else{
			  $solved_chapteInfo='all';
			  }
                $url=  generateContentLink('study-packages', $details->exam, $solved_subjectInfo, $solved_chapteInfo, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
                $this->data['file']=$details;
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
                $this->data['isProduct']=$isProduct;
            }else{
				if(isset($relation[0]->subject)){
				  $solved_subjectInfo=$relation[0]->subject;
			  }else{
			  $solved_subjectInfo='all';
			  }
			  
			  if(isset($relation[0]->chapter)){
				  $solved_chapteInfo=$relation[0]->chapter;
			  }else{
			  $solved_chapteInfo='all';
			  }
                $details=$this->Studymaterial_model->detail($relatedfiles[0]->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($relatedfiles[0]->related_module_id);                                 
                $url=  generateContentLink('study-packages', $relation[0]->exam, $solved_subjectInfo, $solved_chapteInfo, $details->name, $details->id);
               
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            
            $this->data['file_price_info']=$file_price_info[0];
            /*Get flax paper details*/
            $this->data['linktostudypackage']=$url;
        }
        //End Get StudyPackage Detail
        
        //update View Count
        $this->Pricelist_model->update_viewcount($spid,'cmssolvedpapers');
        $section=null;
        $chapter_id=null;
        if($segments == 4){ // Vieweing From exam
            
        }
        if($segments == 5){ // Vieweing From subjects
            $section=$this->uri->segment(3);
            if($section=='physics'){ $section='A';}
            if($section=='chemistry'){ $section='B';}
            if($section=='mathematics'){ $section='C';}
        }
        if($segments == 6){ // Vieweing From Chapter
            $chapter_name=  $this->uri->segment(4);
            $chapter=$this->Chapters_model->getChapterBySlug($chapter_name);
            
            $chapter_id=$chapter->id;
        }
        $this->load->model('Questions_model');
        $spdetails=$this->Solvedpapers_model->detail($spid);
        $relation=$this->Solvedpapers_model->getRelations($spid);
        
        $questions=$this->Solvedpapers_model->getQuestions($spid,$section,$chapter_id);
        // This can be replaced with chapters when viewing paper from subjects link
        $sections=$this->Solvedpapers_model->getSectionsForQuestions($spid,$section,$chapter_id); 
        $this->data['class_id']=$details->exam;
        $this->data['sections']=$sections;
        $this->data['relation']=$relation[0];
        $questiontypes=  $this->Solvedpapers_model->questionTypes($spid);
        $title=generateTitle('Solved papers for',$relation[0],$spdetails->name);
        $this->data['title']=$title;
        $this->data['h1title']=$title;
        $this->data['spdetails']=$spdetails;
        $this->data['questiontypes']=$questiontypes;
        $this->data['questions']=$questions;
        $this->data['content']='appquestions';
        $this->data['loadMathJax']='YES';
	$this->load->view('template_mid',$this->data);
    }
    
        public function printdetails($spname,$spid){
        $file_key =  decrypt($spid);
        $qbid_array = explode('_st@ad_',$file_key);
        $spid=$qbid_array[0];
        $segments = $this->uri->total_segments();
        //Start Get StudyPackageDetail
        $this->load->model('Mergesection_model');
        $relatedfiles=$this->Mergesection_model->getRelatedModule($spid,10,1);
        if(count($relatedfiles) == 1){
            $this->load->model('Studymaterial_model');
            $file_price_info = $this->Studymaterial_model->getinfo_formerge($relatedfiles[0]->related_module_id);            
             if($relatedfiles[0]->related_file_id > 0){
                $this->load->model('File_model');
                $details=$this->File_model->getStudyPackageDetails($relatedfiles[0]->related_file_id);
                $isProduct = $this->Pricelist_model->getItemPrice($relatedfiles[0]->related_file_id,1);
              
			  
				if(isset($details->subject)){
				  $solved_subjectInfo=$details->subject;
			  }else{
			  $solved_subjectInfo='all';
			  }
			  
			  if(isset($details->chapter)){
			  $solved_chapteInfo=$details->chapter;
			  }else{
			  $solved_chapteInfo='all';
			  }


                $url=  generateContentLink('study-packages', $details->exam, $solved_subjectInfo, $solved_chapteInfo, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
                $this->data['file']=$details;
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
                $this->data['isProduct']=$isProduct;
            }else{

				if(isset($relation[0]->subject)){
				  $solved_subjectInfo=$relation[0]->subject;
			  }else{
			  $solved_subjectInfo='all';
			  }
			  
			  if(isset($relation[0]->chapter)){
			  $solved_chapteInfo=$relation[0]->chapter;
			  }else{
			  $solved_chapteInfo='all';
			  }

                $details=$this->Studymaterial_model->detail($relatedfiles[0]->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($relatedfiles[0]->related_module_id);                                 
                $url=  generateContentLink('study-packages', $relation[0]->exam, $solved_subjectInfo, $solved_chapteInfo, $details->name, $details->id);
               
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            
            $this->data['file_price_info']=$file_price_info[0];
            /*Get flax paper details*/
            $this->data['linktostudypackage']=$url;
        }
        //End Get StudyPackage Detail
        
        //update View Count
        $this->Pricelist_model->update_viewcount($spid,'cmssolvedpapers');
        $section=null;
        $chapter_id=null;
        if($segments == 4){ // Vieweing From exam
            
        }
        if($segments == 5){ // Vieweing From subjects
            $section=$this->uri->segment(3);
            if($section=='physics'){ $section='A';}
            if($section=='chemistry'){ $section='B';}
            if($section=='mathematics'){ $section='C';}
        }
        if($segments == 6){ // Vieweing From Chapter
            $chapter_name=  $this->uri->segment(4);
            $chapter=$this->Chapters_model->getChapterBySlug($chapter_name);
            
            $chapter_id=$chapter->id;
        }
        $this->load->model('Questions_model');
        $spdetails=$this->Solvedpapers_model->detail($spid);
        $relation=$this->Solvedpapers_model->getRelations($spid);
        
        $questions=$this->Solvedpapers_model->getQuestions($spid,$section,$chapter_id);
        // This can be replaced with chapters when viewing paper from subjects link
        $sections=$this->Solvedpapers_model->getSectionsForQuestions($spid,$section,$chapter_id); 
        $this->data['class_id']=$details->exam;
        $this->data['sections']=$sections;
        $this->data['relation']=$relation[0];
        $questiontypes=  $this->Solvedpapers_model->questionTypes($spid);
        $title=generateTitle('Solved papers for',$relation[0],$spdetails->name);
        $this->data['title']=$title;
        $this->data['h1title']=$title;
        $this->data['spdetails']=$spdetails;
        $this->data['questiontypes']=$questiontypes;
        $this->data['questions']=$questions;
        $this->data['content']='pdfquestions';
        $this->data['loadMathJax']='YES';
	$this->load->view('template_mid',$this->data);
    }
    public function question($spname,$spid,$qid) {
       //update View Count
        $this->Pricelist_model->update_viewcount($qid,'cmsquestions');
        if($this->input->get('proxy') && $this->input->get('proxy')=='v2016'){
            $isvalid=true;
            
        }else{
            $isvalid=$this->Solvedpapers_model->checkQuestion($spid,$qid);
        }
        
        if($isvalid){
            $this->load->model('Questions_model');
            $spdetails=$this->Solvedpapers_model->detail($spid);
            $question=$this->Questions_model->detail($qid);
            $answers=$this->Questions_model->answers($qid);
            $relation=$this->Solvedpapers_model->getRelations($spid);
            $this->data['relation']=$relation[0];
            $title=generateTitle('Solved papers for',$relation[0],$spdetails->name);
            $this->data['title']=$title;
            $this->data['nextquestion']=$this->Questions_model->getNext('cmssolvedpapers_details','solvedpapers_id',$spid,$qid);
            $this->data['previousquestion']=$this->Questions_model->getPrevious('cmssolvedpapers_details','solvedpapers_id',$spid,$qid);
            $this->data['question']=$question;
            $this->data['answers']=$answers;
            $this->data['spdetails']=$spdetails;
            $this->data['loadMathJax']='YES';
            $this->data['linkurl']=base_url('solved-papers/'.$spname.'/'.$spid);
			
			$spname_array=explode('_q',$spname);
			$spname_val=$spname_array[1];
			if(isset($spname_val)&&$spname_val>=0){
				$url_spname=$spname_array[0];
			}else{
				$url_spname=$spname;
			}
			
			$appurl=substr($url_spname,-6);
			if($appurl=='appapi'){
			$this->data['content']='common/appquestiondetail';
			$this->load->view('template_mid',$this->data);
            }else{
			$this->data['content']='common/questiondetail';
			$this->load->view('template',$this->data);
			}
			
        }else{
            redirect('solved-papers/details/'.$spname.'/'.$spid);
        }
    }
}