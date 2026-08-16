@extends('layouts.app')

@section('content')

<div class="oc-page">

    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <div class="mb-4">

        <p class="oc-eyebrow">
            Clinic Schedule
        </p>

        <h2 class="oc-heading">
            Edit Appointment
        </h2>

        <p class="oc-subtitle">
            Update the patient's appointment details and status.
        </p>

    </div>


    {{-- =========================================================
        CARD
    ========================================================== --}}

    <div class="oc-card">

        <div class="oc-card-body">

            {{-- =================================================
                VALIDATION ERRORS
            ================================================== --}}

            @if ($errors->any())

                <div class="oc-alert oc-alert-danger">

                    <div>

                        <strong>
                            Please fix the following errors:
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            @endif


            {{-- =================================================
                SUCCESS
            ================================================== --}}

            @if(session('success'))

                <div class="oc-alert oc-alert-success">

                    <i class="bi bi-check-circle-fill"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            {{-- =================================================
                FORM
            ================================================== --}}

            <form
                action="{{ route('appointments.update', $appointment->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                {{-- =================================================
                    PATIENT
                ================================================== --}}

                <div class="oc-field">

                    <label for="patient_id">
                        Patient
                    </label>

                    <select
                        id="patient_id"
                        name="patient_id"
                        required
                    >

                        <option value="">
                            -- Choose Patient --
                        </option>

                        @foreach($patients as $patient)

                            <option
                                value="{{ $patient->id }}"
                                {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}
                            >

                                {{ $patient->full_name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- =================================================
                    APPOINTMENT TYPE
                ================================================== --}}

                <div class="oc-field">

                    <label for="type">
                        Appointment Type
                    </label>

                    @php

                        $types = [

                            'Comprehensive Eye Examination',

                            'Prescription Eyeglasses',

                            'Contact Lens Fitting and Assessment',

                            'Ishihara Color Vision Test',

                            'Eye Condition Certification',

                            'Eyewear Accessories',

                            'Eyewear Repair and Maintenance',

                            'Frame Fitting',

                            'Other'

                        ];

                    @endphp

                    <select
                        id="type"
                        name="type"
                        required
                    >

                        <option value="">
                            -- Select Appointment Type --
                        </option>

                        @foreach($types as $type)

                            <option
                                value="{{ $type }}"
                                {{ old('type', $appointment->type) == $type ? 'selected' : '' }}
                            >

                                {{ $type }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- =================================================
                    LOCATION
                ================================================== --}}

                <div class="oc-field">

                    <label for="location">
                        Location
                    </label>

                    <input
                        type="text"
                        id="location"
                        name="location"
                        placeholder="Enter appointment location"
                        value="{{ old('location', $appointment->location) }}"
                        required
                    >

                    <small class="oc-help">
                        Enter the clinic location where the appointment will take place.
                    </small>

                </div>


                {{-- =================================================
                    DATE
                ================================================== --}}

                <div class="oc-field">

                    <label for="appointment_date">
                        Appointment Date
                    </label>

                    <input
                        type="date"
                        id="appointment_date"
                        name="appointment_date"
                        value="{{ old('appointment_date', $appointment->appointment_date) }}"
                        required
                    >

                </div>


                {{-- =================================================
                    TIME
                ================================================== --}}

                <div class="oc-field">

                    <label for="appointment_time">
                        Appointment Time
                    </label>

                    <input
                        type="time"
                        id="appointment_time"
                        name="appointment_time"
                        value="{{ old('appointment_time', $appointment->appointment_time) }}"
                        required
                    >

                </div>


                {{-- =================================================
                    DOCTOR
                ================================================== --}}

                <div class="oc-field">

                    <label for="doctor_name">
                        Doctor / Optometrist Name
                    </label>

                    <input
                        type="text"
                        id="doctor_name"
                        name="doctor_name"
                        placeholder="Enter doctor / optometrist name"
                        value="{{ old('doctor_name', $appointment->doctor_name) }}"
                        required
                    >

                </div>


                {{-- =================================================
                    SOURCE
                ================================================== --}}

                <div class="oc-field">

                    <label>
                        Appointment Source
                    </label>

                    <div class="oc-readonly">

                        <i class="bi bi-info-circle"></i>

                        <span>
                            {{ $appointment->source ?? 'Walk-in' }}
                        </span>

                    </div>

                    <small class="oc-help">
                        Appointment source cannot be changed from the edit page.
                    </small>

                </div>


                {{-- =================================================
                    STATUS
                ================================================== --}}

                <div class="oc-field">

                    <label for="status">
                        Appointment Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                    >

                        <option
                            value="Pending"
                            {{ old('status', $appointment->status) === 'Pending' ? 'selected' : '' }}
                        >
                            Pending
                        </option>

                        <option
                            value="Approved"
                            {{ old('status', $appointment->status) === 'Approved' ? 'selected' : '' }}
                        >
                            Approved
                        </option>

                        <option
                            value="Completed"
                            {{ old('status', $appointment->status) === 'Completed' ? 'selected' : '' }}
                        >
                            Completed
                        </option>

                        <option
                            value="Cancelled"
                            {{ old('status', $appointment->status) === 'Cancelled' ? 'selected' : '' }}
                        >
                            Cancelled
                        </option>

                    </select>

                </div>


                {{-- =================================================
                    MESSAGE
                ================================================== --}}

                <div class="oc-field">

                    <label for="message">
                        Message / Remarks
                    </label>

                    <textarea
                        id="message"
                        name="message"
                        rows="4"
                        maxlength="500"
                        placeholder="Enter appointment message or remarks..."
                    >{{ old('message', $appointment->message) }}</textarea>

                    <small class="oc-help">
                        Optional message or remarks for this appointment.
                    </small>

                </div>


                {{-- =================================================
                    BUTTONS
                ================================================== --}}

                <div class="oc-form-actions">

                    <button
                        type="submit"
                        class="oc-btn oc-btn-primary"
                    >

                        <i class="bi bi-check-circle"></i>

                        Update Appointment

                    </button>


                    <a
                        href="{{ route('appointments.index') }}"
                        class="oc-btn oc-btn-ghost-bordered"
                    >

                        <i class="bi bi-arrow-left"></i>

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =============================================================
    FONTS
============================================================= --}}

<link
    rel="preconnect"
    href="https://fonts.bunny.net"
>

<link
    href="https://fonts.bunny.net/css?family=fraunces:500,600,700|inter:400,500,600,700"
    rel="stylesheet"
/>


<style>

/* ================================================================
   PAGE
================================================================ */

.oc-page {

    --oc-ink: #1C2B33;

    --oc-teal: #1B4B4F;

    --oc-gold: #C98A3E;

    --oc-green: #2E7D5B;

    --oc-red: #C1533A;

    font-family: 'Inter', 'Segoe UI', sans-serif;

    color: var(--oc-ink);

}


/* ================================================================
   HEADER
================================================================ */

.oc-eyebrow {

    text-transform: uppercase;

    letter-spacing: 0.12em;

    font-size: 0.7rem;

    font-weight: 600;

    color: var(--oc-gold);

    margin-bottom: 4px;

}


.oc-heading {

    font-family: 'Fraunces', Georgia, serif;

    font-weight: 600;

    margin-bottom: 4px;

}


.oc-subtitle {

    color: #7A898D;

    font-size: 0.88rem;

    margin-bottom: 0;

}


/* ================================================================
   CARD
================================================================ */

.oc-card {

    background: #fff;

    border-radius: 18px;

    border: 1px solid rgba(28, 43, 51, 0.06);

    box-shadow:
        0 2px 10px rgba(28, 43, 51, 0.04);

    max-width: 700px;

}


.oc-card-body {

    padding: 28px;

}


/* ================================================================
   FIELD
================================================================ */

.oc-field {

    margin-bottom: 18px;

}


.oc-field label {

    display: block;

    font-size: 0.8rem;

    font-weight: 600;

    color: #5a6b70;

    margin-bottom: 6px;

}


.oc-field input,
.oc-field select,
.oc-field textarea {

    width: 100%;

    border: 1px solid rgba(28,43,51,0.14);

    border-radius: 12px;

    padding: 10px 14px;

    font-size: 0.92rem;

    font-family: 'Inter', sans-serif;

    color: var(--oc-ink);

    background: #fff;

    outline: none;

    transition:
        border-color 0.15s ease,
        box-shadow 0.15s ease;

}


.oc-field textarea {

    resize: vertical;

    min-height: 100px;

}


.oc-field input:focus,
.oc-field select:focus,
.oc-field textarea:focus {

    border-color: var(--oc-teal);

    box-shadow: 0 0 0 3px rgba(27,75,79,0.08);

}


/* ================================================================
   HELP TEXT
================================================================ */

.oc-help {

    display: block;

    margin-top: 6px;

    font-size: 0.72rem;

    color: #89969A;

}


/* ================================================================
   READ ONLY SOURCE
================================================================ */

.oc-readonly {

    width: 100%;

    display: flex;

    align-items: center;

    gap: 8px;

    border: 1px solid rgba(28,43,51,0.10);

    background: #F7F8F6;

    color: #68777B;

    border-radius: 12px;

    padding: 10px 14px;

    font-size: 0.92rem;

}


.oc-readonly i {

    color: var(--oc-teal);

}


/* ================================================================
   ALERT
================================================================ */

.oc-alert {

    display: flex;

    align-items: flex-start;

    gap: 10px;

    border-radius: 12px;

    padding: 14px 18px;

    margin-bottom: 20px;

    font-size: 0.88rem;

}


.oc-alert-danger {

    background: rgba(193,83,58,0.10);

    color: var(--oc-red);

}


.oc-alert-success {

    background: rgba(46,125,91,0.10);

    color: var(--oc-green);

}


/* ================================================================
   BUTTONS
================================================================ */

.oc-form-actions {

    display: flex;

    align-items: center;

    gap: 10px;

    margin-top: 24px;

}


.oc-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    border-radius: 20px;

    padding: 10px 20px;

    font-size: 0.88rem;

    font-weight: 600;

    text-decoration: none;

    border: none;

    cursor: pointer;

    transition: all 0.15s ease;

}


.oc-btn-primary {

    background: var(--oc-teal);

    color: #fff;

}


.oc-btn-primary:hover {

    background: #123638;

    color: #fff;

    transform: translateY(-1px);

}


.oc-btn-ghost-bordered {

    background: transparent;

    color: #5a6b70;

    border: 1px solid rgba(28,43,51,0.14);

}


.oc-btn-ghost-bordered:hover {

    background: #F5F5F3;

    color: var(--oc-ink);

}


/* ================================================================
   RESPONSIVE
================================================================ */

@media (max-width: 576px) {

    .oc-card-body {

        padding: 18px;

    }


    .oc-form-actions {

        flex-direction: column;

        align-items: stretch;

    }


    .oc-btn {

        width: 100%;

    }

}

</style>

@endsection