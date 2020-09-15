<div id="wrapper">
    <div class="container">
        <div class="row">
             <?php
             //$this->load->view('common/breadcrumb');?>
    <div class="col-md-12 col-sm-12 onlinetestbody">
            <div id="page-inner">
                <div class="module_panel row">  
                <div class="col-sm-12 col-md-9">                
                  <!-- content panel start here -->
                  <div class="col-sm-12 col-md-12 online_btn_test">
                  <div class="col-sm-6 col-md-6">
              <?php             
        $customer_id = $this->session->userdata('customer_id');
        if(!isset($customer_id)&&($customer_id=='')){
            ?>       
              <span class="ts-btn">
              <a href="<?php echo base_url('login')?>" >
                  <button type="button" class=" btn-md btn btn-success btn-raised btn-lg searchgo">Login to View Result</button>
              </a>
              </span>
        <?php  
		   redirect(base_url('/login')); 
		}else{
          
        }
        ?>
        </div>                      
        </div>    
                 <?php if(isset($customer_id)&&($customer_id!='')){ ?> 
                  <div class="col-sm-12 col-md-12">
                  <div class="panel panel-success">
                  <div class="panel-heading">
                 	 <h4><i class="material-icons">folder</i> Test Attempted By Me </h4>
                     </div>
                     <ul class="row startexampanel">
<?php 
foreach($usertest_info as $testvalue){
    echo "<li class='col-xs-12 col-sm-6 col-md-6'><i class='material-icons'>update</i>  <a href='".base_url('online-test/result/'.$testvalue->id)."' >".$testvalue->name."</a></li>";
    
}
?>
                  </ul>                  </div>
                  </div>   
                 <?php }else{
					 ?>
					    <div class="col-sm-12 col-md-12">
                  <div class="panel panel-success">
                  <div class="panel-heading">
                 	 <h4><i class="material-icons">folder</i>You have not attempted Any Test.</h4>
                     </div>
					 </div>
					 </div>
					 <?php
				 } ?>  
                  </div> 
<div class="col-sm-12 col-md-3">  
                  <!-- right panel -->
                <div class="rht_status_mat">
<?php if(isset($userGroup)&&count($userGroup)>0){ 
?>
                    <div class="panel panel-primary">
                	<div class="panel-heading">
                            <h4> <i class="material-icons">book</i>Group Wise Result</h4>
                        </div>
                	<div class="panel-body">
                            <ul>
							    <li><i class="material-icons">&#xE037;</i> <a href="#"><span class="text-warning"></span>Current  Group-<b><?php echo $userGroup[0]->name; ?></b></a></li>
                                <li><i class="material-icons">&#xE037;</i><a href="#"> <span class="text-warning"></span>Total Student-<b><?php echo count($usersOfGroup); ?></b></a></li>
                            </ul>
                        </div>
                    </div>
                   <?php } ?>
                    <div class="hidden-xs hidden-sm right_advertisepanel"><img alt="adversite" src="<?php echo base_url('assets/images/150adv_2.jpg')?>">
                    </div>
                     
                </div>
                </div> 
    </div>
             <!-- /. PAGE INNER  -->
            </div>
</div>
</div>
</div>
