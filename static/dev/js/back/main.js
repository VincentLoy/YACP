/**
 * Project : wordpress_base
 * Date : 11/26/18
 * Author : Vincent Loy <vincent.loy1@gmail.com>
 * Copyright (c) Loy Vincent
 */
(function () {
    let start = function () {
        // Init the datepicker for administration
        flatpickr('.yacp_date', {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            altFormat: 'F j, Y'
        });

        // select shortcode
        let shortcodeInput = document.getElementById('#yacp_shortcode_input');

        let selectShortcode = () => {
            shortcodeInput.select();
        }

        shortcodeInput.addEventListener('click', selectAndCopy);
    }

    function ready(fn) {
        if (document.attachEvent ? document.readyState === 'complete' : document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    ready(start);
}());
