<!--<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>-->
<!--<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>-->
    <!--<script type="text/javascript" src="assets/MathJax/MathJax.js"></script>-->

<?php 	
$conn=mysqli_connect("localhost","studywhm_study","Study1dd1","studywhm_stdproduction");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
  
	 $result = mysqli_query($conn,"SELECT * FROM cmsquestionbank_details where questionbank_id = '1019'");	
		
		
		while($row = mysqli_fetch_array($result)) {
			  $mar_id = $row['question_id']; //echo "<br>";
			
			$result = mysqli_query($conn, "SELECT * FROM cmsquestions WHERE id = '$mar_id'");
			while($row = mysqli_fetch_array($result)) 
			{
			         $iid = $row['id'];
			 echo  $str = $row['question']; //echo "<br>";
			 
			 	$result = mysqli_query($conn,"SELECT * FROM cmsanswers WHERE question_id = '$iid'");
				 $coouds = mysqli_num_rows($result);
	        	while($row = mysqli_fetch_array($result)) 
	        	{
	        	   $chapid = $row['id'];
	        	  $resultm = mysqli_query($conn, "SELECT * FROM cmsanswers where id = '$chapid' ");
		while($rowm = mysqli_fetch_array($resultm)) 
		     {

           //$returnV  = 	$rowm['id']; echo "<br>";
                      $returnV  = 	$rowm['id'];
          // $ret  = 	$rowm['is_correct'];
          
            $ansp = $rowm['answer'];
        $ansp = utf8_encode($ansp);
        $ansp = strip_tags($ansp, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
        $ansp = htmlentities($ansp, ENT_QUOTES, "UTF-8");
        $ansp = preg_replace("!\r?\n!", "", $ansp);
        $ansp = str_replace("&nbsp;", "", $ansp);
        $ansp = str_replace("nbsp;", "", $ansp);
        $ansp = str_replace("&amp;", "", $ansp);
           
             echo  $ansp; 
             
              $ansext = $rowm['description'];
        $ansext = utf8_encode($ansext);
        $ansext = strip_tags($ansext, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
        $ansext = htmlentities($ansext, ENT_QUOTES, "UTF-8");
        $ansext = preg_replace("!\r?\n!", "", $ansext);
        $ansext = str_replace("&nbsp;", "", $ansext);
        $ansext = str_replace("nbsp;", "", $ansext);
        $ansext = str_replace("&amp;", "", $ansext);
        //echo $ansext;
       
       //echo  $ansext = $rowm['description']; //echo "<br>";
       
	
		    }
	        	  
	        	  
	        	}
			    
			}
			
			
		
	   }
		
		
  
 
 

?>

