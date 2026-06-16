document.addEventListener('DOMContentLoaded', () => {
    // Navigation Drawer Logic
    const drawer = document.getElementById('drawer-menu');
    const sheet = drawer ? drawer.querySelector('.drawer-sheet') : null;
    const openBtn = document.getElementById('menu-toggle');
    const closeBtn = document.getElementById('menu-close-btn');

    if (drawer && sheet && openBtn) {
        let isOpening = false;
        
        async function openDrawer() {
            isOpening = true;
            drawer.showPopover();

            if (!CSS.supports('scroll-initial-target', 'nearest')) {
                // Jump-scroll to the closed stop so the scroll below animates in
                drawer.scrollTo({left: drawer.offsetWidth, behavior: 'instant'});
                await new Promise((r) => requestAnimationFrame(() => requestAnimationFrame(r)));
            }

            drawer.scrollTo({left: 0, behavior: 'smooth'}); // smooth scroll
            isOpening = false;
        }

        function closeDrawer() {
            // Scroll back to the spacer. IntersectionObserver will hide popover.
            drawer.scrollTo({left: drawer.offsetWidth, behavior: 'smooth'});
        }

        // Open Trigger
        openBtn.addEventListener('click', openDrawer);
        
        // Close Button
        if (closeBtn) {
            closeBtn.addEventListener('click', closeDrawer);
        }

        // Light-dismiss (tap outside sheet)
        drawer.addEventListener('click', (event) => {
            if (!sheet.contains(event.target)) closeDrawer();
        });

        // Escape Key
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && drawer.matches(':popover-open')) {
                closeDrawer();
            }
        });

        // Intersection Observer to detect open/closed state
        function onDrawerOpened() {
            const main = document.querySelector('main');
            if (main) main.inert = true;
            openBtn.setAttribute('aria-expanded', 'true');
            sheet.focus();
        }

        function onDrawerClosed() {
            drawer.hidePopover();
            const main = document.querySelector('main');
            if (main) main.inert = false;
            openBtn.setAttribute('aria-expanded', 'false');
            openBtn.focus();
        }

        const visibleThreshold = 1 / window.innerWidth;
        const observer = new IntersectionObserver(
            (entries) => {
                const entry = entries.at(-1);
                if (!isOpening && entry.intersectionRatio < visibleThreshold) onDrawerClosed();
                if (entry.intersectionRatio === 1) onDrawerOpened();
            },
            { root: drawer, threshold: [visibleThreshold, 1] }
        );
        
        observer.observe(sheet);

        // Fallback for Backdrop fade if scroll-driven animations are not supported
        if (!CSS.supports('animation-timeline: scroll()')) {
            drawer.addEventListener('scroll', () => {
                const ratio = 1 - drawer.scrollLeft / sheet.offsetWidth;
                drawer.style.setProperty('--drawer-backdrop', Math.max(0, ratio));
            });
        }
    }
});
