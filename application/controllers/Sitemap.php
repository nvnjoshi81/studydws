<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sitemap extends CI_Controller {
 
    public function _constrct(){
        parent :: _construct();
    }
    
    public function index()
	{
        $this->load->view('welcome_message');
	}
    
        
        
/*For pdf Genration */



 public function questionbank_pdfdownload(){

   $this->load->model('Questionbank_model');
        $return_val =  $this->Questionbank_model->getClass_Questionbank();
        
        $solutions_array=array();
        foreach($return_val as $result){
           
            if(!array_key_exists($result->exam_id, $solutions_array)){
                $solutions_array[$result->exam_id]=array('name'=>$result->exam,'subjects'=>array());
            }
            if(!array_key_exists($result->subject_id, $solutions_array[$result->exam_id]['subjects']) && $result->subject_id > 0){
                $solutions_array[$result->exam_id]['subjects'][$result->subject_id]=array('id'=>$result->subject_id,'name'=>$result->subject);
            }
        }
   
    
	echo "<br>CLASS<br>" ; 
    //Create Class URLS
    echo base_url()."question-bank/\n<br>";
    foreach($solutions_array as $key=>$value){
       // echo base_url('question-bank/'.url_title($value['name'],'-',true).'/'.$key."\n<br>");
    }
    
	echo "<br>SUBJECT<br>";  
    //Create Subject URLS    
foreach($solutions_array as $key=>$value){
    foreach($value['subjects'] as $k=>$v){
        
              //echo  base_url('question-bank/'.url_title($value['name'],'-',true).'/'.$key.'/'.url_title($v['name'],'-',true).'/'.$k)."\n<br>";
  
     }
}


echo "<br>CHAPTER<br>" ; 
//Create Chapter URLS
$chapter_array = $this->Questionbank_model->getChapter_Questionbank();
foreach($chapter_array as $qb){    
	
   $sequrecode=$qb->id.'_st@ad_'.$qb->id;
            $sequrecode =  encrypt($sequrecode);
echo generateContentLink('pdfquestion-bank',$qb->exam,$qb->subject,$qb->chapter,$qb->name.$qb->id,$sequrecode)."\n<br>"; 




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
                    //$cmsfiles_last_id = $this->Contents_model->add_cmsfiles($data_files);
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
                       // $this->Contents_model->add($price_data);



}

echo "<br>FILE<br>" ; 

//Create file urls
$filedetails =$this->Questionbank_model->getfiles_Questionbank();

foreach($filedetails as $files){
    if($files->file_id > 0){
    //echo base_url('question-bank/show/'.  url_title($files->filename,'-',true).'/'.$files->file_id)."\n<br>";
    }
    }
    
echo 'check';
$allowpdf='no';
	 if($allowpdf=='yes'){
try
{
    require APPPATH . 'third_party\pdfcrowd\pdfcrowd.php';
    // create the API client instance
    $client = new \Pdfcrowd\HtmlToPdfClient("naveenhybrid123", "b4d354f10a33bb0da3732c3270d4cd64");
    // create output file for conversion result
    $output_file = fopen("$_SERVER[DOCUMENT_ROOT]\upload\pdfs\spsexample.pdf", "wb");
    // check for a file creation error
    if (!$output_file)
        throw new \Exception(error_get_last()['message']);
    // run the conversion and store the result into a pdf variable
    $pdf = $client->convertUrl("https://studyadda.com/question-bank/jee-main-advanced/mathematics/complex-numbers-and-quadratic-equations/critical-thinking/1506");

    // write the pdf into the output file
    $written = fwrite($output_file, $pdf);

    // check for a file write error
    if ($written === false)
        throw new \Exception(error_get_last()['message']);

    // close the output file
    fclose($output_file);
}
catch(\Pdfcrowd\Error $why)
{
// report the error
error_log("Pdfcrowd Error: {$why}\n");
// handle the exception here or rethrow and handle it at a higher level
    throw $why;
}
 }
 }
 }
        
    public function solvedpapers_map()
	{
        $this->load->model('Solvedpapers_model');
        $return_val =  $this->Solvedpapers_model->getClass_solvedpapers();
        
        $solutions_array=array();
        foreach($return_val as $result){
           
            if(!array_key_exists($result->exam_id, $solutions_array)){
                $solutions_array[$result->exam_id]=array('name'=>$result->exam,'subjects'=>array());
            }
            if(!array_key_exists($result->subject_id, $solutions_array[$result->exam_id]['subjects']) && $result->subject_id > 0){
                $solutions_array[$result->exam_id]['subjects'][$result->subject_id]=array('id'=>$result->subject_id,'name'=>$result->subject);
            }
        }
   
        $file = "solvedpapers_urls";
    $fh = fopen($file, 'w');
    
    //Create Class URLS
    fwrite($fh, base_url()."solved-papers/\n");
    foreach($solutions_array as $key=>$value){
        fwrite($fh, base_url('solved-papers/'.url_title($value['name'],'-',true).'/'.$key."\n"));
    }
    
    //Create Subject URLS
    $solvedpapers=$this->Solvedpapers_model->getSubject_solvedpapers();
    
   foreach($solvedpapers as $qb){
        fwrite($fh, generateContentLink('solved-papers',$qb->exam,$qb->subject,$qb->chapter,$qb->name,$qb->id)."\n");
    }
     //Create chapter URLS
   
        $questions=$this->Solvedpapers_model->getQuestions_solvedpapers();
       
      foreach($questions as $question){
      if($question->question_id!=''){    
           fwrite($fh, base_url('solved-papers/'.url_title($question->name,'-',TRUE).'/'.$question->solvedpapers_id.'/'.$question->question_id)."\n");
       
      }
       }
       
           //Create file urls
$filedetails =$this->Solvedpapers_model->getfiles_Solvedpapers();

foreach($filedetails as $files){
    if($files->file_id > 0){
    fwrite($fh, base_url('solved-papers/show/'.  url_title($files->filename,'-',true).'/'.$files->file_id)."\n");
    }

}
    
    fclose($fh);
    
    
        //echo $return_val.'-outer-';
	}
        
        public function ncert_map(){
            $this->load->model("Ncertsolutions_model");
            $class_array = $this->Ncertsolutions_model->getClass_Ncertsolutions();
            
            $solutions_array=array();
        foreach($class_array as $result){
           
            if(!array_key_exists($result->exam_id, $solutions_array)){
                $solutions_array[$result->exam_id]=array('name'=>$result->exam,'subjects'=>array());
            }
            if(!array_key_exists($result->subject_id, $solutions_array[$result->exam_id]['subjects']) && $result->subject_id > 0){
                $solutions_array[$result->exam_id]['subjects'][$result->subject_id]=array('id'=>$result->subject_id,'name'=>$result->subject);
            }
        }
            $file = "ncertsolution_urls";
    $fh = fopen($file, 'w');
    
    //Create Class URLS
    fwrite($fh, base_url()."ncert-solution/\n");
    foreach($solutions_array as $key=>$value){
        fwrite($fh, base_url('ncert-solution/'.url_title($value['name'],'-',true).'/'.$key."\n"));
    }
    
    

//Create Subject URLS    
//$subject_array = $this->Ncertsolutions_model->getClass_Ncertsolutions();
foreach($solutions_array as $key=>$value){
    foreach($value['subjects'] as $k=>$v){
        
              fwrite($fh, base_url('ncert-solution/'.url_title($value['name'],'-',true).'/'.$key.'/'.url_title($v['name'],'-',true).'/'.$k)."\n");
  
     }
    
}

//Create Chapter URLS
$chapter_array = $this->Ncertsolutions_model->getChapter_Ncertsolutions();

foreach($chapter_array as $qb){
    
             fwrite($fh, generateContentLink('ncert-solution',$qb->exam,$qb->subject,$qb->chapter,$qb->name,$qb->id)."\n");
 
}

//Create Questions URLS
 $ncertdetails = $this->Ncertsolutions_model->getQuestions_Ncertsolutions();
    
      foreach($ncertdetails as $ncert){
          if($ncert->question_id!=''){
      fwrite($fh, base_url('ncert-solution').'/'.url_title($ncert->name,'-',TRUE).'/'.$ncert->ncertsolutions_id.'/'.$ncert->question_id."\n");
    }
    }
    
    
    //Create file urls
$filedetails =$this->Ncertsolutions_model->getfiles_Ncertsolutions();

foreach($filedetails as $files){
    if($files->file_id > 0){
    fwrite($fh, base_url('ncert-solution/show/'.  url_title($files->filename,'-',true).'/'.$files->file_id)."\n");
    }

}
     fclose($fh);
        
    }
        
    public function samplepapers_map(){ 
          $this->load->model('Samplepapers_model');
        $return_val =  $this->Samplepapers_model->getClass_samplepapers();
        
        $solutions_array=array();
        foreach($return_val as $result){
           
            if(!array_key_exists($result->exam_id, $solutions_array)){
                $solutions_array[$result->exam_id]=array('name'=>$result->exam,'subjects'=>array());
            }
            if(!array_key_exists($result->subject_id, $solutions_array[$result->exam_id]['subjects']) && $result->subject_id > 0){
                $solutions_array[$result->exam_id]['subjects'][$result->subject_id]=array('id'=>$result->subject_id,'name'=>$result->subject);
            }
        }
   
        $file = "samplepapers_urls";
    $fh = fopen($file, 'w');
    
    //Create Class URLS
    fwrite($fh, base_url()."sample-papers/\n");
    foreach($solutions_array as $key=>$value){
        fwrite($fh, base_url('sample-papers/'.url_title($value['name'],'-',true).'/'.$key."\n"));
    }
    
    //Create Subject URLS    
foreach($solutions_array as $key=>$value){
    foreach($value['subjects'] as $k=>$v){
        
              fwrite($fh, base_url('sample-papers/'.url_title($value['name'],'-',true).'/'.$key.'/'.url_title($v['name'],'-',true).'/'.$k)."\n");
  
     }
}
//Create Chapter URLS
$chapter_array = $this->Samplepapers_model->getChapter_Samplepapers();

foreach($chapter_array as $qb){
    
             fwrite($fh, generateContentLink('sample-papers',$qb->exam,$qb->subject,$qb->chapter,$qb->name,$qb->id)."\n");
 
}

//Create Questions URLS
 $samplepapersdetails = $this->Samplepapers_model->getQuestions_Samplepapers();
    
      foreach($samplepapersdetails as $samplepapers){
      if($samplepapers->question_id!=''){
          fwrite($fh, base_url('sample-papers').'/'.url_title($samplepapers->name,'-',TRUE).'/'.$samplepapers->samplepaper_id.'/'.$samplepapers->question_id."\n");
    }
    }
    
    //Create file urls
$filedetails =$this->Samplepapers_model->getfiles_Samplepapers();

foreach($filedetails as $files){
    if($files->file_id > 0){
    fwrite($fh, base_url('sample-papers/show/'.  url_title($files->filename,'-',true).'/'.$files->file_id)."\n");
    }
}
        fclose($fh);
        
    }
    
    public function studymaterial_map(){
        $this->load->model('Studymaterial_model');
        $return_val =  $this->Studymaterial_model->getClass_Studymaterial();
        
        $solutions_array=array();
        foreach($return_val as $result){
           
            if(!array_key_exists($result->exam_id, $solutions_array)){
                $solutions_array[$result->exam_id]=array('name'=>$result->exam,'subjects'=>array());
            }
            if(!array_key_exists($result->subject_id, $solutions_array[$result->exam_id]['subjects']) && $result->subject_id > 0){
                $solutions_array[$result->exam_id]['subjects'][$result->subject_id]=array('id'=>$result->subject_id,'name'=>$result->subject);
            }
        }
   
        $file = "studymaterial_urls";
    $fh = fopen($file, 'w');
    
    //Create Class URLS
    fwrite($fh, base_url()."study-packages/\n");
    foreach($solutions_array as $key=>$value){
        fwrite($fh, base_url('study-packages/'.url_title($value['name'],'-',true).'/'.$key."\n"));
    }
    
    //Create Subject URLS    
foreach($solutions_array as $key=>$value){
    foreach($value['subjects'] as $k=>$v){
        
              fwrite($fh, base_url('study-packages/'.url_title($value['name'],'-',true).'/'.$key.'/'.url_title($v['name'],'-',true).'/'.$k)."\n");
  
     }
}
//Create Chapter URLS
$chapter_array = $this->Studymaterial_model->getChapter_Studymaterial();

foreach($chapter_array as $qb){
    
             fwrite($fh, generateContentLink('study-packages',$qb->exam,$qb->subject,$qb->chapter,$qb->name,$qb->id)."\n");
 
}

//Create Questions URLS
 $studymaterialsdetails = $this->Studymaterial_model->getQuestions_Studymaterial();
 

    
      foreach($studymaterialsdetails as $studymaterials){
          if($studymaterials->question_id!=''){
      fwrite($fh, base_url('study-packages').'/'.url_title($studymaterials->name,'-',TRUE).'/'.$studymaterials->studymaterial_id.'/'.$studymaterials->question_id."\n");
    }
}
//Create file urls
$filedetails =$this->Studymaterial_model->getfiles_Studyamaterials();

foreach($filedetails as $files){
    if($files->file_id > 0){
    fwrite($fh, base_url('study-packages/show/'.  url_title($files->filename,'-',true).'/'.$files->file_id)."\n");
    }
}

        fclose($fh);
        
}

 public function questionbank_map(){
        $this->load->model('Questionbank_model');
        $return_val =  $this->Questionbank_model->getClass_Questionbank();
        $solutions_array=array();
        foreach($return_val as $result){
            if(!array_key_exists($result->exam_id, $solutions_array)){
                $solutions_array[$result->exam_id]=array('name'=>$result->exam,'subjects'=>array());
            }
            if(!array_key_exists($result->subject_id, $solutions_array[$result->exam_id]['subjects']) && $result->subject_id > 0){
                $solutions_array[$result->exam_id]['subjects'][$result->subject_id]=array('id'=>$result->subject_id,'name'=>$result->subject);
            }
        }
   
    $file = "questionbank_urls";
    $fh = fopen($file, 'w');
    
    //Create Class URLS
    fwrite($fh, base_url()."question-bank/\n");
    foreach($solutions_array as $key=>$value){
        fwrite($fh, base_url('question-bank/'.url_title($value['name'],'-',true).'/'.$key."\n"));
    }
    
    //Create Subject URLS    
foreach($solutions_array as $key=>$value){
    foreach($value['subjects'] as $k=>$v){
        
              fwrite($fh, base_url('question-bank/'.url_title($value['name'],'-',true).'/'.$key.'/'.url_title($v['name'],'-',true).'/'.$k)."\n");
  
     }
}

//Create Chapter URLS
$chapter_array = $this->Questionbank_model->getChapter_Questionbank();
foreach($chapter_array as $qb){    
fwrite($fh, generateContentLink('question-bank',$qb->exam,$qb->subject,$qb->chapter,$qb->name,$qb->id)."\n"); 
}
//Create Questions URLS
 $questiondetails = $this->Questionbank_model->getQuestions_Questionbank();
      foreach($questiondetails as $question){
          if($question->question_id!=''){
      fwrite($fh, base_url('question-bank').'/'.url_title($question->name,'-',TRUE).'/'.$question->questionbank_id.'/'.$question->question_id."\n");
    }
}

//Create file urls
$filedetails =$this->Questionbank_model->getfiles_Questionbank();

foreach($filedetails as $files){
    if($files->file_id > 0){
    fwrite($fh, base_url('question-bank/show/'.  url_title($files->filename,'-',true).'/'.$files->file_id)."\n");
    }
    }
    
        fclose($fh);
    }
    
     public function notes_map(){
        $this->load->model('Posting_model');
        $return_val =  $this->Posting_model->getPosting_sitemap(21);
        $solutions_array=array();
        foreach($return_val as $result){
           
            if(!array_key_exists($result->category_id, $solutions_array)){
                $solutions_array[$result->category_id]=array('name'=>$result->exam,'subjects'=>array());
            }
            if(!array_key_exists($result->subject_id, $solutions_array[$result->category_id]['subjects']) && $result->subject_id > 0){
                $solutions_array[$result->category_id]['subjects'][$result->subject_id]=array('id'=>$result->subject_id,'name'=>$result->subject);
            }
        }
   
        $file = "notes_urls";
    $fh = fopen($file, 'w');
    
    //Create Class URLS
    fwrite($fh, base_url()."notes/\n");
    foreach($solutions_array as $key=>$value){
        fwrite($fh, base_url('notes/'.url_title($value['name'],'-',true).'/'.$key."\n"));
    }
    
        //Create Subject URLS    
foreach($solutions_array as $key=>$value){
    foreach($value['subjects'] as $k=>$v){
        
              fwrite($fh, base_url('notes/'.url_title($value['name'],'-',true).'/'.$key.'/'.url_title($v['name'],'-',true).'/'.$k)."\n");
  
     }
}

//Create Chapter URLS
//$chapter_array = $this->Notes_model->getChapter_Notes();

foreach($return_val as $qb){    
             fwrite($fh, generateContentLink('notes', $qb->exam, $qb->subject, $qb->chapter, $qb->title, $qb->id)."\n"); 
 }

        fclose($fh);
}
 

    public function articles_map(){
        $this->load->model('Posting_model');
        $return_val =  $this->Posting_model->getPosting_sitemap(12);
        $solutions_array=array();
        foreach($return_val as $result){
           
            if(!array_key_exists($result->category_id, $solutions_array)){
                $solutions_array[$result->category_id]=array('name'=>$result->exam,'subjects'=>array());
            }
            if(!array_key_exists($result->subject_id, $solutions_array[$result->category_id]['subjects']) && $result->subject_id > 0){
                $solutions_array[$result->category_id]['subjects'][$result->subject_id]=array('id'=>$result->subject_id,'name'=>$result->subject);
            }
        }
   
        $file = "articles_urls";
    $fh = fopen($file, 'w');
    
    //Create Class URLS
    fwrite($fh, base_url()."articles/\n");
    foreach($solutions_array as $key=>$value){
        fwrite($fh, base_url('articles/'.url_title($value['name'],'-',true).'/'.$key."\n"));
    }
    
        //Create Subject URLS    
foreach($solutions_array as $key=>$value){
    foreach($value['subjects'] as $k=>$v){
        
              fwrite($fh, base_url('articles/'.url_title($value['name'],'-',true).'/'.$key.'/'.url_title($v['name'],'-',true).'/'.$k)."\n");
  
     }
}

//Create Chapter URLS
//$chapter_array = $this->Notes_model->getChapter_Notes();

foreach($return_val as $qb){    
             fwrite($fh, generateContentLink('articles', $qb->exam, $qb->subject, $qb->chapter, $qb->title, $qb->id)."\n"); 
 }

        fclose($fh);
}

public function amazingfacts_map(){
   $this->load->model('Categories_model');
   
   $file = "amazingfacts_url";
    $fh = fopen($file, 'w');
    
    
    //Create Class URLS
    fwrite($fh, base_url()."amazing-facts/\n");
    
        $articlecategories=$this->Categories_model->getCategoryTree(13);
        
     foreach($articlecategories as $key=>$value){
         
                      fwrite($fh, base_url('amazing-facts/'.getDashedUrl($value['name']).'/'.$value['id'])."\n"); 
  } 
fclose($fh);
}

public function videos_map(){
    
    $this->load->model('Videos_model');
    $this->load->model('Pricelist_model');
    $file ="videos_url";
    $fh= fopen($file,'w');
    
    //Create Class URLS
    fwrite($fh, base_url()."videos/\n");
    $productslist = $this->Videos_model->getClass_Videos();
     foreach($productslist as $product){
         $type='videos';
         fwrite($fh, getProductLink($product,$type)."\n");
     }
     
     $chapterlist = $this->Videos_model->getChapter_Videos();
     foreach($chapterlist as $qb){
         
    fwrite($fh, generateContentLink('videos', $qb->exam, $qb->subject, $qb->chapter, $qb->name, $qb->id)."\n"); 
 
     }
     
     
     $videolist = $this->Videos_model->getsitemap_Videos();
     

     foreach($videolist as $qb){
         
        
         $previous_url = generateContentLink('videos', $qb->exam, $qb->subject, $qb->chapter, $qb->name, '');
         fwrite($fh, $previous_url.getDashedUrl($qb->video_name).'/'.$qb->video_id."\n"); 
         
     }
     
    fclose($fh);
}

}
?>