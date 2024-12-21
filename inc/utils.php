<?php

// CUT A STRING TO A SPECIFIED LENGTH ================================================================
function substr_words($text, $maxchar, $end = "...") {
  if (mb_strlen($text) > $maxchar || $text == "") {
    $words = preg_split('/\s/', $text);
    $output = "";
    $i = 0;

    while (1) {
      $length = mb_strlen($output)+mb_strlen($words[$i]);
      if ($length > $maxchar) {
        break;
      }
      else {
        $output .= " " . $words[$i];
        ++$i;
      }
    }

    $output .= $end;
  }
  else {
    $output = $text;
  }

  return $output;
}

// PUT ACF IMAGE WITH CUSTOM SIZE ================================================================
function insert_acf_image_with_custom_size($image_acf, $size = "full") {
  if (empty($image_acf)) {
    return;
  }

  if (is_array($image_acf)) {
    $image = $image_acf["sizes"][ $size ];

    return $image;
  } elseif (is_string($image_acf) && filter_var($image_acf, FILTER_VALIDATE_URL)) {
    $image_id = attachment_url_to_postid($image_acf);
    $image = wp_get_attachment_image_src($image_id, $size);

    return $image[0];
  } elseif (is_numeric($image_acf)) {
    $image_id = $image_acf;
    $image = wp_get_attachment_image_src($image_id, $size);

    return $image[0];
  } else {
    return;
  }
}

// PUT IMAGE URL OR DEFAULT THUMBNAIL ================================================================
function insert_image_or_default_thumbnail($image) {
  if ($image) {
    return $image;
  } else {
    return get_template_directory_uri() . "/img/default-thumbnail.jpg";
  }
}