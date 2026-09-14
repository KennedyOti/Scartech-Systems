import Alpine from 'alpinejs';

const FOCUSABLE = 'a[href], button:not([disabled]), input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

const prefersReducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/**
 * Keep Tab focus inside a container. Returns a cleanup function.
 */
function trapFocus(container) {
    const handler = (event) => {
        if (event.key !== 'Tab') {
            return;
        }

        const items = [...container.querySelectorAll(FOCUSABLE)].filter((el) => el.offsetParent !== null);

        if (items.length === 0) {
            return;
        }

        const first = items[0];
        const last = items[items.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    };

    container.addEventListener('keydown', handler);

    return () => container.removeEventListener('keydown', handler);
}

function lockScroll(locked) {
    document.documentElement.style.overflow = locked ? 'hidden' : '';
}

Alpine.data('siteHeader', () => ({
    scrolled: false,
    mobileOpen: false,
    servicesOpen: false,
    releaseTrap: null,
    returnFocusTo: null,

    init() {
        let ticking = false;
        const update = () => {
            this.scrolled = window.scrollY > 20;
            ticking = false;
        };

        update();
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(update);
                ticking = true;
            }
        }, { passive: true });

        window.matchMedia('(min-width: 64rem)').addEventListener('change', (event) => {
            if (event.matches && this.mobileOpen) {
                this.closeMobile(false);
            }
        });
    },

    toggleServices() {
        this.servicesOpen = !this.servicesOpen;
    },

    closeServices(returnFocus = false) {
        if (!this.servicesOpen) {
            return;
        }

        this.servicesOpen = false;

        if (returnFocus) {
            this.$refs.servicesTrigger?.focus();
        }
    },

    openMobile() {
        this.returnFocusTo = document.activeElement;
        this.mobileOpen = true;
        lockScroll(true);

        this.$nextTick(() => {
            const sheet = this.$refs.mobileSheet;
            this.releaseTrap = trapFocus(sheet);
            sheet.querySelector(FOCUSABLE)?.focus();
        });
    },

    closeMobile(returnFocus = true) {
        this.mobileOpen = false;
        lockScroll(false);
        this.releaseTrap?.();
        this.releaseTrap = null;

        if (returnFocus) {
            (this.returnFocusTo ?? this.$refs.mobileTrigger)?.focus();
        }
    },
}));

Alpine.data('heroCarousel', (count, interval = 6000) => ({
    current: 0,
    previous: null,
    direction: 'next',
    count,
    interval,
    playing: true,
    hovering: false,
    focusWithin: false,
    timer: null,
    touchStartX: null,
    remaining: 0,
    startedAt: 0,
    cycle: 0,

    init() {
        this.remaining = this.interval;

        if (prefersReducedMotion() || this.count < 2) {
            this.playing = false;
        }

        this.schedule();

        document.addEventListener('visibilitychange', () => this.schedule());
    },

    get paused() {
        return !this.playing || this.hovering || this.focusWithin;
    },

    /**
     * Start or stop the timer to match the paused state, keeping the time already elapsed on the
     * current slide so the progress bar and the timer stay in step.
     */
    schedule() {
        if (this.timer) {
            clearTimeout(this.timer);
            this.timer = null;
            this.remaining = Math.max(0, this.remaining - (performance.now() - this.startedAt));
        }

        if (this.paused || document.hidden) {
            return;
        }

        this.startedAt = performance.now();
        this.timer = setTimeout(() => {
            this.timer = null;
            this.next(false);
        }, this.remaining);
    },

    go(index, manual = true, direction = null) {
        clearTimeout(this.timer);
        this.timer = null;

        const target = (index + this.count) % this.count;

        if (target !== this.current) {
            this.direction = direction ?? (target > this.current ? 'next' : 'prev');
            this.previous = this.current;
        }

        this.current = target;
        this.remaining = this.interval;
        this.cycle++;

        if (manual) {
            this.$refs.live.textContent = `Slide ${this.current + 1} of ${this.count}`;
        }

        this.schedule();
    },

    next(manual = true) {
        this.go(this.current + 1, manual, 'next');
    },

    prev() {
        this.go(this.current - 1, true, 'prev');
    },

    togglePlay() {
        this.playing = !this.playing;

        if (this.playing) {
            this.go(this.current, false);
        } else {
            this.schedule();
        }
    },

    setHover(value) {
        this.hovering = value;
        this.schedule();
    },

    setFocus(value) {
        this.focusWithin = value;
        this.schedule();
    },

    touchStart(event) {
        this.touchStartX = event.changedTouches[0].clientX;
    },

    touchEnd(event) {
        if (this.touchStartX === null) {
            return;
        }

        const delta = event.changedTouches[0].clientX - this.touchStartX;
        this.touchStartX = null;

        if (Math.abs(delta) > 40) {
            delta < 0 ? this.next() : this.prev();
        }
    },
}));

Alpine.data('lightbox', (images = []) => ({
    images,
    open: false,
    index: 0,
    releaseTrap: null,
    returnFocusTo: null,

    show(index) {
        this.returnFocusTo = document.activeElement;
        this.index = index;
        this.open = true;
        lockScroll(true);

        this.$nextTick(() => {
            this.releaseTrap = trapFocus(this.$refs.dialog);
            this.$refs.close.focus();
        });
    },

    close() {
        this.open = false;
        lockScroll(false);
        this.releaseTrap?.();
        this.returnFocusTo?.focus();
    },

    next() {
        this.index = (this.index + 1) % this.images.length;
    },

    prev() {
        this.index = (this.index - 1 + this.images.length) % this.images.length;
    },
}));

Alpine.data('enquiryForm', () => ({
    sending: false,

    submit(event) {
        if (this.sending) {
            event.preventDefault();

            return;
        }

        this.sending = true;
    },
}));

/**
 * A continuously moving product strip. The track holds several identical groups of cards; the
 * offset wraps after one group's width so the loop is seamless. Hover or focus eases it to a stop,
 * the arrow buttons glide it by one card, and it can be dragged or swiped.
 */
Alpine.data('productMarquee', (speed = 45) => ({
    offset: 0,
    velocity: 0,
    nudge: 0,
    hovering: false,
    focusWithin: false,
    dragging: false,
    dragMoved: false,
    dragStartX: 0,
    dragStartOffset: 0,
    visible: false,
    frame: null,
    lastTime: 0,

    init() {
        this.velocity = prefersReducedMotion() ? 0 : speed;

        new IntersectionObserver(([entry]) => {
            this.visible = entry.isIntersecting;

            if (this.visible) {
                this.start();
            }
        }).observe(this.$el);
    },

    get groupWidth() {
        return this.$refs.track.firstElementChild?.offsetWidth ?? 0;
    },

    get cardWidth() {
        return this.$refs.track.querySelector('li')?.offsetWidth ?? 300;
    },

    start() {
        if (this.frame) {
            return;
        }

        this.lastTime = performance.now();
        this.frame = requestAnimationFrame((time) => this.tick(time));
    },

    tick(time) {
        const delta = Math.min((time - this.lastTime) / 1000, 0.05);
        this.lastTime = time;

        const stopped = this.hovering || this.focusWithin || this.dragging || document.hidden || prefersReducedMotion();
        const targetVelocity = stopped ? 0 : speed;
        this.velocity += (targetVelocity - this.velocity) * Math.min(delta * 4, 1);

        if (!this.dragging) {
            const step = this.nudge * Math.min(delta * 7, 1);
            this.nudge -= step;
            this.offset += step - this.velocity * delta;

            if (Math.abs(this.nudge) < 0.5) {
                this.nudge = 0;
            }
        }

        this.render();

        if (this.visible) {
            this.frame = requestAnimationFrame((next) => this.tick(next));
        } else {
            this.frame = null;
        }
    },

    render() {
        const width = this.groupWidth;

        if (width > 0) {
            this.offset = ((this.offset % width) - width) % width;
        }

        this.$refs.track.style.transform = `translate3d(${this.offset}px, 0, 0)`;
    },

    next() {
        this.nudge -= this.cardWidth;
    },

    prev() {
        this.nudge += this.cardWidth;
    },

    pointerDown(event) {
        if (event.pointerType === 'mouse' && event.button !== 0) {
            return;
        }

        this.dragging = true;
        this.dragMoved = false;
        this.dragStartX = event.clientX;
        this.dragStartOffset = this.offset;
        this.nudge = 0;
    },

    pointerMove(event) {
        if (!this.dragging) {
            return;
        }

        const distance = event.clientX - this.dragStartX;

        if (Math.abs(distance) > 6 && !this.dragMoved) {
            this.dragMoved = true;
            this.$el.setPointerCapture?.(event.pointerId);
        }

        if (this.dragMoved) {
            this.offset = this.dragStartOffset + distance;
            this.render();
        }
    },

    pointerUp() {
        this.dragging = false;
    },

    preventClickAfterDrag(event) {
        if (this.dragMoved) {
            event.preventDefault();
            event.stopPropagation();
            this.dragMoved = false;
        }
    },
}));

/**
 * The delivery timeline: the track fills as the reader scrolls and each phase lights up once the
 * middle of the viewport reaches its marker.
 */
Alpine.data('processSteps', () => ({
    progress: 0,
    active: -1,

    init() {
        let ticking = false;
        const update = () => {
            const rect = this.$el.getBoundingClientRect();
            const middle = window.innerHeight * 0.55;

            this.progress = Math.min(Math.max((middle - rect.top) / rect.height, 0), 1);
            this.active = [...this.$el.querySelectorAll('[data-step]')]
                .filter((step) => step.getBoundingClientRect().top < middle)
                .length - 1;
            ticking = false;
        };

        update();
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(update);
                ticking = true;
            }
        }, { passive: true });
        window.addEventListener('resize', update, { passive: true });
    },
}));

/**
 * Fade and lift [data-reveal] elements into place as they scroll into view.
 */
function initReveal() {
    const elements = document.querySelectorAll('[data-reveal]');

    if (elements.length === 0 || prefersReducedMotion() || !('IntersectionObserver' in window)) {
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-revealed');
                observer.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

    elements.forEach((element) => {
        if (element.getBoundingClientRect().top < window.innerHeight) {
            element.classList.add('is-revealed');
        } else {
            observer.observe(element);
        }
    });

    document.documentElement.classList.add('reveal-ready');
}

initReveal();

window.Alpine = Alpine;
Alpine.start();
