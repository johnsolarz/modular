<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part( 'modular/templates/section' ); ?>
<?php endwhile; ?>
