<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Admin Users</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <div class="col-sm-12">
            <a href="<?php echo base_url()?>admin/adminusers" class="btn btn-primary pull-right new-acc">View Users</a>
        </div>
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">
 <form  method="post" action="<?php echo base_url(); ?>admin/adminusers/<?php echo isset($adminuser)?'updateuser':'adduser'?>">
    
    <div class="form-group">
        <div class="col-lg-6">
        <label>First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo isset($adminuser)?$adminuser->first_name:''?>">
        </div>
        <div class="col-lg-6">
        <label>Last Name</label>
        <input type="text" class="form-control"  id="last_name" name="last_name" value="<?php echo isset($adminuser)?$adminuser->last_name:''?>">
        </div>
    </div>
  
    <div class="form-group">
        <div class="col-lg-6">
        <label>Email</label>
        <input type="text" class="form-control input-group-sm"  id="email" name="email" value="<?php echo isset($adminuser)?$adminuser->email:''?>">
        </div>
        <?php if(!isset($adminuser)){ ?>
        <div class="col-lg-6">
        <label>Password</label>
        <input type="text" class="form-control input-group-sm"  id="password" name="password" value="<?php echo generatePassword(8);?>">
        </div>
        <?php } ?>
    </div>
    <div class="form-group">
         <div class="col-lg-12">
        <h4>Permissions</h4>
       
        <div class="col-lg-6">
            <label>Modules</label>
            <?php foreach($menuitems as $menu){ ?>
            <p><input 
                    type="checkbox" 
                    name='moduleperms[]' 
                    value='<?php echo $menu->id?>'
                    <?php if(isset($cat) && count($mod) > 0 && in_array($menu->id, $mod)){ echo 'checked="checked"';} ?>
               >
                <?php echo $menu->title;?></p>
            <?php } ?>
        </div> 
        <div class="col-lg-6">
            <label>Categories</label>
            <?php foreach($categories as $category){ ?>
            <p><input 
                    type="checkbox" 
                    name='categoryperms[]' 
                    value='<?php echo $category->id?>'
                    <?php if(isset($cat) && count($cat) > 0 && in_array($category->id, $cat)){ echo 'checked="checked"';} ?>
                >
                <?php echo $category->name;?></p>
            <?php } ?>
        </div>
         </div>
    </div>
      <div class="form-group">
        <div class="col-lg-12">
        <?php if(isset($adminuser)){ ?>
          <input type="hidden" name="user_id" value="<?php echo $adminuser->id?>">  
         <button type="submit" class="btn btn-primary">Update User</button>
        <?php }else{ ?>
        <button type="submit" class="btn btn-primary">Add User</button>
        <?php } ?>
        </div>
    </div>
    <input type="hidden" name="type" value="2">
</form>
                       
                </div>
            </div>
        </div>
    </div>
</div>