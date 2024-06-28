<?php
/**
 * Plugin Name: WordPress Memory Usage
 * Plugin URI: https://github.com/ppfeufer/pp-wp-show-ids
 *  Description: Display the IDs of posts, categories, pages, taxonomies, users, tags, and more.
 * Version: 1.0.0
 * Author: H. Peter Pfeufer
 * Author URI: http://ppfeufer.de
 * License: GPLv3
 * Text Domain: pp-wp-show-ids
 * Domain Path: /l10n
 */

namespace Ppfeufer\Plugin\PpWpShowIDs;

// phpcs:disable
define(
    constant_name: __NAMESPACE__ . '\PLUGIN_DIR',
    value: plugin_dir_path(file: __FILE__)
);

require_once PLUGIN_DIR . 'Sources/autoloader.php';
require_once PLUGIN_DIR . 'Sources/Libs/autoload.php';
// phpcs:enable

/**
 * Start the show
 */
//new ShowIDs();
(new Main())->init();
