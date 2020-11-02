<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Examcategory_model extends CI_Model {
    
    public function getExamCatgeories($id=21){
        $this->db->select('id,name,parent_id,description');
        $this->db->from('categories');
        $this->db->where('parent_id', $id);
        $this->db->where('status', 'show');
        $this->db->order_by('order','asc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }
    
    public function getExamSubject(){
        $this->db->select('id,name,description');
        $this->db->from('cmssubjects');
        $this->db->order_by('order','asc');
        $query = $this->db->get();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }
	
	
/*for getting sub Exam list for category table*/

public function getSubExam($exam_id=0){
//SELECT * FROM `categories` WHERE `parent_id` = $examid 
  	if($exam_id>0){
		
  $this->db->select('id,name,order,parent_id,description');
        $this->db->from('categories');
        $this->db->where('parent_id', $exam_id);
        $this->db->where('status', 'show');
        $this->db->order_by('order','asc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
	}else{
		return array();
	}
}

public function getSubSubject($subject_id=0){
//SELECT * FROM `categories` WHERE `parent_id` = $examid 
  	if($subject_id>0){
  $this->db->select('id,name,order,parent_id,description');
        $this->db->from('cmssubjects');
        $this->db->where('parent_id',$subject_id);
        $this->db->order_by('order','asc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
	}else{
		return array();
	}
}	  
    public function getAdminExamCatgeories(){
        $this->db->select('id,name,parent_id,description');
        $this->db->from('categories');
        $this->db->where('parent_id', 21);
        $this->db->or_where('parent_id', 39);
        $this->db->order_by('name','asc');
        $query = $this->db->get();if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }
     public function getExamCatgeoryById($id){
        $this->db->select('id,name,parent_id,description');
        $this->db->from('categories');
        $this->db->where('id', $id);
        $query = $this->db->get();
       // echo $this->db->last_query(); die;
       if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }
	
	public function getExamProductById($id){		
		if( $id>0){
        $this->db->select('C.id,C.name,C.parent_id,C.description,P.id as pid,P.exam_id,P.subject_id,P.chapter_id,P.item_id,P.type,P.price,P.discounted_price,P.description,P.offline_status,P.image,P.modules_item_id,P.modules_item_name');
        $this->db->from('cmspricelist P');
        $this->db->where('P.exam_id', $id);
        $this->db->where('P.subject_id', 0);
		$this->db->where('P.chapter_id', 0);
		$this->db->where('P.item_id', 0);
		$this->db->join('categories C', 'P.exam_id=C.id', 'left');
        $query = $this->db->get();
        //$this->db->save_queries = TRUE;
        //echo  $this->db->last_query();
        return $query->result();
		}else{
		return NULL;
		}		
    }
    
        public function  getProductVideo($exam_id,$sid=NULL,$cid=NULL){
        $this->db->select('vlr.id as vlid,vlr.exam_id,vlr.subject_id,vlr.chapter_id');
        $this->db->from('cmsvideolist_relations vlr');
        //$this->db->where('cmssubjects.id','cd.subject_id');
        $this->db->where('vlr.exam_id',$exam_id);
        $this->db->where('vlr.subject_id',$sid);
        $this->db->where('vlr.chapter_id',$cid);
        $this->db->order_by('vlr.chapter_id','asc');
        //$this->db->order_by('cname');
        $query = $this->db->get();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
        }
    public function getExamChapters($id){
        $this->db->select('cmschapters.id as cid,cmschapters.name as cname,cmssubjects.id as sid, cmssubjects.name as sname, cmssubjects.imagename');
        $this->db->from('cmschapter_details cd ');
        $this->db->join('cmschapters', 'cd.chapter_id = cmschapters.id');
        $this->db->join('cmssubjects', 'cd.subject_id = cmssubjects.id');
        //$this->db->where('cmssubjects.id','cd.subject_id');
        $this->db->where('cd.class_id',$id);
        $this->db->order_by('cd.sortorder','asc');
        $this->db->order_by('cd.id','asc');
        //$this->db->order_by('cname');
        $query = $this->db->get();
		//echo $this->db->last_query();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }
    
    public function getExamSubChapters($id,$subjectid=0){
        $this->db->select('cmschapters.id as cid,cmschapters.name as cname,cmssubjects.id as sid, cmssubjects.name as sname');
        $this->db->from('cmschapter_details cd ');
        $this->db->join('cmschapters', 'cd.chapter_id = cmschapters.id');
        $this->db->join('cmssubjects', 'cd.subject_id = cmssubjects.id');
        //$this->db->where('cmssubjects.id','cd.subject_id');
        $this->db->where('cd.class_id',$id);
        if($subjectid>0){
         $this->db->where('cmssubjects.id',$subjectid);
        }
        //$this->db->order_by('cmssubjects.id');
        //$this->db->order_by('cname');
		
		$this->db->order_by('cd.sortorder','asc');$this->db->order_by('cd.id','asc');
        $query = $this->db->get();
		
		//echo $this->db->last_query();
        if($query->num_rows()>0){
        return $query->result();
        }else{
        return array();
        }
    }
  
}