<?php
/**
 * Cover slideshow module. Supports title, text, background color, image and embed slides
 *
 * Requires ACF, addons and fields: @see fields.php
 * - Advanced Custom Fields (http://www.advancedcustomfields.com)
 * - ACF Repeater Field (http://www.advancedcustomfields.com/add-ons/repeater-field)
 * - ACF Flexible Content Field (http://www.advancedcustomfields.com/add-ons/flexible-content-field)
 *
 * Requires jQuery plugins and scripts: @see _main.js
 * - RoyalSlider (http://dimsemenov.com/plugins/royal-slider/documentation/)
 */
// Cover repeater (max 1)
if(get_field('cover_slideshow')):

  while(has_sub_field('cover_slideshow')):

  $class  = strtolower(get_sub_field('cover_slideshow_class')); // default, hidden, other
  $height = get_sub_field('cover_slideshow_height'); // default, 50%, 100%, other

  if($class != 'hidden'):
?>

  <div class="cover-slideshow<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>" style="height:<?php if($height == 'default') { echo '100%;'; } else { echo $height . ';'; } ?>">

    <div class="royalSlider rsDefault">

    <?php
      // Slide repeater
      while(has_sub_field('slide')):

      $width      = get_sub_field('slide_text_width');
      $offset     = get_sub_field('slide_text_offset');
      $text_color = get_sub_field('slide_text_color');
      $title      = get_sub_field('slide_title'); // (image) title, none, other
      $text       = get_sub_field('slide_text'); // (image) caption, none, other
      $background = get_sub_field('slide_background');
      $image      = get_sub_field('slide_image');
      $embed      = get_sub_field('slide_embed');
    ?>

      <div class="cover-slide rsContent" <?php if($text_color || $background) { echo 'style="' . (($text_color)?'color:' . $text_color .';':'') . (($background)?'background-color:' . $background . ';':'') . '"'; } ?>>

        <?php
          // Display an image, or poster image and video
          if($image) {
            echo '<img class="rsImg" src="' . $image['url'] . '"' . (($image['alt'])?' alt="' . $image['alt'] . '"':'') . (($embed)?' data-rsVideo="' . $embed . '"':'') . '>';
          }
        ?>

        <div class="rsABlock">
          <div class="container">
            <div class="row">
              <div class="cover-slide__text <?php if($width == 'default') { echo 'col-xs-12'; } else { echo $width; } if($offset == 'default') { echo ''; } else { echo ' ' . $offset; } ?>">
                <div class="inner">

                  <?php
                    // Display the title
                    if($title == 'title') {
                      echo '<h1 class="cover-title">' . $image['title'] . '</h1>';
                    } elseif ($title != 'none') {
                      echo '<h1 class="cover-title">' . $title . '</h1>';
                    }

                    // Display the text
                    if($text == 'caption') {
                      echo '<p>' . $image['caption'] . '</p>';
                    } elseif ($text != 'none') {
                      echo '<p>' . $text . '</p>';
                    }
                  ?>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    <?php
      // End while flexible content
      endwhile;
    ?>

    </div>

    <a class="scroll-btn scroll-btn--down" href="#main">
      <i class="fa fa-angle-down fa-3x"></i>
    </a>

  </div> <!-- /.cover-module -->

<?php
  // End if module class is not hidden
  endif;

  // End while page cover repeater
  endwhile;

// End if page cover repeater
endif;
?>
