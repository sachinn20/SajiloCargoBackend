@extends('layouts.admin')

@section('title', 'Booking Management')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-primary fw-bold">
            <i class="fa-solid fa-clipboard-list me-2"></i>Booking Management
        </h2>

    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-start border-success border-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="ps-3">#</th>
                            <th><i class="fa-solid fa-barcode me-2"></i>Tracking</th>
                            <th><i class="fa-solid fa-circle-info me-2"></i>Status</th>
                            <th><i class="fa-solid fa-box me-2"></i>Shipment</th>
                            <th><i class="fa-solid fa-weight-scale me-2"></i>Weight</th>
                            <th><i class="fa-solid fa-ruler-combined me-2"></i>Dimension</th>
                            <th><i class="fa-solid fa-note-sticky me-2"></i>Notes</th>
                            <th><i class="fa-solid fa-money-bill me-2"></i>Amount</th>
                            <th><i class="fa-solid fa-boxes-stacked me-2"></i>Packages</th>
                            <th><i class="fa-solid fa-user me-2"></i>Receiver</th>
                            <th><i class="fa-solid fa-phone me-2"></i>Contact</th>
                            <th><i class="fa-solid fa-credit-card me-2"></i>Payment</th>
                            <th><i class="fa-solid fa-circle-check me-2"></i>Paid</th>
                            <th><i class="fa-solid fa-receipt me-2"></i>Transaction</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-dark fw-normal">{{ $booking->tracking_no }}</span>
                            </td>
                            <td>
                                @if($booking->status === 'cancelled')
                                    <span class="badge bg-danger">
                                        <i class="fa-solid fa-ban me-1"></i>{{ ucfirst($booking->status) }}
                                    </span>
                                @elseif($booking->status === 'completed')
                                    <span class="badge bg-success">
                                        <i class="fa-solid fa-check-circle me-1"></i>{{ ucfirst($booking->status) }}
                                    </span>
                                @elseif($booking->status === 'rejected')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i>{{ ucfirst($booking->status) }}
                                    </span>
                                @elseif($booking->status === 'pending')
                                    <span class="badge bg-info">
                                        <i class="fa-solid fa-clock me-1"></i>{{ ucfirst($booking->status) }}
                                    </span>
                                @elseif($booking->status === 'in_transit')
                                    <span class="badge bg-primary">
                                        <i class="fa-solid fa-truck me-1"></i>{{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fa-solid fa-circle-info me-1"></i>{{ ucfirst($booking->status) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if(strtolower($booking->shipment_type) == 'goods')
                                    <span class="badge bg-info text-dark">
                                        <i class="fa-solid fa-box me-1"></i>{{ ucfirst($booking->shipment_type) }}
                                    </span>
                                @elseif(strtolower($booking->shipment_type) == 'documents')
                                    <span class="badge bg-secondary">
                                        <i class="fa-solid fa-file me-1"></i>{{ ucfirst($booking->shipment_type) }}
                                    </span>
                                @else
                                    <span class="badge bg-primary">
                                        <i class="fa-solid fa-cube me-1"></i>{{ ucfirst($booking->shipment_type) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold">{{ $booking->weight }}</span> kg
                            </td>
                            <td>
                                <small class="text-muted">{{ $booking->dimension }}</small>
                            </td>
                            <td>
                                @if($booking->notes)
                                    <span data-bs-toggle="tooltip" title="{{ $booking->notes }}">
                                        <i class="fa-solid fa-comment text-muted"></i>
                                        {{ \Illuminate\Support\Str::limit($booking->notes, 20) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold text-success">Rs. {{ number_format($booking->amount) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill">{{ $booking->no_of_packages }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $booking->receiver_name }}</div>
                            </td>
                            <td>
                                <a href="tel:{{ $booking->receiver_number }}" class="text-decoration-none">
                                    <i class="fa-solid fa-phone-flip text-primary me-1"></i>
                                    {{ $booking->receiver_number }}
                                </a>
                            </td>
                            <td>
                                @if(strtolower($booking->payment_mode) == 'cash')
                                    <i class="fa-solid fa-money-bill-wave text-success me-1"></i>
                                @elseif(strtolower($booking->payment_mode) == 'khalti')
                                    <i class="fa-solid fa-mobile-screen text-purple me-1"></i>
                                @elseif(strtolower($booking->payment_mode) == 'card')
                                    <i class="fa-solid fa-credit-card text-primary me-1"></i>
                                @else
                                    <i class="fa-solid fa-money-check text-muted me-1"></i>
                                @endif
                                {{ ucfirst($booking->payment_mode) }}
                            </td>
                            <td>
                                @if($booking->is_paid)
                                    <span class="badge bg-success">
                                        <i class="fa-solid fa-circle-check me-1"></i>Yes
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fa-solid fa-circle-xmark me-1"></i>No
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($booking->khalti_transaction_id)
                                    <small class="text-muted">{{ \Illuminate\Support\Str::limit($booking->khalti_transaction_id, 10) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
 
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fa-solid fa-clipboard-list text-muted mb-2" style="font-size: 2.5rem;"></i>
                                    <p class="mb-0">No bookings found.</p>
                                    <p class="text-muted small">Try adjusting your search or filter criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">Showing {{ count($bookings ?? []) }} bookings</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this to your layout or include it here -->
<style>
    /* Custom responsive behavior for the bookings table */
    @media (max-width: 1599.98px) {
        .table th:nth-child(6),
        .table td:nth-child(6),
        .table th:nth-child(7),
        .table td:nth-child(7),
        .table th:nth-child(14),
        .table td:nth-child(14) {
            display: none;
        }
    }
    
    @media (max-width: 1399.98px) {
        .table th:nth-child(5),
        .table td:nth-child(5),
        .table th:nth-child(9),
        .table td:nth-child(9),
        .table th:nth-child(11),
        .table td:nth-child(11) {
            display: none;
        }
    }
    
    @media (max-width: 1199.98px) {
        .table th:nth-child(4),
        .table td:nth-child(4),
        .table th:nth-child(12),
        .table td:nth-child(12) {
            display: none;
        }
    }
    
    @media (max-width: 991.98px) {
        .table th:nth-child(8),
        .table td:nth-child(8),
        .table th:nth-child(10),
        .table td:nth-child(10) {
            display: none;
        }
    }
    
    @media (max-width: 767.98px) {
        .table th:nth-child(13),
        .table td:nth-child(13) {
            display: none;
        }
    }

    /* Custom color for Khalti */
    .text-purple {
        color: #5C2D91;
    }
</style>

<!-- Initialize tooltips -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection