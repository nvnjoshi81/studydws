<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contents_model extends CI_Model {

    public function add($data) {
        $this->db->insert('cmspricelist', $data);
        return $this->db->insert_id();
    }

    public function add_question_bank($data) {
        $this->db->insert('cmsquestionbank', $data);
        return $this->db->insert_id();
    }

    public function update_question_bank($id, $data) {

        $this->db->update('cmsquestionbank', $data, array('id' => $id));
    }
	
	
    public function update_SortChapter($content_type,$exam_id,$subject_id,$chapter_id,$chapter_sortid) {
//echo "<br><--->".$content_type,'content_type<br>',$exam_id,'exam_id<br>',$subject_id,'subject_id<br>',$chapter_id,'chapter_id<br>',$chapter_sortid,'chapter_sortid<br>',"<--->";

$ipp=0;
if(isset($content_type)&&$content_type!=''){
//$ipp++;	
}
if(isset($exam_id)&&$exam_id!=''){
$ipp++;	
}
if(isset($subject_id)&&$subject_id!=''){
$ipp++;	
}
if(isset($chapter_id)&&$chapter_id!=''){
$ipp++;	
}

if(isset($chapter_sortid)&&$chapter_sortid!=''){
$ipp++;
}

$sortdata=array('sortorder'=>$chapter_sortid);

if($ipp=='4'){
	 $this->db->update('cmschapter_details', $sortdata, array('class_id' => $exam_id,'subject_id' => $subject_id,'chapter_id' => $chapter_id,));
     return true; 
}else{	
	 return false; 
}
}
    public function add_cmsquestionbank_details($data) {

        $this->db->insert('cmsquestionbank_details', $data);
        return $this->db->insert_id();
    }

    public function update_cmsquestionbank_details($id, $data) {

        $this->db->update('cmsquestionbank_details', $data, array('id' => $id));
    }

    public function remove_cmsquestionbank_details_by_questionbank_id($id) {
        $this->db->where('questionbank_id', $id);
        $this->db->delete('cmsquestionbank_details');
    }

    public function add_sample_papers($data) {

        $this->db->insert('cmssamplepapers', $data);
        return $this->db->insert_id();
    }

    public function update_sample_papers($id, $data) {

        $this->db->update('cmssamplepapers', $data, array('id' => $id));
    }

    public function add_cmssamplepapers_details($data) {

        $this->db->insert('cmssamplepapers_details', $data);
        return $this->db->insert_id();
    }

    public function deleteContentType($id) {

        $this->db->where('id', $id);

        $this->db->delete('postings');
    }

    public function add_article($data) {

        $this->db->insert('postings', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {

        $this->db->update('cmspricelist', $data, array('id' => $id));
    }

    public function get($type, $exam_id, $subject_id = 0, $chapter_id = 0) {
        $this->db->select('*');
        $this->db->from('cmspricelist');
        $this->db->where('type', $type);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('chapter_id', $chapter_id);

        $query = $this->db->get();
        if ($this->db->count_all_results() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getItemPrice($param) {
        // TO_DO
    }

    public function add_cmsfiles($data) {

        $this->db->insert('cmsfiles', $data);
        return $this->db->insert_id();
    }

    public function add_cmsvideos($data) {

        $this->db->insert('cmsvideos', $data);
        return $this->db->insert_id();
    }

    public function update_cmsvideos($id, $data) {
        $this->db->update('cmsvideos', $data, array('id' => $id));
    }

    public function add_books($data) {
        $this->db->insert('cmsbooks', $data);
        return $this->db->insert_id();
    }

    public function add_cmsbooks_details($data) {

        $this->db->insert('cmsbooks_details', $data);
        return $this->db->insert_id();
    }

    public function update_books($id, $data) {
        $this->db->update('cmsbooks', $data, array('id' => $id));
    }

    public function add_videos($data) {
        $this->db->insert('cmsvideoslist', $data);
        return $this->db->insert_id();
    }

    public function add_videos_playlist($data) {
        $this->db->insert('cmsvideoslist', $data);
        return $this->db->insert_id();
    }

    public function update_playlist($id, $data) {
        $this->db->update('cmsvideoslist', $data, array('id' => $id));
    }

    public function add_cmsvideoslist_details($data) {

        $this->db->insert('cmsvideolist_details', $data);
        return $this->db->insert_id();
    }

    public function update_videos($id, $data) {
        $this->db->update('cmsvideoslist', $data, array('id' => $id));
    }

    public function add_solvedpapers($data) {
        $this->db->insert('cmssolvedpapers', $data);
        return $this->db->insert_id();
    }

    public function add_cmssolvedpapers_details($data) {

        $this->db->insert('cmssolvedpapers_details', $data);
        return $this->db->insert_id();
    }

    /* To edit solved papers */

    public function update_solvedpapers($id, $data) {

        $this->db->update('cmssolvedpapers', $data, array('id' => $id));
    }

    public function add_studymaterial($data) {
        $this->db->insert('cmsstudymaterial', $data);
        return $this->db->insert_id();
    }

    public function add_cmsstudymaterial_details($data) {
        $this->db->insert('cmsstudymaterial_details', $data);
        return $this->db->insert_id();
    }

    public function update_studymaterial($id, $data) {
        $this->db->update('cmsstudymaterial', $data, array('id' => $id));
    }
    
  public function check_sminfo($productname,$exam_id = null, $subject_id = null, $chapter_id = null) {
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
        $this->db->where('F.displayname',$productname);
        $this->db->limit(1);       
        $this->db->order_by('F.id','desc');
        $this->db->group_by('F.id');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();   
        
    }

    public function add_onlinetest($data) {
        $this->db->insert('cmsonlinetest', $data);
        return $this->db->insert_id();
    }

    public function add_onlinetest_details($data) {

        $this->db->insert('cmsonlinetest_details', $data);
        return $this->db->insert_id();
    }

    public function update_onlinetest($id, $data) {
        $this->db->update('cmsonlinetest', $data, array('id' => $id));
    }
    public function update_onlinetestrelations($id, $data) {
        $this->db->update('cmsonlinetest_relations', $data, array('onlinetest_id' => $id));
    }

    public function add_ncertsolutions($data) {
        $this->db->insert('cmsncertsolutions', $data);
        return $this->db->insert_id();
    }

    public function add_cmsncertsolutions_details($data) {

        $this->db->insert('cmsncertsolutions_details', $data);
        return $this->db->insert_id();
    }

    /* To edit NSERT Solutions */

    public function update_ncertsolutions($id, $data) {

        $this->db->update('cmsncertsolutions', $data, array('id' => $id));
    }

    public function add_notes($data) {
        $this->db->insert('cmsnotes', $data);
        return $this->db->insert_id();
    }

    public function add_cmsnotes_details($data) {

        $this->db->insert('cmsnotes_details', $data);
        return $this->db->insert_id();
    }

    public function update_notes($id, $data) {

        $this->db->update('cmsnotes', $data, array('id' => $id));
    }

    public function update_relation_in_questionbank($exam_id, $subject_id, $chapter_id, $module_id, $relations_data) {

        $this->db->update('cmsquestionbank_relations', $relations_data, array('questionbank_id' => $module_id, 'exam_id' => $exam_id, 'subject_id' => $subject_id, 'chapter_id' => $chapter_id));
        // echo  $this->db->last_query(); die;  
    }

    public function add_relation_in_questionbank($relation_data) {

        $this->db->insert('cmsquestionbank_relations', $relation_data);
        return $this->db->insert_id();
    }

    public function add_relation_in_solvedpapers($relation_data) {

        $this->db->insert('cmssolvedpapers_relations', $relation_data);
        return $this->db->insert_id();
    }

    public function add_relation_in_samplepapers($relation_data) {

        $this->db->insert('cmssamplepapers_relations', $relation_data);
        return $this->db->insert_id();
    }

    public function add_relation_in_studymaterial($relation_data) {

        $this->db->insert('cmsstudymaterial_relations', $relation_data);
        return $this->db->insert_id();
    }

    public function add_relation_in_onlinetest($relation_data) {

        $this->db->insert('cmsonlinetest_relations', $relation_data);
        return $this->db->insert_id();
    }

    public function add_relation_in_books($relation_data) {

        $this->db->insert('cmsbooks_relations', $relation_data);
        return $this->db->insert_id();
    }

    public function add_relation_in_videolist($relation_data) {

        $this->db->insert('cmsvideolist_relations', $relation_data);
        return $this->db->insert_id();
    }

    public function add_relation_in_ncertsolutions($relation_data) {

        $this->db->insert('cmsncertsolutions_relations', $relation_data);
        return $this->db->insert_id();
    }

    public function add_relation_in_notes($relation_data) {

        $this->db->insert('cmsnotes_relations', $relation_data);
        return $this->db->insert_id();
    }

    public function add_relation_in_videos($relation_data) {

        $this->db->insert('cmsvideolist_relations', $relation_data);
        return $this->db->insert_id();
    }

    public function createStudents($relation_data) {
        $this->db->insert('students', $relation_data);
        //echo $this->db->last_query();;die;
        return $this->db->insert_id();
    }

    public function addRelation($table_name, $relation_data, $columnname) {
        $this->db->select('*');
        $this->db->from($table_name);
        if ($relation_data['exam_id'] > 0) {
            $this->db->where('exam_id', $relation_data['exam_id']);
        }else if($relation_data['category_id'] > 0){
			
			  $this->db->where('category_id', $relation_data['category_id']);
		}
        if (isset($relation_data['chapter_id']) && $relation_data['chapter_id'] > 0) {
            $this->db->where('chapter_id', $relation_data['chapter_id']);
        }
        if (isset($relation_data['subject_id']) && $relation_data['subject_id'] > 0) {
            $this->db->where('subject_id', $relation_data['subject_id']);
        }
        $this->db->where($columnname, $relation_data[$columnname]);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            $this->db->insert($table_name, $relation_data);
            return $this->db->insert_id();
        }
        return 0;
    }

    public function remove_relation_byid($relation_id, $id, $module_id, $tablename, $exam_id, $subject_id, $chapter_id) {

        $this->db->delete($tablename, array('id' => $relation_id));
        $this->session->set_flashdata('message', 'Relation Deleted!');
        redirect('admin/contents/edit/' . $id . '/' . $module_id);
    }

    public function getVideoSource() {

        $array_video_source = array(
            '0' => (object) array('id' => 'studyadda', 'name' => 'studyadda'),
            '1' => (object) array('id' => 'youtube', 'name' => 'youtube'),
            '2' => (object) array('id' => 'amazon', 'name' => 'amazon')
        );
        return $array_video_source;
    } 
	
	
    public function getVideoBy() {

        $array_video_by = array(
            '0'  =>  (object) array('id' => '137922', 'name' => 'Lalit Sardana Sir-137922'),
            '1'  =>  (object) array('id' => '153585', 'name' => 'Shweta Sardana Mam-153585'),
            '2'  =>  (object) array('id' => '299858', 'name' => 'Rohit Rathor Sir-299858'),
            '3'  =>  (object) array('id' => '294554', 'name' => 'JP Chokikar Sir-294554'),
            '4'  =>  (object) array('id' => '300065', 'name' => 'Praveen Mishra Sir-300065'),
            '5'  =>  (object) array('id' => '288078', 'name' => 'Apeksha JoshiMam-288078'),
            '6'  =>  (object) array('id' => '306858', 'name' => 'Sudhir Tyagi Sir-306858'),
            '7'  =>  (object) array('id' => '306844', 'name' => 'Sapna Agrwal Mam-306844'),
            '8'  =>  (object) array('id' => '306867', 'name' => 'Roselin Mam-306867'),
            '9'  =>  (object) array('id' => '306874', 'name' => 'Priyanka Gorkhe Mam-306874'),
			'10' =>  (object) array('id' => '312291', 'name' => 'Jitendra Jhalaya Sir-312291'),
			'11' =>  (object) array('id' => '312290', 'name' => 'Devendra Sendhav Sir-312290'),
			'12' =>  (object) array('id' => '315370', 'name' => 'Arjun Sendhav sir-315370'),
			'13' =>  (object) array('id' => '313107', 'name' => 'Manali Joshi Mam-313107'),
			'14' =>  (object) array('id' => '315420', 'name' => 'Sakshi Sharma Mam-315420'),
			'15' =>  (object) array('id' => '315422', 'name' => 'Raj Chandna Sir-315422'),
			'16' =>  (object) array('id' => '315423', 'name' => 'Meghna Shah Mam-315423'),
			'17' =>  (object) array('id' => '317596', 'name' => 'Rashmi shrivas Mam-317596'),
			'18' =>  (object) array('id' => '327821', 'name' => 'Nivedita Choudhry Mam-327821'),
			'19' =>  (object) array('id' => '327824', 'name' => 'Neha Soni Mam-327824'),
			'20' =>  (object) array('id' => '327835', 'name' => 'Aditi Agrawal Mam-327835'),
			'21' =>  (object) array('id' => '323776', 'name' => 'Mousami Mazumdar Mam-323776'),
			'22' =>  (object) array('id' => '338545', 'name' => 'Kamini Sharma Mam-338545'),
			'23' =>  (object) array('id' => '346381', 'name' => 'Shubhangi Kadam Mam-346381'),
			'24' =>  (object) array('id' => '346368', 'name' => 'Shivam Sharma Sir-346368'),
			'25' =>  (object) array('id' => '346370', 'name' => 'Leena Mirge Mam-346370'),
			'26' =>  (object) array('id' => '346373', 'name' => 'Rohit Singh Sir-346373'),
			'27' =>  (object) array('id' => '346376', 'name' => 'Chandni Panchal Mam-346376'),
			'28' =>  (object) array('id' => '346334', 'name' => 'Madhuri Panwar Mam-346334'),
			'29' =>  (object) array('id' => '348053', 'name' => 'Gunjan Saluja Mam-348053'),
			'30' =>  (object) array('id' => '348055', 'name' => 'Rukmani Sahu Mam-348055'),
			'31' =>  (object) array('id' => '339291', 'name' => 'Ajay Khatri Sir-339291'),
			'32' =>  (object) array('id' => '356456', 'name' => 'Avijeet Vyas Sir-356456'),
            '33' =>  (object) array('id' => '364069', 'name' => 'Kajal Choudhary Mam-364069'),
            '34' =>  (object) array('id' => '364975', 'name' => 'Pooja Rathore Mam-364975'),
            '35' =>  (object) array('id' => '364976', 'name' => 'Rani Patwa Mam-364976'),
            '36' =>  (object) array('id' => '364980', 'name' => 'Nishant Sharma sir-364980'),
            '37' =>  (object) array('id' => '364984', 'name' => 'Rajendra Jaiswal Sir-364984'),
            '38' =>  (object) array('id' => '364985', 'name' => 'Deepa Mam-364985'),
            '39' =>  (object) array('id' => '365070', 'name' => 'Manju Sahu Mam-365070'),
            '40' =>  (object) array('id' => '395403', 'name' => 'Jyoti Butani Mam-395403')
			
        );
		
		    /*,
		    '23' => (object) array('id' => '', 'name' => ''),
			'24' => (object) array('id' => '', 'name' => ''),
			'25' => (object) array('id' => '', 'name' => ''),
			'26' => (object) array('id' => '', 'name' => ''),
			'27' => (object) array('id' => '', 'name' => '')
			*/
        return $array_video_by;
    } 
	

    public function getVideoSourceById($id) {

        $array_video_source = $this->getVideoSource();
        return $array_video_source[$id];
    }

    public function getIsFeatured() {
        $array_is_featured = array(
            '0' => (object) array('id' => '0', 'name' => 'No'),
            '1' => (object) array('id' => '1', 'name' => 'Yes')
        );
        return $array_is_featured;
    }

    public function getStatus() {
        $array_status = array(
            '0' => (object) array('id' => '1', 'name' => 'Show'),
            '1' => (object) array('id' => '0', 'name' => 'Hide')
        );
        return $array_status;
    }
	
	
	    public function addcomment($data) {
        $this->db->insert('comments', $data);
        return $this->db->insert_id();
    }
	
	    public function showcomment($post_id,$post_type,$status=1) {
            $this->db->select('com_name,com_dis,likes,date,status');
        $this->db->from('comments');
        $this->db->where('post_type', $post_type);
        $this->db->where('post_id', $post_id);
        $this->db->order_by('com_id','desc');
        $this->db->order_by('status',$status);

        $query = $this->db->get();
        if ($this->db->count_all_results() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	
		public function addlike($id,$like_data,$action,$cid) {								
		switch($action){
		case "like":				 
			//$query = "INSERT INTO commentslikes (postid,post_type,userid,ipaddress,date) VALUES ('" . $id . "','" . $ptyp . "','" . $cid . "','" . $ip_address . "','" . $date . "')";
			  $this->db->insert('commentslikes', $like_data);		
			$result = $this->db->insert_id();
			if(!empty($result)) {
		$like_data = array('like_count' => 'like_count'+1);		
        $this->db->update('cmsvideos', $like_data, array('id' => $id));			
			}			
		break;		
		case "unlike":
		$this->db->where('id', $id);
		$this->db->where('userid', $cid);
        $result=$this->db->delete('commentslikes');
		if(!empty($result)) {				
		$like_data = array('like_count' => 'like_count'-1);		
        $this->db->update('cmsvideos', $like_data, array('id' => $id));
			}
		break;		
	}
	
	}


}
