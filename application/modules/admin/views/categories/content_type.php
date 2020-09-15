<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Manage content type for  - <?php echo $category->name;?></h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover">
            <?php foreach($content_type as $type){ 
            if(isset($ccarray) && isset($ccarray[$type->id])){ ?>
                <form action="<?php echo base_url(); ?>admin/categories/updatecontent" method="post">
                    <input type="hidden" name="content_type_id" value="<?php echo $type->id;?>">
                    <input type="hidden" name="category_id" value="<?php echo $category->id;?>">
                    <input type="hidden" name="faction" id="faction" value="update">
                <tr>
                    <td><?php echo $type->name?></td>
                    <td><input type="text" name="content_link" value="<?php echo $ccarray[$type->id]?>"></td>
                    <td>
                        <button  type="submit" class="btn btn-primary">Update</button>
                        <button  type="submit" class="btn btn-danger" onclick="$('#faction').val('del');">Remove</button>  
                    </td>
                </tr>
                </form>
            <?php }else{    
            ?><form action="<?php echo base_url(); ?>admin/categories/addcontent" method="post">
                <input type="hidden" name="content_type_id" value="<?php echo $type->id;?>">
                <input type="hidden" name="category_id" value="<?php echo $category->id;?>">
                <tr>
                    <td><?php echo $type->name?></td>
                    <td><input type="text" name="content_link" value=""></td>
                    <td><button type="submit" class="btn btn-primary">Add</button></td>
                </tr>
            </form>
            <?php 
            }
            }?>
            </table>
        </div>
    </div>
</div>