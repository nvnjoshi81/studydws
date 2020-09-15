<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Questionbankqusans_model extends CI_Model
{
    public function getData(){
        $this->db->select('*');
        $this->db->limit('500');
        $this->db->from('question_bank_qus_ans_31012016');
        $this->db->order_by('chapter_id','asc');
        $query=$this->db->get();
        return $query->result();
    }
    public function getSamplePapersData(){
        $this->db->select('*');
        //$this->db->limit('1');
        $this->db->from('sample_papers_title');
        $query=$this->db->get();
        return $query->result();
    }
    public function getSamplePapers($sample_papers_title_id){
        $this->db->select('*');
        $this->db->where('sample_papers_title_id',$sample_papers_title_id);
        $this->db->from('sample_papers_02022016');
        $query=$this->db->get();
        return $query->result();
    }
    
    public function getVideos(){
        $this->db->select('*');
        //$this->db->limit('1');
        $this->db->from('video_topic');
        $query=$this->db->get();
        return $query->result();
    }
    public function getOnlineTest(){
        $this->db->select('*');
        //$this->db->limit('1');
        $this->db->from('online_exam_question_paper');
        $query=$this->db->get();
        return $query->result();
    }
    
    public function getOnlineTestQuestions($id){
        $this->db->select('*');
        //$this->db->limit('1');
        $this->db->from('online_exam_questions');
        $this->db->where('quiz_id',$id);
        $query=$this->db->get();
        return $query->result();
    }
    public function getOnlineTestQuestionAnswers($qid){
        $this->db->select('*');
        //$this->db->limit('1');
        $this->db->from('online_exam_answers');
        $this->db->where('group_id',$qid);
        $query=$this->db->get();
        return $query->result();
    }
    
    public function getPlaylist(){
        $this->db->select('*');
        $this->db->order_by('cat_pid','asc');
        $query=$this->db->get('video_cat');
        return $query->result();
        
    }
    
    public function getPlaylistVideos($playlist_id){
        $this->db->select('*');
        $this->db->where('topic_examid',$playlist_id);
        $query=$this->db->get('video_topic');
        return $query->result();
    }
    
    public function videoTopicDetails($id){
        $this->db->select('*');
        $this->db->where('topic_pid',$id);
        $this->db->from('video_topic');
        $query=$this->db->get();
        return $query->row();
    }
    public function getStudyMaterial(){
        $array=array(1,5,15,17);
        $this->db->select('*');
        $this->db->from('s_down');
        $this->db->where_in('down_examid',$array);
        $query=$this->db->get();
        return $query->result();
    }
    
    public function getNcertSolution(){
        
        $this->db->select('*');
        $this->db->from('ncert_solutions_qus_ans');
        //$this->db->limit(500);
        $this->db->order_by('qus_ans_id','asc');
        $query=$this->db->get();
        return $query->result();
    }
    public function getNcertExempler(){
        
        $this->db->select('*');
        $this->db->from('ncert_chapter_exemplar_21mar');
        $this->db->limit(500);
        $this->db->order_by('chapter_exemplar_id','asc');
        $query=$this->db->get();
        return $query->result();
    }
    public function getBooksTitle(){
        $this->db->select('*');
        $this->db->from('books_title');
       
        $query=$this->db->get();
        return $query->result();
    }
    public function getBooksChapter(){
        $query=$this->db->query('SELECT t.book_class_id,t.book_subject_id,c.* FROM `books_chapter` c, books_title t WHERE t.subject_id=c.subject_id');
        return $query->result();
    }
    public function getSolvedPapers(){
        $this->db->select('*');
        $this->db->from('solved_papers_qus_ans');
        $this->db->limit(500);
        $this->db->order_by('qus_ans_id','asc');
        $query=$this->db->get();
        return $query->result();
    }
}


