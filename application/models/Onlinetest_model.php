	
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Onlinetest_model extends CI_Model {
   
    public function getOnlineTests($exam_id = null, $subject_id = null, $chapter_id = null,$limit_start=null, $limit_end=null) {
        $this->db->select('cmsonlinetest.name,cmsonlinetest.id,cmsonlinetest_relations.exam_id,cmsonlinetest_relations.subject_id,cmsonlinetest_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsonlinetest_relations');

        if ($exam_id > 0) {
            $this->db->where('cmsonlinetest_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsonlinetest_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {

            $this->db->where('cmsonlinetest_relations.chapter_id', $chapter_id);
        }
        $this->db->join('categories', 'cmsonlinetest_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsonlinetest_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsonlinetest_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsonlinetest', 'cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id');
        $this->db->order_by('cmsonlinetest.id',"desc");
        if($limit_start || $limit_end){
			$this->db->limit($limit_start, $limit_end);
		}
        $query = $this->db->get();
        //echo $this->db->last_query(); 
        return $query->result();
    }
    

    public function getOnlineTests_bymodule($exam_id = null, $subject_id = null, $chapter_id = null,$module_id=null,$not_module_id=0) {
        $this->db->select('cmsonlinetest.name,cmsonlinetest.id,cmsonlinetest.created_from,cmsonlinetest.created_from_id,cmsonlinetest.olcategory_id,cmsonlinetest.dt_start,cmsonlinetest.dt_end,cmsonlinetest.assessment_type,cmsonlinetest_relations.exam_id,cmsonlinetest_relations.subject_id,cmsonlinetest_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsonlinetest_relations');

        if ($exam_id > 0) {
            $this->db->where('cmsonlinetest_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsonlinetest_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {

            $this->db->where('cmsonlinetest_relations.chapter_id', $chapter_id);
        }
if($not_module_id>0){
	    $this->db->where('cmsonlinetest.created_from_id!=',$not_module_id);		
}else if($module_id > 0) {
        $this->db->where('cmsonlinetest.created_from_id',$module_id);
        }        
        $this->db->join('categories', 'cmsonlinetest_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsonlinetest_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsonlinetest_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsonlinetest', 'cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id');
        $this->db->order_by('cmsonlinetest.olcategory_id',"desc");
        $query = $this->db->get();
        //echo $this->db->last_query(); //die; 
        return $query->result();
    }
    
    public function getAllTestCount() {
        return $this->db->count_all('cmsusertest');
    }

    function getAllTest($limit_start = null, $limit_end = null) {
        if ($limit_start || $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
        $this->db->select('A.*,B.firstname,B.email,B.lastname,B.mobile,B.guest,C.name as testname');
        $this->db->from('cmsusertest A');
        $this->db->join('cmscustomers B', 'A.user_id=B.id');
        $this->db->join('cmsonlinetest C', 'A.test_id=C.id');
        $this->db->order_by('A.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
	
    public function getQuestionCount($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('cmsonlinetest_details.id');
        $this->db->from('cmsonlinetest_relations');

        $this->db->join('cmsonlinetest_details', 'cmsonlinetest_details.onlinetest_id=cmsonlinetest_relations.onlinetest_id');

        if ($exam_id > 0) {
            $this->db->where('cmsonlinetest_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsonlinetest_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsonlinetest_relations.chapter_id', $chapter_id);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getCronOtCount($exam_id = null, $subject_id = null, $chapter_id = null) {
        $this->db->select('count(cmsonlinetest_details.id) as qcount');
        $this->db->from('cmsonlinetest_relations');

        $this->db->join('cmsonlinetest_details', 'cmsonlinetest_details.onlinetest_id=cmsonlinetest_relations.onlinetest_id');

        if ($exam_id > 0) {
            $this->db->where('cmsonlinetest_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsonlinetest_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {
            $this->db->where('cmsonlinetest_relations.chapter_id', $chapter_id);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function detail($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('cmsonlinetest');
        //echo $this->db->last_query();
        return $query->row();
    }

    public function detail_with_relation($id,$exam_id=0,$subject_id=0,$chapter_id=0) {
        $this->db->select('A.id,A.name,A.instructions,A.formula_id,A.calculater,A.time,A.type,A.qus_pdf,A.ans_pdf,A.solution_pdf,B.exam_id,B.subject_id,B.chapter_id,B.file_id');
        $this->db->from('cmsonlinetest A');
        $this->db->join('cmsonlinetest_relations B', 'B.onlinetest_id=A.id', 'left');
		$this->db->where('A.id', $id);
        if($exam_id>0){
			$this->db->where('B.exam_id', $exam_id);        
		}
		if($subject_id>0){
			$this->db->where('B.subject_id', $subject_id);        
		}
		if($chapter_id>0){
			$this->db->where('B.chapter_id', $chapter_id);        
		}		
		$query = $this->db->get();  
        //echo $this->db->last_query();
        return $query->row();
    }
    
    public function getolDetails($id) {
        $this->db->select('A.*,C.name as type,B.question_id,B.marks,B.qus_formula_id,B.id as details_id');
        $this->db->from('cmsquestions A');
        $this->db->join('cmsonlinetest_details B','B.question_id=A.id', 'left');
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->where('B.onlinetest_id', $id);
        $query = $this->db->get();  //echo $this->db->last_query();
        return $query->result();
    }
    public function getolQuestion($id) {
        $this->db->select('A.*,D.answer_extra,C.name as type,B.question_id,B.onlinetest_id,B.marks,B.qus_formula_id');
        $this->db->distinct();
        $this->db->from('cmsquestions A');
        $this->db->join('cmsonlinetest_details B','B.question_id=A.id', 'left');
        $this->db->join('cmsquestiontypes C', 'C.id=A.type', 'left');
        $this->db->join('cmsanswers D','D.question_id=A.id','left');
        $this->db->where('B.onlinetest_id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        return $query->result();
    }
    public function appquesinfo($id) {
    $this->db->select('A.*,C.answer_extra,B.name as typename');
    $this->db->distinct();
    $this->db->from('cmsquestions A');
        $this->db->join('cmsquestiontypes B', 'B.id=A.type', 'left');
        $this->db->join('cmsanswers C','C.question_id=A.id','left');
        $this->db->where('A.id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        return $query->result();
    }

        public function appquesans_info($id) {
        $this->db->select('A.*,C.answer_extra,B.name as typename');
        $this->db->distinct();
        $this->db->from('cmsquestions A');
        $this->db->join('cmsquestiontypes B', 'B.id=A.type', 'left');
        $this->db->join('cmsanswers C','C.question_id=A.id','left');
        $this->db->where('A.id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        return $query->result();
    }
    public function getAnswerByQuestion($questionId) {
        $this->db->select('id,question_id,answer,answer_extra,description,is_correct');
        $this->db->from('cmsanswers');
        $this->db->where('question_id', $questionId);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }

    public function getUserGroup($userid) {
        $this->db->select('cmsonlinetest_usergroup.id,cmsonlinetest_usergroup.groupid,cmsonlinetest_usergroup.status,cmsonlinetest_group.name');
        $this->db->from('cmsonlinetest_usergroup');
		$this->db->join('cmsonlinetest_group','cmsonlinetest_group.id=cmsonlinetest_usergroup.groupid');
		$this->db->where('cmsonlinetest_usergroup.userid', $userid);
		$this->db->where('cmsonlinetest_usergroup.status', 'show');
        $this->db->order_by("cmsonlinetest_usergroup.id", "desc");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
	
	public function getUsersOfGroup($groupid) {
        $this->db->select('id,groupid,userid,status');
        $this->db->from('cmsonlinetest_usergroup');
        $this->db->where('groupid', $groupid);
		$this->db->where('status', 'show');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
		
	public function examResultOfGroup($groupUserId,$exam_id) {
        $this->db->select('id,groupid,userid,status');
        $this->db->from('cmsonlinetest_usergroup');
        $this->db->where('groupid', $groupid);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }


    public function getRelationDetail($relation_data_type) {
        $this->db->select('id,onlinetest_id,exam_id,subject_id,chapter_id');
        $this->db->from('cmsonlinetest_relations');
        $this->db->where('onlinetest_id', $relation_data_type);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }

    public function getolExamFormula() {
        $this->db->select('*');
        $this->db->from('cmsonlinetest_formula');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }

    public function getolExamCategory($exam_id=0) {
        $this->db->select('*');
        $this->db->from('cmsonlinetest_cat');
        if($exam_id>0){
        $this->db->where('exam_id',$exam_id);
        }
        $this->db->order_by("name", "asc");
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
public function OnlineTests_byCategory($exam_id = null, $subject_id = null, $chapter_id = null,$exCategory_id=null) {
        $this->db->select('cmsonlinetest.name,cmsonlinetest.id,cmsonlinetest.created_from,cmsonlinetest.created_from_id,cmsonlinetest.olcategory_id,cmsonlinetest_relations.exam_id,cmsonlinetest_relations.subject_id,cmsonlinetest_relations.chapter_id')->select('categories.name as exam')->select('cmssubjects.name as subject')->select('cmschapters.name as chapter');
        $this->db->from('cmsonlinetest_relations');
		
        if ($exam_id > 0) {
            $this->db->where('cmsonlinetest_relations.exam_id', $exam_id);
        }
        if ($subject_id > 0) {
            $this->db->where('cmsonlinetest_relations.subject_id', $subject_id);
        }
        if ($chapter_id > 0) {

            $this->db->where('cmsonlinetest_relations.chapter_id', $chapter_id);
        }
        if ($exam_id > 0) {
        $this->db->where('cmsonlinetest.olcategory_id',$exCategory_id);
        }        
        $this->db->join('categories', 'cmsonlinetest_relations.exam_id=categories.id', 'left');
        $this->db->join('cmssubjects', 'cmsonlinetest_relations.subject_id=cmssubjects.id', 'left');
        $this->db->join('cmschapters', 'cmsonlinetest_relations.chapter_id=cmschapters.id', 'left');
        $this->db->join('cmsonlinetest', 'cmsonlinetest.id=cmsonlinetest_relations.onlinetest_id');
        $this->db->order_by('cmsonlinetest.olcategory_id',"desc");
        $query = $this->db->get();
        //echo $this->db->last_query(); die; 
        return $query->result();
        }
        
    public function formula_detail($id) {
        $this->db->select('*');
        $this->db->from('cmsonlinetest_formula');
        $this->db->where('online_exam_formula_id', $id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->row();
    }

    //get correct answer
    public function getCorrectAns($id) {
        $this->db->select('id,answer,answer_extra,is_correct,description');
        $this->db->from('cmsanswers');
        $this->db->where('question_id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    //get answer by answer id.
    public function getAns($id) {
        $this->db->select('id,question_id,answer,answer_extra,is_correct,description');
        $this->db->from('cmsanswers');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function delete_module_onlinetest($id) {
        //delete from cmspricelist table
        $this->db->where('modules_item_id', $id);
        $this->db->delete('cmspricelist');

        //delete from cmsncertsolutions_relations table
        $this->db->where('onlinetest_id', $id);
        $this->db->delete('cmsonlinetest_relations');

        //delete from cmsncertsolutions_details table
        $this->db->where('onlinetest_id', $id);
        $this->db->delete('cmsonlinetest_details');

        //delete from cmsncertsolutions table
        $this->db->where('id', $id);
        $this->db->delete('cmsonlinetest');
    }

    public function getInstructionById($instructions_id) {
        $this->db->select('description');
        $this->db->from('instructions');
        $this->db->where('id', $instructions_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function add_user_testdata($data) {
        $this->db->insert('cmsusertest', $data);
        return $this->db->insert_id();
    }
    public function add_usertest_detail($data) {
        $this->db->insert('cmsusertest_detail', $data);
        return $this->db->insert_id();
    }

    public function edit_usertest_detail($id, $data) {
        $this->db->update('cmsusertest_detail', $data, array('id' => $id));
    }
    public function edit_ottest_detail($id, $data) {
        $this->db->update('cmsonlinetest_details', $data, array('id' => $id));
    }
    public function get_userqus_detail($customer_id, $test_id, $usertest_id, $question_id) {
        $this->db->select('B.id');
        $this->db->from('cmsusertest A');
        $this->db->join('cmsusertest_detail B', 'A.id=B.usertest_id');
        $this->db->where('A.user_id', $customer_id);
        $this->db->where('A.test_id', $test_id);
        $this->db->where('B.usertest_id', $usertest_id);
        $this->db->where('B.question_id', $question_id);
        $query = $this->db->get();
        //echo $this->db->last_query(); 
        return $query->result();
    }

    public function update_user_testdata($id, $data) {
        $this->db->update('cmsusertest', $data, array('id' => $id));
    }

    public function get_testinfo_by_customer($customer_id) {
        $this->db->select('A.id,A.status,A.dt_created,A.start_time,A.end_time,B.name');
        $this->db->from('cmsusertest A');
        $this->db->join('cmsonlinetest B', 'B.id=A.test_id');
        $this->db->where('A.user_id', $customer_id);
        $this->db->order_by("A.id", "desc");
        $query = $this->db->get();
        //echo $this->db->last_query(); 
        return $query->result();
    }



public function userpurchases($productid,$customer_id,$orderstatus=1){
	
        $this->db->select('cmsorders.id as mainid');
		$this->db->from('cmsorders');
        $this->db->join('cmsorder_details', 'cmsorders.id=cmsorder_details.order_id');
        $this->db->where('cmsorder_details.product_id', $productid);
        $this->db->where('cmsorders.user_id', $customer_id);
        $this->db->where('cmsorders.status', $orderstatus);
		$query = $this->db->get();
        //echo $this->db->last_query(); 
        return $query->result();
		}
		
    public function get_testinfo_byid($id) {
        $this->db->select('A.*,B.name');
        $this->db->from('cmsusertest A');
        $this->db->join('cmsonlinetest B', 'B.id=A.test_id');
        $this->db->where('A.id', $id);
        $this->db->order_by("A.id", "desc");
        $query = $this->db->get();
        //echo $this->db->last_query(); 
        return $query->row();
    }
	
    public function get_qusformula($usertestid,$question_id) {
		
		   $this->db->select('A.qus_formula_id,A.question_id,B.online_exam_formula_id,B.online_exam_formula_name,B.right_answer_marks,B.wrong_answer_marks');
        $this->db->from('cmsonlinetest_details A');
        $this->db->join('cmsonlinetest_formula B','B.online_exam_formula_id=A.qus_formula_id');
        $this->db->where('A.onlinetest_id', $usertestid);
		$this->db->where('A.question_id', $question_id);
		$query = $this->db->get();
        //echo $this->db->last_query(); 
        return $query->row();
	
	}
    public function get_testdetail_byid($id,$question_id=0) {
        $this->db->select('D.*,Q.id as qid,Q.question,Q.description,Q.type,Q.type_extra,Q.section,Q.section_name,Q.instructions_id,Q.calculator,ut.test_id as usertestid');
        $this->db->from('cmsusertest_detail D');
        $this->db->join('cmsquestions Q','Q.id=D.question_id');
		$this->db->join('cmsusertest ut','D.usertest_id=ut.id');
        $this->db->where('D.usertest_id', $id);
		       
		if($question_id>0){
		 $this->db->where('D.question_id', $question_id);
		}
		        $query = $this->db->get();
        //echo $this->db->last_query(); 
        return $query->result();
    }
    public function remove_userans($exam_id,$qus_id) {
        $this->db->where('usertest_id', $exam_id);
        $this->db->where('question_id', $qus_id);
        $this->db->delete('cmsusertest_detail');
    }
    public function remove_examques($ol_test_id,$qus_id) {
        $this->db->where('onlinetest_id', $ol_test_id);
        $this->db->where('question_id', $qus_id);
        $this->db->delete('cmsonlinetest_details');
    }
    public function getContents_name($id) {
        $this->db->select('A.name');
        $this->db->from('cmsonlinetest A');
        $this->db->where('A.id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function edit_contentsname($id, $data) {

        $this->db->update('cmsonlinetest', $data, array('id' => $id));
    }

    public function getUserTests($user_id, $limit_start = null, $limit_end = null) {
        $this->db->select('cmsusertest.*')->select('cmsonlinetest.name');
        $this->db->from('cmsusertest');
        $this->db->join('cmsonlinetest', 'cmsonlinetest.id=cmsusertest.test_id');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('id', 'desc');
        
        if ($limit_start || $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
   public function getUserTestsCount($user_id) {
        $this->db->select('cmsusertest.*')->select('cmsonlinetest.name');
        $this->db->from('cmsusertest');
        $this->db->join('cmsonlinetest', 'cmsonlinetest.id=cmsusertest.test_id');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getRightAnswerMarks($test_id) {
        $this->db->select('*');
        $this->db->from('cmsusertest_detail');
        $this->db->where('usertest_id', $test_id);
        $this->db->where('is_correct', 1);
        $this->db->where('users_answer IS NOT NULL');
        $query = $this->db->get();

        return $query->result();
    }

    public function reportRightAns($test_id) {
        $this->db->select('count(id) as rightanswer');
        $this->db->from('cmsusertest_detail');
        $this->db->where('usertest_id', $test_id);
        $this->db->where('is_correct', 1);
        $this->db->where('users_answer IS NOT NULL');
        $query = $this->db->get();
        return $query->row();
    }




    public function getwrongAnswerMarks($test_id) {
        $this->db->select('*');
        $this->db->from('cmsusertest_detail');
        $this->db->where('usertest_id', $test_id);
        $this->db->where('is_correct', 0);
        $this->db->where('users_answer!=','');
        $query = $this->db->get();
        return $query->result();
    }
	
  public function reportWrongAns($test_id) {
        $this->db->select('count(id) as wronganswer');
        $this->db->from('cmsusertest_detail');
        $this->db->where('usertest_id', $test_id);
        $this->db->where('is_correct', 0);
        $this->db->where('users_answer!=','');
        $query = $this->db->get();
        return $query->row();
    }
    public function getReviewdQuestion($test_id) {
        $this->db->select('id');
        $this->db->from('cmsusertest_detail');
        $this->db->where('usertest_id', $test_id);
        $this->db->where('is_correct', 2);
        $query = $this->db->get();
        return $query->result();
    }
	
   public function reportReviewdQue($test_id) {
        $this->db->select('count(id) as revied');
        $this->db->from('cmsusertest_detail');
        $this->db->where('usertest_id', $test_id);
        $this->db->where('is_correct', 2);
        $query = $this->db->get();
        return $query->row();
    }
 

    public function getattamptedQuestion($test_id) {
        $this->db->select('id');
        $this->db->from('cmsusertest_detail');
        $this->db->where('usertest_id', $test_id);
        $this->db->where('is_correct!=', 2);
		$this->db->where('users_answer!=', '');
        $this->db->where('is_correct IS NOT NULL');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
	
	  public function reportAttmQue($test_id) {
        $this->db->select('count(id) as attampted');
        $this->db->from('cmsusertest_detail');
        $this->db->where('usertest_id', $test_id);
        $this->db->where('is_correct!=', 2);
		$this->db->where('users_answer!=', '');
        $this->db->where('is_correct IS NOT NULL');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }
	
	 public function getNotattamptedQuestion($test_id) {
        $this->db->select('id');
        $this->db->from('cmsusertest_detail');
        $this->db->where('usertest_id', $test_id);
        $this->db->where('is_correct!=', 2);
		$this->db->where('users_answer=', '');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    public function getAttempts($test_id,$user_id){
        $this->db->select('*');
        $this->db->from('cmsusertest');
        $this->db->where('user_id', $user_id);
        $this->db->where('test_id', $test_id);
		$this->db->order_by("id", "desc"); 
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
	
	   public function getGroupAttempts($test_id,$user_id){
        $this->db->select('cmsusertest.*,cmscustomers.firstname,cmscustomers.lastname');
        $this->db->from('cmsusertest');
		$this->db->join('cmscustomers', 'cmscustomers.id=cmsusertest.user_id','left');
        $this->db->where('cmsusertest.user_id', $user_id);
        $this->db->where('cmsusertest.test_id', $test_id);
		$this->db->order_by("cmsusertest.id", "asc"); 
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }
    
    public function getUserAnswerData($test_id,$question_id){
        $this->db->select('*');
        $this->db->from('cmsusertest_detail');
        $this->db->where('usertest_id', $test_id);
        $this->db->where('question_id', $question_id);
        $query = $this->db->get();
        return $query->row();
    }
    
     public function getDetails_bymoduleID_file($mid) {
        $this->db->select('*');
        $this->db->from('cmsonlinetest_relations');
        $this->db->join('cmsfiles', 'cmsfiles.id=cmsonlinetest_relations.file_id');
        $this->db->where('cmsonlinetest_relations.file_id>', 0);
        $this->db->where('cmsonlinetest_relations.onlinetest_id', $mid);
        $this->db->order_by("cmsfiles.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

}
