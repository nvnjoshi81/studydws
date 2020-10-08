<?php
class States_model extends CI_Model
{
        
    public function getStates()
    {
        
        $this->db->select('id,state_name');
        $this->db->from('cmsstate');
        $this->db->order_by('state_name'); 
        $query=$this->db->get();
        return $query->result();
    }
    public function cities($state_id=0){
        $this->db->select('id,state_id,city_name');
        $this->db->from('cmscity');
		if(isset($state_id)&&$state_id>0){
        $this->db->where('state_id',$state_id);
		}
        $this->db->order_by('city_name'); 
        $query=$this->db->get();
        return $query->result();
    }
    function statedetails($id){
        $this->db->select('id,state_name');
        $this->db->from('cmsstate');
        $this->db->where('id',$id);
        $query=$this->db->get();
        return $query->row();
    }
    function citydetails($id){
        $this->db->select('id,state_id,city_name');
        $this->db->from('cmscity');
        $this->db->where('id',$id);
        $query=$this->db->get();
        return $query->row();
    }
    
}