<?php
/**
 * The template part used for displaying the FES Vendor Dashboard
 *
 * This template part is used by the edd_templates/fes-dashboard.php
 * page template. Page Template: FES Dashboard
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'edds' ),
				'after'  => '</div>',
			) );
		?>
	</div>
</article>
