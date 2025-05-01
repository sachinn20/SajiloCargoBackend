@extends('layouts.admin')

@section('title', 'Trip Management')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-primary fw-bold">
            <i class="fa-solid fa-route me-2"></i>Trip Management
        </h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-start border-success border-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">

        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="ps-3">#</th>
                            <th><i class="fa-solid fa-truck me-2"></i>Vehicle</th>
                            <th><i class="fa-solid fa-id-card me-2"></i>Plate</th>
                            <th><i class="fa-solid fa-user me-2"></i>Owner</th>
                            <th><i class="fa-solid fa-location-dot me-2"></i>From</th>
                            <th><i class="fa-solid fa-location-arrow me-2"></i>To</th>
                            <th><i class="fa-solid fa-calendar me-2"></i>Date</th>
                            <th><i class="fa-solid fa-clock me-2"></i>Time</th>
                            <th><i class="fa-solid fa-box me-2"></i>Type</th>
                            <th><i class="fa-solid fa-weight-scale me-2"></i>Capacity</th>
                            <th><i class="fa-solid fa-circle-info me-2"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($trips as $trip)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold">{{ $trip->vehicle_name }}</div>
                            </td>
                            <td>
                                <span class="badge bg-dark">{{ $trip->vehicle_plate }}</span>
                            </td>
                            <td>{{ $trip->owner_name }}</td>
                            <td>
                                <span data-bs-toggle="tooltip" title="{{ $trip->from_location }}">
                                    <i class="fa-solid fa-circle text-danger me-1"></i>
                                    {{ \Illuminate\Support\Str::limit($trip->from_location, 15) }}
                                </span>
                            </td>
                            <td>
                                <span data-bs-toggle="tooltip" title="{{ $trip->to_location }}">
                                    <i class="fa-solid fa-location-pin text-success me-1"></i>
                                    {{ \Illuminate\Support\Str::limit($trip->to_location, 15) }}
                                </span>
                            </td>
                            <td>
                                <i class="fa-solid fa-calendar-day text-primary me-1"></i>
                                {{ \Carbon\Carbon::parse($trip->date)->format('M d, Y') }}
                            </td>
                            <td>
                                <i class="fa-solid fa-clock text-primary me-1"></i>
                                {{ \Carbon\Carbon::parse($trip->time)->format('h:i A') }}
                            </td>
                            <td>
                                @if(strtolower($trip->shipment_type) == 'goods')
                                    <span class="badge bg-info">
                                        <i class="fa-solid fa-box me-1"></i>{{ ucfirst($trip->shipment_type) }}
                                    </span>
                                @elseif(strtolower($trip->shipment_type) == 'passengers')
                                    <span class="badge bg-primary">
                                        <i class="fa-solid fa-users me-1"></i>{{ ucfirst($trip->shipment_type) }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fa-solid fa-cube me-1"></i>{{ ucfirst($trip->shipment_type) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">{{ $trip->available_capacity }} kg</div>
                                    <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                                        @php
                                            // This is just an example - adjust the calculation based on your actual data
                                            $capacityPercentage = min(100, max(0, ($trip->available_capacity / 1000) * 100));
                                        @endphp
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $capacityPercentage }}%" aria-valuenow="{{ $capacityPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($trip->status === 'cancelled')
                                    <span class="badge bg-danger">
                                        <i class="fa-solid fa-ban me-1"></i>{{ ucfirst($trip->status) }}
                                    </span>
                                @elseif($trip->status === 'completed')
                                    <span class="badge bg-success">
                                        <i class="fa-solid fa-check-circle me-1"></i>{{ ucfirst($trip->status) }}
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        <i class="fa-solid fa-clock me-1"></i>{{ ucfirst($trip->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fa-solid fa-route text-muted mb-2" style="font-size: 2.5rem;"></i>
                                    <p class="mb-0">No trips found.</p>
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
                    <span class="text-muted">Showing {{ count($trips ?? []) }} trips</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this to your layout or include it here -->
<style>
    /* Custom responsive behavior for the trips table */
    @media (max-width: 1399.98px) {
        .table th:nth-child(8),
        .table td:nth-child(8),
        .table th:nth-child(9),
        .table td:nth-child(9) {
            display: none;
        }
    }
    
    @media (max-width: 1199.98px) {
        .table th:nth-child(3),
        .table td:nth-child(3),
        .table th:nth-child(4),
        .table td:nth-child(4),
        .table th:nth-child(10),
        .table td:nth-child(10) {
            display: none;
        }
    }
    
    @media (max-width: 991.98px) {
        .table th:nth-child(6),
        .table td:nth-child(6),
        .table th:nth-child(7),
        .table td:nth-child(7) {
            display: none;
        }
    }
    
    @media (max-width: 767.98px) {
        .table th:nth-child(5),
        .table td:nth-child(5) {
            display: none;
        }
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