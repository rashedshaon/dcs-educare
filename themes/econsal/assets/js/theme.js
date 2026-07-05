(function () {
    var backToTop = document.querySelector('.back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', function () {
            backToTop.classList.toggle('is-visible', window.scrollY > 500);
        });
        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    function getYouTubeEmbedUrl(url) {
        if (!url) {
            return '';
        }

        var videoId = '';
        var match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/shorts\/)([A-Za-z0-9_-]{6,})/);

        if (match && match[1]) {
            videoId = match[1];
        }

        if (!videoId) {
            try {
                var parsedUrl = new URL(url);
                videoId = parsedUrl.searchParams.get('v') || '';
            } catch (e) {
                videoId = '';
            }
        }

        return videoId ? 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0' : url;
    }

    document.querySelectorAll('[data-video-url]').forEach(function (button) {
        button.addEventListener('click', function () {
            var url = button.getAttribute('data-video-url');
            var modalElement = document.getElementById('videoModal');
            var frame = document.getElementById('videoModalFrame');

            if (!url || !modalElement || !frame || !window.bootstrap) {
                return;
            }

            frame.setAttribute('src', getYouTubeEmbedUrl(url));
            bootstrap.Modal.getOrCreateInstance(modalElement).show();
        });
    });

    var videoModal = document.getElementById('videoModal');
    if (videoModal) {
        videoModal.addEventListener('hidden.bs.modal', function () {
            var frame = document.getElementById('videoModalFrame');
            if (frame) {
                frame.setAttribute('src', '');
            }
        });
    }

    window.addEventListener('load', function () {
        var preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.classList.add('is-hidden');
        }
    });
})();
