const CookieBanner = {
    options: {
        locale: "en",
        disableOutsideClick: false,
        overlayCrossButton: false,
        trackingAnalytics: false,
        lang: {
            consentModal: {
                title: "This website uses cookies.",
                description:
                    'By clicking "Accept" you agree to the storing of cookies on your device to enhance site navigation, analyze site usage and assist in our marketing efforts.',
                primaryBtn: {
                    text: "Accept",
                },
                secondaryBtn: {
                    text: "Reject",
                },
            },
            settingsModal: {
                title: "Cookie Settings",
                save_settings_btn: "Accept Selected",
                accept_all_btn: "Accept All",
                reject_all_btn: "Reject All",
                close_btn_label: "Close",
                cookie_table_headers: {
                    name: "Name",
                    domain: "Domain",
                    description: "Description",
                },
                blocks: {
                    header: {
                        title: "Cookie Usage",
                        description: (appName) =>
                            `${appName} uses cookies in order to provide you with a safer and more streamlined experience. Learn more by reading our <a href="/cookie-policy">Cookie Policy</a>.`,
                    },
                    necessary_cookies: {
                        title: "Strictly Necessary Cookies",
                        description:
                            "These cookies are essential for the proper functioning of our website and don't store any user-identifiable data. Without these cookies, the website would not work properly. This option cannot be disabled.",
                    },
                    analytics: {
                        title: "Performance and Analytics Cookies",
                        description:
                            "These cookies collect information about how you use the website, which pages you visited and which links you clicked on. All of the data is anonymized and cannot be used to identify you.",
                        analytics_description:
                            "This cookie is installed by Google Analytics and used for the site’s analytics report. This information is stored anonymously and assigned a random number to identify unique visitors.",
                        session_description:
                            "This cookie is installed by Google Analytics for session management.",
                    },
                    footer: {
                        title: "More Information",
                        description: (url) =>
                            `For any queries in relation to our policy on cookies and your choices, please <a href="${url}">contact us</a>.`,
                    },
                },
            },
        },
    },
    cookieConsent: null,
    disableOutsideClick() {
        this.options.disableOutsideClick = true;

        return this;
    },
    overlayCrossButton() {
        this.options.overlayCrossButton = true;

        return this;
    },
    withtrackingAnalytics(key, domain = "") {
        this.options.trackingAnalytics = {
            key,
            domain,
        };

        return this;
    },
    withLocale(locale) {
        this.options.locale = locale;

        return this;
    },
    withLang(lang) {
        this.options.lang = lang;

        return this;
    },
    showSettings() {
        this.cookieConsent.showSettings();
    },
    init({ appName, domain, contactUrl }) {
        this.cookieConsent = initCookieConsent(null, this.options);

        let addAnalytics;
        let removeAnalytics;

        if (this.options.trackingAnalytics) {
            addAnalytics = () => {
                var analyticsScript = document.createElement("script");
                analyticsScript.id = "google_analytics_script";
                analyticsScript.type = "text/javascript";
                analyticsScript.src = `https://www.googletagmanager.com/gtag/js?id=${this.options.trackingAnalytics.key}`;
                document.body.append(analyticsScript);

                window.dataLayer = window.dataLayer || [];
                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag("js", new Date());
                gtag("config", this.options.trackingAnalytics.key);
            };

            removeAnalytics = () => {
                const analyticsScript = document.getElementById(
                    "google_analytics_script"
                );
                analyticsScript.remove();

                // Get google analytics cookies
                const cookieNames = document.cookie
                    .split(";")
                    .filter((cookie) => cookie.trim().startsWith("_ga"))
                    .map((cookie) => cookie.split("=")[0]);

                const host =
                    this.options.trackingAnalytics.domain || document.domain;
                this.cookieConsent.eraseCookies(cookieNames, "/", host);

                window[
                    `ga-disable-${this.options.trackingAnalytics.key}`
                ] = true;
            };
        }

        const cookieConsentOptions = {
            current_lang: this.options.locale,

            languages: {
                en: {
                    consent_modal: {
                        title: this.options.lang.consentModal.title,
                        description: this.options.lang.consentModal.description,
                        primary_btn: {
                            text: this.options.lang.consentModal.primaryBtn
                                .text,
                            role: "accept_all",
                        },
                        secondary_btn: {
                            text: this.options.lang.consentModal.secondaryBtn
                                .text,
                            role: "accept_necessary",
                        },
                    },
                    settings_modal: {
                        title: this.options.lang.settingsModal.title,
                        save_settings_btn:
                            this.options.lang.settingsModal.save_settings_btn,
                        accept_all_btn:
                            this.options.lang.settingsModal.accept_all_btn,
                        reject_all_btn:
                            this.options.lang.settingsModal.reject_all_btn,
                        close_btn_label:
                            this.options.lang.settingsModal.close_btn_label,
                        cookie_table_headers: [
                            {
                                col1: this.options.lang.settingsModal
                                    .cookie_table_headers.name,
                            },
                            {
                                col2: this.options.lang.settingsModal
                                    .cookie_table_headers.domain,
                            },
                            {
                                col3: this.options.lang.settingsModal
                                    .cookie_table_headers.description,
                            },
                        ],
                        blocks: [
                            {
                                title: this.options.lang.settingsModal.blocks
                                    .header.title,
                                description:
                                    this.options.lang.settingsModal.blocks.header.description(
                                        appName
                                    ),
                            },
                            {
                                title: this.options.lang.settingsModal.blocks
                                    .necessary_cookies.title,
                                description:
                                    this.options.lang.settingsModal.blocks
                                        .necessary_cookies.description,
                                toggle: {
                                    value: "necessary",
                                    enabled: true,
                                    readonly: true,
                                },
                            },
                            {
                                title: this.options.lang.settingsModal.blocks
                                    .analytics.title,
                                description:
                                    this.options.lang.settingsModal.blocks
                                        .analytics.description,
                                toggle: {
                                    value: "analytics",
                                    enabled: false,
                                    readonly: false,
                                },
                                cookie_table: [
                                    {
                                        col1: "^_ga",
                                        col2: domain,
                                        col3: this.options.lang.settingsModal
                                            .blocks.analytics
                                            .analytics_description,
                                    },
                                    {
                                        col1: `_ga_${this.options.trackingAnalytics.key}`,
                                        col2: domain,
                                        col3: this.options.lang.settingsModal
                                            .blocks.analytics
                                            .session_description,
                                    },
                                ],
                            },
                            {
                                title: this.options.lang.settingsModal.blocks
                                    .footer.title,
                                description:
                                    this.options.lang.settingsModal.blocks.footer.description(
                                        contactUrl
                                    ),
                            },
                        ],
                    },
                },
            },
            gui_options: {
                consent_modal: {
                    layout: "cloud",
                    position: "bottom center",
                    transition: "slide",
                },
                settings_modal: {
                    layout: "box",
                    transition: "slide",
                },
            },
        };

        if (this.options.trackingAnalytics) {
            cookieConsentOptions.onAccept = (settings) => {
                if (settings.categories.includes("analytics")) {
                    addAnalytics();
                }
            };

            cookieConsentOptions.onChange = (settings) => {
                if (settings.categories.includes("analytics")) {
                    addAnalytics();
                } else {
                    removeAnalytics();
                }
            };
        }

        this.cookieConsent.run(cookieConsentOptions);

        let cookieBannerText = document.getElementById("c-txt");

        if (cookieBannerText) {
            // Append a third button to manage cookies preferences
            cookieBannerText.insertAdjacentHTML(
                "beforeend",
                '&nbsp;<button type="button" onclick="CookieBanner.showSettings()" data-cc="c-settings" class="preferences-button">Manage Preferences</button>'
            );
        }
    },
};

export default CookieBanner;
