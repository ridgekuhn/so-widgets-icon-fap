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

function rjk_sow_icon_fontawesomepro_filter( $icon_families ) {
  /**
   * Config
   */
  /** @var string $icon_meta_uri Path the Font Awesome Pro icon metadata generated by parser.js */
  $icon_meta_uri = dirname(__FILE__) . '/inc/fap-icons.json';

  /** @var string $style_uri Path to the Font Awesome Pro stylesheet */
  $style_uri = plugin_dir_url( __FILE__ ) . 'css/all.css';
  // Cache busting
  $style_uri .= '?ver=' . filemtime( plugin_dir_path(__FILE__) . $font . '/style.css' );

  /** @var array $styles Set up icon Styles list for SO Icon widget form */
  // [key] is rendered as a class name by siteorigin_widget_get_icon()
  $styles = array(
    'fab' => __( 'Pro - Brands', 'so-widgets-bundle' ),
    'fad' => __( 'Pro - Duotone', 'so-widgets-bundle' ),
    'fal' => __( 'Pro - Light', 'so-widgets-bundle' ),
    'far' => __( 'Pro - Regular', 'so-widgets-bundle' ),
    'fas' => __( 'Pro - Solid', 'so-widgets-bundle' )
  );

  /**
   * Do the thing
   */
  /** @var array $icons Icon metadata generated by parser.js */
  $icons = rjk_sow_icon_fontawesomepro_import( $icon_meta_uri );

  // Register the icon set with SO Icon widget
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
 * @return array Processed icon metadata generated by parser.js
 */
function rjk_sow_icon_fontawesomepro_import( $icon_meta_uri ) {
  /** @var array $icons Icon metadata generated by parser.js */
  $icons = [];

  if ( $icons = json_decode( file_get_contents( $icon_meta_uri ), true ) ) {
    return $icons
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
