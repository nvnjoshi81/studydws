<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customers extends MY_Admincontroller {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('Customer_model');
            $this->load->model('Examcategory_model');
            
        }
        public function index(){
            $this->load->library('pagination');
                $ordercol=$this->input->get('col');
                $order=$this->input->get('order');
                if(!$ordercol){
                    $ordercol='id';
                }if(!$order){
                    $order='desc';
                }
                /***** pgination _categories***   */
                $total=$this->Customer_model->getAllCustomersCount();
                $this->data['total']=$total;
                $config = array();
                $config["base_url"] = base_url() . "admin/customers/index/";
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
		$customers =$this->Customer_model->getCustomers($config["per_page"], $page,$ordercol,$order); 
		$this->data['customers']=  $customers;      
                $this->data['content']='customers/index';
                               
                $this->load->view('common/template',$this->data);
        }
        public function edit($customer_id){   
            
            $this->data['user_info'] = $this->Customer_model->getCustomerDetails($customer_id);
	    $default_address = $this->Customer_model->getDefaultAddress($customer_id);
            
             $this->data['user_info_default_address']=$default_address;
            if(isset($default_address->id)&&($default_address->id>0)){
             $this->data['user_info_address'] = $this->Customer_model->getAddresses($customer_id,$default_address->id);
            }else{
              $this->data['user_info_address']='';  
            }
            
		    $this->data['mainexamcategories']=$this->Examcategory_model->getExamCatgeories(); 
            $this->data['content']='customers/edit';
            $this->load->view('common/template',$this->data);
           
        }
        
        public function updatecustomer(){
		 $firstname = $this->input->post('firstname');
		 $lastname = $this->input->post('lastname');
		 $email = $this->input->post('email');
		 $mobile = $this->input->post('mobile');
		 $schoolid = $this->input->post('schoolid');
$device_id = $this->input->post('device_id');	
$user_key = $this->input->post('user_key');			 
                 $mobile_verified = $this->input->post('mobile_verified');
                 $wallet_balance = $this->input->post('wallet_balance');
                 $status = $this->input->post('status');
                 $user_id = $this->input->post('user_id');
                 $modified_by_id = $this->session->userdata("userid");
                 $date = time();
		 $userdata = array('firstname'=>$firstname,
						   'lastname'=>$lastname,
							'email'=>$email,
							'mobile'=>$mobile,
							'mobile_verified'=>$mobile_verified,
							'wallet_balance'=>$wallet_balance,
							'schoolid'=>$schoolid,
							'device_id'=>$device_id,
							'user_key'=>$user_key,
							'status'=>$status,'modified_by'=>$modified_by_id,
                                                        'modified_dt'=>$date );
		 $this->Customer_model->updatecustomerinfo($user_id,$userdata);
		 $this->session->set_flashdata('update_msg','Your information has been updated successfully');
		 redirect('admin/customers/edit/'.$user_id);
	 }
         
         
         public function search_customer(){
                $customer_id =$this->input->post('customer_id');
                $customer_email =$this->input->post('customer_email');
                $customer_mobile =$this->input->post('customer_mobile');
                $this->data['total']=1;
                $this->data['ordercol']='id';
                $config = array();
                $config["base_url"] = base_url() . "admin/customers/index/";
                $customers =$this->Customer_model->getCustomerDetails_byparam($customer_id,$customer_email,$customer_mobile); 
                $this->data['customers']=  $customers;      
                $this->data['content']='customers/search_customer';
                $this->load->view('common/template',$this->data);
        }
           
         public function customer_by_date(){
      
                $start_date =$this->input->post('start_date');
                $end_date =$this->input->post('end_date');
                $start_date_string = strtotime($start_date);
                $end_date_string = strtotime($end_date);
                if($start_date_string == $end_date_string){
                    $end_date_string=$start_date_string+(3600*24);
                }
                //echo date('m-d-Y',$start_date_string);
                //echo date('m-d-Y',$end_date_string);
                $this->data['total']=1;
                $this->data['ordercol']='id';
                $this->data['start_date']=$start_date;
                $this->data['end_date']=$end_date;
                $config = array();
                $config["base_url"] = base_url() . "admin/customers/index/";
                
             if(($start_date=='')||($end_date=='')){
             $this->session->set_flashdata('message','Please enter both date.');
             redirect(base_url('admin/customers'));
             $this->data['customers']= NULL ;  
             }else{
             $regiType =$this->input->post('regiType');
             $this->data['regiType']=$regiType;
             $customers =$this->Customer_model->getCustomer_bydate($start_date_string,$end_date_string,$regiType); 
             //$customers_downlaod =$this->Customer_model->getCustomer_xls_downlaod($start_date_string,$end_date_string); 
             $this->data['customers']=  $customers;  
             }           
             
                $this->data['content']='customers/search_customer';
                $this->load->view('common/template',$this->data);
                
        }
        
        public function create_customer_xls($start_date,$end_date){
                $start_date_string = strtotime($start_date);
                $end_date_string = strtotime($end_date);
                 if($start_date_string == $end_date_string){
                    $end_date_string=$start_date_string+(3600*24);
                }
                
             $regiType =$this->input->post('regiType');
             $this->data['regiType']=$regiType;
                $customers_downlaod =$this->Customer_model->getCustomer_xls_downlaod($start_date_string,$end_date_string,$regiType); 
        }
          public function subscriber_search(){ 
              $start_date =$this->input->post('start_date');
                $end_date =$this->input->post('end_date');
                if($start_date == $end_date){
                $start_date_string = $start_date.' 00:00:00';
                $end_date_string=$start_date.' 00:00:00';
                }else{
                       
                $start_date_string = $start_date.' 00:00:00';
                $end_date_string = $end_date.' 00:00:00';
                }
               // print_r($this->input->post()); die;
                $config = array();
                $this->data['start_date']=$start_date;
                $this->data['end_date']=$end_date;
                $config["base_url"] = base_url() . "admin/customers/index/";
                if(($start_date=='')||($end_date=='')){
                 $this->session->set_flashdata('message','Please enter both date.');
                 //redirect(base_url('admin/subscriber_search'));
             $this->data['customers']= NULL ;  
             }else{
             $customers =$this->Customer_model->getSubscriber_bydate($start_date_string,$end_date_string); 
             $this->data['customers']=  $customers;  
             }           
             
                $this->data['content']='customers/subscriber_search';
                $this->load->view('common/template',$this->data);
          }
          public function create_subscriber_xls($start_date,$end_date){
                if($start_date == $end_date){
                $start_date_string = $start_date.' 00:00:00';
                $end_date_string=$start_date.' 00:00:00';
                }else{
                $start_date_string = $start_date.' 00:00:00';
                $end_date_string = $end_date.' 00:00:00';
                }           
                $customers_downlaod =$this->Customer_model->getSubscriber_xls_downlaod($start_date_string,$end_date_string); 
        }
		  
		public function set_password($user_id){

        $modified_by_id = $this->session->userdata("userid");
		$date = time();
		$userdata = array('password'=>'e10adc3949ba59abbe56e057f20f883e',
						   'modified_by'=>$modified_by_id,
                           'modified_dt'=>$date);
		$this->Customer_model->updatecustomerinfo($user_id,$userdata);
		$this->session->set_flashdata('update_msg','Password set 123456');
		redirect('admin/customers/edit/'.$user_id);
		}

		public function admincart($user_id){
		  $this->load->model('Cart_model');
          $this->data['user_productCart'] = $this->Cart_model->getFrCustCart($user_id); 
		  $this->data['user_info'] = $this->Customer_model->getCustomerDetails($user_id);
		  $this->data['mainexamcategories']=$this->Examcategory_model->getExamCatgeories();
          $this->data['content']='customers/usercart';
          $this->load->view('common/template',$this->data);
		}
		  
 		 public function prdcustcart($priclist_id){
		  $this->load->model('Cart_model');
          $this->data['user_productCart'] = $this->Cart_model->getCartPricelistId($priclist_id); 
		  //$this->data['user_info'] = $this->Customer_model->getCustomerDetails($user_id);
          $this->data['content']='customers/usercart';
          $this->load->view('common/template',$this->data);
		} 
		 
}
