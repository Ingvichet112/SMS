<!DOCTYPE html>
<html lang="km" data-bs-theme="light" id="htmlRoot">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') — SMS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Khmer:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family:'Inter', 'Noto Sans Khmer', sans-serif; min-height:100vh; background:linear-gradient(135deg,#0f172a 0%,#1e1b4b 50%,#0f172a 100%); display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden; }
        body::before,body::after { content:''; position:absolute; border-radius:50%; filter:blur(80px); opacity:.4; animation:float 8s ease-in-out infinite alternate; }
        body::before { width:500px; height:500px; background:radial-gradient(circle,#6366f1,transparent); top:-100px; left:-100px; }
        body::after  { width:400px; height:400px; background:radial-gradient(circle,#8b5cf6,transparent); bottom:-80px; right:-80px; animation-delay:-4s; }
        @keyframes float { from{transform:translate(0,0) scale(1);} to{transform:translate(30px,20px) scale(1.05);} }
        .auth-card { background:rgba(255,255,255,.05); backdrop-filter:blur(20px); border:1px solid rgba(255,255,255,.1); border-radius:24px; padding:2.5rem; width:100%; max-width:420px; position:relative; z-index:10; box-shadow:0 25px 50px rgba(0,0,0,.5); }
        .auth-logo  { width:56px; height:56px; background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 1.25rem; box-shadow:0 8px 24px rgba(99,102,241,.4); }
        .auth-title { color:#fff; font-weight:700; font-size:1.5rem; text-align:center; }
        .auth-sub   { color:#94a3b8; font-size:.875rem; text-align:center; margin-bottom:2rem; }
        .form-label { color:#cbd5e1; font-size:.875rem; font-weight:500; }
        .form-control { background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12); color:#fff; border-radius:10px; padding:.65rem 1rem; transition:all .2s; }
        .form-control:focus { background:rgba(255,255,255,.1); border-color:#6366f1; color:#fff; box-shadow:0 0 0 3px rgba(99,102,241,.25); }
        .form-control::placeholder { color:#475569; }
        .btn-login { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border:none; border-radius:10px; padding:.7rem; font-weight:600; font-size:.95rem; transition:all .2s; box-shadow:0 4px 16px rgba(99,102,241,.4); }
        .btn-login:hover { background:linear-gradient(135deg,#4f46e5,#7c3aed); color:#fff; transform:translateY(-1px); box-shadow:0 8px 24px rgba(99,102,241,.5); }
        .input-group-text { background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12); color:#64748b; }
        [data-lucide] { width:16px; height:16px; vertical-align:middle; stroke-width:2; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <i data-lucide="graduation-cap" style="width:28px;height:28px;stroke:#fff;stroke-width:1.75;"></i>
        </div>
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.511.0/dist/umd/lucide.min.js"></script>
    <script>lucide.createIcons();</script>
</body>
</html>
