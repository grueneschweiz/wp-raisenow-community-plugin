<div id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-short-code-generator" style="display: none;">
    <div class="raisenow-community-wrapper">
        <div id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-short-code-message"></div>
        <form action="#" method="post">
            <div id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-short-code-donation_form"
                 class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-short-code-type-element">

				<?php include RAISENOW_COMMUNITY_PATH . '/admin/configuration-warning.php' ?>

                <div id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-select-donation_form-language"
                     class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-short-code-input">
                    <h3><?php _e( 'Language' ) ?></h3>
                    <label for="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-language">
						<?php _e( 'Choose language for the donation form', RAISENOW_COMMUNITY_PREFIX ); ?>
                    </label><br/>
					<?php $lang = substr( get_locale(), 0, 2 ); ?>
                    <select name="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-language"
                            id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-language">
                        <option value="de" <?php if ( 'de' === $lang )
							echo 'selected="selected"' ?>>
							<?php _e( 'German', RAISENOW_COMMUNITY_PREFIX ); ?></option>
                        <option value="fr" <?php if ( 'fr' === $lang )
							echo 'selected="selected"' ?>>
							<?php _e( 'French', RAISENOW_COMMUNITY_PREFIX ); ?></option>
                        <option value="en" <?php if ( 'en' === $lang )
							echo 'selected="selected"' ?>>
							<?php _e( 'English', RAISENOW_COMMUNITY_PREFIX ); ?></option>
                    </select>
                </div>
                <div id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-select-donation_form-amounts"
                     class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-short-code-input">
                    <h3><?php _e( 'Amounts', RAISENOW_COMMUNITY_PREFIX ) ?></h3>
                    <h4><?php _e( 'One Time Donations', RAISENOW_COMMUNITY_PREFIX ) ?></h4>
                    <div><?php _e( 'Set the predefined amounts for one time donations in CHF. Field 2 will be preselected.', RAISENOW_COMMUNITY_PREFIX ) ?></div>
                    <div class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount">
                        <label for="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-one-time-1">
							<?php _e( 'Field 1', RAISENOW_COMMUNITY_PREFIX ); ?>
                        </label>
                        <input type="number"
                               name="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-one-time-1"
                               step="1"
                               min="1"
                               max="9999"
                               value="<?php echo $default_amounts['one_time_1'] ?>">
                    </div>
                    <div class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount">
                        <label for="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-one-time-2">
							<?php _e( 'Field 2', RAISENOW_COMMUNITY_PREFIX ); ?>
                        </label>
                        <input type="number"
                               name="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-one-time-2"
                               step="1"
                               min="1"
                               max="9999"
                               value="<?php echo $default_amounts['one_time_2'] ?>">
                    </div>
                    <div class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount">
                        <label for="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-one-time-3">
							<?php _e( 'Field 3', RAISENOW_COMMUNITY_PREFIX ); ?>
                        </label>
                        <input type="number"
                               name="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-one-time-3"
                               step="1"
                               min="1"
                               max="9999"
                               value="<?php echo $default_amounts['one_time_3'] ?>">
                    </div>
                    <div class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount">
                        <label for="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-one-time-4">
							<?php _e( 'Field 4', RAISENOW_COMMUNITY_PREFIX ); ?>
                        </label>
                        <input type="number"
                               name="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-one-time-4"
                               step="1"
                               min="1"
                               max="9999"
                               value="<?php echo $default_amounts['one_time_4'] ?>">
                    </div>
                    <h4><?php _e( 'Recurring Donations', RAISENOW_COMMUNITY_PREFIX ) ?></h4>
                    <div><?php _e( 'Set the predefined amounts for recurring donations in CHF. Field 2 will be preselected.', RAISENOW_COMMUNITY_PREFIX ) ?></div>
                    <div class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount">
                        <label for="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-recurring-1">
							<?php _e( 'Field 1', RAISENOW_COMMUNITY_PREFIX ); ?>
                        </label>
                        <input type="number"
                               name="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-recurring-1"
                               step="1"
                               min="1"
                               max="9999"
                               value="<?php echo $default_amounts['recurring_1'] ?>">
                    </div>
                    <div class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount">
                        <label for="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-recurring-2">
							<?php _e( 'Field 2', RAISENOW_COMMUNITY_PREFIX ); ?>
                        </label>
                        <input type="number"
                               name="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-recurring-2"
                               step="1"
                               min="1"
                               max="9999"
                               value="<?php echo $default_amounts['recurring_2'] ?>">
                    </div>
                    <div class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount">
                        <label for="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-recurring-3">
							<?php _e( 'Field 3', RAISENOW_COMMUNITY_PREFIX ); ?>
                        </label>
                        <input type="number"
                               name="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-recurring-3"
                               step="1"
                               min="1"
                               max="9999"
                               value="<?php echo $default_amounts['recurring_3'] ?>">
                    </div>
                    <div class="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount">
                        <label for="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-recurring-4">
							<?php _e( 'Field 4', RAISENOW_COMMUNITY_PREFIX ); ?>
                        </label>
                        <input type="number"
                               name="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-donation_form-amount-recurring-4"
                               step="1"
                               min="1"
                               max="9999"
                               value="<?php echo $default_amounts['recurring_4'] ?>">
                    </div>
                </div>
            </div>
            <input id="<?php echo RAISENOW_COMMUNITY_PREFIX ?>-submit-short-code" type="submit"
                   value="<?php esc_attr_e( 'Insert shortcode', RAISENOW_COMMUNITY_PREFIX ); ?>"
                   class="button button-primary button-large">
        </form>
    </div>
</div>