<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pricelist extends MY_Admincontroller {

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
            $this->load->model('Content_model');
            $this->load->model('Pricelist_model');
            $exams=$this->Examcategory_model->getAdminExamCatgeories();
            $this->data['exams']=  $exams;
            $this->data['subjects']= $this->Subjects_model->getSubjects();
            $this->data['content_type']=$this->Content_model->getContentType();
        }
        public function index()
        {   
            $this->data['content']='pricelist/index';
            $this->load->view('common/template',$this->data);
        }
        public function getPrice($type,$exam_id,$subject_id=0,$chapter_id=0){
            
        $content_price=  $this->Pricelist_model->get($type,$exam_id,$subject_id,$chapter_id);
            $response=array();
            if($content_price){
                $response['data']=(array)$content_price;
                $response['success']=1;
            }else{
                $response['success']=0;
            }
            echo json_encode($response);
        }
        
        
        public function getPriceTotal($type,$exam_id,$subject_id=0,$chapter_id=0){
            $content_price_total=$this->Pricelist_model->getSum_mainprice($type,$exam_id,$subject_id,$chapter_id);   
            $total=0;
            //$response['total']=$content_price_total->total;
            foreach($content_price_total as $num){
                 $total +=$num->total;
            }
            
           $response['total']=$total;
           
            echo json_encode($response); 
        }
        
        public function getProductByExam($examid=0){
            
            if(isset($examid)&&$examid==0){
                echo 'Select or Enter Exam.Go Back!';
            }else{
            
                $product_total=$this->Pricelist_model->allproduct_by_exam($examid);   
                //print_r($product_total);
                
            $total=1;
            //$response['total']=$content_price_total->total;
            foreach($product_total as $num){
                 $total +=1;
                 echo "UPDATE `cmspricelist` SET `app_image` = '' WHERE `cmspricelist`.`id` = '$num->id' and '$num->modules_item_name' and '$num->image';".'<br>';
            }  
            }
            
            /* FROM `cmspricelist` LEFT JOIN `categories` ON `cmspricelist`.`exam_id`=`categories`.`id` LEFT JOIN `cmssubjects` ON `cmspricelist`.`subject_id`=`cmssubjects`.`id` LEFT JOIN `cmschapters` ON `cmspricelist`.`chapter_id`=`cmschapters`.`id` LEFT JOIN `cmsfiles` ON `cmsfiles`.`id`=`cmspricelist`.`item_id` WHERE `cmspricelist`.`type` in(2,1,3) AND `cmspricelist`.`price` >0 and `item_id`=0 and  `cmspricelist`.`exam_id` =28 GROUP BY `cmspricelist`.`id` ORDER BY `cmspricelist`.`price` DESC, `cmspricelist`.`id` DESC*/
        }
        
        public function addPrice(){
           $type        =  $this->input->post('content_type');
           $exam_id     =  $this->input->post('category');
           $subject_id  =  $this->input->post('subject');
           $chapter_id  =  $this->input->post('chapter');
           $price       =  $this->input->post('price');
           
           $appimage       =  $this->input->post('appimage');
           $description =  $this->input->post('description');
           $offline_status =  $this->input->post('offline_status');
           $modules_item_id  =  $this->input->post('modules_item_id'); 
           $modules_item_name  =  $this->input->post('modules_item_name'); 
           $item_id =$this->input->post('item_id');
                   $no_of_dvds=$this->input->post('total_dvds'); 
                   $no_of_lectures=$this->input->post('number_of_lectures'); 
                   $subscription_expiry=$this->input->post('subscription_validity'); 
                   $no_of_subscribers=$this->input->post('total_subscribers'); 
                   $lecture_duration=$this->input->post('lecture_duration'); 
           
            if(!$item_id){
                $item_id=0;
            }
           
           if(!$modules_item_id){
               $modules_item_id=0;
           }
           $discounted_price =  $this->input->post('discounted_price');
           $action   =  $this->input->post('faction');
           $data=array('type'=>$type,
                        'exam_id'=>$exam_id,
                        'subject_id'=>$subject_id,
                        'chapter_id'=>$chapter_id,
                        'discounted_price'=>$discounted_price,
                        'description'=>$description?$description:'',
                        'offline_status'=>$offline_status?$offline_status:0,
                        'modules_item_id'=>$modules_item_id,
                        'modules_item_name'=>$modules_item_name,
                        'price'=>$price,
                        'item_id'=>$item_id,
                        'no_of_dvds'=>$no_of_dvds,
                        'no_of_lectures'=>$no_of_lectures,
                        'subscription_expiry'=>$subscription_expiry,
                        'no_of_subscribers'=>$no_of_subscribers,
                        'lecture_duration'=>$lecture_duration
                   );
				   
				   if(isset($appimage)&&$appimage!=''){
				     $data['app_image']=$appimage;
				   }
				   
            if(isset($_FILES) && count($_FILES)>0){
                $config['upload_path'] = dirname($_SERVER['SCRIPT_FILENAME']).'/assets/frontend/product_images/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $this->load->library('upload', $config);
           
            if($this->upload->do_upload('image')){
                $imgdata = array('upload_data' => $this->upload->data());
                $imagename=$imgdata['upload_data']['file_name'];
                $data['image']=$imagename;
            }else{
                $error = array('error' => $this->upload->display_errors());
		//print_r($error);
            }
            }
		
           if($action > 0){
               $this->Pricelist_model->update($action,$data,$item_id);
           }else{
               $this->Pricelist_model->add($data);
           }
           if(!$this->input->is_ajax_request()){
           redirect('admin/pricelist');
           }
        }
		
		public function pricechange(){
			$contentType=1;
            $productlist=$this->Pricelist_model->allproduct_by_content($contentType);  
			$action = $this->input->post('faction');
			$faction_pricelist_id_array = $this->input->post('faction_pricelist_id');
			
			$modules_item_name_array = $this->input->post('modules_item_name');
			$price_array = $this->input->post('price');
			$discounted_price_array = $this->input->post('discounted_price');
			
			if($action > 0){
				$product_cnt=0;
				foreach($faction_pricelist_id_array as $pkey=>$pval){
			if(isset($modules_item_name_array[$product_cnt])&&$modules_item_name_array[$product_cnt]!=''){
				$data['modules_item_name']=$modules_item_name_array[$product_cnt];
			}
					if(isset($price_array[$product_cnt])&&$price_array[$product_cnt]!=''){
				$data['price']=$price_array[$product_cnt];
			}
			if(isset($discounted_price_array[$product_cnt])&&$discounted_price_array[$product_cnt]!=''){
				$data['discounted_price']=$discounted_price_array[$product_cnt];
			}
			if($pval>0){
$this->Pricelist_model->update($pval,$data);
			}
$product_cnt++;
			}
           redirect('admin/pricelist/pricechange');
			  }
			$this->data['productlist']=$productlist;
			$this->data['content']='pricelist/pricechange';
            $this->load->view('common/template',$this->data);
		}
		
        
}