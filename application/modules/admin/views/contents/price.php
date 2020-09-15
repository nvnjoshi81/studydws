
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Price</h4>
</div>
<div class="modal-body">
    <p></p>
    <p>
        <label>Product Name</label>
        <input type="text" name="modules_item_name1" value="<?php echo $price?$price->modules_item_name:''?>"  id="modules_item_name1"/>
    </p>
    <p>
        <label>Price</label>
            <input type="text" name="price1" value="<?php echo $price?$price->price:''?>"  id="price1"/>
    </p>
    <p>
            <label>Discounted Price</label>
            <input type="text" name="discounted_price1" value="<?php echo $price?$price->discounted_price:''?>"  id="discounted_price1"/>
    </p>      
    <?php if(isset($item_id)){
        ?>
            <input type='hidden' name='item_id' id='item_id' value='<?php echo $item_id?>'/>
            <?php
    } ?>
            <input type='hidden' name='faction1' id='faction1' value='<?php echo $price?$price->id:'0'?>'/>
            <input type='hidden' name='modules_item_id' id='modules_item_id' value='<?php echo $modules_item_id?>'/>
            <input type='hidden' name='exam_id1' id='exam_id1' value='<?php echo isset($relations)&&$relations->exam_id?$relations->exam_id:0?>'/>
            <input type='hidden' name='subject_id1' id='subject_id1' value='<?php echo isset($relations)&&$relations->subject_id?$relations->subject_id:0?>'/>
            <input type='hidden' name='chapter_id1' id='chapter_id1' value='<?php echo isset($relations)&&$relations->chapter_id?$relations->chapter_id:0?>'/>
            <input type='hidden' name='type1' id='type1' value='<?php echo $content_type->id?>'/>
            
        </p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <button type="button" id="updateprice" class="btn btn-primary">Update</button>
</div>

