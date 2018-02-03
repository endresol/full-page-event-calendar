<?php

function fpec_display_fullpage_calendar($atts, $content) {
  global $fpec_options;

  $atts = shortcode_atts( array(
		'month' => 'next'
	), $atts, 'fpec_calendar' );

  $showimages = $fpec_options['image_enabled'] == true;
  $theme = $fpec_options['theme'];

  $current_month_first = strtotime('first day of this month');
  $current_month_last = strtotime('last day of this month');

  $args = array(
    'posts_per_page' => -1,
    'post_type' => 'fpec_event',
    'meta_query' => array (
      'relation' => 'AND',
      array (
         'key'     => 'fpec_event_startdate',
         'value'   => $current_month_first,
         'compare' => '>'
      ),
      array (
        'key'     => 'fpec_event_startdate',
        'value'   => $current_month_last,
        'compare' => '<'
      ),
    ),
  );

  $posts = get_posts( $args );

  ob_start(); ?>
  <h2> <?php echo $content . ' ' . $current_month ; ?> </h2>

<?php
  if ($posts) {
    global $post;
    foreach ($posts as $post){
      setup_postdata($post);

      // - custom variables -
      $custom = get_post_custom(get_the_ID());
      $sd = $custom["fpec_event_startdate"][0];
      $ed = $custom["fpec_event_enddate"][0];

      // - determine if it's a new day -
      $longdate = date("l, F j, Y", $sd);
      if ($daycheck == null) { echo '<h2 class="full-events">' . $longdate . '</h2>'; }
      if ($daycheck != $longdate && $daycheck != null) { echo '<h2 class="full-events">' . $longdate . '</h2>'; }

      // - local time format -
      $time_format = get_option('time_format');
      $stime = date($time_format, $sd);
      $etime = date($time_format, $ed);
    }
  }
?>

  <p>Follow me on <a class="twitter" href="<?php echo $fpec_options['twitter_url']; ?>">Twitter</a></p>

  <?php
  return ob_get_clean();
}

add_shortcode( 'fpec_calendar', 'fpec_display_fullpage_calendar' );

?>
