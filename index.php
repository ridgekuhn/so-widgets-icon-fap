<?php

/**
 * SiteOrigin Icon Font Awesome Pro
 *
 * Plugin Name: SiteOrigin Icon Font Awesome Pro (Unofficial)
 * Description: Adds support for Font Awesome Pro to SiteOrigin Icon widget
 * Version:     0.1
 * Author:      ridgekuhn
 * Author URI:  https://github.com/ridgekuhn
 *
 * @link https://siteorigin.com/docs/widgets-bundle/form-building/icons-and-fonts/
 */

/**
 * Prepares Font Awesome Pro to be added to SiteOrigin Icon widget.
 *
 * @param array $icon_families Icon data passed from siteorigin_widgets_icon_families
 *
 * @var string $icon_meta_uri Path to the Font Awesome Pro icon metadata generated by parser.js
 * @var string $style_uri Path to the Font Awesome Pro stylesheet
 * @var array  $icons Icon metadata generated by parser.js
 * @var array  $styles Icon Styles list required by SO Icon widget form
 *
 * @link https://siteorigin.com/docs/widgets-bundle/form-building/icons-and-fonts/
 *
 * @return array $icon_families Icon data to be passed to siteorigin_widgets_icon_families
 */
function rjk_sow_icon_fontawesomepro_filter( $icon_families ) {
  // Config
  $icon_meta_uri = dirname(__FILE__) . '/inc/fap-icons.json';
  $style_uri = plugin_dir_url( __FILE__ ) . 'css/all.css';
  // Cache busting
  $style_uri .= '?ver=' . filemtime( plugin_dir_url( __FILE__ ) . 'css/all.css' );

  // Import the icon metadata
  $icons = rjk_sow_icon_fontawesomepro_import( $icon_meta_uri );

  // Return $icon_families if there was an error importing the .json file
  if ( is_wp_error( $icons ) ) {
    add_action( 'admin_notices', rjk_sow_icon_admin_notice__error( $icons ) );
    return $icon_families;
  }

  // Prepare the styles list for SO Icon widget's style dropdown
  // [key] is rendered as a class name by siteorigin_widget_get_icon()
  $styles = array(
    'fab' => __( 'Pro - Brands', 'so-widgets-bundle' ),
    'fad' => __( 'Pro - Duotone', 'so-widgets-bundle' ),
    'fal' => __( 'Pro - Light', 'so-widgets-bundle' ),
    'far' => __( 'Pro - Regular', 'so-widgets-bundle' ),
    'fas' => __( 'Pro - Solid', 'so-widgets-bundle' )
  );

  // Add the Font Awesome Pro icon set to the array
  $icon_families['fontawesomepro'] = array(
      'name' => __( 'Font Awesome Pro', 'so-widgets-bundle' ),
      'style_uri' => $style_uri,
      'icons' => $icons
  );

  // Register style list with SO Icon widget
  $icon_families['fontawesomepro']['styles'] = $styles;

  return $icon_families;
}

add_filter( 'siteorigin_widgets_icon_families', 'rjk_sow_icon_fontawesomepro_filter' );

/**
 * Imports Font Awesome Pro icon metadata
 *
 * @param string $icon_meta_uri Path to the Font Awesome Pro icon metadata generated by parser.js
 *
 * @var array $icons Icon metadata generated by parser.js
 *
 * @return array $icons Processed icon metadata generated by parser.js
 */
function rjk_sow_icon_fontawesomepro_import( $icon_meta_uri ) {
  $icons = [];

  if ( $icons = json_decode( file_get_contents( $icon_meta_uri ), true ) ) {
    return $icons;
  } else {
    return new WP_Error(
      500,
       __( 'Error parsing Font Awesome Pro icon metadata from JSON', 'so-widgets-bundle' ),
      array(
        'status' => 500,
      )
    );
  }
}

/**
 * Error handler
 *
 * @param Object A WP_Error object
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices
 */
function rjk_sow_icon_admin_notice__error( $error ) {
?>
  <div class="notice notice-error">
    <p>Plugin so-widgets-icon-fap: <?php echo $error->get_error_message(); ?></p>
  </div>
<?php
}
