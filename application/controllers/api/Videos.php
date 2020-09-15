<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Videos extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
       
        $this->load->model('Videos_model');
    }

    function playlist_get($product_id) {
        $this->load->model('Products_model');
        $details=$this->Products_model->details($product_id);
        $playlists = $this->Videos_model->getVideos($details->exam_id,$details->subject_id,$details->chapter_id);
        $data_array=array();
        foreach($playlists as $playlist){
             $videolist = $this->Videos_model->getVideosList($playlist->id);
             $data_array[]=array("name"=>$playlist->name,
                 "id"=>$playlist->id,
                 "exam_id"=>$playlist->exam_id,
                 "subject_id"=>$playlist->subject_id,
                 "chapter_id"=>$playlist->chapter_id,
                 "exam"=>$playlist->exam,
                 "subject"=>$playlist->subject,
                 "chapter"=>$playlist->chapter,
                 "count"=>count($videolist));
            }
        $this->response([
            'status' => 1,
            'data' => array('product'=>$details,'playlists'=>$data_array)
                ], REST_Controller::HTTP_OK);
    }
    
    function list_get($playlistid) {
       
        $videolist = $this->Videos_model->getVideosList($playlistid);
        $array=array();
        foreach($videolist as $video){
            //if($video->video_source=='youtube' && $video->video_url_code!=''){
            $relation=$this->Videos_model->getRelations($video->id);            
            $array[]=array('video'=>$video,'relation'=>$relation);
            //}
        }
        $this->response(['status' => 1,'data' => $array], REST_Controller::HTTP_OK);
        
    }
    

    function detail_get($video_id) {
       
        $details= $this->Videos_model->getVideoDetails($video_id);
         $this->response(['status' => 1,'data' => $details], REST_Controller::HTTP_OK);
    }
    
}
