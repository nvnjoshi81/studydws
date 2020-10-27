<?php
function get_content_array_by_zip($html_foldername_path_with_ext,$extractfolder_path_html){
       $rest = substr($html_foldername_path_with_ext, -4);  
        $html_foldername_path_no_ext=NULL;
        $content_desc=Null;
        if($rest=='.zip'){
            $html_foldername_path_no_ext = substr($html_foldername_path_with_ext,0,-4);
        }else{
           $html_foldername_path_no_ext = $html_foldername_path_with_ext; 
        }
        
        $html_foldername_path = $_SERVER["DOCUMENT_ROOT"].$html_foldername_path_no_ext;
        
    	if ($file_handler = opendir($html_foldername_path))
		{
		while (false !== ($inner_file = readdir($file_handler)))
			{
			$inner_file_ext = substr($inner_file, -4);                        
                        $inner_file_no_ext = substr($inner_file, 0,-4);
			$i = 1;
			if ($inner_file_ext == '.htm')
				{
			$html_contents = file_get_contents($html_foldername_path.'/'.$inner_file) or die('Error in get contents.');                             
                        $final_html_contents = str_replace($inner_file_no_ext . '_files',base_url($extractfolder_path_html).'/' . $inner_file_no_ext . '/' . $inner_file_no_ext . '_files', $html_contents);
			$content_desc = trim(utf8_encode($final_html_contents));
				}
			}
		closedir($file_handler);
		return $content_desc;
		}
	}
	/*https://joshtronic.com/2013/09/23/sorting-associative-array-specific-key/*/
     function sortByName($a, $b)
{
    $a = $a['name'];
    $b = $b['name'];

    if ($a == $b) return 0;
    return ($a < $b) ? -1 : 1;
}

function sortByWeight($a, $b)
{
    $a = $a['obtain_marks'];
    $b = $b['obtain_marks'];

    if ($a == $b) return 0;
    return ($a < $b) ? -1 : 1;
}

function sortBy($field, &$array)
{
 
    usort($array, create_function('$a, $b', '
        $a = $a["' . $field . '"];
        $b = $b["' . $field . '"];

        if ($a == $b) return 0;


        return ($a ' . ('desc'== 'desc' ? '>' : '<') .' $b) ? -1 : 1;
    '));

    return true;
}
       function remove_tabSpace($text){
       $removed_tabspace = str_replace('&nbsp;','',$text);
       $text_clean = preg_replace('/\s+/S', " ", $removed_tabspace);
       //To remove special char and extra spece in start 
       $text_clean = iconv('UTF-8', "utf-8//IGNORE", $text_clean);
       //$text_clean = iconv("utf-8", "ISO-8859-1//IGNORE",$text_clean);
       return  $text_clean;
   }
   
   //To save table image and br tages
   function custom_strip_tags($custom_text){
      return  strip_tags($custom_text, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>,<span>'); 
       
   }
   function custom_strip_tags_two($custom_text){
      return  strip_tags($custom_text, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
       
   }
    function clear_html_text_two($custom_text){
      return  strip_tags($custom_text, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>,<p>,<span>'); 
   }
   
function clear_html_text($text){    
    $remove_title_text = preg_replace('#([<]e)(.title)(.*)([<]/title[>])#', ' ', $text);
    $text_clean =preg_replace("/<!--.*?-->/ms","",$remove_title_text);
    $un_quote_text = trim($text_clean);
    return  custom_strip_tags_two($un_quote_text);
}
function jsonClean($str){
    $str=strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>,<span>');
    $str = str_replace("\r", ' ', $str); 
    $str = str_replace("\n", ' ', $str);  
    return $str;
}
function custom_date($time){
    return date('Y-m-d H:i:s', $time);
}
function show_thumb($image_path,$height=100,$width=100,$extra=null) {
    if(!empty($image_path)){
 // Get the CodeIgniter super object
    $CI =& get_instance();
    $pathtoimage=$_SERVER['DOCUMENT_ROOT'].'/assets/videoimages/thumbs/';
    $source=$_SERVER['DOCUMENT_ROOT'].'/assets/videoimages/';
    // Path to image thumbnail
    $thumbImageName=$height . '_' . $width .'_'.$image_path;
    $image_thumb = $pathtoimage.$height . '_' . $width .'_'.$image_path;
    if($image_path!=null){
    if( ! file_exists($image_thumb))
    {
       // CONFIGURE IMAGE LIBRARY
        $config['image_library']    = 'gd2';
        $config['source_image']     = $source.$image_path;
        $config['new_image']        = $image_thumb;
        $config['maintain_ratio']   = TRUE;
        $config['height']           = $height;
        $config['width']            = $width;
        
        // LOAD LIBRARY
        $CI->load->library('image_lib',$config);
        try{
        $CI->image_lib->initialize($config);
        //$CI->image_lib->resize();
        if (!$CI->image_lib->resize()) {
			// echo $CI->image_lib->display_errors();
        }
        }catch(Exception $e){}
        $CI->image_lib->clear();

    }

    }
    if(file_exists($image_thumb)){
  
  //return '<img src="' .base_url().$image_thumb . '" '.$extra.'>';  
        return base_url().'assets/videoimages/thumbs/'.$thumbImageName;  
    }else{ 
        return base_url().'assets/videoimages/video-cover-image-not-exist.jpg';
        
    }
    }else{
        return base_url().'assets/videoimages/video-cover-image-not-exist.jpg';
    }
 
}
function show_product_thumb($image_path,$height=100,$width=100,$extra=null) {
    $imgbase='ebooks.png';
    if(!empty($image_path)){
 // Get the CodeIgniter super object
    $CI =& get_instance();
    $pathtoimage=$_SERVER['DOCUMENT_ROOT'].'/assets/frontend/product_images/';
    $source=$_SERVER['DOCUMENT_ROOT'].'/assets/frontend/product_images/';
    
    // Path to image thumbnail
    $thumbImageName=$height . '_' . $width .'_'.$image_path;
    $image_thumb = $pathtoimage.$height . '_' . $width .'_'.$image_path;
	if($image_path!=null){
    if( ! file_exists($image_thumb))
    {
        // LOAD LIBRARY
        $CI->load->library('image_lib');
       // CONFIGURE IMAGE LIBRARY
        $config['image_library']    = 'gd2';
        $config['source_image']     = $source.$image_path;
        $config['new_image']        = $image_thumb;
        $config['maintain_ratio']   = TRUE;
        $config['height']           = $height;
        $config['width']            = $width;
        try{
        $CI->image_lib->initialize($config);
        //$CI->image_lib->resize();
        if (!$CI->image_lib->resize()) {
			// echo $CI->image_lib->display_errors();
        }
        }catch(Exception $e){}
        $CI->image_lib->clear();

    }

    }
	if($extra!=null){
	$imgbase=$extra;
	}else{
	$imgbase='ebooks.png';
	}
    if(file_exists($image_thumb)){
        return base_url().'assets/frontend/product_images/'.$thumbImageName;  
    }else{ 
        return base_url().'assets/frontend/images/'.$imgbase;
        
    }
    }else{
        return base_url().'assets/frontend/images/'.$imgbase;
    }
}

function show_vid_thumb($image_path,$height=100,$width=100,$extra=null) {
    $imgbase='vbooks.png';
    if(!empty($imgbase)){
 // Get the CodeIgniter super object
    $CI =& get_instance();
    $pathtoimage=$_SERVER['DOCUMENT_ROOT'].'/assets/frontend/images/';
    $source=$_SERVER['DOCUMENT_ROOT'].'/assets/frontend/images/';
    
    // Path to image thumbnail
    $thumbImageName=$height . '_' . $width .'_'.$imgbase;
    $image_thumb = $pathtoimage.$height . '_' . $width .'_'.$imgbase;
	if($imgbase!=null){
    if( ! file_exists($image_thumb))
    {
        // LOAD LIBRARY
        $CI->load->library('image_lib');
       // CONFIGURE IMAGE LIBRARY
        $config['image_library']    = 'gd2';
        $config['source_image']     = $source.$imgbase;
        $config['new_image']        = $image_thumb;
        $config['maintain_ratio']   = TRUE;
        $config['height']           = $height;
        $config['width']            = $width;
        try{
        $CI->image_lib->initialize($config);
        //$CI->image_lib->resize();
        if (!$CI->image_lib->resize()) {
			// echo $CI->image_lib->display_errors();
        }
        }catch(Exception $e){}
        $CI->image_lib->clear();

    }

    }
	if($extra!=null){
	$imgbase=$extra;
	}else{
	$imgbase='vbooks.png';
	}
    if(file_exists($image_thumb)){
        return base_url().'assets/frontend/product_images/'.$thumbImageName;  
    }else{ 
        return base_url().'assets/frontend/images/'.$imgbase;
        
    }
    }else{
        return base_url().'assets/frontend/images/'.$imgbase;
    }
}
function show_flex_thumb($flaxImageName,$height=100,$width=100,$extra=null) { 
                 if(file_exists('upload/webreader/'.$flaxImageName.'/docs/'.$flaxImageName.'.pdf_1_thumb.jpg')&&($flaxImageName!='')){
                $imagePathFlax = base_url('upload/webreader/'.$flaxImageName.'/docs/'.$flaxImageName.'.pdf_1_thumb.jpg');
                }else{                    
                $imagePathFlax = base_url('assets/frontend/images/ebooks.png');  
                }
     return  $imagePathFlax;
}
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = str_replace('(', '', $string); // Replaces all spaces with hyphens.
   $string = str_replace(')', '', $string); // Replaces all spaces with hyphens.
   $string = str_replace('/', '', $string); // Replaces all spaces with hyphens.
   $string = str_replace(',', '', $string); // Replaces all spaces with hyphens.
   $string = str_replace('---', '-', $string); // Replaces all spaces with hyphens.
   $string = str_replace("'", '', $string); // Replaces all spaces with hyphens.
   $string = str_replace("&", 'and', $string); // Replaces all spaces with hyphens.

   //return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
   return strtolower($string);
}
function getDashedUrl($url)
{
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
    $url = trim($url, "-");
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
    return $url;
}
function reform($string) {
   $string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.

   //return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
   return strtolower($string);
}
function safe_b64encode($string) {
    $data = base64_encode($string);
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    return $data;
}

function safe_b64decode($string) {
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}

function encryptorg($value,$skey = "s7GR03Lstudyadda"){
    $CI =& get_instance();
    $CI->load->library('encrypt');
    if(!$value){return false;}
    return $CI->encrypt($value);
    /*$text = $value;
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
    return trim(safe_b64encode($crypttext));*/
}
function encrypt($value,$skey = "s7GR03Lstudyadda"){
    $CI =& get_instance();
    $CI->load->library('encrypt');
    if(!$value){return false;}
     $url_safe=true;
    $enc_value=$CI->encrypt->encode($value);
     if ($url_safe)
        {
            $enc_value = strtr(
                    $enc_value,
                    array(
                        '+' => '.',
                        '=' => '-',
                        '/' => '~'
                    )
                );
        }
    return $enc_value;
    /*$text = $value;
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
    return trim(safe_b64encode($crypttext));*/
}
function decrypt($value,$skey = "s7GR03Lstudyadda"){
    if(!$value){return false;}
    $CI =& get_instance();
    $CI->load->library('encrypt');
      $url_dec_value = strtr(
                $value,
                array(
                    '.' => '+',
                    '-' => '=',
                    '~' => '/'
                )
            );

    return $CI->encrypt->decode($url_dec_value);
    /*$crypttext = safe_b64decode($value);
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
    $pos=strpos($decrypttext,'.');
    //return substr($decrypttext,0,$pos);
    return trim($decrypttext);*/
}

function nested2ul($data) {
    $result = array();
    if (sizeof($data) > 0) {
        
        $result[] = '<ul>';
            foreach ($data as $entry) {
                $result[] = sprintf('<li>%s %s</li>','<a href="'.base_url().'category/'.clean($entry['name']).'/'.$entry['id'].'">'.ucwords(strtolower($entry['name'])).'</a>', nested2ul($entry['sub_categories']));
            }
            $result[] = '</ul>';
    }
    
  return implode($result);
}

function nested2ulnew($data,$level=0) {
   // $result = array();
   if($level <=1){
    foreach ($data as $entry) {
		if($entry['parent']==0){
			echo '<li class="main_menu_category">';
			echo '<a href="'.base_url().'category/'.clean($entry['name']).'/'.$entry['id'].'"><span class="inner">'.ucwords(strtolower($entry['name'])).'</span></a>';
			
		}else{
			echo '<li><a href="'.base_url().'category/'.clean($entry['name']).'/'.$entry['id'].'">
				<span class="cat-name">'. ucwords(strtolower($entry['name'])).'</span>
				</a> ';
			
		}
        echo '</li>';
		if(count($entry['sub_categories']) > 0){
			
			nested2ulnew($entry['sub_categories'],$level+1);
			
		}
			
	}
   }
    
}
function reformName($str){
    $str= ucwords(strtolower($str));
    return $str;
}

function categoryTree($data,$level=0) {
   // $result = array();
  
    foreach ($data as $entry) {
		
		if(count($entry['sub_categories']) > 0){
			echo '<li>
                <ul class="xtraMenu">
                    <li>
                        <h4 class="head"><a href="javascript:;">'.$entry['name'].'</a></h4>
                        <ul>';
			
			categoryTree($entry['sub_categories'],$level+1);
            echo '</ul></li></ul>';
			
		}else{
            echo '<li><a href="'.base_url().'category/'.clean($entry['name']).'/'.$entry['id'].'">'.$entry['name'].'</a>';
        }
			echo '</li>';
	}

    
}
function menuCategoryTree($data,$level=0) {
   // $result = array();
  
    foreach ($data as $entry) {
		if(count($entry['sub_categories']) > 0){
            echo '<li class="parent"><a href="'.base_url().'category/'.clean($entry['name']).'/'.$entry['id'].'" class="glyphicon-plus"> '.$entry['name'].'</a>';
        }else{
            echo ' <li><a href="'.base_url().'category/'.clean($entry['name']).'/'.$entry['id'].'">'.$entry['name'].'</a>';
        }
		if(count($entry['sub_categories']) > 0){
			
			echo '<ul style="display: none;">';
			menuCategoryTree($entry['sub_categories'],$level+1);
            echo '</ul>';
			
		}
			echo '</li>';
	}

    
}
function menuCategoryTreeAll($data,$level=0) {
   // $result = array();
	$class='lvl1';
    foreach ($data as $entry) {
		if($level==1){
			$class='lvl2';
		}
		if(count($entry['sub_categories']) > 0){
            echo '<li class="'.$class.'"><a href="'.base_url().'category/'.clean($entry['name']).'/'.$entry['id'].'"> '.$entry['name'].'</a>';
        }else{
            echo ' <li class="'.$class.'"><a href="'.base_url().'category/'.clean($entry['name']).'/'.$entry['id'].'">'.$entry['name'].'</a>';
        }
		if(count($entry['sub_categories']) > 0){
			
			//echo '<ul>';
			menuCategoryTreeAll($entry['sub_categories'],$level+1);
            //echo '</ul>';
			
		}
			echo '</li>';
	}

    
}
function objectToArray ($object) {
    if(!is_object($object) && !is_array($object))
        return $object;

    return array_map('objectToArray', (array) $object);
}
function formatDate($timestamp){
	return date('d-m-Y h:i A',$timestamp);
	
}
function sendEmail($to,$subject,$message,$from='info@studyadda.com',$filename=NULL){
		//$message = 'Hello sir/madam , You are registered successfully with patanjaliayurved.net';
        $CI =& get_instance();
		$CI->load->library('email');
		$CI->email->set_mailtype('html');
		$CI->email->set_newline("\r\n");
		$CI->email->from($from,'StudyAdda Team'); // change it to yours
		$CI->email->to($to);// change it to yours
		$CI->email->subject($subject);
		$CI->email->message($message);
                if($filename){
                $CI->email->attach($this->input->server('DOCUMENT_ROOT').'/upload/contact_file/'.$filename);  
                }
		if($CI->email->send())
		{
		//echo 'Email sent.';
		}
		else
		{
		// show_error($this->email->print_debugger());
		}
}
function generatePassword(){
	$seed = str_split('abcdefghijklmnopqrstuvwxyz'
                     .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                     .'0123456789'); // and any other characters
			shuffle($seed); // probably optional since array_is randomized; this may be redundant
			$rand = '';
			foreach (array_rand($seed, 6) as $k) $rand .= $seed[$k];
		 
			return $rand;
}

function generateSelectBox($name,$data,$value,$text,$showdefault=1,$extra=null,$selection_id=0){
    $str='<select name="'.$name.'" id="'.$name.'" '.$extra.'>';
    if($showdefault==1){
        $str.='<option value="0">Select..</option>';
    }
    if($data){
        foreach($data as $item){
            if($item->$value==$selection_id){
                
            $str.='<option value="'.$item->$value.'" selected>'.$item->$text.'</option>';
            }else{
            $str.='<option value="'.$item->$value.'">'.$item->$text.'</option>';
            }
        }
    }
    $str.='</select>';
    return $str;
}



function generateSelectBox_custom($name,$data,$value,$text,$showdefault=1,$extra=null,$selection_id=''){
    $str='<select name="'.$name.'[]" multiple="multiple" id="'.$name.'" '.$extra.'>';
    if($showdefault==1){
       //$str.='<option value="0">Select..</option>';
    }
    if($data){
        foreach($data as $item){
            if($item->$value==$selection_id){
                
            $str.='<option value="'.$item->$value.'" selected>'.$item->$text.'</option>';
            }else{
            $str.='<option value="'.$item->$value.'">'.$item->$text.'</option>';
            }
            
        }
    }
    $str.='</select>';
    return $str;
}

  function unzipToFolder($filedata,$zipSaveToPath,$unzipSaveToPath,$extractfolder_path_var){
      
                    $zip = new ZipArchive;
                    $file_name=$filedata['upload_data']['file_name'];
                    $orig_name=$filedata['upload_data']['orig_name'];
                    $file_name_rest = substr($orig_name, 0,-4); 
                    //Remove folder if exist with same name
                    if ($zip->open($zipSaveToPath.$file_name) === TRUE) {
                    $zip->extractTo($unzipSaveToPath);
                    //echo $unzipSaveToPath.$file_name_rest.'---'; die;
                    chmod($unzipSaveToPath.$file_name_rest, 0777);
                    $zip->close();
                    unlink($zipSaveToPath.$orig_name);
                    return  $file_name_rest;
                    } else {
                    return 'failed';
                    }    
                    }
                    
                    //Function to upload zip and extract flex 
                    
                    
                function upload_extract_file($zipfolder_path_var,$extractfolder_path_var='',$zip_field_name_var,$extract_var){  
                    
                     // Get the CodeIgniter super object
                        $CI =& get_instance();
                        $uploadpath=$_SERVER['DOCUMENT_ROOT'].$zipfolder_path_var; 
                        $config['upload_path']=$uploadpath;
                        $config['allowed_types'] = 'zip|pdf|mp4|jpg|png|jpeg|gif|doc';
                        $config['max_size'] = 0;
                        $extract_path = $_SERVER['DOCUMENT_ROOT'].$extractfolder_path_var;
                        $CI->load->library('upload', $config);
                        $file_name=null;
			$filedata=NULL;
	                if($CI->upload->do_upload($zip_field_name_var)!=null){
                            $filedata = array('upload_data' => $CI->upload->data());
			    $file_name=$filedata['upload_data']['file_name'];
                        }else{
                            
                           $CI->session->set_flashdata('message', $CI->upload->display_errors()); 
                           // echo $zipfolder_path_var,'<-->',$extractfolder_path_var,'<-->',$zip_field_name_var,'<-->',$extract_var;
                            //print_r($_FILES);
                            //print_r($CI->upload->display_errors());
                            //die();
			}
                        unset($config);
			$zipFileName=$file_name;
                        $zipSaveToPath=$uploadpath;
                        $unzipSaveToPath=$extract_path;	
                        if($extract_var=='yes'){
                       return unzipToFolder($filedata,$zipSaveToPath,$unzipSaveToPath,$extractfolder_path_var); 
                           }else{
                       if($file_name!=''){
                       return  $file_name;
                       } else {
                       return 'failed';
                       }    
                               
                           }		
                    }              
                    
                     //Function to upload zip and extract flex 
                    
                    
                function video_image_upload($zipfolder_path_var,$zip_field_name_var,$video_sql_id){  
                    
                     // Get the CodeIgniter super object
                        $CI =& get_instance();
                        $uploadpath=$_SERVER['DOCUMENT_ROOT'].$zipfolder_path_var; 
                        $config['upload_path']=$uploadpath;
                        $config['allowed_types'] = 'jpg|jpeg|png';
                        $config['max_size'] = 0;
                        $new_name = 'image_'.$video_sql_id.'.jpg';
                        $config['file_name'] = $new_name;
                        $CI->load->library('upload', $config);
                        $file_name=null;
			$filedata=NULL;
	                if($CI->upload->do_upload($zip_field_name_var)!=null){
                            $filedata = array('upload_data' => $CI->upload->data());
			    $file_name=$filedata['upload_data']['file_name'];
                        }else{
                            
                           // echo $zipfolder_path_var,'<-->',$extractfolder_path_var,'<-->',$zip_field_name_var,'<-->',$extract_var;
                            //print_r($_FILES);
                            //print_r($CI->upload->display_errors());
                           // die();
			}
                        unset($config);
			  if($file_name!=''){
                       return  $file_name;
                       } else {
                       return 'failed';
                       }   	
                    }
                    
                    function media_image_upload($zipfolder_path_var,$zip_field_name_var){  
                    
                     // Get the CodeIgniter super object
                        $CI =& get_instance();
                        $uploadpath=$_SERVER['DOCUMENT_ROOT'].$zipfolder_path_var;                         
                        $config['upload_path']=$uploadpath;
                        $config['allowed_types'] = 'jpg|jpeg';
                        $config['max_size'] = 0;
                        $new_name = 'image_'.time().'.jpg';
                        $config['file_name'] = $new_name;
                        $CI->load->library('upload', $config);
                        $file_name=NULL;
			$filedata=NULL;
                        
	                if($CI->upload->do_upload($zip_field_name_var)!=null){
                            $filedata = array('upload_data' => $CI->upload->data());
			    $file_name=$filedata['upload_data']['file_name'];
                        }else{
                            
                           // echo $zipfolder_path_var,'<-->',$extractfolder_path_var,'<-->',$zip_field_name_var,'<-->',$extract_var;
                            //print_r($_FILES);
                            //print_r($CI->upload->display_errors());
                           // die();
			}
                        unset($config);
			  if($file_name!=''){
                       return  $file_name;
                       } else {
                       return 'failed';
                       }   	
                    } 
                
                    function get_assets($path){
                    return base_url().$path;
                    }
function getSignedURL($resource, $timeout)
{
	//This comes from key pair you generated for cloudfront
	$keyPairId = "APKAJO3KUWTWE323VIRQ";

	$expires = time() + $timeout; //Time out in seconds
	$json = '{"Statement":[{"Resource":"'.$resource.'","Condition":{"DateLessThan":{"AWS:EpochTime":'.$expires.'}}}]}';		
	
	//Read Cloudfront Private Key Pair
	$fp=fopen(APPPATH."pk-APKAJO3KUWTWE323VIRQ.pem","r"); 
	$priv_key=fread($fp,8192); 
	fclose($fp); 

	//Create the private key
	$key = openssl_get_privatekey($priv_key);
	if(!$key)
	{
		echo "<p>Failed to load private key!</p>";
		return;
	}
	
	//Sign the policy with the private key
	if(!openssl_sign($json, $signed_policy, $key, OPENSSL_ALGO_SHA1))
	{
		echo '<p>Failed to sign policy: '.openssl_error_string().'</p>';
		return;
	}
	
	//Create url safe signed policy
	$base64_signed_policy = base64_encode($signed_policy);
	$signature = str_replace(array('+','=','/'), array('-','_','~'), $base64_signed_policy);

	//Construct the URL
	$url = $resource.'?Expires='.$expires.'&Signature='.$signature.'&Key-Pair-Id='.$keyPairId;
	
	return $url;
}

function getResourceKey($amazonaws_link){
    $amazonaws_explode_result_by_domain = explode('/',$amazonaws_link);
    $amazonaws_link_explode_by_slesh= array_slice($amazonaws_explode_result_by_domain,4);
    $amazonaws_link_implode_by_slesh = implode("/", $amazonaws_link_explode_by_slesh);
    $amazonaws_video_name_refine_result = str_replace('+',' ',$amazonaws_link_implode_by_slesh);
    $resourceKey = $amazonaws_video_name_refine_result;
    return $resourceKey;
}

// to remove zip ext		

function rm_zip_ext($orig_name)
	{
	$getzipext = substr($orig_name, -4);
	if ($getzipext == '.zip')
		{
		$main_orig_name = substr($orig_name, 0, -4);
		}
	  else
		{
		$main_orig_name = $orig_name;
		}

	return $main_orig_name;
	}

function generateContentLink($module,$exam,$subject,$chapter,$name,$id){
    $link[]=$module;
    $link[]=url_title($exam,'-',TRUE);
    $subject ? $link[]=url_title($subject,'-',TRUE):'';
    $chapter ? $link[]=url_title($chapter,'-',TRUE):'';
    $link[]=url_title($name,'-',TRUE);
    $link[]=$id;
    return base_url().implode('/', $link);
}

function generateContentLink_custom($module,$exam,$subject,$chapter,$name,$exam_id,$subject_id=0,$chapter_id=0,$id){
    $link[]=$module;
    $link[]=url_title($exam,'-',TRUE);
    $subject ? $link[]=url_title($subject,'-',TRUE):$link[]=url_title('All','-',TRUE);
    $chapter ? $link[]=url_title($chapter,'-',TRUE):$link[]=url_title('All','-',TRUE);
    $link[]=url_title($name,'-',TRUE);
    $link[]=$id;
    return base_url().implode('/', $link);
}


function generate_stmt_ContentLink($module,$exam,$subject,$chapter,$name,$id){
    
    $link[]=$module;
    $link[]=url_title($exam,'-',TRUE);
    $subject ? $link[]=url_title($subject,'-',TRUE):$link[]=url_title('All','-',TRUE);
    $chapter ? $link[]=url_title($chapter,'-',TRUE):$link[]=url_title('All','-',TRUE);
    $link[]=url_title($name,'-',TRUE);
    $link[]=url_title($name,'-',TRUE);
    $link[]=$id;
    return base_url().implode('/', $link);
}
function getTitle($str,$categories){
    $exams=array();
        foreach($categories as $k=>$mexams){
            if($str == 'NCERT Solutions'){ 
                if($mexams->id !=28 && $mexams->id !=29){
                $exams[]=  addSuffix($mexams->name,'Class');
                }
            }else{
                $exams[]=  addSuffix($mexams->name,'Class');
            }
        }
        return $str.' for '.implode(', ', $exams);
}

function generateTitle($text,$relation,$modulename=null){
    $title_free_toshow='';    
    if($text=='Ncert Solutions for'){
         $title_free_toshow ='Free';   
        }
        
    $titleStr[]=$title_free_toshow.' '.$text;
    if(isset($relation->exam_id)&&$relation->exam_id > 0){
        $titleStr[]=addSuffix($relation->exam,'Class');
    }
    if(isset($relation->subject_id)&&$relation->subject_id > 0){
        $titleStr[]=$relation->subject;
    }
    if(isset($relation->chapter_id)&&$relation->chapter_id > 0){
        $titleStr[]=$relation->chapter;
    }
    if($modulename){
        $titleStr[]=$modulename;
    }
    
    return implode(' ',$titleStr);
    
}
function addSuffix($text,$suffix){
    return $text;
    if(is_numeric(substr($text, 0, 1))){
        return $text.' '.$suffix;
    }else{
        return $text;
    }
}
function generateOTP(){
    $seed = str_split('0123456789'); // and any other characters
    shuffle($seed); // probably optional since array_is randomized; this may be redundant
    $rand = '';
    foreach (array_rand($seed, 6) as $k) $rand .= $seed[$k];
	return $rand;
}

  function getYesNo_array(){
             
        $status_array = array ( 
                '0' => (object) array ( 'id' => '0', 'value' => 'No' ) ,
                '1' => (object) array( 'id' => '1', 'value' => 'Yes' )           
            );
         return $status_array;
         } 
         
         function get_orgprice($price,$discounted_price){
                    if($discounted_price>0){
                        $orignal_price = $discounted_price;
                    }else{
                       $orignal_price = $price; 
                    }
                    return $orignal_price;
                }
function search_array($needle, $haystack) {
     if(in_array($needle, $haystack)) {
          return true;
     }
     foreach($haystack as $element) {
          if(is_array($element) && search_array($needle, $element))
               return true;
     }
   return false;
}         
function getProductImage($image){
    $path=dirname($_SERVER['SCRIPT_FILENAME']).'/assets/frontend/product_images/';
    if(file_exists($path.$image) && $image !=''){
        return '<img src="'.base_url('assets/frontend/product_images/'.$image).'" alt="bootsnipp"
                            class="img-rounded img-responsive" />';
    }else{
        return '<img src="'.base_url('assets/frontend/images/ebooks.png').'" alt="bootsnipp"
                            class="img-rounded img-responsive" />';
    }
}

function getProductLink($product,$type='videos',$classid=0){
    $CI =& get_instance();
    if(isset($product->exam)){
    $exam=$product->exam;
    }
    if(isset($product->subject)){
    $subject=$product->subject;
    }
    if(isset($product->chapter)){
    $chapter=$product->chapter;
    }
    if(isset($product->exam_id)){
    $exam_id=$product->exam_id;
    }
    if(isset($product->subject_id)){
    $subject_id=$product->subject_id;
    }
    if(isset($product->chapter_id)){
    $chapter_id=$product->chapter_id;
    }
    /*$exam_id=$product->exam_id;
    $subject_id=$product->subject_id;
    $chapter_id=$product->chapter_id;*/
	$urlMod='videos';
	if($product->type==1){
		$urlMod='study-packages';
	}elseif($product->type==2){
		$urlMod='videos';
	}elseif($product->type==3){
		$urlMod='online-test';
	}
	
    $link=array($urlMod);

    if($product->item_id > 0){        
        if($product->type==2){
            if($exam_id >0){
                $link[]=url_title($exam,'-',TRUE);
            }
            if($subject_id >0){
                $link[]=url_title($subject,'-',TRUE);
            }else{
                $link[]='all';
            }
            if($chapter_id >0){
                $link[]=url_title($chapter,'-',TRUE);
            }else{
                $link[]='all';
            }
            $CI->load->model('Videos_model');
            $detail=$CI->Videos_model->getVideoDetails($product->item_id);
            $link[]=url_title($detail->title,'-',TRUE);
            $link[]=$detail->id;
        }
		
        if($product->type==1){
            $CI->load->model('File_model');
            $detail=$CI->File_model->getStudyPackageDetails($product->item_id,$product->productlist_id,$classid);
            if(!$detail){
               // print_r($product);
            }
            if($detail->exam){
                $link[]=url_title($detail->exam,'-',TRUE);
            }
            if($detail->subject){
                $link[]=url_title($detail->subject,'-',TRUE);
            }else{
                $link[]='all';
            }
            if($detail->chapter){
                $link[]=url_title($detail->chapter,'-',TRUE);
            }else{
                $link[]='all';
            }
            $link[]=url_title($detail->name,'-',TRUE);
            $link[]=url_title($detail->displayname?$detail->displayname:$detail->filename,'-',TRUE);
            $link[]=$detail->id;
        }
    }elseif($product->modules_item_id > 0){
        if($exam_id >0){
            $link[]=url_title($exam,'-',TRUE);
        }
        if($subject_id >0){
            $link[]=url_title($subject,'-',TRUE);
        }
        if($chapter_id >0){
            $link[]=url_title($chapter,'-',TRUE);
        }
        $link[]=url_title($product->modules_item_name,'-',TRUE);
        $link[]=$product->modules_item_id;
        
    }else{
        if($exam_id >0){
            $link[]=url_title($exam,'-',TRUE);
            $link[]=$exam_id;
        }
        if($subject_id >0){
            $link[]=url_title($subject,'-',TRUE);
            $link[]=$subject_id;
        }
        if($chapter_id >0){
            $link[]=url_title($chapter,'-',TRUE);
            $link[]=$chapter_id;
        }
    }
    
    return base_url(implode('/',$link));    
}

function in_array_r($needle, $haystack, $strict = false) {
   if(isset($haystack)){ 
       foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
   }

    return false;
}
                
function secondsToTime($seconds)
{
    // extract hours
    $hours = floor($seconds / (60 * 60));
 
    // extract minutes
    $divisor_for_minutes = $seconds % (60 * 60);
    $minutes = floor($divisor_for_minutes / 60);
 
    // extract the remaining seconds
    $divisor_for_seconds = $divisor_for_minutes % 60;
    $seconds = ceil($divisor_for_seconds);
 
    // return the final array
    $obj = array(
        "h" => (int) $hours,
        "m" => (int) $minutes,
        "s" => (int) $seconds,
    );
    return $obj;
}
function logdata($login,$mode=null) {
    $data = $login->id . ' | ' . $login->firstname . ' | ' . $login->lastname . ' | ' . $login->email . ' | ' . $login->mobile . ' | ' . date('h:i A') .' | '.$mode."\n";

    $todate = date('d-m-Y');

    file_put_contents(FCPATH . 'assets/login/log_' . $todate . '.txt', $data, FILE_APPEND | LOCK_EX);
}

function moneyFormatIndia($num){
    $explrestunits = "" ;
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}

//To get Browser

function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
	// check if we have a number
    
	if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
} 

function get_assets_cdn($filepath,$cdn='https://www.dewastimes.com/'){
$break_host_array=substr($_SERVER['HTTP_HOST'],-3);
if($break_host_array=='cal'){
	$cdn=base_url();
}
	if(base_url()==''){
	  $cdn=base_url();
	}
	  if(isset($cdn)&&$cdn!=''){
		$cdn_path=$cdn;
	  }else{
		$cdn_path=base_url();  
	  } 
	  return $cdn_path.$filepath;
	  
  }
