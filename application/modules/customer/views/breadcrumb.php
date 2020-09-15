<div class="col-md-12">
    <div class="col-md-7">
    <ol class="breadcrumb">
        <li>
             <a href="<?php echo base_url()?>"><i class="glyphicon glyphicon-home"></i></a>
        </li>
        <li>
             <a href="<?php echo base_url('customer')?>">My Account</a>
        </li>
        <li>
          <?php if($this->router->fetch_method()=='index') echo 'Dashboard';
          if($this->router->fetch_method()=='myaccount') echo 'Account Info';
          if($this->router->fetch_method()=='addaddress') echo 'Add Address';
          if($this->router->fetch_method()=='addressess') echo 'Address Book';
          if($this->router->fetch_method()=='orders' || $this->router->fetch_method()=='orderdetails') echo 'My Orders';
          if($this->router->fetch_method()=='tests') echo 'Online Test';
          if($this->router->fetch_method()=='library') echo 'Library';
          ?>
        </li>
        <?php if($this->router->fetch_method()=='orderdetails'){ 
            echo '<li>Order Details</li>';
        }
?>
    </ol>
    </div>
</div>
<div class="clearfix"></div>
 
<div class="col-md-12">
    <div class="heading-bar">
        <h1>
             <?php if($this->router->fetch_method()=='index') echo 'My Account';
          if($this->router->fetch_method()=='myaccount') echo 'Account Info';
          if($this->router->fetch_method()=='addaddress') echo 'Add Address';
          if($this->router->fetch_method()=='addressess') echo 'Address Book';
          if($this->router->fetch_method()=='orders' || $this->router->fetch_method()=='orderdetails') echo 'My Orders';
          
          ?>
            
        </h1>
        <span class="h-line"></span>
    </div>
</div>