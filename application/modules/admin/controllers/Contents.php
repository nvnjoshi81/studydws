<?php
ob_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contents extends MY_Admincontroller {
    public function __construct() {
        parent::__construct();
        $this->load->library("pagination");
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->model('Chapters_model');
        $this->load->model('Examcategory_model');
        $this->load->model('Subjects_model');
        $this->load->model('Categories_model');
        $this->load->model('Content_model');
        $this->load->model('Contents_model');
        $this->load->model('Pricelist_model');
        $this->load->model('Questions_model');
        $this->load->model('Answers_model');
        $this->load->model('Onlinetest_model');$this->load->model('Videos_model');
        $exams = $this->Examcategory_model->getAdminExamCatgeories();
        $this->data['exams'] = $exams;
        $this->data['subjects'] = $this->Subjects_model->getSubjects();
        $this->data['chapters_arr'] = $this->Chapters_model->getChapters();
        $this->data['content_type_array'] = $this->Content_model->getContentType();
        $this->data['questions_type'] = $this->Content_model->questions_type();
        $this->data['examformula_array'] = $this->Onlinetest_model->getolExamFormula();
        $this->data['olcategory_array'] = $this->Onlinetest_model->getolExamCategory();
        $this->data['array_video_source'] = $this->Contents_model->getVideoSource();
        
		$this->data['array_video_by'] = $this->Contents_model->getVideoBy();
		
		$this->data['array_is_featured'] = $this->Contents_model->getIsFeatured();
        $this->data['array_status'] = $this->Contents_model->getStatus();
    }

    public function index($page = 0) {
        /**pgination _categories**/
        $config = array();
        $config["base_url"] = base_url() . "admin/contents/index/";
        $config["total_rows"] = $this->Contents_model->getContentTypeCount();
        $config["per_page"] = $this->config->item('records_per_page');
        $config["uri_segment"] = 4;
        $config["num_links"] = 5;
        $config['first_link'] = '&lsaquo; First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &rsaquo;';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        //$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;               

        $this->data["links"] = $this->pagination->create_links();
        $this->data['content_type'] = $this->Contents_model->getContentType();
        $this->data['content'] = 'contents/index';
        $this->load->view('common/template', $this->data);
    }

    public function remove_multiple_videos() {
        
        $inner_items = $this->input->post('inner_item_id');
        for ($cc_itm = 0; count($inner_items) > $cc_itm; $cc_itm++) {

            $this->Videos_model->delete_video_byid($inner_items[$cc_itm]);
        }

        $questionbank_id = $this->input->post('questionbank_id');
        $questionbank_type_id = $this->input->post('questionbank_type_id');
        if ($questionbank_id != '' && $questionbank_type_id != '') {
            $this->session->set_flashdata('message', 'Video Deleted.');

            redirect('admin/contents/edit/' . $questionbank_id . '/' . $questionbank_type_id);
        } else {

            $this->session->set_flashdata('message', 'Question bank id OR Question Bank Type not found!');
            redirect('admin/contents/add');
        }
    }

    public function remove_onlinetest_qus() {
        $main_exam_id = $this->input->post('main_exam_id');
        $main_subject_id = $this->input->post('main_subject_id');
        $main_chapter_id = $this->input->post('main_chapter_id');
        $inner_items = $this->input->post('inner_item_id');
        $questionbank_id = $this->input->post('questionbank_id');
        $questionbank_type_id = $this->input->post('questionbank_type_id');

        if ($questionbank_id != '' && $questionbank_type_id != '') {
            $this->load->model('Onlinetest_model');
            for ($cc_itm = 0; count($inner_items) > $cc_itm; $cc_itm++) {
                $this->Onlinetest_model->remove_examques($questionbank_id, $inner_items[$cc_itm]);
            }

            $this->session->set_flashdata('message', 'Question Answer Deleted for Online test only.');
            redirect('admin/contents/edit/' . $questionbank_id . '/' . $questionbank_type_id . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id);
        } else {
            $this->session->set_flashdata('message', 'Question bank id OR Question Bank Type not found!');
            redirect('admin/contents/add');
        }
    }

    public function alert_remove_multi_qus() {
        $main_exam_id = $this->input->post('main_exam_id');
        $main_subject_id = $this->input->post('main_subject_id');
        $main_chapter_id = $this->input->post('main_chapter_id');
        $inner_item_id = $this->input->post('inner_item_id');
        $questionbank_id = $this->input->post('questionbank_id');
        $questionbank_type_id = $this->input->post('questionbank_type_id');
        $form_action = $this->input->post('form_action');
        $this->data['form_action'] = $form_action;
        $this->data['main_exam_id'] = $main_exam_id;
        $this->data['main_subject_id'] = $main_subject_id;
        $this->data['main_chapter_id'] = $main_chapter_id;
        $this->data['inner_item_id'] = $inner_item_id;
        $this->data['questionbank_id'] = $questionbank_id;
        $this->data['questionbank_type_id'] = $questionbank_type_id;
        $this->data['content'] = 'contents/alert_remove';
        $this->load->view('common/template', $this->data);
    }

    public function remove_multi_qus() {
        $main_exam_id = $this->input->post('main_exam_id');
        $main_subject_id = $this->input->post('main_subject_id');
        $main_chapter_id = $this->input->post('main_chapter_id');
        $inner_items = $this->input->post('inner_item_id');
        $questionbank_id = $this->input->post('questionbank_id');
        $questionbank_type_id = $this->input->post('questionbank_type_id');

        if ($questionbank_id != '' && $questionbank_type_id != '') {
            $this->load->model('Questions_model');
            //Online Test
            if ($questionbank_type_id == 3) {
                $this->load->model('Onlinetest_model');
                for ($cc_itm = 0; count($inner_items) > $cc_itm; $cc_itm++) {
                    $this->Onlinetest_model->remove_examques($questionbank_id, $inner_items[$cc_itm]);
                }
            }

            //Sample Papers
            if ($questionbank_type_id == 6) {
                $this->load->model('Samplepapers_model');
                for ($cc_itm = 0; count($inner_items) > $cc_itm; $cc_itm++) {
                    $this->Samplepapers_model->remove_examques($questionbank_id, $inner_items[$cc_itm]);
                }
            }
            //Question Bank
            if ($questionbank_type_id == 7) {
                $this->load->model('Questionbank_model');
                for ($cc_itm = 0; count($inner_items) > $cc_itm; $cc_itm++) {
                    $this->Questionbank_model->remove_examques($questionbank_id, $inner_items[$cc_itm]);
                }
            }
            //Ncert Solutions
            if ($questionbank_type_id == 9) {
                $this->load->model('Ncertsolutions_model');
                for ($cc_itm = 0; count($inner_items) > $cc_itm; $cc_itm++) {
                    $this->Ncertsolutions_model->remove_examques($questionbank_id, $inner_items[$cc_itm]);
                }
            }
            //Solved Papers
            if ($questionbank_type_id == 10) {
                $this->load->model('Solvedpapers_model');
                for ($cc_itm = 0; count($inner_items) > $cc_itm; $cc_itm++) {
                    $this->Solvedpapers_model->remove_examques($questionbank_id, $inner_items[$cc_itm]);
                }
            }
// Check this function for deletion question answer should not delete from quation answer table.
            for ($cc_itm = 0; count($inner_items) > $cc_itm; $cc_itm++) {

                $this->Questions_model->delete_qus_ans_byid($inner_items[$cc_itm]);
            }

            $this->session->set_flashdata('message', 'Question Answer Deleted.');

            redirect('admin/contents/edit/' . $questionbank_id . '/' . $questionbank_type_id . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id);
        } else {

            $this->session->set_flashdata('message', 'Question bank id OR Question Bank Type not found!');

            redirect('admin/contents/add');
        }
    }

    public function deletecontent($id, $mtypeid, $mid, $main_exam_id = '', $main_subject_id = '', $main_chapter_id = '') {
        //Online Test
        if ($mtypeid == 6) {
            $this->load->model('Onlinetest_model');
            $this->Onlinetest_model->remove_examques($mid, $id);
        }
        //Sample Papers
        if ($mtypeid == 6) {
            $this->load->model('Samplepapers_model');
            $this->Samplepapers_model->remove_examques($mid, $id);
        }
        //Question Bank
        if ($mtypeid == 7) {
            $this->load->model('Questionbank_model');
            $this->Questionbank_model->remove_examques($mid, $id);
        }
        //Ncert Solutions
        if ($mtypeid == 9) {
            $this->load->model('Ncertsolutions_model');
            $this->Ncertsolutions_model->remove_examques($mid, $id);
        }
        //Solved Papers
        if ($mtypeid == 10) {
            $this->load->model('Solvedpapers_model');
            $this->Solvedpapers_model->remove_examques($mid, $id);
        }
        $this->Content_model->delete_cmsquestions_byid($id);
        $this->Content_model->delete_cmsanswers_byid($id);
        $this->session->set_flashdata('message', 'Question Answer Deleted!');
        redirect('admin/contents/edit/' . $mid . '/' . $mtypeid . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id);
    }

    public function add() {
        $this->data['content'] = 'contents/add';
        $this->load->view('common/template', $this->data);
    }
	
	
	
    public function sortlist() {
        $this->data['content'] = 'contents/sortlist';
        $this->load->view('common/template', $this->data);
    }
    
    public function add_relation() {
        $item_id = 0;
        $is_deleted = 0;
        $contents = '';
        $date = time();
        $exam_id = $this->input->post('relation_exam');
        $subject_id = $this->input->post('relation_subject');
        $chapter_ids = $this->input->post('eschapters_selected');
        $chapter_id = $this->input->post('relation_chapter');
        $module_id = $this->input->post('module_id');
        $module_type_id = $this->input->post('module_type_id');
        $created_by_id = $this->session->userdata("userid");
        $type = $this->input->post('relation_content_type');
        $add_content_type = $this->Content_model->getContentTypeDetail($type);
        $tablename = '';
        $columnname = '';
        $relations_data = array(
            'exam_id' => $exam_id,
            'subject_id' => $subject_id,
            'created_by' => $created_by_id,
            'dt_created' => $date
        );

        if ($add_content_type->name == 'Study Material') {
            $relations_data['studymaterial_id'] = $module_id;
            $columnname = 'studymaterial_id';
            $tablename = 'cmsstudymaterial_relations';
            //$this->Contents_model->add_relation_in_studymaterial($relations_data);
        }

        if ($add_content_type->name == 'Question Bank') {
            $relations_data['questionbank_id'] = $module_id;
            $columnname = 'questionbank_id';
            $tablename = 'cmsquestionbank_relations';
            //$this->Contents_model->add_relation_in_questionbank($relations_data);
        }

        if ($add_content_type->name == 'Sample Papers') {
            $relations_data['samplepaper_id'] = $module_id;
            $columnname = 'samplepaper_id';
            $tablename = 'cmssamplepapers_relations';
            //$this->Contents_model->add_relation_in_samplepapers($relations_data);
        }

        if ($add_content_type->name == 'Solved Papers') {
            $relations_data['solvedpapers_id'] = $module_id;
            $columnname = 'solvedpapers_id';
            $tablename = 'cmssolvedpapers_relations';

            //$this->Contents_model->add_relation_in_solvedpapers($relations_data);
        }

        if ($add_content_type->name == 'Notes') {
			unset($relations_data);
			 $relations_data = array(
            'category_id' => $exam_id,
            'top_category_id' => '21',
            'subject_id' => $subject_id,
            'article_id' => $module_id,
            'created_by' => $created_by_id,
            'dt_created' => $date
        );
            $columnname = 'article_id';
            $tablename = 'relatedpostings';
            //$this->Contents_model->add_relation_in_notes($relations_data);
        }

        if ($add_content_type->name == 'Books') {
            $relations_data['books_id'] = $module_id;
            $columnname = 'books_id';
            $tablename = 'cmsbooks_relations';
            //$this->Contents_model->add_relation_in_books($relations_data);
        }

        if ($add_content_type->name == 'Ncert Solutions') {
            $relations_data['ncertsolutions_id'] = $module_id;
            $columnname = 'ncertsolutions_id';
            $tablename = 'cmsncertsolutions_relations';
            //$this->Contents_model->add_relation_in_ncertsolutions($relations_data);
        }

        if ($add_content_type->name == 'Online Tests') {
            $relations_data['onlinetest_id'] = $module_id;
            $columnname = 'onlinetest_id';
            $tablename = 'cmsonlinetest_relations';
            //$this->Contents_model->add_relation_in_onlinetest($relations_data);
        }

        if ($add_content_type->name == 'Videos') {
            $relations_data['videolist_id'] = $module_id;
            $columnname = 'videolist_id';
            $tablename = 'cmsvideolist_relations';
            //$this->Contents_model->add_relation_in_videos($relations_data);
        }
	
        if (count($chapter_ids) > 0) {
            foreach ($chapter_ids as $key => $value) {
                $relations_data['chapter_id'] = $value;
                $this->Contents_model->addRelation($tablename, $relations_data, $columnname);
            }
        } else {
            $this->Contents_model->addRelation($tablename, $relations_data, $columnname);
        }
				
        $this->session->set_flashdata('message', $add_content_type->name . ' Relationship Added!');
		
		 if ($add_content_type->name == 'Notes') { 
		 
        redirect('admin/listings/edit_listing/' . $module_id );
		 }else{
        redirect('admin/contents/edit/' . $module_id . '/' . $module_type_id);
		 }
    }
    public function add_submit() {
        $this->load->model('Questionbank_model');
        $this->load->model('Samplepapers_model');
        $type = $this->input->post('content_type');
        $questionbankPdf='no';
        $solvedpaperPdf='no';
	    $notesPdf='no';
        $samplepaperPdf='no';
        $type_match_the_coloumn = 11;
        $studypdf_path=$this->config->item('studypdf_path');
        $action = 0;
        $item_id = 0;
        $is_deleted = 0;
        $contents = '';
        $date = time();
        $created_by_id = $this->session->userdata("userid");
        $zipfolder_path = '/upload/pdfs/';
        $zipfolder_path_one = $studypdf_path;
        $common_file_name = '';
        $display_file_name = '';
        $fileupload = 'no';
        $var_filename_one = '';
        $var_filename_zero = '';
        $exam_id = $this->input->post('category');
        $subexam_id = $this->input->post('sub_category');
        $subject_id = $this->input->post('subject');
        $chapter_id = $this->input->post('chapter');
		if(isset($subexam_id)&&$subexam_id>0){
		$subject_id = $subexam_id;	
		}else{
		$subject_id = $this->input->post('subject');	
		}
		/*For Upload in hindi english language*/
       $language_post = $this->input->post('language');
        if(isset($language_post)&&$language_post!=''){
			$language_var=$language_post;
		}else{
			$language_var='english';
		}
		
        if(null !=$this->input->post('studypackage_feed')){
        $studypackage_feed=$this->input->post('studypackage_feed');
        }else{
        $studypackage_feed=0;
        }
        $upload_type = $this->input->post('upload_type');
        $product_expiry_date=$this->input->post('product_expiry_date');
        $discounted_price_others = $this->input->post('discounted_price_others');
        $add_content_type = $this->Content_model->getContentTypeDetail($type);
        //print_r($add_content_type);die;
        if ($add_content_type->name == 'Article') {

            if (($exam_id < 1)) {
                $this->session->set_flashdata('message', 'Please select Exam Values.');
                redirect('admin/contents/add');
            }
            if ((empty($_FILES['article_zip_file']['name'])) || ($_FILES['article_zip_file']['name'] == '')) {
                $this->session->set_flashdata('message', 'Please Upload Zip file!');
                redirect('admin/contents/add');
           }
                $zip_field_name_html = 'article_zip_file';
        } else {
            $zip_field_name_html = 'html_zip_file';
            if ($add_content_type->name != 'Videos') {
                $this->form_validation->set_rules('name', 'Name', 'required');
                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata('message', 'Please Enter Name!');
                    redirect('admin/contents/add');
                }
            }
        }
        //$this->form_validation->set_rules('price', 'Price', 'required');
        if ($add_content_type->name == 'Solved Papers') {
            $extractfolder_path = '/upload/webreader_solved/';
        } else {
            $extractfolder_path = '/upload/webreader/';
        }
        $extractfolder_path_html = '/upload/html_folder/';
        $zip_field_name = 'zip_file';
        $zip_field_name_one = 'pdf_file';
        $name = $this->input->post('name');
        $price = $this->input->post('price');
        $cmsquestiontypes = $this->input->post('questions_type');
        $article_title = $name;
        $article_description = $this->input->post('description');
        $common_file_name = $this->input->post('common_file_name');
        $display_file_name = $this->input->post('display_file_name');
        $page_number = $this->input->post('page_number');
        $years = $this->input->post('years');
        if ($add_content_type->name == 'Videos') {
            $upload_type = 1;
        }
        if ($add_content_type->name == 'Online Tests') {
            $upload_type = 2;
            if ($upload_type == 1) {
                $this->session->set_flashdata('message', 'Use Multiple Question Upload button for Online Tests zip Upload!');
                redirect('admin/contents/add');
            }
            /* Insert Question PDF */
            $qus_pdf_field_name = 'qus_pdf';
            if ($_FILES[$qus_pdf_field_name]['name'] != '') {
                $qus_pdf_file_name = upload_extract_file($zipfolder_path_one, $zipfolder_path_one, $qus_pdf_field_name, $extract = 'no');
            } else {
                $qus_pdf_file_name = '';
            }
            /* Insert ans PDF */
            $ans_pdf_field_name = 'ans_pdf';
            if ($_FILES[$ans_pdf_field_name]['name'] != '') {
                $ans_pdf_file_name = upload_extract_file($zipfolder_path_one, $zipfolder_path_one, $ans_pdf_field_name, $extract = 'no');
            } else {
                $ans_pdf_file_name = '';
            }
            /* Insert Solution PDF */
            $solution_pdf_field_name = 'solution_pdf';
            if ($_FILES[$solution_pdf_field_name]['name'] != '') {
                $solution_pdf_file_name = upload_extract_file($zipfolder_path_one, $zipfolder_path_one, $solution_pdf_field_name, $extract = 'no');
            } else {
                $solution_pdf_file_name = '';
            }
            $ol_instructions = $this->input->post('exam_instructions');
            $ol_formula_id = $this->input->post('exam_formula_id');
            $olcategory_id = $this->input->post('olcategory_id');
            $ol_time = $this->input->post('exam_time');
            $ol_type = $this->input->post('exam_type');
            $exam_calculator = $this->input->post('exam_calculator');
            $data = array(
                'name' => $name,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
				'language'=>$language_var,
                'instructions' => $ol_instructions,
                'formula_id' => $ol_formula_id,
                'olcategory_id'=>$olcategory_id,
                'time' => $ol_time,
                'type' => $ol_type,
                'calculater' => $exam_calculator,
                'qus_pdf' => $qus_pdf_file_name,
                'solution_pdf' => $solution_pdf_file_name,
                'ans_pdf' => $ans_pdf_file_name,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );
            $formula_array=$this->Onlinetest_model->formula_detail($ol_formula_id);
            $right_answer_marks=$formula_array->right_answer_marks;
        } else {
            $data = array(
                'name' => $name,
				'language'=>$language_var,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );
        }
           if($studypackage_feed==1){
            $studypackage_feed_data = array(
                'name' => $name,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );    
            }
            /*SET Merge variable in case of edit section*/
        if(null !=$this->input->post('merge_module_id_post')){
            $merge_module_id=$this->input->post('merge_module_id_post');
            $merge_module_type=$this->input->post('merge_module_type_post');;
            $merge_module_item_id=0;
            }
// Add Upload flex zip section zip
        $fileupload_flex = '';
        $extract_file_name = '';
        $extract_file_name_one = '';
        if ($upload_type == 1||$studypackage_feed==1) {
            /* Upload flex zip section */
            if ($_FILES[$zip_field_name]['name'] != '') {
            $extract_file_name = upload_extract_file($zipfolder_path, $extractfolder_path, $zip_field_name, $extract = 'yes');
            } else {
                $extract_file_name = 'failed';
            }

            if ($_FILES[$zip_field_name_one]['name'] != '') {
                $extract_file_name_one = upload_extract_file($zipfolder_path_one, $zipfolder_path_one, $zip_field_name_one, $extract = 'no');
            } else {
                $extract_file_name_one = 'failed';
            }
            if (($extract_file_name != 'failed') && ($extract_file_name != '') || ($extract_file_name_one != 'failed') && ($extract_file_name_one != '')) {
                $fileupload_flex = 'yes';
                if ($extract_file_name != 'failed') {
                    $var_filename_zero = $extract_file_name;
                }
                if ($extract_file_name_one != 'failed') {
                    $var_filename_one = $extract_file_name_one;
                }
            } else if ($common_file_name != '') {
                $var_filename_zero = $common_file_name;
                $var_filename_one = $common_file_name . '.pdf';
                $fileupload_flex = 'yes';
            }
        } 
        
        if ($upload_type == 2) {
            /* Multiple Upload section for question bank */

            /* Upload questions zip section */

            if ($add_content_type->name != 'Article') {

                if ((empty($_FILES['html_zip_file']['name'])) || ($_FILES['html_zip_file']['name'] == '')) {
                    $this->session->set_flashdata('message', 'Please Upload Zip file!');
                    redirect('admin/contents/add');
                }
            }

            $chaeck_space = preg_match('/\s/', $_FILES[$zip_field_name_html]['name']);

            if (preg_match('/[\'^Â£$&*()}{@#~?><>,|=+Â¬]/', $_FILES[$zip_field_name_html]['name'])) {
                $chaeck_space = 1;
                // one or more of the 'special characters' found in $string
            }

            if ($chaeck_space == 1) {
                $this->session->set_flashdata('message', 'Please check your zip file.Space or special characters found in file name.');
                redirect('admin/contents/add');
                die();
            }

            if ($_FILES[$zip_field_name_html]['name'] != '') {

                $extract_file_name = upload_extract_file($zipfolder_path, $extractfolder_path_html, $zip_field_name_html, $extract = 'yes');

                if ($extract_file_name == 'failed') {
                    //session message is set in function - upload_extract_file 
                    //redirect('admin/contents/add');
                    //die(); 
                }
                $html_folder_name_path = $extractfolder_path_html . $extract_file_name;
                //fatch question answer from uploaded html folder                                     
                $text_question_answer = get_content_array_by_zip($html_folder_name_path, $extractfolder_path_html);

                if (($add_content_type->name == 'Article') || ($add_content_type->name == 'Notes')) {  $fileupload_flex = 'yes';
                    $content_question_answer = $text_question_answer;
                } else {
                    $content_question_answer = clear_html_text($text_question_answer);
                }
            } else {
                $extract_file_name = 'failed';
            }
        }
        /* Start Article Add */
        if (($add_content_type->name == 'Article') || ($add_content_type->name == 'Notes')) {
            /* zip Upload section for Article */
            if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {

                $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                $question_answer_description_count = count($question_answer_description_multiple_array);

                for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {

                    $single_array_qus_ans = clear_html_text_two($question_answer_description_multiple_array[$qa_number]);
                    $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                    $qus_text_var = strip_tags($single_qus_ans[0]);
                    //Remove tabs from contant
                    $qus_text = remove_tabSpace($qus_text_var);
                    $ans_text_var = $single_qus_ans[1];
                    //Remove tabs from contant
                    $ans_text = remove_tabSpace($ans_text_var);
                    if($display_file_name==''){
                        $artiTitle=custom_strip_tags($qus_text);
                    }else{
                        $artiTitle=$display_file_name;
                    }
                    
                    $article_data = array(
                        'category_id' => $exam_id,
                        'subject_id' => $subject_id,
                        'chapter_id' => $chapter_id,
				        'language'=>$language_var,
                        'user_id' => $created_by_id,
                        'dt_created' => $date,
                        'title' => $artiTitle,
                        'description' => $ans_text_var,
                        'top_category_id' => '21',
                        'published' => '1'
                    );
                    $article_insert_id = $this->Contents_model->add_article($article_data);
                }
            }
            $merge_module_id=$article_insert_id;
            $merge_module_type=$add_content_type->id;
            $merge_module_item_id=0;
            
            $this->session->set_flashdata('message', 'Article Or Notes Contents Added!');
            if($studypackage_feed==1){
            $notesPdf='yes';
            }
        }


        if ($add_content_type->name == 'Question Bank') {
            // Entry in DB
            $questoin_bank_insert_id = $this->Contents_model->add_question_bank($data);
            $relations_data = array(
                'questionbank_id' => $questoin_bank_insert_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );

            $this->Contents_model->add_relation_in_questionbank($relations_data);

            if ($upload_type == 1) {
                /* Upload zip section */
                if ($fileupload_flex == 'yes') {
                    // There is know single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $extract_file_name = rm_zip_ext($extract_file_name);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );
                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $questoin_bank_insert_id,
                            'modules_item_name' => $name
                        );
                        //No need to set price
                        //$this->Contents_model->add($price_data);
                    }
                    $data_questoin_bank_details = array(
                        'questionbank_id' => $questoin_bank_insert_id,
                        'question_id' => 0,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );

                    $this->Contents_model->add_cmsquestionbank_details($data_questoin_bank_details);
                }
            } else {
                /* Multiple Upload section for question bank */
                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {

                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);


                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {


                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);

                        /* Modification for Match the column ans provided in variable which will be used bellow */
                        $qus_option_var = $single_qus_ans[0];
                        $qus_text_var = $qus_option_var;
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);
                        if (isset($single_qus_ans[1])) {
                            $ans_text_var = $single_qus_ans[1];
                        } else {
                            $ans_text_var = '';
                        }
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];

                        $section_instructions_array = explode('*-ENTER_SECTION-*', $type_instructions_array[1]);

                        if (isset($section_instructions_array[0]) && ($section_instructions_array[0] != '')) {
                            $instructions_id = $section_instructions_array[0];
                        } else {
                            $instructions_id = 0;
                        }

                        $sectionname_array = $section_instructions_array[1];
                        $section_array = explode('-', $sectionname_array);
                        $section_name = $section_array[0];

                        if (isset($section_name) && $section_name != '') {

                            $section = $section_array[1];
                        } else {
                            $this->session->set_flashdata('message', 'Please enter section name in doc file!');
                            redirect('admin/contents/add');
                        }

                        //For Match The Box Only
                        $question_options = '';
                        if ($type_of_qus_ans == $type_match_the_coloumn) {
                            $get_qus_option_array = explode('*-question-options-*', $qus_option_var);
                            $qus_text_var = $get_qus_option_array[0];
                            $qus_text = remove_tabSpace($qus_text_var);
                            $question_options = $get_qus_option_array[1];
                        }

//If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }
                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'type_extra' => trim($question_options),
                            'section' => trim($section),
                            'section_name' => trim($section_name),
                            'instructions_id' => trim($instructions_id),
                            'filter' => $page_number,
                            'created_by' => $created_by_id,
                            'dt_created' => $date);

                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);
                        // $module_field_name is db field name
                        $data_questoin_bank_details = array(
                            'questionbank_id' => $questoin_bank_insert_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmsquestionbank_details($data_questoin_bank_details);
                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {

                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                $correct_answer_text = $correct_ans_description[0];
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }
                                $correct_answer_desc = $correct_ans_description_text;
                            }
                            $correct_answer_text_combo = $correct_answer_text;

                            $array_ans_extra = explode('_*_', $correct_answer_text_combo);
                            /* for match  the coloumn only */
                            /* Get value for answer_extra field */
                            $correct_answer_text = $array_ans_extra[0];
                            //For Match The Box Only
                            if ($entry_question_type == $type_match_the_coloumn) {
                                $answer_extra = $array_ans_extra[1];
                            } else {
                                $answer_extra = '';
                            }
                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'answer_extra' => trim($answer_extra),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                    // End Multiple ques ans   
                }
            }
            
            $merge_module_id=$questoin_bank_insert_id;
            
            $merge_module_type=$add_content_type->id;
            
            $merge_module_item_id=0;
            
            if($studypackage_feed==1){
                $questionbankPdf='yes';
            }

        $this->session->set_flashdata('message', 'Question Bank Contents Added!');
        }

        if ($add_content_type->name == 'Sample Papers') {
            // Entry in DB
            $sample_papers_insert_id = $this->Contents_model->add_sample_papers($data);
            $relations_data = array(
                'samplepaper_id' => $sample_papers_insert_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );

            $this->Contents_model->add_relation_in_samplepapers($relations_data);

            if ($upload_type == 1) {
                //Flex single question upload 

                if ($fileupload_flex == 'yes') {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $extract_file_name = rm_zip_ext($extract_file_name);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );
                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $sample_papers_insert_id,
                            'modules_item_name' => $name
                        );
                        //No need to set price
                        //$this->Contents_model->add($price_data);
                    }
                    $data_cmssamplepapers_details = array(
                        'samplepaper_id' => $sample_papers_insert_id,
                        'question_id' => 0,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );
                    $sample_papers_insert_id = $this->Contents_model->add_cmssamplepapers_details($data_cmssamplepapers_details);
                }
            } else {
                // Multiple question upload    
                /* Upload zip section */
                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {

                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);

                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {


                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);

                        /* Modification for Match the column ans provided in variable which will be used bellow */
                        $qus_option_var = $single_qus_ans[0];
                        $qus_text_var = $qus_option_var;
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);


                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];
                        $question_options = '';

                        $section_instructions_array = explode('*-ENTER_SECTION-*', $type_instructions_array[1]);

                        if (isset($section_instructions_array[0]) && ($section_instructions_array[0] != '')) {
                            $instructions_id = $section_instructions_array[0];
                        } else {
                            $instructions_id = 0;
                        }

                        $sectionname_array = $section_instructions_array[1];
                        $section_array = explode('-', $sectionname_array);
                        $section_name = $section_array[0];

                        if (isset($section_name) && $section_name != '') {

                            $section = $section_array[1];
                        } else {
                            $this->session->set_flashdata('message', 'Please enter section name in doc file!');
                            redirect('admin/contents/add');
                        }

                        //For Match The Box Only                        
                        if ($type_of_qus_ans == $type_match_the_coloumn) {
                            $get_qus_option_array = explode('*-question-options-*', $qus_option_var);
                            $qus_text_var = $get_qus_option_array[0];
                            $qus_text = remove_tabSpace($qus_text_var);
                            $question_options = $get_qus_option_array[1];
                        }
                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }

                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'type_extra' => trim($question_options),
                            'section' => trim($section),
                            'section_name' => trim($section_name),
                            'instructions_id' => trim($instructions_id),
                            'filter' => $page_number,
                            'created_by' => $created_by_id,
                            'dt_created' => $date);


                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);
                        // $module_field_name is db field name
                        $data_sample_papers_details = array(
                            'samplepaper_id' => $sample_papers_insert_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmssamplepapers_details($data_sample_papers_details);

                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }


                                $correct_answer_text = $correct_ans_description[0];
                                $correct_answer_desc = $correct_ans_description_text;
                            }

                            //For Match The Box Only
                            if ($entry_question_type == $type_match_the_coloumn) {
                                $answer_extra = $correct_answer_desc;
                                
                            } else {
                                $answer_extra = '';
                            }

                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'answer_extra' => trim($answer_extra),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                }
                // End Multiple ques ans   
            }

            //echo "<h3>Samplepapers Contents Added!</h3>";
            $merge_module_id=$sample_papers_insert_id;
            
            $merge_module_type=$add_content_type->id;
            
            $merge_module_item_id=0;
            if($studypackage_feed==1){
            $samplepaperPdf='yes';
             }
            $this->session->set_flashdata('message', 'Samplepapers Contents Added!');
        }

        if ($add_content_type->name == 'Solved Papers') {
            $solved_papers_data = array(
                'name' => $name,
                'years' => $years,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );
            // Entry in DB
            $solvedpapers_insert_id = $this->Contents_model->add_solvedpapers($solved_papers_data);
            $relations_data = array(
                'solvedpapers_id' => $solvedpapers_insert_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );

            $this->Contents_model->add_relation_in_solvedpapers($relations_data);

            if ($upload_type == 1) {
                // Add new Solved paper Flex and pdf through upload zip
                if ($fileupload_flex == 'yes') {
                    // There is know single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $extract_file_name = rm_zip_ext($extract_file_name);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );
                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $solvedpapers_insert_id,
                            'modules_item_name' => $name
                        );
                        //No need to set price
                        //$this->Contents_model->add($price_data);
                    }
                    $data_solvedpapers_details = array(
                        'solvedpapers_id' => $solvedpapers_insert_id,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );
                    $this->Contents_model->add_cmssolvedpapers_details($data_solvedpapers_details);
                }
            } else {
                // Multiple question upload    
                /* Upload zip section */

                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {

                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);

                    $question_answer_description_count = count($question_answer_description_multiple_array);

                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {

                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                        /* Modification for Match the column ans provided in variable which will be used bellow */
                        $qus_option_var = $single_qus_ans[0];
                        $qus_text_var = $qus_option_var;
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);
                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];
                        $question_options = '';

                        //For Match The Box Only                        
                        if ($type_of_qus_ans == $type_match_the_coloumn) {
                            $get_qus_option_array = explode('*-question-options-*', $qus_option_var);
                            $qus_text_var = $get_qus_option_array[0];
                            $qus_text = remove_tabSpace($qus_text_var);
                            $question_options = $get_qus_option_array[1];
                        }


                        $section_instructions_array = explode('*-ENTER_SECTION-*', $type_instructions_array[1]);

                        if (isset($section_instructions_array[0]) && ($section_instructions_array[0] != '')) {
                            $instructions_id = $section_instructions_array[0];
                        } else {
                            $instructions_id = 0;
                        }

                        $sectionname_array = $section_instructions_array[1];
                        $section_array = explode('-', $sectionname_array);
                        $section_name = $section_array[0];

                        if (isset($section_name) && $section_name != '') {

                            $section = $section_array[1];
                        } else {
                            $this->session->set_flashdata('message', 'Please enter section name in doc file!');
                            redirect('admin/contents/add');
                        }

                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }
                        
                        if($chapter_id>0){
                            $solved_chapter_id=$chapter_id;
                        }else{
                            $solved_chapter_id='NULL';
                        }
                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'type_extra' => trim($question_options),
                            'section' => trim($section),
                            'section_name' => trim($section_name),
                            'instructions_id' => trim($instructions_id),
                            'chapter_id'=>$chapter_id,
                            'filter' => $page_number,
                            'created_by' => $created_by_id,
                            'dt_created' => $date);

                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);
                        // $module_field_name is db field name
                        $data_solvedpapers_details = array(
                            'solvedpapers_id' => $solvedpapers_insert_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmssolvedpapers_details($data_solvedpapers_details);

                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }
                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }


                                $correct_answer_text = $correct_ans_description[0];
                                $correct_answer_desc = $correct_ans_description_text;
                            }
                            //For Match The Box Only
                            if ($entry_question_type == $type_match_the_coloumn) {
                                $answer_extra = $correct_answer_desc;
                                
                            } else {
                                $answer_extra = '';
                            }
                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'answer' => trim($correct_answer_text),
                                'answer_extra' => trim($answer_extra),
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                }
                // End Multiple ques ans   
            }
            
            $merge_module_id=$solvedpapers_insert_id;
            $merge_module_type=$add_content_type->id;
            $merge_module_item_id=0;
             if($studypackage_feed==1){
            $solvedpaperPdf='yes';
             }
            $this->session->set_flashdata('message', 'Solved Papers Contents Added!');
        }

        if ($add_content_type->name == 'Online Tests') {
            // Entry in DB
            $onlinetest_insert_id = $this->Contents_model->add_onlinetest($data);
            /*save comman file name online test table*/
                $var_filename_zero = rm_zip_ext($var_filename_zero);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );

                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    /*update relation online test for file id*/
                  
            
            $relations_data = array(
                'onlinetest_id' => $onlinetest_insert_id,
                'file_id'=>$cmsfiles_last_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );
            $this->Contents_model->add_relation_in_onlinetest($relations_data);
            if ($price > 0) {
                $price_data = array(
                    'exam_id' => $exam_id,
                    'subject_id' => $subject_id,
                    'chapter_id' => $chapter_id,
                    'item_id' => $item_id,
                    'type' => $type,
                    'price' => $price,
                    'discounted_price' => $discounted_price_others,
                    'product_expiry_date'=> $product_expiry_date,
                    'created_by' => $created_by_id,
                    'dt_created' => $date,
                    'modules_item_id' => $onlinetest_insert_id,
                    'modules_item_name' => $name
                );

                $this->Contents_model->add($price_data);
            }
            if ($upload_type == 1) {
                /* Upload zip section */
                if ($fileupload_flex == 'yes') {
                    $this->session->set_flashdata('message', 'Online Tests Can not be saved as pdf or doc!');
                    redirect('admin/contents/add');
                }
            } else {

                /* Multiple Upload section for question bank */
                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {

                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);


                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {
                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                        $qus_option_var = $single_qus_ans[0];
                        $qus_text_var = $qus_option_var;
                        $qus_text = remove_tabSpace($qus_text_var);
                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];

                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];
                        $question_options = '';

                        //For Match The Box Only                        
                        if ($type_of_qus_ans == $type_match_the_coloumn) {
                            $get_qus_option_array = explode('*-question-options-*', $qus_option_var);
                            $qus_text_var = $get_qus_option_array[0];
                            $qus_text = remove_tabSpace($qus_text_var);
                            $question_options = $get_qus_option_array[1];
                        }


                        $section_instructions_array = explode('*-ENTER_SECTION-*', $type_instructions_array[1]);

                        if (isset($section_instructions_array[0]) && ($section_instructions_array[0] != '')) {
                            $instructions_id = $section_instructions_array[0];
                        } else {
                            $instructions_id = 0;
                        }

                        $sectionname_array = $section_instructions_array[1];
                        $section_array = explode('-', $sectionname_array);
                        $section_name = $section_array[0];

                        if (isset($section_name) && $section_name != '') {

                            $section = $section_array[1];
                        } else {

                            $this->session->set_flashdata('message', 'Please enter section name in exam doc File!');
                            redirect('admin/contents/add');
                        }
                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }

                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'type_extra' => trim($question_options),
                            'section' => trim($section),
                            'section_name' => trim($section_name),
                            'instructions_id' => trim($instructions_id),
                            'filter' => $page_number,
                            'created_by' => $created_by_id,
                            'dt_created' => $date);

                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);
                        // $module_field_name is db field name
                        $data_onlinetest_details = array(
                            'onlinetest_id' => $onlinetest_insert_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'marks'=>$right_answer_marks,
                            'created_by' => $created_by_id,
                            'dt_created' => $date
                        );
                        $this->Contents_model->add_onlinetest_details($data_onlinetest_details);
                        $ans_option_text = explode('*-answer-options-*', $ans_text);

                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;

                                $correct_answer_text = $correct_ans_description[0];


                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }

                                $correct_answer_desc = $correct_ans_description_text;
                            }
                            $correct_answer_text_combo = $correct_answer_text;

                            $array_ans_extra = explode('_*_', $correct_answer_text_combo);
                            /* for match  the coloumn only */
                            /* Get value for answer_extra field */
                            $correct_answer_text = $array_ans_extra[0];
                            //For Match The Box Only
                            if ($entry_question_type == $type_match_the_coloumn) {
                                $answer_extra = $array_ans_extra[1];
                                
                            } else {
                                $answer_extra = '';
                            }

                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'answer' => trim($correct_answer_text),
                                'answer_extra' => trim($answer_extra),
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                    // End Multiple ques ans   
                }
            }
            
            $merge_module_id=$onlinetest_insert_id;
            $merge_module_type=$add_content_type->id;
            $merge_module_item_id=0;
            $this->session->set_flashdata('message', 'Online Tests Contents Added!');
        }

        if ($add_content_type->name == 'Ncert Solutions') {
            // Entry in DB

            $ncertsolutions_insert_id = $this->Contents_model->add_ncertsolutions($data);

            $relations_data = array(
                'ncertsolutions_id' => $ncertsolutions_insert_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );

            $this->Contents_model->add_relation_in_ncertsolutions($relations_data);

            // Add new ncert solutions and upload zip
            if ($upload_type == 1) {
                if ($fileupload_flex == 'yes') {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $extract_file_name = rm_zip_ext($extract_file_name);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );
                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $ncertsolutions_insert_id,
                            'modules_item_name' => $name
                        );
                        //No need to set price
                        //$this->Contents_model->add($price_data);
                    }
                    $data_ncertsolutions_details = array(
                        'ncertsolutions_id' => $ncertsolutions_insert_id,
                        'question_id' => 0,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );
                    $this->Contents_model->add_cmsncertsolutions_details($data_ncertsolutions_details);
                }
            } else {
                /* Multiple Upload section for question bank */
                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {
                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);
                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {
                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                        $qus_text_var = $single_qus_ans[0];
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);

                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];
                        if (isset($type_instructions_array[1]) && ($type_instructions_array[1] != '')) {
                            $instructions_id = $type_instructions_array[1];
                        } else {
                            $instructions_id = 0;
                        }

                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }

                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'instructions_id' => trim($instructions_id),
                            'filter' => $page_number,
                            'created_by' => $created_by_id,
                            'dt_created' => $date);
                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);
                        $data_ncertsolutions_details = array(
                            'ncertsolutions_id' => $ncertsolutions_insert_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmsncertsolutions_details($data_ncertsolutions_details);
                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }

                                $correct_answer_text = $correct_ans_description[0];
                                $correct_answer_desc = $correct_ans_description_text;
                            }

                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                }
            }
            $merge_module_id=$ncertsolutions_insert_id;
            $merge_module_type=$add_content_type->id;
            $merge_module_item_id=0;
            $this->session->set_flashdata('message', 'Ncert Contents Added!');
        }

        /* Start Video section */
        if ($add_content_type->name == 'Videos') {
            //For Playlist
            $upload_type = $this->input->post('video_upload_type');
            if ($upload_type == "playlist") {
                if ($exam_id < 1) {
                    $this->session->set_flashdata('message', 'select Exam type.');
                    redirect('admin/contents/add');
                    die();
                }
                $playlist_name = $this->input->post('playlist_name');
                $playlist_description = $this->input->post('playlist_description');
                $playlist_data = array(
                    'name' => $playlist_name,
                    'description' => $playlist_description,
                    'created_by' => $created_by_id,
                    'dt_created' => $date
                );
                $playlist_insert_id = $this->Contents_model->add_videos_playlist($playlist_data);

                $relations_data = array(
                    'videolist_id' => $playlist_insert_id,
                    'exam_id' => $exam_id,
                    'subject_id' => $subject_id,
                    'chapter_id' => $chapter_id,
                    'created_by' => $created_by_id,
                    'dt_created' => $date
                );
                $this->Contents_model->add_relation_in_videolist($relations_data);
                $this->session->set_flashdata('message', 'Playlist Added!');
            } else {
                //For Videos
                $video_source = $this->input->post('video_source');
                $video_url_code = $this->input->post('video_url_code');
                $is_featured = $this->input->post('is_featured');
                $description = $this->input->post('description');
                $video_by = $this->input->post('video_by');
                $videolist_by = 'Studyadda';
                $status = $this->input->post('status');
                $custom_video_duration = $this->input->post('custom_video_duration');
                $amazonaws_link = $this->input->post('amazonaws_link');
                $amazon_cloudfront_domain = $this->input->post('amazon_cloudfront_domain');
                $name = $this->input->post('video_name');
                $price = $this->input->post('video_price');
                $video_tag = $this->input->post('video_tag');
                $new_playlist_name = $this->input->post('new_playlist_name');
                $existing_playlist_id = $this->input->post('existing_playlist_id');
                $discounted_price = $this->input->post('discounted_price');
                $common_file_name = $this->input->post('common_file_name_video');
                if ($discounted_price > 0) {
                    $discounted_price = $this->input->post('discounted_price');
                } else {
                    $discounted_price = 0;
                }

                //Array for video description
                if ($existing_playlist_id < 1) {
                    $this->session->set_flashdata('message', 'select existing playlist name.');
                    redirect('admin/contents/add');
                    die();
                }

                //'description' => $description,
                //'video_by' => $videolist_by, 
                //Error chaking for video        
                $this->form_validation->set_rules('video_name', 'Name', 'required');
                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata('message', 'Please enter Video name!');
                    redirect('admin/contents/add');
                }
                if ($upload_type == 1) {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as videos
                    $videofolder_path = '/assets/videoimages/';
                    $video_file_field_name = 'video_file';
                    if ($_FILES[$video_file_field_name]['name'] != '') {

                        $extract_file_name_one = upload_extract_file($videofolder_path, '', $video_file_field_name, $extract = 'no');
                        if (($extract_file_name_one != 'failed') && ($extract_file_name_one != '')) {
                            $var_filename_video = $extract_file_name_one;
                        } else if ($common_file_name != '') {
                            $var_filename_video = $common_file_name;
                        }
                    } else {
                        $var_filename_video = '';
                    }
                    $filetype = 'videos';
                    $data_files = array(
                        'title' => $name,
                        'video_source' => $video_source,
                        'video_url_code' => $video_url_code,
                        'video_file_name' => $var_filename_video,
                        'video_url_code' => $video_url_code,
                        'is_featured' => $is_featured,
                        'description' => $description,
                        'video_by' => $video_by,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'status' => $status,
                        'video_tag' => $video_tag,
                        'custom_video_duration' => $custom_video_duration,
                        'amazonaws_link' => $amazonaws_link,
                        'amazon_cloudfront_domain' => $amazon_cloudfront_domain
                    );
                    $cmsfiles_last_id = $this->Contents_model->add_cmsvideos($data_files);

                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $existing_playlist_id,
                            'modules_item_name' => $name
                        );
                        $this->Contents_model->add($price_data);
                    }
                    $imagefolder_path = '/assets/videoimages/';
                    $video_image_field_name = 'video_image';
                    // Video image upload
                    $videoimage_file_name = '';
                    if ($_FILES[$video_image_field_name]['name'] != '') {

                        $videoimage_file_name = video_image_upload($imagefolder_path, $video_image_field_name, $cmsfiles_last_id);
                    }

                    if (($videoimage_file_name == '') || ($videoimage_file_name == 'failed')) {
                        $videoimage_file_name = $cmsfiles_last_id . '.jpg';
                    }
                    // update image field
                    $data_video_image = array(
                        'video_image' => $videoimage_file_name
                    );
                    $this->Contents_model->update_cmsvideos($cmsfiles_last_id, $data_video_image);
                    $data_videos_details = array(
                        'videolist_id' => $existing_playlist_id,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'video_id' => $cmsfiles_last_id
                    );
                    $this->Contents_model->add_cmsvideoslist_details($data_videos_details);
                } else {
                    $this->session->set_flashdata('message', 'Multiple question can not be added in videos');
                    redirect('admin/contents/add');
                    die();
                }
                $this->session->set_flashdata('message', 'Video Contents Added!');
            }
        }
        /* End Video Section */
        /*Start Book Section Books_model*/
		  if ($add_content_type->name == 'Books') {
            $books_insert_id = $this->Contents_model->add_books($data);
            $relations_data = array(
                'books_id' => $books_insert_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );
            $this->Contents_model->add_relation_in_books($relations_data);
            if ($upload_type == 1) {
                if ($fileupload_flex == 'yes') {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $extract_file_name = rm_zip_ext($extract_file_name);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );
                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $books_insert_id,
                            'modules_item_name' => $name
                        );
                        $this->Contents_model->add($price_data);
                    }
                    $data_books_details = array(
                        'books_id' => $books_insert_id,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );
                    $this->Contents_model->add_cmsbooks_details($data_books_details);
                }
            } 
		}
		/*End Book Section*/
		/* Start StudyMaterial Add */
        if ($add_content_type->name == 'Study Material') {
            $studymaterial_insert_id = $this->Contents_model->add_studymaterial($data);
            $relations_data = array(
                'studymaterial_id' => $studymaterial_insert_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );
            $this->Contents_model->add_relation_in_studymaterial($relations_data);
            if ($upload_type == 1) {
                if ($fileupload_flex == 'yes') {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $extract_file_name = rm_zip_ext($extract_file_name);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );
                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $studymaterial_insert_id,
                            'modules_item_name' => $name
                        );
                        $this->Contents_model->add($price_data);
                    }
                    $data_studymaterial_details = array(
                        'studymaterial_id' => $studymaterial_insert_id,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );
                    $this->Contents_model->add_cmsstudymaterial_details($data_studymaterial_details);
                }
            } else {
                /* Multiple Upload section for Studymaterial */
                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {

                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);

                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {
                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                        $qus_text_var = $single_qus_ans[0];
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);
                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];
                        if (isset($type_instructions_array[1]) && ($type_instructions_array[1] != '')) {
                            $instructions_id = $type_instructions_array[1];
                        } else {
                            $instructions_id = 0;
                        }

                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }

                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'instructions_id' => trim($instructions_id),
                            'created_by' => $created_by_id,
                            'filter' => $page_number,
                            'dt_created' => $date);

                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);
                        // $module_field_name is db field name
                        $data_studymaterial_details = array(
                            'studymaterial_id' => $studymaterial_insert_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmsstudymaterial_details($data_studymaterial_details);

                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        $correct_ans_description = '';
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }


                                $correct_answer_text = $correct_ans_description[0];
                                $correct_answer_desc = $correct_ans_description_text;
                            }

                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                    // End Multiple ques ans   
                }
            }
        $this->session->set_flashdata('message', 'Studymaterial Contents Added!');
        }
        
        /* Start Feed for StudyMaterial Merge Section Add */
        if ($studypackage_feed==1) {
            $type=1;   
            $upload_type=1;
            $checkExist='no';
            /*Check If studypackeg is already exist Starts*/
            $productname=$studypackage_feed_data['name'];
            $check_sminfo_array=$this->Contents_model->check_sminfo($productname,$exam_id,$subject_id,$chapter_id);
            /*Check If ends*/
            $check_sminfo_count=count($check_sminfo_array);
            if($check_sminfo_count>0){
            $checkExist='yes';
            }
            if($checkExist=='yes'){
                $studymaterial_insert_id=$check_sminfo_array[0]->miid;
                $cmsfiles_last_id==$check_sminfo_array[0]->id;
            }else if($checkExist=='no'){
                if ($fileupload_flex != 'yes') { 
                $this->session->set_flashdata('message', 'PDF file not uploaded!');
                redirect('admin/contents/add'); die;
                }
                $studymaterial_insert_id = $this->Contents_model->add_studymaterial($studypackage_feed_data);
            $relations_data = array(
                'studymaterial_id' => $studymaterial_insert_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );
            $this->Contents_model->add_relation_in_studymaterial($relations_data);
                if ($fileupload_flex == 'yes') {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $extract_file_name = rm_zip_ext($extract_file_name);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );
                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $studymaterial_insert_id,
                            'modules_item_name' => $name
                        );
                        $this->Contents_model->add($price_data);
                    }
                    $data_studymaterial_details = array(
                        'studymaterial_id' => $studymaterial_insert_id,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );
                    $this->Contents_model->add_cmsstudymaterial_details($data_studymaterial_details);
                }
            
        }
            /*Merge Section Entry start*/
            $merge_rel_module_id=$studymaterial_insert_id;
            $merge_rel_module_type=1;
            $merge_related_file_id=$cmsfiles_last_id;
            
            if(!isset($merge_module_id)){
                $merge_module_id=0;
            }
            
            if(!isset($merge_module_type)){
                $merge_module_type=0;
            }
            if($merge_module_id>0&&$merge_module_type>0){
            if($merge_rel_module_id>0&&$merge_related_file_id>0&&$merge_rel_module_type>0){ $currentdate=date("d/m/Y");
            $this->load->model('Mergesection_model');
            $mergedata=array(
            'module_id'=>$merge_module_id,
            'module_type'=>$merge_module_type,
            'module_item_id'=>$merge_module_item_id,
            'related_module_id'=>$merge_rel_module_id,
            'related_module_type'=>$merge_rel_module_type, 
            'related_file_id'=>$merge_related_file_id,
            'created_at'=>$currentdate 
            ); 
            $this->Mergesection_model->merge_module($mergedata);
            }    
            }
            if(isset($var_filename_one) && ($var_filename_one != '')){
              $var_filename_one =$var_filename_one;
            }else{
            if(isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {
                   $var_filename_one =$extract_file_name.'_autogen.pdf';
                }else{
                   $var_filename_one =$studymaterial_insert_id.'_autogen.pdf';
                }    
            }
            /*Merge Section End*/
            if(file_exists(FCPATH."upload/pdfs/".$var_filename_one)&&$var_filename_one!=''){
            //Do not need to create online PDF file
            $this->session->set_flashdata('message', 'Merge Section Studymaterial Contents Added! <font color="red">Online file not created.</font>');
            }else{
            //create online pdf if pdf file not uploaded 
           $sequrecode=$merge_module_id.'_st@ad_'.$merge_module_id;
           $sequrecode = encrypt($sequrecode);
           //Set parameters
//$apikey_old_naveen.synsoft =   '6be3239c-86a8-45f8-9217-80f723caae07';
//oldnvnjoshi.online ='63e4805e-61ce-4ff6-99fa-9860759aa90a'
//*sardanatutorials@gmail.com $apikey ='24047cd0-f890-44b1-ad03-5a7ad7d4e8c0';
//
//javed.khan1394@gmail.com  ='195a64d6-c9e5-4d57-be95-1a5e582ea96f';
//apoorvepandey15@gmail.com='529038b1-683c-4459-b32e-16621e6a4da1';
//*/
//sardanatutorials        
$apikey ='24047cd0-f890-44b1-ad03-5a7ad7d4e8c0';

if(isset($chapter_id)&&$chapter_id>0){
    $chaptersInfo=$this->Chapters_model->getChapter($chapter_id);
    $chapter_idUrl=url_title($chaptersInfo->slug,'-',true);
}else{
    $chapter_idUrl='chapter';
}
if(isset($subject_id)&&$subject_id>0){
    $subjectsInfo=$this->Subjects_model->getSubject($subject_id);
    $subject_idUrl=url_title($subjectsInfo->name,'-',true);
}else{
    $subject_idUrl='subject';
}
            if(($solvedpaperPdf=='yes')||$merge_module_type==10){
$value = base_url().'pdfsolved-papers/class/'.$subject_idUrl.'/'.$chapter_idUrl.'/topic/'.$sequrecode;
            }
            if(($questionbankPdf=='yes')||$merge_module_type==7){
$value = base_url().'pdfquestion-bank/class/'.$subject_idUrl.'/'.$chapter_idUrl.'/topic/'.$sequrecode;
            }
            if(($notesPdf=='yes')||$merge_module_type==8){
$value = base_url().'pdfnotes/class/'.$subject_idUrl.'/'.$chapter_idUrl.'/topic/'.$sequrecode;
            }
            if(($samplepaperPdf=='yes')||$merge_module_type==6){
$value = base_url().'pdfsample-papers/class/'.$subject_idUrl.'/'.$chapter_idUrl.'/topic/'.$sequrecode;
            }	   
//
// Note that by default all page margins are set to zero - so to make space in the bottom for the footer we set the bottom margin to a higher value
                    
//$result = file_get_contents("http://api.html2pdfrocket.com/pdf?apikey=" . urlencode($apikey) . "&value=" . urlencode($value) . "&MarginBottom=10");

//&FooterUrl=" . urlencode("http://www.html2pdfrocket.com/Examples/footer.htm")

//file_put_contents(FCPATH."upload/pdfs/".$var_filename_one, $result);

$this->session->set_flashdata('message', 'Merge Section Studymaterial Contents Added! <font color="red">Online file created.</font>');
        }   
        }
        sleep(10);
        redirect('admin/contents/add');
        die();
        //$this->data['content'] = 'contents/add';
        //$this->load->view('common/template', $this->data);
}
//add_submit end adding
//start sortchapter_submit

    public function  sortchapter_submit(){
		
	$content_type = $this->input->post('content_type');
	$exam_id = $this->input->post('category');
        $subject_id = $this->input->post('subject');
        $chapter_id = $this->input->post('chapter');
		$chapter_sortid=$this->input->post('chapter_sortid');
		 $sortreturn=$this->Contents_model->update_SortChapter($content_type,$exam_id,$subject_id,$chapter_id,$chapter_sortid);
		 
		 if($sortreturn==true){
			
            $this->session->set_flashdata('message', 'Sorting updated'); 
		 }else{
			 
            $this->session->set_flashdata('message', 'Please enter all field!');
		 }
		 sleep(10);
        redirect('admin/contents/sortlist');
        die();
}

//End sortchapter_submit
    public function edit_submit() { 
        $studypdf_path=$this->config->item('studypdf_path');
        $type_match_the_coloumn = 11;
        $type = $this->input->post('content_type');
        $edit_content_type = $this->Content_model->getContentTypeDetail($type);
        if ($edit_content_type->name == 'Videos') {
            $upload_type = 1;
            $form_validation_value = TRUE;
        } else {
            $this->form_validation->set_rules('name', 'Name', 'required');

            $form_validation_value = $this->form_validation->run();
        }

        $product_expiry_date=$this->input->post('product_expiry_date');
		
		/*For Upload in hindi english language*/
       $language_post = $chapter_id = $this->input->post('language');
        if(isset($language_post)&&$language_post!=''){
			$language_var=$language_post;
		}else{
			$language_var='english';
		}
		
		
        if ($form_validation_value == FALSE) {
            $this->session->set_flashdata('message', 'Please enter name!');
            redirect('admin/contents/edit/' . $this->input->post('module_id') . '/' . $this->input->post('module_type_id'));
        } else {
            $item_id = 0;
            $is_deleted = 0;
            $contents = '';
            $date = time();
            $created_by_id = $this->session->userdata("userid");
            $zipfolder_path = '/upload/pdfs/';
            $zipfolder_path_one = $studypdf_path;
            $zip_field_name_html = 'html_zip_file';
            $zip_field_name = 'zip_file';
            $zip_field_name_one = 'pdf_file';
            $this->load->model('Questionbank_model');
            $this->load->model('Samplepapers_model');
            $name = $this->input->post('name');
            $exam_id = $this->input->post('category');
            $subject_id = $this->input->post('subject');
            $chapter_id = $this->input->post('chapter');
            $exam_id_in_db = $this->input->post('category_in_db');
            $subject_id_in_db = $this->input->post('subject_in_db');
            $chapter_id_in_db = $this->input->post('chapter_in_db');
            $price = $this->input->post('price');
            $cmsquestiontypes = $this->input->post('questions_type');
            $price_table_id = $this->input->post('price_table_id');
            $module_id = $this->input->post('module_id');
            $module_type_id = $this->input->post('module_type_id');
            $common_file_name = $this->input->post('common_file_name');
            $display_file_name = $this->input->post('display_file_name');
            $page_number = $this->input->post('page_number');
            $years = $this->input->post('years');
            $discounted_price_others = $this->input->post('discounted_price_others');
            if (!isset($page_number) || ($page_number == '')) {
                $page_number = 0;
            }
            $upload_type = $this->input->post('upload_type');
            $var_filename_zero = '';
            $var_filename_one = '';

            if ($edit_content_type->name == 'Solved Papers') {
                $extractfolder_path = '/upload/webreader_solved/';
            } else {
                $extractfolder_path = '/upload/webreader/';
            }
            $extractfolder_path_html = '/upload/html_folder/';
        }

        if ($edit_content_type->name == 'Online Tests') {
            
            if ($common_file_name != '') {
                $var_filename_zero = $common_file_name;
                $var_filename_one = $common_file_name . '.pdf';
                $fileupload_flex = 'yes';
            }
            
            $upload_type = 2;
            if ($upload_type == 1) {
                $this->session->set_flashdata('message', 'Use Multiple Question Upload button for Online Tests zip Upload!');
                redirect('admin/contents/edit/' . $this->input->post('module_id') . '/' . $this->input->post('module_type_id'));
            }

            $db_qus_pdf = $this->input->post('db_qus_pdf');
            $db_ans_pdf = $this->input->post('db_ans_pdf');
            $db_solution_pdf = $this->input->post('db_solution_pdf');
            $removepath = $_SERVER['DOCUMENT_ROOT'] . $zipfolder_path_one;
            /* Insert Question PDF */
            $qus_pdf_field_name = 'qus_pdf';
            if ((isset($_FILES[$qus_pdf_field_name]['name']))&&$_FILES[$qus_pdf_field_name]['name'] != '') {

                if (substr($_FILES[$qus_pdf_field_name]['name'], -4) != '.pdf') {
                    $this->session->set_flashdata('message', 'UPLOAD ONLY ZIP FILE FOR ' . $qus_pdf_field_name);
                    //session message is set in function - upload_extract_file 
                    redirect('admin/contents/edit/' . $this->input->post('module_id') . '/' . $this->input->post('module_type_id'));
                    die();
                }
                $qus_pdf_file_name = upload_extract_file($zipfolder_path_one, $zipfolder_path_one, $qus_pdf_field_name, $extract = 'no');
                if ($db_qus_pdf != $qus_pdf_file_name) {
                    unlink($removepath . $db_qus_pdf);
                }
            } else {
                $qus_pdf_file_name = $db_qus_pdf;
            }

            /* Insert ans PDF */
            $ans_pdf_field_name = 'ans_pdf';
            if ((isset($_FILES[$ans_pdf_field_name]['name']))&&$_FILES[$ans_pdf_field_name]['name'] != '') {

                if (substr($_FILES[$ans_pdf_field_name]['name'], -4) != '.pdf') {
                    $this->session->set_flashdata('message', 'UPLOAD ONLY ZIP FILE FOR ' . $ans_pdf_field_name);
                    //session message is set in function - upload_extract_file 
                    redirect('admin/contents/edit/' . $this->input->post('module_id') . '/' . $this->input->post('module_type_id'));
                    die();
                }
                $ans_pdf_file_name = upload_extract_file($zipfolder_path_one, $zipfolder_path_one, $ans_pdf_field_name, $extract = 'no');
                if ($db_ans_pdf != $ans_pdf_file_name) {
                    unlink($removepath . $db_ans_pdf);
                }
            } else {
                $ans_pdf_file_name = $db_ans_pdf;
            }

            /* Insert Solution PDF */
            $solution_pdf_field_name = 'solution_pdf';
            if ((isset($_FILES[$solution_pdf_field_name]['name']))&&$_FILES[$solution_pdf_field_name]['name'] != '') {

                if (substr($_FILES[$solution_pdf_field_name]['name'], -4) != '.pdf') {
                    $this->session->set_flashdata('message', 'UPLOAD ONLY ZIP FILE FOR ' . $solution_pdf_field_name);
                    //session message is set in function - upload_extract_file 
                    redirect('admin/contents/edit/' . $this->input->post('module_id') . '/' . $this->input->post('module_type_id'));
                    die();
                }

                $solution_pdf_file_name = upload_extract_file($zipfolder_path_one, $zipfolder_path_one, $solution_pdf_field_name, $extract = 'no');
                if ($db_solution_pdf != $solution_pdf_file_name) {
                    unlink($removepath . $db_solution_pdf);
                }
            } else {
                $solution_pdf_file_name = $db_solution_pdf;
            }

            $ol_instructions = $this->input->post('exam_instructions');
            $ol_formula_id = $this->input->post('exam_formula_id');
            $olcategory_id=$this->input->post('olcategory_id');
            $ol_time = $this->input->post('exam_time');
			
            $dt_start = $this->input->post('dt_start');
			
            $dt_start_db = $this->input->post('dt_start_db');
			$dt_starthrs = $this->input->post('dt_starthrs');
            $dt_startmin = $this->input->post('dt_startmin');
            $dt_startsec = $this->input->post('dt_startsec');
			
            $dt_end = $this->input->post('dt_end');
            $dt_end_db = $this->input->post('dt_end_db');
            $dt_endhrs = $this->input->post('dt_endhrs');
            $dt_endmin = $this->input->post('dt_endmin');
            $dt_endsec = $this->input->post('dt_endsec');
			
			if(isset($dt_start)&&$dt_start!=''){
				  
				if(isset($dt_starthrs)&&$dt_starthrs>0){
					$dt_starthrs=$dt_starthrs;
				}else{
					$dt_starthrs='00';
				}
				
				if(isset($dt_startmin)&&$dt_startmin>0){
					$dt_startmin=$dt_startmin;
				}else{
					$dt_startmin='00';
				}
				
				if(isset($dt_startsec)&&$dt_startsec>0){
					$dt_startsec=$dt_startsec;
				}else{
					$dt_startsec='00';
				}
				
				$dt_start_normal = $dt_start.$dt_starthrs.$dt_startmin.$dt_startsec;
				$dt_start=strtotime($dt_start_normal);
				}else{
					$dt_start =$dt_start_db; 
					}
if(isset($dt_end)&&$dt_end!=''){
	
	
				if(isset($dt_endhrs)&&$dt_endhrs>0){
					$dt_endhrs=$dt_endhrs;
				}else{
					$dt_endhrs='00';
				}
				
				if(isset($dt_endmin)&&$dt_endmin>0){
					$dt_endmin=$dt_endmin;
				}else{
					$dt_endmin='00';
				}
				
				if(isset($dt_endsec)&&$dt_endsec>0){
					$dt_endsec=$dt_endsec;
				}else{
					$dt_endsec='00';
				}
				
				$dt_end_normal = $dt_end.$dt_endhrs.$dt_endmin.$dt_endsec;  
				$dt_end=strtotime($dt_end_normal);
				
				}else{
					$dt_end =$dt_end_db; 
					}
			
            $ol_type = $this->input->post('exam_type');
            $exam_calculator = $this->input->post('exam_calculator');
            $data = array(
                'name' => $name,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
				'language'=>$language_var,
                'instructions' => $ol_instructions,
                'formula_id' => $ol_formula_id,
                'olcategory_id' => $olcategory_id,
                'time' => $ol_time,
                'type' => $ol_type,
                'calculater' => $exam_calculator,
                'qus_pdf' => $qus_pdf_file_name,
                'ans_pdf' => $ans_pdf_file_name,
                'solution_pdf' => $solution_pdf_file_name,
				'dt_start' => $dt_start,
				'dt_end' => $dt_end,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );
            $formula_array=$this->Onlinetest_model->formula_detail($ol_formula_id);
            $right_answer_marks=$formula_array->right_answer_marks;
			
        } else {
            $data = array(
                'name' => $name,
				'language'=>$language_var,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );
        }

		
        if ($upload_type == 1) {
            /* Upload flex zip section */
            if ($_FILES[$zip_field_name]['name'] != '') {
                $extract_file_name = upload_extract_file($zipfolder_path, $extractfolder_path, $zip_field_name, $extract = 'yes');
            } else {
                $extract_file_name = 'failed';
            }

            if ($_FILES[$zip_field_name_one]['name'] != '') {
                $extract_file_name_one = upload_extract_file($zipfolder_path_one, $zipfolder_path_one, $zip_field_name_one, $extract = 'no');
            } else {
                $extract_file_name_one = 'failed';
            }


            if (($extract_file_name != 'failed') && ($extract_file_name != '') || ($extract_file_name_one != 'failed') && ($extract_file_name_one != '')) {
                $fileupload_flex = 'yes';
                if ($extract_file_name != 'failed') {
                    $var_filename_zero = $extract_file_name;
                }
                if ($extract_file_name_one != 'failed') {
                    $var_filename_one = $extract_file_name_one;
                }
            } else if ($common_file_name != '') {
                $var_filename_zero = $common_file_name;
                $var_filename_one = $common_file_name . '.pdf';
                $fileupload_flex = 'yes';
            }
        } elseif ($upload_type == 2) {
            /* Multiple Upload section for question bank */
            /* Upload questions zip section */

            $chaeck_space = preg_match('/\s/', $_FILES[$zip_field_name_html]['name']);

            if (preg_match('/[\'^Â£$&*()}{@#~?><>,|=+Â¬]/', $_FILES[$zip_field_name_html]['name'])) {
                $chaeck_space = 1;
                // one or more of the 'special characters' found in $string
            }
            if ($chaeck_space == 1) {

                $this->session->set_flashdata('message', 'Please check your zip file.There may be space or special character in file name.');
                redirect('admin/contents/edit/' . $this->input->post('module_id') . '/' . $this->input->post('module_type_id'));
                die();
            }
            if ($_FILES[$zip_field_name_html]['name'] != '') {
                $extract_file_name = upload_extract_file($zipfolder_path, $extractfolder_path_html, $zip_field_name_html, $extract = 'yes');
                if ($extract_file_name == 'failed') {
                    $this->session->set_flashdata('message', 'Multiple Question Zip is not zip file.Please check.');
                    //session message is set in function - upload_extract_file 
                    redirect('admin/contents/edit/' . $this->input->post('module_id') . '/' . $this->input->post('module_type_id'));
                    die();
                }
                //fatch question answer from uploaded html folder 
                $html_folder_name_path = $extractfolder_path_html . $extract_file_name;
$text_question_answer = get_content_array_by_zip($html_folder_name_path, $extractfolder_path_html);

                if (($edit_content_type->name == 'Article') || ($edit_content_type->name == 'Notes')) {
                    $content_question_answer = $text_question_answer;
                } else {
                    $content_question_answer = clear_html_text($text_question_answer);
                }
            } else {
                $extract_file_name = 'failed';
                $content_question_answer = NULL;
            }
        }
        /* Start Question Bank Edit */
        if ($edit_content_type->name == 'Question Bank') {
            // Entry in DB
            $this->Contents_model->update_question_bank($module_id, $data);

            if ($upload_type == 1) {
                /* Upload zip section */

                if ($fileupload_flex == 'yes') {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $var_filename_zero = rm_zip_ext($var_filename_zero);

                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );

                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $module_id,
                            'modules_item_name' => $name
                        );
                        $this->Contents_model->add($price_data);
                    }

                    //Remove from cms question bank
                    //$this->Contents_model->remove_cmsquestionbank_details_by_questionbank_id($module_id);
                    $data_questoin_bank_details = array(
                        'questionbank_id' => $module_id,
                        'question_id' => 0,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );

                    $this->Contents_model->add_cmsquestionbank_details($data_questoin_bank_details);
                }
            } else {

                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {

                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);

                    $question_answer_description_count = count($question_answer_description_multiple_array);

                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {
                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);

                        /* Modification for Match the column ans provided in variable which will be used bellow */
                        $qus_option_var = $single_qus_ans[0];
                        $qus_text_var = $qus_option_var;
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);
                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);

                        $type_of_qus_ans = $type_instructions_array[0];

                        $section_instructions_array = explode('*-ENTER_SECTION-*', $type_instructions_array[1]);


                        if (isset($section_instructions_array[0]) && ($section_instructions_array[0] != '')) {
                            $instructions_id = $section_instructions_array[0];
                        } else {
                            $instructions_id = 0;
                        }
                        $sectionname_array = $section_instructions_array[1];
                        $section_array = explode('-', $sectionname_array);
                        $section_name = $section_array[0];
                        if (isset($section_name) && $section_name != '') {
                            $section = $section_array[1];
                        } else {
                            $this->session->set_flashdata('message', 'Please enter section in your doc file for Question Bank.');
                            redirect('admin/contents/edit/' . $this->input->post('module_id') . '/' . $this->input->post('module_type_id'));
                        }

                        $question_options = '';
                        //For Match The Box Only                        
                        if ($type_of_qus_ans == $type_match_the_coloumn) {
                            $get_qus_option_array = explode('*-question-options-*', $qus_option_var);
                            $qus_text_var = $get_qus_option_array[0];
                            $qus_text = remove_tabSpace($qus_text_var);
                            $question_options = $get_qus_option_array[1];
                        }
                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }
                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'type_extra' => trim($question_options),
                            'section' => trim($section),
                            'section_name' => trim($section_name),
                            'instructions_id' => trim($instructions_id),
                            'filter' => $page_number,
                            'created_by' => $created_by_id,
                            'dt_created' => $date
                        );
						//print_r($data_questoin_text); die;
                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);
                        $data_questoin_bank_details = array(
                            'questionbank_id' => $module_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmsquestionbank_details($data_questoin_bank_details);

                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                $correct_answer_text = $correct_ans_description[0];
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }
                                $correct_answer_desc = $correct_ans_description_text;
                            }
                            
                            $correct_answer_text_combo = $correct_answer_text;
                            $array_ans_extra = explode('_*_', $correct_answer_text_combo);
                            /* for match  the coloumn only */
                            /* Get value for answer_extra field */
                            $correct_answer_text = $array_ans_extra[0];
                            //For Match The Box Only
                            if ($entry_question_type == $type_match_the_coloumn) {
                                $answer_extra = $array_ans_extra[1];
                                
                            } else {
                                $answer_extra = '';
                            }

                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'answer_extra' => trim(answer_extra),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                }
            }
            $this->session->set_flashdata('message', $edit_content_type->name . ' Contents Added!');
        }
        /* Start Sample Papers Edit */
        if ($edit_content_type->name == 'Sample Papers') {
            // Entry in DB
            $this->Contents_model->update_sample_papers($module_id, $data);

            if ($upload_type == 1) {
                /* Upload zip section */
                if ($fileupload_flex == 'yes') {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $var_filename_zero = rm_zip_ext($var_filename_zero);

                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );

                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $module_id,
                            'modules_item_name' => $name
                        );
                        $this->Contents_model->add($price_data);
                    }

                    //Remove from cms question bank
                    //$this->Contents_model->remove_cmsquestionbank_details_by_questionbank_id($module_id);
                    $data_sample_papers = array(
                        'samplepaper_id' => $module_id,
                        'question_id' => 0,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );

                    $this->Contents_model->add_cmssamplepapers_details($data_sample_papers);
                }
            } else {

                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {
                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);

                    if (($question_answer_description_count > 0) && ($content_question_answer != '')) {
                        for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {
                            $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                            $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                            /* Modification for Match the column ans provided in variable which will be used bellow */
                            $qus_option_var = $single_qus_ans[0];
                            $qus_text_var = $qus_option_var;

                            //Remove tabs from contant
                            $qus_text = remove_tabSpace($qus_text_var);
                            $ans_text_var = $single_qus_ans[1];
                            //Remove tabs from contant
                            $ans_text_clean = remove_tabSpace($ans_text_var);
                            $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                            $ans_text = $single_qus_ans_type_break[0];
                            $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                            $type_of_qus_ans = $type_instructions_array[0];

                            $section_instructions_array = explode('*-ENTER_SECTION-*', $type_instructions_array[1]);


                            if (isset($section_instructions_array[0]) && ($section_instructions_array[0] != '')) {
                                $instructions_id = $section_instructions_array[0];
                            } else {
                                $instructions_id = 0;
                            }
                            $sectionname_array = $section_instructions_array[1];
                            $section_array = explode('-', $sectionname_array);
                            $section_name = $section_array[0];
                            if (isset($section_name) && $section_name != '') {
                                $section = $section_array[1];
                            } else {

                                $this->session->set_flashdata('message', 'Please enter section in your doc file for sample paper.');
                                redirect('admin/contents/edit/' . $this->input->post('module_id') . '/' . $this->input->post('module_type_id'));
                            }

                            $question_options = '';
                            //For Match The Box Only                        
                            if ($type_of_qus_ans == $type_match_the_coloumn) {
                                $get_qus_option_array = explode('*-question-options-*', $qus_option_var);
                                $qus_text_var = $get_qus_option_array[0];
                                $qus_text = remove_tabSpace($qus_text_var);
                                $question_options = $get_qus_option_array[1];
                            }

//If question type is NOT available in doc file than only use dropdown value.
                            if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                                $entry_question_type = $type_of_qus_ans;
                            } else {
                                $entry_question_type = $cmsquestiontypes;
                            }

                            $data_questoin_text = array(
                                'question' => trim($qus_text),
                                'type' => $entry_question_type,
                                'type_extra' => trim($question_options),
                                'section' => trim($section),
                                'section_name' => trim($section_name),
                                'instructions_id' => trim($instructions_id),
                                'filter' => $page_number,
                                'created_by' => $created_by_id,
                                'dt_created' => $date);

                            $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);

                            $data_sample_papers = array(
                                'samplepaper_id' => $module_id,
                                'question_id' => $data_questoin_ans_insert_id,
                                'created_by' => $created_by_id,
                                'dt_created' => $date,
                                'file_id' => 0
                            );
                            $this->Contents_model->add_cmssamplepapers_details($data_sample_papers);

                            $ans_option_text = explode('*-answer-options-*', $ans_text);
                            $ans_option_count = count($ans_option_text);
                            // Insert Multiple answer is if exist
                            for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                                //Save multiple answer
                                $correct_answer = '0';
                                $correct_answer_text = $ans_option_text[$ans_cnt];
                                $correct_answer_desc = NULL;
                                $correct_ans_description = NULL;
                                if (isset($ans_option_text[$ans_cnt])) {
                                    $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                                }

                                if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                    $correct_ans_description_text = NULL;
                                    if (isset($correct_ans_description[1])) {
                                        $correct_ans_description_text = $correct_ans_description[1];
                                        $correct_answer = '1';
                                    }
                                    $correct_answer_text = $correct_ans_description[0];
                                    $correct_answer_desc = $correct_ans_description_text;
                                }
                                $correct_answer_text_combo = $correct_answer_text;

                                $array_ans_extra = explode('_*_', $correct_answer_text_combo);
                                /* for match  the coloumn only */
                                /* Get value for answer_extra field */
                                $correct_answer_text = $array_ans_extra[0];
                                //For Match The Box Only
                                if ($entry_question_type == $type_match_the_coloumn) {
                                    $answer_extra = $correct_answer_desc;
                                } else {
                                    $answer_extra = '';
                                }

                                $data_answer_text = array(
                                    'question_id' => $data_questoin_ans_insert_id,
                                    'description' => trim($correct_answer_desc),
                                    'is_correct' => $correct_answer,
                                    'answer' => trim($correct_answer_text),
                                    'answer_extra' => trim($answer_extra),
                                    'created_by' => $created_by_id,
                                    'dt_created' => $date);
                                $this->Answers_model->add($data_answer_text);
                            }
                        }
                    }
                }
            }

            $this->session->set_flashdata('message', $edit_content_type->name . ' Contents Added!');
        }
        /* Start Solved papers edit */
        if ($edit_content_type->name == 'Solved Papers') {
            $solved_papers_data = array(
                'name' => $name,
                'years' => $years,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );
            $this->Contents_model->update_solvedpapers($module_id, $solved_papers_data);
            // Entry in DB


            if ($upload_type == 1) {
                /* Upload zip section */

                if ($fileupload_flex == 'yes') {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $var_filename_zero = rm_zip_ext($var_filename_zero);

                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );

                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $module_id,
                            'modules_item_name' => $name
                        );
                        $this->Contents_model->add($price_data);
                    }

                    //Remove from cms question bank
                    //$this->Contents_model->remove_cmsquestionbank_details_by_questionbank_id($module_id);
                    $data_solvedpapers = array(
                        'solvedpapers_id' => $module_id,
                        'question_id' => 0,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );

                    $this->Contents_model->add_cmssolvedpapers_details($data_solvedpapers);
                }
            } else {
                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {

                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);
                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {
                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                        /* Modification for Match the column ans provided in variable which will be used bellow */
                        $qus_option_var = $single_qus_ans[0];
                        $qus_text_var = $qus_option_var;
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);
                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];
                        $question_options = '';
                        //For Match The Box Only                        
                        if ($type_of_qus_ans == $type_match_the_coloumn) {
                            $get_qus_option_array = explode('*-question-options-*', $qus_option_var);
                            $qus_text_var = $get_qus_option_array[0];
                            $qus_text = remove_tabSpace($qus_text_var);
                            $question_options = $get_qus_option_array[1];
                        }
                        $section_instructions_array = explode('*-ENTER_SECTION-*', $type_instructions_array[1]);
                        if (isset($section_instructions_array[0]) && ($section_instructions_array[0] != '')) {
                            $instructions_id = $section_instructions_array[0];
                        } else {
                            $instructions_id = 0;
                        }

                        $sectionname_array = $section_instructions_array[1];
                        $section_array = explode('-', $sectionname_array);
                        $section_name = $section_array[0];
                        if (isset($section_name) && $section_name != '') {

                            $section = $section_array[1];
                        } else {

                            $this->session->set_flashdata('message', 'Please enter section in your doc file .');
                            redirect('admin/contents/edit/' . $this->input->post('module_id') . '/' . $this->input->post('module_type_id'));
                        }

                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }

                        if($chapter_id>0){
                            $solved_chapter_id=$chapter_id;
                        }else{
                            $solved_chapter_id='NULL';
                        }
                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'type_extra' => trim($question_options),
                            'section' => trim($section),
                            'section_name' => trim($section_name),
                            'instructions_id' => trim($instructions_id),
                            'chapter_id' => $solved_chapter_id ,
                            'created_by' => $created_by_id,
                            'dt_created' => $date);
                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);
                        $data_solvedpapers = array(
                            'solvedpapers_id' => $module_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmssolvedpapers_details($data_solvedpapers);

                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }

                                $correct_answer_text = $correct_ans_description[0];
                                $correct_answer_desc = $correct_ans_description_text;
                            }

                            $correct_answer_text_combo = $correct_answer_text;

                            $array_ans_extra = explode('_*_', $correct_answer_text_combo);
                            /* for match  the coloumn only */
                            /* Get value for answer_extra field */
                            $correct_answer_text = $array_ans_extra[0];
                            //For Match The Box Only
                            if ($entry_question_type == $type_match_the_coloumn) {
                                $answer_extra = $correct_answer_desc;
                               
                            } else {
                                $answer_extra = '';
                            }

                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'answer_extra' => trim($answer_extra),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                }
            }

            $this->session->set_flashdata('message', $edit_content_type->name . ' Contents Added!');
        }
        /* Start Online Test */

        if ($edit_content_type->name == 'Online Tests') {
            // Entry in DB
            $this->Contents_model->update_onlinetest($module_id, $data);
                  /*save comman file name online test table*/
                $var_filename_zero = rm_zip_ext($var_filename_zero);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );                   
                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    /*update online test tale for file id*/
                    $dataFileid= array(
                        'file_id'=>$cmsfiles_last_id
                    );                    
            $this->Contents_model->update_onlinetestrelations($module_id, $dataFileid);
            if ($price > 0) {
                $price_data = array(
                    'exam_id' => $exam_id,
                    'subject_id' => $subject_id,
                    'chapter_id' => $chapter_id,
                    'item_id' => $item_id,
                    'type' => $type,
                    'price' => $price,
                    'discounted_price' => $discounted_price_others,
                    'product_expiry_date'=> $product_expiry_date,
                    'created_by' => $created_by_id,
                    'dt_created' => $date,
                    'modules_item_id' => $module_id,
                    'modules_item_name' => $name
                );
                $this->Contents_model->add($price_data);
            }
            if ($upload_type == 1) {
                /* Upload zip section */

                $this->session->set_flashdata('message', 'Online Tests Can not be saved as pdf or doc!');

                redirect('admin/contents/edit/' . $module_id . '/' . $module_type_id);
            } else {


                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {
                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);


                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {
                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                        $qus_option_var = $single_qus_ans[0];
                        $qus_text_var = $qus_option_var;
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);
                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);

                        $type_of_qus_ans = $type_instructions_array[0];
                        $question_options = '';
                        //For Match The Box Only                        
                        if ($type_of_qus_ans == $type_match_the_coloumn) {
                            $get_qus_option_array = explode('*-question-options-*', $qus_option_var);
                            $qus_text_var = $get_qus_option_array[0];
                            $qus_text = remove_tabSpace($qus_text_var);
                            $question_options = $get_qus_option_array[1];
                        }
                        $section_instructions_array = explode('*-ENTER_SECTION-*', $type_instructions_array[1]);


                        if (isset($section_instructions_array[0]) && ($section_instructions_array[0] != '')) {
                            $instructions_id = $section_instructions_array[0];
                        } else {
                            $instructions_id = 0;
                        }

                        $sectionname_array = $section_instructions_array[1];
                        $section_array = explode('-', $sectionname_array);
                        $section_name = $section_array[0];
                        if (isset($section_name) && $section_name != '') {

                            $section = $section_array[1];
                        } else {

                            $this->session->set_flashdata('message', 'Please Enter section name!');
                            redirect('admin/contents/edit/' . $module_id . '/' . $module_type_id);
                        }
                        //If question type is NOT available in doc file than only use dropdown value.


                        if ($type_of_qus_ans != '' && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }
                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'type_extra' => trim($question_options),
                            'section' => trim($section),
                            'section_name' => trim($section_name),
                            'instructions_id' => trim($instructions_id),
                            'filter' => $page_number,
                            'created_by' => $created_by_id,
                            'dt_created' => $date);
                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);
                        $data_onlinetest_details = array(
                            'onlinetest_id' => $module_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'marks'=>$right_answer_marks,
                            'created_by' => $created_by_id,
                            'dt_created' => $date
                        );
                        $this->Contents_model->add_onlinetest_details($data_onlinetest_details);

                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }

                                $correct_answer_text = $correct_ans_description[0];
                                $correct_answer_desc = $correct_ans_description_text;
                            }
                            //For Match The Box Only
                            if ($entry_question_type == $type_match_the_coloumn) {
                                $answer_extra = $correct_answer_desc;
                                
                            } else {
                                $answer_extra = '';
                            }
                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'answer_extra' => trim($answer_extra),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                }
            }
      
            
            $this->session->set_flashdata('message', $edit_content_type->name . ' Contents Added!');
        }
        /* Start Notes Edit */
        if ($edit_content_type->name == 'Notes') {
            // Entry in DB

            $this->Contents_model->update_notes($module_id, $data);

            if ($upload_type == 1) {


                if ($fileupload_flex == 'yes') {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $var_filename_zero = rm_zip_ext($var_filename_zero);

                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );

                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);


                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $module_id,
                            'modules_item_name' => $name
                        );
                        $this->Contents_model->add($price_data);
                    }
//Remove from cms question bank

                    $data_notes = array(
                        'notes_id' => $module_id,
                        'question_id' => 0,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );

                    $this->Contents_model->add_cmsnotes_details($data_notes);
                }
            } else {

                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {
                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);


                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {


                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                        $qus_text_var = $single_qus_ans[0];
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);


                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];
                        if (isset($type_instructions_array[1]) && ($type_instructions_array[1] != '')) {
                            $instructions_id = $type_instructions_array[1];
                        } else {
                            $instructions_id = 0;
                        }

                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }

                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'instructions_id' => trim($instructions_id),
                            'filter' => $page_number,
                            'created_by' => $created_by_id,
                            'dt_created' => $date);

                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);

                        $data_notes = array(
                            'notes_id' => $module_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmsnotes_details($data_notes);

                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }

                                $correct_answer_text = $correct_ans_description[0];
                                $correct_answer_desc = $correct_ans_description_text;
                            }

                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                }
            }

            $this->session->set_flashdata('message', $edit_content_type->name . ' Contents Added!');
        }
        /* Start Books Edit */
        if ($edit_content_type->name == 'Books') {
            // Entry in DB
            $this->Contents_model->update_books($module_id, $data);

            if ($upload_type == 1) {


                if ($fileupload_flex == 'yes') {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $var_filename_zero = rm_zip_ext($var_filename_zero);

                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );

                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $module_id,
                            'modules_item_name' => $name
                        );
                        $this->Contents_model->add($price_data);
                    }
                    //Remove from cms question bank

                    $data_books = array(
                        'books_id' => $module_id,
                        'question_id' => 0,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );

                    $this->Contents_model->add_cmsbooks_details($data_books);
                }
            } else {

                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {
                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);


                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {


                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                        $qus_text_var = $single_qus_ans[0];
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);


                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];
                        if (isset($type_instructions_array[1]) && ($type_instructions_array[1] != '')) {
                            $instructions_id = $type_instructions_array[1];
                        } else {
                            $instructions_id = 0;
                        }

                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }

                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'instructions_id' => trim($instructions_id),
                            'filter' => $page_number,
                            'created_by' => $created_by_id,
                            'dt_created' => $date);

                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);

                        $data_books = array(
                            'books_id' => $module_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmsbooks_details($data_books);

                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }


                                $correct_answer_text = $correct_ans_description[0];
                                $correct_answer_desc = $correct_ans_description_text;
                            }

                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                }
            }

            $this->session->set_flashdata('message', $edit_content_type->name . ' Contents Added!');
        }
        /* Start studymaterial Edit */
        if ($edit_content_type->name == 'Study Material') {
            // Entry in DB
            $this->Contents_model->update_studymaterial($module_id, $data);

            if ($upload_type == 1) {

                if ($fileupload_flex == 'yes') {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $var_filename_zero = rm_zip_ext($var_filename_zero);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );

                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);

                    //Remove from cms question bank

                    $data_studymaterial = array(
                        'studymaterial_id' => $module_id,
                        'question_id' => 0,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );

                    $this->Contents_model->add_cmsstudymaterial_details($data_studymaterial);
                }


                if ($price > 0) {
                    $price_data = array(
                        'exam_id' => $exam_id,
                        'subject_id' => $subject_id,
                        'chapter_id' => $chapter_id,
                        'item_id' => $cmsfiles_last_id,
                        'type' => $type,
                        'price' => $price,
                        'discounted_price' => $discounted_price_others,
                        'product_expiry_date'=> $product_expiry_date,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'modules_item_id' => $module_id,
                        'modules_item_name' => $name
                    );
                    $this->Contents_model->add($price_data);
                }
            } else {

                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {
                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);
                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {
                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                        $qus_text_var = $single_qus_ans[0];
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);
                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];
                        if (isset($type_instructions_array[1]) && ($type_instructions_array[1] != '')) {
                            $instructions_id = $type_instructions_array[1];
                        } else {
                            $instructions_id = 0;
                        }

                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }

                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'instructions_id' => trim($instructions_id),
                            'filter' => $page_number,
                            'created_by' => $created_by_id,
                            'dt_created' => $date);

                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);

                        $data_studymaterial = array(
                            'studymaterial_id' => $module_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmsstudymaterial_details($data_studymaterial);

                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }

                                $correct_answer_text = $correct_ans_description[0];
                                $correct_answer_desc = $correct_ans_description_text;
                            }
                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                }
            }

            $this->session->set_flashdata('message', $edit_content_type->name . ' Contents Added!');
        }
        if ($edit_content_type->name == 'Ncert Solutions') {
            // Entry in DB
            $this->Contents_model->update_ncertsolutions($module_id, $data);

            if ($upload_type == 1) {

                if ($fileupload_flex == 'yes') {
                    // There is no single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $var_filename_zero = rm_zip_ext($var_filename_zero);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );

                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $module_id,
                            'modules_item_name' => $name
                        );
                        $this->Contents_model->add($price_data);
                    }
                    $data_ncertsolutions_details = array(
                        'ncertsolutions_id' => $module_id,
                        'question_id' => 0,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );

                    $this->Contents_model->add_cmsncertsolutions_details($data_ncertsolutions_details);
                }
            } else {

                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {
                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);

                    $question_answer_description_count = count($question_answer_description_multiple_array);
                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {
                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                        $qus_text_var = $single_qus_ans[0];
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);

                        $ans_text_var = $single_qus_ans[1];

                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];
                        if (isset($type_instructions_array[1]) && ($type_instructions_array[1] != '')) {
                            $instructions_id = $type_instructions_array[1];
                        } else {
                            $instructions_id = 0;
                        }

                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }

                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'instructions_id' => trim($instructions_id),
                            'filter' => $page_number,
                            'created_by' => $created_by_id,
                            'dt_created' => $date);

                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);

                        $data_ncertsolutions_details = array(
                            'ncertsolutions_id' => $module_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmsncertsolutions_details($data_ncertsolutions_details);

                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }

                                $correct_answer_text = $correct_ans_description[0];
                                $correct_answer_desc = $correct_ans_description_text;
                            }
                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                }
            }

            $this->session->set_flashdata('message', $edit_content_type->name . ' Contents Updated!');
        }
        /* Start Notes Edit */
        if ($edit_content_type->name == 'Videos') {
            //For Playlist
            $upload_type = $this->input->post('video_upload_type');
            if ($upload_type == "playlist") {
                $playlist_id = $this->input->post('playlist_id');
                $playlist_name = $this->input->post('playlist_name');
                $playlist_description = $this->input->post('playlist_description');
                $playlist_data = array(
                    'name' => $playlist_name,
                    'description' => $playlist_description,
                    'modified_by' => $created_by_id,
                    'dt_modified' => $date
                );
                $playlist_insert_id = $this->Contents_model->update_playlist($playlist_id, $playlist_data);

                $this->session->set_flashdata('message', 'Playlist Updated!');
            } else {
                //For Videos
                $video_url_code = $this->input->post('video_url_code');
                $is_featured = $this->input->post('is_featured');
                $description = $this->input->post('description');
                $amazon_cloudfront_domain = $this->input->post('amazon_cloudfront_domain');
                $video_source = $this->input->post('video_source');
				$androidapp_link = $this->input->post('androidapp_link');
	            $video_by = $this->input->post('video_by');
                $status = $this->input->post('status');
                $custom_video_duration = $this->input->post('custom_video_duration');
                $amazonaws_link = $this->input->post('amazonaws_link');
                $videolist_by = 'Studyadda';
                $name = $this->input->post('video_name');
                $price = $this->input->post('video_price');
                $discounted_price = $this->input->post('discounted_price');
                $file_id = $this->input->post('cmsvideos_table_id');
                $video_tag = $this->input->post('video_tag');
                $new_playlist_name = $this->input->post('new_playlist_name');
                //Custom videolist table entry
                $existing_playlist_id = $this->input->post('existing_playlist_id');
                //Error chaking for video        
                $this->form_validation->set_rules('video_name', 'Name', 'required');
                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata('message', 'Please enter Video name if you want to add new video!');
                    redirect('admin/contents/edit/' . $this->input->post('module_id') . '/' . $this->input->post('module_type_id'));
                }

                    $filetype = 'videos';
                    $data_files = array(
                        'title' => $name,
                        'video_source' => $video_source,
                        'video_url_code' => $video_url_code,
                        'video_file_name' => '',
                        'video_image' => 'image_0.jpg',
                        'video_url_code' =>
						$video_url_code,
						'androidapp_link'=>$androidapp_link,
                        'is_featured' => $is_featured,
                        'description' => $description,
                        'video_by' => $video_by,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'status' => $status,
                        'video_tag' => $video_tag,
                        'custom_video_duration' => $custom_video_duration,
                        'amazonaws_link' => $amazonaws_link,
                        'amazon_cloudfront_domain' => $amazon_cloudfront_domain
                    );
                    $cmsfiles_last_id = $this->Contents_model->add_cmsvideos($data_files);
				
/*Image upload Start*/
                if ($upload_type == 1) {
                    // video file uplaod section
                    $videofolder_path = '/assets/videoimages/';
                    $video_file_field_name = 'video_file';
                    $video_image_in_db = $this->input->post('video_image_in_db');
                    $video_file_in_db = $this->input->post('video_file_in_db');
                    $common_file_name = $this->input->post('common_file_name_video');

                    if ($_FILES[$video_file_field_name]['name'] != '') {

                        $extract_file_name_one = upload_extract_file($videofolder_path, '', $video_file_field_name, $extract = 'no');
                        if (($extract_file_name_one != 'failed') && ($extract_file_name_one != '')) {
                            $var_filename_video = $extract_file_name_one;
                        } else if ($common_file_name != '') {
                            $var_filename_video = $common_file_name;
                        }
                    } else {
                        $var_filename_video = $common_file_name;
                    }

                    $imagefolder_path = '/assets/videoimages/';
                    $video_image_field_name = 'video_image';
                    $videoimage_file_name = '';
                    if ($_FILES[$video_image_field_name]['name'] != '') {
                        // Video image upload
                        $videoimage_file_name = video_image_upload($imagefolder_path, $video_image_field_name, $cmsfiles_last_id);
                    }

                    if (($videoimage_file_name == '') || ($videoimage_file_name == 'failed'||$var_filename_video==NULL)) {
                        $videoimage_file_name = 'image_'.$cmsfiles_last_id.'.jpg';
                    }

                    if ($var_filename_video == NULL) {
                        $var_filename_video = '';
                    }
                   
				   /*Update Video Image name in Database*/
				    $data_videosImages = array(  
                        'video_file_name' => $var_filename_video,                      
                        'video_image' => $videoimage_file_name,
						'dt_modified' => $date
                    );
                    $this->Contents_model->update_cmsvideos($cmsfiles_last_id,$data_videosImages);
				   
				   
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $module_id,
                            'modules_item_name' => $name
                        );

                        $this->Contents_model->add($price_data);
                    }

                    $data_videos_details = array(
                        'videolist_id' => $module_id,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'video_id' => $cmsfiles_last_id
                    );
                    $this->Contents_model->add_cmsvideoslist_details($data_videos_details);
                } else {
                    //This option not allowed for video section 
                    $this->session->set_flashdata('message', 'Multiple question can not be added in videos');
                    redirect('admin/contents/edit/' . $module_id . '/' . $module_type_id);
                    die();
                }

                $this->session->set_flashdata('message', $edit_content_type->name . ' Contents Updated!');
            }
        }

        redirect('admin/contents/edit/' . $module_id . '/' . $module_type_id);
    }
    
    
/*
NOT USEFUL
 * 

        if ($add_content_type->name == 'Notes-delete') {
            // Add new books and upload zip

            $notes_insert_id = $this->Contents_model->add_notes($data);
            $relations_data = array(
                'notes_id' => $notes_insert_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );

            $this->Contents_model->add_relation_in_notes($relations_data);

            if ($upload_type == 1) {
                if ($fileupload_flex == 'yes') {

                    // There is know single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $extract_file_name = rm_zip_ext($extract_file_name);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );
                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=> $product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $notes_insert_id,
                            'modules_item_name' => $name
                        );

                        $this->Contents_model->add($price_data);
                    }
                    $data_notes_details = array(
                        'notes_id' => $notes_insert_id,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );
                    $this->Contents_model->add_cmsnotes_details($data_notes_details);
                }
            } else {

                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {
                   //Multiple question answer 

                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);


                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {


                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                        $qus_text_var = $single_qus_ans[0];
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);


                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];
                        if (isset($type_instructions_array[1]) && ($type_instructions_array[1] != '')) {
                            $instructions_id = $type_instructions_array[1];
                        } else {
                            $instructions_id = 0;
                        }

                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }

                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'instructions_id' => trim($instructions_id),
                            'filter' => $page_number,
                            'created_by' => $created_by_id,
                            'dt_created' => $date);

                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);

                        $data_notes = array(
                            'notes_id' => $notes_insert_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmsnotes_details($data_notes);

                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }

                                $correct_answer_text = $correct_ans_description[0];
                                $correct_answer_desc = $correct_ans_description_text;
                            }

                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                }
            }

            echo "<h3>Notes Contents Added!</h3>";
        }
        
        if ($add_content_type->name == 'Books') { // Entry in DB
            $books_insert_id = $this->Contents_model->add_books($data);
            $relations_data = array(
                'books_id' => $books_insert_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'created_by' => $created_by_id,
                'dt_created' => $date
            );

            $this->Contents_model->add_relation_in_books($relations_data);

            if ($upload_type == 1) {
                if ($fileupload_flex == 'yes') {
                    // There is know single question id so  question_id will be zero.
                    // save complete question answer as flex
                    $extract_file_name = rm_zip_ext($extract_file_name);
                    $filetype = 'flex';
                    $data_files = array(
                        'displayname' => $display_file_name,
                        'filename' => $var_filename_zero,
                        'filepath' => $extractfolder_path,
                        'filename_one' => $var_filename_one,
                        'filepath_one' => $zipfolder_path_one,
                        'type' => $type,
                        'filetype' => $filetype,
                        'is_deleted' => $is_deleted,
                        'created_by' => $created_by_id,
                        'dt_created' => $date
                    );
                    $cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
                    if ($price > 0) {
                        $price_data = array(
                            'exam_id' => $exam_id,
                            'subject_id' => $subject_id,
                            'chapter_id' => $chapter_id,
                            'item_id' => $cmsfiles_last_id,
                            'type' => $type,
                            'price' => $price,
                            'discounted_price' => $discounted_price_others,
                            'product_expiry_date'=>$product_expiry_date,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'modules_item_id' => $books_insert_id,
                            'modules_item_name' => $name
                        );
                        //No need to set price
                        //$this->Contents_model->add($price_data);
                    }
                    $data_books_details = array(
                        'books_id' => $books_insert_id,
                        'created_by' => $created_by_id,
                        'dt_created' => $date,
                        'file_id' => $cmsfiles_last_id
                    );
                    $this->Contents_model->add_cmsbooks_details($data_books_details);
                }
            } else {
                // Multiple Upload section for Books Id 
                if (isset($extract_file_name) && ($extract_file_name != '') && ($extract_file_name != 'failed')) {

                    $question_answer_description_multiple_array = explode('*-ENTER_NEXT_LINE-*', $content_question_answer);
                    $question_answer_description_count = count($question_answer_description_multiple_array);

                    for ($qa_number = 0; $question_answer_description_count > $qa_number; $qa_number++) {
                        $single_array_qus_ans = $question_answer_description_multiple_array[$qa_number];
                        $single_qus_ans = explode('*-answer-*', $single_array_qus_ans);
                        $qus_text_var = $single_qus_ans[0];
                        //Remove tabs from contant
                        $qus_text = remove_tabSpace($qus_text_var);


                        $ans_text_var = $single_qus_ans[1];
                        //Remove tabs from contant
                        $ans_text_clean = remove_tabSpace($ans_text_var);
                        $single_qus_ans_type_break = explode('*-question-type-*', $ans_text_clean);
                        $ans_text = $single_qus_ans_type_break[0];
                        $type_instructions_array = explode('*-question-instructions-*', $single_qus_ans_type_break[1]);
                        $type_of_qus_ans = $type_instructions_array[0];
                        if (isset($type_instructions_array[1]) && ($type_instructions_array[1] != '')) {
                            $instructions_id = $type_instructions_array[1];
                        } else {
                            $instructions_id = 0;
                        }

                        //If question type is NOT available in doc file than only use dropdown value.
                        if (isset($type_of_qus_ans) && $type_of_qus_ans > 0) {
                            $entry_question_type = $type_of_qus_ans;
                        } else {
                            $entry_question_type = $cmsquestiontypes;
                        }

                        $data_questoin_text = array(
                            'question' => trim($qus_text),
                            'type' => $entry_question_type,
                            'instructions_id' => trim($instructions_id),
                            'created_by' => $created_by_id,
                            'filter' => $page_number,
                            'dt_created' => $date);


                        $data_questoin_ans_insert_id = $this->Questions_model->add($data_questoin_text);
                        // $module_field_name is db field name
                        $data_books_details = array(
                            'books_id' => $books_insert_id,
                            'question_id' => $data_questoin_ans_insert_id,
                            'created_by' => $created_by_id,
                            'dt_created' => $date,
                            'file_id' => 0
                        );
                        $this->Contents_model->add_cmsbooks_details($data_books_details);
                        $ans_option_text = explode('*-answer-options-*', $ans_text);
                        $ans_option_count = count($ans_option_text);
                        // Insert Multiple answer is if exist
                        for ($ans_cnt = 0; $ans_option_count > $ans_cnt; $ans_cnt++) {
                            //Save multiple answer
                            $correct_answer = '0';
                            $correct_answer_text = $ans_option_text[$ans_cnt];
                            $correct_answer_desc = NULL;
                            $correct_ans_description = NULL;
                            if (isset($ans_option_text[$ans_cnt])) {
                                $correct_ans_description = explode('*-correct-answer-description-*', $ans_option_text[$ans_cnt]);
                            }

                            if (((count($correct_ans_description) > 0) && is_array($correct_ans_description))) {
                                $correct_ans_description_text = NULL;
                                if (isset($correct_ans_description[1])) {
                                    $correct_ans_description_text = $correct_ans_description[1];
                                    $correct_answer = '1';
                                }


                                $correct_answer_text = $correct_ans_description[0];
                                $correct_answer_desc = $correct_ans_description_text;
                            }

                            $data_answer_text = array(
                                'question_id' => $data_questoin_ans_insert_id,
                                'description' => trim($correct_answer_desc),
                                'is_correct' => $correct_answer,
                                'answer' => trim($correct_answer_text),
                                'created_by' => $created_by_id,
                                'dt_created' => $date);
                            $this->Answers_model->add($data_answer_text);
                        }
                    }
                    // End Multiple ques ans   
                }
            }

            $this->session->set_flashdata('message', 'Books Contents Added!');
        }
 *  */
    public function getLastLevelList($id, $type) {
        $edit_content_type = $this->Content_model->getContentTypeDetail($type);
        $this->data['content_type'] = $edit_content_type;
        //Get relation ships Exam,subject and chapter  
        $response = array();
        $content_array = array();
        $contents = '';

        if ($edit_content_type->name == 'Videos') {
           
            $contents = $this->Videos_model->getMergeVideosDetails($id);
        }

        if ($edit_content_type->name == 'Notes') {
            $this->load->model('Notes_model');
            $contents_one = $this->Notes_model->getNotesDetails($id);
            $contents_one = $this->Notes_model->getfiles_merge($id);
            $contents = arraer_merge($contents_one, $contents_two);
        }

        if ($edit_content_type->name == 'Study Material') {
            $this->load->model('Studymaterial_model');
            $contents_one = $this->Studymaterial_model->getStudyMaterialDetails($id);
            $contents_two = $this->Studymaterial_model->getFiles_merge($id);
            $contents = array_merge($contents_one, $contents_two);
        }


        if ($edit_content_type->name == 'Books') {
            $this->load->model('Books_model');
            $contents = $this->Books_model->getBookDetails($id);
        }

        if ($edit_content_type->name == 'Online Tests') {
            $this->load->model('Onlinetest_model');

            $contents = $this->Onlinetest_model->getolDetails($id);
        }

        if ($edit_content_type->name == 'Question Bank') {
            $this->load->model('Questionbank_model');
            $contents_one = $this->Questionbank_model->getQbDetails($id);
            $contents_two = $this->Questionbank_model->getFiles_merge($id);
            $contents = array_merge($contents_one, $contents_two);
        }

        if ($edit_content_type->name == 'Sample Papers') {
            $this->load->model('Samplepapers_model');
            $contents_one = $this->Samplepapers_model->getSamplePaperData($id);
            $contents_two = $this->Samplepapers_model->getFiles_merge($id);
            $contents = array_merge($contents_one, $contents_two);
        }

        if ($edit_content_type->name == 'Solved Papers') {
            $this->load->model('Solvedpapers_model');
            $contents_one = $this->Solvedpapers_model->getSolvedPapersData($id);
            $contents_two = $this->Solvedpapers_model->getFiles_merge($id);
            $contents = array_merge($contents_one, $contents_two);
        }

        if ($edit_content_type->name == 'Ncert Solutions') {
            $this->load->model('Ncertsolutions_model');
            $contents_one = $this->Ncertsolutions_model->getNcertSolutionsData($id);
            $contents_two = $this->Ncertsolutions_model->getFiles_merge($id);

            if (count($contents_two) < 1 || $contents_two == '') {
                $questions_array = $this->Ncertsolutions_model->getNcertSolutionsData($id);
                $contents_two = $questions_array;
            }

            $contents = array_merge($contents_one, $contents_two);
        }

        if (count($contents) > 0) {
            foreach ($contents as $content) {
                $content_array[] = (array) $content;
            }

            $response['data'] = $content_array;
            $response['count'] = count($contents);
        } else {
            $response['data'] = array();
        }

        echo json_encode($response);
    }
	public function updtQue_formula($dId,$qId,$fID=0){
		if($dId>0&&$fID>0){
			$fdata=array('qus_formula_id'=>$fID);
		$this->load->model('Onlinetest_model');
		$contents = $this->Onlinetest_model->edit_ottest_detail($dId,$fdata);
		$response['sqlid']=$dId;
		$response['formulaid']=$fID;
		 $response['message'] ='success';
		 $response['response'] =array('success');
		}else{
			$response['sqlid']=$dId;
		$response['formulaid']=$fID;
 $response['message'] ='failed';
		 $response['response'] =array('failed');
			
		}
        echo json_encode($response);
	}
    
    public function edit_onlinetest($id, $type, $main_exam_id = NULL, $main_subject_id = NULL, $main_chapter_id = NULL) { 
        if (($id == '') || ($type == '')) {
            $this->session->set_flashdata('message', 'Something went wrong Please try again!Module Id not Found.');
            redirect($_SERVER['HTTP_REFERER']);
            die;
        }
        
        $this->data['main_exam_id'] = $main_exam_id;
        $this->data['main_subject_id'] = $main_subject_id;
        $this->data['main_chapter_id'] = $main_chapter_id;
        
        $edit_content_type = $this->Content_model->getContentTypeDetail($type);
        $this->data['content_type'] = $edit_content_type;
        //$all_test_paper=$this->get($type, $main_exam_id); 
        //print_r($all_test_paper); die;       
        if ($edit_content_type->name == 'Online Tests') {
            $this->load->model('Onlinetest_model');
            $this->load->model('Pricelist_model');
            $this->load->model('Examcategory_model');
            $ol_test = $this->Onlinetest_model->detail($id);
            $ol_details = $this->Onlinetest_model->getolDetails($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = NULL;
            $module_relation_details = $this->Onlinetest_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
            $this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['pricelist_by_moduleid'] = $ol_test;
            $this->data['maincontent'] = $ol_test;
            $this->data['items'] = $ol_details;
            $this->data['heading'] = $edit_content_type->name;
            if (isset($qbdetails[0]->type)) {
                $this->data['type_of_question'] = $qbdetails[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }
            if (isset($ol_test->formula_id)) {
                $this->data['formula_id_for_exam'] = $ol_test->formula_id;
            } else {
                $this->data['formula_id_for_exam'] = 0;
            }
            
            if (isset($ol_test->olcategory_id)) {
                $this->data['category_id_for_exam'] = $ol_test->olcategory_id;
            } else {
                $this->data['category_id_for_exam'] = 0;
            }

            if (isset($ol_test->dt_start)) {
                $this->data['dt_start'] = $ol_test->dt_start;
            } else {
                $this->data['dt_start'] = 0;
            }

            if (isset($ol_test->dt_end)) {
                $this->data['dt_end'] = $ol_test->dt_end;
            } else {
                $this->data['dt_end'] = 0;
            }

            $this->data['show_calculater'] = $ol_test->calculater;

            if (count($module_relation_details) > 0) {
                for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                    $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                    $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);

                    $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);
                    if (isset($relation_exam_name[0]->name)) {
                        $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                    } else {
                        $this->data['relation_exam'][$rcnt] = 'None';
                    }

                    if (isset($relation_subject_name->name)) {
                        $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                    } else {
                        $this->data['relation_subject'][$rcnt] = 'None';
                    }

                    if (isset($relation_chapter_name->name)) {
                        $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                    } else {
                        $this->data['relation_chapter'][$rcnt] = 'None';
                    }
                }
            }
        }
        
        $this->data['content'] = 'contents/edit_onlinetest';
        $this->load->view('common/template', $this->data);
    }
    
    public function getmodule_qus($id, $type, $main_exam_id = NULL, $main_subject_id = NULL, $main_chapter_id = NULL){
        
        $edit_content_type = $this->Content_model->getContentTypeDetail($type);
        
        if ($edit_content_type->name == 'Question Bank') {
            $this->load->model('Questionbank_model');
            $this->load->model('Pricelist_model');
            $this->load->model('Examcategory_model');
            $qb = $this->Questionbank_model->detail($id);
            $qbdetails = $this->Questionbank_model->getQbDetails($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = $this->Questionbank_model->getDetails_bymoduleID_file($id);
            $module_relation_details = $this->Questionbank_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
            $this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['pricelist_by_moduleid'] = $qb;
            $this->data['maincontent'] = $qb;
            $this->data['items'] = $qbdetails;
            $this->data['heading'] = $edit_content_type->name;

            if (isset($qbdetails[0]->type)) {
                $this->data['type_of_question'] = $qbdetails[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }

            for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);

                $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);

                if (isset($relation_exam_name[0]->name)) {
                    $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                } else {
                    $this->data['relation_exam'][$rcnt] = 'None';
                }

                if (isset($relation_subject_name->name)) {
                    $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                } else {
                    $this->data['relation_subject'][$rcnt] = 'None';
                }

                if (isset($relation_chapter_name->name)) {
                    $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                } else {
                    $this->data['relation_chapter'][$rcnt] = 'None';
                }
            }
        }
        if ($edit_content_type->name == 'Sample Papers') {
            $this->load->model('Samplepapers_model');
            $this->load->model('Pricelist_model');
            $sp = $this->Samplepapers_model->detail($id);
            $spdetails = $this->Samplepapers_model->getSamplePaperData($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = $this->Samplepapers_model->getDetails_bymoduleID_file($id);
            $module_relation_details = $this->Samplepapers_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
            $this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['maincontent'] = $sp;
            $this->data['items'] = $spdetails;
            $this->data['heading'] = $edit_content_type->name;
            if (isset($spdetails[0]->type)) {
                $this->data['type_of_question'] = $spdetails[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }
            for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);

                $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);

                if (isset($relation_exam_name[0]->name)) {
                    $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                } else {
                    $this->data['relation_exam'][$rcnt] = 'None';
                }

                if (isset($relation_subject_name->name)) {
                    $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                } else {
                    $this->data['relation_subject'][$rcnt] = 'None';
                }

                if (isset($relation_chapter_name->name)) {
                    $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                } else {
                    $this->data['relation_chapter'][$rcnt] = 'None';
                }
            }
        }
        if ($edit_content_type->name == 'Solved Papers') {
            $this->load->model('Solvedpapers_model');
            $this->load->model('Pricelist_model');
            $solved_p = $this->Solvedpapers_model->detail($id);
            $solved_p_details = $this->Solvedpapers_model->getSolvedPapersData($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = $this->Solvedpapers_model->getDetails_bymoduleID_file($id);
            $module_relation_details = $this->Solvedpapers_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
            $this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['maincontent'] = $solved_p;
            $this->data['items'] = $solved_p_details;
            $this->data['heading'] = $edit_content_type->name;
            if (isset($solved_p_details[0]->type)) {
                $this->data['type_of_question'] = $solved_p_details[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }
            $added_chapters = array();
            for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);

                $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);

                if (isset($relation_exam_name[0]->name)) {
                    $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                } else {
                    $this->data['relation_exam'][$rcnt] = 'None';
                }

                if (isset($relation_subject_name->name)) {
                    $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                } else {
                    $this->data['relation_subject'][$rcnt] = 'None';
                }

                if (isset($relation_chapter_name->name)) {
                    $added_chapters[$relation_chapter_name->id] = $relation_chapter_name->name;
                    $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                } else {
                    $this->data['relation_chapter'][$rcnt] = 'None';
                }
            }
            $this->data['added_chapters'] = $added_chapters;
        }
               
        if ($edit_content_type->name == 'Online Tests') {
            $this->load->model('Onlinetest_model');
            $this->load->model('Pricelist_model');
            $this->load->model('Examcategory_model');
            $ol_test = $this->Onlinetest_model->detail($id);
            $ol_details = $this->Onlinetest_model->getolDetails($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = NULL;
            $module_relation_details = $this->Onlinetest_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
            $this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['pricelist_by_moduleid'] = $ol_test;
            $this->data['maincontent'] = $ol_test;
            $this->data['items'] = $ol_details;
            $this->data['heading'] = $edit_content_type->name;
            if (isset($qbdetails[0]->type)) {
                $this->data['type_of_question'] = $qbdetails[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }
            if (isset($ol_test->formula_id)) {
                $this->data['formula_id_for_exam'] = $ol_test->formula_id;
            } else {
                $this->data['formula_id_for_exam'] = 0;
            }

            $this->data['show_calculater'] = $ol_test->calculater;

            if (count($module_relation_details) > 0) {
                for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                    $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                    $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);

                    $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);
                    if (isset($relation_exam_name[0]->name)) {
                        $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                    } else {
                        $this->data['relation_exam'][$rcnt] = 'None';
                    }

                    if (isset($relation_subject_name->name)) {
                        $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                    } else {
                        $this->data['relation_subject'][$rcnt] = 'None';
                    }

                    if (isset($relation_chapter_name->name)) {
                        $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                    } else {
                        $this->data['relation_chapter'][$rcnt] = 'None';
                    }
                }
            }
        }
        
        
        
        $contents=$this->data['items'];
        if (count($contents) > 0) {
               /*foreach ($contents as $content) {
                $content_array[] = (array) $content;
            } */
            $response['data'] = $contents;
            $response['type'] = $type;
            $response['count'] = count($contents);
        } else {
            $response['data'] = array();
            $response['type']='';
            $response['count'] = 0;
        }

        echo json_encode($response);
        
        
    }
    
    
    public function edit($id, $type, $main_exam_id = NULL, $main_subject_id = NULL, $main_chapter_id = NULL) { 
        if (($id == '') || ($type == '')) {
            $this->session->set_flashdata('message', 'Something went wrong Please try again!');
            redirect($_SERVER['HTTP_REFERER']);
            die;
        }

        $edit_content_type = $this->Content_model->getContentTypeDetail($type);
        $this->data['content_type'] = $edit_content_type;
        //Get relation ships Exam,subject and chapter  

        if ($edit_content_type->name == 'Article') {

            redirect('/admin/listings/edit_listing/' . $id);
             die;
        }
        
        if ($edit_content_type->name == 'Notes') {
            redirect('/admin/listings/edit_listing/' . $id);
            die;

            $this->load->model('Notes_model');
            $this->load->model('Pricelist_model');
            $notes = $this->Notes_model->detail($id);
            $notesdetails = $this->Notes_model->getNotesDetails($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = $this->Notes_model->getDetails_bymoduleID_file($id);
            $module_relation_details = $this->Notes_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
            //$this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['pricelist_by_moduleid'] = $notes;
            $this->data['maincontent'] = $notes;
            $this->data['items'] = $notesdetails;
            $this->data['heading'] = $edit_content_type->name;
            if (isset($notesdetails[0]->type)) {
                $this->data['type_of_question'] = $notesdetails[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }

            for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);
                $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);

                if (isset($relation_exam_name[0]->name)) {
                    $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                } else {
                    $this->data['relation_exam'][$rcnt] = 'None';
                }

                if (isset($relation_subject_name->name)) {
                    $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                } else {
                    $this->data['relation_subject'][$rcnt] = 'None';
                }

                if (isset($relation_chapter_name->name)) {
                    $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                } else {
                    $this->data['relation_chapter'][$rcnt] = 'None';
                }
            }
        }
        if ($edit_content_type->name == 'Study Material') {
            $this->load->model('Studymaterial_model');
            $this->load->model('Pricelist_model');
            $studymaterial = $this->Studymaterial_model->detail($id);
            $studymaterialdetails = $this->Studymaterial_model->getStudyMaterialDetails($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = $this->Studymaterial_model->getDetails_bymoduleID_file($id);
            $module_relation_details = $this->Studymaterial_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
            $this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['pricelist_by_moduleid'] = $studymaterial;
            $this->data['maincontent'] = $studymaterial;
            $this->data['items'] = $studymaterialdetails;
            $this->data['heading'] = $edit_content_type->name;
            if (isset($studymaterialdetails[0]->type)) {
                $this->data['type_of_question'] = $studymaterialdetails[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }

            for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);

                $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);

                if (isset($relation_exam_name[0]->name)) {
                    $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                } else {
                    $this->data['relation_exam'][$rcnt] = 'None';
                }

                if (isset($relation_subject_name->name)) {
                    $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                } else {
                    $this->data['relation_subject'][$rcnt] = 'None';
                }

                if (isset($relation_chapter_name->name)) {
                    $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                } else {
                    $this->data['relation_chapter'][$rcnt] = 'None';
                }
            }
        }
        if ($edit_content_type->name == 'Books') {
            $this->load->model('Books_model');
            $this->load->model('Pricelist_model');
            $books = $this->Books_model->detail($id);
            $bookdetails = $this->Books_model->getBookDetails($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = $this->Books_model->getDetails_bymoduleID_file($id);
            $module_relation_details = $this->Books_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
            $this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['pricelist_by_moduleid'] = $books;
            $this->data['maincontent'] = $books;
            $this->data['items'] = $bookdetails;
            $this->data['heading'] = $edit_content_type->name;
            if (isset($bookdetails[0]->type)) {
                $this->data['type_of_question'] = $bookdetails[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }
            for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);
                $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);

                if (isset($relation_exam_name[0]->name)) {
                    $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                } else {
                    $this->data['relation_exam'][$rcnt] = 'None';
                }

                if (isset($relation_subject_name->name)) {
                    $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                } else {
                    $this->data['relation_subject'][$rcnt] = 'None';
                }

                if (isset($relation_chapter_name->name)) {
                    $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                } else {
                    $this->data['relation_chapter'][$rcnt] = 'None';
                }
            }
        }
        if ($edit_content_type->name == 'Question Bank') {
            $this->load->model('Questionbank_model');
            $this->load->model('Pricelist_model');
            $this->load->model('Examcategory_model');
            $qb = $this->Questionbank_model->detailsrelation($id);
			$qbdetails = $this->Questionbank_model->getQbDetails($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = $this->Questionbank_model->getDetails_bymoduleID_file($id);
            $module_relation_details = $this->Questionbank_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
           // $this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['pricelist_by_moduleid'] = $qb;
            $this->data['maincontent'] = $qb;
            $this->data['items'] = $qbdetails;
            $this->data['heading'] = $edit_content_type->name;

            if (isset($qbdetails[0]->type)) {
                $this->data['type_of_question'] = $qbdetails[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }

            for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);

                $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);

                if (isset($relation_exam_name[0]->name)) {
                    $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                } else {
                    $this->data['relation_exam'][$rcnt] = 'None';
                }

                if (isset($relation_subject_name->name)) {
                    $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                } else {
                    $this->data['relation_subject'][$rcnt] = 'None';
                }

                if (isset($relation_chapter_name->name)) {
                    $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                } else {
                    $this->data['relation_chapter'][$rcnt] = 'None';
                }
            }
        }
        if ($edit_content_type->name == 'Sample Papers') {
            $this->load->model('Samplepapers_model');
            $this->load->model('Pricelist_model');
            $sp = $this->Samplepapers_model->detail($id);
            $spdetails = $this->Samplepapers_model->getSamplePaperData($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = $this->Samplepapers_model->getDetails_bymoduleID_file($id);
            $module_relation_details = $this->Samplepapers_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
            //$this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['maincontent'] = $sp;
            $this->data['items'] = $spdetails;
            $this->data['heading'] = $edit_content_type->name;
            if (isset($spdetails[0]->type)) {
                $this->data['type_of_question'] = $spdetails[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }
            for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);

                $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);

                if (isset($relation_exam_name[0]->name)) {
                    $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                } else {
                    $this->data['relation_exam'][$rcnt] = 'None';
                }

                if (isset($relation_subject_name->name)) {
                    $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                } else {
                    $this->data['relation_subject'][$rcnt] = 'None';
                }

                if (isset($relation_chapter_name->name)) {
                    $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                } else {
                    $this->data['relation_chapter'][$rcnt] = 'None';
                }
            }
        }
        if ($edit_content_type->name == 'Solved Papers') {
            $this->load->model('Solvedpapers_model');
            $this->load->model('Pricelist_model');
            $solved_p = $this->Solvedpapers_model->detail($id);
            $solved_p_details = $this->Solvedpapers_model->getSolvedPapersData($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = $this->Solvedpapers_model->getDetails_bymoduleID_file($id);
            $module_relation_details = $this->Solvedpapers_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
            //$this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['maincontent'] = $solved_p;
            $this->data['items'] = $solved_p_details;
            $this->data['heading'] = $edit_content_type->name;
            if (isset($solved_p_details[0]->type)) {
                $this->data['type_of_question'] = $solved_p_details[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }
            $added_chapters = array();
            for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);

                $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);

                if (isset($relation_exam_name[0]->name)) {
                    $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                } else {
                    $this->data['relation_exam'][$rcnt] = 'None';
                }

                if (isset($relation_subject_name->name)) {
                    $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                } else {
                    $this->data['relation_subject'][$rcnt] = 'None';
                }

                if (isset($relation_chapter_name->name)) {
                    $added_chapters[$relation_chapter_name->id] = $relation_chapter_name->name;
                    $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                } else {
                    $this->data['relation_chapter'][$rcnt] = 'None';
                }
            }
            $this->data['added_chapters'] = $added_chapters;
        }
               
        if ($edit_content_type->name == 'Online Tests') {
            
            $this->load->model('Onlinetest_model');
            $this->load->model('Pricelist_model');
            $this->load->model('Examcategory_model');
            $ol_test = $this->Onlinetest_model->detail($id);
            $ol_details = $this->Onlinetest_model->getolDetails($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = $this->Onlinetest_model->getDetails_bymoduleID_file($id);
            //$uploaded_file_details = NULL;
            $module_relation_details = $this->Onlinetest_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
            //$this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['pricelist_by_moduleid'] = $ol_test;
            $this->data['maincontent'] = $ol_test;
            $this->data['items'] = $ol_details;
            $this->data['heading'] = $edit_content_type->name;
            if (isset($qbdetails[0]->type)) {
                $this->data['type_of_question'] = $qbdetails[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }
            if (isset($ol_test->formula_id)) {
                $this->data['formula_id_for_exam'] = $ol_test->formula_id;
            } else {
                $this->data['formula_id_for_exam'] = 0;
            }
            if (isset($ol_test->olcategory_id)) {
                $this->data['category_id_for_exam'] = $ol_test->olcategory_id;
            } else {
                $this->data['category_id_for_exam'] = 0;
            }
            
            $this->data['show_calculater'] = $ol_test->calculater;

            if (count($module_relation_details) > 0) {
                for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                    $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                    $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);

                    $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);
                    if (isset($relation_exam_name[0]->name)) {
                        $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                    } else {
                        $this->data['relation_exam'][$rcnt] = 'None';
                    }

                    if (isset($relation_subject_name->name)) {
                        $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                    } else {
                        $this->data['relation_subject'][$rcnt] = 'None';
                    }

                    if (isset($relation_chapter_name->name)) {
                        $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                    } else {
                        $this->data['relation_chapter'][$rcnt] = 'None';
                    }
                }
            }
        }
        
        if ($edit_content_type->name == 'Ncert Solutions') {
            $this->load->model('Ncertsolutions_model');
            $ncertsolution_detail = $this->Ncertsolutions_model->detail($id);
            $ncertsolution_data = $this->Ncertsolutions_model->getNcertSolutionsData($id);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = $this->Ncertsolutions_model->getDetails_bymoduleID_file($id);
            $module_relation_details = $this->Ncertsolutions_model->getRelationDetail($id);
            $this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $uploaded_file_details;
            //$this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['maincontent'] = $ncertsolution_detail;
            $this->data['items'] = $ncertsolution_data;
            $this->data['heading'] = $edit_content_type->name;
            if (isset($ncertsolution_data[0]->type)) {
                $this->data['type_of_question'] = $ncertsolution_data[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }
            for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);

                $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);

                if (isset($relation_exam_name[0]->name)) {
                    $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                } else {
                    $this->data['relation_exam'][$rcnt] = 'None';
                }

                if (isset($relation_subject_name->name)) {
                    $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                } else {
                    $this->data['relation_subject'][$rcnt] = 'None';
                }

                if (isset($relation_chapter_name->name)) {
                    $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                } else {
                    $this->data['relation_chapter'][$rcnt] = 'None';
                }
            }
        } 
        if ($edit_content_type->name == 'Videos') {
            
            $this->load->model('Pricelist_model');
            $videos = $this->Videos_model->detail($id);
            $playlist_detail = $this->Videos_model->playlist_detail($id);
            $videosdetails = $this->Videos_model->getVideosDetails($id,2);
            $pricelist_details_arr = $this->Pricelist_model->getDetails_bymoduleID($id);
            $uploaded_file_details = $this->Videos_model->getDetails_bymoduleID_file($id);
            $module_relation_details = $this->Videos_model->getRelationDetail($id);
			$andVideoID=$this->input->post('andVideoID');
			$this->data['module_relation_details'] = $module_relation_details;
            $this->data['module_file_details'] = $videosdetails;
            //$this->data['pricelist_details'] = $pricelist_details_arr;
            $this->data['pricelist_by_moduleid'] = $videos;
            $this->data['maincontent'] = $videos;
            $this->data['items'] = $videosdetails;
            $this->data['heading'] = $edit_content_type->name;
            $this->data['array_existing_playlist_id'] = $playlist_detail;
            if (isset($videosdetails[0]->type)) {
                $this->data['type_of_question'] = $videosdetails[0]->type;
            } else {
                $this->data['type_of_question'] = 0;
            }

            for ($rcnt = 0; count($module_relation_details) > $rcnt; $rcnt++) {

                $relation_exam_name = $this->Examcategory_model->getExamCatgeoryById($module_relation_details[$rcnt]->exam_id);
                $relation_subject_name = $this->Subjects_model->getSubject($module_relation_details[$rcnt]->subject_id);
                $relation_chapter_name = $this->Chapters_model->getChapter($module_relation_details[$rcnt]->chapter_id);
                if (isset($relation_exam_name[0]->name)) {
                    $this->data['relation_exam'][$rcnt] = $relation_exam_name[0]->name;
                } else {
                    $this->data['relation_exam'][$rcnt] = 'None';
                }
                if (isset($relation_subject_name->name)) {
                    $this->data['relation_subject'][$rcnt] = $relation_subject_name->name;
                } else {
                    $this->data['relation_subject'][$rcnt] = 'None';
                }

                if (isset($relation_chapter_name->name)) {
                    $this->data['relation_chapter'][$rcnt] = $relation_chapter_name->name;
                } else {
                    $this->data['relation_chapter'][$rcnt] = 'None';
                }
            }
        }
        $maincontent_name_array=array();
        $maincontent_name=NULL;
        if(isset($this->data['maincontent'])){
            $maincontentarr=$this->data['maincontent'];
            $maincontent_name=$maincontentarr->name;
            if(isset($maincontent_name)&&count($maincontent_name)>1){
                $maincontent_name_array=$this->Studymaterial_model->getSM_byName($maincontent_name);
            }
        }
        $this->data['maincontent_name_array'] = $maincontent_name_array;
        $this->data['main_exam_id'] = $main_exam_id;
        $this->data['main_subject_id'] = $main_subject_id;
        $this->data['main_chapter_id'] = $main_chapter_id;
        $this->data['loadMathJax'] = 'yes';
        
       
        //$this->data['result']=$result;
        $this->data['content'] = 'contents/edit';
        $this->load->view('common/template', $this->data);
    }

    public function get($type, $examid, $subject_id = 0, $chapter_id = 0) {
        $this->load->model('Studymaterial_model');
        $this->load->model('Books_model');
        $this->load->model('Videos_model');
        $this->load->model('Onlinetest_model');
        $this->load->model('Questionbank_model');
        $this->load->model('Samplepapers_model');
        $this->load->model('Solvedpapers_model');
        $this->load->model('Ncertsolutions_model');
        $this->load->model('Notes_model');
        $this->load->model('Posting_model');
        $response = array();
        $content_array = array();
        $contents = '';
        $show_content_type = $this->Content_model->getContentTypeDetail($type);
        if ($show_content_type->name == 'Study Material') {
        //$contents = $this->Studymaterial_model->getStudyMaterial($examid, $subject_id, $chapter_id);
        $contents = $this->Studymaterial_model->getStudyMaterial_list($examid, $subject_id, $chapter_id,$type);
        }
        if ($show_content_type->name == 'Books') {
        $contents = $this->Books_model->getBooks($examid, $subject_id, $chapter_id);
        }
        if ($show_content_type->name == 'Videos') {
        $contents = $this->Videos_model->getVideos($examid, $subject_id, $chapter_id);
        }

        if ($show_content_type->name == 'Online Tests') {
        $contents = $this->Onlinetest_model->getOnlineTests($examid, $subject_id, $chapter_id);
        }

        if ($show_content_type->name == 'Question Bank') {
            $contents = $this->Questionbank_model->getQuestionBank($examid, $subject_id, $chapter_id);
        }

        if ($show_content_type->name == 'Sample Papers') {
            $contents = $this->Samplepapers_model->getSamplePapers($examid, $subject_id, $chapter_id);
        }

        if ($show_content_type->name == 'Solved Papers') {
            $contents = $this->Solvedpapers_model->getSolvedPapers($examid, $subject_id, $chapter_id);
		}

        if ($show_content_type->name == 'Ncert Solutions') {
            $contents = $this->Ncertsolutions_model->getNcertSolutions($examid, $subject_id, $chapter_id);
        }
        if($show_content_type->name == 'Notes') {
           $contents = $this->Notes_model->getNotes($examid, $subject_id, $chapter_id);
        }
        if ($show_content_type->name == 'Article') {
            $contents = $this->Posting_model->getArticlesForExams($examid, $subject_id, $chapter_id);
        }
		
		$subClass_array[] = array('id'=>'1','name'=>'ICSE');
		
		$subClass_array[] = array('id'=>'2','name'=>'RJ Board');
		
		$cntCount=count($contents);
        if ($cntCount > 0) {
            foreach ($contents as $content) {
            $content_array[] = (array) $content;
        }
        	$response['data'] = $content_array;
            $response['type'] = $type;
            $response['count'] = count($contents);
        } else {
            $response['data'] = array();
            $response['count'] = 1;
        }
		$response['subClass'] = $subClass_array;
        echo json_encode($response);
    }

    public function getContentsFileInfo($module_id, $module_type_id) {
        $this->data['module_id'] = $module_id;
        $this->data['module_type_id'] = $module_type_id;

        $this->load->model('Content_model');
        $content_type = $this->Content_model->getContentTypeDetail($module_type_id);


        if ($content_type->name == 'Question Bank') {
            $this->load->model('Questionbank_model');
            $Contents_array = $this->Questionbank_model->getContents_name($module_id);
            $contents_name = $Contents_array[0]->name;
        }
        if ($content_type->name == 'Sample Papers') {
            $this->load->model('Samplepapers_model');
            $Contents_array = $this->Samplepapers_model->getContents_name($module_id);
            $contents_name = $Contents_array[0]->name;
        }
        if ($content_type->name == 'Solved Papers') {
            $this->load->model('Solvedpapers_model');
            $Contents_array = $this->Solvedpapers_model->getContents_name($module_id);
            $contents_name = $Contents_array[0]->name;
        }
        if ($content_type->name == 'Online Tests') {
            $this->load->model('Onlinetest_model');
            $Contents_array = $this->Onlinetest_model->getContents_name($module_id);
            $contents_name = $Contents_array[0]->name;
        }

        if ($content_type->name == 'Study Material') {
            $this->load->model('Studymaterial_model');
            $Contents_array = $this->Studymaterial_model->getContents_name($module_id);
            $contents_name = $Contents_array[0]->name;
        }


        $this->data['contents_name'] = $contents_name;
        $Contents_array = $this->load->view('contents/edit_contents', $this->data);
    }

    public function edit_contentsname() {

        $contents_name = $this->input->post('contents_name');
        $module_type_id = $this->input->post('module_type_id');
        $module_id = $this->input->post('module_id');
        $this->load->model('Content_model');
        $content_type = $this->Content_model->getContentTypeDetail($module_type_id);

        $data = array('name' => $contents_name);

        if ($content_type->name == 'Question Bank') {
            $this->load->model('Questionbank_model');
            $this->Questionbank_model->edit_contentsname($module_id, $data);
        }
        if ($content_type->name == 'Sample Papers') {
            $this->load->model('Samplepapers_model');
            $this->Samplepapers_model->edit_contentsname($module_id, $data);
        }
        if ($content_type->name == 'Solved Papers') {
            $this->load->model('Solvedpapers_model');
            $this->Solvedpapers_model->edit_contentsname($module_id, $data);
        }
        if ($content_type->name == 'Online Tests') {
            $this->load->model('Onlinetest_model');
            $this->Onlinetest_model->edit_contentsname($module_id, $data);
        }

        if ($content_type->name == 'Study Material') {
            $this->load->model('Studymaterial_model');
            $this->Studymaterial_model->edit_contentsname($module_id, $data);
        }
    }

    public function getFileInfo($file_id) {
        $this->load->model('File_model');
        $file_info = $this->File_model->detail($file_id);
        $this->data['file_info'] = $file_info;
        $this->load->view('contents/fileInfo', $this->data);
    }

    public function edit_displayname() {
        $file_id = $this->input->post('file_id');
        $file_name = $this->input->post('file_name');
        $common_filename = $this->input->post('common_filename');
        $data = array('displayname' => $file_name,'filename'=>$common_filename,'filename_one'=>$common_filename.'.pdf');
        $this->load->model('File_model');
        $this->File_model->edit_displayname($file_id, $data);
    }

    public function price($id, $type, $item_id = 0, $module_item_id) {
        $this->load->model('Pricelist_model', 'prices');
        $details = null;
        $relations = null;
        $price = null;
        $this->load->model('Content_model');
        $content_type = $this->Content_model->getContentTypeDetail($type);
        if ($content_type->name == 'Question Bank') {
            $relations = $this->Content_model->getRelations('cmsquestionbank_relations', 'questionbank_id', $id);
            $price = $this->prices->getcontentprice($relations[0], $type, $id);
        }
        if ($content_type->name == 'Sample Papers') {
            $relations = $this->Content_model->getRelations('cmssamplepapers_relations', 'samplepaper_id', $id);
            $price = $this->prices->getcontentprice($relations[0], $type, $id);
        }
        if ($content_type->name == 'Solved Papers') {
            $relations = $this->Content_model->getRelations('cmssolvedpapers_relations', 'questionbank_id', $id);
            $price = $this->prices->getcontentprice($relations[0], $type, $id);
        }
        if ($content_type->name == 'Online Tests') {
            $relations = $this->Content_model->getRelations('cmsonlinetest_relations', 'onlinetest_id', $id);
            $price = $this->prices->getcontentprice($relations[0], $type, $id);
        }
        if ($content_type->name == 'Videos') {
            $relations = $this->Content_model->getRelations('cmsvideolist_relations', 'videolist_id', $id);
            $price = $this->prices->getcontentprice($relations[0], $type, $id);
        }
        if ($content_type->name == 'Study Material') {

            if ($item_id > 0) {
                $price = $this->prices->getItemPrice($item_id, $type);
            } else {
                //$relations = $this->Content_model->getRelations('cmsstudymaterial_relations', 'studymaterial_id', $id);
                //$price = $this->prices->getcontentprice($relations[0], $type, $id);
                $relations = $this->Content_model->getRelations('cmsstudymaterial_relations', 'studymaterial_id', $module_item_id);
                $price = $this->prices->getcontentprice($relations[0], $type, $module_item_id);

                /* $itemid_array = $this->prices->getiemid_std($module_item_id);
                  if(isset($itemid_array->file_id)){
                  $item_id=$itemid_array->file_id;
                  }else{
                  $item_id=0;
                  }
                 */
                $item_id = $id;
                //echo "-----".$item_id;
            }
        }
        if ($content_type->name == 'Articles') {
            
        }
        $this->data['item_id'] = $item_id;
        $this->data['modules_item_id'] = $module_item_id;
        if (isset($relations[0])) {
            $this->data['relations'] = $relations[0];
        } else {
            $this->data['relations'] = NULL;
        }
        $this->data['price'] = $price;
        $this->data['content_type'] = $content_type;
        $this->load->view('contents/price', $this->data);
    }

    public function tag($id, $type) {
        $this->load->model('Tags_model', 'tags');
        $allow = false;
        $details = null;
        $relations = null;
        $tags = null;
        $this->load->model('Content_model');
        $content_type = $this->Content_model->getContentTypeDetail($type);
        if ($content_type->name == 'Question Bank') {
            $relations = $this->Content_model->getRelations('cmsquestionbank_relations', 'questionbank_id', $id);
            $tags = $this->tags->getcontenttags($id, $type);
        }
        if ($content_type->name == 'Sample Papers') {
            $relations = $this->Content_model->getRelations('cmssamplepapers_relations', 'samplepaper_id', $id);
            $tags = $this->tags->getcontenttags($id, $type);
        }
        if ($content_type->name == 'Solved Papers') {
            $relations = $this->Content_model->getRelations('cmssolvedpapers_relations', 'solvedpapers_id', $id);
            $tags = $this->tags->getcontenttags($id, $type);
        }
        if ($content_type->name == 'Online Tests') {
            $relations = $this->Content_model->getRelations('cmsonlinetest_relations', 'onlinetest_id', $id);
            $tags = $this->tags->getcontenttags($id, $type);
        }
        if ($content_type->name == 'Videos') {
            $relations = $this->Content_model->getRelations('cmsvideolist_relations', 'videolist_id', $id);
            $tags = $this->tags->getcontenttags($id, $type);
        }
        if ($content_type->name == 'Study Material') {
            $relations = $this->Content_model->getRelations('cmsstudymaterial_relations', 'studymaterial_id', $id);
            $tags = $this->tags->getcontenttags($id, $type);
        }
        if ($content_type->name == 'Articles') {
            
        }
        $chapterids = array();
        if ($relations) {
            $availabletags = null;
            foreach ($relations as $relation) {
                if ($relation->chapter_id > 0) {
                    $chapterids[] = $relation->chapter_id;
                }
            }
            if (count($chapterids) > 0) {
                $avatags = $this->tags->getChapterTags($chapterids);
                if ($avatags) {
                    foreach ($avatags as $tag) {
                        $availabletags[] = $tag->name;
                    }
                    if ($tags) {
                        $this->data['contenttags'] = $tags;
                    }
                    $this->data['availabletags'] = $availabletags;
                    $this->data['content_id'] = $id;
                    $this->data['type'] = $type;
                    $allow = true;
                }
            }
        }
        $this->data['allow'] = $allow;
        $this->data['content_type'] = $content_type;

        $this->load->view('contents/tags', $this->data);
    }

    public function tags() {
        $term = $this->input->get('term');
        $this->load->model('Tags_model', 'tags');
        $tags = $this->tags->getTagByName($term);
        $tagarray = array();
        if ($tags) {
            foreach ($tags as $tag) {
                //$tagarray[]= array('value'=>$tag->id,'text'=>$tag->name);
                $tagarray[] = $tag->name;
            }
            echo json_encode($tagarray);
        }
    }

    public function addtag() {
        $this->load->model('Tags_model', 'tags');
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $tag = $this->input->post('tag');
        $data = array('content_id' => $id, 'type' => $type, 'tag' => $tag);
        $this->tags->addtagtocontent($data);
    }

    public function removetag() {
        $this->load->model('Tags_model', 'tags');
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $tag = $this->input->post('tag');
        $data = array('content_id' => $id, 'type' => $type, 'tag' => $tag);
        $this->tags->removetagtocontent($data);
    }

    public function remove_relation_byid($relation_id = 0, $id = 0, $type = 0) {
        $this->load->model('Contents_model');
        $this->load->model('Content_model');
        $exam_id = $this->input->post('exam_id');
        $subject_id = $this->input->post('subject_id');
        $chapter_id = $this->input->post('chapter_id');

        $edit_content_type = $this->Content_model->getContentTypeDetail($type);

        if ($edit_content_type->name == 'Study Material') {

            $db_table_name = 'cmsstudymaterial_relations';
        }

        if ($edit_content_type->name == 'Books') {
            $db_table_name = 'cmsbooks_relations';
        }
        if ($edit_content_type->name == 'Videos') {
            $db_table_name = 'cmsvideolist_relations';
        }
        if ($edit_content_type->name == 'Online Tests') {
            $db_table_name = 'cmsonlinetest_relations';
        }
        if ($edit_content_type->name == 'Question Bank') {
            $db_table_name = 'cmsquestionbank_relations';
        }

        if ($edit_content_type->name == 'Sample Papers') {
            $db_table_name = 'cmssamplepapers_relations';
        }

        if ($edit_content_type->name == 'Solved Papers') {
            $db_table_name = 'cmssolvedpapers_relations';
        }

        if ($edit_content_type->name == 'Ncert Solutions') {
            $db_table_name = 'cmsncertsolutions_relations';
        }
        if ($edit_content_type->name == 'Notes') {
            $db_table_name = 'relatedpostings'; 
        }
        $contents = $this->Contents_model->remove_relation_byid($relation_id, $id, $type, $db_table_name, $exam_id = 0, $subject_id = 0, $chapter_id = 0);
    }

    public function delete($id, $module_type) {
        $content_type_name = $this->Content_model->getContentTypeDetail($module_type);

        if ($content_type_name->name == 'Study Material') {
            $this->load->model('Studymaterial_model');
            //Check for question exist or not
            $studymaterial_data = $this->Studymaterial_model->getStudyMaterialDetails($id);

            $studymaterial_data_count = count($studymaterial_data);
            if ($studymaterial_data_count > 0) {

                $this->session->set_flashdata('message', 'Module can not be deleted.Please Remove all questions First!');
                redirect('admin/contents/edit/' . $id . '/' . $module_type);
            } else {
                $this->Studymaterial_model->delete_module_studymaterial($id);
                $this->session->set_flashdata('message', 'Study Material deleted!');
            }
        }

        if ($content_type_name->name == 'Ncert Solutions') {
            $this->load->model('Ncertsolutions_model');
            //Check for question exist or not
            $ncertsolution_data = $this->Ncertsolutions_model->getNcertSolutionsData($id);

            $ncertsolution_data_count = count($ncertsolution_data);

            if ($ncertsolution_data_count > 0) {

                $this->session->set_flashdata('message', 'Module can not be deleted.Please Remove all questions First!');
                redirect('admin/contents/edit/' . $id . '/' . $module_type);
            } else {
                $this->Ncertsolutions_model->delete_module_ncert($id);
                $this->session->set_flashdata('message', 'Ncert Solutions deleted!');
            }
        }

        if ($content_type_name->name == 'Article') {

            $this->Contents_model->deleteContentType($id);
            $this->session->set_flashdata('message', 'Posting deleted!');
        }
        if ($content_type_name->name == 'Videos') {
            $this->load->model('Videos_model');
            //Check for question exist or not
            $videos_data = $this->Videos_model->getVideosDetails($id);

            $videos_data_count = count($videos_data);
            if ($videos_data_count > 0) {

                $this->session->set_flashdata('message', 'Module can not be deleted.Please Remove all Video First!');
                redirect('admin/contents/edit/' . $id . '/' . $module_type);
            } else {
                $this->Videos_model->delete_module_videos($id);
                $this->session->set_flashdata('message', 'Videos Module deleted!');
            }
        }
        if ($content_type_name->name == 'Online Tests') {

            $this->load->model('Onlinetest_model');
            //Check for question exist or not
            $books_data = $this->Onlinetest_model->getolDetails($id);

            $books_data_count = count($books_data);
            if ($books_data_count > 0) {

                $this->session->set_flashdata('message', 'Module can not be deleted.Please Remove all questions First!');
                redirect('admin/contents/edit/' . $id . '/' . $module_type);
            } else {
                $this->Onlinetest_model->delete_module_onlinetest($id);
                $this->session->set_flashdata('message', 'Books deleted!');
            }
        }

        if ($content_type_name->name == 'Books') {

            $this->load->model('Books_model');
            //Check for question exist or not
            $books_data = $this->Books_model->getBookDetails($id);

            $books_data_count = count($books_data);
            if ($books_data_count > 0) {

                $this->session->set_flashdata('message', 'Module can not be deleted.Please Remove all questions First!');
                redirect('admin/contents/edit/' . $id . '/' . $module_type);
            } else {
                $this->Books_model->delete_module_books($id);
                $this->session->set_flashdata('message', 'Books deleted!');
            }
        }
        if ($content_type_name->name == 'Notes') {

            $this->load->model('Notes_model');
            //Check for question exist or not
            $notes_data = $this->Notes_model->getNotesDetails($id);

            $notes_data_count = count($notes_data);
            if ($notes_data_count > 0) {

                $this->session->set_flashdata('message', 'Module can not be deleted.Please Remove all questions First!');
                redirect('admin/contents/edit/' . $id . '/' . $module_type);
            } else {
                $this->Notes_model->delete_module_notes($id);
                $this->session->set_flashdata('message', 'Books deleted!');
            }
        }
        if($content_type_name->name == 'Sample Papers') {
            $this->load->model('Samplepapers_model');
            //Check for question exist or not
            $samplepaper_data = $this->Samplepapers_model->getSamplePaperData($id);
            $samplepaper_data_count = count($samplepaper_data);
            if ($samplepaper_data_count > 0) {
                $this->session->set_flashdata('message', 'Module can not be deleted.Please Remove all questions First!');
                redirect('admin/contents/edit/' . $id . '/' . $module_type);
            } else {
                $this->Samplepapers_model->delete_module_samplepaper($id);
                $this->session->set_flashdata('message', 'Sample Papers deleted!');
            }
        }

        if ($content_type_name->name == 'Question Bank') {
            $this->load->model('Questionbank_model');
            //Check for question exist or not
            $questionbank_data = $this->Questionbank_model->getQuestionbankData($id);

            $questionbank_data_count = count($questionbank_data);
            if ($questionbank_data_count > 0) {
                $this->session->set_flashdata('message', 'Module can not be deleted.Please Remove all questions First!');
                redirect('admin/contents/edit/' . $id . '/' . $module_type);
            } else {
                $this->Questionbank_model->delete_module_questionbank($id);
                $this->session->set_flashdata('message', 'Question Bank deleted!');
            }
        }
        if ($content_type_name->name == 'Solved Papers') {
            $this->load->model('Solvedpapers_model');
            //Check for question exist or not
            $solvedpapers_data = $this->Solvedpapers_model->getSolvedPapersData($id);
            $solvedpapers_data_count = count($solvedpapers_data);
            if ($solvedpapers_data_count > 0) {
                $this->session->set_flashdata('message', 'Module can not be deleted.Please Remove all questions First!');
                redirect('admin/contents/edit/' . $id . '/' . $module_type);
            } else {
                $this->Solvedpapers_model->delete_module_solvedpapers($id);
                $this->session->set_flashdata('message', 'Solved Papers deleted!');
            }
        }
        redirect('admin/contents/add');
    }

    public function samplepaper_to_onlinetest($id, $module_id) {
        $this->load->model('Samplepapers_model');
        $sample_paper = $this->Samplepapers_model->detail($id);
        $sample_paper_details = $this->Samplepapers_model->getSamplePaperData($id);
        $module_relation_details = $this->Samplepapers_model->getRelationDetail($id);
        $instructions = $this->input->post('instructions');
        $formula_id = $this->input->post('formula_id');
        $olcategory_id = $this->input->post('olcategory_id');
        $time = $this->input->post('exam_time');
        $type = $this->input->post('type');
        $test_name = $this->input->post('test_name');
        $calculater = $this->input->post('calculater');
        $main_exam_id = $this->input->post('main_exam_id');
        $main_subject_id = $this->input->post('main_subject_id');
        $main_chapter_id = $this->input->post('main_chapter_id');
        $date = time();
        $otqus_array = $this->input->post('otqus_array');
        if(count($otqus_array)<1||count($otqus_array)==''){
          $this->session->set_flashdata('message', 'Please select atleast one question from bottom.');
        redirect('admin/contents/edit/' . $id . '/' . $module_id . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id);  
        }
        if ($main_exam_id == '' || $main_subject_id == '' || $main_chapter_id == '') {
            $this->session->set_flashdata('message', 'For Online test Exam,Subject and Chapter Require.Please select again and add now. ');
            redirect('admin/contents/add');
        }
        if (!isset($time)) {
            $time = 0;
        }
        if (!isset($test_name)) {
            $test_name = $sample_paper->name;
        }

        $entry_cmsonlinetest = array(
            'name' => $test_name,
            'instructions' => $instructions,
            'formula_id' => $formula_id,
            'olcategory_id'=>$olcategory_id,
            'time' => $time,
            'type' => $type,
            'calculater' => $calculater,
            'created_from' => 'sample-papers',
            'created_from_id' => $module_id,
            'created_by' => $sample_paper->created_by,
            'modified_by' => $sample_paper->modified_by,
            'dt_created' => $date,
            'dt_modified' => $date,
            'is_deleted' => $sample_paper->is_deleted
        );

        $onlinetest_id = $this->Contents_model->add_onlinetest($entry_cmsonlinetest);

        foreach ($sample_paper_details as $sample_paper_details_value) {
             if(in_array($sample_paper_details_value->question_id,$otqus_array)){ 
            $entry_cmsonlinetest_details = array(
                'onlinetest_id' => $onlinetest_id,
                'question_id' => $sample_paper_details_value->question_id,
                'created_by' => $sample_paper_details_value->created_by,
                'modified_by' => $sample_paper_details_value->modified_by,
                'dt_created' => $sample_paper_details_value->dt_created,
                'dt_modified' => $sample_paper_details_value->dt_modified
            );

            $this->Contents_model->add_onlinetest_details($entry_cmsonlinetest_details);
             }
        }


        $entry_cmsonlinetest_relations = array(
            'onlinetest_id' => $onlinetest_id,
            'exam_id' => $main_exam_id,
            'subject_id' => $main_subject_id,
            'chapter_id' => $main_chapter_id,
            'created_by' => 1,
            'dt_created' => $date
        );
        $this->Contents_model->add_relation_in_onlinetest($entry_cmsonlinetest_relations);
        /*
         * //Do Not add test in all relationship
          for ($i = 0; count($module_relation_details) > $i; $i++) {

          $entry_cmsonlinetest_relations = array(
          'onlinetest_id' => $onlinetest_id,
          'exam_id' => $module_relation_details[$i]->exam_id,
          'subject_id' => $module_relation_details[$i]->subject_id,
          'chapter_id' => $module_relation_details[$i]->chapter_id,
          'created_by' => $module_relation_details[$i]->created_by,
          'modified_by' => $module_relation_details[$i]->modified_by,
          'dt_created' => $module_relation_details[$i]->dt_created,
          'dt_modified' => $module_relation_details[$i]->dt_modified
          );
          $this->Contents_model->add_relation_in_onlinetest($entry_cmsonlinetest_relations);
          }
         */
        $this->session->set_flashdata('message', 'Online Test Added!');
        redirect('admin/contents/edit/' . $id . '/' . $module_id . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id);
    }

    public function solvedpaper_to_onlinetest($id, $module_id) {
        $this->load->model('Solvedpapers_model');
        $solved_paper = $this->Solvedpapers_model->detail($id);
        $solved_paper_details = $this->Solvedpapers_model->getSolvedPapersData($id);
        $module_relation_details = $this->Solvedpapers_model->getRelationDetail($id);        
        $instructions = $this->input->post('instructions');
        $formula_id = $this->input->post('formula_id');
        $olcategory_id = $this->input->post('olcategory_id');
        $time = $this->input->post('exam_time');
        $type = $this->input->post('type');
        $test_name = $this->input->post('test_name');
        $calculater = $this->input->post('calculater');
        $main_exam_id = $this->input->post('main_exam_id');
        $main_subject_id = $this->input->post('main_subject_id');
        $main_chapter_id = $this->input->post('main_chapter_id');
        $date = time();
        $otqus_array = $this->input->post('otqus_array');
        if(count($otqus_array)<1||count($otqus_array)==''){
          $this->session->set_flashdata('message', 'Please select atleast one question from bottom.');
        redirect('admin/contents/edit/' . $id . '/' . $module_id . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id);  
        }

        if ($main_exam_id == '' || $main_subject_id == '' || $main_chapter_id == '') {
            $this->session->set_flashdata('message', 'For Online test Exam,Subject and Chapter Require.Please select again and add now. ');
            redirect('admin/contents/add');
        }
        if (!isset($time)) {
            $time = 0;
        }
        if (!isset($test_name)) {
            $test_name = $solved_paper->name;
        }

        $entry_cmsonlinetest = array(
            'name' => $test_name,
            'instructions' => $instructions,
            'formula_id' => $formula_id,
            'olcategory_id'=>$olcategory_id,
            'time' => $time,
            'type' => $type,
            'calculater' => $calculater,
            'created_from' => 'solved-papers',
            'created_from_id' => $module_id,
            'created_by' => $solved_paper->created_by,
            'modified_by' => $solved_paper->modified_by,
            'dt_created' => $date,
            'dt_modified' => $date,
            'is_deleted' => $solved_paper->is_deleted
        );

        $onlinetest_id = $this->Contents_model->add_onlinetest($entry_cmsonlinetest);

        foreach ($solved_paper_details as $solved_paper_details_value) {
             if(in_array($solved_paper_details_value->question_id,$otqus_array)){ 
            $entry_cmsonlinetest_details = array(
                'onlinetest_id' => $onlinetest_id,
                'question_id' => $solved_paper_details_value->question_id,
                'created_by' => $solved_paper_details_value->created_by,
                'modified_by' => $solved_paper_details_value->modified_by,
                'dt_created' => $solved_paper_details_value->dt_created,
                'dt_modified' => $solved_paper_details_value->dt_modified
            );

            $this->Contents_model->add_onlinetest_details($entry_cmsonlinetest_details);
             }
        }

        $entry_cmsonlinetest_relations = array(
            'onlinetest_id' => $onlinetest_id,
            'exam_id' => $main_exam_id,
            'subject_id' => $main_subject_id,
            'chapter_id' => $main_chapter_id,
            'created_by' => 1,
            'dt_created' => $date
        );
        $this->Contents_model->add_relation_in_onlinetest($entry_cmsonlinetest_relations);
        /*
         * //Do Not add test in all relationship
          for ($i = 0; count($module_relation_details) > $i; $i++) {

          $entry_cmsonlinetest_relations = array(
          'onlinetest_id' => $onlinetest_id,
          'exam_id' => $module_relation_details[$i]->exam_id,
          'subject_id' => $module_relation_details[$i]->subject_id,
          'chapter_id' => $module_relation_details[$i]->chapter_id,
          'created_by' => $module_relation_details[$i]->created_by,
          'modified_by' => $module_relation_details[$i]->modified_by,
          'dt_created' => $module_relation_details[$i]->dt_created,
          'dt_modified' => $module_relation_details[$i]->dt_modified
          );
          $this->Contents_model->add_relation_in_onlinetest($entry_cmsonlinetest_relations);
          }
         */

        $this->session->set_flashdata('message', 'Online Test Added!');
        redirect('admin/contents/edit/' . $id . '/' . $module_id . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id);
    }

    public function questionbank_to_onlinetest($id, $module_id) {
        $this->load->model('Questionbank_model');
        $this->load->model('Questions_model');
        $questionbank = $this->Questionbank_model->detail($id);
        $questionbank_details = $this->Questionbank_model->getQuestionbankData($id);
        $module_relation_details = $this->Questionbank_model->getRelationDetail($id);
        $instructions = $this->input->post('instructions');
        $formula_id = $this->input->post('formula_id');
        $olcategory_id=$this->input->post('olcategory_id');
        $time = $this->input->post('exam_time');
        $type = $this->input->post('type');
        $test_name = $this->input->post('test_name');
        $calculater = $this->input->post('calculater');
        $main_exam_id = $this->input->post('main_exam_id');
        $main_subject_id = $this->input->post('main_subject_id');
        $main_chapter_id = $this->input->post('main_chapter_id');
        $section=$this->input->post('section');
        $section_name=$this->input->post('section_name');
        $date = time();
        $otqus_array = $this->input->post('otqus_array');
        if(count($otqus_array)<1||count($otqus_array)==''){
          $this->session->set_flashdata('message', 'Please select atleast one question from bottom.');
        redirect('admin/contents/edit/' . $id . '/' . $module_id . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id);  
        }
       
        if ($main_exam_id == '' || $main_subject_id == '' || $main_chapter_id == '') {
            $this->session->set_flashdata('message', 'For Online test Exam,Subject and Chapter Require.Please select again and add now. ');
            redirect('admin/contents/add');
        }
        if (!isset($time)) {
            $time = 0;
        }
        if (!isset($test_name)) {
            $test_name = $questionbank->name;
        }
        $entry_cmsonlinetest = array(
            'name' => $test_name,
            'instructions' => $instructions,
            'formula_id' => $formula_id,
            'olcategory_id'=>$olcategory_id,
            'time' => $time,
            'type' => $type,
            'calculater' => $calculater,
            'created_from' => 'question-bank',
            'created_from_id' => $module_id,
            'created_by' => $questionbank->created_by,
            'modified_by' => $questionbank->modified_by,
            'dt_created' => $date,
            'dt_modified' => $date,
            'is_deleted' => $questionbank->is_deleted
        );

        $onlinetest_id = $this->Contents_model->add_onlinetest($entry_cmsonlinetest);

        foreach ($questionbank_details as $questionbank_details_value) {
         if(in_array($questionbank_details_value->question_id,$otqus_array)){   
            $entry_cmsonlinetest_details = array(
                'onlinetest_id' => $onlinetest_id,
                'question_id' => $questionbank_details_value->question_id,
                'created_by' => $questionbank_details_value->created_by,
                'modified_by' => $questionbank_details_value->modified_by,
                'dt_created' => $questionbank_details_value->dt_created,
                'dt_modified' => $questionbank_details_value->dt_modified
            );

            $this->Contents_model->add_onlinetest_details($entry_cmsonlinetest_details);
            //Edit question table for section and section name
            $qid=$questionbank_details_value->question_id;
            if($qid>0){
                if($section==''){
                    $section='A';
                }
                
                if($section_name==''){
                    $section_name='FIRST';
                }
                
                $q_data = array(
                  'section'=>$section,
                  'section_name'=>$section_name  
                );
             $this->Questions_model->update_question($qid,$q_data);
            }
        }
        }

        $entry_cmsonlinetest_relations = array(
            'onlinetest_id' => $onlinetest_id,
            'exam_id' => $main_exam_id,
            'subject_id' => $main_subject_id,
            'chapter_id' => $main_chapter_id,
            'created_by' => 1,
            'dt_created' => $date
        );
        $this->Contents_model->add_relation_in_onlinetest($entry_cmsonlinetest_relations);
        $this->session->set_flashdata('message', 'Online Test Added!');
        redirect('admin/contents/edit/' . $id . '/' . $module_id . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id);
    }
    
     function updateot_marks($onlinetest_details_id,$marks){
         
         $date = time();
          $edit_cmsonlinetest_details = array(
                'marks' => $marks,
                'modified_by' => 1,
                'dt_modified' => $date
                );
        $this->Onlinetest_model->edit_ottest_detail($onlinetest_details_id,$edit_cmsonlinetest_details);
     }
     
     
     
    function updateot_qus($onlinetest_id,$question_id,$action){
        $date = time();
        $result=array();
        if($action=='add'){
            
if($question_id>0&&$onlinetest_id>0){
            $qdetail=$this->Questions_model->detail($question_id);
            $entry_cmsonlinetest_details = array(
                'onlinetest_id' => $onlinetest_id,
                'question_id' => $question_id,
                'section' => $qdetail->section,
                'section_name' => $qdetail->section_name,
                'created_by' => 1,
                'dt_created' => $date
                );
           $this->Contents_model->add_onlinetest_details($entry_cmsonlinetest_details);
}else{
     $result['added']='no';
}
        }
        if($action=='remove'){
            $this->Onlinetest_model->remove_examques($onlinetest_id,$question_id);
       $result['deleted']='yes';
            }
        
        if (count($result) > 0) {
            $response['data'] = $result;
        } else {
            $response['data'] = array();
        }
        echo json_encode($response);
        
    }
    
    function create_selfAssessment($ot_id,$module_id,$main_exam_id,$main_subject_id,$main_chapter_id){
        $date = time();
        $entry_cmsonlinetest_details = array(
            'assessment_type' => 'self',
            'dt_modified'=>$date);
        $this->Contents_model->update_onlinetest($ot_id,$entry_cmsonlinetest_details);        
        redirect('admin/contents/edit/' . $ot_id . '/' . $module_id . '/' . $main_exam_id . '/' . $main_subject_id . '/' . $main_chapter_id);
    }
    
    function tamp($tempvar='youtube'){$this->load->model('Videos_model');
        $showall_vid=$this->Videos_model->getVideoDetails_all($tempvar);
        ?><table style="width:100%;border-color: coral;">
  <tr>
    <th>Number</th>
    <th>Video Name</th>
    <th>Playlist</th> 
    <th>video tag</th>
    <th>Image</th>
    <th>Delete</th>
  </tr><?php $cnt=1;
        foreach($showall_vid as $value){
         ?> 
  <tr>
    <td><?php echo $cnt; ?></td>
    <td><a title="<?php echo $value->exam.'=>'.$value->subject.'=>'.$value->chapter; ?>"><?php  echo $value->title; ?></a></td>
    <td><?php echo $value->name; ?></td>
    <td><?php echo substr($value->video_tag, 0, 12); ?></td>
    <td><img data-default="https://i.ytimg.com/vi/<?php echo $value->video_url_code; ?>/mqdefault.jpg" data-retina="https://i.ytimg.com/vi/aZN_s5M_H-4/mqdefault.jpg" src="https://i.ytimg.com/vi/<?php echo $value->video_url_code; ?>/mqdefault.jpg" style="width: auto; height: 100%; margin-left: -13px; margin-top: 0px;">
    </td>
    <td><a onclick="return myFunction()" target="_blank" href="https://www.studyadda.com/admin/content/deletevideo/<?php echo $value->id; ?>/0/0/0/0/0">
        <?php echo 'DELETE'; ?></td>
    
  </tr> <?php $cnt++;
        }
        ?>
  <script>
function myFunction() {
  var txt;
  var r = confirm("Video will be delete");
  if (r == true) {
    return true;
  } else {
    return false;
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>
</table>
    <?php
    } 
}

?>
