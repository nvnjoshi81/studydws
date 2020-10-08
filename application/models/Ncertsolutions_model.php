<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ncertsolutions_model extends CI_Model {

    public function add($data) {
        $this->db->insert('cmsncertsolutions', $data);
        return $this->db->insert_id();
    }

    public function addDetails($data) {
        $this->db->insert('cmsncertsolutions_details', $data);
        return $this->db->insert_id();
    }

    public function detail($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('cmsncertsolutions');
        return $query->row();
    }

    public function ncertsolutions_relations_details($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('cmsncertsolutions_relations');
        //echo $this->db->last_query(); die; 
        return $query->row();
    }

    public function getNcertSolutions($exam_id = null, $subject_id = null, $chapter_id = null,$limit=null) {
        $this->db->select('cmsncertsolutions.name,cmsncertsolutions.id,cmsncertsolutions_relations.exam_id,cmsncertsolutions_relations.subject_id,cmsncertsolutions_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsncertsolutions_relations');

        if ($exam_id > 0) {
            $this->db->where('cmsncertsolutions_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsncertsolutions_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsncertsolutions_relations.chapter_id', $chapter_id);
        }
        if($limit !=null){
            $this->db->limit($limit);
        }
        $this->db->join('categories', 'cmsncertsolutions_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsncertsolutions_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsncertsolutions_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsncertsolutions', 'cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id');
        $this->db->order_by('cmsncertsolutions.id','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    public function getCronNS($exam_id = null, $subject_id = null, $chapter_id = null,$limit=null) {
        $this->db->select('count(cmsncertsolutions.id) as package_count')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsncertsolutions_relations');

        if ($exam_id > 0) {
            $this->db->where('cmsncertsolutions_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsncertsolutions_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsncertsolutions_relations.chapter_id', $chapter_id);
        }
        if($limit !=null){
            $this->db->limit($limit);
        }
        $this->db->join('categories', 'cmsncertsolutions_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsncertsolutions_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsncertsolutions_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsncertsolutions', 'cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id');
        $this->db->order_by('cmsncertsolutions.id','desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getNcertSolutionsData($id) {
        $this->db->select('A.*,C.name as type,B.question_id,A.question');
        $this->db->from('cmsquestions A');
        $this->db->join('cmsncertsolutions_details B', 'B.question_id=A.id', 'left');
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.ncertsolutions_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDetails_bymoduleID_file($mid) {
        $this->db->select('*');
        $this->db->from('cmsncertsolutions_details');
        $this->db->join('cmsfiles', 'cmsfiles.id=cmsncertsolutions_details.file_id');
        $this->db->where('cmsncertsolutions_details.file_id>', 0);
        $this->db->where('cmsncertsolutions_details.ncertsolutions_id', $mid);
        $this->db->order_by("cmsfiles.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    public function getRelationDetail($relation_data_type) {
        $this->db->select('id,ncertsolutions_id,exam_id,subject_id,chapter_id,created_by,dt_created,modified_by,dt_modified');
        $this->db->from('cmsncertsolutions_relations');
        $this->db->where('ncertsolutions_id', $relation_data_type);
        $query = $this->db->get();
        //echo $this->db->last_query(); die; 
        return $query->result();
    }

    public function checksolution($name) {
        $this->db->select('id,ncertsolutions_id,exam_id,subject_id,chapter_id,created_by,dt_created,modified_by,dt_modified');
        $this->db->from('cmsncertsolutions n');

        $this->db->where('name', $name);

        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            $result = $query->row();
            return $result->id;
        }
    }

    public function checkrelation($solid, $exam_id, $subject_id, $chapter_id) {
        $this->db->select('id,ncertsolutions_id,exam_id,subject_id,chapter_id,created_by,dt_created,modified_by,dt_modified');
        $this->db->from('cmsncertsolutions_relations');
        $this->db->where('ncertsolutions_id', $solid);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('chapter_id', $chapter_id);
        $query = $this->db->get();
        //echo $this->db->last_query(); die; 
        return $query->result();
    }
    public function getRelations($id) {
        $this->db->select('cmsncertsolutions_relations.id ,cmsncertsolutions_relations.ncertsolutions_id,cmsncertsolutions_relations.exam_id,cmsncertsolutions_relations.subject_id,cmsncertsolutions_relations.chapter_id,cmsncertsolutions_relations.created_by,cmsncertsolutions_relations.dt_created,cmsncertsolutions_relations.modified_by,cmsncertsolutions_relations.dt_modified')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsncertsolutions_relations');
        $this->db->join('categories', 'cmsncertsolutions_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsncertsolutions_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsncertsolutions_relations.chapter_id=cmschapters.id', 'left');
        $this->db->where('cmsncertsolutions_relations.ncertsolutions_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getRelationsByDetails($exam_id, $subject_id, $chapter_id) {
        $this->db->select('id,ncertsolutions_id,exam_id,subject_id,chapter_id,created_by,dt_created,modified_by,dt_modified');
        $this->db->from('cmsncertsolutions_relations');
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('chapter_id', $chapter_id);

        $query = $this->db->get();
        return $query->result();
    }

    public function getQuestions($id) {
		if(isset($id)&&$id>0){
        $this->db->select('A.*,C.name as type');
        $this->db->from('cmsquestions A');
        $this->db->join('cmsncertsolutions_details B', 'B.question_id=A.id', 'left');
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.ncertsolutions_id', $id);
        $this->db->where('A.type !=', 12);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
		}else{
		return array();	
		}
    }
    public function getFiles($solution_id){
        $this->db->select('F.*');
        $this->db->from('cmsfiles F');
        $this->db->join('cmsncertsolutions_details S','S.file_id=F.id');
        $this->db->where('S.ncertsolutions_id',$solution_id);
        $this->db->where('S.file_id > ',0);
        $query=$this->db->get();
        //echo $this->db->last_query(); die;
        return $query->result();
    }    
  
    public function getExemplarQuestions($id) {
        $this->db->select('A.*,C.name as type');
        $this->db->from('cmsquestions A');
        $this->db->join('cmsncertsolutions_details B', 'B.question_id=A.id', 'left');
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.ncertsolutions_id', $id);
        $this->db->where('A.type', 12);
        $query = $this->db->get();
        return $query->result();
    }

    public function questionTypes($id) {
        $this->db->select('cmsquestions.type,cmsquestions.filter as typeid');
        $this->db->from('cmsquestions');
        $this->db->join('cmsncertsolutions_details', 'cmsncertsolutions_details.question_id=cmsquestions.id');
        //$this->db->join('cmsquestiontypes','cmsquestiontypes.id=cmsquestions.type');
        $this->db->group_by('cmsquestions.filter');
        $this->db->where('cmsncertsolutions_details.ncertsolutions_id', $id);
        $this->db->where('cmsquestions.type !=', 12);
        $this->db->order_by('ABS(cmsquestions.filter)');
        $query = $this->db->get();
        return $query->result();
    }

    public function getQuestionCount($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('cmsncertsolutions_details.question_id');
        $this->db->from('cmsncertsolutions');

        $this->db->join('cmsncertsolutions_details', 'cmsncertsolutions_details.ncertsolutions_id=cmsncertsolutions.id');
        $this->db->join('cmsncertsolutions_relations', 'cmsncertsolutions_relations.ncertsolutions_id=cmsncertsolutions.id');

        if ($exam_id > 0) {
            $this->db->where('cmsncertsolutions_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsncertsolutions_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsncertsolutions_relations.chapter_id', $chapter_id);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getCronQuestionCount($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('count(cmsncertsolutions_details.question_id) as q_count');
        $this->db->from('cmsncertsolutions');

        $this->db->join('cmsncertsolutions_details', 'cmsncertsolutions_details.ncertsolutions_id=cmsncertsolutions.id');
        $this->db->join('cmsncertsolutions_relations', 'cmsncertsolutions_relations.ncertsolutions_id=cmsncertsolutions.id');

        if ($exam_id > 0) {
            $this->db->where('cmsncertsolutions_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsncertsolutions_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsncertsolutions_relations.chapter_id', $chapter_id);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function checkQuestion($solid, $qid) {
        $this->db->select('id,ncertsolutions_id,question_id,created_by,dt_created,modified_by,dt_modified,file_id');
        $this->db->where('question_id', $qid);
        $this->db->where('ncertsolutions_id', $solid);
        $this->db->from('cmsncertsolutions_details');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkrelationbydata($exam_id, $subject_id, $chapter_id) {
        $this->db->select('id,ncertsolutions_id,exam_id,subject_id,chapter_id,created_by,dt_created,modified_by,dt_modified');
        $this->db->from('cmsncertsolutions_relations');

        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('chapter_id', $chapter_id);
        $query = $this->db->get();
        //echo $this->db->last_query(); die; 
        return $query->result();
    }

    public function search($search, $limit = 0, $start = 0) {
        $this->db->select('V.id,V.name,R.ncertsolutions_id,R.exam_id,R.subject_id,R.chapter_id,R.created_by')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsncertsolutions V');
        $this->db->join('cmsncertsolutions_details D', 'D.ncertsolutions_id=V.id');
        $this->db->join('cmsncertsolutions_relations R', 'R.ncertsolutions_id=D.ncertsolutions_id');
        $this->db->join('categories', 'categories.id=R.exam_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id', 'left');
        $this->db->join('cmschapters', 'cmschapters.id=R.chapter_id', 'left');
        $this->db->like('V.name', urldecode($search));
        if ($limit > 0) {
            $this->db->limit($limit, $start);
        }
        $this->db->group_by('V.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function search_count($search) {
        $this->db->select('V.id,V.name,R.id as rid,R.ncertsolutions_id,R.exam_id,R.subject_id,R.chapter_id,R.created_by,R.dt_created,R.modified_by,R.dt_modified')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsncertsolutions V');
        $this->db->join('cmsncertsolutions_details D', 'D.ncertsolutions_id=V.id');
        $this->db->join('cmsncertsolutions_relations R', 'R.ncertsolutions_id=D.ncertsolutions_id');
        $this->db->join('categories', 'categories.id=R.exam_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id', 'left');
        $this->db->join('cmschapters', 'cmschapters.id=R.chapter_id', 'left');
        $this->db->like('V.name', urldecode($search));
        $this->db->group_by('V.id');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function delete_module_ncert($id) {
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
        $this->db->where('ncertsolutions_id', $id);
        $this->db->delete('cmsncertsolutions_relations');

        //delete from cmsncertsolutions_details table
        $this->db->where('ncertsolutions_id', $id);
        $this->db->delete('cmsncertsolutions_details');

        //delete from cmsncertsolutions table
        $this->db->where('id', $id);
        $this->db->delete('cmsncertsolutions');
    }
	
 public function remove_examques($ol_test_id,$qus_id) {
        $this->db->where('questionbank_id', $ol_test_id);
        $this->db->where('question_id', $qus_id);
        $this->db->delete('cmsquestionbank_details');
    }


    public function getNcertSolution($exam_id = 0, $subject_id = 0) {
        $this->db->select('cmsncertsolutions_relations.id,cmsncertsolutions_relations.ncertsolutions_id,'
                . 'cmsncertsolutions_relations.exam_id,cmsncertsolutions_relations.subject_id,'
                . 'cmsncertsolutions_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmsncertsolutions_relations');
        if ($exam_id > 0) {
            $this->db->where('exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        $this->db->join('categories', 'categories.id=cmsncertsolutions_relations.exam_id');
        $this->db->join('cmssubjects', 'cmssubjects.id=cmsncertsolutions_relations.subject_id');
        //$this->db->where('chapter_id',0);
        $this->db->order_by('ABS(exam)', 'asc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function getClass_Ncertsolutions(){
        $this->db->select('cmsncertsolutions_relations.id ,cmsncertsolutions_relations.ncertsolutions_id,cmsncertsolutions_relations.exam_id,cmsncertsolutions_relations.subject_id,cmsncertsolutions_relations.chapter_id,cmsncertsolutions_relations.created_by,cmsncertsolutions_relations.dt_created,cmsncertsolutions_relations.modified_by,cmsncertsolutions_relations.dt_modified')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmsncertsolutions_relations');
        $this->db->join('categories', 'categories.id=cmsncertsolutions_relations.exam_id');
        $this->db->join('cmssubjects', 'cmssubjects.id=cmsncertsolutions_relations.subject_id');
        $this->db->order_by('ABS(exam)', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
    
    
    public function getChapter_Ncertsolutions() { 
        $this->db->select('cmsncertsolutions.name,cmsncertsolutions.id,cmsncertsolutions_relations.exam_id,cmsncertsolutions_relations.subject_id,cmsncertsolutions_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsncertsolutions_relations');
        $this->db->join('categories', 'cmsncertsolutions_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsncertsolutions_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsncertsolutions_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsncertsolutions', 'cmsncertsolutions.id=cmsncertsolutions_relations.ncertsolutions_id');
        $this->db->order_by('cmsncertsolutions.id','desc');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getQuestions_Ncertsolutions(){
        
        $this->db->select('A.ncertsolutions_id,B.id as question_id,B.question,C.name');
        $this->db->from('cmsncertsolutions_details A');
        $this->db->join('cmsquestions B','B.id=A.question_id','left');
        $this->db->join('cmsncertsolutions C','C.id=A.ncertsolutions_id','left');        
        $query = $this->db->get();
        //echo $this->db->last_query();         
        return $query->result();
    }
    
    public function getfiles_Ncertsolutions(){
        $this->db->select('cmsfiles.filename,cmsncertsolutions_details.file_id');
        $this->db->from('cmsncertsolutions_details');
        $this->db->join('cmsfiles','cmsfiles.id=cmsncertsolutions_details.file_id');
        $query = $this->db->get();
        return $query->result();
    }
     public function getFiles_merge($smid){
        $this->db->select('cmsfiles.filename as question,cmsncertsolutions_details.file_id,cmsfiles.displayname');
        $this->db->from('cmsncertsolutions_details');
        $this->db->join('cmsfiles','cmsfiles.id=cmsncertsolutions_details.file_id');
        $this->db->where('cmsncertsolutions_details.ncertsolutions_id', $smid);
        $query = $this->db->get();
        return $query->result();
    }
    
    function getAllVideoProducts($exam_id=0, $subject_id=0, $chapter_id=0, $type=2) {

        $this->db->select('cmschapters.id,cmschapters.exam_id,cmschapters.subject_id,cmschapters.chapter_id,cmschapters.item_id,cmschapters.type,cmschapters.price,cmschapters.discounted_price,cmschapters.product_expiry_date,cmschapters.description,cmschapters.offline_status,cmschapters.image,cmschapters.thumb_image,cmschapters.app_image,cmschapters.created_by,cmschapters.dt_created,cmschapters.modified_by,cmschapters.dt_modified,cmschapters.modules_item_id,cmschapters.modules_item_name,cmschapters.no_of_dvds,cmschapters.subscription_expiry,cmschapters.no_of_lectures,cmschapters.lecture_duration,cmschapters.no_of_subscribers,cmschapters.status,cmschapters.order_arrange')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmspricelist');
        $this->db->where('cmspricelist.type', $type);
        $this->db->where('cmspricelist.price > ',0);
        if ($exam_id > 0) {
            $this->db->where('exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('chapter_id', $chapter_id);
        }
        $this->db->join('categories', 'cmspricelist.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmspricelist.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmspricelist.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsfiles', 'cmsfiles.id=cmspricelist.item_id', 'left');
        $this->db->group_by('cmspricelist.id');
        $this->db->order_by('rand()');
        $this->db->limit('1,0');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        return $query->result();
    }
    public function getVideos(){
        
        $this->db->select('V.id,V.name,V.description,V.exam_id,V.subject_id,V.chapter_id,'
                . 'V.display_image,V.video_by')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsmergesection S');
        $this->db->join('cmsvideoslist V','V.id=S.related_module_id');
        $this->db->where('S.module_type',9);
        $this->db->where('S.related_module_type',2);
        $this->db->join('cmsvideolist_relations', 'cmsvideolist_relations.videolist_id=V.id');
        $this->db->join('categories', 'cmsvideolist_relations.exam_id=categories.id');
        $this->db->join('cmssubjects', 'cmsvideolist_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsvideolist_relations.chapter_id=cmschapters.id', 'left');
      
        $query=$this->db->get();
        return $query->result();
    }
    public function getStudyPackage(){
        $this->db->select('V.*');
        $this->db->from('cmsmergesection S');
        $this->db->join('cmsstudymaterial V','V.id=S.related_module_id');
        $this->db->where('S.module_type',9);
        $this->db->where('S.related_module_type',2);
        $query=$this->db->get();
        return $query->result();
    }
}
