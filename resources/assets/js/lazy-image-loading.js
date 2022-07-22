function lazyLoad(selector = "[lazy]") {
    const svgLookup = {};

    let $lazy;
    let lastCheck = Date.now();
    let scrolling = false;

    const scrollIntervalHandle = setInterval(() => {
        if (scrolling && lastCheck > Date.now() - 3000) {
            $lazy = $lazy.filter(toApplyLazyLoad);
        } else {
            scrolling = false;
        }
    }, 100);

    document.addEventListener("scroll", registerScrolling, {
        capture: false,
        passive: true,
    });
    document.addEventListener("wheel", registerScrolling, {
        capture: false,
        passive: true,
    });
    document.addEventListener("touchmove", registerScrolling, {
        capture: false,
        passive: true,
    });
    document.addEventListener("touchstart", registerScrolling, {
        capture: false,
        passive: true,
    });
    document.addEventListener("touchend", registerScrolling, {
        capture: false,
        passive: true,
    });

    registerDelayedContainers(selector);

    registerLivewireObserver();

    registerLazyElements();

    function registerLazyElements() {
        $lazy = (typeof selector === "string"
            ? [...document.querySelectorAll(selector)]
            : [...selector]
        ).filter(toApplyLazyLoad);
    }

    function registerScrolling() {
        lastCheck = Date.now();
        scrolling = true;
    }

    function toApplyLazyLoad(el) {
        const parentElement = el.closest(".w-full.mt-6");

        if (parentElement && parentElement.classList.contains("md:hidden")) {
            if (window.screen.width >= 768) {
                ok;
                return false;
            }
        }

        return el && !(isScrolledIntoView(el) && applyLazy(el));
    }

    function applyLazy(el) {
        if (!el) {
            return;
        }

        const imageUrl = el.getAttribute("lazy");
        if (el instanceof window.HTMLImageElement) {
            const parent = el.parentElement;
            const srcset = el.getAttribute("lazy-srcset");
            if (srcset) {
                el.setAttribute("srcset", srcset);
            } else {
                el.setAttribute("src", imageUrl);
            }

            el.onload = () => {
                el.classList.remove("invisible");
                if (parent.classList.contains("lazy-image-container")) {
                    parent.classList.remove("lazy-image-container");
                }
            };
        } else if (el instanceof window.SVGElement) {
            fetchSVG(imageUrl, el);
        } else {
            el.style.backgroundImage = `url(${imageUrl})`;
        }

        return true;
    }

    async function fetchSVG(url, el) {
        let data;
        if (!svgLookup[url]) {
            let response = await fetch(url);
            data = await response.text();

            svgLookup[url] = data;
        } else {
            data = svgLookup[url];
        }

        const parser = new DOMParser();
        const parsed = parser.parseFromString(data, "image/svg+xml");

        let svg = parsed.getElementsByTagName("svg");

        if (svg.length) {
            svg = svg[0];

            const attr = svg.attributes;
            const attrLen = attr.length;
            for (let i = 0; i < attrLen; ++i) {
                if (attr[i].specified) {
                    if ("class" === attr[i].name) {
                        const classes = attr[i].value
                            .replace(/\s+/g, " ")
                            .trim()
                            .split(" ");

                        const classesLen = classes.length;
                        for (let j = 0; j < classesLen; ++j) {
                            el.classList.add(classes[j]);
                        }
                    } else {
                        el.setAttribute(attr[i].name, attr[i].value);
                    }
                }
            }

            while (svg.childNodes.length) {
                el.appendChild(svg.childNodes[0]);
            }
        }
    }

    function registerDelayedContainers(selector) {
        const delayContainers = [
            ...document.querySelectorAll("[data-lazy-svg-delay]"),
        ];

        if (delayContainers.length > 0) {
            const delayLookup = {};

            for (const delayContainer of delayContainers) {
                const lazySvgDelay = delayContainer.dataset.lazySvgDelay;

                if (!Array.isArray(delayLookup[lazySvgDelay])) {
                    delayLookup[lazySvgDelay] = [];
                }

                delayLookup[lazySvgDelay].push(delayContainer);
            }

            for (const [timeout, containers] of Object.entries(delayLookup)) {
                setTimeout(() => {
                    for (const container of containers) {
                        [...container.querySelectorAll(selector)].forEach(
                            applyLazy
                        );
                    }
                }, timeout);
            }
        }
    }

    function registerLivewireObserver() {
        Livewire.hook("message.processed", () => registerLazyElements());
    }
}

function isScrolledIntoView(el) {
    if (!el) {
        return;
    }

    let rect = el.getBoundingClientRect();
    if (el.parentElement.classList.contains("lazy-image-container")) {
        rect = el.parentElement.getBoundingClientRect();
    }

    if (
        [rect.top, rect.left, rect.bottom, rect.right].reduce(
            (a, b) => a + b,
            0
        ) === 0
    ) {
        return;
    }

    const topIsVisible =
        rect.top >= 0 &&
        rect.top <=
            (window.innerHeight || document.documentElement.clientHeight);
    const bottomIsVisible =
        rect.bottom >= 0 &&
        rect.bottom <=
            (window.innerHeight || document.documentElement.clientHeight);

    return (
        (topIsVisible || bottomIsVisible) &&
        rect.left >= 0 &&
        rect.right <=
            (window.innerWidth || document.documentElement.clientWidth) +
                rect.width
    );
}

document.addEventListener("DOMContentLoaded", () => {
    try {
        lazyLoad("[lazy]");
    } catch (err) {
        console.error(err.message, err);
    }
});
