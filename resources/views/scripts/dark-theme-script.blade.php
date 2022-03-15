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
            localStorage.theme = e.detail.theme;
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
                _theme = 'dark';
            } else {
                document.documentElement.classList.remove('dark');
                _theme = 'light';
            }

            /**
             * Emit a custom `theme-changed` event.
             */
            document.documentElement.dispatchEvent(new CustomEvent('theme-changed', {
                detail: {theme: _theme},
                bubbles: true,
            }));

            if (window.Livewire) {
                Livewire.emit('themeChanged', _theme);
            }
        }

        toggleTheme();

        /**
         * Helper to get the current theme name.
         *
         * @return {string}
         */
        window.getThemeMode = () => _theme;
    </script>
@endif
