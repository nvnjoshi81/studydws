<div id="wrapper">
<div class="container">
            <div class="row">
            <?php if($this->session->flashdata('update_msg')){ ?>
			<div class="alert alert-success alert-dismissible" id="success-alert" role="alert">
			  
			  <strong><?php echo $this->session->flashdata('update_msg'); ?></strong>
			</div>
			<?php } ?>
            <?php $this->load->view('customer/breadcrumb');?>
            <div class="col-md-3 col-sm-3 my_account"> 
   
    <?php $this->load->view('customer/menu'); ?>



    
    
    
    </div>
            
            
            
            <div class="col-sm-9 my_account_right">
        <div class="my-account"><div class="dashboard">
    <!--<div class="page-title">
        <h1><i class="material-icons">account_circle</i>  Order History</h1>
    </div>-->
    <div class="subline-title">
			<h4>Recommended Search</h4>
		</div>
<?php if($my_orders){?>
<div data-example-id="togglable-tabs" class="bs-example bs-example-tabs">
   <!-- <ul role="tablist" class="nav nav-tabs" id="myTabs">
      <li class="active" role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="home-tab" href="#home">Recent orders</a></li>
      
    </ul>-->
    <div class="tab-content" id="myTabContent">
      <div aria-labelledby="home-tab" id="home" class="tab-pane fade in active" role="tabpanel">
      <div class="table-responsive">
			<table class="table table-hover">
    <thead>
      <tr>
        <th>Search Keyword</th>
        <th>Result</th>
        <th>Search Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
	<?php foreach($my_orders as $orders){ ?>
      <tr>
        <td><?php echo $orders->searchtxt; ?></td> 
        <td><?php echo $orders->results; ?></td>
        <td><?php echo $orders->search_dt; ?></td>      	
        <td><a href="<?php echo base_url(); ?>search/<?php echo $orders->searchtxt; ?>/all"><i class="fa fa-external-link-square" aria-hidden="true"></i></a></td>
      </tr>
	<?php } ?>
    </tbody>
  </table>
  </div>
  <?php echo '<div class="pagination" align="center">'.$this->pagination->create_links().'</div>'; ?>
      </div>
    </div>
  </div>
<?php } else{ echo "<b>You had not placed any order yet</b>";}?>

        </div></div>	</div>
             </div>
           
        </div>
</div>