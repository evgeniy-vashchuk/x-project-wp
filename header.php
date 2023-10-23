<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<title><?php bloginfo('name'); ?> — <?php echo is_front_page() ? "Home" : wp_title(''); ?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="format-detection" content="telephone=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- META FOR SHARING -->
	<meta property="og:title" content="<?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' : '; } ?><?php bloginfo('name'); ?>" />
	<meta property="og:description" content="<?php bloginfo('description'); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?php echo get_site_url(); ?>" />
	<meta property="og:site_name" content="<?php echo str_replace(array( 'http://', 'https://' ), '', get_site_url()); ?>" />

	<?php
		$image_for_sharing = get_field('image_for_sharing', 'option');

		if ($image_for_sharing) : ?>
		<meta property="og:image" content="<?php echo $image_for_sharing; ?>" />
	<?php endif; ?>
	<!-- META FOR SHARING END -->

	<!-- THEME PATH -->
	<script type="text/javascript">
		var pathInfo = {
			base: '<?php echo get_template_directory_uri(); ?>/',
			css: 'css/',
			js: 'js/'
		}
	</script>
	<!-- THEME PATH END -->

	<?php
		$additional_scripts = get_field('additional_scripts', 'option');

		if ($additional_scripts) :
	?>
		<script type="text/javascript">
			<?php echo $additional_scripts; ?>
		</script>
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<!-- HEADER -->
	<header class="header">
		<div class="container">

		</div>
	</header>
	<!-- HEADER END -->

	<!-- CONTENT -->
	<main class="main">