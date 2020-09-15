<?php 
class testand{
public function androidindex($exam_id,$subject_id,$chapter_id,$onlinetest_id,$total_time,$total_question,$formula_id,$customer_id){
        $exam_id = $exam_id;
        $subject_id     = $subject_id;
        $chapter_id     = $chapter_id;
        $onlinetest_id  = $onlinetest_id;
        $total_question = $total_time;
        $total_time = $total_question;
        $formula_id = $formula_id;
        $customer_id = $customer_id;
        $current_time = time();
        $current_exam_timestamp = $current_time;
        if (isset($onlinetest_id)) {
                $this->data['exam_id'] = $exam_id;
                $this->data['subject_id'] = $subject_id;
                $this->data['chapter_id'] = $chapter_id;
                $this->data['onlinetest_id'] = $onlinetest_id;
                $this->data['total_question'] = $total_question;
                $this->data['total_time'] = $total_time;
                $this->data['formula_id'] = $formula_id;
                $this->data['customer_id'] = $customer_id;
                $this->data['current_exam_timestamp'] = $current_exam_timestamp;
                $this->data['current_exam_timestamp']=$current_exam_timestamp;
            
            if (($customer_id == '') || ($customer_id < 1)) {
               // $customer_id = $this->session->userdata('current_exam_timestamp');
            die('There Is Some Problem.Please Try Again.');
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
                'dt_created' => $current_time
            );
            $usertest_id = $this->Onlinetest_model->add_user_testdata($usertest_data);
                $this->data['usertest_id'] = $usertest_id;
        } else {
                $this->data['exam_id'] = $exam_id;
                $this->data['subject_id'] = $subject_id;
                $this->data['chapter_id'] = $chapter_id;
                $this->data['onlinetest_id'] = $onlinetest_id;
                $this->data['total_question'] = $total_question;
                $this->data['total_time'] = $total_time;
                $this->data['formula_id'] = $formula_id;
                $this->data['customer_id'] = $customer_id;
            //get formula detail
            $formula_info = $this->Onlinetest_model->formula_detail($formula_id);
            $right_answer_marks = $formula_info->right_answer_marks;
            $wrong_answer_marks = $formula_info->wrong_answer_marks;
            $total_marks=$right_answer_marks*$total_question;            
        }
        
            if(isset($usertest_id)&&$usertest_id>0){
                $this->data['usertest_id'] = $usertest_id;
            }else{
                $this->data['usertest_id'] = 0;
            }
        if (!isset($onlinetest_id)) {
            $this->session->set_flashdata('massage', 'Please try again.Test Id not found.');
            die('Please try again.Test Id not found.');
        }
        $current_user_id = $customer_id;

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
               'answerid_array' => $answerid_array
            );
            $q_count++;
        }
        $this->data['var_single_choice'] = $this->config->item('var_single_choice');
        $this->data['var_multiple_choice'] = $this->config->item('var_multiple_choice');
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
        $this->data['content'] = 'appexam_paper';
        $this->load->view('template_onlinetest', $this->data);

}
}

?>