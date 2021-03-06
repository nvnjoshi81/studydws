<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Start extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Onlinetest_model');
        //$this->output->enable_profiler(TRUE);
        $this->data['loadMathJax'] = 'YES';
    }

    public function index() {
        //$this->output->enable_profiler(TRUE);
        $exam_id = $this->input->post('exam_id');
        $subject_id = $this->input->post('subject_id');
        $chapter_id = $this->input->post('chapter_id');
        $onlinetest_id = $this->input->post('onlinetest_id');
        $total_question = $this->input->post('total_question');
        $total_time = $this->input->post('total_time');
        $formula_id = $this->input->post('formula_id');
        $current_time = time();
        $customer_id = $this->session->userdata('customer_id');
        $current_exam_timestamp = $this->session->userdata('current_exam_timestamp');
        
        if (!isset($current_exam_timestamp) && ($current_exam_timestamp == '')) {
            $this->session->set_userdata('current_exam_timestamp', $current_time);
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
                'right_answer_marks' => $right_answer_marks,
                'wrong_answer_marks' => $wrong_answer_marks,                
                'total_time' => $total_time,
                'total_marks'=> $total_marks,
                'formula_id' => $formula_id,
                'total_qus'  => $total_question,
                'status'     => 0,
                'dt_created' => $current_time,
				'start_time' =>date("h:i a")
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
                'answer_extra' => $questioninfo->answer_extra,
                'answer_array' => $answer_array,
               'answerid_array' => $answerid_array,
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
        if(is_array($question_answer_array)){
        $this->data['question_answer_array'] = $question_answer_array;
        }else{
        $this->data['question_answer_array'] =''; 
        }
        $this->data['content'] = 'exam_paper';
        $this->load->view('template_onlinetest', $this->data);
    }
public function androidindex($exam_id,$subject_id,$chapter_id=0,$onlinetest_id,$total_time,$total_question,$formula_id,$customer_id){
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
           $customer_id = $this->session->userdata('customer_id');
        if (($customer_id == '') || ($customer_id < 1)) {
        $this->session->set_userdata('customer_id', $customer_id);
        }else{
            die('Customer Id Not Found.');
        }  
            }else{
            $customer_id = $customer_id;
            $this->session->set_userdata('customer_id', $customer_id);
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
                'right_answer_marks' => $right_answer_marks,
                'wrong_answer_marks' => $wrong_answer_marks,                
                'total_time' => $total_time,
                'total_marks'=> $total_marks,
                'formula_id' => $formula_id,
                'total_qus'  => $total_question,
                'status'     => 0,
                'dt_created' => $current_time,
				'start_time' =>date("h:i a")
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
        if(is_array($question_answer_array)){
        $this->data['question_answer_array'] = $question_answer_array;
        }else{
        $this->data['question_answer_array'] =''; 
        }
        $this->data['current_user_id'] = $current_user_id;
        $this->data['customer_id'] = $customer_id;
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
        $customer_id = $this->session->userdata('current_user_id');
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
        if ($question_type == ($var_single_choice||$var_grid_single_choice)) {
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
            
        } else if ($question_type == ($var_multiple_choice||$var_grid_multiple_choice)) {

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
            $correct_answer_string = trim($questions_answer[0]->answer);
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
            $users_answer_string ='';
            $correct_answer_string='';
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
        
       $getRightMarksarray[0] =  $this->Onlinetest_model->getRightAnswerMarks($usertest_id);
       $countRightAnswer = count($getRightMarksarray[0]);
       $total_right_answer_marks = $countRightAnswer*$right_answer_marks;
       
       $getWrongMarksarray[0] =  $this->Onlinetest_model->getwrongAnswerMarks($usertest_id);
       
       $countwrongAnswer = count($getWrongMarksarray[0]);
        
       $total_wrong_answer_marks = $countwrongAnswer*$wrong_answer_marks;
       
       $getReviewdQuestionarray[0] =  $this->Onlinetest_model->getReviewdQuestion($usertest_id);
 
       $reviedQuestion = count($getReviewdQuestionarray[0]);
       
       $obtain_marks = $total_right_answer_marks-$total_wrong_answer_marks;
       
       $getAttamptedQuestionarray[0] =  $this->Onlinetest_model->getattamptedQuestion($usertest_id);
 
       $attamptedQuestion = count($getAttamptedQuestionarray[0]);
       $not_attampted_qus=$total_question-$attamptedQuestion;
       
        $usertest_data = array(
            'time_remaining' => $time_remaining,
            'time_taken' => $time_taken,
            'obtain_marks' => $obtain_marks,
            'reviewed_qus' =>$reviedQuestion,
            'attampted_ques' =>$attamptedQuestion,
            'not_attampted_qus' =>$not_attampted_qus,
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
            
       $isProduct = $this->Pricelist_model->getProduct($exam_id, '', '', 3);
       /*Get Info for produt block Start*/
       $isProduct_array=array(); 
        if(isset($isProduct)){
       //if(1){
       $isProduct_array[]= $isProduct;
                   // }
                    
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
    
    
    
        public function androiduseertest_result($testid) {
$this->load->model('File_model');
        $this->load->model('Pricelist_model');
        $usertest_info = $this->Onlinetest_model->get_testinfo_byid($testid); 
        $onlinetest_id=0;
        if(isset($usertest_info->test_id)&&$usertest_info->test_id>0){
            $onlinetest_id=$usertest_info->test_id;
        }
        $onlinetest_info=$this->Onlinetest_model->detail_with_relation($onlinetest_id);
      
        /*Get PDF file infornmation */
        $ot_filedetail = $this->File_model->detail($onlinetest_info->file_id);
        
        $user_id=$usertest_info->user_id; //
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
                $var_single_choice = $this->config->item('var_single_choice');
                $var_grid_single_choice = $this->config->item('var_grid_single_choice');
                $var_multiple_choice = $this->config->item('var_multiple_choice');
				$var_grid_multiple_choice= $this->config->item('var_grid_multiple_choice');
                $var_fill_in_the_blanks = $this->config->item('var_fill_in_the_blanks');
                $var_match_the_column = $this->config->item('var_match_the_column');
                //CHECK For radeo button single choice
                if($usertest_val->type ==( $var_single_choice|| $var_grid_single_choice)) {
                    
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
            
       $isProduct = $this->Pricelist_model->getProduct($exam_id, '', '', 3);
       /*Get Info for produt block Start*/
       $isProduct_array=array(); 
       
        if(isset($isProduct)){
       if(count($isProduct)>0){
       $isProduct_array[]= $isProduct;
                    }}else{
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
        $this->data['customer_id'] = $user_id;
        $this->data['loadMathJax']='yes';
        $this->data['content'] = 'appusertest_result';
        $this->load->view('template_mid', $this->data);
    }
    
    

}