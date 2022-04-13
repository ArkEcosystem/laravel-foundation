import { disableBodyScroll, enableBodyScroll } from "body-scroll-lock";

const onNavbarClosed = (navbar) => {
    enableBodyScroll(navbar);
};

const onNavbarOpened = (navbar) => {
    disableBodyScroll(navbar);

    navbar.focus();
};

const Navbar = {
    dropdown(xData = {}) {
        return {
            inverted: false,
            invertOnScroll: false,
            open: false,
            openDropdown: null,
            selectedChild: null,
            scrollProgress: 0,
            nav: null,
            header: null,
            dark: false,
            lockBodyBreakpoint: 640,

            onScroll() {
                const progress = this.getScrollProgress();

                if (progress !== this.scrollProgress) {
                    this.scrollProgress = progress;
                    this.updateStyles(progress);
                }
            },

            getScrollProgress() {
                const position = document.documentElement.scrollTop;
                const offset = this.inverted ? 20 : 0;
                const span = this.inverted ? 50 : 82;

                return position < offset
                    ? 0
                    : Math.min(1, (position - offset) / span);
            },

            updateStyles(progress) {
                if (this.invertOnScroll) {
                    if (progress === 1) {
                        this.header.classList.add("inverted");
                    } else {
                        this.header.classList.remove("inverted");
                    }
                } else if (!this.inverted) {
                    this.updateShadow(progress);
                }
            },

            init() {
                const { nav, scrollable } = this.$refs;
                this.nav = nav;
                this.header = this.$root;

                window.onscroll = this.onScroll.bind(this);
                this.scrollProgress = this.getScrollProgress();

                this.updateStyles(this.scrollProgress);

                this.$watch("dark", () =>
                    this.updateStyles(this.getScrollProgress())
                );

                this.$watch("open", (open) => {
                    this.$nextTick(() => {
                        if (open) {
                            if (this.lockBody()) {
                                onNavbarOpened(scrollable || nav);
                            }
                        } else {
                            onNavbarClosed(scrollable || nav);
                        }
                    });
                });

                if (this.open && this.lockBody()) {
                    onNavbarOpened(scrollable || nav);
                }
            },

            updateShadow(progress) {
                const maxTransparency = this.dark ? 0.6 : 0.22;
                const shadowTransparency =
                    Math.round(maxTransparency * progress * 100) / 100;
                const borderTransparency =
                    Math.round((1 - progress) * 100) / 100;
                const borderColorRgb = this.dark
                    ? [60, 66, 73]
                    : [219, 222, 229];
                const boxShadowRgb = this.dark ? [18, 18, 19] : [192, 200, 207];
                this.nav.style.boxShadow = `0px 2px 10px 0px rgba(${boxShadowRgb.join(
                    ", "
                )}, ${shadowTransparency})`;
                this.nav.style.borderColor = `rgba(${borderColorRgb.join(
                    ", "
                )}, ${borderTransparency})`;
            },

            toggleDropdown(name) {
                this.openDropdown = this.openDropdown === name ? null : name;
            },
            closeDropdown() {
                this.openDropdown = null;
                this.open = false;
            },
            closeIfBlurOutside(event) {
                const focusedElementIsChild =
                    event.relatedTarget &&
                    (this.$refs.menuDropdown.contains(event.relatedTarget) ||
                        this.$refs.menuDropdownButton === event.relatedTarget);

                if (!focusedElementIsChild) {
                    this.closeDropdown();
                }
            },
            hide() {
                this.open = false;
            },
            show() {
                this.open = true;
            },
            toggle() {
                this.open = !this.open;
            },
            lockBody() {
                return window.innerWidth <= this.lockBodyBreakpoint;
            },
            ...xData,
        };
    },
};

export default Navbar;
