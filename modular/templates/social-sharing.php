<?php
/**
 * Social media sharing buttons module
 *
 * Include in your theme: <?php get_template_part('modular/templates/social', 'sharing'); ?>
 */
// Social media share button options (T/F)
$facebook_share  = get_field('facebook_share', 'option');
$google_share    = get_field('google_share', 'option');
$houzz_share     = get_field('houzz_share', 'option');
$linkedin_share  = get_field('linkedin_share', 'option');
$pinterest_share = get_field('pinterest_share', 'option');
$twitter_share   = get_field('twitter_share', 'option');

// Grab twitter handle from the link value
$twitter_link        = get_field('twitter_link', 'option');
$twitter_handle_opts = array('https://twitter.com/','http://twitter.com/');
$twitter_handle      = str_replace( $twitter_handle_opts,'', $twitter_link  );

// Other useful post info
$title     = get_the_title();
$permalink = get_permalink();

if ($facebook_share || $google_share || $houzz_share || $linkedin_share || $pinterset_share || $twitter_share) :
?>
  <div class="social-sharing-module">
    <div class="inner">
      <ul class="list-inline">
        <?php
          if ($google_share) {
            echo '<li><div class="g-plusone" data-size="medium" data-href="' . $permalink . '" data-annotation="none"></div></li>';
          }
          if ($houzz_share) {
            echo '<li><a class="houzz-share-button" data-url="' . $permalink . '" data-hzid="Your HZID" data-title="' . $title . '" data-img="http://yoursite/path/to/product/image.jpg " data-desc="Product description text " data-category="Category keywords " data-showcount="1 " href="http://www.houzz.com">Houzz</a></li>';
          }
          if ($linkedin_share) {
            echo '<li><script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script><script type="IN/Share"></script></li>';
          }
          if ($pinterest_share) {
            echo '<li><a href="//pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" ><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a></li>';
          }
          if ($twitter_share) {
            echo '<li><a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-via="' . $twitter_handle . '" data-text="' . $title . '">Tweet</a></li>';
          }
          // fb-like button takes longest to load
          if ($facebook_share) {
            echo '<li><div class="fb-like" data-href="' . $permalink . '" data-send="false" data-layout="button_count" data-show-faces="false" data-colorscheme="light" data-font="arial"></div></li>';
          }
        ?>
      </ul>
    </div>
  </div>
<?php endif; ?>
