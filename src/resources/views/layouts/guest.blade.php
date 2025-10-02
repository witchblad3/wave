{{-- resources/views/layouts/guest.blade.php --}}
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen text-slate-100">
{{-- Фон --}}
<div class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-br from-gray-950 via-slate-900 to-gray-800 animate-[bgShift_14s_ease-in-out_infinite]"></div>
    <div class="absolute inset-0 opacity-20 [background:radial-gradient(rgba(255,255,255,.08)_1px,transparent_1px)] [background-size:18px_18px]"></div>
    <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full blur-3xl opacity-30 bg-indigo-500/30"></div>
    <div class="absolute -bottom-24 -right-24 h-72 w-72 rounded-full blur-3xl opacity-30 bg-fuchsia-500/30"></div>
</div>

{{-- Контент --}}
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        {{ $slot }}
    </div>
</div>

{{-- Прелоадер (для всех форм с классом js-preload-on-submit) --}}
<div id="global-preloader" class="fixed inset-0 hidden z-50 items-center justify-center bg-black/60 backdrop-blur-sm">
    <div class="h-12 w-12 animate-spin rounded-full border-4 border-white/20 border-t-white"></div>
</div>

<script>
    document.addEventListener('submit', (e) => {
        const form = e.target.closest('form.js-preload-on-submit');
        if (!form) return;
        const overlay = document.getElementById('global-preloader');
        if (overlay) overlay.classList.remove('hidden');
        const btn = form.querySelector('button[type="submit"], button:not([type])');
        if (btn) {
            btn.dataset.originalText = btn.innerHTML;
            btn.innerHTML = 'Загрузка…';
            btn.disabled = true;
            btn.classList.add('opacity-70','cursor-not-allowed');
        }
    });
</script>

<style>
    @keyframes bgShift { 0%,100% { filter:hue-rotate(0deg) } 50% { filter:hue-rotate(20deg) } }
</style>
</body>
{{-- resources/views/components/guest-layout.blade.php --}}

</html>
