<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 250px; height: 100vh;">
    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4">SajiloCargo Admin</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                📊 Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}" class="nav-link text-white">
                👤 User Management
            </a>
        </li>
        <li>
            <a href="{{ route('admin.vehicles.index') }}" class="nav-link text-white">
                🚚 Vehicles
            </a>
        </li>
        <li>
            <a href="{{ route('admin.trips.index') }}" class="nav-link text-white">
                🧭 Trips
            </a>
        </li>
        <li>
            <a href="{{ route('admin.bookings.index') }}" class="nav-link text-white">
                📦 Bookings
            </a>
        </li>
        <li>
            <a href="{{ route('admin.payments.index') }}" class="nav-link text-white">
                💰 Payments
            </a>
        </li>
    </ul>
    <hr>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="btn btn-outline-light w-100">Logout</button>
    </form>
</div>
