(function () {
    function initGallery(gallery) {
        var items = gallery.querySelectorAll('[data-vidian-gallery-item]');
        var thumbs = gallery.querySelectorAll('[data-vidian-gallery-thumb]');

        function activate(index) {
            items.forEach(function (item) {
                item.classList.toggle('is-active', item.getAttribute('data-vidian-gallery-item') === String(index));
            });
            thumbs.forEach(function (thumb) {
                thumb.classList.toggle('is-active', thumb.getAttribute('data-vidian-gallery-thumb') === String(index));
            });
        }

        thumbs.forEach(function (thumb) {
            thumb.addEventListener('click', function () {
                activate(thumb.getAttribute('data-vidian-gallery-thumb'));
            });
        });

        items.forEach(function (item) {
            item.addEventListener('click', function () {
                var image = item.querySelector('img');
                if (!image) {
                    return;
                }

                var overlay = document.createElement('div');
                overlay.className = 'vidian-lightbox';
                overlay.innerHTML = '<button type="button" aria-label="Close">×</button><img src="' + image.src + '" alt="" />';
                document.body.appendChild(overlay);
                overlay.querySelector('button').focus();

                overlay.addEventListener('click', function () {
                    overlay.remove();
                });
            });
        });
    }

    document.querySelectorAll('.vidian-gallery').forEach(initGallery);

    var style = document.createElement('style');
    style.textContent = '.vidian-lightbox{position:fixed;inset:0;z-index:999999;background:rgba(0,0,0,.92);display:grid;place-items:center;padding:30px}.vidian-lightbox img{max-width:96vw;max-height:90vh;object-fit:contain}.vidian-lightbox button{position:absolute;right:24px;top:18px;background:#fff;border:0;color:#000;font-size:34px;height:48px;width:48px;cursor:pointer}';
    document.head.appendChild(style);
})();
