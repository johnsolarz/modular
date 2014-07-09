<?php
/**
 * Section module
 *
 * Include in your theme template: <?php get_template_part('modular/templates/section'); ?>
 * Loops through Section > Column > Content: Title, Text, Image, Embed, List, Table, Gallery, Blockquote, Horizontal Line, Filter + Loop, Loop
 */
// Section repeater
if(get_field('section')):

  while(has_sub_field('section')):

  $id      = sanitize_title(get_sub_field('section_id'));
  $class   = strtolower(get_sub_field('section_class')); // default, hidden, other
  $wrapper = get_sub_field('section_wrapper'); // container, container fullwidth
  $layout  = get_sub_field('section_layout'); // row, row isotope

  if($class != 'hidden'):
?>

  <section <?php if($id) { echo 'id="' . $id . '"'; } ?> class="section-module<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>">

    <div class="<?php echo $wrapper; ?>">

      <div class="<?php echo $layout; ?>">

        <?php
          // Use Isotope columnWidth element sizing when using percentage widths.
          if($layout == 'row isotope') {
            echo '<div class="col-xs-3 isotope-sizer"></div>';
          }

          // Column repeater
          if(get_sub_field('column')):

          while(has_sub_field('column')):

          $class  = strtolower(get_sub_field('column_class'));
          $width  = get_sub_field('column_width');
          $offset = get_sub_field('column_offset');
        ?>

          <div class="<?php echo (($width == 'default')?'col-xs-6 col-sm-3':$width) . ' ' . (($offset == 'default')?'':$offset) . (($class == 'default')?'': ' ' . $class) . (($layout == 'row isotope')?' isotope-item':''); ?>">

            <?php
              // Flexible content
              while(has_sub_field('content')):

              // Title content
              if(get_row_layout() == 'title'):

              $class = strtolower(get_sub_field('title_class')); // default, other
              $title = get_sub_field('title');

              if($title):
            ?>

              <div class="title-module<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>">
                <div class="inner">
                  <?php echo $title; ?>
                </div>
              </div> <!-- /.title-module -->

            <?php
              // End if title module
              endif;

              // Text content
              elseif(get_row_layout() == 'text'):

              $class = strtolower(get_sub_field('text_class')); // default, other
              $text  = get_sub_field('text');

              if($text):
            ?>

              <div class="text-module<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>">
                <div class="inner">
                  <?php echo $text; ?>
                </div>
              </div> <!-- /.text-module -->

            <?php
              // End if text module
              endif;

              // Image content
              elseif(get_row_layout() == 'image'):

              $class = strtolower(get_sub_field('image_class')); // default, other
              $layout = get_sub_field('image_layout'); // default, circle, rounded, thumbnail
              $link  = get_sub_field('image_link');
              $image = get_sub_field('image');

              if($image):
            ?>

              <div class="image-module<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>">

                <?php
                  if($link) {
                    echo '<a href="' . $link . '">';
                  } else {
                    echo '<a href="' . $image['url'] . '" class="fluidbox">';
                  }
                ?>
                  <img class="img-responsive<?php if($layout == 'default') { echo ''; } else { echo ' ' . $layout; } ?>" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">

                  <?php
                  /* Example picturefill responsive image
                  <span data-picture data-alt="<?php echo $image['alt']; ?>">
                    <span data-src="<?php echo $image['sizes']['screen-xs-img']; ?>"></span>
                    <span data-src="<?php echo $image['sizes']['screen-sm-img']; ?>" data-media="(min-width: 768px)"></span>
                    <span data-src="<?php echo $image['sizes']['screen-md-img']; ?>" data-media="(min-width: 992px)"></span>
                    <span data-src="<?php echo $image['sizes']['screen-lg-img']; ?>" data-media="(min-width: 1200px)"></span>

                    <!-- Fallback content for non-JS browsers. Same img src as the initial, unqualified source element. -->
                    <noscript>
                      <img src="<?php echo $image['sizes']['screen-xs-img']; ?>" alt="<?php echo $image['alt']; ?>">
                    </noscript>
                  </span>
                  */ ?>

                </a>
                <?php
                  if($image['caption']) {
                    echo '<div class="caption">' . $image['caption'] . '</div>';
                  }
                ?>
              </div> <!-- /.image-module -->

            <?php
              // End if image module
              endif;

              // Embed content
              elseif(get_row_layout() == 'embed'):

              $class = strtolower(get_sub_field('embed_class')); // default, other
              $embed = get_sub_field('embed');

              if($embed):
            ?>

              <div class="embed-module<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>">
                <?php echo $embed; ?>
              </div> <!-- /.embed-module -->

            <?php
              // End if embed module
              endif;

              // List content
              elseif(get_row_layout() == 'list'):

              $class  = strtolower(get_sub_field('list_class')); // default, other
              $layout = get_sub_field('list_layout'); // default, list-unstyled, list-inline, list-justified, list-group
            ?>

              <div class="list-module">
                <div class="inner">
                  <ul class="<?php if($class == 'default') { echo ''; } else { echo $class; } if($layout == 'default') { echo ''; } else { echo ' ' . $layout; } ?>">

                    <?php
                      // Items repeater
                      while(has_sub_field('list_item')):

                      $item = get_sub_field('item');

                      if($item):

                        echo '<li' . (($layout == 'list-group')?' class="list-group-item"':'') . '>' . $item .'</li>';

                      // End if item
                      endif;

                      // End item repeater
                      endwhile;
                    ?>

                  </ul>
                </div>
              </div> <!-- /.list-module -->

            <?php
              // Table content
              elseif(get_row_layout() == 'table'):

              $class  = strtolower(get_sub_field('table_class')); // default, other
              $layout = get_sub_field('table_layout'); // default, table-striped, table-bordered, table-hover, table-condensed
            ?>

              <div class="table-module table-responsive<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>">
                <div class="inner">
                  <table class="table<?php if($layout == 'default') { echo ''; } else { echo ' ' . $layout; } ?>">
                    <thead>
                      <tr>

                        <?php
                          // Heading repeater
                          while(has_sub_field('table_heading')):

                          $heading = get_sub_field('heading');

                          if($heading):

                            echo '<th>' . $heading . '</th>';

                          // End if heading
                          endif;

                          // End heading repeater
                          endwhile;
                        ?>

                      </tr>
                    </thead>
                    <tbody>

                      <?php
                        // Row repeater
                        while(has_sub_field('table_row')):

                          echo '<tr>';

                            // Cells repeater
                            while(has_sub_field('row_cell')):

                            $cell = get_sub_field('cell');

                            if($cell):

                              echo '<td>' . $cell . '</td>';

                            // End if cell
                            endif;

                            // Cells repeater
                            endwhile;

                          echo '</tr>';

                        // End row repeater
                        endwhile;
                      ?>

                    </tbody>
                  </table>
                </div>
              </div> <!-- /.table-module -->

            <?php
              // Gallery content
              elseif(get_row_layout() == 'gallery'):

              $class  = strtolower(get_sub_field('gallery_class')); // default, other
              $layout = get_sub_field('gallery_layout'); // row, masonry, slideshow
              $width  = get_sub_field('gallery_image_width');
              $images = get_sub_field('gallery_images');

              if($images):
            ?>

              <div class="gallery-module<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>">

                <?php if($layout == 'row') { ?>
                  <div class="row">
                    <?php foreach ($images as $image) { ?>
                      <div class="<?php if($width == 'default') { echo 'col-xs-12'; } else { echo $width; } ?>">
                        <a href="<?php echo $image['url']; ?>" class="fluidbox">
                          <img class="img-responsive aligncenter" src="<?php echo $image['url']; ?>" alt="<?php $image['alt']; ?>">

                          <?php
                          /* Alternate picturefill responsive image
                          <span data-picture data-alt="<?php echo $image['alt']; ?>">
                            <span data-src="<?php echo $image['sizes']['screen-xs-min']; ?>"></span>
                            <span data-src="<?php echo $image['sizes']['screen-sm-min']; ?>" data-media="(min-width: 768px)"></span>
                            <span data-src="<?php echo $image['sizes']['screen-md-min']; ?>" data-media="(min-width: 992px)"></span>
                            <span data-src="<?php echo $image['sizes']['screen-lg-min']; ?>" data-media="(min-width: 1200px)"></span>

                            <!-- Fallback content for non-JS browsers. Same img src as the initial, unqualified source element. -->
                            <noscript>
                              <img src="<?php echo $image['sizes']['screen-xs-min']; ?>" alt="<?php echo $image['alt']; ?>">
                            </noscript>
                          </span>
                          */ ?>

                        </a>
                        <?php
                          if($image['caption']) {
                            echo '<div class="caption">' . $image['caption'] . '</div>';
                          }
                        ?>
                      </div>
                    <?php } ?>
                  </div>
                <?php } elseif($layout == 'masonry') { ?>
                  <div class="row isotope">
                    <div class="<?php if($width == 'default') { echo 'col-xs-6'; } else { echo $width; } ?> isotope-sizer"></div>
                    <?php foreach ($images as $image) { ?>
                      <div class="<?php if($width == 'default') { echo 'col-xs-6'; } else { echo $width; } ?> isotope-item">
                        <a href="<?php echo $image['url']; ?>" class="isotope__fluidbox">
                          <img class="img-responsive" src="<?php echo $image['url']; ?>" alt="<?php $image['alt']; ?>">

                          <?php
                          /* Alternate picturefill responsive image
                          <span data-picture data-alt="<?php echo $image['alt']; ?>">
                            <span data-src="<?php echo $image['sizes']['screen-xs-min']; ?>"></span>
                            <span data-src="<?php echo $image['sizes']['screen-sm-min']; ?>" data-media="(min-width: 768px)"></span>
                            <span data-src="<?php echo $image['sizes']['screen-md-min']; ?>" data-media="(min-width: 992px)"></span>
                            <span data-src="<?php echo $image['sizes']['screen-lg-min']; ?>" data-media="(min-width: 1200px)"></span>

                            <!-- Fallback content for non-JS browsers. Same img src as the initial, unqualified source element. -->
                            <noscript>
                              <img src="<?php echo $image['sizes']['screen-xs-min']; ?>" alt="<?php echo $image['alt']; ?>">
                            </noscript>
                          </span>
                          */ ?>

                        </a>
                        <?php
                          if($image['caption']) {
                            echo '<div class="caption">' . $image['caption'] . '</div>';
                          }
                        ?>
                      </div>
                    <?php } ?>
                  </div>
                <?php } elseif($layout == 'slideshow') { ?>
                  <div class="row">
                    <div class="<?php if($width == 'default') { echo 'col-xs-12'; } else { echo $width; } ?>">
                      <div class="flexslider">
                        <ul class="slides">
                          <?php foreach ($images as $image) { ?>
                            <li>
                              <img class="img-responsive" src="<?php echo $image['url']; ?>" alt="<?php $image['alt']; ?>">

                              <?php
                              /* Alternate picturefill responsive image
                              <span data-picture data-alt="<?php echo $image['alt']; ?>">
                                <span data-src="<?php echo $image['sizes']['screen-xs-min']; ?>"></span>
                                <span data-src="<?php echo $image['sizes']['screen-sm-min']; ?>" data-media="(min-width: 768px)"></span>
                                <span data-src="<?php echo $image['sizes']['screen-md-min']; ?>" data-media="(min-width: 992px)"></span>
                                <span data-src="<?php echo $image['sizes']['screen-lg-min']; ?>" data-media="(min-width: 1200px)"></span>

                                <!-- Fallback content for non-JS browsers. Same img src as the initial, unqualified source element. -->
                                <noscript>
                                  <img src="<?php echo $image['sizes']['screen-xs-min']; ?>" alt="<?php echo $image['alt']; ?>">
                                </noscript>
                              </span>
                              */ ?>

                              <?php
                                if($image['caption']) {
                                  echo '<div class="caption">' . $image['caption'] . '</div>';
                                }
                              ?>
                            </li>
                          <?php } ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                <?php } ?>

              </div> <!-- /.gallery-module -->

            <?php
              // End if gallery module
              endif;

              // Blockquote content
              elseif(get_row_layout() == 'blockquote'):

              $class = strtolower(get_sub_field('blockquote_class')); // default, other
              $quote = get_sub_field('blockquote');

              if($quote):
            ?>
              <div class="blockquote-module<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>">

                <?php
                  // Multiple blockquotes get slideshow treatment
                  if($quote[1]) {
                ?>
                  <div class="flexslider">
                    <ul class="slides">

                      <?php
                        // Blockquote repeater
                        while(has_sub_field('blockquote')):

                        $text   = get_sub_field('blockquote_text');
                        $source = get_sub_field('blockquote_source');
                      ?>

                      <li>
                        <blockquote>
                          <?php
                            // Display blockquote text
                            if($text) { echo $text; }
                            // Display blockquote source
                            if($source) { echo '<footer><cite title="' . $source . '">' . $source . '</cite></footer>'; }
                          ?>
                        </blockquote>
                      </li>

                      <?php
                        // Endwhile blockquote repeater
                        endwhile;
                      ?>
                    </ul>
                  </div>
                <?php
                  // Single blockquote
                  } else {

                    // Still need to loop through blockquote repeater
                    while(has_sub_field('blockquote')):

                    $text   = get_sub_field('blockquote_text');
                    $source = get_sub_field('blockquote_source');
                  ?>
                    <blockquote>
                      <?php
                        // Display blockquote text
                        if($text) { echo $text; }
                        // Display blockquote source
                        if($source) { echo '<footer><cite title="' . $source . '">' . $source . '</cite></footer>'; }
                      ?>
                    </blockquote>
                  <?php
                    // Endwhile blockquote repeater
                    endwhile;
                } ?>
              </div> <!-- /.blockquote-module -->

            <?php
              // End if blockquote module
              endif;

              // Horizontal Line content
              elseif(get_row_layout() == 'horizontal_line'):

              $class = strtolower(get_sub_field('line_class')); // default, other
              $color = get_sub_field('line_color');
            ?>

              <div class="line-module<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>"><hr<?php if($color) { echo ' style="border-color:' . $color . ';"'; } ?>></div> <!-- /.line-module -->

            <?php
              // Filter + Loop content in masonry layout
              elseif(get_row_layout() == 'filter_+_loop'):

              $class         = strtolower(get_sub_field('filter_class')); // default, other
              $post_width    = get_sub_field('post_width');
              $post_per_page = get_sub_field('posts_per_page');
              $post_type     = sanitize_title(get_sub_field('post_type'));

              if($post_type):
            ?>

              <div class="filter-module<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>">
                <ul class="filters list-inline">
                  <li class="active"><a href="#" data-filter="*">All</a></li>

                    <?php
                      // Filter repeater
                      while(has_sub_field('filter')):

                      $title  = get_sub_field('title');
                      $target = sanitize_title(get_sub_field('target'));

                        echo '<li><a href="#" data-filter=".' . $target . '">' . $title . '</a></li>';

                      // End filter repeater
                      endwhile;
                    ?>

                </ul>
              </div>
              <div class="filter-content row isotope">

                <?php
                // Use Isotope columnWidth element sizing when using percentage widths.
                echo '<div class="'. (($post_width == 'default')?'col-xs-6 col-sm-3':$post_width) . ' isotope-sizer"></div>';

                // For creating multiple, customized loops.
                // http://codex.wordpress.org/Class_Reference/WP_Query
                // Parameters
                $args = array(
                  'post_type'      => $post_type,
                  'posts_per_page' => $post_per_page
                );

                // Results
                $the_query = new WP_Query( $args );

                // The loop
                while($the_query->have_posts()) : $the_query->the_post(); ?>

                  <article <?php post_class('loop-module ' . (($post_width == 'default')?'col-xs-6 col-sm-3':$post_width) . ' isotope-item'); ?>>
                    <header>
                      <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </header>
                    <div class="entry-summary">
                      <?php the_excerpt(); ?>
                    </div>
                  </article>

                <?php endwhile; ?>

                <?php wp_reset_postdata(); // reset the query ?>

              </div>

            <?php
              // End if filter module
              endif;

              // Loop content
              elseif(get_row_layout() == 'loop'):

              $post_width    = get_sub_field('post_width');
              $post_per_page = get_sub_field('posts_per_page');
              $post_type     = sanitize_title(get_sub_field('post_type'));
              $post_tax      = sanitize_title(get_sub_field('post_taxonomy')); // Optional, uses conditional below
              $post_term     = sanitize_title(get_sub_field('post_term')); // Optional, uses conditional below

              if($post_type):
            ?>

              <div class="row isotope">

                <?php
                // Use Isotope columnWidth element sizing when using percentage widths.
                echo '<div class="' . (($post_width == 'default')?'col-xs-6 col-sm-3':$post_width) .' isotope-sizer"></div>';

                // For creating multiple, customized loops.
                // http://codex.wordpress.org/Class_Reference/WP_Query
                if($post_type && $post_tax && $post_term) {
                  // Parameters
                  $args = array(
                    'post_type'      => $post_type,
                    'posts_per_page' => $post_per_page,
                    'tax_query'      => array(
                      array(
                        'taxonomy'   => $post_tax,
                        'field'      => 'slug',
                        'terms'      => $post_term
                      )
                    )
                  );
                } else {
                  // Parameters
                  $args = array(
                    'post_type'      => $post_type,
                    'posts_per_page' => $post_per_page
                  );
                }

                // Results
                $the_query = new WP_Query( $args );

                // The loop
                while($the_query->have_posts()) : $the_query->the_post(); ?>

                  <article <?php post_class('loop-module ' . (($post_width == 'default')?'col-xs-6 col-sm-3':$post_width) . ' isotope-item'); ?>>
                    <header>
                      <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </header>
                    <div class="entry-summary">
                      <?php the_excerpt(); ?>
                    </div>
                  </article>

                <?php endwhile; ?>

                <?php wp_reset_postdata(); // reset the query ?>

              </div>

            <?php
              // End if loop module
              endif;

              // End if flexible content
              endif;

            // End while flexible content
            endwhile;
            ?>

          </div>

        <?php
          // End while column repeater
          endwhile;

          // End if column repeater
          endif;
        ?>

      </div>

    </div>

  </section> <!-- /.section-module -->

<?php
  // End if module class is not hidden
  endif;

  // End while column section repeater
  endwhile;

// End if column section repeater
endif;
?>
