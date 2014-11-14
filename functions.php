<?php
/**
 * Theme: Flat Bootstrap Developer
 * 
 * Functions file for child theme. If you want to make simpler changes than what is 
 * included here, consider using the Flat Bootstrap Child theme that is included with the 
 * parent theme, Flat Bootstrap.
 *
 * @package flat-bootstrap-dev
 */
 
/**
 * SET THEME OPTIONS HERE
 *
 * Theme options can be overriden here. The ones that load javascript are turned off
 * here to make this developer theme as stripped down as possible.
 * 
 * Parameters:
 * background_color - Hex code for default background color without the #. eg) ffffff
 * 
 * content_width - Only for determining "full width" image. Actual width in Bootstrap.css
 * 		is 1170 for screens over 1200px resolution, otherwise 970.
 * 
 * embed_video_width - Sets the maximum width of videos that use the <embed> tag. The
 * 		default is 1170 to handle full-width page templates. If you will ALWAYS display
 * 		the sidebar, can set to 600 for better performance.
 * 
 * embed_video_height - Leave empty to automatically set at a 16:9 ratio to the width
 * 
 * post_formats - Array of WordPress extra post formats. i.e. aside, image, video, quote,
 * 		and/or link
 * 
 * touch_support - Whether to load touch support for carousels (sliders)
 * 
 * fontawesome - Whether to load font-awesome font set or not
 * 
 * bootstrap_gradients - Whether to load Bootstrap "theme" CSS for gradients
 * 
 * navbar_classes - One or more of navbar-default, navbar-inverse, navbar-fixed-top, etc.
 * 
 * custom_header_location - If 'header', displays the custom header above the navbar. If
 * 		'content-header', displays it below the navbar in place of the colored content-
 *		header section.
 * 
 * image_keyboard_nav - Whether to load javascript for using the keyboard to navigate
 		image attachment pages
 * 
 * sample_widgets - Whether to display sample widgets in the footer and page-bottom widet
 		areas.
 * 
 * sample_footer_menu - Whether to display sample footer menu with Top and Home links
 * 
 * testimonials - Whether to activate testimonials custom post type if Jetpack plugin is 
 * 		active
 *
 * NOTE: $theme_options is being deprecated and replaced with $xsbf_theme_options. You'll
 * need to update your child themes.
 */
$xsbf_theme_options = array(
	'background_color' 		=> 'ffffff',
	//'content_width' 			=> 1170, // used for full-width images
	//'embed_video_width' 		=> 1170, // full-width videos on full-width pages
	//'embed_video_height' 		=> null, // i.e. calculate it automatically
	//'post_formats' 			=> null,
	'touch_support' 			=> false,
	'fontawesome' 				=> false,
	//'bootstrap_gradients' 	=> false,
	//'navbar_classes'			=> 'navbar-default navbar-static-top',
	//'custom_header_location' 	=> 'header',
	'image_keyboard_nav' 		=> false,
	'sample_widgets' 			=> false,
	'sample_footer_menu'		=> false,
	'testimonials'				=> false // requires Jetpack plugin
);

/*
 * ALSO HOOK INTO PRINT_STYLES TO OVERRIDE WHAT CSS GETS LOADED
 */
add_action('wp_print_styles', 'xsbf_dev_print_styles');
function xsbf_dev_print_styles() {

	// Remove the parent theme's custom bootstrap CSS
	wp_dequeue_style('bootstrap');
	wp_deregister_style('bootstrap');

	// Load the standard Bootstrap CSS from the Bootstrap CDN
	wp_register_style('bootstrap', '//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css', array(), '3.1.0', 'all' );
	
	// ... OR replace it with your own Bootstrap version in this child theme
	//wp_register_style('bootstrap.css', get_stylesheet_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), '3.1.0', 'all' );
	
	wp_enqueue_style( 'bootstrap');

	// Get rid of the parent theme's custom boostrap overlay (colored sections, etc.)
	wp_dequeue_style('theme-flat');
	//wp_deregister_style('theme-flat');

	// Note: In a child theme, the parent's theme doesn't get loaded. So you don't
	// have to dequeue or deregister that here. Just don't @import it in the child theme's
	// style.css. Nor do you have to register or enqueue your child theme's style.css as
	// it is automatically included by WordPress.

}

/*
 * IF YOU WANT TO HOOK INTO PRINT_SCRIPTS TO OVERRIDE WHAT JAVASCRIPT GETS LOADED YOU 
 * CAN DO SO HERE.
 */
/*
add_action( 'wp_print_scripts', 'xsbf_dev_print_scripts' );
function xsbf_dev_print_scripts() {
    //wp_dequeue_script( 'jquerymobile' );
    //wp_deregister_script( 'jquerymobile' );
}
*/

/**
 * OVERRIDE WHAT INCLUDE FILES GET USED. THIS PARTICULAR EXAMPLE ONLY LOADS
 * THE ONES WE CONSIDER ESSENTIAL FOR THE THEME TO FUNCTION AT ALL.
 */
xsbf_load_includes();
function xsbf_load_includes() {

	// Custom template tags for this theme. This is needed for sure.
	require_once get_template_directory() . '/inc/template-tags.php';

	// Functions not related to template tags. This is needed for sure.
	require_once get_template_directory() . '/inc/theme-functions.php';

	//Overide the standard WordPress nav menu with Bootstrap divs, data attributes, and CSS. Nice to have.
	require_once get_template_directory() . '/inc/bootstrap-navmenu.php';
	
	// Note that the parent theme has more includes, but they are optional.

} // end function

/* 
 * OVERRIDE THE CUSTOM HEADER WIDTH AND HEIGHT
 *
 * You can change anything EXCEPT the last 3 lines (unless you also completely replace
 * those functions. Those functions are needed from the parent theme to display the 
 * custom header options in admin and format the output on the site itself.
 */
/*
add_filter ( 'xsbf_custom_header_args', 'xsbf_dev_custom_header_args' );
function xsbf_dev_custom_header_args() {
	return array(
		'default-image'          => '',
		'default-text-color'     => '555555',
		'width'                  => 1600,
		'height'                 => 200,
		'flex-width'             => true,
		'flex-height'            => true,
		'header-text'            => true,
		'wp-head-callback'       => 'xsbf_header_style', // DON'T CHANGE THIS!!!
		'admin-head-callback'    => 'xsbf_admin_header_style', // DON'T CHANGE THIS!!!
		'admin-preview-callback' => 'xsbf_admin_header_image', // DON'T CHANGE THIS!!!
	);
}
*/

/*
 * OVERRIDE THE SITE CREDITS. IF YOU WANT TO REMOVE THEM ALTOGETHER, JUST RETURN
 * NOTHING INSTEAD.
 */
add_filter('xsbf_credits', 'xsbf_dev_credits'); 
function xsbf_dev_credits ( $site_credits ) {
		
	$theme = wp_get_theme();
	$site_credits = sprintf( __( '&copy; %1$s %2$s. Theme by %3$s and %4$s.', 'xtremelysocial' ), 
		date ( 'Y' ),
		'<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a>',
		'<a href="http://xtremelysocial.com/" rel="designer">XtremelySocial</a>',
		'<a href="' . $theme->get( 'ThemeURI' ) . '" rel="designer">' . $theme->get( 'Author' ) . '</a>'
	);
	return $site_credits;
}
