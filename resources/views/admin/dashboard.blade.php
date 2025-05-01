@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-primary fw-bold">Welcome, {{ Auth::user()->name }}</h1>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow border-0 h-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <div class="position-absolute top-0 end-0 bg-primary bg-opacity-10 p-3 rounded-circle m-3">
                        <i class="fas fa-users text-primary fs-3"></i>
                    </div>
                    <h5 class="card-title text-secondary mb-3">Total Users</h5>
                    <p class="card-text fs-2 fw-bold text-primary mb-0">{{ $totalUsers }}</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 h-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <div class="position-absolute top-0 end-0 bg-primary bg-opacity-10 p-3 rounded-circle m-3">
                        <i class="fas fa-calendar-check text-primary fs-3"></i>
                    </div>
                    <h5 class="card-title text-secondary mb-3">Total Bookings</h5>
                    <p class="card-text fs-2 fw-bold text-primary mb-0">{{ $totalBookings }}</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 65%"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 h-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <div class="position-absolute top-0 end-0 bg-primary bg-opacity-10 p-3 rounded-circle m-3">
                        <i class="fas fa-car text-primary fs-3"></i>
                    </div>
                    <h5 class="card-title text-secondary mb-3">Total Vehicles</h5>
                    <p class="card-text fs-2 fw-bold text-primary mb-0">{{ $totalVehicles }}</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection