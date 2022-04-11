/**
 * Resolve the given CSS property value from the given HTML element.
 *
 * @param {HTMLElement} element
 * @param {String} property
 * @returns String
 */
const resolveElementProperty = (element, property) =>
    document.defaultView.getComputedStyle(element, null)[property];

/**
 * Extract the RGB values from the hex code (`#FFFFFF -> [255, 255, 255]`).
 *
 * @param {String} hex
 * @returns Number[]
 */
const hex2rgb = (hex) => {
    const bigint = parseInt(hex, 16);

    return [(bigint >> 16) & 255, (bigint >> 8) & 255, bigint & 255];
};

/**
 * Extract the RGB values from the RGB color string (`rgb(255, 255, 255)` -> [255, 255, 255]).
 *
 * @param {String} text
 * @returns Number[]
 */
const rgbToArray = (text) => {
    if (text.startsWith("rgb(")) {
        text = text.replace(/\)/, "");
        text = text.replace(/rgb\(/, "");
    }

    return text.split(", ").map(Number);
};

/**
 * Extract the RGB values from the CSS variable (`--text-white` -> [255, 255, 255]).
 *
 * @param {String} variable
 * @returns Number[]
 */
export function rgbFromCssVariable(variable) {
    return hex2rgb(
        getComputedStyle(document.documentElement)
            .getPropertyValue(variable)
            .replace("#", "")
    );
}

/**
 * Extract the RGB values from the given element's CSS property.
 *
 * @param {HTMLElement} element
 * @param {String} property
 * @returns Number[]
 */
export function rgbFromCssProperty(element, property) {
    return rgbToArray(resolveElementProperty(element, property));
}

/**
 * Given the start and end RGB values, compute the RGB values that are between the two by the given progress.
 * Example:
 * Start: [255, 255, 255]
 * End: [0, 0, 0]
 * Progress: 0.5
 * Output: [127, 127, 127]
 *
 *
 * @param {Number[]} start
 * @param {Number[]} end
 * @param {Number} progress
 * @returns String
 */
export function computeRgbColorBetween(start, end, progress) {
    if (progress === 0) {
        return `rgb(${[...start].join(", ")})`;
    }

    if (progress === 1) {
        return `rgb(${[...end].join(", ")})`;
    }

    return `rgb(${[...end]
        .map((color, index) => {
            // lower RGB value + abs(difference * progress)

            const startingColor = Math.min(color, start[index]);
            let progressPercentage = progress;

            if (color <= start[index]) {
                progressPercentage = 1 - progressPercentage;
            }

            const diff = color - start[index];

            return startingColor + Math.abs(diff * progressPercentage);
        })
        .map(Math.ceil)
        .join(",")})`;
}
