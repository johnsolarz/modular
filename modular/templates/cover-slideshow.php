<?php
/**
 * Cover slideshow module
 *
 * Include in your theme template: <?php get_template_part('modular/templates/cover', 'slideshow'); ?>
 * Requires RoyalSlider: http://dimsemenov.com/plugins/royal-slider/documentation
 */
// Cover repeater (max 1)
if(get_field('cover_slideshow')):

  while(has_sub_field('cover_slideshow')):

  $class  = strtolower(get_sub_field('cover_slideshow_class'));
  $height = get_sub_field('cover_slideshow_height'); // 25%, 50%, 75%, 100%

?>

  <div class="cover-slideshow<?php if($class) { echo ' ' . $class; } ?>" style="height:<?php if($height) { echo $height . ';'; } ?>">

    <div class="royalSlider rsDefault">

    <?php
      // Slide repeater
      while(has_sub_field('slide')):

      $width      = get_sub_field('slide_text_width');
      $offset     = get_sub_field('slide_text_offset');
      $text_color = get_sub_field('slide_text_color');
      $title      = get_sub_field('slide_title');
      $text       = get_sub_field('slide_text');
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
  // End while page cover repeater
  endwhile;

// End if page cover repeater
endif;
?>
