@extends('layouts.admin')

@section('title', 'Payment Management')

@section('styles')
<style>
    /* Enhanced UI Styles */
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
    
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    .btn-primary:hover {
        background-color: #4338ca;
        border-color: #4338ca;
    }
    
    .btn-outline-primary {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .btn-outline-primary:hover {
        background-color: var(--primary);
        color: white;
    }
    
    .btn-outline-secondary {
        border-color: var(--gray);
        color: var(--gray);
    }
    
    .btn-outline-secondary:hover {
        background-color: var(--gray);
        color: white;
    }
    
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 1.5rem;
        transition: all 0.2s;
    }
    
    .card:hover {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .card-header {
        background-color: white;
        border-bottom: 1px solid var(--border);
        padding: 1rem;
    }
    
    .card-title {
        font-weight: 600;
        margin-bottom: 0;
        color: var(--dark);
        font-size: 1rem;
    }
    
    .card-body {
        padding: 1.25rem;
    }
    
    .card-footer {
        background-color: white;
        border-top: 1px solid var(--border);
        padding: 0.75rem 1rem;
        color: var(--gray);
        font-size: 0.875rem;
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
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
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
    
    .badge-success {
        background-color: rgba(34, 197, 94, 0.1);
        color: var(--success);
        border: 1px solid rgba(34, 197, 94, 0.2);
    }
    
    .badge-secondary {
        background-color: rgba(107, 114, 128, 0.1);
        color: var(--gray);
        border: 1px solid rgba(107, 114, 128, 0.2);
    }
    
    .badge-info {
        background-color: rgba(59, 130, 246, 0.1);
        color: var(--info);
        border: 1px solid rgba(59, 130, 246, 0.2);
    }
    
    .badge-warning {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
        border: 1px solid rgba(245, 158, 11, 0.2);
    }
    
    .tracking-number {
        font-family: monospace;
        font-size: 0.875rem;
        background-color: var(--dark);
        color: white;
        padding: 0.35rem 0.65rem;
        border-radius: 0.375rem;
        letter-spacing: 0.05em;
    }
    
    .amount {
        font-weight: 600;
        color: var(--success);
    }
    
    .form-control, .form-select {
        border-radius: 0.5rem;
        border: 1px solid var(--border);
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
        outline: none;
    }
    
    .input-group-text {
        border-radius: 0.5rem 0 0 0.5rem;
        border: 1px solid var(--border);
        background-color: #f9fafb;
    }
    
    .input-group .form-control {
        border-radius: 0 0.5rem 0.5rem 0;
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
    
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        border-radius: 0.375rem;
        margin: 0 0.125rem;
        color: var(--primary);
    }
    
    .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    /* Stats Cards */
    .stats-card {
        height: 100%;
    }
    
    .stats-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 1rem;
    }
    
    .stats-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        line-height: 1;
    }
    
    .stats-label {
        color: var(--gray);
        font-size: 0.875rem;
        margin-bottom: 0;
    }
    
    /* Tooltip styles */
    .tooltip-container {
        position: relative;
        display: inline-block;
    }
    
    .tooltip-content {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: var(--dark);
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        white-space: nowrap;
        z-index: 10;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s;
        pointer-events: none;
    }
    
    .tooltip-container:hover .tooltip-content {
        opacity: 1;
        visibility: visible;
        bottom: calc(100% + 5px);
    }
    
    .tooltip-content::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 5px;
        border-style: solid;
        border-color: var(--dark) transparent transparent transparent;
    }
    
    /* Filter count badge */
    .filter-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: var(--primary);
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .page-header {
        margin-bottom: 1.5rem;
    }
    
    .modal-content {
        border: none;
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .modal-header {
        border-bottom: 1px solid var(--border);
        background-color: #f9fafb;
    }
    
    .modal-footer {
        border-top: 1px solid var(--border);
        background-color: #f9fafb;
    }
    
    .form-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--dark);
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center page-header">
        <h1 class="page-title">
            <i class="fa-solid fa-credit-card" style="color:#004aad"></i>
            Payment Management
        </h1>
        
        <!-- Update Pricing Button -->
        <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#pricingModal">
            <i class="fa-solid fa-dollar-sign me-2"></i> Update Pricing
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background-color: var(--primary-light);">
                        <i class="fa-solid fa-credit-card" style="color: var(--primary); font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $bookings->total() }}</h3>
                        <p class="text-muted mb-0">Total Payments</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background-color: rgba(34, 197, 94, 0.1);">
                        <i class="fa-solid fa-check-circle" style="color: var(--success); font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $paidCount }}</h3>
                        <p class="text-muted mb-0">Paid</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background-color: rgba(239, 68, 68, 0.1);">
                        <i class="fa-solid fa-exclamation-circle" style="color: var(--danger); font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $unpaidCount }}</h3>
                        <p class="text-muted mb-0">Unpaid</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background-color: rgba(59, 130, 246, 0.1);">
                        <i class="fa-solid fa-rupee-sign" style="color: var(--info); font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">Rs. {{ number_format($totalAmount, 0) }}</h3>
                        <p class="text-muted mb-0">Total Amount</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <form method="GET" class="mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0" 
                                placeholder="Search by tracking number..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="payment_status" class="form-select">
                            <option value="">All Payment Status</option>
                            <option value="1" {{ request('payment_status') == '1' ? 'selected' : '' }}>Paid</option>
                            <option value="0" {{ request('payment_status') == '0' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="payment_mode" class="form-select">
                            <option value="">All Payment Modes</option>
                            <option value="online" {{ request('payment_mode') == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="cash" {{ request('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary flex-grow-1 position-relative">
                            <i class="fa-solid fa-filter me-1"></i> Filter
                            @php
                                $filterCount = 0;
                                if(request('search')) $filterCount++;
                                if(request('payment_status') !== null && request('payment_status') !== '') $filterCount++;
                                if(request('payment_mode')) $filterCount++;
                            @endphp
                            @if($filterCount > 0)
                                <span class="filter-count">{{ $filterCount }}</span>
                            @endif
                        </button>
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Payment Table Card -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fa-solid fa-list me-2 text-primary"></i>
                Payment Records
            </h5>
            <span class="badge bg-primary">{{ $bookings->total() }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="paymentsTable">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">Tracking No</th>
                            <th width="20%">User Name</th>
                            <th width="10%">Payment Mode</th>
                            <th width="10%">Amount</th>
                            <th width="10%">Status</th>
                            <th width="15%">Transaction ID</th>
                            <th width="15%">Payment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                        <tr>
                            <td>{{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}</td>
                            <td>
                                <span class="tracking-number">{{ $booking->tracking_no ?? '-' }}</span>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $booking->user->name ?? '-' }}</div>
                                <div class="text-muted small">{{ $booking->user->email ?? '' }}</div>
                            </td>
                            <td>
                                @php
                                    $modeIcon = $booking->payment_mode == 'online' ? 'fa-credit-card' : 'fa-money-bill';
                                    $modeClass = $booking->payment_mode == 'online' ? 'badge-info' : 'badge-warning';
                                @endphp
                                <span class="badge {{ $modeClass }}">
                                    <i class="fa-solid {{ $modeIcon }}"></i>
                                    {{ ucfirst($booking->payment_mode) }}
                                </span>
                            </td>
                            <td>
                                <span class="amount">Rs. {{ number_format($booking->amount, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $booking->is_paid ? 'badge-success' : 'badge-secondary' }}">
                                    <i class="fa-solid {{ $booking->is_paid ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                    {{ $booking->is_paid ? 'Paid' : 'Unpaid' }}
                                </span>
                            </td>
                            <td>
                                @if($booking->transaction_id)
                                    <span class="fw-medium" style="font-family: monospace;">{{ $booking->transaction_id }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($booking->payment_date)
                                    <div class="tooltip-container">
                                        {{ date('d M Y', strtotime($booking->payment_date)) }}
                                        <div class="tooltip-content">
                                            {{ date('d M Y, h:i A', strtotime($booking->payment_date)) }}
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="empty-state">
                                <i class="fa-solid fa-credit-card text-muted"></i>
                                <p class="mb-1 fw-medium">No payment records found</p>
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
                <div>
                    Showing {{ $bookings->firstItem() ?? 0 }} to {{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() }} payments
                </div>
                <div>
                    {{ $bookings->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pricing Update Modal -->
<div class="modal fade" id="pricingModal" tabindex="-1" aria-labelledby="pricingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pricingModalLabel">
                    <i class="fa-solid fa-dollar-sign me-2"></i>
                    Update Pricing Configuration
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.pricing.update') }}">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="price_per_km" class="form-label">Price per KM (Rs)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-rupee-sign"></i></span>
                            <input type="number" step="0.01" name="price_per_km" id="price_per_km" class="form-control" value="{{ $pricing->price_per_km ?? 0 }}" required>
                        </div>
                        <small class="text-muted">Current price: Rs. {{ number_format($pricing->price_per_km ?? 0, 2) }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="price_per_kg" class="form-label">Price per KG (Rs)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-rupee-sign"></i></span>
                            <input type="number" step="0.01" name="price_per_kg" id="price_per_kg" class="form-control" value="{{ $pricing->price_per_kg ?? 0 }}" required>
                        </div>
                        <small class="text-muted">Current price: Rs. {{ number_format($pricing->price_per_kg ?? 0, 2) }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
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