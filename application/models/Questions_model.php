<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Questions_model extends CI_Model
{
    public function add($data){
        $this->db->insert('cmsquestions',$data);
        return $this->db->insert_id();
    }
    public function detail($id){
        $this->db->where('id',$id);
        $query=$this->db->get('cmsquestions');
        return $query->row();
    }
    public function answers($question_id) {
        $this->db->where('question_id',$question_id);
        $query=$this->db->get('cmsanswers');
        //echo $this->db->last_query();
        return $query->result();
    }
    public function answers_byid($id) {
        $this->db->where('id',$id);
        $query=$this->db->get('cmsanswers');
        return $query->result();
    }
    public function update_question($id,$q_data){
     $this->db->update('cmsquestions',$q_data,array('id'=>$id));
    }
    public function update_answer($id,$a_data){
    $this->db->update('cmsanswers',$a_data,array('question_id'=>$id));
    }
	
    public function update_answer_by_answerid($id,$a_data){
        $this->db->update('cmsanswers',$a_data,array('id'=>$id));
      
    }   
    
    public function delete_qus_ans_byid($id){
     //Delete from question and ans table
     $this->db->where('id', $id);
     $this->db->delete('cmsquestions');
     
     $this->db->where('question_id', $id);
    //echo $this->db->last_query(); 
     $this->db->delete('cmsanswers');
     
     
     }
     public function getNext($tablename,$fieldname,$content_id,$question_id){
         $this->db->select('*');
         $this->db->from($tablename);
         $this->db->where($fieldname,$content_id);
         $this->db->where('question_id > ',$question_id);
         $this->db->where('file_id < 1');
		 $this->db->order_by('question_id', 'asc');
         $this->db->limit(1);
         $query=$this->db->get();
         if($query->num_rows() > 0){
             return $query->row();
         }else{
             return false;
         }
     }
     public function getPrevious($tablename,$fieldname,$content_id,$question_id){
         $this->db->select('*');
         $this->db->from($tablename);
         $this->db->where($fieldname,$content_id);
         $this->db->where('question_id < ',$question_id);
         $this->db->where('file_id < 1');
		 $this->db->order_by('question_id', 'desc');
         $this->db->limit(1);
         $query=$this->db->get();
		 //echo $this->db->last_query(); 
         if($query->num_rows() > 0){
             return $query->row();
         }else{
             return false;
         }
     }
     public function search($search){
        $this->db->select('V.id,V.question,R.*')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsquestions V');
        $this->db->join('cmsquestionbank_details D','D.question_id=V.id');
        $this->db->join('cmsquestionbank_relations R','R.questionbank_id=D.questionbank_id');
        $this->db->join('categories', 'categories.id=R.exam_id','left');
        $this->db->join('cmssubjects', 'cmssubjects.id=R.subject_id','left');
        $this->db->join('cmschapters', 'cmschapters.id=R.chapter_id','left');
        //$this->db->join('cmsanswers A','A.question_id=V.id');
        $this->db->like('V.question', $search);
        $query = $this->db->get();
        return $query->result();
    }
    public function relate($question_id,$chapter_id){
        $this->db->where('id',$question_id);
        $this->db->update('cmsquestions',array('chapter_id'=>$chapter_id));
    }
    
    
    public function createQBlank($qdata,$type){
        $this->db->insert('cmsquestions',$qdata);
    }
    
 public function createABlank($adata,$type){
    $count=1;
    if($type=='1'||$type=='2'||$type=='3'||$type=='10'){
        $count=1;
    }
    if($type=='5'||$type=='6'){
        $count=4;
    }   
        for($i=1;$i<=$count;$i++){
        $this->db->insert('cmsanswers',$adata);
        }
        
    }
    
    
        }
