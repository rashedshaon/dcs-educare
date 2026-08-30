(function () {
    var themeScript = document.currentScript;
    var gtmEnabled = Boolean(
        themeScript &&
        themeScript.getAttribute('data-gtm-enabled') === 'true' &&
        Array.isArray(window.dataLayer)
    );

    function cleanText(value) {
        return String(value || '').replace(/\s+/g, ' ').trim().slice(0, 120);
    }

    function linkLabel(link) {
        var image = link.querySelector('img[alt]');
        return cleanText(link.textContent) ||
            cleanText(link.getAttribute('aria-label')) ||
            cleanText(image && image.getAttribute('alt'));
    }

    function pushDataLayerEvent(eventName, parameters) {
        if (!gtmEnabled) {
            return;
        }

        var eventData = { event: eventName };
        Object.keys(parameters || {}).forEach(function (key) {
            if (parameters[key] !== undefined && parameters[key] !== null && parameters[key] !== '') {
                eventData[key] = parameters[key];
            }
        });
        window.dataLayer.push(eventData);
    }

    function elementLocation(element) {
        if (element.closest('header')) {
            return element.closest('#mobileMenu') ? 'mobile_menu' : 'header';
        }
        if (element.closest('footer')) {
            return 'footer';
        }
        if (element.closest('.hero-slider')) {
            return 'hero';
        }
        if (element.closest('.contact-band')) {
            return 'contact_band';
        }
        if (element.closest('.cta-band')) {
            return 'cta_band';
        }
        return document.body.getAttribute('data-page-type') || 'page';
    }

    function socialNetwork(url) {
        var host = url.hostname.replace(/^www\./, '');
        var networks = {
            'facebook.com': 'facebook',
            'instagram.com': 'instagram',
            'linkedin.com': 'linkedin',
            'youtube.com': 'youtube',
            'youtu.be': 'youtube',
            'tiktok.com': 'tiktok',
            'twitter.com': 'x',
            'x.com': 'x'
        };

        var matchedHost = Object.keys(networks).find(function (networkHost) {
            return host === networkHost || host.endsWith('.' + networkHost);
        });

        return matchedHost ? networks[matchedHost] : '';
    }

    function contentSelection(link) {
        var card = link.closest('.image-card, .visa-card, .blog-card');
        if (!card) {
            return;
        }

        var heading = card.querySelector('h2, h3');
        var itemType = card.classList.contains('blog-card') ? 'blog_post' :
            (card.classList.contains('visa-card') ? 'visa_category' : 'study_destination');

        pushDataLayerEvent('select_content', {
            content_type: itemType,
            item_name: heading ? cleanText(heading.textContent) : cleanText(link.textContent),
            click_location: elementLocation(link)
        });
    }

    document.addEventListener('click', function (event) {
        var link = event.target.closest('a[href]');
        if (!link) {
            return;
        }

        var href = link.getAttribute('href') || '';
        var location = elementLocation(link);

        if (/^tel:/i.test(href)) {
            pushDataLayerEvent('contact_click', { contact_method: 'phone', click_location: location });
            return;
        }

        if (/^mailto:/i.test(href)) {
            pushDataLayerEvent('contact_click', { contact_method: 'email', click_location: location });
            return;
        }

        var url;
        try {
            url = new URL(href, window.location.href);
        } catch (e) {
            return;
        }

        if (/^(wa\.me|api\.whatsapp\.com|web\.whatsapp\.com)$/i.test(url.hostname)) {
            pushDataLayerEvent('contact_click', { contact_method: 'whatsapp', click_location: location });
        } else if (link.hasAttribute('data-track-map') || ((/(^|\.)google\.[^/]+$/.test(url.hostname)) && /\/maps/i.test(url.pathname))) {
            pushDataLayerEvent('map_click', { click_location: location });
        } else if (socialNetwork(url)) {
            pushDataLayerEvent('social_click', {
                social_network: socialNetwork(url),
                click_location: location
            });
        } else if (url.origin !== window.location.origin) {
            pushDataLayerEvent('outbound_click', {
                link_domain: url.hostname,
                click_location: location
            });
        }

        if (/\.(pdf|docx?|xlsx?|pptx?|zip)$/i.test(url.pathname)) {
            pushDataLayerEvent('file_download', {
                file_name: url.pathname.split('/').pop(),
                file_extension: url.pathname.split('.').pop().toLowerCase(),
                click_location: location
            });
        }

        contentSelection(link);

        if (link.closest('.gallery-wrap')) {
            pushDataLayerEvent('select_content', {
                content_type: 'gallery',
                item_name: linkLabel(link),
                click_location: 'gallery'
            });
        }

        if (link.closest('nav, footer') && !link.hasAttribute('data-track-cta')) {
            pushDataLayerEvent('navigation_click', {
                link_text: linkLabel(link),
                navigation_location: location,
                link_path: url.origin === window.location.origin ? url.pathname : undefined
            });
        }

        if (
            link.hasAttribute('data-track-cta') ||
            link.matches('.btn, .read-more, .stretched-link')
        ) {
            pushDataLayerEvent('cta_click', {
                cta_text: linkLabel(link),
                cta_location: link.getAttribute('data-track-cta') || location,
                link_path: url.origin === window.location.origin ? url.pathname : undefined,
                link_domain: url.origin !== window.location.origin ? url.hostname : undefined
            });
        }
    });

    document.addEventListener('shown.bs.collapse', function (event) {
        if (!event.target.closest('#servicesAccordion')) {
            return;
        }

        var trigger = document.querySelector('[data-bs-target="#' + event.target.id + '"]');
        pushDataLayerEvent('service_expand', {
            service_name: trigger ? cleanText(trigger.textContent) : event.target.id
        });
    });

    var trackedForms = new WeakSet();
    document.addEventListener('focusin', function (event) {
        var form = event.target.closest('form');
        if (!form || !form.closest('[id^="scf-"]') || trackedForms.has(form)) {
            return;
        }

        trackedForms.add(form);
        pushDataLayerEvent('form_start', { form_name: 'contact_form' });
    });

    document.addEventListener('submit', function (event) {
        if (event.target.matches('form[id^="scf-form-id-"]')) {
            pushDataLayerEvent('form_submit', { form_name: 'contact_form' });
        }
    });

    function trackSuccessfulContactForm() {
        document.querySelectorAll('[id^="scf-message-"] .alert-success').forEach(function (message) {
            if (message.getAttribute('data-gtm-lead-tracked') === 'true') {
                return;
            }
            message.setAttribute('data-gtm-lead-tracked', 'true');
            pushDataLayerEvent('generate_lead', {
                form_name: 'contact_form',
                lead_source: 'website'
            });
        });
    }

    function trackContactFormErrors() {
        document.querySelectorAll('[id^="scf-message-"] .alert-danger').forEach(function (message) {
            if (message.getAttribute('data-gtm-error-tracked') === 'true') {
                return;
            }
            message.setAttribute('data-gtm-error-tracked', 'true');
            pushDataLayerEvent('form_error', { form_name: 'contact_form' });
        });
    }

    trackSuccessfulContactForm();
    trackContactFormErrors();
    window.addEventListener('ajax:update-complete', function () {
        trackSuccessfulContactForm();
        trackContactFormErrors();
    });

    var pageType = document.body.getAttribute('data-page-type');
    if (pageType === 'country-details' || pageType === 'blog-post') {
        pushDataLayerEvent('view_content', {
            content_type: pageType === 'country-details' ? 'study_destination' : 'blog_post',
            item_name: cleanText(document.body.getAttribute('data-page-title'))
        });
    }

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

        return videoId ? 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0&enablejsapi=1' : url;
    }

    document.querySelectorAll('[data-video-url]').forEach(function (button) {
        button.addEventListener('click', function () {
            var url = button.getAttribute('data-video-url');
            var modalElement = document.getElementById('videoModal');
            var frame = document.getElementById('videoModalFrame');

            if (!url || !modalElement || !frame || !window.bootstrap) {
                return;
            }

            pushDataLayerEvent('video_start', {
                video_provider: 'youtube',
                video_title: cleanText(button.getAttribute('aria-label')),
                click_location: elementLocation(button)
            });

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
