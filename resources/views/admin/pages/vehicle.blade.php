@extends('layouts.admin')

@section('title', 'Vehicle Management')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-primary fw-bold">
            <i class="fa-solid fa-car me-2"></i>Vehicle Management
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
                            <th><i class="fa-solid fa-user me-2"></i>Owner</th>
                            <th><i class="fa-solid fa-truck-monster me-2"></i>Type</th>
                            <th><i class="fa-solid fa-users me-2"></i>Capacity</th>
                            <th><i class="fa-solid fa-id-card me-2"></i>Plate</th>
                            <th><i class="fa-solid fa-id-badge me-2"></i>License</th>
                            <th><i class="fa-solid fa-shield-alt me-2"></i>Insurance</th>
                            <th><i class="fa-solid fa-circle-info me-2"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($vehicles as $vehicle)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold">{{ $vehicle->owner_name ?? ($vehicle->owner->name ?? '-') }}</div>
                                @if(isset($vehicle->owner) && isset($vehicle->owner->phone))
                                    <div class="small text-muted"><i class="fa-solid fa-phone me-1"></i>{{ $vehicle->owner->phone }}</div>
                                @endif
                            </td>
                            <td>
                                @if(strtolower($vehicle->type) == 'car')
                                    <i class="fa-solid fa-car text-primary me-2"></i>
                                @elseif(strtolower($vehicle->type) == 'truck')
                                    <i class="fa-solid fa-truck text-primary me-2"></i>
                                @elseif(strtolower($vehicle->type) == 'bus')
                                    <i class="fa-solid fa-bus text-primary me-2"></i>
                                @else
                                    <i class="fa-solid fa-truck-monster text-primary me-2"></i>
                                @endif
                                {{ $vehicle->type }}
                            </td>
                            <td>
                                <span class="badge bg-info rounded-pill">{{ $vehicle->capacity }} seats</span>
                            </td>
                            <td>
                                <span class="badge bg-dark">{{ $vehicle->plate }}</span>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ $vehicle->license }}">
                                    {{ $vehicle->license }}
                                </span>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ $vehicle->insurance }}">
                                    {{ $vehicle->insurance }}
                                </span>
                            </td>
                            <td>
                                @if(strtolower($vehicle->status) == 'active')
                                    <span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i>{{ ucfirst($vehicle->status) }}</span>
                                @elseif(strtolower($vehicle->status) == 'inactive')
                                    <span class="badge bg-secondary"><i class="fa-solid fa-circle-pause me-1"></i>{{ ucfirst($vehicle->status) }}</span>
                                @elseif(strtolower($vehicle->status) == 'maintenance')
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-wrench me-1"></i>{{ ucfirst($vehicle->status) }}</span>
                                @else
                                    <span class="badge bg-info"><i class="fa-solid fa-circle-info me-1"></i>{{ ucfirst($vehicle->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fa-solid fa-car-burst text-muted mb-2" style="font-size: 2.5rem;"></i>
                                    <p class="mb-0">No vehicles found.</p>
                                    <p class="text-muted small">Try adjusting your search or filter criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add this to your layout or include it here -->
<style>
    @media (max-width: 991.98px) {
        .table-responsive {
            border-radius: 0.25rem;
        }
        
        .table th:nth-child(4),
        .table td:nth-child(4),
        .table th:nth-child(6),
        .table td:nth-child(6),
        .table th:nth-child(7),
        .table td:nth-child(7) {
            display: none;
        }
    }
    
    @media (max-width: 767.98px) {
        .table th:nth-child(3),
        .table td:nth-child(3),
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