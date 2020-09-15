<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Search_model extends CI_Model {

    public function insert($searchtxt,$ip,$results,$type,$user_id=0) {
        $data=array('searchtxt'=>urldecode($searchtxt),'ip_address'=>$ip,'user_id'=>$user_id,'results'=>$results,'type'=>$type);
        $this->db->insert('cmssearch',$data);
    }
   
    public function getSearchResult($search){
       $this->db->select('*');
        $this->db->from('cmssearch');
        $this->db->where('searchtxt', $search);
        $query = $this->db->get();        
        return $query->num_rows();
    } 
    
}
