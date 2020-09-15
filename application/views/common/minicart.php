<div id="cartpanel" class="cartpanel">
    <a href="<?php echo $this->config->item('web_root');?>shopping/shopping_cart.php">
        <img alt="cart" src="<?php echo $this->config->item('web_root');?>study_images/cart_img.png">
    </a>
    CART
    <span> [
        <button onclick="location.href ='<?php echo $this->config->item('web_root');?>shopping/shopping_cart.php';">
            <?php echo $customer_basket?count($customer_basket):'0';?> item &nbsp;
            <img src="<?php echo $this->config->item('web_root');?>images/wtrs.png">
            <?php echo $cart_price;?>
        </button>
    ]</span>
    <span>Wallet Balance:<img src="<?php echo $this->config->item('web_root');?>images/wtrs.png">
    <?php echo count($customer_info)>0?$customer_info->regi_point:0; ?>
    </span>
</div>