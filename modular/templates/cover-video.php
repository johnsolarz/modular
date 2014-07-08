<?php
/**
 * Cover video module. Fullscreen ambient video with bigvideo.js.
 *
 * Requires ACF, addons and fields: @see fields.php
 * - Advanced Custom Fields (http://www.advancedcustomfields.com)
 * - ACF Repeater Field (http://www.advancedcustomfields.com/add-ons/repeater-field)
 * - ACF Flexible Content Field (http://www.advancedcustomfields.com/add-ons/flexible-content-field)
 *
 * Requires jQuery plugins and scripts: @see _main.js
 * - video.js (https://github.com/videojs/video.js/blob/stable/docs/guides/setup.md)
 * - bigVideo.js (https://github.com/dfcb/BigVideo.js)
 * - jQuery 1.7.2 or higher
 * - jQuery UI slider 1.8.22 or higher
 * - Video.js 3.2 or higher
 * - imagesloaded 2.1.1 or higher
 * - bv-slider.js
 */
// Cover repeater (max 1)
if(get_field('cover_video')):

  while(has_sub_field('cover_video')):

  $class  = strtolower(get_sub_field('cover_video_class')); // default, hidden, other
  $height = get_sub_field('cover_video_height'); // default, 50%, 100%, other
  $width  = get_sub_field('cover_video_text_width');
  $offset = get_sub_field('cover_video_text_offset');
  $color  = get_sub_field('cover_video_text_color');
  $title  = get_sub_field('cover_video_title'); // title, none, other
  $text   = get_sub_field('cover_video_text'); // excerpt, none, other
  $image  = get_sub_field('cover_video_image');
  $mp4    = get_sub_field('cover_video_mp4');
  $webm   = get_sub_field('cover_video_webm');

  if($class != 'hidden'):
?>

  <div class="cover-module cover-video<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>" style="height:<?php if($height == 'default') { echo '100%;'; } else { echo $height . ';'; } ?>">

    <div id="screen-1" class="cover-slide" <?php if($mp4) { echo 'data-video-mp4="' . $mp4['url'] . '"'; } if($webm) { echo 'data-video-webm="' . $webm['url'] . '"'; } if($color) { echo ' style="color:' . $color . ';"'; } ?>>

      <?php
        if($image) {
          echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" class="fullscreen-image">';
        }
      ?>

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
