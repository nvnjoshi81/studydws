<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends MY_Admincontroller {

        public function __construct()
        {
            parent::__construct();
          
            
            $this->load->library("pagination");
            $this->load->library('form_validation');
            $this->load->helper(array('form', 'url'));
            $this->load->model('categories_model'); 
            
        }
        public function index($page=0)
        {   
                /***** pgination _categories***   */
                $config = array();
                $config["base_url"] = base_url() . "admin/categories/index/";
                $config["total_rows"] = $this->categories_model->getcategoriesCount();
                $config["per_page"] = $this->config->item('records_per_page');
                $config["uri_segment"] = 4;
                $config["num_links"] = 5;
                $config['prev_tag_open'] = '<a>';
                $config['next_link'] = '<button>Next</button>';
                $config['prev_link'] = '<button>Previous</button>';
                $config['prev_tag_close'] = '</a>';
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                $tocategories=$this->categories_model->get_pageCategories($config["per_page"], $page);
                
                $this->data["links"] = $this->pagination->create_links();
                $this->data['tocategories']=$tocategories;         
                 $this->data['content']='categories/categories';
                if(isset($_GET['cid']) && $_GET['cid']> 0){
			             echo $selected_cat=$_GET['cid'];
            		}else{
            			$selected_cat=0;
            		}
                $this->data['allcategories']=$this->categories_model->fetchCategoryTree();
          		$parent_categories=$this->categories_model->getParentcategories();
          		$categories=$this->categories_model->getcategories($selected_cat);
               $this->data['selected_cat']=$selected_cat;
          		$this->data['categories']=$categories;
          		$this->data['parent_categories']=$parent_categories;
              $this->load->view('common/template',$this->data);
        }
        public  function filter(){
             $id = $this->input->post('cid');
             $config = array();
                $config["base_url"] = base_url() . "admin/categories/filter/index";
                $config["total_rows"] = $this->categories_model->getcategoriesCount($id);
                $config["per_page"] =  $this->config->item('records_per_page');
                $config["uri_segment"] = 4;
                $config["num_links"] = 5;
                $config['prev_tag_open'] = '<a>';
                $config['next_link'] = '<button>Next</button>';
                $config['prev_link'] = '<button>Previous</button>';
                $config['prev_tag_close'] = '</a>';
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                $tocategories=$this->categories_model->getFilterCategories($config["per_page"], $page,$id);
                $this->data["links"] = $this->pagination->create_links();
                $this->data['tocategories']=$tocategories;         
                $this->data['content']='categories/categories';
                if(isset($_GET['cid']) && $_GET['cid']> 0){
			             echo $selected_cat=$_GET['cid'];
            		}else{
            			$selected_cat=0;
            		}
            		$parent_categories=$this->categories_model->getParentcategories();
            		$categories=$this->categories_model->getcategories($selected_cat);
                $this->data['allcategories']=$this->categories_model->fetchCategoryTree();
                $this->data['selected_cat']=$selected_cat;
            		$this->data['categories']=$categories;
            		$this->data['parent_categories']=$parent_categories;
                $this->load->view('common/template',$this->data);
            
        }
        
        
        
        public  function search_filter(){
             $id = $this->input->post('cid');
             $config = array();
                $config["base_url"] = base_url() . "admin/categories/filter/index";
                $config["total_rows"] = $this->categories_model->getcategoriesCount($id);
                $config["per_page"] =  $this->config->item('records_per_page');
                $config["uri_segment"] = 4;
                $config["num_links"] = 5;
                $config['prev_tag_open'] = '<a>';
                $config['next_link'] = '<button>Next</button>';
                $config['prev_link'] = '<button>Previous</button>';
                $config['prev_tag_close'] = '</a>';
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                if(isset($_REQUEST['catename'])){
                    $catname=$_REQUEST['catename'];
                }else{
                    
                    $catname='';
                }
                $tocategories=$this->categories_model->getSearchCategories($config["per_page"], $page,$catname);
                $this->data["links"] = $this->pagination->create_links();
                $this->data['tocategories']=$tocategories;         
                $this->data['content']='categories/categories';
                if(isset($_GET['cid']) && $_GET['cid']> 0){
			             echo $selected_cat=$_GET['cid'];
            		}else{
            			$selected_cat=0;
            		}
            		$parent_categories=$this->categories_model->getParentcategories();
            		
                        
                        
                        if($catname!=''){
                         
                       $categories=$this->categories_model->getcategoriesbyname($catname);
              
                        }else{
                       
                          $categories=$this->categories_model->getcategories($selected_cat);
               
                        
                        }
                        
                        $this->data['allcategories']=$this->categories_model->fetchCategoryTree();
                $this->data['selected_cat']=$selected_cat;
            		$this->data['categories']=$categories;
            		$this->data['parent_categories']=$parent_categories;
                $this->load->view('common/template',$this->data);
            
        }

        public function add_categories()
        {
        
          $this->form_validation->set_rules('name', 'Name','required');
          $this->form_validation->set_rules('order', 'order','required');
          $this->form_validation->set_rules('cparent', 'Parent','required');
          //$this->form_validation->set_rules('description', 'description','required');
          if ($this->form_validation->run() == FALSE)
        {
              $this->index();

        }else{
           $hindicatname= $this->input->post('catname');
		   
		   if(isset($hindicatname)&&$hindicatname!=''){
		/*Save for hindi font*/
		
			 $update_id=$this->input->post("update");
        $hindidata = array(
            'categories_id' => $update_id,
            'catname' => $this->input->post('catname')
			);
			
            $this->categories_model->update_langcategories($hindidata,$update_id,'hindi');
				  
			$englishdata = array(
            'categories_id' => $update_id,
            'catname' => $this->input->post('name')
			);	
				   $this->categories_model->update_langcategories($englishdata,$update_id,'english');
		   }
		   
         $this->data = array(
            'name' => $this->input->post('name'),
            'order' => $this->input->post('order'),
            'parent_id' => $this->input->post('cparent'),
            'description' => $this->input->post('description'),
            'keywords' => $this->input->post('keywords'),
             'link' => $this->input->post('link'),
            'tagline' => $this->input->post('tagline'));
            if($this->input->post("update")){
                  $update_id=$this->input->post("update");
                  $this->categories_model->update_categories($this->data,$update_id);
                  echo "<h3>Successfull Update Category Thanks</h3>";
             }else{
             $this->categories_model->add_categories($this->data);
               
            echo "<h3>Successfull Add Category Thanks</h3>";
        //    redirect('admin/categories');
             }
        
             $this->index();
          }
          //redirect('admin/categories');
       //   $this->loade->view("categories");
        }
        public function edit_categories($id){
            
               if(isset($_GET['cid']) && $_GET['cid']> 0){
                 echo $selected_cat=$_GET['cid'];
              }else{
                 $selected_cat=0;
        }
        $parent_categories=$this->categories_model->getParentcategories();
        $categories=$this->categories_model->getcategories($selected_cat);
        $this->data['allcategories']=$this->categories_model->fetchCategoryTree();
        $this->data['selected_cat']=$selected_cat;
        $this->data['categories']=$categories;
        $this->data['parent_categories']=$parent_categories;

            /*    edit categories */             
            $result=$this->categories_model->getPrentName($id);
            $this->data['result']=$result;
			$resulthindi=$this->categories_model->getPrentNamehindi($id,'hindi');
			$this->data['resulthindi']=$resulthindi;
            $this->data['content']='categories/categories';
            $this->load->view('common/template',$this->data);
                            
        }
		
		/* code by Mahesh */
		public function sub_categories($id) {
			$id;
			$result=$this->categories_model->getPrentName($id);
			
			$this->data['result'] = $result;
			
			$parentId = $result[0]->parent_id;
					
			if($this->input->post('sub_cat')) {
					
				$sub_cat_name = $this->input->post('sub_cat_name');

				$sub_cat_order = $this->input->post('sub_cat_order');

				$sub_cat_parent = $this->input->post('sub_cat_parentId');

				$sub_cat_description = $this->input->post('sub_cat_description');

				$sub_cat_keywords = $this->input->post('sub_cat_keywords');

				$sub_cat_tagline = $this->input->post('sub_cat_tagline');

				$cat_link = $this->input->post('sub_cat_link');

				$current_dt = date('Y-m-d h:i:sa');


					$data = array('name'=>$sub_cat_name,
					'order'=>$sub_cat_order,
					'created'=>$current_dt,
					'parent_id'=>$id,
					'description'=>$sub_cat_description,
					'keywords'=>$sub_cat_keywords,
					'tagline'=>$sub_cat_tagline,
					'link'=>$cat_link);
					
					$this->Categories_model->add_categories($data);
					
					echo "<script>alert('Sub-Category Added Successfully!');</script>";
			}
			
			$get_sub_categories=$this->Categories_model->get_sub_cat($id);
			
			$this->data['get_sub_categories']=$get_sub_categories;	
			
			$this->data['content'] = 'categories/sub_categories';
            
			$this->load->view('common/template',$this->data);
		}
		
		public function update_sub_categories($id) {
			
			$get_sub_categories=$this->Categories_model->get_sub_cat1($id);
			
			$this->data['get_sub_categories']=$get_sub_categories;
			
			if($this->input->post('update_sub_cat')) {
				$id;
				
				$pid = $this->input->post('sub_cat_parentId');
				
				$sub_cat_name = $this->input->post('sub_cat_name');

				$sub_cat_order = $this->input->post('sub_cat_order');

				$sub_cat_description = $this->input->post('sub_cat_description');

				$sub_cat_keywords = $this->input->post('sub_cat_keywords');

				$sub_cat_tagline = $this->input->post('sub_cat_tagline');

				$cat_link = $this->input->post('sub_cat_link');

				$current_dt = date('Y-m-d h:i:sa');			

				$data=array('name'=>$sub_cat_name,
				'order'=>$sub_cat_order,
				'description'=>$sub_cat_description,
				'keywords'=>$sub_cat_keywords,
				'tagline'=>$sub_cat_tagline,
				'link'=>$cat_link,
				'dt_modified'=>$current_dt);
				
				$this->Categories_model->update_categories($data, $id);
				echo "<script>alert('Sub-Category Updated Successfully!');</script>";
				
				redirect('admin/categories/sub_categories/'.$pid);
			}				
			
			$this->data['content'] = 'categories/update_sub_categories';
			
			$this->load->view('common/template',$this->data);
		}
		
		/* // code by Mahesh */
		
        public function delete($id)
        {
                $this->categories_model->deleteCategory($id);
                redirect('admin/categories');
    
        }
       public function content($category_id){
           $this->load->model('Content_model');
           $content_type=$this->Content_model->getContentType();
           $category=$this->categories_model->getCategoryDetails($category_id);
           $category_content=  $this->Content_model->getCategoryContentType($category_id);
           if(count($category_content) > 0){
               $ccarray=array();
               foreach($category_content as $content){
                   $ccarray[$content->content_type_id]=$content->link;
               }
               $this->data['ccarray']=$ccarray;
           }
           $this->data['content']='categories/content_type';
           $this->data['content_type']=$content_type;
           $this->data['category']=$category;
           $this->load->view('common/template',$this->data); 
       }
       public function addcontent(){
           $this->load->model('Content_model');
           $category_id=  $this->input->post('category_id');
           $content_type_id=  $this->input->post('content_type_id');
           $content_link=  $this->input->post('content_link');
           $this->data=array('category_id'=>$category_id,
                        'content_type_id' =>$content_type_id,
                        'link'=>$content_link);
           $this->Content_model->addCategoryContent($this->data);
           redirect('/admin/categories/content/'.$category_id);
       }
       public function updatecontent(){
           $this->load->model('Content_model');
           $category_id=  $this->input->post('category_id');
           $content_type_id=  $this->input->post('content_type_id');
           $content_link=  $this->input->post('content_link');
           $action=$this->input->post('faction');
           if($action=='del'){
               $this->Content_model->deleteCategoryContent($category_id,$content_type_id);
           }elseif($action=='update'){
                $this->data=array('link'=>$content_link);
                $this->Content_model->updateCategoryContent($category_id,$content_type_id,$this->data);
           }
           redirect('/admin/categories/content/'.$category_id);
       }
}

?>
