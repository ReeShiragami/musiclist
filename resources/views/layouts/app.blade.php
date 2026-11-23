<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MusicList')</title>
    <style>
        :root {
            --bg: #ffffff;
            --bg-subtle: #f6f8fa;
            --border: #d0d7de;
            --text: #1f2328;
            --muted: #59636e;
            --accent: #0969da;
            --danger: #cf222e;
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #0d1117;
                --bg-subtle: #151b23;
                --border: #3d444d;
                --text: #e6edf3;
                --muted: #9198a1;
                --accent: #4493f8;
                --danger: #f85149;
            }
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font: 14px/1.5 -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .wrap { max-width: 900px; margin: 0 auto; padding: 24px 16px 64px; }
        header.top {
            border-bottom: 1px solid var(--border);
            background: var(--bg-subtle);
            padding: 12px 0;
        }
        header.top .wrap { padding: 0 16px; display: flex; align-items: center; gap: 12px; }
        header.top a { color: var(--text); text-decoration: none; font-weight: 600; }
        a { color: var(--accent); }
        .counter {
            border: 1px solid var(--border);
            border-radius: 2em;
            padding: 0 8px;
            font-size: 12px;
            color: var(--muted);
            background: var(--bg);
        }
        .btn {
            display: inline-block;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 5px 12px;
            background: var(--bg-subtle);
            color: var(--text);
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-primary { background: #1f883d; border-color: #1f883d; color: #fff; }
        .btn-danger { color: var(--danger); }
        .card { border: 1px solid var(--border); border-radius: 6px; overflow: hidden; }
        .card-head {
            background: var(--bg-subtle);
            border-bottom: 1px solid var(--border);
            padding: 10px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .row { border-bottom: 1px solid var(--border); padding: 12px 16px; }
        .row:last-child { border-bottom: 0; }
        .row h3 { margin: 0 0 2px; font-size: 15px; }
        .meta { color: var(--muted); font-size: 12px; }
        .tag {
            display: inline-block;
            border-radius: 2em;
            padding: 0 9px;
            font-size: 12px;
            line-height: 20px;
            background: rgba(68,147,248,.15);
            color: var(--accent);
            text-decoration: none;
            margin-right: 4px;
        }
        .tag.active { background: var(--accent); color: #fff; }
        .flash {
            border: 1px solid rgba(31,136,61,.4);
            background: rgba(31,136,61,.1);
            border-radius: 6px;
            padding: 10px 16px;
            margin-bottom: 16px;
        }
        label { display: block; font-weight: 600; margin: 16px 0 6px; }
        input[type=text], input[type=url] {
            width: 100%;
            padding: 6px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
        }
        .hint { color: var(--muted); font-size: 12px; margin-top: 4px; }
        .error { color: var(--danger); font-size: 12px; margin-top: 4px; }
        .actions { margin-top: 24px; display: flex; gap: 8px; align-items: center; }
        .empty { padding: 48px 16px; text-align: center; color: var(--muted); }
    </style>
</head>
<body>
    <header class="top">
        <div class="wrap">
            <a href="{{ route('songs.index') }}">♪ MusicList</a>
        </div>
    </header>

    <main class="wrap">
        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>