import {
    getInfoFromThemeName,
    makeGradient,
    getFontConfig,
    getAxisThemeConfig,
    getCrosshairColor,
} from "./chart-theme";

import { Chart, registerables, LineController } from "chart.js";

Chart.register(...registerables);

/**
 * @param {String} id
 * @param {Array} values
 * @param {Array} labels
 * @param {Boolean} grid
 * @param {Boolean} tooltips
 * @param {Array<Object{name, mode}>} theme
 * @param {Number} time
 * @param {String} currency
 * @param {Number} yPadding
 * @param {Number} xPadding
 * @param {Boolean} showCrosshair
 * @param {CallableFunction|null} tooltipHandler
 * @param {Boolean} hasDateTimeLabels
 * @param {String|null} dateUnitOverride
 * @return {Object}
 */
const CustomChart = (
    id,
    values,
    labels,
    grid,
    tooltips,
    theme,
    time,
    currency,
    yPadding = 15,
    xPadding = 10,
    showCrosshair = false,
    tooltipHandler = null,
    hasDateTimeLabels = false,
    dateUnitOverride = null
) => {
    const themeMode = () => {
        if (theme.mode === "auto") {
            return ["light", "dark", "dim"].includes(localStorage.theme)
                ? localStorage.theme
                : "light";
        }

        return theme.mode;
    };

    class LineWithCrosshair extends LineController {
        draw() {
            super.draw(arguments);

            // Based on https://stackoverflow.com/a/70245628/3637093
            if (
                this.chart.tooltip._active &&
                this.chart.tooltip._active.length
            ) {
                const activePoint = this.chart.tooltip._active[0].element;
                const ctx = this.chart.ctx;
                const x = activePoint.x;
                const y = activePoint.y;
                const topY = this.chart.legend.bottom;
                const bottomY = this.chart.chartArea.bottom;
                const left = this.chart.chartArea.left;
                const right = this.chart.chartArea.right;

                ctx.save();
                ctx.lineWidth = 1;
                ctx.setLineDash([3, 3]);
                ctx.strokeStyle = getCrosshairColor(themeMode());

                ctx.beginPath();
                ctx.moveTo(x, topY);
                ctx.lineTo(x, bottomY);
                ctx.stroke();

                ctx.beginPath();
                ctx.moveTo(left, y);
                ctx.lineTo(right, y);
                ctx.stroke();

                ctx.restore();
            }
        }
    }

    LineWithCrosshair.id = "lineWithCrosshair";
    LineWithCrosshair.defaults = LineController.defaults;

    Chart.register(LineWithCrosshair);

    return {
        time: time,
        chart: null,
        currency: currency || "USD",

        getCanvas() {
            return this.$refs[id];
        },

        getCanvasContext() {
            return this.getCanvas().getContext("2d");
        },

        getRangeFromValues(values, margin = 0) {
            const max = Math.max.apply(Math, values);
            const min = Math.min.apply(Math, values);
            const _margin = max * margin;

            return {
                min: min - _margin,
                max: max + _margin,
            };
        },

        getCurrencyValue(value) {
            return new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: this.currency,
            }).format(value);
        },

        resizeChart() {
            this.updateChart();
        },

        updateChart() {
            this.chart.datasets = this.loadData();
            this.chart.labels = labels;
            this.chart.update();
        },

        loadData() {
            const datasets = [];

            if (values.length === 0) {
                values = [0, 0];
                labels = [0, 1];
            }

            if (Array.isArray(values) && !values[0].hasOwnProperty("data")) {
                values = [values];
            }

            values.forEach((value, key) => {
                let themeName = value.type === "bar" ? "grey" : theme.name;
                let graphic = getInfoFromThemeName(themeName, themeMode());
                let backgroundColor = graphic.backgroundColor;
                if (backgroundColor.hasOwnProperty("gradient")) {
                    backgroundColor = makeGradient(
                        this.getCanvas(),
                        backgroundColor.gradient
                    );
                }

                let chartType = value.type || "line";
                if (showCrosshair && chartType === "line") {
                    chartType = "lineWithCrosshair";
                }

                datasets.push({
                    fill: true,
                    stack: "combined",
                    label: value.name || "",
                    data: value.data || value,
                    type: chartType,
                    backgroundColor:
                        value.type === "bar"
                            ? graphic.borderColor
                            : backgroundColor,
                    borderColor:
                        value.type === "bar"
                            ? "transparent"
                            : graphic.borderColor,
                    borderWidth:
                        value.type === "bar"
                            ? "transparent"
                            : graphic.borderWidth,
                    cubicInterpolationMode: "monotone",
                    tension: graphic.lineTension,
                    pointRadius: graphic.pointRadius,
                    pointBackgroundColor: graphic.pointBackgroundColor,
                    pointHoverRadius: tooltips ? graphic.pointHoverRadius : 0,
                    pointHoverBorderWidth: tooltips
                        ? graphic.pointHoverBorderWidth
                        : 0,
                    pointHoverBorderColor: tooltips ? graphic.borderColor : 0,
                    pointHoverBackgroundColor: tooltips
                        ? graphic.pointHoverBackgroundColor
                        : 0,
                });
            });

            return datasets;
        },

        loadYAxes() {
            const axes = [];

            values.forEach((value, key) => {
                let range = this.getRangeFromValues(value, 0.01);
                axes.push({
                    display: grid && key === 0,
                    type: "linear",
                    ticks: {
                        ...getFontConfig("axis", themeMode()),
                        padding: yPadding,
                        display: grid && key === 0,
                        suggestedMax: range.max,
                        callback: (value, index, data) =>
                            this.getCurrencyValue(value),
                    },
                    grid: {
                        drawTicks: false,
                        display: grid && key === 0,
                        drawBorder: false,
                        borderDash: [3, 3],
                        color: getAxisThemeConfig(themeMode()).y.color,
                    },
                });
            });

            return axes;
        },

        init() {
            if (this.chart) {
                this.chart.destroy();
            } else if (Chart.getChart(this.getCanvas())) {
                Chart.getChart(this.getCanvas()).destroy();
            }

            this.$watch("time", () => this.updateChart());

            window.addEventListener("resize", () => {
                try {
                    this.chart.resize();
                } catch (e) {
                    // Hide resize errors - they don't seem to cause any issues
                }
            });

            const data = {
                labels: labels,
                datasets: this.loadData(),
            };

            let tooltipOptions = {
                enabled: tooltips,
                external: this.tooltip,
                displayColors: false,
                callbacks: {
                    title: (items) => {},
                    label: (context) => this.getCurrencyValue(context.raw),
                    labelTextColor: (context) =>
                        getFontConfig("tooltip", themeMode()).fontColor,
                },
                backgroundColor: getFontConfig("tooltip", themeMode())
                    .backgroundColor,
            };
            if (tooltipHandler) {
                tooltipOptions = {
                    enabled: false,
                    external: tooltipHandler,
                };
            }

            const options = {
                currency,
                spanGaps: true,
                normalized: true,
                responsive: true,
                maintainAspectRatio: false,
                showScale: grid,
                animation: { duration: 300, easing: "easeOutQuad" },
                interaction: {
                    mode: "nearest",
                    intersect: false,
                },
                plugins: {
                    legend: { display: false },
                    tooltip: tooltipOptions,
                },
                hover: {
                    mode: "nearest",
                    intersect: false,
                    axis: "x",
                },
                scales: {
                    yAxes: {
                        ...this.loadYAxes()[0],
                        position: "right",
                    },
                    xAxes: {
                        display: grid,
                        type: "category",
                        labels: labels,
                        ticks: {
                            display: grid,
                            includeBounds: true,
                            padding: xPadding,
                            ...getFontConfig("axis", themeMode()),
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                            color: getAxisThemeConfig(themeMode()).x.color,
                        },
                    },
                },
            };

            if (hasDateTimeLabels) {
                options.scales.xAxes.type = "time";
                options.scales.xAxes.ticks.maxRotation = 0;
                options.scales.xAxes.ticks.autoSkipPadding = 20;
                options.scales.yAxes.ticks.autoSkipPadding = 15;

                options.scales.xAxes.time = {
                    displayFormats: {
                        hour: "HH:00",
                        day: "dd.MM",
                        month: "MMM yyyy",
                        year: "yyyy",
                    },
                };

                if (dateUnitOverride) {
                    options.scales.xAxes.time.unit = dateUnitOverride;
                }
            }

            this.chart = new Chart(this.getCanvasContext(), { data, options });
        },
    };
};

export default CustomChart;
