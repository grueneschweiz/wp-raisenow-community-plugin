<?php

/**
 * lock out script kiddies: die an direct call
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * This class contains all the extra stuff of the backend
 */
class Raisenow_Community_Admin {
	
	/**
	 * Add a media button above the tinyMCE to insert shortcode easily
	 *
	 * @see http://de.wpseek.com/function/media_buttons/
	 */
	public function add_media_button() {
		// make sure the thickbox script is loaded
		add_thickbox();
		
		// add media button
		echo '<a href="#TB_inline?&inlineId='.RAISENOW_COMMUNITY_PREFIX.'-short-code-generator" class="thickbox button" ' .
		     'title="' . esc_attr__( 'Insert Donation Form', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . '">' .
		     '<span class="wp-media-buttons-icon dashicons dashicons-plus"></span> ' .
		     __( 'Insert Donation Form', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . '</a>';
	}
	
	/**
	 * print out the shortcode generators html
	 */
	function add_short_code_generator_html() {
		// include thickbox content
		include RAISENOW_COMMUNITY_PATH . '/admin/short-code-generator.php';
	}
}