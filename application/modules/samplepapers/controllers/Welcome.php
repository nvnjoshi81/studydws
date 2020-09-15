<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends Modulecontroller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('Samplepapers_model');
        $this->load->model('Chapters_model');
    }
    public function index($examname=null,$exam_id=0,$subjectname=null,$subject_id=0,$chapter_name=null,$chapter_id=0){
        $examdata=array();
        if($examname==null){
            $title=getTitle('Sample Papers',$this->data['examcategories']);
            
            $titleStr[]=$title;
        }else{
            $titleStr[]='Sample Papers for';
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
            $this->load->model('Chapters_model');
            $this->data['selectedchapter']=$this->Chapters_model->getChapter($chapter_id);
            $titleStr[]=$this->data['selectedchapter']->name;
        }
        if($exam_id){
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
                        $notes = $this->Samplepapers_model->getSamplePapers($exam_id, $record->sid, $record->cid);
                        if(count($notes) > 0){
                        if (!in_array($record->cname, $chapters_array)) {

                            $chapters_array[$record->cid] = array('name' => $record->cname, 'count' => count($notes));
                        } else {
                            $chapters_array[$record->cid]['count'] = count($notes);
                        }
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
            $this->data['subject_chapters'] = $data_array;
            if (count($subjects_array) > 0) {
                foreach($subjects_array as $key => $value) {
                    $notes = $this->Samplepapers_model->getSamplePapers($exam_id, $key, 0);
                    $subjects_array[$key]['count'] = count($notes);
                }
            }
            $this->data['subjects_array'] = $subjects_array;

            $this->data['chapters_array'] = $chapters_array;
        }
        $samplepapers=$this->Samplepapers_model->getSamplePapers($exam_id,$subject_id,$chapter_id);
        $this->data['samplepapers']=$samplepapers;
        $questions=$this->Samplepapers_model->getQuestionCount($exam_id,$subject_id,$chapter_id);
        $this->data['title']= implode(' ',$titleStr);
        $this->data['h1title']= implode(' ',$titleStr);
        $this->data['questions']=$questions;
        $this->data['exam_id']=$exam_id;
        $this->data['subject_id']=$subject_id;
        $this->data['chapter_id']=$chapter_id;
        $this->data['examdata']=$examdata;
        $this->data['content']='welcome';
        $data=$this->Samplepapers_model->getSamplepapersList($exam_id,$subject_id);
       
        $solutions_array=array();
        foreach($data as $result){
           
            if(!array_key_exists($result->exam_id, $solutions_array)){
                $solutions_array[$result->exam_id]=array('name'=>$result->exam,'subjects'=>array());
            }
            if(!array_key_exists($result->subject_id, $solutions_array[$result->exam_id]['subjects'])){
                $solutions_array[$result->exam_id]['subjects'][$result->subject_id]=array('id'=>$result->subject_id,'name'=>$result->subject);
            }
        }
        $this->data['solutions_array']=$solutions_array;
	$this->load->view('template',$this->data);
    }
    
    public function details($spname,$spid){
        
        $segments = $this->uri->total_segments();
        
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
        
         $this->load->model('Mergesection_model');
         //6==Sample paper type
        $relatedfiles=$this->Mergesection_model->getRelatedModule($spid,6,1);
        
           if(count($relatedfiles) == 1){
            $this->load->model('Studymaterial_model');
            $file_price_info = $this->Studymaterial_model->getinfo_formerge($relatedfiles[0]->related_module_id);
             if($relatedfiles[0]->related_file_id > 0){
              $this->load->model('File_model');
              $details=$this->File_model->getStudyPackageDetails($relatedfiles[0]->related_file_id);
              $isProduct = $this->Pricelist_model->getItemPrice($relatedfiles[0]->related_file_id,1);
              $details_chaptername=$details->chapter;
              if(isset($details_chaptername)&&count($details_chaptername)>1){
                $details_chaptername=$details->chapter; 
              }else{
                  $details_chaptername='all';
              }
              $details_subjectname=$details->subject;
              if(isset($details_subjectname)&&count($details_subjectname)>1){
                $details_subjectname=$details->subject; 
              }else{
                  $details_subjectname='all';
              }
              
              $url=  generateContentLink('study-packages', $details->exam, $details_subjectname, $details_chaptername, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
                $this->data['file']=$details;
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
                $this->data['isProduct']=$isProduct;
            }else{
                $details=$this->Studymaterial_model->detail($relatedfiles[0]->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($relatedfiles[0]->related_module_id);  
                 $details_chaptername=$relation[0]->chapter;
              if(isset($details_chaptername)&&count($details_chaptername)>1){
                $details_chaptername=$relation[0]->chapter; 
              }else{
                  $details_chaptername='all';
              }
                $details_subjectname=$relation[0]->subject;
              if(isset($details_subjectname)&&count($details_subjectname)>1){
                $details_subjectname=$details->subject; 
              }else{
                  $details_subjectname='all';
              }
                $url=  generateContentLink('study-packages', $relation[0]->exam, $details_subjectname, $details_chaptername, $details->name, $details->id);
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            $this->data['file_price_info']=$file_price_info[0];
            /*Get flax paper details*/
            $this->data['linktostudypackage']=$url;
        }
        
        //update View Count
        $this->Pricelist_model->update_viewcount($spid,'cmssamplepapers');
        $spdetails=$this->Samplepapers_model->detail($spid);
        $relation=$this->Samplepapers_model->getRelations($spid);
        //$questions=$this->Samplepapers_model->getQuestions($spid);
        $questions=$this->Samplepapers_model->getQuestions($spid,$section,$chapter_id);
        // This can be replaced with chapters when viewing paper from subjects link
        $sections=$this->Samplepapers_model->getSectionsForQuestions($spid,$section,$chapter_id);       
        $this->data['sections']=$sections;
        $this->data['relation']=$relation[0];
        $questiontypes=  $this->Samplepapers_model->questionTypes($spid);
        $title=generateTitle('Sample papers for',$relation[0],$spdetails->name);
        $this->data['title']=$title;
        $this->data['spdetails']=$spdetails;
        $this->data['questiontypes']=$questiontypes;
        $this->data['questions']=$questions;
        $this->data['content']='questions';
        $this->data['loadMathJax']='YES';
	$this->load->view('template',$this->data);
    }
    
    public function androiddetails($spname,$spid){
		$urlcust_array=explode('-encid-',$spname);
			if(isset($urlcust_array[1])){
				$urlcustid=base64_decode($urlcust_array[1]);
			}else{
				$urlcustid=0;
			}
        $segments = $this->uri->total_segments();
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
        
         $this->load->model('Mergesection_model');
         //6==Sample paper type
        $relatedfiles=$this->Mergesection_model->getRelatedModule($spid,6,1);
        
           if(count($relatedfiles) == 1){
            $this->load->model('Studymaterial_model');
            $file_price_info = $this->Studymaterial_model->getinfo_formerge($relatedfiles[0]->related_module_id);
             if($relatedfiles[0]->related_file_id > 0){
              $this->load->model('File_model');
              $details=$this->File_model->getStudyPackageDetails($relatedfiles[0]->related_file_id);
              $isProduct = $this->Pricelist_model->getItemPrice($relatedfiles[0]->related_file_id,1);
              $details_chaptername=$details->chapter;
              if(isset($details_chaptername)&&count($details_chaptername)>1){
                $details_chaptername=$details->chapter; 
              }else{
                  $details_chaptername='all';
              }
               $details_subjectname= $details->subject;
              if(isset($details_subjectname)&&count($details_subjectname)>1){
                $details_subjectname=$details->subject; 
              }else{
                  $details_subjectname='all';
              }
              
              $url=  generateContentLink('study-packages', $details->exam, $details_subjectname, $details_chaptername, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
                $this->data['file']=$details;
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
                $this->data['isProduct']=$isProduct;
            }else{
                $details=$this->Studymaterial_model->detail($relatedfiles[0]->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($relatedfiles[0]->related_module_id);  
                 $details_chaptername=$relation[0]->chapter;
              if(isset($details_chaptername)&&count($details_chaptername)>1){
                $details_chaptername=$relation[0]->chapter; 
              }else{
                  $details_chaptername='all';
              }
              
                 $details_subjectname=$relation[0]->subject;
              if(isset($details_subjectname)&&count($details_subjectname)>1){
                $details_subjectname=$details->subject; 
              }else{
                  $details_subjectname='all';
              }
                $url=  generateContentLink('study-packages', $relation[0]->exam, $details_subjectname, $details_chaptername, $details->name, $details->id);
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            $this->data['file_price_info']=$file_price_info[0];
            /*Get flax paper details*/
            $this->data['linktostudypackage']=$url;
        }
        
        //update View Count
        $this->Pricelist_model->update_viewcount($spid,'cmssamplepapers');
        $spdetails=$this->Samplepapers_model->detail($spid);
        $relation=$this->Samplepapers_model->getRelations($spid);
        $questions=$this->Samplepapers_model->getQuestions($spid);
        //$questions=$this->Samplepapers_model->getQuestions($spid,$section,$chapter_id);
        // This can be replaced with chapters when viewing paper from subjects link
        $sections=$this->Samplepapers_model->getSectionsForQuestions($spid,$section,$chapter_id);       
        $this->data['sections']=$sections;
        $this->data['relation']=$relation[0];
        $questiontypes=  $this->Samplepapers_model->questionTypes($spid);
        $title=generateTitle('Sample papers for',$relation[0],$spdetails->name);
		$this->data['urlcustid']=$urlcustid;
        $this->data['title']=$title;
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
         
            if(isset($chapter_name)&&$chapter_name!=NULL){
            $chapter=$this->Chapters_model->getChapterBySlug($chapter_name);
            $chapter_id=$chapter->id;
            }else{
            $chapter_id=0;
            }
        }
          
        $this->load->model('Questions_model');
        
         $this->load->model('Mergesection_model');
         //6==Sample paper type
        $relatedfiles=$this->Mergesection_model->getRelatedModule($spid,6,1);
        
           if(count($relatedfiles) == 1){
            $this->load->model('Studymaterial_model');
            $file_price_info = $this->Studymaterial_model->getinfo_formerge($relatedfiles[0]->related_module_id);
             if($relatedfiles[0]->related_file_id > 0){
              $this->load->model('File_model');
              $details=$this->File_model->getStudyPackageDetails($relatedfiles[0]->related_file_id);
              $isProduct = $this->Pricelist_model->getItemPrice($relatedfiles[0]->related_file_id,1);
              $details_chaptername=$details->chapter;
              if(isset($details_chaptername)&&count($details_chaptername)>1){
                $details_chaptername=$details->chapter; 
              }else{
                  $details_chaptername='all';
              }
               $details_subjectname= $details->subject;
              if(isset($details_subjectname)&&count($details_subjectname)>1){
                $details_subjectname=$details->subject; 
              }else{
                  $details_subjectname='all';
              }
              
              $url=  generateContentLink('study-packages', $details->exam, $details_subjectname, $details_chaptername, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
                $this->data['file']=$details;
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
                $this->data['isProduct']=$isProduct;
            }else{
                $details=$this->Studymaterial_model->detail($relatedfiles[0]->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($relatedfiles[0]->related_module_id);  
                 $details_chaptername=$relation[0]->chapter;
              if(isset($details_chaptername)&&count($details_chaptername)>1){
                $details_chaptername=$relation[0]->chapter; 
              }else{
                  $details_chaptername='all';
              }
              
                 $details_subjectname=$relation[0]->subject;
              if(isset($details_subjectname)&&count($details_subjectname)>1){
                $details_subjectname=$details->subject; 
              }else{
                  $details_subjectname='all';
              }
                $url=  generateContentLink('study-packages', $relation[0]->exam, $details_subjectname, $details_chaptername, $details->name, $details->id);
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            $this->data['file_price_info']=$file_price_info[0];
            /*Get flax paper details*/
            $this->data['linktostudypackage']=$url;
        }
        
        //update View Count
        $this->Pricelist_model->update_viewcount($spid,'cmssamplepapers');
        $spdetails=$this->Samplepapers_model->detail($spid);
        $relation=$this->Samplepapers_model->getRelations($spid);
        //$questions=$this->Samplepapers_model->getQuestions($spid);
        $questions=$this->Samplepapers_model->getQuestions($spid,$section,$chapter_id);
        
        // This can be replaced with chapters when viewing paper from subjects link
        $sections=$this->Samplepapers_model->getSectionsForQuestions($spid,$section,$chapter_id);       
        $this->data['sections']=$sections;
        $this->data['relation']=$relation[0];
        $questiontypes=  $this->Samplepapers_model->questionTypes($spid);
        $title=generateTitle('Sample papers for',$relation[0],$spdetails->name);
        $this->data['title']=$title;
        $this->data['spdetails']=$spdetails;
        $this->data['questiontypes']=$questiontypes;
        $this->data['questions']=$questions;
        $this->data['content']='pdfquestions';
        $this->data['loadMathJax']='YES';
	$this->load->view('template_mid',$this->data);
    }
    
    public function question($spname,$spid,$qid) {
       
        if($this->input->get('proxy') && $this->input->get('proxy')=='v2016'){
            $isvalid=true;
            
        }else{
            $isvalid=$this->Samplepapers_model->checkQuestion($spid,$qid);
        }
        //update View Count
        $this->Pricelist_model->update_viewcount($qid,'cmsquestions');
        if($isvalid){
            $this->load->model('Questions_model');
            $spdetails=$this->Samplepapers_model->detail($spid);
            $question=$this->Questions_model->detail($qid);
            $answers=$this->Questions_model->answers($qid);
            $relation=$this->Samplepapers_model->getRelations($spid);
            $this->data['relation']=$relation[0];
            $title=generateTitle('Sample papers for',$relation[0],$spdetails->name);
            $this->data['title']=$title;
            $this->data['nextquestion']=$this->Questions_model->getNext('cmssamplepapers_details','samplepaper_id',$spid,$qid);
            $this->data['previousquestion']=$this->Questions_model->getPrevious('cmssamplepapers_details','samplepaper_id',$spid,$qid);
            $this->data['question']=$question;
            $this->data['answers']=$answers;
            $this->data['spdetails']=$spdetails;
            $this->data['loadMathJax']='YES';
			/*Only for display qcount*/

                       $topicname=$this->uri->segment(2);
                       if(isset($topicname)){
                          $topicname_array = explode('_q', $topicname);
                       } 
					
                        if(isset($topicname_array[1])&&$topicname_array[1]!=''){
							
							
                          $topicname_array = explode('_', $topicname_array[1]);
							
                            $qcount=$topicname_array[0];
                        
                            $appcustid=$topicname_array[1];
						}else{
                            $qcount=1;
							$appcustid=0;
                        } 
                    /*End qcount*/	
			
			$this->data['qcount']=$qcount;
			$this->data['appcustid']=$appcustid;
			
			
			
            $this->data['linkurl']=base_url('sample-papers/'.$spname.'/'.$spid);
			$spname_array=explode('_q',$spname);
			$spname_val=$spname_array[0];
			if(isset($spname_val)&&count($spname_val)>0){
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
            redirect('sample-papers/details/'.$spname.'/'.$spid);
        }
    }
}
?>
