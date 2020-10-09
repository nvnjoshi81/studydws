<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends Modulecontroller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('Questionbank_model');
    }
    public function index($examname=null,$exam_id=0,$subjectname=null,$subject_id=0,$chapter_name=null,$chapter_id=0){
        $examdata=array();
        if($examname==null){
            $title=getTitle('Question Bank',$this->data['examcategories']);
            
            $titleStr[]=$title;
        }else{
            $titleStr[]='Question Bank for';
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
            $subjects_array = array();
            $chapters_array = array();
            $chaptersubjects=  $this->Examcategory_model->getExamChapters($exam_id);
            if(count($chaptersubjects) > 0){
                foreach($chaptersubjects as $record){
                    if (!in_array($record->sname, $subjects_array)) {
                        $subjects_array[$record->sid] = array('name' => $record->sname);
                    }
                    if ($subject_id > 0 && $subject_id == $record->sid) {
                        $notes = $this->Questionbank_model->getQuestionBank($exam_id, $record->sid, $record->cid);
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
                    $notes = $this->Questionbank_model->getQuestionBank($exam_id, $key, 0);
                    $subjects_array[$key]['count'] = count($notes);
                }
            }
            $this->data['subjects_array'] = $subjects_array;

            $this->data['chapters_array'] = $chapters_array;
        }
       if($chapter_id>0){
          $plimit=900;
      }else {
          $plimit=20;
      }
        
        $questionbanks=$this->Questionbank_model->getQuestionBank($exam_id,$subject_id,$chapter_id,$plimit);
        $this->data['title']= implode(' ',$titleStr);
        $this->data['h1title']= implode(' ',$titleStr);
        $this->data['questionbanks']=$questionbanks;
        $this->data['exam_id']=$exam_id;
        $this->data['subject_id']=$subject_id;
        $this->data['chapter_id']=$chapter_id;
        $this->data['examdata']=$examdata;
        $this->data['content']='welcome';
        //$qbquestions=$this->Questionbank_model->getQuestionCount($exam_id,$subject_id,$chapter_id);
       
        $qbquestions=2000;
        $this->data['qbquestions']=$qbquestions;
        $data=$this->Questionbank_model->getQBList($exam_id,$subject_id);
       
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
    
    public function details($qbname,$qbid){  
        $this->load->model('Questions_model');
        //update View Count
        $this->Pricelist_model->update_viewcount($qbid,'cmsquestionbank');
        $qbdetails=$this->Questionbank_model->detail($qbid);
        $relation=$this->Questionbank_model->getRelations($qbid);
        $questions=$this->Questionbank_model->getQuestions($qbid);
        $questiontypes =  $this->Questionbank_model->questionTypes($qbid);
        $title=generateTitle('Question Bank for',$relation[0],$qbdetails->name);
        /*Display related product for Question bank Start */
        $this->load->model('Mergesection_model');
        $relatedfiles=$this->Mergesection_model->getRelatedModule($qbid,7,1); 
        if(count($relatedfiles) >0){
            $this->load->model('Studymaterial_model');
             $file_price_info = $this->Studymaterial_model->getinfo_formerge($relatedfiles[0]->related_module_id);
            
             if($relatedfiles[0]->related_file_id > 0){
                $this->load->model('File_model');
                $details=$this->File_model->getStudyPackageDetails($relatedfiles[0]->related_file_id);
                $isProduct = $this->Pricelist_model->getItemPrice($relatedfiles[0]->related_file_id,1);
              if(isset($details->id)&&$details->id!=''){
                $url=  generateContentLink('study-packages', $details->exam, $details->subject, $details->chapter, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
			 }else{
				 $url=NULL;
			 }
			 
                $this->data['file']=$details;
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
                $this->data['isProduct']=$isProduct;
            }else{
                 
                $details=$this->Studymaterial_model->detail($relatedfiles[0]->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($relatedfiles[0]->related_module_id);        
				if(isset($details->id)&&$details->id!=''){          
                $url=  generateContentLink('study-packages', $relation[0]->exam, $relation[0]->subject, $relation[0]->chapter, $details->name, $details->id);
				}else{
				$url=NULL;	
				}
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
        
            $this->data['file_price_info']=$file_price_info[0];
            /*Get flax paper details*/
			if(isset($url)&&$url!=NULL){
            $this->data['linktostudypackage']=$url;
			}
        }
        
        
$purchases=$this->session->userdata('purchases');
$user_spOrder=$purchases[1];
$qbid_orderd=array();
if(count($user_spOrder)>0){
        foreach($user_spOrder as $key=>$pid){
            if(isset($pid)&&$pid>0){
                $product_details = $this->Pricelist_model->getDetails($pid);
                 $exam_idqb=$product_details->exam_id;
                 $subject_idqb=$product_details->subject_id;
                 $chapter_idqb=$product_details->chapter_id; 
                 $questionbanksid_array=$this->Questionbank_model->getQuestionBank($exam_idqb,$subject_idqb,$chapter_idqb);
                 foreach($questionbanksid_array as $keyqb=>$qbid_ord){
                 $qbid_orderd[]=$qbid_ord->id;
                 }
            }else{
                 $qbid_orderd=array();
            }
            }
}else{
				$qbid_orderd=array();
			}
            $this->data['showQB_dwn']='NO';
            if (in_array($qbid, $qbid_orderd))
            {
			if($this->session->userdata('customer_id')=='150339'&&$subject_idqb=='10'&&$exam_idqb=='102'){
			  $this->data['showQB_dwn']='YES';
			}
                        if($this->session->userdata('customer_id')=='147503'){
                            //For Email-dikshasharmacps@gmail.com order id- 1549603121 
                             $this->data['showQB_dwn']='NO';
                            if($exam_idqb=='32'||$exam_idqb=='33'||$exam_idqb=='34'||$exam_idqb=='35'||$exam_idqb=='36'||$exam_idqb=='37'||$exam_idqb=='38'){
			  $this->data['showQB_dwn']='YES';
                            }
			}
						
           if($this->session->userdata('customer_id')=='157685'){ 
                            //For Email-rupi_18@yahoo.com order id- 1553326560 
                             $this->data['showQB_dwn']='NO';
                            if($exam_idqb=='24'){
			  $this->data['showQB_dwn']='YES';
                            }
			}
    if($this->session->userdata('customer_id')=='71696'){
		$this->data['showQB_dwn']='YES'; 
	}
  } 
  

            //print_r($qbid_orderd);
        
        
        /*Display related product for Question bank End */
        $this->data['title']=$title;
        $this->data['qbdetails']=$qbdetails;
        $this->data['relation']=$relation[0];
        $this->data['questiontypes']=$questiontypes;
        $this->data['questions']=$questions;
        $this->data['content']='questions';
        $this->data['loadMathJax']='YES';
	$this->load->view('template',$this->data);
    }
    
        
    public function androiddetails($qbname,$qbid){
        $this->load->model('Questions_model');
        //update View Count
        $this->Pricelist_model->update_viewcount($qbid,'cmsquestionbank');
        $qbdetails=$this->Questionbank_model->detail($qbid);
        $relation=$this->Questionbank_model->getRelations($qbid);
        $questions=$this->Questionbank_model->getQuestions($qbid);        
        $questiontypes =  $this->Questionbank_model->questionTypes($qbid);
        $title=generateTitle('Question Bank for',$relation[0],$qbdetails->name);
        $this->data['title']=$title;
        $this->data['qbdetails']=$qbdetails;
        $this->data['relation']=$relation[0];
        $this->data['questiontypes']=$questiontypes;
        $this->data['questions']=$questions;
        $this->data['content']='appquestions';
        $this->data['loadMathJax']='YES';
	$this->load->view('template_mid',$this->data);
    }
    
    public function printdetails($qbname,$qbid){
        $file_key =  decrypt($qbid);
        $qbid_array = explode('_st@ad_',$file_key);
        $qbid=$qbid_array[0];
//$qbid='4198';
		//For PDF print
        $this->load->model('Questions_model');
        //update View Count
        $this->Pricelist_model->update_viewcount($qbid,'cmsquestionbank');

        $qbdetails=$this->Questionbank_model->detail($qbid);
        $relation=$this->Questionbank_model->getRelations($qbid);
        $questions=$this->Questionbank_model->getQuestions($qbid);        
        $questiontypes = $this->Questionbank_model->questionTypes($qbid);
        $title=generateTitle('Question Bank for',$relation[0],$qbdetails->name);
		$this->data['title']=$title;
        $this->data['qbdetails']=$qbdetails;
        $this->data['relation']=$relation[0];
        $this->data['questiontypes']=$questiontypes;
        $this->data['questions']=$questions;
        $this->data['content']='pdfquestions';
        $this->data['loadMathJax']='YES';
	$this->load->view('template_mid',$this->data);
    }
    public function question($qbname,$qbid,$qid) {
        $qbdetails=$this->Questionbank_model->detail($qbid);
        $relation=$this->Questionbank_model->getRelations($qbid);
       //update View Count
        $this->Pricelist_model->update_viewcount($qid,'cmsquestions');
        $this->data['relation']=$relation[0];
        if($this->input->get('proxy') && $this->input->get('proxy')=='v2016'){
            $isvalid=true;
            
        }else{
            $isvalid=$this->Questionbank_model->checkQuestion($qbid,$qid);
        }
        
        if($isvalid){
            $this->data['nextquestion']='';
            $this->data['previousquestion']='';
            $this->load->model('Questions_model');
            $question=$this->Questions_model->detail($qid);
            $answers=$this->Questions_model->answers($qid);
            $this->data['nextquestion']=$this->Questions_model->getNext('cmsquestionbank_details','questionbank_id',$qbid,$qid);
            $this->data['previousquestion']=$this->Questions_model->getPrevious('cmsquestionbank_details','questionbank_id',$qbid,$qid);
            $this->data['question']=$question;
            $this->data['answers']=$answers;
            $this->data['linkurl']=base_url('question-bank/'.$qbname.'/'.$qbid);
            $this->data['qbdetails']=$qbdetails;
            $this->data['loadMathJax']='YES';
			
			
			$spname_array=explode('_q',$qbname);
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
            redirect('question-bank/details/'.$qbname.'/'.$qbid);
        }
    }
    
}

