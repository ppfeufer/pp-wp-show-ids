<?php
/**
 * WP Show IDs
 *
 * Display the memory limit and current memory usage in the dashboard and admin footer
 *
 * @package WordPress\Ppfeufer\Plugin\WordPressTweaks
 * @author H. Peter Pfeufer
 * @copyright 2021 H. Peter Pfeufer
 * @license GPL-3.0-or-later
 * @version 1.1.0
 *
 * @wordpress-plugin
 * Plugin Name: WP Show IDs
 * Plugin URI: https://github.com/ppfeufer/pp-wp-show-ids
 * Description: Display the IDs of posts, categories, pages, taxonomies, users, tags, and more.
 * Version: 1.1.0
 * Requires at least: 6.0
 * Requires PHP: 8.2
 * Author: H. Peter Pfeufer
 * Author URI: https://ppfeufer.de
 * Text Domain: pp-wp-show-ids
 * Domain Path: /l10n
 * License: GPLv3
 * License URI: https://github.com/ppfeufer/pp-wp-show-ids/blob/master/LICENSE
 */

namespace Ppfeufer\Plugin\PpWpShowIDs;

// phpcs:disable
// Define constants
// Plugin directory path
define(
    constant_name: __NAMESPACE__ . '\PLUGIN_DIR_PATH',
    value: plugin_dir_path(file: __FILE__)
);

// Plugin directory relative path
define(
    constant_name: __NAMESPACE__ . '\PLUGIN_REL_PATH',
    value: dirname(plugin_basename(__FILE__))
);

// Plugin GitHub URL
const PLUGIN_GITHUB_URL = 'https://github.com/ppfeufer/pp-wp-show-ids/';

// Plugin slug
const PLUGIN_SLUG = 'pp-wp-show-ids';

// Load the autoloader
require_once PLUGIN_DIR_PATH . 'Sources/autoloader.php';
require_once PLUGIN_DIR_PATH . 'Sources/Libs/autoload.php';
// phpcs:enable

// Initialize the plugin
new Main();
