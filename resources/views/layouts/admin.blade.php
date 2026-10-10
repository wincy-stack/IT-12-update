<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aqua De Smiley Admin Portal – Manage products, prices, and financial reports.">
    <title>@yield('title', 'Admin Portal – Aqua De Smiley')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:      #0284c7;
            --primary-dk:   #0369a1;
            --accent:       #0284c7;
            --admin-purple: #0369a1;
            --admin-light:  #38bdf8;
            --light-blue:   #e0f2fe;
            --light-blue-bg:#f8fafc;
            --border-color: #cbd5e1;
            --body-bg:      #eef2f6;
            --sidebar-bg:   #0f172a;
            --sidebar-w:    260px;
            --topbar-h:     64px;
            --card-bg:      #ffffff;
            --text:         #0f172a;
            --text-muted:   #64748b;
            --success:      #10b981;
            --warning:      #f59e0b;
            --danger:       #ef4444;
        }

        html, body { height: 100%; }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--body-bg);
            color: var(--text);
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* ─── TOP BAR ─────────────────────────────────────────────── */
        .topbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 200;
            height: var(--topbar-h);
            background: #0f172a;
            border-bottom: 1px solid #1e293b;
            display: flex; align-items: center; padding: 0 1.5rem;
            gap: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .topbar__hamburger {
            display: none;
            background: none; border: none; color: #cbd5e1;
            font-size: 1.25rem; cursor: pointer; padding: .3rem .5rem;
        }
        .topbar__brand {
            display: flex; align-items: center; gap: .7rem;
            font-size: 1.15rem; font-weight: 800;
            text-decoration: none;
            color: #ffffff;
            min-width: calc(var(--sidebar-w) - 3rem);
        }
        .topbar__brand i { color: #38bdf8; font-size: 1.35rem; }
        .topbar__portal-pill {
            font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
            padding: .15rem .5rem; border-radius: 99px;
            background: rgba(2,132,199,0.25); color: #38bdf8; border: 1px solid rgba(56,189,248,0.3);
        }
        .topbar__spacer { flex: 1; }
        .topbar__right { display: flex; align-items: center; gap: 1rem; }
        .role-chip {
            padding: .2rem .75rem; border-radius: 99px; font-size: .75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .06em;
            background: rgba(2,132,199,0.25); color: #38bdf8; border: 1px solid rgba(56,189,248,0.3);
        }
        .topbar__user { font-size: .85rem; color: #e2e8f0; font-weight: 600; display: flex; align-items: center; gap: .4rem; }
        .btn-logout {
            display: flex; align-items: center; gap: .35rem;
            padding: .35rem .95rem; border-radius: 8px;
            border: 1px solid #7f1d1d; background: #450a0a;
            color: #fca5a5; font-size: .78rem; font-weight: 600; cursor: pointer;
            transition: all .2s; text-decoration: none; font-family: 'Outfit', sans-serif;
        }
        .btn-logout:hover { background: #7f1d1d; color: #fff; }

        /* ─── SIDEBAR ──────────────────────────────────────────────── */
        .sidebar {
            position: fixed; top: var(--topbar-h); left: 0; bottom: 0;
            width: var(--sidebar-w); z-index: 150;
            background: var(--sidebar-bg);
            border-right: 1px solid #1e293b;
            display: flex; flex-direction: column;
            overflow-y: auto;
            transition: transform .3s ease;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: #334155; border-radius: 99px; }

        .sidebar__section-label {
            padding: 1.25rem 1.25rem .4rem;
            font-size: .68rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .1em; color: #64748b;
        }
        .sidebar__nav { list-style: none; padding: 0 .6rem; }
        .sidebar__nav li { margin-bottom: .2rem; }
        .sidebar__link {
            display: flex; align-items: center; gap: .75rem;
            padding: .65rem .85rem; border-radius: 10px;
            color: #cbd5e1; text-decoration: none;
            font-size: .88rem; font-weight: 500;
            transition: all .2s ease;
        }
        .sidebar__link i { font-size: 1rem; width: 20px; text-align: center; color: #64748b; transition: color .2s; }
        .sidebar__link:hover {
            background: #1e293b;
            color: #ffffff;
        }
        .sidebar__link:hover i { color: #38bdf8; }
        .sidebar__link.active {
            background: #0284c7;
            color: #ffffff; font-weight: 700;
            border: none;
            box-shadow: 0 2px 8px rgba(2,132,199,0.35);
        }
        .sidebar__link.active i { color: #ffffff; }
        .sidebar__badge {
            margin-left: auto; padding: .15rem .5rem; border-radius: 99px;
            font-size: .72rem; font-weight: 700; background: rgba(255,255,255,0.2); color: #ffffff;
        }

        .sidebar__footer {
            margin-top: auto; padding: 1.2rem;
            border-top: 1px solid #1e293b;
            font-size: .75rem; color: #64748b;
        }

        /* ─── MAIN CONTENT ─────────────────────────────────────────── */
        .main-content {
            margin-top: var(--topbar-h);
            margin-left: var(--sidebar-w);
            padding: 2rem;
            flex: 1;
            min-height: calc(100vh - var(--topbar-h));
            background: var(--body-bg);
        }

        /* ─── PAGE HEADER ─────────────────────────────────────────── */
        .page-header { margin-bottom: 1.75rem; }
        .page-header h1 {
            font-size: 1.65rem; font-weight: 800; display: flex; align-items: center; gap: .6rem;
            letter-spacing: -.02em; color: var(--text);
        }
        .page-header p { color: var(--text-muted); font-size: .88rem; margin-top: .3rem; }

        /* ─── CARDS ─────────────────────────────────────────────────── */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 16px rgba(2,132,199,0.03);
        }
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.35rem 1.5rem;
            display: flex; align-items: center; gap: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(2,132,199,0.08); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: grid; place-items: center; font-size: 1.45rem; flex-shrink: 0;
        }
        .stat-icon--purple { background: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; }
        .stat-icon--blue   { background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; }
        .stat-icon--green  { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .stat-icon--amber  { background: #fef3c7; color: #b45309; border: 1px solid #fcd34d; }
        .stat-icon--rose   { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
        .stat-value { font-size: 1.75rem; font-weight: 800; line-height: 1.1; color: var(--text); }
        .stat-label { color: var(--text-muted); font-size: .8rem; font-weight: 500; margin-top: .25rem; }

        /* ─── BUTTONS ───────────────────────────────────────────────── */
        .btn {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .6rem 1.25rem; border-radius: 10px; font-size: .875rem; font-weight: 600;
            cursor: pointer; text-decoration: none; transition: all .2s; border: none;
            font-family: 'Outfit', sans-serif;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dk));
            color: #fff; box-shadow: 0 2px 8px rgba(2,132,199,.2);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(2,132,199,.25); color: #fff; }
        .btn-cyan {
            background: linear-gradient(135deg, var(--primary), var(--primary-dk));
            color: #fff; box-shadow: 0 2px 8px rgba(2,132,199,.2);
        }
        .btn-cyan:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(2,132,199,.25); color: #fff; }
        .btn-outline {
            background: #ffffff; border: 1px solid #cbd5e1;
            color: var(--text);
        }
        .btn-outline:hover { background: #f1f5f9; border-color: #94a3b8; }
        .btn-sm { padding: .35rem .75rem; font-size: .78rem; border-radius: 7px; }

        /* ─── FORMS & INPUTS ────────────────────────────────────────── */
        .form-group { margin-bottom: 1.2rem; }
        .form-label { display: block; font-size: .83rem; font-weight: 600; color: #334155; margin-bottom: .4rem; }
        .form-input, .form-select, .form-textarea {
            width: 100%; padding: .65rem .95rem; border-radius: 10px;
            background: #ffffff; border: 1px solid #cbd5e1;
            color: var(--text); font-family: 'Outfit', sans-serif; font-size: .9rem;
            transition: all .2s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(2,132,199,.15);
        }
        .form-select option { background: #ffffff; color: var(--text); }
        .form-error { color: #dc2626; font-size: .8rem; margin-top: .3rem; display: flex; align-items: center; gap: .35rem; }

        /* ─── TABLES ────────────────────────────────────────────────── */
        .table-wrapper { overflow-x: auto; border-radius: 14px; border: 1px solid var(--border-color); background: var(--card-bg); }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        thead tr { background: var(--light-blue-bg); border-bottom: 1px solid var(--border-color); }
        th {
            padding: .9rem 1.15rem; font-size: .78rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .06em; color: #475569;
        }
        td { padding: .85rem 1.15rem; border-top: 1px solid var(--border-color); font-size: .88rem; color: var(--text); }
        tr:hover td { background: #f8fafc; }

        /* ─── BADGES ────────────────────────────────────────────────── */
        .badge {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .22rem .65rem; border-radius: 99px;
            font-size: .74rem; font-weight: 700;
        }
        .badge--success { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .badge--warning { background: #fef3c7; color: #b45309; border: 1px solid #fcd34d; }
        .badge--danger  { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
        .badge--info    { background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; }
        .badge--purple  { background: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; }

        /* ─── ALERTS ────────────────────────────────────────────────── */
        .alert {
            padding: .9rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem;
            font-size: .9rem; display: flex; align-items: center; gap: .75rem;
        }
        .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #15803d; }
        .alert-error   { background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; }

        /* ─── BACKDROP & MOBILE ─────────────────────────────────────── */
        .sidebar-backdrop {
            display: none; position: fixed; inset: 0;
            background: rgba(15,23,42,0.4); z-index: 140;
        }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-backdrop.open { display: block; }
            .main-content { margin-left: 0; padding: 1.25rem; }
            .topbar__hamburger { display: block; }
        }

        /* ─── PRINT OPTIMIZATIONS ──────────────────────────────────── */
        @media print {
            .topbar, .sidebar, .btn, .filter-bar, form { display: none !important; }
            .main-content { margin: 0 !important; padding: 0 !important; background: #fff !important; color: #000 !important; }
            .card { border: 1px solid #ccc !important; box-shadow: none !important; background: #fff !important; color: #000 !important; }
            table { color: #000 !important; }
            th { color: #000 !important; border-bottom: 2px solid #000 !important; background: #eee !important; }
            td { color: #000 !important; border-top: 1px solid #ddd !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- TOPBAR -->
<header class="topbar">
    <button class="topbar__hamburger" id="sidebarToggle" aria-label="Toggle Navigation">
        <i class="fa-solid fa-bars"></i>
    </button>
    <a href="{{ route('admin.dashboard') }}" class="topbar__brand">
        <i class="fa-solid fa-droplet"></i>
        <span>Aqua De Smiley</span>
        <span class="topbar__portal-pill"><i class="fa-solid fa-shield-halved"></i> Admin</span>
    </a>

    <div class="topbar__spacer"></div>

    <div class="topbar__right">
        <span class="topbar__user">
            <i class="fa-solid fa-circle-user" style="color:var(--admin-light)"></i>
            {{ auth()->user()->name }}
        </span>
        <span class="role-chip">Executive Admin</span>
        <form action="{{ route('logout') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</header>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <span class="sidebar__section-label">Management</span>
    <ul class="sidebar__nav">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="sidebar__link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.products.index') }}" class="sidebar__link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Products & Prices
            </a>
        </li>
    </ul>

    <span class="sidebar__section-label">Financial Reports</span>
    <ul class="sidebar__nav">
        <li>
            <a href="{{ route('admin.reports.sales') }}" class="sidebar__link {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Sales Report
            </a>
        </li>
        <li>
            <a href="{{ route('admin.reports.income') }}" class="sidebar__link {{ request()->routeIs('admin.reports.income') ? 'active' : '' }}">
                <i class="fa-solid fa-coins"></i> Income & Profit
            </a>
        </li>
    </ul>

    <span class="sidebar__section-label">Station Operations</span>
    <ul class="sidebar__nav">
        <li>
            <a href="{{ route('staff.orders.index') }}" class="sidebar__link" target="_blank">
                <i class="fa-solid fa-receipt"></i> Orders Tracking <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:.7rem;margin-left:auto;color:#64748b;"></i>
            </a>
        </li>
        <li>
            <a href="{{ route('staff.payments.index') }}" class="sidebar__link" target="_blank">
                <i class="fa-solid fa-cash-register"></i> Walk-in POS <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:.7rem;margin-left:auto;color:#64748b;"></i>
            </a>
        </li>
        <li>
            <a href="{{ route('staff.supplies.index') }}" class="sidebar__link" target="_blank">
                <i class="fa-solid fa-warehouse"></i> Supplies & Stock <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:.7rem;margin-left:auto;color:#64748b;"></i>
            </a>
        </li>
        <li>
            <a href="{{ route('staff.customers.index') }}" class="sidebar__link" target="_blank">
                <i class="fa-solid fa-users"></i> Customers <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:.7rem;margin-left:auto;color:#64748b;"></i>
            </a>
        </li>
    </ul>

    <div class="sidebar__footer">
        <div style="font-weight:600;color:var(--text);margin-bottom:.2rem;">Aqua De Smiley Station</div>
        <div>System Version 2.2 • Admin Suite</div>
    </div>
</aside>

<!-- MAIN CONTENT -->
<main class="main-content">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @yield('content')
</main>

<script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebarBackdrop');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            backdrop.classList.toggle('open');
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', () => {
            sidebar.classList.remove('open');
            backdrop.classList.remove('open');
        });
    }
</script>

@stack('scripts')
</body>
</html>
