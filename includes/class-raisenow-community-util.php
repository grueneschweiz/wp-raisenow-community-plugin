<?php

/**
 * lock out script kiddies: die on direct call
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Raisenow_Community_Util {
	const WIDGET_LANGUAGES = [ 'de', 'fr', 'en' ];

	public static function get_shortcode_atts() {
		$shortcode_defaults = self::get_shortcode_defaults();
		$options            = get_option( Raisenow_Community_Options::OPTIONS_ID, [] );

		return shortcode_atts( $shortcode_defaults, $options );
	}

	public static function is_valid_language($lang) {
		return in_array( $lang, self::WIDGET_LANGUAGES, true );
	}

	private static function get_shortcode_defaults() {
		return array(
			       'api_key'         => '',
			       'widget_language' => 'en',
			       'widget_type'     => 'lema',
			       'css'             => '',
				   'javascript'      => '',
			       'class'           => 'raisenow_community_donation_form',
			       'add_class'       => '',
		       ) + self::get_default_amounts();
	}

	private static function get_default_amounts() {
		/**
		 * Filters the default amounts for new forms and for legacy forms that
		 * do not have a defined amount yet.
		 *
		 * @param array The default amounts
		 *
		 * @since 1.2.0
		 *
		 */
		return apply_filters(
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
	}
}