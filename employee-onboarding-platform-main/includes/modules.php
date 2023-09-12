<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <?php if (have_rows('modules')) : while (have_rows('modules')) : the_row(); ?>
    <?php if (get_row_layout() === 'content_module') : ?>
      <?php the_sub_field('editor_field'); ?>
    <?php endif; ?>
    <!-- Add more conditionals for other module layouts if needed -->
  <?php endwhile; endif; ?>
<?php endwhile; endif; ?>

