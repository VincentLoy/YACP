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

    let pageTitle = document.querySelector('header h1');
    let processValue = (val) => {
        return val / 150;
    };

    document.onmousemove = (event) => {
        let eventDoc, doc, body;
        event = event || window.event; // IE-ism

        // If pageX/Y aren't available and clientX/Y are,
        // calculate pageX/Y - logic taken from jQuery.
        // (This is to support old IE)
        if (event.pageX === null && event.clientX !== null) {
            eventDoc = (event.target && event.target.ownerDocument) || document;
            doc = eventDoc.documentElement;
            body = eventDoc.body;

            event.pageX = event.clientX +
                (doc && doc.scrollLeft || body && body.scrollLeft || 0) -
                (doc && doc.clientLeft || body && body.clientLeft || 0);
            event.pageY = event.clientY +
                (doc && doc.scrollTop || body && body.scrollTop || 0) -
                (doc && doc.clientTop || body && body.clientTop || 0 );
        }

        pageTitle.style.textShadow =
            `${processValue(event.pageX)}px ${processValue(event.pageY)}px 0 #e59500`;
    }
})();