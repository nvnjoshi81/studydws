<?php
class User_model extends CI_Model {
          private $email_verify = 'email_varification_code';
    
        
function login_submit($email, $user_pass) {
        $this->db->where('email', $email);
        $this->db->where('password', md5($user_pass));
        $query = $this->db->get("users");
        if ($query->num_rows() == 1) {
            return $query->row_array();
            } else {
        return false;
        }
}
public function getUserByEmail($email) {
        $this->db->where('email', $email);
        $query = $this->db->get("users");
        if ($query->num_rows() == 1) {
        $rs = $query->row();
        return $rs->id;
        } else {
        return false;
        }
}
                           
function add_user($user_data){
        $query = $this->db->insert('users',$user_data);
        if($query){
        $last_user_id = $this->db->insert_id();
        return $last_user_id;
        } else{
        return false;
        }
}
public function verified($id,$verified){
        $this->db->where('id', $id);
        $data=array('verified'=>$verified);
        $this->db->update('users',$data);
}

public function getUsers($status=null,$limit=20,$start=0){
        $this->db->select('*');         // table users not exist.
        $this->db->from('users');
        if(!empty($status)){
        $this->db->where('verified',$status);
        }
        $this->db->limit($limit,$start);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        return $query->result();
}
public function getUser($id){
        $this->db->select('*');         // table users not exist.
        $this->db->from('users');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
}
public function checkUser($email){
        $this->db->select('*');         // table users not exist.
        $this->db->from('users');
        $this->db->where('email',$email);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        if($rowcount==0){
            return false;
            }else{
            return $query->row()->id;
        }
}
public function checkPassword($user_id,$password){
            $this->db->select('*');             // table users not exist.
            $this->db->from('users');
            $this->db->where('id',$user_id);
            $this->db->where('password',md5($password));
            $query = $this->db->get();
            $rowcount = $query->num_rows();
            if($rowcount==0){
                return false;
            }else{
            return true;
            }
}
public function createUser($companyname,$fname,$lname,$email,$password=null,$contact=null){
            if(empty($password)){
            $password=generatePassword();
            }
            $data = array(
            'companyname'=>$companyname,
            'firstname'=>$fname,
            'lastname'=>$name,
            'email'=>$email,
            'password'=>md5($password),
            'phone'=>$contact,
            'vcode'=>null,
            'verified'=>0,
            'dt_created' => date('Y:m:d h:i:s'),
            'dt_modified'=> date('Y:m:d h:i:s')	
            );
        $result=$this->db->insert('users', $data); 
        if($result){
        $userId=$this->checkUser($email);
        $user=$this->getUser($userId);
                //send mail 
        $userid=$user->id;
        $verificationCode=generateVerificationCode(25);
        $data=array('vcode'=>$verificationCode);
        $this->db->where('id', $userid);
        $this->db->update('users', $data); 
        $fromname="learning-website.com Support";
        $fromemail="support@learning-website.com";
        $toname=$user->name;
        $toemail=$user->email;
        $subject='Regisration on learning-website.com';
        $content="Dear ".$toname.",<br> Your account has been created. Please click on the link below to verify your account.<p><a href='".base_url()."account/verify/".$user->id."/".$verificationCode."'>".base_url()."account/verify/".$user->id."/".$verificationCode."</a></p><p>Thanks,<br> learning-website.com Support</p>";
        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from($fromemail, $fromname);
        $this->email->to($toemail,$toname);
        $this->email->subject($subject);
        $this->email->message($content);
        $this->email->send();
        return $user;
        }else{
        return false;
        }
}
public function getUserPostings($user_id){
        $this->db->select('id,legacy_id,title,description,user_id,adtype,meta_keywords,meta_description,external_url,external_link,category_id,top_category_id,subject_id,chapter_id,language,published,views,hits,is_featured,dt_created,dt_modified,is_deleted,view_count');
        $this->db->from('postings');
        $this->db->where('user_id',$user_id);
        $this->db->order_by('dt_created','desc');
        $query = $this->db->get();
        return $query->result();
}
public function getUserCount(){
        return $this->db->count_all("users");
}
public function add_newaccount($data){
        $this->db->insert('users', $data);
        return;
} 
public function login_admin($email,$password) {   
        //$this->output->enable_profiler(TRUE);
        $this->db->select('id,email,password,pass,first_name,last_name,mobile,type,company,address,city,state,postcode,dt_created,dt_modified');
        $this->db->from('admin');
        $this->db->where('email',$email);
        $this->db->where('password',  sha1($password));
        $this->db->limit(1);
        $query = $this->db->get();
        
        if($query->num_rows()==1) {
             $row = $query->row(); 
        //echo "WELCOME To Admin";
            return $row; //if data is true
        } else {
        //echo "Please Input Correct Input";
            return 0; //if data is wrong
        }
    } 
    public function update_adminpass($update_data,$id){
        $this->db->where('id', $id); 
        $this->db->update('admin',$update_data);
    }
    
    public function update_active($id,$update_data){
        $this->db->where('id', $id); 
        $this->db->from('users');
        $this->db->update('users',$update_data);
        return ;        
    }
    public  function deleteuser($id){
          $this->db->delete('users',array('id'=>$id));
          return ;
    }
    public function updatelog($data){
		if(isset($data['email'])&&$data['email']!=''){
			//nothing to do
			 $email=$data['email'];
		}else{
				 $email='admin@admin.com';
			$data['email']='admin@admin.com';
			//Do not update log //$this->db->insert('loginlog',$data);
		}
		       
    }
    
    public function getlog($limit=50){
        $this->db->select('id,email,userid,ipaddress,logintime,success');
        $this->db->from('loginlog');
        $this->db->limit($limit);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        return $query->result();
    }

} 
?>
