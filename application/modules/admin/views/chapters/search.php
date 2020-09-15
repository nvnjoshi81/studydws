<div id="page-wrapper">
    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Search Chapters</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
    <div class="row">
                <div class="col-sm-9">
                     <div class="col-sm-6">
                    <form method="post" action="<?php echo base_url('admin/chapters/search')?>">
            
               
                    <div class="input-group custom-search-form">
                        <input type="text" placeholder="Search..." class="form-control" name="search">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>                        
        </form> 
                         </div>
                         <div class="col-sm-6">
                               <form method="post" action="<?php echo base_url('admin/chapters/search')?>">
            
               
                    <div class="input-group custom-search-form">
                        <input type="text" placeholder="Search..." class="form-control" name="searchid">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>                        
        </form>
                         </div>
                </div>
            <div class="col-sm-3">
            <a href="<?php echo base_url('admin/chapters')?>" class="btn btn-success pull-right new-acc">View All Chapters</a>
            

            </div>
            </div> 
    <div class="row">
<div class="col-lg-12">
                    
                    <div class="panel">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr><th>Id. </th>
                                            <th>Chapter</th>
                                             <th>Class</th>
                                            <th>Subject</th>
                                            <th>Order</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                <?php
$i = 1;
if (isset($chapters)) {

	foreach ($chapters as $chapter) { 

// print_r($chapters);
	?>
       
                                        
                                <tr class="odd gradeX">
                                    <td><?php echo $chapter['id'];?></td>
                                    <td><?php if (isset($chapter['name'])) {
                                            echo $chapter['name'];
                                            }
                                        ?>
                                    </td>
                                 
                                        
                                    <td><?php
                                    if (isset($chapter['classes'])) {
                                                echo $chapter['classes'];
                                            }
									?></td>
                                    <td><?php
                                    if (isset($chapter['subjects'])) {
                                                echo $chapter['subjects'];
                                            }
									?></td>
                                       <td><?php
                                            if (isset($chapter['order'])) {
                                                echo $chapter['order'];
                                            }
                                        ?> 
                                        
                                        </td>
                                    <td class="center">
                                        
                                        <a href="<?php echo base_url();?>admin/chapters/edit/<?php echo $chapter['id'];?>" >
                                            <i class="fa fa-edit cat-edit" ></i>
                                        </a>
                                     
                                        <a href="<?php echo base_url(); ?>admin/chapters/delete/<?php echo $chapter['id'];?>">
                                            <i class="fa fa-trash cat-del"></i>
                                        </a>
                                        
    <div style="display:none;" id="name-<?php echo $chapter['id'];?>">
        <?php echo $chapter['name'];?>
    </div>
    <div style="display:none;" id="desc-<?php echo $chapter['id'];?>">
        <?php echo $chapter['description'];?>
    </div>
</td>
</tr>
                <?php
        $i++;

    }
}
?>                          
                                        
                                 </tbody>
                                 <tfoot>
                                     <tr>
                                         <td colspan="6">
                                             <?php
echo "<h6><b>";
echo $data["links"] = $this->pagination->create_links() . "</b></h6>";
?>
                                        </td>
                                     </tr>
                                 </tfoot>
                               </table>
                            </div>
                            <!-- /.table-responsive -->
                            
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
    </div>
</div>