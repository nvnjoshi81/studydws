<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Instructions_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function getInstructionsCount()
    {
    return  $this->db->count_all('instructions');
    }
    
    public function getContentType()
    {
        $this->db->select('id,order,name,created_by,dt_created,modified_by,dt_modified');
        $this->db->from('content_type');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getInstruction()
    {
        $this->db->select('id,description,content_type');
        $this->db->from('instructions');
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function addInstruction($data)
    {
        $this->db->insert('instructions', $data);
        
    }
    
    public function deleteInstruction($id)
    {
        $this->db->delete('instructions',array('id'=>$id));
    }
    
    public function updateInstruction($id,$data)
    {
        $this->db->update('instructions', $data, array('id' => $id));
    } 
    
    public function getInstructionDetail($id)
    {
        $this->db->select('id,description,content_type');
        $this->db->from('instructions');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
 
   
}