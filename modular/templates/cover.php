<?php
/**
 * Cover module
 *
 * Include in your theme template: <?php get_template_part('modular/templates/cover'); ?>
 */
// Cover repeater (max 1)
if(get_field('cover')):

  while(has_sub_field('cover')):

  $class      = strtolower(get_sub_field('cover_class')); // default, hidden, other
  $height     = get_sub_field('cover_height'); // default, 50%, 100%, other
  $layout     = get_sub_field('cover_layout'); // default, scroll, fixed, parallax
  $width      = get_sub_field('cover_text_width');
  $offset     = get_sub_field('cover_text_offset');
  $text_color = get_sub_field('cover_text_color');
  $title      = get_sub_field('cover_title'); // title, none, other
  $text       = get_sub_field('cover_text'); // excerpt, none, other
  $background = get_sub_field('cover_background');
  $image      = get_sub_field('cover_image');

  if($class != 'hidden'):
?>

  <div class="cover-module<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>" style="height:<?php if($height == 'default') { echo '100%;'; } else { echo $height . ';'; } ?>">

    <div class="cover-slide fullscreen background-image<?php if($layout == 'default') { echo ''; } else { echo ' ' . $layout; } ?>" <?php if($text_color || $background || $image) { echo 'style="' . (($text_color)?'color:' . $text_color .';':'') . (($background)?'background-color:' . $background . ';':'') . (($image)?'background-image:url(' . $image['url'] . ');':'') . '"'; } if($image) { echo 'data-img-width="' . $image['width'] . '" data-img-height="' . $image['height'] . '" data-diff="100"'; } ?>>

      <div class="container">
        <div class="row">
          <div class="cover-slide__text <?php if($width == 'default') { echo 'col-xs-12'; } else { echo $width; } if($offset == 'default') { echo ''; } else { echo ' ' . $offset; } ?>">
            <div class="inner">

              <?php
                // Display the title
                if($title == 'title') {
                  echo '<h1 class="cover-title">' . get_the_title() . '</h1>';
                } elseif ($title != 'none') {
                  echo '<h1 class="cover-title">' . $title . '</h1>';
                }

                // Display the text
                if($text == 'excerpt') {
                  echo '<p>' . get_the_excerpt() . '</p>';
                } elseif ($text != 'none') {
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
  // End if module class is not hidden
  endif;

  // End while page cover repeater
  endwhile;

// End if page cover repeater
endif;
?>
