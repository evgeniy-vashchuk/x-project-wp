<?php

if (function_exists("add_theme_support") && function_exists("add_image_size")) {
  add_theme_support("post-thumbnails");

  add_image_size("sm", 320, "", true);
  add_image_size("md", 768, "", true);
  add_image_size("lg", 1200, "", true);
  add_image_size("xl", 1920, "", true);
}

// EXAMPLES

// thumbnails
/*
full size
<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="Image">

custom size (needed post ID)
<img src="<?php echo get_the_post_thumbnail_url(get_queried_object_id(), "lg"); ?>" alt="Image">
*/

// acf images
/*
$image = get_sub_field("image");

<img src="<?php echo insert_acf_image_with_custom_size($image, "lg"); ?>" alt="Image">
*/