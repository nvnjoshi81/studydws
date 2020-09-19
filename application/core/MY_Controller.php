<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    var $customer_id=null;
    public function __construct() { 
        parent:: __construct();
        $customer_basket=array();
        $customer_info=array();
        $cart_price=0;
        $show_new_contant_popup='';
        $studymaterial_count=0; 
        $video_count=0;
        $this->data['studymaterial_count']=0;
        $this->data['video_count']=0;
        //$this->output->enable_profiler(TRUE);
        //$this->db2 = $this->load->database('studyadda', TRUE);
        if($this->session->userdata('customer_id')&& $this->session->userdata('customer_id')>1){
            $this->customer_id=$this->session->userdata('customer_id');
            /*$customer_basket=$this->Customer_model->getBasket($this->customer_id);
            $customer_info=$this->Customer_model->getRegInfo($this->customer_id);
            $this->load->model('Products_model');
            
            if($customer_basket){
            foreach($customer_basket as $items){
		$product_price=$this->Products_model->getProductDetails($items->products_id,array('products_price'));
		$cart_price=$cart_price+$product_price->products_price;
            }
            }*/
        }
        
        //$this->data['cart_price']=$cart_price;
        //$this->data['customer_basket']=$customer_basket;
        //$this->data['customer_info']=$customer_info;
        $this->load->model('Pricelist_model');
        $this->data['mainexamcategories']=$this->Examcategory_model->getExamCatgeories();
        $this->data['showbreadcrumb']=false;
        /*
         * //This getTopLevelProducts() is not useful now...Commented for query optimization. 
        
        $class12=$this->Pricelist_model->getTopLevelProducts(22,2);
        $class11=$this->Pricelist_model->getTopLevelProducts(23,2);
        $classiit=$this->Pricelist_model->getTopLevelProducts(28,2);
        $classaipmt=$this->Pricelist_model->getTopLevelProducts(29,2);
         * */
		 
		 $class12=array();
		 $class11=array();
		 $classiit=array();
		 $classaipmt=array();
		 
        $this->data['class12']=array();        
        $this->data['class11']=array();
        $this->data['classiit']=array();
        $this->data['classaipmt']=array();
        $this->data['homeproducts']=array('12th Class Video Lectured'=>$class12,
                                            '11th Class Video Lectures'=>$class11,
                                            'IIT JEE Video Lectures'=>$classiit,
            'NEET Video Lectures'=>$classaipmt);
  
        
        $customer_id=$this->session->userdata('customer_id');
        if($customer_id){
        /*Start Redirect user if target exam is blank and mobile*/
        
        $customerDetails=$this->Customer_model->getCustomerDetails($customer_id);
            if ($customerDetails->mobile == '') {
                $this->session->set_userdata('ask_mobile', 1);
                }elseif($customerDetails->mobile!=''&&$customerDetails->targate_exam==''){
                    if($this->router->fetch_module()=='customer'&&($this->router->fetch_method()=='myaccount'||$this->router->fetch_method()=='updatecustomer')){
                        $redirecto_targate_page='no';
                    }else{
                        $redirecto_targate_page='no';
                    }
                    if($redirecto_targate_page=='yes'){
                    //redirect('customer/myaccount');
                    }
            
            }
        /*End Redirect user if target exam is blank*/
            // get purchased products            
            
            $products=$this->Customer_model->getCustomerProucts($this->session->userdata('customer_id'));
                $purchased=array();
               if($products){
                   foreach($products as $key=>$product){
                       $subject_id=0;
                       $exam_id=0;
                    if(isset($product->exam_id)){
                        $exam_id=$product->exam_id;
                    }   
                      
                    /*
                    if(isset($product->subject_id)){
                        $subject_id=$product->subject_id;
                    }   
                    if($exam_id>0&&$subject_id>0){     
                    $final_subject_product_id = $this->Pricelist_model->checkSubjectProduct($product->exam_id,$product->subject_id);     
                    }
                    
                    if($final_subject_product_id>0){
                            //$purchased[$product->product_type][]=$final_subject_product_id;
                    }
                       */
                       
                       $purchased[$product->product_type][]=$product->product_id;
                       $this->session->set_userdata('purchases',$purchased); 
                       
                   }
               }
               //echo print_r($this->session->userdata('purchases'));
                //print_r($purchased); 
                $this->load->model('Orders_model');
        $purchased_count=$this->session->userdata('purchases');
        if($purchased_count>0){
        if($this->session->userdata('newcontant_popup_activated')==''){        
            $show_new_contant_popup='yes';    
            $this->session->set_userdata('newcontant_popup_activated','yes');
            $last_order_array=$this->Orders_model->cust_last_order($customer_id);  
            $studymaterial_count=0;
            $video_count=0;
            if(isset($last_order_array[0]->id)&&$last_order_array[0]->id>0){
            $last_order_id=$last_order_array[0]->id;
            
            $order_detail_array=$this->Orders_model->getComplitorderDetails($last_order_id);
            if(isset($order_detail_array)&&count($order_detail_array)>0){
            foreach($order_detail_array  as $order_detail){
                //For Study Material
                if( $order_detail->type==1){
                   $studymaterial_count = $this->Orders_model->sm_count_by_date($order_detail->created_dt);
                }
                //For Videos
                if( $order_detail->type==2){
                   $video_count = $this->Orders_model->video_count_by_date($order_detail->created_dt);
                }
                    
            } }
            }
                           
                      $this->data['studymaterial_count']=$studymaterial_count;
                      $this->data['video_count']=$video_count;
        }else{
        $show_new_contant_popup='';  
        }            
        }     
        }
        $this->data['show_new_contant_popup']=$show_new_contant_popup;   
        
                $this->load->model('Macro_model');
               $all_macroarray=$this->Macro_model->getall_macro();
               foreach($all_macroarray as $key=>$macroarray){
                   if($macroarray->macro=='MACRO_OFFER_DATE'){
                      $this->data['MACRO_OFFER_DATE']=$macroarray->value;
                   }
               }
   //$this->output->enable_profiler(TRUE);
    
    }
}
class Modulecontroller extends MY_Controller{
        public function __construct() {
        parent::__construct();
        $styles=array(base_url().'assets/css/custom.css','http://fonts.googleapis.com/css?family=Open+Sans');
        //$this->data['styles']=$styles;
        $scripts=array(base_url().'assets/js/metisMenu.min.js',base_url().'assets/js/exams.js');
        //$this->data['scripts']=$scripts;
        $this->load->model('Examcategory_model');
        $this->load->model('Questionbank_model');
        $this->load->model('Samplepapers_model');
        $this->load->model('Categories_model');
        $this->load->model('Pricelist_model');
        
         /*
          * $examcategories=$this->Examcategory_model->getExamCatgeories();
       
         * //This getTopLevelProducts() is not useful now...Commented for query optimization. 
        foreach($examcategories as $examc){
           //$subject_array[$examc->id]= $this->getSubjects($examc->id);
        }
         
        */
        $examcategories=array();
        $subject_array=array();
        
        $this->data['examcategories']=$examcategories;
        $this->data['examsubjects']=$subject_array;
        
        $this->data['examsubjects']=array();
        $this->data['module_name']=$this->router->fetch_module();
        /*$class12=$this->Pricelist_model->getTopLevelProducts(22,2);
        $class11=$this->Pricelist_model->getTopLevelProducts(23,2);
        $classiit=$this->Pricelist_model->getTopLevelProducts(28,2);
        $classaipmt=$this->Pricelist_model->getTopLevelProducts(29,2);
        $this->data['class12']=$class12;
        $this->data['class11']=$class11;
        $this->data['classiit']=$classiit;
        $this->data['classaipmt']=$classaipmt;*/
        
     }
     public function getSubjects($exam_id){
        $data_array=array();
            $chaptersubjects=  $this->Examcategory_model->getExamChapters($exam_id);
            if(count($chaptersubjects) > 0){
                foreach($chaptersubjects as $record){
                        $data_array[$record->sname]['id']=$record->sid;
                }
            }
        return $data_array;
    }
}
class MY_Admincontroller extends CI_Controller { 
    public function __construct() { 
    parent::__construct(); 
	
	//$this->output->enable_profiler(TRUE);
            if(!$this->session->userdata('logged_in') && $this->session->userdata('logged_in') !== true ){
                redirect(base_url().'admin/login');
            }
            $this->load->model('Menu_model');
            $this->load->model('Admin_model');
            $this->load->model('Categories_model');
            $this->data['menuitems']=$this->Menu_model->getMenuitems();
            $userpermissions=$this->Admin_model->getUserPermissions($this->session->userdata('userid'));
            if(!$this->session->userdata('loggedincatperms') && !$this->session->userdata('loggedincatperms')){
                $mod=array();
                $cat=array();
                $subarray=array();
                foreach($userpermissions as $perms){
                    if($perms->type=='mod'){
                        $mod[]=$perms->item_id;
                    }elseif($perms->type=='cat'){
                         $subcategories=  $this->Categories_model->getAllSubCategories($perms->item_id);
                         $subarray=  array_merge($subarray,$subcategories);
                         $cat[]=$perms->item_id;
                    }
                }
                $this->session->set_userdata('loggedinmaincatperms',$cat);
                $cat=  array_merge($cat,$subarray);
                $this->session->set_userdata('loggedinmodperms',$mod);
                $this->session->set_userdata('loggedincatperms',$cat);
            }
            $current_module=$this->router->fetch_class();
            $module=  $this->Menu_model->getIdBySlug($current_module);
            if($this->session->userdata('usertype') != '1' ){
                if($current_module != 'dashboard' && !in_array($module->id, $this->session->userdata('loggedinmodperms'))){
                   // TO-DO redirect to unauthorized page
                    redirect('/admin/dashboard');
                }
            }
     }

}

class MY_Salescontroller extends CI_Controller { 
    public function __construct(){ 
        parent::__construct(); 
        $this->data['folder_admin']=$this->config->item('dir_salesadmin');
        $this->data['franchisetype']=$this->config->item('franchisetype');
        $folder_admin=$this->config->item('dir_salesadmin');
		$redirect_active=0;
		$saleslogged_in=$this->session->userdata('saleslogged_in');
		$schoollogged_in=$this->session->userdata('schoollogged_in');
        if(isset($saleslogged_in) && $this->session->userdata('saleslogged_in') == TRUE ){
				
		$redirect_active=1;
            }elseif(isset($schoollogged_in) && $this->session->userdata('schoollogged_in') == TRUE ){
				
		$redirect_active=1;
			}
if($redirect_active==0){			
			redirect(base_url().$folder_admin.'/login');
}		
			
            $this->load->model('Menu_model');
            $this->load->model('Admin_model');
            $this->load->model('Categories_model');
            $this->data['menuitems']=$this->Menu_model->getMenuitems();
            $userpermissions=$this->Admin_model->getUserPermissions($this->session->userdata('userid'));
            if(!$this->session->userdata('loggedincatperms') && !$this->session->userdata('loggedincatperms')){
                $mod=array();
                $cat=array();
                $subarray=array();
                foreach($userpermissions as $perms){
                    if($perms->type=='mod'){
                        $mod[]=$perms->item_id;
                    }elseif($perms->type=='cat'){
                         $subcategories=  $this->Categories_model->getAllSubCategories($perms->item_id);
                         $subarray=  array_merge($subarray,$subcategories);
                         $cat[]=$perms->item_id;
                    }
                }
                $this->session->set_userdata('loggedinmaincatperms',$cat);
                $cat=  array_merge($cat,$subarray);
                $this->session->set_userdata('loggedinmodperms',$mod);
                $this->session->set_userdata('loggedincatperms',$cat);
            }
            $current_module=$this->router->fetch_class();
            $module=  $this->Menu_model->getIdBySlug($current_module);
            if(isset($module->id)){
                $moduleid=$module->id;
            }else{
                $moduleid=NULL;
            }
            if($this->session->userdata('usertype') != '1' ){
                if($current_module != 'dashboard' && !in_array($moduleid, $this->session->userdata('loggedinmodperms'))){
                   // TO-DO redirect to unauthorized page
                    //redirect('/'.$this->data['folder_admin'].'/dashboard');
                }
            }
			    $this->data['mainexamcategories']=$this->Examcategory_model->getExamCatgeories();
    }
} 
?>