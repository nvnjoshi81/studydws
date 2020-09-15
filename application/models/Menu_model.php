<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends CI_Model
{
    public function getMenuitems(){
        $this->db->order_by('title','asc');
        $query=$this->db->get('cmsmenu');
        return $query->result();
    }
    
    public function getIdBySlug($slug) {
        $this->db->select('id');
        $this->db->where('slug',$slug);
        $this->db->from('cmsmenu');
        $query=  $this->db->get();
        return $query->row();
    }
}
