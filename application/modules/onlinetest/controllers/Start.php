<?php
ob_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Start extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Onlinetest_model');
		$this->load->model('Subjects_model');		
		$this->load->model('Chapters_model');
        //$this->output->enable_profiler(TRUE);
        $this->data['loadMathJax'] = 'YES';
    }
        
    public function index() {
		$resume_usertestpost = $this->input->post('resume_usertestid');
		if(isset($resume_usertestpost)&&$resume_usertestpost>0){
			//If user start (resume) same test twise
        $onlinetest_id = 0;
		$resume_usertestid=$resume_usertestpost;//when-online-test-zero-resume_usertestid-will-provide-onlinetestid-fromselectquery
		}else{
		$onlinetest_id = $this->input->post('onlinetest_id');
		$resume_usertestid=0;
        
		}
        //$this->output->enable_profiler(TRUE);
        $exam_id = $this->input->post('exam_id');
        $subject_id = $this->input->post('subject_id');
        $chapter_id = $this->input->post('chapter_id');
		$total_question = $this->input->post('total_question');
        $total_time = $this->input->post('total_time');
        $formula_id = $this->input->post('formula_id');
        $current_time = time();
        $customer_id = $this->session->userdata('customer_id');
		$nta_layout = $this->input->post('nta_layout');
		$customer_name = $this->session->userdata('customer_name'); 
		     if (isset($nta_layout) && ($nta_layout == '1')) {
				    $this->session->set_userdata('current_exam_theme', 'nta'); 
			 }else{
				    $this->session->set_userdata('current_exam_theme', 'studyadda'); 
			 }
        $current_exam_timestamp = $this->session->userdata('current_exam_timestamp');
        
        if (!isset($current_exam_timestamp) && ($current_exam_timestamp == '')) {
            $this->session->set_userdata('current_exam_timestamp', $current_time);
        }
        if (isset($onlinetest_id)&&$onlinetest_id>0) {
            $this->session->set_userdata('exam_id', $exam_id);
            $this->session->set_userdata('subject_id', $subject_id);
            $this->session->set_userdata('chapter_id', $chapter_id);
            $this->session->set_userdata('onlinetest_id', $onlinetest_id);
            $this->session->set_userdata('total_question', $total_question);
            $this->session->set_userdata('total_time', $total_time);
            $this->session->set_userdata('formula_id', $formula_id);
			$this->session->set_userdata('time_remaining', $time_remaining);
            $current_exam_timestamp = $this->session->userdata('current_exam_timestamp');
            if(!isset($current_exam_timestamp) || ($current_exam_timestamp == '')) {
            $this->session->set_userdata('current_exam_timestamp', $current_time);
            }
            
            if (($customer_id == '') || ($customer_id < 1)) {
                $customer_id = $this->session->userdata('customer_id');
            }
            //get formula detail
            $formula_info = $this->Onlinetest_model->formula_detail($formula_id);
            $right_answer_marks = $formula_info->right_answer_marks;
            $wrong_answer_marks = $formula_info->wrong_answer_marks;
            $total_marks=$right_answer_marks*$total_question;
            $usertest_data = array(
                'user_id' => $customer_id,
                'test_id' => $onlinetest_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'right_answer_marks' => $right_answer_marks,
                'wrong_answer_marks' => $wrong_answer_marks,                
                'total_time' => $total_time,
                'total_marks'=> $total_marks,
                'formula_id' => $formula_id,
                'total_qus'  => $total_question,
                'status'     => 0,
                'dt_created' => $current_time,
				'conducted_by' => 'studyadda',
                'conducted_in' => 'web',
				'start_time' =>date("h:i a")
            );
            $usertest_id = $this->Onlinetest_model->add_user_testdata($usertest_data);
            $this->session->set_userdata('usertest_id', $usertest_id);
        } else {
			
			  $usertest_data_edit = array(
                'status'     => 0,
                'dt_created' => $current_time,
				'conducted_by' => 'studyadda',
                'conducted_in' => 'web',
				'start_time' =>date("h:i a")
            );
			$this->Onlinetest_model->update_user_testdata($resume_usertestid,$usertest_data_edit);
			$resume_usertestdetails = $this->Onlinetest_model->getUtDetails_only($resume_usertestid);
			if(isset($resume_usertestdetails->usertest_id)&&$resume_usertestdetails->usertest_id>0){
			$this->session->set_userdata('usertest_id', $resume_usertestid);
			$resume_usertestinfo_array = $this->Onlinetest_model->getUsertestData($resume_usertestid);
			
			$resume_usertestinfo=$resume_usertestinfo_array[0];
			
		$time_remaining = $resume_usertestinfo->time_remaining;
			}else{
		    $resume_usertestinfo = $this->Onlinetest_model->getUt_only($resume_usertestid);	
			
		$time_remaining = $resume_usertestinfo->time_remaining;
			}	
			
			//$resume_usertestid
            $exam_id = $this->session->userdata('exam_id');
			if(isset($exam_id)&&$exam_id>0){
			$exam_id = $this->session->userdata('exam_id');	
			}else{
			$exam_id=$resume_usertestinfo->exam_id;
     		$this->session->set_userdata('exam_id', $exam_id);
			}
		//subject_id
	    $subject_id = $this->session->userdata('subject_id');
		if(isset($subject_id)&&$subject_id>0){
			  $subject_id = $this->session->userdata('subject_id');	
			}else{
			$subject_id=$resume_usertestinfo->subject_id;
     		$this->session->set_userdata('subject_id', $subject_id);
			}
			
			//chapter_id
			
	$chapter_id = $this->session->userdata('chapter_id');
	if(isset($chapter_id)&&$chapter_id>0){
			  $chapter_id = $this->session->userdata('chapter_id');	
			}else{
			$chapter_id=$resume_usertestinfo->chapter_id;
     		$this->session->set_userdata('chapter_id', $chapter_id);
			}
			//onlinetest_id
			$onlinetest_id = $this->session->userdata('onlinetest_id');
			if(isset($onlinetest_id)&&$onlinetest_id>0){
			$onlinetest_id = $this->session->userdata('onlinetest_id');	
			}else{
			$onlinetest_id=$resume_usertestinfo->test_id;
     		$this->session->set_userdata('onlinetest_id', $onlinetest_id);
			}
			//total_question
			$total_question = $this->session->userdata('total_question');
			if(isset($total_question)&&$total_question>0){
			$total_question = $this->session->userdata('total_question');	
			}else{
			$total_question=$resume_usertestinfo->total_qus;
     		$this->session->set_userdata('total_question', $total_question);
			}
			//total_time
			$total_time = $this->session->userdata('total_time');
			if(isset($total_time)&&$total_time>0){
			$total_time = $this->session->userdata('total_time');	
			}else{
			$total_time=$resume_usertestinfo->total_time;
     		$this->session->set_userdata('total_time', $total_time);
			}
			
			//time_remaining
			if(isset($time_remaining)&&$time_remaining>0){
			$time_remaining = $time_remaining;	
			}else{
			$time_remaining=$resume_usertestinfo->time_remaining;
			}
			//time_remaining
			$session_time_remaining = $this->session->userdata('time_remaining');
			if(!isset($session_time_remaining)){
     		$this->session->set_userdata('time_remaining', $time_remaining);
			echo 'In if';
			}
			//formula_id
			$formula_id = $this->session->userdata('formula_id');
			if(isset($formula_id)&&$formula_id>0){
			$formula_id = $this->session->userdata('formula_id');	
			}else{
			$formula_id=$resume_usertestinfo->formula_id;
     		$this->session->set_userdata('formula_id', $formula_id);
			}
			//get formula detail
            $formula_info = $this->Onlinetest_model->formula_detail($formula_id);
            $right_answer_marks = $formula_info->right_answer_marks;
            $wrong_answer_marks = $formula_info->wrong_answer_marks;
            $total_marks=$right_answer_marks*$total_question;            
        }
        $usertest_id = $this->session->userdata('usertest_id');
        
            if(isset($usertest_id)&&$usertest_id>0){
                $this->data['usertest_id'] = $usertest_id;
            }else{
                $this->data['usertest_id'] = 0;
            }
        if (!isset($onlinetest_id)) {
            $this->session->set_flashdata('massage', 'Please try again.Test Id not found.');
            redirect('online-test');
        }
        $current_user_id = $this->session->userdata('current_user_id');
        if (!isset($current_user_id) && ($current_user_id == '')) {
            $current_user_id = $this->session->set_userdata('current_user_id', $customer_id);
        }

        //echo $examid.'-=-=';die;
       //$onlinetest=$this->Onlinetest_model->getOnlineTests($exam_id,$subject_id,$chapter_id);
      //$this->data['onlinetest']=$onlinetest;
        $onlinetestinfo = $this->Onlinetest_model->detail($onlinetest_id);
        /*Get marks formula*/
        if(isset($onlinetestinfo->formula_id)&&$onlinetestinfo->formula_id>0){
        $formulla_array=$this->Onlinetest_model->formula_detail($onlinetestinfo->formula_id);
        $right_answer_marks=$formulla_array->right_answer_marks;
        $wrong_answer_marks=$formulla_array->wrong_answer_marks;
        }else{
        $right_answer_marks=0;
        $wrong_answer_marks=0;
        }
        $this->data['right_answer_marks']=$right_answer_marks;
        $this->data['wrong_answer_marks']=$wrong_answer_marks;
        $this->data['onlinetestinfo'] = $onlinetestinfo;
        $onlinequestioninfo = $this->Onlinetest_model->getolQuestion($onlinetest_id);
        $q_count = 1;
        $question_answer_array =array();
        foreach ($onlinequestioninfo as $questioninfo) {
            $question_id = $questioninfo->question_id;
            $question = $questioninfo->question;
            $qustion_instructions_id = $questioninfo->instructions_id;
            $ol_qus_marks=0;
            if(isset($questioninfo->marks)){
                $ol_qus_marks=$questioninfo->marks;
            }
            $this->data['qustion_instructions_id'] = $qustion_instructions_id;
            if ($qustion_instructions_id > 0) {
                $instruction_detail = $this->Onlinetest_model->detail($onlinetest_id);
                $this->data['instruction_detail'] = $instruction_detail->instructions;
            } else {
                $this->data['instruction_detail'] = '';
            }
            $onlineanswerinfo = $this->Onlinetest_model->getAnswerByQuestion($question_id);
            $a_count = 1;
            $id_count=1;
            if ($onlineanswerinfo) {
                foreach ($onlineanswerinfo as $answerinfo) {
                    if (isset($answerinfo->answer)) {
                        $answer_array[$question_id][$a_count] = $answerinfo->answer;
                        $a_count++;
                    }
                }                
                 foreach ($onlineanswerinfo as $answeridinfo) {
                    if (isset($answeridinfo->id)) {
                        $answerid_array[$question_id][$id_count] = $answeridinfo->id;
						$answerid_selection_array[$question_id][$id_count]=$answeridinfo->users_answer;
						
                        $id_count++;
                    }
                }
            }
            $question_answer_array[$q_count] = array(
                'onlinetest_id' => $questioninfo->onlinetest_id,
                'question_id' => $question_id,
                'question' => $question,
                'qus_marks' => $ol_qus_marks,
                'type' => $questioninfo->type,
                'type_extra' => $questioninfo->type_extra,
                'section' => $questioninfo->section,
                'section_name' => $questioninfo->section_name,
                'instructions_id' => $questioninfo->instructions_id,
                'qus_formula_id' => $questioninfo->qus_formula_id,
                'description' => $questioninfo->description,
                'answer_extra' => $questioninfo->answer_extra,
                'answer_array' => $answer_array,
               'answerid_array' => $answerid_array,
               'answerid_selection_array' => $answerid_selection_array,
                'calculator' => $questioninfo->calculator
            );
            $q_count++;
        }
        $this->data['var_single_choice'] = $this->config->item('var_single_choice');
        $this->data['var_grid_single_choice'] = $this->config->item('var_grid_single_choice');
        $this->data['var_multiple_choice'] = $this->config->item('var_multiple_choice'); $this->data['var_grid_multiple_choice'] = $this->config->item('var_grid_multiple_choice');
        $this->data['var_fill_in_the_blanks'] = $this->config->item('var_fill_in_the_blanks');
        $this->data['var_match_the_column'] = $this->config->item('var_match_the_column');
        $this->data['right_answer_marks']=$right_answer_marks;
        $this->data['wrong_answer_marks']=$wrong_answer_marks;
        $this->data['total_question']=$total_question;
        $this->data['test_id']=$onlinetest_id;
		$this->data['customer_name']=$customer_name;
		$this->data['time_remaining']=$time_remaining;
        if(is_array($question_answer_array)){
        $this->data['question_answer_array'] = $question_answer_array;
        }else{
        $this->data['question_answer_array'] =''; 
        }
        $this->data['content'] = 'exam_paper';
        $this->load->view('template_onlinetest', $this->data);
    }
	
	public function androidusernotfound(){
	    $this->data['content'] = 'androidusernotfound';
        $this->load->view('template_mid', $this->data);
    	
	}
	
public function androidindex($exam_id,$subject_id,$chapter_id=0,$onlinetest_id,$total_time,$total_question,$formula_id,$customer_id){
$urlcust_array=explode('-encid-',$customer_id);
		$customer_name = 'Student'; 
		if(isset($urlcust_array[1])){
		$customer_id=base64_decode($urlcust_array[1]);
        $this->load->model('Customer_model');
		$custInfo=$this->Customer_model->getDetails($customer_id);
		$customer_name=$custInfo->firstname;
		}else{
		$customer_id=0;
		}	
        $exam_id = $exam_id;
        $subject_id = $subject_id;
        $chapter_id = $chapter_id;
        $onlinetest_id = $onlinetest_id;
        $total_question = $total_question;
        $total_time = $total_time;
        $formula_id = $formula_id;
        $current_time = time();
        $current_exam_timestamp = $this->session->userdata('current_exam_timestamp');
        if (!isset($current_exam_timestamp) && ($current_exam_timestamp == '')) {
            $this->session->set_userdata('current_exam_timestamp', $current_time);
        }
    if (($customer_id == '') || ($customer_id < 1)) {
          redirect('apponline-test/androidusernotfound');
            }
            
        if (isset($onlinetest_id)) {
            $this->session->set_userdata('exam_id', $exam_id);
            $this->session->set_userdata('subject_id', $subject_id);
            $this->session->set_userdata('chapter_id', $chapter_id);
            $this->session->set_userdata('onlinetest_id', $onlinetest_id);
            $this->session->set_userdata('total_question', $total_question);
            $this->session->set_userdata('total_time', $total_time);
            $this->session->set_userdata('formula_id', $formula_id);

            $current_exam_timestamp = $this->session->userdata('current_exam_timestamp');
            if (!isset($current_exam_timestamp) && ($current_exam_timestamp == '')) {
            $this->session->set_userdata('current_exam_timestamp', $current_time);
            }
            if (($customer_id == '') || ($customer_id < 1)) {
                      redirect('apponline-test/androidusernotfound');
            }
            //get formula detail
            $formula_info = $this->Onlinetest_model->formula_detail($formula_id);
            $right_answer_marks = $formula_info->right_answer_marks;
            $wrong_answer_marks = $formula_info->wrong_answer_marks;
            $total_marks=$right_answer_marks*$total_question;
            $usertest_data = array(
                'user_id' => $customer_id,
                'test_id' => $onlinetest_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'right_answer_marks' => $right_answer_marks,
                'wrong_answer_marks' => $wrong_answer_marks,               
                'total_time' => $total_time,
                'total_marks'=> $total_marks,
                'formula_id' => $formula_id,
                'total_qus'  => $total_question,
                'status'     => 0,
				'start_time' =>date("h:i a"),
				'conducted_by' => 'studyadda',
                'conducted_in' => 'app',
                'dt_created' => $current_time
            );
            $usertest_id = $this->Onlinetest_model->add_user_testdata($usertest_data);
            $this->session->set_userdata('usertest_id', $usertest_id);
        } else {
            $exam_id = $this->session->userdata('exam_id');
            $subject_id = $this->session->userdata('subject_id');
            $chapter_id = $this->session->userdata('chapter_id');
            $onlinetest_id = $this->session->userdata('onlinetest_id');
            $total_question = $this->session->userdata('total_question');
            $total_time = $this->session->userdata('total_time');
            $formula_id = $this->session->userdata('formula_id');
            //get formula detail
            $formula_info = $this->Onlinetest_model->formula_detail($formula_id);
            $right_answer_marks = $formula_info->right_answer_marks;
            $wrong_answer_marks = $formula_info->wrong_answer_marks;
            $total_marks=$right_answer_marks*$total_question;            
        }
        $usertest_id = $this->session->userdata('usertest_id');
        if(isset($usertest_id)&&$usertest_id>0){
                $this->data['usertest_id'] = $usertest_id;
            }else{
                $this->data['usertest_id'] = 0;
            }
        if (!isset($onlinetest_id)) {
            $this->session->set_flashdata('massage', 'Please try again.Test Id not found.');
            redirect('online-test');
        }
        $current_user_id = $this->session->userdata('current_user_id');
        if (!isset($current_user_id) && ($current_user_id == '')) {
            $current_user_id = $this->session->set_userdata('current_user_id', $customer_id);
        }

        //echo $examid.'-=-=';die;
       //$onlinetest=$this->Onlinetest_model->getOnlineTests($exam_id,$subject_id,$chapter_id);
      //$this->data['onlinetest']=$onlinetest;
        $onlinetestinfo = $this->Onlinetest_model->detail($onlinetest_id);
        /*Get marks formula*/
        if(isset($onlinetestinfo->formula_id)&&$onlinetestinfo->formula_id>0){
        $formulla_array=$this->Onlinetest_model->formula_detail($onlinetestinfo->formula_id);
        $right_answer_marks=$formulla_array->right_answer_marks;
        $wrong_answer_marks=$formulla_array->wrong_answer_marks;
        }else{
        $right_answer_marks=0;
        $wrong_answer_marks=0;
        }
        $this->data['right_answer_marks']=$right_answer_marks;
        $this->data['wrong_answer_marks']=$wrong_answer_marks;
        $this->data['onlinetestinfo'] = $onlinetestinfo;
        $onlinequestioninfo = $this->Onlinetest_model->getolQuestion($onlinetest_id);
		if(count($onlinequestioninfo)<1){
			die('No question found!');
		}
        $q_count = 1; 
        $question_answer_array =array();
		
        foreach ($onlinequestioninfo as $questioninfo) {
            $question_id = $questioninfo->question_id;
            $question = $questioninfo->question;
            $qustion_instructions_id = $questioninfo->instructions_id;
            $ol_qus_marks=0;
            if(isset($questioninfo->marks)){
                $ol_qus_marks=$questioninfo->marks;
            }
            $this->data['qustion_instructions_id'] = $qustion_instructions_id;
            if ($qustion_instructions_id > 0) {
                $instruction_detail = $this->Onlinetest_model->detail($onlinetest_id);
                $this->data['instruction_detail'] = $instruction_detail->instructions;
            } else {
                $this->data['instruction_detail'] = '';
            }
            $onlineanswerinfo = $this->Onlinetest_model->getAnswerByQuestion($question_id);
            $a_count = 1;
            $id_count=1;
            if ($onlineanswerinfo) {
                foreach ($onlineanswerinfo as $answerinfo) {
                    if (isset($answerinfo->answer)) {
                        $answer_array[$question_id][$a_count] = $answerinfo->answer;
                        $a_count++;
                    }
                }                
                 foreach ($onlineanswerinfo as $answeridinfo) {
                    if (isset($answeridinfo->id)) {
                        $answerid_array[$question_id][$id_count] = $answeridinfo->id;
                        $id_count++;
                    }
                }
            }
            $question_answer_array[$q_count] = array(
                'onlinetest_id' => $questioninfo->onlinetest_id,
                'question_id' => $question_id,
                'question' => $question,
                'qus_marks' => $ol_qus_marks,
                'type' => $questioninfo->type,
                'type_extra' => $questioninfo->type_extra,
                'section' => $questioninfo->section,
                'section_name' => $questioninfo->section_name,
                'instructions_id' => $questioninfo->instructions_id,
                'description' => $questioninfo->description,
                'qus_formula_id' => $questioninfo->qus_formula_id,
                'answer_extra' => $questioninfo->answer_extra,
                'answer_array' => $answer_array,
               'answerid_array' => $answerid_array
            );
            $q_count++;
        }
        $this->data['var_single_choice'] = $this->config->item('var_single_choice');
        $this->data['var_grid_single_choice'] = $this->config->item('var_grid_single_choice');
        $this->data['var_multiple_choice'] = $this->config->item('var_multiple_choice');$this->data['var_grid_multiple_choice'] = $this->config->item('var_grid_multiple_choice');
        $this->data['var_fill_in_the_blanks'] = $this->config->item('var_fill_in_the_blanks');
        $this->data['var_match_the_column'] = $this->config->item('var_match_the_column');
        $this->data['right_answer_marks']=$right_answer_marks;
        $this->data['wrong_answer_marks']=$wrong_answer_marks;
        $this->data['total_question']=$total_question;
        $this->data['test_id']=$onlinetest_id;
		$this->data['usertest_id']=$usertest_id;
        if(is_array($question_answer_array)){
        $this->data['question_answer_array'] = $question_answer_array;
        }else{
        $this->data['question_answer_array'] =''; 
        }
        $this->data['current_user_id'] = $customer_id;
        $this->data['customer_id'] = $customer_id;
		$this->data['customer_name'] = $customer_name;
        $this->data['content'] = 'appexam_paper';
        $this->load->view('template_onlinetest', $this->data);
    }
    public function save_qus() {
        $question_type = $this->input->post('qtype');
        $question_id = $this->input->post('qid');
        $users_answerPost = $this->input->post('users_answer');
        $test_id = $this->input->post('test_id');
        $usertest_id = $this->input->post('usertest_id');
        $question_action = $this->input->post('qaction');
        $perclick_time_spent = $this->input->post('perclick_time_spent');
        $question_marks = $this->input->post('question_marks');
		if($question_marks==null||$question_marks==NULL){
		$question_marks=0;	
		}
		$user_marks = $this->input->post('user_marks');
		if($user_marks==null||$user_marks==NULL){
		$user_marks=0;	
		}		
		$uans_laststr=substr($users_answerPost, -1); 
		if($uans_laststr=='.'){
		$uapieces = explode(".", $users_answerPost);
		
if(isset($uapieces[0])){
	$users_answer=$uapieces[0]; 
}else{
	$users_answer=$users_answerPost; 
}
		}else{
	$users_answer=$users_answerPost;
		}
        $qaction = $this->input->post('qaction');
        //$customer_id = $this->session->userdata('current_user_id');
		
        $testinfo_byid = $this->Onlinetest_model->get_testinfo_byid($usertest_id);
		if(isset($testinfo_byid->user_id)&&$testinfo_byid->user_id>0){
		$customer_id=$testinfo_byid->user_id;
		}else{
			die('Customer Id not Exist on line number 431');
		}
		$response['question_type'] = $question_type;
        $response['question_id'] = $question_id;
        $response['test_id'] = $test_id;
        $response['usertest_id'] = $usertest_id;
        $response['question_action'] = $question_action;
        $response['customer_id'] = $customer_id;
        $var_single_choice = $this->config->item('var_single_choice');
        $var_grid_single_choice = $this->config->item('var_grid_single_choice');
        $var_multiple_choice = $this->config->item('var_multiple_choice');
		$var_grid_multiple_choice = $this->config->item('var_grid_multiple_choice');
        $var_fill_in_the_blanks = $this->config->item('var_fill_in_the_blanks');
        $var_match_the_column = $this->config->item('var_match_the_column');
        $this->data['var_single_choice'] = $var_single_choice;
		$this->data['var_grid_single_choice'] = $var_grid_single_choice;
		$this->data['var_multiple_choice'] = $var_multiple_choice;  
		$this->data['var_grid_multiple_choice'] = $var_grid_multiple_choice;
        $this->data['var_fill_in_the_blanks'] = $var_fill_in_the_blanks;
        $this->data['var_match_the_column'] = $var_match_the_column;

        //$this->user_qusans_array =array($question_id=>array('question_type'=>$question_type));
        //$this->session->set_userdata('contans', $this->user_qusans_array);        
        if (!isset($users_answer)) {
            $users_answer = '';
        }
        //get  answer Info by questionid 
        $questions_answer = $this->Onlinetest_model->getCorrectAns($question_id);
        $correct_answer_string = '';
        $questions_answer_cnt = count($questions_answer);
        
        $result_answer='';
        
        $date = time();
        if (is_array($users_answer)) {
            $users_answer_string = serialize($users_answer);
        } else {
            $users_answer_string = trim($users_answer);
        }    
        if ($question_type == $var_single_choice) {
            $mtb_final_string = '';
            for ($i = 0; $questions_answer_cnt > $i; $i++) {
                $questions_answer_var = $questions_answer[$i]->is_correct;
                if ($questions_answer_var > 0) {
                    $mtb_final_string = trim($questions_answer[$i]->id);
                    $correct_answer_id_final_string =$questions_answer[$i]->id;
                }
            }

            $correct_answer_string = $mtb_final_string;
            //$correct_answer_id_string = $correct_answer_id_final_string;
            
            if($users_answer_string==$correct_answer_string){
            
            $result_answer=1;
        }else{
             $result_answer=0;
        }
            
        }elseif($question_type == $var_grid_single_choice){
			//for var_grid_single_choice
			    $mtb_final_string = '';
            for ($i = 0; $questions_answer_cnt > $i; $i++) {
                $questions_answer_var = $questions_answer[$i]->is_correct;
                if ($questions_answer_var > 0) {
                    $mtb_final_string = trim($questions_answer[$i]->id);
                    $correct_answer_id_final_string =$questions_answer[$i]->id;
                }
            }

            $correct_answer_string = $mtb_final_string;
            //$correct_answer_id_string = $correct_answer_id_final_string;
            
            if($users_answer_string==$correct_answer_string){
            
            $result_answer=1;
        }else{
             $result_answer=0;
        }
        
			
		} else if ($question_type == $var_multiple_choice) {

            $mtb_final_array = array();
            for ($i = 0; $questions_answer_cnt > $i; $i++) {
                $questions_answer_var = $questions_answer[$i]->is_correct;
                if ($questions_answer_var > 0) {
                    $mtb_final_array[] = trim($questions_answer[$i]->id);
                    //$correct_answer_id_array[]= $questions_answer[$i]->id;
                }
            }
            //$correct_answer_id_string =serialize($correct_answer_id_array); 
            $correct_answer_string = serialize($mtb_final_array);
            if($users_answer_string==$correct_answer_string){
            
            $result_answer=1;
        }else{
             $result_answer=0;
        }        
        }elseif($question_type == $var_grid_multiple_choice){
			//for var_grid_multiple_choice
            $mtb_final_array = array();
            for ($i = 0; $questions_answer_cnt > $i; $i++) {
                $questions_answer_var = $questions_answer[$i]->is_correct;
                if ($questions_answer_var > 0) {
                    $mtb_final_array[] = trim($questions_answer[$i]->id);
                    //$correct_answer_id_array[]= $questions_answer[$i]->id;
                }
            }
            //$correct_answer_id_string =serialize($correct_answer_id_array); 
            $correct_answer_string = serialize($mtb_final_array);
            if($users_answer_string==$correct_answer_string){
            
            $result_answer=1;
        }else{
             $result_answer=0;
        } 
			
		} else if ($question_type == $var_fill_in_the_blanks) {
			
			if($questions_answer_cnt>=0){
				$correct_answer_string = trim($questions_answer[0]->answer);
			}else{
            $correct_answer_string = trim($questions_answer->answer);
			}		
			
            //$correct_answer_id_string = '';
            
            if($users_answer_string==$correct_answer_string){
            $result_answer=1;
            }else{
            $result_answer=0;
            }
        } else if ($question_type == $var_match_the_column) {
            
            
            /*
            $mtb_final_array = array();
            for ($i = 0; $questions_answer_cnt > $i; $i++) {
                $mtb_array = array();
                $questions_answer_var = trim($questions_answer[$i]->answer_extra);
                $questions_answer_arr = explode(',', $questions_answer_var);
                for ($j = 0; count($questions_answer_arr) > $j; $j++) {
                    $mtb_array[] = $questions_answer_arr[$j];
                }
                $mtb_final_array[$i] = $mtb_array;
                
                   // $correct_answer_id_string ='';
            }  $correct_answer_string = serialize($mtb_final_array);
            */
            
          
        
            //$uns = unserialize($mtb_final_string);
            
                for ($i = 0; count($questions_answer) > $i; $i++) {
                //$correct_ans_array = array();                
                $correct_ans_array[] = trim($questions_answer[$i]->description);               
                }
            $correct_answer_string= serialize($correct_ans_array);           
            $mtb_users_answer=array();
             for ($jk = 0; count($users_answer) > $jk; $jk++) {
                 if(isset($users_answer[$jk][0])){
                    $mtb_users_answer[] = $users_answer[$jk][0];
                 }
                 
                 }
                 
            if(is_array($mtb_users_answer)&&count($mtb_users_answer)){
            $users_answer_string=serialize($mtb_users_answer);
            }else{
          $users_answer_string='';      
            }
            if($users_answer_string==$correct_answer_string){
            $result_answer=1;
            }else{
            $result_answer=0;
            }         
        }
        if(($qaction=='review_paper_submit')||($qaction=='review_submit')){
            $result_answer='2'; 
            //$users_answer_string ='';
            //$correct_answer_string='';
        }
        $flag_usertest_array = $this->Onlinetest_model->get_userqus_detail($customer_id, $test_id, $usertest_id, $question_id);
        //For self assessment functionality
        if($user_marks>0){
        $result_answer=1;
        }
        
        $usertest_detail_one = array(
            'usertest_id' => $usertest_id,
            'question_id' => $question_id,
            'question_type' => urldecode($question_type),
            'users_answer' => $users_answer_string,
            //'users_answer_id' => $users_answer_string,
            'correct_answer' => trim($correct_answer_string),
            //'correct_answer_id'=>$correct_answer_id_string,
            'is_correct' =>$result_answer,
			'action_type' =>$qaction,
            'perclick_time_spent' => $perclick_time_spent,
            'questionmarks'=>$question_marks,
            'usermarks'=>$user_marks
            
        );
        if (isset($flag_usertest_array[0]->id)) {
            $flag_usertest_id = $flag_usertest_array[0]->id;
        } else {
            $flag_usertest_id = 0;
        }
        if (isset($flag_usertest_id) && ($flag_usertest_id > 0)) {

            $usertest_detail_two = array(
                'dt_modified' => $date
            );
            $usertest_detail_data = array_merge($usertest_detail_one, $usertest_detail_two);
            $this->Onlinetest_model->edit_usertest_detail($flag_usertest_id, $usertest_detail_data);
        } else {

            $usertest_detail_two = array(
                'dt_created' => $date
            );

            $usertest_detail_data = array_merge($usertest_detail_one, $usertest_detail_two);
            $this->Onlinetest_model->add_usertest_detail($usertest_detail_data);
        }

        echo json_encode($response);
    }

    public function submit_paper() {
        $test_id = $this->input->post('test_id');
        $usertest_id = $this->input->post('usertest_id');
        $time_remaining_string = $this->input->post('time_remainig');
        $total_time = $this->input->post('total_time');
        $right_answer_marks = $this->input->post('right_answer_marks'); 
        $wrong_answer_marks = $this->input->post('wrong_answer_marks');
        $total_question = $this->input->post('total_question');
        $time_remaining_array = explode(':', $time_remaining_string);
        $rm_hours = $time_remaining_array[0];
        $rm_minits = $time_remaining_array[1];
        $rm_seconds = $time_remaining_array[2];
        $time_remaining = $rm_hours * 3600 + $rm_minits * 60 + $rm_seconds;
        $time_taken = $total_time - $time_remaining;
		//$getRightMarksarray =  $this->Onlinetest_model->getRightAnswerMarks($usertest_id);

$getRightMarksarray =  $this->Onlinetest_model->reportRightAns($usertest_id);		
       $countRightAnswer = $getRightMarksarray->rightanswer;
       $total_right_answer_marks = $countRightAnswer*$right_answer_marks;
       
       //$getWrongMarksarray =  $this->Onlinetest_model->getwrongAnswerMarks($usertest_id);
	   $getWrongMarksarray =  $this->Onlinetest_model->reportWrongAns($usertest_id);
       
       $countwrongAnswer = $getWrongMarksarray->wronganswer;
        
       $total_wrong_answer_marks = $countwrongAnswer*$wrong_answer_marks;
       
       //$getReviewdQuestionarray =  $this->Onlinetest_model->getReviewdQuestion($usertest_id);
	         $getReviewdQuestionarray =  $this->Onlinetest_model->reportReviewdQue($usertest_id);
       $reviedQuestion = $getReviewdQuestionarray->revied;
       
       $obtain_marks = $total_right_answer_marks-$total_wrong_answer_marks;
       
       $getAttamptedQuestionarray =  $this->Onlinetest_model->reportAttmQue($usertest_id);
	   //not attampts should not be type 2 and user answer must b 
 //$getNotAttampQuearr[0] =  $this->Onlinetest_model->getNotattamptedQuestion($usertest_id);
       $attamptedQuestion = $getAttamptedQuestionarray->attampted;
       $not_attqus=$total_question-$attamptedQuestion;
       //$not_attampted_qus=$not_attqus-$reviedQuestion;
	   $not_attampted_qus=$not_attqus;
        $usertest_data = array(
            'time_remaining' => $time_remaining,
            'time_taken' => $time_taken,
            'obtain_marks' => $obtain_marks,
            'reviewed_qus' =>$reviedQuestion,
            'attampted_ques' =>$attamptedQuestion,
            'not_attampted_qus' =>abs($not_attampted_qus),
            'correct_ans' =>$countRightAnswer ,
            'incorrect_ans' =>$countwrongAnswer,
            'status'=>1,
			'end_time'=>date("h:i a")
        );          
        $this->Onlinetest_model->update_user_testdata($usertest_id, $usertest_data);
    }

    public function cleare_answer() {
        $exam_id = $this->input->post('exam_id');
        $qus_id = $this->input->post('qus_id');
        $this->Onlinetest_model->remove_userans($exam_id, $qus_id);
    }
    
    public function appQuesInfo($qid) {
        $oe_question = $this->Onlinetest_model->appquesinfo($qid); 
        $this->data['oe_question']=$oe_question;
        $this->data['content']='app_exam_paper';
            $this->data['loadMathJax']='YES';
	$this->load->view('template_mid',$this->data);
    }
	public function appansinfo($ansid) {
        $oe_answer = $this->Onlinetest_model->getAns($ansid); 
        $this->data['oe_answer']=$oe_answer;
        $this->data['content']='app_exam_ans';
            $this->data['loadMathJax']='YES';
	$this->load->view('template_mid',$this->data);
    }
        
    public function app_paper($qid) {
        $oe_question = $this->Onlinetest_model->appquesinfo($qid);
        $oe_qAnswer=$this->Onlinetest_model->getAnswerByQuestion($qid);
        $this->data['oe_question']=$oe_question;
        $this->data['oe_answer']=$oe_qAnswer;
        $this->data['content']='app_exam_queans';
        $this->data['loadMathJax']='YES';
	$this->load->view('template_mid',$this->data);
    }
	
    public function androidtest_result($testid=0,$userstestid=0) { 
        $this->load->model('File_model');
        $this->load->model('Pricelist_model');
//https://www.studyadda.com/apponline-test/result/1098 
        if($userstestid>0){
        $usertest_info = $this->Onlinetest_model->get_testinfo_byid($userstestid);
        }else{
        $usertest_info=array();
        }
    
        if(isset($testid)&&$testid>0){
            $testid=$testid;
        }else{
            die('OnlineTest Id is not available. '); 
        }
        
        
        $onlinetest_info=$this->Onlinetest_model->detail_with_relation($testid);
        /*Get PDF file infornmation */
        $ot_filedetail = $this->File_model->detail($onlinetest_info->file_id);
        
        if(isset($usertest_info)&&count($usertest_info)>0){
        $user_id=$usertest_info->user_id; //
        if($this->session->userdata('customer_id') != $user_id){
           // redirect('/customer');
        $user_id=0;
        }
		
        $attempts=$this->Onlinetest_model->getAttempts($usertest_info->test_id,$user_id);
		}else{
		$attempts=NULL;
		}
        
        $sections=array();
        $this->data['attempts']=$attempts;  
        $this->data['ot_filedetail']=$ot_filedetail; 
       
            
            $onlinequestioninfo = $this->Onlinetest_model->getolQuestion($testid);
        if(isset($onlinequestioninfo)){
            $this->data['totalquestions']=count($onlinequestioninfo);
        }else{
            $this->data['totalquestions']=0;
        }
            $total_qus_cnt = 0;
            $attempted_qus_cnt = 0;
            $correct_question = 0;
            $qcount=0;
            $this->load->model('Questions_model');
            //foreach ($usertest_detail as $usertest_val) {
            foreach ($onlinequestioninfo as $usertest_val) {
                $useranswer_data=$this->Onlinetest_model->getUserAnswerData($testid,$usertest_val->question_id);
                //print_r($useranswer_data);print_r($usertest_val);
                //die();
                $answers=$this->Questions_model->answers($usertest_val->question_id);
                $quesdetails=(array)$usertest_val;
                $quesdetails['timetaken']=0;
                $quesdetails['answered_correctly']=0;
                $quesdetails['answers']=$answers;
                if(array_key_exists($usertest_val->section_name, $sections)){
                    $sections[$usertest_val->section_name]['questions'][$qcount]=$quesdetails;       
                }else{
                    $sections[$usertest_val->section_name]['questions'][$qcount]=$quesdetails;
                    $sections[$usertest_val->section_name]['timetaken']=0;
                    $sections[$usertest_val->section_name]['attempted']=0;
                    $sections[$usertest_val->section_name]['not_attempted']=0;
                    $sections[$usertest_val->section_name]['correct']=0;
                    $sections[$usertest_val->section_name]['incorrect']=0;
                }
                if($useranswer_data && $useranswer_data->users_answer != '') {
                   
                    $attempted_qus_cnt++;
                    $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=0;
                    //$sections[$usertest_val->section_name]['attempted']=$sections[$usertest_val->section_name]['attempted']+1;
                }else{
                    //$sections[$usertest_val->section_name]['not_attempted']=$sections[$usertest_val->section_name]['not_attempted']+1;
                    $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=2;
                }
                if($useranswer_data){
                    $timetaken=$useranswer_data->perclick_time_spent;
                    
                    sscanf($timetaken, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $sections[$usertest_val->section_name]['timetaken']= $sections[$usertest_val->section_name]['timetaken']+$time_seconds;
                $var_single_choice = $this->config->item('var_single_choice');$var_grid_single_choice = $this->config->item('var_grid_single_choice');
                $var_multiple_choice = $this->config->item('var_multiple_choice');
				$var_grid_multiple_choice = $this->config->item('var_grid_multiple_choice');
                $var_fill_in_the_blanks = $this->config->item('var_fill_in_the_blanks');
                $var_match_the_column = $this->config->item('var_match_the_column');
                //CHECK For radeo button single choice
                if($usertest_val->type == ($var_single_choice||$var_grid_single_choice)) {
                    
                    if ( (trim($useranswer_data->users_answer) == trim($useranswer_data->correct_answer)) && ($useranswer_data->users_answer != '') && ($useranswer_data->correct_answer != '')) {
                        $correct_question++;
                        $sections[$usertest_val->section_name]['correct']=$sections[$usertest_val->section_name]['correct']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
                    }else{
                        $sections[$usertest_val->section_name]['incorrect']=$sections[$usertest_val->section_name]['incorrect']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=0;
                    }
                    $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                      $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                      $a_opt='A';
                      $user_ans_array=array();
                      foreach($answers as $ans){
                          $userans_id=trim($useranswer_data->users_answer);
                         if($ans->id==$userans_id){
                    $user_answers_array=$this->Questions_model->answers_byid($userans_id);
                    $user_ans_array[$a_opt] = $user_answers_array[0]->answer ;  
                        //$user_ans_array[$a_opt] = '' ; 
                         }
                          
                      $a_opt++;     
                      }
                      
                      $sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;   
                }
                
                //CHECK For checkbox Multiple choice
                if ($usertest_val->type == ($var_multiple_choice||$var_grid_multiple_choice)) {
                    
                    $users_answer_clean_array = unserialize($useranswer_data->users_answer);
                    if(isset($users_answer_clean_array)&&$users_answer_clean_array!=''){
                        $users_answer_array=$users_answer_clean_array;
                    }else{
                        $users_answer_array=array();
                    }
                    $correct_answer_array = unserialize($useranswer_data->correct_answer);
                    if (is_array($users_answer_array)) {
                        $users_answer_comma_separated = implode("|", $users_answer_array);
                    } else {
                        $users_answer_comma_separated = $users_answer_array;
                    }
                    if (is_array($correct_answer_array)) {
                        $correct_answer_comma_separated = implode("|", $correct_answer_array);
                    } else {
                        $correct_answer_comma_separated = $correct_answer_array;
                    }
                    if ((trim($users_answer_comma_separated) == trim($correct_answer_comma_separated)) && ($users_answer_comma_separated != '') && ($correct_answer_comma_separated != '')) {
                        $correct_question++;
                        $sections[$usertest_val->section_name]['correct']=$sections[$usertest_val->section_name]['correct']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
                    }else{
                        $sections[$usertest_val->section_name]['incorrect']=$sections[$usertest_val->section_name]['incorrect']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=0;
                    }
                    $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                     $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                      $a_opt='A';
                      $user_ans_array=array();
                      foreach($answers as $ans){     
                    if( in_array($ans->id, $users_answer_array)){
                    $userans_id=$ans->id;    
                    $user_answers_array=$this->Questions_model->answers_byid($userans_id);
                    $user_ans_array[$a_opt] = $user_answers_array[0]->answer ;
                    //$user_ans_array[$a_opt] = '' ;
                         }
                      $a_opt++;     
                      }                      
                      
                    $sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;
                }

                //CHECK For Fill in the blanks
                if ($usertest_val->type == $var_fill_in_the_blanks) {
                    if ((trim($useranswer_data->users_answer) == trim($useranswer_data->correct_answer)) && ($useranswer_data->users_answer != '') && ($useranswer_data->correct_answer != '')) {
                        $correct_question++;
                        $sections[$usertest_val->section_name]['correct']=$sections[$usertest_val->section_name]['correct']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
                    }else{
                        $sections[$usertest_val->section_name]['incorrect']=$sections[$usertest_val->section_name]['incorrect']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=0;
                    }
                     $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                       $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                      
                      $a_opt='A';
                      $user_ans_array=array();                      
                      foreach($answers as $ans){
                          $userans_id=trim($useranswer_data->users_answer);
                           $test_answer=trim($ans->answer);
                    $user_ans_array[$a_opt] = $userans_id ;                     
                           $a_opt++;     
                      }
                      $sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;   
                }

                //CHECK For Match The Column
                if ($usertest_val->type == $var_match_the_column) {

                    $flag_diff = 'no';
                    
                    $users_answer_array = unserialize($useranswer_data->users_answer);
                    $correct_answer_array = unserialize($useranswer_data->correct_answer);
                    if(isset($correct_answer_array)){
                    $correct_answer_count = count($correct_answer_array);
                    }else{
                      $correct_answer_count=0;  
                    }
                    for ($in = 0; $correct_answer_count > $in; $in++) {
                        $count_user_inner = 0;
                        $count_correct_inner = 0;
                        if (isset($correct_answer_array[$in])) {
                            $count_correct_inner = count($correct_answer_array[$in]);
                        }
                        if (isset($users_answer_array[$in])) {
                            $count_user_inner = count($users_answer_array[$in]);
                        }


                        if ($count_correct_inner == $count_user_inner) {
                            /* $result_diffrence = array_diff($correct_answer_array[$in], $users_answer_array[$in]);
                             * */
                            if(is_array($correct_answer_array[$in])){
                            $implode_correct = implode('|', $correct_answer_array[$in]);
                            }else{
                            $implode_correct = $correct_answer_array[$in];
                            }
                            if(is_array($users_answer_array[$in])){
                            $implode_user = implode('|', $users_answer_array[$in]);
                            }else{
                            $implode_user = $users_answer_array[$in];
                            }
                            if (trim($implode_correct) == trim($implode_user)) {
                                $result_diffrence = 0;
                            } else {
                                $result_diffrence = 1;
                            }
                        } else {
                            $result_diffrence = 1;
                        }
                        if ($result_diffrence > 0) {
                            $flag_diff = 'yes';
                        }
                    }
                
                    if ($flag_diff == 'no') {
                        $correct_question++;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
                        $sections[$usertest_val->section_name]['correct']=$sections[$usertest_val->section_name]['correct']+1;
                    }else{
                        $sections[$usertest_val->section_name]['incorrect']=$sections[$usertest_val->section_name]['incorrect']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=0;
                    }
                    
                    if(is_array($correct_answer_array)){
                        $implode_user_var=$correct_answer_array;
                    }else{
                        $implode_user_var=array();
                    }
                    
                    $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                       $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                       
                       $a_opt='A';
                      $user_ans_array=array();
                      $imp=0;
                      foreach($answers as $ans){     
                   //$implode_user_var
                   //$userans_id=$ans->id;    
                   //$user_answers_array=$this->Questions_model->answers_byid($userans_id);
                    if(isset($implode_user_var[$imp])){
                        $cheked_option=$implode_user_var[$imp];
                    }else{
                        
                        $cheked_option='';
                    }
                          
                          $user_ans_array[$a_opt] = $ans->answer.' -> '.$cheked_option ;
                    
                      $a_opt++;  
                      $imp++;
                      }                      
                      
                    $sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;
                    
                }
                }else{
                    $sections[$usertest_val->section_name]['not_attempted']=$sections[$usertest_val->section_name]['not_attempted']+1;
                }
                $total_qus_cnt++;
                $qcount++;
            }
 if(isset($usertest_info)&&count($usertest_info)>0){
            $exam_formula = $usertest_info->formula_id;
            $right_answer_marks = $usertest_info->right_answer_marks;
            $wrong_answer_marks = $usertest_info->wrong_answer_marks;
            $question_markedfor_review = $total_qus_cnt - $attempted_qus_cnt;
            $not_attampted_qus = $usertest_info->total_qus - ($attempted_qus_cnt);
            $total_marks = $usertest_info->total_qus * $right_answer_marks;
            
 }else{
       $exam_formula = 0;
            $right_answer_marks = 0;
            $wrong_answer_marks =0;
            $question_markedfor_review = 0;
            $not_attampted_qus = 0;
            $total_marks = 0;
     
 }
            $wrong_question = ($total_qus_cnt - $question_markedfor_review) - $correct_question;
            $final_result = ($right_answer_marks * $correct_question) - ($wrong_answer_marks * $wrong_question);

            if(isset($onlinetest_info->exam_id)){
                $exam_id=$onlinetest_info->exam_id;
            }else{
                $exam_id=0;
            }
            
        $isProduct = $this->Pricelist_model->getProduct($exam_id, '', '', 1);

       /*Get Info for produt block Start*/
        $isProduct_array=array(); 
        if(isset($isProduct)){
        //if(1){
       $isProduct_array[]= $isProduct;
        //}         
        }else{
        $isProduct_array[]=NULL;   
        }
       $examname=$onlinetest_info->name;
       if(isset($isProduct->modules_item_name)){
       $examname=$isProduct->modules_item_name;
       }//print_r($sections);
        $this->data['testid']=$testid;
        $this->data['isProduct_array'] = $isProduct_array;        
        $this->data['exam_id'] = $exam_id;                
        $this->data['examname'] = $examname;       
        $this->data['isProduct']=$isProduct;
        $this->data['onlinetest_info']=$onlinetest_info;
        $this->data['usertest_result_info'] = $usertest_info;
        $this->data['sections'] = $sections;
        $this->data['loadMathJax']='yes';
        $this->data['content'] = 'app_test_result';
        $this->load->view('template_mid', $this->data);
    }
    
        public function androiduseertest_result($appcid,$testid) { 
        $urlcust_array=explode('-encid-',$appcid);
        if(isset($urlcust_array[1])){
				$urlcustid=base64_decode($urlcust_array[1]);
			}else{
				$urlcustid=0;
			}	
        $this->load->model('File_model');
        $this->load->model('Pricelist_model');
        $usertest_info = $this->Onlinetest_model->get_testinfo_byid($testid);			
	    if($urlcustid>0){ 
		$user_id=$urlcustid;
		}else{
        $user_id=$usertest_info->user_id; 
		}
        $onlinetest_id=0;
        if(isset($usertest_info->test_id)&&$usertest_info->test_id>0){
        $onlinetest_id=$usertest_info->test_id;
        }
		
    $onlinetest_info=$this->Onlinetest_model->detail_with_relation($onlinetest_id,$usertest_info->exam_id,$usertest_info->subject_id,$usertest_info->chapter_id);
	$exam_id=$onlinetest_info->exam_id;
	$subject_id=$onlinetest_info->subject_id;
	$chapter_id=$onlinetest_info->chapter_id;
//$examInfoarr = $this->Examcategory_model->getExamCatgeoryById($exam_id);

$examInfoarr = $this->Examcategory_model->getExamProductById($exam_id,$usertest_info->exam_id,$usertest_info->subject_id,$usertest_info->chapter_id);
if(isset($examInfoarr[0]->pid)){
	$productid=$examInfoarr[0]->pid;
}else{
	$productid=0;
}
$this->load->model('Orders_model');

	$this->data['purchases']='no';  
$orderidInfo = $this->Orders_model->getOrders_customerproduct($user_id,$productid);
if(isset($orderidInfo->id)&&$orderidInfo->id>0&&$orderidInfo->status==1){
	$purchases='yes';
	
    $this->data['purchases']=$purchases;  
}else{
	$purchases='no';
	
    $this->data['purchases']=$purchases;  
}

if(isset($examInfoarr[0]->name)&&$examInfoarr[0]->name!=''){
	
	$examInfo=$examInfoarr[0]->name;
}else{
	$examInfo=$examInfoarr->name;
}
if(isset($subject_id)&&$$subject_id>0){
$subjectsInfo=$this->Subjects_model->getSubject($subject_id);
		}else{
			$subjectsInfo=NULL;
		}
if(isset($chapter_id)&&$$chapter_id>0){
$chaptersInfo=$this->Chapters_model->getChapter($chapter_id);
}else{
	$chaptersInfo=NULL;
}

        /*Get PDF file infornmation */
        $ot_filedetail = $this->File_model->detail($onlinetest_info->file_id);
        
        $attempts=$this->Onlinetest_model->getAttempts($usertest_info->test_id,$user_id);
        $sections=array();
        $this->data['attempts']=$attempts;  
        $this->data['ot_filedetail']=$ot_filedetail; 
       
        if ($usertest_info) {
           
            $usertest_detail = $this->Onlinetest_model->get_testdetail_byid($testid);
            $onlinequestioninfo = $this->Onlinetest_model->getolQuestion($usertest_info->test_id);
        if(isset($onlinequestioninfo)){
            $this->data['totalquestions']=count($onlinequestioninfo);
        }else{
            $this->data['totalquestions']=0;
        }
            $total_qus_cnt = 0;
            $attempted_qus_cnt = 0;
            $correct_question = 0;
            $qcount=0;
            $this->load->model('Questions_model');
            //foreach ($usertest_detail as $usertest_val) {
            foreach ($onlinequestioninfo as $usertest_val) {
                //$useranswer_data=$this->Onlinetest_model->getUserAnswerData($testid,$usertest_val->question_id);    
$useranswer_data_arr=$this->Onlinetest_model->get_testdetail_byid($testid,$usertest_val->question_id);  
$useranswer_data=$useranswer_data_arr[0];

$answers=$this->Questions_model->answers($usertest_val->question_id);
                $quesdetails=(array)$usertest_val;
                $quesdetails['timetaken']=0;
                $quesdetails['answered_correctly']=0;
                $quesdetails['answers']=$answers;
                if(array_key_exists($usertest_val->section_name, $sections)){
                    $sections[$usertest_val->section_name]['questions'][$qcount]=$quesdetails;       
                }else{
                    $sections[$usertest_val->section_name]['questions'][$qcount]=$quesdetails;
                    $sections[$usertest_val->section_name]['timetaken']=0;
                    $sections[$usertest_val->section_name]['attempted']=0;
                    $sections[$usertest_val->section_name]['not_attempted']=0;
                    $sections[$usertest_val->section_name]['correct']=0;
                    $sections[$usertest_val->section_name]['incorrect']=0;
                }
                if($useranswer_data && $useranswer_data->users_answer != '') {
                   
                    $attempted_qus_cnt++;
                    //$sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=0;
                    //$sections[$usertest_val->section_name]['attempted']=$sections[$usertest_val->section_name]['attempted']+1;
                }else{
                    //$sections[$usertest_val->section_name]['not_attempted']=$sections[$usertest_val->section_name]['not_attempted']+1;
                    $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=2;
                }
				
                 if(isset($useranswer_data) && ($useranswer_data->is_correct == '0'||$useranswer_data->is_correct == '1')) {
					 
                    $timetaken=$useranswer_data->perclick_time_spent;                    
                    sscanf($timetaken, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $sections[$usertest_val->section_name]['timetaken']= $sections[$usertest_val->section_name]['timetaken']+$time_seconds;
                $var_single_choice = $this->config->item('var_single_choice');
                $var_grid_single_choice = $this->config->item('var_grid_single_choice');
                $var_multiple_choice = $this->config->item('var_multiple_choice');
				$var_grid_multiple_choice= $this->config->item('var_grid_multiple_choice');
                $var_fill_in_the_blanks = $this->config->item('var_fill_in_the_blanks');
                $var_match_the_column = $this->config->item('var_match_the_column');
                //CHECK For radeo button single choice
				
				//add saprate condition for $var_grid_single_choice
				
                if($usertest_val->type == $var_single_choice) {					
					if($usertest_val->section_name==$useranswer_data->section_name){ 
					
							
						if((isset($useranswer_data->users_answer)&&$useranswer_data->users_answer!='') && (isset($useranswer_data->correct_answer)&&$useranswer_data->correct_answer!='')){							
							
                    if ( (trim($useranswer_data->users_answer) == trim($useranswer_data->correct_answer))) {
					
                        $correct_question++;
                        $sections[$usertest_val->section_name]['correct']=$sections[$usertest_val->section_name]['correct']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
                    }else{ 	
                        $sections[$usertest_val->section_name]['incorrect']=$sections[$usertest_val->section_name]['incorrect']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=0;
                    }
                    $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                      $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                      $a_opt='A';
                      $user_ans_array=array();
                      foreach($answers as $ans){
						  
                         $userans_id=$useranswer_data->users_answer;
						 			$ansid_new=$ans->id;					
                         if($ansid_new==$userans_id){  
							       
                    $user_answers_array=$this->Questions_model->answers_byid($userans_id); 
                    $user_ans_array[$a_opt] = $user_answers_array[0]->answer ;  
                        //$user_ans_array[$a_opt] = '' ; 
                         }
						 
                      $a_opt++;     
                      }
				$sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;   
				}}
                }    

//print_r($sections);				
                //CHECK For checkbox Multiple choice var_grid_multiple_choice
                if ($usertest_val->type == ($var_multiple_choice)) {
                    
                    //$users_answer_clean_array = unserialize($useranswer_data->users_answer);
					   
                    $users_answer_clean_array = $useranswer_data->users_answer;
                    if(isset($users_answer_clean_array)&&$users_answer_clean_array!=''){
                        $users_answer_array=$users_answer_clean_array;
                    }else{
                        $users_answer_array='';
                    }
					
                   // $correct_answer_array = unserialize($useranswer_data->correct_answer);
				      $correct_answer_array = $useranswer_data->correct_answer;
                    if (is_array($users_answer_array)) {
                        $users_answer_comma_separated = implode("|", $users_answer_array);
                    } else {
                        $users_answer_comma_separated = $users_answer_array;
                    }
                    if (is_array($correct_answer_array)) {
                        $correct_answer_comma_separated = implode("|", $correct_answer_array);
                    } else {
                        $correct_answer_comma_separated = $correct_answer_array;
                    }
					
					//echo '<br><br><br>'.$qcount.'--'.$users_answer_comma_separated.'---===========---'.$correct_answer_comma_separated.'<br><br>'; 
                    if ((trim($users_answer_comma_separated) == trim($correct_answer_comma_separated)) && ($users_answer_comma_separated != '') && ($correct_answer_comma_separated != '')) {
                     
					$correct_question++;
                        $sections[$usertest_val->section_name]['correct']=$sections[$usertest_val->section_name]['correct']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
                    }else{
                        $sections[$usertest_val->section_name]['incorrect']=$sections[$usertest_val->section_name]['incorrect']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=0;
                    }
                    $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                     $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                      $a_opt='A';
                      $user_ans_array=array();
                      foreach($answers as $ans){     
                    if( in_array($ans->id, $users_answer_array)){
                    $userans_id=$ans->id;    
                    $user_answers_array=$this->Questions_model->answers_byid($userans_id);
                    $user_ans_array[$a_opt] = $user_answers_array[0]->answer ;
                    //$user_ans_array[$a_opt] = '' ;
                         }
                      $a_opt++;     
                      }                      
                      
                    $sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;
                }

                //CHECK For Fill in the blanks
                if ($usertest_val->type == $var_fill_in_the_blanks) {
                    if ((trim($useranswer_data->users_answer) == trim($useranswer_data->correct_answer)) && ($useranswer_data->users_answer != '') && ($useranswer_data->correct_answer != '')) {
                        $correct_question++;
                        $sections[$usertest_val->section_name]['correct']=$sections[$usertest_val->section_name]['correct']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
                    }else{
                        $sections[$usertest_val->section_name]['incorrect']=$sections[$usertest_val->section_name]['incorrect']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=0;
                    }
                     $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                       $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                      
                      $a_opt='A';
                      $user_ans_array=array();                      
                      foreach($answers as $ans){
                          $userans_id=trim($useranswer_data->users_answer);
                           $test_answer=trim($ans->answer);
                    $user_ans_array[$a_opt] = $userans_id ;                     
                           $a_opt++;     
                      }
                      $sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;   
                }

                //CHECK For Match The Column
                if ($usertest_val->type == $var_match_the_column) {

                    $flag_diff = 'no';
                    
                    $users_answer_array = unserialize($useranswer_data->users_answer);
                    $correct_answer_array = unserialize($useranswer_data->correct_answer);
                    if(isset($correct_answer_array)){
                    $correct_answer_count = count($correct_answer_array);
                    }else{
                      $correct_answer_count=0;  
                    }
                    for ($in = 0; $correct_answer_count > $in; $in++) {
                        $count_user_inner = 0;
                        $count_correct_inner = 0;
                        if (isset($correct_answer_array[$in])) {
                            $count_correct_inner = count($correct_answer_array[$in]);
                        }
                        if (isset($users_answer_array[$in])) {
                            $count_user_inner = count($users_answer_array[$in]);
                        }
                        if ($count_correct_inner == $count_user_inner) {
                            /* $result_diffrence = array_diff($correct_answer_array[$in], $users_answer_array[$in]);
                             * */
                            if(is_array($correct_answer_array[$in])){
                            $implode_correct = implode('|', $correct_answer_array[$in]);
                            }else{
                            $implode_correct = $correct_answer_array[$in];
                            }
                            if(is_array($users_answer_array[$in])){
                            $implode_user = implode('|', $users_answer_array[$in]);
                            }else{
                            $implode_user = $users_answer_array[$in];
                            }
                            if (trim($implode_correct) == trim($implode_user)) {
                                $result_diffrence = 0;
                            } else {
                                $result_diffrence = 1;
                            }
                        } else {
                            $result_diffrence = 1;
                        }
                        if ($result_diffrence > 0) {
                            $flag_diff = 'yes';
                        }
                    }
                
                    if ($flag_diff == 'no') {
                        $correct_question++;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=1;
                        $sections[$usertest_val->section_name]['correct']=$sections[$usertest_val->section_name]['correct']+1;
                    }else{
                        $sections[$usertest_val->section_name]['incorrect']=$sections[$usertest_val->section_name]['incorrect']+1;
                        $sections[$usertest_val->section_name]['questions'][$qcount]['answered_correctly']=0;
                    }
                    
                    if(is_array($correct_answer_array)){
                        $implode_user_var=$correct_answer_array;
                    }else{
                        $implode_user_var=array();
                    }
                    
                    $sections[$usertest_val->section_name]['questions'][$qcount]['per_qus_time']=$useranswer_data->perclick_time_spent;
                       $sections[$usertest_val->section_name]['questions'][$qcount]['question_type']=$useranswer_data->question_type;
                       
                       $a_opt='A';
                      $user_ans_array=array();
                      $imp=0;
                      foreach($answers as $ans){     
                   //$implode_user_var
                   //$userans_id=$ans->id;    
                   //$user_answers_array=$this->Questions_model->answers_byid($userans_id);
                    if(isset($implode_user_var[$imp])){
                    $cheked_option=$implode_user_var[$imp];
                    }else{
                        
                        $cheked_option='';
                    }
                          
                    $user_ans_array[$a_opt] = $ans->answer.' -> '.$cheked_option ;
                    
                      $a_opt++;  
                      $imp++;
                      }                      
                      
                    $sections[$usertest_val->section_name]['questions'][$qcount]['your_answer']=$user_ans_array;
                    
                }
                }else{
                    $sections[$usertest_val->section_name]['not_attempted']=$sections[$usertest_val->section_name]['not_attempted']+1;
                }
                $total_qus_cnt++;
                $qcount++;
            }
				
			//echo "1080 function start and written on 1400 line number";
//print_r($sections['PHYSICS']['incorrect']); 
//die;
            $exam_formula = $usertest_info->formula_id;
            $right_answer_marks = $usertest_info->right_answer_marks;
            $wrong_answer_marks = $usertest_info->wrong_answer_marks;
            $question_markedfor_review = $total_qus_cnt - $attempted_qus_cnt;
            $not_attampted_qus = $usertest_info->total_qus - ($attempted_qus_cnt);
            $total_marks = $usertest_info->total_qus * $right_answer_marks;
            $wrong_question = ($total_qus_cnt - $question_markedfor_review) - $correct_question;

            $final_result = ($right_answer_marks * $correct_question) - ($wrong_answer_marks * $wrong_question);

            }
            if(isset($onlinetest_info->exam_id)){
                $exam_id=$onlinetest_info->exam_id;
            }else{
                $exam_id=0;
            }		
	   //detail_with_relation
$examInfo = $this->Examcategory_model->getExamCatgeoryById($exam_id);
$subject_id=$onlinetest_info->subject_id;   
$subjectsInfo=$this->Subjects_model->getSubject($subject_id);
$chapter_id=$onlinetest_info->chapter_id;
$chaptersInfo=$this->Chapters_model->getChapter($chapter_id);

$this->data['chaptersInfo'] = $chaptersInfo;
$this->data['subjectsInfo'] = $subjectsInfo;
$this->data['examInfo'] = $examInfo[0];	 

	   if($exam_id>0){
       $isProduct = $this->Pricelist_model->getProduct($exam_id, 0, 0, 1);
	   /*Get Info for produt block Start*/
       $isProduct_array=array(); 
       $products_id=0;
       if(isset($isProduct)){
       if(count($isProduct)>0){
       $isProduct_array[]= $isProduct;
	   if(isset($isProduct->id)){
       $products_id=$isProduct->id;
       }
       }
	   }else{  
        $isProduct = $this->Pricelist_model->getProduct($exam_id, 0, 0, 3);
       
		   
	   if(isset($isProduct)){
       if(count($isProduct)>0){
       $isProduct_array[]= $isProduct;
	   if(isset($isProduct->id)){
        $products_id_two=$isProduct->id;
       }
       }
	   }else{ 
	   $isProduct_array[]=NULL;   
	   }
       }
	   }else{
		$isProduct=array();	
		}       
					
		$purchases_info = $this->Onlinetest_model->userpurchases($products_id,$user_id,1);
		
		$purchases_info_two = $this->Onlinetest_model->userpurchases($products_id_two,$user_id,1);
		
		
		/*
		if($user_id=='299204'){
		echo $user_id.'----'.$products_id;
		print_r($purchases_info);	
		
		}
		//print_r($isProduct);
		//echo $products_id.'---';
		//print_r($purchases_info);
		*/
					$orderid=$purchases_info[0]->mainid;
					if(isset($orderid)&&$orderid>0){
						$this->data['purchases']='yes';
					}else{
						$orderid=$purchases_info_two[0]->mainid;
						if(isset($orderid)&&$orderid>0){
						$this->data['purchases']='yes';
						}else{
						$this->data['purchases']='no';
						}
					}
$examname=$onlinetest_info->name;
$products=$this->Customer_model->getCustomerProucts($user_id);
if($products){
                   foreach($products as $key=>$product){
                    $subject_id=0;
                    $exam_id=0;
                    if(isset($product->exam_id)){
                    $exam_id=$product->exam_id;
                    }   
                   $get_allproduct=$this->Pricelist_model->checkExamProduct_All($exam_id,'ALL');
$allp1=$get_allproduct[0];
$allp2=$get_allproduct[1];
$allp3=$get_allproduct[2];
$purchased[$allp1->type][]=$allp1->id;
$purchased[$allp2->type][]=$allp2->id;
$purchased[$allp2->type][]=$allp3->id; 
                   }
               }
	  $this->data['purchased']=$purchased; 
	/*
	$products=$this->Customer_model->getCustomerProucts($user_id);
	print_r($products); die;
	*/
	   
       if(isset($isProduct->modules_item_name)){
       $examname=$isProduct->modules_item_name;
       }//print_r($sections);
	   $this->data['appcid']=$appcid;
        $this->data['testid']=$testid;
        $this->data['isProduct_array'] = $isProduct_array; 
        $this->data['exam_id'] = $exam_id;                
        $this->data['examname'] = $examname;
        $this->data['examInfo'] = $examInfo;              
        $this->data['subjectsInfo'] = $subjectsInfo;              
        $this->data['chaptersInfo'] = $chaptersInfo;
		
        $this->data['isProduct']=$isProduct;
        $this->data['onlinetest_info']=$onlinetest_info;
        $this->data['usertest_result_info'] = $usertest_info;
        $this->data['sections'] = $sections;
        $this->data['customer_id'] = $user_id;
        $this->data['loadMathJax']='yes';
        $this->data['content'] = 'app_usertest_result';
        $this->load->view('template_mid', $this->data);
    }
    
    

}