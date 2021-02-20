<div id="page-wrapper"> 
    
  <!--   <head>
  
 
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>-->

  
   <div class="row">
        <!--<div class="col-lg-12  container ">-->
<div class="col-lg-12 ">
   <div style = "text-align:center;">
  <h2>Online Classes</h2>
    <h2>Create Meeting</h2>  
  </div>
  <form  id = "Formdata"  method="post" enctype="multipart/form-data">
      
        <div class="form-group col-md-6">
  <label for="sel1">Select Class:</label>
  <select class="form-control" id ="my_class" name ="my_class" z required="">
         <option value = "" >Select Class</option>
  <?php
            if(isset($class_list))
            {
                foreach($class_list as $val)
                {
                echo "   <option value = ".$val['id'].','.$val['order'].">".$val['name']."</option>";
                }
            }
            ?>
 
  </select>
   <span class=" text-danger error"></span>
</div>  
      <div class="form-group col-md-6">
  <label for="sel1">Select Subject:</label>
  <select class="form-control " id = "subject" name ="subject" >
    <option value = "" >Select Subject</option>
   
  </select>
   <span class=" text-danger error"></span>
</div>
<div class="form-group col-md-6">
  <label for="sel1">Select Chapter</label>
  <select class="form-control" id ="chapter" name ="chapter" >
    <option value = "" >Select Chapter</option>  
  </select>
   <span class=" text-danger error"></span>
</div>
    <div class="form-group col-md-6">
      <label for="title">Title</label>
      <input type="text" class="form-control" id="email" placeholder="Enter Title" name="title"  required="">
    </div>
  
    
    <div class="form-group col-md-6">
      <label for="date">Date :</label>
      <input type="text" class="form-control" id="startdate" placeholder="Enter Date" name="date" readonly=""  required="" >
    </div>
     <div class="form-group col-md-6">
      <label for="date">Time :</label>
      <input type="time" class="form-control" id="pwd" placeholder="Enter Time" name="time"  required="">
    </div>
    
      <div class="form-group col-md-6">
        <label for="title">Hosted by </label>
      <input type="text" class="form-control" id="hosted_by" placeholder="Enter The Host Name" name="hosted_by"  required="">
           
        </div>
        
       <div class="form-group col-md-6">
          
           <label for="date">Image Upload :</label>
             <div class="custom-file">
                  
            <input type="file" class="custom-file-input" name = "filename">    
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
             </div>
        </div>    
 
         <div class="form-group col-md-6" style ="text-align: center;"> 
                <label for="date">Meeting Url type:</label>
                 <div class ="row" style ="margin-top: 25px;">
                        <div class ="col-md-6" style ="text-align: center;">
                             <input type="radio" class="tesgm t_1" name="url_type" autocomplete="off" value="1" checked="checked" >
                             <label style="color:#000000;">Studyadda Url</label>
                             </div>    
                        <div class ="col-md-6" style ="text-align: center;">
                             <input type="radio" class="tesgm t_2 " name="url_type" autocomplete="off" value="2">
                             <label style="color:#000000;">You Tube Url </label>
                             </div>    
                              <div class ="col-md-12 " id ="my_url_div" style ="text-align: end; display:none">
                                <input type ="text" id = "my_url" name ='you_tube_url' placeholder="Enter you tube url...">  
                                </div> 
                      </div>
              </div>
        
         <div class="form-group col-md-6">
                
              <label for="comment">Description:</label>
              <textarea class="form-control" rows="3" name ="comment" id="comment"></textarea>
           </div>
    
        
        
        
   <div class= "col-md-12">
    <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    
  </form>
</div>
</div>
<!--</div>-->

          <!-- ===================== msg model  start  ====================-->
        <div class="modal fade" id="msg_Modal" role="dialog" style ="margin-top: 10%;" >
          <div class="modal-dialog">
                
                  <!-- Modal content-->
                       <div class="modal-content">
                                 <div class="modal-header" style ="text-align: center;">
                                    <h5 class="modal-title text-white msg"  style = "color:white;" ></h5>
                                    <button type="button" class="close text-white" style = "color:white;" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                        </div>
                      </div>
                    </div>
                 
             <!-- ===================== msg model  end  ====================-->
<script>
        
        
          $('body').on('click','.t_2',function() 
            {
                    $("#my_url_div").show();
                });
      $('body').on('click','.t_1',function() 
            {
                    $("#my_url_div").hide();
                    $("#my_url").val('');
                });
      



        $('body').on('change','#my_class',function() 
                {
            
                      var id = $(this).val();
                        
                      //  alert("jk == "+id);
                         $.ajax({
                                    type: 'post',
                                    url: "<?= base_url('admin/livestream/get_subject');?>",
                                    data: {order_id:id},
                                    success: function (data) 
                                    {
                                       var res =  $.parseJSON(data);
                                       if(res.status)
                                           {
                                            
                                             var option = `<option value = "" >Select Subject</option>`;
                                                 for (var i = 0; i < res.body.length; i++) 
                                                       { 
                                                         option += `<option value = "`+res.body[i].id+`" >`+res.body[i].name+`</option>`;     
                                                       }
                                                   $('#subject').html(option);    

                                           }else{
                                               
                                                         $('.msg').parent().css('background-color', 'red');
                                                          $('.msg').html(res.msg);   
                                                
                                                      $('#msg_Modal').modal('show');
                                                      setTimeout(function(){$('#msg_Modal').modal('hide');   return false;},5000);
                                                 }
                                               
                                               
                                           }
                                });
                });
          $('body').on('change','#subject',function() 
                {
            
                      var subject = $(this).val();   
                      
                      var class_id = $('#my_class').val();   
                        
                      //  alert("jk == "+id);
                         $.ajax({
                                    type: 'post',
                                    url: "<?= base_url('admin/livestream/get_chapter');?>",
                                    data: {subject:subject,class_id:class_id},
                                    success: function (data) 
                                    {
                                       var res =  $.parseJSON(data);
                                       if(res.status)
                                           {
                                            
                                             var option = `<option value = "" >Select Chapter</option>`;
                                                 for (var i = 0; i < res.body.length; i++) 
                                                       { 
                                                         option += `<option value = "`+res.body[i].id+`" >`+res.body[i].name+`</option>`;     
                                                       }
                                                   $('#chapter').html(option);    

                                           }else{
                                               
                                                         $('.msg').parent().css('background-color', 'red');
                                                          $('.msg').html(res.msg);   
                                                
                                                      $('#msg_Modal').modal('show');
                                                      setTimeout(function(){$('#msg_Modal').modal('hide');   return false;},5000);
                                                 }
                                               
                                               
                                           }
                                });
                });
       //Formdata         
         $('body').on('submit','#Formdata',function() 
                {          
                     event.preventDefault();
                   //  $('#submit').prop('disabled', true);
                
                  $.ajax({    
                        type: 'post',
                        url: "<?= base_url('admin/livestream/add_Meeting');?>",
                        //data:$(this).serialize(),
                        data:new FormData(this),
                       processData: false,
                       contentType: false,
                        success: function (data) {
                          var res =  $.parseJSON(data);
                              if(res.status)
                                {
                                       $('.msg').parent().css('background-color', 'green'); 
                                       $('#Formdata').trigger("reset");
                                }else{
                                        $('.msg').parent().css('background-color', 'red');
                                }
                             $('.msg').html(res.msg);   
                                                
                              $('#msg_Modal').modal('show');
                              setTimeout(function(){$('#msg_Modal').modal('hide');   return false;},5000);
                           
                                
                        }           
                  });
                
                });
                
          $(document).ready(function(){
                        
                      // setTimeout(function(){ alert("Hello"); }, 3000);
                    });      
                
                
</script>
        



 <script src="https://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />  
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<script>
   /* $( "#startdate" ).datepicker({
                changeMonth: true,
                changeYear: true,
                firstDay: 1,
                dateFormat: 'dd/mm/yy',
                });
                
       
$( "#startdate" ).datepicker({ dateFormat: 'dd-mm-yy' });  */  
   $(function () {
                var $dp1 = $("#startdate");
                $dp1.datepicker({
                    changeYear: true,
                    changeMonth: true,
                    dateFormat: "dd/m/yy",
                    yearRange: "-100:+20",
                    minDate: '0'
                });
                
                var $dp2 = $("#todate");
                $dp2.datepicker({
                    changeYear: true,
                    changeMonth: true,
                    yearRange: "-100:+20",
                    dateFormat: "dd/m/yy",
                    minDate: '0'
                });
            });
</script>

<!--</div>-->
</div>