<?php if (have_posts()): while (have_posts()) : the_post(); ?>

  <div>
    <?php if (has_post_thumbnail()) : ?>
      <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
    <?php endif; ?>

    <p><?php the_time('m.d.Y'); ?></p>
    <h2>
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
    <div>
      <?php the_content(); ?>
    </div>
  </div>

<?php endwhile; else: ?>

<div>
  <h2>Sorry, nothing to display!</h2>
</div>

<?php endif; ?>