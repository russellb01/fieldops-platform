(function () {
    const header = document.querySelector('[data-header]');
    const navToggle = document.querySelector('[data-nav-toggle]');
    const navLinks = document.querySelector('[data-nav-links]');

    function updateHeader() {
        if (!header) {
            return;
        }

        header.classList.toggle('is-scrolled', window.scrollY > 12);
    }

    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });

    if (navToggle && navLinks) {
        navToggle.addEventListener('click', function () {
            navLinks.classList.toggle('is-open');
        });

        navLinks.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                navLinks.classList.remove('is-open');
            });
        });
    }

    const revealItems = document.querySelectorAll('.reveal');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12
        });

        revealItems.forEach(function (item) {
            observer.observe(item);
        });
    } else {
        revealItems.forEach(function (item) {
            item.classList.add('is-visible');
        });
    }
})();
