<?php
/**
 * the closing of the main content elements and the footer element
 */
?>

			</div>
		</div>
	</div>

	<div class="footer-area full">
		<div class="main">
			<footer id="colophon" class="site-footer inner" role="contentinfo">
				<span class="site-info">
					<?php 
						if ( get_theme_mod( 'edds_credits_copyright' ) ) :
							echo wpautop( get_theme_mod( 'edds_credits_copyright' ) );
						else : 
							echo get_bloginfo( 'name' ) . ' &copy; ' . date( 'Y' ) . ' - ' . get_bloginfo( 'description' );
						endif;
					?>
				</span>
			</footer>
		</div>
	</div>

	<?php wp_footer(); ?>

</body>
</html>