@extends('layouts.admin')

@section('title', 'Vehicle Management')

@section('styles')
<style>
    /* Minimal, clean styling */
    :root {
        --primary: #4f46e5;
        --primary-light: #ebe9ff;
        --success: #22c55e;
        --warning: #f59e0b;
        --danger: #ef4444;
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
        margin-bottom: 1.5rem;
    }
    
    .search-box {
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        padding: 0.6rem 1rem;
        width: 100%;
        transition: all 0.2s;
    }
    
    .search-box:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
        outline: none;
    }
    
    .btn {
        border-radius: 0.5rem;
        padding: 0.6rem 1rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
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
        margin-bottom: 1.5rem;
    }
    
    .stat-card {
        border-radius: 0.75rem;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        background-color: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }
    
    .stat-label {
        color: var(--gray);
        margin: 0;
        font-size: 0.875rem;
    }
    
    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
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
    
    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        margin-right: 0.75rem;
    }
    
    .badge {
        padding: 0.35rem 0.65rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-success {
        background-color: rgba(34, 197, 94, 0.1);
        color: var(--success);
    }
    
    .badge-warning {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }
    
    .badge-secondary {
        background-color: rgba(107, 114, 128, 0.1);
        color: var(--gray);
    }
    
    .badge-pill {
        padding: 0.35rem 0.65rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        background-color: var(--light-gray);
        color: var(--gray);
    }
    
    .action-btn {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--gray);
        background-color: white;
        border: 1px solid var(--border);
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .action-btn:hover {
        background-color: var(--light-gray);
    }
    
    .action-btn-primary {
        color: var(--primary);
    }
    
    .action-btn-danger {
        color: var(--danger);
    }
    
    .doc-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 0.65rem;
        background-color: var(--light-gray);
        border-radius: 0.375rem;
        font-size: 0.75rem;
        color: var(--gray);
    }
    
    .doc-badge i {
        color: var(--primary);
    }
    
    .plate-badge {
        font-family: monospace;
        background-color: var(--light-gray);
        padding: 0.35rem 0.65rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 600;
        letter-spacing: 0.05em;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">Vehicle Management</h1>

    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #ebe9ff;">
                    <i class="fa-solid fa-car text-primary"></i>
                </div>
                <div>
                    <p class="stat-value">{{ $vehicles->total() }}</p>
                    <p class="stat-label">Total Vehicles</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #fef3c7;">
                    <i class="fa-solid fa-tools text-warning"></i>
                </div>
                <div>
                    <p class="stat-value">{{ $vehicles->where('status', 'maintenance')->count() }}</p>
                    <p class="stat-label">In Maintenance</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card p-3 mb-4">
        <form method="GET">
            <div class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control search-box border-start-0" 
                            placeholder="Search by owner or plate" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select search-box">
                        <option value="">All Vehicle Types</option>
                        <option value="Car" {{ request('type') == 'Car' ? 'selected' : '' }}>Car</option>
                        <option value="Truck" {{ request('type') == 'Truck' ? 'selected' : '' }}>Truck</option>
                        <option value="Bus" {{ request('type') == 'Bus' ? 'selected' : '' }}>Bus</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-primary w-100">
                        <i class="fa fa-filter me-2"></i>Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fa fa-rotate-left me-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Vehicle List -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Vehicle</th>
                            <th>Owner</th>
                            <th>Plate</th>
                            <th>Documents</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $vehicle)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @php
                                        $typeIcon = match(strtolower($vehicle->type)) {
                                            'car' => 'fa-car',
                                            'truck' => 'fa-truck',
                                            'bus' => 'fa-bus',
                                            default => 'fa-car-side'
                                        };
                                    @endphp
                                    <div class="avatar">
                                        <i class="fa-solid {{ $typeIcon }}"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ ucfirst($vehicle->type) }}</div>
                                        <div class="text-muted small">{{ $vehicle->capacity }} kg</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $vehicle->owner_name ?? ($vehicle->owner->name ?? '-') }}</div>
                                        @if($vehicle->owner?->phone)
                                            <div class="text-muted small">{{ $vehicle->owner->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="plate-badge">{{ $vehicle->plate }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-2">
                                    <div class="doc-badge" title="{{ $vehicle->license }}">
                                        <i class="fa-solid fa-id-card"></i>
                                        <span>{{ \Illuminate\Support\Str::limit($vehicle->license, 25) }}</span>
                                    </div>
                                    <div class="doc-badge" title="{{ $vehicle->insurance }}">
                                        <i class="fa-solid fa-shield"></i>
                                        <span>{{ \Illuminate\Support\Str::limit($vehicle->insurance, 25) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $status = strtolower($vehicle->status);
                                    list($badgeClass, $icon) = match($status) {
                                        'active' => ['badge-success', 'fa-check-circle'],
                                        'inactive' => ['badge-secondary', 'fa-times-circle'],
                                        'maintenance' => ['badge-warning', 'fa-tools'],
                                        default => ['badge-secondary', 'fa-circle']
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    <i class="fa-solid {{ $icon }} me-1"></i>
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fa-solid fa-car-burst text-muted mb-3" style="font-size: 2rem;"></i>
                                <p class="mb-1 fw-medium">No vehicles found</p>
                                <p class="text-muted small mb-0">Try adjusting your search criteria</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer py-3 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing {{ $vehicles->firstItem() ?? 0 }} to {{ $vehicles->lastItem() ?? 0 }} of {{ $vehicles->total() }} vehicles
                </small>
                {{ $vehicles->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Tooltip Initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

<!-- Responsive Styling -->
<style>
    @media (max-width: 991.98px) {
        .table th:nth-child(4),
        .table td:nth-child(4) {
            display: none;
        }
    }

    @media (max-width: 767.98px) {
        .table th:nth-child(3),
        .table td:nth-child(3) {
            display: none;
        }
    }
</style>
@endsection