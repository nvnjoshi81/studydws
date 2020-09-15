<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Answers_model extends CI_Model
{
    public function add($data){
        $this->db->insert('cmsanswers',$data);
        return $this->db->insert_id();
    }
}
