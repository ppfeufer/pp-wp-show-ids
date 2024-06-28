<?php
/*
  Plugin Name: PP WP Show IDs
  Plugin URI:
  Description: Display the IDs of all posts, categories, pages, taxonomies, users, tags, and more.
  Version: 1.0.0
  Author: H.-Peter Pfeufer
  Author URI: http://ppfeufer.de
  License: GPLv2
 */

/*
  Copyright (C) 2016 ppfeufer

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace WP\Plugins\PP_WP_ShowIDs;

class ShowIDs {
	public function __construct() {
		// Hooks + Filters
		\add_action('admin_head', array($this, 'addCss'));

		// For Post Management
		\add_filter('manage_posts_columns', array($this, 'addColumn'));
		\add_action('manage_posts_custom_column', array($this, 'addValue'), 10, 2);

		// For Page Management
		\add_filter('manage_pages_columns', array($this, 'addColumn'));
		\add_action('manage_pages_custom_column', array($this, 'addValue'), 10, 2);

		// For Media Management
		\add_filter('manage_media_columns', array($this, 'addColumn'));
		\add_action('manage_media_custom_column', array($this, 'addValue'), 10, 2);

		// For Link Management
		\add_filter('manage_link-manager_columns', array($this, 'addColumn'));
		\add_action('manage_link_custom_column', array($this, 'addValue'), 10, 2);

		// For Category Management
		\add_action('manage_edit-link-categories_columns', array($this, 'addColumn'));
		\add_filter('manage_link_categories_custom_column', array($this, 'add_return_value'), 10, 3);

		// For User Management
		\add_action('manage_users_columns', array($this, 'addColumn'));
		\add_filter('manage_users_custom_column', array($this, 'add_return_value'), 10, 3);

		// For Comment Management
		\add_action('manage_edit-comments_columns', array($this, 'addColumn'));
		\add_action('manage_comments_custom_column', array($this, 'addValue'), 10, 2);

		\add_action('admin_init', array($this, 'customObjects'));
	} // END public function __construct()

	/**
	 * Hooks to the 'admin_init'
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public function customObjects() {
		// For Custom Taxonomies
		foreach(\get_taxonomies(array('public' => true), 'names') as $custom_taxonomy) {
			if(isset($custom_taxonomy)) {
				\add_action("manage_edit-" . $custom_taxonomy . "_columns", array($this, 'addColumn'));
				\add_filter("manage_" . $custom_taxonomy . "_custom_column", array($this, 'add_return_value'), 10, 3);
			} // END if(isset($custom_taxonomy))
		} // END foreach(get_taxonomies(array('public' => true), 'names') as $custom_taxonomy)

		// For Custom Post Types
		foreach(\get_post_types(array('public' => true), 'names') as $post_type) {
			if(isset($post_type)) {
				\add_action("manage_edit-" . $post_type . "_columns", array($this, 'addColumn'));
				\add_filter("manage_" . $post_type . "_custom_column", array($this, 'add_return_value'), 10, 3);
			} // END if(isset($post_type))
		} // END foreach(get_post_types(array('public' => true), 'names') as $post_type)
	} // END public function customObjects()

	/**
	 * Hooks to 'admin_head'
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public function addCss() {
		?>
		<style type="text/css">
			#pp-wp-show-ids {
				width: 50px;
			}
		</style>
		<?php
	} // END public function addCss()

	/**
	 * Adds column to edit screen
	 *
	 * @access public
	 * @static
	 * @param mixed $cols
	 * @return void
	 */
	public function addColumn($cols) {
		$cols['pp-wp-show-ids'] = 'ID';

		return $cols;
	} // END public function addColumn($cols)

	/**
	 * Adds id value
	 *
	 * @access public
	 * @static
	 * @param mixed $column_name
	 * @param mixed $id
	 * @return void
	 */
	public function addValue($column_name, $id) {
		if($column_name == 'pp-wp-show-ids') {
			echo $id;
		} // END if($column_name == 'pp-wp-show-ids')
	} // END public function addValue($column_name, $id)

	/**
	 * Adds id value
	 *
	 * @access public
	 * @static
	 * @param mixed $value
	 * @param mixed $column_name
	 * @param mixed $id
	 * @return void
	 */
	public function add_return_value($value, $column_name, $id) {
		if($column_name == 'pp-wp-show-ids') {
			$value = $id;
		} // END if($column_name == 'pp-wp-show-ids')

		return $value;
	} // END public function add_return_value($value, $column_name, $id)
} // END class ShowIDs

/**
 * Start the show
 */
new ShowIDs();
