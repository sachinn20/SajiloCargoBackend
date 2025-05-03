@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4" style="color:#004aad;">Dashboard Overview</h2>
    <hr>

    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Total Users</span>
                        <i class="fas fa-users text-primary"></i>
                    </div>
                    <h3 class="fw-bold text-primary">{{ $totalUsers }}</h3>
                    <span class="badge bg-light text-primary">All Customers + Vehicle Owners</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Total Bookings</span>
                        <i class="fas fa-calendar-check text-success"></i>
                    </div>
                    <h3 class="fw-bold text-success">{{ $totalBookings }}</h3>
                    <span class="badge bg-light text-success">Completed + Active</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Total Vehicles</span>
                        <i class="fas fa-truck text-warning"></i>
                    </div>
                    <h3 class="fw-bold text-warning">{{ $totalVehicles }}</h3>
                    <span class="badge bg-light text-warning">Active Fleet</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Quick Links</span>
                        <i class="fas fa-tools text-danger"></i>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm w-100 mb-2">Manage Users</a>
                    <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-success btn-sm w-100 mb-2">Manage Vehicles</a>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-warning btn-sm w-100">Manage Bookings</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 text-dark">Bookings Trend</h6>
                </div>
                <div class="card-body">
                    <canvas id="bookingsChart" height="220"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 text-dark">Vehicle Usage</h6>
                </div>
                <div class="card-body">
                    <canvas id="vehicleUsageChart" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bookings Trend Chart
    const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    new Chart(bookingsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($bookingMonths) !!},
            datasets: [{
                label: 'Bookings',
                data: {!! json_encode($bookingCounts) !!},
                fill: true,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Vehicle Usage Pie Chart
    const vehicleCtx = document.getElementById('vehicleUsageChart').getContext('2d');
    new Chart(vehicleCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($vehicleTypes) !!},
            datasets: [{
                label: 'Vehicles',
                data: {!! json_encode($vehicleTypeCounts) !!},
                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection
