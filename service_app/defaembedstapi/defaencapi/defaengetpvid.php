<?php
$word = "'";
$mystring = $_GET["defaviddb"];
// Test if string contains the word 
if(strpos($mystring, $word) !== false){
    
} else{
    include('includetop.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
  </head>
  <body style="background:#fff;">
    <?php $str = html_entity_decode(str_replace("%27","'",$_GET["defaviddb"]));?>
    <section>
   <div align="center">
    <object class="embed-responsive-item">
    <video controls  controlsList="nodownload" poster="https://www.studyadda.com/assets/frontend/images/logo_new.png" style="position: fixed;
  right: 0;
  bottom: 0;
  min-width: 100%;
  max-height: 100%;max-width: 100%;min-height:100%;">
       <source src="https://studyadda.com/upload_files/<?php echo $mystring;?>" />
     </video>
   </object>
   </div>
   </section>
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>