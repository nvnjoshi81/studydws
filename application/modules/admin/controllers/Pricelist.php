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
			
			$price_dt_array = $this->input->post('price_dt');
			$discounted_price_dt_array = $this->input->post('discounted_price_dt');
			$date_array = $this->input->post('datevalue');
			
			$price_3m_array = $this->input->post('price_3m');
			$discounted_price_3m_array = $this->input->post('discounted_price_3m');
			$month_3m_array = $this->input->post('monthone');
			
			$price_6m_array = $this->input->post('price_6m');
			$discounted_price_6m_array = $this->input->post('discounted_price_6m');
			$month_6m_array = $this->input->post('monthtwo');
			$price_1y_array = $this->input->post('price_1y');
			$discounted_price_1y_array = $this->input->post('discounted_price_1y');	$year1_array = $this->input->post('monththree');		
					
			if($action > 0){
				
				$product_cnt=0;
				foreach($faction_pricelist_id_array as $pkey=>$pval){
					
$sub_data=NULL;   
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
				//cmsprice table entry
			$this->Pricelist_model->update($pval,$data);
			
			
			
			if(isset($price_dt_array[$product_cnt])&&$price_dt_array[$product_cnt]!=''){
				$sub_data_dt[]=array($price_dt_array[$product_cnt]);
				
			}
			
			if(isset($date_array[$product_cnt])&&$date_array[$product_cnt]!=''){
			$sub_data_dt[]=array($date_array[$product_cnt]);				
			}
			
			if(isset($discounted_price_dt_array[$product_cnt])&&$discounted_price_dt_array[$product_cnt]!=''){
				$sub_data_dt[]=array($discounted_price_dt_array[$product_cnt]);
			}	
			
			
			$sub_data[]=$sub_data_dt;
			
			$sub_data3m=array();
			if(isset($price_3m_array[$product_cnt])&&$price_3m_array[$product_cnt]!=''){
				$sub_data3m[]=array($price_3m_array[$product_cnt]);
				
			}
			
			if(isset($month_3m_array[$product_cnt])&&$month_3m_array[$product_cnt]!=''){
			$sub_data3m[]=array($month_3m_array[$product_cnt]);				
			}
			
			if(isset($discounted_price_3m_array[$product_cnt])&&$discounted_price_3m_array[$product_cnt]!=''){
				$sub_data3m[]=array($discounted_price_3m_array[$product_cnt]);
			}	
				$sub_data6m=array();
			$sub_data[]=$sub_data3m;			
			if(isset($price_6m_array[$product_cnt])&&$price_6m_array[$product_cnt]!=''){
				$sub_data6m[]=array($price_6m_array[$product_cnt]);
			}
			if(isset($month_6m_array[$product_cnt])&&$month_6m_array[$product_cnt]!=''){
			$sub_data6m[]=array($month_6m_array[$product_cnt]);				
			}
			if(isset($discounted_price_6m_array[$product_cnt])&&$discounted_price_6m_array[$product_cnt]!=''){
				$sub_data6m[]=array($discounted_price_6m_array[$product_cnt]);
			}

			$sub_data[]=$sub_data6m;
			$sub_data1y=array();
			if(isset($price_1y_array[$product_cnt])&&$price_1y_array[$product_cnt]!=''){
				$sub_data1y[]=array($price_1y_array[$product_cnt]);
			}
			if(isset($year1_array[$product_cnt])&&$year1_array[$product_cnt]!=''){
			$sub_data1y[]=array($year1_array[$product_cnt]);
			}
			if(isset($discounted_price_1y_array[$product_cnt])&&$discounted_price_1y_array[$product_cnt]!=''){
				$sub_data1y[]=array($discounted_price_1y_array[$product_cnt]);
			}
			
			$sub_data[]=$sub_data1y;
			/* for sub price with date and month */
		
				$ipp=0;
			$final_subPrice='';	
			foreach ($sub_data as $sub_data_val) { 
			//print_r($sub_data_val);echo'<br><br>';	
				$expiry_month=$sub_data_val[1][0];
				
				if($ipp==0) {
				$expiry_dt=$sub_data_val[1][0];					
					$date=date_create($expiry_dt);
					$expiryDt=date_format($date,"Y-m-d");				
					$today = date('Y-m-d');				
					$date1=date_create($today);
					$date2=date_create($expiryDt);
					$diff=date_diff($date1,$date2);
					$difference_bw = $diff->format("%a");
					$get_days=$difference_bw;							
				}else{				
					$get_days=$sub_data_val[1][0]*30;
				}
				$ipp++;
				if(!isset($pval)||$pval==''){
					$pval=0;					
				}
				if(isset($sub_data_val[0][0])&&($sub_data_val[0][0]!='')) {
					$subprice=$sub_data_val[0][0];
				}
				else {
					$subprice=0;
				}
				
				if(isset($sub_data_val[2][0])&&$sub_data_val[2][0]!='') {
					$subdisprice=$sub_data_val[2][0];
				}
				else {
					$subdisprice=0;
				}
				
				if(!isset($get_days)||$get_days=='') {
					$get_days==0;
				}
				
				$created_dt=time();
						$final_subPrice=array();
						
						
				//$final_subPrice = array("parent_id"=>$pval,"expiry_month "=>$expiry_month,"price"=>$subprice,"discounted_price"=>$subdisprice,"subscription_expiry"=>$get_days);			
				
				
				$final_subPrice['parent_id']=$pval;
				$final_subPrice['expiry_month']=$expiry_month;
				$final_subPrice['price']=$subprice;
				$final_subPrice['discounted_price']=$subdisprice;
				$final_subPrice['subscription_expiry']=$get_days;				
				$modifiedby=$this->session->userdata('userid');
				$get_sub_product=$this->Pricelist_model->get_subprice($pval,$get_days);
				
			
						
if(isset($get_sub_product->id)&&$get_sub_product->id>0){	
	$final_subPrice['dt_modified']=$created_dt;
	$final_subPrice['modified_by']=$modifiedby;	
	
	if(count($final_subPrice)>0){
	$this->Pricelist_model->update_subprice($get_sub_product->id,$final_subPrice);
	}		
}else{
	$final_subPrice['dt_created']=$created_dt;
	$final_subPrice['modified_by']=$modifiedby;	
	$this->Pricelist_model->Create_subprice($final_subPrice);	
}	
			}
			}
		
			/* // for sub price with date and month */
			
			$product_cnt++;
			}	 	
           redirect('admin/pricelist/pricechange');
			  }
			$this->data['productlist']=$productlist;

			foreach ($productlist as $porl) {
				$get_price_by_month=$this->Pricelist_model->get_price_by_month($porl->id);
				$get_price_by_month_array[]=$get_price_by_month;	
			}	
			$this->data['get_price_by_month']=$get_price_by_month_array;	
			$this->data['content']='pricelist/pricechange';
            $this->load->view('common/template',$this->data);
		}
		
		public function editproduct($id) {
			$edit_product=$this->Pricelist_model->getProducts_byid($id);
			$this->data['edit_product']=$edit_product;
			$sub_pricelist=$this->Pricelist_model->getsub_pricelist($id);
			$this->data['sub_pricelist']=$sub_pricelist;
			$this->data['content']='pricelist/editproduct';
			$this->load->view('common/template',$this->data);
		}		
		public function price_Validity() {
			if($this->input->post('setValidity')) {
				$parent_Id = $this->input->post('parent_Id');
				$proName = $this->input->post('proName');
				$pricevalidity = $this->input->post('pricevalidity');
				$price = $this->input->post('price');
				$dis_price = $this->input->post('dis_price');
				$c_dt = date('d/M/Y');				
				$data=array(
				'parent_id'=>$parent_Id,
				'name'=>$proName,
				'subscription_expiry'=>$pricevalidity,
				'price'=>$price,
				'discounted_price'=>$dis_price,
				'dt_created'=>$c_dt,
				'modified_by'=>'',
				'dt_modified'=>'',
				);
				$this->Pricelist_model->set_price_validity($data);
				$this->session->set_flashdata('update_msg','Your information has been updated successfully');
				redirect('admin/pricelist/editproduct/'.$parent_Id);	
			}			
			
		}		
		public function deletesubproduct($id,$pid) {
			$this->Pricelist_model->delete_subpro($id);
			$this->session->set_flashdata('update_msg','Sub-Product has been Deleted successfully');
			redirect('admin/pricelist/editproduct/'.$pid);			
		}		
		public function updatesubproduct($id) {
			$subpro_Id=$this->Pricelist_model->displaysubproductById($id);
			$this->data['subpro_Id']=$subpro_Id;			
			$this->data['sub_rowId']=$id;			
			$this->data['content']='pricelist/updatesubproduct';
			$this->load->view('common/template',$this->data);
			
			/* update */
			if($this->input->post('updateValidity')) {
				$sqlId=$this->input->post('sqlId');
				$parent_Id = $this->input->post('parent_Id');
				$proName = $this->input->post('proName');
				$price = $this->input->post('price');
				$dis_price = $this->input->post('dis_price');
				$m_dt = date('d/M/Y');
				//echo $parent_Id."<br>".$proName."<br>".$pricevalidity."<br>".$price."<br>".$dis_price;
				
				$data=array(
				'parent_id'=>$parent_Id,
				'name'=>$proName,
				'price'=>$price,
				'discounted_price'=>$dis_price,
				'dt_modified'=>$m_dt,
				);
				$this->Pricelist_model->update_subproduct($sqlId,$data);
				$this->session->set_flashdata('update_msg','Price for Sub-Product has been updated successfully');
				redirect('admin/pricelist/updatesubproduct/'.$id);
			/* // update */
			}
			
		}		
		public function packagecountchange_edit(){
					
			$exam_id = $this->input->post('hidden_exam_id');
			$pkgcntlist=$this->Pricelist_model->pkgCount_byExam($exam_id); 
			$this->data['pkgcntlist']=$pkgcntlist;
			$this->data['exam_id']=$exam_id;
			$action = $this->input->post('faction');
			if(isset($action)&&$action > 0){
			$pkgid_array = $this->input->post('pkgid');
			$total_package_array = $this->input->post('custom_total_package');
			$total_question_array = $this->input->post('custom_total_question');
			$product_cnt=0;
			foreach($pkgid_array as $pkey=>$pval){			
			if(isset($total_package_array[$pkey])&&$total_package_array[$pkey]!=''){
			$data['custom_total_package']=$total_package_array[$pkey];
			}
			if(isset($total_question_array[$pkey])&&$total_question_array[$pkey]!=''){
				$data['custom_total_question']=$total_question_array[$pkey];
			}
			
			if(isset($pval)&&$pval>0){
			$sqlid=$pval;
			}elseif(isset($pkgid_array[$pkey])&&$pkgid_array[$pkey]>0){
			$sqlid=$pkgid_array[$pkey];
			}else{
			$sqlid=0;
			}
			if($sqlid>0){				
$this->Pricelist_model->pkgupdate($sqlid,$data);
	$data['custom_total_package']='';
				$data['custom_total_question']='';
			}
$product_cnt++;
			}
			
			if($sqlid>0){
				
		 $this->session->set_flashdata('update_msg','Your information has been updated successfully');
			}
			//echo '<form><input type="button" value="Return to previous page" onClick="javascript:history.go(-1)"></form>';
}
            redirect('admin/pricelist/packagecountchange/'.$exam_id);	
			}
		
		public function packagecountchange($getexam_id=0){
			$contentType=1;
			$moduleid=0;
			$postexam_id = $this->input->post('exam_id');
			if(isset($getexam_id)&&$getexam_id>0){
			$exam_id = $getexam_id;
			}else if(isset($postexam_id)&&$postexam_id>0){
			$exam_id = $postexam_id;
			}else{
			$exam_id=0;	
			}
			
			if(isset($exam_id)&&$exam_id>0){
			$pkgcntlist=$this->Pricelist_model->pkgCount_byExam($exam_id);
			}else{
			$pkgcntlist=array();
			}
			$productlist=$this->Pricelist_model->allproduct_by_content($contentType);  			
			$this->data['productlist']=$productlist;			
			$this->data['pkgcntlist']=$pkgcntlist;
				
            
			$this->data['productlist']=$productlist;
			$this->data['content']='pricelist/pkgcountlist';
            $this->load->view('common/template',$this->data);			
			
		
		}
		
		
		
        
}