@props([
    'domain',
])

<script src="{{ mix('js/cookie-consent.js') }}"></script>
<script>
    let cookieConsent = initCookieConsent();

    @if(config('tracking.analytics.key'))
        const addAnalytics = function () {
            var analyticsScript = document.createElement("script");
            analyticsScript.id = "google_analytics_script";
            analyticsScript.type = "text/javascript";
            analyticsScript.src = "https://www.googletagmanager.com/gtag/js?id={{ config('tracking.analytics.key') }}";
            document.body.append(analyticsScript);

            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('tracking.analytics.key') }}');
        };

        const removeAnalytics = function () {
            const analyticsScript = document.getElementById("google_analytics_script");
            analyticsScript.remove();

            // Get google analytics cookies
            const cookieNames = document.cookie
                .split(';')
                .filter(cookie => cookie.trim().startsWith('_ga'))
                .map(cookie => cookie.split('=')[0]);

            const host = '{{ config('tracking.analytics.domain') }}' || document.domain;
            cookieConsent.eraseCookies(cookieNames, '/', host);

            window['ga-disable-{{ config('tracking.analytics.key') }}'] = true;
        };
    @endif

    cookieConsent.run({
        use_rfc_cookie : true,
        @if(config('tracking.analytics.key'))
            onAccept(settings) {
                if (settings.level.includes("analytics")) {
                    addAnalytics();
                }
            },
            onChange(settings) {
                if (settings.level.includes("analytics")) {
                    addAnalytics();
                } else {
                    removeAnalytics();
                }
            },
        @endif
        current_lang : "{{ Config::get('app.locale', 'en') }}",

        languages : {
            en : {
                consent_modal : {
                    title :  "{{ trans('ui::cookie-consent.consent_modal.title') }}",
                    description :  "{{ trans('ui::cookie-consent.consent_modal.description') }}",
                    primary_btn: {
                        text: "{{ trans('ui::cookie-consent.consent_modal.primary_btn.text') }}",
                        role: 'accept_all'
                    },
                    secondary_btn: {
                        text : "{{ trans('ui::cookie-consent.consent_modal.secondary_btn.text') }}",
                        role : 'accept_necessary'
                    }
                },
                settings_modal : {
                    title : "{{ trans('ui::cookie-consent.settings_modal.title') }}",
                    save_settings_btn : "{{ trans('ui::cookie-consent.settings_modal.save_settings_btn') }}",
                    accept_all_btn : "{{ trans('ui::cookie-consent.settings_modal.accept_all_btn') }}",
                    reject_all_btn : "{{ trans('ui::cookie-consent.settings_modal.reject_all_btn') }}",
                    close_btn_label: "{{ trans('ui::cookie-consent.settings_modal.close_btn_label') }}",
                    cookie_table_headers : [
                        {col1: "{{ trans('ui::cookie-consent.settings_modal.cookie_table_headers.name') }}" },
                        {col2: "{{ trans('ui::cookie-consent.settings_modal.cookie_table_headers.domain') }}" },
                        {col3: "{{ trans('ui::cookie-consent.settings_modal.cookie_table_headers.description') }}" },
                    ],
                    blocks : [
                        {
                            title : "{{ trans('ui::cookie-consent.settings_modal.blocks.header.title') }}",
                            description: {!! json_encode(trans('ui::cookie-consent.settings_modal.blocks.header.description')) !!},
                        },
                        {
                            title : "{{ trans('ui::cookie-consent.settings_modal.blocks.necessary_cookies.title') }}",
                            description: "{{ trans('ui::cookie-consent.settings_modal.blocks.necessary_cookies.description') }}",
                            toggle : {
                                value : 'necessary',
                                enabled : true,
                                readonly: true
                            }
                        },
                        {
                            title : "{{ trans('ui::cookie-consent.settings_modal.blocks.analytics.title') }}",
                            description: "{{ trans('ui::cookie-consent.settings_modal.blocks.analytics.description') }}",
                            toggle : {
                                value : 'analytics',
                                enabled : false,
                                readonly: false
                            },
                            cookie_table: [
                                {
                                    col1: '^_ga',
                                    col2: '{{ $domain }}',
                                    col3: '@lang('ui::cookie-consent.settings_modal.blocks.analytics.analytics_description')' ,
                                },
                                {
                                    col1: '_ga_{{ config("tracking.analytics.key") }}',
                                    col2: '{{ $domain }}',
                                    col3: '@lang('ui::cookie-consent.settings_modal.blocks.analytics.session_description')' ,
                                }
                            ]
                        },
                        {
                            title : "{{ trans('ui::cookie-consent.settings_modal.blocks.footer.title') }}",
                            description: {!! json_encode(trans('ui::cookie-consent.settings_modal.blocks.footer.description')) !!},
                        }
                    ]
                }
            }
        },
        gui_options: {
            consent_modal : {
                layout : 'cloud',
                position : 'bottom center',
                transition: 'slide'
            },
            settings_modal : {
                layout : 'box',
                transition: 'slide'
            }
        }
    });

    let cookieBannerText = document.getElementById("c-txt");

    if (cookieBannerText) {
        // Append a third button to manage cookies preferences
        cookieBannerText.insertAdjacentHTML("beforeend",
            '&nbsp;<button type="button" onclick="cookieConsent.showSettings()" data-cc="c-settings" class="preferences-button">Manage Preferences</button>'
        );
    }
</script>
