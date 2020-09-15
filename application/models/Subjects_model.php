<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Subjects_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function getSubjectsCount()
    {
       
        return  $this->db->count_all('cmssubjects');
    }
    
    public function getSubjects()
    {
        $this->db->select('*');
        $this->db->from('cmssubjects');
        $this->db->order_by('name');
        $query = $this->db->get();
        return $query->result();
    }
   
    
    public function addSubject($data)
    {
        $this->db->insert('cmssubjects', $data);
        
    }
    
    public function deleteSubject($id)
    {
        $this->db->delete('cmssubjects',array('id'=>$id));
       
    }
    
    public function updateSubject($data,$id)
    {
        $this->db->update('cmssubjects', $data, array('id' => $id));
    }
    
    
    public function getSubject($id)
    {
        $this->db->select('*');
        $this->db->from('cmssubjects');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getSubjectsByExam($exam_id){
        $this->db->select('S.*');
        $this->db->from('cmschapter_details C');
        $this->db->join('cmssubjects S','S.id=C.subject_id');
        $this->db->where('C.exam_id', $exam_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    
}