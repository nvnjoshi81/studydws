<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Topics_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function getTopicsCount()
    {
       
        return  $this->db->count_all('cmstopics');
    }
    
    public function getTopics($limit = 0, $start = 0)
    {
        $this->db->select('id,chapter_id,name,order,created,description,keywords,tagline');
        $this->db->from('cmstopics');
        if($limit>0 && $start>0){
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        return $query->result();
    }
   
    
    public function addTopic($data)
    {
        $this->db->insert('cmstopics', $data);
        $id=$this->db->insert_id();
        return $id;
        
    }
    
    
    
    public function deleteTopic($id)
    {
        $this->db->delete('cmstopics',array('id'=>$id));
       
    }
    
    public function updateTopic($id,$data)
    {
        $this->db->update('cmstopics', $data, array('id' => $id));
    }
    
    
    public function getTopic($id)
    {
        $this->db->select('id,chapter_id,name,order,created,description,keywords,tagline`');
        $this->db->from('cmstopics');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    
    
    
}