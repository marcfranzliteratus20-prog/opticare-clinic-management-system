<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OptiCare Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:500,600,700|inter:400,500,600,700" rel="stylesheet" />

    <style>
        :root {
            --oc-ink: #1C2B33;
            --oc-teal: #1B4B4F;
            --oc-teal-dark: #123638;
            --oc-gold: #C98A3E;
            --oc-terracotta: #C1533A;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--oc-teal), var(--oc-teal-dark));
        }

        /* Signature: Snellen eye chart, faded into the background */
        .snellen {
            position: absolute;
            top: 50%;
            left: -30px;
            transform: translateY(-50%);
            z-index: 0;
            text-align: left;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.06);
            line-height: 1.1;
            letter-spacing: 0.08em;
            user-select: none;
            pointer-events: none;
        }
        .snellen div:nth-child(1) { font-size: 7rem; }
        .snellen div:nth-child(2) { font-size: 5rem; }
        .snellen div:nth-child(3) { font-size: 3.5rem; }
        .snellen div:nth-child(4) { font-size: 2.4rem; }
        .snellen div:nth-child(5) { font-size: 1.6rem; }

        /* Decorative: concentric lens/aperture rings */
        .lens-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.08);
            pointer-events: none;
            z-index: 0;
        }
        .lens-ring.gold { border-color: rgba(201,138,62,0.18); }

        .ring-1 { width: 420px; height: 420px; top: -140px; right: -140px; }
        .ring-2 { width: 300px; height: 300px; top: -80px; right: -80px; }
        .ring-3 { width: 180px; height: 180px; top: -20px; right: -20px; }

        .ring-4 { width: 380px; height: 380px; bottom: -160px; left: -120px; }
        .ring-5 { width: 240px; height: 240px; bottom: -100px; left: -60px; }

        /* Decorative: floating eyeglasses shapes */
        .float-icon {
            position: absolute;
            color: rgba(255,255,255,0.07);
            pointer-events: none;
            z-index: 0;
        }
        .float-icon.gold { color: rgba(201,138,62,0.14); }

        .icon-1 { font-size: 6rem; top: 8%; right: 12%; transform: rotate(-12deg); }
        .icon-2 { font-size: 3.5rem; bottom: 12%; right: 20%; transform: rotate(8deg); }
        .icon-3 { font-size: 4.5rem; bottom: 8%; left: 8%; transform: rotate(-6deg); }
        .icon-4 { font-size: 2.8rem; top: 14%; left: 14%; transform: rotate(15deg); }

        /* Soft glow behind the card */
        .card-glow {
            position: absolute;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201,138,62,0.18) 0%, rgba(201,138,62,0) 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .lens-ring, .float-icon { display: none; }
        }

        .login-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.35);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.5rem;
            color: #fff;
            margin-bottom: 6px;
            text-shadow: 0 1px 4px rgba(0,0,0,0.2);
        }

        .brand i { color: var(--oc-gold); }

        .subtitle {
            text-align: center;
            color: rgba(255,255,255,0.75);
            font-size: 0.85rem;
            margin-bottom: 30px;
        }

        .field { margin-bottom: 18px; }

        .field label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
            margin-bottom: 6px;
        }

        .field input {
            width: 100%;
            border: 1px solid rgba(255,255,255,0.4);
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 0.92rem;
            font-family: 'Inter', sans-serif;
            color: var(--oc-ink);
            background: rgba(255, 255, 255, 0.65);
            outline: none;
        }

        .field input::placeholder { color: #7a8a8e; }
        .field input:focus { border-color: #fff; background: rgba(255, 255, 255, 0.85); }
        .field input.is-invalid { border-color: var(--oc-terracotta); }

        .password-wrap { position: relative; }

        .password-wrap input { padding-right: 42px; }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #5a6b70;
            cursor: pointer;
            padding: 4px;
        }

        .field-error {
            color: var(--oc-terracotta);
            font-size: 0.78rem;
            margin-top: 4px;
        }

        .alert-box {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .alert-danger { background: rgba(193,83,58,0.1); color: var(--oc-terracotta); }
        .alert-success { background: rgba(63,125,92,0.1); color: #3F7D5C; }

        .btn-login {
            width: 100%;
            background: var(--oc-teal);
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 24px;
            font-weight: 600;
            font-size: 0.95rem;
            margin-top: 6px;
        }

        .btn-login:hover { background: var(--oc-teal-dark); color: #fff; }

        .back-home {
            display: block;
            text-align: center;
            margin-top: 22px;
            color: rgba(255,255,255,0.7);
            font-size: 0.82rem;
            text-decoration: none;
        }

        .back-home:hover { color: #fff; }

        @media (max-width: 480px) {
            .snellen { display: none; }
            .login-card { padding: 28px; }
        }
    </style>
</head>
<body>

    <!-- Decorative lens/aperture rings -->
    <div class="lens-ring ring-1"></div>
    <div class="lens-ring ring-2 gold"></div>
    <div class="lens-ring ring-3"></div>
    <div class="lens-ring ring-4"></div>
    <div class="lens-ring ring-5 gold"></div>

    <!-- Decorative floating eyeglasses shapes -->
    <i class="bi bi-eyeglasses float-icon icon-1"></i>
    <i class="bi bi-eyeglasses float-icon gold icon-2"></i>
    <i class="bi bi-eyeglasses float-icon icon-3"></i>
    <i class="bi bi-eyeglasses float-icon gold icon-4"></i>

    <div class="card-glow"></div>

    <div class="snellen" aria-hidden="true">
        <div>E</div>
        <div>F&nbsp;&nbsp;P</div>
        <div>T&nbsp;O&nbsp;Z</div>
        <div>L&nbsp;P&nbsp;E&nbsp;D</div>
        <div>P&nbsp;E&nbsp;C&nbsp;F&nbsp;D</div>
    </div>

    <div class="login-wrap">
        <div class="login-card">
            <div class="brand"><i class="bi bi-eyeglasses"></i> OptiCare</div>
            <p class="subtitle">Galvez Optical Clinic Management System</p>

            @if (session('error'))
                <div class="alert-box alert-danger">{{ session('error') }}</div>
            @endif

            @if (session('success'))
                <div class="alert-box alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="@error('email') is-invalid @enderror" required autofocus>
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>Password</label>
                    <div class="password-wrap">
                        <input type="password" name="password" id="password"
                               class="@error('password') is-invalid @enderror" required>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Role is never taken from user input -- it comes only from
                     the authenticated user's own DB record, to prevent
                     anyone from picking "Admin" and logging in as one. --}}

                <button class="btn-login">Log In</button>
            </form>

            <a href="/" class="back-home"><i class="bi bi-arrow-left"></i> Back to Home</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.className = isHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
        }
    </script>

</body>
</html>