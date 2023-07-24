<?php

if (!isset($content_width)) {
	$content_width = 900;
}

if (function_exists('add_theme_support')) {

	// Add Thumbnail Theme Support.
	add_theme_support('post-thumbnails');
	add_image_size('large', 700, '', true); // Large Thumbnail.
	add_image_size('medium', 250, '', true); // Medium Thumbnail.
	add_image_size('small', 120, '', true); // Small Thumbnail.
	add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

	// Add Support for Custom Backgrounds - Uncomment below if you're going to use.
	/*add_theme_support('custom-background', array(
		'default-color' => 'FFF',
		'default-image' => get_template_directory_uri() . '/img/bg.jpg'
		));*/

	// Add Support for Custom Header - Uncomment below if you're going to use.
	/*add_theme_support('custom-header', array(
		'default-image'          => get_template_directory_uri() . '/img/headers/default.jpg',
		'header-text'            => false,
		'default-text-color'     => '000',
		'width'                  => 1000,
		'height'                 => 198,
		'random-default'         => false,
		'wp-head-callback'       => $wphead_cb,
		'admin-head-callback'    => $adminhead_cb,
		'admin-preview-callback' => $adminpreview_cb
		));*/

	// Enables post and comment RSS feed links to head.
	add_theme_support('automatic-feed-links');

	// Enable HTML5 support.
	add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

	// Localisation Support.
	load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
		Functions
\*------------------------------------*/

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
	$args['container'] = false;
	return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
	return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
	return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
	global $post;
	if (is_home()) {
		$key = array_search('blog', $classes, true);
		if ($key > -1) {
			unset($classes[$key]);
		}
	} elseif (is_page()) {
		$classes[] = sanitize_html_class($post->post_name);
	} elseif (is_singular()) {
		$classes[] = sanitize_html_class($post->post_name);
	}

	return $classes;
}

// Remove the width and height attributes from inserted images
function remove_width_attribute($html)
{
	$html = preg_replace('/(width|height)="\d*"\s/', "", $html);
	return $html;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar')) {
	// Define Sidebar Widget Area 1
	register_sidebar(array(
		'name'          => esc_html('Widget Area 1', 'html5blank'),
		'description'   => esc_html('Description for this widget-area...', 'html5blank'),
		'id'            => 'widget-area-1',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	));

	// Define Sidebar Widget Area 2
	register_sidebar(array(
		'name'          => esc_html('Widget Area 2', 'html5blank'),
		'description'   => esc_html('Description for this widget-area...', 'html5blank'),
		'id'            => 'widget-area-2',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
	global $wp_widget_factory;

	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action('wp_head', array(
			$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
			'recent_comments_style'
		));
	}
}

// Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
function html5wp_index($length)
{
	return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
	return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
	global $post;
	if (function_exists($length_callback)) {
		add_filter('excerpt_length', $length_callback);
	}
	if (function_exists($more_callback)) {
		add_filter('excerpt_more', $more_callback);
	}
	$output = get_the_excerpt();
	$output = apply_filters('wptexturize', $output);
	$output = apply_filters('convert_chars', $output);
	$output = '<p>' . $output . '</p>';
	echo esc_html($output);
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
	global $post;
	return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . esc_html_e('View Article', 'html5blank') . '</a>';
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
	return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions($html)
{
	$html = preg_replace('/(width|height)=\"\d*\"\s/', '', $html);
	return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar($avatar_defaults)
{
	$myavatar                   = get_template_directory_uri() . '/img/gravatar.jpg';
	$avatar_defaults[$myavatar] = 'Custom Gravatar';
	return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
	if (!is_admin()) {
		if (is_singular() and comments_open() and (get_option('thread_comments') == 1)) {
			wp_enqueue_script('comment-reply');
		}
	}
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ('div' == $args['style']) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
?>
	<!-- heads up: starting < for the html tag (li or div) in the next line: -->
	<<?php echo esc_html($tag) ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID(); ?>">
		<?php if ('div' != $args['style']) : ?>
			<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<?php endif; ?>
			<div class="comment-author vcard">
				<?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['avatar_size']); ?>
				<?php printf(esc_html('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
			</div>
			<?php if ($comment->comment_approved == '0') : ?>
				<em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.') ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>">
					<?php
					printf(esc_html('%1$s at %2$s'), get_comment_date(), get_comment_time()) ?></a><?php edit_comment_link(esc_html_e('(Edit)'), '  ', '');
																																																?>
			</div>

			<?php comment_text() ?>

			<div class="reply">
				<?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
			<?php if ('div' != $args['style']) : ?>
			</div>
		<?php endif; ?>
	<?php }

/*------------------------------------*\
		Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter( 'nav_menu_css_class', 'my_css_attributes_filter', 100, 1 ); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter( 'nav_menu_item_id', 'my_css_attributes_filter', 100, 1 ); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter( 'page_css_class', 'my_css_attributes_filter', 100, 1 ); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('post_thumbnail_html', 'remove_width_attribute', 10); // Remove width and height dynamic attributes to post images
add_filter('image_send_to_editor', 'remove_width_attribute', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether