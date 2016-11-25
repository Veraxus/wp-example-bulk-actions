<?php
/*
Plugin Name: Example Custom Bulk Action
Plugin URI:
Description: Demonstrates how to add a custom bulk action to all admin screens. Requires WordPress 4.7+
Author: Matt van Andel
Version: 1.0
Author URI: http://nouveauframework.org
*/

// Display notice after bulk action is handled
add_action( 'admin_notices', 'bulkactiontest_admin_notice' );
add_action( 'network_admin_notices', 'bulkactiontest_admin_notice' );

// Register the removable query arg we'll use for tracking the action result / message
add_filter( 'removable_query_args', 'bulkactiontest_add_removable_query_args', 10, 1 );

// Add our test bulk action to ALL WordPress's list tables...
add_action( 'current_screen', function () {

	// Custom query arg needs to be removed so the message doesn't persist!
	$_SERVER['REQUEST_URI'] = remove_query_arg( [ 'tstbkact' ], $_SERVER['REQUEST_URI'] );

	// Add new bulk action to all screens
	add_filter( 'bulk_actions-' . get_current_screen()->id, 'bulkactiontest_add_bulk_action' );

	// Add new bulk action handler to standard screens
	add_filter( 'handle_bulk_actions-' . get_current_screen()->id, 'bulkactiontest_handle_bulk_action', 10, 3 );
	
	// Add new bulk action handler to network screens (which get a 3rd parameter with the site id)
	add_filter( 'handle_network_bulk_actions-' . get_current_screen()->id, 'bulkactiontest_handle_bulk_action', 10, 4 );
} );

/**
 * Add the new bulk action to the bulk action drop-down.
 * 
 * Uses 'bulk_actions-{$screen_id}' filter
 * 
 * @param $actions
 * @return mixed
 */
function bulkactiontest_add_bulk_action( $actions ) {
	$actions['tstbkact'] = 'Test Bulk Action';
	return $actions;
}

/**
 * Handle custom bulk actions!
 * 
 * Uses 'handle_bulk_actions-{$screen_id}' & 'handle_network_bulk_actions-{$screen_id}' filters
 * 
 * @param string $sendback The redirect URL, after the action is handled.
 * @param bool $action
 * @param bool $items
 * @param bool $site_id
 *
 * @return string
 */
function bulkactiontest_handle_bulk_action( $sendback, $action = false, $items = false, $site_id = false ) {
	if ( $action === 'tstbkact' ) {
		$sendback = add_query_arg( 'tstbkact', count( $items ), $sendback );
		return $sendback;
	}
	return $sendback;
}

/**
 * Display an admin notice on the screen after the action is processed and the user is redirected.
 * 
 * Uses 'admin_notices' & 'network_admin_notices' actions
 */
function bulkactiontest_admin_notice() {
	$current_screen = get_current_screen();

	if ( isset( $_REQUEST['tstbkact'] ) ) {
		printf( '<div id="message" class="updated fade"><p>Test bulk action caught for %s items on %s!</p></div>', $_REQUEST['tstbkact'], $current_screen->id );
	}
}

/**
 * Register our query argument so that it can be safely added and removed
 * 
 * @param $removable_query_args
 *
 * @return array
 */
function bulkactiontest_add_removable_query_args( $removable_query_args ) {
	$removable_query_args[] = 'tstbkact';
	return $removable_query_args;
}
