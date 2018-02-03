<?php

function fpec_load_scripts() {
  if( is_single()) {
    wp_enqueue_style('fpec_styles', plugin_dir_url( __FILE__) . 'css/plugin-style.css');
  }
}
add_action('wp_enqueue_scripts', 'fpec_load_scripts');

function fpec_load_admin_scripts() {
    wp_enqueue_style('fpec_admin_styles', plugin_dir_url( __FILE__) . 'css/plugin-admin-styles.css');
    wp_enqueue_style('fpec_datapicker_admin_style', plugin_dir_url( __FILE__) . 'css/jquery-ui.css'); 
    wp_enqueue_script('fpec_admin_scripts', plugin_dir_url( __FILE__) . 'js/plugin-admin-script.js', array(jquery));
}
add_action('admin_enqueue_scripts', 'fpec_load_admin_scripts');

?>
