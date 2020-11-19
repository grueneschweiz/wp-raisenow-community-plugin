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

        /**
         * initialize
         *
         * add submit event
         */
        this.init = function () {
            $('#raisenow-community-submit-short-code').click(function (event) {
                var $message = $('#raisenow-community-short-code-message');

                // don't submit
                event.preventDefault();

                // hide error message
                $message.hide();

                // create shortcode
                var shortcode = self.generateShortcode();

                // insert shortcode
                window.send_to_editor(shortcode);

                // close thickbox
                tb_remove();
            });
        };


        /**
         * generate shortcode
         *
         * @return string
         */
        this.generateShortcode = function () {
            var language = $('select[name="raisenow-community-donation_form-language"]').val(),
                amounts = {
                    onetime: [
                        $('input[name="raisenow-community-donation_form-amount-one-time-1"]').val(),
                        $('input[name="raisenow-community-donation_form-amount-one-time-2"]').val(),
                        $('input[name="raisenow-community-donation_form-amount-one-time-3"]').val(),
                        $('input[name="raisenow-community-donation_form-amount-one-time-4"]').val(),
                    ],
                    recurring: [
                        $('input[name="raisenow-community-donation_form-amount-recurring-1"]').val(),
                        $('input[name="raisenow-community-donation_form-amount-recurring-2"]').val(),
                        $('input[name="raisenow-community-donation_form-amount-recurring-3"]').val(),
                        $('input[name="raisenow-community-donation_form-amount-recurring-4"]').val()
                    ]
                };

            return '[donation_form language="' + language + '"'
                + ' one_time_1="' + amounts.onetime[0] + '"'
                + ' one_time_2="' + amounts.onetime[1] + '"'
                + ' one_time_3="' + amounts.onetime[2] + '"'
                + ' one_time_4="' + amounts.onetime[3] + '"'
                + ' recurring_1="' + amounts.recurring[0] + '"'
                + ' recurring_2="' + amounts.recurring[1] + '"'
                + ' recurring_3="' + amounts.recurring[2] + '"'
                + ' recurring_4="' + amounts.recurring[3] + '"'
                + ']';
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