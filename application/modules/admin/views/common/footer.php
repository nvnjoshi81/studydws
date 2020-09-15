<?php
 //Redirect user if user is not logged in.
  if($_SESSION['first_name']==''){ 
      
       redirect('admin/logout');
   }

 ?>
<!--footer---->
<style>
    .modal-backdrop {
        height: 100%;
    }
</style>
<div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
             <!-- Content will be loaded here from "remote.php" file -->
            </div>
        </div>
</div>

<!--To update Display Name -->
<div class="modal fade" id="myModal_edit_displayname">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      
                <!-- Content will be loaded here from "fileInfo.php" file -->
      </div>
    </div>
  </div>

<!--To update Display Name -->
<div class="modal fade" id="myModal_edit_contentsname">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      
                <!-- Content will be loaded here from "edit_contents.php" file -->
      </div>
    </div>
  </div>
<!--For admin password model's -->
<?php 
if($this->session->userdata('logged_in')){ ?>
	<div class="modal fade" id="myModal_admin_pass" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
	  <form action="<?php echo base_url() ?>admin/update/admin_password" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Hello <?php echo $this->session->userdata['first_name'].' '.$this->session->userdata['last_name'] ; ?></b></h4>
        </div>
        <div class="modal-body">
            <p><b>Enter New Password</b></p>
            <div class="form-group has-success label-floating is-empty">
            <label class="control-label" for="name">Password</label>
            <input class="form-control" type="password" name="password" required>
            </div> 
            <div class="form-group has-success label-floating is-empty">
            <label class="control-label" for="name">Confirm Password</label>
            <input class="form-control" type="password" name="confirm_password" required>
            </div>           
            <input type="hidden" name="user_id" value="<?php echo $this->session->userdata['userid']; ?>">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-raised btn-warning">Update</button>
        </div>
      </div>
      </form>
    </div>
  </div>
      <?php } ?>
  <!-- jQuery -->   
    <!-- Bootstrap Core JavaScript --> 
<?php if (isset($loadMathJax)) { ?>
    <!--mathJax -->
    <script type="text/x-mathjax-config">
        //
        //  Do NOT use this page as a template for your own pages.  It includes 
        //  code that is needed for testing your site's installation of MathJax,
        //  and that should not be used in normal web pages.  Use sample.html as
        //  the example for how to call MathJax in your own pages.
        //
        MathJax.HTML.Cookie.Set("menu",{});
        MathJax.Hub.Config({
        extensions: ["tex2jax.js","TeX/AMSmath.js", "TeX/AMSsymbols.js"],
        jax: ["input/TeX","output/HTML-CSS"],
        "HTML-CSS": {
        availableFonts:[],
        styles: {".MathJax_Preview": {visibility: "hidden"},".MathJax_Display":{display:'inline'}}
        }
        });

        MathJax.Hub.Register.StartupHook("HTML-CSS Jax Ready",function () {
        MathJax.Hub.Insert(MathJax.InputJax.TeX.Definitions.macros,{
        cancel: ["Extension","cancel"],
        bcancel: ["Extension","cancel"],
        xcancel: ["Extension","cancel"],
        cancelto: ["Extension","cancel"]
        });
        var HTMLCSS = MathJax.OutputJax["HTML-CSS"];
        if (HTMLCSS && HTMLCSS.imgFonts) {document.getElementById("imageFonts").style.display = ""}

        var FONT = MathJax.OutputJax["HTML-CSS"].Font;
        FONT.loadError = function (font) {
        MathJax.Message.Set("Can't load web font TeX/"+font.directory,null,2000);
        document.getElementById("noWebFont").style.display = "";
        };
        FONT.firefoxFontError = function (font) {
        MathJax.Message.Set("Firefox can't load web fonts from a remote host",null,3000);
        document.getElementById("ffWebFont").style.display = "";
        };
        $("ul#filter li a").click(function(){
        var $grid = $('.grid').isotope({
        // options
        });
        var selText = $(this).text();
        var filter=$(this).attr('tag');

        $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
        $grid.isotope({ filter: '.'+filter });
        });
        });


    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/MathJax/MathJax.js"></script>
<?php } ?>
    
<script>
    $(document).on('click','.cat-del',function(){
        
       return confirm('Are you sure to delete?'); 
    });
	
	$(document).on('click','.rusure',function(){
        
       return confirm('Are you sure?'); 
    });
	
	</script>
<script>
    function chekFileAvail(filepath,file_ext){
         var common_file_val=$('#common_file_name').val();
        //common_file_name
        var newmsgstr=null;
        if(common_file_val==''||typeof(common_file_val) == "undefined" ) {
       newmsgstr='Please Enter complete file name without extansion.';
       $('#fileResultarea').html('[<font color="red">'+newmsgstr+'</font>]');
    }else{
    $.ajax({
             url:base_url+"admin/dashboard/checkFileExist/"+common_file_val+'/'+filepath+'/'+file_ext,  
             dataType:'json',
             success:function(response) {
if (response.result!=null)
{    
newmsgstr='File Exist On <font color="blue"><a target="_blank" href='+response['result']+'>'+response['result']+'</a></font>'; 
}else{
newmsgstr='File '+common_file_val+'.'+file_ext+' not found';    
}
       // $.each(response,function(index,item){
                       //$('#relation_chapter').append('<option value="'+item.id+'">' + item.name+ '</option>');
                       //str+='<div class="col-sm-6"><input type="checkbox" value="'+item.id+'" name="eschapters_selected[]">' + item.result+'</div>';
                          //msgstr=str+'This is working.'+common_file_val;
    
                //  });
                   //$('#eschapters').html(str);
                     $('#fileResultarea').html('[<font color="red">'+newmsgstr+'</font>]');
                }
            });
            }
            //alert("Check Result above the button.");
    }
    
    
     function getContent_relation(is_final){
        if(typeof is_final === 'undefined'){
            is_final=0;
        };
        var ctype=$('#relation_content_type').val();
        if(ctype==0){
            alert('Please select content type');
            return false;
        }
        var exam=$('#relation_exam').val();
        var subject=$('#relation_subject').val();
        var chapter=$('#relation_chapter').val();
        var str='';
        if(exam >  0 && subject > 0 && is_final==0){
            // GET Chapters
            $.ajax({
                url:base_url+"admin/chapters/get/"+exam+'/'+subject,  
                dataType:'json',
                success:function(response) {
                    $('#relation_chapter option[value!="0"]').remove();
                    //var selectbox=$("#chapter");
                  $.each(response,function(index,item){
                       //$('#relation_chapter').append('<option value="'+item.id+'">' + item.name+ '</option>');
                       str+='<div class="col-sm-6"><input type="checkbox" value="'+item.id+'" name="eschapters_selected[]">' + item.name+' ('+item.id+')</div>';
                  });
                   $('#eschapters').html(str);
                }
            });
        }
    }
    
function stripHTML(dirtyString) {
    var container = document.createElement('div');
    var text = document.createTextNode(dirtyString);
    container.appendChild(text);
    return container.innerHTML; // innerHTML will be a xss safe string
}  


function mergeSection(is_final){
    $('#dataTables-example-last tbody').html('');
    $('#contentdata-last').hide();
        if(typeof is_final === 'undefined'){
            is_final=0;
        };
        var ctype=$('#content_type').val();
        var ctype_text=$('#content_type option:selected').text();
        if(ctype==0){
            alert('Please select content type');
            return false;
        }
        var exam=$('#category').val();
        var subject=$('#subject').val();
        var chapter=$('#chapter').val();
        var getModuleId ="<?php echo $this->uri->segment(4)?>";
        var getModuleType ="<?php echo $this->uri->segment(5)?>";
        if(exam >  0 && subject > 0 && is_final==0){
            // GET Chapters
            $.ajax({
                url:base_url+"admin/chapters/get/"+exam+'/'+subject,  
                dataType:'json',
                success:function(response) {
                    $('#chapter option[value!="0"]').remove();
                    //var selectbox=$("#chapter");
                  $.each(response,function(index,item){
                       $('#chapter').append('<option value="'+item.id+'">' + item.name+ '</option>');
                  });
                }
            });
        }

        if(exam > 0){
            // GET content from correct table
            $.ajax({
                url:base_url+"admin/contents/get/"+ctype+"/"+exam+'/'+subject+"/"+chapter,  
                dataType:'json',
                success:function(response) {
                    if(response.count > 0){
                        $('#contentdata').show();
                        $("#dataTables-example > tbody").html("");
                        var trHTML = '';
						var modid ='';
						var modules_item_id=[];
                        trHTML += '<tr><td><b>Currently Showing Question Bank</b></td></tr>';
                        var related_moduleType =ctype;
                        trHTML += '';
                        trHTML += '<tr><td>';
                        trHTML += '<input type="hidden" name="getModuleId" value="'+getModuleId+'" >';
                        trHTML += '<input type="hidden" name="getModuleType" value="'+getModuleType+'" >';
                        
                       // trHTML += '<select name="related_moduleId" id="related_moduleId" onchange="getQusList('+getModuleId+','+getModuleType+','+related_moduleType+');" >';
                        
                       // trHTML += '<option value="0">Please select</option>';
                        $.each(response.data,function(index,item){
                            
 trHTML +='<input type="checkbox" name="modules_item_id[]" value='+ item.id + '>'+ stripHTML(item.displayname)+'<br>';        
                       // trHTML += '<option value=' + item.id + '>' + stripHTML(item.displayname) + '</option>';
                         //modules_item_id.push(item.id);
                        modid=item.miid;
					    trHTML += '<input type="hidden" name="related_moduleId['+item.id+']" value="'+modid+'" >';	
						});
						
						//alert(modules_item_id);
                       // trHTML += '</select>';
                        trHTML += '<input type="hidden" name="related_moduleType" value="'+related_moduleType+'" >&nbsp;<br><br><input type="checkbox" name="mergeDelete" value="Yes" >&nbsp;<b>Delete?(Select Checkbox to delete The Value.)</b>';
                        trHTML += '</td><td><button type="submit">Submit</button></td></tr>';
                        trHTML += '';
                        $('#panel_chang_id').hide();
                        $('#submit_qus_list').hide();
                        $('#dataTables-example tbody').append(trHTML);
                    }else{
                        $('#dataTables-example tbody').html('');
                        $('#contentdata').hide();
                        $('#pricedata').hide();
                    }
                }
            });
            } 
}

    function getQusList(getModuleId,getModuleType,related_moduleType){
    
    var related_moduleId=$('#related_moduleId').val();
    var filesname;
    $.ajax({
                url:base_url+"admin/contents/getLastLevelList/"+related_moduleId+"/"+related_moduleType,  
                dataType:'json',
                success:function(response) {
                   if(response.count > 0){
                        $('#contentdata-last').show();
                        $("#dataTables-example-last > tbody").html("");
                    var trHTML = '';
                    trHTML += '<tr><td colspan="3"><b>Currently Showing Question Bank</b></td></tr>';
                    trHTML += '';
                   
                    $.each(response.data,function(index,item){
                    if(item.displayname!=''){
                        filesname= item.displayname ; 
                    }else{
                        filesname = item.question 
                    }
                        var last_levelId =item.id;            
                    trHTML += '<tr><td>' + item.id + '</td><td>' + item.question + '</td><td><a href="'+base_url+'admin/mergesection/save_merge_lastlevel/'+getModuleId+'/'+getModuleType+'/'+related_moduleId+'/'+related_moduleType+'/'+last_levelId+'">Add</a><br><a href="'+base_url+'admin/mergesection/delete_merge/'+getModuleId+'/'+getModuleType+'/'+related_moduleId+'/'+related_moduleType+'/'+last_levelId+'">Delete</a></td></tr>';
                        
                    });
                    trHTML += '';
                    $('#dataTables-example-last tbody').append(trHTML);
                }else{
                    $('#dataTables-example-last tbody').html('');
                    $('#contentdata-last').hide();
                }
                }
                
                });
    
    //alert("test"+related_moduleId+" related module type "+related_moduleType);
    }    

    function getContent(is_final){
           //$('#playlistTables-example').hide();
           //$('#playlistTables-example-input').show();
           
        if(typeof is_final === 'undefined'){
            is_final=0;
        };
        
        var ctype=$('#content_type').val();
        var ctype_text=$('#content_type option:selected').text();
        if(ctype==0){
            alert('Please select content type');
            return false;
        }
        var exam=$('#category').val();
        var subject=$('#subject').val();
        var chapter=$('#chapter').val();
        if(exam >  0 && subject > 0 && is_final==0){
            // GET Chapters
            $.ajax({
                url:base_url+"admin/chapters/get/"+exam+'/'+subject,  
                dataType:'json',
                success:function(response) {
                    $('#chapter option[value!="0"]').remove();
                    //var selectbox=$("#chapter");
                  $.each(response,function(index,item){
                       $('#chapter').append('<option value="'+item.id+'">' + item.name+ '</option>');
                  });
                }
            });
        }

        if(exam > 0){
            // GET content from correct table
            $.ajax({
                url:base_url+"admin/contents/get/"+ctype+"/"+exam+'/'+subject+"/"+chapter,  
                dataType:'json',
                success:function(response) {
                    if(response.count > 0){
                        $('#contentdata').show();
                        $("#dataTables-example > tbody").html("");
                        var trHTML = '';
                         var sid_total =0;
                        //trHTML += '<tr><td></td><td><b>Currently Showing Question Bank</b></td><td></td></tr>';                        
                        var sid =1;
                        $.each(response.data,function(index,item){
                            var mitm_id='';
                            if((ctype_text=='Study Material')){
                               mitm_id=item.miid;
                            }else{
                                mitm_id=item.id;
                            }
                            
                            var hiddenField ='';
                            var edit='<a href="'+base_url+'admin/contents/edit/' + mitm_id+'/'+response.type+'/'+item.exam_id+'/'+item.subject_id+'/'+item.chapter_id+'">';
                                   edit+='<i class="fa fa-edit cat-edit"></i></a>';
                            var del='<a href="'+base_url+'admin/contents/delete/' + mitm_id+'/'+response.type+'">';
                                   del+='<i class="fa fa-trash cat-del"></i></a>';   
                            var tag='<a data-toggle="modal" data-show="true" data-target="#myModal" href="'+base_url+'admin/contents/tag/' + mitm_id+'/'+response.type+'">';
                                    tag+='<i class="fa fa-tags cat-edit"></i></a>';
                                    if(ctype_text!='Videos'){
                            var price='<a data-toggle="modal" data-show="true" data-target="#myModal" href="'+base_url+'admin/contents/price/' + item.id+'/'+response.type+'/'+item.item_id+'/'+mitm_id+'">';
                            price+='<i class="fa fa-inr cat-edit"></i></a>'; 
                            var item_price = item.discounted_price;
                        }else{
                             var price='';
                             var item_price = '';
                        }
                            
                                    var merge='<a href="'+base_url+'admin/mergesection/merge/' + mitm_id+'/'+response.type+'">';
                                    merge+='<i class="fa fa-shield cat-edit"></i></a>'; 
                                    
  
   var filename_one='';
   if(item.filename_one==undefined){
       filename_one='';
   }else{
       <?php $pdfpath= base_url('upload/pdfs/'); ?>
       filename_one='<a target="_blank" href="<?php echo $pdfpath; ?>/'+item.filename_one+'">'+item.filename_one+'</a>';
   }
trHTML +='<tr><td>' + sid + '</td>'

if(filename_one!=''){ trHTML +='<td>'+mitm_id+'<br>PDF File ID-' + item.id + '</td>';
	
}else{
	  trHTML +='<td>' + item.id + '</td>';
}
	
	if(item.displayname==undefined){ 
    trHTML += '<td>' + stripHTML(item.name) +'<br>'+filename_one+ '</td>';
}else{
    if(stripHTML(item.displayname)==stripHTML(item.name)){
    trHTML += '<td>' + stripHTML(item.name) + '<br>('+filename_one+')</td>';
    }else{
    trHTML += '<td>' + stripHTML(item.name) + '<br>('+item.displayname+'<br>'+filename_one+')</td>';    
    }
    
   
}                 
    
    trHTML += '<td>' + item.exam + '</td><td>' + item.subject + '</td><td>' + item.chapter + '</td>';
     if((item_price==undefined)||(item_price=='')){ 
    trHTML += '<td>&nbsp;</td>';
    }else{
        trHTML += '<td>'+item.price+'/'+item_price +'</td>';
    }
                     
    trHTML += '<td>' + edit + del + price + tag + merge +'</td></tr>';
        $("#totalproduct").html(sid);
                     sid++;
                        });
                        $('#panel_chang_id').hide();
                        $('#submit_qus_list').hide();
                        $('#dataTables-example tbody').append(trHTML);
                    }else{
                        $('#dataTables-example tbody').html('');
                        $('#contentdata').hide();
                        //$('#pricedata').hide();
                    }
                }
            });
            
            // GET Price for content
            $.ajax({
                url:base_url+"admin/pricelist/getPrice/"+ctype+"/"+exam+'/'+subject+"/"+chapter,  
                dataType:'json',
                success:function(response) {
                
                 $('#pricedata').show();
                    if(response.success == 1 ){
                        $('#price').val(response.data.price);
                        $('#discounted_price').val(response.data.discounted_price);
                        $('#description').val(response.data.description);
                        $('#modules_item_name').val(response.data.modules_item_name);
                        $('#offline_status'+response.data.offline_status).attr('checked',true);
                        $('#total_dvds').val(response.data.no_of_dvds);
                        $('#number_of_lectures').val(response.data.no_of_lectures);                               $('#subscription_validity').val(response.data.subscription_expiry);
                        $('#total_subscribers').val(response.data.no_of_subscribers);
                        $('#lecture_duration').val(response.data.lecture_duration);  
                        var orderlist_url = base_url+"admin/orders/ord_products/"+response.data.id+"/"+encodeURI(response.data.modules_item_name);
                        $("#orderlist_url").prop("href", orderlist_url);

						var cartlist_url=base_url+"admin/customers/prdcustcart/"+response.data.id;
                        $("#cartlist_url").prop("href", cartlist_url);
						
                        if(response.data.image !=''){
                            $('#proimage').html('<img src="/assets/frontend/product_images/'+response.data.image+'">').show();
                        }else{
                            $('#proimage').html('').show();
                        }

                        $('#faction').val(response.data.id);
                        $('#faction_pricelist_id').val(response.data.id);
                       
                    }else{
                       $('#price').val('');
                       $('#discounted_price').val('');
                       $('#modules_item_name').val('');
                       $('#faction').val(0);
                       $('#proimage').html('').show();
                    }
                }
            });
        }
      /*For video section playlist Drop Down*/
      if(ctype_text=='Videos'){
          $.ajax({
                url:base_url+"admin/contents/get/"+ctype+"/"+exam+'/'+subject+"/"+chapter,  
                dataType:'json',
                success:function(response) {
                    if(response.count > 0){
                        $('#playlistTables-example').show();
                        
                        $("#playlistTables-example").html("");
                        var trHTML = '<label>Select Existing Playlist</label>';
                        trHTML += '<select class="form-control valid" id="existing_playlist_id" name="existing_playlist_id">'; trHTML += '<option value="0">Select Playlist</option>';  
                        $.each(response.data,function(index,item){
                       
                               trHTML += '<option value="'+item.id +'">' + item.name + '</option>';                           
                        });
                        trHTML += '</select>';
                       // $('#panel_chang_id').hide();
                       // $('#submit_qus_list').hide();
                        
                        $('#playlistTables-example').append(trHTML);
                    }else{
                        
                        $('#playlistTables-example').show();
                        $("#playlistTables-example").html("");
                        var trHTML = '<label>Existing Playlist</label>';
                        trHTML += '<select class="form-control valid" id="existing_playlist_id" name="existing_playlist_id">';
                        trHTML += '<option value="0">Playlist N.A.</option>';
                        trHTML += '</select>';
                       // $('#panel_chang_id').hide();
                       // $('#submit_qus_list').hide();
                        
                        $('#playlistTables-example').append(trHTML);
                        
                       // var trHidden='<input type="hidden" name="existing_playlist_id" value="0">';
                       // $('#playlistTables-example').append(trHidden);
                       // $('#existing_playlist_id').hide();
                        //$('#playlistTables-example').html('');
                        //$('#playlistTables-example').hide();
                        
                    }
                }
            });
        }
        
        //Get total
            $.ajax({
                url:base_url+"admin/pricelist/getPriceTotal/"+ctype+"/"+exam+'/'+subject+"/"+chapter,  
                dataType:'json',
                success:function(response) {
                       $("#priiceTable").html(response.total);
                }
            });
        
        
        
    }
    
    
    
      function viewContent(is_final){
           
        var ctype=$('#content_type').val();
        var ctype_text=$('#content_type option:selected').text();
        if(ctype==0){
            alert('Please select content type');
            return false;
        }
        var exam=$('#category').val();
        var subject=$('#subject').val();
        var chapter=$('#chapter').val();
        var ot_id=$('#ot_id').val();
        

        if(exam > 0){
            // GET content from correct table
            $.ajax({
                url:base_url+"admin/contents/get/"+ctype+"/"+exam+'/'+subject+"/"+chapter,  
                dataType:'json',
                success:function(response) {
                    if(response.count > 0){
                        $('#contentdata').show();
                        $("#dataTables-example > tbody").html("");
                        var trHTML = '';
                         var sid_total =0;
                        //trHTML += '<tr><td></td><td><b>Currently Showing Question Bank</b></td><td></td></tr>';                        
                        var sid =1;
                        $.each(response.data,function(index,item){
                            var mitm_id='';
                            if((ctype_text=='Study Material')){
                               mitm_id=item.miid;
                            }else{
                                mitm_id=item.id;
                            }
                            
                            var hiddenField ='';
                            var edit='<a onclick="contentsQus('+ot_id+','+mitm_id+','+response.type+','+item.exam_id+','+item.subject_id+','+item.chapter_id+')">Show</a>';                      
                               var price='';
                             var item_price = '';
                            
                                    
                                    
    trHTML +='<tr><td>' + sid + '</td><td>' + item.id + '</td>';
    
    if(item.displayname==undefined){ 
    trHTML += '<td>' + stripHTML(item.name) + '</td>';
}else{
    
    trHTML += '<td>' + stripHTML(item.name) + '<br>('+item.displayname+')</td>';
   
}                 
    
    trHTML += '<td>' + item.exam + '</td><td>' + item.subject + '</td><td>' + item.chapter + '</td>';
     if((item_price==undefined)||(item_price=='')){ 
    trHTML += '<td>&nbsp;</td>';
    }else{
        trHTML += '<td>'+item.price+'/'+item_price +'</td>';
    }
                     
    trHTML += '<td>' + edit +'</td></tr>';
        $("#totalproduct").html(sid);
                     sid++;
                        });
                        $('#panel_chang_id').hide();
                        $('#submit_qus_list').hide();
                        $('#dataTables-example tbody').append(trHTML);
                    }else{
                        $('#dataTables-example tbody').html('');
                        $('#contentdata').hide();
                        //$('#pricedata').hide();
                    }
                }
            });
            
           
        }
     
        
    }
    
    function contentsQus(ot_id,module_id,module_type,exam_id,subject_id=0,chapter_id=0){
    //alert("nvn"+module_id+'ty'+module_type+'ex'+exam_id);
        if(exam_id > 0){
            // GET content from correct table
            $.ajax({
                url:base_url+"admin/contents/getmodule_qus/"+module_id+"/"+module_type+"/"+exam_id+'/'+subject_id+"/"+chapter_id,  
                dataType:'json',
                success:function(response) {
                    if(response.count > 0){
                    var class_name='alert-success';
                    var class_name_array=['ffcccc','8c7373','00ffff','ffbf00','00ffbf','0080ff','ffffcc','9933ff']; 
                    var random=0;
                    random =Math.floor((Math.random() * 8));
                    class_name=class_name_array[random];
                        $('#contentdata_qa').show();
                        //$("#dataTables_qa > tbody").html("");
                        var trHTML = '';
                        var sid_total =0;
                        //trHTML += '<tr><td></td><td><b>Currently Showing Question Bank</b></td><td></td></tr>'; 
                    var allQ=$("#totalquestion").val();
                    if(allQ>0){
                    var sid =parseInt(allQ)+parseInt(1);
                    }else{
                    var sid =1;
                    }
                        $.each(response.data,function(index,item){
                            var mitm_id='';
                            mitm_id=item.id;
                            var hiddenField ='';
                            var edit='<input type="checkbox" name="qflag" id="qflag_'+sid+'" onclick="update_otqus('+ot_id+','+mitm_id+','+sid+')" >';                      
                            var price='';
                            var item_price = '';
    trHTML +='<tr  style="background-color: #'+class_name+'">';                      
    trHTML +='<td>' + sid + '</td><td>' + item.id + '</td>';
    //var pure_text =$(item.question).text()
    trHTML += '<td>' + item.question + '</td>';               
    trHTML += '<td>' + item.type + '</td>';
    trHTML += '<td>' + edit +'</td>';
    trHTML += '</tr>';
        $("#totalquestion_span").html(sid);
        $("#totalquestion").val(sid);
                     sid++;
                        });
                        //$('#panel_chang_id_qa').hide();
                        //$('#submit_qus_list').hide();
                        $('#dataTables_qa tbody').append(trHTML);
                    }else{
                        $('#dataTables_qa tbody').html('');
                        $('#contentdata_qa').hide();
                        //$('#pricedata').hide();
                    }
                }
            });
        }
    }
    
    function update_otqus(ot_id,qus_id,num){
    var action='';
    if ($("#qflag_"+num).is(":checked"))
    {
    action ='add'; 
    }else{
    action ='remove';
    }
    
    $.ajax({
               url:base_url+"admin/contents/updateot_qus/"+ot_id+"/"+qus_id+"/"+action,               dataType:'json',               
               success:function(response) {
                if(response.count > 0){
                //success    
                }else{
                //Fails
                }
                }
            });
    
    }
    
    function editMarks(ot_details_id,qid){
         var marks =$('#qusmarks_'+qid).val();
    $.ajax({
               url:base_url+"admin/contents/updateot_marks/"+ot_details_id+"/"+marks,               dataType:'json',               
               success:function(response) {
                if(response.count > 0){
                //success    
                }else{
                //Fails
                }
                }
            });
        
    }
    function resetSelect(){
        $('#category').prop('selectedIndex',0);
        $('#subject').prop('selectedIndex',0);
        $('#chapter').prop('selectedIndex',0);
        $('#contentdata').hide();
        $("#dataTables-example > tbody").html("");
        $('#pricedata').hide();
        $('#price').val('');
        $('#modules_item_name').val('');
        $('#discounted_price').val('');
        $('#faction').val(0);
    }
    
    
     $('body').on('hide.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
      });
      $('body').on('shown.bs.modal', function (e) {
           /* var tags = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: base_url+'admin/contents/tags'
              });
              tags.initialize();

              var elt = $('#tags');
              elt.tagsinput({
                itemValue: 'value',
                itemText: 'text',
                freeInput: true,
                typeaheadjs: {
                  name: 'tags',
                  displayKey: 'text',
                  source: tags.ttAdapter()
                }
              });
            var tags = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: base_url+'admin/contents/tags',
            prefetch: {
              url: base_url+'admin/contents/tags',
              filter: function(list) {
                return $.map(list, function(tag) {
                  return { name: tag }; });
              }
            }
          });
          tags.clearPrefetchCache();
          tags.initialize();

          $('#tags').tagsinput({
              freeInput: true,
            typeaheadjs: {
              name: 'tag',
              displayKey: 'name',
              valueKey: 'name',
              source: tags.ttAdapter()
            }
          });*/
        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
              var matches, substringRegex;

              // an array that will be populated with substring matches
              matches = [];

              // regex used to determine if a string contains the substring `q`
              substrRegex = new RegExp(q, 'i');

              // iterate through the pool of strings and for any string that
              // contains the substring `q`, add it to the `matches` array
              $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                  matches.push(str);
                }
              });

              cb(matches);
            };
        };
         $('#tags').on('itemAdded', function(event) {
            $.ajax({
                    type: 'POST',
                    url: base_url+'admin/contents/addtag',
                    data: 'tag='+event.item+'&id='+$('#content_id').val()+'&type='+$('#type').val(),
                    success:function(){
                        
                    }
                });
            //$('#selectedvalues').val($('#tags').tagsinput('items'));
          });
          $('#tags').on('itemRemoved', function(event) {
             $.ajax({
                    type: 'POST',
                    url: base_url+'admin/contents/removetag',
                    data: 'tag='+event.item+'&id='+$('#content_id').val()+'&type='+$('#type').val(),
                    success:function(){
                        
                    }
                });
          });
        if($('#avatags').get(0)){
            var states = $("#avatags").val().split(',');
              $('#tags').tagsinput({
                  freeInput: false,
                typeaheadjs: {
                  name: 'tag',
                  source: substringMatcher(states)
                }
              });
        }
          $(document).on('click','#updateprice', function() {          
          var faction=$('#faction1').val();
          var price=$('#price1').val();
          var discounted_price=$('#discounted_price1').val();
          var modules_item_name=$('#modules_item_name1').val();
          var exam_id=$('#exam_id1').val();
          var subject_id=$('#subject_id1').val();
          var chapter_id=$('#chapter_id1').val();
          var type=$('#type1').val();
          var modules_item_id=$('#modules_item_id').val();
          var item_id = 0;
          if($('#item_id').get(0)){
            item_id = $('#item_id').val(); 
          }
          
          $.ajax({
                    type: 'POST',
                    cache:false,
                    url: base_url+'admin/pricelist/addPrice',
                    data: 'modules_item_name='+encodeURIComponent(modules_item_name)+'&modules_item_id='+modules_item_id+'&faction='+faction+'&price='+price+'&discounted_price='+discounted_price+'&category='+exam_id+'&subject='+subject_id+'&chapter='+chapter_id+'&content_type='+type+'&item_id='+item_id,
                    success:function(){
                        //$('#myModal').modal('hide')
                        location.reload();
                    }
                });
          //updatePrice(faction,price,discounted_price,exam_id,subject_id,chapter_id,type);
       });
   });
   
   $(document).on('click','#edit_displayname', function() {
           
          var display_filename=$('#display_filename').val();
          var common_filename=$('#common_filename').val();
          var display_filename_id=$('#display_filename_id').val();
          $.ajax({
                    type: 'POST',
                    cache:false,
                    url: base_url+'admin/contents/edit_displayname',
                    data: 'file_id='+display_filename_id+'&file_name='+encodeURIComponent(display_filename)+'&common_filename='+encodeURIComponent(common_filename),
                    success:function(){
                        //$('#myModal').modal('hide')
                        location.reload();
                    }
                });
       });
        $(document).on('click','#edit_contentsname', function() {
          var contents_name=$('#contents_name').val();
          var module_type_id=$('#module_type_id').val();
          var module_id=$('#module_id').val();
          $.ajax({
                    type: 'POST',
                    cache:false,
                    url: base_url+'admin/contents/edit_contentsname',
                    data: 'contents_name='+encodeURIComponent(contents_name)+'&module_type_id='+module_type_id+'&module_id='+module_id,
                    success:function(){
                        location.reload();
                    }
                });
       });
   function relateQuestion(question_id,chapter_id){
        $.ajax({
                url:base_url+"admin/questions/relate/"+question_id+'/'+chapter_id,  
                dataType:'json',
                success:function(response) {
                alert('Done');
                }
            });
    }
	function updtQue_formula(details_id,question_id,formula_id){ 
        $.ajax({
                url:base_url+"admin/contents/updtQue_formula/"+details_id+'/'+question_id+'/'+formula_id,  
                dataType:'json',
                success:function(response) {
    if(response.message=='success'){
			                
alert('Question Updated.');
	}else{               
alert('Try Again.Filed.');
	
	}
                }
            });
    }
	
</script>
