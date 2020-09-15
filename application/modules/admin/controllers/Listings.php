<?php 
class Listings extends MY_Admincontroller
{
 public function __construct()
	{
            parent::__construct();
            $this->load->helper(array('form', 'url','text'));
             $this->load->model('posting_model');
             $this->load->model('categories_model');
             $this->load->library("pagination");
             
    $this->load->model('Examcategory_model');
    $this->load->model('Subjects_model');
    $this->load->model('Chapters_model');
    $this->data['exams_article_arr']=  $this->Examcategory_model->getAdminExamCatgeories();
    $this->data['subjects_article_arr']= $this->Subjects_model->getSubjects();
    $this->data['chapters_article_arr']= $this->Chapters_model->getChapters(); 

            
         }
 public function index($id=0,$page=0) {
                
                $this->load->library('pagination');
                $config = array();
                $config["base_url"] = base_url()."admin/listings/".$id;
                $config["total_rows"] =$this->posting_model->count_category_post($id,'all');
                //print_r($config);
                $config["per_page"] =$this->config->item('records_per_page'); 
                $config["uri_segment"] = 4;
                $config["num_links"] = 5;
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
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                
                //$postings=$this->posting_model->get_filter_Posting($config["per_page"],$page,$id);

               $categoryArray=$this->categories_model->fetchCategoryTree();
               $this->data['allcategories']=$categoryArray;
               $postings=$this->posting_model->getPostingList($id,$config["per_page"],$page);
               $this->data["links"] = $this->pagination->create_links();
               //$this->data['id']=$id; 
               $this->data['postings']=$postings;         
               $this->load->model('categories_model');  
               $query=$this->categories_model->getParentCategories();
               $this->data['parent_categories']=$query;
               $this->data['action']=base_url().'admin/listings';
               $this->data['content']='listings/listings';
               $this->load->view('common/template',$this->data);
         }
         
         public function current_affairs($id=0,$page=0){
                $current_affairs_id=83;
                if($id>0){
                    $cid=$id;
                }else{
                    $cid=$current_affairs_id;
                }
                $this->load->library('pagination');
                $config = array();
                $config["base_url"] = base_url()."admin/listings/current_affairs/".$id;
                $config["total_rows"] =$this->posting_model->count_post_by_parent($cid);
                //print_r($config);
                $config["per_page"] =$this->config->item('records_per_page'); 
                $config["uri_segment"] = 5;
                $config["num_links"] = 5;
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
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
               $categoryArray=$this->categories_model->fetchCategoryTree($current_affairs_id);
               $this->data['allcategories']=$categoryArray;
               $postings=$this->posting_model->getca_List($current_affairs_id,$config["per_page"],$page);
               $this->data["links"] = $this->pagination->create_links();
               //$this->data['id']=$id; 
               $this->data['postings']=$postings;         
               $this->load->model('categories_model');  
               $query=$this->categories_model->getParentCategories();
               $this->data['parent_categories']=$query;
               $this->data['action']=base_url().'admin/current_affairs/listings';
               $this->data['content']='listings/current_affairs';
               $this->load->view('common/template',$this->data);
         }
         
    public function unpublished($id=0,$page=0) {
                $status=0;
                $config = array();
                $config["base_url"] = base_url() . "admin/listings/unpublished/".$id;
                $config["total_rows"] = $this->posting_model->count_unpublish_post($id,'all');
                $config["per_page"] =  $this->config->item('records_per_page');
                $config["uri_segment"] =5;
                $config["num_links"] = 5;
                $config['prev_tag_open'] = '<a>';
                $config['next_link'] = '<button>Next</button>';
                $config['prev_link'] = '<button>Previous</button>';
                $config['prev_tag_close'] = '</a>';
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
                $postings=$this->posting_model->getPostingList($id,$config["per_page"], $page,$status);
              
                $this->data["links"] = $this->pagination->create_links();
                $this->data['status']=$status;         
                $this->data['postings']=$postings;         
                 $this->load->model('categories_model');  
                $query=$this->categories_model->getParentCategories();
                $categoryArray=$this->categories_model->fetchCategoryTree();
               
                $this->data['allcategories']=$categoryArray;
                $this->data['parent_categories']=$query;     
               $this->data['content']='listings/listings';
               $this->data['action']=base_url().'admin/listings/unpublished';
               $this->load->view('common/template',$this->data);
         }
         public  function published($id){
             $config = array();
              $config["base_url"] = base_url() . "admin/listings/published/id";
             $published_status=1;
              $update_data =array(
                 'published'=>$published_status
                   );
               $this->posting_model->update_posting($id,$update_data); 
                redirect(base_url().'admin/listings/');
         }

          public  function deletelisting($id){
                
                $query= $this->posting_model->delete_posting($id); 
                $m_img_real= $_SERVER['DOCUMENT_ROOT'].'/assets/upload/'.$query[0]->external_url;
                $m_img_thumbs = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/'.'200_300_'.$query[0]->external_url;
                if (file_exists($m_img_real) && file_exists($m_img_thumbs)){
                    unlink($m_img_real);
                    unlink($m_img_thumbs);
                }
                redirect(base_url().'admin/listings/');
         }



   public function edit_listing($id){
     
    $config = array();
    $config["base_url"] = base_url() . "admin/listings/edit_listing/id";         
    $listing=$this->posting_model->getPostinginfo($id);
    $categoryArray=$this->categories_model->fetchCategoryTree();
	$module_relation_details=$this->posting_model->getRelationDetail($id);
	$this->data['module_relation_details']=$module_relation_details;
	/*For relate module*/
	
	
            if (count($module_relation_details) > 0) {
                for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                    $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                    $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);

                    $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);
                    if (isset($relation_exam_name[0]->name)) {
                        $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                    } else {
                        $this->data['relation_exam'][$rcnt] = 'None';
                    }

                    if (isset($relation_subject_name->name)) {
                        $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                    } else {
                        $this->data['relation_subject'][$rcnt] = 'None';
                    }

                    if (isset($relation_chapter_name->name)) {
                        $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                    } else {
                        $this->data['relation_chapter'][$rcnt] = 'None';
                    }
                }
            }
	
	
	/*End relate module*/
	
    $this->data['allcategories']=$categoryArray;
    $this->data['listing']=$listing;
	$this->data['maincontent_id']=$id;
    $this->data['content']='listings/listings';    
    $this->load->view('common/template',$this->data);                 
    }
    
    public function add_listing() {
      $post_date = $this->input->post("postdate"); 
      $post_date=str_replace('/', '-', $post_date);
      $post_time = strtotime($post_date);
      $zip_field_name_html='article_zip_file';
 
         if($this->input->post("update")){ 
                   $zip_field_name_html ='zip_content_title';
                   $zipfolder_path = '/upload_pdf/'; 
                   $extractfolder_path_html='/upload/html_folder/'; 
                   
                    if($_FILES[$zip_field_name_html]['name']!=''){
                    /*Multiple Upload section for question bank*/                                        
               /* Upload questions zip section */
                    $chaeck_space = preg_match('/\s/',$_FILES[$zip_field_name_html]['name']);      
                                    if($chaeck_space==1){
                    $this->session->set_flashdata('message', 'Please check your zip file.There may be space in file name.');
		    redirect('admin/listings/edit_listing/'.$this->input->post("update"));
                                    die();
                                    }
                                    if($_FILES[$zip_field_name_html]['name']!=''){
                                             
                                        $extract_file_name = upload_extract_file($zipfolder_path, $extractfolder_path_html, $zip_field_name_html, $extract = 'yes');  
                                        if($extract_file_name =='failed'){
					redirect($this->input->post('redir'));
					}  
                                        
                                         }else{
                                             
                                           $extract_file_name ='failed'; 
                                           
                                         }
                                        
                                        $html_folder_name_path=$extractfolder_path_html.$extract_file_name;
                     //fatch question answer from uploaded html folder                                          
       
                                        $text_question_answer=get_content_array_by_zip($html_folder_name_path,$extractfolder_path_html);
                                        
                                        
                                        $content_question_answer =clear_html_text_two($text_question_answer); 
                                        }
               /*zip Upload section for Article*/
                                 if(isset($extract_file_name)&&($extract_file_name!='')){
$question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*',$content_question_answer);
	$question_answer_description_count = count($question_answer_description_multiple_array);
        		
			$single_array_qus_ans = clear_html_text($question_answer_description_multiple_array[0]);

                        $single_qus_ans=explode('*-answer-*',$single_array_qus_ans);
                        $qus_text_var = $single_qus_ans[0];
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);
                        
                        $ans_text_var =$single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text =remove_tabSpace($ans_text_var); 
                        
                        $title = $qus_text;
                   $description = $ans_text;
                }else{
                   $title = $this->input->post('title');
                   $description = $this->input->post('description');
                } 
          $config['upload_path']=$_SERVER['DOCUMENT_ROOT'].'/assets/upload/';
          $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf'; 
          $this->load->library('upload', $config);
          $file_name=null;
          $image =$this->input->post('image');
          $update_id=$this->input->post("update");
          $image_url = $this->input->post('image_url');
          $rss_url = $this->input->post('rss_url');
          $external_url = $this->input->post('external_url');
          $category = $this->input->post('category');
          $subject = $this->input->post('subject');     
          $chapter = $this->input->post('chapter');
          $external_link = $this->input->post('external_link');          
          $category_other =$this->input->post('category_other');
          $top_parents=$this->categories_model->getParents($category_other);
          $top_category_id=$top_parents[count($top_parents)-1];
                            
                   if($this->upload->do_upload('file')!=null){
                      $m_img_real= $_SERVER['DOCUMENT_ROOT'].'/assets/upload/'.$image;
                      $m_img_thumbs = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/'.'200_300_'.$image;
                   
                      unlink($m_img_real);
                      unlink($m_img_thumbs);
                      $filedata = array('upload_data' => $this->upload->data());
                      $file_name=$filedata['upload_data']['file_name'];
                    }
                   if($external_url!=null){
                       $external=$external_url;
                   }else{

                    if($file_name!=null){
                       $external=$file_name;
                     }elseif($image_url!=null){

                      $external=$image_url;
                     }elseif($rss_url !=null){
                        $external=$rss_url;
                     }else{
                      $external=$image;
                     }
                   }
                   $published=1;
                  $date = time();
                  
                   if($post_time!=''){
                     $dt_modified=$post_time;
                  }else{
                      
                     $dt_modified=$date;
                  }
                  
                  

                  if($category_other!=''){
                  $update_data=array(
                  'title' => $title,
                  'description' => $description,
                  'external_url' => $external,
                  'external_link' => $external_link,
                  'category_id'=>$category_other,
                  'subject_id'=>0,
                  'chapter_id'=>0,
                  'top_category_id' =>  $top_category_id,
                  'published' => $published,                             
                  'dt_created' =>$dt_modified,     
                  'dt_modified' => $dt_modified
                  );
                  }else{
                         $update_data=array(
                  'title' => $title,
                  'description' => $description,
                  'external_url' => $external,
                  'external_link' => $external_link,
                  'category_id'=>$category,
                  'subject_id'=>$subject,
                  'chapter_id'=>$chapter,
                  'published' => $published,                             
                  'dt_created' =>$dt_modified,
                  'dt_modified' => $dt_modified
                  );
                      
                  }
                 //echo $post_time.'----'.$dt_modified.'==='.$date; die;
                                   
                   $this->posting_model->update_posting($update_id,$update_data);
                   redirect($this->input->post('redir'));
                   //redirect(base_url().'admin/listings/edit_listing/'.$update_id);
                   }else{
                   $userid = $this->session->userdata('userid');
                   $this->load->model('posting_model');
                   $adtype =$this->input->post('adtype');
                   $category_id =$this->input->post('category');
                   $top_parents=$this->categories_model->getParents($category_id);
                   $top_category_id=$top_parents[count($top_parents)-1];
                   $title = $this->input->post('title');
                   $description = $this->input->post('description');
                   $image_url = $this->input->post('image_url');
                   $rss_url = $this->input->post('rss_url');
                   $external_url = $this->input->post('external_url');
                   $external_link = $this->input->post('external_link');
                   $config['upload_path']=$_SERVER['DOCUMENT_ROOT'].'/assets/upload/';
                   $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                   $this->load->library('upload', $config);
                   $file_name=null;
                   $this->upload->do_upload('file');

                    $filedata = array('upload_data' => $this->upload->data());
                    
                    $file_name=$filedata['upload_data']['file_name'];

                   if($external_url!=null){
                       $external=$external_url;
                   }else{
                      if($file_name!=null){
                       $external=$file_name;
                      }else{
                        $external=$image_url;
                      }
                   }
                  $published=1;
                  $date = time();
                  if($post_time!=''){
                     $dt_created=$post_time;
                  }else{
                      
                     $dt_created=$date;
                  }
                  
                  if($adtype == 4){
                      $external   =$rss_url;
                  }
                  $post_data = array(
                  'title' => $title,
                  'description' => $description,
                  'user_id' => $userid,
                  'adtype'=>$adtype,
                  'external_url' => $external,
                  'external_link' => $external_link,
                  'category_id' => $category_id,
                  'top_category_id' =>  $top_category_id,
                  'published' => $published,
                  'dt_created' =>$dt_created
         	 );
                  
                $this->posting_model->add_post($post_data);
                redirect($this->input->post('redir'));

              }
    }

    public function add_rsslist(){
      $userid = $this->session->userdata('userid');
      $this->load->model('posting_model');
      
      $category_id =$this->input->post('rsscatgeory_id');
      $items=$this->input->post('chkid');
       $date = time();
      foreach($items as $item){
        $item=urldecode($item);
        $item=unserialize($item);
       

        preg_match( '@src="([^"]+)"@' , $item['external_url'], $match );

        $src = array_pop($match);
        $post_data = array(
                  'title' => $item['title'],
                  //'description' => $description,
                  'user_id' => $userid,
                  'adtype'=>3,
                  'external_url' => $src,
                  'external_link' => $item['external_link'],
                  'category_id' => $category_id,
                  'published' => 1,
                  'dt_created' =>$date,
                  'dt_modified' => $date
           );
                  
              
            $this->posting_model->add_post($post_data);
      }
     
                 
                   redirect(base_url().'admin/listings');


    }

    public function filter($id=null) {

      $id = $this->input->post('filter_cat');

                $config["base_url"] = base_url() . "admin/listings/filter/index/id";
                $config["total_rows"] = $this->posting_model->count_all_post();
                $config["per_page"] =  $this->config->item('records_per_page');
                $config["uri_segment"] = 3;
                $config["num_links"] = 1;
                $config['prev_tag_open'] = '<a>';
                $config['next_link'] = '<button>Next</button>';
                $config['prev_link'] = '<button>Previous</button>';
                $config['prev_tag_close'] = '</a>';
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                $postings=$this->posting_model->get_filter_Posting($config["per_page"], $page,$id);
                //print_r($postings);die;
                 
                $this->data["links"] = $this->pagination->create_links();
                $this->data['postings']=$postings;         
                 $this->load->model('categories_model');  
                $query=$this->categories_model->getParentCategories();
                $this->data['parent_categories']=$query;     
               $this->data['content']='listings/listings';
               $this->load->view('common/template',$this->data);
    }



}
?>
