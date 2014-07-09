<?php
/**
 * Google Maps JavaScript API v3
 * @link https://developers.google.com/maps/documentation/javascript/tutorial
 *
 * Inlcude Google Maps API: <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWbvi54jLIjQ7ZoJgqtHG9i3ZTZu1wtfk&sensor=false"></script>
 */
?>
<div style="height:600px;">
  <div id="map-canvas" style="height:100%; width:100%"></div>
</div>

<?php
// Grab only the first term from selected taxonomies, can be helpful for determining marker icon.
function get_single_term($post_id, $taxonomy) {
  $terms = wp_get_object_terms($post_id, $taxonomy);
  if(!is_wp_error($terms)) {
    return '<a href="'.get_term_link($terms[0]->slug, $taxonomy).'">'.$terms[0]->name.'</a>';
  }
}

// Begin counter
$i = 0;

// For creating multiple, customized loops.
// http://codex.wordpress.org/Class_Reference/WP_Query
$custom_query = new WP_Query('post_type=location&posts_per_page=-1');
while($custom_query->have_posts()) : $custom_query->the_post();

  $title           = get_the_title(); // Location title
  $map             = get_field('location'); // Custom field location contains ['address'] and ['coordinates']
  $terms           = strip_tags( get_the_term_list( $post->ID, 'market', '', ' & ' )); // Get market terms and rm links
  $info            = '<strong>' . $terms . '</strong><br>' . $title; // Info window content
  $link            = get_field('link');
  if($link) {
    $info           .= '<br><a href="http://'. $link .'">'. $link .'</a>';
  }
  $location[$i][0] = $title; // Store the post title
  $location[$i][1] = $map['coordinates']; // Store the ACF coordinates
  $location[$i][2] = json_encode($info); // Store info window content
  $location[$i][3] = strip_tags( get_single_term( $post->ID, 'market' )); // Get first term for marker icon

  $i ++;

endwhile; ?>

<?php wp_reset_postdata(); // reset the query ?>

<script type="text/javascript">

function googlemap() {

  // Center map on our main location
  var myLatLng = new google.maps.LatLng(41.589841,-93.61179099999998);
  var bounds = new google.maps.LatLngBounds();

  // Create an array of styles.
  // https://developers.google.com/maps/documentation/javascript/styling
  var styles = [
    {
      stylers: [
        { saturation: -99.9 }
      ]
    }
  ];

  // Create a new StyledMapType object, passing it the array of styles,
  // as well as the name to be displayed on the map type control.
  var styledMap = new google.maps.StyledMapType(styles, {name: 'eightsevencentral'});

  // Create a map object, and include the MapTypeId to add to the map type control.
  var mapOptions = {
    mapTypeId: 'roadmap',
    center: myLatLng,
    zoom: 15,
    disableDefaultUI: true,
    scrollwheel: false,
    draggable: false
  };

  // Display a map on the page
  map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

  //Associate the styled map with the MapTypeId and set it to display.
  map.mapTypes.set('eightsevencentral', styledMap);
  map.setMapTypeId('eightsevencentral');

  // Marker icons
  typeObject = {
    "Home" : {
      "icon" : new google.maps.MarkerImage('assets/img/target.png', new google.maps.Size(28,28), new google.maps.Point(0,0), new google.maps.Point(36,14)),
      "shadow" : new google.maps.MarkerImage('http://maps.google.com/mapfiles/shadow50.png', new google.maps.Size(40,34))
    }
    //"Other" : {
    //  "icon" : new google.maps.MarkerImage('assets/img/map-marker.png', new google.maps.Size(16,26), new google.maps.Point(0,0), new google.maps.Point(8,26)),
    //  "shadow" : new google.maps.MarkerImage('http://maps.google.com/mapfiles/shadow50.png', new google.maps.Size(40,34))
    //}
  }

  // Multiple Markers
  // http://wrightshq.com/playground/placing-multiple-markers-on-a-google-map-using-api-3/
  var markers = [
    ["Eight Seven Central", 41.589841,-93.61179099999998,"Home"], // example marker object
    <?php
    if (count($location)>0) {
      foreach ($location as $key => $value){
        if ($key < (count($location)-1)){
          echo '["' . $location[$key][0] . '",' . $location[$key][1] . ',"' . $location[$key][3] . '"], ' . "\n";
        } else {
          echo '["' . $location[$key][0] . '",' . $location[$key][1] . ',"' . $location[$key][3] . '"]';
        }
      }
    }
    ?>
  ];

  // Info Window Content
  var infoWindowContent = [
    ["<strong>Eight Seven Central</strong><br>424 E Locust, Des Moines, IA 50309"], // example info window object
    <?php
    if (count($location)>0) {
      foreach ($location as $key => $value){
        if ($key < (count($location)-1)) {
          echo '[' . $location[$key][2] . '], ' . "\n";
        } else {
          echo '[' . $location[$key][2] . ']';
        }
      }
    }
    ?>
  ];

  // Display multiple markers on a map
  var infoWindow = new google.maps.InfoWindow(), marker, i;

  // Loop through our array of markers & place each one on the map
  for( i = 0; i < markers.length; i++ ) {
    var position = new google.maps.LatLng(markers[i][1], markers[i][2]); // ACF coordinates
    var icon = typeObject[markers[i][3]]['icon'];
    var shadow = typeObject[markers[i][3]]['shadow'];
    bounds.extend(position);
    marker = new google.maps.Marker({
      position: position,
      map: map,
      title: markers[i][0],
      icon: icon,
      shadow: shadow
    });

    // Allow each marker to have an info window
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infoWindow.setContent(infoWindowContent[i][0]);
        infoWindow.open(map, marker);
      }
    })(marker, i));

    // Automatically center the map fitting all markers on the screen
    map.fitBounds(bounds);
  }

  // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
  var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
    this.setZoom(15);
    google.maps.event.removeListener(boundsListener);
  });

};

// Use an event listener to load the map after the page has loaded.
google.maps.event.addDomListener(window, 'load', googlemap);

</script>
