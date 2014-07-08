<?php
/**
 * Cover video slideshow module. Fullscreen ambient video slideshow with bigvideo.js.
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
if(get_field('cover_video_slideshow')):

  while(has_sub_field('cover_video_slideshow')):

  $class  = strtolower(get_sub_field('cover_video_slideshow_class')); // default, hidden, other
  $height = get_sub_field('cover_video_slideshow_height'); // default, 50%, 100%, other

  if($class != 'hidden'):
?>

  <div class="cover-module cover-video--slideshow<?php if($class == 'default') { echo ''; } else { echo ' ' . $class; } ?>" style="height:<?php if($height == 'default') { echo '100%;'; } else { echo $height . ';'; } ?>">

    <div class="wrapper">

    <?php
      // Slide repeater
      if(get_sub_field('slide')):

        // Begin number of screens
        $i = 1;

        while(has_sub_field('slide')):

        $width  = get_sub_field('slide_text_width');
        $offset = get_sub_field('slide_text_offset');
        $color  = get_sub_field('slide_text_color');
        $title  = get_sub_field('slide_title'); // (image) title, none, other
        $text   = get_sub_field('slide_text'); // (image) caption, none, other
        $image  = get_sub_field('slide_image');
        $mp4    = get_sub_field('slide_video_mp4');
        $webm   = get_sub_field('slide_video_webm');
      ?>

        <div id="screen-<?php echo $i; ?>" class="cover-slide" <?php if($mp4) { echo 'data-video-mp4="' . $mp4['url'] . '"'; } if($webm) { echo 'data-video-webm="' . $webm['url'] . '"'; } if($color) { echo ' style="color:' . $color . ';"'; } ?>>

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

      <?php
        // Count number of slides
        $i++;

        // End while slide repeater
        endwhile;

      // End while slide repeater
      endif;
      ?>

    </div>

    <?php
      // Show scroll navigation if there's more than one slide
      $slide = get_sub_field('slide');
      if($slide[1]) {
        echo '<a class="scroll-btn scroll-btn--right" href="#"><i class="fa fa-angle-right fa-3x"></i></a>';
        echo '<a class="scroll-btn scroll-btn--left" href="#"><i class="fa fa-angle-left fa-3x"></i></a>';
      }
    ?>

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
