<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SolvedPapers_model extends CI_Model {

    public function detail($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('cmssolvedpapers');

        return $query->row();
    }

    public function getSolvedPapers($exam_id = null, $subject_id = null, $chapter_id = null,$order_by=null) {
        
        $this->db->select('cmssolvedpapers.name,cmssolvedpapers.id,cmssolvedpapers_relations.exam_id,cmssolvedpapers_relations.subject_id,cmssolvedpapers_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');

        $this->db->from('cmssolvedpapers_relations');

        if ($exam_id > 0) {
            $this->db->where('cmssolvedpapers_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmssolvedpapers_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmssolvedpapers_relations.chapter_id', $chapter_id);
        }

        $this->db->join('categories', 'cmssolvedpapers_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmssolvedpapers_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmssolvedpapers_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmssolvedpapers', 'cmssolvedpapers.id=cmssolvedpapers_relations.solvedpapers_id');
        $this->db->group_by('cmssolvedpapers_relations.solvedpapers_id');
        if($order_by){
            $this->db->order_by('cmssolvedpapers.years','desc');
        }else{
            $this->db->order_by('cmssolvedpapers.id','desc');
        }
        $query = $this->db->get();
        
        //echo $this->db->last_query(); die;
        return $query->result();
    }
    
    public function getSubject_solvedpapers(){
        $this->db->select('cmssolvedpapers.name,cmssolvedpapers.id,cmssolvedpapers_relations.exam_id,cmssolvedpapers_relations.subject_id,cmssolvedpapers_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmssolvedpapers_relations');
        $this->db->join('categories', 'cmssolvedpapers_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmssolvedpapers_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmssolvedpapers_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmssolvedpapers', 'cmssolvedpapers.id=cmssolvedpapers_relations.solvedpapers_id');
        $this->db->group_by('cmssolvedpapers_relations.solvedpapers_id');
        $query = $this->db->get();
        return $query->result(); 
    }
    
    public function getSolvedPapersData($id) {
        $this->db->select('A.*,C.name as type,B.question_id,B.solvedpapers_id');
        $this->db->from('cmsquestions A');
        $this->db->join('cmssolvedpapers_details B', 'B.question_id=A.id', 'left');
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.solvedpapers_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function samplePaperDetails() {
        $this->db->select('id,solvedpapers_id,question_id,created_by,dt_created,modified_by,dt_modified,file_id');
        $this->db->from('cmssolvedpapers_details');
        $this->db->group_by('solvedpaper_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function getQuestionCount($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('cmssolvedpapers_details.question_id');
        $this->db->from('cmssolvedpapers');

        $this->db->join('cmssolvedpapers_relations', 'cmssolvedpapers_relations.solvedpapers_id=cmssolvedpapers.id');
        $this->db->join('cmssolvedpapers_details', 'cmssolvedpapers_details.solvedpapers_id=cmssolvedpapers.id');

        if ($exam_id > 0) {
            $this->db->where('cmssolvedpapers_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmssolvedpapers_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmssolvedpapers_relations.chapter_id', $chapter_id);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getCronQCount($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('COUNT(cmssolvedpapers_details.id) as qcount');
        $this->db->from('cmssolvedpapers');

        $this->db->join('cmssolvedpapers_relations', 'cmssolvedpapers_relations.solvedpapers_id=cmssolvedpapers.id');
        $this->db->join('cmssolvedpapers_details', 'cmssolvedpapers_details.solvedpapers_id=cmssolvedpapers.id');

        if ($exam_id > 0) {
            $this->db->where('cmssolvedpapers_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmssolvedpapers_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmssolvedpapers_relations.chapter_id', $chapter_id);
        }
        $query = $this->db->get();
        return $query->result();
    }
    

    public function questionTypes($id) {
        $this->db->select('cmsquestions.type as typeid,cmsquestiontypes.name as typename');
        $this->db->from('cmsquestions');
        $this->db->join('cmssolvedpapers_details', 'cmssolvedpapers_details.question_id=cmsquestions.id');
        $this->db->join('cmsquestiontypes', 'cmsquestiontypes.id=cmsquestions.type');
        $this->db->group_by('cmsquestions.type');
        $this->db->where('cmssolvedpapers_details.solvedpapers_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDetails_bymoduleID_file($mid) {
        $this->db->select('id,solvedpapers_id,question_id,created_by,dt_created,modified_by,dt_modified,file_id');
        $this->db->from('cmssolvedpapers_details');
        $this->db->join('cmsfiles', 'cmsfiles.id=cmssolvedpapers_details.file_id');
        $this->db->where('cmssolvedpapers_details.file_id>', 0);
        $this->db->where('cmssolvedpapers_details.solvedpapers_id', $mid);
        $this->db->order_by("cmsfiles.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    public function getRelationDetail($relation_data_type) {
        $this->db->select('id,solvedpapers_id,exam_id,subject_id,chapter_id,created_by,dt_created,modified_by,dt_modified');
        $this->db->from('cmssolvedpapers_relations');
        $this->db->where('solvedpapers_id', $relation_data_type);
        $query = $this->db->get();
        //echo $this->db->last_query(); die; 
        return $query->result();
    }

    public function delete_module_solvedpapers($id) {

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
        $this->db->where('solvedpapers_id', $id);
        $this->db->delete('cmssolvedpapers_relations');

        //delete from cmsncertsolutions_details table
        $this->db->where('solvedpapers_id', $id);
        $this->db->delete('cmssolvedpapers_details');

        //delete from cmsncertsolutions table
        $this->db->where('id', $id);
        $this->db->delete('cmssolvedpapers');
    }

    public function getSolvedpapersList($exam_id = 0, $subject_id = 0) {
        $this->db->select('R.solvedpapers_id,R.id,R.exam_id,R.subject_id,R.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmssolvedpapers_relations R');
        if ($exam_id > 0) {
            $this->db->where('exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        $this->db->join('categories', 'categories.id=R.exam_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id', 'left');
        //$this->db->where('chapter_id',0);
        //$this->db->order_by('ABS(exam)', 'asc');
        $this->db->order_by('categories.id', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getRelations($id) {
        $this->db->select('*')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmssolvedpapers_relations');
        $this->db->join('categories', 'cmssolvedpapers_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmssolvedpapers_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmssolvedpapers_relations.chapter_id=cmschapters.id', 'left');
        $this->db->where('cmssolvedpapers_relations.solvedpapers_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getQuestions($id, $section = null, $chapter = null) {
        $this->db->select('A.*,C.name as type');
        $this->db->from('cmsquestions A');
        $this->db->join('cmssolvedpapers_details B', 'B.question_id=A.id');
        if ($section) {
            $this->db->where('A.section', $section);
        }
        if ($chapter) {
            $this->db->where('A.chapter_id', $chapter);
        }
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.solvedpapers_id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query().'...';
        return $query->result();
    }
    
    
    public function getQuestions_new($id, $section = null, $chapter = null) {
        $this->db->select('A.*,C.name as type');
        $this->db->from('cmsquestions A');
        $this->db->join('cmssolvedpapers_details B', 'B.question_id=A.id');
        if ($section) {
            //$this->db->where('A.section_name', $section);

			$this->db->like('A.section_name', $section, 'both');
        }
        if ($chapter) {
            $this->db->where('A.chapter_id', $chapter);
        }
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.solvedpapers_id', $id);
        $query = $this->db->get();       
        return $query->result();
    }
    
    
    public function getQuestions_solvedpapers(){
        $this->db->select('A.solvedpapers_id,B.id as question_id,B.question,C.name');
        $this->db->from('cmssolvedpapers_details A');
        $this->db->join('cmsquestions B','B.id=A.question_id','left');
        $this->db->join('cmssolvedpapers C','C.id=A.solvedpapers_id','left');  
        $query = $this->db->get();
        return $query->result();
    }

    public function getSectionsForQuestions($id, $section = null,$chapter_id=null) {
        $this->db->select('A.section,A.section_name,A.id');
        $this->db->from('cmsquestions A');
        $this->db->join('cmssolvedpapers_details B', 'B.question_id=A.id');
        if ($section) {
            $this->db->where('A.section', $section);
        }
        if ($chapter_id) {
            $this->db->where('A.chapter_id', $chapter_id);
        }
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.solvedpapers_id', $id);
        $this->db->group_by('A.section');
        $query = $this->db->get();
        //echo $this->db->last_query(); 
        return $query->result();
    }
    
    public function getSectionsForQue_new($id, $section = null,$chapter_id=null) {
        $this->db->select('A.section,A.section_name,A.id');
        $this->db->from('cmsquestions A');
        $this->db->join('cmssolvedpapers_details B', 'B.question_id=A.id');
        if ($section) {
            $this->db->where('A.section_name', $section);
        }
        if ($chapter_id) {
            $this->db->where('A.chapter_id', $chapter_id);
        }
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.solvedpapers_id', $id);
        $this->db->group_by('A.section_name');
        $query = $this->db->get();
        //echo $this->db->last_query(); 
        return $query->result();
    }

    public function checkQuestion($qbid, $qid) {
        $this->db->select('id,solvedpapers_id,question_id,created_by,dt_created,modified_by,dt_modified,file_id');
        $this->db->where('question_id', $qid);
        $this->db->where('solvedpapers_id', $qbid);
        $this->db->from('cmssolvedpapers_details');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function getSolvedPapersCount($exam_id = null, $subject_id = null, $chapter_id = null)      {
        $this->db->select('*');
        $this->db->from('cmssolvedpapers_relations');

        $this->db->join('cmssolvedpapers_details', 'cmssolvedpapers_details.solvedpapers_id=cmssolvedpapers_relations.solvedpapers_id');

        if ($exam_id > 0) {
            $this->db->where('cmssolvedpapers_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmssolvedpapers_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmssolvedpapers_relations.chapter_id', $chapter_id);
        }
        $this->db->group_by('cmssolvedpapers_relations.solvedpapers_id');
        $query = $this->db->get();
        return $query->result();
    }    
    public function getClass_solvedpapers(){
        
         $this->db->select('R.solvedpapers_id,R.id,R.exam_id,R.subject_id,R.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmssolvedpapers_relations R');
        $this->db->join('categories', 'categories.id=R.exam_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id', 'left');
        $this->db->order_by('ABS(exam)', 'asc');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        return $query->result();
    }
    public function getfiles_Solvedpapers(){
        
          $this->db->select('cmsfiles.filename,cmssolvedpapers_details.file_id');
        $this->db->from('cmssolvedpapers_details');
        $this->db->join('cmsfiles','cmsfiles.id=cmssolvedpapers_details.file_id');
        $query = $this->db->get();
        return $query->result();
    }
    public function getFiles_merge($smid){
        
          $this->db->select('cmsfiles.filename,cmssolvedpapers_details.file_id,cmsfiles.displayname');
        $this->db->from('cmssolvedpapers_details');
        $this->db->join('cmsfiles','cmsfiles.id=cmssolvedpapers_details.file_id');
        $this->db->where('cmssolvedpapers_details.solvedpapers_id', $smid);
        $query = $this->db->get();
        return $query->result();
    }
    public function getContents_name($id) {
        $this->db->select('A.name');
        $this->db->from('cmssolvedpapers A');
        $this->db->where('A.id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function edit_contentsname($id,$data){
 
               $this->db->update('cmssolvedpapers',$data,array('id'=>$id));
    }
    public function search($search,$limit=0,$start=0){
        $this->db->select('V.id,V.name,R.solvedpapers_id,R.exam_id,R.subject_id,R.chapter_id,R.created_by')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmssolvedpapers V');
        $this->db->join('cmssolvedpapers_details D','D.solvedpapers_id=V.id');
        $this->db->join('cmssolvedpapers_relations R','R.solvedpapers_id=D.solvedpapers_id');
        $this->db->join('categories', 'categories.id=R.exam_id','left');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id','left');
        $this->db->join('cmschapters', 'cmschapters.id=R.chapter_id','left');
        $this->db->like('V.name',urldecode($search));
        $this->db->group_by('V.id');
        if($limit>0){
        $this->db->limit($limit,$start);
        }
        $query=$this->db->get();
        return $query->result();
    }
    public function search_count($search){
        $this->db->select('V.id,V.name,R.*')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmssolvedpapers V');
        $this->db->join('cmssolvedpapers_details D','D.solvedpapers_id=V.id');
        $this->db->join('cmssolvedpapers_relations R','R.solvedpapers_id=D.solvedpapers_id');
        $this->db->join('categories', 'categories.id=R.exam_id','left');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id','left');
        $this->db->join('cmschapters', 'cmschapters.id=R.chapter_id','left');
        $this->db->like('V.name',urldecode($search));
        $this->db->group_by('V.id');
        $query=$this->db->get();
        return $query->num_rows();
    }
    
        public function remove_examques($ol_test_id,$qus_id) {
        /*$this->db->where('solvedpapers_id', $ol_test_id);
        $this->db->where('question_id', $qus_id);
        $this->db->delete('cmssolvedpapers_details');
         * */
            echo "Admin can delete the content. ";
    }
}
