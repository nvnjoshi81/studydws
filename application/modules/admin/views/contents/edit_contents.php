    <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Edit Contents Name</b></h4>
        </div>
        <div class="modal-body">
          <p><b>Enter Contents Name</b></p>
            <div class="form-group has-success label-floating is-empty">
                        <label class="control-label" for="name">Name</label>
                        <input class="form-control" type="text" name="contents_name" id="contents_name" value="<?php echo $contents_name; ?>" required >
                        <input class="form-control" type="hidden" name="module_type_id" id="module_type_id" value="<?php echo $module_type_id; ?>" >
                        <input class="form-control" type="hidden" name="module_id" id="module_id" value="<?php echo $module_id; ?>" >
            </div> 
                  
        </div>
        <div class="modal-footer">
            <button type="submit" id="edit_contentsname" class="btn btn-raised btn-warning">Update</button>
        </div>