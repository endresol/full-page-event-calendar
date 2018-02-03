<?php
/*
Plugin Name: Fullpage Event Calendar
Plugin URI: http://endresolem.no/fullpage-event-calendar
Description: This is my first WordPress Plugin
Author: Endre Solem
Author URI: http://endresolem.no
Version: 1.0
*/

/********************************
* Globals
********************************/

$fpec_plugin_name = "Fullpage Event Calendar";

$fpec_options = get_option('fpec_settings');


/********************************
* includes
********************************/

include('includes/scripts.php'); // loads css and js
include('includes/data_processing.php');
include('includes/display-functions.php');
include('includes/register_post_types.php');

include('includes/admin-page.php');


?>
