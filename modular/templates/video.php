<?php
/**
 * Video module
 *
 * Include in your theme template: <?php get_template_part('modular/templates/cover-video'); ?>
 * Fullscreen ambient video, @link https://github.com/dfcb/BigVideo.js
 */
// Cover repeater (max 1)
if(get_field('video')):

  while(has_sub_field('video')):

  $class  = strtolower(get_sub_field('video_class'));
  $height = get_sub_field('video_height'); // 25%, 50%, 75%, 100%
  $width  = get_sub_field('video_text_width');
  $offset = get_sub_field('video_text_offset');
  $color  = get_sub_field('video_text_color');
  $title  = get_sub_field('video_title');
  $text   = get_sub_field('video_text');
  $image  = get_sub_field('video_image');
  $mp4    = get_sub_field('video_mp4');
  $webm   = get_sub_field('video_webm');

?>

  <div class="cover-module cover-video<?php if($class) { echo ' ' . $class; } ?>" style="height:<?php if($height) { echo $height . ';'; } ?>">

    <div id="screen-1" class="cover-slide" <?php if($mp4) { echo 'data-video-mp4="' . $mp4['url'] . '"'; } if($webm) { echo 'data-video-webm="' . $webm['url'] . '"'; } if($color) { echo ' style="color:' . $color . ';"'; } ?>>

      <?php
        if($image) {
          echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" class="fullscreen-image">';
        }
      ?>

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
