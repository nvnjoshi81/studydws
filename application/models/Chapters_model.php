<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chapters_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getChaptersCount() {
    return $this->db->count_all('cmschapters');
    }

    public function getChapters($limit = 0, $start = 0, $ordercol = 'name', $order = 'asc') {
        $this->db->select('*');
        $this->db->from('cmschapters');
        if ($limit > 0) {
            $this->db->limit($limit, $start);
        }
        $this->db->order_by($ordercol, $order);
        $query = $this->db->get();
        return $query->result();
    }

    public function getChapterDetails($id=0) {
        $this->db->select('*');
        $this->db->from('cmschapters');
        $this->db->join('cmschapter_details', 'cmschapter_details.chapter_id=cmschapters.id');
        if($id>0){
		$this->db->where('cmschapters.id', $id);
	    }
        $query = $this->db->get();
        return $query->result();
    }

    public function addChapter($data) {
        $this->db->insert('cmschapters', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function linkChapter($data) {
        $this->db->insert('cmschapter_details', $data);
    }

    public function deleteChapter($id) {
        $this->db->delete('cmschapters', array('id' => $id));
    }

    public function updateChapter($data, $id) {
        $this->db->update('cmschapters', $data, array('id' => $id));
    }
	
	

    public function getChapterDetailsEnter($class_id,$subject_id,$chapter_id,$sort) {
		
		$data=array('sortorder'=>$sort);
		
		//$this->db->update('cmschapter_details', $data, array('chapter_id' => $chapter_id,'class_id' => $class_id,'subject_id' => $subject_id));
    }
	

    public function getChapter($id) {
        $this->db->select('*');
        $this->db->from('cmschapters');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
	
		
 public function getChaptersDetails($id) {
        $this->db->distinct('subject_id');
        $this->db->where('chapter_id', $id);
        $this->db->from('cmschapter_details');
        $query = $this->db->get();
        return $query->result();
    }

    public function getClassInfo($id) {
        $this->db->select('*');
        $this->db->from('cmschapters');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getChapterClasses($id) {
        $this->db->distinct('class_id');
        $this->db->where('chapter_id', $id);
        $this->db->from('cmschapter_details');
        $query = $this->db->get();
        return $query->result();
    }

    public function getChapterSubjects($id) {
        $this->db->distinct('subject_id');
        $this->db->where('chapter_id', $id);
        $this->db->from('cmschapter_details');
        $query = $this->db->get();
        return $query->result();
    }

    public function unlinkChapter($chapter_id) {
        $this->db->where('chapter_id', $chapter_id);
        $this->db->delete('cmschapter_details');
    }

    public function getChapterByExamSubject($exam_id, $subject_id) {
        $this->db->select('*');
        $this->db->from('cmschapters');
        $this->db->join('cmschapter_details', 'cmschapter_details.chapter_id=cmschapters.id');
        $this->db->where('cmschapter_details.class_id', $exam_id);
        $this->db->where('cmschapter_details.subject_id', $subject_id);
        $this->db->order_by('cmschapters.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function getChapterByExamSubject_multiple($exam_id, $subject_id) {

        $this->db->select('*');
        $this->db->from('cmschapters');
        $this->db->join('cmschapter_details', 'cmschapter_details.chapter_id=cmschapters.id');
        $this->db->where_in('cmschapter_details.class_id', str_replace('-', ',', $exam_id));
        $this->db->where_in('cmschapter_details.subject_id', str_replace('-', ',', $subject_id));
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function getChapterByName($name) {
        $this->db->select('*');
        $this->db->from('cmschapters');
        $this->db->like('name', $name);
        $query = $this->db->get();
        return $query->result();
    }
    
     public function getChapterById($id) {
        $this->db->select('*');
        $this->db->from('cmschapters');
        $this->db->like('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getChapterBySlug($slug) {
        $this->db->select('*');
        $this->db->from('cmschapters');
        $this->db->like('slug', $slug);
        $query = $this->db->get();
		//echo $this->db->last_query();
        return $query->row();
    }

    public function getList() {
        $this->db->select('*');
        $this->db->from('cmschapters');
        $this->db->where('slug', null);
        $query = $this->db->get();
        return $query->result();
    }

}
