<?php

// INSTALL PLUGINS ================================================================
require_once dirname( __FILE__ ) . "/../class-tgm-plugin-activation.php";
add_action( "tgmpa_register", "x_project_wp_theme_plugins" );

function x_project_wp_theme_plugins() {
  /*
   * Array of plugin arrays. Required keys are name and slug.
   * If the source is NOT from the .org repo, then local source is also required.
   */
  $plugins = array(
    array(
      "name"     => "Clear Cache For Me",
      "slug"     => "clear-cache-for-widgets",
      "required" => true,
    ),
    array(
      "name"     => "Resize Image After Upload",
      "slug"     => "resize-image-after-upload",
      "required" => true,
    ),
    array(
      "name"     => "reSmush.it Image Optimizer",
      "slug"     => "resmushit-image-optimizer",
      "required" => true,
    ),
    array(
      "name"     => "WebP Express",
      "slug"     => "webp-express",
      "required" => true,
    ),
    array(
      "name"     => "SVG Support",
      "slug"     => "svg-support",
      "required" => true,
    ),
    array(
      "name"     => "W3 Total Cache",
      "slug"     => "w3-total-cache",
      "required" => true,
    ),
    array(
      "name"     => "Disable Admin Notices individually",
      "slug"     => "disable-admin-notices",
      "required" => true,
    ),
    array(
      "name"     => "Disable Gutenberg",
      "slug"     => "disable-gutenberg",
      "required" => true,
    ),
    array(
      "name"     => "Simple Custom Post Order",
      "slug"     => "simple-custom-post-order",
      "required" => true,
    ),
    array(
      "name"     => "WPS Hide Login",
      "slug"     => "wps-hide-login",
      "required" => true,
    ),
    array(
      "name"     => "Support For Icomoon with Advanced Custom Fields",
      "slug"     => "acf-icomoon",
      "required" => false,
    ),
    array(
      "name"     => "Duplicate Post Page Menu & Custom Post Type",
      "slug"     => "duplicate-post-page-menu-custom-post-type",
      "required" => false,
    ),
    array(
      "name"     => "Contact Form 7",
      "slug"     => "contact-form-7",
      "required" => false,
    ),
    array(
      "name"     => "Advanced Custom Fields Pro",
      "slug"     => "advanced-custom-fields-pro",
      "source"   => get_template_directory_uri() . "/bundled-plugins/advanced-custom-fields-pro.zip",
      "required" => true,
    ),
    array(
      "name"     => "All-in-One WP Migration Unlimited",
      "slug"     => "all-in-one-wp-migration-unlimited",
      "source"   => get_template_directory_uri() . "/bundled-plugins/all-in-one-wp-migration-unlimited.zip",
      "required" => true,
    ),
  );

  /*
   * Array of configuration settings.
  */
  $config = array(
    "id"           => "tgmpa",                 // Unique ID for hashing notices for multiple instances of TGMPA.
    "default_path" => "",                      // Default absolute path to bundled plugins.
    "menu"         => "tgmpa-install-plugins", // Menu slug.
    "parent_slug"  => "themes.php",            // Parent menu slug.
    "capability"   => "edit_theme_options",    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
    "has_notices"  => true,                    // Show admin notices or not.
    "dismissable"  => true,                    // If false, a user cannot dismiss the nag message.
    "dismiss_msg"  => "",                      // If "dismissable" is false, this message will be output at top of nag.
    "is_automatic" => true,                    // Automatically activate plugins after installation or not.
    "message"      => "",                      // Message to output right before the plugins table.
    /*
    "strings"      => array(
      "page_title"                      => __( "Install Required Plugins", "theme-slug" ),
      "menu_title"                      => __( "Install Plugins", "theme-slug" ),
      // <snip>...</snip>
      "nag_type"                        => "updated", // Determines admin notice type - can only be "updated", "update-nag" or "error".
    )
    */
  );
  tgmpa( $plugins, $config );
}

// SHOW/HIDE ADMIN BAR ================================================================
show_admin_bar(false);

// ENABLE HTML5 SUPPORT ================================================================
add_theme_support("html5", array("comment-list", "comment-form", "search-form", "gallery", "caption"));

// LOCALIZATION SUPPORT ================================================================
load_theme_textdomain(LOCALIZATION, get_template_directory() . "/languages");

// REGISTER NAVIGATION MENUS ================================================================
register_nav_menus(array(
  "header" => __("Header Menu", LOCALIZATION),
  "footer" => __("Footer Menu", LOCALIZATION),
));

// THEME OPTIONS TAB IN APPEARANCE ================================================================
if (function_exists("acf_add_options_page")) {
  acf_add_options_page(array(
    "page_title"    => __("Theme General Settings", LOCALIZATION),
    "menu_title"    => __("Theme Settings", LOCALIZATION),
    "menu_slug"     => "theme-general-settings",
    "capability"    => "edit_posts",
    "redirect"      => false
  ));

  acf_add_options_sub_page(array(
    "page_title"    => __("Theme Header Settings", LOCALIZATION),
    "menu_title"    => __("Header", LOCALIZATION),
    "parent_slug"   => "theme-general-settings",
  ));

  acf_add_options_sub_page(array(
    "page_title"    => __("Theme Footer Settings", LOCALIZATION),
    "menu_title"    => __("Footer", LOCALIZATION),
    "parent_slug"   => "theme-general-settings",
  ));
}

// RENAME DEFAULT TEMPLATE
add_filter("default_page_template_title", function() {
  return __("Flexible content page", LOCALIZATION);
});

// GOOGLE FONTS ================================================================
function add_google_fonts() {
  wp_enqueue_style("add_google_fonts", "https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&amp;family=Roboto+Slab:wght@300;400;700&amp;display=swap", false);
}

//add_action( "wp_enqueue_scripts", "add_google_fonts" );

// REMOVE EMOJI ICONS ================================================================
remove_action("wp_head", "print_emoji_detection_script", 7);
remove_action("wp_print_styles", "print_emoji_styles");

// REMOVE <p> AND <br> FROM CF7 ================================================================
add_filter( "wpcf7_autop_or_not", "__return_false" );

// REMOVE EMPTY PARAGRAPHS FROM CONTENT ================================================================
add_filter('the_content', function ($content) {
  $content = preg_replace('/<p>(\s|&nbsp;)*<\/p>/i', '', $content);
  return $content;
}, 20);

// PAGINATION ================================================================
function pagination() {
  $listClass = "pagination";
  $listItemClass = "page-item";
  $listLinkClass = "page-link";
  $activeClass = "active";

  if( is_singular() )
    return;

  global $wp_query;

  // Stop execution if there's only 1 page
  if( $wp_query->max_num_pages <= 1 )
      return;

  $paged = get_query_var( "paged" ) ? absint( get_query_var( "paged" ) ) : 1;
  $max   = intval( $wp_query->max_num_pages );

  // Add current page to the array
  if ( $paged >= 1 )
      $links[] = $paged;

  // Add the pages around the current page to the array
  if ( $paged >= 3 ) {
      $links[] = $paged - 1;
      $links[] = $paged - 2;
  }

  if ( ( $paged + 2 ) <= $max ) {
      $links[] = $paged + 2;
      $links[] = $paged + 1;
  }

  echo '<nav aria-label="' . __("Pagination", LOCALIZATION) . '"><ul class="' . $listClass . ' mb-0 justify-content-center">' . "\n";

  // Previous Post Link
  if ( get_previous_posts_link() )
      printf( '<li class="' . $listItemClass . '"><a href="%s" class="' . $listLinkClass . '" aria-label="' . __("Previous", LOCALIZATION) . '"><span aria-hidden="true"></span></a></li>' . "\n", get_previous_posts_page_link() );

  // Link to first page, plus ellipses if necessary
  if ( ! in_array( 1, $links ) ) {
      $class = 1 == $paged ? ' class="' . $activeClass . '"' : '';

      printf( '<li%s class="' . $listItemClass . '"><a href="%s" class="' . $listLinkClass . '">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

      if ( ! in_array( 2, $links ) )
          echo '<li class="' . $listItemClass . '"><span class="' . $listLinkClass . '">…</span></li>';
  }

  // Link to current page, plus 2 pages in either direction if necessary
  sort( $links );
  foreach ( (array) $links as $link ) {
      $class = $paged == $link ? ' class="' . $listItemClass . ' ' . $activeClass . '"' : '';
      printf( '<li%s class="' . $listItemClass . '"><a href="%s" class="' . $listLinkClass . '">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
  }

  // Link to last page, plus ellipses if necessary
  if ( ! in_array( $max, $links ) ) {
      if ( ! in_array( $max - 1, $links ) )
          echo '<li class="' . $listItemClass . '"><span class="' . $listLinkClass . '">…</span></li>' . "\n";

      $class = $paged == $max ? ' class="' . $activeClass . '"' : '';
      printf( '<li%s class="' . $listItemClass . '"><a href="%s" class="' . $listLinkClass . '">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
  }

  // Next Post Link
  if ( get_next_posts_link() )
      printf( '<li class="' . $listItemClass . '"><a href="%s" class="' . $listLinkClass . '" aria-label="' . __("Next", LOCALIZATION) . '"><span aria-hidden="true"></span></a></li>' . "\n", get_next_posts_page_link() );

  echo '</ul></nav>' . "\n";
}

// DECLARING WOOCOMMERCE SUPPORT IN THEME
function x_project_wp_add_woocommerce_support() {
  add_theme_support( "woocommerce" );
}

add_action( "after_setup_theme", "x_project_wp_add_woocommerce_support" );

// REMOVE CONTENT EDITOR ================================================================
function remove_content_editor() {
  remove_post_type_support("page", "editor");
}

add_action("admin_head", "remove_content_editor");