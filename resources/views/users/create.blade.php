@extends('layouts.app')

@section('content')
<div class="oc-page">

    <div class="mb-4">
        <p class="oc-eyebrow">Access &amp; Accounts</p>
        <h2 class="oc-heading">Add User</h2>
    </div>

    <div class="oc-card" style="max-width: 560px;">
        <div class="oc-card-body">

            @if($errors->any())
                <div class="oc-alert oc-alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="oc-field">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="oc-field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="oc-field">
                    <label>Password <span class="oc-optional">(minimum 8 characters)</span></label>
                    <input type="password" name="password" minlength="8" required>
                </div>

                <div class="oc-field">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="">Select Role</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Staff" {{ old('role') == 'Staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="oc-btn oc-btn-primary">Save User</button>
                    <a href="{{ route('users.index') }}" class="oc-btn oc-btn-ghost-bordered">Cancel</a>
                </div>
            </form>
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

    .oc-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(28, 43, 51, 0.06);
        box-shadow: 0 2px 10px rgba(28, 43, 51, 0.04);
    }

    .oc-card-body { padding: 28px; }

    .oc-field { margin-bottom: 18px; }

    .oc-field label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #5a6b70;
        margin-bottom: 6px;
    }

    .oc-optional { font-weight: 400; color: #a0a09a; }

    .oc-field input, .oc-field select {
        width: 100%;
        border: 1px solid rgba(28,43,51,0.14);
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 0.92rem;
        font-family: 'Inter', sans-serif;
        color: var(--oc-ink);
        outline: none;
    }

    .oc-field input:focus, .oc-field select:focus { border-color: var(--oc-teal); }

    .oc-alert { border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; font-size: 0.88rem; }
    .oc-alert-danger { background: rgba(193,83,58,0.1); color: var(--oc-terracotta); }

    .oc-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 20px;
        padding: 10px 22px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .oc-btn-primary { background: var(--oc-teal); color: #fff; }
    .oc-btn-primary:hover { background: #123638; color: #fff; }

    .oc-btn-ghost-bordered { background: transparent; color: #5a6b70; border: 1px solid rgba(28,43,51,0.14); }
    .oc-btn-ghost-bordered:hover { background: #f5f5f3; color: var(--oc-ink); }
</style>
@endsection