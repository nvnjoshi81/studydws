<div class="container order_conf">Please wait...  <img style="width:50px" src="<?php echo base_url('assets/images/loading_spinner.gif') ?>" alt="Please Wait ..."></div>
<div class="container order_conf" >
  <div class="row">Your transaction has been declined.
      Transection Failed due to some or other reason.
  </div>
  <div class="row">
  <button onclick="return goToAppFailed()">Try Again  </button>
</div>
<script>
function goToAppFailed(){
	return 'failed';
}
</script>
    