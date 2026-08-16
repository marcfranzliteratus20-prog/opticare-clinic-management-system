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
            Book Appointment
        </h2>

        <p class="oc-subtitle">
            Create a new appointment request for a patient.
        </p>

    </div>


    {{-- =========================================================
        FORM CARD
    ========================================================== --}}
    <div class="oc-card" style="max-width: 680px;">

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
                INFORMATION
            ================================================== --}}
            <div class="oc-info-box">

                <i class="bi bi-info-circle"></i>

                <div>

                    <strong>
                        Appointment Request
                    </strong>

                    <p>
                        New appointments will initially have a
                        <strong>Pending</strong> status.
                        The clinic staff will review and either
                        approve or reject the appointment.
                    </p>

                </div>

            </div>


            {{-- =================================================
                FORM
            ================================================== --}}
            <form
                action="{{ route('appointments.store') }}"
                method="POST"
            >

                @csrf


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
                            -- Select Patient --
                        </option>

                        @foreach($patients as $patient)

                            <option
                                value="{{ $patient->id }}"
                                {{ old('patient_id') == $patient->id ? 'selected' : '' }}
                            >

                                {{ $patient->full_name }}

                                @if($patient->contact_number)
                                    - {{ $patient->contact_number }}
                                @endif

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

                    <select
                        id="type"
                        name="type"
                        required
                    >

                        <option value="">
                            -- Select Appointment Type --
                        </option>

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


                        @foreach($types as $type)

                            <option
                                value="{{ $type }}"
                                {{ old('type') == $type ? 'selected' : '' }}
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
                        value="{{ old('location') }}"
                        maxlength="255"
                        required
                    >

                    <small class="oc-help-text">
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
                        min="{{ date('Y-m-d') }}"
                        value="{{ old('appointment_date') }}"
                        required
                    >

                    <small class="oc-help-text">
                        Please select today or a future date.
                    </small>

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
                        value="{{ old('appointment_time') }}"
                        required
                    >

                    <small class="oc-help-text">
                        Select your preferred appointment time.
                    </small>

                </div>


                {{-- =================================================
                    DOCTOR / OPTOMETRIST
                ================================================== --}}
                <div class="oc-field">

                    <label for="doctor_name">
                        Doctor / Optometrist
                    </label>

                    <input
                        type="text"
                        id="doctor_name"
                        name="doctor_name"
                        value="{{ old('doctor_name') }}"
                        placeholder="Enter doctor or optometrist name"
                        maxlength="100"
                        required
                    >

                </div>


                {{-- =================================================
                    STATUS INFORMATION
                ================================================== --}}
                <div class="oc-status-info">

                    <div class="oc-status-icon">

                        <i class="bi bi-clock-history"></i>

                    </div>

                    <div>

                        <strong>
                            Initial Status: Pending
                        </strong>

                        <p>
                            This appointment will remain pending
                            until the clinic approves or rejects it.
                        </p>

                    </div>

                </div>


                {{-- =================================================
                    BUTTONS
                ================================================== --}}
                <div class="oc-form-actions">

                    <button
                        type="submit"
                        class="oc-btn oc-btn-primary"
                    >

                        <i class="bi bi-calendar-plus"></i>

                        Book Appointment

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
    --oc-teal-dark: #123638;
    --oc-gold: #C98A3E;
    --oc-red: #C1533A;
    --oc-green: #2E7D5B;

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

    margin-bottom: 5px;

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

}


.oc-card-body {

    padding: 28px;

}


/* ================================================================
   INFORMATION BOX
================================================================ */

.oc-info-box {

    display: flex;

    align-items: flex-start;

    gap: 12px;

    background: #EEF6F5;

    border: 1px solid rgba(27, 75, 79, 0.10);

    border-radius: 12px;

    padding: 14px 16px;

    margin-bottom: 24px;

}


.oc-info-box > i {

    color: var(--oc-teal);

    font-size: 20px;

    margin-top: 1px;

}


.oc-info-box strong {

    color: var(--oc-teal);

    font-size: 0.86rem;

}


.oc-info-box p {

    color: #617174;

    font-size: 0.78rem;

    line-height: 1.5;

    margin: 4px 0 0;

}


/* ================================================================
   FIELD
================================================================ */

.oc-field {

    margin-bottom: 19px;

}


.oc-field label {

    display: block;

    font-size: 0.8rem;

    font-weight: 600;

    color: #5A6B70;

    margin-bottom: 7px;

}


.oc-field input,
.oc-field select {

    width: 100%;

    border: 1px solid rgba(28,43,51,0.14);

    border-radius: 12px;

    padding: 11px 14px;

    font-size: 0.9rem;

    font-family: 'Inter', sans-serif;

    color: var(--oc-ink);

    background: #fff;

    outline: none;

    transition: all 0.15s ease;

}


.oc-field input:focus,
.oc-field select:focus {

    border-color: var(--oc-teal);

    box-shadow:
        0 0 0 3px rgba(27,75,79,0.08);

}


.oc-field input::placeholder {

    color: #A3AFB2;

}


.oc-help-text {

    display: block;

    margin-top: 6px;

    color: #89979A;

    font-size: 0.72rem;

}


/* ================================================================
   STATUS INFORMATION
================================================================ */

.oc-status-info {

    display: flex;

    align-items: flex-start;

    gap: 12px;

    background: #FFF8EC;

    border: 1px solid rgba(201,138,62,0.15);

    border-radius: 12px;

    padding: 14px 16px;

    margin-top: 4px;

    margin-bottom: 24px;

}


.oc-status-icon {

    width: 34px;

    height: 34px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background: rgba(201,138,62,0.12);

    color: #A66D21;

    flex-shrink: 0;

}


.oc-status-info strong {

    display: block;

    color: #8A601D;

    font-size: 0.82rem;

}


.oc-status-info p {

    margin: 3px 0 0;

    color: #7A6B51;

    font-size: 0.76rem;

    line-height: 1.4;

}


/* ================================================================
   ALERT
================================================================ */

.oc-alert {

    border-radius: 12px;

    padding: 14px 18px;

    margin-bottom: 20px;

    font-size: 0.85rem;

}


.oc-alert-danger {

    background: rgba(193,83,58,0.10);

    color: var(--oc-red);

}


.oc-alert-danger ul {

    padding-left: 20px;

}


/* ================================================================
   BUTTONS
================================================================ */

.oc-form-actions {

    display: flex;

    align-items: center;

    gap: 10px;

    margin-top: 4px;

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

    background: var(--oc-teal-dark);

    color: #fff;

    transform: translateY(-1px);

}


.oc-btn-ghost-bordered {

    background: transparent;

    color: #5A6B70;

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


    .oc-heading {

        font-size: 1.6rem;

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