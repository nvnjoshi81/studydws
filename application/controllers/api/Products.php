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
class Products extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Products_model');
        $this->load->model('Videos_model');
    }

    function videos_get($exam_id = 0) {
        $products = $this->Products_model->getVideos($exam_id);
        $product_array=array();
        foreach ($products as $product) {
            $temp_array=array();
            $buylink = getProductLink($product,'videos');
            $videos=$this->Videos_model->getVideosCount($product->exam_id);
            if($product->subject_id >  0 && $product->chapter_id == 0){
                $videos=$this->Videos_model->getVideosCount($product->exam_id,$product->subject_id);
            }elseif($product->subject_id >  0 && $product->chapter_id > 0){
                $videos=$this->Videos_model->getVideosCount($product->exam_id,$product->subject_id,$product->chapter_id);
            }
            if(count($videos) > 0){
            $product_array[]=array('id'=>$product->id,
                                'title'=>$product->modules_item_name,
                                'link'=>$buylink,
                                'price'=>$product->price,
                                'discounted_price'=>$product->discounted_price,
                                'image'=>$product->image,
                                'videos'=>count($videos));
            }
        }
        // For Playlist dispaly
        
        $playlists = $this->Videos_model->getVideos();
        $data_array=array();
        foreach($playlists as $playlist){
             $videolist = $this->Videos_model->getVideosList($playlist->id);
             $data_video_array[]=array("name"=>$playlist->name,
                 "id"=>$playlist->id,
                 "exam_id"=>$playlist->exam_id,
                 "subject_id"=>$playlist->subject_id,
                 "chapter_id"=>$playlist->chapter_id,
                 "exam"=>$playlist->exam,
                 "subject"=>$playlist->subject,
                 "chapter"=>$playlist->chapter,
                 "display_image"=>$playlist->display_image,
                 "count"=>count($videolist));
            }                 
                
        $this->response([
            'status' => 1,
            'count' => count($product_array),
            'data' => $product_array,
            'data_video_array' => $data_video_array
            ], REST_Controller::HTTP_OK);
    }

    function freevideos_get($exam_id = 0) {
        $videos = $this->Videos_model->getfeaturedVideoDetails();
        $this->response([
            'status' => 1,
            'count' => count($videos),
            'data' => $videos
                ], REST_Controller::HTTP_OK);
    }
    
    function details_get($product_id){
        $videos = $this->Products_model->details($product_id);
        $this->response([
            'status' => 1,
            'data' => $videos
                ], REST_Controller::HTTP_OK);
    }
    
     
    
    

}
