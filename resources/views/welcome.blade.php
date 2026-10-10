<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqua De Smiley – Pure & Clean Water</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --accent: #38bdf8;
            --bg: #0b1329;
            --card-bg: #ffffff;
            --border: #e2e8f0;
            --text: #0f172a;
            --text-muted: #64748b;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0b1329 0%, #0f172a 50%, #1e293b 100%);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            position: relative;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(56,189,248,0.12) 0%, rgba(2,132,199,0.03) 60%, transparent 75%);
            z-index: 0;
            pointer-events: none;
        }
        .hero-content {
            z-index: 1;
            max-width: 800px;
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 28px;
            padding: 3.5rem 2.5rem;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        }
        h1 {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 1.25rem;
            color: var(--text);
            letter-spacing: -0.02em;
        }
        h1 i {
            color: var(--primary);
            margin-right: 0.2rem;
        }
        p {
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            color: var(--text-muted);
            margin-bottom: 2.25rem;
            max-width: 600px;
            margin-inline: auto;
            line-height: 1.6;
        }
        .btn-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 1.8rem;
            border-radius: 99px;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            box-shadow: 0 2px 10px rgba(2, 132, 199, 0.22);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.3);
            color: #fff;
        }
        .btn-outline {
            background: #ffffff;
            color: var(--text);
            border: 1.5px solid var(--border);
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .btn-outline:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="hero-content">
            <h1><i class="fa-solid fa-droplet" style="-webkit-text-fill-color:var(--accent);"></i> Aqua De Smiley</h1>
            <p>Experience the purest and cleanest water refilling station in town. Fast delivery, pristine quality, and reliable service.</p>
            <div class="btn-group">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard <i class="fa-solid fa-arrow-right"></i></a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Log In <i class="fa-solid fa-right-to-bracket"></i></a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
