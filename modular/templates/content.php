<?php
/**
 * Content module
 *
 * Include in your theme template: <?php get_template_part('modular/templates/content'); ?>
 * Loops through content: Title, Text, Image, Embed, List, Table, Gallery, Blockquote, Horizontal Line
 */
// Content repeater
while(has_sub_field('content')):

  // Title content
  if(get_row_layout() == 'title'):

  $class  = strtolower(get_sub_field('title_class')); // default, other
  $title  = get_sub_field('title');

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

  $class  = strtolower(get_sub_field('text_class')); // default, other
  $text   = get_sub_field('text');

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

  $class  = get_sub_field('image_class'); // default, other
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
      <img class="img-responsive aligncenter<?php if($layout == 'default') { echo ''; } else { echo ' ' . $layout; } ?>" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">

      <?php
      /* Example picturefill responsive image
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
    <?php echo $embed;?>
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
  // End if flexible content
  endif;

// End while flexible content
endwhile;
?>


