<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Questionbank_model extends CI_Model {

    public function add($data) {
        $this->db->insert('cmsquestionbank', $data);
        return $this->db->insert_id();
    }

    public function addDetails($data) {
        $this->db->insert('cmsquestionbank_details', $data);
        return $this->db->insert_id();
    }

    public function detail($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('cmsquestionbank');
        return $query->row();
    }
    
		public function detailsrelation($id) {
	    $this->db->select('A.id,A.name,A.language,A.is_deleted,A.view_count,B.questionbank_id,B.exam_id,B.subject_id,B.chapter_id');
        $this->db->from('cmsquestionbank A');
        $this->db->join('cmsquestionbank_relations B', 'B.questionbank_id=A.id', 'left');
        $this->db->where('A.id', $id);
        $query = $this->db->get();
        return $query->row();
	}
	
	
    public function checkqb($exam_id, $subject_id, $chapter_id) {
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('chapter_id', $chapter_id);
        $this->db->from('cmsquestionbank_relations');
        $query = $this->db->get();
        return $query->row();
    }

    public function getQuestionBank($exam_id = null, $subject_id = null, $chapter_id = null,$limit=null) {
        $this->db->select('cmsquestionbank.name,cmsquestionbank.id,cmsquestionbank_relations.exam_id,cmsquestionbank_relations.subject_id,cmsquestionbank_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');

        if ($exam_id > 0) {
            $this->db->where('cmsquestionbank_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsquestionbank_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsquestionbank_relations.chapter_id', $chapter_id);
        }
        $this->db->join('categories', 'cmsquestionbank_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsquestionbank_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsquestionbank_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsquestionbank', 'cmsquestionbank.id=cmsquestionbank_relations.questionbank_id');
        if($limit > 0){
            $this->db->limit($limit);
        }
        $this->db->from('cmsquestionbank_relations');
        $this->db->order_by('cmsquestionbank.id', 'desc');
        $query = $this->db->get();
       // echo $this->db->last_query();die;
        return $query->result();
    }


public function getSubSubject_indi($exam_id = null, $subexam_id=null, $subject_id = null, $chapter_id = null,$limit=null) {
        $this->db->select('cmsquestionbank.name,cmsquestionbank.id,cmsquestionbank_relations.exam_id,cmsquestionbank_relations.subject_id,cmsquestionbank_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');

        if ($exam_id > 0) {
            $this->db->where('cmsquestionbank_relations.exam_id', $exam_id);
        }
		
		
        if ($subexam_id > 0) {
            $this->db->where('cmsquestionbank_relations.subexam_id', $subexam_id);
        }
		
        if ($subject_id > 0) {
            $this->db->where('cmsquestionbank_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsquestionbank_relations.chapter_id', $chapter_id);
        }
        $this->db->join('categories', 'cmsquestionbank_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsquestionbank_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsquestionbank_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsquestionbank', 'cmsquestionbank.id=cmsquestionbank_relations.questionbank_id');
        if($limit > 0){
            $this->db->limit($limit);
        }
        $this->db->from('cmsquestionbank_relations');
        $this->db->order_by('cmsquestionbank.id', 'desc');
        $query = $this->db->get();
       // echo $this->db->last_query();die;
        return $query->result();
    }
    public function getQuestionbankData($id) {

        $this->db->select('A.*,C.name as type,B.question_id');
        $this->db->from('cmsquestions A');
        $this->db->join('cmsquestionbank_details B', 'B.question_id=A.id', 'left');
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.questionbank_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

 
    public function getQuestionCount($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('cmsquestionbank_details.question_id');
        $this->db->from('cmsquestionbank');

        $this->db->join('cmsquestionbank_details', 'cmsquestionbank_details.questionbank_id=cmsquestionbank.id');
        $this->db->join('cmsquestionbank_relations', 'cmsquestionbank_relations.questionbank_id=cmsquestionbank.id');

        if ($exam_id > 0) {
            $this->db->where('cmsquestionbank_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsquestionbank_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsquestionbank_relations.chapter_id', $chapter_id);
        }
        $query = $this->db->get();
       //echo $this->db->last_query();
        
        return $query->result();
    }

    public function questionTypes($id) {
        $this->db->select('cmsquestions.type as typeid,cmsquestiontypes.name as typename');
        $this->db->from('cmsquestions');
        $this->db->join('cmsquestionbank_details', 'cmsquestionbank_details.question_id=cmsquestions.id');
        $this->db->join('cmsquestiontypes', 'cmsquestiontypes.id=cmsquestions.type');
        $this->db->group_by('cmsquestions.type');
        $this->db->where('cmsquestionbank_details.questionbank_id', $id);
        $query = $this->db->get();
        return $query->result();
    }
	
    public function getSubClass($mainExamid) {
	   $this->db->select('id,name,parent_id');
        $this->db->from('categories');
        $this->db->where('parent_id', $mainExamid);
        $query = $this->db->get();
        return $query->result();
	} 
	  public function getSubSubject($mainSubjectid) {
	   $this->db->select('id,name,parent_id');
       $this->db->from('cmssubjects');
       $this->db->where('parent_id', $mainSubjectid);
       $query = $this->db->get();
       return $query->result();
	}
    public function getDetails_bymoduleID_file($mid) {
        $this->db->select('*');
        $this->db->from('cmsquestionbank_details');
        $this->db->join('cmsfiles', 'cmsfiles.id=cmsquestionbank_details.file_id', 'left');
        $this->db->where('cmsquestionbank_details.file_id>', 0);
        $this->db->where('cmsquestionbank_details.questionbank_id', $mid);
        $this->db->order_by("cmsfiles.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    public function getQbDetails($id) {
        $this->db->select('A.*,C.name as type,A.type as typeid,B.question_id');
        $this->db->from('cmsquestions A');
        $this->db->join('cmsquestionbank_details B', 'B.question_id=A.id', 'left');
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.questionbank_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getQuestions($id) {
        $this->db->select('A.*,C.name as type');
        $this->db->from('cmsquestions A');
        $this->db->join('cmsquestionbank_details B', 'B.question_id=A.id', 'left');
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.questionbank_id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    
	/*public function getQuestions($id) {
        $this->db->select('A.*,C.name as type,D.answer,D.answer_extra,D.description,D.is_correct');
        $this->db->from('cmsquestions A');
        $this->db->join('cmsquestionbank_details B', 'B.question_id=A.id', 'left');
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->join('cmsanswers D', 'D.question_id=A.id', 'left');
        $this->db->where('B.questionbank_id', $id);
        $query = $this->db->get();
        return $query->result();
    }*/

    public function checkQuestion($qbid, $qid) {
        $this->db->select('id,questionbank_id,question_id,created_by,dt_created,modified_by,dt_modified,file_id');
        $this->db->where('question_id', $qid);
        $this->db->where('questionbank_id', $qbid);
        $this->db->from('cmsquestionbank_details');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getRelations($id) {
        $this->db->select('cmsquestionbank_relations.id,cmsquestionbank_relations.questionbank_id,'
                . 'cmsquestionbank_relations.exam_id,cmsquestionbank_relations.subject_id,cmsquestionbank_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsquestionbank_relations');
        $this->db->join('categories', 'cmsquestionbank_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsquestionbank_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsquestionbank_relations.chapter_id=cmschapters.id', 'left');
        $this->db->where('cmsquestionbank_relations.questionbank_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getRelationDetail($relation_data_type) {
        $this->db->select('cmsquestionbank_relations.id,cmsquestionbank_relations.questionbank_id,cmsquestionbank_relations.exam_id,cmsquestionbank_relations.subject_id,cmsquestionbank_relations.chapter_id');
        $this->db->from('cmsquestionbank_relations');
        $this->db->where('questionbank_id', $relation_data_type);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }

    public function delete_module_questionbank($id) {

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
        $this->db->where('questionbank_id', $id);
        $this->db->delete('cmsquestionbank_relations');

        //delete from cmsncertsolutions_details table
        $this->db->where('questionbank_id', $id);
        $this->db->delete('cmsquestionbank_details');

        //delete from cmsncertsolutions table
        $this->db->where('id', $id);
        $this->db->delete('cmsquestionbank');
    }
    public function remove_examques($ol_test_id,$qus_id) {
        $this->db->where('questionbank_id', $ol_test_id);
        $this->db->where('question_id', $qus_id);
        $this->db->delete('cmsquestionbank_details');
    }

    public function getQBList($exam_id = 0, $subject_id = 0) {
        $this->db->select('cmsquestionbank_relations.id,cmsquestionbank_relations.questionbank_id,'
                . 'cmsquestionbank_relations.exam_id,cmsquestionbank_relations.subject_id,cmsquestionbank_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmsquestionbank_relations');
        if ($exam_id > 0) {
            $this->db->where('exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        $this->db->join('categories', 'categories.id=cmsquestionbank_relations.exam_id');
        $this->db->join('cmssubjects', 'cmssubjects.id=cmsquestionbank_relations.subject_id');
        //$this->db->where('chapter_id',0);
        $this->db->order_by('ABS(exam)', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function search($search, $limit = 0, $start = 0) {
        $this->db->select('V.id,V.name,R.questionbank_id,R.exam_id,R.subject_id,R.chapter_id,R.created_by')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsquestionbank V');
        $this->db->join('cmsquestionbank_details D', 'D.question_id=V.id');
        $this->db->join('cmsquestionbank_relations R', 'R.questionbank_id=D.questionbank_id');
        $this->db->join('categories', 'categories.id=R.exam_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id', 'left');
        $this->db->join('cmschapters', 'cmschapters.id=R.chapter_id', 'left');
        $this->db->like('V.name', urldecode($search));
        $this->db->group_by('V.id');
        if ($limit > 0) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function search_count($search) {
        $this->db->select('V.id,V.name,R.*')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsquestionbank V');
        $this->db->join('cmsquestionbank_details D', 'D.question_id=V.id');
        $this->db->join('cmsquestionbank_relations R', 'R.questionbank_id=D.questionbank_id');
        $this->db->join('categories', 'categories.id=R.exam_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id', 'left');
        $this->db->join('cmschapters', 'cmschapters.id=R.chapter_id', 'left');
        $this->db->like('V.name', urldecode($search));
        $this->db->group_by('V.id');
        $query = $this->db->get();
        return $query->num_rows();
    }
      public function getClass_Questionbank(){
        $this->db->select('cmsquestionbank_relations.id,cmsquestionbank_relations.questionbank_id,'
                . 'cmsquestionbank_relations.exam_id,cmsquestionbank_relations.subject_id,cmsquestionbank_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmsquestionbank_relations');
        $this->db->join('categories', 'categories.id=cmsquestionbank_relations.exam_id');
        $this->db->join('cmssubjects', 'cmssubjects.id=cmsquestionbank_relations.subject_id');
        $this->db->order_by('ABS(exam)', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getChapter_Questionbank(){
        $this->db->select('cmsquestionbank.name,cmsquestionbank.id,cmsquestionbank_relations.exam_id,cmsquestionbank_relations.subject_id,cmsquestionbank_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsquestionbank_relations');
        $this->db->join('categories', 'cmsquestionbank_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsquestionbank_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsquestionbank_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsquestionbank', 'cmsquestionbank.id=cmsquestionbank_relations.questionbank_id');
        $this->db->order_by('cmsquestionbank.id','desc');
        $query = $this->db->get();
        return $query->result();
    }

    
      public function getQuestions_Questionbank(){
        $this->db->select('A.questionbank_id,B.id as question_id,B.question,C.name');
        $this->db->from('cmsquestionbank_details A');
        $this->db->join('cmsquestions B','B.id=A.question_id','left');
        $this->db->join('cmsquestionbank C','C.id=A.questionbank_id','left');        
        $query = $this->db->get();
        //echo $this->db->last_query();         
        return $query->result();
    }
    
        public function getfiles_Questionbank() {
        $this->db->select('cmsfiles.filename,cmsquestionbank_details.file_id');
        $this->db->from('cmsquestionbank_details');
        $this->db->join('cmsfiles','cmsfiles.id=cmsquestionbank_details.file_id');
        $query = $this->db->get();
        return $query->result();
    }
     public function getFiles_merge($smid) {
        $this->db->select('cmsfiles.id,cmsfiles.filename,cmsquestionbank_details.file_id,cmsfiles.displayname');
        $this->db->from('cmsquestionbank_details');
        $this->db->join('cmsfiles','cmsfiles.id=cmsquestionbank_details.file_id');
        $this->db->where('cmsquestionbank_details.questionbank_id', $smid);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    public function getContents_name($id) {
        $this->db->select('A.name');
        $this->db->from('cmsquestionbank A');
        $this->db->where('A.id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function edit_contentsname($id,$data){
 
               $this->db->update('cmsquestionbank',$data,array('id'=>$id));
    }


    
}
