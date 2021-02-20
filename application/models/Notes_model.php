<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class   Notes_model extends CI_Model
{
        public function getNotes($exam_id=null,$subject_id=null,$chapter_id=null) {
            /*
        $this->db->select('cmsnotes.name,cmsnotes.id,cmsnotes_relations.exam_id,cmsnotes_relations.subject_id,cmsnotes_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsnotes_relations');
        
        if($exam_id > 0){
            $this->db->where('cmsnotes_relations.exam_id',$exam_id);
        }
        if($subject_id > 0){
            $this->db->where('cmsnotes_relations.subject_id',$subject_id);
        }
        if($chapter_id > 0){
            $this->db->where('cmsnotes_relations.chapter_id',$chapter_id);
        }
        
        $this->db->join('categories','cmsnotes_relations.exam_id=categories.id','left');
        $this->db->join('cmssubjects','cmsnotes_relations.subject_id=cmssubjects.id','left');
        $this->db->join('cmschapters','cmsnotes_relations.chapter_id=cmschapters.id','left');
        $this->db->join('cmsnotes','cmsnotes.id=cmsnotes_relations.notes_id');
        $this->db->order_by('cmsnotes.id','desc');
        $query=$this->db->get();
        return $query->result();*/
              $this->db->select('postings.id as id,postings.title as name,postings.category_id,postings.subject_id,postings.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('postings');
        if ($exam_id > 0) {
        $this->db->where('category_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('chapter_id', $chapter_id);
        }
        $this->db->join('categories', 'categories.id=postings.category_id', 'left');
        $this->db->join('cmssubjects', 'cmssubjects.id=postings.subject_id', 'left');
        $this->db->join('cmschapters', 'cmschapters.id=postings.chapter_id', 'left');
        //$this->db->where('chapter_id',0);
        $this->db->where('top_category_id', '21');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        return $query->result();
    }

    
    public function detail($id){
        $this->db->select('id,name,exam_id,subject_id,chapter_id,language,created_by,dt_created,modified_by,dt_modified,is_deleted,view_count');
        $this->db->from('cmsnotes');
        $this->db->where('id',$id);
        $query=$this->db->get();
        return $query->row();
    }
    
    public function getNotesDetails($id){
        $this->db->select('A.*,C.name as type,B.question_id');
        $this->db->from('cmsquestions A');
        $this->db->join('cmsnotes_details B','B.question_id=A.id','left');
        $this->db->join('cmsquestiontypes C','C.id=A.type','left');
        $this->db->where('B.notes_id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    
            public function getDetails_bymoduleID_file($mid){
         $this->db->select('*');         
         $this->db->from('cmsnotes_details');
         $this->db->join('cmsfiles','cmsfiles.id=cmsnotes_details.file_id');
         $this->db->where('cmsnotes_details.file_id>',0);
         $this->db->where('cmsnotes_details.notes_id',$mid);
         $this->db->order_by("cmsfiles.id","desc");
         $query=  $this->db->get();
         return $query->result();
    }
    
        public function getRelationDetail($relation_data_type){
        $this->db->select('id,notes_id,exam_id,subject_id,chapter_id,created_by,dt_created,modified_by,dt_modified');
        $this->db->from('cmsnotes_relations');
        $this->db->where('notes_id',$relation_data_type);
	    $query=$this->db->get();
           //echo $this->db->last_query(); die; 
             return $query->result();
    }
    
    
  public function delete_module_notes($id){
      
      $file_check_array=$this->getDetails_bymoduleID_file($id);              
                //delete file if exist
              if(count($file_check_array)>0){
                 $file_id = $file_check_array[0]->file_id; 
                 $filename = $file_check_array[0]->filename;
                 $filepath = $file_check_array[0]->filepath;
                 $filename_one = $file_check_array[0]->filename_one;
                 $filepath_one = $file_check_array[0]->filepath_one;
                 unlink($_SERVER['DOCUMENT_ROOT'].$filepath.$filename);
                 unlink($_SERVER['DOCUMENT_ROOT'].$filepath_one.$filename_one);
                 $this->db->where('id', $file_id);       
                 $this->db->delete('cmsfiles');                 
              }
              
                //delete from cmspricelist table
                $this->db->where('modules_item_id', $id);       
                $this->db->delete('cmspricelist'); 
                 
                //delete from cmsncertsolutions_relations table
                 $this->db->where('notes_id', $id);       
                 $this->db->delete('cmsnotes_relations'); 
              
                //delete from cmsncertsolutions_details table
                 $this->db->where('notes_id', $id);       
                 $this->db->delete('cmsnotes_details'); 
                 
                //delete from cmsncertsolutions table
                 $this->db->where('id', $id);       
                 $this->db->delete('cmsnotes'); 
       
   }
   
   public function getClass_Notes(){
       
        $this->db->select('*')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmsnotes_relations');
        $this->db->join('categories', 'categories.id=cmsnotes_relations.exam_id');
        $this->db->join('cmssubjects', 'cmssubjects.id=cmsnotes_relations.subject_id');
        $this->db->order_by('ABS(exam)', 'asc');
        $query = $this->db->get();
        return $query->result();
       
   }
   
   public function getChapter_Notes(){
       
       $this->db->select('cmsnotes.name,cmsnotes.id,cmsnotes_relations.exam_id,cmsnotes_relations.subject_id,cmsnotes_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsnotes_relations');
        $this->db->join('categories', 'cmsnotes_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsnotes_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsnotes_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsnotes', 'cmsnotes.id=cmsnotes_relations.notes_id');
        $this->db->order_by('cmsnotes.id','desc');
        $query = $this->db->get();
        return $query->result();
   }
   
     public function getQuestions_Notes(){
        
        $this->db->select('A.notes_id,B.id as question_id,B.question,C.name');
        $this->db->from('cmsnotes_details A');
        $this->db->join('cmsquestions B','B.id=A.question_id','left');
        $this->db->join('cmsnotes C','C.id=A.notes_id','left');        
        $query = $this->db->get();
        //echo $this->db->last_query();         
        return $query->result();
    }
    
    public function getfiles_Notes(){
        $this->db->select('cmsfiles.filename,cmsnotes_details.file_id');
        $this->db->from('cmsnotes_details');
        $this->db->join('cmsfiles','cmsfiles.id=cmsnotes_details.file_id');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getfiles_merge($smid){
        $this->db->select('cmsfiles.id,cmsfiles.filename as question,cmsnotes_details.file_id');
        $this->db->from('cmsnotes_details');
        $this->db->join('cmsfiles','cmsfiles.id=cmsnotes_details.file_id');
        $this->db->where('cmsnotes_details.notes_id', $smid);
        $query = $this->db->get();
        return $query->result();
    }
    
   
       
}
