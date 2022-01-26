import { createPopper } from "@popperjs/core";

const Dropdown = {
    defaultSettings: {
        onOpened: null,
        onClosed: null,
        placement: "bottom-end",
        offset: [0, 8],
    },
    onOpened(settings = Dropdown.defaultSettings) {
        if (settings.onOpened) {
            settings.onOpened(this.$el);
        }
    },
    onClosed(settings = Dropdown.defaultSettings) {
        if (settings.onClosed) {
            settings.onClosed(this.$el);
        }
    },
    setup(propertyName = "dropdownOpen", settings = Dropdown.defaultSettings) {
        settings = { ...Dropdown.defaultSettings, ...settings };

        const alpineSetup = {
            propertyName,
            popperInstance: null,
            update() {
                if (!this[this.propertyName]) {
                    return;
                }

                this.popperInstance.update();
            },
            /**
             * The dropdown is adjusted when shown but since we use animation
             * classes it creates a weird effect. The following method pre-adjust
             * the dropdown so when it is shown it is in the correct position.
             */
            preAdjustDropdownPosition(dropdown) {
                dropdown.style.opacity = "0";
                dropdown.style.display = "block";

                this.update();

                dropdown.style.removeProperty("opacity");
                dropdown.style.removeProperty("display");
            },
            toggle() {
                this[this.propertyName] = !this[this.propertyName];
            },
            close() {
                this[this.propertyName] = false;
            },
            open() {
                this[this.propertyName] = true;
            },
            init() {
                const container = this.$el;
                const dropdown = container.querySelector(".dropdown");
                const button = container.querySelector(".dropdown-button");

                this.popperInstance = createPopper(button, dropdown, {
                    strategy: "fixed",
                    placement: settings.placement,
                    modifiers: [
                        {
                            name: "preventOverflow",
                        },
                        {
                            name: "offset",
                            options: {
                                offset: settings.offset,
                            },
                        },
                    ],
                });

                this.$watch(propertyName, (expanded) => {
                    if (expanded) {
                        this.preAdjustDropdownPosition(dropdown);

                        this.$nextTick(() => {
                            this.update();
                            Dropdown.onOpened.call(this, settings);
                        });
                    } else {
                        this.$nextTick(() => {
                            Dropdown.onClosed.call(this, settings);
                        });
                    }
                });
            },
        };

        alpineSetup[propertyName] = false;

        return alpineSetup;
    },
};

export default Dropdown;
