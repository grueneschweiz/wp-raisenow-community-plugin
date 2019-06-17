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

		extract(
			shortcode_atts(
				array(
					'api_key'   => $options['api_key'],
					'language'  => '',
					'css'       => '',
					'class'     => 'raisenow_community_donation_form',
					'add_class' => '',
				),
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
				       . sprintf( _x( 'Donation form: Missing api key. Add the API key you received from RaiseNow on in your %splugin settings.%s', 'HTML link tag to the settings page', RAISENOW_COMMUNITY_PREFIX ),
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
						'[donation_form api_key="API_KEY" language="LANG"]' ) . '</div>';
			} else {
				return '<div>' . __( 'Donation form: Invalid language setting. Please contact site administrator.', RAISENOW_COMMUNITY_PREFIX ) . '</div>';
			}
		}

		$custom_css    = $options['css'];
		$custom_script = $options['javascript'];

		return '<div class="' . esc_attr( $class ) . ' ' . esc_attr( $add_class ) . '" style="' . esc_attr( $css ) . '">'
		       . '<div class="dds-widget-container" data-widget="lema"></div>'
		       . '<script language="javascript" src="https://widget.raisenow.com/widgets/lema/' . esc_attr( $api_key ) . '/js/dds-init-widget-' . esc_attr( $language ) . '.js" type="text/javascript"></script>'
		       . '<script type="text/javascript">' . $custom_script . '</script>'
		       . '<style type="text/css">' . $custom_css . '</style>'
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
		$options            = get_option( RAISENOW_COMMUNITY_PREFIX . '_donation_options' );
		$options['api_key'] = $api_key;
		update_option( RAISENOW_COMMUNITY_PREFIX . '_donation_options', $options );
	}
}