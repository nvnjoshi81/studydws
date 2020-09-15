<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends Modulecontroller {
    public function __construct() {
        parent:: __construct();
        $this->custom_category_id=12;
        define('A_CATEGORY_ID',$this->custom_category_id);        
        $this->module_name='articles'; 
        $this->module_name_heading='Articles';
        define('MODULE_NAME_CF',$this->module_name); 
        define('MODULE_NAME_HEADING_CF',$this->module_name_heading); 
        $this->load->model('Posting_model');
        $this->load->model('Categories_model');
        $articlecategories=$this->Categories_model->getCategoryTree($this->custom_category_id);
        $this->data['articlecategories']=$articlecategories;
        $this->load->library('pagination');
        $archives=$this->Categories_model->getArticlesArchives();
        $this->data['archives']=$archives;
        $featured=$this->Posting_model->getFeaturedPostings($this->custom_category_id);
        $this->data['featured']=$featured;
        $recent=$this->Posting_model->getRecentPostings($this->custom_category_id);
        $this->data['recent']=$recent;
        $trending=$this->Posting_model->getTrendingPostings($this->custom_category_id);
        $this->data['trending']=$trending;
        $this->load->helper('text');
    }
    public function index(){
        $total_rows=$this->Posting_model->count_post_by_parent($this->custom_category_id);
        $config = array();
        $config['per_page'] = 10;           
        $config['base_url'] = base_url().$this->module_name;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_rows ;
        $config['num_links'] = 12;
        $config['uri_segment'] = 2;
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
        
        $page = $this->uri->segment(2);
        if(!$page) $page=1;
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        }
        $this->pagination->initialize($config);
        $listings=$this->Posting_model->getListingsByParent($this->custom_category_id,$config['per_page'],$limit_end);        
        $category=$this->Categories_model->getCategoryDetails($page);
        $this->data['category']=$category;
        $this->data['listings']=$listings;
        $this->data['content']='welcome';
	$this->load->view('template',$this->data);
        
        
    }
    public function category($category_name,$category_id){
        $childcategories=$this->Categories_model->getCategoryTree($category_id);
        $this->data['childcategories']=$childcategories;
        $category=$this->Categories_model->getCategoryDetails($category_id);
        $total_rows=$this->Posting_model->count_category_post($category_id);
        $config = array();
        $config['per_page'] = 10;
           
        $config['base_url'] = base_url().'articles/'.$category_name.'/'.$category_id;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_rows ;
        $config['num_links'] = 12;
        $config['uri_segment'] = 4;
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
        
        $page = $this->uri->segment(4);
        if(!$page) $page=1;
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        }
        $this->pagination->initialize($config);
        $listings=$this->Posting_model->getPostings($category_id,$config['per_page'],$limit_end);
        $this->data['category']=$category;
        $this->data['listings']=$listings;
        $this->data['content']='welcome';
	$this->load->view('template',$this->data);
    }
    public function article($category_name,$article_name,$article_id){        
       //update View Count
        $this->Pricelist_model->update_viewcount($article_id,'postings');
        $this->load->helper('text');
        $postdetails=$this->Posting_model->getPostinginfo($article_id);
        $related=$this->Posting_model->getRelatedPostings($postdetails->category_id);
        $recentarticles=$this->Posting_model->getRecentPostingsInCategory($postdetails->category_id);
        $category=$this->Categories_model->getCategoryDetails($postdetails->category_id);
        $nextpost=  $this->Posting_model->getNextPost($postdetails->id,$postdetails->category_id);
        $previouspost=  $this->Posting_model->getPreviousPost($postdetails->id,$postdetails->category_id);
        //$this->data['styles']=array('ask/style/studyadda.askexpert.css');
        //print_r($previouspost);
        //print_r($nextpost);
        $this->data['recentarticles']=$recentarticles;
        $this->data['related']=$related;
        $this->data['nextpost']=$nextpost;
        $this->data['previouspost']=$previouspost;
        $this->data['postdetails']=$postdetails;
        $this->data['category']=$category;
        $this->data['article_id']=$article_id;
        $this->data['content']='details';
	$this->load->view('template',$this->data);
    }
    
    public function archives($year,$month){
        // Update function below to get listings count by month and year
        $total_rows=$this->Posting_model->count_post_by_parent($this->custom_category_id,1,$year,$month);
        $config = array();
        $config['per_page'] = 10;
           
        $config['base_url'] = base_url().'articles/archives/'.$year.'/'.$month;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_rows ;
        $config['num_links'] = 12;
        $config['uri_segment'] = 5;
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
        
        $page = $this->uri->segment(5);
        if(!$page) $page=1;
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        }
        $this->pagination->initialize($config);

        //$products= $this->Categories_model->getProducts($ids,$config['per_page'],$limit_end,$pricefilter);
        //$this->data['productslist']=$products;
        $listings=$this->Posting_model->getListingsByParent($this->custom_category_id,$config['per_page'],$limit_end,$year,$month);
        
        $this->data['listings']=$listings;
        $this->data['content']='welcome';
	$this->load->view('template',$this->data);
    }
    public function examarticle($exam_name,$subject_name,$chapter_name,$article_name,$article_id){
        
        $this->data['loadMathJax']='yes';
        $article=$this->Posting_model->getExamArticleInfo($article_id);        
	$this->data['relation']=$article[0];
        $this->data['article']=$article[0];
           
       //update View Count
        $this->Pricelist_model->update_viewcount($article_id,'postings');
        $related=null;
        $check=false;
        if($article[0]->chapter_id > 0){
          $related=$this->Posting_model->getNotesList($article[0]->exam_id, $article[0]->subject_id,$article[0]->chapter_id,'asc');
          $check=true;
        }elseif($article[0]->subject_id > 0){
          $related=$this->Posting_model->getNotesList($article[0]->exam_id, $article[0]->subject_id,'asc');
          $check=true;
        }else{
          $related=$this->Posting_model->getRelatedPostings($article[0]->exam_id);
        }
        $this->data['check']=$check;
        $nextpost=  $this->Posting_model->getNextPost($article_id,$article[0]->exam_id,$article[0]->subject_id,$article[0]->chapter_id);
        $previouspost=  $this->Posting_model->getPreviousPost($article_id,$article[0]->exam_id,$article[0]->subject_id,$article[0]->chapter_id);
        
        /*Display related product for notes Start */
        $this->load->model('Mergesection_model');
        $relatedfiles=$this->Mergesection_model->getRelatedModule($article_id,5,1);        
        $rfileArray_count=count($relatedfiles);
		$url=NULL;
		if($rfileArray_count>0){
			$rfile_count=$rfileArray_count-1;
            $this->load->model('Studymaterial_model');
             $file_price_info = $this->Studymaterial_model->getinfo_formerge($relatedfiles[$rfile_count]->related_module_id);
             if($relatedfiles[$rfile_count]->related_file_id > 0){
                $this->load->model('File_model');
                $details=$this->File_model->getStudyPackageDetails($relatedfiles[$rfile_count]->related_file_id);
                $isProduct = $this->Pricelist_model->getItemPrice($relatedfiles[$rfile_count]->related_file_id,1);
              
                $url=  generateContentLink('study-packages', $details->exam, $details->subject, $details->chapter, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
                $this->data['file']=$details;
                $this->data['filename'] = $file_price_info[$rfile_count]->displayname?$file_price_info[$rfile_count]->displayname:$file_price_info[$rfile_count]->filename;
                $this->data['filepath'] = 'upload/webreader/';
                $this->data['isProduct']=$isProduct;
            }else{
                 
                $details=$this->Studymaterial_model->detail($relatedfiles[$rfile_count]->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($relatedfiles[$rfile_count]->related_module_id);             
                $url=  generateContentLink('study-packages', $relation[$rfile_count]->exam, $relation[$rfile_count]->subject, $relation[$rfile_count]->chapter, $details->name, $details->id);
				$this->data['file']=$details;
                $this->data['filename'] = $file_price_info[$rfile_count]->displayname?$file_price_info[$rfile_count]->displayname:$file_price_info[$rfile_count]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            
            $this->data['file_price_info']=$file_price_info[$rfile_count];
            /*Get flax paper details*/
            $this->data['linktostudypackage']=$url;
        }
        
		// print_r($relatedfiles); echo 'article id'.$article_id;
        /*Display related product for notes End */
        $this->data['related']=$related;
        $this->data['nextpost']=$nextpost;
        $this->data['previouspost']=$previouspost;
        $this->data['content']='article';
        
        $this->data['article_id']=$article_id;
        $this->load->model('Customer_model');
        $customer_info = $this->Customer_model->getCustomerDetails($article[0]->user_id); 
        $this->data['customer_info']=$customer_info;
        
	$this->load->view('template',$this->data);
    }
    
    
     public function androidnotes($exam_name,$subject_name,$chapter_name,$article_name,$article_id){
            //echo $exam_name,'..',$subject_name,'..',$chapter_name,'..',$article_name,'..',$article_id; die;
        $this->data['loadMathJax']='yes';
        $article=$this->Posting_model->getExamArticleInfo($article_id);        
	$this->data['relation']=$article[0];
        $this->data['article']=$article[0];
           
       //update View Count
        //$this->Pricelist_model->update_viewcount($article_id,'postings');
        $related=null;
        $check=false;
        if($article[0]->chapter_id > 0){
          $related=$this->Posting_model->getNotesList($article[0]->exam_id, $article[0]->subject_id,$article[0]->chapter_id,'asc');
          $check=true;
        }elseif($article[0]->subject_id > 0){
          $related=$this->Posting_model->getNotesList($article[0]->exam_id, $article[0]->subject_id,'asc');
          $check=true;
        }else{
          $related=$this->Posting_model->getRelatedPostings($article[0]->exam_id);
        }
        $this->data['check']=$check;
        $nextpost=  $this->Posting_model->getNextPost($article_id,$article[0]->exam_id,$article[0]->subject_id,$article[0]->chapter_id);
        $previouspost=  $this->Posting_model->getPreviousPost($article_id,$article[0]->exam_id,$article[0]->subject_id,$article[0]->chapter_id);
        
        /*Display related product for notes Start */
        $this->load->model('Mergesection_model');
        $relatedfiles=$this->Mergesection_model->getRelatedModule($article_id,5,1);        
        if(count($relatedfiles) == 1){
            $this->load->model('Studymaterial_model');
             $file_price_info = $this->Studymaterial_model->getinfo_formerge($relatedfiles[0]->related_module_id);
            
             if($relatedfiles[0]->related_file_id > 0){
                $this->load->model('File_model');
                $details=$this->File_model->getStudyPackageDetails($relatedfiles[0]->related_file_id);
                $isProduct = $this->Pricelist_model->getItemPrice($relatedfiles[0]->related_file_id,1);
              
                $url=  generateContentLink('study-packages', $details->exam, $details->subject, $details->chapter, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
                $this->data['file']=$details;
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
                $this->data['isProduct']=$isProduct;
            }else{
                 
                $details=$this->Studymaterial_model->detail($relatedfiles[0]->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($relatedfiles[0]->related_module_id);             
                $url=  generateContentLink('study-packages', $relation[0]->exam, $relation[0]->subject, $relation[0]->chapter, $details->name, $details->id);
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            
            $this->data['file_price_info']=$file_price_info[0];
            /*Get flax paper details*/
            $this->data['linktostudypackage']=$url;
        }
        
        /*Display related product for notes End */
       
        $this->data['related']=$related;
        $this->data['nextpost']=$nextpost;
        $this->data['previouspost']=$previouspost;
        $this->data['content']='app_article';
        
        $this->load->model('Customer_model');
        $customer_info = $this->Customer_model->getCustomerDetails($article[0]->user_id); 
        $this->data['customer_info']=$customer_info;
        
	$this->load->view('template_mid',$this->data);
    }
    
     
     public function printnotes($exam_name,$subject_name,$chapter_name,$article_name,$article_id){
         $file_key =  decrypt($article_id);
        $qbid_array = explode('_st@ad_',$file_key);
        $article_id=$qbid_array[0];
               
//echo $exam_name,'..',$subject_name,'..',$chapter_name,'..',$article_name,'..',$article_id; die;
        $this->data['loadMathJax']='yes';
        $article=$this->Posting_model->getExamArticleInfo($article_id);        
	$this->data['relation']=$article[0];
        $this->data['article']=$article[0];
       //update View Count
        //$this->Pricelist_model->update_viewcount($article_id,'postings');
        $related=null;
        $check=false;
        if($article[0]->chapter_id > 0){
          $related=$this->Posting_model->getNotesList($article[0]->exam_id, $article[0]->subject_id,$article[0]->chapter_id,'asc');
          $check=true;
        }elseif($article[0]->subject_id > 0){
          $related=$this->Posting_model->getNotesList($article[0]->exam_id, $article[0]->subject_id,'asc');
          $check=true;
        }else{
          $related=$this->Posting_model->getRelatedPostings($article[0]->exam_id);
        }
        $this->data['check']=$check;
        
        /*Display related product for notes Start */
        $this->load->model('Mergesection_model');
        $relatedfiles=$this->Mergesection_model->getRelatedModule($article_id,5,1);        
        if(count($relatedfiles) == 1){
            $this->load->model('Studymaterial_model');
             $file_price_info = $this->Studymaterial_model->getinfo_formerge($relatedfiles[0]->related_module_id);
            
             if($relatedfiles[0]->related_file_id > 0){
                $this->load->model('File_model');
                $details=$this->File_model->getStudyPackageDetails($relatedfiles[0]->related_file_id);
                $isProduct = $this->Pricelist_model->getItemPrice($relatedfiles[0]->related_file_id,1);
              
                $url=  generateContentLink('study-packages', $details->exam, $details->subject, $details->chapter, $details->name,url_title($details->displayname?$details->displayname:$details->filename,'-',true));
                $url.='/'.$details->id;
                $this->data['file']=$details;
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
                $this->data['isProduct']=$isProduct;
            }else{
                 
                $details=$this->Studymaterial_model->detail($relatedfiles[0]->related_module_id);
                $relation=$this->Studymaterial_model->getRelations($relatedfiles[0]->related_module_id);             
                $url=  generateContentLink('study-packages', $relation[0]->exam, $relation[0]->subject, $relation[0]->chapter, $details->name, $details->id);
                $this->data['filename'] = $file_price_info[0]->displayname?$file_price_info[0]->displayname:$file_price_info[0]->filename;
                $this->data['filepath'] = 'upload/webreader/';
            }
            
            $this->data['file_price_info']=$file_price_info[0];
            /*Get flax paper details*/
            $this->data['linktostudypackage']=$url;
        }
        
        /*Display related product for notes End */
       
        $this->data['related']=$related;
        $this->data['nextpost']=array();
        $this->data['previouspost']=array();
        $this->data['content']='pdf_article';
        
        $this->load->model('Customer_model');
        $customer_info = $this->Customer_model->getCustomerDetails($article[0]->user_id); 
        $this->data['customer_info']=$customer_info;
        
	$this->load->view('template_mid',$this->data);
    }
    
    public function exams($examname = null, $exam_id = 0, $subjectname = null, $subject_id = 0, $chapter_name = null, $chapter_id = 0){
       
        $examdata = array();
        if ($examname == null) {
            $title = getTitle('Notes', $this->data['examcategories']);

            $titleStr[] = $title;
        } else {
            $titleStr[] = 'Notes for';
        }
        if ($exam_id > 0) {
            $exam = $this->Categories_model->getCategoryDetails($exam_id);
            $this->data['selectedexam'] = $exam;
            $titleStr[] = addSuffix($exam->name, 'Class');
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
            $chaptersubjects = $this->Examcategory_model->getExamChapters($exam_id);
            $subjects_array = array();
            $chapters_array = array();

            if (count($chaptersubjects) > 0) {
                foreach ($chaptersubjects as $record) {

                    if (!in_array($record->sname, $subjects_array)) {
                        $subjects_array[$record->sid] = array('name' => $record->sname);
                    }
                    if ($subject_id > 0 && $subject_id == $record->sid) {
                        $notes = $this->Posting_model->getNotesCount($exam_id, $record->sid, $record->cid);
                        $notes2 = $this->Posting_model->getNotesCount2($exam_id, $record->sid, $record->cid);
                        if (!in_array($record->cname, $chapters_array)) {

                            $chapters_array[$record->cid] = array('name' => $record->cname, 'count' => count($notes)+count($notes2));
                        } else {
                            $chapters_array[$record->cid]['count'] = count($notes)+count($notes2);
                        }
                    }

                    if(array_key_exists($record->sname, $data_array)) {
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
                foreach($subjects_array as $key => $value) {
                    $notes = $this->Posting_model->getNotesCount($exam_id, $key, 0);
                    $notes2 = $this->Posting_model->getNotesCount2($exam_id, $key, 0);
                    $subjects_array[$key]['count'] = count($notes)+count($notes2);
                }
            }
            $this->data['subjects_array'] = $subjects_array;

            $this->data['chapters_array'] = $chapters_array;
        }

        $this->data['title'] = implode(' ', $titleStr);
        $this->data['h1title'] = implode(' ', $titleStr);
        

        $this->data['exam_id'] = $exam_id;
        $this->data['subject_id'] = $subject_id;
        $this->data['chapter_id'] = $chapter_id;
        
        $this->data['content'] = 'articles/exams';
        if($chapter_id>0){
          $plimit=900;
      }else{
          $plimit=20;
      }
        $data = $this->Posting_model->getNotesList($exam_id, $subject_id,$chapter_id);
       $data2 = $this->Posting_model->getNotesList2($exam_id, $subject_id,$chapter_id);
        
       $unlimited_array=array_merge($data,$data2);
       $limited_array=array_slice($unlimited_array,0,$plimit);
       $this->data['notes']=$limited_array;
       $this->data['solutions_notes']=$unlimited_array;
        
        $solutions_array = array();
        foreach ($this->data['solutions_notes'] as $result) {

            if (!array_key_exists($result->category_id, $solutions_array)) {
                $solutions_array[$result->category_id] = array('name' => $result->exam, 'subjects' => array());
            }
            if (!array_key_exists($result->subject_id, $solutions_array[$result->category_id]['subjects'])) {
                $solutions_array[$result->category_id]['subjects'][$result->subject_id] = array('id' => $result->subject_id, 'name' => $result->subject);
            }
        }
        $this->data['solutions_array'] = $solutions_array;
        
        $this->load->view('template', $this->data);
    }
}
?>
