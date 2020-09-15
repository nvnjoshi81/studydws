<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ob_start(function($output){
    if( (strpos($output,"<video") > -1 || strpos($output,"<audio") > -1  || strpos($output,"<source") > -1 )  && (strpos($output,"<safe") == FALSE) ){
    $output = preg_replace_callback("/((<video[^>]|<audio[^>]|source[^>])src *= *[\"']?)([^\"']*)/i", function ($matches) 
    {
            $crc = substr(sha1($matches['3']), -8, -1);
            $_SESSION['defaprotect'.$crc] = $matches['3'];
            $randnum = rand();
            return $matches[1] . "/defavid.php?crc=".$crc;
      } , $output);
    }
    return $output;
});
