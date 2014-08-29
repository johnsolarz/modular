<?php
/**
 * Social media links module
 *
 * Include in your theme: <?php get_template_part('modular/templates/social', 'links'); ?>
 */
// URL values
$facebook_link  = get_field('facebook_link', 'option');
$facebook_text  = get_field('facebook_link_text', 'option');
$google_link    = get_field('google_link', 'option');
$google_text    = get_field('google_link_text', 'option');
$houzz_link     = get_field('houzz_link', 'option');
$houzz_text     = get_field('houzz_link_text', 'option');
$linkedin_link  = get_field('linkedin_link', 'option');
$linkedin_text  = get_field('linkedin_link_text', 'option');
$pinterest_link = get_field('pinterest_link', 'option');
$pinterest_text = get_field('pinterest_link_text', 'option');
$twitter_link   = get_field('twitter_link', 'option');
$twitter_text   = get_field('twitter_link_text', 'option');
$instagram_link = get_field('instagram_link', 'option');
$instagram_text = get_field('instagram_link_text', 'option');
$youtube_link   = get_field('youtube_link', 'option');
$youtube_text   = get_field('youtube_link_text', 'option');
$vimeo_link     = get_field('vimeo_link', 'option');
$vimeo_text     = get_field('vimeo_link_text', 'option');
$email_link     = get_field('email_link', 'option');
$email_text     = get_field('email_link_text', 'option');

echo '<div class="social-links-module">';
echo '<ul class="list-inline">';
if($facebook_link) {
  echo '<li><a href="' . $facebook_link . '"><i class="fa fa-facebook-square"></i>' . (($facebook_text)?' ' . $facebook_text:'') . '</a></li>';
}
if($google_link) {
  echo '<li><a href="' . $google_link . '"><i class="fa fa-google-plus-square"></i>' . (($google_text)?' ' . $google_text:'') . '</a></li>';
}
if($houzz_link) {
  echo '<li><a href="' . $houzz_link . '"><i class="fa fa-home"></i>' . (($houzz_text)?' ' . $houzz_text:'') . '</a></li>';
}
if($linkedin_link) {
  echo '<li><a href="' . $linkedin_link . '"><i class="fa fa-linkedin-square"></i>' . (($linkedin_text)?' ' . $linkedin_text:'') . '</a></li>';
}
if($pinterest_link) {
  echo '<li><a href="' . $pinterest_link . '"><i class="fa fa-pinterest-square"></i>' . (($pinterest_text)?' ' . $pinterest_text:'') . '</a></li>';
}
if($twitter_link) {
  echo '<li><a href="' . $twitter_link . '"><i class="fa fa-twitter"></i>' . (($twitter_text)?' ' . $twitter_text:'') . '</a></li>';
}
if($instagram_link) {
  echo '<li><a href="' . $instagram_link . '"><i class="fa fa-instagram"></i>' . (($instagram_text)?' ' . $instagram_text:'') . '</a></li>';
}
if($youtube_link) {
  echo '<li><a href="' . $youtube_link . '"><i class="fa fa-youtube"></i>' . (($youtube_text)?' ' . $youtube_text:'') . '</a></li>';
}
if($vimeo_link) {
  echo '<li><a href="' . $vimeo_link . '"><i class="fa fa-vimeo-square"></i>' . (($vimeo_text)?' ' . $vimeo_text:'') . '</a></li>';
}
if($email_link) {
  echo '<li><a href="' . $email_link . '"><i class="fa fa-envelope"></i>' . (($email_text)?' ' . $email_text:'') . '</a></li>';
}
echo '</ul>';
echo '</div>';
?>
