<?php if($allow){ ?>
<form method="post" id="tagform" action="<?php echo base_url('admin/contents/addtags')?>" />
<input name="selectedvalues" id="selectedvalues" type="hidden">
<input type="hidden" name="content_id" id="content_id" value="<?php echo $content_id;?>"/>
<input type="hidden" name="type" id="type" value="<?php echo $type;?>"/>
<input type="hidden" name="avatags" id="avatags" value="<?php echo implode(',',$availabletags);?>"/>
<?php 
$ctags=array();
if(isset($contenttags)){
    
    foreach($contenttags as $ctag){
        $ctags[]=$ctag->tag;
    }
    
}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Tags</h4>
</div>
<div class="modal-body">
    <p>Available Tags :<?php echo implode(',',$availabletags);?></p>
    <p><input type="text" name="tags" id="tags" value="<?php echo implode(',',$ctags);?>"></p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    
</div>
</form>
<?php }else{ ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Tags</h4>
</div>
<div class="modal-body">
        <p>There are no tags available.</p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    
</div>
<?php } ?>