<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Books_model extends CI_Model {

    public function getBooks($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('cmsbooks.name,cmsbooks.id,cmsbooks_relations.exam_id,cmsbooks_relations.subject_id,cmsbooks_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsbooks_relations');

        if ($exam_id > 0) {
            $this->db->where('cmsbooks_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsbooks_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsbooks_relations.chapter_id', $chapter_id);
        }
        $this->db->join('categories', 'cmsbooks_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsbooks_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsbooks_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsbooks', 'cmsbooks.id=cmsbooks_relations.books_id');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function getBooksDetails($id) {
        $this->db->select('*');
        $this->db->from('cmsquestions');
        $this->db->join('cmsbooks_details', 'cmsbooks_details.question_id=cmsquestions.id');
        $this->db->join('cmsanswers', 'cmsanswers.question_id=cmsbooks_details.question_id');
        $this->db->where('cmsbooks_details.questionbank_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function details($id) {
        $this->db->select('*');
        $this->db->from('cmsbooks');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
	
	
	   public function detail($id) {
        $this->db->select('A.id,A.name,B.exam_id,B.subject_id,B.chapter_id');
        $this->db->from('cmsbooks A');
        $this->db->join('cmsbooks_relations B','A.id=B.books_id','left');
        $this->db->where('A.id', $id);
        $query = $this->db->get();
        return $query->row();
    }


    public function getBookDetails($id) {
        $this->db->select('*');
        $this->db->from('cmsbooks_details');
        $this->db->join('cmsfiles', 'cmsfiles.id=cmsbooks_details.file_id');
        $this->db->where('cmsbooks_details.file_id>', 0);
        $this->db->where('cmsbooks_details.books_id', $mid);
        $this->db->order_by("cmsfiles.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    public function getDetails_bymoduleID_file($mid) {
        $this->db->select('*');
        $this->db->from('cmsbooks_details');
        $this->db->join('cmsfiles', 'cmsfiles.id=cmsbooks_details.file_id');
        $this->db->where('cmsbooks_details.file_id>', 0);
        $this->db->where('cmsbooks_details.books_id', $mid);
        $this->db->order_by("cmsfiles.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    public function getRelationDetail($relation_data_type) {
        $this->db->select('*');
        $this->db->from('cmsbooks_relations');
        $this->db->where('books_id', $relation_data_type);
        $query = $this->db->get();
        //echo $this->db->last_query(); die; 
        return $query->result();
    }

    public function delete_module_books($id) {
        $file_check_array = $this->getDetails_bymoduleID_file($id);

        //delete file if exist
        if (count($file_check_array) > 0) {
            $file_id = $file_check_array[0]->file_id;
            $filename = $file_check_array[0]->filename;
            $filepath = $file_check_array[0]->filepath;
            $filename_one = $file_check_array[0]->filename_one;
            $filepath_one = $file_check_array[0]->filepath_one;
            unlink($_SERVER['DOCUMENT_ROOT'] . $filepath . $filename);
            unlink($_SERVER['DOCUMENT_ROOT'] . $filepath_one . $filename_one);
            $this->db->where('id', $file_id);
            $this->db->delete('cmsfiles');
        }

        //delete from cmspricelist table
        $this->db->where('modules_item_id', $id);
        $this->db->delete('cmspricelist');

        //delete from cmsncertsolutions_relations table
        $this->db->where('books_id', $id);
        $this->db->delete('cmsbooks_relations');

        //delete from cmsncertsolutions_details table
        $this->db->where('books_id', $id);
        $this->db->delete('cmsbooks_details');

        //delete from cmsncertsolutions table
        $this->db->where('id', $id);
        $this->db->delete('cmsbooks');
    }

    public function getBooksCount($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('*');
        $this->db->from('cmsbooks');
        $this->db->join('cmsbooks_relations', 'cmsbooks_relations.books_id=cmsbooks.id');
        $this->db->join('cmsbooks_details', 'cmsbooks_details.books_id=cmsbooks.id');

        if ($exam_id > 0) {
            $this->db->where('cmsbooks_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsbooks_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsbooks_relations.chapter_id', $chapter_id);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function getBooksList($exam_id = 0, $subject_id = 0) {
        $this->db->select('*')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmsbooks_relations');
        
        if ($exam_id > 0) {
            $this->db->where('exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        $this->db->join('categories', 'categories.id=cmsbooks_relations.exam_id');
        $this->db->join('cmssubjects', 'cmssubjects.id=cmsbooks_relations.subject_id');
        //$this->db->where('chapter_id',0);
        $this->db->order_by('ABS(exam)', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
    public function getRelations($id){
        $this->db->select('*')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsbooks_relations');
        $this->db->join('categories','cmsbooks_relations.exam_id=categories.id','left');
        $this->db->join('cmssubjects','cmsbooks_relations.subject_id=cmssubjects.id','left');
        $this->db->join('cmschapters','cmsbooks_relations.chapter_id=cmschapters.id','left');
        $this->db->where('cmsbooks_relations.books_id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    public function getFiles($smid){
        $this->db->select('F.*,P.price,P.discounted_price,D.file_id');
        $this->db->from('cmsfiles F');
        $this->db->join('cmsbooks_details D','D.file_id=F.id');
        $this->db->join('cmspricelist P','P.item_id=F.id','left');
        //$this->db->where('P.type',1);
        $this->db->where('D.books_id',$smid);
        $query=$this->db->get();
        return $query->result();
    }
    public function getBooksFiles($fid){
        $this->db->select('F.*,P.price,P.discounted_price,D.file_id,D.books_id');
        $this->db->from('cmsfiles F');
        $this->db->join('cmsbooks_details D','D.file_id=F.id');
        $this->db->join('cmspricelist P','P.item_id=F.id','left');
        $this->db->where('F.id',$fid);
        $query=$this->db->get();
        return $query->result();
    }
   
}
