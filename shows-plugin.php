<?php
	/*
	Plugin Name: The Shows List Plugin
	Plugin URI: http://kakemultimedia.com/
	Description: Declares a plugin that will create a custom post type displaying shows.
	Version: 1.0
	Author: James Burrell
	Author URI: http://web.prodhmd.com/
	License: GPLv2
	*/
	
	// Start Plugin
	function create_shows_posttype() {
		register_post_type( 'shows',
		// CPT Options
			array(
				'description' => __( 'Upcoming Events' ),
				'labels' => array(
					'name' => ( 'Shows' ),
					'slug' => 'shows',
					'singular_name' => __( 'Show' ),
					'add_new' => 'Add New',
					'add_new_item' => 'Add New Show',
					'edit' => 'Edit',
					'edit_item' => 'Edit Show',
					'new_item' => 'New Show',
					'view' => 'View',
					'view_item' => 'View Show',
					'search_items' => 'Search Shows',
					'not_found' => 'No Shows found',
					'not_found_in_trash' => 'No Shows found in Trash',
					'parent' => 'Parent Show'
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'shows'),
				'supports' => array('title','editor','thumbnail','revisions','custom-fields'),
				'taxonomies' => array( 'venue' ),
				'menu_position' => 6,
				'menu_icon' => 'dashicons-calendar-alt',
				'register_meta_box_cb' => 'add_events_metaboxes'
			)
		);
	}
	// Hooking up our function to theme setup
	add_action( 'init', 'create_shows_posttype' );
	
	// Add metaboxes
	function add_events_metaboxes() {
		add_meta_box('events_location', 'Event Location', 'events_location', 'shows', 'normal', 'default');
		add_meta_box('events_location', 'Event Time', 'events_time', 'shows', 'normal', 'default');
	}
	// Add Event Location Info
	function events_location() {
		global $post;
		// Noncename needed to verify where the data originated
		echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
		wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
		// Get the location data if its already been entered
		$location = get_post_meta($post->ID, '_location', true);
		// Echo out the field
		echo '<label class="pull-left" for="venue">Venue</label>';
		echo '<input type="text" name="_location" value="' . $location  . '" class="widefat pull-left" />';
	}
	add_action( 'add_meta_boxes', 'add_events_metaboxes' );
	
	// Save the Metabox Data
	function save_events_meta($post_id, $post) {
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( !wp_verify_nonce( $_POST['eventmeta_noncename'], plugin_basename(__FILE__) )) {
		return $post->ID;
		}
		// Is the user allowed to edit the post or page?
		if ( !current_user_can( 'edit_post', $post->ID ))
			return $post->ID;
		// OK, we're authenticated: we need to find and save the data
		// We'll put it into an array to make it easier to loop though.
		$events_meta['_location'] = $_POST['_location'];
		// Add values of $events_meta as custom fields
		foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
			if( $post->post_type == 'revision' ) return; // Don't store custom data twice
			$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
			if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
				update_post_meta($post->ID, $key, $value);
			} else { // If the custom field doesn't have a value
				add_post_meta($post->ID, $key, $value);
			}
			if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
		}
	}
	add_action('save_post', 'save_events_meta', 1, 2); // save the custom fields
	
	
?>