import "tippy.js/dist/tippy.css";

import tippy, { hideAll } from "tippy.js";

const visibleTooltips = [];

/** Enable tooltips for components with this data attribute, and global config options */
const tooltipSettings = {
    theme: "ark",
    trigger: "mouseenter focus",
    duration: 0,
    onShown: (instance) => {
        visibleTooltips.push(instance);
    },
    onHidden: (instance, e) => {
        const index = visibleTooltips.findIndex((i) => i.id === instance.id);
        if (index >= 0) {
            visibleTooltips.splice(index, 1);
        }
    },
};

let tippyInstances = [];

const initTippy = (parentEl = document.body) => {
    Array.from(
        parentEl.querySelectorAll("[data-tippy-content], [data-tippy-hover]")
    ).forEach((el) => {
        const instanceSettings = { ...tooltipSettings };

        if (el.getAttribute("data-tippy-hover")) {
            instanceSettings.touch = "hold";
            instanceSettings.trigger = "mouseenter";
            instanceSettings.content = (reference) =>
                reference.dataset.tippyHover;
        } else {
            instanceSettings.content = (reference) =>
                reference.dataset.tippyContent;
        }

        if (el._tippy) {
            el._tippy.setProps(instanceSettings);
        } else {
            tippyInstances.push(tippy(el, instanceSettings));
        }
    });

    // For HTML version
    Array.from(parentEl.querySelectorAll("[data-tippy-html-content]")).forEach(
        (el) => {
            const instanceSettings = { allowHTML: true, ...tooltipSettings };
            instanceSettings.content = (reference) =>
                reference.dataset.tippyHtmlContent;

            if (el._tippy) {
                el._tippy.setProps(instanceSettings);
            } else {
                tippyInstances.push(tippy(el, instanceSettings));
            }
        }
    );
};

const destroyTippy = (parentEl = document.body) => {
    parentEl
        .querySelectorAll(
            "[data-tippy-content], [data-tippy-hover], [data-tippy-html-content]"
        )
        .forEach((el) => {
            if (!el._tippy) {
                console.error(
                    "Tippy tooltip instance not found. Ensure all tippy instances are properly initialized.",
                    el
                );
                return;
            }

            if (!el.parentNode) {
                el._tippy.destroy();
            }
        });
};

const destroyOutdatedTippyInstances = () => {
    tippyInstances = tippyInstances.reduce((collection, instance) => {
        const el = instance.reference;

        if (
            // The element is still in the DOM
            !!el.parentNode &&
            // The element still has the tippy attribute
            (el.getAttribute("data-tippy-hover") ||
                el.getAttribute("data-tippy-content") ||
                el.getAttribute("data-tippy-html-content"))
        ) {
            collection.push(instance);
        } else {
            instance.destroy();
        }

        return collection;
    }, []);
};

initTippy();

window.tooltipSettings = tooltipSettings;

window.initTippy = initTippy;

window.destroyTippy = destroyTippy;

document.addEventListener("scroll", () =>
    visibleTooltips.forEach((instance) => instance.hide(0))
);

window.initClipboard = () => {
    tippy(".clipboard", {
        theme: "ark",
        trigger: "click",
        content: (reference) => reference.getAttribute("tooltip-content"),
        onShow(instance) {
            setTimeout(() => {
                instance.hide();
            }, 3000);
        },
    });
};

document.addEventListener("DOMContentLoaded", function () {
    if (typeof Livewire !== "undefined") {
        Livewire.hook("commit", ({ component, succeed }) => {
            succeed(() => {
                Alpine.nextTick(() => {
                    destroyOutdatedTippyInstances();

                    initTippy(component.el);
                });
            });
        });
    }
});

window.tippy = tippy;
window.hideAllTooltips = hideAll;
