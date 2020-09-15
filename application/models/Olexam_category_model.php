<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Olexam_category_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function getCategoryCount()
    {
       
        return  $this->db->count_all('cmsonlinetest_cat');
    }
    
    public function getCategories()
    {
        $this->db->select('*');
        $this->db->from('cmsonlinetest_cat');
        $this->db->order_by('name');
        $query = $this->db->get();
        return $query->result();
    }
   
    
    public function addCategory($data)
    {
        $this->db->insert('cmsonlinetest_cat', $data);
        
    }
    
    public function deleteCategory($id)
    {
        $this->db->delete('cmsonlinetest_cat',array('id'=>$id));
       
    }
    
    public function updateCategory($data,$id)
    {
        $this->db->update('cmsonlinetest_cat', $data, array('id' => $id));
    }
    
    public function getCategory($id)
    {
        $this->db->select('*');
        $this->db->from('cmsonlinetest_cat');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getCategoryByExam($exam_id){
        $this->db->select('S.*');
        $this->db->from('cmschapter_details C');
        $this->db->join('cmssubjects S','S.id=C.subject_id');
        $this->db->where('C.exam_id', $exam_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    
}