<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model
{
    public function getAdminUsers(){
        $this->db->select('id,email,password,pass,first_name,last_name,mobile,type,company,address,city,state,postcode,dt_created,dt_modified');
        $this->db->from('admin');
        $this->db->where('type',2);
        $query=$this->db->get();
        return $query->result();
    }
    public function getAdminUser($id){
        $this->db->select('id,email,password,pass,first_name,last_name,mobile,type,company,address,city,state,postcode,dt_created,dt_modified');
        $this->db->from('admin');
        $this->db->where('id',$id);
        $query=$this->db->get();
        return $query->row();
    }
	
	
	
	
	
    public function createUser($data){
        $this->db->insert('admin',$data);
        return $this->db->insert_id();
    }
	
	 public function save_analytics($data){
        $this->db->insert('analytics_web',$data);
        return $this->db->insert_id();
    }
	
    
    public function userPermissions($permissions) {
        $this->db->insert('cmsuserpermissions', $permissions);
    }
   
    public function getUserPermissions($user_id){
        $this->db->select('id,user_id,item_id,type');
        $this->db->from('cmsuserpermissions');
        $this->db->where('user_id',$user_id);
        $query=$this->db->get();
        return $query->result();
    }
    public function flushPermissions($id){
        $this->db->where('user_id',$id);
        $this->db->delete('cmsuserpermissions');
    }
    public function updateUser($id,$data)
    {
        $this->db->update('admin', $data, array('id' => $id));       
    }
    public function deleteUser($id) {
        if($id > 1){
        $this->flushPermissions($id);
        $this->db->where('id',$id);
        $this->db->delete('admin');    
        }
    }
}
