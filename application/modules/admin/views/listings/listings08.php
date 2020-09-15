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

<?php if(!empty($listing)){ ?>
<script>
$(document).ready(function() {
    
    $(".new-acc-form").slideToggle();
  
});
</script>
 <?php   }?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Listing's </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
      <div class="col-sm-12">


      <form class="filter-form" id="filter" method="get" action="<?php echo $action;?>" >
         <div class="row">
         <div class="col-xs-5">
            <div class="input-group">
                <select id="filter_cat" name="filter_cat" class="form-control">
                <option value=0>All</option>
               
           <?php 
                  foreach($parent_categories as $category) { ?>
                 <option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>
                 <?php if($this->categories_model->hasSubcategory($category->id) > 0 ){ 
                     foreach($this->categories_model->getSubCategories($category->id) as $subcategory) { ?>
                 <option value="<?php echo $subcategory->id;?>"><?php echo '&nbsp;&nbsp;'.$subcategory->name;?></option>
               <?php }
                   } ?>
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

            <?php if(isset($listing[0]->id)) {if($listing[0]->id!=NULL){ ?>
            <a href="#" class="btn btn-success pull-right new-acc">Edit Listing</a>
            <?php  } } else { ?>
            <a href="#" class="btn btn-success pull-right new-acc">New Listing</a>
            <?php  }  ?>
     </div>
                <!--form Add New listing--->



<div class="col-lg-12 clr-bth"> 
            <form class="new-acc-form new-list-form" <?php if(isset($listing[0]->id)) { ?> id="edit_list-form" <?php } else{ ?>id="add_list-form" <?php } ?> method="post"  enctype="multipart/form-data"  action="<?php echo base_url();?>admin/listings/add_listing" >
            <?php if(isset($listing[0]->id)) {if($listing[0]->id!=NULL){ ?>

            <h2>Edit Listing</h2>
            <?php } }  else { ?>
            <h2>New Listing</h2>
            
    <div class="form-group" >
        <label>Type</label>
        <span class="new-list-spn"><input type="radio" name="adtype" value="0"> <span>Text</span></span>
        <span class="new-list-spn"><input type="radio" name="adtype" value="1"> <span>Audio</span></span>
        <span class="new-list-spn"><input type="radio" name="adtype" value="2"> <span>Video</span></span>
        <span class="new-list-spn"><input type="radio" name="adtype" value="3"> <span>Image</span></span>
           
    </div>
    
    
            <div class="form-group">
             
             <label>Categories</label>
          <select id="category" name="category" class="form-control">
           <?php 
                  foreach($parent_categories as $category) { ?>
                 <option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>
                 <?php if($this->categories_model->hasSubcategory($category->id) > 0 ){ 
                     foreach($this->categories_model->getSubCategories($category->id) as $subcategory) { ?>
                 <option value="<?php echo $subcategory->id;?>"><?php echo '&nbsp;&nbsp;'.$subcategory->name;?></option>
               <?php }
                   } ?>
             <?php } ?>
              </select>
              
            </div>
<?php } ?>


    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" id="title"  value="<?php if(isset($listing[0]->title)) { echo $listing[0]->title; } ?>" class="form-control" />
    </div>
    <div class="form-group">
        <label>Content</label>
         <textarea rows="5"  name="description"   id="description" class="form-control"><?php if(isset($listing[0]->description)) { echo $listing[0]->description; } ?></textarea>
    </div>
    <div class="form-group toHide" style="display:none" id="blk-1">
        <label>Audio</label>
        <input type="text" class="form-control">
    </div>


    <div class="form-group toHide" style="display:none" id="blk-2">
        <label>Video Embed / IFrame Code</label>
        <textarea rows="5"  name="external_url"   id="external_url" class="form-control"></textarea>
    </div>
            
            <div class="form-group toHide" style="display:none" id="blk-3">
        <label>Image</label>
        <input type="file"  name="file" id="file"   class="form-control" />
    </div>
   
    <?php if(isset($listing[0]->external_link)){

      if($listing[0]->adtype==2){
     ?>

    <div class="form-group toHide"   id="blk-2">

    <label>Video Embed / IFrame Code</label>
        <textarea rows="5"  name="external_url"   id="external_url" class="form-control"><?php if(isset($listing[0]->external_url)){ echo $listing[0]->external_url; } ?></textarea>
        
       
    </div>
     <?php } else { ?>

  <input type="hidden" name="image" id="image" value="<?php if(isset($listing[0]->external_url)) { echo $listing[0]->external_url; } ?>"> 

    <div class="form-group toHide"  id="blk-3">
        <label>Image</label>
        
        <input type="file"  name="file" id="file"  class="form-control" />
    </div>
   <?php }  } ?>
    
            

    <div class="form-group">
              <label>External Link</label>
               <input type="text"  name="external_link" value="<?php if(isset($listing[0]->external_link)) { echo $listing[0]->external_link; } ?>" class="form-control"/>
            </div>

   <input type="hidden" name="update" id="update" value="<?php if(isset($listing[0]->id)) { echo $listing[0]->id; } ?>">  
     <?php if(isset($listing[0]->id)) {if($listing[0]->id!=NULL){ ?>
     <button type="submit" class="btn btn-primary">Edit Listing </button>
     <?php } } else  { ?>

    <button type="submit" class="btn btn-primary">New Listing</button>

    <?php  } ?>
</form>
                </div>
<!--End here Listing--->
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
                                            <td><?php if($list->adtype==0){
                                                                                echo" Text";
                                                                                }elseif ($list->adtype==1) {
                                                                                    echo "Audio";
                                                                                }elseif ($list->adtype==2) {
                                                                                  echo "Video";
                                                                                    }elseif ($list->adtype==3) {
                                                                                     echo " Image";
                                                                                   }   ?></td>
                                            <td><?php  echo $list->description;  ?></td>
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