<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Content_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function getContentTypeCount()
    {
       
        return  $this->db->count_all('content_type');
    }
    
    public function getContentType()
    {
        $this->db->select('id,name,order,created_by,modified_by,dt_created,dt_modified');
        $this->db->from('content_type');
        $this->db->order_by('name');
        $query = $this->db->get();
        return $query->result();
    }
    
    
    public function getContentTypeLimit($limit,$start){
        $this->db->select('id,name,order,created_by,modified_by,dt_created,dt_modified');
        $this->db->limit($limit,$start);
        $this->db->from('content_type');
        $this->db->order_by('name');
        $query = $this->db->get();        
        //echo $this->db->last_query(); die;
        return $query->result();
    }
    
    
        public function questions_type()
    {
        $this->db->select('id,name');
        $this->db->from('cmsquestiontypes');
        $this->db->order_by('name');
        $query = $this->db->get();
        return $query->result();
    }
    public function getCategoryContentType($category_id)
    {
        $this->db->select('*');     // table category_content not exists.
        $this->db->from('category_content');
        $this->db->where('category_id',$category_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function addContentType($data)
    {
        $this->db->insert('content_type', $data);
        
    }
    
    public function deleteContentType($id)
    {
        $this->db->delete('content_type',array('id'=>$id));
       
    }
     public function delete_cmsquestions_byid($id)
    {   $this->db->where('id',$id);
        $this->db->delete('cmsquestions');
    }
    
     public function delete_cmsanswers_byid($id)
    {   $this->db->where('question_id',$id);
        $this->db->delete('cmsanswers');
    }
    
     public function delete_cmsvideos_byid($id)
    {   $this->db->where('id',$id);
        $this->db->delete('cmsvideos');
    }
    public function delete_cmsvideolist_details_byid($id)
    {   $this->db->where('video_id',$id);
        $this->db->delete('cmsvideolist_details');
    }
    
    public function updateContentType($id,$data)
    {
        $this->db->update('content_type', $data, array('id' => $id));
    }
    
    public function getContentTypeDetail($id)
    {
        $this->db->select('id,name,order,created_by,modified_by,dt_created,dt_modified');
        $this->db->from('content_type');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function addCategoryContent($data){
        $this->db->insert('category_content',$data);
    }
    public function updateCategoryContent($category_id,$content_type_id,$data){
        $this->db->where('category_id',$category_id);
        $this->db->where('content_type_id',$content_type_id);
        $this->db->update('category_content',$data);
    }
    public function deleteCategoryContent($category_id,$content_type_id){
        $this->db->where('category_id',$category_id);
        $this->db->where('content_type_id',$content_type_id);
        $this->db->delete('category_content');
    }
    public function getRelations($tablename,$colname,$colid) {
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($colname,$colid);
        $query=$this->db->get();
        return $query->result();
    }
}