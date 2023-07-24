<?php
	$text = get_sub_field("text");
?>

<!-- SECTION -->
<section class="section">
	<div class="container">
		<?php if ($text) : ?>
			<p><?php echo $text; ?></p>
		<?php endif; ?>
	</div>
</section>
<!-- SECTION END -->