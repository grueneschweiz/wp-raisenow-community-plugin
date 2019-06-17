<div id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-short-code-generator" style="display: none;">
    <div class="raisenow-community-wrapper">
        <div id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-short-code-message" class="notice-warning"></div>
        <form action="#" method="post">
            <div id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-short-code-donation_form"
                 class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-short-code-type-element">
                <div class="notice-info">
                    <p><?php echo sprintf(
							__( 'You need to have a contract with %s to use this function.',
								RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
							'<a href="https://www.raisenow.com/">RaiseNow</a>' ) ?></p>
                </div>
                <p id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-select-donation_form-language"
                   class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-short-code-input">
                    <label for="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-language">
						<?php _e( 'Choose language for the donation form', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ); ?>
                    </label><br/>
                    <select name="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-language"
                            id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-language">
                        <option value="de" selected="selected"><?php _e( 'German',
								RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ); ?></option>
                        <option value="fr"><?php _e( 'French', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ); ?></option>
                        <option value="en"><?php _e( 'English', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ); ?></option>
                    </select>
                </p>
            </div>
            <input id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-submit-short-code" type="submit"
                   value="<?php esc_attr_e( 'Insert shortcode', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ); ?>"
                   class="button button-primary button-large">
        </form>
    </div>
</div>