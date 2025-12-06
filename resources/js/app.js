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
    const isSmallScreen = window.matchMedia('(max-width: 767px)').matches;

    // Only run parallax on larger screens with motion allowed
    if (parallaxSections.length && !prefersReducedMotion && !isSmallScreen) {
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

                // Adjust background position instead of moving the element, and clamp to avoid exposing empty space
                const maxOffset = elementHeight * 0.25;
                const offset = distance * speed;
                const clampedOffset = Math.max(-maxOffset, Math.min(maxOffset, offset));
                el.style.backgroundPosition = `center calc(50% + ${-clampedOffset}px)`;
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
        let lastScrollY = window.scrollY;
        let tickingHeader = false;

        const updateHeaderState = () => {
            const currentScrollY = window.scrollY;
            const heroRect = hero.getBoundingClientRect();
            const scrollingDown = currentScrollY > lastScrollY;
            const scrollingUp = currentScrollY < lastScrollY;

            // At the very top (over hero)
            if (currentScrollY < 100) {
                header.classList.add('site-header--at-top');
                header.classList.remove('site-header--scrolled', 'site-header--hidden');
            }
            // Scrolling down and past hero - hide header
            else if (scrollingDown && currentScrollY > 200) {
                header.classList.remove('site-header--at-top');
                header.classList.add('site-header--scrolled', 'site-header--hidden');
            }
            // Scrolling up - show header with scrolled style
            else if (scrollingUp) {
                header.classList.remove('site-header--at-top', 'site-header--hidden');
                header.classList.add('site-header--scrolled');
            }

            lastScrollY = currentScrollY;
        };

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

    const gallerySection = document.getElementById('gallery');
    const galleryPages = Array.from(document.querySelectorAll('[data-gallery-page]'));
    const galleryPageButtons = Array.from(document.querySelectorAll('[data-gallery-page-target]'));

    if (galleryPages.length && galleryPageButtons.length) {
        let currentGalleryPage = 0;

        const setGalleryPage = (index, options = { scroll: false }) => {
            if (index < 0 || index >= galleryPages.length) return;

            galleryPages.forEach((page, i) => {
                if (i === index) {
                    page.classList.remove('hidden');
                } else {
                    page.classList.add('hidden');
                }
            });

            galleryPageButtons.forEach((button, i) => {
                if (i === index) {
                    button.classList.add('gallery-page-button--active');
                    button.setAttribute('aria-current', 'page');
                } else {
                    button.classList.remove('gallery-page-button--active');
                    button.removeAttribute('aria-current');
                }
            });

            currentGalleryPage = index;

            if (options.scroll && gallerySection) {
                const rect = gallerySection.getBoundingClientRect();
                const offset = window.scrollY + rect.top - 120;
                window.scrollTo({ top: offset, behavior: 'smooth' });
            }
        };

        galleryPageButtons.forEach((button) => {
            const targetAttr = button.getAttribute('data-gallery-page-target');
            const targetIndex = parseInt(targetAttr || '', 10);

            if (Number.isNaN(targetIndex)) return;

            button.addEventListener('click', (event) => {
                event.preventDefault();
                setGalleryPage(targetIndex, { scroll: true });
            });
        });

        setGalleryPage(currentGalleryPage);
    }

    // Legend section toggle (Read the full legend / Show less)
    const legendToggle = document.querySelector('[data-legend-toggle]');
    const legendExtended = document.getElementById('legend-extended');

    if (legendToggle && legendExtended) {
        const moreLabel = legendToggle.querySelector('[data-legend-more]');
        const lessLabel = legendToggle.querySelector('[data-legend-less]');
        let legendOpen = false;

        const setLegendState = (open) => {
            legendOpen = open;
            legendToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            legendExtended.classList.toggle('hidden', !open);

            if (moreLabel && lessLabel) {
                moreLabel.classList.toggle('hidden', open);
                lessLabel.classList.toggle('hidden', !open);
            }
        };

        legendToggle.addEventListener('click', () => {
            setLegendState(!legendOpen);
        });

        setLegendState(false);
    }
});
