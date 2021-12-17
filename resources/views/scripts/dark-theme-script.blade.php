@if(config('ui.dark-mode.enabled', false) === true)
    <script>
        document.addEventListener('setThemeMode', (e) => {
            localStorage.theme = e.detail.theme; toggleTheme();
        });

        document.addEventListener('setOSThemeMode', (e) => {
            localStorage.removeItem('theme'); toggleTheme();
        });

        document.addEventListener('toggleThemeMode', (e) => toggleTheme());

        const toggleTheme = () => {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        }

        toggleTheme();
    </script>
@endif
