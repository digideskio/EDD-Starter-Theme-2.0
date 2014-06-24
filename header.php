<?php
/**
 * the header element and the opening of the main content elements
 */
$title = get_bloginfo('name');
$tagline = get_bloginfo('description');
$char = get_bloginfo('charset');
$ping = get_bloginfo('pingback_url');
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php echo $char; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php echo $ping; ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div class="header-area full">
		<div class="main">
			<header id="masthead" class="site-header inner" role="banner">
				<span class="site-title">
					<?php if ( get_theme_mod( 'edds_logo' ) ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img src="<?php echo get_theme_mod( 'edds_logo' ); ?>" alt="<?php echo esc_attr( $title ); ?>">
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( $title ); ?>">
							<?php echo $title; ?>
						</a>
					<?php endif; ?>
				</span>
				<?php if ( get_theme_mod( 'edds_hide_tagline' ) != 1 ) : ?>
					<h1 class="site-description"><?php echo $tagline; ?></h1>
				<?php endif; ?>
				
				<?php if ( has_nav_menu( 'header' ) ) : ?>
					<nav id="header-navigation" class="header-menu" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'header', 'fallback_cb' => '__return_false' ) ); ?>
					</nav>
				<?php endif; ?>
			</header>
		</div>
	</div>

	<?php if ( has_nav_menu( 'main' ) ) : ?>
		<div class="main-menu-area full">
			<div class="main">
				<div class="main-menu-container inner">
					<nav id="site-navigation" class="main-navigation clear" role="navigation">
						<span class="menu-toggle"><?php echo '<i class="fa fa-bars"></i> ' . __( 'Menu', 'edds' ); ?></span>
						<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'edds' ); ?></a>
						<?php wp_nav_menu( array( 'theme_location' => 'main', 'fallback_cb' => '__return_false' ) ); ?>
					</nav>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="main-content-area full">
		<div class="main">
			<div id="content" class="site-content inner">