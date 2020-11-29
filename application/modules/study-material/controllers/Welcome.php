<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Welcome extends Modulecontroller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Studymaterial_model');
        $this->load->model('History_model');
    }
    public function index($examname = null, $exam_id = 0, $subjectname = null, $subject_id = 0, $chapter_name = null, $chapter_id = 0) {    
	
        $examdata = array();
        if ($examname == null) {
            $title = getTitle('Study Packages', $this->data['examcategories']);

            $titleStr[] = $title;
        } else {
            $titleStr[] = 'Study Packages for';
        }
        if ($exam_id > 0) {
            $exam = $this->Categories_model->getCategoryDetails($exam_id);
            $this->data['selectedexam'] = $exam;
            $titleStr[] = $exam->name;
        }
        if ($subject_id > 0) {
            $this->load->model('Subjects_model');
            $this->data['selectedsubject'] = $this->Subjects_model->getSubject($subject_id);
            $titleStr[] = $this->data['selectedsubject']->name;
        }
        if ($chapter_id > 0) {
            $this->load->model('Chapters_model');
            $this->data['selectedchapter'] = $this->Chapters_model->getChapter($chapter_id);
            $titleStr[] = $this->data['selectedchapter']->name;
        }
        if ($exam_id) {
            $data_array = array();
            $subjects_array = array();
            $chapters_array = array();
            $chaptersubjects = $this->Examcategory_model->getExamChapters($exam_id);
			
			if (count($chaptersubjects) > 0) {
                foreach ($chaptersubjects as $record) {
                    if (!in_array($record->sname, $subjects_array)) {
                        $subjects_array[$record->sid] = array('name' => $record->sname);
                    }
                    if ($subject_id > 0 && $subject_id == $record->sid) {
                        $sm = $this->Studymaterial_model->getStudyMaterialCount($exam_id, $record->sid, $record->cid);
                        if (!in_array($record->cname, $chapters_array)) {

                            $chapters_array[$record->cid] = array('name' => $record->cname, 'count' => count($sm));
                        } else {
                            $chapters_array[$record->cid]['count'] = count($sm);
                        }
                    }
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
            if (count($subjects_array) > 0) {
                foreach ($subjects_array as $key => $value) {
                    $sm = $this->Studymaterial_model->getStudyMaterialCount($exam_id, $key, 0);
                    $subjects_array[$key]['count'] = count($sm);
                }
            }
            $this->data['subjects_array'] = $subjects_array;

            $this->data['chapters_array'] = $chapters_array;
        }
        $studymaterials = $this->Studymaterial_model->getStudyMaterial($exam_id, $subject_id, $chapter_id);
        
        $this->data['studymaterials'] = $studymaterials;
        
        $files = $this->Studymaterial_model->getStudyMaterialCount($exam_id, $subject_id, $chapter_id);
      if($chapter_id>0){
          $plimit=900;
      }else{
           $plimit=20;
      }
        $productslist = $this->Studymaterial_model->getFilesProducts($exam_id, $subject_id, $chapter_id,$plimit);
        
        
        foreach($productslist as $fd){
            $file_id=$fd->file_id;
            $customer_id=$this->session->userdata('customer_id');
            $historyArray[$file_id]=$this->History_model->getDownloadHistory($customer_id,$file_id,$type=2);
        }
        $this->data['downloadHistory']=$historyArray;
        
        //Check Exam Id is a product or not
        $final_product_id = $this->Pricelist_model->checkExamProduct($exam_id);
        $final_product_details = $this->Pricelist_model->checkExamProduct_detail($exam_id);        
        $final_subject_product_id = $this->Pricelist_model->checkSubjectProduct($exam_id,$subject_id);       
        $final_subject_product_details = $this->Pricelist_model->checkSubjectProduct_detail($exam_id,$subject_id);         
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
             if($final_product_details->exam_id==$exam_id){
                 $this->session->set_userdata('sub_purchases','yes');
             }
             //$purchased[1][]=$final_subject_product_id;             
             
               $purchased_material=$this->session->userdata('purchases');
               array_push($purchased_material[1],$final_subject_product_id);
               $this->session->unset_userdata('purchases');
               $this->session->set_userdata('purchases',$purchased_material);
         }
         
            if (!$this->session->userdata('purchases') || !in_array_r($final_subject_product_id, $this->session->userdata('purchases'))) {
             //echo "not Subject brought";
         }else{
             if(isset($final_subject_product_details->subject_id)&&$final_subject_product_details->subject_id==$subject_id){
                 $this->session->set_userdata('sub_purchases','yes');
             }
         }
         
        $isProduct = $this->Pricelist_model->getProduct($exam_id, $subject_id, $chapter_id, 1);
        $this->data['isProduct'] = $isProduct;
        $allfiles=array();
        if($chapter_id > 0){
            foreach($studymaterials as $sm){
                //echo $sm->name;
                $allfiles[$sm->name]=$this->Studymaterial_model->getFiles($sm->id);
            }
             $this->data['allfiles'] = $allfiles;         
      
        }
         $allexpr=array();$allsubpr=array();$allchpr=array();
        $boughtproducts=array();
        if($this->session->userdata('customer_id')){
        $purchsed_products = $this->session->userdata('purchases');  
        //print_r($purchsed_products);
  if(count($purchsed_products)>0){
    foreach($purchsed_products as $key=>$value){
                foreach ($value as $k1 => $v1) {
                        $prdetails=$this->Pricelist_model->getDetails($v1);
                    //print_r($prdetails);
                    if(isset($prdetails->type)&&$prdetails->type==1){
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
                                $chaptreprojects=$this->Pricelist_model->getAllProducts($prdetails->exam_id,$prdetails->subject_id,$prdetails->chapter_id,1);
                                //print_r($chaptreprojects);
                                $allchpr[]=$chaptreprojects;
                           // }
                        }
                    }
                }
                }
            }
  }
            //print_r($allchpr);
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
          // To insert data in purchases session
          foreach($marray as $pid){
               $purchased_material=$this->session->userdata('purchases');                        array_push($purchased_material[1],$final_subject_product_id);
               $this->session->unset_userdata('purchases');
               $this->session->set_userdata('purchases',$purchased_material);
          }
          
          /* Display All exam product on page*/
       $ts_categories=array();
       $isProduct_array=array();
       $testseries_Product=array();
       $ts_categories=$this->Examcategory_model->getExamCatgeories();
       foreach($ts_categories as $ex){ 
       $ts_chapter_id='';
       $ts_subject_id='';     
       $ts_exam_id=$ex->id;
       $testseries_Product = $this->Pricelist_model->getProduct($ts_exam_id, $ts_subject_id, $ts_chapter_id, 1);
       if(count($testseries_Product)>0){
          $isProduct_array[]= $testseries_Product;
       }
       }
        //print_r($isProduct_array);
        $this->data['isProduct_array']=$isProduct_array;
        /*End Display all packge*/
        $this->data['pproducts']=$marray;
        $this->data['productslist'] = $productslist;
        $this->data['title'] = implode(' ', $titleStr);
        $this->data['h1title'] = implode(' ', $titleStr);
        $this->data['files'] = $files;
        $this->data['exam_id'] = $exam_id;
        $this->data['subject_id'] = $subject_id;
        $this->data['chapter_id'] = $chapter_id;
        $this->data['examdata'] = $examdata;
        $this->data['content'] = 'welcome';
        $data = $this->Studymaterial_model->getStudyMaterialList($exam_id, $subject_id);

        $solutions_array = array();
        foreach ($data as $result) {

            if (!array_key_exists($result->exam_id, $solutions_array)) {
                $solutions_array[$result->exam_id] = array('name' => $result->exam, 'subjects' => array());
            }
            if (!array_key_exists($result->subject_id, $solutions_array[$result->exam_id]['subjects'])) {
                $solutions_array[$result->exam_id]['subjects'][$result->subject_id] = array('id' => $result->subject_id, 'name' => $result->subject);
            }
        }
        $this->data['solutions_array'] = $solutions_array;
        $this->load->view('template', $this->data);
    }

    
      public function showbought_subject($examname = null, $exam_id = 0, $subjectname = null, $subject_id = 0, $chapter_name = null, $chapter_id = 0){
        //$chapters=$this->Chapters_model->getChapterByExamSubject($exam,$subject);
$this->load->helper('text'); 
        $productslist_html='';
        $productslist = $this->Studymaterial_model->getFilesProducts($exam_id, $subject_id, $chapter_id,100);
           
        foreach($productslist as $fd){
            $file_id=$fd->file_id;
            $customer_id=$this->session->userdata('customer_id');
            $historyArray[$file_id]=$this->History_model->getDownloadHistory($customer_id,$file_id,$type=2);
        }
        $this->data['downloadHistory']=$historyArray;
        $productslist_html .='<div class="col-xs-12 col-md-12 download_list_exam">';
         if(count($productslist)>0){
        $productslist_html.='<div class="col-md-12 text-center bavl"><h3 class="bg-info">Download Packages';
        if($subjectname!=''){
            $productslist_html.=' for ';
            if($examname!=''){
                //$productslist_html.=$examname.' ';
            }
            $productslist_html.=urldecode($chapter_name);
        }
       $productslist_html .='</h3></div>';
                $productslist_html.= '<div class="row">';
        $count = 1;
            foreach ($productslist as $product) {
                
                $productslist_html .='<div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="col-item">
                       <div class="photo">';
                $productslist_html .='<a href="'.getProductLink($product, 1).'">';
                          $productslist_html .='<img style="width:60%;" src="'.show_flex_thumb($product->filename, 300, 350).'" class="img-responsive lazy"/>';
                       $productslist_html .='</a>';             
                           $productslist_html .='</div>';
                           
                           $productslist_html.=' <div class="info">';
                           
                                $productslist_html.='<div class="row">
                                    <div class="price col-xs-12 col-md-12">';
$st_productname=character_limiter($product->displayname ? $product->displayname : $product->modules_item_name, 40);                           
                        $productslist_html.='<h5 class="vid_prod_hed">'.$st_productname.'</h5>';
                           
						$productslist_html.='</div></div>';
                         
						$productslist_html .='<div class="separator btn_prod_ved">
                                        <p class="buy_btn">';
                           
                          $downloadurl = base_url('study-packages/download/'.encrypt($product->file_id.'.'.$this->session->userdata('customer_id')));
                           
                          $productslist_html .='<a href="'.$downloadurl.'" target="blank">
                                            <button class="btn-md btn-xs btn btn-raised btn-success" name="btnAlreadyExist">Download Now</button>
                                             </a>';
                           $productslist_html.='</p>
                                    </div>';
                           //$productslist_html.='<div class="clearfix"> </div>';
                           $productslist_html.='</div>';
                           
                           $productslist_html.='</div></div>';
           
           
           if($count%4==0){
               
                          $productslist_html.='<div class="clearfix"> </div>';
           }
           
           $count++;
                           }
                        
        
                 $productslist_html .='</div>';
         }else{
             $productslist_html.='<div class="col-md-12 text-center bavl" id="no_download_info"><h2>No Download available.We are updating studypackages.</h2></div>';
         }
                 
                $productslist_html .='</div>';
                
        $chapters_array=array();        
        $chapters_array[]=array('productslist_html'=>$productslist_html,'productslist_count'=>count($productslist));
        
        echo json_encode($chapters_array);
    }
    
    public function details($smname, $smid) {
		$cache_minutes=$this->config->item('cache_minutes');	
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $url_segments = $this->uri->segment_array();
        
        array_pop($url_segments);
        if(count($url_segments)==4){
            $url_segments[]='all';
        }
        if(count($url_segments)==3){
            $url_segments[]='all'; $url_segments[]='all';
        }
        $this->data['url_segments'] = $url_segments;
        $this->load->model('Questions_model');
        $smdetails = $this->Studymaterial_model->details($smid);
		$examname=$this->uri->segment(2);
		$examname_array=$this->Categories_model->getCategoriesbyname($examname); 

if($examname_id<1||$examname_id==''){
		$examname_id=$examname_array[0]->id;	
		}
		
        $relation = $this->Studymaterial_model->getRelations($smid,$examname_id);
        $files = $this->Studymaterial_model->getFiles($smid);
        //$files = $this->Pricelist_model->getFiles_withallproducts($smid);
        /* To display questions */
        $questions = $this->Studymaterial_model->getQuestions($smid);
        $questiontypes = $this->Studymaterial_model->questionTypes($smid);
        $title = generateTitle('Study Packages for', $relation[0], $smdetails->name);
        $relation_detail_array = $this->Studymaterial_model->getRelationDetail($smid); 
        $exam_id=$relation_detail_array[0]->exam_id;
        $subject_id=$relation_detail_array[0]->subject_id;
        $chapter_id=$relation_detail_array[0]->chapter_id;
        $isProduct = $this->Pricelist_model->getProduct($exam_id, $subject_id, $chapter_id, 1);
        $this->data['isProduct'] = $isProduct;
        $this->data['title'] = $title;
        $this->data['smdetails'] = $smdetails;
        $this->data['relation'] = $relation[0];
        $this->data['files'] = $files;
        $this->data['content'] = 'details';
        /* To display questions */
        $this->data['questiontypes'] = $questiontypes;
        $this->data['questions'] = $questions;
        $this->data['loadMathJax'] = 'YES';
        $this->load->view('template', $this->data);
    }

    public function show($filename, $fileid) {
		$cache_minutes=$this->config->item('cache_minutes');	
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
         //update View Count
        $this->Pricelist_model->update_viewcount($fileid,'cmsfiles');
        $this->load->model('File_model');
        $file = $this->File_model->detail($fileid);
        $studyfile_array = $this->Studymaterial_model->getStudydetailsFiles($fileid);        
        if(isset($studyfile_array[0]->studymaterial_id)){
            $smid = $studyfile_array[0]->studymaterial_id ;
        $isProduct = $this->Pricelist_model->getItemPrice($fileid,1);
   
$examname=$this->uri->segment(2);
$examname_array=$this->Categories_model->getCategoriesbyname($examname); 

if($examname_id<1||$examname_id==''){
		$examname_id=$examname_array[0]->id;	
		}
        
        $relation_detail_array = $this->Studymaterial_model->getRelations($smid,$examname_id);
		if(isset($relation_detail_array[0]->exam_id)&&$relation_detail_array[0]->exam_id>0){			
		$exam_id=$relation_detail_array[0]->exam_id;
		}else{
	    $exam_id =$isProduct->exam_id;
		}
		
		//Check Exam Id is a product or not
         $final_product_id = $this->Pricelist_model->checkExamProduct($exam_id);
         if($final_product_id>0){
         $this->data['isMainProductBrought']=$final_product_id;
         }else{
         $this->data['isMainProductBrought']=0;
         }
         $subject_id=$isProduct->subject_id;
         //Check for subject is product or not
          $final_subject_product_id = $this->Pricelist_model->checkSubjectProduct($exam_id,$subject_id);
         
         if($final_subject_product_id>0){
         $this->data['isSubjectProductBrought']=$final_subject_product_id;
         }else{
          $this->data['isSubjectProductBrought']=0;   
         }
                  
       $this->data['relation']=$relation_detail_array[0];
        
        $this->data['title']=str_replace('_',' ',$file->filename).' Study Package';
        }else{
            $smid=0;
            $relation_detail_array =array();
            $isProduct='';
            $this->data['title']='Study Package Not Found!';
        }
        
        /*
        $subject_id=$relation_detail_array[0]->subject_id;
        $chapter_id=$relation_detail_array[0]->chapter_id;*/
        $this->data['isProduct'] = $isProduct;
        $this->data['exam_id'] = $exam_id;
        $this->data['file'] = $file;
        $this->data['content'] = 'show'; 
        $this->load->view('template', $this->data);
    }

    public function rename(){
        $sm=$this->Studymaterial_model->getChapterNameForStudyMaterial();
        $count=0;
        
        foreach($sm as $item){
            $name=$item->name;
            if($item->id==92){
                $name='HCV Solutions';
            }else{
                $name=$item->chapter;
            }
          //  $this->db->query('Update cmsstudymaterial set name="'.$name.'" where id='.$item->id);
        }
        echo $count;
    }
    
    public function showanswer($solname,$solid,$qid){
		$cache_minutes=$this->config->item('cache_minutes');	
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $studymatrerialsdetails=$this->Studymaterial_model->detail($solid);
		$examname=$this->uri->segment(2);
$examname_array=$this->Categories_model->getCategoriesbyname($examname); 

		if($examname_id<1||$examname_id==''){
		$examname_id=$examname_array[0]->id;	
		}
        $relation=$this->Studymaterial_model->getRelations($solid,$examname_id);
        $this->data['relation']=$relation[0];
        
        $title=generateTitle('Free Ncert Solutions for',$relation[0]);
        $this->data['title']=$title ;
        if($this->input->get('proxy') && $this->input->get('proxy')=='v2016'){
            $isvalid=true;
            
        }else{
            $isvalid=$this->Studymaterial_model->checkQuestion($solid,$qid);
        }     
        
           if($isvalid){
            $this->data['nextquestion']='';
            $this->data['previousquestion']='';
            $this->load->model('Questions_model');
            $question=$this->Questions_model->detail($qid);
            $answers=$this->Questions_model->answers($qid);
            $this->data['nextquestion']=$this->Questions_model->getNext('cmsstudymaterial_details','studymaterial_id',$solid,$qid);
            $this->data['previousquestion']=$this->Questions_model->getPrevious('cmsstudymaterial_details','studymaterial_id',$solid,$qid);
            $this->data['question']=$question;
            $this->data['answers']=$answers;
            $this->data['content']='common/questiondetail';
            $this->data['linkurl']=base_url('study-packages/'.$solname.'/'.$solid);
            $this->data['studymatrerialsdetails']=studymatrerialsdetails;
            $this->data['loadMathJax']='YES';
            $this->load->view('template',$this->data);
        }else{
            redirect('study-packages/'.$solname.'/'.$solid);
        }
    }
}
