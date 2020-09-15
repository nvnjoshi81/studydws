<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chapters extends MY_Admincontroller {

        public function __construct()
        {
            parent::__construct();
            $this->load->library("pagination");
            $this->load->library('form_validation');
            $this->load->helper(array('form', 'url'));
            $this->load->model('Chapters_model'); 
            $this->load->model('Examcategory_model');
            $this->load->model('Subjects_model');
            $this->load->model('Categories_model');
            $exams=$this->Examcategory_model->getAdminExamCatgeories();
            $this->data['exams']=  $exams;
            $this->data['subjects']= $this->Subjects_model->getSubjects();
                        
        }
        public function index($page=0)
        {   
                $ordercol=$this->input->get('col');
                $order=$this->input->get('order');
                if(!$ordercol){
                    $ordercol='id';
                }if(!$order){
                    $order='desc';
                }
                /***** pgination _categories***   */
                $total=$this->Chapters_model->getChaptersCount();
                $this->data['total']=$total;
                $config = array();
                $config["base_url"] = base_url() . "admin/chapters/index/";
                $config["total_rows"] = $total;
                $config["per_page"] = $this->config->item('records_per_page');
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
                $config['reuse_query_string'] = true;
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                $this->data['page']=$page;
                $this->data['ordercol']=$ordercol;
                $this->data['order']=$order;
                $this->data["links"] = $this->pagination->create_links();
				$chapter_details=array();
				$chapters =$this->Chapters_model->getChapters($config["per_page"], $page,$ordercol,$order); 
				foreach($chapters as $chapter){
					$classesDetail_name=array();
					$subjectDetail_name=array();
					$classes=$this->Chapters_model->getChapterClasses($chapter->id);
					$subjects=$this->Chapters_model->getChapterSubjects($chapter->id);
					
					foreach($classes as $classesfild){
					$classesDetail=$this->Categories_model->getCategoryDetails($classesfild->class_id);
				
					$classesDetail_name[]=$classesDetail->name;
					}
					
					foreach($subjects as $subjectsfild){
					$subjectDetail=$this->Subjects_model->getSubject($subjectsfild->subject_id);
					$subjectDetail_name[]=$subjectDetail->name;
					}
				
 					$chapter_details[]=array('id'=>$chapter->id,'name'=>$chapter->name,'classes'=>implode(",", array_unique($classesDetail_name)),'subjects'=>implode(",", array_unique($subjectDetail_name)),'order'=>$chapter->order);
				}			
                $this->data['chapters']=  $chapter_details;      
                $this->data['content']='chapters/index';
                               
                $this->load->view('common/template',$this->data);
        }
		
		
        public function copySort(){
        
		$chapterDetails =$this->Chapters_model->getChapterDetails(); 
		
		foreach($chapterDetails as $chapDetail){
			echo $chapDetail->id.'...'.$chapDetail->class_id.'...'.$chapDetail->subject_id.'...<'.$chapDetail->sororder.'>...'.$chapDetail->order.'.<br>';
		
			if($chapDetail->id>0){
			//$this->Chapters_model->getChapterDetailsEnter($chapDetail->class_id,$chapDetail->subject_id,$chapDetail->chapter_id,$chapDetail->order);
			}			
			
			
		}
		
		}
		
		
		
        public function add(){
            
        
	$this->form_validation->set_rules('name', 'Name', 'required');
	
	

	// $this->form_validation->set_rules('description', 'description','required');

	if ($this->form_validation->run() == FALSE) {
		$this->index();
	}
	else {
		$data = array(
			'name' => $this->input->post('name') ,
			'order' => $this->input->post('order') ,
			'description' => $this->input->post('description') ,
			'keywords' => $this->input->post('keywords') ,
			
			'tagline' => $this->input->post('tagline')
		);
		if ($this->input->post("update")) {
                   
                    $update_id = $this->input->post("update");
		    $this->Chapters_model->updateChapter($data, $update_id);
                    $this->Chapters_model->unlinkChapter($update_id);
                    $classes=  $this->input->post('class');
                        $subjects=  $this->input->post('subject');
                        foreach($classes as $key=>$value){
                            foreach($subjects as $k=>$v){
                                $subdata=array('chapter_id'=>$update_id,
                                'class_id'=>$value,  'subject_id'=>$v,
								'sortorder'=>$this->input->post('order'));
                                $this->Chapters_model->linkChapter($subdata);
                            }
                        }
			//echo "<h3>Chapter Updated</h3>";
		}
		else {
			$chapter_id= $this->Chapters_model->addChapter($data);
                        $classes=  $this->input->post('class');
                        $subjects=  $this->input->post('subject');
                        foreach($classes as $key=>$value){
                            foreach($subjects as $k=>$v){
                                $subdata=array('chapter_id'=>$chapter_id,
								'class_id'=>$value,'subject_id'=>$v,
								'sortorder'=>$this->input->post('order'));
                                $this->Chapters_model->linkChapter($subdata);
                            }
                        }
			//echo "<h3>Chapter Added</h3>";

			//    redirect('admin/categories');

		}

		redirect('admin/chapters');
	}

	// redirect('admin/categories');
	//   $this->loade->view("categories");

    }
    public function edit($id){
        $total=$this->Chapters_model->getChaptersCount();
        $this->data['total']=$total;
        $ordercol=$this->input->get('col');
                $order=$this->input->get('order');
                if(!$ordercol){
                    $ordercol='id';
                }if(!$order){
                    $order='desc';
                }
                $this->data['ordercol']=$ordercol;
                $this->data['order']=$order;
	$chapter = $this->Chapters_model->getChapter($id);
        $chapterClasses=$this->Chapters_model->getChapterClasses($id);
        $chapterSubjects=$this->Chapters_model->getChapterSubjects($id);
        $chapter_classes=array();
        $chapter_subjects=array();
        if(count($chapterClasses)>0){
            foreach($chapterClasses as $class){
                $chapter_classes[]=$class->class_id;
            }
        }
        if(count($chapterSubjects)>0){
            foreach($chapterSubjects as $subject){
                $chapter_subjects[]=$subject->subject_id;
            }
        }
        $this->data['chapter_classes']=$chapter_classes;
        $this->data['chapter_subjects']=$chapter_subjects;
	$this->data['result'] = $chapter;
	$this->data['content'] = 'chapters/index';
	$this->load->view('common/template', $this->data);
    }
    
    public function delete($id){
        $this->Chapters_model->deleteChapter($id);
        redirect('admin/chapters');
    }
    public function get($exam,$subject){
        $chapters=$this->Chapters_model->getChapterByExamSubject($exam,$subject);
        $chapters_array=array();
        foreach($chapters as $chapter){
            $chapters_array[]=array('id'=>$chapter->chapter_id,'name'=>$chapter->name);
        }
        echo json_encode($chapters_array);
    }
    public function get_multiple($exam,$subject){
        
        $chapters=$this->Chapters_model->getChapterByExamSubject_multiple($exam,$subject);
        $chapters_array=array();
        foreach($chapters as $chapter){
            $chapters_array[]=array('id'=>$chapter->chapter_id,'name'=>$chapter->name);
        }
        echo json_encode($chapters_array);
    }
    
    
    public function getChapterByName($name){
        $chapters=$this->Chapters_model->getChapterByName(urldecode($name));
        if($chapters){
            $chapters_array=array();
            foreach($chapters as $chapter){
                $chapters_array[]=array('id'=>$chapter->id,'name'=>$chapter->name);
            }
        echo json_encode($chapters_array);
        }else{
            echo json_encode(array());
        }
    }
    public function search(){
        $search=$this->input->post('search');
        $searchid=$this->input->post('searchid');
        if($searchid!=''){
        $chapters=$this->Chapters_model->getChapterById($searchid);
        }else{
            
        $chapters=$this->Chapters_model->getChapterByName(urldecode($search));
        }
        $chapter_details=array();
        foreach($chapters as $chapter){
					$classesDetail_name=array();
					$subjectDetail_name=array();
					$classes=$this->Chapters_model->getChapterClasses($chapter->id);
					$subjects=$this->Chapters_model->getChapterSubjects($chapter->id);
					
					foreach($classes as $classesfild){
					$classesDetail=$this->Categories_model->getCategoryDetails($classesfild->class_id);
				
					$classesDetail_name[]=$classesDetail->name;
					}
					
					foreach($subjects as $subjectsfild){
					$subjectDetail=$this->Subjects_model->getSubject($subjectsfild->subject_id);
					$subjectDetail_name[]=$subjectDetail->name;
					}
				
 					$chapter_details[]=array('id'=>$chapter->id,'name'=>$chapter->name,'classes'=>implode(",", array_unique($classesDetail_name)),'subjects'=>implode(",", array_unique($subjectDetail_name)),'order'=>$chapter->order);
				}
                                $this->data['chapters'] = $chapter_details;
	$this->data['content'] = 'chapters/search';
	$this->load->view('common/template', $this->data);
    }
}

?>
