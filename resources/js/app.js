import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // Section fade-in on scroll
    const sections = document.querySelectorAll('.section-fade-in');

    if (!('IntersectionObserver' in window) || sections.length === 0) {
        sections.forEach((el) => el.classList.add('is-visible'));
    } else {
        const observer = new IntersectionObserver(
            (entries, obs) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        obs.unobserve(entry.target);
                    }
                });
            },
            {
                threshold: 0.2,
            },
        );

        sections.forEach((el) => observer.observe(el));
    }

    // Parallax backgrounds (respect reduced motion preferences)
    const parallaxSections = document.querySelectorAll('.parallax-section .parallax-bg');
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (parallaxSections.length && !prefersReducedMotion) {
        let ticking = false;

        const updateParallax = () => {
            const scrollY = window.scrollY || window.pageYOffset;
            const viewportHeight = window.innerHeight || document.documentElement.clientHeight;

            parallaxSections.forEach((el) => {
                const speed = parseFloat(el.getAttribute('data-parallax-speed') || '0.25');
                const rect = el.parentElement.getBoundingClientRect();
                const elementTop = rect.top + scrollY;
                const elementHeight = rect.height;
                const elementCenter = elementTop + elementHeight / 2;
                const viewportCenter = scrollY + viewportHeight / 2;
                const distance = viewportCenter - elementCenter;

                // Adjust background position instead of moving the element to avoid gaps
                const offset = distance * speed;
                el.style.backgroundPosition = `center calc(50% + ${-offset}px)`;
            });

            ticking = false;
        };

        const requestParallaxUpdate = () => {
            if (!ticking) {
                ticking = true;
                window.requestAnimationFrame(updateParallax);
            }
        };

        window.addEventListener('scroll', requestParallaxUpdate, { passive: true });
        window.addEventListener('resize', requestParallaxUpdate);
        requestParallaxUpdate();
    }

    const header = document.getElementById('site-header');
    const hero = document.getElementById('hero');

    if (header && hero) {
        const updateHeaderState = () => {
            const rect = hero.getBoundingClientRect();
            const threshold = 72;

            if (rect.bottom <= threshold) {
                header.classList.remove('site-header--at-top');
                header.classList.add('site-header--scrolled');
            } else {
                header.classList.add('site-header--at-top');
                header.classList.remove('site-header--scrolled');
            }
        };

        let tickingHeader = false;

        const requestHeaderUpdate = () => {
            if (!tickingHeader) {
                tickingHeader = true;
                window.requestAnimationFrame(() => {
                    updateHeaderState();
                    tickingHeader = false;
                });
            }
        };

        window.addEventListener('scroll', requestHeaderUpdate, { passive: true });
        window.addEventListener('resize', requestHeaderUpdate);
        updateHeaderState();
    }

    // Gallery lightbox
    const galleryImages = Array.from(document.querySelectorAll('.js-gallery-image'));
    const lightbox = document.getElementById('gallery-lightbox');
    const lightboxImage = document.getElementById('gallery-lightbox-image');
    const lightboxCaption = document.getElementById('gallery-lightbox-caption');
    const lightboxClose = document.getElementById('gallery-lightbox-close');
    const lightboxPrev = document.getElementById('gallery-lightbox-prev');
    const lightboxNext = document.getElementById('gallery-lightbox-next');

    let currentIndex = -1;

    const openLightbox = (index) => {
        if (!lightbox || !lightboxImage || !lightboxCaption) return;
        const image = galleryImages[index];
        if (!image) return;

        currentIndex = index;
        lightboxImage.src = image.getAttribute('data-full') || image.src;
        lightboxCaption.textContent = image.getAttribute('data-caption') || image.alt || '';
        lightbox.classList.remove('hidden');
        lightbox.focus?.();
    };

    const closeLightbox = () => {
        if (!lightbox) return;
        lightbox.classList.add('hidden');
        currentIndex = -1;
    };

    const showOffset = (offset) => {
        if (!galleryImages.length) return;
        if (currentIndex === -1) return;
        let nextIndex = (currentIndex + offset + galleryImages.length) % galleryImages.length;
        openLightbox(nextIndex);
    };

    galleryImages.forEach((img, index) => {
        img.addEventListener('click', () => openLightbox(index));
    });

    lightboxClose?.addEventListener('click', closeLightbox);
    lightboxPrev?.addEventListener('click', () => showOffset(-1));
    lightboxNext?.addEventListener('click', () => showOffset(1));

    lightbox?.addEventListener('click', (event) => {
        if (event.target === lightbox) {
            closeLightbox();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (currentIndex === -1) return;
        if (event.key === 'Escape') {
            closeLightbox();
        } else if (event.key === 'ArrowLeft') {
            showOffset(-1);
        } else if (event.key === 'ArrowRight') {
            showOffset(1);
        }
    });
});
