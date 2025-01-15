@if(config('ui.dark-mode.enabled') === true)
    <script>
        let _theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

        /**
         * Set the O.S. preference.
         */
        document.addEventListener('setOSThemeMode', () => {
            localStorage.removeItem('theme');
            toggleTheme();
        });

        /**
         * Set the given theme ('light' or 'dark').
         */
        document.addEventListener('setThemeMode', (e) => {
            // The latest version of Livewire sends the details as an array.
            // Handling both cases for backward compatibility.
            theme = Array.isArray(e.detail) ? e.detail[0].theme : e.detail.theme;
            localStorage.theme = theme;
            toggleTheme();
        });

        /**
         * Toggle the current theme from light to dark and vice-versa.
         */
        document.addEventListener('toggleThemeMode', () => {
            toggleTheme();
        });

        const toggleTheme = () => {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
                document.documentElement.classList.remove('dim');
                _theme = 'dark';
            } else if (localStorage.theme === 'dim') {
                document.documentElement.classList.add('dim');
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
                _theme = 'dim';
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.remove('dim');
                _theme = 'light';
            }

            if (!('theme' in localStorage)) {
                localStorage.theme = _theme;
            }

            /**
             * Emit a custom `theme-changed` event.
             */
            document.documentElement.dispatchEvent(new CustomEvent('theme-changed', {
                detail: {theme: _theme},
                bubbles: true,
            }));

            @unless (app()->isDownForMaintenance())

                if (window.Livewire) {
                    Livewire.dispatch('themeChanged', {newValue: _theme});
                }

            @endunless
        }

        toggleTheme();

        /**
         * Helper to get the current theme name.
         *
         * @return {string}
         */
        window.getThemeMode = () => _theme;

        document.addEventListener("DOMContentLoaded", () => {
            toggleTheme();
        });
    </script>
@endif
