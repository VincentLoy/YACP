/**
 * Project : wordpress_base
 * Date : 11/26/18
 * Author : Vincent Loy <vincent.loy1@gmail.com>
 * Copyright (c) Loy Vincent
 */

window.setTimeout(function () {
    flatpickr('.yacp_date', {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        altFormat: 'F j, Y'
    });
}, 0);
