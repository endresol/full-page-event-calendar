<?php

function fpec_options_page() {

  global $fpec_options;

  ob_start(); ?>
    <div class="wrap">
      <h2>Fullpage Event Calendar Options</h2>
      <form method="post" action="options.php">
        <?php settings_fields('fpec_settings_group'); ?>

        <h4> <?php _e('Enable images', 'fpec_domain') ?> </h4>
        <p>
          <input id="fpec_settings[image_enabled]" name="fpec_settings[image_enabled]" type="checkbox" value="1" <?php checked('1', $fpec_options['image_enabled']); ?> />
          <label class="description" for="fpec_settings[image_enabled]"><?php _e('Display images in calendar', 'fpec_domain') ?></label>
        </p>

        <h4> <?php _e('Theme', 'fpec_domain');  ?> </h4>
        <p>
          <?php $styles= array('blue', 'red'); ?>
          <select name="fpec_settings[theme]" id="fpec_settings[theme]">
            <?php foreach($styles as $style) { ?>
              <?php if ($fpec_options['theme'] == $style) { $selected = 'selected="selected"'; } else { $selected=''; } ?>
              <option value="<?php echo $style ?>" <?php echo $selected ?> ><?php echo $style ?></option>
              <?php } ?>
            </select>
          </p>

        <h4> <?php _e('Twitter info', 'fpec_domain');  ?> </h4>
        <p>
          <input id="fpec_settings[twitter_url]" name="fpec_settings[twitter_url]" type="text" value="<?php echo $fpec_options['twitter_url'] ?>" />
          <label class="description" for="fpec_settings[twitter_url]"><?php _e('Enter twitter url', 'fpec_domain'); ?></label>
        </p>
        <p class="submit">
          <input type="submit" class="button-primary" value="<?php _e('Save Option', 'fpec_domain'); ?>" />
        </p>
      </form>
    </div>
  <?php
  echo ob_get_clean();
}

function fpec_add_options_link() {
  add_options_page('Fullpage Event Calendar', 'Fullpage Event', 'manage_options', 'fpec-options', 'fpec_options_page');
}
add_action('admin_menu', 'fpec_add_options_link');

function fpec_register_settings() {
  register_setting('fpec_settings_group', 'fpec_settings');
}
add_action('admin_init', 'fpec_register_settings');

?>
