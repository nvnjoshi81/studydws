<?php 
if(isset($question->id)){
$questionid=$question->id;
$question_section=$question->section;
$question_section_name=$question->section_name;
$question_type=$question->type;
$question_instructions_id=$question->instructions_id;
$question_question=$question->question; 
$question_description=$question->description;
$question_chapter_id=$question->chapter_id; 
$calculator=$question->calculator; 
}else{
$questionid=$this->uri->segment(4); 
$question_section='NA';
$question_section_name='NA';
$question_type='NA';
$question_instructions_id='NA';
$question_question='NA'; 
$question_description='NA';
$question_chapter_id=0;
$calculator=0;
}
$typeidd=$this->uri->segment(5); 
$modeidd=$this->uri->segment(6); 
if($typeidd<1||$typeidd==''){
	$typeidd=0;
}
if($modeidd<1||$modeidd==''){
	$modeidd=0;
}
if($calculator==0){
$selectnone='checked';
$selectscience='';
$selectnormal='';
}elseif($calculator==1){
$selectnormal='checked';
$selectscience='';	
$selectnone='';
}elseif($calculator==2){
$selectscience='checked';	
$selectnormal='';	
$selectnone='';
}
if(isset($language)&&$language=='hindi'){
$hindicss = "class='hindifont form-control'";
}else{
$hindicss='';
}
?>
<!-- middle content-start -->
<div id="page-wrapper">
   <div class="row">
      <div class="col-lg-6 text-left">
         <h1 class="page-header">Question ID : <?php echo $questionid;?>(<? echo $typename;?>)</h1>
         <?php 
         if($this->session->flashdata('message')){
             ?>
                 <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
         $back_url ='';
         if(isset($_SERVER['HTTP_REFERER'])){
             
            $back_url = $_SERVER['HTTP_REFERER']; 
         }else{
             
             $back_url = "admin/content/editcontent/".$questionid;
         }
         
         
        ?>
      </div>
	  
       <div class="col-lg-6 text-right">
           <h1 class="page-header"><?php if(isset($back_url)){ ?><a href="<?php echo $back_url; ?>"><< Back</a><?php  } ?></h1>
      </div>
      <!-- /.col-lg-12 -->
   </div>
   <!-- /.row -->
   <div class="row">
      <div class="panel panel-default">
          <form method="post" action="<?php echo base_url('admin/content/update');?>">
            <input type="hidden" name="question_id" value="<?php echo $questionid?>">
            <input type="hidden" name="back_url" value="<?php echo $back_url?>">
                 <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
               </div>
            <div class="form-group"><label>Section:</label>&nbsp;<input type="text" name="section" value="<?php echo $question_section?>">&nbsp;Ex.- A,B,C,D</div>            
            <div class="form-group"><label>Section Name:</label>&nbsp;<input type="text" name="section_name" value="<?php echo $question_section_name?>">&nbsp;Ex.- Physics,Chemistry,Maths</div>
            <div class="form-group"><label>Question Type:</label>&nbsp;<input type="text" name="type" value="<?php echo $question_type?>">&nbsp;Ex.- 
    Type 1 FOR Very Short,
    2  FOR Short,
    3  FOR Long,
    5  FOR Multiple Choice,
    6  FOR Single Choice,
    10 FOR Fill in the blanks,
    11 FOR Match the column,
	12 Exempler,
	13 Value Based,
	14 FOR Grid Single Choice,
	15 FOR Grid Multiple Choice
</div>
            <div class="form-group"><label>Instructions Id:</label>&nbsp;<input type="text" name="instructions_id" value="<?php echo $question_instructions_id?>">&nbsp;From Instruction table</div>
            <div class="form-group"><label>Calculator:</label>&nbsp;<input type="radio" name="calce" id="none" value="0" <?php echo $selectnone; ?>>None &nbsp;<input type="radio" name="calce" id="normal" value="1" <?php echo $selectnormal; ?>>Normal &nbsp;<input type="radio" name="calce" id="scintific" value="2" <?php echo $selectscience; ?>>Scientific 
			</div>

<?php

if($language=="hindi") {

 ?>
 <div class="form-group">
                <label>Question</label>
                <textarea rows="5" name="question" id="question" <?php echo $hindicss; ?>">
				<?php echo $question_question;?></textarea> 
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea rows="3"  name="description"   id="description" <?php echo $hindicss; ?>><?php echo $question_description;?></textarea>
            </div>
            <?php 
            $question_alphabet=array('A','B','C','D','E','F','G','H','I','J');
            $cc=0;
			if(isset($answers)){
				foreach($answers as $answer){ ?>
            <div class="form-group">
                <label>Answer(<?php echo $question_alphabet[$cc]; ?>)&nbsp;&nbsp;<a style="color:red" href="<?php echo base_url('admin/content/deloption/'.$answer->id.'/'.$questionid.'/'.$typeidd.'/'.$modeidd);?>">Delete This Option <?php echo $question_alphabet[$cc]; ?></a></label>
                <textarea rows="5"  name="answer_<?php echo $cc;?>"   id="answer_<?php echo $cc;?>" <?php echo $hindicss; ?>><?php echo $answer->answer;?></textarea>
            </div>
            <div class="form-group">
                <label>Description (<?php echo $question_alphabet[$cc]; ?>)</label>
                <textarea rows="5"  name="answer_description_<?php echo $cc;?>"   id="answer_description_<?php echo $cc;?>" <?php echo $hindicss; ?>><?php echo $answer->description;?></textarea>
            </div> 
            <?php $cc++; } }?>
    
  <?php
}else {

?>

            <div class="form-group">
                <label>Question</label>
                <textarea rows="5" name="question" id="question" class="form-control <?php echo $englishcss; ?>">
				<?php echo $question_question;?></textarea>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea rows="3"  name="description"   id="description" class="form-control"><?php echo $question_description;?></textarea>
            </div>
            <?php 
            $question_alphabet=array('A','B','C','D','E','F','G','H','I','J');
            $cc=0;
			if(isset($answers)){
				foreach($answers as $answer){ ?>
            <div class="form-group">
                <label>Answer(<?php echo $question_alphabet[$cc]; ?>)&nbsp;&nbsp;<a style="color:red" href="<?php echo base_url('admin/content/deloption/'.$answer->id.'/'.$questionid.'/'.$typeidd.'/'.$modeidd);?>">Delete This Option <?php echo $question_alphabet[$cc]; ?></a></label>
                <textarea rows="5"  name="answer_<?php echo $cc;?>"   id="answer_<?php echo $cc;?>" class="form-control ckeditor"><?php echo $answer->answer;?></textarea>
            </div>
            <div class="form-group">
                <label>Description (<?php echo $question_alphabet[$cc]; ?>)</label>
                <textarea rows="5"  name="answer_description_<?php echo $cc;?>"   id="answer_description_<?php echo $cc;?>" class="form-control ckeditor"><?php echo $answer->description;?></textarea>
            </div> 
            <?php $cc++; } }?>
            
          
			
<?php
}
?>
            <div class="form-group">
                <label>Chapter ID</label>
                <input type="text" name="chapter_id" value="<?php echo $question_chapter_id?>">
            </div> <input type="hidden" name="answer_count" value="<?php echo $cc; ?>">       
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
         
      </div>
      
</div>
  <?php
   if($language=='hindi') { 
   //some code
   }else{
?> 
<script type="text/javascript">
tinymce.init({
    selector: 'textarea',
    language: 'hi_IN',
    inline: false,
    height: 500,
    width:1000,
    plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools '
  ],
  toolbar3: 'fontselect',
  font_formats: 'KrutiDev030=k010, Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace; AkrutiKndPadmini=Akpdmi-n',
  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  filemanager_title:"Responsive Filemanager",
    external_filemanager_path:"/filemanager/",
    external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
  content_css: [
    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
    '//www.tinymce.com/css/codepen.min.css',
    '//www.studyadda.com/assets/css/admin_style.css'
  ],
  //theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
//font_size_style_values : "10px,12px,13px,14px,16px,18px,20px",
 // body, td, pre {color:#000; font-family:kruti-dev; font-size:14px; margin:8px;}
  automatic_uploads: true,
  relative_urls: false
  });
  </script>
   <?php  } ?>
<script>
    //CKEDITOR.replace( 'question');
   //CKEDITOR.replace( 'description');
</script>
<!-- /.panel .chat-panel -->
<!---middle-content---End-->