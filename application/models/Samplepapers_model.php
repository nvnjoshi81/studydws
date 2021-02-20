<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Samplepapers_model extends CI_Model
{
    public function add($data){
        $this->db->insert('cmssamplepapers',$data);
        return $this->db->insert_id();
    }
    public function addDetails($data){
        $this->db->insert('cmssamplepapers_details',$data);
        return $this->db->insert_id();
    }
    public function detail($id){
        $this->db->where('id',$id);
        $query=  $this->db->get('cmssamplepapers');
        return $query->row();
    }

    public function checksp($legacy_id){
        //$this->db->where('exam_id',$exam_id);
        //$this->db->where('subject_id',$subject_id);
        $this->db->where('legacy_id',$legacy_id);
        $this->db->from('cmssamplepapers');
        $query=$this->db->get();
        return $query->row();
    }
    public function getSamplePapers($exam_id=null,$subject_id=null,$chapter_id=null) {
        $this->db->select('cmssamplepapers.name,cmssamplepapers.id,cmssamplepapers_relations.exam_id,cmssamplepapers_relations.subject_id,cmssamplepapers_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmssamplepapers_relations');
        
        if($exam_id > 0){
            $this->db->where('cmssamplepapers_relations.exam_id',$exam_id);
        }
        if($subject_id > 0){
            $this->db->where('cmssamplepapers_relations.subject_id',$subject_id);
        }
        if($chapter_id > 0){
            //$this->db->select('cmschapters.name as chapter');
            $this->db->where('cmssamplepapers_relations.chapter_id',$chapter_id);
            
        }
        $this->db->join('categories','cmssamplepapers_relations.exam_id=categories.id','left');
        $this->db->join('cmssubjects','cmssamplepapers_relations.subject_id=cmssubjects.id','left');
        $this->db->join('cmschapters','cmssamplepapers_relations.chapter_id=cmschapters.id','left');
        $this->db->join('cmssamplepapers','cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id');
        $this->db->order_by('cmssamplepapers.id','desc');
        $query=$this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    
    public function getSamplePaperData($id){
    
        $this->db->select('A.*,C.name as type,B.question_id');
        $this->db->from('cmsquestions A');
        $this->db->join('cmssamplepapers_details B','B.question_id=A.id','left');
        $this->db->join('cmsquestiontypes C','C.id=A.type','left');
        $this->db->where('B.samplepaper_id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    
    public function samplePaperDetails(){
        $this->db->select('id,samplepaper_id,question_id,created_by,dt_created,modified_by,dt_modified,file_id');
        $this->db->from('cmssamplepapers_details');
        $this->db->group_by('samplepaper_id');
        $query=$this->db->get();
        return $query->result();
    }
    public function getQuestionCount($exam_id=null,$subject_id=null,$chapter_id=null) {
        $this->db->select('cmssamplepapers_relations.id,cmssamplepapers_relations.samplepaper_id,'
                . 'cmssamplepapers_relations.exam_id,cmssamplepapers_relations.subject_id,'
                . 'cmssamplepapers_relations.chapter_id,cmssamplepapers_details.id,cmssamplepapers_details.samplepaper_id,'
                . 'cmssamplepapers_details.question_id');
         $this->db->from('cmssamplepapers_relations');
       
        $this->db->join('cmssamplepapers_details','cmssamplepapers_details.samplepaper_id=cmssamplepapers_relations.id');
        
        if($exam_id > 0){
            $this->db->where('cmssamplepapers_relations.exam_id',$exam_id);
        }
        if($subject_id > 0){
            $this->db->where('cmssamplepapers_relations.subject_id',$subject_id);
        }
        if($chapter_id > 0){
            $this->db->where('cmssamplepapers_relations.chapter_id',$chapter_id);
        }
        //$this->db->join('cmssamplepapers','cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id');
        $query=$this->db->get();
        return $query->result();
    }
    public function questionTypes($id){
        $this->db->select('cmsquestions.type as typeid,cmsquestiontypes.name as typename');
        $this->db->from('cmsquestions');
        $this->db->join('cmssamplepapers_details','cmssamplepapers_details.question_id=cmsquestions.id');
        $this->db->join('cmsquestiontypes','cmsquestiontypes.id=cmsquestions.type');
        $this->db->group_by('cmsquestions.type');
        $this->db->where('cmssamplepapers_details.samplepaper_id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    public function getDetails_bymoduleID_file($mid) {
         $this->db->select('*');         
         $this->db->from('cmssamplepapers_details');
         $this->db->join('cmsfiles','cmsfiles.id=cmssamplepapers_details.file_id');
         $this->db->where('cmssamplepapers_details.file_id>',0);
         $this->db->where('cmssamplepapers_details.samplepaper_id',$mid);
         $this->db->order_by("cmsfiles.id","desc");
         $query=  $this->db->get();
         return $query->result();
    }
   public function getQuestions($id){
        $this->db->select('A.*,C.name as type');
        $this->db->from('cmsquestions A');
        $this->db->join('cmssamplepapers_details B','B.question_id=A.id');
        $this->db->join('cmsquestiontypes C','C.id=A.type','left');
        $this->db->where('B.samplepaper_id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    
    public function checkQuestion($qbid,$qid){
        $this->db->select('id,samplepaper_id,question_id,created_by,dt_created,modified_by,dt_modified,file_id');
        $this->db->where('question_id',$qid);
        $this->db->where('samplepaper_id',$qbid);
        $this->db->from('cmssamplepapers_details');
        $query=$this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }    
    public function getRelations($id){
        $this->db->select('*')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmssamplepapers_relations');
        $this->db->join('categories','cmssamplepapers_relations.exam_id=categories.id','left');
        $this->db->join('cmssubjects','cmssamplepapers_relations.subject_id=cmssubjects.id','left');
        $this->db->join('cmschapters','cmssamplepapers_relations.chapter_id=cmschapters.id','left');
        $this->db->where('cmssamplepapers_relations.samplepaper_id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    
     public function getRelationDetail($relation_data_type){
        $this->db->select('id,samplepaper_id,exam_id,subject_id,chapter_id,created_by,dt_created,modified_by,dt_modified');
        $this->db->from('cmssamplepapers_relations');
        $this->db->where('samplepaper_id',$relation_data_type);
	    $query=$this->db->get();
           //echo $this->db->last_query(); die; 
             return $query->result();
    }
    public function search($search,$limit=0,$start=0){
        $this->db->select('V.id,V.name,R.samplepaper_id,R.exam_id,R.subject_id,R.chapter_id,R.created_by')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmssamplepapers V');
        $this->db->join('cmssamplepapers_details D','D.samplepaper_id=V.id');
        $this->db->join('cmssamplepapers_relations R','R.samplepaper_id=D.samplepaper_id');
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
        $this->db->from('cmssamplepapers V');
        $this->db->join('cmssamplepapers_details D','D.samplepaper_id=V.id');
        $this->db->join('cmssamplepapers_relations R','R.samplepaper_id=D.samplepaper_id');
        $this->db->join('categories', 'categories.id=R.exam_id','left');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id','left');
        $this->db->join('cmschapters', 'cmschapters.id=R.chapter_id','left');
        $this->db->like('V.name',urldecode($search));
        $this->db->group_by('V.id');
        $query=$this->db->get();
        return $query->num_rows();
    }
    public function delete_module_samplepaper($id){
      
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
                 $this->db->where('samplepaper_id', $id);       
                 $this->db->delete('cmssamplepapers_relations'); 
              
                //delete from cmsncertsolutions_details table
                 $this->db->where('samplepaper_id', $id);       
                 $this->db->delete('cmssamplepapers_details'); 
                 
                //delete from cmsncertsolutions table
                 $this->db->where('id', $id);       
                 $this->db->delete('cmssamplepapers'); 
   
    }
    public function getSamplepapersList($exam_id = 0, $subject_id = 0) {
        $this->db->select('R.samplepaper_id,R.id,R.exam_id,R.subject_id,R.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmssamplepapers_relations R');
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
       // echo $this->db->last_query();
        return $query->result();
    }
    
        public function getSectionsForQuestions($id, $section = null,$chapter_id=null) {
        $this->db->select('A.section,A.section_name,A.id');
        $this->db->from('cmsquestions A');
        $this->db->join('cmssamplepapers_details B', 'B.question_id=A.id');
        if ($section) {
            $this->db->where('A.section', $section);
        }
        if ($chapter_id) {
            $this->db->where('A.chapter_id', $chapter_id);
        }
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.samplepaper_id', $id);
        $this->db->group_by('A.section');
        $query = $this->db->get();
        //echo $this->db->last_query(); 
        return $query->result();
    }
    public function getClass_samplepapers(){
        $this->db->select('*')->select('categories.name as exam')->select('cmssubjects.name as subject');
        $this->db->from('cmssamplepapers_relations');
        $this->db->join('categories', 'categories.id=cmssamplepapers_relations.exam_id');
        $this->db->join('cmssubjects', 'cmssubjects.id=cmssamplepapers_relations.subject_id');
        $this->db->order_by('ABS(exam)', 'asc');
        $query = $this->db->get();
        return $query->result();
        
    }
    
    
    public function getChapter_Samplepapers() { 
        $this->db->select('cmssamplepapers.name,cmssamplepapers.id,cmssamplepapers_relations.exam_id,cmssamplepapers_relations.subject_id,cmssamplepapers_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmssamplepapers_relations');
        $this->db->join('categories', 'cmssamplepapers_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmssamplepapers_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmssamplepapers_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmssamplepapers', 'cmssamplepapers.id=cmssamplepapers_relations.samplepaper_id');
        $this->db->order_by('cmssamplepapers.id','desc');
        $query = $this->db->get();
        return $query->result();
    }
    
      public function getQuestions_Samplepapers(){
        $this->db->select('A.samplepaper_id,B.id as question_id,B.question,C.name');
        $this->db->from('cmssamplepapers_details A');
        $this->db->join('cmsquestions B','B.id=A.question_id','left');
        $this->db->join('cmssamplepapers C','C.id=A.samplepaper_id','left');        
        $query = $this->db->get();
        //echo $this->db->last_query();         
        return $query->result();
    }
    public function getfiles_Samplepapers(){
        
          $this->db->select('cmsfiles.filename,cmssamplepapers_details.file_id');
        $this->db->from('cmssamplepapers_details');
        $this->db->join('cmsfiles','cmsfiles.id=cmssamplepapers_details.file_id');
        $query = $this->db->get();
        return $query->result();
    }
    
public function getFiles_merge($smid){
        $this->db->select('cmsfiles.filename,cmssamplepapers_details.file_id,cmsfiles.displayname');
        $this->db->from('cmssamplepapers_details');
        $this->db->join('cmsfiles','cmsfiles.id=cmssamplepapers_details.file_id');
        $this->db->where('cmssamplepapers_details.samplepaper_id', $smid);
        $query = $this->db->get();
        return $query->result();
    }  
     public function getContents_name($id) {
        $this->db->select('A.name');
        $this->db->from('cmssamplepapers A');
        $this->db->where('A.id', $id);
        $query = $this->db->get();
        return $query->result();
    }
      public function edit_contentsname($id,$data){
 
               $this->db->update('cmssamplepapers',$data,array('id'=>$id));
    }
         public function remove_examques($ol_test_id,$qus_id) {
        $this->db->where('samplepaper_id', $ol_test_id);
        $this->db->where('question_id', $qus_id);
        $this->db->delete('cmssamplepapers_details');
    }

    
}
