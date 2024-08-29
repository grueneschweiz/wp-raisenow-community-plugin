<?php

/**
 * lock out script kiddies: die on direct call
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Raisenow_Community_Frontend {
	/**
	 * Process shortcode for raise now donation forms
	 *
	 * Use [donation_form] with the required arguments 'api_key' and 'language'.
	 * Use the conditional arguments 'css' to add some custom styles and 'add_class'
	 * to append some custom classes.
	 *
	 * @param array $atts given from the add_shortcode function
	 *
	 * @return string
	 */
	public function donation_form( $atts ) {
		$options = shortcode_atts(
			Raisenow_Community_Util::get_shortcode_atts(),
			$atts
		);

		/**
		 * As we use the key 'language' in the shortcode and 'widget_language' in the settings,
		 * we have to add the value from the shortcode manually to $options.
		 */
		if ( ! empty( $atts['language'] ) ) {
			$lang = strtolower( trim( $atts['language'] ) );
			if ( Raisenow_Community_Util::is_valid_language( $lang ) ) {
				$options['widget_language'] = $atts['language'];
			}
		}

		$api_key = trim( $options['api_key'] );

		/**
		 * Migration function: Add the form api key as global api key
		 *
		 * Since we had an API key per form prior to version 1.1.0 we
		 * add the first forms api key as global key.
		 *
		 * @since 1.1.0
		 */
		if ( $api_key && empty( $options['api_key'] ) ) {
			$this->legacy_add_api_key_to_global_settings( $api_key );
		}

		if ( empty( $api_key ) ) {
			if ( current_user_can( 'manage_options' ) ) {
				$settings_link = admin_url( 'options-general.php?page=' . RAISENOW_COMMUNITY_PREFIX . '_donation_settings' );

				return '<div>'
				       . sprintf( _x( 'Donation form: Missing api key. Add the API key you received from RaiseNow to your %splugin settings%s.', 'HTML link tag to the settings page', RAISENOW_COMMUNITY_PREFIX ),
						'<a href="' . $settings_link . '" target="_blank">',
						'</a>' )
				       . '</div>';
			} else {
				return '<div>' . __( 'Donation form: Missing api key. Please contact site administrator.', RAISENOW_COMMUNITY_PREFIX ) . '</div>';
			}
		}

		$language = strtolower( trim( $options['widget_language'] ) );
		if ( ! in_array( $language, Raisenow_Community_Util::WIDGET_LANGUAGES ) ) {
			$id = get_the_ID();
			if ( current_user_can( 'edit_posts', $id ) || current_user_can( 'edit_pages', $id ) ) {
				return '<div>' . sprintf( __( 'Donation form: Unknown language key in shortcode. Accepted values are %1$s. Shortcode must have the form: %2$s',
						'%1$s will be replaced with the accepted language keys. %2$s will be replaced with an example shortcode.',
						RAISENOW_COMMUNITY_PREFIX ), implode( ', ', Raisenow_Community_Util::WIDGET_LANGUAGES ),
						'[donation_form language="en" one_time_1="200" one_time_2="100" one_time_3="50" one_time_4="20" recurring_1="100" recurring_2="50" recurring_3="20" recurring_4="5"]' ) . '</div>';
			} else {
				return '<div>' . __( 'Donation form: Invalid language setting. Please contact site administrator.', RAISENOW_COMMUNITY_PREFIX ) . '</div>';
			}
		}

		$one_time_amounts  = $this->get_amounts( 'one_time', $options );
		$recurring_amounts = $this->get_amounts( 'recurring', $options );

		$custom_css    = $options['css'];
		$custom_script = $options['javascript'];

		if ( $options['widget_type'] === 'tamaro' ) {
			return '<div class="' . esc_attr( $options['class'] ) . ' ' . esc_attr( $options['add_class'] ) . '">'
			       . '<div class="rnw-widget-container"></div>'
			       . '<script type="text/javascript" referrerpolicy="no-referrer" src="https://tamaro.raisenow.com/' . esc_attr( $api_key ) . '/latest/widget.js"></script>'
			       . '<script type="text/javascript">' . $custom_script . '</script>'
			       . '<script type="text/javascript">' . $this->js_tamaro( $one_time_amounts, $recurring_amounts, $language ) . '</script>'
			       . '<style>' . $custom_css . '</style>'
			       . '</div>';
		}

		return '<div class="' . esc_attr( $options['class'] ) . ' ' . esc_attr( $options['add_class'] ) . '">'
		       . '<div class="dds-widget-container" data-widget="lema"></div>'
		       . '<script type="text/javascript" referrerpolicy="no-referrer" src="https://widget.raisenow.com/widgets/lema/' . esc_attr( $api_key ) . '/js/dds-init-widget-' . esc_attr( $language ) . '.js"></script>'
		       . '<script type="text/javascript">' . $custom_script . '</script>'
		       . '<script type="text/javascript">' . $this->amounts_js_lema( $one_time_amounts, $recurring_amounts ) . '</script>'
		       . '<style>' . $custom_css . '</style>'
		       . '</div>';
	}

	/**
	 * Add the given API key to the global settings.
	 *
	 * This function is used to migrate from plugins version prior 1.1.0.
	 *
	 * @param $api_key
	 */
	private function legacy_add_api_key_to_global_settings( $api_key ) {
		$options            = get_option( Raisenow_Community_Options::OPTIONS_ID );
		$options['api_key'] = $api_key;
		update_option( Raisenow_Community_Options::OPTIONS_ID, $options );
	}

	/**
	 * Returns the JS to inject in order to customize the amounts in lema form.
	 *
	 * @param array $one_time
	 * @param array $recurring
	 *
	 * @return string
	 */
	private function amounts_js_lema( $one_time, $recurring ) {
		$one_time_default  = count( $one_time ) >= 2 ? $one_time[1] : $one_time[0];
		$recurring_default = count( $recurring ) >= 2 ? $recurring[1] : $recurring[0];

		return 'window.rnwWidget = window.rnwWidget || {};'
		       . 'window.rnwWidget.configureWidget = window.rnwWidget.configureWidget || [];'
		       . 'window.rnwWidget.configureWidget.push(function(options) {'
		       . 'options.translations.step_amount.onetime_amounts = ' . $this->get_lema_amounts_json( $one_time ) . ';'
		       . 'options.translations.step_amount.recurring_amounts = ' . $this->get_lema_amounts_json( $recurring ) . ';'
		       . "options.defaults['ui_onetime_amount_default'] = " . (int) $one_time_default * 100 . ';'
		       . "options.defaults['ui_recurring_amount_default'] = " . (int) $recurring_default * 100 . ';'
		       . '});';
	}

	/**
	 * Returns the JS to inject in order to customize the amounts in tamaro form.
	 *
	 * @param array $one_time
	 * @param array $recurring
	 * @param string $language
	 *
	 * @return string
	 */
	private function js_tamaro( $one_time, $recurring, $language ) {
		$one_time_amounts_string   = implode( ',', $one_time );
		$recurring_amounts_strings = $this->get_tamaro_recurring_amounts( $recurring );

		$default = count( $one_time ) >= 2 ? $one_time[1] : $one_time[0];

		return <<<EOJS
if (window.rnw && window.rnw.tamaro) {
	window.rnw.tamaro.runWidget('.rnw-widget-container', {
	  amounts: [
	    {
	       "if": "paymentType() === onetime",
	       "then": [$one_time_amounts_string],
	    },
	    {
	       "if": "paymentType() === recurring && recurringInterval() === monthly",
	       "then": [{$recurring_amounts_strings['monthly']}],
	    },
	    {
	       "if": "paymentType() === recurring && recurringInterval() === quarterly",
	       "then": [{$recurring_amounts_strings['quarterly']}],
	    },
	    {
	       "if": "paymentType() === recurring && recurringInterval() === semestral",
	       "then": [{$recurring_amounts_strings['semestral']}],
	    },
	    {
	       "if": "paymentType() === recurring && recurringInterval() === yearly",
	       "then": [{$recurring_amounts_strings['yearly']}],
	    },
	  ],
	  defaultAmount: {$default},
	  language: '$language'
	});
}
EOJS;
	}

	/**
	 * Transform the amounts into the expected format by the lema widget.
	 *
	 * @param $amounts
	 *
	 * @return false|string
	 */
	private function get_lema_amounts_json( $amounts ) {
		$ret = [];
		foreach ( $amounts as $amount ) {
			$a     = (int) $amount;
			$ret[] = [ 'text' => $a, 'value' => $a * 100 ];
		}

		return json_encode( $ret );
	}

	/**
	 * Extrapolate the monthly amounts for recurring donations for quarterly,
	 * semestral and yearly recurring donations.
	 *
	 * @param array $amounts amounts for monthly recurring donations
	 *
	 * @return array with the indexes 'monthly', 'quarterly', 'semestral', 'yearly'
	 */
	private function get_tamaro_recurring_amounts( $amounts ) {
		$monthly   = implode( ',', $amounts );
		$quarterly = implode( ',',
			array_map(
				static function ( $amount ) {
					/**
					 * Filters the multiplier to extrapolate the amount of
					 * monthly recurring donations to quarterly donations.
					 *
					 * @param int The default multiplier
					 *
					 * @since 1.4.0
					 */
					return $amount * apply_filters( RAISENOW_COMMUNITY_PREFIX . '_quarterly_amount_multiplier', 3 );
				},
				$amounts )
		);
		$semestral = implode( ',',
			array_map(
				static function ( $amount ) {
					/**
					 * Filters the multiplier to extrapolate the amount of
					 * monthly recurring donations to semestral donations.
					 *
					 * @param int The default multiplier
					 *
					 * @since 1.4.0
					 */
					return $amount * apply_filters( RAISENOW_COMMUNITY_PREFIX . '_semestral_amount_multiplier', 6 );
				},
				$amounts )
		);
		$yearly    = implode( ',',
			array_map(
				static function ( $amount ) {
					/**
					 * Filters the multiplier to extrapolate the amount of
					 * monthly recurring donations to yearly donations.
					 *
					 * @param int The default multiplier
					 *
					 * @since 1.4.0
					 */
					return $amount * apply_filters( RAISENOW_COMMUNITY_PREFIX . '_yearly_amount_multiplier', 12 );
				},
				$amounts )
		);

		return compact( 'monthly', 'quarterly', 'semestral', 'yearly' );
	}

	/**
	 * Get the amounts from the shortcode $atts or set default amounts if none
	 * are given.
	 *
	 * @param string $type the amount type. allowed types: 'one_time', 'recurring'
	 * @param array $atts the shortcode attributes as provided by the add_shortcode function
	 *
	 * @return array
	 */
	private function get_amounts( $type, $atts ) {
		$amounts = array();

		for ( $i = 0; $i <= 10; $i ++ ) {
			$key = "{$type}_{$i}";
			if ( array_key_exists( $key, $atts )
			     && ! empty( $atts[ $key ] ) ) {
				$amounts[] = $atts[ $key ];
			}
		}

		return $amounts;
	}
}