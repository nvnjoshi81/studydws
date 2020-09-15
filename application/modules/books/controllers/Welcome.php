<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Welcome extends Modulecontroller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Books_model');
    }

    public function index($examname = null, $exam_id = 0, $subjectname = null, $subject_id = 0, $chapter_name = null, $chapter_id = 0) {
        $examdata = array();
        if ($examname == null) {
            $title = getTitle('E-Books', $this->data['examcategories']);

            $titleStr[] = $title;
        } else {
            $titleStr[] = 'E-Books for';
        }
        if ($exam_id > 0) {
            $exam = $this->Categories_model->getCategoryDetails($exam_id);
            $this->data['selectedexam'] = $exam;
            $titleStr[] = $exam->name;
        }
        if ($subject_id > 0) {
            $this->load->model('Subjects_model');
            $this->data['selectedsubject'] = $this->Subjects_model->getSubject($subject_id);
            $titleStr[] = $this->data['selectedsubject']->name;
        }
        if ($chapter_id > 0) {
            $this->load->model('Chapters_model');
            $this->data['selectedchapter'] = $this->Chapters_model->getChapter($chapter_id);
            $titleStr[] = $this->data['selectedchapter']->name;
        }
        if ($exam_id) {
            $data_array = array();
            $chaptersubjects = $this->Examcategory_model->getExamChapters($exam_id);
            if (count($chaptersubjects) > 0) {
                foreach ($chaptersubjects as $record) {
                    if (array_key_exists($record->sname, $data_array)) {
                        //$data_array[$record->name][]
                        array_push($data_array[$record->sname]['chapters'], array($record->cid, $record->cname));
                    } else {
                        $data_array[$record->sname]['id'] = $record->sid;
                        if (isset($data_array[$record->sname]['chapters'])) {
                            array_push($data_array[$record->sname]['chapters'], array($record->cid, $record->cname));
                        } else {
                            $data_array[$record->sname]['chapters'][0] = array($record->cid, $record->cname);
                        }
                    }
                }
            }
            $this->data['subject_chapters'] = $data_array;
        }
        //$studymaterials = $this->Studymaterial_model->getStudyMaterial($exam_id, $subject_id, $chapter_id);
        //$this->data['studymaterials'] = $studymaterials;
        $books = $this->Books_model->getBooks($exam_id, $subject_id, $chapter_id);
        $this->data['books'] = $books;
        $files = $this->Books_model->getBooksCount($exam_id, $subject_id, $chapter_id);
        $productslist = $this->Pricelist_model->getAllProducts($exam_id, $subject_id, $chapter_id, 4);
        $isProduct = $this->Pricelist_model->getProduct($exam_id, $subject_id, $chapter_id, 4);
        $this->data['isProduct'] = $isProduct;
        //print_r($isProduct);
        $this->data['productslist'] = $productslist;
        $this->data['title'] = implode(' ', $titleStr);
        $this->data['h1title'] = implode(' ', $titleStr);
        $this->data['files'] = $files;
        $this->data['exam_id'] = $exam_id;
        $this->data['subject_id'] = $subject_id;
        $this->data['chapter_id'] = $chapter_id;
        $this->data['examdata'] = $examdata;
        $this->data['content'] = 'welcome';
        $data = $this->Books_model->getBooksList($exam_id, $subject_id);

        $solutions_array = array();
        foreach ($data as $result) {

            if (!array_key_exists($result->exam_id, $solutions_array)) {
                $solutions_array[$result->exam_id] = array('name' => $result->exam, 'subjects' => array());
            }
            if (!array_key_exists($result->subject_id, $solutions_array[$result->exam_id]['subjects'])) {
                $solutions_array[$result->exam_id]['subjects'][$result->subject_id] = array('id' => $result->subject_id, 'name' => $result->subject);
            }
        }
        $this->data['solutions_array'] = $solutions_array;
        $this->load->view('template', $this->data);
    }

    public function details($smname, $smid) {
        $url_segments = $this->uri->segment_array();
        
        array_pop($url_segments);
        if(count($url_segments)==4){
            $url_segments[]='all';
        }
        if(count($url_segments)==3){
            $url_segments[]='all';$url_segments[]='all';
        }
        $this->data['url_segments'] = $url_segments;
        $this->load->model('Questions_model');
        $smdetails = $this->Books_model->details($smid);
        $relation = $this->Books_model->getRelations($smid);
        $files = $this->Books_model->getFiles($smid);
        /* To display questions */
        //$questions = $this->Books_model->getQuestions($smid);
        //$questiontypes = $this->Books_model->questionTypes($smid);
        $title = generateTitle('E-Books for', $relation[0], $smdetails->name);
        $relation_detail_array = $this->Books_model->getRelationDetail($smid); 
        $exam_id=$relation_detail_array[0]->exam_id;
        $subject_id=$relation_detail_array[0]->subject_id;
        $chapter_id=$relation_detail_array[0]->chapter_id;
        $isProduct = $this->Pricelist_model->getProduct($exam_id, $subject_id, $chapter_id, 1);
        $this->data['isProduct'] = $isProduct;
        $this->data['title'] = $title;
        $this->data['smdetails'] = $smdetails;
        $this->data['relation'] = $relation[0];
        $this->data['files'] = $files;
        $this->data['content'] = 'details';
        /* To display questions */
        //$this->data['questiontypes'] = $questiontypes;
        //$this->data['questions'] = $questions;
        $this->data['loadMathJax'] = 'YES';
        $this->load->view('template', $this->data);
    }

    public function show($filename, $fileid) {
        
        $this->load->model('File_model');
        $file = $this->File_model->detail($fileid);

        $studyfile_array = $this->Books_model->getBooksFiles($fileid);
        
        $smid = $studyfile_array[0]->books_id ;
        $relation_detail_array = $this->Books_model->getRelations($smid);
        
        /*$exam_id=$relation_detail_array[0]->exam_id;
        $subject_id=$relation_detail_array[0]->subject_id;
        $chapter_id=$relation_detail_array[0]->chapter_id;*/
        $isProduct = $this->Pricelist_model->getItemPrice($fileid,4);
        $this->data['relation']=$relation_detail_array[0];
        $this->data['title']=str_replace('_',' ',$file->filename).' Study Package';
        $this->data['isProduct'] = $isProduct;
        
        $this->data['file'] = $file;
        $this->data['content'] = 'show'; 
        $this->load->view('template', $this->data);
    }

    public function rename(){
        $sm=$this->Studymaterial_model->getChapterNameForStudyMaterial();
        $count=0;
        
        foreach($sm as $item){
            $name=$item->name;
            if($item->id==92){
                $name='HCV Solutions';
            }else{
                $name=$item->chapter;
            }
          //  $this->db->query('Update cmsstudymaterial set name="'.$name.'" where id='.$item->id);
        }
        echo $count;
    }
}
