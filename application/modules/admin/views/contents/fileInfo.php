    <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Edit Display Name</b></h4>
        </div>
        <div class="modal-body">
          <p><b>Enter Display Name</b></p>
            <div class="form-group has-success label-floating is-empty">
                        <label class="control-label" for="name">Name</label>
                        <input class="form-control" type="text" name="display_filename" id="display_filename" value="<?php echo $file_info->displayname; ?>" required >
                        
                        <label class="control-label" for="name">Common File Name</label>
                        <input class="form-control" type="text" name="common_filename" id="common_filename" value="<?php echo $file_info->filename; ?>" required >
                        
                        <input class="form-control" type="hidden" name="display_filename_id" id="display_filename_id" value="<?php echo $file_info->id; ?>" >
            </div> 
                  
        </div>
        <div class="modal-footer">
            <button type="submit" id="edit_displayname" class="btn btn-raised btn-warning">Update</button>
        </div>