<?php if ( empty( get_option( RAISENOW_COMMUNITY_PREFIX . '_donation_options', array() )['api_key'] ) ): ?>
    <div class="notice-warning">
		<?php echo sprintf(
			__( 'You need to have a contract with %s.',
				RAISENOW_COMMUNITY_PREFIX ),
			'<a href="https://www.raisenow.com/">RaiseNow</a>' ) ?>
        <br>
		<?php if ( current_user_can( 'manage_options' ) ) {
			$settings_link = admin_url( 'options-general.php?page=' . RAISENOW_COMMUNITY_PREFIX . '_donation_settings' );

			echo sprintf(
				_x( 'Missing API key. Add the API key you received from RaiseNow to your %splugin settings%s.',
					'HTML link tag to the settings page',
					RAISENOW_COMMUNITY_PREFIX
				),
				'<a href="' . $settings_link . '" target="_blank">',
				'</a>' );
		} else {
			echo __( 'Missing api key. Please contact site administrator.', RAISENOW_COMMUNITY_PREFIX );
		} ?>
    </div>
<?php endif; ?>