<?php
/**
 * Cover module
 *
 * Include in your theme template: <?php get_template_part('modular/templates/cover'); ?>
 */
// Cover repeater (max 1)
if(get_field('cover')):

  while(has_sub_field('cover')):

  $class      = strtolower(get_sub_field('cover_class'));
  $height     = get_sub_field('cover_height'); // 25%, 50%, 75&, 100%
  $layout     = get_sub_field('cover_layout'); // fixed, scroll, parallax
  $width      = get_sub_field('cover_text_width');
  $offset     = get_sub_field('cover_text_offset');
  $text_color = get_sub_field('cover_text_color');
  $title      = get_sub_field('cover_title');
  $text       = get_sub_field('cover_text');
  $background = get_sub_field('cover_background');
  $image      = get_sub_field('cover_image');

?>

  <div class="cover-module<?php if($class) { echo ' ' . $class; } ?>" style="height:<?php if($height) { echo $height . ';'; } ?>">

    <div class="cover-slide fullscreen background-image<?php if($layout)  { echo ' ' . $layout; } ?>" <?php if($text_color || $background || $image) { echo 'style="' . (($text_color)?'color:' . $text_color .';':'') . (($background)?'background-color:' . $background . ';':'') . (($image)?'background-image:url(' . $image['url'] . ');':'') . '"'; } if($image) { echo 'data-img-width="' . $image['width'] . '" data-img-height="' . $image['height'] . '" data-diff="100"'; } ?>>

      <div class="container">
        <div class="row">
          <div class="cover-slide__text <?php if($width) { echo $width; } if($offset) { echo ' ' . $offset; } ?>">
            <div class="inner">

              <?php
                // Display the title
                if($title) {
                  echo '<h1 class="cover-title">' . $title . '</h1>';
                }

                // Display the text
                if($text) {
                  echo '<p>' . $text . '</p>';
                }
              ?>

            </div>
          </div>
        </div>
      </div>

      <a class="scroll-btn scroll-btn--down" href="#main">
        <i class="fa fa-angle-down fa-3x"></i>
      </a>

    </div>

  </div> <!-- /.cover-module -->

<?php
  // End while page cover repeater
  endwhile;

// End if page cover repeater
endif;
?>
