/**
 * Parses the icons.yml metadata file provided by the Font Awesome npm package,
 * and prepares the metadata for extending SiteOrigin Icon widget
 *
 * @link https://siteorigin.com/docs/widgets-bundle/form-building/icons-and-fonts/
 * @see ../plugins/so-widgets-bundle/icons/fontawesome/filter.php
 */
// Load npm dependencies
const yaml = require('js-yaml');
const fs   = require('fs');

/**
 * Config
 */
/** @var string iconsMetaURI Set the path to the Font Awesome Pro icon metadata file */
const iconsMetaURI = 'node_modules/@fortawesome/fontawesome-pro/metadata/icons.yml';

/** @var string outputPath Set the path to save a file to */
const outputPath  = 'inc/fap-icons.json';

/**
 * Variables
 */
/** @var object iconsMeta The Font Awesome Pro icon metadata */
let iconsMeta = {};

/** @var object icons The processed icon metadata */
let icons = {};

/**
 * Functions
 */
// Load the metadata
try {
  iconsMeta = yaml.safeLoad( fs.readFileSync( iconsMetaURI, 'utf8' ) );
  console.log( 'Successfully parsed ' + iconsMetaURI );
} catch ( e ) {
  console.error( e );
}

// Process the metadata
try {
  // Loop over each icon in iconsMeta
  for( let icon in iconsMeta ) {
    /** @var object newMeta The processed metadata */
    let newMeta = {};
        newMeta[ 'unicode' ] = '';
        newMeta[ 'styles' ]  = [];

    /** @var object styles The icon style properties */
    let styles = iconsMeta[ icon ][ 'styles' ];

    // Add unicode and hex charater escapes to the new metadata
    newMeta[ 'unicode' ] = '&#x' + iconsMeta[ icon ][ 'unicode' ] + ';'

    // Loop over the icon style properties
    for( let style in styles ) {
      // Values are used for Styles variants in Icon form
      // and for rendering element class names
      switch ( styles [ style ] ) {
        case 'solid'   :
          newMeta[ 'styles' ].push( 'sow-fas' );
          break;
        case 'regular' :
          newMeta[ 'styles' ].push( 'sow-far' );
          break;
        case 'light'   :
          newMeta[ 'styles' ].push( 'sow-fal' );
          break;
        case 'duotone' :
          newMeta[ 'styles' ].push( 'sow-fad' );
          break;
        case 'brands'  :
          newMeta[ 'styles' ].push( 'sow-fab' );
          break;
      }
    }

    // Add the icon and new metadata
    icons[ icon ] = newMeta;
  }
} catch ( e ) {
  console.error( e );
}

try {
  // Stringify icons for saving to file
  const jsonString = JSON.stringify( icons );

  // Write to file
  const output = fs.writeFileSync( outputPath , jsonString );

  console.log('Successfully wrote icon metadata to ' + outputPath );
} catch (e) {
  console.error(e)
}
