<?php
/**
 * Register options pages
 */
if(function_exists('acf_add_options_page')) {

  acf_add_options_page();
  acf_add_options_sub_page('Colors');
  acf_add_options_sub_page('Footer');
  acf_add_options_sub_page('Logo');
  acf_add_options_sub_page('Social Media');
  acf_add_options_sub_page('Typography');

}

/**
 * Load options page styles in head: Colors, Logo, Typography
 */
function acf_options_page_styles() {

  // Colors
  $bodyBg               = get_field('body_background', 'option');
  $textColor            = get_field('text_color', 'option');
  $linkColor            = get_field('link_color', 'option');
  $linkHoverColor       = get_field('link_hover_color', 'option');
  $navbarBg             = get_field('navbar_background', 'option');
  $navbarBorder         = get_field('navbar_border_color', 'options');
  $navbarLinkColor      = get_field('navbar_link_color', 'option');
  $navbarLinkHoverColor = get_field('navbar_link_hover_color', 'option');
  $footerBg             = get_field('footer_background', 'option');
  $footerTextColor      = get_field('footer_text_color', 'option');
  $footerLinkColor      = get_field('footer_link_color', 'option');
  $footerLinkHoverColor = get_field('footer_link_hover_color', 'option');

  // Typography
  $webFontSnippet       = get_field('web_font_snippet', 'option');
  $fontFamily           = get_field('font_family', 'option');
  $headingsFontFamily   = get_field('headings_font_family', 'option');

  // Navbar
  $navbarLogo           = get_field('navbar_logo', 'option');
  $navbarLogoWidth      = get_field('navbar_logo_display_width', 'option');
  $navbarLogoHeight     = get_field('navbar_logo_display_height', 'option');

  // Load webfont snippet
  if($webFontSnippet){
    echo $webFontSnippet;
  } ?>

  <style>
    <?php if($fontFamily || $textColor || $bodyBg) { ?>
      body { <?php if($fontFamily) { echo 'font-family:' . $fontFamily . ';'; } if($textColor) { echo 'color:' . $textColor . ';'; } if($bodyBg) { echo 'background-color:' . $bodyBg . ';'; } ?> }
    <?php }
    if($linkColor) { ?>
      a { color: <?php echo $linkColor; ?>; }
    <?php }
    if($linkHoverColor) { ?>
      a:hover, a:focus { color: <?php echo $linkHoverColor; ?>; }
    <?php }
    if($headingsFontFamily) { ?>
      h1,h2,h3,h4,h5,h6 { font-family: <?php echo $headingsFontFamily; ?>; }
    <?php }
    if($navbarBg || $navbarBorder) { ?>
      .navbar { <?php if($navbarBg) { echo 'background-color:' . $navbarBg . ';'; } if($navbarBorder) { echo 'border-color:' . $navbarBorder . ';'; } ?> }
    <?php }
    if($navbarLinkColor) { ?>
      .navbar .navbar-nav > li > a { color: <?php echo $navbarLinkColor; ?>; }
    <?php }
    if($navbarLinkHoverColor) { ?>
      .navbar .navbar-nav > li > a:hover, .navbar .navbar-nav>li>a:focus { color: <?php echo $navbarLinkHoverColor; ?>; }
    <?php }
    // CSS3 retina first navbar logo
    if($navbarLogo) { ?>
      .navbar-brand { background-image: url('<?php echo $navbarLogo['url']; ?>'); background-size: <?php echo $navbarLogoWidth . 'px ' . $navbarLogoHeight . 'px'; ?>; background-repeat: no-repeat; display: block; overflow: hidden; padding: 0; text-indent: -9999px; width: <?php echo $navbarLogoWidth; ?>px; height: <?php echo $navbarLogoHeight; ?>px; }
    <?php }
    if($footerBg || $footerTextColor) { ?>
      .content-info { <?php if($footerBg) { echo 'background-color:' . $footerBg . ';'; } if($footerTextColor) { echo 'color:' . $footerTextColor . ';'; } ?> }
    <?php }
    if($footerLinkColor) { ?>
      .content-info a { color: <?php echo $footerLinkColor; ?>; }
    <?php }
    if($footerLinkHoverColor) { ?>
      .content-info a:hover, .content-info a:focus { color: <?php echo $footerLinkHoverColor; ?>; }
    <?php } ?>
  </style>

<?php
}
add_action('wp_head', 'acf_options_page_styles');

/**
 * Display social media sharing buttons and load scripts in footer
 */
// Social media share button options (T/F)
$facebook_share  = get_field('facebook_share', 'option');
$google_share    = get_field('google_share', 'option');
$linkedin_share  = get_field('linkedin_share', 'option'); // Inline in social-sharing.php
$pinterest_share = get_field('pinterest_share', 'option');
$twitter_share   = get_field('twitter_share', 'option');

// Output scripts in footer
//
// HTML tags should be in the templates when possible:
// https://github.com/retlehs/roots/pull/554
if ($facebook_share) {
  function facebook_share_script() {
    echo "\n\t<div id=\"fb-root\"></div>\n";
    echo "\n\t<script>(function(d, s, id) {\n";
    echo "\t\tvar js, fjs = d.getElementsByTagName(s)[0];\n";
    echo "\t\tif (d.getElementById(id)) return;\n";
    echo "\t\tjs = d.createElement(s); js.id = id;\n";
    echo "\t\tjs.src = \"//connect.facebook.net/en_US/all.js#xfbml=1\";\n";
    echo "\t\tfjs.parentNode.insertBefore(js, fjs);\n";
    echo "\t\t}(document, 'script', 'facebook-jssdk'));</script>\n";
  }
  add_action('wp_footer', 'facebook_share_script');
}

if ($google_share) {
  function google_share_script() {
    echo "\n\t<script type=\"text/javascript\">\n";
    echo "\t\t(function() {\n";
    echo "\t\tvar po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;\n";
    echo "\t\tpo.src = 'https://apis.google.com/js/plusone.js';\n";
    echo "\t\tvar s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);\n";
    echo "\t\t})();\n";
    echo "\t</script>\n";
  }
  add_action('wp_footer', 'google_share_script');
}

if ($pinterset_share) {
  function pinterset_share_script() {
    echo "\n\t<script type=\"text/javascript\" src=\"//assets.pinterest.com/js/pinit.js\">\n";
    echo "\t</script>\n";
  }
  add_action('wp_footer', 'pinterset_share_script');
}

if ($twitter_share) {
  function twitter_share_script() {
    echo "\n\t<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=\"//platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);}}(document,\"script\",\"twitter-wjs\");</script>";
  }
  add_action('wp_footer', 'twitter_share_script');
}
