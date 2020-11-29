<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends Modulecontroller {
    public function __construct() {
        parent:: __construct();
        $this->custom_category_id=83;
        define('CA_CATEGORY_ID',$this->custom_category_id);        
        $this->module_name='current-affairs'; 
        $this->module_name_heading='Current Affairs';
        define('MODULE_NAME_CF',$this->module_name); 
        define('MODULE_NAME_HEADING_CF',$this->module_name_heading);        
        $custom_category_id=$this->custom_category_id;
        $this->load->model('Posting_model');
        $this->load->model('Categories_model');
        $articlecategories=$this->Categories_model->getCategoryTree($custom_category_id);
        $this->data['articlecategories']=$articlecategories;
        $this->load->library('pagination');
        $archives=$this->Categories_model->getCA_Archives();
        $this->data['archives']=$archives;
        $featured=$this->Posting_model->getFeaturedPostings($custom_category_id);
        $this->data['featured']=$featured;
        $recent=$this->Posting_model->getRecentPostings($custom_category_id);
        $this->data['recent']=$recent;
        $trending=$this->Posting_model->getTrendingPostings($custom_category_id);
        $this->data['trending']=$trending;
        $this->load->helper('text');
    }
    public function index(){
		$cache_minutes=$this->config->item('cache_minutes');	
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
       $custom_category_id = $this->custom_category_id;
        $total_rows=$this->Posting_model->count_post_by_parent($custom_category_id);
        $config = array();
        $config['per_page'] = 10;           
        $config['base_url'] = base_url($this->module_name);
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
        $listings=$this->Posting_model->getListingsByParent($custom_category_id,$config['per_page'],$limit_end);        
        $category=$this->Categories_model->getCategoryDetails($page);
        $this->data['category']=$category;
        $this->data['listings']=$listings;
        $this->data['content']='welcome';
	$this->load->view('template',$this->data);
        
        
    }
    public function category($category_name,$category_id){
		$cache_minutes=$this->config->item('cache_minutes');	
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        $childcategories=$this->Categories_model->getCategoryTree($category_id);
        $this->data['childcategories']=$childcategories;
        $category=$this->Categories_model->getCategoryDetails($category_id);
        $total_rows=$this->Posting_model->count_category_post($category_id);
        $config = array();
        $config['per_page'] = 10;
           
        $config['base_url'] = base_url($this->module_name).'/'.$category_name.'/'.$category_id;
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
$cache_minutes=$this->config->item('cache_minutes');	
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}        
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
        $this->data['content']='details';
	$this->load->view('template',$this->data);
    }
    
    public function archives($year,$month){
$cache_minutes=$this->config->item('cache_minutes');	
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}		
        $custom_category_id=$this->custom_category_id;
        // Update function below to get listings count by month and year
        $total_rows=$this->Posting_model->count_post_by_parent($custom_category_id,1,$year,$month);
        $config = array();
        $config['per_page'] = 10;
           
        $config['base_url'] = base_url($this->module_name).'/archives/'.$year.'/'.$month;
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
        $listings=$this->Posting_model->getListingsByParent($custom_category_id,$config['per_page'],$limit_end,$year,$month);
        $this->data['listings']=$listings;
        $this->data['content']='welcome';
	$this->load->view('template',$this->data);
    }
    public function examarticle($exam_name,$subject_name,$chapter_name,$article_name,$article_id){
		$cache_minutes=$this->config->item('cache_minutes');	
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
        
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
       
        $this->data['related']=$related;
        $this->data['nextpost']=$nextpost;
        $this->data['previouspost']=$previouspost;
        $this->data['content']=$this->module_name;
        
        $this->load->model('Customer_model');
        $customer_info = $this->Customer_model->getCustomerDetails($article[0]->user_id); 
        $this->data['customer_info']=$customer_info;
        
	$this->load->view('template',$this->data);
    }
    public function exams($examname = null, $exam_id = 0, $subjectname = null, $subject_id = 0, $chapter_name = null, $chapter_id = 0){
       $cache_minutes=$this->config->item('cache_minutes');	
		if(isset($cache_minutes)&&$cache_minutes>0){ 
		$this->output->cache($cache_minutes);
		}
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
        
        $this->data['content'] = $this->module_name.'/exams';
        
        $data = $this->Posting_model->getNotesList($exam_id, $subject_id,$chapter_id);
        $data2 = $this->Posting_model->getNotesList2($exam_id, $subject_id,$chapter_id);
        $this->data['notes']=array_merge($data,$data2);
        $solutions_array = array();
        foreach ($this->data['notes'] as $result) {

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
