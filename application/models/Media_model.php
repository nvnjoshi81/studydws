<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Media_model extends CI_Model
{
    public function getMediaCount(){
        
        return $this->db->count_all_results('cmsmedia');
    }
    public function getcontent($limit = 0, $start = 0) {
        $this->db->select('*');
        $this->db->from('cmsmedia');
        if ($limit > 0) {
            $this->db->limit($limit, $start);
        }
       
        $query = $this->db->get();
        return $query->result();
    }
    
    
    public function createMedia($media_data)
         {
       $this->db->insert('cmsmedia',$media_data);
       //echo $this->db->last_query();;die;
        return $this->db->insert_id();
    }
    
    public function getmedia()
         {       
        $this->db->select('id,title,description,image,image_big,date');
        $this->db->from('cmsmedia');
	$query=$this->db->get();
        return $query->result();
    }
    
    public function getMediaById($id){
        $this->db->select('id,title,description,image,image_big,date');
        $this->db->from('cmsmedia');
        $this->db->where('id',$id);
        $query=$this->db->get();
        return $query->row();
    }
     public function editMedia($data, $id) {
        $this->db->update('cmsmedia', $data, array('id' => $id));
    }
    
    public function deleteMedia($id){
      $this->db->delete('cmsmedia',array('id'=>$id));  
    }
    
    
}
