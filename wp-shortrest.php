<?php
/*
Plugin Name:  ShortRest - The Shortcode REST API Plugin
Description:  ShortRest allows you to easily consume APIs without coding, and use them however you wish in your website via handy shortcodes.
Version:      0.0.1
Author:       Estevão "Steven" Neto
Text Domain:  wp-shortrest
License:      GPLv3

    Copyright (C) 2023 Estevão J. Neto

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

*/

if ( ! defined( 'ABSPATH' ) ) {
	exit('Go for a short rest, chap.');
}

if(file_exists(__DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php'))
{
    require __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
} else {
    exit("vendor/autoload.php is missing; please run `composer install`");
}

define('SHORTREST_VERSION', '0.0.1');

\SR\Plugin::instantiate();


// TODO: Actually put this in a proper class

// Add the meta box
function sr_request_add_meta_box() {
    add_meta_box(
        'sr_request_metabox',         // Unique ID
        'Request Information',        // Title
        'sr_request_meta_box_callback', // Callback function
        'sr_request'                   // Post type
    );
}
add_action( 'add_meta_boxes', 'sr_request_add_meta_box' );

// Callback to render the HTML for the meta box
function sr_request_meta_box_callback( $post ) {
    // Add a nonce for security
    wp_nonce_field( 'sr_request_save_meta_box', 'sr_request_meta_box_nonce' );

    // Get the current values if they exist
    $request_url = get_post_meta( $post->ID, 'request_url', true );
    $method      = get_post_meta( $post->ID, 'method', true );

    // HTML for the meta box
    echo '<label for="request_url">Request URL: </label>';
    echo '<input type="text" id="request_url" name="request_url" value="' . esc_attr( $request_url ) . '">';
    echo '<br>';

    echo '<label for="method">Method: </label>';
    echo '<select id="method" name="method">';
    echo '<option value="POST"' . selected( $method, 'POST', false ) . '>POST</option>';
    echo '<option value="GET"' . selected( $method, 'GET', false ) . '>GET</option>';
    echo '</select>';
}

// Save the meta box data
function sr_request_save_meta_box( $post_id ) {
    // Verify the nonce
    if ( ! isset( $_POST['sr_request_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['sr_request_meta_box_nonce'], 'sr_request_save_meta_box' ) ) {
        return;
    }

    // Don't save during autosave or for other post types
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( 'sr_request' !== $_POST['post_type'] ) {
        return;
    }

    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save the fields
    if ( isset( $_POST['request_url'] ) ) {
        update_post_meta( $post_id, 'request_url', sanitize_text_field( $_POST['request_url'] ) );
    }

    if ( isset( $_POST['method'] ) ) {
        update_post_meta( $post_id, 'method', sanitize_text_field( $_POST['method'] ) );
    }
}
add_action( 'save_post', 'sr_request_save_meta_box' );
