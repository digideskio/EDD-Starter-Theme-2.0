<?php
/**
 * Custom functions that act independently of the theme templates
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function edds_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	
	if ( is_page_template( 'edd_templates/edd-store-front.php' ) ) {		
		$classes[] = 'edd-store-front-template';
	} elseif ( is_page_template( 'edd_templates/edd-checkout.php' ) ) {		
		$classes[] = 'edd-checkout-template';	
	} elseif ( is_page_template( 'edd_templates/edd-confirmation.php' ) ) {		
		$classes[] = 'edd-confirmation-template';
	} elseif ( is_page_template( 'edd_templates/edd-history.php' ) ) {		
		$classes[] = 'edd-history-template';
	} elseif ( is_page_template( 'edd_templates/edd-members.php' ) ) {		
		$classes[] = 'edd-members-template';
	} elseif ( is_page_template( 'edd_templates/edd-failed.php' ) ) {	
		$classes[] = 'edd-failed-template';				
	}

	return $classes;
}
add_filter( 'body_class', 'edds_body_classes' );


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function edds_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}
	
	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'edds' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'edds_wp_title', 10, 2 );


/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function edds_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'edds_setup_author' );


if ( !function_exists( 'edds_comment_template' ) ) :
/**
 * Used as a custom callback by wp_list_comments() for displaying
 * the comments and pings.
 */
function edds_comment_template( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$avatar_size = apply_filters( 'avatar_size', 48 );

	switch ( $comment->comment_type ) {

		// Pings format
		case 'pingback' :
		case 'trackback' : ?>
			<div class="pingback">
				<span>
					<?php
						echo __( 'Pingback: ', 'edds'),
						comment_author_link(),
						edit_comment_link( __(' (Edit) ', 'edds') ); 
					?>
				</span>
			<?php 
			break;

		// Comments format	
		default : ?>
			<div <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment-full">
					<footer class="comment-footer">
						<div class="comment-author vcard">
							<div class="comment-avatar">
								<?php echo get_avatar( $comment, $avatar_size ); ?>
							</div>
						</div>
						<?php
							if ( $comment->comment_approved == '0' ) : ?>
								<em><?php _e( 'Your comment is awaiting moderation.', 'edds' ); ?></em><br /> 
								<?php
							endif;
						?>
						<div class="comment-meta commentmetadata">
							<cite class="fn"><?php echo __( 'by ', 'edds' ) . get_comment_author_link(); ?></cite>
							<span class="comment-date">
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
									<time pubdate datetime="<?php comment_time( 'c' ); ?>"><?php echo get_comment_date(); // translators: 1: date, 2: time ?></time>
								</a>
								<?php edit_comment_link( __( ' (Edit) ', 'edds' ) ); ?>
							</span>
						</div>
					</footer>
					<div class="comment-content"> 
						<?php comment_text(); ?>
					</div>
					<div class="reply">
						<?php 
							comment_reply_link(
								array_merge( $args, array(
									'reply_text'	=> __( 'Reply', 'edds' ),
									'depth'			=> $depth, 
									'max_depth'		=> $args['max_depth'],
								) )
							);
						?>
					</div>
				</article>
			<?php
			break;
	}
}
endif;