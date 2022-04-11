import { disableBodyScroll, enableBodyScroll } from "body-scroll-lock";
import {
    rgbFromCssProperty,
    rgbFromCssVariable,
    computeRgbColorBetween,
} from "./colors.js";

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
            dark: false,
            lockBodyBreakpoint: 640,

            // Colors...
            white: [255, 255, 255],
            black: [0, 0, 0],
            initialBackgroundColor: null,
            initialBorderColor: null,
            primary700: null,
            secondary300: null, // text-theme-primary-700
            links: [],

            onScroll() {
                const progress = this.getScrollProgress();

                if (progress !== this.scrollProgress) {
                    this.scrollProgress = progress;
                    this.updateStyles(progress);
                }
            },

            getScrollProgress() {
                const navbarHeight = 82;
                return Math.min(
                    1,
                    document.documentElement.scrollTop / navbarHeight
                );
            },

            updateStyles(progress) {
                if (this.invertOnScroll) {
                    this.invertColorScheme(progress);
                } else {
                    this.updateShadow(progress);
                }
            },

            init() {
                const { nav, scrollable } = this.$refs;
                this.nav = nav;

                // Register initial colors...
                if (this.invertOnScroll) {
                    this.initialBorderColor = rgbFromCssProperty(
                        nav,
                        "borderColor"
                    );
                    this.initialBackgroundColor = rgbFromCssProperty(
                        nav,
                        "backgroundColor"
                    );

                    this.secondary300 = rgbFromCssVariable(
                        "--theme-color-secondary-300"
                    );
                    this.secondary700 = rgbFromCssVariable(
                        "--theme-color-secondary-700"
                    );
                    this.secondary900 = rgbFromCssVariable(
                        "--theme-color-secondary-900"
                    );

                    this.primary100 = rgbFromCssVariable(
                        "--theme-color-primary-100"
                    );
                    this.primary600 = rgbFromCssVariable(
                        "--theme-color-primary-600"
                    );
                    this.primary700 = rgbFromCssVariable(
                        "--theme-color-primary-700"
                    );
                    this.primary800 = rgbFromCssVariable(
                        "--theme-color-primary-800"
                    );

                    this.links = this.$el.querySelectorAll("[data-link]");
                }

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
                    : this.inverted
                    ? this.primary800
                    : [219, 222, 229];
                const boxShadowRgb = this.dark ? [18, 18, 19] : [192, 200, 207];
                this.nav.style.boxShadow = `0px 2px 10px 0px rgba(${boxShadowRgb.join(
                    ", "
                )}, ${shadowTransparency})`;
                this.nav.style.borderColor = `rgba(${borderColorRgb.join(
                    ", "
                )}, ${borderTransparency})`;
            },

            invertColorScheme(progress) {
                // Button...
                this.$refs.button.style.backgroundColor = computeRgbColorBetween(
                    this.primary800,
                    this.primary100,
                    progress
                );
                this.$refs.button.style.color = computeRgbColorBetween(
                    this.white,
                    this.primary600,
                    progress
                );

                // Nav...
                this.nav.style.backgroundColor = computeRgbColorBetween(
                    this.initialBackgroundColor,
                    this.white,
                    progress
                );
                this.nav.style.borderColor = computeRgbColorBetween(
                    this.initialBorderColor,
                    this.secondary300,
                    progress
                );

                // Separator...
                this.$refs.separator.style.borderColor = computeRgbColorBetween(
                    this.primary700,
                    this.secondary300,
                    progress
                );

                // Logo...
                this.$refs.logo.style.fill = computeRgbColorBetween(
                    this.white,
                    this.primary600,
                    progress
                );
                this.$refs.siteName.style.color = computeRgbColorBetween(
                    this.white,
                    this.secondary900,
                    progress
                );

                // Navigation links...
                this.links.forEach((link) => {
                    if (link.hasAttribute("data-active")) {
                        link.style.color = computeRgbColorBetween(
                            this.white,
                            this.secondary900,
                            progress
                        );
                    } else {
                        link.style.color = computeRgbColorBetween(
                            this.primary100,
                            this.secondary700,
                            progress
                        );
                    }
                });
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
