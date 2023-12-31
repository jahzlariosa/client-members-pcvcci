<?php

/**
 * Forums Admin Actions
 *
 * @package BuddyBoss\Admin
 */

/**
 * This file contains the actions that are used through-out Forums Admin. They
 * are consolidated here to make searching for them easier, and to help developers
 * understand at a glance the order in which things occur.
 *
 * There are a few common places that additional actions can currently be found
 *
 *  - Forums: In {@link bbPress::setup_actions()} in bbpress.php
 *  - Admin: More in {@link BBP_Admin::setup_actions()} in admin.php
 *
 * @see bbp-core-actions.php
 * @see bbp-core-filters.php
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Attach Forums to WordPress
 *
 * Forums uses its own internal actions to help aid in third-party plugin
 * development, and to limit the amount of potential future code changes when
 * updates to WordPress core occur.
 *
 * These actions exist to create the concept of 'plugin dependencies'. They
 * provide a safe way for plugins to execute code *only* when Forums is
 * installed and activated, without needing to do complicated guesswork.
 *
 * For more information on how this works, see the 'Plugin Dependency' section
 * near the bottom of this file.
 *
 *           v--WordPress Actions       v--Forums Sub-actions
 */
add_action( 'admin_menu', 'bbp_admin_menu' );
add_action( 'admin_init', 'bbp_admin_init' );
add_action( 'admin_head', 'bbp_admin_head' );
add_action( 'admin_notices', 'bbp_admin_notices' );
add_action( 'custom_menu_order', 'bbp_admin_custom_menu_order' );
add_action( 'menu_order', 'bbp_admin_menu_order' );
add_action( 'wpmu_new_blog', 'bbp_new_site', 10, 6 );

// Hook on to admin_init
add_action( 'bbp_admin_init', 'bbp_admin_forums' );
add_action( 'bbp_admin_init', 'bbp_admin_topics' );
add_action( 'bbp_admin_init', 'bbp_admin_replies' );
add_action( 'bbp_admin_init', 'bbp_setup_updater', 999 );
add_action( 'bbp_admin_init', 'bbp_register_importers' );
add_action( 'bbp_admin_init', 'bbp_register_admin_scripts' );
add_action( 'bbp_admin_init', 'bbp_register_admin_style' );
add_action( 'bbp_admin_init', 'bbp_register_admin_settings' );

// Initialize the admin area
add_action( 'bbp_init', 'bbp_admin' );

// Reset the menu order
add_action( 'bbp_admin_menu', 'bbp_admin_separator' );

// Activation
add_action( 'bbp_activation', 'bbp_delete_rewrite_rules' );
add_action( 'bbp_activation', 'bbp_make_current_user_keymaster' );

// Deactivation
add_action( 'bbp_deactivation', 'bbp_remove_caps' );
add_action( 'bbp_deactivation', 'bbp_remove_roles' );
add_action( 'bbp_deactivation', 'bbp_delete_rewrite_rules' );

// New Site
add_action( 'bbp_new_site', 'bbp_create_initial_content', 8 );

// Contextual Helpers
add_action( 'load-settings_page_bbpress', 'bbp_admin_settings_help' );

// Handle submission of Tools pages
add_action( 'load-tools_page_bbp-repair', 'bbp_admin_repair_handler' );
add_action( 'load-tools_page_bbp-reset', 'bbp_admin_reset_handler' );

// Add sample permalink filter
add_filter( 'post_type_link', 'bbp_filter_sample_permalink', 10, 4 );

// Add quick stats to dashboard glance elements.
add_filter( 'dashboard_glance_items', 'bbp_filter_dashboard_glance_items', -99 );

/**
 * When a new site is created in a multisite installation, run the activation
 * routine on that site
 *
 * @since bbPress (r3283)
 *
 * @param int     $blog_id
 * @param int     $user_id
 * @param string  $domain
 * @param string  $path
 * @param int     $site_id
 * @param array() $meta
 */
function bbp_new_site( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {

	// Bail if plugin is not network activated
	if ( ! is_plugin_active_for_network( bbpress()->basename ) ) {
		return;
	}

	// Switch to the new blog
	switch_to_blog( $blog_id );

	// Do the Forums activation routine
	do_action( 'bbp_new_site', $blog_id, $user_id, $domain, $path, $site_id, $meta );

	// restore original blog
	restore_current_blog();
}

/**
 * Filter sample permalinks so that certain languages display properly.
 *
 * @since bbPress (r3336)
 *
 * @param string $post_link Custom post type permalink
 * @param object $_post Post data object
 * @param bool   $leavename Optional, defaults to false. Whether to keep post name or page name.
 * @param bool   $sample Optional, defaults to false. Is it a sample permalink.
 *
 * @uses is_admin() To make sure we're on an admin page
 * @uses bbp_is_custom_post_type() To get the forum post type
 *
 * @return string The custom post type permalink
 */
function bbp_filter_sample_permalink( $post_link, $_post, $leavename = false, $sample = false ) {

	// Bail if not on an admin page and not getting a sample permalink
	if ( ! empty( $sample ) && is_admin() && bbp_is_custom_post_type() ) {
		return urldecode( $post_link );
	}

	// Return post link
	return $post_link;
}

/** Sub-Actions ***************************************************************/

/**
 * Piggy back admin_init action
 *
 * @since bbPress (r3766)
 * @uses do_action() Calls 'bbp_admin_init'
 */
function bbp_admin_init() {
	do_action( 'bbp_admin_init' );
}

/**
 * Piggy back admin_menu action
 *
 * @since bbPress (r3766)
 * @uses do_action() Calls 'bbp_admin_menu'
 */
function bbp_admin_menu() {
	do_action( 'bbp_admin_menu' );
}

/**
 * Piggy back admin_head action
 *
 * @since bbPress (r3766)
 * @uses do_action() Calls 'bbp_admin_head'
 */
function bbp_admin_head() {
	do_action( 'bbp_admin_head' );
}

/**
 * Piggy back admin_notices action
 *
 * @since bbPress (r3766)
 * @uses do_action() Calls 'bbp_admin_notices'
 */
function bbp_admin_notices() {
	do_action( 'bbp_admin_notices' );
}

/**
 * Dedicated action to register Forums importers
 *
 * @since bbPress (r3766)
 * @uses do_action() Calls 'bbp_admin_notices'
 */
function bbp_register_importers() {
	do_action( 'bbp_register_importers' );
}

/**
 * Dedicated action to register admin styles
 *
 * @since bbPress (r3766)
 * @uses do_action() Calls 'bbp_admin_notices'
 */
function bbp_register_admin_style() {
	do_action( 'bbp_register_admin_style' );
}

/**
 * Dedicated action to register admin scripts
 *
 * @since 2.6.0 bbPress (r6912)
 */
function bbp_register_admin_scripts() {
	do_action( 'bbp_register_admin_scripts' );
}

/**
 * Dedicated action to register admin settings
 *
 * @since bbPress (r3766)
 * @uses do_action() Calls 'bbp_register_admin_settings'
 */
function bbp_register_admin_settings() {
	do_action( 'bbp_register_admin_settings' );
}
