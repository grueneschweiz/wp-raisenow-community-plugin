<div class="wrap">
    <h2><?php _e( 'Online donation options', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community'); ?></h2>

    <form action="options.php" method="post">
		
		<?php
		settings_fields( RAISENOW_COMMUNITY_PREFIX . '_donation_settings' );
		do_settings_sections( RAISENOW_COMMUNITY_PREFIX . '_donation_settings' );
		submit_button();
		?>

    </form>
</div>