/**
 * jQuery wrapper
 *
 * @param {jQuery} $
 */
(function ($) {
    /**
     * handles all the functionality of the short code generator
     */
    var ShortCodeGen = function () {

        var self = this;
        var error = '';

        /**
         * initialize
         *
         * add submit event
         */
        this.init = function () {
            console.log('hugo');
            $('#raisenow-community-submit-short-code').click(function (event) {
                var $message = $('#raisenow-community-short-code-message');

                // don't submit
                event.preventDefault();

                // hide error message
                $message.hide();

                // check if input is valid
                if (false === self.isInputValid()) {
                    $message.text(self.error).show();
                    return;
                }

                // create shortcode
                var shortcode = self.generateShortcode();

                // insert shortcode
                window.send_to_editor(shortcode);

                // close thickbox
                tb_remove();
            });
        };

        /**
         * validate input
         *
         * @return bool
         */
        this.isInputValid = function () {
            if ('' !== $('input[name="raisenow-community-donation_form-api_key"]').val()) {
                return true;
            } else {
                self.error = raisenow_community_invalid_shortcode_msg;
                return false;
            }
        };


        /**
         * generate shortcode
         *
         * @return string
         */
        this.generateShortcode = function () {
            var api_key = $('input[name="raisenow-community-donation_form-api_key"]').val(),
                language = $('select[name="raisenow-community-donation_form-language"]').val();
            return '[donation_form api_key="' + api_key + '" language="' + language + '"]';
        };
    };

    /**
     * wait until DOM is loaded
     */
    $(document).ready(function () {
        var shortcode_gen = new ShortCodeGen();
        shortcode_gen.init();
    });
})(jQuery);