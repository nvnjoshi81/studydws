             <div id="wrapper">
    <div class="container">
          <?php 
         if($this->session->flashdata('message')){
             ?>
             <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
            <?php 
         }
         ?>
             
               <div id="message_box" class="col-md-12 col-sm-12">
               </div>
        <div class="row">
          <?php $this->load->view('common/breadcrumb');?>            
        <!--
        <div class="col-md-3 col-sm-3">
            <?php //$this->load->view('common/leftnav');?>
        </div>
        -->
    <div class="col-md-12 col-sm-12">
            <div id="page-inner">
                <div class="module_panel row">                  
                  <!-- content panel start here -->
                  <!-- left panel -->
                  <div class="col-sm-12 col-md-12">
                  
                  <div class="col-md-12 cont_log">
                  <!--<div class="pull-right img-thumbnail contact-img"><img src="<?php echo base_url('assets/images/contact_img.jpg')?>" class="img-responsive" /></div>-->
                     <h3 class="text-danger">For general enquiry:- </h3>
<span>  
            <a href="mailto:info@studyadda.com">
            <i class="fa fa-envelope-square fa-2">
            </i>
            <h4>: info@studyadda.com</h4>
            </a>
</span>
<span>  
            <a href="mailto:jobs@studyadda.com">
            <i class="fa fa-envelope-square fa-2">
            </i>
            <h4>: jobs@studyadda.com</h4>
            </a>
</span>
<!--           <a href="tel:+91 6261036004">
           <i class="fa fa-phone-square fa-2">
           </i>
           <h4>: +91 6261036004</h4>
           </a> 
</span>-->
<br/>
                  </div>
                      <div class="col-md-12 cont_log">         			  
                                <div class="error-no2tice">
                                    <div id="error_box" class="oaerror danger" style="display:none;">
                                           </div>
                                          </div>
                                <div id="mainlogin" class="col-md-6">
                                    <?php //echo base_url().'common/jobs_info'; ?>
                                   <form id="contact_info" name="contact_info" method="post" action="" novalidate="novalidate" enctype="multipart/form-data">
                                    <input type="hidden"  name="type" value="contact">                                   
                                    <div class="form-group has-success label-floating is-empty">
                                        <label for="guestname" class="control-label">Full Name </label>
                                        <input type="text" id="guestname" class="form-control" name="guestname" required="required">
                                    <span class="material-input"></span></div>                                    
                                    <div class="form-group has-success label-floating is-empty">
                                        <label for="email" class="control-label">Enter Email </label>
                                        <input type="email" id="enteremail" class="form-control" name="enteremail" required>
                                    <span class="material-input"></span></div>                                    
                                     <div class="form-group has-success label-floating is-empty">
                                        <label for="exampleInputPassword1" class="control-label">Enter Contact </label>
                                        <input type="contact" id="contact" class="form-control" name="contact" required>
                                    <span class="material-input"></span>
                                     </div>    
                                    
                                     <div class="form-group has-success label-floating is-empty">
                                        <label for="contactComment" class="control-label">Enter Comment </label>
                                        <textarea id="contactComment" class="form-control" name="contactComment" ></textarea>
                                    <span class="material-input"></span>
                                     </div>
                                    <button class="btn btn-raised btn-warning" type="submit">Submit</button>                                     
                                    </form>
                                </div> 
                          <p class="required text-left text-warning" style="text-align:right;">* Required Fields</p>
                          </div>
                  </div>
                  <!-- right panel -->
                 <!--<div class="col-sm-12 col-md-3 rht_status_mat">
                 <div class="right_advertisepanel"><img alt="adversite" src="<?php //echo base_url('assets/images/260adv_2.jpg')?>"></div>
                     
                </div>-->
                 </div>
               <!-- /. ROW  -->
                 <hr>               
    </div>
             <!-- /. PAGE INNER  -->
            </div>
</div>
</div>
</div>