@extends(
    session('user_role') == 'Staff'
        ? 'layouts.staff'
        : 'layouts.app'
)

@section('content')
<div class="oc-page">

    <div class="mb-4">
        <p class="oc-eyebrow">Clinic Records</p>
        <h2 class="oc-heading">Edit Patient</h2>
    </div>

    <div class="oc-card" style="max-width: 640px;">
        <div class="oc-card-body">

            @if ($errors->any())
                <div class="oc-alert oc-alert-danger">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('patients.update', $patient->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="oc-field">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $patient->full_name) }}" required>
                </div>

                <div class="oc-field">
                    <label>Age</label>
                    <input type="number" name="age" min="0" max="120" value="{{ old('age', $patient->age) }}" required>
                </div>

                <div class="oc-field">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender', $patient->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="oc-field">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number', $patient->contact_number) }}" required>
                </div>

                <div class="oc-field">
                    <label>Eye Grade <span class="oc-optional">(optional)</span></label>
                    <input type="text" name="eye_grade" value="{{ old('eye_grade', $patient->eye_grade) }}" placeholder="e.g. OD -1.25 / OS -1.00">
                </div>

                <div class="oc-field">
                    <label>Address</label>
                    <textarea name="address" rows="3" required>{{ old('address', $patient->address) }}</textarea>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="oc-btn oc-btn-primary">Update Patient</button>
                    <a href="{{ route('patients.index') }}" class="oc-btn oc-btn-ghost-bordered">Cancel</a>
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

    .oc-field input, .oc-field select, .oc-field textarea {
        width: 100%;
        border: 1px solid rgba(28,43,51,0.14);
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 0.92rem;
        font-family: 'Inter', sans-serif;
        color: var(--oc-ink);
        outline: none;
    }

    .oc-field textarea { resize: vertical; }

    .oc-field input:focus, .oc-field select:focus, .oc-field textarea:focus { border-color: var(--oc-teal); }

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