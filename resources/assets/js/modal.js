import {
    disableBodyScroll,
    enableBodyScroll,
    clearAllBodyScrollLocks,
} from "body-scroll-lock";

import { createFocusTrap } from "focus-trap";

const Modal = {
    previousPaddingRight: undefined,
    previousNavPaddingRight: undefined,
    trappedElement: null,
    trappedFocus: null,

    defaultSettings: {
        reserveScrollBarGap: true,
        reserveNavScrollBarGap: true,
        disableFocusTrap: false,
    },

    disableBodyScroll(scrollable, settings = {}) {
        settings = Object.assign({}, this.defaultSettings, settings);

        if (settings.reserveScrollBarGap) {
            this.reserveModalScrollBarGap(scrollable);
        }

        if (settings.reserveNavScrollBarGap) {
            this.reserveNavScrollBarGap(scrollable);
        }

        disableBodyScroll(scrollable, {
            reserveScrollBarGap: !!settings.reserveScrollBarGap,
        });
    },

    enableBodyScroll(scrollable, settings = {}) {
        settings = Object.assign({}, this.defaultSettings, settings);

        if (settings.reserveScrollBarGap) {
            this.restoreModalScrollBarGap(scrollable);
        }

        if (settings.reserveNavScrollBarGap) {
            this.restoreNavScrollBarGap(scrollable);
        }

        enableBodyScroll(scrollable);
    },

    onModalOpened(scrollable, settings = {}) {
        this.disableBodyScroll(scrollable, settings);

        if (settings.disableFocusTrap) {
            scrollable.focus();
        } else {
            this.trapFocus(scrollable);
        }
    },

    onModalClosed(scrollable, settings = {}) {
        this.enableBodyScroll(scrollable, settings);

        this.releaseTrappedFocus();

        if (!document.querySelectorAll("[data-modal]").length) {
            clearAllBodyScrollLocks();
        }
    },

    trapFocus(el) {
        if (this.trappedElement === el) {
            return;
        }

        this.releaseTrappedFocus();

        let trap = createFocusTrap(el, {
            escapeDeactivates: false,
            allowOutsideClick: true,
            fallbackFocus: el.querySelector("input:not([type=hidden])"),
        });

        this.trappedFocus = trap.activate();
        this.trappedElement = el;
    },

    releaseTrappedFocus() {
        if (!this.trappedFocus) {
            return;
        }

        this.trappedFocus.deactivate();
        this.trappedFocus = null;
        this.trappedElement = null;
    },

    alpine(extraData = {}, modalName = "", eventSettings = {}) {
        return {
            name: modalName,
            shown: false,
            onBeforeHide: false,
            onBeforeShow: false,
            onHidden: false,
            onShown: false,
            options: null,
            init() {
                const scrollable = this.getScrollable();
                if (this.name) {
                    Livewire.on("openModal", (modalName, ...options) => {
                        if (this.name === modalName) {
                            this.show(options);
                        }
                    });

                    Livewire.on("closeModal", (modalName) => {
                        if (this.name === modalName) {
                            this.hide();
                        }
                    });
                }

                this.$watch("shown", (shown) => {
                    if (shown && typeof this.onBeforeShow === "function") {
                        this.onBeforeShow(this.options);
                    }

                    if (!shown && typeof this.onBeforeHide === "function") {
                        this.onBeforeHide(this.options);
                    }

                    this.$nextTick(() => {
                        if (shown) {
                            if (typeof this.onShown === "function") {
                                this.onShown(this.options);
                            }

                            Modal.onModalOpened(scrollable, eventSettings);
                        } else {
                            if (typeof this.onHidden === "function") {
                                this.onHidden(this.options);
                            }

                            Modal.onModalClosed(scrollable, eventSettings);
                        }
                    });
                });

                if (this.shown) {
                    Modal.onModalOpened(scrollable, eventSettings);
                }
            },
            hide() {
                this.options = null;

                this.shown = false;
            },
            show(options) {
                this.options = options;

                this.shown = true;
            },
            getScrollable() {
                const { modal } = this.$refs;
                return modal;
            },
            ...extraData,
        };
    },

    livewire(extraData = {}, eventSettings = {}) {
        return {
            init() {
                const scrollable = this.getScrollable();

                this.$wire.on("modalClosed", () => {
                    this.$nextTick(() => {
                        Modal.onModalClosed(scrollable, eventSettings);
                    });
                });

                Modal.onModalOpened(scrollable, eventSettings);
            },
            getScrollable() {
                const { modal } = this.$refs;
                return modal;
            },
            ...extraData,
        };
    },

    // Based on https://github.com/willmcpo/body-scroll-lock/blob/master/src/bodyScrollLock.js#L72
    reserveModalScrollBarGap(container) {
        if (this.previousPaddingRight === undefined) {
            const scrollBarGap =
                window.innerWidth - document.documentElement.clientWidth;

            if (scrollBarGap > 0) {
                const computedBodyPaddingRight = parseInt(
                    window
                        .getComputedStyle(container)
                        .getPropertyValue("padding-right"),
                    10
                );
                this.previousPaddingRight = container.style.paddingRight;
                container.style.paddingRight = `${
                    computedBodyPaddingRight + scrollBarGap
                }px`;
            }
        }
    },

    // Based on https://github.com/willmcpo/body-scroll-lock/blob/master/src/bodyScrollLock.js#L92
    restoreModalScrollBarGap(container) {
        if (this.previousPaddingRight !== undefined) {
            container.style.paddingRight = this.previousPaddingRight;
            this.previousPaddingRight = undefined;
        }
    },

    reserveNavScrollBarGap() {
        const navbar = document.querySelector("header nav");
        if (this.previousNavPaddingRight === undefined) {
            const scrollBarGap =
                window.innerWidth - document.documentElement.clientWidth;

            if (scrollBarGap > 0) {
                const computedBodyPaddingRight = parseInt(
                    window
                        .getComputedStyle(navbar)
                        .getPropertyValue("padding-right"),
                    10
                );
                this.previousNavPaddingRight = navbar.style.paddingRight;
                navbar.style.paddingRight = `${
                    computedBodyPaddingRight + scrollBarGap
                }px`;
            }
        }
    },

    restoreNavScrollBarGap() {
        const navbar = document.querySelector("header nav");
        if (this.previousNavPaddingRight !== undefined) {
            navbar.style.paddingRight = this.previousNavPaddingRight;
            this.previousNavPaddingRight = undefined;
        }
    },
};

export default Modal;
