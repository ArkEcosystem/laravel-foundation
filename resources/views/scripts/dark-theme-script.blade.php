@if((bool) config('ui.dark-mode.enabled', false))
    <script>document.addEventListener("setThemeMode",(e=>{localStorage.theme=e.detail.theme,toggleTheme()})),document.addEventListener("setOSThemeMode",(e=>{localStorage.removeItem("theme"),toggleTheme()})),document.addEventListener("toggleThemeMode",(e=>toggleTheme()));const toggleTheme=()=>{"dark"===localStorage.theme||!("theme"in localStorage)&&window.matchMedia("(prefers-color-scheme: dark)").matches?document.documentElement.classList.add("dark"):document.documentElement.classList.remove("dark")};toggleTheme();</script>
@endif
