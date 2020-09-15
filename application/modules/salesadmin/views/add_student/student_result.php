<div class="content">
    <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
		 $firstname=$this->session->userdata('firstname');
		 if(isset($firstname)){
		 $firstname=$this->session->userdata('firstname');
		 }else{
		$firstname=NULL;	 
		 }
		 $lastname=$this->session->userdata('lastname');
if(isset($lastname)){
		 $lastname=$this->session->userdata('lastname');
		 }else{
		$lastname=NULL;	 
		 }
		 $studentclass=$this->session->userdata('studentclass');		 
if(isset($studentclass)){
		 $studentclass=$this->session->userdata('studentclass');
		 }else{
		$studentclass=NULL;	 
		 } 
$emailstudent=$this->session->userdata('emailstudent');
if(isset($emailstudent)){
		 $emailstudent=$this->session->userdata('emailstudent');
		 }else{
		$emailstudent=NULL;	 
		 }
		 $mobilestudent=$this->session->userdata('mobilestudent');
if(isset($mobilestudent)){
		 $mobilestudent=$this->session->userdata('mobilestudent');
		 }else{
		$mobilestudent=NULL;	 
		 }
$studentschool_id=$this->session->userdata('studentschool_id');		 	 
if(isset($studentschool_id)){
		 $studentschool_id=$this->session->userdata('studentschool_id');
		 }else{
		 $studentschool_id=NULL;	 
		 } 
		 
        ?> 
		<div class="container-fluid">
          <div class="row">
		  <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <p class="card-category">Exams Given By Student</p>
                </div>
                <div class="card-body">
		<!--test result start-->  <div class="table-responsive">
		<?php

		if(isset($attempts)&&is_array($attempts)&&count($attempts)>0) { ?>
                    <table class="table table-hover table-responsive">
                        <thead> 
                            <tr>
                                <td colspan="8" class="overAllScore">
                                    <h4>All Attempts</h4>
                                </td> 
                            </tr>
                            <tr> 
                                <th>#</th> 
                                <th>Correct Ans</th> 
                                <th>Incorrect Ans</th>
                                <th>Reviewed Qus</th>  
                                <th>Not Attempted</th> 
                                <th>Total Qus</th> 
                                <th>Time Taken(Min)</th> 
                                <th>Score</th> 
								<th>Obtain Marks</th>
                                <th>Date</th> 
                                <th>Download</th> 
                            </tr> 
                        </thead>
                        <tbody>
                        <?php
						
                        $cc = 1; // Traverse result and generate report
                        $previous_score = 0;
                        foreach($attempts as $allrow) {
                            
                            //Solution for Division by zero.
                            if($allrow->obtain_marks>0){
                            $percentage=($allrow->obtain_marks / $allrow->total_marks)*100;
                            }else{
                            $percentage=NULL;    
                            }
                            $change = $previous_score - $percentage;
                        ?>
                        <tr>
                            <th><?php echo $cc; ?></th> 
                            <td><?php echo $allrow->correct_ans; ?></td> 
                            <td><?php echo $allrow->incorrect_ans; ?></td> 
                            <td><?php echo $allrow->reviewed_qus; ?></td> 
                            <td><?php 
							$not_att_qus=abs($allrow->not_attampted_qus);
							$att_ques=abs($allrow->attampted_ques); 
							$review_qus=abs($allrow->reviewed_qus);
							if(isset($not_att_qus)&&$not_att_qus>0){
								$row_notatt_q=$not_att_qus;
							}else{
								$row_notatt_q=0;
							}
							
							
							if(isset($review_qus)&&$review_qus>0){
								$row_reviewed_qus=$review_qus;
							}else{
								$row_reviewed_qus=0;
							}
							
							$total_not_attq=$row_notatt_q-$row_reviewed_qus;
							echo $total_not_attq;
							?></td>     
							<td><?php echo $allrow->total_qus; ?></td> 
                            <td><?php echo round($allrow->time_taken / 60, 1); ?></td> 
                            <td><?php echo round($percentage,2); ?>%</td> 
							<td><?php echo $allrow->obtain_marks.'/'.$allrow->total_marks; ?></td>
                            <td><?php echo date('d-m-Y',$allrow->dt_created); ?></td> 
							<?php
							$studentid=$allrow->user_id;
							$testid=$allrow->id;
							?>
                            <td><a href="<?php echo base_url($folder_admin.'/add_student/dresultxl/'.$studentid.'/'.$testid); ?>">
                                DOWNLOAD</a>
                            </td> 
                        </tr>
                        <?php 
                        $previous_score = $percentage;
                        $cc++;
                        } ?>
                    </tbody>
                </table>
		<?php }else{
			echo "Result not found!";
		}?>
            </div>
            <!--test result ends-->
            <div class="row">
                <div class="col-lg-12">
                    
                    <div class="panel">
                        <!-- /.panel-heading -->
                        <div class="table-responsive">
                            <div class="dataTable_wrapper">
							    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead class="text-primary">
                                 <th>
                                                Id. 
                                            <?php if($ordercol=='id'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=id&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=id&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url($folder_admin.'/Add_Order/')?>?col=id&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?>
                                            </th>
                                            <th>Name<?php if($ordercol=='firstname'){ 
                                                if($order=='desc'){ ?>
                                                    <a href="<?php echo current_url()?>?col=firstname&order=asc"><i class="fa fa-sort-desc pull-right"></i></a>
                                               <?php }else{ ?>
                                                   <a href="<?php echo current_url()?>?col=firstname&order=desc"><i class="fa fa-sort-asc pull-right"></i></a>
                                               <?php }
                                            }else{ ?>
                                                <a href="<?php echo base_url($folder_admin.'/Add_Order/')?>?col=firstname&order=asc"><i class="fa fa-sort pull-right"></i></a>
                                           <?php }?></th>
                                            <th>Date</th>              
                                            <th>Action</th>
                                    <tbody>
<?php
$i = 1;
if (isset($usertest_info)) {
	foreach ($usertest_info as $customer) { 

	
// print_r($chapters);
	?>
       <tr class="odd gradeX"><td><?php echo $i; ?></td>
                                    <td><?php echo $customer->name;?></td>
                                    
                                    <td><?php
                                            if (!empty($customer->dt_created)) {
                                                echo date('d/m/Y',$customer->dt_created);
                                            }
                                        ?> 
                                    </td>
                                    <td class="center">
									<a class="btn btn-primary" href="<?php echo base_url($folder_admin.'/add_student/showResult/'.$studentid.'/'.$customer->id);?>">Result</a>
<?php //$ferEncodeUrl=base_url().$folder_admin.'/add_order/productlist'; 
										$linkToUserAcc=base_url().'Common/FranchiseUser_login';
										?>
                                    </td>
       </tr>
                <?php
                $i++;
    }
}
?>                          </tbody>
                                 <tfoot>
                                     <tr>
                                         <td colspan="7">
<?php
echo "<h6><b>";
echo $this->pagination->create_links() . "</b></h6>";
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
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>   