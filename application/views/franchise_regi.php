<div id="wrapper">
  <div class="container">
    <div class="row">
      <?php $this->load->view('common/breadcrumb');?>
      <div class="col-md-12 col-sm-12">
        <div id="page-inner">
          <div class="module_panel row"> 
              <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
        ?>
            <!-- content panel start here -->
            <!-- left panel -->
              <div class="container ">   
                   <div class="col-md-10 col-sm-12">
                    <h2>Franchise Application :</h2>
                   </div>
    <div class="panel-group col-md-10 col-sm-12">
                                <div id="mainlogin" class="col-md-12"><p class="required text-left text-warning" style="text-align:right;">* Required Fields</p>
                                    <?php //echo base_url().'common/jobs_info contact_info'; ?>
                                            <form id="franchForm" name="franchForm" method="post" action="<?php echo base_url(); ?>common/jobs_info" enctype="multipart/form-data">
                                  <div class="row">
                                    <div class="form-group has-success label-floating is-empty col-xs-6 col-sm-6 col-md-6">
                                        <label for="guestname" class="control-label">Full Name<span class="required text-warning">*</span></label>
                                        <input type="hidden" name="type" value="franchise">
                                    
                                        <input type="text" id="guestname" class="form-control" name="guestname" required="required" value="">
                                    <span class="material-input"></span></div>                                    
                                    <div class="col-xs-6 col-sm-6 col-md-6 form-group has-success label-floating is-empty">
                                        <label for="email" class="control-label">Enter Email<span class="required text-warning">*</span> </label>
                                        <input type="email" id="enteremail" class="form-control" name="enteremail" required="required" value="">
                                    <span class="material-input"></span></div>                                    
                                    </div>
<div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 form-group has-success label-floating is-empty">
                                        <label for="Mobil" class="control-label">Enter Mobile<span class="required text-warning">*</span></label>
                                        <input type="text" id="fcontact" class="form-control" name="fcontact" required="required" value="">
                                    <span class="material-input"></span>
                                    </div>
       <div class="col-xs-6 col-sm-6 col-md-6 form-group has-success label-floating is-empty">
                                        <label for="description" class="control-label">Address<span class="required text-warning">*</span></label>
                                     <input type="text" id="youraddress" class="form-control" name="youraddress" required="required" value="">
                                    <span class="material-input"></span>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 form-group has-success label-floating is-empty">
                                        <label for="other" class="control-label">Background Details</label>
                                     <input type="text" id="other" class="form-control" name="other" value="">
                                    <span class="material-input"></span>
                                    </div>
            
    <div class="form-group has-success label-floating is-empty col-xs-6 col-sm-6 col-md-6">
                                          <label for="other" class="control-label">Working As</label>
                                        <select name="workingas" id="workingas" class="form-control"><option value=""></option>
                                            <option value="Salaried">Salaried</option>
                                            <option value="self-employed">Self-Employed</option>
                                        </select>
                                        
                                    <span class="material-input"></span>
                                    </div>
                                         
                                        
    <div class="form-group has-success label-floating col-xs-6 col-sm-6 col-md-6">
                                        <label for="academicProfile" class="control-label">Academic Profile</label>
                                        <input type="text" id="academicProfile" class="form-control" name="academicProfile" value="">
                                    <span class="material-input"></span>
    </div>
                                        
                                             
    <div class="form-group has-success label-floating col-xs-6 col-sm-6 col-md-6">
                                        <label for="investmentCapacity" class="control-label">Investment Capacity</label>
                                        <input type="text" id="investmentCapacity" class="form-control" name="investmentCapacity" value="">
                                    <span class="material-input"></span>
    </div>
        <div class="form-group has-success label-floating col-xs-6 col-sm-6 col-md-6">
                                        <label for="preferredCity " class="control-label">Preferred City</label>
                                        <input type="text" id="preferredCity" class="form-control" name="preferredCity" value="">
                                    <span class="material-input"></span>
    </div>                                             
                                        
                                     
    <div class="form-group has-success label-floating col-xs-6 col-sm-6 col-md-6">
                                        <label for="contactComment" class="control-label">Enter Comment</label>
                                        <input type="text" id="contactComment" class="form-control" name="contactComment" value="">
                                    <span class="material-input"></span>
    </div>

					   
<?php
$num1=rand(1,9); //Generate First number between 1 and 9  
$num2=rand(1,9); //Generate Second number between 1 and 9  
$captcha_total=$num1+$num2;

$this->session->set_userdata('franchise_num1',$num1);
$this->session->set_userdata('franchise_num2',$num2);
?>
		                           
    <div class="form-group has-success label-floating col-xs-6 col-sm-6 col-md-6">
                                        <label for="contactComment" class="control-label">Add Numbers <?php echo $num1; ?> + <?php echo $num2; ?> = </label>
                                        <input type="hidden" id="num1"  name="num1" value="<?php echo  $num1; ?>">
                                        <input type="hidden" id="num2"  name="num2" value="<?php echo  $num2; ?>">
                                        <input type="text" id="franchise_captcha_total" class="form-control" name="franchise_captcha_total" value="">
                                    <span class="material-input"></span>
    </div>
        <div class="form-group has-success label-floating is-empty col-xs-6 col-sm-6 col-md-6">
		<label for="other" class="control-label">Upload</label>
                                          <input type="text" placeholder="Upload" class="form-control" readonly="">
                                          <input type="file" id="inputFile" name="inputFile">
                                           <span class="material-input"></span>
        </div>              
                      </div>     
                       
		<button class="btn btn-raised btn-warning" type="submit">Submit</button>                                     

                                    </form>
                                </div> 
    </div>
    <!--/panel-group-->
     <!-- right panel -->
            <div class="hidden-xs hidden-sm col-md-2 rht_status_mat">
              <div class="right_advertisepanel"><img alt="adversite" src="<?php echo base_url('assets/images/260adv_2.jpg')?>"></div>
            </div>
</div>


            </div>
            </div>	
           
          </div>
          <!-- /. ROW  -->
    
        </div>
        <!-- /. PAGE INNER  -->
      </div>
    </div>
 