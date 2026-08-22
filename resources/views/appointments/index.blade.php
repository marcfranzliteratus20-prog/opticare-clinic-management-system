@extends('layouts.app')

@section('content')

<div class="oc-page">

    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <p class="oc-eyebrow">
                Clinic Schedule
            </p>

            <h2 class="oc-heading">
                Appointments
            </h2>

            <p class="oc-subtitle">
                Manage patient appointments and appointment requests.
            </p>
        </div>

        <a href="{{ route('appointments.create') }}"
           class="oc-btn oc-btn-primary">

            <i class="bi bi-plus-circle"></i>
            Add Appointment

        </a>

    </div>


    {{-- =========================================================
        SUCCESS MESSAGE
    ========================================================== --}}

    @if(session('success'))

        <div class="oc-alert oc-alert-success">

            <i class="bi bi-check-circle-fill"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    {{-- =========================================================
        ERROR MESSAGE
    ========================================================== --}}

    @if(session('error'))

        <div class="oc-alert oc-alert-danger">

            <i class="bi bi-exclamation-circle-fill"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- =========================================================
        VALIDATION ERRORS
    ========================================================== --}}

    @if($errors->any())

        <div class="oc-alert oc-alert-danger">

            <strong>
                Please fix the following errors:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =========================================================
        SEARCH
    ========================================================== --}}

    <div class="oc-card mb-4">

        <div class="oc-card-body">

            <form action="{{ route('appointments.index') }}"
                  method="GET">

                <div class="row g-2 align-items-center">

                    <div class="col-md-10">

                        <div class="oc-search">

                            <i class="bi bi-search"></i>

                            <input
                                type="text"
                                name="search"
                                value="{{ $search ?? request('search') }}"
                                placeholder="Search patient, contact, address, doctor, appointment type, status, or source..."
                            >

                        </div>

                    </div>

                    <div class="col-md-2">

                        <button
                            type="submit"
                            class="oc-btn oc-btn-primary w-100"
                        >

                            <i class="bi bi-search"></i>

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
        APPOINTMENTS TABLE
    ========================================================== --}}

    <div class="oc-card">

        <div class="oc-card-body p-0">

            <div class="table-responsive">

                <table class="oc-table">

                    {{-- =================================================
                        TABLE HEADER
                    ================================================== --}}

                    <thead>

                        <tr>

                            <th>
                                Patient
                            </th>

                            <th>
                                Contact
                            </th>

                            <th>
                                Appointment Type
                            </th>

                            <th>
                                Address
                            </th>

                            <th>
                                Date
                            </th>

                            <th>
                                Time
                            </th>

                            <th>
                                Doctor
                            </th>

                            <th>
                                Source
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Message
                            </th>

                            <th>
                                Action
                            </th>

                        </tr>

                    </thead>


                    {{-- =================================================
                        TABLE BODY
                    ================================================== --}}

                    <tbody>

                        @forelse($appointments as $appointment)

                            <tr>

                                {{-- =================================================
                                    PATIENT
                                ================================================== --}}

                                <td>

                                    <div class="patient-name">

                                        {{ $appointment->patient->full_name ?? 'N/A' }}

                                    </div>

                                </td>


                                {{-- =================================================
                                    CONTACT
                                ================================================== --}}

                                <td>

                                    {{ $appointment->patient->contact_number ?? 'N/A' }}

                                </td>


                                {{-- =================================================
                                    APPOINTMENT TYPE
                                ================================================== --}}

                                <td>

                                    <span class="appointment-type">

                                        {{ $appointment->type ?? 'N/A' }}

                                    </span>

                                </td>


                                {{-- =================================================
                                    PATIENT ADDRESS
                                ================================================== --}}

                                <td>

                                    @if($appointment->patient && $appointment->patient->address)

                                        <span class="appointment-address" title="{{ $appointment->patient->address }}">

                                            <i class="bi bi-geo-alt-fill"></i>

                                            {{ $appointment->patient->address }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            N/A
                                        </span>

                                    @endif

                                </td>


                                {{-- =================================================
                                    DATE
                                ================================================== --}}

                                <td>

                                    @if($appointment->appointment_date)

                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}

                                    @else

                                        N/A

                                    @endif

                                </td>


                                {{-- =================================================
                                    TIME
                                ================================================== --}}

                                <td>

                                    @if($appointment->appointment_time)

                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}

                                    @else

                                        N/A

                                    @endif

                                </td>


                                {{-- =================================================
                                    DOCTOR
                                ================================================== --}}

                                <td>

                                    {{ $appointment->doctor_name ?? 'N/A' }}

                                </td>


                                {{-- =================================================
                                    SOURCE
                                ================================================== --}}

                                <td>

                                    @if($appointment->source)

                                        @if($appointment->source === 'Online')

                                            <span class="source-badge source-online">

                                                <i class="bi bi-globe2"></i>

                                                Online

                                            </span>

                                        @elseif($appointment->source === 'Walk-in')

                                            <span class="source-badge source-walkin">

                                                <i class="bi bi-person-walking"></i>

                                                Walk-in

                                            </span>

                                        @else

                                            <span class="source-badge source-default">

                                                {{ $appointment->source }}

                                            </span>

                                        @endif

                                    @else

                                        <span class="text-muted">
                                            N/A
                                        </span>

                                    @endif

                                </td>


                                {{-- =================================================
                                    STATUS
                                ================================================== --}}

                                <td>

                                    @if($appointment->status === 'Pending')

                                        <span class="oc-status oc-status-pending">

                                            <i class="bi bi-clock"></i>

                                            Pending

                                        </span>

                                    @elseif($appointment->status === 'Approved')

                                        <span class="oc-status oc-status-approved">

                                            <i class="bi bi-check-circle"></i>

                                            Approved

                                        </span>

                                    @elseif($appointment->status === 'Completed')

                                        <span class="oc-status oc-status-completed">

                                            <i class="bi bi-check-circle-fill"></i>

                                            Completed

                                        </span>

                                    @elseif($appointment->status === 'Cancelled')

                                        <span class="oc-status oc-status-cancelled">

                                            <i class="bi bi-x-circle"></i>

                                            Cancelled

                                        </span>

                                    @else

                                        <span class="oc-status oc-status-default">

                                            {{ $appointment->status ?? 'Unknown' }}

                                        </span>

                                    @endif

                                </td>


                                {{-- =================================================
                                    MESSAGE
                                ================================================== --}}

                                <td>

                                    @if($appointment->message)

                                        <div
                                            class="appointment-message"
                                            title="{{ $appointment->message }}"
                                        >

                                            {{ $appointment->message }}

                                        </div>

                                    @else

                                        <span class="text-muted">
                                            No message
                                        </span>

                                    @endif

                                </td>


                                {{-- =================================================
                                    ACTION
                                ================================================== --}}

                                <td>

                                    <div class="action-buttons">

                                        {{-- ================================
                                            PENDING ACTIONS
                                        ================================= --}}

                                        @if($appointment->status === 'Pending')

                                            {{-- APPROVE --}}

                                            <form
                                                action="{{ route('appointments.approve', $appointment->id) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="action-btn action-approve"
                                                    onclick="return confirm('Approve this appointment?')"
                                                >

                                                    <i class="bi bi-check-circle"></i>

                                                    <span>
                                                        Approve
                                                    </span>

                                                </button>

                                            </form>


                                            {{-- REJECT --}}

                                            <button
                                                type="button"
                                                class="action-btn action-reject"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $appointment->id }}"
                                            >

                                                <i class="bi bi-x-circle"></i>

                                                <span>
                                                    Reject
                                                </span>

                                            </button>

                                        @endif


                                        {{-- ================================
                                            APPROVED ACTION
                                        ================================= --}}

                                        @if($appointment->status === 'Approved')

                                            <form
                                                action="{{ route('appointments.complete', $appointment->id) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="action-btn action-complete"
                                                    onclick="return confirm('Mark this appointment as completed?')"
                                                >

                                                    <i class="bi bi-check2-all"></i>

                                                    <span>
                                                        Complete
                                                    </span>

                                                </button>

                                            </form>

                                        @endif


                                        {{-- ================================
                                            EDIT
                                        ================================= --}}

                                        <a
                                            href="{{ route('appointments.edit', $appointment->id) }}"
                                            class="action-btn action-edit"
                                        >

                                            <i class="bi bi-pencil-square"></i>

                                            <span>
                                                Edit
                                            </span>

                                        </a>


                                        {{-- ================================
                                            DELETE
                                        ================================= --}}

                                        <form
                                            action="{{ route('appointments.destroy', $appointment->id) }}"
                                            method="POST"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn action-delete"
                                                onclick="return confirm('Delete this appointment?')"
                                            >

                                                <i class="bi bi-trash"></i>

                                                <span>
                                                    Delete
                                                </span>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="11"
                                    class="empty-state"
                                >

                                    <div class="empty-icon">

                                        <i class="bi bi-calendar-x"></i>

                                    </div>

                                    <h5>
                                        No appointments found
                                    </h5>

                                    <p>
                                        There are no appointments matching your search.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =========================================================
            PAGINATION
        ========================================================== --}}

        @if($appointments->hasPages())

            <div class="oc-pagination">

                {{ $appointments->links() }}

            </div>

        @endif

    </div>

</div>


{{-- =============================================================
    REJECT MODALS
============================================================= --}}

@foreach($appointments as $appointment)

    @if($appointment->status === 'Pending')

        <div
            class="modal fade"
            id="rejectModal{{ $appointment->id }}"
            tabindex="-1"
            aria-labelledby="rejectModalLabel{{ $appointment->id }}"
            aria-hidden="true"
        >

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content reject-modal">

                    {{-- MODAL HEADER --}}

                    <div class="modal-header">

                        <div>

                            <p class="modal-eyebrow">
                                Appointment Action
                            </p>

                            <h5
                                class="modal-title"
                                id="rejectModalLabel{{ $appointment->id }}"
                            >
                                Reject Appointment
                            </h5>

                        </div>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>

                    </div>


                    {{-- MODAL BODY --}}

                    <form
                        action="{{ route('appointments.reject', $appointment->id) }}"
                        method="POST"
                    >

                        @csrf

                        <div class="modal-body">

                            <div class="reject-info">

                                <i class="bi bi-person-circle"></i>

                                <div>

                                    <strong>

                                        {{ $appointment->patient->full_name ?? 'Patient' }}

                                    </strong>

                                    <small>

                                        @if($appointment->appointment_date)

                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}

                                        @endif

                                        @if($appointment->appointment_time)

                                            at

                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}

                                        @endif

                                    </small>

                                </div>

                            </div>


                            <div class="mb-3">

                                <label
                                    for="message{{ $appointment->id }}"
                                    class="form-label"
                                >

                                    Reason for Rejection

                                </label>

                                <textarea
                                    id="message{{ $appointment->id }}"
                                    name="message"
                                    class="form-control reject-textarea"
                                    rows="4"
                                    placeholder="Enter the reason why this appointment is being rejected..."
                                    required
                                ></textarea>

                                <small class="text-muted">

                                    This message will be shown to the patient on their appointment status page.

                                </small>

                            </div>

                        </div>


                        {{-- MODAL FOOTER --}}

                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal"
                            >

                                Cancel

                            </button>

                            <button
                                type="submit"
                                class="btn btn-danger"
                            >

                                <i class="bi bi-x-circle"></i>

                                Reject Appointment

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endif

@endforeach


{{-- =============================================================
    FONTS
============================================================= --}}

<link rel="preconnect" href="https://fonts.bunny.net">

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
    --oc-blue: #3D6F9E;

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

}


.oc-card-body {

    padding: 22px;

}


/* ================================================================
   BUTTON
================================================================ */

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


/* ================================================================
   ALERTS
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


.oc-alert-success {

    background: rgba(46, 125, 91, 0.10);

    color: var(--oc-green);

}


.oc-alert-danger {

    background: rgba(193, 83, 58, 0.10);

    color: var(--oc-red);

}


/* ================================================================
   SEARCH
================================================================ */

.oc-search {

    position: relative;

}


.oc-search i {

    position: absolute;

    left: 14px;

    top: 50%;

    transform: translateY(-50%);

    color: #8B999D;

}


.oc-search input {

    width: 100%;

    border: 1px solid rgba(28,43,51,0.12);

    border-radius: 12px;

    padding: 11px 14px 11px 40px;

    font-size: 0.88rem;

    outline: none;

    transition: border-color 0.15s ease;

}


.oc-search input:focus {

    border-color: var(--oc-teal);

}


/* ================================================================
   TABLE
================================================================ */

.oc-table {

    width: 100%;

    border-collapse: collapse;

    font-size: 0.84rem;

}


.oc-table thead {

    background: #F7F8F6;

}


.oc-table th {

    padding: 14px 15px;

    text-align: left;

    font-size: 0.7rem;

    text-transform: uppercase;

    letter-spacing: 0.05em;

    font-weight: 700;

    color: #718084;

    border-bottom: 1px solid rgba(28,43,51,0.08);

    white-space: nowrap;

}


.oc-table td {

    padding: 15px;

    border-bottom: 1px solid rgba(28,43,51,0.06);

    vertical-align: middle;

}


.oc-table tbody tr:hover {

    background: #FAFBFA;

}


/* ================================================================
   PATIENT
================================================================ */

.patient-name {

    font-weight: 600;

    color: var(--oc-ink);

    white-space: nowrap;

}


.appointment-type {

    color: #596B70;

}


/* ================================================================
   PATIENT ADDRESS
================================================================ */

.appointment-address {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    color: #596B70;

    max-width: 200px;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;

}


.appointment-address i {

    color: var(--oc-gold);

    flex-shrink: 0;

}


/* ================================================================
   SOURCE
================================================================ */

.source-badge {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 5px 9px;

    border-radius: 20px;

    font-size: 0.7rem;

    font-weight: 700;

    white-space: nowrap;

}


.source-online {

    background: rgba(61, 111, 158, 0.12);

    color: #35648E;

}


.source-walkin {

    background: rgba(201, 138, 62, 0.12);

    color: #A66D21;

}


.source-default {

    background: #EEF1F1;

    color: #68777B;

}


/* ================================================================
   STATUS
================================================================ */

.oc-status {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 0.72rem;

    font-weight: 700;

    white-space: nowrap;

}


.oc-status-pending {

    background: rgba(201, 138, 62, 0.12);

    color: #A66D21;

}


.oc-status-approved {

    background: rgba(61, 111, 158, 0.12);

    color: #35648E;

}


.oc-status-completed {

    background: rgba(46, 125, 91, 0.12);

    color: #26704F;

}


.oc-status-cancelled {

    background: rgba(193, 83, 58, 0.12);

    color: #A5412E;

}


.oc-status-default {

    background: #EEF1F1;

    color: #68777B;

}


/* ================================================================
   MESSAGE
================================================================ */

.appointment-message {

    max-width: 220px;

    color: #596B70;

    font-size: 0.78rem;

    line-height: 1.4;

}


/* ================================================================
   ACTION BUTTONS
================================================================ */

.action-buttons {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

    flex-wrap: wrap;

    min-width: 300px;

}


.action-buttons form {

    margin: 0;

}


.action-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 5px;

    padding: 7px 10px;

    border-radius: 8px;

    border: none;

    font-size: 0.72rem;

    font-weight: 600;

    text-decoration: none;

    cursor: pointer;

    transition: all 0.15s ease;

    white-space: nowrap;

}


/* APPROVE */

.action-approve {

    background: rgba(46, 125, 91, 0.12);

    color: #26704F;

}


.action-approve:hover {

    background: #2E7D5B;

    color: #fff;

}


/* REJECT */

.action-reject {

    background: rgba(193, 83, 58, 0.12);

    color: #A5412E;

}


.action-reject:hover {

    background: #C1533A;

    color: #fff;

}


/* COMPLETE */

.action-complete {

    background: rgba(61, 111, 158, 0.12);

    color: #35648E;

}


.action-complete:hover {

    background: #3D6F9E;

    color: #fff;

}


/* EDIT */

.action-edit {

    background: rgba(61, 111, 158, 0.12);

    color: #35648E;

}


.action-edit:hover {

    background: #3D6F9E;

    color: #fff;

}


/* DELETE */

.action-delete {

    background: #F0F1F1;

    color: #667579;

}


.action-delete:hover {

    background: #667579;

    color: #fff;

}


/* ================================================================
   EMPTY STATE
================================================================ */

.empty-state {

    text-align: center;

    padding: 60px 20px !important;

    color: #7A898D;

}


.empty-icon {

    font-size: 40px;

    margin-bottom: 12px;

    color: #B8C2C4;

}


.empty-state h5 {

    color: var(--oc-ink);

    margin-bottom: 5px;

}


.empty-state p {

    margin: 0;

    font-size: 0.85rem;

}


/* ================================================================
   PAGINATION
================================================================ */

.oc-pagination {

    padding: 18px 22px;

}


/* ================================================================
   REJECT MODAL
================================================================ */

.reject-modal {

    border: none;

    border-radius: 18px;

    overflow: hidden;

}


.modal-header {

    padding: 20px 22px;

    border-bottom: 1px solid rgba(28,43,51,0.08);

}


.modal-eyebrow {

    text-transform: uppercase;

    letter-spacing: 0.1em;

    font-size: 0.65rem;

    font-weight: 700;

    color: var(--oc-red);

    margin-bottom: 3px;

}


.modal-title {

    font-family: 'Fraunces', Georgia, serif;

    font-weight: 600;

    color: var(--oc-ink);

}


.modal-body {

    padding: 22px;

}


.reject-info {

    display: flex;

    align-items: center;

    gap: 12px;

    background: #F7F8F6;

    border-radius: 12px;

    padding: 13px;

    margin-bottom: 20px;

}


.reject-info > i {

    font-size: 30px;

    color: #839195;

}


.reject-info strong {

    display: block;

    color: var(--oc-ink);

}


.reject-info small {

    display: block;

    color: #7A898D;

    margin-top: 2px;

}


.reject-textarea {

    border: 1px solid rgba(28,43,51,0.14);

    border-radius: 12px;

    resize: vertical;

}


.reject-textarea:focus {

    border-color: var(--oc-red);

    box-shadow: none;

}


.modal-footer {

    padding: 15px 22px;

    border-top: 1px solid rgba(28,43,51,0.08);

}


/* ================================================================
   RESPONSIVE
================================================================ */

@media (max-width: 992px) {

    .oc-table {

        min-width: 1500px;

    }

}


@media (max-width: 576px) {

    .oc-heading {

        font-size: 1.6rem;

    }

    .oc-card-body {

        padding: 15px;

    }

    .oc-btn {

        padding: 9px 14px;

    }

}

</style>

@endsection