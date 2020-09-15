<div class="container">
            <div class="row">
            
            <?php if($this->session->flashdata('update_msg')){ ?>
			<div class="alert alert-danger alert-dismissible" id="success-alert" role="alert">
			  
			  <strong><?php echo $this->session->flashdata('update_msg'); ?></strong>
			</div>
			<?php } ?> 
            <div class="col-md-3 col-sm-3 my_account"> 
   
    <?php $this->load->view('customer/menu'); ?>


 
    
    
    </div>
            
            
            
           
    <div class="col-sm-9 col-sm-9 wishlist_right main">
	<?php if($product_wishlist){ ?>
    <div class="my-account">
		<div class="page-title">
			<h1>WishList</h1>
		</div>
        
        
        <table class="table ">
    <thead>
      <tr>
        <th>Product	</th>
        <th>Product Details</th>
        <th>Price</th>
       
      </tr>
    </thead>
    <tbody>
	<?php foreach($product_wishlist as $row){ ?>
      <tr>
        <td><?php echo show_thumb($row->image,200,200,'class="media-object" alt="'.$row->name.'"')?></td>
        <td><p><?php echo $row->name; ?></p>
        <!--<div class="price"> 
					Rs. <?php //echo $row->price; ?>
				</div>--> 
				<div class="lu-status">
					<?php if($row->available_qty > 1){ ?>				
					<p><strong>In Stock.</strong></p>
					
					Delivered in 7-8 business days. 
				</div> 
				<div class="add_to_cart_cont"> 
					<button name="btnAddToCart" class="btn btn-success btn-xs addtocart"  itemqty="1" itemid="<?php echo $row->pro_id;?>" itemprice="<?php echo $row->price;?>" itemname="<?php echo $row->name;?>" >Add to cart</button>
					</div>
					<?php } else{?>
					<p><strong>Out Of Stock.</strong></p>
					<?php } ?>
					<p><strong><a style="cursor:pointer" href="<?php echo base_url() ?>customer/removeWishlist/<?php echo $row->wishlist_id; ?>/<?php echo url_title($row->name,'-',true); ?>" onClick="return confirm('Are you sure you want to remove this item from wishlist?')" title="Remove from wishlist">Remove item from wishlist</a></strong></p>
         </td>
        <td><strong><?php echo $this->config->item('currency'); ?><?php echo $row->price; ?></strong></td>
        
      </tr>
	<?php } ?>
      
    </tbody>
  </table>
        
        
		
		
		 
			
			
			
			
			
			
       
		
		
		
	</div>
	<?php } else { ?>
	<div class="col-md-12 center">
         
         <div class="jumbotron text-center">
            <h3>You have no items in your wishlist !</h3>
            <p><a class="btn btn-primary btn-lg" href="<?php echo base_url()?>" role="button">Continue Shopping</a></p>
         </div>
      </div>
	<?php }?>
            
            </div>
            
            
            
            
            
      
                
            </div>
            
           
        </div>
    