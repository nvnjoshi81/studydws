<?php

class History_model extends CI_Model {

    function count($type) {

        $this->db->select('id');
        if ($type == 1) {
            $this->db->from('cmsvideohistory');
        }else{
            $this->db->from('cmsdownloadhistory');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function all($type,$start,$end) {
        $this->db->select('H.*,C.firstname,C.id as user_id');
        $this->db->join('cmscustomers C','C.id=H.user_id');
        $this->db->limit($start,$end);
        if ($type == 1) {
            $this->db->from('cmsvideohistory H');
        }else{
            $this->db->from('cmsdownloadhistory H');
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    function getDownloadHistory($customerid,$fileid,$type = 2){
        $this->db->select('H.*,C.firstname,C.id as user_id');
        $this->db->join('cmscustomers C','C.id=H.user_id');
        if ($type == 1) {
            $this->db->from('cmsvideohistory H');
        }else{
            $this->db->from('cmsdownloadhistory H');
        }
        $this->db->where('user_id',$customerid);
        $this->db->where('fileid',$fileid);
        $query = $this->db->get();
        return $query->result(); 
    }

}
