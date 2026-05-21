<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    window.FIREBASE_CONFIG = @json(greeate_setting('firebase_web_config_json', []));
    (function () {
        const stored = localStorage.getItem('greeate-dark');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (stored === 'true' || (stored === null && prefersDark)) {
            document.documentElement.classList.add('dark');
        }
    })();
    (function () {
        const locale = @json(app()->getLocale());
        const isRtl = @json(greeate_is_rtl());
        document.documentElement.setAttribute('lang', locale);
        document.documentElement.setAttribute('dir', isRtl ? 'rtl' : 'ltr');
    })();
</script>
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
<style>
    :root {
        --greeate-primary: {{ greeate_setting('primary_color', '#8b7fd9') }};
        --greeate-secondary: {{ greeate_setting('secondary_color', '#6b46c1') }};
    }
</style>
@vite(['resources/css/greeate.css', 'resources/js/greeate.js'])
@if(greeate_is_rtl())
    @vite(['resources/css/greeate-rtl.css'])
@endif
