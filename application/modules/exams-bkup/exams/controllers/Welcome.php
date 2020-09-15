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
        $this->load->model('Examcategory_model'); 
                $this->data['qb_package']='';
                $this->data['qb_questions']='';
            
                $this->data['sp_package']='';
                $this->data['sp_questions']='';
    
                $this->data['video_package']='';
                $this->data['videos_questions']='';
   
                $this->data['ot_package']='';
                $this->data['ot_questions']='';
            
                $this->data['stpac_package']='';
                $this->data['stpac_questions']='';  
                
                $this->data['notes_package']='';
                $this->data['notes_questions']='';
                
                $this->data['ns_package']='';
                $this->data['ns_questions']='';    
            
                $this->data['solpap_package']='';
                $this->data['solpap_questions']='';  
        
    }
    public function cron_update_packagecount(){ 
        ini_set('memory_limit', '-1');
    //Start For Question Bank count update
         $qb_packages_count=$this->Videos_model->check_modules_package('','question-bank','cmspackagesall_counter');
        $qb=$this->Questionbank_model->getQuestionBank();
        $qbquestions=$this->Questionbank_model->getQuestionCount();
         $qb_update_array=array(
             'total_package'=>count($qb),
             'total_question'=>count($qbquestions),
             'module_type'=>'question-bank'
         );
         if(count($qb_packages_count)>0){
             //update entry
             $qb_update_id = $qb_packages_count[0]->id;
             $this->Videos_model->update_modules_package($qb_update_id,$qb_update_array,'cmspackagesall_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($qb_update_array,'cmspackagesall_counter');         
         }
         //End For Question Bank count update
    
            //Start For Sample Papers count update
         $sampap_packages_count=$this->Videos_model->check_modules_package('','sample-papers','cmspackagesall_counter');
        $sampap=$this->Samplepapers_model->getSamplePapers();
        $sampapquestions=$this->Samplepapers_model->getQuestionCount();
         $sampap_update_array=array(
             'total_package'=>count($sampap),
             'total_question'=>count($sampapquestions),
             'module_type'=>'sample-papers'
         );
         if(count($sampap_packages_count)>0){
             //update entry
             $sampap_update_id = $sampap_packages_count[0]->id;
             $this->Videos_model->update_modules_package($sampap_update_id,$sampap_update_array,'cmspackagesall_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($sampap_update_array,'cmspackagesall_counter');         
         }
         //End For Sample Papers count update
         
    //Start For Solved Papers count update
         $solpap_packages_count=$this->Videos_model->check_modules_package('','solved-papers','cmspackagesall_counter');
        $solpap=$this->Solvedpapers_model->getSolvedPapers();
        $solpapquestions=$this->Solvedpapers_model->getQuestionCount();
         $solpap_update_array=array(
             'total_package'=>count($solpap),
             'total_question'=>count($solpapquestions),
             'module_type'=>'solved-papers'
         );
         if(count($solpap_packages_count)>0){
             //update entry
             $solpap_update_id = $solpap_packages_count[0]->id;
             $this->Videos_model->update_modules_package($solpap_update_id,$solpap_update_array,'cmspackagesall_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($solpap_update_array,'cmspackagesall_counter');         
         }
         //End For solved Papers count update
    
         //Start For Video count update
         $video_packages_count=$this->Videos_model->check_modules_package('','videos','cmspackagesall_counter');
        $video=$this->Videos_model->getVideos();
        $videoquestions=$this->Videos_model->getVideosCount();
         $video_update_array=array(
             'total_package'=>count($video),
             'total_question'=>count($videoquestions),
             'module_type'=>'videos'
         );
         if(count($video_packages_count)>0){
             //update entry
             $video_update_id = $video_packages_count[0]->id;
             $this->Videos_model->update_modules_package($video_update_id,$video_update_array,'cmspackagesall_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($video_update_array,'cmspackagesall_counter');         
         }
         //End For Video count update
    
    //Start For online Test count update
         $ot_packages_count=$this->Videos_model->check_modules_package('','online-test','cmspackagesall_counter');
        $ot=$this->Onlinetest_model->getOnlineTests();
        $otquestions=$this->Onlinetest_model->getQuestionCount();
         $ot_update_array=array(
             'total_package'=>count($ot),
             'total_question'=>count($otquestions),
             'module_type'=>'online-test'
         );
         if(count($ot_packages_count)>0){
             //update entry
             $ot_update_id = $ot_packages_count[0]->id;
             $this->Videos_model->update_modules_package($ot_update_id,$ot_update_array,'cmspackagesall_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($ot_update_array,'cmspackagesall_counter');         
         }
         //End For Online Test count update
         
         
          //Start For Study Material count update
         $sm_packages_count=$this->Videos_model->check_modules_package('','study-packages','cmspackagesall_counter');
        $sm=$this->Studymaterial_model->getStudyMaterial();
        $smquestions=$this->Studymaterial_model->getStudyMaterialCount();
         $sm_update_array=array(
             'total_package'=>count($sm),
             'total_question'=>count($smquestions),
             'module_type'=>'study-packages'
         );
         if(count($sm_packages_count)>0){
             //update entry
             $sm_update_id = $sm_packages_count[0]->id;
             $this->Videos_model->update_modules_package($sm_update_id,$sm_update_array,'cmspackagesall_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($sm_update_array,'cmspackagesall_counter');         
         }
         //End For Study Material count update
         
    //Start For Notes count update
         $notes_packages_count=$this->Videos_model->check_modules_package('','notes','cmspackagesall_counter');
        $notes=$this->Posting_model->getArticlesForExams();;
        $notesquestions=$this->Posting_model->getQuestionCount();
        $notes_update_array=array(
             'total_package'=>count($notes),
             'total_question'=>count($notesquestions),
             'module_type'=>'notes'
         );
         if(count($notes_packages_count)>0){
             //update entry
             $notes_update_id = $notes_packages_count[0]->id;
             $this->Videos_model->update_modules_package($notes_update_id,$notes_update_array,'cmspackagesall_counter');
         }else{
             //Insert Entry
        $this->Videos_model->insert_modules_package($notes_update_array,'cmspackagesall_counter');         
         }
         //End For Notes count update 
          //Start For NCERT Solutions count update
         $ns_packages_count=$this->Videos_model->check_modules_package('','ncert-solution','cmspackagesall_counter');
        $ns=$this->Ncertsolutions_model->getNcertSolutions();
        $nsquestions=$this->Ncertsolutions_model->getQuestionCount();
         $ns_update_array=array(
             'total_package'=>count($ns),
             'total_question'=>count($nsquestions),
             'module_type'=>'ncert-solution'
         );
         if(count($ns_packages_count)>0){
             //update entry
             $ns_update_id = $ns_packages_count[0]->id;
             $this->Videos_model->update_modules_package($ns_update_id,$ns_update_array,'cmspackagesall_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($ns_update_array,'cmspackagesall_counter');         
         }
         //End For Ncert Solution count update
         
         }
    
    
    public function cron_update_packagecnt_byexamid(){
        
    ini_set('memory_limit', '-1');
    $examid_array = $this->Examcategory_model->getExamCatgeories();
    $type=1;//For study-package
    foreach($examid_array as $examinfo){
        $exam_id=$examinfo->id;
        $exam_name=$examinfo->name;
        if($exam_id>0){
         //Start For Question Bank count update
       $qb_packages_count=$this->Videos_model->check_modules_package($exam_id,'question-bank','cmspackages_counter');
        $qb=$this->Questionbank_model->getQuestionBank($exam_id);
        $qbquestions=$this->Questionbank_model->getQuestionCount($exam_id);
         $qb_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>count($qb),
             'total_question'=>count($qbquestions),
             'module_type'=>'question-bank'
         );
         if(count($qb_packages_count)>0){
             //update entry
             $qb_update_id = $qb_packages_count[0]->id;
             $this->Videos_model->update_modules_package($qb_update_id,$qb_update_array,'cmspackages_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($qb_update_array,'cmspackages_counter');         
         }         
         //End For Question Bank count update
         
            //Start For Sample Papers count update
         $sampap_packages_count=$this->Videos_model->check_modules_package($exam_id,'sample-papers','cmspackages_counter');
        $sampap=$this->Samplepapers_model->getSamplePapers($exam_id);
        $sampapquestions=$this->Samplepapers_model->getQuestionCount($exam_id);
         $sampap_update_array=array(  
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>count($sampap),
             'total_question'=>count($sampapquestions),
             'module_type'=>'sample-papers'
         );
         if(count($sampap_packages_count)>0){
             //update entry
             $sampap_update_id = $sampap_packages_count[0]->id;
             $this->Videos_model->update_modules_package($sampap_update_id,$sampap_update_array,'cmspackages_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($sampap_update_array,'cmspackages_counter');         
         }
         //End For Sample Papers count update
         
    //Start For Solved Papers count update
         $solpap_packages_count=$this->Videos_model->check_modules_package($exam_id,'solved-papers','cmspackages_counter');
        $solpap=$this->Solvedpapers_model->getSolvedPapers($exam_id);
        $solpapquestions=$this->Solvedpapers_model->getQuestionCount($exam_id);
         $solpap_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>count($solpap),
             'total_question'=>count($solpapquestions),
             'module_type'=>'solved-papers'
         );
         if(count($solpap_packages_count)>0){
             //update entry
             $solpap_update_id = $solpap_packages_count[0]->id;
             $this->Videos_model->update_modules_package($solpap_update_id,$solpap_update_array,'cmspackages_counter');
         }else{
             //Insert Entry
        $this->Videos_model->insert_modules_package($solpap_update_array,'cmspackages_counter');         
         }
         //End For solved Papers count update
         //Start For Video count update
         $video_packages_count=$this->Videos_model->check_modules_package($exam_id,'videos','cmspackages_counter');
        $video=$this->Videos_model->getVideos($exam_id);
        $videoquestions=$this->Videos_model->getVideosCount($exam_id);
         $video_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>count($video),
             'total_question'=>count($videoquestions),
             'module_type'=>'videos'
         );
         if(count($video_packages_count)>0){
             //update entry
             $video_update_id = $video_packages_count[0]->id;
             $this->Videos_model->update_modules_package($video_update_id,$video_update_array,'cmspackages_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($video_update_array,'cmspackages_counter');         
         }
         //End For Video count update
    
    //Start For online Test count update
         $ot_packages_count=$this->Videos_model->check_modules_package($exam_id,'online-test','cmspackages_counter');
        $ot=$this->Onlinetest_model->getOnlineTests($exam_id);
        $otquestions=$this->Onlinetest_model->getQuestionCount($exam_id);
         $ot_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>count($ot),
             'total_question'=>count($otquestions),
             'module_type'=>'online-test'
         );
         if(count($ot_packages_count)>0){
             //update entry
             $ot_update_id = $ot_packages_count[0]->id;
             $this->Videos_model->update_modules_package($ot_update_id,$ot_update_array,'cmspackages_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($ot_update_array,'cmspackages_counter');         
         }
         //End For Online Test count update         
         
          //Start For Study Material count update
         $sm_packages_count=$this->Videos_model->check_modules_package($exam_id,'study-packages','cmspackages_counter');
        $sm=$this->Studymaterial_model->getStudyMaterial($exam_id);
        $smquestions=$this->Studymaterial_model->getStudyMaterialCount($exam_id);
         $sm_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>count($sm),
             'total_question'=>count($smquestions),
             'module_type'=>'study-packages'
         );
         if(count($sm_packages_count)>0){
             //update entry
             $sm_update_id = $sm_packages_count[0]->id;
             $this->Videos_model->update_modules_package($sm_update_id,$sm_update_array,'cmspackages_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($sm_update_array,'cmspackages_counter');         
         }
         //Update product pricelist table
         if($exam_id>0){
            
        $product_info = $this->Pricelist_model->get($type,$exam_id); 
        
           $content_price_total=$this->Pricelist_model->getSum_mainprice($type,$exam_id,0,0);   
            $package_total=0;
            //$response['total']=$content_price_total->total;
            foreach($content_price_total as $num){
                 $package_total +=$num->total;
            }
            
            $data_array= array(
                'price'=>$package_total,
                'no_of_lectures'=>count($sm)
            );
            if(isset($product_info->id)&&$product_info->id>0){
        $this->Pricelist_model->update($product_info->id,$data_array);
            }
            // Update Subject product price
            $content_subject_price = $this->Pricelist_model->getsubject_product($type,$exam_id);            
            
            if(isset($content_subject_price->subject_id)&&$content_subject_price->subject_id>0){
                $subject_id=$content_subject_price->subject_id;
            $sm_subject=$this->Studymaterial_model->getStudyMaterial($exam_id,$subject_id);       
        $subject_product_info = $this->Pricelist_model->get($type,$exam_id,$subject_id); 
        
           $subject_price_total=$this->Pricelist_model->getSum_mainprice($type,$exam_id,$subject_id,0);   
            $subject_package_total=0;
            //$response['total']=$content_price_total->total;
            foreach($subject_price_total as $num){
                 $subject_package_total +=$num->total;
            }
            
            $subject_data_array= array(
                'price'=>$subject_package_total,
                'no_of_lectures'=>count($sm_subject)
            );
            
           if(isset($subject_product_info->id)&&$subject_product_info->id>0){
        $this->Pricelist_model->update($subject_product_info->id,$subject_data_array);
            }
             } 
          
         }
//End For Study Material count update
   
    //Start For Notes count update
         $notes_packages_count=$this->Videos_model->check_modules_package($exam_id,'notes','cmspackages_counter');
        $notes=$this->Posting_model->getArticlesForExams($exam_id);
        $notesquestions=$this->Posting_model->getQuestionCount($exam_id);
        $notes_update_array=array(
            'exam_id'=>$exam_id,
            'exam_name'=>$exam_name,
            'total_package'=>count($notes),
            'total_question'=>count($notesquestions),
            'module_type'=>'notes'
         );
         if(count($notes_packages_count)>0){
             //update entry
             $notes_update_id = $notes_packages_count[0]->id;
             $this->Videos_model->update_modules_package($notes_update_id,$notes_update_array,'cmspackages_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($notes_update_array,'cmspackages_counter');         
         }
         //End For Notes count update 
          //Start For NCERT Solutions count update
         $ns_packages_count=$this->Videos_model->check_modules_package($exam_id,'ncert-solution','cmspackages_counter');
        $ns=$this->Ncertsolutions_model->getNcertSolutions($exam_id);
        $nsquestions=$this->Ncertsolutions_model->getQuestionCount($exam_id);
         $ns_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>count($ns),
             'total_question'=>count($nsquestions),
             'module_type'=>'ncert-solution'
         );
         if(count($ns_packages_count)>0){
             //update entry
             $ns_update_id = $ns_packages_count[0]->id;
             $this->Videos_model->update_modules_package($ns_update_id,$ns_update_array,'cmspackages_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($ns_update_array,'cmspackages_counter');         
         }
         //End For Ncert Solution count update
        }
        
        
    }    
   
    }
    
    
    public function index(){       
        
        $this->data['path']='';
        $qb=$this->Questionbank_model->getQuestionBank();
        $this->data['qb']=$qb;
       
        // Get Sample papers for class
        $sp=$this->Samplepapers_model->getSamplePapers();
        $this->data['sp']=$sp;
        
        //$qbquestions=$this->Questionbank_model->getQuestionCount();
        $this->data['qbquestions']='108759';
        
        //$spquestions=$this->Samplepapers_model->getQuestionCount();
        $this->data['spquestions']='2021';
        
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
        //$ar=$this->Posting_model->getArticlesForExams();
        //Check it properly
        $ar=array();
        $this->data['ar']=$ar;
        
        // GET Ncert Solutions
        $ncert=$this->Ncertsolutions_model->getNcertSolutions();
        $this->data['ncert']=$ncert;
        
        //$videos=$this->Videos_model->getVideosCount();
        $this->data['videos']='8074';
        
        //$test=$this->Onlinetest_model->getQuestionCount();
        $this->data['tests']='234';
        
        //$material=$this->Studymaterial_model->getStudyMaterialCount();
        $this->data['material']='2028';
        
        //$ncertq=$this->Ncertsolutions_model->getQuestionCount();
        $this->data['ncertquestion']='573'; 
        
        //$solvedq=$this->Solvedpapers_model->getQuestionCount();
        $this->data['solvedquestions']='363968';         
        
        $all_packages=$this->Videos_model->get_modules_package();
                
      
        foreach($all_packages as $package){
            if($package->module_type=='question-bank'){
                $this->data['qb_package']=$package->total_package;
                $this->data['qb_questions']=$package->total_question;
            }
            
            if($package->module_type=='sample-papers'){
                $this->data['sp_package']=$package->total_package;
                $this->data['sp_questions']=$package->total_question;
            }
            
            if($package->module_type=='videos'){
                $this->data['video_package']=$package->total_package;
                $this->data['videos_questions']=$package->total_question;
            }
            if($package->module_type=='online-test'){
                $this->data['ot_package']=$package->total_package;
                $this->data['ot_questions']=$package->total_question;
            }
            if($package->module_type=='study-packages'){
                $this->data['stpac_package']=$package->total_package;
                $this->data['stpac_questions']=$package->total_question;
            }
            if($package->module_type=='notes'){
              $this->data['notes_package']=$package->total_package;
              $this->data['notes_questions']=$package->total_question;   
            }
            
            if($package->module_type=='ncert-solution'){
             $this->data['ns_package']=$package->total_package;
             $this->data['ns_questions']=$package->total_question;     
            }
            
            if($package->module_type=='solved-papers'){
              $this->data['solpap_package']=$package->total_package;
             $this->data['solpap_questions']=$package->total_question;  
            }
            
        }
        
        $this->data['isProduct'] = '';
        $this->data['isProduct_array'] = '';
        
        $this->data['content']='welcome';  
          
	$this->load->view('template',$this->data);
    }
    public function main($examname,$examid,$subjectname=null,$subject_id=0,$chapter_name=null,$chapter_id=0){
        
        
        
         $isProduct_array=array();
        $testseries_Product = $this->Pricelist_model->getProduct($examid, $subject_id, $chapter_id, 3);
        
       if(count($testseries_Product)>0){
                   $isProduct_array[]= $testseries_Product;
       }
        $this->data['isProduct_array'] = $isProduct_array;
        
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
         if(isset($purchsed_products)){
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
        }}
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
          }
        $this->data['pproducts']=$marray;  
        
        
        
        
        //Check Exam Id is a product or not
        $final_product_id = $this->Pricelist_model->checkExamProduct($examid);
         
        $final_subject_product_id = $this->Pricelist_model->checkSubjectProduct($examid,$subject_id);
        $final_product_details = $this->Pricelist_model->checkExamProduct_detail($examid);
        $final_subject_product_details = $this->Pricelist_model->checkSubjectProduct_detail($examid,$subject_id);
        
        //echo $final_product_id .'-=--=-='.$final_subject_product_id;
         
         if($final_subject_product_id>0){
         $this->data['isSubjectProductBrought']=$final_subject_product_id;
         }else{
          $this->data['isSubjectProductBrought']=0;   
         }        
         if($final_product_id>0){
         $this->data['isMainProductBrought']=$final_product_id;
         }else{
          $this->data['isMainProductBrought']=0;   
         }
         if (!$this->session->userdata('purchases') || !in_array_r($final_product_id, $this->session->userdata('purchases'))) {
             //echo "not brought";
         }else{
             
             //$purchased[1][]=$final_subject_product_id;
             
             if($final_product_details->exam_id==$examid){
                 $this->session->set_userdata('sub_purchases','yes');
             }
             
               $purchased_material=$this->session->userdata('purchases');               
               array_push($purchased_material[1],$final_subject_product_id);
               $this->session->unset_userdata('purchases');
                 $this->session->set_userdata('purchases',$purchased_material);               
        }
                
        if(!$this->session->userdata('purchases') || !in_array_r($final_subject_product_id, $this->session->userdata('purchases'))) {
             //echo "not Subject brought";
         }else{
             if($final_subject_product_details->subject_id==$subject_id){
                 $this->session->set_userdata('sub_purchases','yes');
             }
         }   
         
        //$qbquestions=$this->Questionbank_model->getQuestionCount($examid,$subject_id,$chapter_id);
        $this->data['qbquestions']='31039';
        
       // $spquestions=$this->Samplepapers_model->getQuestionCount($examid,$subject_id,$chapter_id);
        $this->data['spquestions']='635';
        
        //$solvedquestions=$this->Solvedpapers_model->getQuestionCount($examid,$subject_id,$chapter_id);
        $this->data['solvedquestions']='314263';
        
        //$videos=$this->Videos_model->getVideosCount($examid,$subject_id,$chapter_id);
        $this->data['videos']='2875';
        
        //$test=$this->Onlinetest_model->getQuestionCount($examid,$subject_id,$chapter_id);
        $this->data['tests']='235';
        
        //$material=$this->Studymaterial_model->getStudyMaterialCount($examid,$subject_id,$chapter_id);
        $this->data['material']='689';
        
       // $ncertq=$this->Ncertsolutions_model->getQuestionCount($examid,$subject_id,$chapter_id);
        $this->data['ncertquestion']='4965';  
        
        /* Get question count information */
        
        if($examid>0&&$subject_id>0){ 
            $all_packages=array();
        }else{
        
        $all_packages=$this->Videos_model->get_modules_package($examid);
        }
        foreach($all_packages as $package){
            if($package->module_type=='question-bank'){
                $this->data['qb_package']=$package->total_package;
                $this->data['qb_questions']=$package->total_question;
            }
            
            if($package->module_type=='sample-papers'){
                $this->data['sp_package']=$package->total_package;
                $this->data['sp_questions']=$package->total_question;
            }
            
            if($package->module_type=='videos'){
                $this->data['video_package']=$package->total_package;
                $this->data['videos_questions']=$package->total_question;
            }
            if($package->module_type=='online-test'){
                $this->data['ot_package']=$package->total_package;
                $this->data['ot_questions']=$package->total_question;
            }
            if($package->module_type=='study-packages'){
                $getProduct_id = $this->Pricelist_model->getProduct_id($examid, $subject_id, $chapter_id, 1);
                if($getProduct_id){
                    //Update Product count
                if(isset($getProduct_id->id)&&($getProduct_id->id>0)){
                  if($examid>0&&($subject_id<1||$subject_id=='')){  
             $dataarray=array('no_of_lectures'=>$package->total_package);
                    $this->Pricelist_model->update_packageCount($getProduct_id->id,$dataarray);
                  }
                  
                  if($examid>0&&$subject_id>0&&($chapter_id<1||$chapter_id=='')){  
             $dataarray=array('no_of_lectures'=>count($sm));
                    $this->Pricelist_model->update_packageCount($getProduct_id->id,$dataarray);
                  }
                    
                }
                    
                }
                       if($examid>0&&$subject_id>0&&($chapter_id<1||$chapter_id=='')){                 
                           $this->data['stpac_package']=count($sm);
                       
                       }else{  
                           $this->data['stpac_package']=$package->total_package;
                       }
                $this->data['stpac_questions']=$package->total_question;
            }
            if($package->module_type=='notes'){
              $this->data['notes_package']=$package->total_package;
              $this->data['notes_questions']=$package->total_question;   
            }
            
            if($package->module_type=='ncert-solution'){
             $this->data['ns_package']=$package->total_package;
             $this->data['ns_questions']=$package->total_question;     
            }
            
            if($package->module_type=='solved-papers'){
              $this->data['solpap_package']=$package->total_package;
             $this->data['solpap_questions']=$package->total_question;  
            }
            
        }        
        $isProduct=array();
        $isProduct = $this->Pricelist_model->getProduct($examid, $subject_id, $chapter_id, 1);
       
        if(count($isProduct)>0){
        $this->data['isProduct'] = $isProduct;
        }else{
            $this->data['isProduct'] = '';
        }
        
        $this->data['path']=$path;
        $this->data['subject_chapters']=$data_array;
        $this->data['content']='welcome';
        $this->data['modulepath']=$path;
	$this->load->view('template',$this->data);
    }
    
    
}
?>
