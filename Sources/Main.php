<?php

namespace Ppfeufer\Plugin\PpWpShowIDs;

use Ppfeufer\Plugin\PpWpShowIDs\Libs\YahnisElsts\PluginUpdateChecker\v5p5\PucFactory;

/**
 * Main class for the plugin
 *
 * @package Ppfeufer\Plugin\PpWpShowIDs
 */
class Main {
    /**
     * Main constructor
     *
     * @return void
     * @access public
     */
    public function __construct() {
        $this->init();
    }

    /**
     * Initialize the class
     *
     * @return void
     * @access public
     */
    public function init(): void {
        $this->doUpdateCheck();
        $this->loadHooks();
    }

    /**
     * Check GitHub for updates
     *
     * @return void
     * @access public
     */
    public function doUpdateCheck(): void {
        PucFactory::buildUpdateChecker(
            metadataUrl: PLUGIN_GITHUB_URL,
            fullPath: PLUGIN_DIR_PATH . 'ShowIDs.php',
            slug: PLUGIN_SLUG
        )->getVcsApi()->enableReleaseAssets();
    }

    /**
     * Load the hooks
     *
     * @return void
     * @access public
     */
    public function loadHooks(): void {
        // Load the text domain
        add_action(hook_name: 'init', callback: static function () {
            load_plugin_textdomain(
                domain: PLUGIN_SLUG,
                plugin_rel_path: PLUGIN_REL_PATH . '/l10n/'
            );
        });

        if (is_admin()) {
            // Add CSS
            add_action(hook_name: 'admin_head', callback: [$this, 'addCss']);

            // For Post Management
            add_filter(hook_name: 'manage_posts_columns', callback: [$this, 'addColumn']);
            add_action(
                hook_name: 'manage_posts_custom_column',
                callback: [$this, 'addValue'],
                accepted_args: 2
            );

            // For Page Management
            add_filter(hook_name: 'manage_pages_columns', callback: [$this, 'addColumn']);
            add_action(
                hook_name: 'manage_pages_custom_column',
                callback: [$this, 'addValue'],
                accepted_args: 2
            );

            // For Media Management
            add_filter(hook_name: 'manage_media_columns', callback: [$this, 'addColumn']);
            add_action(
                hook_name: 'manage_media_custom_column',
                callback: [$this, 'addValue'],
                accepted_args: 2
            );

            // For Link Management
            add_filter(
                hook_name: 'manage_link-manager_columns',
                callback: [$this, 'addColumn']
            );
            add_action(
                hook_name: 'manage_link_custom_column',
                callback: [$this, 'addValue'],
                accepted_args: 2
            );

            // For Category Management
            add_action(
                hook_name: 'manage_edit-link-categories_columns',
                callback: [$this, 'addColumn']
            );
            add_filter(
                hook_name: 'manage_link_categories_custom_column',
                callback: [$this, 'addReturnValue'],
                accepted_args: 3
            );

            // For User Management
            add_action(hook_name: 'manage_users_columns', callback: [$this, 'addColumn']);
            add_filter(
                hook_name: 'manage_users_custom_column',
                callback: [$this, 'addReturnValue'],
                accepted_args: 3
            );

            // For Comment Management
            add_action(
                hook_name: 'manage_edit-comments_columns',
                callback: [$this, 'addColumn']
            );
            add_action(
                hook_name: 'manage_comments_custom_column',
                callback: [$this, 'addValue'],
                accepted_args: 2
            );

            add_action(hook_name: 'admin_init', callback: [$this, 'customObjects']);
        }
    }

    /**
     * Hooks to the `admin_init`
     *
     * @return void
     * @access public
     */
    public function customObjects(): void {
        // For Custom Taxonomies
        foreach (get_taxonomies(args: ['public' => true]) as $custom_taxonomy) {
            if (isset($custom_taxonomy)) {
                add_action(
                    hook_name: 'manage_edit-' . $custom_taxonomy . '_columns',
                    callback: [$this, 'addColumn']
                );
                add_filter(
                    hook_name: 'manage_' . $custom_taxonomy . '_custom_column',
                    callback: [$this, 'addReturnValue'],
                    accepted_args: 3
                );
            }
        }

        // For Custom Post Types
        foreach (get_post_types(args: ['public' => true]) as $post_type) {
            if (isset($post_type)) {
                add_action(
                    hook_name: 'manage_edit-' . $post_type . '_columns',
                    callback: [$this, 'addColumn']
                );
                add_filter(
                    hook_name: 'manage_' . $post_type . '_custom_column',
                    callback: [$this, 'addReturnValue'],
                    accepted_args: 3
                );
            }
        }
    }

    /**
     * Hooks to `admin_head`
     *
     * @return void
     * @access public
     */
    public function addCss(): void {
        ?>
        <style>
            .manage-column.column-pp-wp-show-ids {
                text-align: right;
                width: 50px;
            }

            .column-pp-wp-show-ids {
                text-align: right;
            }
        </style>
        <?php
    }

    /**
     * Adds column to edit screen
     *
     * @param array $cols The columns
     * @return array The modified columns
     * @access public
     */
    public function addColumn(array $cols): array {
        $cols['pp-wp-show-ids'] = __('ID', 'pp-wp-show-ids');

        return $cols;
    }

    /**
     * Adds id value
     *
     * @param string $column_name The column name
     * @param int $id The column ID
     * @return void
     * @access public
     */
    public function addValue(string $column_name, int $id): void {
        if ($column_name === 'pp-wp-show-ids') {
            echo $id;
        }
    }

    /**
     * Adds id value
     *
     * @param mixed $value
     * @param string $column_name
     * @param mixed $id
     * @return mixed
     * @access public
     */
    public function addReturnValue(mixed $value, string $column_name, mixed $id): mixed {
        if ($column_name === 'pp-wp-show-ids') {
            $value = $id;
        }

        return $value;
    }
}
