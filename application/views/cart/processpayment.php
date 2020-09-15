<form id="myAvenues" name="myAvenues"  method="post" action="<?php echo $action;?>">
<!--<input type="hidden" name="encRequest" value="<?php //echo $parameters; ?>">;
<input type="hidden" name="Merchant_Id" value="<?php //echo $merchant_parameters; ?>" >
-->
<?php 
$key_order_id=$order_no;
$key_amount=$final_amount;    

    foreach($parameters as $key=>$value){ ?>
    <input type="hidden" name="<?php echo $key?>" value="<?php echo $value;?>">
    <?php
    if($key=='Order_Id'){
    $key_order_id=$value;
    }
     if($key=='Amount'){
    $key_amount=$value;
    }
    }
 
?> <div class="container order_conf">Please wait you are being redirected...  <img style="width:50px" src="<?php echo base_url('assets/images/loading_spinner.gif') ?>" alt="Please Wait ..."></div><span>If You are not redirected  Please click submit button bellow.</span><input type="submit" name="MenualProceed" value="Proceed...">

</form> 

<script>
document.myAvenues.submit();
</script>
<?php 
$showOld='no';
if($showOld=='yes'){ ?>
<script>
//Google Analytical code Start
/*    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-40859911-1', 'studyadda.com');
ga('send', 'pageview');

    ga('require', 'ecommerce');
    ga('ecommerce:addTransaction', {
  'id': '<?php echo $key_order_id; ?>',                     // Transaction ID. Required.
  'affiliation': 'Studyadda',   // Affiliation or store name.
  'revenue': '<?php echo $key_amount; ?>',               // Grand Total.
        'shipping': '0', // Shipping.
        'tax': '0'                     // Tax.
    });
    ga('ecommerce:send');
    ga('ecommerce:clear');
    
    //Google Analytical code End
    document.myAvenues.submit();
	*/
</script>
<?php } ?>
