/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function($) {

// Use this variable to set up the common and page specific functions. If you
// rename this variable, you will also need to rename the namespace below.
var Roots = {
  // All pages
  common: {
    init: function() {
      // JavaScript to be fired on all pages

      /*-----------------------------------------------------------------------------------*/
      /*  Parallax and position background image
      /*-----------------------------------------------------------------------------------*/

      // Parallax backgrounds with centered content
      // http://www.minimit.com/articles/lets-animate/parallax-backgrounds-with-centered-content

      // Use Modernizr to detect for touch devices
      isTouch = Modernizr.touch;

      if(!isTouch){
        // Fixed background on non-touchscreen devices
        $('.parallax').css('background-attachment', 'fixed');
      }

      // Fix vertical when no overflow content
      // call fullscreenFix() if .fullscreen content changes
      function fullscreenFix(){
        var h = $('.cover-module').height();
        // set .fullscreen height
        $('.cover-slide__text').each(function(i){
          if($(this).innerHeight() <= h){
            $(this).closest('.fullscreen').addClass('no-overflow');
          }
        });
      }
      $(window).resize(fullscreenFix);
      fullscreenFix();

      // Resize background images
      function backgroundResize(){
        var windowH = $(window).height();
        $('.background-image').each(function(i){
          var path = $(this);
          // variables
          var contW = path.width();
          var contH = path.height();
          var imgW = path.attr('data-img-width');
          var imgH = path.attr('data-img-height');
          var ratio = imgW / imgH;
          // overflowing difference
          var diff = parseFloat(path.attr('data-diff'));
          diff = diff ? diff : 0;
          // remaining height to have fullscreen image only on parallax
          var remainingH = 0;
          if(path.hasClass('parallax') && !isTouch){
              var maxH = contH > windowH ? contH : windowH;
              remainingH = windowH - contH;
          }
          // set img values depending on cont
          imgH = contH + remainingH + diff;
          imgW = imgH * ratio;
          // fix when too large
          if(contW > imgW){
              imgW = contW;
              imgH = imgW / ratio;
          }
          //
          path.data('resized-imgW', imgW);
          path.data('resized-imgH', imgH);
          path.css('background-size', imgW + "px " + imgH + "px");
        });
      }
      $(window).resize(backgroundResize);
      $(window).focus(backgroundResize);
      backgroundResize();

      // Set parallax background-position
      function parallaxPosition(e){
        var heightWindow = $(window).height();
        var topWindow = $(window).scrollTop();
        var bottomWindow = topWindow + heightWindow;
        var currentWindow = (topWindow + bottomWindow) / 2;
        $('.parallax').each(function(i){
          var path = $(this);
          var height = path.height();
          var top = path.offset().top;
          var bottom = top + height;
          // only when in range
          if(bottomWindow > top && topWindow < bottom){
            var imgW = path.data('resized-imgW');
            var imgH = path.data('resized-imgH');
            // min when image touch top of window
            var min = 0;
            // max when image touch bottom of window
            var max = - imgH + heightWindow;
            // overflow changes parallax
            var overflowH = height < heightWindow ? imgH - height : imgH - heightWindow; // fix height on overflow
            top = top - overflowH;
            bottom = bottom + overflowH;
            // value with linear interpolation
            var value = min + (max - min) * (currentWindow - top) / (bottom - top);
            // set background-position
            var orizontalPosition = path.attr('data-oriz-pos');
            orizontalPosition = orizontalPosition ? orizontalPosition : "50%";
            $(this).css('background-position', orizontalPosition + " " + value + "px");
          }
        });
      }
      if(!isTouch){
        $(window).resize(parallaxPosition);
        //$(window).focus(parallaxPosition);
        $(window).scroll(parallaxPosition);
        parallaxPosition();
      }



      /*-----------------------------------------------------------------------------------*/
      /*  Cover Module
      /*-----------------------------------------------------------------------------------*/

      // Global cover module vars
      var $coverContainer    = $('.cover-module');
      var $coverSlide        = $('.cover-module .cover-slide');
      var $coverSlideText    = $('.cover-module .cover-slide__text');
      var $coverScrollButton = $('.scroll-btn--down');

      // Fade in cover opacity image after images have been loaded
      $coverContainer.imagesLoaded(function(){
        $coverSlide.fadeIn(500, function() {
          $(this).animate({opacity: '1'}, 500);
        });
      });

      // Animate cover text after images have been loaded
      $coverContainer.imagesLoaded(function(){
        $coverSlideText.delay(500).fadeIn(500, function() {
          $(this).animate({opacity: '1', 'padding-top': '0'}, 500);
        });
      });

      // Animate cover scroll link after images have been loaded
      $coverContainer.imagesLoaded(function(){
        if($(window).width()<767){
          $coverScrollButton.delay(500).animate({opacity: '1', 'bottom': '0'});
        } else {
          $coverScrollButton.delay(500).animate({opacity: '1', 'bottom': '20px'});
        }
      });

      // Parallaxing calculations to the cover text on window scroll
      function coverTextParallax() {
        // Get scroll position of window
        windowScroll = $(this).scrollTop();

        // Cover text slow scroll and fade it out
        $coverSlideText.css({
          'margin-top' : (windowScroll/2)+"px",
          'opacity' : 1-(windowScroll/300)
        });
        // Scroll down button
        $coverScrollButton.css({
          'bottom' : 20-(windowScroll/4)+"px",
          'opacity' : 1-(windowScroll/200)
        });
        // Scroll right button
        $('.scroll-btn--right').css({
          'margin-top' : -21+(windowScroll/4)+"px",
          'opacity' : 1-(windowScroll/200)
        });
        // Scroll down button
        $('.scroll-btn--left').css({
          'margin-top' : -21+(windowScroll/4)+"px",
          'opacity' : 1-(windowScroll/200)
        });
      }

      // Vertically center the cover text
      function centerCoverText() {
        $coverSlideText.css({
          position: 'absolute',
          top: ($('.cover-module').height() - $coverSlideText.outerHeight())/2
        });
      }

      centerCoverText();

      if(!isTouch){
        // Parallax the cover text on larger viewports
        $(window).scroll(function(){
          coverTextParallax();
        });
        // Example: Use Scrolly.js to add data-velocty and parallax to a div
        // $('.example').attr('data-velocity', '-.2').scrolly({bgParallax: true});
      }

      $(window).resize(function(){
        // Recalc all parallaxing values if window gets large enough
        coverTextParallax();
        // Recenter the cover text on resize
        centerCoverText();
      });



      $(window).load(function() {

        /*-----------------------------------------------------------------------------------*/
        /*  Isotope: http://isotope.metafizzy.co
        /*-----------------------------------------------------------------------------------*/

        // Initializing on $(window).load rather than $(document).ready to make sure the stylesheet
        // and images/other resources that may affect the element size has been loaded before the
        // jQuery tries to access the width value.

        // Cache containers
        var $isotopeContainer = $('.isotope');
        var $isotopeFilter    = $('.filter-content');

        // Init Isotope only when images are loaded
        $isotopeContainer.imagesLoaded(function(){
          // Fade in container after imagesLoaded
          $isotopeContainer.fadeIn().isotope({
            // options
            masonry: {
              columnWidth: '.isotope-sizer'
            },
            itemSelector: '.isotope-item',
            layoutMode: 'masonry'  // 'masonry', 'fitRows', 'vertical'
          })
          // Apply Fluidbox to dynamically added elements
          .find('.isotope__fluidbox').fluidbox();

          // Filter Isotope items on click
          $('.filters').on( 'click', 'a', function( event ) {
            // Prevent link behavior on Isotope filter click
            event.preventDefault();

            $('.filters .active').removeClass('active');
            $(this).parent().addClass('active');

            var filtr = $(this).attr('data-filter');
            $isotopeFilter.isotope({
              // options
              filter: filtr
            });
          });
        });

      });

      $(document).ready(function() {

        /*-----------------------------------------------------------------------------------*/
        /*  RoyalSlider: http://dimsemenov.com/plugins/royal-slider/documentation/
        /*-----------------------------------------------------------------------------------*/

        $('.royalSlider').royalSlider({
          slidesSpacing: 0,                 // Spacing between slides in pixels.
          //startSlideId: 0,                // Start slide index
          //loop: false,                    // Makes slider to go from last slide to first.
          loopRewind: true,                 // Makes slider to go from last slide to first with rewind. Overrides prev option
          //numImagesToPreload: 4,          // Number of slides to preload on sides. If you set it to 0, only one slide will be kept in the display list at once.
          //fadeinLoadedSlide: true,        // Fades in slide after it's loaded.
          //slidesOrientation: 'horizontal', // Can be 'vertical' or 'horizontal'.
          //transitionType: 'move',         // 'move' or 'fade'. Important note about fade transition, slides must have background as only one image is animating.
          //transitionSpeed: 600,           // Slider transition speed, in ms.
          controlNavigation: 'none',        // Navigation type, can be 'bullets', 'thumbnails', 'tabs' or 'none'
          //controlsInside: true,           // If set to true adds arrows and fullscreen button inside rsOverflow container, otherwise inside root slider container..
          //arrowsNav: true,                // Direction arrows navigation.
          //
          //arrowsNavAutoHide: true,        // Auto hide arrows.
          //navigateByClick: true,          // Navigates forward by clicking on slide.
          //randomizeSlides: false,         // Randomizes all slides at start.
          //sliderDrag: true,               // Mouse drag navigation over slider.
          //sliderTouch: true,              // Touch navigation of slider.
          //keyboardNavEnabled: false,      // Navigate slider with keyboard left and right arrows.
          //fadeInAfterLoaded: true,
          //allowCSS3: true,                // Allows usage of CSS3 transitions. Might be useful if you're experiencing font-rendering problems, or other CSS3-related bugs.
          //allowCSS3OnWebkit: true,
          //addActiveClass: false,          // Adds rsActiveSlide class to current slide before transition.
          //autoHeight: false,              // Scales and animates height based on current slide. Doesn't work with properties like autoScaleSlider, imageScaleMode and imageAlignCenter.
          //easeOut: 'easeOutSine',         // Easing function of animation after ending of the swipe gesture. Read more in the easing section of the documentation.
          //easeInOut: 'easeInOutSine',     // Easing function for simple transition. Read more in the easing section of the documentation.
          //minSlideOffset: 10,             // Minimum distance in pixels to show next slide while dragging. Added in version 9.1.7.
          imageScaleMode:"fill",            // Scale mode for images. "fill", "fit", "fit-if-smaller" or "none".
          //imageAlignCenter:true,          // Aligns image to center of slide.
          //imageScalePadding: 4,           // Distance between image and edge of slide (doesn't work with 'fill' scale mode).
          //usePreloader: true,             // Enables spinning preloader, you may style it via CSS (class rsPreloader). Since 9.3 version.
          //autoScaleSlider: false,         // Automatically updates slider height based on base width.
          //autoScaleSliderWidth: 800,      // Base slider width. Slider will autocalculate the ratio based on these values.
          //autoScaleSliderHeight: 400,     // Base slider height
          //autoScaleHeight: true,
          //arrowsNavHideOnTouch: false,    // Hides arrows completely on touch devices.
          //globalCaption: false,           // Adds global caption element to slider, read more in the global caption section of documentation.
          autoPlay: {
            //enabled: false,               // Enable autoplay or not.
            //stopAtAction: true,           // Stop autoplay at first user action.
            //pauseOnHover: true,           // Pause autoplay on hover.
            //delay: 3000                   // Delay between items in ms.
          }
        });


        // Extending slider prototype. Override any function
        // http://dimsemenov.com/plugins/royal-slider/documentation/#api
        // Throwing errors when no royalSliders are present, so ensure we have one in the DOM
        var sliders = $('.royalSlider').length;
        if(sliders >= 1) {
          // initialize slider as usual and save it's object
          var slider = $('.royalSlider').royalSlider({
            // options
          }).data('royalSlider');

          // extend slider object
          slider.ev.on('rsVideoPlay', function() {
            // hide scroll button on play video
            $('.scroll-btn--down').addClass('hidden');
          });

          slider.ev.on('rsVideoStop', function() {
            // show scroll button on stop video
            $('.scroll-btn--down').removeClass('hidden');
          });
        }



        /*-----------------------------------------------------------------------------------*/
        /*  Responsive video and lightbox
        /*-----------------------------------------------------------------------------------*/

        // FitVids: https://github.com/davatron5000/FitVids.js
        $('body').fitVids();

        // Fluidbox Images: https://github.com/terrymun/Fluidbox
        $('.fluidbox').fluidbox();



        /*-----------------------------------------------------------------------------------*/
        /*  FlexSlider 2: http://www.woothemes.com/flexslider
        /*-----------------------------------------------------------------------------------*/

        // Note: Bootstrap scrollspy works better with flexlider on document ready.
        $('.gallery-module .flexslider').flexslider({
          //namespace: "flex-",             //{NEW} String: Prefix string attached to the class of every element generated by the plugin
          //selector: ".slides > li",       //{NEW} Selector: Must match a simple pattern. '{container} > {slide}' -- Ignore pattern at your own peril
          animation: "slide",               //String: Select your animation type, "fade" or "slide"
          //easing: "swing",                //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
          //direction: "horizontal",        //String: Select the sliding direction, "horizontal" or "vertical"
          //reverse: false,                 //{NEW} Boolean: Reverse the animation direction
          //animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
          //smoothHeight: false,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
          //startAt: 0,                     //Integer: The slide that the slider should start on. Array notation (0 = first slide)
          //slideshow: true,                //Boolean: Animate slider automatically
          //slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
          //animationSpeed: 600,            //Integer: Set the speed of animations, in milliseconds
          //initDelay: 0,                   //{NEW} Integer: Set an initialization delay, in milliseconds
          //randomize: false,               //Boolean: Randomize slide order

          // Usability features
          //pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
          //pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
          //useCSS: true,                   //{NEW} Boolean: Slider will use CSS3 transitions if available
          //touch: true,                    //{NEW} Boolean: Allow touch swipe navigation of the slider on touch-enabled devices
          //video: false,                   //{NEW} Boolean: If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches

          // Primary Controls
          controlNav: true,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
          directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
          prevText: '<i class="fa fa-angle-left fa-3x"></i>',           //String: Set the text for the "previous" directionNav item
          nextText: '<i class="fa fa-angle-right fa-3x"></i>',          //String: Set the text for the "next" directionNav item

          // Secondary Navigation
          //keyboard: true,                 //Boolean: Allow slider navigating via keyboard left/right keys
          //multipleKeyboard: false,        //{NEW} Boolean: Allow keyboard navigation to affect multiple sliders. Default behavior cuts out keyboard navigation with more than one slider present.
          //mousewheel: false,              //{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
          //pausePlay: false,               //Boolean: Create pause/play dynamic element
          //pauseText: 'Pause',             //String: Set the text for the "pause" pausePlay item
          //playText: 'Play',               //String: Set the text for the "play" pausePlay item

          // Special properties
          //controlsContainer: "",          //{UPDATED} Selector: USE CLASS SELECTOR. Declare which container the navigation elements should be appended too. Default container is the FlexSlider element. Example use would be ".flexslider-container". Property is ignored if given element is not found.
          //manualControls: "",             //Selector: Declare custom control navigation. Examples would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
          //sync: "",                       //{NEW} Selector: Mirror the actions performed on this slider with another slider. Use with care.
          //asNavFor: "",                   //{NEW} Selector: Internal property exposed for turning the slider into a thumbnail navigation for another slider

          // Carousel Options
          //itemWidth: 0,                   //{NEW} Integer: Box-model width of individual carousel items, including horizontal borders and padding.
          //itemMargin: 0,                  //{NEW} Integer: Margin between carousel items.
          //minItems: 0,                    //{NEW} Integer: Minimum number of carousel items that should be visible. Items will resize fluidly when below this.
          //maxItems: 0,                    //{NEW} Integer: Maxmimum number of carousel items that should be visible. Items will resize fluidly when above this limit.
          //move: 0,                        //{NEW} Integer: Number of carousel items that should move on animation. If 0, slider will move all visible items.

          // Callback API
          //start: function(){},            //Callback: function(slider) - Fires when the slider loads the first slide
          //before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
          //after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
          //end: function(){},              //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
          //added: function(){},            //{NEW} Callback: function(slider) - Fires after a slide is added
          //removed: function(){}           //{NEW} Callback: function(slider) - Fires after a slide is removed
        });

        $('.blockquote-module .flexslider')
        .flexslider({
          animation: 'fade',
          directionNav: false
        });



        /*-----------------------------------------------------------------------------------*/
        /*  Header
        /*-----------------------------------------------------------------------------------*/

        // Global navbar vars
        var windowScroll;
        var $navbarContainer = $('.navbar');
        var navbarHeight    = 50;
        var animate         = 'down';

        // Add scrolling class to navbar on window scroll
        $(window).scroll(function() {
          // Get scroll position of window
          windowScroll = $(this).scrollTop();

          if(windowScroll >= $('.main').offset().top-(navbarHeight+1)){
            $navbarContainer.addClass('navbar-scrolling');
          }
          if(windowScroll < $('.main').offset().top-(navbarHeight+1)){
            $navbarContainer.removeClass('navbar-scrolling');
          }

          if (windowScroll >= $('.main').offset().top-(navbarHeight+1) && animate === 'down') {
            animate='up';
            $('.navbar-hidden').stop().animate({top:'0'}, 300);
          }
          if(windowScroll < $('.main').offset().top-(navbarHeight+1) && animate === 'up'){
            animate='down';
            $('.navbar-hidden').stop().animate({top:-(navbarHeight+1)}, 300);
          }
        });

        // Bootstrap scrollspy
        $('body').attr('id', 'top').scrollspy({ target: '.navbar nav', offset: (navbarHeight+1)});

        // Recalculate scrollspy offsets on resize
        $(window).resize(function() {
          $('[data-spy="scroll"]').each(function () {
            var $spy = $(this).scrollspy('refresh');
          });
        });

        // Make bootstrap menu dropdown on hover rather than click
        // http://stackoverflow.com/questions/8878033/how-to-make-twitter-bootstrap-menu-dropdown-on-hover-rather-than-click
        $(function() {
          $('.navbar .dropdown').hover(
            function(){
              $(this).addClass('open');
            },
            function(){
              $(this).removeClass('open');
            }
          );
        });

        /*-----------------------------------------------------------------------------------*/
        /*  Smooth Scroll: Navbar and scroll buttons
        /*-----------------------------------------------------------------------------------*/

        $('.navbar nav li').bind('click',function(event){
          var anchor = $(this).find('a');

          $('html, body').stop().animate({
            scrollTop: $(anchor.attr('href')).offset().top-navbarHeight
          }, 1500,'easeInOutExpo');

          // If Mobile hide navbar on select
          if($(window).width()<=767){
            $('.navbar nav').removeClass('in');
            $('.navbar nav').addClass('collapse');
          }

          event.preventDefault();
        });

        $('.scroll-btn--up').bind('click',function(event){
          var anchor = $(this);

          $('html, body').stop().animate({
            scrollTop: $(anchor.attr('href')).offset().top-0
          }, 1500,'easeInOutExpo');

          // If Mobile hide navbar on select
          if($(window).width()<=767){
            $('.navbar nav').removeClass('in');
            $('.navbar nav').addClass('collapse');
          }

          event.preventDefault();
        });

        $('.scroll-btn--down').bind('click',function(event){
            var anchor = $(this);

            $('html, body').stop().animate({
                scrollTop: $(anchor.attr('href')).offset().top-navbarHeight
            }, 1500,'easeInOutExpo');

            // If Mobile hide navbar on select
            if($(window).width()<=767){
              $('.navbar nav').removeClass('in');
              $('.navbar nav').addClass('collapse');
            }

            event.preventDefault();
        });

      });
    }
  },
  // Home page
  home: {
    init: function() {
      // JavaScript to be fired on the home page
    }
  },
  // About us page, note the change from about-us to about_us.
  about_us: {
    init: function() {
      // JavaScript to be fired on the about us page
    }
  }
};

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
var UTIL = {
  fire: function(func, funcname, args) {
    var namespace = Roots;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {
    UTIL.fire('common');

    $.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
    });
  }
};

$(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
