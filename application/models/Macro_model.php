<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Macro_model extends CI_Model
{
    public function getall_macro() {
        $this->db->select('id,macro,value,extra');
        $this->db->from('cmsmacro');
        $query = $this->db->get();
        return $query->result();
    }
}
