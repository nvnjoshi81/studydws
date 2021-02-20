<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Content extends MY_Admincontroller {

        public function __construct()
        {
            parent::__construct();
            
            $this->load->library("pagination");
            $this->load->library('form_validation');
            $this->load->helper(array('form', 'url'));$this->load->model('Content_model');  
            $this->data['content_type']=$this->Content_model->getContentType();           
        }
		
        public function index($page=0)
        {   
                /***** pgination _categories***   */
                $config = array();
                $config["base_url"] = base_url() . "admin/content/index/";
                $config["total_rows"] = $this->Content_model->getContentTypeCount();
                $config["per_page"] =   $this->config->item('records_per_page');
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
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;                           $this->data['content_type']=$this->Content_model->getContentTypeLimit($config["per_page"],$page);
                $this->data["links"] = $this->pagination->create_links();        
                $this->data['content']='content/index';
                $this->load->view('common/template',$this->data);
        }
        public function add(){
        
          $this->form_validation->set_rules('name', 'Name','required');
          
          //$this->form_validation->set_rules('description', 'description','required');
          if ($this->form_validation->run() == FALSE){
              $this->session->set_flashdata('message', $add_content_type->name . ' Content Type Name is required!');
	      redirect('admin/content');

            }else{            
         $this->data = array(
            'name' => $this->input->post('name'),
            'order' => $this->input->post('order'));
            if($this->input->post("update")){
                  $update_id=$this->input->post("update");
                  $this->Content_model->updateContentType($update_id,$this->data);
          $this->session->set_flashdata('message', 'Content Type Updated!');
             }else{
             echo  $result = $this->Content_model->addContentType($this->data);
          $this->session->set_flashdata('message', 'Content Type Added!');
        //    redirect('admin/categories');
             }        
	redirect('admin/content');
          }         
        }
        public function edit($id){
            /*     edit categories */             
            $result=$this->Content_model->getContentTypeDetail($id);
            //print_r($result); die;
            $this->data['result']=$result;
            $this->data['content']='content/index';
            $this->load->view('common/template',$this->data);                            
        }
        
        public function delete($id)
        {
                $this->Content_model->deleteContentType($id);
                $this->session->set_flashdata('message', 'Content Type Deleted!');
                redirect('admin/content');
        }
		public function deloption($answerid,$qusid,$typeid,$modeidd){
			/*For delete answer option */	
			$this->Content_model->delete_cmsanswers_byid($answerid);
                $this->session->set_flashdata('message', 'Answers Option Deleted!');
			  redirect('admin/content/editcontent/'.$qusid.'/'.$typeid.'/'.$modeidd);}
       
	   public function editcontent($id,$type=0,$moduleid=0) {            
            $type = urldecode($type);
			$all_lang='english';
			$typename=="";
            /* question bank */
			if($type==7){ 
			$this->load->model('Questionbank_model');
			$question=$this->Questionbank_model->detailsrelation($moduleid);
$all_lang=$question->language;			
			$typename='Question Bank';
			}
			/* Notes (Article) */
			else if($type==8){
			$this->load->model('Posting_model');
			$question=$this->Posting_model->getPostinginfo($moduleid);
			$typename='Notes';	
			$all_lang=$question->language;
			}
			/* Ncert Solutions */
			else if($type==9){
			$this->load->model('Ncertsolutions_model');
			$question=$this->Ncertsolutions_model->detail($moduleid);
			$typename='Ncert Solutions';
			$all_lang=$question->language;			
			}
			/* Solved Papers */
			else if($type==10){
			$this->load->model('Solvedpapers_model');
			$question=$this->Solvedpapers_model->detail($moduleid);
			$typename='Solved Papers';	
			$all_lang=$question->language;	
			}
			/* Books */
			else if($type==4){
			$this->load->model('Books_model');
			$question=$this->Books_model->details($moduleid);
//print_r($question);	
			$typename='Books';		
	$all_lang=$question->language;		
			}
			/* Sample Papers */
			else if($type==6){
			$this->load->model('Samplepapers_model');
			$question=$this->Samplepapers_model->detail($moduleid);
//print_r($question);	
	$typename='Sample Papers';	
	$all_lang=$question->language;		
			}
			
			$this->data['language']=$all_lang;	
                $this->load->model('Questions_model');
                $question=$this->Questions_model->detail($id);
                $answers=$this->Questions_model->answers($id);
                $modified_by_text = $this->session->userdata("userid");
                $dt_modified_text = time();  
                $qdata=array('id'=>$id,
                             'dt_created'=>$dt_modified_text,
                             'created_by'=>$modified_by_text);                
                
                 $adata=array('question_id'=>$id,
                             'dt_created'=>$dt_modified_text,
                             'created_by'=>$modified_by_text);
                 
                $adata=array();
                if(isset($question)&&count($question)>0){
                $this->data['question']=$question;
                }else{
                $this->Questions_model->createQBlank($qdata,$type);
                $this->data['question']=array();
                }
                if(isset($answers)&&count($answers)>0){
                $this->data['answers']=$answers;
                }else{
                    
                $this->Questions_model->createABlank($adata,$type);
                $this->data['answers']=array();
                }
			$this->data['type']=$type;
			$this->data['loadMathJax']='yes';
			$this->data['typename']=$typename;
            $this->data['content']='content/question';
            $this->load->view('common/template',$this->data);
        }
        
        //For video edit delete 
        
        public function deletevideo($id,$mtypeid,$mid)
        {       $this->Content_model->delete_cmsvideos_byid($id);
                $this->Content_model->delete_cmsvideolist_details_byid($id);
                $this->session->set_flashdata('message', 'Video Deleted!');
                redirect('admin/contents/edit/'.$mid.'/'.$mtypeid);
        }
        
        public function editvideos($id,$module_type,$module_id) {
                $type = urldecode($module_type);
                $this->load->model('Videos_model');
                $this->load->model('Contents_model');
                $this->load->model('Pricelist_model');
                $question=$this->Videos_model->getVideoDetails($id,2);
                $array_video_source=$this->Contents_model->getVideoSource(); 
				$array_video_by=$this->Contents_model->getVideoBy();
                $array_is_featured=$this->Contents_model->getIsFeatured(); 
                $array_status=$this->Contents_model->getStatus();
                $price_array=$this->Pricelist_model->getDetails_bymoduleID($module_id);
                $this->data['price_array']=$price_array;
                $this->data['question']=$question;
                 $this->data['video_id']=$id;
                $this->data['module_id']=$module_id;
                $this->data['module_type_id']=$type;
                $this->data['array_video_source']=$array_video_source;
				$this->data['array_video_by']=$array_video_by;
				$this->data['array_is_featured']=$array_is_featured;
                $this->data['array_status']=$array_status;
                $this->data['content']='content/videoinfo';
                $this->load->view('common/template',$this->data);
        }
        
        
        public function updatevideos_info($id,$module_type_id,$module_id) {           
                $this->load->model('Contents_model');
                $date = time();
                $common_file_name=$this->input->post('common_file_name');
                $videos_insert_id = $this->input->post('id');
                $video_source=$this->input->post('video_source');
                $video_url_code=$this->input->post('video_url_code');
                $is_featured=$this->input->post('is_featured');
                $description=$this->input->post('description'); 
                $video_by=$this->input->post('video_by');
                $videolist_by='Studyadda';
                $status=$this->input->post('status');
                $custom_video_duration=$this->input->post('custom_video_duration');
                $amazonaws_link=$this->input->post('amazonaws_link');
                $androidapp_link=$this->input->post('androidapp_link');
                $amazon_cloudfront_domain =$this->input->post('amazon_cloudfront_domain');
		$video_file_name=$common_file_name;
                $upload_type = $this->input->post('video_upload_type');             
                $name = $this->input->post('video_name');
		$price = $this->input->post('video_price');
                $discounted_price = $this->input->post('discounted_price');
                $video_tag = $this->input->post('video_tag');
                $price_id = $this->input->post('price_id');
                $video_image_in_db = $this->input->post('video_image_in_db');
                //Array for video description
                        if($name=='')
                        {
                        $this->session->set_flashdata('message', 'Please Enter Video name.');
                        redirect('admin/contents/add'); 
                        die();
                        }
                 
                        $price_data = array(
                                        'item_id' => $videos_insert_id,
					'type' => $module_type_id,
					'price' => $price,
                    'discounted_price' => $discounted_price,
					'dt_created' => $date,
					'modules_item_id' => $module_id,
					'modules_item_name' => $name
				);
                        /*
						//Price not required for video
                        if($price_id>0){
                               //$this->Contents_model->update($price_id,$price_data);
                          }  else {
                               //$price_id = $this->Contents_model->add($price_data);
                          }
						  */
                      $videofolder_path='/assets/videoimages/';                  
                      $video_file_field_name='video_file';
                      $extract_file_name_one='';
                                if($_FILES[$video_file_field_name]['name']!=''){
                    
                      $extract_file_name_one = upload_extract_file($videofolder_path, '' , $video_file_field_name, $extract = 'no');
                             
                                        }
                                  $var_filename_video='';      
                                         if(($extract_file_name_one != 'failed') && ($extract_file_name_one != '')){
                        $var_filename_video=$extract_file_name_one;
                             }else if($common_file_name!=''){
                        $var_filename_video=$common_file_name;
                                       
                        }
                        
                      $filetype = 'videos';
                      $imagefolder_path='/assets/videoimages/';                  
                      $video_image_field_name='video_image';                 
                                        // Video image upload
                       $videoimage_file_name='';
                      if($_FILES[$video_image_field_name]['name']!=''){
                      
                                $videoimage_file_name = video_image_upload($imagefolder_path, $video_image_field_name,$videos_insert_id);  
                      }     
                        
                        if(($videoimage_file_name=='')||($videoimage_file_name=='failed')){
                        $videoimage_file_name='image_'.$videos_insert_id.'.jpg';
                        }
                                        // update image field
                                        $data_files = array(
						'title' => $name,
						'video_source' => $video_source,
                                                'video_url_code' => $video_url_code,
						'video_file_name' => $var_filename_video,
                                                'video_image' =>$videoimage_file_name,
                                                'video_source' => $video_source,
                                                'video_url_code' => $video_url_code,
                                                'is_featured' => $is_featured,
                                                'description' => $description,
                                                'video_by' => $video_by,
                                                'status' => $status,
                                                'video_tag' => $video_tag,
                                                'custom_video_duration' => $custom_video_duration,
             'androidapp_link'=>$androidapp_link, 'amazonaws_link' => $amazonaws_link,
                                                'amazon_cloudfront_domain' => $amazon_cloudfront_domain
                                            );
                                        
			$this->Contents_model->update_cmsvideos($videos_insert_id,$data_files);                  
                        
        $this->session->set_flashdata('message', 'Video Information updated!');
        redirect('admin/content/editvideos/'.$id.'/'.$module_type_id.'/'.$module_id);   
        }
        
        public function update(){
                $question_id = $this->input->post('question_id');
                $question_text = $this->input->post('question');
                $description_text = $this->input->post('description');
                $type = $this->input->post("type");
                $instructions_id = $this->input->post("instructions_id");
				$calce = $this->input->post("calce");
		$section = $this->input->post("section");                
		$section_name = $this->input->post("section_name");
		$answer_count = $this->input->post("answer_count");
                $modified_by_text = $this->session->userdata("userid");
                $back_url = $this->input->post("back_url");
                $chapter_id = $this->input->post("chapter_id");
                $dt_modified_text = time();    
                
                //$question_text=str_ireplace('<p>','',$question_text);
               // $question_text=str_ireplace('</p>','',$question_text);
                
            $question_data = array(
				'question' => trim($question_text),
				'description' => trim($description_text),
                                'type'=>trim($type),
                                'section'=>trim($section),
                                'section_name'=>trim($section_name),
                                'instructions_id'=>trim($instructions_id),
                                'chapter_id' =>trim($chapter_id),
                                'calculator' =>$calce,
				                'modified_by' => $modified_by_text,
                		'dt_modified' => $dt_modified_text
				);
                
                                $this->load->model('Questions_model');
               
                                $this->Questions_model->update_question($question_id,$question_data);   
                                for($i=0;$i<$answer_count;$i++){ 
                                    $answer = $this->input->post('answer_'.$i);
                                    $answer_description = $this->input->post('answer_description_'.$i);
                                    
                                    if($answer_description!=''){
                                        $iscorrect=1;
                                        }else{
                                        $iscorrect=0;                                            
                                        }   
                                        
                $answer=str_ireplace('<p>','',$answer);
                $answer=str_ireplace('</p>','',$answer);
                $answer_description=str_ireplace('<p>','',$answer_description);
                $answer_description=str_ireplace('</p>','',$answer_description);
                
                                   $answer_data[$i] = array(
                                        'answer' => $answer,
					'description' => $answer_description,
                                       'is_correct' => $iscorrect,
					'modified_by' => $modified_by_text,
					'dt_modified' => $dt_modified_text
				);
                                   
                                }  
                                
                                $answer_id_array = $this->Questions_model->answers($question_id);
                                
                                //print_r($answer_id_array);  
                                for($ai=0;$ai<count($answer_id_array);$ai++){ 
                                $this->Questions_model->update_answer_by_answerid($answer_id_array[$ai]->id,$answer_data[$ai]);
                               }
                                $this->session->set_flashdata('message', 'Question Updated.');
                                if(isset($back_url)){
                                redirect($back_url);
                                }else{
                                    redirect('admin/content/editcontent/'.$question_id.'/questions');
                                
                                }       
                                }
        
        public function view($type) {
            $content=$this->Content_model->getContentTypeDetail($type);
            $this->data['type']=$content;
            if($content->name == 'Question Bank'){
                 $this->load->model('Questionbank_model');
                 $qb=$this->Questionbank_model->getQuestionBank();
                 $this->data['results']=$qb;
            }
            if($content->name == 'Sample Papers'){
                 $this->load->model('Samplepapers_model');
                 $sp=$this->Samplepapers_model->getSamplePapers();
                 $this->data['results']=$sp;
            }
            $this->data['content']='content/view';
            $this->load->view('common/template',$this->data);
            
        }
        
        
        public function remove_file_byid($id,$module_id,$module_type_id){
            
            $content=$this->Content_model->getContentTypeDetail($module_type_id);
            
            if($content->name == 'Videos'){
                
            }else{
             $this->load->model('File_model');
             $query = $this->File_model->unlink_and_remove_byId($id,$module_id,$module_type_id);
             
             if(isset($query[0]->filepath)){
                 $file_path=$query[0]->filepath;
                 
             }else{
                 
                  $file_path='/upload/webreader/';
             }
              if(isset($query[0]->filepath_one)){
                 $file_path_one=$query[0]->filepath_one;
                 
             }else{
                 
                  $file_path_one='/upload_pdf/';
             }
             $this->load->helper("file");
             $flexfile_delete_path= $_SERVER['DOCUMENT_ROOT'].''.$file_path.''.$query[0]->filename;
                if ((file_exists($flexfile_delete_path))&&($query[0]->filename!='')){
                    //delete_files($flexfile_delete_path,TRUE);
                    //rmdir($flexfile_delete_path);
                    }
                
                $flexfile_delete_path_one= $_SERVER['DOCUMENT_ROOT'].''.$file_path_one.''.$query[0]->filename_one;
                if ((file_exists($flexfile_delete_path_one))&&$query[0]->filename_one!=''){
                                        
                       //unlink($flexfile_delete_path_one);
                        
                }
        }
             $this->session->set_flashdata('message', 'File has been deleted!');  
             redirect('admin/contents/edit/'.$module_id.'/'.$module_type_id);
        }
    
}
?>
