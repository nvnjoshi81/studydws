<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        //$font = '/usr/share/fonts/truetype/freefont/FreeSans.ttf';
        $image = imagecreatetruecolor(140, 120);
        imagealphablending($image, false);
        $col=imagecolorallocatealpha($image,255,255,255,127);
        imagefilledrectangle($image,0,0,140, 120,$col);
        imagealphablending($image,true);
        $white = imagecolorallocate($image, 0, 0, 0);
        /* add door glass */
        $img_doorGlass = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/assets/frontend/images/logo_new.png");
        imagecopyresampled($image, $img_doorGlass, 3, 5, 0, 0, 134, 74, 134, 74);
        imagealphablending($image,true);
        //imagettftext($image, 24, 0, 10, 60, $white, $font, $_SERVER['REMOTE_ADDR']);
        $text=$_SERVER['REMOTE_ADDR'];
        if($this->session->userdata('customer_name')){ imagestring($image, 5, 3, 85,$this->session->userdata('customer_name'), $white); }
        imagestring($image, 5, 3, 100,$text , $white);

        $fn = md5(microtime()."door_builder").".png";

        imagealphablending($image,false);
        imagesavealpha($image,true);
        header('Content-Type: image/png');
        imagepng($image);
        //if(imagepng($image, "$fn", 1)){
        //    echo "$fn";
        //}
        imagedestroy($image);
    }
}
