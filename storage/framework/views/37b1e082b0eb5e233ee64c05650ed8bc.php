<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aqua De Smiley Staff Portal – Manage orders, customers and supplies.">
    <title><?php echo $__env->yieldContent('title', 'Staff Portal – Aqua De Smiley'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:      #0284c7;
            --primary-dk:   #0369a1;
            --accent:       #0284c7;
            --light-blue:   #e0f2fe;
            --light-blue-bg:#f8fafc;
            --border-color: #cbd5e1;
            --body-bg:      #eef2f6;
            --sidebar-bg:   #0f172a;
            --sidebar-w:    255px;
            --topbar-h:     62px;
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
            display: none; /* shown on mobile */
            background: none; border: none; color: #cbd5e1;
            font-size: 1.2rem; cursor: pointer; padding: .3rem .5rem;
        }
        .topbar__brand {
            display: flex; align-items: center; gap: .6rem;
            font-size: 1.1rem; font-weight: 800;
            text-decoration: none;
            color: #ffffff;
            min-width: calc(var(--sidebar-w) - 3rem);
        }
        .topbar__brand i { color: #38bdf8; font-size: 1.25rem; }
        .topbar__spacer { flex: 1; }
        .topbar__right { display: flex; align-items: center; gap: .85rem; }
        .role-chip {
            padding: .2rem .65rem; border-radius: 99px; font-size: .72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .06em;
            background: rgba(2,132,199,0.25); color: #38bdf8; border: 1px solid rgba(56,189,248,0.3);
        }
        .topbar__user { font-size: .85rem; color: #e2e8f0; font-weight: 600; display:flex;align-items:center;gap:.4rem; }
        .btn-logout {
            display: flex; align-items: center; gap: .35rem;
            padding: .35rem .9rem; border-radius: 8px;
            border: 1px solid #7f1d1d; background: #450a0a;
            color: #fca5a5; font-size: .78rem; font-weight: 600; cursor: pointer;
            transition: all .2s; text-decoration: none; font-family: 'Outfit',sans-serif;
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

        .nav-item {
            display: flex; align-items: center; gap: .75rem;
            padding: .65rem 1.25rem; margin: .15rem .6rem;
            border-radius: 10px; text-decoration: none;
            color: #cbd5e1; font-size: .875rem; font-weight: 500;
            transition: all .2s; position: relative;
        }
        .nav-item i { width: 18px; text-align: center; font-size: .95rem; flex-shrink: 0; color: #64748b; }
        .nav-item:hover { background: #1e293b; color: #ffffff; }
        .nav-item:hover i { color: #38bdf8; }
        .nav-item.active {
            background: #0284c7;
            color: #ffffff; font-weight: 700;
            border: none;
            box-shadow: 0 2px 8px rgba(2,132,199,0.35);
        }
        .nav-item.active i { color: #ffffff; }
        .nav-item .badge {
            margin-left: auto; padding: .15rem .5rem; border-radius: 99px;
            font-size: .65rem; font-weight: 700;
            background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5;
        }
        .nav-item .badge-blue {
            margin-left: auto; padding: .15rem .5rem; border-radius: 99px;
            font-size: .65rem; font-weight: 700;
            background: rgba(255,255,255,0.2); color: #ffffff;
        }

        /* Sidebar footer */
        .sidebar__footer {
            margin-top: auto; padding: 1rem;
            border-top: 1px solid #1e293b;
        }
        .sidebar__profile {
            display: flex; align-items: center; gap: .75rem;
            padding: .65rem .75rem; border-radius: 10px;
            background: #1e293b; border: 1px solid #334155;
        }
        .sidebar__avatar {
            width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, var(--primary), var(--primary-dk));
            color: #ffffff;
            display: grid; place-items: center; font-weight: 700; font-size: .85rem;
        }
        .sidebar__name { font-size: .85rem; font-weight: 700; line-height: 1.2; color: #ffffff; }
        .sidebar__email { font-size: .72rem; color: #94a3b8; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 130px; }

        /* ─── MAIN CONTENT AREA ────────────────────────────────────── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            margin-top: var(--topbar-h);
            min-height: calc(100vh - var(--topbar-h));
            padding: 2rem;
            background: var(--body-bg);
        }

        /* ─── PAGE HEADER ──────────────────────────────────────────── */
        .page-header { margin-bottom: 1.75rem; }
        .page-header h1 { font-size: 1.6rem; font-weight: 800; display:flex;align-items:center;gap:.6rem; color: var(--text); }
        .page-header p { color: var(--text-muted); margin-top: .25rem; font-size: .9rem; }

        /* ─── STAT CARDS ───────────────────────────────────────────── */
        .card-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.75rem; }
        .stat-card {
            background: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: 14px; padding: 1.25rem 1.35rem;
            display: flex; align-items: center; gap: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(2,132,199,0.08); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display:grid;place-items:center; font-size:1.3rem; flex-shrink:0; }
        .si-blue   { background:#e0f2fe; color:#0284c7; }
        .si-green  { background:#dcfce7; color:#15803d; }
        .si-amber  { background:#fef3c7; color:#b45309; }
        .si-purple { background:#f3e8ff; color:#7e22ce; }
        .si-red    { background:#fee2e2; color:#dc2626; }
        .stat-value { font-size: 1.6rem; font-weight: 800; line-height:1; color: var(--text); }
        .stat-label { color: var(--text-muted); font-size: .78rem; font-weight: 500; margin-top:.15rem; }

        /* ─── CARDS ────────────────────────────────────────────────── */
        .card {
            background: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: 14px; padding: 1.35rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(2,132,199,0.03);
            color: var(--text);
        }
        .card + .card { margin-top: 1.25rem; }
        .card-header { display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:.75rem; }
        .card-title { font-size:1rem;font-weight:700;display:flex;align-items:center;gap:.5rem; color: var(--text); }

        /* ─── TABLE ────────────────────────────────────────────────── */
        .table-wrap { overflow-x:auto;border-radius:10px;border:1px solid var(--border-color); background: var(--card-bg); }
        table { width:100%;border-collapse:collapse; }
        thead tr { background:var(--light-blue-bg); }
        th { padding:.75rem 1.1rem;text-align:left;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-muted); }
        td { padding:.8rem 1.1rem;border-top:1px solid var(--border-color);font-size:.875rem; color: var(--text); }
        tr:hover td { background:#f8fafc; }

        /* ─── STATUS BADGES ────────────────────────────────────────── */
        .status-badge {
            display:inline-flex;align-items:center;gap:.35rem;
            padding:.22rem .75rem;border-radius:99px;font-size:.72rem;font-weight:700;
        }

        /* ─── BUTTONS ──────────────────────────────────────────────── */
        .btn { display:inline-flex;align-items:center;gap:.45rem;padding:.55rem 1.2rem;border-radius:9px;font-size:.85rem;font-weight:600;cursor:pointer;text-decoration:none;transition:all .2s;border:none;font-family:'Outfit',sans-serif; }
        .btn-primary { background:linear-gradient(135deg,var(--primary),var(--primary-dk));color:#fff;box-shadow:0 2px 8px rgba(2,132,199,.2); }
        .btn-primary:hover { transform:translateY(-1px);box-shadow:0 4px 14px rgba(2,132,199,.25); color:#fff; }
        .btn-sm { padding:.35rem .85rem;font-size:.78rem; }
        .btn-outline { background:#ffffff;border:1px solid #cbd5e1;color:var(--text); }
        .btn-outline:hover { background:#f1f5f9; border-color: #94a3b8; }
        .btn-ghost { background:transparent;color:var(--text-muted);padding:.3rem .6rem;font-size:.8rem; }
        .btn-ghost:hover { color:var(--text); }
        .btn-danger { background:#fef2f2;border:1px solid #fecaca;color:#dc2626; }
        .btn-danger:hover { background:#fee2e2; }

        /* ─── FORM ─────────────────────────────────────────────────── */
        .form-row { display:grid;gap:1.1rem;margin-bottom:1.1rem; }
        .form-row-2 { grid-template-columns:1fr 1fr; }
        .form-row-3 { grid-template-columns:1fr 1fr 1fr; }
        .form-group { display:flex;flex-direction:column;gap:.35rem; }
        .form-label { font-size:.8rem;font-weight:600;color:#334155;text-transform:uppercase;letter-spacing:.04em; }
        .form-input,.form-select,.form-textarea {
            width:100%;padding:.65rem .9rem;border-radius:9px;
            background:#ffffff;border:1px solid #cbd5e1;
            color:var(--text);font-family:'Outfit',sans-serif;font-size:.875rem;
            transition:border-color .2s,box-shadow .2s;
        }
        .form-input:focus,.form-select:focus,.form-textarea:focus {
            outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(2,132,199,.15);
        }
        .form-input::placeholder,.form-textarea::placeholder { color:#94a3b8; }
        .form-select option { background:#ffffff; color: var(--text); }
        .form-textarea { resize:vertical;min-height:80px; }
        .form-error { color:#dc2626;font-size:.78rem;display:flex;align-items:center;gap:.3rem; }

        /* ─── ALERTS ───────────────────────────────────────────────── */
        .alert { padding:.85rem 1.1rem;border-radius:10px;margin-bottom:1.1rem;font-size:.875rem;display:flex;align-items:center;gap:.65rem; }
        .alert-success { background:#dcfce7;border:1px solid #86efac;color:#15803d; }
        .alert-error   { background:#fee2e2;border:1px solid #fca5a5;color:#b91c1c; }
        .alert-warning  { background:#fef3c7;border:1px solid #fcd34d;color:#b45309; }

        /* ─── LOW STOCK PILL ───────────────────────────────────────── */
        .low-stock { color:#dc2626;display:flex;align-items:center;gap:.3rem; }
        .ok-stock  { color:#15803d; }

        /* ─── MOBILE ───────────────────────────────────────────────── */
        .sidebar-overlay { display:none;position:fixed;inset:0;background:rgba(15,23,42,.4);z-index:140; }

        @media (max-width: 768px) {
            .topbar__hamburger { display:block; }
            .topbar__brand { min-width: unset; }
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display:block; }
            .main-wrap { margin-left:0;padding:1.25rem; }
            .form-row-2,.form-row-3 { grid-template-columns:1fr; }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<!-- Sidebar overlay for mobile -->
<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

<!-- ── TOP BAR ── -->
<header class="topbar">
    <button class="topbar__hamburger" id="hamburger-btn" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </button>
    <a href="<?php echo e(route('staff.dashboard')); ?>" class="topbar__brand">
        <i class="fa-solid fa-droplet"></i> Aqua De Smiley
    </a>
    <div class="topbar__spacer"></div>
    <div class="topbar__right">
        <span class="role-chip">Staff</span>
        <span class="topbar__user">
            <i class="fa-regular fa-user"></i>
            <?php echo e(auth()->user()?->name ?? 'Staff'); ?>

        </span>
        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
        </form>
    </div>
</header>

<!-- ── SIDEBAR ── -->
<aside class="sidebar" id="sidebar">

    <div class="sidebar__section-label">Main Menu</div>

    <a href="<?php echo e(route('staff.dashboard')); ?>"
       class="nav-item <?php echo e(request()->routeIs('staff.dashboard') ? 'active' : ''); ?>">
        <i class="fa-solid fa-gauge-high"></i>
        Dashboard
    </a>

    <a href="<?php echo e(route('staff.orders.create')); ?>"
       class="nav-item <?php echo e(request()->routeIs('staff.orders.create') ? 'active' : ''); ?>">
        <i class="fa-solid fa-circle-plus"></i>
        New Order
    </a>

    <a href="<?php echo e(route('staff.orders.index')); ?>"
       class="nav-item <?php echo e(request()->routeIs('staff.orders.*') && !request()->routeIs('staff.orders.create') ? 'active' : ''); ?>">
        <i class="fa-solid fa-clipboard-list"></i>
        Order Tracking
        <?php $pendingCount = \App\Models\Order::whereIn('status',['pending','confirmed'])->count(); ?>
        <?php if($pendingCount > 0): ?>
            <span class="badge-blue"><?php echo e($pendingCount); ?></span>
        <?php endif; ?>
    </a>

    <a href="<?php echo e(route('staff.payments.index')); ?>"
       class="nav-item <?php echo e(request()->routeIs('staff.payments.*') ? 'active' : ''); ?>">
        <i class="fa-solid fa-cash-register"></i>
        Payment Process
        <?php $awaitingCount = \App\Models\Order::where('status', '!=', 'cancelled')->where(fn($q) => $q->where('payment_status', 'unpaid')->orWhere('status', '!=', 'completed')->orWhereNull('released_at'))->count(); ?>
        <?php if($awaitingCount > 0): ?>
            <span class="badge" style="background:#0284c7;color:#fff;font-weight:700;"><?php echo e($awaitingCount); ?></span>
        <?php endif; ?>
    </a>

    <a href="<?php echo e(route('staff.customers.index')); ?>"
       class="nav-item <?php echo e(request()->routeIs('staff.customers.*') ? 'active' : ''); ?>">
        <i class="fa-solid fa-users"></i>
        Customers
    </a>

    <a href="<?php echo e(route('staff.supplies.index')); ?>"
       class="nav-item <?php echo e(request()->routeIs('staff.supplies.*') ? 'active' : ''); ?>">
        <i class="fa-solid fa-boxes-stacked"></i>
        Supplies &amp; Stock
        <?php $lowStockCount = \App\Models\Supply::whereColumn('quantity','<=','minimum_stock')->count(); ?>
        <?php if($lowStockCount > 0): ?>
            <span class="badge"><?php echo e($lowStockCount); ?></span>
        <?php endif; ?>
    </a>

    <!-- Profile footer -->
    <div class="sidebar__footer">
        <div class="sidebar__profile">
            <div class="sidebar__avatar"><?php echo e(strtoupper(substr(auth()->user()?->name ?? 'S',0,1))); ?></div>
            <div>
                <div class="sidebar__name"><?php echo e(auth()->user()?->name ?? 'Staff'); ?></div>
                <div class="sidebar__email"><?php echo e(auth()->user()?->email ?? ''); ?></div>
            </div>
        </div>
    </div>
</aside>

<!-- ── MAIN CONTENT ── -->
<main class="main-wrap">
    <?php if(session('success')): ?>
        <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-error"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>
</main>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('show');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.remove('show');
    }
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\wince karl samillano\Downloads\IT-12-main\IT-12-main\resources\views/layouts/staff.blade.php ENDPATH**/ ?>