@extends('layouts.admin')

@section('title', 'Booking Management')

@section('styles')
<style>
    /* Minimal, clean styling */
    :root {
        --primary: #4f46e5;
        --primary-light: #ebe9ff;
        --success: #22c55e;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --dark: #1f2937;
        --gray: #6b7280;
        --light-gray: #f3f4f6;
        --border: #e5e7eb;
    }
    
    .container {
        max-width: 1200px;
    }
    
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #004aad;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .page-title i {
        color: var(--primary);
    }
    
    .search-box {
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        width: 100%;
        transition: all 0.2s;
        background-color: white;
    }
    
    .search-box:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
        outline: none;
    }
    
    .btn {
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .btn-outline-primary {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .btn-outline-primary:hover {
        background-color: var(--primary);
        color: white;
    }
    
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.75rem 1rem;
        background-color: #f9fafb;
        border-bottom: 1px solid var(--border);
    }
    
    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border);
    }
    
    .table tr:hover {
        background-color: #f9fafb;
    }
    
    .badge {
        padding: 0.35rem 0.65rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-status {
        padding: 0.4rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.2s;
    }
    
    .badge-status:hover {
        transform: translateY(-1px);
    }
    
    .badge-dark {
        background-color: var(--dark);
        color: white;
    }
    
    .badge-success {
        background-color: rgba(34, 197, 94, 0.1);
        color: var(--success);
    }
    
    .badge-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }
    
    .badge-warning {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }
    
    .badge-info {
        background-color: rgba(59, 130, 246, 0.1);
        color: var(--info);
    }
    
    .badge-primary {
        background-color: rgba(79, 70, 229, 0.1);
        color: var(--primary);
    }
    
    .badge-secondary {
        background-color: rgba(107, 114, 128, 0.1);
        color: var(--gray);
    }
    
    .tracking-badge {
        background-color: var(--dark);
        color: white;
        padding: 0.35rem 0.65rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        font-family: monospace;
        letter-spacing: 0.05em;
    }
    
    .amount {
        font-weight: 600;
        color: var(--success);
    }
    
    .contact-link {
        color: var(--primary);
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .contact-link:hover {
        color: var(--primary);
        text-decoration: underline;
    }
    
    .payment-badge {
        background-color: var(--light-gray);
        color: var(--gray);
        padding: 0.35rem 0.65rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .alert {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .alert-success {
        background-color: rgba(34, 197, 94, 0.1);
        border-left: 3px solid var(--success);
        color: var(--success);
    }
    
    .empty-state {
        padding: 3rem 0;
        text-align: center;
        color: var(--gray);
    }
    
    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        opacity: 0.6;
    }
    
    .card-footer {
        background-color: white;
        border-top: 1px solid var(--border);
        padding: 0.75rem 1rem;
        color: var(--gray);
        font-size: 0.875rem;
    }
    
    .page-header {
        margin-bottom: 1.5rem;
    }
    
    .filter-group {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center page-header">
        <h1 class="page-title">
            <i class="fa-solid fa-clipboard-list" style="color:#004aad"></i>
            Booking Management
        </h1>
    </div>
    
    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body p-3">
            <form method="GET" class="d-flex flex-wrap gap-2">
                <div class="flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control search-box border-start-0" 
                            placeholder="Search tracking..." value="{{ request('search') }}">
                    </div>
                </div>
                <div>
                    <select name="status" class="search-box">
                        <option value="all">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <select name="payment_mode" class="search-box">
                        <option value="all">All Payments</option>
                        <option value="cash" {{ request('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="khalti" {{ request('payment_mode') == 'khalti' ? 'selected' : '' }}>Khalti</option>
                    </select>
                </div>
                <div>
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            <i class="fa-solid fa-circle-check me-2"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background-color: #ebe9ff;">
                        <i class="fa-solid fa-clipboard-list" style="color: var(--primary); font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">{{ count($bookings) }}</h3>
                        <p class="text-muted mb-0">Total Bookings</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background-color: rgba(59, 130, 246, 0.1);">
                        <i class="fa-solid fa-clock" style="color: var(--info); font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $bookings->where('status', 'pending')->count() }}</h3>
                        <p class="text-muted mb-0">Pending</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background-color: rgba(34, 197, 94, 0.1);">
                        <i class="fa-solid fa-check-circle" style="color: var(--success); font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $bookings->where('status', 'completed')->count() }}</h3>
                        <p class="text-muted mb-0">Completed</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background-color: rgba(239, 68, 68, 0.1);">
                        <i class="fa-solid fa-times-circle" style="color: var(--danger); font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $bookings->where('status', 'cancelled')->count() }}</h3>
                        <p class="text-muted mb-0">Cancelled</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tracking No.</th>
                            <th>Status</th>
                            <th>Weight</th>
                            <th>Amount</th>
                            <th>Receiver</th>
                            <th>Contact</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="tracking-badge">{{ $booking->tracking_no }}</span></td>
                            <td>
                                @php
                                    list($statusClass, $statusIcon) = match($booking->status) {
                                        'pending' => ['badge-info', 'fa-clock'],
                                        'completed' => ['badge-success', 'fa-check-circle'],
                                        'cancelled' => ['badge-danger', 'fa-times-circle'],
                                        'rejected' => ['badge-warning', 'fa-exclamation-circle'],
                                        'in_transit' => ['badge-primary', 'fa-truck'],
                                        default => ['badge-secondary', 'fa-circle']
                                    };
                                @endphp
                                <span class="badge-status {{ $statusClass }}">
                                    <i class="fa-solid {{ $statusIcon }}"></i>
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                            <td>{{ $booking->weight }} kg</td>
                            <td><span class="amount">Rs. {{ number_format($booking->amount) }}</span></td>
                            <td>{{ $booking->receiver_name }}</td>
                            <td>
                                <a href="tel:{{ $booking->receiver_number }}" class="contact-link">
                                    {{ $booking->receiver_number }}
                                </a>
                            </td>
                            <td>
                                @php
                                    $paymentIcon = match($booking->payment_mode) {
                                        'cash' => 'fa-money-bill',
                                        'khalti' => 'fa-credit-card',
                                        default => 'fa-money-bill'
                                    };
                                @endphp
                                <span class="payment-badge">
                                    <i class="fa-solid {{ $paymentIcon }} me-1"></i>
                                    {{ ucfirst($booking->payment_mode) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="empty-state">
                                <i class="fa-solid fa-clipboard-list text-muted"></i>
                                <p class="mb-1 fw-medium">No bookings found</p>
                                <p class="text-muted small mb-0">Try adjusting your search or filter criteria</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <span>Showing {{ count($bookings ?? []) }} bookings</span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection