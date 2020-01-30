# SiteOrigin Icon Font Awesome Pro
**WIP**: *This plugin is non-functional. Has issues saving and rendering.*

Adds Font Awesome Pro icon library to [SiteOrigin Icon Widget](https://siteorigin.com/widgets-bundle/icon-widget/).

This unofficial plugin is not created, sponsored, or maintained by [SiteOrigin](https://siteorigin.com/).

***

## Requirements
* [SiteOrigin Widgets Bundle](https://siteorigin.com/widgets-bundle/)
* [Font Awesome Pro npm auth token](https://fontawesome.com/how-to-use/on-the-web/setup/using-package-managers#installing-pro)
* [Node.js](https://nodejs.org/)

### Instructions
1. Copy this project to your WP plugins folder.

2. Copy `.npmrc.example` to `.npmrc`
    or add the included setting to your existing .npmrc file.

3. Edit `.npmrc` to replace `${FONTAWESOME_NPM_AUTH_TOKEN}` with your npm auth token
    or export `FONTAWESOME_NPM_AUTH_TOKEN` as an environment variable.

4. Install dependencies

    `$ yarn install --dev`

    What's installed:
    * Installs Font Awesome 5 npm package
    * Copies `all.css` and `webfonts/` from npm package to plugin directory
    * Adds SiteOrigin Icon-specific css to `all.css`
    * Prepares `metadata/icons.yml` to be passed to `siteorigin_widgets_icon_families` filter hook

5. Enable plugin in WP

## To Do:
* Get icons to render outside Icon form
* Remove free Font Awesome from Icon form
* Add manual install instructions to README.md
* Resolve conflicts for if FA is already installed
