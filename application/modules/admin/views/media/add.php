<div id="page-wrapper">   


    <div class="row">
        <div class="col-lg-12">
            <h1>Add Media<span class="pull-right"><a class="btn btn-primary" href="<?php echo base_url('admin/media');?>">Media List</a></span></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <form role="form" id="media-form" class="contact-form" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/media/submitadd'); ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" autocomplete="off" id="title" placeholder="Title">
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
             <div class="row">
                <div class="col-md-6">Ex:Sep 15, 2015
                    <div class="form-group">
                         <input type="text" class="form-control" name="date" autocomplete="off" id="date" placeholder="Date">
                    </div>
                </div>
            </div>
            
            <div class="row">
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
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary pull-right">Add Content</button>
                </div>
            </div>
        </form>
    </div>


</div>
