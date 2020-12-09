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
		$languages = [ 'de', 'fr', 'en' ];
		$options   = get_option( RAISENOW_COMMUNITY_PREFIX . '_donation_options' );

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

		$defaults = array(
			'api_key'   => $options['api_key'],
			'language'  => '',
			'css'       => '',
			'class'     => 'raisenow_community_donation_form',
			'add_class' => '',
		);

		extract(
			shortcode_atts(
				$defaults + $default_amounts,
				$atts
			)
		);

		$api_key = trim( $api_key );

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

		$language = trim( strtolower( $language ) );
		if ( ! in_array( $language, $languages ) ) {
			$id = get_the_ID();
			if ( current_user_can( 'edit_posts', $id ) || current_user_can( 'edit_pages', $id ) ) {
				return '<div>' . sprintf( __( 'Donation form: Unknown language key in shortcode. Accepted values are %1$s. Shortcode must have the form: %2$s',
						'%1$s will be replaced with the accepted language keys. %2$s will be replaced with an example shortcode.',
						RAISENOW_COMMUNITY_PREFIX ), implode( ', ', $languages ),
						'[donation_form language="en" one_time_1="200" one_time_2="100" one_time_3="50" one_time_4="20" recurring_1="100" recurring_2="50" recurring_3="20" recurring_4="5"]' ) . '</div>';
			} else {
				return '<div>' . __( 'Donation form: Invalid language setting. Please contact site administrator.', RAISENOW_COMMUNITY_PREFIX ) . '</div>';
			}
		}

		$one_time_amounts = [
			1 => $one_time_1,
			2 => $one_time_2,
			3 => $one_time_3,
			4 => $one_time_4
		];

		$recurring_amounts = [
			1 => $recurring_1,
			2 => $recurring_2,
			3 => $recurring_3,
			4 => $recurring_4
		];

		$custom_css    = $options['css'];
		$custom_script = $options['javascript'];
		$form_type = $options['form_type'];

		if($form_type == 'tamaro'){
			return '<div class="' . esc_attr( $class ) . ' ' . esc_attr( $add_class ) . '" style="' . esc_attr( $css ) . '">'
			. '<div class="dds-widget-container"></div>'
			. '<script language="javascript" src="https://tamaro.raisenow.com/' . esc_attr( $api_key ) . '/latest/widget.js" type="text/javascript"></script>'
			. '<script type="text/javascript">' . $custom_script . '</script>'
			. "<script>window.rnw.tamaro.runWidget('.dds-widget-container', {language: 'de'});</script>"
			. '<style type="text/css">' . $custom_css . '</style>'
			. '</div>';
		}

		else{
			return '<div class="' . esc_attr( $class ) . ' ' . esc_attr( $add_class ) . '" style="' . esc_attr( $css ) . '">'
			. '<div class="dds-widget-container" data-widget="lema"></div>'
		    . '<script language="javascript" src="https://widget.raisenow.com/widgets/lema/' . esc_attr( $api_key ) . '/js/dds-init-widget-' . esc_attr( $language ) . '.js" type="text/javascript"></script>'
		    . '<script type="text/javascript">' . $custom_script . '</script>'
		    . '<script type="text/javascript">' . $this->amounts_js( $one_time_amounts, $recurring_amounts ) . '</script>'
		    . '<style type="text/css">' . $custom_css . '</style>'
		    . '</div>';	
		}
	}

	/**
	 * Add the given API key to the global settings.
	 *
	 * This function is used to migrate from plugins version prior 1.1.0.
	 *
	 * @param $api_key
	 */
	private function legacy_add_api_key_to_global_settings( $api_key ) {
		$options            = get_option( RAISENOW_COMMUNITY_PREFIX . '_donation_options' );
		$options['api_key'] = $api_key;
		update_option( RAISENOW_COMMUNITY_PREFIX . '_donation_options', $options );
	}

	/**
	 * Returns the JS to inject in order to customize the amounts.
	 *
	 * @param array $one_time
	 * @param array $recurring
	 *
	 * @return string
	 */
	private function amounts_js( $one_time, $recurring ) {
		return 'window.rnwWidget = window.rnwWidget || {};'
		       . 'window.rnwWidget.configureWidget = window.rnwWidget.configureWidget || [];'
		       . 'window.rnwWidget.configureWidget.push(function(options) {'
		       . 'options.translations.step_amount.onetime_amounts = ' . $this->get_amounts_json( $one_time ) . ';'
		       . 'options.translations.step_amount.recurring_amounts = ' . $this->get_amounts_json( $recurring ) . ';'
		       . "options.defaults['ui_onetime_amount_default'] = " . (int) $one_time[2] * 100 . ';'
		       . "options.defaults['ui_recurring_amount_default'] = " . (int) $recurring[2] * 100 . ';'
		       . '});';
	}

	/**
	 * Transform the amounts into the expected format by the lema widget.
	 *
	 * @param $amounts
	 *
	 * @return false|string
	 */
	private function get_amounts_json( $amounts ) {
		$ret = [];
		foreach ( $amounts as $amount ) {
			$a     = (int) $amount;
			$ret[] = [ 'text' => $a, 'value' => $a * 100 ];
		}

		return json_encode( $ret );
	}
}