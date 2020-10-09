<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class File_model extends CI_Model {

    public function unlink_and_remove_byId($id, $module_id, $module_type_id) {
        $this->db->select('filename,filepath,filename_one,filepath_one');
        $this->db->from('cmsfiles');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $this->db->delete('cmsfiles', array('id' => $id));
        return $query->result();
    }

    public function add($data) {
        $this->db->insert('cmsfiles', $data);
        return $this->db->insert_id();
    }

    public function detail($fileid) {
        $this->db->select('id,displayname,filename,filepath,filename_one,filepath_one,type,filetype,pagecount,is_deleted');
        $this->db->where('id', $fileid);
        $this->db->from('cmsfiles');
        $query = $this->db->get();
        return $query->row();
    }
    public function getStudyPackageDetails($fileid,$productlist_id=0,$classid=0){
        $this->db->select('F.id,F.displayname,F.filename,F.filepath,' . 
'F.filename_one,F.filepath_one,F.type,F.filetype,F.pagecount,F.is_deleted')->select('S.name')->select('categories.name as exam,categories.id as exam_id')
                ->select('cmssubjects.name as subject,cmssubjects.id as subject_id')
                ->select('cmschapters.name as chapter,cmschapters.id as chapter_id');
				if($classid>0){
        $this->db->where('categories.id', $classid);	
				}
				
        $this->db->where('F.id', $fileid);
        $this->db->from('cmsfiles F');
        $this->db->join('cmsstudymaterial_details D','D.file_id=F.id');
        $this->db->join('cmsstudymaterial_relations R','R.studymaterial_id=D.studymaterial_id');
        $this->db->join('cmsstudymaterial S','S.id=D.studymaterial_id');
        $this->db->join('categories','R.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects','R.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters','R.chapter_id=cmschapters.id', 'left');
        $query = $this->db->get();
		//echo $this->db->last_query(); 
        return $query->row();
    }
     public function getBooksDetails($fileid,$productlist_id=0,$classid=0){
        $this->db->select('F.id,F.displayname,F.filename,F.filepath,' . 
'F.filename_one,F.filepath_one,F.type,F.filetype,F.pagecount,F.is_deleted')->select('S.name')->select('categories.name as exam,categories.id as exam_id')
                ->select('cmssubjects.name as subject,cmssubjects.id as subject_id')
                ->select('cmschapters.name as chapter,cmschapters.id as chapter_id');
				if($classid>0){
        $this->db->where('categories.id', $classid);	
				}
				
        $this->db->where('F.id', $fileid);
        $this->db->from('cmsfiles F');
        $this->db->join('cmsbooks_details D','D.file_id=F.id');
        $this->db->join('cmsbooks_relations R','R.books_id=D.books_id');
        $this->db->join('cmsbooks S','S.id=D.books_id');
        $this->db->join('categories','R.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects','R.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters','R.chapter_id=cmschapters.id', 'left');
        $query = $this->db->get();
		//echo $this->db->last_query(); 
        return $query->row();
    }
    
      public function edit_displayname($id,$data){
 
               $this->db->update('cmsfiles',$data,array('id'=>$id));
    }

}  