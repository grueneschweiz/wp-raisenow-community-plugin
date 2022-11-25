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
		echo '<a href="#TB_inline?&inlineId=' . RAISENOW_COMMUNITY_PREFIX . '-short-code-generator&height=550&width=600" class="thickbox button" ' .
		     'title="' . esc_attr__( 'Insert Donation Form', RAISENOW_COMMUNITY_PREFIX ) . '">' .
		     '<span class="wp-media-buttons-icon dashicons dashicons-plus"></span> ' .
		     __( 'Insert Donation Form', RAISENOW_COMMUNITY_PREFIX ) . '</a>';
	}

	/**
	 * print out the shortcode generators html
	 */
	function add_short_code_generator_html() {
		/**
		 * Filters the default amounts for new forms and for legacy forms that
		 * do not have a defined amount yet.
		 *
		 * @param array The default amounts
		 *
		 * @since 1.2.0
		 *
		 */
		$default_amounts = apply_filters(
			RAISENOW_COMMUNITY_PREFIX . '_default_amounts',
			array(
				'one_time_1'  => '10',
				'one_time_2'  => '20',
				'one_time_3'  => '50',
				'one_time_4'  => '100',
				'recurring_1' => '5',
				'recurring_2' => '10',
				'recurring_3' => '30',
				'recurring_4' => '100',
			)
		);

		// include thickbox content
		include RAISENOW_COMMUNITY_PATH . '/admin/short-code-generator.php';
	}
}