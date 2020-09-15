<?php 
class Recommendations_model extends CI_Model{
	
	public function getRecommendationsCount($user_id){
		$this->db->where('user_id',$user_id);
		$rs=$this->db->get('cmssearch');
		return $rs->num_rows();
	}
    
    function getMyRecommendations($customer_id, $limit_start = null, $limit_end = null) {
        if ($limit_start || $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
        $this->db->select('*');
        $this->db->from('cmssearch');
        $this->db->where('user_id', $customer_id);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
}
?>