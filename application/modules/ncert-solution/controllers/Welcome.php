<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Modulecontroller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Ncertsolutions_model');
		$this->load->model('Studymaterial_model');       
    }
	
    public function index($examname=null,$exam_id=0,$subjectname=null,$subject_id=0,$chapter_name=null,$chapter_id=0){
		$cache_minutes=$this->config->item('cache_minutes');	
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $this->load->model('Videos_model');
        $examdata=array();
        
        if($examname==null){
            $title=getTitle('Free NCERT Solutions',$this->data['examcategories']);
            
            $titleStr[]=$title;
        }else{
            $titleStr[]='Free NCERT Solutions for';
        }
        if($exam_id > 0){
            $exam=  $this->Categories_model->getCategoryDetails($exam_id);
            $this->data['selectedexam']=$exam;
            if($exam->id !=28 && $exam->id !=29){
             $titleStr[]=  addSuffix($exam->name,'Class');
            }
        }
        if($subject_id > 0){
            $this->load->model('Subjects_model');
            $this->data['selectedsubject']=$this->Subjects_model->getSubject($subject_id);
            if($this->data['selectedexam']->id !=28 && $this->data['selectedexam']->id !=29){
            $titleStr[]=$this->data['selectedsubject']->name;
            }
        }
        if($chapter_id > 0){
            $this->load->model('Chapters_model');
            $this->data['selectedchapter']=$this->Chapters_model->getChapter($chapter_id);
            if($this->data['selectedexam']->id !=28 && $this->data['selectedexam']->id !=29){
            $titleStr[]=$this->data['selectedchapter']->name;
            }
        }
        if($exam_id){
            $data_array=array();
            $chaptersubjects=$this->Examcategory_model->getExamChapters($exam_id);
             $subjects_array = array();
              $chapters_array = array();
            if(count($chaptersubjects) > 0){
                foreach($chaptersubjects as $record){
                    if (!in_array($record->sname, $subjects_array)) {
                        $subjects_array[$record->sid] = array('name' => $record->sname);
                    }
                    if ($subject_id > 0 && $subject_id == $record->sid) {
     
                        $ncertsol = $this->Ncertsolutions_model->getNcertSolutions($exam_id, $record->sid, $record->cid);
                        
                        if (!in_array($record->cname, $chapters_array)) {

                            $chapters_array[$record->cid] = array('name' => $record->cname, 'count' => count($ncertsol));
                        } else {
                            $chapters_array[$record->cid]['count'] = count($ncertsol);
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
        $hasncertinsubject=0;
        if (count($subjects_array) > 0) {
                foreach ($subjects_array as $key => $value) {
                    $ncertquestions = $this->Ncertsolutions_model->getNcertSolutions($exam_id, $key, 0);$hasncertinsubject+=count($ncertquestions);
                    $subjects_array[$key]['count'] = count($ncertquestions);
                }
            }
			
            $this->data['subjects_array'] = $subjects_array;
            $this->data['chapters_array'] = $chapters_array;
            $this->data['borwsebysubjects']=$hasncertinsubject;
           
        }
        if($subject_id > 0){
        $ncertsolutions=$this->Ncertsolutions_model->getNcertSolutions($exam_id,$subject_id,$chapter_id);
        }else{
        $ncertsolutions=$this->Ncertsolutions_model->getNcertSolutions($exam_id,$subject_id,$chapter_id,12);    
        }
        $idredirect=0;
		foreach($ncertsolutions as $ncKey=>$ncVal){
		if(isset($ncVal->id)&&$ncVal->id>0){
			
        $questions=$this->Ncertsolutions_model->getQuestions($ncVal->id);
			if(is_array($questions)&&count($questions)>0){
				//print_r($questions);
				$idredirect=$ncVal->id;
				
			}
		}
		}
		
        $videos=$this->Ncertsolutions_model->getVideos();
        $this->data['rvideos']=  $videos;
        
       // $studypacakge=$this->Ncertsolutions_model->getStudyPackage();
        $files=array();
        if(isset($studypacakge)){
           // $this->load->model('Studymaterial_model');
            $this->load->model('File_model');
            foreach($studypacakge as $package){
                $files[] = $this->Studymaterial_model->getFiles($package->id);
            }
        }
		$this->data['idredirect']=$idredirect;
        $this->data['rstudypackage']=$files;
        //print_r($files);
        $this->data['ncertsolutions']=$ncertsolutions;
        $this->data['exam_id']=$exam_id;
        $this->data['subject_id']=$subject_id;
        $this->data['chapter_id']=$chapter_id;
        $this->data['examdata']=$examdata;
        $this->data['title']= implode(' ',$titleStr);
        $this->data['h1title']= implode(' ',$titleStr);
        //$ncertquestions=$this->Ncertsolutions_model->getQuestionCount($exam_id,$subject_id,$chapter_id);
        //$this->data['ncertquestions']=$ncertquestions;
        $this->data['content']='welcome';
        
        $data=$this->Ncertsolutions_model->getNcertSolution($exam_id,$subject_id);
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
	
    public function details($solution_name,$solution_id){ 
        $url_segments = $this->uri->segment_array();
        //update View Count
        $this->Pricelist_model->update_viewcount($solution_id,'cmsncertsolutions');
        array_pop($url_segments);
        if(count($url_segments)==4){
        $url_segments[]='all';
        }
        if(count($url_segments)==3){
        $url_segments[]='all';
        $url_segments[]='all';
        }
        $this->data['url_segments'] = $url_segments;
        $this->load->model('Questions_model');
        $this->load->model('Mergesection_model');
        //$files=$this->Ncertsolutions_model->getFiles_withprice($solution_id);
        //$this->data['files']=$files;
        //9==ncert solution type
		//  1020 echo $solution_id;
        $relatedfiles=$this->Mergesection_model->getRelatedModule($solution_id,9,1); 

//print_r($relatedfiles);
		
        if(count($relatedfiles) > 0){
		foreach($relatedfiles as $rkey=>$rvalue){			
        //$this->load->model('Studymaterial_model');
		
		
		
                $relation=$this->Studymaterial_model->getRelations($rvalue->related_module_id); 
				
				//print_r($relation);
				$exam_id=$relation[0]->exam_id;
				
				$subject_id=$relation[0]->subject_id;
				
				$chapter_id=$relation[0]->chapter_id;
				
				
        // $file_price_info = $this->Studymaterial_model->getinfo_formerge($rvalue->related_module_id);
		$file_price_info = $this->Studymaterial_model->getinfo_file($rvalue->id);		
             if($rvalue->related_file_id > 0){
              $this->load->model('File_model');
              $details=$this->File_model->getStudyPackageDetails($rvalue->related_file_id);
              //$isProduct = $this->Pricelist_model->getItemPrice($rvalue->related_file_id,1);			  
			  $isProduct=array();
              $details_chaptername=$details->chapter;
              if(isset($details_chaptername)&&count($details_chaptername)>1){
              $details_chaptername=$details->chapter; 
              }else{
              $details_chaptername='all';
              }
              $url =  generateContentLink('study-packages', $details->exam, $details->subject, $details_chaptername, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
                $this->data['file']=$details;
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
                $this->data['isProduct']=$isProduct;
            }else{
                $details=$this->Studymaterial_model->detail($rvalue->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($rvalue->related_module_id);  
                
                $details_chaptername=$relation[0]->chapter;
              if(isset($details_chaptername)&&count($details_chaptername)>1){
                $details_chaptername=$relation[0]->chapter; 
              }else{
                $details_chaptername='all';
              }
                $url=  generateContentLink('study-packages', $relation[0]->exam, $relation[0]->subject, $details_chaptername, $details->name, $details->id);
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            $this->data['file_price_info']=$file_price_info[0];
        /*Get flax paper details*/
		
		$presentArray=array( $this->data['filepath'],$url,$this->data['filename'],$file_price_info[0],$details);
		
		$this->data['linktostudypackage'][]=$presentArray;
		}
        }
        //if($files){$this->data['file']=$files;}
        $relatedVideos=$this->Mergesection_model->getRelatedModule($solution_id,9,2);
        
		if(count($relatedVideos) > 0){
            $this->load->model('Videos_model');
            $playlists=array();
            foreach($relatedVideos as $related){
            $playlists[$related->related_module_id]=$this->Videos_model->getVideosList($related->related_module_id);
            }
            $this->data['related_playlists']=$playlists;
        }
	
		
		    if($subject_id > 0){
        $ncert_extrafile=$this->Ncertsolutions_model->getNcertSolutions($exam_id,$subject_id,$chapter_id);
        }else{
        $ncert_extrafile=$this->Ncertsolutions_model->getNcertSolutions($exam_id,$subject_id,$chapter_id,12);    
        }
		$extra_ncertid=$ncert_extrafile[0]->id;
		
		/*For Side bar value*/
		$relatedfiles=$this->Mergesection_model->getRelatedModule($extra_ncertid,9,1); 

//print_r($relatedfiles);
		
        if(count($relatedfiles) > 0){
		foreach($relatedfiles as $rkey=>$rvalue){			
        //$this->load->model('Studymaterial_model');
		
                $relation=$this->Studymaterial_model->getRelations($rvalue->related_module_id); 
				
				//print_r($relation);
				$exam_id=$relation[0]->exam_id;
				
				$subject_id=$relation[0]->subject_id;
				
				$chapter_id=$relation[0]->chapter_id;
				
				
        // $file_price_info = $this->Studymaterial_model->getinfo_formerge($rvalue->related_module_id);
		$file_price_info = $this->Studymaterial_model->getinfo_file($rvalue->id);		
             if($rvalue->related_file_id > 0){
              $this->load->model('File_model');
              $details=$this->File_model->getStudyPackageDetails($rvalue->related_file_id);
              //$isProduct = $this->Pricelist_model->getItemPrice($rvalue->related_file_id,1);			  
			  $isProduct=array();
              $details_chaptername=$details->chapter;
              if(isset($details_chaptername)&&count($details_chaptername)>1){
              $details_chaptername=$details->chapter; 
              }else{
              $details_chaptername='all';
              }
              $url =  generateContentLink('study-packages', $details->exam, $details->subject, $details_chaptername, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
                $this->data['file']=$details;
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
                $this->data['isProduct']=$isProduct;
            }else{
                $details=$this->Studymaterial_model->detail($rvalue->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($rvalue->related_module_id);  
                
                $details_chaptername=$relation[0]->chapter;
              if(isset($details_chaptername)&&count($details_chaptername)>1){
                $details_chaptername=$relation[0]->chapter; 
              }else{
                $details_chaptername='all';
              }
                $url=  generateContentLink('study-packages', $relation[0]->exam, $relation[0]->subject, $details_chaptername, $details->name, $details->id);
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            $this->data['file_price_info']=$file_price_info[0];
        /*Get flax paper details*/
		
		$presentArray=array( $this->data['filepath'],$url,$this->data['filename'],$file_price_info[0],$details);
		
		$this->data['linktostudypackage'][]=$presentArray;
		}
        }
		//print_r($this->data['linktostudypackage']); 
		
		/*End side bar value*/
		
        $soldetails=$this->Ncertsolutions_model->detail($solution_id);
        $relation=$this->Ncertsolutions_model->getRelations($solution_id);
		
		//checkrelation($solution_id, $exam_id, $subject_id, $chapter_id);
        //print_r($relation);
        $questions=$this->Ncertsolutions_model->getQuestions($solution_id);
		
        $exmeplar_questions=$this->Ncertsolutions_model->getExemplarQuestions($solution_id);
        $questiontypes=  $this->Ncertsolutions_model->questionTypes($solution_id);
        
        $title=generateTitle('Free Ncert Solutions for',$relation[0]);
        /* Get video list for side bar*/
        //$videoListAll =  $this->Ncertsolutions_model->getAllVideoProducts();
        //$this->data['videoListAll']=$videoListAll;
        
        $this->data['title']=$title;
        $this->data['soldetails']=$soldetails;		
        $this->data['relation']=$relation[1];
        $this->data['questiontypes']=$questiontypes;
        $this->data['questions']=$questions;
        $this->data['exmeplar_questions']=$exmeplar_questions;
        $this->data['content']='questions';
		$getlan = $soldetails->language;
		if(isset($getlan)&&$getlan=="hindi") {
			$this->data['loadMathJax']='no';
		}
		else {
			$this->data['loadMathJax']='yes';
		}
		
		//print_r( $this->data['relation']);
		//echo '[-===-=-]';
	$this->load->view('template',$this->data);
    }
    public function androiddetails($solution_name,$solution_id){
			$urlcust_array=explode('-encid-',$solution_name);
			
			if(isset($urlcust_array[1])){
				$urlcustid=base64_decode($urlcust_array[1]);
			}else{
				$urlcustid=0;
			}
		$url_segments = $this->uri->segment_array();
		
		///echo $solution_id." ==jk   "; print_r($url_segments); die();
		
         //update View Count
		 
        $this->Pricelist_model->update_viewcount($solution_id,'cmsncertsolutions');
        array_pop($url_segments);
		
        if(count($url_segments)==4){
            $url_segments[]='all';
        }
        
        
        if(count($url_segments)==3){
            $url_segments[]='all';
            $url_segments[]='all';
        }
        $this->data['url_segments'] = $url_segments;
        $this->load->model('Questions_model');
        $this->load->model('Mergesection_model');
		
        //$files=$this->Ncertsolutions_model->getFiles_withprice($solution_id);
        //$this->data['files']=$files;
        //9==ncert solution type
		
        $relatedfiles=$this->Mergesection_model->getRelatedModule($solution_id,9,1);
    if(count($relatedfiles) == 1){
            //$this->load->model('Studymaterial_model');
            $file_price_info = $this->Studymaterial_model->getinfo_formerge($relatedfiles[0]->related_module_id);
         
             
             if($relatedfiles[0]->related_file_id > 0){
              $this->load->model('File_model');
              $details=$this->File_model->getStudyPackageDetails($relatedfiles[0]->related_file_id);
              $isProduct = $this->Pricelist_model->getItemPrice($relatedfiles[0]->related_file_id,1);
             $details_chaptername=$details->chapter;
            
             //jk_test if(isset($details_chaptername)&&count($details_chaptername)>1){
               if(isset($details_chaptername)){
               
               $details_chaptername=$details->chapter; 
              }else{
                $details_chaptername='all';
              }
              $url=  generateContentLink('study-packages', $details->exam, $details->subject, $details_chaptername, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
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
                $url=  generateContentLink('study-packages', $relation[0]->exam, $relation[0]->subject, $details_chaptername, $details->name, $details->id);
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            $this->data['file_price_info']=$file_price_info[0];
            /*Get flax paper details*/
            $this->data['linktostudypackage']=$url;
        }
        //if($files){$this->data['file']=$files;}
        $relatedVideos=$this->Mergesection_model->getRelatedModule($solution_id,9,2);
     if(count($relatedVideos) > 0){
            $this->load->model('Videos_model');
            $playlists=array();
            foreach($relatedVideos as $related){
                $playlists[$related->related_module_id]=$this->Videos_model->getVideosList($related->related_module_id);
            }
            $this->data['related_playlists']=$playlists;
        }
        $soldetails=$this->Ncertsolutions_model->detail($solution_id);
        $relation=$this->Ncertsolutions_model->getRelations($solution_id);
       //print_r($relation);
        $questions=$this->Ncertsolutions_model->getQuestions($solution_id);
        $exmeplar_questions=$this->Ncertsolutions_model->getExemplarQuestions($solution_id);
 
 ///echo "js ==1 <br>";print_r($exmeplar_questions); die();

        $questiontypes=  $this->Ncertsolutions_model->questionTypes($solution_id);
        
        $title=generateTitle('Free Ncert Solutions for',$relation[0]);
        /* Get video list for side bar*/
        //$videoListAll =  $this->Ncertsolutions_model->getAllVideoProducts();
        //$this->data['videoListAll']=$videoListAll;		
        $this->data['title']=  $title;
        $this->data['soldetails']=$soldetails;
        $this->data['relation']=$relation[0];
        $this->data['questiontypes']=$questiontypes;
        $this->data['urlcustid']=$urlcustid;
        $this->data['questions']=$questions;
        $this->data['exmeplar_questions']=$exmeplar_questions;
        $this->data['content']='appquestions';		
		$getlan = $soldetails->language;
		if(isset($getlan)&&$getlan=="hindi") {
			$this->data['loadMathJax']='no';
		}
		else {
			$this->data['loadMathJax']='yes';
		}
		$this->load->view('template_mid',$this->data);
    }
    
    public function question($solname,$solid,$qid) {
        $this->load->model('Mergesection_model');
        $files=$this->Ncertsolutions_model->getFiles($solid);
        //update View Count
        $this->Pricelist_model->update_viewcount($qid,'cmsquestions');
        $this->data['files']=$files;
          $relatedfiles=$this->Mergesection_model->getRelatedModule($solid,9,1);
        if(count($relatedfiles) == 1){
           // $this->load->model('Studymaterial_model');
            if($relatedfiles[0]->related_file_id > 0){
                $this->load->model('File_model');
                $details=$this->File_model->getStudyPackageDetails($relatedfiles[0]->related_file_id);
                $url=  generateContentLink('study-packages', $details->exam, $details->subject, $details->chapter, $details->name,url_title($details->filename,'-',true));
                $url.='/'.$details->id;
                 $this->data['filename'] = $details->filename;
                 $this->data['filepath'] = 'upload/webreader/';
            }else{
                 
                $details=$this->Studymaterial_model->detail($relatedfiles[0]->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($relatedfiles[0]->related_module_id);             
                $url=  generateContentLink('study-packages', $relation[0]->exam, $relation[0]->subject, $relation[0]->chapter, $details->name, $details->id);
                $files = $this->Studymaterial_model->getFiles($relatedfiles[0]->related_file_id);
                $this->data['filename'] = $files[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            /*Get flax paper details*/
            $this->data['linktostudypackage']=$url;
        }
        
        $ncertdetails=$this->Ncertsolutions_model->detail($solid);
        $relation=$this->Ncertsolutions_model->getRelations($solid);
        $this->data['relation']=$relation[0];
        
        $title=generateTitle('Free Ncert Solutions for',$relation[0]);
        $this->data['title']=$title ;
        if($this->input->get('proxy') && $this->input->get('proxy')=='v2016'){
            $isvalid=true;
            
        }else{
            $isvalid=$this->Ncertsolutions_model->checkQuestion($solid,$qid);
        }
        $allquesgrid=$this->Ncertsolutions_model->getQuestions($solid);        
        $soldetails=$this->Ncertsolutions_model->detail($solid);        
        $this->data['soldetails']=$soldetails;
        $this->data['allquesgrid']=$allquesgrid;
        if($isvalid){
            $this->data['nextquestion']='';
            $this->data['previousquestion']='';
            $this->load->model('Questions_model');
            $question=$this->Questions_model->detail($qid);
            $answers=$this->Questions_model->answers($qid);
            $this->data['nextquestion']=$this->Questions_model->getNext('cmsncertsolutions_details','ncertsolutions_id',$solid,$qid);
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
			$dffd=$this->Questions_model->getPrevious('cmsncertsolutions_details','ncertsolutions_id',$solid,$qid);			
            $this->data['previousquestion']=$this->Questions_model->getPrevious('cmsncertsolutions_details','ncertsolutions_id',$solid,$qid);
			if($qcount>1){
				$qcount_prev=$qcount-1;
				$qcount_next=$qcount+1;
			}else{
				$qcount_prev=1;
				$qcount_next=1;
			}	
			
            $this->data['question']=$question;
            $this->data['answers']=$answers;
			$this->data['appcustid']=$appcustid;
            $this->data['linkurl']=base_url('ncert-solution/'.$url_solname.'/'.$solid);
            $this->data['linkurl_next']=base_url('ncert-solution/'.$url_solname.'_q'.$qcount_next.'/'.$solid);
            $this->data['linkurl_prev']=base_url('ncert-solution/'.$url_solname.'_q'.$qcount_prev.'/'.$solid);
			
			  $this->data['applinkurl_next']=base_url('appncert-solution/'.$url_solname.'_q'.$qcount_next.'/'.$solid);
            $this->data['applinkurl_prev']=base_url('appncert-solution/'.$url_solname.'_q'.$qcount_prev.'/'.$solid);
			
			$this->data['qcount']=$qcount;
			$this->data['ncertdetails']=$ncertdetails;
            $this->data['loadMathJax']='YES';
			$solname_array=explode('_q',$solname);
			$solname_val=$solname_array[0];
			if(isset($solname_val)&&count($solname_val)>0){
				$url_solname=$solname_array[0];
			}else{
				$url_solname=$solname;
			}
			$appurl=substr($url_solname,-6);
			if($appurl=='appapi'){
			$this->data['content']='common/appquestiondetail';
			$this->load->view('template_mid',$this->data);
            }else{
			$this->data['content']='common/questiondetail';
			$this->load->view('template',$this->data);
			}
			
            
            
        }else{
            redirect('ncert-solution/'.$solname.'/'.$solid);
        }
    }
    public function downloadPDF($file){
        $this->load->helper('download');
        $path=$this->input->server('DOCUMENT_ROOT').'/upload/pdfs/';
        $file=  decrypt($file);
        force_download($path.$file, NULL);
    }  
    
}