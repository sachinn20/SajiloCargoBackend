@extends('layouts.admin')

@section('title', 'Trip Management')

@section('styles')
<style>
    /* Enhanced styling with smoother transitions and modern design */
    .search-control {
        border-radius: 0.75rem;
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1.25rem;
        font-size: 0.95rem;
        background-color: #fdfdff;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .search-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59,130,246,0.15);
        transform: translateY(-1px);
    }

    .hover-row {
        transition: all 0.25s ease;
    }

    .hover-row:hover {
        background-color: #f8fafc !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .text-gradient {
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .bg-gradient {
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
    }

    th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        color: #4b5563;
        white-space: nowrap;
    }

    .table .text-muted {
        color: #6b7280 !important;
    }

    .table td, .table th {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    .badge-status {
        padding: 0.45rem 0.85rem;
        font-size: 0.72rem;
        font-weight: 500;
        border-radius: 999px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }

    .badge-status:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }

    .btn {
        border-radius: 0.75rem;
        padding: 0.65rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn-outline-primary {
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .btn-outline-primary:hover {
        background-color: #3b82f6;
        color: white;
    }

    .btn-outline-secondary {
        border-color: #9ca3af;
        color: #4b5563;
    }

    .card {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .card:hover {
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
    }

    .empty-state {
        padding: 3rem 0;
        text-align: center;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.6;
    }

    .page-header {
        position: relative;
        overflow: hidden;
    }

    .page-header::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
        border-radius: 3px;
    }
    
    .location-badge {
        background-color: #f9fafb;
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .location-badge:hover {
        background-color: #f1f5f9;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .location-badge i {
        color: #3b82f6;
        font-size: 0.9rem;
    }
    
    .location-badge span {
        font-size: 0.85rem;
        font-weight: 500;
        color: #4b5563;
    }
    
    .progress {
        background-color: #f1f5f9;
        border-radius: 999px;
        overflow: hidden;
    }
    
    .progress-bar {
        border-radius: 999px;
        transition: width 0.5s ease;
    }
    
    .capacity-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .capacity-text {
        font-size: 0.8rem;
        font-weight: 500;
        white-space: nowrap;
        color: #4b5563;
    }
    
    .alert {
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        animation: slideDown 0.3s ease-out forwards;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .vehicle-info {
        display: flex;
        flex-direction: column;
    }
    
    .vehicle-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1f2937;
    }
    
    .vehicle-plate {
        font-size: 0.8rem;
        color: #6b7280;
    }
    
    .date-time-wrapper {
        display: flex;
        flex-direction: column;
    }
    
    .date-display {
        font-weight: 500;
        font-size: 0.85rem;
        color: #1f2937;
    }
    
    .time-display {
        font-size: 0.8rem;
        color: #6b7280;
    }
    
    .shipment-badge {
        padding: 0.4rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 500;
        background-color: #f3f4f6;
        color: #4b5563;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }
    
    .shipment-badge:hover {
        background-color: #e5e7eb;
        transform: translateY(-1px);
    }
    
    .status-badge {
        padding: 0.4rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }
    
    .status-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
    
    .status-badge i {
        font-size: 0.7rem;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 page-header">
        <h2 class="fw-bold d-flex align-items-center" style="font-size: 1.75rem;color:#004aad;">
            <i class="fa-solid fa-route me-3" style="font-size: 2rem;"></i>
            Trip Management
        </h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-start border-success border-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-check-circle me-3" style="font-size: 1.2rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search & Filter -->
    <form method="GET" class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 0.75rem 0 0 0.75rem;">
                        <i class="fa fa-map-marker-alt text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control search-control border-start-0" 
                           style="border-radius: 0 0.75rem 0.75rem 0;" 
                           placeholder="Search by location" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select search-control">
                    <option value="">All Shipment Types</option>
                    <option value="individual" {{ request('type') == 'individual' ? 'selected' : '' }}>Individual</option>
                    <option value="Group" {{ request('type') == 'Group' ? 'selected' : '' }}>Group</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary shadow-sm w-100">
                    <i class="fa fa-filter me-2"></i>Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.trips.index') }}" class="btn btn-outline-secondary shadow-sm w-100">
                    <i class="fa fa-rotate-left me-2"></i>Reset
                </a>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 px-4 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-primary fw-semibold">Trip List</span>
                <span class="badge bg-light text-primary">{{ $trips->total() }} Trips</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="bg-light text-dark border-bottom">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Vehicle</th>
                            <th>Owner</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Schedule</th>
                            <th>Type</th>
                            <th>Capacity</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($trips as $trip)
                        <tr class="hover-row border-bottom">
                            <td class="ps-4">{{ $loop->iteration + ($trips->currentPage() - 1) * $trips->perPage() }}</td>
                            <td>
                                <div class="vehicle-info">
                                    <span class="vehicle-name">{{ $trip->vehicle_name }}</span>
                                    <span class="vehicle-plate">{{ $trip->vehicle_plate }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" 
                                         style="width: 32px; height: 32px;">
                                        <i class="fa-solid fa-user text-primary" style="font-size: 0.8rem;"></i>
                                    </div>
                                    <span class="fw-medium">{{ $trip->owner_name }}</span>
                                </div>
                            </td>
                            <td>
                                    <i class="fa-solid fa-circle text-success" style="font-size: 0.6rem;"></i>
                                    <span>{{ \Illuminate\Support\Str::limit($trip->from_location, 18) }}</span>
                            </td>
                            <td>
                                    <i class="fa-solid fa-location-dot text-danger"></i>
                                    <span>{{ \Illuminate\Support\Str::limit($trip->to_location, 18) }}</span>
                            </td>
                            <td>
                                <div class="date-time-wrapper">
                                    <span class="date-display">{{ \Carbon\Carbon::parse($trip->date)->format('M d, Y') }}</span>
                                    <span class="time-display">{{ \Carbon\Carbon::parse($trip->time)->format('h:i A') }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="shipment-badge">
                                    {{ ucfirst($trip->shipment_type) }}
                                </span>
                            </td>
                            <td>
                                <div class="capacity-wrapper">
                                    <span class="capacity-text">{{ $trip->available_capacity }} kg</span>
                                    <div class="progress" style="height: 6px; width: 70px;">
                                        @php
                                            $capacityPercentage = min(100, max(0, ($trip->available_capacity / 1000) * 100));
                                            $barColor = $capacityPercentage > 70 ? 'bg-success' : ($capacityPercentage > 30 ? 'bg-warning' : 'bg-danger');
                                        @endphp
                                        <div class="progress-bar {{ $barColor }}" role="progressbar"
                                            style="width: {{ $capacityPercentage }}%;"
                                            aria-valuenow="{{ $capacityPercentage }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $status = strtolower($trip->status);
                                    $statusClass = match($status) {
                                        'cancelled' => 'bg-danger',
                                        'completed' => 'bg-success',
                                        'pending' => 'bg-warning text-dark',
                                        'in progress' => 'bg-info text-dark',
                                        default => 'bg-secondary'
                                    };
                                    $statusIcon = match($status) {
                                        'cancelled' => 'fa-times-circle',
                                        'completed' => 'fa-check-circle',
                                        'pending' => 'fa-clock',
                                        'in progress' => 'fa-truck',
                                        default => 'fa-circle'
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}" style="color:white;">
                                    <i class="fa-solid {{ $statusIcon }}"></i>
                                    {{ ucfirst($trip->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="empty-state">
                                <i class="fa-solid fa-route text-muted mb-3"></i>
                                <p class="mb-1 fw-medium">No trips found</p>
                                <p class="text-muted small mb-0">Try adjusting your search criteria</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="card-footer bg-white py-3 px-4 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing {{ $trips->firstItem() ?? 0 }} to {{ $trips->lastItem() ?? 0 }} of {{ $trips->total() }} trips
                </small>
                {{ $trips->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Tooltip and Responsive Styling -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

<style>
    @media (max-width: 1199.98px) {
        .table th:nth-child(3),
        .table td:nth-child(3),
        .table th:nth-child(7),
        .table td:nth-child(7) {
            display: none;
        }
    }

    @media (max-width: 991.98px) {
        .table th:nth-child(5),
        .table td:nth-child(5) {
            display: none;
        }
    }

    @media (max-width: 767.98px) {
        .table th:nth-child(8),
        .table td:nth-child(8) {
            display: none;
        }
    }
</style>
@endsection