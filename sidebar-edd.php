<?php
/**
 * The Sidebar containing the EDD widget areas.
 */
?>
	<div id="secondary" class="widget-area" role="complementary">
		<div class="widget product-info-wrapper">
			<div class="product-sidebar-price">
				<?php if ( edd_has_variable_prices( get_the_ID() ) ) : ?>
					<span class="widget-title"><?php _e( 'Starting at:', 'edds'); edd_price( get_the_ID() ); ?></span>						
				<?php elseif ( '0' != edd_get_download_price( get_the_ID() ) && !edd_has_variable_prices( get_the_ID() ) ) : ?>	
					<span class="widget-title"><?php _e( 'Price:', 'edds' ); edd_price( get_the_ID() ); ?></span> 
				<?php else : ?>
					<span class="widget-title"><?php _e( 'Free','edds' ); ?></span>
				<?php endif;  ?>
			</div>	
			<div class="product-download-buy-button">
				<?php echo edd_get_purchase_link( array( 'id' => get_the_ID() ) ); ?>
			</div>
		</div>
		<?php if ( is_active_sidebar( 'sidebar-edd' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar-edd' ); ?>
		<?php else : ?>
			<?php dynamic_sidebar( 'sidebar-primary' ); ?>
		<?php endif; ?>
	</div>
