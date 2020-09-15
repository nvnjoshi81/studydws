<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notification_model extends CI_Model
{
    public function getMediaCount(){
        
        return $this->db->count_all_results('cmsnotify');
    }
    public function getcontent($limit = 0, $start = 0) {
        $this->db->select('*');
        $this->db->from('cmsnotify');
        if ($limit > 0) {
            $this->db->limit($limit, $start);
        }
       
        $query = $this->db->get();
        return $query->result();
    }
    
    
    public function createMedia($media_data)
         {
       $this->db->insert('cmsnotify',$media_data);
       //echo $this->db->last_query();;die;
        return $this->db->insert_id();
    }
    
    public function getmedia()
         {       
        $this->db->select('id,title,description,class_id,content_type,packageid,date');
        $this->db->from('cmsnotify');
	    $query=$this->db->get();
        return $query->result();
    }
	
    public function getStudentByClassId($classid)
         {  
		 if($classid>0){
    $this->db->select('id,targate_exam,mobile,targate_exam,status,device_id');
        $this->db->from('cmscustomers');
        $this->db->where('is_app_registered',1);
        $this->db->where('mobile!=','');
	    $query=$this->db->get();
        $studentarray=$query->result();
	
  foreach($studentarray as $userInfo){
	  $targetexamstring=$userInfo->targate_exam;
	  if(isset($targetexamstring[0])&&$targetexamstring[0]!=''){
	  $targetexamArray=explode('_',$targetexamstring);
if (in_array($classid, $targetexamArray))
  {
  $senderIdArray[]=$userInfo->id;
  }
	  }
  }
		
		 return $senderIdArray; 
		 }else{
			 return array(); 	 
		 }
    }
	
	
	public function getnotification($content_type,$exam_type,$noti_type='web'){
        $this->db->select('id,title,class_id,description,content_type,packageid,date,notitype');
        $this->db->from('cmsnotify');
		if($content_type!=0){
        $this->db->where('content_type',$content_type);
		}	
	if($exam_type!=0){		
        $this->db->where('class_id',$exam_type);
	}	
        $this->db->where('notitype',$noti_type);
        $query=$this->db->get();
        return $query->result();
    }
		public function getnotification_details($detail_id){
        $this->db->select('id,title,class_id,description,content_type,packageid,date,notitype');
        $this->db->from('cmsnotify');
		if($detail_id>1){
        $this->db->where('id',$detail_id);
		}
        $this->db->limit(1,0);
        $query=$this->db->get();
        return $query->row();
    }
	
	public function getnotification_all($noti_type='web'){
        $this->db->select('id,title,class_id,description,content_type,packageid,date,notitype');
        $this->db->from('cmsnotify');
        $this->db->where('notitype',$noti_type);
        $query=$this->db->get();
        return $query->result();
    }
	
    
    public function getMediaById($id){
        $this->db->select('id,title,class_id,description,content_type,packageid,date,notitype');
        $this->db->from('cmsnotify');
        $this->db->where('id',$id);
        $query=$this->db->get();
        return $query->row();
    }
     public function editMedia($data, $id) {
        $this->db->update('cmsnotify', $data, array('id' => $id));
    }
    
    public function deleteMedia($id){
      $this->db->delete('cmsnotify',array('id'=>$id));  
    }
    
    
}
