<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends Modulecontroller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('Videos_model');
        $this->load->model("Onlinetest_model");
        $this->load->model("Studymaterial_model");
        $this->load->model('Posting_model');
        $this->load->model('Ncertsolutions_model');
        $this->load->model('Solvedpapers_model');
        $this->load->model('Products_model');
        $this->load->model('Pricelist_model');
        $this->load->model('File_model');
        
    }
    public function index(){
        $this->data['path']='';
        $qb=$this->Questionbank_model->getQuestionBank();
        $this->data['qb']=$qb;
        
       
        // Get Sample papers for class
        $sp=$this->Samplepapers_model->getSamplePapers();
        $this->data['sp']=$sp;
        
        //$qbquestions=$this->Questionbank_model->getQuestionCount();
        $this->data['qbquestions']='4567';
        
        //$spquestions=$this->Samplepapers_model->getQuestionCount();
        $this->data['spquestions']='3455';
        
         // Get Solved papers for class
        $solvedp=$this->Solvedpapers_model->getSolvedPapers();
        $this->data['solvedp']=$solvedp;
        
        $vid=$this->Videos_model->getVideos();
        
        $this->data['vid']=$vid;
        
        // GET Online Test  Comment Temporarily
        //$ot=$this->Onlinetest_model->getOnlineTests();
        //$this->data['ot']=$ot;
        
        // GET StudyMaterial
        $sm=$this->Studymaterial_model->getStudyMaterial();
        $this->data['sm']=$sm;
        
        // GET Articles
        $ar=$this->Posting_model->getArticlesForExams();
        $this->data['ar']=$ar;
        
        // GET Ncert Solutions
        $ncert=$this->Ncertsolutions_model->getNcertSolutions();
        $this->data['ncert']=$ncert;
        
        //$videos=$this->Videos_model->getVideosCount();
        $this->data['videos']='5654';
        
        //$test=$this->Onlinetest_model->getQuestionCount();
        $this->data['tests']='234';
        
        //$material=$this->Studymaterial_model->getStudyMaterialCount();
        $this->data['material']='3455';
        
        //$ncertq=$this->Ncertsolutions_model->getQuestionCount();
        $this->data['ncertquestion']='2245'; 
        
        //$solvedq=$this->Solvedpapers_model->getQuestionCount();
        $this->data['solvedquestions']='3634'; 
        
        $this->data['content']='welcome';
       
          
	$this->load->view('template',$this->data);
    }
    public function main($examname,$examid,$subjectname=null,$subject_id=0,$chapter_name=null,$chapter_id=0){
        $data_array=array();
        $exam=  $this->Categories_model->getCategoryDetails($examid);
        $titleStr[]=addSuffix($exam->name,'Class');
        $this->data['selectedexam']=$exam;
        $path=$examname.'/'.$examid;
        if($subject_id > 0){
            $this->load->model('Subjects_model');
            $this->data['selectedsubject']=$this->Subjects_model->getSubject($subject_id);
            $path.='/'.$subjectname.'/'.$subject_id;
            $titleStr[]=$this->data['selectedsubject']->name;
        }
        if($chapter_id > 0){
            $this->load->model('Chapters_model');
            $this->data['selectedchapter']=$this->Chapters_model->getChapter($chapter_id);
            $path.='/'.$chapter_name.'/'.$chapter_id;
            $titleStr[]=$this->data['selectedchapter']->name;
        }
        $chaptersubjects=  $this->Examcategory_model->getExamChapters($examid);
        if(count($chaptersubjects) > 0){
            foreach($chaptersubjects as $record){
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
        $titleStr[]='Online Prepration';
        $this->data['title']=  implode(' ', $titleStr);
        // GET different content types and count
        // GET Question Bank for Class
        $qb=$this->Questionbank_model->getQuestionBank($examid,$subject_id,$chapter_id);
        $this->data['qb']=$qb;
        
        // Get Sample papers for class
        $sp=$this->Samplepapers_model->getSamplePapers($examid,$subject_id,$chapter_id);
        $this->data['sp']=$sp;
        
        // Get Solved papers for class
        $solvedp=$this->Solvedpapers_model->getSolvedPapers($examid,$subject_id,$chapter_id);
        $this->data['solvedp']=$solvedp;
        
        
        
        // GET Videos
        $vid=$this->Videos_model->getVideos($examid,$subject_id,$chapter_id);
        
        $this->data['vid']=$vid;
        
        // GET Online Test Comment Temporarily
        //$ot=$this->Onlinetest_model->getOnlineTests($examid,$subject_id,$chapter_id);
       // $this->data['ot']=$ot;
        
        // GET StudyMaterial
        $sm=$this->Studymaterial_model->getStudyMaterial($examid,$subject_id,$chapter_id);
        $this->data['sm']=$sm;
        
        // GET Articles
        $ar=$this->Posting_model->getArticlesForExams($examid,$subject_id,$chapter_id);
        $this->data['ar']=$ar;
        
        // GET Ncert Solutions
        $ncert=$this->Ncertsolutions_model->getNcertSolutions($examid,$subject_id,$chapter_id);
        $this->data['ncert']=$ncert;
        
        
        $filelist=$this->Studymaterial_model->getFilesProducts($examid,$subject_id,$chapter_id);
        //$this->data['productslist']=$pricelist;         
        $videolist=$this->Products_model->getVideos($examid,$subject_id,$chapter_id);
        $this->data['productslist']=array_merge($videolist,$filelist);
        //print_r($this->session->userdata('purchases'));
       
        
        // Deepak check products bought
        $this->data['isMainProductBrought']=false;
        $this->data['isSubjectProductBrought']=false;
        $this->data['isChapterProductBrought']=false;
        $allexpr=array();$allsubpr=array();$allchpr=array();
        $boughtproducts=array();
        if($this->session->userdata('customer_id')){
        $purchsed_products = $this->session->userdata('purchases');  
            foreach($purchsed_products as $key=>$value){
                foreach ($value as $k1 => $v1) {
                    $prdetails=$this->Pricelist_model->getDetails($v1);
                    if($prdetails->type==1){
                        //print_r($prdetails);
                    if($prdetails->item_id==0){
                        if($prdetails->exam_id > 0 && $prdetails->subject_id ==0 && $prdetails->chapter_id ==0){
                            //echo 'Exam';
                            //if($prdetails->exam_id==$examid){
                               $allexpr[]=$this->Pricelist_model->getAllProducts($prdetails->exam_id,0,0,1);
                            //}
                        }elseif($prdetails->exam_id > 0 && $prdetails->subject_id  > 0 && $prdetails->chapter_id ==0){
                            //echo 'Subject';
                            //if($prdetails->exam_id==$examid && $prdetails->subject_id == $subject_id){
                                $allsubpr[]=$this->Pricelist_model->getAllProducts($prdetails->exam_id,$prdetails->subject_id,0,1);
                            //} 
                        }elseif($prdetails->exam_id > 0 && $prdetails->subject_id > 0 && $prdetails->chapter_id > 0){
                            //echo 'chapter';
                            //if($prdetails->exam_id==$examid && $prdetails->subject_id == $subject_id && $prdetails->chapter_id == $chapter_id){
                                $allchpr[]=$this->Pricelist_model->getAllProducts($prdetails->exam_id,$prdetails->subject_id,$prdetails->chapter_id,1);
                           // }
                        }
                        
                        
                    }
                }
                }
            }
            if(count($allexpr) >0 ){
                foreach($allexpr as $e=>$f){
                    foreach($f as $e1=>$f1){
                    $boughtproducts[]=$f1->productlist_id;
                    }
                }
            }
            if(count($allsubpr) > 0 ){
                foreach($allsubpr as $e=>$f){
                    foreach($f as $e1=>$f1){
                    $boughtproducts[]=$f1->productlist_id;
                    }
                }
            }
            if(count($allchpr) >0 ){
                foreach($allchpr as $e=>$f){
                    foreach($f as $e1=>$f1){
                        $boughtproducts[]=$f1->productlist_id;
                    }
                }
            }
            $this->data['checkforpurchase']=true;
        }else{
            $this->data['checkforpurchase']=false;
        }
          $marray=array();
          if(count($boughtproducts) > 0){
              $marray = $this->session->userdata('purchases');
          if(array_key_exists(1, $marray)){
              $result=array_merge($marray[1],$boughtproducts);
              $marray[1]=$result;
          }else{
              $marray[1]=$boughtproducts;
          }
          ;}
        $this->data['pproducts']=$marray;
       
        
         
        
        //$qbquestions=$this->Questionbank_model->getQuestionCount($examid,$subject_id,$chapter_id);
        $this->data['qbquestions']='3455';
        
       // $spquestions=$this->Samplepapers_model->getQuestionCount($examid,$subject_id,$chapter_id);
        $this->data['spquestions']='2343';
        
        //$solvedquestions=$this->Solvedpapers_model->getQuestionCount($examid,$subject_id,$chapter_id);
        $this->data['solvedquestions']='3343';
        
        
        //$videos=$this->Videos_model->getVideosCount($examid,$subject_id,$chapter_id);
        $this->data['videos']='4324';
        
        //$test=$this->Onlinetest_model->getQuestionCount($examid,$subject_id,$chapter_id);
        $this->data['tests']='4378';
        
        //$material=$this->Studymaterial_model->getStudyMaterialCount($examid,$subject_id,$chapter_id);
        $this->data['material']='3298';
        
       // $ncertq=$this->Ncertsolutions_model->getQuestionCount($examid,$subject_id,$chapter_id);
        $this->data['ncertquestion']='4965';  
        $this->data['path']=$path;
        $this->data['subject_chapters']=$data_array;
        $this->data['content']='welcome';
        $this->data['modulepath']=$path;
	$this->load->view('template',$this->data);
    }
    
    
}
?>
