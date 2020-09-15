<style type="text/css">
  .input-group img{
    width:40% !important;
    height: auto;
  }
</style>
<script>
    
   $(document).ready(function() {
    
    $(".new-acc").click(function(){
    $(".new-acc-form").slideToggle();
    });

    $(".btn-success.new-acc").click(function(){
         $(".new-cat-form").slideToggle();
       });
 });
 
     $(function() {
    $("[name=adtype]").change(function(){
            $('.toHide').hide();
            $("#blk-"+$(this).val()).show('slow');
    });
 });

    </script>

<?php
if(!empty($listing)){ ?>
<script>
$(document).ready(function() {
    $(".new-acc-form").slideToggle();
});
</script>
 <?php   } ?>

<div id="page-wrapper" class="row">
            <div class="row">
			
<div><a onclick="relationMod('show');" href="#">Show</a> / <a onclick="relationMod('hide');" href="#">Hide</a> Module Relation</div>
<div id="rele-section" class="col-lg-12 col-sm-12 col-md-12 clr-bth"  style='display:block'> 
            <!--Show relation table entry -->
            <div>
                <div class="form-group" id="rel_box">
<?php
  $module_relation_count = NULL;
        if (isset($module_relation_details)) {
            $module_relation_count = count($module_relation_details);
        }
if (isset($module_relation_count) && ($module_relation_count != NULL)) {
    ?>
<label>Module Relation List</label>
<div  id="rel_tab">
                        <table class="table">
                            <thead>
                                <tr>  
                                    <th>#</th>
                                    <th>Module Id</th>
                                    <th>Exam Id</th>  
                                    <th>Subject Id</th>
                                    <th>Chapter Id</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php
    $rid = 1;
    $rn_id = 0;
    foreach ($module_relation_details as $relation_details) {
        ?>
                                    <tr class="success">
                                        <td><?php echo $rid; ?></td>
                                        <td><?php if(isset($listing->title)) { echo $listing->title; } ?></td>
                                        <td><?php echo $relation_exam[$rn_id]; ?></td>
                                        <td><?php echo $relation_subject[$rn_id]; ?></td>
                                        <td><?php echo $relation_chapter[$rn_id]; ?></td>
                                        <td><a href="/admin/Contents/remove_relation_byid/<?php echo $relation_details->id; ?>/<?php echo $maincontent_id; ?>/5" ><i class="fa fa-trash cat-del"></i></a></td>
                                    </tr>

        <?php
        $rn_id++;
        $rid++;
    }
    ?>
                            </tbody>
                        </table> 
</div>
                            <?php } ?>
               
           
            <!--Show relation Form entry -->
            <div id="Others1">
                <form  enctype="multipart/form-data" id="add_category_form" method="post" action="<?php echo base_url(); ?>admin/contents/add_relation" onsubmit="return add_relation_validation();" >
                    <div class="form-group">

                        <label>Add Relation</label>


                        <div class="col-sm-12">

<?php
$price_table_id = 0;
if (isset($pricelist_details->id)) {
    $price_table_id = $pricelist_details->id;
}
?>
                            <input type="hidden" name="module_id"  value="<?php echo $maincontent_id; ?>" >
                            <input type="hidden" name="module_type_id"  value="5" >
                            <input type="hidden" name="price_table_id"  value="0" >
                            <input type="hidden" name="relation_content_type"  id="relation_content_type"  value="5" >
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select Exam</label>
<?php
$content_type_exam_id = 0;
if (isset($maincontent->exam_id)) {
    $content_type_exam_id = $maincontent->exam_id;
}

echo generateSelectBox('relation_exam', $exams_article_arr, 'id', 'name', 1, 'class="form-control" onchange="getContent_relation();"', $content_type_exam_id);
?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select Subject</label>
<?php
$content_type_subject = 0;
if (isset($maincontent->subject_id)) {
    $content_type_subject = $maincontent->subject_id;
}
echo generateSelectBox('relation_subject', $subjects_article_arr, 'id', 'name', 1, 'class="form-control" onchange="getContent_relation();"', $content_type_subject);
?>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Select Chapters</label>
                                    <div id="eschapters"></div>
                                </div>
                            </div>
                        </div> 

<?php $relation_submit_button_text = 'Add Relation'; ?>
                        <button type="submit" class="btn btn-primary"><?php echo $relation_submit_button_text; ?></button>

                    </div>
                </form>
            </div>
 </div>
        </div> 

<div>&nbsp;
<div class="alert alert-danger" role="alert">
<a onclick="relationMod('hide');" href="#">Hide Module Relation</a></div>	
</div>

    </div>
			
		
                <div class="col-lg-12">
                    <h1 class="page-header">Listings </h1>
                    <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
         ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
      <div class="col-sm-12">


      <form class="filter-form" id="filter" method="get"  <?php if(isset($listing->id)) { ?> action="" <?php } else{ ?> action="<?php echo isset($action)?$action:'';?>" <?php } ?> >
         <div class="row">
         <div class="col-xs-5">
            <div class="input-group">
                <select id="filter_cat" name="filter_cat" class="form-control">
                <option value=0>All</option>
                <?php foreach($allcategories as $cl) { ?>
                <option value="<?php echo $cl["id"] ?>"><?php echo $cl["name"]; ?></option>
                <?php } ?>
              </select>
               
                <span class="input-group-btn">
                    <button type="button"  class="btn btn-default" onClick="return mysubmit(this);">Filter</button>
                </span>
            </div>
            
        </div>
        </div>
      </form>


        <script>
      function mysubmit(frm){
        frmaction=document.getElementById('filter').action;
     
     var url=frmaction+'/'+document.getElementById('filter_cat').value;
     //frm.action(url);
     //alert(url);
        window.location.href=url;
      
     }
    </script>

            <a href="<?php echo base_url();?>admin/listings/unpublished"   class="btn btn-primary pull-right new-aacc">Pending Listing</a>

            <?php if(isset($listing->id)) {if($listing->id !=NULL){ ?>
            
            <a href="#" class="btn btn-success pull-right new-acc">Edit Listing</a>
            <?php  } } else { ?>
            <a href="#" class="btn btn-success pull-right new-acc">New Listing</a>
            <?php  }  ?>
     </div>
     </div>
                
<div class="row">
<!--form Add New listing -->
<div>
<div class="col-lg-8 col-sm-8 col-md-8 clr-bth"> 
<form class="new-acc-form new-list-form" <?php if(isset($listing->id)) { ?> id="edit_list-form" <?php } else{ ?>id="add_list-form" <?php } ?> method="post"  enctype="multipart/form-data"  action="<?php echo base_url();?>admin/listings/add_listing" >
                <?php
                if((isset($listing->top_category_id))&&($listing->top_category_id=='83')){
                
                $returnpath=base_url().'admin/listings/current_affairs';
                    
                }else{
                $returnpath=current_url();
                }
               ?>
            <input type="hidden" name="redir" value="<?php echo $returnpath; ?>"> 
            <?php if(isset($listing->id)&&($listing->id!=NULL)) {  ?>
                   
            <h2><font size="5">Edit Listing by Zip</font>(Title and Content only)</h2>
            <?php 
            
            }  else { ?>
            <h2>New Listing</h2>
            
    <div class="form-group" >
        <label>Type</label>
        <span class="new-list-spn"><input type="radio" name="adtype" selected value="0" checked="checked" > <span>Text</span></span>
        <span class="new-list-spn"><input type="radio" name="adtype" value="1"> <span>Audio</span></span>
        <span class="new-list-spn"><input type="radio" name="adtype" value="2"> <span>Video</span></span>
        <span class="new-list-spn"><input type="radio" name="adtype" value="3"> <span>Image</span></span>
        <span class="new-list-spn"><input type="radio" name="adtype" value="4"> <span>RSS Feed</span></span>
    </div>
                       
    <div class="form-group">
             
             <label>Categories</label>
            <select id="category" name="category" class="form-control">
                <?php foreach($allcategories as $cl) { 
                   $d_selection='';
                    if($cl["id"]=='83'){
                        $d_selection='selected="selected"';
                    }
                    
                    ?>
                <option <?php  echo $d_selection; ?> value="<?php echo $cl["id"] ?>"><?php echo $cl["name"]; ?></option>
                <?php } ?>
              </select>
              
            </div>
<?php }  ?>
             <div class="form-group">
                               <label>Post Date</label>
                            <div> 
                        <?php
                    
                if(isset($listing->dt_created)&&($listing->dt_created!='')){
                $postdate_value= date('d/m/Y', $listing->dt_created); 
                }else{
                $postdate_value= date('d/m/Y'); 
                        } ?>        
                                                    <input type='text' class="form-control" id="postdate"  name="postdate" value="<?php echo $postdate_value ; ?>" />
                               For Example : 16/04/2018 [DD/MM/YYYY]
                            </div>
                        </div>
            
      
            

  <div id="listingentryform">
    <?php
      if(isset($listing->id)&&($listing->id!=NULL)){ 
      ?>
        <div class="form-group" style=" background-color: #D0D0D0">
            <label class="url">Upload Title and Content by zip</label>
            <input type="file"  name="zip_content_title" id="zip_content_title" />
        </div>
        <div class="form-group"  style="align:center">
            <label class="url"><font size="5">OR Edit Manually</font></label>
        </div>
      <?php  } 
      
      if(isset($listing->top_category_id)&&(($listing->top_category_id=='12')||($listing->top_category_id=='13')||($listing->top_category_id=='83'))){
          //For primary listing
        ?>
             <div class="form-group">
             
             <label>Categories</label>
            <select id="category_other" name="category_other" class="form-control">
                <?php foreach($allcategories as $cl) { 
                    if($cl["id"]==$listing->category_id){
                        ?>
                            
                <option value="<?php echo $cl["id"] ?>" selected="selected"><?php echo $cl["name"]; ?></option>
                            <?php
                    }else{
                    
                    
                    ?>
                <option value="<?php echo $cl["id"] ?>"><?php echo $cl["name"]; ?></option>
                
                    <?php
                    }
                    
                    } ?>
              </select>
              
            </div>
            <?php
      }else{
      if(isset($listing->category_id )){
          
          $content_type_exam_id=$listing->category_id;
          
      }
      
      if(isset($listing->subject_id)){
          
          $content_type_subject=$listing->subject_id;
      }
      
      if(isset($listing->chapter_id )){
          
          $content_type_chapter_id=$listing->chapter_id;
          
      }
      
     if(isset($content_type_exam_id)){
            ?>  <label>Select Exam</label><?php
        
echo generateSelectBox('category', $exams_article_arr, 'id', 'name', 1 , 'class="form-control" onchange="getContent();"',$content_type_exam_id); 
        }
        
        if(isset($content_type_subject)){
            ?> <label>Select Subject</label><?php
echo generateSelectBox('subject', $subjects_article_arr, 'id', 'name', 1 , 'class="form-control" onchange="getContent();"', $content_type_subject);
        }
        
        if(isset($content_type_chapter_id)){
            ?>  <label>Select Chapter</label><?php
echo generateSelectBox('chapter', $chapters_article_arr, 'id', 'name', 1 , ' class="form-control" onchange="getContent(1);"',$content_type_chapter_id); 
        }
        }
?>    
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" id="title"  value="<?php if(isset($listing->title)) { echo $listing->title; } ?>" class="form-control input-lg" />
    </div>
    <div class="form-group">
        <label>Content</label>
         <textarea rows="5"  name="description"   id="description" class="form-control"><?php if(isset($listing->description)) { echo $listing->description; } ?></textarea>
    </div>
    <div class="form-group toHide" style="display:none" id="blk-1">
        <label>Audio</label>
        <input type="text" class="form-control">
    </div>
    <div class="form-group toHide" style="display:none" id="blk-4">
        <label>Rss Feed Url</label>
        <input type="text"  name="rss_url" id="rss_url" class="form-control" />
    </div>
      
    <div class="form-group toHide" style="display:none" id="blk-2">
        <label>Video Embed / IFrame Code</label>
        <textarea rows="5"  name="external_url"   id="external_url" class="form-control"></textarea>
    </div>
            
         <div class="form-group toHide" style="display:none" id="blk-3">
        <div class="list-img-upload">
        <div class="form-group">
            <label class="url">Image External Url</label>
            <input type="text"  name="image_url" id="image_url" class="form-control" />
        </div>
        <div class="or-saperate">OR</div>
        <div class="form-group">
            <label class="url">Upload Image</label>
            <input type="file"  name="file" id="file" class="form-control" />
        </div>
        
        </div>
    </div>
   
    <?php   if(isset($listing->external_link)){

      if($listing->adtype==2){
     ?>

    <div class="form-group toHide"   id="blk-2">

    <label>Video Embed / IFrame Code</label>
        <textarea rows="5"  name="external_url"   id="external_url" class="form-control"><?php if(isset($listing->external_url)){ echo $listing->external_url; } ?></textarea>
        
       
    </div>
     <?php } elseif($listing->adtype==4){
      ?>
       <div class="form-group toHide"  id="blk-4">
        <label>Rss Feed Url</label>
        <input type="text"  name="rss_url" id="rss_url" class="form-control" value="<?php echo $listing->external_url;?>"/>
    </div>
      <?php
      }else {    ?>

  <input type="hidden" name="image" id="image" value="<?php if(strpos($listing->external_url,'http')==false) { echo $listing->external_url; } ?>"> 

    <div class="form-group toHide"  id="blk-3">
        <div class="list-img-upload">
        <div class="form-group">
            <label class="url">Image External Url</label>
            <input type="text"  name="image_url" id="image_url" value="<?php if(strpos($listing->external_url, 'http') !== false) { echo $listing->external_url; } ?>" class="form-control" />
        </div>
        <div class="or-saperate">OR</div>
        <div class="form-group">
            <label class="url">Upload Image</label>
            <input type="file"  name="file" id="file" class="form-control" />
        </div>
        
        </div>

   <?php
        if(strpos($listing->external_url, 'http') !== false) {
        $image_path= $listing->external_url;  //$posting->external_url;
         
           
            ?>
            <img  height="200" width="300" src="<?php echo $image_path;?>">
            <?php }else{

                 $image_path= $listing->external_url;

            echo show_thumb($image_path,200,300,null,false);
            
         }
     ?>

    </div>
   <?php }  } ?>
    
            

    <div class="form-group ">
              <label>External Link</label>
               <input type="text"  name="external_link" value="<?php if(isset($listing->external_link)) { echo $listing->external_link; } ?>" class="form-control"/>
            </div>
          

   <input type="hidden" name="update" id="update" value="<?php if(isset($listing->id)) { echo $listing->id; } ?>">  
     <?php if(isset($listing->id)) {if($listing->id!=NULL){ ?>
     <button type="submit" class="btn btn-primary">Edit Listing </button>
     <?php } } else  { ?>

    <button type="submit" class="btn btn-primary">New Listing</button>

    <?php  } ?>
</form>
<div id="rssurlbox"  style="display:none; padding-bottom:20px;">
<form name="getfeeditemsform" id="getfeeditemsform" >
<div class="input-group" style="width:50% !important;">
   <input type="text"  name="feed_url" id="feed_url" class="form-control">
   <span class="input-group-btn">
        <button class="btn btn-success" type="submit" name="getfeed" id="getfeed">Get Items!</button>
   </span>
</div>
</form>
</div>

<div id="feeditems"  style="display:none">
  
</div>
</div>  

</div>
	</div>


                </div>
<!--End here Listing -->
                <div class="col-lg-12 clr-bth">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                   
                                    <thead>
                                        <tr> <th>No.</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Hits</th>
                                            <th>Published</th>
                                            <th>Date</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 

                                           if(!empty($postings)){
                                                     $i=1;  
                                                     
                                                     $value =  $this->config->item('records_per_page');
                                                     if(isset($status)){
                                                      $cur_page = $this->uri->segment(5) ? intval($this->uri->segment(5)) : 1;     
                                                    }else{
                                                    $cur_page = $this->uri->segment(4) ? intval($this->uri->segment(4)) : 1;
                                                }

                                                 

                                                    
                                                   if($cur_page==1){
                                                    $i=(($cur_page-1)+$i);
                                                   }else{
                                                    $i=(($cur_page)+$i);
                                                   }

                                                      
                                                
                                                  foreach($postings as $list){
                                              ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $list->title; ?></td>
                                           <td><?php echo $list->name; ?></td>
                                            <td>
                                            <?php if($list->adtype==0){
                                              echo "Text";
                                            }elseif ($list->adtype==1) {
                                              echo "Audio";
                                            }elseif ($list->adtype==2) {
                                              echo "Video";
                                            }elseif ($list->adtype==3) {
                                              echo "Image";
                                            }elseif ($list->adtype==4) {
                                              echo "RSS Feed";
                                            }    ?></td>
                                            <td>
                                            <?php 
                                            $des=strip_tags($list->description);
                                            echo word_limiter($des,12);  
                                            ?>
                                            </td>
                                             <td><?php  echo $list->hits;  ?></td>
                                            <td><?php  if($list->published==1){
                                                                                 echo" Published" ;
                                                                                 $id=$list->id;
                                                                                 }else {
                                                                            $id=$list->id;
                                                                            ?>
                                               <a href="<?php echo base_url().'admin/listings/published/'.$id ?>">Pending</a>
                                                         <?php
                                                                          }  ?></td>
                                            <td class="center"><?php echo date('d/m/Y', $list->dt_created); ?></td>

                                            <td> 
                                             <a href="<?php echo base_url().'admin/listings/edit_listing/'.$id ?>" ><i class="fa fa-edit cat-edit" ></i></a>
                                       
                                             <a href="<?php echo base_url().'admin/listings/deletelisting/'.$id ?>"><i class="fa fa-trash cat-del"></i></a>
                                             
                                             </td>
                                        </tr>
                                                  <?php    $i++;  }  } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>

                                    <?php 
                                    
                                    if(!empty($postings)){ ?>
                                        <td colspan="8">
                                            <?php //echo "<h6>".$links."</h6>"; 

                                            if ($value<$i) {
                                              
                                            ?>
                                            <?php  echo "<h6><b>";
                                                   echo $data["links"] = $this->pagination->create_links()."</b></h6>";?>
                                                   <?php } ?>
                                        </td>
                                        <?php } ?>
                                    </tr></tfoot>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
   
<script type="text/javascript">
function relationMod(parm){
	if(parm=='show'){
document.getElementById("rele-section").style.display = "block";
	}else{
document.getElementById("rele-section").style.display = "none";
	}
}

  tinymce.init({
    selector: 'textarea',
    inline: false,
    height: 500,
    width:1000,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools '
  ],
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
    '//www.tinymce.com/css/codepen.min.css'
  ],
  automatic_uploads: true,
  relative_urls: false
  });
  </script>