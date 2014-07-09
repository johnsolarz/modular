<?php
/**
 * Section footer module
 *
 * Include in your theme template: <?php get_template_part('modular/templates/section', 'footer'); ?>
 * Loops through Section > Column > Content: Title, Text, Image, Blockquote, Horizontal Line, Menu
 */
// Section repeater
if(get_field('section_footer', 'option')):

  while(has_sub_field('section_footer', 'option')):

  $id      = sanitize_title(get_sub_field('section_id'));
  $class   = strtolower(get_sub_field('section_class')); // default, hidden, other
  $wrapper = get_sub_field('section_wrapper'); // container, container fullwidth
  $layout  = get_sub_field('section_layout'); // row

  if($class != 'hidden'):
?>

  <section <?php if($id) { echo 'id="' . $id . '"'; } ?> class="section-module<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>">

    <div class="<?php echo $wrapper; ?>">

      <div class="<?php echo $layout; ?>">

        <?php
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

              $class  = strtolower(get_sub_field('image_class')); // default, other
              $layout = get_sub_field('image_layout'); // default, circle, rounded, thumbnail
              $link   = get_sub_field('image_link');
              $image  = get_sub_field('image');

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
              // Menu content in masonry layout
              elseif(get_row_layout() == 'menu'):

              $class  = strtolower(get_sub_field('menu_class')); // default, other
              $layout = get_sub_field('menu_layout'); // default, list-unstyled, list-inline, list-justified
              $menu   = get_sub_field('menu');
            ?>

              <div class="menu-module<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>" role="navigation">
                <?php wp_nav_menu(array('menu_id' => $menu, 'menu_class' => $layout )); ?>
              </div>

            <?php
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
