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
        if (isset($exam_id)) {
            $this->session->set_userdata('exam_id', $exam_id);
            $this->session->set_userdata('subject_id', $subject_id);
            $this->session->set_userdata('chapter_id', $chapter_id);
            $this->session->set_userdata('onlinetest_id', $onlinetest_id);
            $this->session->set_userdata('total_time', $total_time);

            $current_exam_timestamp = $this->session->userdata('current_exam_timestamp');
            if (!isset($current_exam_timestamp) && ($current_exam_timestamp == '')) {

                $this->session->set_userdata('current_exam_timestamp', $timestamp);
            }
            
            if (($customer_id == '') || ($customer_id < 1)) {
                $customer_id = $this->session->userdata('current_exam_timestamp');
            }
            //get formula detail

            $formula_info = $this->Onlinetest_model->formula_detail($formula_id);

            $usertest_data = array(
                'user_id' => $customer_id,
                'test_id' => $onlinetest_id,
                'details' => $formula_id,
                'right_answer_marks' => $formula_info->right_answer_marks,
                'wrong_answer_marks' => $formula_info->wrong_answer_marks,
                'total_qus' => $total_question,
                'total_time' => $total_time,
                'status' => 0,
                'dt_created' => $current_time
            );

            $usertest_id = $this->Onlinetest_model->add_user_testdata($usertest_data);            
            $this->session->set_userdata('usertest_id', $usertest_id);
        } else {
            $exam_id = $this->session->userdata('exam_id');
            $subject_id = $this->session->userdata('subject_id');
            $chapter_id = $this->session->userdata('chapter_id');
            $onlinetest_id = $this->session->userdata('onlinetest_id');
            $total_time = $this->session->userdata('total_time');
            
        }$usertest_id = $this->session->userdata('usertest_id');
        
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

        // echo $examid.'-=-=';die;
        //$onlinetest=$this->Onlinetest_model->getOnlineTests($exam_id,$subject_id,$chapter_id);
        //$this->data['onlinetest']=$onlinetest;
        $onlinetestinfo = $this->Onlinetest_model->detail($onlinetest_id);
        $this->data['onlinetestinfo'] = $onlinetestinfo;
        $onlinequestioninfo = $this->Onlinetest_model->getolQuestion($onlinetest_id);
        $q_count = 1;
        $question_answer_array =array();
        foreach ($onlinequestioninfo as $questioninfo) {

            $question_id = $questioninfo->question_id;
            $question = $questioninfo->question;
            $qustion_instructions_id = $questioninfo->instructions_id;
            $this->data['qustion_instructions_id'] = $qustion_instructions_id;
            if ($qustion_instructions_id > 0) {
                $instruction_detail = $this->Onlinetest_model->detail($onlinetest_id);
                $this->data['instruction_detail'] = $instruction_detail->instructions;
            } else {
                $this->data['instruction_detail'] = '';
            }

            $onlineanswerinfo = $this->Onlinetest_model->getAnswerByQuestion($question_id);
            $a_count = 1;
            if ($onlineanswerinfo) {
                foreach ($onlineanswerinfo as $answerinfo) {
                    if (isset($answerinfo->answer)) {
                        $answer_array[$question_id][$a_count] = $answerinfo->answer;
                        $a_count++;
                    }
                }
            }
            $question_answer_array[$q_count] = array(
                'onlinetest_id' => $questioninfo->onlinetest_id,
                'question_id' => $question_id,
                'question' => $question,
                'type' => $questioninfo->type,
                'type_extra' => $questioninfo->type_extra,
                'section' => $questioninfo->section,
                'section_name' => $questioninfo->section_name,
                'instructions_id' => $questioninfo->instructions_id,
                'description' => $questioninfo->description,
                'answer_array' => $answer_array
            );
            $q_count++;
        }

        $this->data['var_single_choice'] = $this->config->item('var_single_choice');
        $this->data['var_multiple_choice'] = $this->config->item('var_multiple_choice');
        $this->data['var_fill_in_the_blanks'] = $this->config->item('var_fill_in_the_blanks');
        $this->data['var_match_the_column'] = $this->config->item('var_match_the_column');
        if(is_array($question_answer_array)){
        $this->data['question_answer_array'] = $question_answer_array;
        }else{
             $this->data['question_answer_array'] =''; 
        }
        $this->data['content'] = 'exam_paper';

        $this->load->view('template_onlinetest', $this->data);
    }

    public function save_qus() {
        $question_type = $this->input->post('qtype');
        $question_id = $this->input->post('qid');
        $users_answer = $this->input->post('users_answer');
        $test_id = $this->input->post('test_id');
        $usertest_id = $this->input->post('usertest_id');
        $question_action = $this->input->post('qaction');
        $perclick_time_spent = $this->input->post('perclick_time_spent');
        $customer_id = $this->session->userdata('current_user_id');
        $response['question_type'] = $question_type;
        $response['question_id'] = $question_id;
        $response['test_id'] = $test_id;
        $response['usertest_id'] = $usertest_id;
        $response['question_action'] = $question_action;
        $response['customer_id'] = $customer_id;

        $var_single_choice = $this->config->item('var_single_choice');
        $var_multiple_choice = $this->config->item('var_multiple_choice');
        $var_fill_in_the_blanks = $this->config->item('var_fill_in_the_blanks');
        $var_match_the_column = $this->config->item('var_match_the_column');

        $this->data['var_single_choice'] = $var_single_choice;
        $this->data['var_multiple_choice'] = $var_multiple_choice;
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

        if ($question_type == $var_single_choice) {
            $mtb_final_string = '';
            for ($i = 0; $questions_answer_cnt > $i; $i++) {
                $questions_answer_var = $questions_answer[$i]->is_correct;
                if ($questions_answer_var > 0) {
                    $mtb_final_string = trim($questions_answer[$i]->answer);
                }
            }

            $correct_answer_string = $mtb_final_string;
        } else if ($question_type == $var_multiple_choice) {

            $mtb_final_array = array();
            for ($i = 0; $questions_answer_cnt > $i; $i++) {
                $questions_answer_var = $questions_answer[$i]->is_correct;
                if ($questions_answer_var > 0) {
                    $mtb_final_array[] = trim($questions_answer[$i]->answer);
                }
            }

            $correct_answer_string = serialize($mtb_final_array);
        } else if ($question_type == $var_fill_in_the_blanks) {


            $correct_answer_string = trim($questions_answer[0]->answer);
        } else if ($question_type == $var_match_the_column) {

            $mtb_final_array = array();
            for ($i = 0; $questions_answer_cnt > $i; $i++) {
                $mtb_array = array();
                $questions_answer_var = trim($questions_answer[$i]->answer_extra);
                $questions_answer_arr = explode(',', $questions_answer_var);
                for ($j = 0; count($questions_answer_arr) > $j; $j++) {
                    $mtb_array[] = $questions_answer_arr[$j];
                }
                $mtb_final_array[$i] = $mtb_array;
            }
            $correct_answer_string = serialize($mtb_final_array);
        }

        $flag_usertest_array = $this->Onlinetest_model->get_userqus_detail($customer_id, $test_id, $usertest_id, $question_id);

        $date = time();
        if (is_array($users_answer)) {
            $users_answer_string = serialize($users_answer);
        } else {
            $users_answer_string = trim($users_answer);
        }

        $usertest_detail_one = array(
            'usertest_id' => $usertest_id,
            'question_id' => $question_id,
            'question_type' => urldecode($question_type),
            'users_answer' => trim($users_answer_string),
            'correct_answer' => trim($correct_answer_string),
            'perclick_time_spent' => $perclick_time_spent
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
        $time_remaining_array = explode(':', $time_remaining_string);
        $rm_hours = $time_remaining_array[0];
        $rm_minits = $time_remaining_array[1];
        $rm_seconds = $time_remaining_array[2];
        $time_remaining = $rm_hours * 3600 + $rm_minits * 60 + $rm_seconds;
        $time_taken = $total_time - $time_remaining;
        $usertest_data = array(
            'time_remaining' => $time_remaining,
            'time_taken' => $time_taken
        );
        $this->Onlinetest_model->update_user_testdata($usertest_id, $usertest_data);
    }

    public function cleare_answer() {
        $exam_id = $this->input->post('exam_id');
        $qus_id = $this->input->post('qus_id');
        $this->Onlinetest_model->remove_userans($exam_id, $qus_id);
    }

}
