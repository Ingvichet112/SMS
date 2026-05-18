<!DOCTYPE html>
<html lang="km" data-bs-theme="light" id="htmlRoot">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Khmer:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #ffffff;
            --sidebar-text: #64748b;
            --sidebar-active-bg: #f3e8ff;
            --sidebar-active-text: #8b5cf6;
            --sidebar-hover-bg: #f8fafc;
            --sidebar-width: 260px;
            --topbar-height: 64px;
            --accent: #6366f1;
            --card-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 12px rgba(0,0,0,.04);
            font-family: 'Inter', 'Noto Sans Khmer', sans-serif;
        }
        [data-bs-theme="dark"] {
            --bs-body-bg: #0f172a;
            --bs-body-color: #e2e8f0;
            --bs-card-bg: #1e293b;
            --bs-border-color: #334155;
            --sidebar-bg: #1e293b;
            --sidebar-hover-bg: rgba(255,255,255,0.05);
            --sidebar-active-bg: rgba(139,92,246,0.15);
        }
        body { font-family: 'Inter', 'Noto Sans Khmer', sans-serif; }

        /* Lucide icon defaults — target both the placeholder <i> and the rendered <svg> */
        [data-lucide], svg.lucide { width: 18px; height: 18px; vertical-align: middle; stroke-width: 1.75; display: inline-block; flex-shrink: 0; }
        .lucide-sm,  svg.lucide.lucide-sm  { width: 14px !important; height: 14px !important; }
        .lucide-md,  svg.lucide.lucide-md  { width: 20px !important; height: 20px !important; }
        .lucide-lg,  svg.lucide.lucide-lg  { width: 24px !important; height: 24px !important; }
        .lucide-xl,  svg.lucide.lucide-xl  { width: 32px !important; height: 32px !important; }
        .lucide-2xl, svg.lucide.lucide-2xl { width: 48px !important; height: 48px !important; }

        #sidebar {
            width: var(--sidebar-width); min-height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--bs-border-color, #f1f5f9);
            position: fixed; top: 0; left: 0; z-index: 1050;
            display: flex; flex-direction: column;
            transition: transform .3s ease, background .3s, border-color .3s;
        }
        .sidebar-brand {
            padding: 1.5rem 1.5rem 1rem;
            display: flex; align-items: center; gap: .75rem; text-decoration: none;
        }
        .sidebar-brand .brand-icon {
            width: 38px; height: 38px;
            background: #8b5cf6;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center; color: #fff;
        }
        .sidebar-brand .brand-text { color: var(--bs-body-color, #1e293b); font-weight: 700; font-size: 1.15rem; letter-spacing: -.02em; }
        
        .nav-label {
            color: #94a3b8; font-size: .65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            padding: 1rem 1.5rem .5rem;
        }
        .sidebar-nav .nav-link {
            color: var(--sidebar-text); padding: .75rem 1.2rem;
            border-radius: 12px; display: flex; align-items: center; gap: .85rem;
            font-size: .9rem; font-weight: 500; transition: all .2s;
            margin: .2rem 1.2rem;
            text-decoration: none;
        }
        .sidebar-nav .nav-link [data-lucide] { width: 20px; height: 20px; stroke-width: 2; opacity: .7; }
        .sidebar-nav .nav-link:hover { background: var(--sidebar-hover-bg); color: var(--bs-body-color, #334155); }
        .sidebar-nav .nav-link:hover [data-lucide] { opacity: 1; }
        
        .sidebar-nav .nav-link.active {
            color: var(--sidebar-active-text);
            background: var(--sidebar-active-bg);
            font-weight: 600;
        }
        .sidebar-nav .nav-link.active [data-lucide] {
            opacity: 1; stroke: var(--sidebar-active-text);
        }
        
        .sidebar-footer { 
            margin-top: auto; padding: 1.25rem 1.5rem; 
            border-top: 1px solid var(--bs-border-color, #f1f5f9); 
        }
        .logout-link {
            display: flex; align-items: center; gap: .85rem;
            color: var(--sidebar-text); font-weight: 500; font-size: .9rem;
            text-decoration: none; padding: .5rem 0; transition: color .2s;
            background: transparent; border: none; width: 100%; text-align: left; cursor: pointer;
        }
        .logout-link:hover { color: #ef4444; }
        .logout-link [data-lucide] { width: 20px; height: 20px; stroke-width: 2; opacity: .7; }
        .logout-link:hover [data-lucide] { opacity: 1; stroke: #ef4444; }

        #main-content { margin-left: var(--sidebar-width); min-height: 100vh; transition: margin .3s ease; display: flex; flex-direction: column; }
        #topbar {
            height: var(--topbar-height); background: var(--bs-body-bg, #fff);
            border-bottom: 1px solid var(--bs-border-color, #e2e8f0);
            display: flex; align-items: center; padding: 0 1.5rem; gap: 1rem;
            position: sticky; top: 0; z-index: 100; backdrop-filter: blur(8px);
        }
        [data-bs-theme="dark"] #topbar { background: rgba(15,23,42,.8); }
        .topbar-title { font-weight: 600; font-size: 1rem; margin: 0; }
        .topbar-right { margin-left: auto; display: flex; align-items: center; gap: .75rem; }
        #darkModeToggle {
            width: 38px; height: 38px; border-radius: 12px;
            border: 1px solid var(--bs-border-color, #e2e8f0);
            background: transparent; display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--bs-body-color); transition: all .2s;
        }
        #darkModeToggle:hover { background: var(--bs-secondary-bg); }
        
        /* Dark Mode Toggle Icons */
        #darkModeToggle .icon-sun { display: none; }
        [data-bs-theme="dark"] #darkModeToggle .icon-moon { display: none; }
        [data-bs-theme="dark"] #darkModeToggle .icon-sun { display: inline-block; }
        .page-content { padding: 1.75rem; flex: 1; }
        .stat-card { border-radius: 16px; border: none; box-shadow: var(--card-shadow); overflow: hidden; transition: transform .2s, box-shadow .2s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }
        .stat-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; }
        .badge-gender-male   { background: #dbeafe; color: #1d4ed8; }
        .badge-gender-female { background: #fce7f3; color: #be185d; }
        .badge-gender-other  { background: #f3f4f6; color: #374151; }
        .table th { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #64748b; white-space: nowrap; }
        .avatar-sm { width: 36px; height: 36px; border-radius: 10px; object-fit: cover; }
        .card { border-radius: 16px; border: 1px solid var(--bs-border-color, #e2e8f0); box-shadow: var(--card-shadow); }
        .btn-accent { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; border: none; }
        .btn-accent:hover { background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #fff; }
        #sidebarOverlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1040; }
        @media (max-width: 991.98px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #sidebarOverlay.show { display: block; }
            #main-content { margin-left: 0; }
        }
        .alert { animation: slideDown .3s ease; }
        @keyframes slideDown { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }
        .page-content { animation: fadeIn .25s ease; }
        @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

        /* Bookshelf Loader */
        .page-loader {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background-color: var(--bs-body-bg, #ffffff);
            z-index: 9999; display: flex; justify-content: center; align-items: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        .page-loader.hidden { opacity: 0; visibility: hidden; }
        .bookshelf_wrapper { position: relative; top: -20px; width: 300px; margin: 0 auto; }
        .books_list { margin: 0 auto; width: 300px; padding: 0; }
        .book_item {
            position: absolute; top: -120px; box-sizing: border-box; list-style: none;
            width: 40px; height: 120px; opacity: 0; background-color: var(--accent, #8b5cf6);
            border: 5px solid white; transform-origin: bottom left;
            transform: translateX(300px); animation: travel 2500ms linear infinite;
        }
        [data-bs-theme="dark"] .book_item { border-color: #0f172a; }
        .book_item.first { top: -140px; height: 140px; }
        .book_item.first:before, .book_item.first:after {
            content: ''; position: absolute; top: 10px; left: 0; width: 100%; height: 5px; background-color: white;
        }
        [data-bs-theme="dark"] .book_item.first:before, [data-bs-theme="dark"] .book_item.first:after { background-color: #0f172a; }
        .book_item.first:after { top: initial; bottom: 10px; }
        .book_item.second:before, .book_item.second:after, .book_item.fifth:before, .book_item.fifth:after {
            box-sizing: border-box; content: ''; position: absolute; top: 10px; left: 0; width: 100%; height: 17.5px;
            border-top: 5px solid white; border-bottom: 5px solid white;
        }
        [data-bs-theme="dark"] .book_item.second:before, [data-bs-theme="dark"] .book_item.second:after,
        [data-bs-theme="dark"] .book_item.fifth:before, [data-bs-theme="dark"] .book_item.fifth:after { border-color: #0f172a; }
        .book_item.second:after, .book_item.fifth:after { top: initial; bottom: 10px; }
        .book_item.third:before, .book_item.third:after {
            box-sizing: border-box; content: ''; position: absolute; top: 10px; left: 9px; width: 12px; height: 12px;
            border-radius: 50%; border: 5px solid white;
        }
        [data-bs-theme="dark"] .book_item.third:before, [data-bs-theme="dark"] .book_item.third:after { border-color: #0f172a; }
        .book_item.third:after { top: initial; bottom: 10px; }
        .book_item.fourth { top: -130px; height: 130px; }
        .book_item.fourth:before {
            box-sizing: border-box; content: ''; position: absolute; top: 46px; left: 0; width: 100%; height: 17.5px;
            border-top: 5px solid white; border-bottom: 5px solid white;
        }
        [data-bs-theme="dark"] .book_item.fourth:before { border-color: #0f172a; }
        .book_item.fifth { top: -100px; height: 100px; }
        .book_item.sixth { top: -140px; height: 140px; }
        .book_item.sixth:before {
            box-sizing: border-box; content: ''; position: absolute; bottom: 31px; left: 0px; width: 100%; height: 5px; background-color: white;
        }
        [data-bs-theme="dark"] .book_item.sixth:before { background-color: #0f172a; }
        .book_item.sixth:after {
            box-sizing: border-box; content: ''; position: absolute; bottom: 10px; left: 9px; width: 12px; height: 12px;
            border-radius: 50%; border: 5px solid white;
        }
        [data-bs-theme="dark"] .book_item.sixth:after { border-color: #0f172a; }
        .book_item:nth-child(2) { animation-delay: 416ms; }
        .book_item:nth-child(3) { animation-delay: 833ms; }
        .book_item:nth-child(4) { animation-delay: 1250ms; }
        .book_item:nth-child(5) { animation-delay: 1666ms; }
        .book_item:nth-child(6) { animation-delay: 2083ms; }
        .shelf { width: 300px; height: 5px; margin: 0 auto; background-color: white; position: absolute; }
        [data-bs-theme="dark"] .shelf { background-color: #0f172a; }
        .shelf:before, .shelf:after {
            content: ''; position: absolute; width: 100%; height: 100%; background: var(--accent, #8b5cf6);
            background-image: radial-gradient(rgba(255, 255, 255, 0.5) 30%, transparent 0); background-size: 10px 10px;
            background-position: 0 -2.5px; top: 200%; left: 5%; animation: move 250ms linear infinite;
        }
        [data-bs-theme="dark"] .shelf:before, [data-bs-theme="dark"] .shelf:after { background-image: radial-gradient(rgba(255, 255, 255, 0.1) 30%, transparent 0); }
        .shelf:after { top: 400%; left: 7.5%; }
        @keyframes move { from { background-position-x: 0; } to { background-position-x: 10px; } }
        @keyframes travel {
            0% { opacity: 0; transform: translateX(300px) rotateZ(0deg) scaleY(1); }
            6.5% { transform: translateX(279.5px) rotateZ(0deg) scaleY(1.1); }
            8.8% { transform: translateX(273.6px) rotateZ(0deg) scaleY(1); }
            10% { opacity: 1; transform: translateX(270px) rotateZ(0deg); }
            17.6% { transform: translateX(247.2px) rotateZ(-30deg); }
            45% { transform: translateX(165px) rotateZ(-30deg); }
            49.5% { transform: translateX(151.5px) rotateZ(-45deg); }
            61.5% { transform: translateX(115.5px) rotateZ(-45deg); }
            67% { transform: translateX(99px) rotateZ(-60deg); }
            76% { transform: translateX(72px) rotateZ(-60deg); }
            83.5% { opacity: 1; transform: translateX(49.5px) rotateZ(-90deg); }
            90% { opacity: 0; }
            100% { opacity: 0; transform: translateX(0px) rotateZ(-90deg); }
        }
    </style>
    @stack('styles')
</head>
<body>
<!-- Bookshelf Loader -->
<div id="page-loader" class="page-loader">
    <div class="bookshelf_wrapper">
        <ul class="books_list">
            <li class="book_item first"></li>
            <li class="book_item second"></li>
            <li class="book_item third"></li>
            <li class="book_item fourth"></li>
            <li class="book_item fifth"></li>
            <li class="book_item sixth"></li>
        </ul>
        <div class="shelf"></div>
    </div>
</div>

<div id="sidebarOverlay"></div>

<nav id="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <div class="brand-icon"><i data-lucide="package" style="width:22px;height:22px;stroke:#fff;"></i></div>
        <div>
            <div class="brand-text">SMS System</div>
        </div>
    </a>
    <div class="sidebar-nav mt-1">
        <div class="nav-label">ទូទៅ</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i data-lucide="layout-dashboard"></i> Dashboard
        </a>
        <div class="nav-label mt-2">ការគ្រប់គ្រង</div>
        <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
            <i data-lucide="users"></i> សិស្ស
        </a>
        <a href="{{ route('teachers.index') }}" class="nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
            <i data-lucide="user-cog"></i> គ្រូ
        </a>
        <a href="{{ route('courses.index') }}" class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
            <i data-lucide="book-open"></i> មុខវិជ្ជា
        </a>
        <a href="{{ route('classes.index') }}" class="nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
            <i data-lucide="building-2"></i> ថ្នាក់រៀន
        </a>
    </div>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="logout-link">
                <i data-lucide="log-out"></i> Log Out
            </button>
        </form>
    </div>
</nav>

<div id="main-content">
    <div id="topbar">
        <button class="btn btn-sm border d-lg-none" id="sidebarToggle">
            <i data-lucide="menu" class="lucide-md"></i>
        </button>
        <h6 class="topbar-title d-none d-md-block">@yield('page-title', 'Dashboard')</h6>
        <div class="topbar-right">
            <button id="darkModeToggle" title="Toggle Theme">
                <i data-lucide="moon" class="icon-moon"></i>
                <i data-lucide="sun" class="icon-sun"></i>
            </button>
            <div class="dropdown">
                <button class="btn btn-sm border dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <span style="width:28px;height:28px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:7px;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.75rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <span class="d-none d-md-inline" style="font-size:.85rem;">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">{{ auth()->user()->email }}</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                <i data-lucide="log-out" class="lucide-sm me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i data-lucide="check-circle" class="lucide-md"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i data-lucide="alert-triangle" class="lucide-md"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lucide@0.511.0/dist/umd/lucide.min.js"></script>
<script>
// Dark Mode
const htmlRoot   = document.getElementById('htmlRoot');
const darkToggle = document.getElementById('darkModeToggle');

function applyTheme(theme) {
    htmlRoot.setAttribute('data-bs-theme', theme);
    localStorage.setItem('sms_theme', theme);
}
applyTheme(localStorage.getItem('sms_theme') || 'light');
darkToggle.addEventListener('click', () => {
    applyTheme(htmlRoot.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark');
});

// Mobile Sidebar
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');
document.getElementById('sidebarToggle')?.addEventListener('click', () => {
    sidebar.classList.toggle('show'); overlay.classList.toggle('show');
});
overlay.addEventListener('click', () => {
    sidebar.classList.remove('show'); overlay.classList.remove('show');
});

// Auto-dismiss alerts
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => bootstrap.Alert.getOrCreateInstance(el).close());
}, 4000);

// Hide Loader
window.addEventListener('load', () => {
    const loader = document.getElementById('page-loader');
    if(loader) {
        // Small delay to ensure the animation is visible briefly
        setTimeout(() => { loader.classList.add('hidden'); }, 300);
    }
});
</script>
@stack('scripts')
<script>
// Init Lucide AFTER all content and stacked scripts are in the DOM
lucide.createIcons();
</script>
</body>
</html>
