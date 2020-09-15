<div id="page-wrapper">   


    <div class="row">
        <div class="col-lg-12">
        <h1>Add Notification<span class="pull-right"><a class="btn btn-primary" href="<?php echo base_url('admin/notification');?>">Notification List</a></span></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <form role="form" id="media-form" class="contact-form" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/notification/submitadd'); ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group"><label>Display Title</label>
                        <input type="text" class="form-control" name="title" autocomplete="off" id="title" placeholder="Title" value="">
                    </div>
                </div>

            </div>
			
				<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
<?php  
             
$content_type_exam_id=0;                 
?><label>Select Exam</label><?php
echo generateSelectBox('class_id', $exams, 'id', 'name', 1 , 'class="form-control"',$content_type_exam_id); 
?>
                </div>
                </div>
            </div>
			   <div class="row">
                <div class="col-md-6">
            <div class="form-group"><label>Content Type</label>	
<?php
	echo generateSelectBox('content_type', $contentArray, 'id', 'name', 1 , 'class="form-control"',$mediaResult->content_type); 
?>
			</div>
			</div>
			</div>

<div class="row">
                <div class="col-md-6">
            <div class="form-group"><label>Notification Type</label>	
<?php
	//echo generateSelectBox('content_type', $contentArray, 'id', 'name', 1 , 'class="form-control"',$mediaResult->content_type); 
?>

<select name="noti_type" id="noti_type" class="form-control">
<option value="0">Select Type..</option>
<option value="Web">Web</option>
<option value="app">App</option>
</select>
			</div>
			</div>
			</div>

			
			<div class="row">
                <div class="col-md-6">
                    <div class="form-group"><label>package id</label>
                        <input type="text" class="form-control" name="packageid" autocomplete="off" id="packageid" placeholder="packageid" value="">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea class="form-control textarea" rows="3" name="description" id="description" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
            <!--<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="briefing_doc">Select Image (Only JPG)</label>
                        <div class="col-md-4">
                            <input id="mediaimage" name="mediaimage" class="input-file" type="file">
                        </div>
                    </div>
                </div>
            </div>
            
            
            
             <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="briefing_doc">Select Big Image (Only JPG)</label>
                        <div class="col-md-4">
                            <input id="mediaimage_big" name="mediaimage_big" class="input-file" type="file">
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary pull-right">Add Content</button>
                </div>
            </div>
        </form>
    </div>


</div>
