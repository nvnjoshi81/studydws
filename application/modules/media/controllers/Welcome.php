<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends MY_Controller {
    public function __construct() {
        parent:: __construct();
         $this->load->model('Media_model');
        $this->load->model('Posting_model');
        $this->load->model('Categories_model');
        $articlecategories=$this->Categories_model->getCategoryTree(13);
        $this->data['articlecategories']=$articlecategories;
        $this->load->library('pagination');
        //$archives=$this->Categories_model->getArticlesArchives();
        //$this->data['archives']=$archives;
        //$featured=$this->Posting_model->getFeaturedPostings(12);
        //$this->data['featured']=$featured;
        $recent=$this->Posting_model->getRecentPostings(13);
        $this->data['recent']=$recent;
        //$trending=$this->Posting_model->getTrendingPostings(12);
        //$this->data['trending']=$trending;
    }
    public function index(){
        $total_rows=$this->Posting_model->count_post_by_parent(13);
        $config = array();
        $config['per_page'] = 10;
           
        $config['base_url'] = base_url().'media';
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

        
        $this->data['media_array'] = $this->Media_model->getmedia();
        
        //$products= $this->Categories_model->getProducts($ids,$config['per_page'],$limit_end,$pricefilter);
        //$this->data['productslist']=$products;
        $listings=$this->Posting_model->getListingsByParent(13,$config['per_page'],$limit_end);
        //$this->data['styles']=array('study_css/stylegi.css');
        $this->data['listings']=$listings;
        $this->data['content']='welcome';
               
	$this->load->view('template',$this->data);
    }
    public function category($category_name,$category_id){
        $category=$this->Categories_model->getCategoryDetails($category_id);
        $total_rows=$this->Posting_model->count_category_post($category_id);
        $config = array();
        $config['per_page'] = 10;
           
        $config['base_url'] = base_url().'amazing-facts/'.$category_name.'/'.$category_id;
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
        $this->load->helper('text');
        $postdetails=$this->Posting_model->getPostinginfo($article_id);
        $related=$this->Posting_model->getRelatedPostings($postdetails->category_id);
        $recentarticles=$this->Posting_model->getRecentPostingsInCategory($postdetails->category_id);
        $category=$this->Categories_model->getCategoryDetails($postdetails->category_id);
        $nextpost=  $this->Posting_model->getNextPost($postdetails->id,$postdetails->category_id);
        $previouspost=  $this->Posting_model->getPreviousPost($postdetails->id,$postdetails->category_id);
       
        $this->data['recentarticles']=$recentarticles;
        $this->data['related']=$related;
        $this->data['nextpost']=$nextpost;
        $this->data['previouspost']=$previouspost;
        $this->data['postdetails']=$postdetails;
        $this->data['category']=$category;
        $this->data['content']='details';
	$this->load->view('template',$this->data);
    }
	
    public function notify($content_type=0,$exam_type=0,$detail_id=0){
		$showAll='no';
        $this->load->model('Notification_model');
		if(isset($detail_id)&&$detail_id>0){
	
        $noti_list=  $this->Notification_model->getnotification_details($detail_id);	
	    }else{
		$noti_type='web';
		if($content_type==0&&$exam_type==0){				 
        $noti_list=  $this->Notification_model->getnotification_all($noti_type);
		}else{				 
        $noti_list=  $this->Notification_model->getnotification($content_type,$exam_type,$noti_type);	
		}			
		}	
		
    $this->data['detail_id']=$detail_id;
    $this->data['lang_dropdown']='no';
    $this->data['noti_list']=$noti_list;
	$this->data['content']='notify';
	$this->load->view('template',$this->data);
		
	}
	
	
	    public function androidnotify($content_type=0,$exam_type=0,$detail_id=0){
		$showAll='no';
        $this->load->model('Notification_model');
		if(isset($detail_id)&&$detail_id>0){
	
        $noti_list=  $this->Notification_model->getnotification_details($detail_id);	
	    }else{
			
		$noti_type='web';
		if($content_type==0&&$exam_type==0){				 
        $noti_list=  $this->Notification_model->getnotification_all($noti_type);
		}else{				 
        $noti_list=  $this->Notification_model->getnotification($content_type,$exam_type,$noti_type);	
		}			
		}	
		
    $this->data['detail_id']=$detail_id;
    $this->data['lang_dropdown']='no';
    $this->data['noti_list']=$noti_list;
	$this->data['content']='appnotify';
	$this->load->view('template_mid',$this->data);
		
	}
	
	
    
}
?>
