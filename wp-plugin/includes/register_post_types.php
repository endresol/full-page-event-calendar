<?php

function fpec_register_event_post_type() {
  $labels = array(
		'name'               => _x( 'Events', 'post type general name', 'fpec_domain' ),
		'singular_name'      => _x( 'Event', 'post type singular name', 'fpec_domain' ),
		'menu_name'          => _x( 'Events', 'admin menu', 'fpec_domain' ),
		'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'fpec_domain' ),
		'add_new'            => _x( 'Add New', 'Event', 'fpec_domain' ),
		'add_new_item'       => __( 'Add New Event', 'fpec_domain' ),
		'new_item'           => __( 'New Event', 'fpec_domain' ),
		'edit_item'          => __( 'Edit Event', 'fpec_domain' ),
		'view_item'          => __( 'View Event', 'fpec_domain' ),
		'all_items'          => __( 'All Events', 'fpec_domain' ),
		'search_items'       => __( 'Search Events', 'fpec_domain' ),
		'parent_item_colon'  => __( 'Parent Events:', 'fpec_domain' ),
		'not_found'          => __( 'No Events found.', 'fpec_domain' ),
		'not_found_in_trash' => __( 'No Events found in Trash.', 'fpec_domain' )
	);

	$args = array(
		'labels'             => $labels,
    'description'        => __( 'Description.', 'fpec_domain' ),
		'public'             => true,
    'show_in_rest'       => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'fpecevent' ),
		'capability_type'    => 'post',
    'menu_icon'          => 'dashicons-calendar-alt',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
    'taxonomies'         => array( 'fpec_eventcategory', 'post_tag')
	);
  register_post_type('fpec_event', $args);
}
add_action('init', 'fpec_register_event_post_type');


function fpec_register_eventcategory_taxonomy() {
  $labels = array(
      'name' => _x( 'Categories', 'taxonomy general name', 'fpec_domain' ),
      'singular_name' => _x( 'Category', 'taxonomy singular name', 'fpec_domain' ),
      'search_items' =>  __( 'Search Categories', 'fpec_domain' ),
      'popular_items' => __( 'Popular Categories', 'fpec_domain' ),
      'all_items' => __( 'All Categories', 'fpec_domain' ),
      'parent_item' => null,
      'parent_item_colon' => null,
      'edit_item' => __( 'Edit Category', 'fpec_domain' ),
      'update_item' => __( 'Update Category', 'fpec_domain' ),
      'add_new_item' => __( 'Add New Category', 'fpec_domain' ),
      'new_item_name' => __( 'New Category Name', 'fpec_domain' ),
      'separate_items_with_commas' => __( 'Separate categories with commas', 'fpec_domain' ),
      'add_or_remove_items' => __( 'Add or remove categories', 'fpec_domain' ),
      'choose_from_most_used' => __( 'Choose from the most used categories', 'fpec_domain' ),
  );

  register_taxonomy('fpec_eventcategory','fpec_event', array(
      'label' => __('Event Category', 'fpec_register_event_post_type', 'fpec_domain'),
      'labels' => $labels,
      'hierarchical' => true,
      'show_ui' => true,
      'query_var' => true,
      'rewrite' => array( 'slug' => 'event-category' ),
  ));
}
add_action( 'init', 'fpec_register_eventcategory_taxonomy', 0 );

function fpec_event_edit_columns($columns) {
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __('Event', 'fpec_domain'),
    'fpec_column_event_category' => __('Category', 'fpec_domain'),
    'fpec_column_event_dates' => __('Dates', 'fpec_domain'),
    'fpec_column_event_times' => __('Times', 'fpec_domain'),
    'fpec_column_event_thumbnail' => __('Thumbnail', 'fpec_domain'),
    'fpec_column_event_description' => __('Description', 'fpec_domain'),
  );
  return $columns;
}
add_filter('manage_fpec_event_posts_columns' , 'fpec_event_edit_columns');


function fpec_event_custom_columns($column) {
  global $post;
  $custom = get_post_custom();
  switch($column) {
    case 'fpec_column_event_category':
      $eventcats =   get_the_terms($post->ID, 'fpec_eventcategory');
      $eventcats_html = array();
      if ($eventcats) {
        foreach ($eventcats as $eventcat) {
          array_push($eventcats_html, $eventcat->name);
        }
        echo implode($eventcats_html, ', ');
      } else {
        _e('None', 'fpec_domain');
      }
    break;

    case 'fpec_column_event_dates':
      $startdate = $custom['fpec_event_startdate'][0];
      $enddate = $custom['fpec_event_enddate'][0];
      $startdatestring = date('F  j, Y', $startdate);
      $enddatestring = date('F j, Y', $enddate);
      echo $startdatestring . '<br /><em>' . $enddatestring .'</em>';
    break;

    case 'fpec_column_event_times':
      $startdate = $custom['fpec_event_startdate'][0];
      $enddate = $custom['fpec_event_enddate'][0];
      $time_format = get_option('time_format');
      $starttimestring = date($time_format, $startdate);
      $endtimestring = date($time_format, $enddate);
      echo $starttimestring . '<br /><em>' . $endtimestring .'</em>';
    break;

    case 'fpec_column_event_thumbnail':
      echo '<div>';
      $thumbnail = get_the_post_thumbnail( $post->ID, 'thumbnail' );
      echo $thumbnail;
      echo '</div>';
    break;

    case 'fpec_column_event_description':
      the_excerpt();
    break;
  }
}
add_action('manage_posts_custom_column', 'fpec_event_custom_columns');

function fpec_event_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $meta_startdate = $custom['fpec_event_startdate'][0];
  $meta_enddate = $custom['fpec_event_enddate'][0];
  $meta_starttime = $meta_startdate;
  $meta_endtime = $meta_enddate;

  $date_format = get_option('date_format');
  $time_format = get_option('time_format');

  if ($meta_startdate == null ) {
    $meta_startdate = time();
    $meta_enddate = $meta_startdate;
    $meta_starttime = 0;
    $meta_endtime = 0;
  };

  $clean_startdate = date("D, M d, Y", $meta_startdate);
  $clean_enddate = date("D, M d, Y", $meta_enddate);
  $clean_starttime = date($time_format, $meta_starttime);
  $clean_endtime = date($time_format, $meta_endtime);

  echo '<input type="hidden" name="fpec-event-nonce" id="fpec-event-nonce" value="' .
    wp_create_nonce( 'fpec-event-nonce' ) . '" />';

?>
  <div class="fpec_meta">
    <ul>
      <li><label>Start Date</label><input name="fpec_event_startdate" class="fpec_date" value="<?php echo $clean_startdate; ?>" /></li>
      <li><label>Start Time</label><input name="fpec_event_starttime" value="<?php echo $clean_starttime; ?>" /><em>Use 24h format (7pm = 19:00)</em></li>
      <li><label>End Date</label><input name="fpec_event_enddate" class="fpec_date" value="<?php echo $clean_enddate; ?>" /></li>
      <li><label>End Time</label><input name="fpec_event_endtime" value="<?php echo $clean_endtime; ?>" /><em>Use 24h format (7pm = 19:00)</em></li>
  </ul>
  </div>
<?php
}

function fpec_event_meta_create() {
  add_meta_box('fpec_event_meta', 'Events', 'fpec_event_meta', 'fpec_event');
}
add_action( 'admin_init', 'fpec_event_meta_create' );


function fpec_save_event() {
  global $post;

  if ( !wp_verify_nonce( $_POST['fpec-event-nonce'], 'fpec-event-nonce') )
    return $post->ID;

  if ( !current_user_can('edit_post', $post->ID) )
    return $post->ID;

  if ( !isset( $_POST['fpec_event_startdate']) ) {
    return $post;
  }
  $newstartdatetime = strtotime ( $_POST["fpec_event_startdate"] . $_POST["fpec_event_starttime"] );
  update_post_meta( $post->ID, 'fpec_event_startdate', $newstartdatetime);

  if ( !isset( $_POST['fpec_event_enddate']) ) {
    return $post;
  }
  $newenddatetime = strtotime ( $_POST["fpec_event_enddate"] . $_POST["fpec_event_endtime"] );
  update_post_meta( $post->ID, 'fpec_event_enddate', $newenddatetime);

}
add_action('save_post', 'fpec_save_event');

// function create_api_fpec_event_meta_field() {
//     // register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() )
//     register_rest_field( 'fpec_event', 'post-meta-fields', array(
//            'get_callback'    => 'get_post_meta_for_api',
//            'schema'          => null,
//         )
//     );
// }
// add_action( 'rest_api_init', 'create_api_fpec_event_meta_field' );
//
// function get_post_meta_for_api( $object ) {
//     //get the id of the post object array
//     $post_id = $object['id'];
//
//     //return the post meta
//     return get_post_meta( $post_id );
// }


// TODO: move this in to rest-api.php file

function fpec_get_post_meta_date_cb( $object, $field_name, $request ) {
    $timestamp = get_post_meta( $object[ 'id' ], $field_name );
    $formated = gmdate("Y-m-d\TH:i:s\Z", $timestamp[0]);
    return $formated;
}

function fpec_get_post_meta_month_cb( $object, $field_name, $request ) {
    $timestamp = get_post_meta( $object[ 'id' ], 'fpec_event_startdate' );
    $formated = gmdate("mY", $timestamp[0]);
    return $formated;
}

function fpec_update_post_meta_date_cb( $value, $object, $field_name ) {
    return update_post_meta( $object[ 'id' ], $field_name, $value );
}

function fpec_meta_to_api() {
  register_rest_field( 'fpec_event',
      'fpec_event_startdate',
      array(
         'get_callback'    => 'fpec_get_post_meta_date_cb',
         'update_callback' => 'fpec_update_post_meta_date_cb',
         'schema'          => null,
      )
  );
  register_rest_field( 'fpec_event',
      'fpec_event_enddate',
      array(
         'get_callback'    => 'fpec_get_post_meta_date_cb',
         'update_callback' => 'fpec_update_post_meta_date_cb',
         'schema'          => null,
      )
  );

  register_rest_field( 'fpec_event',
      'fpec_event_month',
      array(
         'get_callback'    => 'fpec_get_post_meta_month_cb',
         'update_callback' => null,
         'schema'          => null,
      )
  );
}
add_action( 'rest_api_init', 'fpec_meta_to_api');

//The Following registers an api route with multiple parameters.

function fpec_add_custom_users_api(){
      register_rest_route( 'fpec_events/v1', '/events/(?P<year>[0-9-]+)/(?P<month>[a-z0-9 .\-]+)', array(
        'methods' => 'GET',
        'callback' => 'fpec_get_custom_users_data',
    ));
}
add_action( 'rest_api_init', 'fpec_add_custom_users_api');


//Customize the callback to your liking
function fpec_get_custom_users_data($data){
    $year = (int)$data['year'];
    $month = (int)$data['month'];
    $monthName = date('F', mktime(0, 0, 0, $month, 10));

    $current_month_first = strtotime('first day of ' . $monthName . ' ' . $year);
    $current_month_last = strtotime('last day of ' . $monthName . ' ' . $year);
    //
    // $args = array(
    //   'posts_per_page' => -1,
    //   'post_type' => 'fpec_event',
    //   'meta_query' => array (
    //     'relation' => 'AND',
    //     array (
    //        'key'     => 'fpec_event_startdate',
    //        'value'   => $current_month_first,
    //        'compare' => '>'
    //     ),
    //     array (
    //       'key'     => 'fpec_event_startdate',
    //       'value'   => $current_month_last,
    //       'compare' => '<'
    //     ),
    //   ),
    // );
    //
    // $posts =  get_posts( $args );
    //
    // return $posts;

    $args = array(
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
    $query = new WP_Query( $args );

    $posts = $query->posts;

    $custom_posts = array();

    if ($posts) {
      global $post;
      foreach ($posts as $post){
        $custom = get_post_meta($post->ID);

        // - custom variables -
        // $custom = get_post_custom(get_the_ID());
        $sd = $custom["fpec_event_startdate"][0];
        $ed = $custom["fpec_event_enddate"][0];

        $post->fpec_event_startdate = date('Y-m-d H:i:s', $sd);
        $post->fpec_event_enddate = date('Y-m-d H:i:s', $ed);

        $post->image_id = get_post_thumbnail_id();
        $imagesize="thumbnail";

        $post->image_url = wp_get_attachment_image_src($post->image_id, $imagesize, true)[0];
        array_push($custom_posts, $post);;
      }
    }


    return $custom_posts;
}

// END OF TODO

function fpec_event_updated_messages( $messages ) {

  global $post, $post_ID;

  $messages['fpec_event'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Event updated. <a href="%s">View item</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Event updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Event restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Event published. <a href="%s">View event</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Event saved.'),
    8 => sprintf( __('Event submitted. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Event draft updated. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter('post_updated_messages', 'fpec_event_updated_messages');


?>
