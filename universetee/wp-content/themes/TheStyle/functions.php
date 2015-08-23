<?php 
require_once(TEMPLATEPATH . '/epanel/custom_functions.php'); 

require_once(TEMPLATEPATH . '/includes/functions/comments.php'); 

require_once(TEMPLATEPATH . '/includes/functions/sidebars.php'); 

load_theme_textdomain('TheStyle',get_template_directory().'/lang');

require_once(TEMPLATEPATH . '/epanel/options_thestyle.php');

require_once(TEMPLATEPATH . '/epanel/core_functions.php'); 

require_once(TEMPLATEPATH . '/epanel/post_thumbnails_thestyle.php');

require_once(TEMPLATEPATH . '/includes/additional_functions.php');

require_once(TEMPLATEPATH . '/includes/functions/custom_footer_functions.php');

require_once(TEMPLATEPATH . '/includes/functions/custom_product_functions.php');

function insertThumbnailRSS($content) {
global $post;

$thumb = ''; $thumb = get_post_meta($post->ID, 'Thumbnail',true);

if ( has_post_thumbnail( $post->ID ) ){
$content = '<p>' . get_the_post_thumbnail( $post->ID, 'medium' ) . '</p>' . $content;
} else if ($thumb <> '') {
$content = '<p>' . '<img src="'.get_bloginfo('template_directory').'/timthumb.php?src='.$thumb.'&amp;h=200&amp;w=300&amp;zc=1"/>' . '</p>' . $content;
}

return $content;
}
add_filter('the_excerpt_rss', 'insertThumbnailRSS');
add_filter('the_content_feed', 'insertThumbnailRSS');

function register_main_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu' )
		)
	);
}
if (function_exists('register_nav_menus')) add_action( 'init', 'register_main_menus' );

$wp_ver = substr($GLOBALS['wp_version'],0,3);
if ($wp_ver >= 2.8) include(TEMPLATEPATH . '/includes/widgets.php'); ?>
<?php remove_action('wp_head', 'wp_generator');?>
<?php add_filter('login_errors',create_function('$a', "return null;"));?>