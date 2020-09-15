<style type="text/css">
  .input-group img{
    width:40% !important;
    height: auto;
  }
</style>
<script>
     $(function() {
    $("[name=adtype]").change(function(){
            $('.toHide').hide();
            $("#blk-"+$(this).val()).show('slow');
    });
 });

    </script>


<div id="page-wrapper" class="row">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Current Affairs</h1>
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
                <!--form Add New listing -->
<div class="col-lg-12 clr-bth"> 
            <form style="display: block;" class="new-acc-form new-list-form" <?php if(isset($listing->id)) { ?> id="edit_list-form" <?php } else{ ?>id="add_list-form" <?php } ?> method="post"  enctype="multipart/form-data"  action="<?php echo base_url();?>admin/listings/add_listing" >
               
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
    <h2>New Current Affairs</h2>
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
                <?php $d_selection=0; foreach($allcategories as $cl) { 
                    ?>
                <option <?php  echo $d_selection; ?> value="<?php echo $cl["id"] ?>"><?php echo $cl["name"]; ?></option>
                <?php } ?>
              </select>
              
            </div>
<?php }  ?>
             <div class="form-group">
                               <label>Posting Date</label>
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
  </div>
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

</div>
</form>
<div id="feeditems"  style="display:none">
  
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
                                            <td><?php 
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