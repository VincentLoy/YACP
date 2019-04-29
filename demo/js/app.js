/**
 * Project : wordpress_base
 * Date : 4/29/19
 * Author : Vincent Loy <vincent.loy1@gmail.com>
 * Copyright (c) Loy Vincent
 */
(function () {
    let images = document.querySelectorAll('img.rounded');

    Array.prototype.forEach.call(images, (img) => {
        img.onclick = () => {
            basicLightbox.create(`
                <img src="${img.getAttribute('src')}">
            `).show();
        };
    });
})();