<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Mergesection_model extends CI_Model {

    public function merge_module($data) {
        $this->db->insert('cmsmergesection', $data);
        return $this->db->insert_id();
    }

    public function delete_merge_section($moduleId, $moduleType, $related_moduleId, $relatedModuleType, $last_levelId) {
        $where_array =array('module_id' => $moduleId, 'module_type' => $moduleType, 'related_module_id' => $related_moduleId, 'related_module_type' => $relatedModuleType, 'related_file_id' => $last_levelId);
        print_r($where_array); die;
        $this->db->delete('cmsmergesection', $where_array);
        //$this->session->set_flashdata('message', 'Information Deleted!');
        //redirect('admin/mergesection/merge/' . $moduleId . '/' . $moduleType);
    }
    public function getlist(){
         $module_id = 23;
        
    }
    // $module_id   =   Video List ID (videos)
    //              =   Quesation Bank ID
    //              =   Sample Paper ID
    //              =   Solved Paper ID
    //              =   Study Package ID
    //              =   Ncert Solution ID
    //              =   Online TEST ID
    // $module_item_id     =   Question ID
    //              =   Video ID
    //              =   Postings ID    
    public function getRelatedModule($module_id,$module_type,$related_module_type=null,$related_module_id=null){
        
        $this->db->select('*');
        $this->db->from('cmsmergesection');
        if($related_module_id){
            $this->db->where('related_module_id',$related_module_id);
        }
        if($related_module_type){
            $this->db->where('related_module_type',$related_module_type);
        }
        $this->db->where('module_id',$module_id);
        $this->db->where('module_type',$module_type);
        $query=$this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    
    public function get_studymaterial_by_file_id($file_id){
        $this->db->select('studymaterial_id');
        $this->db->from('cmsstudymaterial_details');
        $this->db->where('file_id',$file_id);
        $query=$this->db->get();
        return $query->result();
    }
	
	
    public function get_fileid_by_studymaterial($studymaterialid){
        $this->db->select('id,studymaterial_id,file_id');
        $this->db->from('cmsstudymaterial_details');
        $this->db->where('studymaterial_id',$studymaterialid);
		$this->db->order_by('id','desc');
        $query=$this->db->get();
        return $query->result();
    }
	

}
