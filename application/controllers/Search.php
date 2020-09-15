<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Search extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Videos_model', 'videos');
        $this->load->model('Posting_model', 'articles');
        $this->load->model('Ncertsolutions_model', 'ncertsolutions');
        $this->load->model('Studymaterial_model', 'studymaterial');
        $this->load->model('Questionbank_model', 'questions');
        $this->load->model('Samplepapers_model', 'samplepapers');
        $this->load->model('Solvedpapers_model', 'solvedpapers');
        $this->load->model('Search_model', 'search');
    }
    public function index($search = null, $type = null) {
        if (!empty($search)) {
            $this->load->library('pagination');
            $config = array();
            $config["base_url"] = base_url('search/' . $search . '/' . $type);
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
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $video_results = null;
            $studymaterial_results = null;
            $article_results = null;
            $question_results = null;
            $samplepapers_results = null;
            $solvedpaers_results = null;
            $ncertsolutions_results = null;
            $searchtxt = null;
            $video_results_count = $this->videos->search_count($search);
            $video_results = $this->videos->search($search, $config["per_page"], $page);

            $studymaterial_results_count = $this->studymaterial->search_count($search);
            $studymaterial_results = $this->studymaterial->search($search, $config["per_page"], $page);

            $article_results_count = $this->articles->search_count($search);
            $article_results = $this->articles->search($search, $config["per_page"], $page);

            $ncertsolutions_results_count = $this->ncertsolutions->search_count($search);
            $ncertsolutions_results = $this->ncertsolutions->search($search, $config["per_page"], $page);

            $question_results_count = $this->questions->search_count($search);
            $question_results = $this->questions->search($search, $config["per_page"], $page);

            $samplepapers_results_count = $this->samplepapers->search_count($search);
            $samplepapers_results = $this->samplepapers->search($search, $config["per_page"], $page);

            $solvedpapers_results_count = $this->solvedpapers->search_count($search);
            $solvedpapers_results = $this->solvedpapers->search($search, $config["per_page"], $page);

            $totalresults = $video_results_count + $studymaterial_results_count + $article_results_count + $ncertsolutions_results_count + $question_results_count + $samplepapers_results_count + $solvedpapers_results_count;
            if ($type == 'all') {
                $title = "Allcontent for " . urldecode($search);
                $searchtxt = ' <b>" ' . $totalresults . ' results found for ' . urldecode($search) . ' "</b>';
            }
            if ($type == 'videos') {
                $title = "Videos for " . urldecode($search);
                $searchtxt = ' <b>" ' . $video_results_count . ' videos found for ' . urldecode($search) . ' "</b>';
                $config["total_rows"] = $video_results_count;
            }

            if ($type == 'study-packages') {
                $title = "Study Packages for " . urldecode($search);
                $searchtxt = ' <b>" ' . $studymaterial_results_count . ' study packages found for ' . urldecode($search) . ' "</b>';
                $config["total_rows"] = $studymaterial_results_count;
            }


            if ($type == 'notes') {
                $title = "Notes for " . urldecode($search);
                $searchtxt = ' <b>" ' . $article_results_count . ' notes found for ' . urldecode($search) . ' "</b>';
                $config["total_rows"] = $article_results_count;
            }


            if ($type == 'ncert-solution') {
                $title = "NCERT Solutions for " . urldecode($search);
                $searchtxt = ' <b>" ' . $ncertsolutions_results_count . ' NCERT solution found for ' . urldecode($search) . ' "</b>';
                $config["total_rows"] = $ncertsolutions_results_count;
            }


            if ($type == 'question-bank') {
                $title = "Questions for " . urldecode($search);
                $searchtxt = ' <b>" ' . $question_results_count . ' questions found for ' . urldecode($search) . ' "</b>';
                $config["total_rows"] = $question_results_count;
            }
            if ($type == 'sample-papers') {
                $title = "Sample Papers for " . urldecode($search);
                $searchtxt = ' <b>" ' . $samplepapers_results_count . ' sample papers found for ' . urldecode($search) . ' "</b>';
                $config["total_rows"] = $samplepapers_results_count;
            }

            if ($type == 'solved-papers') {
                $title = "solved Papers for " . urldecode($search);
                $searchtxt = ' <b>" ' . $solvedpapers_results_count . ' Solved papers found for ' . urldecode($search) . ' "</b>';
                $config["total_rows"] = $solvedpapers_results_count;
            }
            //echo $searchtxt;
            $this->pagination->initialize($config);
            $this->data['samplepapers_results'] = $samplepapers_results;
            $this->data['samplepapers_results_count'] = $samplepapers_results_count;
            $this->data['solvedpapers_results'] = $solvedpapers_results;
            $this->data['solvedpapers_results_count'] = $solvedpapers_results_count;
            $this->data['question_results'] = $question_results;
            $this->data['question_results_count'] = $question_results_count;
            $this->data['ncertsolutions_results'] = $ncertsolutions_results;
            $this->data['ncertsolutions_results_count'] = $ncertsolutions_results_count;
            $this->data['article_results'] = $article_results;
            $this->data['article_results_count'] = $article_results_count;
            $this->data['video_results'] = $video_results;
            $this->data['video_results_count'] = $video_results_count;
            $this->data['studymaterial_results'] = $studymaterial_results;
            $this->data['studymaterial_results_count'] = $studymaterial_results_count;
            $this->data['content'] = 'search';
            $this->data['totalresults'] = $totalresults;
            $this->data['searchtxt'] = $searchtxt;
            $this->data['title'] = $title;
            $this->data["links"] = $this->pagination->create_links();
            $resultCount = $this->search->getSearchResult($search);
            if (($resultCount < 1) || ($resultCount == '')) {
                $this->search->insert($search, $this->input->server('REMOTE_ADDR'), $totalresults, $type, $this->session->userdata('customer_id') ? $this->session->userdata('customer_id') : 0);
            }
        } else {
            $this->data['searchtxt'] = '';
            $this->data['content'] = 'emptysearch';
        }

        $this->data['type'] = $type;
        $this->data['search'] = $search;
        $this->load->view('template', $this->data);
    }

}
