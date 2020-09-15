<form name="paytmgetaway" method="post" action="<?php echo $PAYTM_TXN_URL;?>">
<?php
			foreach($parameters as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
?>
</form>
<script>//document.paytmgetaway.submit();</script>