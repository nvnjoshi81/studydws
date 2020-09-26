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
        $this->load->model('History_model');
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
        $ar=$this->Posting_model->getArticlesForExams();
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
		$all_packages=array();
		if(count($all_packages)>0){
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
        
	} $this->data['isProduct'] = '';
        $this->data['isProduct_array'] = '';
        
        $this->data['content']='welcome';  
          
	$this->load->view('template',$this->data);
    }
	
	/*for subject and chapters*/
    public function main($examname,$examid,$subjectname=null,$subject_id=0,$chapter_name=null,$chapter_id=0){
        
        $urlChapter_name=NULL;
         $isProduct_array=array();
        $testseries_Product = $this->Pricelist_model->getProduct($examid, $subject_id, $chapter_id, 3);
        $all_packages=array();
       if(count($all_packages)>0){
                   $isProduct_array[]= $testseries_Product;
       }
        $this->data['isProduct_array'] = $isProduct_array;
        
        $data_array=array();
        $exam=  $this->Categories_model->getCategoryDetails($examid);
        $titleStr[]=addSuffix($exam->name,'Class');
        $this->data['selectedexam']=$exam;
        $path=$examname.'/'.$examid;   
		$this->load->model('Subjects_model');
		$this->data['allsubject']=$this->Subjects_model->getSubjects();
		
        if($subject_id > 0){
         
            $this->data['selectedsubject']=$this->Subjects_model->getSubject($subject_id);
            $path.='/'.$subjectname.'/'.$subject_id;
            $titleStr[]=$this->data['selectedsubject']->name;
        }
        if($chapter_id > 0){
            $this->load->model('Chapters_model');
            $this->data['selectedchapter']=$this->Chapters_model->getChapter($chapter_id);
            $path.='/'.$chapter_name.'/'.$chapter_id;
            $titleStr[]=$this->data['selectedchapter']->name;
            $urlChapter_name=$this->data['selectedchapter']->name;
        }
        $subjects_array = array();
        $chapters_array = array();
        $chaptersubjects=  $this->Examcategory_model->getExamChapters($examid); 
        if(count($chaptersubjects) > 0){
            foreach($chaptersubjects as $record){
				if (!in_array($record->sname, $subjects_array)) {
                        $subjects_array[$record->sid] = array('name' => $record->sname);
                    }
                        $sm = $this->Studymaterial_model->getStudyMaterialCount($examid, $record->sid, $record->cid);
						// print_r(count($sm));
						 $videos = $this->Videos_model->getVideosCount($exam_id, $record->sid, $record->cid);
						$samplepap=$this->Samplepapers_model->getQuestionCount($examid, $record->sid, $record->cid);
						$onlinetest=$this->Onlinetest_model->getQuestionCount($examid, $record->sid, $record->cid);
						$questionbank=$this->Questionbank_model->getQuestionCount($examid, $record->sid, $record->cid);
						$ncertSol=$this->Ncertsolutions_model->getQuestionCount($examid, $record->sid, $record->cid);
						$solvedpap=$this->Solvedpapers_model->getQuestionCount($examid, $record->sid, $record->cid);
						$notesposting=$this->Posting_model->getQuestionCount($examid, $record->sid, $record->cid);
						
$chkcount=0;
if(count($sm)>0){
$chkcount=$chkcount+1;
}elseif(count($videos)>0){

$chkcount=$chkcount+1; 
}elseif(count($samplepap)>0){
$chkcount=$chkcount+1;
}elseif(count($onlinetest)>0){
$chkcount=$chkcount+1;
}elseif(count($questionbank)>0){
$chkcount=$chkcount+1;
}elseif(count($ncertSol)>0){
$chkcount=$chkcount+1;
}elseif(count($solvedpap)>0){
$chkcount=$chkcount+1;
}elseif(count($notesposting)>0){
$chkcount=$chkcount+1;
}							
                    if ($subject_id > 0 && $subject_id == $record->sid) {
                        if (!in_array($record->cname, $chapters_array)) {
                        $chapters_array[$record->cid] = array('name' => $record->cname, 'count' => $chkcount);
                        } else {
                        $chapters_array[$record->cid]['count'] = $chkcount;
                        }
                    }
				if(array_key_exists($record->sname, $data_array)){
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
		?>
		
		<?php 
        $this->data['subject_chapters']=$data_array;
		 if (count($subjects_array) > 0) {
                foreach ($subjects_array as $key => $value) {
                    $sm = $this->Studymaterial_model->getStudyMaterialCount($examid, $key, 0);
                    $subjects_array[$key]['count'] = count($sm);
                }
            }
           // echo "<pre>";
            //print_r($chapters_array);
            //echo "<pre>";
            $this->data['subjects_array'] = $subjects_array;

            $this->data['chapters_array'] = $chapters_array;

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
        $ot=$this->Onlinetest_model->getOnlineTests($examid,$subject_id,$chapter_id);
        $this->data['ot']=$ot;         
        // GET StudyMaterial
        $sm=$this->Studymaterial_model->getStudyMaterial($examid,$subject_id,$chapter_id);
        $this->data['sm']=$sm;
        
        // GET Articles
        $ar=$this->Posting_model->getArticlesForExams($examid,$subject_id,$chapter_id);
        $this->data['ar']=$ar;
        
        // GET Ncert Solutions
        $ncert=$this->Ncertsolutions_model->getNcertSolutions($examid,$subject_id,$chapter_id);
        $this->data['ncert']=$ncert;
        //Commented As we want product on current class and  subject basis     
        //$filelist=$this->Studymaterial_model->getFilesProducts($examid,$subject_id,$chapter_id);
        $limitforblock=18;
  if($chapter_id>0){
         $filelist=$this->Studymaterial_model->getFilesbylevel($examid,$subject_id,$chapter_id);
  }else{
         $filelist=$this->Studymaterial_model->getFilesbylevel($examid,$subject_id,$chapter_id,$limitforblock);
  }
        //Commented As we want product on current class subject basis     
        //$videolist=$this->Products_model->getVideos($examid,$subject_id,$chapter_id);
        
        $videolist=$this->Products_model->getVideosByLevel($examid,$subject_id,$chapter_id);
        //print_r($filelist);exit;
        /*If class and subject wise videos are not available show recent */
        if(isset($filelist)&&count($filelist)>0){
        $this->data['productslist']=$filelist;
        }else{
        $filelist=$this->Studymaterial_model->getFilesProducts($examid,$subject_id,$chapter_id,$limitforblock);
            $this->data['productslist']=$filelist;
        }
        $historyArray=array();
        foreach($filelist as $fd){
            $file_id=$fd->file_id;
            $customer_id=$this->session->userdata('customer_id');
            $historyArray[$file_id]=$this->History_model->getDownloadHistory($customer_id,$file_id,$type=2);
        }
        $this->data['downloadHistory']=$historyArray;
        if(isset($videolist)&&count($videolist)>0){
         $this->data['videoproductslist']=$videolist; 
        }else{
            $videolist=$this->Products_model->getVideos($examid,$subject_id,$chapter_id);
            $this->data['videoproductslist']=$videolist; 
        }
        //Display Both product sapartlly $videolist
        $this->data['productslist']=array_merge(array(),$filelist);
        //For Question Bank
        $questionbanks=$this->Questionbank_model->getQuestionBank($examid,$subject_id,$chapter_id,$limitforblock);
        $this->data['module_name']='question-bank';
        $this->data['questionbanks']=$questionbanks;  
        
        //For Notes
        $notesdata = $this->Posting_model->getNotesList($examid, $subject_id,$chapter_id,'',$limitforblock);
        $notesdata2 = $this->Posting_model->getNotesList2($examid, $subject_id,$chapter_id,'',$limitforblock);
        $this->data['module_notes_name']='notes';
      
        if(count($notesdata2)>0){
        $this->data['notes']=$notesdata2;
        }else{
        $this->data['notes']=$notesdata;
        }

        
        // Deepak check products bought
        $this->data['isMainProductBrought']=false;
        $this->data['isSubjectProductBrought']=false;
        $this->data['isChapterProductBrought']=false;
        $allexpr=array();
		$allsubpr=array();$allchpr=array();
        $boughtproducts=array();
        if($this->session->userdata('customer_id')){
        $purchsed_products = $this->session->userdata('purchases'); 
         if(isset($purchsed_products)){
            foreach($purchsed_products as $key=>$value){
                foreach ($value as $k1 => $v1) {
                    $prdetails=$this->Pricelist_model->getDetails($v1);
                    if($prdetails->type==1){
                       
                    if($prdetails->item_id==0){
                        if($prdetails->exam_id > 0 && $prdetails->subject_id ==0 && $prdetails->chapter_id ==0){
                           

                               $allexpr[]=$this->Pricelist_model->getAllProducts($prdetails->exam_id,0,0,1);
                            
                        }elseif($prdetails->exam_id > 0 && $prdetails->subject_id  > 0 && $prdetails->chapter_id ==0){
                           

                                $allsubpr[]=$this->Pricelist_model->getAllProducts($prdetails->exam_id,$prdetails->subject_id,0,1);
   
                        }elseif($prdetails->exam_id > 0 && $prdetails->subject_id > 0 && $prdetails->chapter_id > 0){
                           

                                $allchpr[]=$this->Pricelist_model->getAllProducts($prdetails->exam_id,$prdetails->subject_id,$prdetails->chapter_id,1);
                           
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
             if(isset($final_subject_product_details->subject_id)&&$final_subject_product_details->subject_id==$subject_id){
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
        if($chapter_id>0){ 
        $all_packages=array();
        }else{
       $all_packages=$this->Videos_model->get_modules_package($examid,$subject_id); 
	   //$all_packages=array();
        }
		
		   if($this->session->userdata('customer_id')=='71696'){
           //print_r($all_packages);
        }
        foreach($all_packages as $package){
            if($package->module_type=='question-bank'){
                $this->data['qb_package']=$package->custom_total_package;
                $this->data['qb_questions']=$package->custom_total_question;
            }
            if($package->module_type=='sample-papers'){
                $this->data['sp_package']=$package->custom_total_package;
                $this->data['sp_questions']=$package->custom_total_question;
            }
            
            if($package->module_type=='videos'){
                $this->data['video_package']=$package->custom_total_package;
                $this->data['videos_questions']=$package->custom_total_question;
            }
            if($package->module_type=='online-test'){
                $this->data['ot_package']=$package->custom_total_package;
                $this->data['ot_questions']=$package->custom_total_question;
            }
            if($package->module_type=='study-packages'){
                $getProduct_id = $this->Pricelist_model->getProduct_id($examid, $subject_id, $chapter_id, 1);
                if($getProduct_id){
                    //Update Product count
                if(isset($getProduct_id->id)&&($getProduct_id->id>0)){
                  if($examid>0&&($subject_id<1||$subject_id=='')){  
             $dataarray=array('no_of_lectures'=>$package->custom_total_package);
                    //$this->Pricelist_model->update_packageCount($getProduct_id->id,$dataarray);
                  }
                  
                  if($examid>0&&$subject_id>0&&($chapter_id<1||$chapter_id=='')){  
             $dataarray=array('no_of_lectures'=>count($sm));
                    //$this->Pricelist_model->update_packageCount($getProduct_id->id,$dataarray);
                  }
                    
                }
                    
                }				
                /*
                       if($examid>0&&$subject_id>0&&($chapter_id<1||$chapter_id=='')){                 
                           $this->data['stpac_package']=count($sm);
                       
                       }else{  
                           $this->data['stpac_package']=$package->total_package;
                       }
                 *  */
                $this->data['stpac_package']=$package->custom_total_package;       
                $this->data['stpac_questions']=$package->custom_total_question;
            }
            if($package->module_type=='notes'){
              $this->data['notes_package']=$package->custom_total_package;
              $this->data['notes_questions']=$package->custom_total_question;   
            }
            
            if($package->module_type=='ncert-solution'){
             $this->data['ns_package']=$package->custom_total_package;
             $this->data['ns_questions']=$package->custom_total_question;     
            }
            
            if($package->module_type=='solved-papers'){
              $this->data['solpap_package']=$package->custom_total_package;
             $this->data['solpap_questions']=$package->custom_total_question;  
            }			
          
        }   
        //Get statistics on subject bassis for all module.
        $subjectArray_package=array();
        foreach ($data_array as $sublist_key => $sublist_value) {
        if(count($data_array[$sublist_key]) > 0) {
        $md_subject_id=$sublist_value['id'];
        $packagesFor_subject=$this->Videos_model->get_modules_package($examid,$md_subject_id);  
        $subjectArray_package[$md_subject_id]=$packagesFor_subject;                    
                                                      }
                                                   }
        $this->data['subjectArray_package']=$subjectArray_package; 
        $isProduct=array();
        //$subject_id, $chapter_id is sety to zero
        $isProduct = $this->Pricelist_model->getProduct($examid, 0, 0, 1);
        $examPlaylist = $this->Videos_model->getVideos($examid, $subject_id, $chapter_id,18);
       //Get package count
	   
       $packagecnt = $this->Pricelist_model->pkgCount_byExam($examid);
		$packagecnt_array[$examid]= $packagecnt;
		$this->data['packagecnt_array']=$packagecnt_array;
		
        $this->data['examPlaylist']=$examPlaylist;
            //Get video name for playlist in case of chapter
        if($chapter_id > 0){
            $videolist=NULL;
            foreach($examPlaylist as $playlist_array){
            $playlistid=$playlist_array->id;
          $videolist = $this->Videos_model->getVideosList($playlistid);
            $this->data['videolist']=$videolist;
            $this->data['v_relations_id']=$playlist_array->v_relations_id;
        }
        }
        if(count($isProduct)>0){
        $this->data['isProduct'] = $isProduct;
        $product_id=$isProduct->id;
        $user_id=$customer_id=$this->session->userdata('customer_id');
        $orderInfo=$this->Pricelist_model->getOrderInfo($product_id, $user_id);        
        $this->data['orderInfo'] = $orderInfo;
        }else{
        $this->data['isProduct'] = '';
        }
		
        $this->data['subject_id'] = $subject_id;
        $this->data['examid'] = $examid;
        $this->data['urlChapter_name']=$urlChapter_name;
        $this->data['path']=$path;
        $this->data['content']='welcome';
        $this->data['modulepath']=$path;
	$this->load->view('template',$this->data);
    }
     
    public function cron_update_packagecount(){ 
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        //echo ini_get('memory_limit'); die;
    //Start For Question Bank count update
         $qb_packages_count=$this->Videos_model->check_modules_package('','','question-bank','cmspackagesall_counter','root');
        $qb=$this->Questionbank_model->getQuestionBank();   
        $qbquestions=$this->Questionbank_model->getQuestionCount();
         $qb_update_array=array(
             'total_package'=>count($qb),
             'total_question'=>count($qbquestions),
             'module_type'=>'question-bank',
             'level'=>'root'
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
        echo "Question Bank saved!<br>";
        //Start For Sample Papers count update
         $sampap_packages_count=$this->Videos_model->check_modules_package('','','sample-papers','cmspackagesall_counter','root');
        $sampap=$this->Samplepapers_model->getSamplePapers();
        $sampapquestions=$this->Samplepapers_model->getQuestionCount();
         $sampap_update_array=array(
             'total_package'=>count($sampap),
             'total_question'=>count($sampapquestions),
             'module_type'=>'sample-papers',
             'level'=>'root'
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
         
        echo "Sample paper saved!<br>";
    //Start For Solved Papers count update
         $solpap_packages_count=$this->Videos_model->check_modules_package('','','solved-papers','cmspackagesall_counter','root');
        $solpap=$this->Solvedpapers_model->getSolvedPapers();
        //$solpapquestions=$this->Solvedpapers_model->getQuestionCount();             
        $solpapquestions=$this->Solvedpapers_model->getCronQCount();        
        if(isset($solpapquestions[0]->qcount)){
        $solpap_qcount=$solpapquestions[0]->qcount;
        }else{
        $solpap_qcount=0;  
        }
         $solpap_update_array=array(
             'total_package'=>count($solpap),
             'total_question'=>$solpap_qcount,
             'module_type'=>'solved-papers',
             'level'=>'root'
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
    
        echo "solved Paper saved!<br>";
         //Start For Video count update
         $video_packages_count=$this->Videos_model->check_modules_package('','','videos','cmspackagesall_counter','root');
        $video=$this->Videos_model->getVideos();
        $videoquestions=$this->Videos_model->getVideosCount();
         $video_update_array=array(
             'total_package'=>count($video),
             'total_question'=>count($videoquestions),
             'module_type'=>'videos',
             'level'=>'root'
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
    
        echo "Video saved!<br>";
    //Start For online Test count update
         $ot_packages_count=$this->Videos_model->check_modules_package('','','online-test','cmspackagesall_counter','root');
        $ot=$this->Onlinetest_model->getOnlineTests();
        $otquestions=$this->Onlinetest_model->getQuestionCount();
         $ot_update_array=array(
             'total_package'=>count($ot),
             'total_question'=>count($otquestions),
             'module_type'=>'online-test',
             'level'=>'root'
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
         
         
        echo "online test saved..!<br>";
          //Start For Study Material count update
         $sm_packages_count=$this->Videos_model->check_modules_package('','','study-packages','cmspackagesall_counter','root');
        $sm=$this->Studymaterial_model->getCronSM();
       $smpackage_count=$sm[0]->package_count;
        $smquestions=$this->Studymaterial_model->getCronSmCount();
       $sm_qcount = $smquestions[0]->qcount;
         $sm_update_array=array(
             'total_package'=>$smpackage_count,
             'total_question'=>$sm_qcount,
             'module_type'=>'study-packages',
             'level'=>'root'
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
         
        echo "stydymaterial saved!<br>";
    //Start For Notes count update
         $notes_packages_count=$this->Videos_model->check_modules_package('','','notes','cmspackagesall_counter','root');
        //$notes=$this->Posting_model->getArticlesForExams();;
       // $notesquestions=$this->Posting_model->getQuestionCount();       
        
        $notes=$this->Posting_model->getCronArForExams();
        $notes_package_count=$notes[0]->package_count;
        $notesquestions=$this->Posting_model->getCronQuestionCount();
        $notesq_counts=$notesquestions[0]->q_count;
        $notes_update_array=array(
             'total_package'=>$notes_package_count,
             'total_question'=>$notesq_counts,
             'module_type'=>'notes',
             'level'=>'root'
         );
         if(count($notes_packages_count)>0){
             //update entry
             $notes_update_id = $notes_packages_count[0]->id;
             $this->Videos_model->update_modules_package($notes_update_id,$notes_update_array,'cmspackagesall_counter');
         }else{
             //Insert Entry
        $this->Videos_model->insert_modules_package($notes_update_array,'cmspackagesall_counter');         
         }
         
        echo "Notes saved!<br>";
         //End For Notes count update 
          //Start For NCERT Solutions count update
         $ns_packages_count=$this->Videos_model->check_modules_package('','','ncert-solution','cmspackagesall_counter','root');
        //$ns=$this->Ncertsolutions_model->getNcertSolutions();
       // $nsquestions=$this->Ncertsolutions_model->getQuestionCount();
         
         $ns=$this->Ncertsolutions_model->getCronNS();
         $ns_count=$ns[0]->package_count;
         $nsquestions=$this->Ncertsolutions_model->getCronQuestionCount();
         $ns_q_count=$nsquestions[0]->q_count;
         
         $ns_update_array=array(
             'total_package'=>$ns_count,
             'total_question'=>$ns_q_count,
             'module_type'=>'ncert-solution',
             'level'=>'root'
         );
         if(count($ns_packages_count)>0){
             //update entry
             $ns_update_id = $ns_packages_count[0]->id;
             $this->Videos_model->update_modules_package($ns_update_id,$ns_update_array,'cmspackagesall_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($ns_update_array,'cmspackagesall_counter');         
         }
         
        echo "NCERT saved!<br>";
         //End For Ncert Solution count update
         
        echo "All record saved!";
         }
    
    public function cron_update_packagecnt_byexamid(){
        
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    $examid_array = $this->Examcategory_model->getExamCatgeories();
    $type=1;//For study-package
    echo "Total Exam -".count($examid_array)."<br><brgetCronQCount>";
    
    foreach($examid_array as $examinfo){
        $exam_id=$examinfo->id;
        $exam_name=$examinfo->name;
        
        echo "<br><br>For Exam Id - ".$exam_id."<br><br>";
        if($exam_id>0){
         //Start For Question Bank count update
       $qb_packages_count=$this->Videos_model->check_modules_package($exam_id,'','question-bank','cmspackages_counter','exam');
        $qb=$this->Questionbank_model->getQuestionBank($exam_id);
        $qbquestions=$this->Questionbank_model->getQuestionCount($exam_id);
         $qb_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>count($qb),
             'total_question'=>count($qbquestions),
             'module_type'=>'question-bank',
             'level'=>'exam'
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
           echo "Question Bank saved!<br>";
            //Start For Sample Papers count update
         $sampap_packages_count=$this->Videos_model->check_modules_package($exam_id,'','sample-papers','cmspackages_counter','exam');
        $sampap=$this->Samplepapers_model->getSamplePapers($exam_id);
        $sampapquestions=$this->Samplepapers_model->getQuestionCount($exam_id);
         $sampap_update_array=array(  
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>count($sampap),
             'total_question'=>count($sampapquestions),
             'module_type'=>'sample-papers',
             'level'=>'exam'
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
           echo "Sample paper saved!<br>";
    //Start For Solved Papers count update
         $solpap_packages_count=$this->Videos_model->check_modules_package($exam_id,'','solved-papers','cmspackages_counter','exam');
        $solpap=$this->Solvedpapers_model->getSolvedPapers($exam_id);        
        $solpapquestions=$this->Solvedpapers_model->getCronQCount($exam_id);        
        if(isset($solpapquestions[0]->qcount)){
        $solpap_qcount=$solpapquestions[0]->qcount;
        }else{
            $solpap_qcount=0;
        }
         $solpap_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>count($solpap),
             'total_question'=>$solpap_qcount,
             'module_type'=>'solved-papers',
             'level'=>'exam'
         );
         if(count($solpap_packages_count)>0){
             //update entry
             $solpap_update_id = $solpap_packages_count[0]->id;
             $this->Videos_model->update_modules_package($solpap_update_id,$solpap_update_array,'cmspackages_counter','exam');
         }else{
             //Insert Entry
        $this->Videos_model->insert_modules_package($solpap_update_array,'cmspackages_counter');         
         }
         //End For solved Papers count update
           echo "Solved paper saved!<br>";
         //Start For Video count update
         $video_packages_count=$this->Videos_model->check_modules_package($exam_id,'','videos','cmspackages_counter');
        $video=$this->Videos_model->getVideos($exam_id);
        $videoquestions=$this->Videos_model->getVideosCount($exam_id);
         $video_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>count($video),
             'total_question'=>count($videoquestions),
             'module_type'=>'videos',
             'level'=>'exam'
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
           echo "Video saved!<br>";
         
    
    //Start For online Test count update
         $ot_packages_count=$this->Videos_model->check_modules_package($exam_id,'','online-test','cmspackages_counter','exam');
        $ot=$this->Onlinetest_model->getOnlineTests($exam_id);
        //$otquestions=$this->Onlinetest_model->getQuestionCount($exam_id);
        $otquestions=$this->Onlinetest_model->getCronOtCount($exam_id);
       if(isset($otquestions[0]->qcount)){
        $ot_qcount = $otquestions[0]->qcount;
       }else{
       $ot_qcount=0;    
       }
         $ot_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>count($ot),
             'total_question'=>$ot_qcount,
             'module_type'=>'online-test',
             'level'=>'exam'
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
         echo "Onliner test saved!<br>";
         
          //Start For Study Material count update
         $sm_packages_count=$this->Videos_model->check_modules_package($exam_id,'','study-packages','cmspackages_counter','exam');
        //$sm=$this->Studymaterial_model->getStudyMaterial($exam_id);
        $smp=$this->Studymaterial_model->getCronSM($exam_id);
        if(isset($smp[0]->package_count)){
       $smpackage_count=$smp[0]->package_count;
        }else{
        $smpackage_count=0;    
        }
      
        //$smquestions=$this->Studymaterial_model->getStudyMaterialCount($exam_id);
        $smquestions=$this->Studymaterial_model->getCronSmCount($exam_id);
        if(isset($smquestions[0]->qcount)){
        $sm_qcount = $smquestions[0]->qcount;
        }else{
            $sm_qcount = 0;
        }
        
         $sm_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>$smpackage_count,
             'total_question'=>$sm_qcount,
             'module_type'=>'study-packages',
             'level'=>'exam'
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
                'no_of_lectures'=>$smpackage_count
            );
            if(isset($product_info->id)&&$product_info->id>0){
       // $this->Pricelist_model->update($product_info->id,$data_array);
            }
          
         }
//End For Study Material count update
   echo "Study Material saved!<br>";
    //Start For Notes count update
         $notes_packages_count=$this->Videos_model->check_modules_package($exam_id,'','notes','cmspackages_counter','exam');
        //$notes=$this->Posting_model->getArticlesForExams($exam_id);
        //$notesquestions=$this->Posting_model->getQuestionCount($exam_id);
        $notes=$this->Posting_model->getCronArForExams($exam_id);
        if(isset($notes[0]->package_count)){
        $notes_package_count=$notes[0]->package_count;
        }else{
        $notes_package_count=0;
        }
        $notesquestions=$this->Posting_model->getCronQuestionCount($exam_id);
        if(isset($notesquestions[0]->q_count)){
        $notesq_counts=$notesquestions[0]->q_count;
        }else{
            $notesq_counts=0;
        }
        $notes_update_array=array(
            'exam_id'=>$exam_id,
            'exam_name'=>$exam_name,
            'total_package'=>$notes_package_count,
            'total_question'=>$notesq_counts,
            'module_type'=>'notes',
            'level'=>'exam'
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
         echo "Notes saved!<br>";
          //Start For NCERT Solutions count update
         $ns_packages_count=$this->Videos_model->check_modules_package($exam_id,'','ncert-solution','cmspackages_counter','exam');
        //$ns=$this->Ncertsolutions_model->getNcertSolutions($exam_id);
       // $nsquestions=$this->Ncertsolutions_model->getQuestionCount($exam_id);
         
         $ns=$this->Ncertsolutions_model->getCronNS($exam_id);
         if(isset($ns[0]->package_count)){
         $ns_count=$ns[0]->package_count;
         }else{
          $ns_count=0;   
         }
         $nsquestions=$this->Ncertsolutions_model->getCronQuestionCount($exam_id);
         $ns_q_count=$nsquestions[0]->q_count;
         $ns_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'total_package'=>$ns_count,
             'total_question'=>$ns_q_count,
             'module_type'=>'ncert-solution',
             'level'=>'exam'
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
         echo "Ncert Solutions saved!<br>";
         }
    }    
   echo "All Record saved!<br>";
    }
    
    //Update module count for subject.    
    public function cron_update_packagecnt_bysubjectid(){
        
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    $examid_array = $this->Examcategory_model->getExamCatgeories();
    $type=1;//For study-package
    foreach($examid_array as $examinfo){
        $exam_id=$examinfo->id;
        $exam_name=$examinfo->name;
        if($exam_id>0){
            $subjectid_array=$this->Examcategory_model->getExamSubject();
           foreach( $subjectid_array as  $subjectinfo){
                $subject_id=$subjectinfo->id;
                $subject_name=$subjectinfo->name;
                echo "<br><b>exam_id-(".$exam_id.") subject_id-(".$subject_id.")!<br></b>";
            //Start For Question Bank count update
       $qb_packages_count=$this->Videos_model->check_modules_package($exam_id,$subject_id,'question-bank','cmspackages_counter','subject');
        $qb=$this->Questionbank_model->getQuestionBank($exam_id,$subject_id);
        $qbquestions=$this->Questionbank_model->getQuestionCount($exam_id,$subject_id);
         $qb_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'subject_id'=>$subject_id,
             'subject_name'=>$subject_name,
             'total_package'=>count($qb),
             'total_question'=>count($qbquestions),
             'module_type'=>'question-bank',
             'level'=>'subject'
         );
         
         if(count($qb_packages_count)>0){
             //update entry
             $qb_update_id = $qb_packages_count[0]->id;
             $this->Videos_model->update_modules_package($qb_update_id,$qb_update_array,'cmspackages_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($qb_update_array,'cmspackages_counter');         
         }     
         
         echo "<br>Question Bank Added!<br>";
         //End For Question Bank count update
         
          //Start For Sample Papers count update
         $sampap_packages_count=$this->Videos_model->check_modules_package($exam_id,$subject_id,'sample-papers','cmspackages_counter','subject');
        $sampap=$this->Samplepapers_model->getSamplePapers($exam_id,$subject_id);
        $sampapquestions=$this->Samplepapers_model->getQuestionCount($exam_id,$subject_id);
         $sampap_update_array=array(  
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'subject_id'=>$subject_id,
             'subject_name'=>$subject_name,
             'total_package'=>count($sampap),
             'total_question'=>count($sampapquestions),
             'module_type'=>'sample-papers',
             'level'=>'subject'
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
                  echo "<br>Sanple paper Added!<br>";
    //Start For Solved Papers count update
         $solpap_packages_count=$this->Videos_model->check_modules_package($exam_id,$subject_id,'solved-papers','cmspackages_counter','subject');
        $solpap=$this->Solvedpapers_model->getSolvedPapers($exam_id,$subject_id);
       // $solpapquestions=$this->Solvedpapers_model->getQuestionCount($exam_id,$subject_id);
         $solpapquestions=$this->Solvedpapers_model->getCronQCount($exam_id,$subject_id);     
        $solpap_qcount=$solpapquestions[0]->qcount;
         $solpap_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'subject_id'=>$subject_id,
             'subject_name'=>$subject_name,
             'total_package'=>count($solpap),
             'total_question'=>count($solpapquestions),
             'module_type'=>'solved-papers',
             'level'=>'subject'
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
                  echo "<br>Solved paper Added!<br>";
          //Start For Video count update
         $video_packages_count=$this->Videos_model->check_modules_package($exam_id,$subject_id,'videos','cmspackages_counter','subject');
        $video=$this->Videos_model->getVideos($exam_id,$subject_id);
        $videoquestions=$this->Videos_model->getVideosCount($exam_id,$subject_id);
         $video_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'subject_id'=>$subject_id,
             'subject_name'=>$subject_name,
             'total_package'=>count($video),
             'total_question'=>count($videoquestions),
             'module_type'=>'videos',
             'level'=>'subject'
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
                  echo "<br>Video Added!<br>";
         
    //Start For online Test count update
         $ot_packages_count=$this->Videos_model->check_modules_package($exam_id,$subject_id,'online-test','cmspackages_counter','subject');
        $ot=$this->Onlinetest_model->getOnlineTests($exam_id,$subject_id);
        //$otquestions=$this->Onlinetest_model->getQuestionCount($exam_id,$subject_id);
        $otquestions=$this->Onlinetest_model->getCronOtCount($exam_id,$subject_id);
       $ot_qcount = $otquestions[0]->qcount;
         $ot_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'subject_id'=>$subject_id,
             'subject_name'=>$subject_name,
             'total_package'=>count($ot),
             'total_question'=>$ot_qcount,
             'module_type'=>'online-test',
             'level'=>'subject'
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
                  echo "<br>Online Teat Added!<br>"; 
          //Start For Study Material count update
         $sm_packages_count=$this->Videos_model->check_modules_package($exam_id,$subject_id,'study-packages','cmspackages_counter','subject');
        //$sm=$this->Studymaterial_model->getStudyMaterial($exam_id,$subject_id);
        $sm=$this->Studymaterial_model->getCronSM($exam_id,$subject_id);
       if(isset($sm[0]->package_count)){
       $smpackage_count=$sm[0]->package_count;        
       }else{
           $smpackage_count=0;
       }
        //$smquestions=$this->Studymaterial_model->getStudyMaterialCount($exam_id,$subject_id);
        $smquestions=$this->Studymaterial_model->getCronSmCount($exam_id,$subject_id);
       $sm_qcount = $smquestions[0]->qcount;
         $sm_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'subject_id'=>$subject_id,
             'subject_name'=>$subject_name,
             'total_package'=>$smpackage_count,
             'total_question'=>$sm_qcount,
             'module_type'=>'study-packages',
             'level'=>'subject'
         );
         if(count($sm_packages_count)>0){
             //update entry
             $sm_update_id = $sm_packages_count[0]->id;
             $this->Videos_model->update_modules_package($sm_update_id,$sm_update_array,'cmspackages_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($sm_update_array,'cmspackages_counter');         
         }
                  echo "<br>Study Packages Added!<br>";
            // Update Subject product price
          
            if(isset($subject_id)&&$subject_id>0){
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
                'no_of_lectures'=>$smpackage_count
            );
            
           if(isset($subject_product_info->id)&&$subject_product_info->id>0){
        //$this->Pricelist_model->update($subject_product_info->id,$subject_data_array);
            }
             } 
         
         //End For studypackages count update   
    //Start For Notes count update
         $notes_packages_count=$this->Videos_model->check_modules_package($exam_id,$subject_id,'notes','cmspackages_counter','subject');
        $notes=$this->Posting_model->getCronArForExams($exam_id,$subject_id);
        $notes_package_count=$notes[0]->package_count;
        $notesquestions=$this->Posting_model->getCronQuestionCount($exam_id,$subject_id);
        $notesq_counts=$notesquestions[0]->q_count;
        $notes_update_array=array(
            'exam_id'=>$exam_id,
            'exam_name'=>$exam_name,
             'subject_id'=>$subject_id,
             'subject_name'=>$subject_name,
            'total_package'=>$notes_package_count,
            'total_question'=>$notesq_counts,
            'module_type'=>'notes',
            'level'=>'subject'
         );
         if(count($notes_packages_count)>0){
             //update entry
             $notes_update_id = $notes_packages_count[0]->id;
             $this->Videos_model->update_modules_package($notes_update_id,$notes_update_array,'cmspackages_counter');
         }else{
             //Insert Entry
         $this->Videos_model->insert_modules_package($notes_update_array,'cmspackages_counter');         
         }
                  echo "<br>Notes Added!<br>";
         //End For Notes count update 
          //Start For NCERT Solutions count update
         $ns_packages_count=$this->Videos_model->check_modules_package($exam_id,$subject_id,'ncert-solution','cmspackages_counter','subject');
        //$ns=$this->Ncertsolutions_model->getNcertSolutions($exam_id,$subject_id);
       // $nsquestions=$this->Ncertsolutions_model->getQuestionCount($exam_id,$subject_id);
        $ns=$this->Ncertsolutions_model->getCronNS($exam_id,$subject_id);
         $ns_count=$ns[0]->package_count;
         $nsquestions=$this->Ncertsolutions_model->getCronQuestionCount($exam_id,$subject_id);
         $ns_q_count=$nsquestions[0]->q_count;
         $ns_update_array=array(
             'exam_id'=>$exam_id,
             'exam_name'=>$exam_name,
             'subject_id'=>$subject_id,
             'subject_name'=>$subject_name,
             'total_package'=>$ns_count,
             'total_question'=>$ns_q_count,
             'module_type'=>'ncert-solution',
             'level'=>'subject'
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
          echo "<br>Ncert Solution!<br>";
        }
    }
    }
    }
    
    
    
}
?>
