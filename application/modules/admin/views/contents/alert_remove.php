<div id="page-wrapper" class="row">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Confirmation for Delete</h1>
        </div>
    <!--Other Section-->
    <div class="form-group">
        <h1 style="color:red" class="page-header">This action will delete Question and Answer from online test ,Solved Paper and Sample Paper if they are connected.Are you sure you want to delete now. </h1>
        
<form method="post" id="tagform" action="<?php echo base_url('/admin/Contents/').'/'.$form_action?>" />

        <input type='hidden' name='form_action' value='<?php echo $form_action ?>'>
        <input type='hidden' name='questionbank_type_id' value='<?php echo $questionbank_type_id ?>'>       
        <input type='hidden' name='questionbank_id' value='<?php echo $questionbank_id ?>'>
        <?php foreach($inner_item_id as $innerid){ ?>
        <input type='hidden' name='inner_item_id[]' value='<?php echo $innerid ?>'>
        <?php } ?>
        <input type='hidden' name='main_chapter_id' value='<?php echo $main_chapter_id ?>'> 
        <input type='hidden' name='main_subject_id' value='<?php echo $main_subject_id ?>'>
        <input type='hidden' name='main_exam_id' value='<?php echo $main_exam_id ?>'>
<div class="modal-footer">
    <button type="submit" class="btn btn-default">Delete Now</button>
</div>
</form>
    </div>
</div>
</div>