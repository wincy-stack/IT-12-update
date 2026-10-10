<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aqua De Smiley – Pure & Clean Water Refilling Station. Manage your orders and account.">
    <title><?php echo $__env->yieldContent('title', 'Aqua De Smiley'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:      #0284c7;
            --primary-dark: #0369a1;
            --accent:       #0284c7;
            --light-blue:   #e0f2fe;
            --light-blue-bg:#f8fafc;
            --border-color: #cbd5e1;
            --card-bg:      #ffffff;
            --body-bg:      #eef2f6;
            --text:         #0f172a;
            --text-muted:   #64748b;
            --success:      #10b981;
            --danger:       #ef4444;
            --warning:      #f59e0b;
            --sidebar-w:    260px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--body-bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── NAV ── */
        .topnav {
            position: sticky; top: 0; z-index: 100;
            background: #0f172a;
            border-bottom: 1px solid #1e293b;
            padding: 0 2rem;
            height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .topnav__brand {
            display: flex; align-items: center; gap: .75rem;
            font-size: 1.25rem; font-weight: 800;
            color: #ffffff;
            text-decoration: none;
        }
        .topnav__brand i { font-size: 1.5rem; color: #38bdf8; }
        .topnav__right { display: flex; align-items: center; gap: 1rem; }
        .role-badge {
            padding: .25rem .75rem; border-radius: 99px; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em;
        }
        .role-badge--admin    { background: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; }
        .role-badge--staff    { background: rgba(2,132,199,0.25); color: #38bdf8; border: 1px solid rgba(56,189,248,0.3); }
        .role-badge--customer { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }

        .topnav__user { color: #cbd5e1; font-size: .875rem; font-weight: 500; }
        .btn-logout {
            display: flex; align-items: center; gap: .4rem;
            padding: .4rem 1rem; border-radius: 8px; border: 1px solid #7f1d1d;
            background: #450a0a; color: #fca5a5; font-size: .8rem; font-weight: 600;
            cursor: pointer; transition: all .2s; text-decoration: none;
        }
        .btn-logout:hover { background: #7f1d1d; color: #fff; }

        /* ── MAIN CONTENT ── */
        .page-wrapper { flex: 1; padding: 2rem; max-width: 1300px; margin: 0 auto; width: 100%; }

        /* ── CARDS ── */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(2,132,199,0.03);
        }
        .card-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 2rem; }
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex; align-items: center; gap: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(2,132,199,0.08); }
        .stat-icon { width: 52px; height: 52px; border-radius: 12px; display: grid; place-items: center; font-size: 1.4rem; flex-shrink: 0; }
        .stat-icon--blue   { background: #e0f2fe; color: #0284c7; }
        .stat-icon--purple { background: #f3e8ff; color: #7e22ce; }
        .stat-icon--green  { background: #dcfce7; color: #15803d; }
        .stat-icon--amber  { background: #fef3c7; color: #b45309; }
        .stat-value { font-size: 1.75rem; font-weight: 800; line-height: 1; color: var(--text); }
        .stat-label { color: var(--text-muted); font-size: .8rem; font-weight: 500; margin-top: .2rem; }

        /* ── TABLE ── */
        .table-wrapper { overflow-x: auto; border-radius: 12px; border: 1px solid var(--border-color); background: var(--card-bg); }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: var(--light-blue-bg); }
        th { padding: .85rem 1.25rem; text-align: left; font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--text-muted); }
        td { padding: .85rem 1.25rem; border-top: 1px solid var(--border-color); font-size: .9rem; color: var(--text); }
        tr:hover td { background: #f8fafc; }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .6rem 1.4rem; border-radius: 10px; font-size: .875rem; font-weight: 600;
            cursor: pointer; text-decoration: none; transition: all .2s; border: none;
        }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; box-shadow: 0 2px 8px rgba(2,132,199,.2); }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(2,132,199,.25); color: #fff; }
        .btn-outline { background: #ffffff; border: 1px solid #cbd5e1; color: var(--text); }
        .btn-outline:hover { background: #f1f5f9; border-color: #94a3b8; }

        /* ── ALERTS ── */
        .alert { padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1rem; font-size: .9rem; display: flex; align-items: center; gap: .75rem; }
        .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #15803d; }
        .alert-error   { background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; }

        /* ── PAGE HEADER ── */
        .page-header { margin-bottom: 2rem; }
        .page-header h1 { font-size: 1.75rem; font-weight: 800; color: var(--text); }
        .page-header p { color: var(--text-muted); margin-top: .25rem; }

        /* ── FORM ── */
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: .85rem; font-weight: 600; color: #334155; margin-bottom: .4rem; }
        .form-input {
            width: 100%; padding: .7rem 1rem; border-radius: 10px;
            background: #ffffff; border: 1px solid #cbd5e1;
            color: var(--text); font-family: 'Outfit', sans-serif; font-size: .9rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(2,132,199,.15); }
        .form-input::placeholder { color: #94a3b8; }
        .form-error { color: #dc2626; font-size: .8rem; margin-top: .3rem; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<nav class="topnav">
    <div style="display:flex;align-items:center;gap:2rem;">
        <a href="<?php echo e(auth()->check() && auth()->user()->role === 'customer' ? route('customer.dashboard') : '#'); ?>" class="topnav__brand">
            <i class="fa-solid fa-droplet"></i>
            Aqua De Smiley
        </a>
        <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->role === 'customer'): ?>
            <div style="display:flex;align-items:center;gap:1.25rem;">
                <a href="<?php echo e(route('customer.dashboard')); ?>" style="color:<?php echo e(request()->routeIs('customer.dashboard') ? '#38bdf8' : 'var(--text-muted)'); ?>;text-decoration:none;font-size:.9rem;font-weight:600;display:flex;align-items:center;gap:.4rem;">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
                <a href="<?php echo e(route('customer.orders.index')); ?>" style="color:<?php echo e(request()->routeIs('customer.orders.index') ? '#38bdf8' : 'var(--text-muted)'); ?>;text-decoration:none;font-size:.9rem;font-weight:600;display:flex;align-items:center;gap:.4rem;">
                    <i class="fa-solid fa-receipt"></i> My Orders
                </a>
                <a href="<?php echo e(route('customer.orders.create')); ?>" class="btn btn-primary" style="padding:.35rem .9rem;font-size:.8rem;">
                    <i class="fa-solid fa-plus"></i> Place Order
                </a>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="topnav__right">
        <?php if(auth()->guard()->check()): ?>
            <span class="topnav__user"><i class="fa-regular fa-user" style="margin-right:.35rem"></i><?php echo e(auth()->user()->name); ?></span>
            <span class="role-badge role-badge--<?php echo e(auth()->user()->role); ?>"><?php echo e(ucfirst(auth()->user()->role)); ?></span>
            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
            </form>
        <?php endif; ?>
    </div>
</nav>

<div class="page-wrapper">
    <?php if(session('success')): ?>
        <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-error"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>
</div>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\wince karl samillano\Downloads\IT-12-main\IT-12-main\resources\views/layouts/app.blade.php ENDPATH**/ ?>