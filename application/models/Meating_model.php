<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Meating_model extends CI_Model
{

    public function getcontent($limit = 0, $start = 0) {
        $this->db->select('*');
        $this->db->from('');
        if ($limit > 0) {
            $this->db->limit($limit, $start);
        }
       
        $query = $this->db->get();
        return $query->result();
    }
    
    
}
