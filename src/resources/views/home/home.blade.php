{{-- resources/views/home.blade.php --}}
@extends('layouts.app') {{-- если у тебя есть общий app. Если нет, убери extends --}}
@section('content')

    <div
        x-data="homePage()"
        x-init="init({{ request()->boolean('welcome') ? 'true' : 'false' }})"
        class="relative min-h-[calc(100vh-4rem)] overflow-hidden"
    >
        {{-- Фон — тёмный градиент + сетка --}}
        <div class="pointer-events-none absolute inset-0 -z-10">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-950 via-slate-900 to-gray-800 animate-[bgShift_12s_ease-in-out_infinite]"></div>
            <div class="absolute inset-0 opacity-20 [background:radial-gradient(rgba(255,255,255,.08)_1px,transparent_1px)] [background-size:18px_18px]"></div>
            <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full blur-3xl opacity-30 bg-indigo-500/30"></div>
            <div class="absolute -bottom-24 -right-24 h-72 w-72 rounded-full blur-3xl opacity-30 bg-fuchsia-500/30"></div>
        </div>

        {{-- Глобальный NAV (если не вставлен через layout, раскомментируй) --}}
        {{-- @include('layouts.navigation') --}}

        {{-- Прелоадер --}}
        <div
            x-show="loading"
            x-transition.opacity
            class="fixed inset-0 z-50 grid place-items-center bg-black/70 backdrop-blur-sm"
        >
            <div class="relative h-14 w-14">
                <div class="absolute inset-0 animate-ping rounded-full border-4 border-indigo-400/60"></div>
                <div class="absolute inset-2 rounded-full border-4 border-white/30 border-t-transparent animate-spin"></div>
            </div>
            <p class="mt-4 text-sm text-slate-300">Загрузка…</p>
        </div>

        {{-- Контент страницы --}}
        <div class="mx-auto max-w-6xl px-4 py-10">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-8 backdrop-blur-xl shadow-[0_25px_50px_-12px_rgba(0,0,0,.5)]">
                <h1 class="text-3xl font-semibold tracking-tight text-white">Главная</h1>
                <p class="mt-2 text-slate-300/90">Добро пожаловать, {{ Auth::user()->name }}!</p>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <a href="{{ route('rooms.index') }}" class="group rounded-xl border border-white/10 bg-white/0 p-5 text-slate-200 hover:bg-white/5 transition">
                        <div class="flex items-center justify-between">
                            <div class="text-lg font-medium">Комнаты</div>
                            <span class="rounded-lg bg-white/10 px-2 py-1 text-xs">перейти</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-400">Создавайте и находите комнаты для общения.</p>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="group rounded-xl border border-white/10 bg-white/0 p-5 text-slate-200 hover:bg-white/5 transition">
                        <div class="flex items-center justify-between">
                            <div class="text-lg font-medium">Профиль</div>
                            <span class="rounded-lg bg-white/10 px-2 py-1 text-xs">настройки</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-400">Имя, аватар, безопасность аккаунта.</p>
                    </a>
                </div>
            </div>
        </div>

        {{-- Модалка «Добро пожаловать» (открывается только при ?welcome=1) --}}
        <div x-cloak x-show="showWelcome" x-transition.opacity
             class="fixed inset-0 z-40 grid place-items-center p-4">
            <div class="absolute inset-0 bg-black/60" @click="closeWelcome()"></div>

            <div x-trap.noscroll.inert="showWelcome"
                 class="relative z-10 w-full max-w-lg rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl shadow-xl"
                 x-transition.scale.origin.center
            >
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-white">Добро пожаловать 👋</h2>
                    <button class="rounded-lg px-2 py-1 text-slate-300 hover:bg-white/10 hover:text-white"
                            @click="closeWelcome()">&times;</button>
                </div>
                <p class="mt-2 text-slate-300/90">
                    Вы успешно вошли. Приятной работы!
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <button class="rounded-xl border border-white/10 bg-white/0 px-4 py-2 text-slate-300 hover:bg-white/10"
                            @click="closeWelcome()">Спасибо</button>
                    <a href="{{ route('rooms.index') }}"
                       class="rounded-xl bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-500">
                        В комнаты
                    </a>
                </div>
            </div>

            {{-- Canvas для конфетти --}}
            <canvas id="confetti" class="pointer-events-none fixed inset-0 z-30"></canvas>
        </div>
    </div>

    {{-- Локальные стили/анимации --}}
    <style>
        @keyframes bgShift { 0%,100%{filter:hue-rotate(0deg)} 50%{filter:hue-rotate(20deg)} }
    </style>

    {{-- Локальный JS (Alpine + простое конфетти без внешних либ) --}}
    <script>
        function homePage(){
            let rafId = null;
            let confettiRunning = false;

            function startConfetti(duration = 1800, count = 140){
                const cvs = document.getElementById('confetti');
                if(!cvs) return;
                const ctx = cvs.getContext('2d');
                const dpr = window.devicePixelRatio || 1;

                function resize(){
                    cvs.width = Math.floor(innerWidth * dpr);
                    cvs.height = Math.floor(innerHeight * dpr);
                    ctx.scale(dpr, dpr);
                }
                resize();
                window.addEventListener('resize', resize);

                const particles = Array.from({length: count}, () => ({
                    x: Math.random()*innerWidth,
                    y: -20 - Math.random()*innerHeight*0.5,
                    r: 2 + Math.random()*3,
                    vx: -1 + Math.random()*2,
                    vy: 2 + Math.random()*3.5,
                    rot: Math.random()*360,
                    vr: -6 + Math.random()*12,
                    alpha: .8 + Math.random()*.2
                }));

                const colors = ['#a78bfa','#60a5fa','#34d399','#f472b6','#fbbf24'];

                const start = performance.now();
                confettiRunning = true;

                function frame(t){
                    const elapsed = t - start;
                    ctx.clearRect(0,0,innerWidth,innerHeight);
                    particles.forEach(p=>{
                        p.x += p.vx;
                        p.y += p.vy;
                        p.rot += p.vr;
                        if(p.y > innerHeight + 30) { p.y = -20; p.x = Math.random()*innerWidth; }
                        ctx.save();
                        ctx.globalAlpha = p.alpha;
                        ctx.translate(p.x, p.y);
                        ctx.rotate(p.rot*Math.PI/180);
                        ctx.fillStyle = colors[(p.r|0) % colors.length];
                        ctx.fillRect(-p.r, -p.r, p.r*2, p.r*2);
                        ctx.restore();
                    });
                    if(elapsed < duration && confettiRunning){
                        rafId = requestAnimationFrame(frame);
                    }else{
                        confettiRunning = false;
                        ctx.clearRect(0,0,innerWidth,innerHeight);
                        cancelAnimationFrame(rafId);
                    }
                }
                rafId = requestAnimationFrame(frame);
            }

            return {
                loading: true,
                showWelcome: false,
                init(open){
                    // скрываем прелоадер после готовности
                    window.addEventListener('load', () => setTimeout(()=>{ this.loading = false }, 300));
                    this.showWelcome = !!open;
                    if(this.showWelcome){ startConfetti(); }
                },
                closeWelcome(){
                    this.showWelcome = false;
                }
            }
        }
    </script>
@endsection
