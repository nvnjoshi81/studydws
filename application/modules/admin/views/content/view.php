<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $type->name;?></h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <?php if(isset($results)&&(count($results)>0)){ ?>
                    <div class="dataTable_wrapper table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach($results as $result){?>
                                <tr class="odd gradeX">
                                    <td><?php echo $result->id; ?></td>
                                    <td><?php if(isset($result->name)) { echo $result->name;}?></td>
                                    <td><?php  ?></td>
                                    <td class="center">
                                        <!--<a href="<?php echo base_url(); ?>admin/content/edit/<?php echo $contenttype->id; ?>" ><i class="fa fa-edit cat-edit" ></i></a>
                                        <a href="<?php echo base_url(); ?>admin/content/delete/<?php echo $contenttype->id;?>"><i class="fa fa-trash cat-del"></i></a>
                                        <a href="<?php echo base_url(); ?>admin/content/view/<?php echo $contenttype->id;?>"><i class="fa fa-file cat-list"></i></a>-->
                                    </td>
                                </tr>
                            <?php } ?>                  
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <?php  echo "<h6><b>";
                                            echo $data["links"] = $this->pagination->create_links()."</b></h6>";?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php }else{
                        ?>
                    <div>No Result found!</div>    
                        <?php
                        
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
