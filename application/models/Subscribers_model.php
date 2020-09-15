<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Subscribers_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function add($data)
    {
        $this->db->insert('cmssubscribers',$data);
        return $this->db->insert_id();
    }
}