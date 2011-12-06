<?php
/**
 * This sets up the metaboxes for timeline custom fields
 *
 * @package WordPress
 * @subpackage History of the Future
 * @since Version 0.1
 */

function byron_add_timeline_metaboxes() {
	add_meta_box( 'byron_timeline_date', 'Timeline Date', 'byron_timeline_date', 'post', 'side', 'default' );
}
add_action( 'admin_init', 'byron_add_timeline_metaboxes' );

// The Timeline Metabox HTML

function byron_timeline_date() {
	global $post, $wp_locale;

	// Use nonce for verification ... ONLY USE ONCE!
	wp_nonce_field( plugin_basename( __FILE__ ), 'timeline_nonce' );

	$time_adj = current_time( 'timestamp' );

	$month = get_post_meta( $post->ID, '_month', true );

	if ( empty( $month ) ) {
		$month = gmdate( 'm', $time_adj );
	}

	$day = get_post_meta( $post->ID, '_day', true );

	if ( empty( $day ) ) {
		$day = gmdate( 'd', $time_adj );
	}

	$year = get_post_meta( $post->ID, '_year', true );

	if ( empty( $year ) ) {
		$year = gmdate( 'Y', $time_adj );
	}

	$month_s = "<select name=\"_month\">\n";
	for ( $i = 1; $i < 13; $i = $i +1 ) {
		$month_s .= "\t\t\t" . '<option value="' . zeroise( $i, 2 ) . '"';
		if ( $i == $month )
			$month_s .= ' selected="selected"';
		$month_s .= '>' . $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) . "</option>\n";
	}
	$month_s .= '</select>';

	echo $month_s;

	echo '<input type="text" name="_day" value="' . $day  . '" size="2" maxlength="2" />';
	echo '<input type="text" name="_year" value="' . $year . '" size="5" maxlength="5" />';
}

// Save the Metabox Data

function byron_save_timeline_meta( $post_id, $post ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	if ( !isset( $_POST['timeline_nonce'] ) )
		return;

	if ( !wp_verify_nonce( $_POST['timeline_nonce'], plugin_basename( __FILE__ ) ) )
		return;

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ) )
		return;

	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.

	$events_meta['_month'] = $_POST['_month'];
	$events_meta['_day'] = $_POST['_day'];
	$events_meta['_year'] = $_POST['_year'];
	$events_meta['_timelinetimestamp'] = $events_meta['_year'] . $events_meta['_month'] . $events_meta['_day'];

	// Add values of $events_meta as custom fields

	foreach ( $events_meta as $key => $value ) { // Cycle through the $events_meta array!
		if ( $post->post_type == 'revision' ) return; // Don't store custom data twice
		$value = implode( ',', (array)$value ); // If $value is an array, make it a CSV (unlikely)
		if ( get_post_meta( $post->ID, $key, FALSE ) ) { // If the custom field already has a value
			update_post_meta( $post->ID, $key, $value );
		} else { // If the custom field doesn't have a value
			add_post_meta( $post->ID, $key, $value );
		}
		if ( !$value ) delete_post_meta( $post->ID, $key ); // Delete if blank
	}

}

add_action( 'save_post', 'byron_save_timeline_meta', 1, 2 );
