<?php
/*
 * Template Name: FES Dashboard
 */
get_header(); ?>

	<div id="fes-primary" class="content-area">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content/content', 'fes-dashboard' ); ?>

		<?php endwhile; // end of the loop. ?>

	</div>

<?php get_footer(); ?>