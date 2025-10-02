<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Мой сайт') }}</title>
    <meta name="color-scheme" content="light dark">

    <style>
        :root{
            --bg:#f6f7f9; --fg:#101114; --muted:#6b7280; --card:#ffffff; --border:#e5e7eb; --accent:#ef4444;
            --btn:#111827; --btn-fg:#ffffff; --btn-hover:#0b1220; --radius:14px;
        }
        @media (prefers-color-scheme: dark){
            :root{
                --bg:#0b0c0f; --fg:#eef2ff; --muted:#a1a1aa; --card:#121418; --border:#24262b; --accent:#f97316;
                --btn:#f8fafc; --btn-fg:#0b0c0f; --btn-hover:#e5e7eb;
            }
        }
        *{box-sizing:border-box}
        html,body{height:100%}
        body{
            margin:0; font:16px/1.6 system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, "Helvetica Neue", Arial, "Apple Color Emoji","Segoe UI Emoji";
            color:var(--fg); background:radial-gradient(1200px 600px at 10% -10%, rgba(0,0,0,.04), transparent 60%), var(--bg);
            display:grid; place-items:center; padding:24px;
        }
        .wrap{width:100%; max-width:880px}
        header{display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:18px}
        .brand{display:flex; align-items:center; gap:10px; font-weight:700; letter-spacing:.2px}
        .brand .dot{width:10px; height:10px; border-radius:50%; background:var(--accent)}
        nav{display:flex; gap:10px; flex-wrap:wrap}
        a{color:inherit; text-decoration:none}
        .btn{display:inline-flex; align-items:center; justify-content:center; gap:.5rem; padding:.6rem 1rem; border-radius:10px; border:1px solid var(--border); background:var(--btn); color:var(--btn-fg); font-weight:600}
        .btn:hover{background:var(--btn-hover)}
        .btn.ghost{background:transparent; color:var(--fg)}
        .btn.ghost:hover{background-color:rgba(0,0,0,.06)}
        @media (prefers-color-scheme: dark){
            .btn.ghost:hover{background-color:rgba(255,255,255,.08)}
        }

        .card{background:var(--card); border:1px solid var(--border); border-radius:var(--radius); padding:28px 24px; box-shadow:0 6px 30px rgba(0,0,0,.06)}
        .hero{display:grid; grid-template-columns:1.2fr; gap:18px}
        .title{font-size:clamp(28px, 3.2vw, 40px); line-height:1.2; margin:0}
        .lead{color:var(--muted); margin:6px 0 0 0; font-size:clamp(14px, 1.6vw, 16px)}
        .actions{display:flex; gap:10px; flex-wrap:wrap; margin-top:16px}
        footer{margin-top:16px; color:var(--muted); font-size:13px; text-align:center}
        .accent{color:var(--accent)}
    </style>
</head>
<body>
<div class="wrap">
    <header>
        <div class="brand" aria-label="Логотип">
            <span class="dot" aria-hidden="true"></span>
            <a href="{{ url('/') }}" class="accent">{{ config('app.name', 'Мой сайт') }}</a>
        </div>

        @if (Route::has('login'))
            <nav>
                @auth
                    <a class="btn ghost" href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a class="btn ghost" href="{{ route('login') }}">Войти</a>
                    @if (Route::has('register'))
                        <a class="btn" href="{{ route('register') }}">Регистрация</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="card hero" role="main">
        <section>
            <h1 class="title">Добро пожаловать на <span class="accent">{{ config('app.name', 'сайт') }}</span></h1>
            <p class="lead">Лёгкая стартовая страница без лишнего — только главное. Можно сразу перейти в панель или войти на сайт.</p>

            <div class="actions">
                @auth
                    <a class="btn" href="{{ url('/dashboard') }}">Перейти в Dashboard</a>
                @else
                    @if (Route::has('register'))
                        <a class="btn" href="{{ route('register') }}">Создать аккаунт</a>
                    @endif
                    <a class="btn ghost" href="{{ route('login') }}">У меня уже есть аккаунт</a>
                @endauth
            </div>
        </section>
    </main>

    <footer>
        © {{ date('Y') }} {{ config('app.name', 'Мой сайт') }} · Все права защищены
    </footer>
</div>
</body>
</html>
