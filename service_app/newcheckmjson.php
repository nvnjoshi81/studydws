<?php
error_reporting(0);
include('config.php');
//777109
//739719
//777100
// Working fine-  199420
//issue 11896
$result = mysqli_query($conn,"SELECT * FROM cmsanswers where id = '11896'");
		if($row = mysqli_fetch_array($result)) 
		{
$str = $row['answer'];
$str = trim($str);
echo $str.'==<br>FILTERD DATA<br>==';
$str = iconv("utf-8", "ISO-8859-1//IGNORE",$str);
//$str = htmlentities($str, ENT_QUOTES, "UTF-8");
//$str = preg_replace("!\r?\n!", "", $str);
//$str = htmlspecialchars_decode($str);

echo $str.'==<br>JSON DATA<br>==';

$str=jsonClean($str); 
echo json_encode($str);
}

function jsonClean($str){
    $str=strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>,<span>');
    $str = str_replace("\r", ' ', $str); 
    $str = str_replace("\n", ' ', $str);  
    return $str;
}

//$str = "        130 ";
//echo json_encode($str);

/*$str = htmlentities($str, ENT_QUOTES, "UTF-8");
$str = preg_replace("!\r?\n!", "", $str);
$str = htmlspecialchars_decode($str);*/
?>