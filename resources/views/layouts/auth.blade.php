<!DOCTYPE html>
<html lang="km" data-bs-theme="light" id="htmlRoot">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') — SMS System</title>
    <link rel="icon" type="image/png" href="{{ asset('images/school-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Khmer:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { 
            --primary: #6366f1; 
            --primary-hover: #4f46e5; 
            --bg-body: #f8fafc;
            --card-bg: rgba(255, 255, 255, 0.8);
            --text-main: #1e293b;
            --text-sub: #64748b;
            --input-bg: rgba(0, 0, 0, 0.03);
            --input-border: rgba(0, 0, 0, 0.1);
        }
        
        [data-bs-theme="dark"] {
            --bg-body: #0f172a;
            --card-bg: rgba(15, 23, 42, 0.65);
            --text-main: #f8fafc;
            --text-sub: #94a3b8;
            --input-bg: rgba(255, 255, 255, 0.05);
            --input-border: rgba(255, 255, 255, 0.1);
        }

        body { 
            font-family: 'Inter', 'Noto Sans Khmer', sans-serif; 
            min-height: 100vh; 
            background: var(--bg-body); 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0;
            overflow: hidden;
            color: var(--text-main);
            transition: background 0.3s, color 0.3s;
        }
        
        #particles-root { 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            z-index: 0; 
            opacity: 0.6;
        }

        .auth-card { 
            background: var(--card-bg); 
            backdrop-filter: blur(16px) saturate(180%); 
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid var(--input-border); 
            border-radius: 28px; 
            padding: 3rem; 
            width: 100%; 
            max-width: 440px; 
            position: relative; 
            z-index: 10; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2); 
        }

        .auth-logo { 
            width: 64px; 
            height: 64px; 
            background: linear-gradient(135deg, var(--primary), #a855f7); 
            border-radius: 18px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 1.5rem; 
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
            transform: rotate(-5deg);
        }

        .auth-title { font-size: 1.75rem; font-weight: 800; text-align: center; margin-bottom: 0.5rem; letter-spacing: -0.025em; color: var(--text-main); }
        .auth-sub { color: var(--text-sub); font-size: 0.95rem; text-align: center; margin-bottom: 2.5rem; }

        .form-label { color: var(--text-sub); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.6rem; display: block; }
        
        .input-group { background: var(--input-bg); border: 1px solid var(--input-border); border-radius: 14px; overflow: hidden; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .input-group:focus-within { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15); background: var(--input-bg); }
        
        .input-group-text { background: transparent; border: none; color: var(--text-sub); padding-left: 1.25rem; padding-right: 0.75rem; }
        .form-control { background: transparent; border: none; color: var(--text-main); padding: 0.85rem 1rem 0.85rem 0; font-size: 1rem; }
        .form-control:focus { box-shadow: none; background: transparent; color: var(--text-main); }
        .form-control::placeholder { color: var(--text-sub); opacity: 0.5; }

        .btn-login { 
            background: var(--primary); 
            color: #fff; 
            border: none; 
            border-radius: 14px; 
            padding: 1rem; 
            font-weight: 700; 
            font-size: 1rem; 
            width: 100%;
            transition: all 0.3s; 
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-login:hover { background: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.5); color: #fff; }
        .btn-login:active { transform: translateY(0); }

        .btn-guest { 
            background: var(--input-bg); 
            color: var(--text-sub); 
            border: 1px solid var(--input-border); 
            border-radius: 14px; 
            padding: 0.85rem; 
            font-weight: 600; 
            font-size: 0.95rem; 
            width: 100%;
            transition: all 0.3s; 
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }
        .btn-guest:hover { 
            background: var(--input-bg); 
            color: var(--text-main);
            border-color: var(--primary);
            transform: translateY(-2px); 
        }

        .form-check-input { background-color: var(--input-bg); border-color: var(--input-border); cursor: pointer; width: 1.15rem; height: 1.15rem; }
        .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }
        .form-check-label { color: var(--text-sub); font-size: 0.9rem; cursor: pointer; transition: color 0.2s; }
        .form-check-label:hover { color: var(--text-main); }

        .alert-danger { 
            background: rgba(239, 68, 68, 0.1); 
            border: 1px solid rgba(239, 68, 68, 0.2); 
            color: #ef4444; 
            border-radius: 14px; 
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        [data-lucide] { stroke-width: 2.25; }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 100;
            background: var(--card-bg);
            border: 1px solid var(--input-border);
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-main);
            transition: all 0.3s;
            backdrop-filter: blur(8px);
        }
        .theme-toggle:hover {
            transform: scale(1.1);
            border-color: var(--primary);
        }
        .theme-toggle .icon-sun { display: none; }
        [data-bs-theme="dark"] .theme-toggle .icon-moon { display: none; }
        [data-bs-theme="dark"] .theme-toggle .icon-sun { display: block; }
    </style>
</head>
<body>
    <button class="theme-toggle" id="themeToggle" title="Toggle Theme">
        <i data-lucide="moon" class="icon-moon"></i>
        <i data-lucide="sun" class="icon-sun"></i>
    </button>

    <div id="particles-root"></div>
    <div class="auth-card">
        <div class="text-center mb-4">
            <img src="{{ asset('images/school-logo.png') }}" alt="School Logo" style="height: 72px; width: auto; border-radius: 12px; object-fit: contain; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">
        </div>
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.511.0/dist/umd/lucide.min.js"></script>
    <script>
        lucide.createIcons();

        // Theme Logic
        const htmlRoot = document.getElementById('htmlRoot');
        const themeToggle = document.getElementById('themeToggle');

        function applyTheme(theme) {
            htmlRoot.setAttribute('data-bs-theme', theme);
            localStorage.setItem('sms_theme', theme);
        }

        applyTheme(localStorage.getItem('sms_theme') || 'light');

        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlRoot.getAttribute('data-bs-theme');
            applyTheme(currentTheme === 'dark' ? 'light' : 'dark');
        });
    </script>
    @vite(['resources/js/login-particles.jsx'])
</body>
</html>
