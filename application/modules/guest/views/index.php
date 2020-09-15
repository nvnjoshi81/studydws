<style>
    .email_form{
        width:50%;
    }
</style>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb'); ?>

            <?php
            if ($this->session->flashdata('message')) {
                ?>
                <div class="alert alert-success"> <?php echo $this->session->flashdata('message') ?> </div>
                <?php
            }
            ?>
            <div class="col-sm-12">
                <div class="form-box" id="frm_box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Welcome Guest</h3>
                            <p>Fill in the form below to get instant access:</p> 
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-pencil"></i>
                        </div>
                    </div>
                    <div class="alert alert-danger alert-dismissible" id="err_msg" role="alert" style="display:none">
                    </div>
                     <form role="form" action="<?php echo base_url(); ?>api/customer/guest" method="post" id="guestform">
                    <div class="form-bottom frm_box col-sm-6">
                       
                            <div class="form-group1 form-group has-success label-floating is-empty">
                                <label for="firstname"><em>*</em>
                                    Name </label>
                                <input type="text" name="firstname" class="form-control" id="firstname">
                            </div>
                            <div class="form-group1 form-group has-success label-floating is-empty">
                                <label  for="email"><em>*</em>
                                    Email </label>
                                <input type="email" name="email" class="form-control" id="email">
                            </div>

                            <div class="form-group1 form-group has-success label-floating is-empty">
                                <label for="mobile"><em>*</em> Mobile </label>
                                <input type="text" name="mobile" class="form-control" id="mobile">

                            </div>

                            <div class="form-group1 form-group has-success label-floating is-empty">
                                <label  for="address_one"><em>*</em>
                                    Address:</label>
                                <input type="text" name="address_one" class="form-control" id="address_one">
                            </div>                 
                    </div>
                    <!--Address section start -->
                    <div class="form-bottom frm_box col-sm-6">


                        <div class="form-group1 form-group has-success label-floating is-empty">
                            <label for="pincode"><em>*</em> Pincode </label>
                            <input type="pincode" name="pincode" class="form-control" id="pincode">
                        </div>
                        <div class="form-group1 form-group has-success label-floating is-empty">
                            <label  for="state"><em>*</em> State </label>
                         <select class="form-control" name="state" id="state" onchange="getCity()">
                            <option value="">Please Select</option>
                           <?php foreach($states as $state){ ?>
                           <option value="<?php echo $state->id; ?>"><?php echo $state->state_name; ?></option>
                           <?php } ?>
                        </select>
                        </div>
                        <div class="form-group1 form-group has-success label-floating is-empty">
                            <label for="city"><em>*</em> City </label>
                           <select class="form-control" name="city" id="city">
                           </select>
 <?php
                            $random_number = rand(999, 9999);
                            $this->session->set_userdata("regi_session", $random_number);
                            $regi_session_value = $random_number;
                            ?>
                            <input type="hidden"  name="regi_session_input" value="<?php echo $regi_session_value; ?>">
                        </div>
                               <div class="form-group1 form-group has-success label-floating is-empty"><br>
                        <button class="btn btn-raised btn-info" type="submit">Continue</button>
                               </div>
    
                     
                    </div>
   </form>
                </div>



            </div>




        </div>

    </div>


</div>

