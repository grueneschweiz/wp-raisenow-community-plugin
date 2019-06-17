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
            var language = $('select[name="raisenow-community-donation_form-language"]').val();
            return '[donation_form language="' + language + '"]';
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