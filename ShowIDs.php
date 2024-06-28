<?php
/**
 * Plugin Name: WP Show IDs
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
// Define constants
define(
    constant_name: __NAMESPACE__ . '\PLUGIN_DIR',
    value: plugin_dir_path(file: __FILE__)
);

const PLUGIN_GITHUB_URL = 'https://github.com/ppfeufer/pp-wp-show-ids/';
const PLUGIN_SLUG = 'pp-wp-show-ids';
const PLUGIN_FILE = __FILE__;

// Load the autoloader
require_once PLUGIN_DIR . 'Sources/autoloader.php';
require_once PLUGIN_DIR . 'Sources/Libs/autoload.php';
// phpcs:enable

// Initialize the plugin
(new Main())->init();
