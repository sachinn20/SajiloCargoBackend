<div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white shadow-sm" style="width: 250px; height: 100vh;">
    {{-- Brand --}}
    <div class="d-flex align-items-center mb-4">
    <i class="fas fa-truck-fast me-2 fs-4" style="color: #004aad;" aria-hidden="true"></i>
    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none fw-bold text-white" style="font-size: 23px;">
        SajiloCargo
    </a>
</div>



    <hr class="text-secondary">

    {{-- Navigation --}}
    <ul class="nav nav-pills flex-column gap-2">
        <li>
            <a href="{{ route('admin.dashboard') }}" 
               class="nav-link d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active text-white' : 'text-white' }}" 
               style="{{ request()->routeIs('admin.dashboard') ? 'background-color:#004aad;' : '' }}">
                <i class="fas fa-home me-2"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}" 
               class="nav-link d-flex align-items-center {{ request()->routeIs('admin.users.*') ? 'active text-white' : 'text-white' }}"
               style="{{ request()->routeIs('admin.users.*') ? 'background-color:#004aad;' : '' }}">
                <i class="fas fa-users me-2"></i>
                Users
            </a>
        </li>
        <li>
            <a href="{{ route('admin.vehicles.index') }}" 
               class="nav-link d-flex align-items-center {{ request()->routeIs('admin.vehicles.*') ? 'active text-white' : 'text-white' }}"
               style="{{ request()->routeIs('admin.vehicles.*') ? 'background-color:#004aad;' : '' }}">
                <i class="fas fa-truck me-2"></i>
                Vehicles
            </a>
        </li>
        <li>
            <a href="{{ route('admin.trips.index') }}" 
               class="nav-link d-flex align-items-center {{ request()->routeIs('admin.trips.*') ? 'active text-white' : 'text-white' }}"
               style="{{ request()->routeIs('admin.trips.*') ? 'background-color:#004aad;' : '' }}">
                <i class="fas fa-route me-2"></i>
                Trips
            </a>
        </li>
        <li>
            <a href="{{ route('admin.bookings.index') }}" 
               class="nav-link d-flex align-items-center {{ request()->routeIs('admin.bookings.*') ? 'active text-white' : 'text-white' }}"
               style="{{ request()->routeIs('admin.bookings.*') ? 'background-color:#004aad;' : '' }}">
                <i class="fas fa-calendar-check me-2"></i>
                Bookings
            </a>
        </li>
        <li>
            <a href="{{ route('admin.payments.index') }}" 
               class="nav-link d-flex align-items-center {{ request()->routeIs('admin.payments.*') ? 'active text-white' : 'text-white' }}"
               style="{{ request()->routeIs('admin.payments.*') ? 'background-color:#004aad;' : '' }}">
                <i class="fas fa-wallet me-2"></i>
                Payments
            </a>
        </li>
    </ul>

    <hr class="text-secondary mt-auto">

    {{-- Logout --}}
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="btn btn-outline-light w-100 text-start d-flex align-items-center">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </button>
    </form>
</div>