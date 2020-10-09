<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Studymaterial_model extends CI_Model {
    public function getStudyMaterial($exam_id = null, $subject_id = null, $chapter_id = null) {
            $this->db->select('F.displayname,F.filename,F.filepath,F.filename_one,F.filepath_one,F.type,F.filetype,F.pagecount,F.is_deleted,F.id,D.file_id,F.filename as question,A.name as modules_item_name,P.discounted_price,P.price,P.modules_item_id,P.item_id,P.id as productlist_id,A.name,cmsstudymaterial_relations.exam_id,cmsstudymaterial_relations.subject_id,cmsstudymaterial_relations.chapter_id,cmsstudymaterial_relations.studymaterial_id as miid')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsfiles F');
        if ($exam_id > 0) {
            $this->db->where('cmsstudymaterial_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsstudymaterial_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsstudymaterial_relations.chapter_id', $chapter_id);
        }
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');        
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmsstudymaterial_relations ', 'A.id=cmsstudymaterial_relations.studymaterial_id');
        $this->db->join('categories', 'cmsstudymaterial_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsstudymaterial_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsstudymaterial_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        //$this->db->where('P.type',1);
        //if($limit > 0){
        //$this->db->limit($limit);
        //}        
        $this->db->order_by('F.id','desc');
        $this->db->group_by('F.id');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result(); 
    }
    public function getCronSM($exam_id = null, $subject_id = null, $chapter_id = null) {
            $this->db->select('count(A.id) as package_count');
            $this->db->from('cmsfiles F');
        if ($exam_id > 0) {
            $this->db->where('cmsstudymaterial_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsstudymaterial_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsstudymaterial_relations.chapter_id', $chapter_id);
        }
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');        
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmsstudymaterial_relations ', 'A.id=cmsstudymaterial_relations.studymaterial_id');
        $this->db->join('categories', 'cmsstudymaterial_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsstudymaterial_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsstudymaterial_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        //$this->db->where('P.type',1);
        //if($limit > 0){
            //$this->db->limit($limit);
      //}        
        $this->db->order_by('F.id','desc');
        //$this->db->group_by('F.id');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();   
     $showCode='no';
        if($showCode=='yes'){   
        $querydb->result();
     }
        
    }
    
      public function getStudyMaterial_list($exam_id = null, $subject_id = null, $chapter_id = null,$type_id=0) {
            $this->db->select('F.displayname,F.filename,F.filepath,F.filename_one,F.filepath_one,F.type,F.filetype,F.pagecount,F.is_deleted,F.id,D.file_id,F.filename as question,A.name as modules_item_name,P.discounted_price,P.price,P.modules_item_id,P.item_id,P.id as productlist_id,A.name,cmsstudymaterial_relations.exam_id,cmsstudymaterial_relations.subject_id,cmsstudymaterial_relations.chapter_id,cmsstudymaterial_relations.studymaterial_id as miid')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsfiles F');
        if ($exam_id > 0) {
            $this->db->where('cmsstudymaterial_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsstudymaterial_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsstudymaterial_relations.chapter_id', $chapter_id);
        }
        
        if($type_id>0){
            $this->db->where('P.type', $type_id);
            
        }
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');        
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmsstudymaterial_relations ', 'A.id=cmsstudymaterial_relations.studymaterial_id');
         $this->db->join('categories', 'cmsstudymaterial_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsstudymaterial_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsstudymaterial_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        //$this->db->where('P.type',1);
        //if($limit > 0){
            //$this->db->limit($limit);
      //}        
        $this->db->order_by('F.id','desc');
        $this->db->group_by('F.id');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();   
        
    }
  
  
    public function getStudyMaterial_old($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('cmsstudymaterial.name,cmsstudymaterial.id,cmsstudymaterial_relations.exam_id,cmsstudymaterial_relations.subject_id,cmsstudymaterial_relations.chapter_id,cmspricelist.discounted_price,cmspricelist.price,cmspricelist.item_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsstudymaterial_relations');

        if ($exam_id > 0) {
            $this->db->where('cmsstudymaterial_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsstudymaterial_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsstudymaterial_relations.chapter_id', $chapter_id);
        }

        $this->db->join('categories', 'cmsstudymaterial_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsstudymaterial_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsstudymaterial_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsstudymaterial', 'cmsstudymaterial.id=cmsstudymaterial_relations.studymaterial_id','left');
        $this->db->join('cmspricelist', 'cmspricelist.modules_item_id=cmsstudymaterial_relations.studymaterial_id');        
        $this->db->order_by('cmsstudymaterial.id','desc');
        $this->db->group_by('cmsstudymaterial.id');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
   /* 
    public function details($id) {
        $this->db->select('id,name,exam_id,subject_id,chapter_id');
        $this->db->from('cmsstudymaterial');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function detail($id) {
        $this->db->select('id,name,exam_id,subject_id,chapter_id');
        $this->db->from('cmsstudymaterial');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }*/
    
     public function details($id) {
        $this->db->select('A.id,A.name,B.exam_id,B.subject_id,B.chapter_id,A.language');
        $this->db->from('cmsstudymaterial A');
        $this->db->join('cmsstudymaterial_relations B','A.id=B.studymaterial_id','left');
        $this->db->where('A.id', $id); 
        $query = $this->db->get(); 
        return $query->row();
    }
    public function getSM_byName($name) {
        $this->db->select('A.id,A.name,B.exam_id,B.subject_id,B.chapter_id');
        $this->db->from('cmsstudymaterial A');
        $this->db->join('cmsstudymaterial_relations B','A.id=B.studymaterial_id','left');
        $this->db->where('A.name', $name); 
        $query = $this->db->result(); 
        return $query->row();
    }
    
    public function detail($id) {
        $this->db->select('A.id,A.name,A.language,B.exam_id,B.subject_id,B.chapter_id');
        $this->db->select('A.id,A.name,B.exam_id,B.subject_id,B.chapter_id,A.language');
        $this->db->from('cmsstudymaterial A');
        $this->db->join('cmsstudymaterial_relations B','A.id=B.studymaterial_id','left');
        $this->db->where('A.id', $id);
        $query = $this->db->get();
        return $query->row();
    }


    public function add($data) {
        $this->db->insert('cmsstudymaterial', $data);
        return $this->db->insert_id();
    }

    public function getStudyMaterialDetails($id) {
        $this->db->select('A.*,C.name as type,B.question_id');
        $this->db->from('cmsquestions A');
        $this->db->join('cmsstudymaterial_details B', 'B.question_id=A.id', 'left');
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.studymaterial_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function check($exam_id, $subject_id, $chapter_id) {
        $this->db->select('id,name,exam_id,subject_id,chapter_id');
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('chapter_id', $chapter_id);
        $query = $this->db->get('cmsstudymaterial');
        return $query->row();
    }
	
    public function getStudyMaterialCount($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('cmsstudymaterial.id');
        $this->db->from('cmsstudymaterial');
        $this->db->join('cmsstudymaterial_relations', 'cmsstudymaterial_relations.studymaterial_id=cmsstudymaterial.id');
        $this->db->join('cmsstudymaterial_details', 'cmsstudymaterial_details.studymaterial_id=cmsstudymaterial.id');

        if ($exam_id > 0) {
            $this->db->where('cmsstudymaterial_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsstudymaterial_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsstudymaterial_relations.chapter_id', $chapter_id);
        }
        $query = $this->db->get();
		//echo $this->db->last-query();
        return $query->result();
    }
 public function getCronSmCount($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('count(cmsstudymaterial.id) as qcount');
        $this->db->from('cmsstudymaterial');
        $this->db->join('cmsstudymaterial_relations', 'cmsstudymaterial_relations.studymaterial_id=cmsstudymaterial.id');
        $this->db->join('cmsstudymaterial_details', 'cmsstudymaterial_details.studymaterial_id=cmsstudymaterial.id');

        if ($exam_id > 0) {
            $this->db->where('cmsstudymaterial_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsstudymaterial_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsstudymaterial_relations.chapter_id', $chapter_id);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getFiles($smid) {
        $this->db->select('F.id,F.displayname,F.filename,F.filepath,'
                . 'F.filename_one,F.filepath_one,F.type,F.filetype,F.pagecount,F.is_deleted,P.price,P.discounted_price,D.file_id,F.filename as question,A.name,P.id as pricelist_id ');
        $this->db->from('cmsfiles F');
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        //$this->db->where('P.type',1);
        $this->db->where('D.studymaterial_id', $smid);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    public function getFilesProducts($exam_id = null, $subject_id = null, $chapter_id = null,$limit=null) {
        $this->db->select('F.displayname,F.filename,F.filepath,'
                . 'F.filename_one,F.filepath_one,F.type,F.filetype,F.pagecount,F.is_deleted,F.id as item_id,P.price,P.discounted_price,D.file_id,F.filename as question,A.name as modules_item_name,P.id as productlist_id');
        $this->db->from('cmsfiles F');
        if ($exam_id > 0) {
            $this->db->where('cmsstudymaterial_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsstudymaterial_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsstudymaterial_relations.chapter_id', $chapter_id);
        }
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');        
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmsstudymaterial_relations', 'A.id=cmsstudymaterial_relations.studymaterial_id');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        $this->db->where('P.type',1);
        if($limit > 0){
        $this->db->limit($limit);
        }        
        $this->db->order_by('F.id','desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }  
    public function getFilesbylevel($exam_id = null, $subject_id = null, $chapter_id = null,$limit=null) {
        $this->db->select('F.displayname,F.filename,F.filepath,'
                . 'F.filename_one,F.filepath_one,F.type,F.filetype,F.pagecount,F.is_deleted,F.id as item_id,P.price,P.discounted_price,D.file_id,F.filename as question,A.name as modules_item_name,P.id as productlist_id');
        $this->db->from('cmsfiles F');
        if ($exam_id > 0) {
            $this->db->where('cmsstudymaterial_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsstudymaterial_relations.subject_id', $subject_id);
        }else{
            $this->db->where('cmsstudymaterial_relations.subject_id<', 1);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsstudymaterial_relations.chapter_id', $chapter_id);
        }else{
            $this->db->where('cmsstudymaterial_relations.chapter_id<', 1);
        }
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');        
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmsstudymaterial_relations', 'A.id=cmsstudymaterial_relations.studymaterial_id');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        $this->db->where('P.type',1);
        if($limit > 0){
            $this->db->limit($limit);
        }        
        $this->db->order_by('F.id','desc');
        $query = $this->db->get();      //echo $this->db->last_query();
        return $query->result();
    }
       
    public function getStudydetailsFiles($fid) {
        $this->db->select('F.id,F.displayname,F.filename,F.filepath,'
                . 'F.filename_one,F.filepath_one,F.type,F.filetype,F.pagecount,F.is_deleted,P.price,P.discounted_price,D.file_id,D.studymaterial_id');
        $this->db->from('cmsfiles F');
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        $this->db->where('F.id', $fid);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDetails_bymoduleID_file($mid) {
        $this->db->select('*');
        $this->db->from('cmsstudymaterial_details');
        $this->db->join('cmsfiles', 'cmsfiles.id=cmsstudymaterial_details.file_id');
        $this->db->where('cmsstudymaterial_details.file_id>', 0);
        $this->db->where('cmsstudymaterial_details.studymaterial_id', $mid);
        $this->db->order_by("cmsfiles.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    public function getRelationDetail($relation_data_type) {
        $this->db->select('id,studymaterial_id,exam_id,subject_id,chapter_id,created_by,dt_created,modified_by,dt_modified');
        $this->db->from('cmsstudymaterial_relations');
        $this->db->where('studymaterial_id', $relation_data_type);
        $query = $this->db->get();
        //echo $this->db->last_query(); die; 
        return $query->result();
    }

    public function getRelations($id,$examid=0) {
        $this->db->select('*')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsstudymaterial_relations');
        $this->db->join('categories', 'cmsstudymaterial_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsstudymaterial_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsstudymaterial_relations.chapter_id=cmschapters.id', 'left');
		if($examid>0){
        $this->db->where('categories.id', $examid);
		}
        $this->db->where('cmsstudymaterial_relations.studymaterial_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function questionTypes($id) {
        $this->db->select('cmsquestions.type as typeid,cmsquestiontypes.name as typename');
        $this->db->from('cmsquestions');
        $this->db->join('cmsstudymaterial_details', 'cmsstudymaterial_details.question_id=cmsquestions.id');
        $this->db->join('cmsquestiontypes', 'cmsquestiontypes.id=cmsquestions.type');
        $this->db->group_by('cmsquestions.type');
        $this->db->where('cmsstudymaterial_details.studymaterial_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getQuestions($id) {
        $this->db->select('A.*,C.name as type');
        $this->db->from('cmsquestions A');
        $this->db->join('cmsstudymaterial_details B', 'B.question_id=A.id', 'left');
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.studymaterial_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function search($search, $limit = 0, $start = 0) {
        $this->db->select('V.id,V.name,R.studymaterial_id,R.exam_id,R.subject_id,R.chapter_id,R.created_by')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsstudymaterial V');
        $this->db->join('cmsstudymaterial_details D', 'D.studymaterial_id=V.id');
        $this->db->join('cmsstudymaterial_relations R', 'R.studymaterial_id=D.studymaterial_id');
        $this->db->join('categories', 'categories.id=R.exam_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id', 'left');
        $this->db->join('cmschapters', 'cmschapters.id=R.chapter_id', 'left');
        $this->db->group_by('V.id');
        if ($limit > 0) {
            $this->db->limit($limit, $start);
        }
        $this->db->like('V.name', urldecode($search));
        $query = $this->db->get();
        return $query->result();
    }

    public function search_count($search) {
        $this->db->select('V.id,V.name,R.*')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsstudymaterial V');
        $this->db->join('cmsstudymaterial_details D', 'D.studymaterial_id=V.id');
        $this->db->join('cmsstudymaterial_relations R', 'R.studymaterial_id=D.studymaterial_id');
        $this->db->join('categories', 'categories.id=R.exam_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id', 'left');
        $this->db->join('cmschapters', 'cmschapters.id=R.chapter_id', 'left');
        $this->db->group_by('V.id');
        $this->db->like('V.name', urldecode($search));
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function delete_module_studymaterial($id) {
        $file_check_array = $this->getDetails_bymoduleID_file($id);

        //delete file if exist
        if (count($file_check_array) > 0) {
            $file_id = $file_check_array[0]->file_id;
            $filename = $file_check_array[0]->filename;
            $filepath = $file_check_array[0]->filepath;
            $filename_one = $file_check_array[0]->filename_one;
            $filepath_one = $file_check_array[0]->filepath_one;
            //unlink($_SERVER['DOCUMENT_ROOT'] . $filepath . $filename);
            //unlink($_SERVER['DOCUMENT_ROOT'] . $filepath_one . $filename_one);
            $this->db->where('id', $file_id);
            $this->db->delete('cmsfiles');
        }

        //delete from cmspricelist table
        $this->db->where('modules_item_id', $id);
        $this->db->delete('cmspricelist');

        //delete from cmsncertsolutions_relations table
        $this->db->where('studymaterial_id', $id);
        $this->db->delete('cmsstudymaterial_relations');

        //delete from cmsncertsolutions_details table
        $this->db->where('studymaterial_id', $id);
        $this->db->delete('cmsstudymaterial_details');

        //delete from cmsncertsolutions table
        $this->db->where('id', $id);
        $this->db->delete('cmsstudymaterial');
    }

    public function getStudyMaterialList($exam_id = 0, $subject_id = 0) {
        $this->db->select('*')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmsstudymaterial_relations');

        if ($exam_id > 0) {
            $this->db->where('exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        $this->db->join('categories', 'categories.id=cmsstudymaterial_relations.exam_id');
        $this->db->join('cmssubjects', 'cmssubjects.id=cmsstudymaterial_relations.subject_id');
        //$this->db->where('chapter_id',0);
        $this->db->order_by('ABS(exam)', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getChapterNameForStudyMaterial() {
        $this->db->select('S.id,S.name')->select('SU.name as subject')->select('C.name as chapter');
        $this->db->from('cmsstudymaterial S');
        $this->db->join('cmsstudymaterial_relations R', 'R.studymaterial_id=S.id');
        $this->db->join('cmschapters C', 'R.chapter_id=C.id', 'left');
        $this->db->join('cmssubjects SU', 'R.subject_id=SU.id', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    public function getClass_Studymaterial(){
        $this->db->select('*')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmsstudymaterial_relations');
        $this->db->join('categories', 'categories.id=cmsstudymaterial_relations.exam_id');
        $this->db->join('cmssubjects', 'cmssubjects.id=cmsstudymaterial_relations.subject_id');
        $this->db->order_by('ABS(exam)', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
     public function getChapter_Studymaterial() { 
        $this->db->select('cmsstudymaterial.name,cmsstudymaterial.id,cmsstudymaterial_relations.exam_id,cmsstudymaterial_relations.subject_id,cmsstudymaterial_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsstudymaterial_relations');
        $this->db->join('categories', 'cmsstudymaterial_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsstudymaterial_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsstudymaterial_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsstudymaterial', 'cmsstudymaterial.id=cmsstudymaterial_relations.studymaterial_id');
        $this->db->order_by('cmsstudymaterial.id','desc');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getQuestions_Studymaterial(){
        $this->db->select('A.studymaterial_id,B.id as question_id,B.question,C.name');
        $this->db->from('cmsstudymaterial_details A');
        $this->db->join('cmsquestions B','B.id=A.question_id','left');
        $this->db->join('cmsstudymaterial C','C.id=A.studymaterial_id','left');        
        $query = $this->db->get();
        //echo $this->db->last_query();         
        return $query->result();
    }
    
    public function getfiles_Studyamaterials() {
        $this->db->select('cmsfiles.filename,cmsstudymaterial_details.file_id');
        $this->db->from('cmsstudymaterial_details');
        $this->db->join('cmsfiles','cmsfiles.id=cmsstudymaterial_details.file_id');
        $query = $this->db->get();
        return $query->result();
    }
public function getFiles_merge($smid) {
        $this->db->select('D.file_id,F.id,F.filename as question,F.displayname');
        $this->db->from('cmsfiles F');
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');
        $this->db->where('D.studymaterial_id', $smid);
        $query = $this->db->get();
        return $query->result();
    }
    public function getinfo_forncert($smid) {
        
        $this->db->select('F.id,F.displayname,F.filename,F.filepath,'
                . 'F.filename_one,F.filepath_one,F.type,F.filetype,F.pagecount,F.is_deleted,P.price,P.discounted_price,D.file_id,F.filename as question,A.name');
        $this->db->from('cmsfiles F');
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        //$this->db->where('P.type',1);
        $this->db->where('D.studymaterial_id', $smid);
        $query = $this->db->get();
        return $query->result();
    }
    public function getinfo_formerge($smid) {
        $this->db->select('F.id,F.displayname,F.filename,F.filepath,'
                . 'F.filename_one,F.filepath_one,F.type,F.filetype,F.pagecount,F.is_deleted,P.price,P.discounted_price,D.file_id,F.filename as question,A.name');
        $this->db->from('cmsfiles F');
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        //$this->db->where('P.type',1);
        $this->db->where('D.studymaterial_id', $smid);
        $query = $this->db->get();
        return $query->result();
    }
	   public function getinfo_file($smid) {
        $this->db->select('F.id,F.displayname,F.filename,F.filepath,F.filename_one,F.filepath_one,F.type,F.filetype,F.pagecount,F.is_deleted,P.price,P.discounted_price,P.id as product_id,P.offline_status,D.file_id,F.filename as question,A.name');
        $this->db->from('cmsfiles F');
        $this->db->join('cmsstudymaterial_details D', 'D.file_id=F.id');
        $this->db->join('cmsstudymaterial A','A.id=D.studymaterial_id');
        $this->db->join('cmspricelist P', 'P.item_id=F.id', 'left');
        //$this->db->where('P.type',1);
        $this->db->where('F.id', $smid);
        $query = $this->db->get();
        return $query->result();
    }
       public function getContents_name($id) {
        $this->db->select('A.name');
        $this->db->from('cmsstudymaterial A');
        $this->db->where('A.id', $id);
        $query = $this->db->get();
        return $query->result();
    }
     public function edit_contentsname($id,$data){
 
               $this->db->update('cmsstudymaterial',$data,array('id'=>$id));
    }
        public function remove_examques($ol_test_id,$qus_id) {
        $this->db->where('studymaterial_id', $ol_test_id);
        $this->db->where('question_id', $qus_id);
        $this->db->delete('cmsstudymaterial_details');
    }
    
    public function checkQuestion($qbid,$qid){
        $this->db->select('id,studymaterial_id,question_id,created_by,dt_created,modified_by,dt_modified,file_id');
        $this->db->where('question_id',$qid);
        $this->db->where('studymaterial_id',$qbid);
        $this->db->from('cmsstudymaterial_details');
        $query=$this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    
}
