<?php
class Freevideo_model extends CI_Model
{
        
    public function saveVideo($video_id)
    {
      $sql="update cmsfree_videos set video_id='".$video_id."' where id=1";
        $this->db->query($sql);
        return TRUE;
    }
    
    
    public function getVideolist(){
        
        $this->db->select('video_id');
		$this->db->from('cmsfree_videos');
		$this->db->where('id',1); 
		$query = $this->db->get();
		return $query->row();
    }
  
    
}