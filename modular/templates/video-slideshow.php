<?php
/**
 * Video slideshow module
 *
 * Include in your theme template: <?php get_template_part('modular/templates/video', 'slideshow'); ?>
 * Fullscreen ambient video slideshow, @link https://github.com/dfcb/BigVideo.js. Requires bv-slider.js.
 * @example http://tympanus.net/codrops/2012/09/19/fullscreen-video-slideshow-with-bigvideo-js/
 */
// Cover repeater (max 1)
if(get_field('video_slideshow')):

  while(has_sub_field('video_slideshow')):

  $class  = strtolower(get_sub_field('video_slideshow_class')); // default, hidden, other
  $height = get_sub_field('video_slideshow_height'); // default, 50%, 100%, other

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
