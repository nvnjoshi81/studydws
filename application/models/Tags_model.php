<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tags_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function getTagsCount()
    {
       
        return  $this->db->count_all('cmstags');
    }
    
    public function getTags($limit = 0, $start = 0)
    {
        $this->db->select('cmstags.name as name, cmstags.id as id')->select('cmschapters.name as chapter');
        $this->db->from('cmstags');
        $this->db->join('cmschapters','cmschapters.id=cmstags.chapter_id');
        if($limit>0 && $start>0){
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        return $query->result();
    }
   
    
    public function addTag($data)
    {
        $this->db->insert('cmstags', $data);
        $id=$this->db->insert_id();
        return $id;
        
    }
    
    
    
    public function deleteTag($id)
    {
        $this->db->delete('cmstags',array('id'=>$id));
       
    }
    
    public function updateTag($id,$data)
    {
        $this->db->update('cmstags', $data, array('id' => $id));
    }
    
    
    public function getTag($id)
    {
        $this->db->select('*');
        $this->db->from('cmstags');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function getTagByName($name)
    {
        $this->db->select('*');
        $this->db->from('cmstags');
        $this->db->like('name', $name);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getChapterTags($chapterids){
        $this->db->select('*');
        $this->db->where_in('chapter_id',  implode(',',$chapterids));
        $this->db->from('cmstags');
        $query=$this->db->get();
        return $query->result();
    }
    
    public function addtagtocontent($data) {
        $this->db->insert('cmscontent_tags',$data);
    }
    public function removetagtocontent($data) {
        $this->db->delete('cmscontent_tags',$data);
    }
    public function getcontenttags($id,$type){
        $this->db->select('*');
        $this->db->from('cmscontent_tags');
        $this->db->where('content_id',$id);
        $this->db->where('type',$type);
        $query=$this->db->get();
        return $query->result();
    }
    
}