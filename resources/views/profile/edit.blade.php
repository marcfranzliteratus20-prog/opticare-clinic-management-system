@extends(
    session('user_role') == 'Staff'
        ? 'layouts.staff'
        : 'layouts.app'
)

@section('content')
<div class="oc-page">

    <div class="mb-4">
        <p class="oc-eyebrow">Your Account</p>
        <h2 class="oc-heading">Account Settings</h2>
    </div>

    @if(session('success'))
        <div class="oc-alert oc-alert-success mb-3">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="oc-alert oc-alert-danger mb-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="oc-card">
                <div class="oc-card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="oc-section-title">Profile Info</h5>

                        <div class="oc-field">
                            <label>Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="oc-field">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="oc-field">
                            <label>Role</label>
                            <input type="text" value="{{ $user->role }}" disabled>
                            <small class="oc-hint">Only an Admin can change your role, from User Management.</small>
                        </div>

                        <hr class="my-4">

                        <h5 class="oc-section-title">Change Password <span class="oc-optional">(optional)</span></h5>

                        <div class="oc-field">
                            <label>Current Password</label>
                            <input type="password" name="current_password">
                        </div>

                        <div class="oc-field">
                            <label>New Password</label>
                            <input type="password" name="new_password" minlength="8">
                        </div>

                        <div class="oc-field">
                            <label>Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" minlength="8">
                        </div>

                        <button type="submit" class="oc-btn oc-btn-primary mt-2">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="oc-card">
                <div class="oc-card-body text-center py-5">
                    <div class="oc-big-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <h5 class="mt-3 mb-1">{{ $user->name }}</h5>
                    <p class="oc-muted mb-2">{{ $user->email }}</p>
                    @if($user->role == 'Admin')
                        <span class="oc-badge oc-badge-gold">Admin</span>
                    @else
                        <span class="oc-badge oc-badge-sage">Staff</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=fraunces:500,600,700|inter:400,500,600,700" rel="stylesheet" />

<style>
    .oc-page {
        --oc-ink: #1C2B33;
        --oc-teal: #1B4B4F;
        --oc-gold: #C98A3E;
        --oc-amber-dark: #A8672A;
        --oc-sage: #3F7D5C;
        --oc-terracotta: #C1533A;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        color: var(--oc-ink);
    }

    .oc-eyebrow {
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--oc-gold);
        margin-bottom: 4px;
    }

    .oc-heading { font-family: 'Fraunces', Georgia, serif; font-weight: 600; margin-bottom: 0; }
    .oc-muted { color: #9a9a94; }

    .oc-section-title {
        font-family: 'Fraunces', Georgia, serif;
        font-weight: 600;
        font-size: 1.05rem;
        margin-bottom: 16px;
    }

    .oc-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(28, 43, 51, 0.06);
        box-shadow: 0 2px 10px rgba(28, 43, 51, 0.04);
        height: 100%;
    }

    .oc-card-body { padding: 28px; }

    .oc-alert { border-radius: 12px; padding: 12px 18px; font-size: 0.88rem; }
    .oc-alert-success { background: rgba(63,125,92,0.1); color: var(--oc-sage); }
    .oc-alert-danger { background: rgba(193,83,58,0.1); color: var(--oc-terracotta); }

    .oc-field { margin-bottom: 16px; }

    .oc-field label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #5a6b70;
        margin-bottom: 6px;
    }

    .oc-optional { font-weight: 400; color: #a0a09a; }

    .oc-hint {
        display: block;
        color: #9a9a94;
        font-size: 0.76rem;
        margin-top: 4px;
    }

    .oc-field input {
        width: 100%;
        border: 1px solid rgba(28,43,51,0.14);
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 0.92rem;
        font-family: 'Inter', sans-serif;
        color: var(--oc-ink);
        outline: none;
    }

    .oc-field input:focus { border-color: var(--oc-teal); }
    .oc-field input:disabled { background: #f5f5f3; color: #9a9a94; }

    .oc-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 20px;
        padding: 10px 24px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .oc-btn-primary { background: var(--oc-teal); color: #fff; }
    .oc-btn-primary:hover { background: #123638; color: #fff; }

    .oc-big-avatar {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: var(--oc-teal);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Fraunces', serif;
        font-weight: 600;
        font-size: 2.2rem;
        margin: 0 auto;
    }

    .oc-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .oc-badge-gold { background: rgba(201,138,62,0.15); color: var(--oc-amber-dark); }
    .oc-badge-sage { background: rgba(63,125,92,0.15); color: var(--oc-sage); }
</style>
@endsection