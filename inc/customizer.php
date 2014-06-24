<?php
/**
 * Theme Customizer
 */
function edds_customize_register( $wp_customize ) {


	/** ===============
	 * Extends controls class to add textarea with description
	 */
	class EDDS_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public $description = '';
		public function render_content() { ?>
	
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="control-description"><?php echo esc_html( $this->description ); ?></div>
			<textarea rows="5" style="width:98%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
	
		<?php }
	}
	

	/** ===============
	 * Extends controls class to add descriptions to text input controls
	 */
	class EDDS_WP_Customize_Text_Control extends WP_Customize_Control {
		public $type = 'customtext';
		public $description = '';
		public function render_content() { ?>
		
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="control-description"><?php echo esc_html( $this->description ); ?></div>
			<input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
		</label>
		
		<?php }
	}
	

	/** ===============
	 * Site Title (Logo) & Tagline
	 */
	// section adjustments
	$wp_customize->get_section( 'title_tagline' )->title = __( 'Site Title (Logo) & Tagline', 'edds' );
	$wp_customize->get_section( 'title_tagline' )->priority = 10;
	
	//site title
	$wp_customize->get_control( 'blogname' )->priority = 10;
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	
	// tagline
	$wp_customize->get_control( 'blogdescription' )->priority = 30;
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	
	// logo uploader
	$wp_customize->add_setting( 'edds_logo', array( 'default' => null ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'edds_logo', array(
		'label'		=> __( 'Custom Site Logo (replaces title)', 'edds' ),
		'section'	=> 'title_tagline',
		'settings'	=> 'edds_logo',
		'priority'	=> 20
	) ) );	
	// hide the tagline?
	$wp_customize->add_setting( 'edds_hide_tagline', array( 
		'default' => 0,
		'sanitize_callback' => 'edds_sanitize_checkbox'  
	) );
	$wp_customize->add_control( 'edds_hide_tagline', array(
		'label'		=> __( 'Hide Tagline', 'edds' ),
		'section'	=> 'title_tagline',
		'priority'	=> 40,
		'type'      => 'checkbox',
	) );


	/** ===============
	 * Content Options
	 */
	$wp_customize->add_section( 'edds_content_section', array(
    	'title'       	=> __( 'Content Options', 'edds' ),
		'description' 	=> __( 'Adjust the display of content on your website. All options have a default value that can be left as-is but you are free to customize.', 'edds' ),
		'priority'   	=> 20,
	) );
	// post content
	$wp_customize->add_setting( 'edds_post_content', array( 
		'default'			=> 0,
		'sanitize_callback'	=> 'edds_sanitize_checkbox'  
	) );
	$wp_customize->add_control( 'edds_post_content', array(
		'label'		=> __( 'Display Post Excerpts', 'edds' ),
		'section'	=> 'edds_content_section',
		'priority'	=> 10,
		'type'      => 'checkbox',
	) );
	// read more link
	$wp_customize->get_setting( 'edds_read_more' )->transport = 'postMessage';
	$wp_customize->add_setting( 'edds_read_more', array(
		'default' => __( 'Read More &rarr;', 'edds' ),
		'sanitize_callback' => 'edds_sanitize_text' 
	) );		
	$wp_customize->add_control( new EDDS_WP_Customize_Text_Control( $wp_customize, 'edds_read_more', array(
	    'label' 	=> __( 'Excerpt & More Link Text', 'edds' ),
	    'section' 	=> 'edds_content_section',
		'settings' 	=> 'edds_read_more',
		'priority'	=> 20,
	) ) );
	// show featured images on feed?
	$wp_customize->add_setting( 'edds_featured_image', array( 
		'default' => 1,
		'sanitize_callback' => 'edds_sanitize_checkbox'  
	) );
	$wp_customize->add_control( 'edds_featured_image', array(
		'label'		=> __( 'Show Featured Images in post listings?', 'edds' ),
		'section'	=> 'edds_content_section',
		'priority'	=> 30,
		'type'      => 'checkbox',
	) );
	// show featured images on posts?
	$wp_customize->add_setting( 'edds_single_featured_image', array( 
		'default' => 1,
		'sanitize_callback' => 'edds_sanitize_checkbox'  
	) );
	$wp_customize->add_control( 'edds_single_featured_image', array(
		'label'		=> __( 'Show Featured Images on Single Posts?', 'edds' ),
		'section'	=> 'edds_content_section',
		'priority'	=> 40,
		'type'      => 'checkbox',
	) );
	// comments on pages?
	$wp_customize->add_setting( 'edds_page_comments', array( 
		'default' => 0,
		'sanitize_callback' => 'edds_sanitize_checkbox'  
	) );
	$wp_customize->add_control( 'edds_page_comments', array(
		'label'		=> __( 'Display Comments on Standard Pages?', 'edds' ),
		'section'	=> 'edds_content_section',
		'priority'	=> 50,
		'type'      => 'checkbox',
	) );
	// credits & copyright
	$wp_customize->get_setting( 'edds_credits_copyright' )->transport = 'postMessage';
	$wp_customize->add_setting( 'edds_credits_copyright', array( 
		'default' => null,
		'sanitize_callback'	=> 'edds_sanitize_textarea',
	) );
	$wp_customize->add_control( new EDDS_Customize_Textarea_Control( $wp_customize, 'edds_credits_copyright', array(
		'label'		=> __( 'Footer Credits & Copyright', 'edds' ),
		'section'	=> 'edds_content_section',
		'settings'	=> 'edds_credits_copyright',
		'priority'	=> 60,
		'description'	=> __( 'Displays tagline, site title, copyright, and year by default. Allowed tags: <img>, <a>, <div>, <span>, <blockquote>, <p>, <em>, <strong>, <form>, <input>, <br>, <s>, <i>, <b>', 'edds' ),
	) ) );
	
	
	/** ===============
	 * Easy Digital Downloads Options
	 */
	// only if EDD is activated
	if ( class_exists( 'Easy_Digital_Downloads' ) ) {
		$wp_customize->add_section( 'edds_edd_options', array(
	    	'title'       	=> __( 'Easy Digital Downloads', 'edds' ),
			'description' 	=> __( 'All other EDD options are under Dashboard => Downloads. If you deactivate EDD, these options will no longer appear.', 'edds' ),
			'priority'   	=> 30,
		) );
		// show comments on downloads?
		$wp_customize->add_setting( 'edds_download_comments', array( 
			'default' => 0,
			'sanitize_callback' => 'edds_sanitize_checkbox'  
		) );
		$wp_customize->add_control( 'edds_download_comments', array(
			'label'		=> __( 'Comments on Downloads?', 'edds' ),
			'section'	=> 'edds_edd_options',
			'priority'	=> 10,
			'type'      => 'checkbox',
		) );
		// store front/downloads archive headline
		$wp_customize->get_setting( 'edds_edd_store_archives_title' )->transport = 'postMessage';
		$wp_customize->add_setting( 'edds_edd_store_archives_title', array( 
			'default' => null,
			'sanitize_callback' => 'edds_sanitize_text' 
		) );
		$wp_customize->add_control( new EDDS_WP_Customize_Text_Control( $wp_customize, 'edds_edd_store_archives_title', array(
			'label'		=> __( 'Store Front Main Title', 'edds' ),
			'section'	=> 'edds_edd_options',
			'settings'	=> 'edds_edd_store_archives_title',
			'priority'	=> 20,
		) ) );
		// store front/downloads archive description
		$wp_customize->add_setting( 'edds_edd_store_archives_description', array( 'default' => null ) );
		$wp_customize->add_control( new EDDS_Customize_Textarea_Control( $wp_customize, 'edds_edd_store_archives_description', array(
			'label'		=> __( 'Store Front Description', 'edds' ),
			'section'	=> 'edds_edd_options',
			'settings'	=> 'edds_edd_store_archives_description',
			'priority'	=> 30,
		) ) );
		// hide download description (excerpt)?
		$wp_customize->add_setting( 'edds_download_description', array( 
			'default' => 0,
			'sanitize_callback' => 'edds_sanitize_checkbox'  
		) );
		$wp_customize->add_control( 'edds_download_description', array(
			'label'		=> __( 'Hide Download Description & Link', 'edds' ),
			'section'	=> 'edds_edd_options',
			'priority'	=> 40,
			'type'      => 'checkbox',
		) );
		//  view details link
		$wp_customize->get_setting( 'edds_product_view_details' )->transport = 'postMessage';
		$wp_customize->add_setting( 'edds_product_view_details', array( 
			'default' => __( 'View Details', 'edds' ),
			'sanitize_callback' => 'edds_sanitize_text' 
		) );
		$wp_customize->add_control( new EDDS_WP_Customize_Text_Control( $wp_customize, 'edds_product_view_details', array(
		    'label' 	=> __( 'Store Item Link Text', 'edds' ),
		    'section' 	=> 'edds_edd_options',
			'settings' 	=> 'edds_product_view_details',
			'priority'	=> 50,
		) ) );
		// store front/archive item count
		$wp_customize->add_setting( 'edds_store_front_count', array(
			'default' => 8
		) );		
		$wp_customize->add_control( new EDDS_WP_Customize_Text_Control( $wp_customize, 'edds_store_front_count', array(
		    'label' 	=> __( 'Store Front/Categories/Tags Item Count', 'edds' ),
		    'section' 	=> 'edds_edd_options',
			'settings' 	=> 'edds_store_front_count',
			'priority'	=> 60,
		) ) );
	}
	

	/** ===============
	 * Navigation Menu(s)
	 */
	// section adjustments
	$wp_customize->get_section( 'nav' )->title = __( 'Navigation Menu(s)', 'edds' );
	$wp_customize->get_section( 'nav' )->priority = 40;
	
	

	/** ===============
	 * Static Front Page
	 */
	// section adjustments
	$wp_customize->get_section( 'static_front_page' )->priority = 50;
}
add_action( 'customize_register', 'edds_customize_register' );


/** ===============
 * Sanitize checkbox options
 */
function edds_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return 0;
    }
}


/** ===============
 * Sanitize text input
 */
function edds_sanitize_text( $input ) {
    return strip_tags( stripslashes( $input ) );
}


/** ===============
 * Sanitize textarea
 */
function edds_sanitize_textarea( $input ) {
	$allowed = array(
		's'			=> array(),
		'br'		=> array(),
		'em'		=> array(),
		'i'			=> array(),
		'strong'	=> array(),
		'b'			=> array(),
		'a'			=> array(
			'href'			=> array(),
			'title'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'form'		=> array(
			'id'			=> array(),
			'class'			=> array(),
			'action'		=> array(),
			'method'		=> array(),
			'autocomplete'	=> array(),
			'style'			=> array(),
		),
		'input'		=> array(
			'type'			=> array(),
			'name'			=> array(),
			'class' 		=> array(),
			'id'			=> array(),
			'value'			=> array(),
			'placeholder'	=> array(),
			'tabindex'		=> array(),
			'style'			=> array(),
		),
		'img'		=> array(
			'src'			=> array(),
			'alt'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
			'height'		=> array(),
			'width'			=> array(),
		),
		'span'		=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'p'			=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'div'		=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'blockquote' => array(
			'cite'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
	);
    return wp_kses( $input, $allowed );
}


/** ===============
 * Add Customizer UI styles to the <head> only on Customizer page
 */
function edds_customizer_styles() { ?>
	<style type="text/css">
		body { background: #fff; }
		#customize-controls #customize-theme-controls .description { display: block; color: #999; margin: 2px 0 15px; font-style: italic; }
		textarea, input, select, .customize-description { font-size: 12px !important; }
		.customize-control-title { font-size: 13px !important; margin: 10px 0 3px !important; }
		.customize-control label { font-size: 12px !important; }
		#customize-control-edds_read_more { margin-bottom: 30px; }
		#customize-control-edds_store_front_count input { width: 50px; }
		.control-description { color: #999; font-style: italic; margin-bottom: 6px; }
	</style>
<?php }
add_action( 'customize_controls_print_styles', 'edds_customizer_styles' );


/** ===============
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function edds_customize_preview_js() {
	wp_enqueue_script( 'edds_customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'edds_customize_preview_js' );
