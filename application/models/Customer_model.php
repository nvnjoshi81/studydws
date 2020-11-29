<?php 
class Customer_model extends CI_Model{
    public function __construct() {
        $this->franchisetype=$this->session->userdata('usertype');
    }
	//Teacher functions
	
	public function get_teacherlist($techerid=0)
	{
	$this->db->select('id,teacher_id,firstname,lastname,gender,designation,email,mob');
        $this->db->from('cmsteachers');
		if($limit_start || $limit_end){
			$this->db->limit($limit_start, $limit_end);
		}
	if(isset($techerid)&&$techerid>0){
		   $this->db->where('id',$techerid);
		$query = $this->db->get();
		return $query->row();
	}else{
		$query = $this->db->get();
		return $query->result();
		
	}	
    // $this->db->order_by($ordercol,$order);
	}
	
		//Mahesh:-Teacher functions
	
	public function teacherbytid($techerid)
	{
		
		 $this->db->select('id,teacher_id,firstname,lastname,gender,designation,email,mob');
            $this->db->from('cmsteachers');
			$this->db->where('teacher_id',$techerid);
		$query = $this->db->get();
		return $query->result();
	}
	
		public function edit_teacher($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('cmsteachers',$data);     
		return; 
	}
	
	public function addteachersinfo($data){
        $this->db->insert('cmsteachers',$data);
        return $this->db->insert_id();
    }
	
	function getCustomers($limit_start=null, $limit_end=null,$ordercol='id',$order='desc')
	{
            $this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
            $this->db->from('cmscustomers');
		if($limit_start || $limit_end){
			$this->db->limit($limit_start, $limit_end);
		}
                $this->db->order_by($ordercol,$order);
		$query = $this->db->get();
		return $query->result();
	}
        
        function getFrCustomers($limit_start=null, $limit_end=null,$ordercol='c.firstname',$order='desc',$userid,$franchiseid)
	{
            $this->db->select('c.id,c.firstname,c.lastname,c.email,c.dob,c.mobile,c.status,c.targate_exam,c.usertype,c.is_social,c.fbid,c.twitterid,c.googleplusid,c.created_dt,f.id as franid,f.franchise_id');
            $this->db->from('cmscustomers AS c');
            $this->db->join('cmscust_franchise AS f','c.id=f.customer_id','right');
            $this->db->where('c.usertype',$userid);
            $this->db->where('f.franchise_id',$franchiseid);
		if($limit_start || $limit_end){
			$this->db->limit($limit_start, $limit_end);
		}
                $this->db->order_by($ordercol,$order);
		$query = $this->db->get();
		return $query->result();
	}
	public function getCustomerDetails($id)
	{
		$this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
		$this->db->from('cmscustomers');
		$this->db->where('id', $id); 
		$query = $this->db->get();
		return $query->row();
	}
	public function studentschool($franchId=0)
	{
		$this->db->select('id,school_name,franchise_id');
		$this->db->from('cmscust_school');
		if($franchId>0){
		$this->db->where('franchise_id', $franchId); 
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	
        public function getCustomerLegacy($customer_id){
		$this->db->select('id,mobile,targate_exam,usertype');
		$this->db->from('cmscustomers_legacy');
		$this->db->where('customer_id', $customer_id); 
		$query = $this->db->get();
		return $query->row();
        }
		
    public function editCustomerLegacy($data,$id){
		$this->db->where('id',$id);
		$this->db->update('cmscustomers_legacy',$data);     
		return;        
    }
     public function addCustomerLegacy($data){
        $this->db->insert('cmscustomers_legacy',$data);
        return $this->db->insert_id();
    }
    public function getCustomerDetails_byparam($customer_id,$customer_email,$customer_mobile=NULL){
            $this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
            $this->db->from('cmscustomers');
            if($customer_id>0){
            $this->db->where('id',$customer_id);
            }else{
if($customer_mobile!=NULL){
$this->db->like('mobile',$customer_mobile);
}

if($customer_email!=''){
$this->db->like('email',$customer_email);
}
}
            $query=$this->db->get();
            //echo $this->db->last_query(); 
            return $query->result();
        }
		
		 public function searchcustomer($searchcustomer){
			 $cfname=$searchcustomer['cfname'];
			 $clname=$searchcustomer['clname'];
			 $customer_email=$searchcustomer['customer_email'];
			 $customer_id=$searchcustomer['customer_id'];
			 $customer_mobile=$searchcustomer['customer_mobile'];
			 $limit_start=3;
             $limit_end=100;
			 
			$this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
            $this->db->from('cmscustomers');
         
            
			if($customer_id>0){
            $this->db->where('id',$customer_id);
            }else{
				
//            $this->db->where($where);
	$chk=1;			
if(isset($cfname)&&$cfname!=''){
 $this->db->or_where('firstname',$cfname); $chk++;
}
				
if(isset($clname)&&$clname!=''){
 $this->db->or_where('lastname',$clname);
$chk++;
}
				
if(isset($customer_mobile)&&$customer_mobile!=''){
 $this->db->or_where('mobile',$customer_mobile);  $chk++;
}
if(isset($customer_email)&&$customer_email!=''){
 $this->db->or_where('email',$customer_email); $chk++;
}
if($chk==1){
	die('Please Enter Atleast One Field!');
}
}
        $query=$this->db->get();
        return $query->result();
		}
		
        
        public function getFrCustDetails_byparam($customer_id,$customer_email=NULL,$customer_mobile=NULL,$userid,$franchiseid,$searchschool_id=0){
            $this->db->select('c.id,c.firstname,c.lastname,c.email,c.dob,c.mobile,c.status,c.targate_exam,c.usertype,c.created_dt,f.id as franid,f.franchise_id');
            $this->db->from('cmscustomers AS c');
            $this->db->join('cmscust_franchise AS f','c.id=f.customer_id','right');
            if($customer_id>0){
            $this->db->where('c.id',$customer_id);
            }
			if($searchschool_id>0){
            $this->db->where('c.schoolid',$searchschool_id);
            }
			if($customer_email!=NULL){
            $this->db->like('c.email',$customer_email);
            }
			if($customer_mobile!=NULL){
            $this->db->like('c.mobile',$customer_mobile);
            }
            $this->db->where('c.usertype',$userid);
            $this->db->where('f.franchise_id',$franchiseid);
            $query=$this->db->get();
            //echo $this->db->last_query(); 
            return $query->result();
        }
        
         public function getCustomer_bydate($start_date,$end_date,$regiType='all'){
            $this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
            $this->db->from('cmscustomers');
            $this->db->where('created_dt >=', $start_date);
            $this->db->where('created_dt <=', $end_date);
			if($regiType=='app'){
            $this->db->where('device_id!=','');
			}
			if($regiType=='web'){
            $this->db->where('device_id','');
			}
            $query=$this->db->get();
            echo $this->db->last_query();
            return $query->result();
        }
        
        public function getCustomer_xls_downlaod($start_date,$end_date,$regiType='all'){
            $this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
            $this->db->from('cmscustomers');
            $this->db->where('created_dt >=', $start_date);
            $this->db->where('created_dt <=', $end_date);
			if($regiType=='app'){
            $this->db->where('device_id!=','');
			}
			if($regiType=='web'){
            $this->db->where('device_id','');
			}
            $query=$this->db->get();
             echo $this->db->last_query(); die;
            $result = $query->result();
    $this->load->library('excel');
    $this->create_excel_customer($result,'search_customer_list');
            //return $query->result();
    
        }        

 function create_excel_customer($array,$filename) {
     
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                                   ->setLastModifiedBy("Maarten Balliauw")
                                                   ->setTitle("Office 2007 XLSX Test Document")
                                                   ->setSubject("Office 2007 XLSX Test Document")
                                                   ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                                   ->setKeywords("office 2007 openxml php")
                                                   ->setCategory("Test result file");

        //'id,name,contact_name,email,email2,mobile,mobile2,website,country,city,address,postal_code,info'
        // Add some data
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Mobile');
        $i = 2;
        foreach($array as $row){
        if(isset($row->mobile)&&$row->mobile!=''){
           $mobile_row = $row->mobile;
        }else{
            $mobile_row='0000000000';
        }
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $mobile_row);
              $i++;
        }

        // Miscellaneous glyphs, UTF-8
        //          $objPHPExcel->setActiveSheetIndex(0)
        //                            ->setCellValue('A4', 'Miscellaneous glyphs')
        //                            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Probable Clients');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="your_name.xls"');
header('Cache-Control: max-age=0');

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=0');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
public function getSubscriber_bydate($start_date,$end_date){
            $this->db->select('id,email,mobile,address,class,date');
            $this->db->from('cmssubscribers');
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date);
            $query=$this->db->get();
            //echo $this->db->last_query();
            return $query->result();
        }
     public function getSubscriber_xls_downlaod($start_date,$end_date){
            $this->db->select('id,email,mobile,address,class,date');
            $this->db->from('cmssubscribers');
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date);
            $query=$this->db->get();
            //echo $this->db->last_query();
            $result=$query->result();
            $this->load->library('excel');
            $this->create_excel_customer($result,'search_subscriber_list');
        }   
        
    public function getDetails($id)
	{
		$this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
		$this->db->from('cmscustomers');
		$this->db->where('id', $id); 
		$query = $this->db->get();
		return $query->row();
	}
	
	//Create function to get all parent categories
	function getParentCategories()
	{
		$this->db->where('parent',0); 
		$query = $this->db->get('cmscategories');
		return $query->result();
	}
	//Create function to get all subcategories of a given parent categories
	public function updateCustomers($data,$id){
		$this->db->where('id',$id);
		$this->db->update('cmscategories',$data);     
		return;        
    }
    //update customer addresses
	
	// ####Delete####
	public function deleteCustomers($id){
		$this->db->where('id', $id);
		$this->db->delete('cmscustomers'); 
	}
	public function getAllCustomersCount(){
		return $this->db->count_all('cmscustomers');
	}        
        public function getAllFrCustomersCount(){
            $usertype=$this->franchisetype;
            $franchiseid=$this->session->userdata("userid");;
            $this->db->select('c.id,f.id as frid');
            $this->db->from('cmscustomers AS c');
            $this->db->join('cmscust_franchise AS f','c.id=f.customer_id','right');
            $this->db->where('c.usertype',$usertype);
            $this->db->where('f.franchise_id',$franchiseid);
	    $frcust_result = $this->db->get();
            return $frcust_result->num_rows();
        }
        public function getAllEmailCount(){
            $this->db->select('firstname,lastname,email');
            $this->db->where('email!=','');
            $result=$this->db->get('cmscustomers');
            return $result->num_rows(); 
	}
        public function getAllEmails(){
            $this->db->select('firstname,lastname,email,status,verification_code,is_social');
            $this->db->where('email!=','');
            $this->db->from('cmscustomers');
            $query = $this->db->get();
            return $query->result();
	}
        
    public function login($email,$password){
        $this->db->select('id,last_activity,mobile,mobile_verified,firstname,lastname,email,mobile,status');
        $this->db->where('email',$email);
        $this->db->where('password',md5($password));
        $result=$this->db->get('cmscustomers');
        if($result->num_rows()==0){
            return false;
        }else{
            return $result->row();
        }
    }
    
    public function get_varification_code($email){
        $this->db->select('id,email,status,verification_code,is_social');
        $this->db->where('email',$email);
        $this->db->where('status',0);
        $this->db->where('is_social',0);
        $this->db->where('verification_code!=','');
        $result=$this->db->get('cmscustomers');
        return $result->result();
    }
     public function bypass_login_id($bypass_login_id){
        $this->db->select('id,last_activity,mobile,mobile_verified,firstname,lastname,email,mobile,status');
        $this->db->where('id',$bypass_login_id);
        $result=$this->db->get('cmscustomers');
        if($result->num_rows()==0){
            return false;
        }else{
            return $result->row();
        }
    }
    
    public function register($data){
        $this->db->insert('cmscustomers',$data);
        return $this->db->insert_id();
    }
    public function addAddress($data){
        if(!$this->getDefaultAddress($data['customer_id'])){
            $data['is_default']=1;
        }
        $this->db->insert('cmscustomer_addresses',$data);
        return $this->db->insert_id();
    }
    public function getCart($user_id){
        $this->db->where('user_id',$user_id);
        $query=$this->db->get('cmscart');
        return $query->row();
    }
    public function getCartItems($user_id){
        $cart=$this->getCart($user_id);
        $this->db->where('cart_id',$cart->id);
        $query=$this->db->get('cmscart_items');
        return $query->result();
    }
    public function getCartItem($cart_id,$product_id){
      
        $this->db->where('cart_id',$cart_id);
        $this->db->where('product_id',$product_id);
        $query=$this->db->get('cmscart_items');
        return $query->row();
    }
    public function checkCartItem($cart_id,$product_id){
        $this->db->where('product_id',$product_id);
        $this->db->where('cart_id',$cart_id);
        $query=$this->db->get('cmscart_items');
        return $query->row();
    }
    public function countCartItems($cart_id){
        $this->db->where('cart_id',$cart_id);
        $query=$this->db->get('cmscart_items');
        return $query->num_rows();
    }
    public function addToCart($user_id,$product_id,$quantity,$price,$offline=0,$createdby=0){
        $franchiseid=$this->session->userdata('userid');
        if(isset($franchiseid)&&$franchiseid>0){
        $createdby=$franchiseid;
        }else{
        $createdby=0;    
        }
        $date = time();
        $price=$quantity*$price;
        $checkCart=$this->getCart($user_id);
        if($checkCart){
            $cart_id=$checkCart->id;
            $checkCartItem=$this->checkCartItem($checkCart->id,$product_id);
            if($checkCartItem){
                $sql="update cmscart_items set quantity=quantity+$quantity, price=price+$price,modified_dt=$date where product_id=$product_id and cart_id=$checkCart->id";
                $this->db->query($sql);
            }else{
                 $sql="Insert into cmscart_items (cart_id,product_id,quantity,price,offline,dt_created) values($checkCart->id,$product_id,$quantity,$price,$offline,$date)";
                $this->db->query($sql);
                /*$item_id,$modules_item_id,$image_name,$image_src*/
            }
        }else{
            $sql="Insert into cmscart (user_id,created_by,created_dt) values ($user_id,$createdby,$date)";
            $this->db->query($sql);
            $cart_id=$this->db->insert_id();
             $sql="Insert into cmscart_items (cart_id,product_id,quantity,price,offline,dt_created) values($cart_id,$product_id,$quantity,$price,$offline,$date)";
             $this->db->query($sql);
        }
        $cartitems=$this->countCartItems($cart_id);
        $sql="update cmscart set cart_qty=cart_qty+$quantity, cart_price=cart_price+$price ,cart_items=$cartitems,created_by=$createdby,modified_dt=$date where id=$cart_id and user_id=$user_id";
        $this->db->query($sql);
        $cart=$this->getCart($user_id);
        
    }   
    public function removeCartItem($user_id,$cart_id,$product_id){
        $date = time();
        $itemtoremove=$this->getCartItem($cart_id,$product_id);
        $sql="update cmscart set cart_qty=cart_qty-$itemtoremove->quantity,cart_price=cart_price-$itemtoremove->price,modified_dt=$date where id=$cart_id and user_id=$user_id ";
        $this->db->query($sql);
        $this->db->where('cart_id',$cart_id);        
        $this->db->where('product_id',$product_id);
        $this->db->delete('cmscart_items');        
        return true;
    }
    public function updateCart($user_id,$cart_id,$product_id,$quantity,$price){
        $this->removeCartItem($user_id,$cart_id,$product_id);
        $this->addToCart($user_id,$product_id,$quantity,$price);
        return true;
    }
	public function getUserInfo($user_id){
		$this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
		$this->db->from('cmscustomers');
		$this->db->where('id',$user_id);
		$query = $this->db->get();
		return $query->row();
	}
    public function emptyCart($user_id){
        $checkCart=$this->getCart($user_id);
        if($checkCart){
            $this->db->where('cart_id',$checkCart->id);
            $this->db->delete('cmscart_items');
            $this->db->where('id',$checkCart->id);
            $this->db->delete('cmscart');
        }
        return true;
    }
	public function getAddresses($customer_id,$default_address_id=0){
		$this->db->select('id,customer_id,address_name,address,address2,city,city_name,state,state_name,country_id,country_name,zipcode,is_default,mobile');
		$this->db->from('cmscustomer_addresses');
		$this->db->where('customer_id',$customer_id);
                if($default_address_id > 0){
		$this->db->where('is_default',0);
		}
		$user_addresses = $this->db->get();
		return $user_addresses->result();
	}
	
	//
	public function getShippingAddresses($shipping_id){
		$this->db->select('id,customer_id,address_name,address,address2,city,city_name,state,state_name,country_id,country_name,zipcode,is_default,mobile');
		$this->db->from('cmscustomer_addresses');
		$this->db->where('id',$shipping_id);
		//$this->db->where('is_default',0);
		$shipping_addresses = $this->db->get();
		return $shipping_addresses->row();
	}
	//
	public function addToWishlist($user_id,$id,$product_name)
	{
		$this->db->insert('cmswishlist',array('user_id'=>$user_id,'product_id'=>$id,'product_name'=>$product_name));
		return true;
	}
	public function getWishlistItems($customer_id){
		$this->db->select('A.*,A.id as pro_id,B.*,C.id as wishlist_id,C.product_id,C.product_name');
		$this->db->from('cmsproducts AS A');
		$this->db->join('cmsproduct_images AS B','A.id = B.product_id','left');
		$this->db->join('cmswishlist AS C', 'C.product_id = A.id', 'left');
		$this->db->where('C.user_id',$customer_id);
		$this->db->where('B.is_main',1);
		$product_wishlist = $this->db->get();
		return $product_wishlist->result();
	}
    public function checkemail($email){
        $this->db->select('id,email');
        $this->db->from('cmscustomers');
        $this->db->where('email',$email);
        $result=$this->db->get();
        if($result->num_rows()==0){
            return true;
        }else{
            return false;
        }
    }
	
	  public function checkmobile($mobile){
        $this->db->select('id,mobile');
        $this->db->from('cmscustomers');
        $this->db->where('mobile',$mobile);
        $result=$this->db->get();
        if($result->num_rows()==0){
            return true;
        }else{
            return false;
        }
    }
	public function checkSubscribedEmail($email){
        $this->db->select('id');
        $this->db->from('cmssubscribers');
        $this->db->where('email',$email);
        $result=$this->db->get();
        if($result->num_rows()==0){
            return true;
        }else{
            return false;
        }
    }
	public function checkZip($zipcode)
	{
		$this->db->select('*');       // table cmscod_availability_pin not exist.
		$this->db->from('cmscod_availability_pin');
		$this->db->where('cod_pin',$zipcode);
		$zip = $this->db->get();
		return $zip->result();
	}
	public function getDefaultAddress($user_id)
	{
		$this->db->select('id,customer_id,address_name,address,address2,city,city_name,state,state_name,country_id,country_name,zipcode,is_default,mobile');
		$this->db->from('cmscustomer_addresses');
		$this->db->where('is_default',1);
		$this->db->where('customer_id',$user_id);
		$default_address = $this->db->get();
                //echo $this->db->last_query();
		return $default_address->row();
	}
	public function getAddressDetail($id)
	{
		$this->db->select('id,customer_id,address_name,address,address2,city,city_name,state,state_name,country_id,country_name,zipcode,is_default,mobile');
		$this->db->from('cmscustomer_addresses');
		$this->db->where('id',$id);
		//$this->db->where('customer_id',$user_id);
		$address_detail = $this->db->get();
		return $address_detail->row();
	}
	public function addOrder($user_id,$payment_mode,$final_amount,$shipping_charges,$cod_charges,$shipping_address_id,$agree_terms_value='no'){
		
		
		$validity_days=ORDER_VALIDITY;
		if(isset($validity_days)&&$validity_days>0){
		//First set global value from macro	
		$validity_dt=strtotime('+'.$validity_days.' days');
		$validity_day=$validity_days;		
		}
		  
			 $loginFranId = $this->session->userdata('loginFranId');
			 if($loginFranId>0){
				 $createdby=$loginFranId;
			 }else{
				 $createdby=$user_id;
			 }
			 
            if($this->session->userdata('isGuest')=='yes'){
                $isGuest='yes';
            }else{
                $isGuest='no'; 
            }
if($agree_terms_value=='yes'){
                $agree_terms_value='yes';
            }else{
                $agree_terms_value='no'; 
            }    

			
		$cart = $this->Cart_model->getCustomerCart($user_id,1);
		$order_no=time();
		$dataorder = array('order_no'=>$order_no,
							  'session_id'=>$this->session->session_id,
							  'user_id'=>$user_id,
							  'order_items'=>$cart->cart_items,
							  'order_qty'=>$cart->cart_qty,
							  'order_price'=>$cart->cart_price,
							  'payment_mode'=>$payment_mode,
							  'shipping_charges'=>$shipping_charges,
							  'cod_charges'=>$cod_charges,
							  'final_amount'=>$final_amount,
                              'guest'=> $isGuest, 
							  'shipping_id'=>$shipping_address_id,
                              'agree_terms'=>$agree_terms_value,
							  'validity_dt'=>$validity_dt,
							  'created_dt'=>time(),
							  'created_by'=>$createdby);
			
			$dataorderarray = $this->db->insert('cmsorders',$dataorder);
			
			$order_id = $this->db->insert_id();
			$cart_items = $this->Cart_model->getCartItems($cart->id);
                        $type=0;
                        $offline_status=0;
/*Entry Order Detals table*/
		foreach($cart_items as $item){
                    $product_info =  $this->Pricelist_model->getProducts_byid($item->product_id);
                   if(isset($product_info[0]->type)){
                      $type= $product_info[0]->type; 
                   }
                   if(isset($product_info[0]->offline_status)){
                       $offline_status= $product_info[0]->offline_status; 
                   }
                   
	$dataorderitems = array('order_id'=>$order_id,  				'product_id'=>$item->product_id,
                		'quantity'=>$item->quantity,
						'offline'=>$item->offline,
                        'price'=>$item->price,
                        'type'=>$type,
                        'offline'=>$offline_status,
						'end_date'=>$validity_dt,
						'user_id'=>$user_id);
				$dataorderitemsarray = $this->db->insert('cmsorder_details',$dataorderitems);
				$cartexamid[]=$product_info[0]->exam_id;
				
				$subscription_expiry=$product_info[0]->subscription_expiry;
				$subscription_type=$product_info[0]->subscription_type;
        }
		
		if(isset($subscription_type)&&$subscription_type=='global'){
		//set global value from macro	
		
		$validity_days=ORDER_VALIDITY;
		$validity_dt=strtotime('+'.$validity_days.' days'); 
		$validity_day=$validity_days;
		
		}else if(isset($subscription_type)&&$subscription_type=='local'){
	    if(isset($subscription_expiry)&&$subscription_expiry>0){
		//set local value from cmspricelist table
		$validity_days=$subscription_expiry;
		$validity_dt=strtotime('+'.$validity_days.' days'); 
		$validity_day=$validity_days;
		}else{
				//set 1 year from todays date 	
	    $validity_dt=strtotime('+365 days'); 
		$validity_day='365';
		}
		}else{
				//set 1 year from todays date 
$validity_dt=strtotime('+365 days'); 
$validity_day='365';				
		}
	
	//Update in order details for video and test serise for complemntry 
	 if($cart->cart_qty>3){
		 $total_cartqty=$cart->cart_qty;
	}else{
		$total_cartqty=3;
	}
	 $validity_dt_array = array('order_qty'=>$total_cartqty,'validity_dt'=>$validity_dt,'validity_day'=>$validity_day);
	 $updateorder_info = $this->Pricelist_model->updateorder($order_id,$validity_dt_array);
	 
	 //Ends Update in order
		
		foreach ($cartexamid as $crtitm_pid){
			
			//Get all product from cartexamid
			$vidarra=$this->Pricelist_model->complemtry_order(2, $crtitm_pid, 0, 0);
			if(isset($vidarra->pid)){
                    $product_info_crt =  $this->Pricelist_model->getProducts_byid($vidarra->pid);
					
					  if(isset($product_info_crt[0]->type)){
                       $type= $product_info_crt[0]->type; 
                   }
                   if(isset($product_info_crt[0]->offline_status)){
                       $offline_status= $product_info_crt[0]->offline_status; 
                   }
                   if(isset($vidarra->price)&&$vidarra->price>0){
					   $cp_price=$vidarra->price;
				   }else{
					$cp_price=0;   
				   }
	$complematry_v = array('order_id'=>$order_id,  				
	                     'product_id'=>$vidarra->pid,
                		'quantity'=>1,
						'offline'=>0,
                        'price'=>$cp_price,
                        'type'=>$type,
						'end_date'=>$validity_dt,
						'user_id'=>$user_id);
				$complematryarray = $this->db->insert('cmsorder_details',$complematry_v);
		}
		
		//testseries Entry
			$otarra=$this->Pricelist_model->complemtry_order(3, $crtitm_pid, 0, 0);
			if(isset($otarra->pid)){
                    $product_info_crt =  $this->Pricelist_model->getProducts_byid($otarra->pid);
					
					if(isset($product_info_crt[0]->type)){
                    $type= $product_info_crt[0]->type; 
                    }
                    if(isset($product_info_crt[0]->offline_status)){
                    $offline_status= $product_info_crt[0]->offline_status; 
                    }
                    if(isset($otarra->price)&&$otarra->price>0){
					$ocp_price=$otarra->price;
				   }else{
					$ocp_price=0;   
				   }
	$complematry = array('order_id'=>$order_id,
	                    'product_id'=>$otarra->pid,
                		'quantity'=>1,    
						'offline'=>0,
                        'price'=>$ocp_price,
                        'type'=>$type,
						'end_date'=>$validity_dt,
						'user_id'=>$user_id);
						
	$complematryarray = $this->db->insert('cmsorder_details',$complematry);
		}
		}
		//update End
        //product to showing in email
        if($item->offline==''){
            $item_offline=0;
        }else{
            $item_offline=$item->offline;
        }
        $this->db->select('A.product_id,A.price,B.modules_item_name');
		$this->db->from('cmsorder_details A');
                $this->db->join('cmspricelist B','A.product_id=B.id');
		$this->db->where('A.order_id',$order_id);
		$default_order = $this->db->get();
        $order_details_array = $default_order->result();
        return array('order_id'=>$order_id,'order_no'=>$order_no,'order_items'=>$cart->cart_items,'order_qty'=>$cart->cart_qty,'offline'=>$item_offline,'shipping_charges'=>$shipping_charges,'final_amount'=>$final_amount,'product_id'=>$item->product_id,'order_details_array'=>$order_details_array,'order_price'=>$cart->cart_price);
		
        
	}
	public function updatecustomerinfo($user_id,$userdata)
	{
		$this->db->where('id',$user_id);
		$this->db->update('cmscustomers',$userdata);
	}
        
        public function updateByEmail($email,$userdata)
	{
		$this->db->where('email',$email);
		$this->db->update('cmscustomers',$userdata);

        $this->db->select('id,email,firstname,lastname,email,status,verification_code,is_social');
		$this->db->from('cmscustomers');
		$this->db->where('email', $email); 
		$query = $this->db->get();
		return $query->row();
	}
        
        public function update_last_activity($email,$last_activity)
	{
            $curent_time =time();
            if($last_activity!=''){
                 $userdata = array(
                'last_login' => $last_activity,
                'last_activity' => $curent_time
            );
            }else{
                  $userdata = array(
                'last_login' => $curent_time,
                'last_activity' => $curent_time
            );
            }
		$this->db->where('email',$email);
		$this->db->update('cmscustomers',$userdata);
	}
        
        public function getAllWishlistCount(){
		return $this->db->count_all('cmswishlist');
	}
	public function getAllWishlist(){
		$this->db->select('A.product_name,A.product_id,A.user_id,A.id as wish_id,B.*,C.*');
		$this->db->from('cmswishlist A');
		$this->db->join('cmscustomers B','A.user_id=B.id');
		$this->db->join('cmsproducts C','A.product_id=C.id');
		$query = $this->db->get();
		return $query->result();
	}
	public function wishlistDetails($id){
		$this->db->select('A.product_name,A.product_id,A.user_id,A.id as wish_id,B.*,C.*');
		$this->db->from('cmswishlist A');
		$this->db->join('cmscustomers B','A.user_id=B.id');
		$this->db->join('cmsproducts C','A.product_id=C.id');
		$this->db->where('A.id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	public function updatePassword($passwordarray,$user_id){
		$this->db->where('id',$user_id);
		$this->db->update('cmscustomers',$passwordarray);
	}
        
    public function ediCod_Orderstatus($order_id,$ordstatus=3){
         $data=array('payment_status'=>0,'status'=>$ordstatus); 
         $this->db->update('cmsorders',$data,array('id'=>$order_id));
    }
    public function updateOrder($order_id,$order_no,$payment_status,$txn_number,$payment=0){
        if($payment==1){
            
        $data=array('txn_number'=>$txn_number,'payment_status'=>$payment_status,'status'=>1);
        }else{
            
        $data=array('txn_number'=>$txn_number,'payment_status'=>$payment_status,'status'=>2);
        }
        $this->db->update('cmsorders',$data,array('id'=>$order_id,'order_no'=>$order_no));
		
		
                $this->db->select("order_items,order_qty,payment_mode,shipping_charges,final_amount,order_price");
                $this->db->from("cmsorders");
                $this->db->where("id",$order_id); 
                $order_query = $this->db->get();                
                $order_array = $order_query->row();                
                $this->db->select('A.product_id,A.price,A.offline,B.modules_item_name');
		$this->db->from('cmsorder_details A');
                $this->db->join('cmspricelist B','A.product_id=B.id');
		$this->db->where('A.order_id',$order_id);
		$default_order = $this->db->get();
                $order_details_array = $default_order->result();
                $item_offline=0;
                  
        return array('order_id'=>$order_id,'order_no'=>$order_no,'order_items'=>$order_array->order_items,'order_qty'=>$order_array->order_qty,'offline'=>$item_offline,'shipping_charges'=>$order_array->shipping_charges,'final_amount'=>$order_array->final_amount,'order_price'=>$order_array->order_price,'order_details_array'=>$order_details_array);
        
    }
    public function cancelOrder($order_id,$order_no,$payment_status,$txn_number){
        $data=array('txn_number'=>$txn_number,'payment_status'=>$payment_status,'status'=>2);
        $this->db->update('cmsorders',$data,array('id'=>$order_id,'order_no'=>$order_no));
    }
	public function editCustomerAddress($addressdata,$address_id){
		$this->db->where('id',$address_id);
		$this->db->update('cmscustomer_addresses',$addressdata);
		
	}
	public function setDefault($address_id,$user_id){
		$this->db->where('customer_id',$user_id);
		$this->db->where('is_default',1);
		$this->db->update('cmscustomer_addresses',array('is_default'=>0));
		$this->db->where('customer_id',$user_id);
		$this->db->where('id',$address_id);
		$this->db->update('cmscustomer_addresses',array('is_default'=>1));
		
	}
	public function removeFromWishlist($id){
		$this->db->where('id',$id);
		$this->db->delete('cmswishlist');
	}
	public function getCustomerOrdersCount($user_id){
		$this->db->where('user_id',$user_id);
		$rs=$this->db->get('cmsorders');
		return $rs->num_rows();
	}
	public function addReview($review_array){
		$this->db->insert('cmsproduct_reviews',$review_array);
		return $this->db->insert_id();
	}
	public function resetPassword($email,$forgotpasswordarray){
		$this->db->where('email',$email);
		$this->db->update('cmscustomers',$forgotpasswordarray);
	}
	public function deletemyaddress($id){
		$this->db->where('id',$id);
		$this->db->delete('cmscustomer_addresses');
	}
    public function getCustomersCount($from=null,$to=null){
        if(empty($from)&&empty($to)){
            $this->db->where('created_dt >=',mktime(0,0,0,date('m'),date('d'),date('Y')));
            $result=$this->db->get('cmscustomers');
            return $result->num_rows();
        }
    }
    public function getCustomerProucts($customer_id){
        $this->db->select('A.product_id ,B.type as product_type,B.exam_id,B.subject_id,B.chapter_id');
	$this->db->from('cmsorder_details A');
        $this->db->join('cmsorders O','O.id=A.order_id');
	$this->db->join('cmspricelist B','A.product_id=B.id');
	$this->db->where('O.user_id',$customer_id);
        $this->db->where('O.status',1);
	$order_details = $this->db->get();
	return $order_details->result();
    }
    public function verify($id,$email,$verification_code){
        $this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
        $this->db->where('id',$id);
        $this->db->where('email',$email);
        $this->db->where('verification_code',$verification_code);
        $this->db->from('cmscustomers');
        $query=$this->db->get();
        if($query->num_rows()==1){
            $this->db->where('id',$id);
            $this->db->where('email',$email);
            $this->db->where('verification_code',$verification_code);
            $this->db->update('cmscustomers',array('status'=>1));
            return true;
        }else{
            return false;
        }
    }
    public function verifyotp($user_id,$otp) {
        $this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
        $this->db->where('id',$user_id);
        $this->db->where('otp',$otp);
        $this->db->where('otp_expiry >=',time());
        $this->db->from('cmscustomers');
        $query=$this->db->get();
        if($query->num_rows()==1){
            $this->db->where('id',$user_id);
            $this->db->where('otp',$otp);
            $this->db->update('cmscustomers',array('mobile_verified'=>1));
            return true;
        }else{
            return false;
        }
    }
    public function isFbUser($fbid){
	$this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
	$this->db->where('fbid',$fbid);
	$query = $this->db->get('cmscustomers');
	if($this->db->count_all_results() > 0){
		$user=$query->row();
		return $user; 
	}else{
	    	return false;
	}
    }
    public function isTwitterUser($twitterid){
	$this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
	$this->db->where('twitterid',$twitterid);
	$query = $this->db->get('cmscustomers');
	if($this->db->count_all_results() > 0){
		$user=$query->row();
		return $user; 
	}else{
	    	return false;
	}
    }
    public function isGooglePlusUser($googleplusid){
	$this->db->select('id,firstname,lastname,email,dob,mobile_legacy_no,mobile,password,status,is_social,fbid,twitterid,googleplusid,wallet_balance,alt_contact_no,is_app_registered,verification_code,otp,mobile_verified,otp_expiry,targate_exam,schoolid,usertype,user_key,device_id,order_success,last_login,last_activity,Guest,image,subject_id,city_id,legacy_id,created_dt,created_by,user_login_token,modified_dt,modified_by');
	$this->db->where('googleplusid',$googleplusid);
	$query = $this->db->get('cmscustomers');
	if($this->db->count_all_results() > 0){
		$user=$query->row();
		return $user; 
	}else{
	    	return false;
	}
    }
    public function newusers($start_date = null, $end_date = null){
        $this->db->select('id');
        $this->db->from('cmscustomers');
        if($start_date==null){
            $start_date= strtotime(date('Y-m-d'));
            $this->db->where('created_dt > ',$start_date);
        }
        if($end_date !=null){
            $this->db->where('created_dt <= ',$end_date);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
	
    public function franchise_users($userid,$franchiseid,$limit_start=null, $limit_end=null){
            $this->db->select('c.id,c.firstname,c.lastname,c.email,c.dob,c.mobile,c.status,c.targate_exam,c.usertype,c.is_social,c.fbid,c.twitterid,c.googleplusid,c.created_dt,f.id as franid,f.franchise_id');
            $this->db->from('cmscustomers AS c');
            $this->db->join('cmscust_franchise AS f','c.id=f.customer_id','right');
            $this->db->where('c.usertype',$userid);
            $this->db->where('f.franchise_id',$franchiseid);
		if($limit_start || $limit_end){
			$this->db->limit($limit_start, $limit_end);
		}
		$query = $this->db->get();
		return $query->num_rows();
    }
	
	public function addfranchise($franchisedata){
		
        $this->db->insert('cmscust_franchise',$franchisedata);
        return $this->db->insert_id();
    }
	
    public function watch_history($start_date = null, $end_date = null){
        $this->db->select('id');
        $this->db->from('cmsvideohistory');
        if($start_date !=null){
            
            $this->db->where('dt_created > ',$start_date);
        }
        if($end_date !=null){
            $this->db->where('created_dt <= ',$end_date);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function download_history($start_date = null, $end_date = null){
        $this->db->select('id');
        $this->db->from('cmsdownloadhistory');
        if($start_date !=null){
            
            $this->db->where('dt_created > ',$start_date);
        }
        if($end_date !=null){
            $this->db->where('created_dt <= ',$end_date);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function updatecustomermobile($id,$userdata){
        $this->db->where('id',$id);
		$this->db->update('cmscustomers',$userdata);
    }
    
    public function checkCurrentPassword($customer_id,$current_password){
        $password=md5($current_password);
        $this->db->select('password');
        $this->db->from('cmscustomers');
        $this->db->where('password',$password);
        $this->db->where('id',$customer_id);        
        $query=$this->db->get();
        return $query->num_rows();
    }

    public function setvalidity ($id,$userdata) {
        $this->db->where('macro',$id);
        $this->db->update('cmsmacro',$userdata);
    }
}
?>