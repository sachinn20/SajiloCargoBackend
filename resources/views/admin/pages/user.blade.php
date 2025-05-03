@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color:#004aad;"><i class="fa-solid fa-users me-2"></i>User Management</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-start border-success border-4" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search & Filter -->
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="vehicle_owner" {{ request('role') == 'vehicle_owner' ? 'selected' : '' }}>Vehicle Owner</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100"><i class="fa fa-search me-1"></i>Search</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100"><i class="fa fa-rotate-left me-1"></i>Reset</a>
            </div>
        </div>
    </form>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>
                                @if($user->profile_photo)
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                         alt="Profile Photo"
                                         class="rounded-circle avatar-img shadow-sm"
                                         width="50" height="50"
                                         onclick="showFullImage(this.src)"
                                         style="cursor: default;">
                                @else
                                    <div class="avatar-placeholder bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-user text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $user->name }}</div>
                                <div class="text-muted small">{{ $user->email }}</div>
                            </td>
                            <td>{{ $user->phone_number ?? '-' }}</td>
                            <td>
                                <span class="badge text-white"
                                      style="background-color:
                                          {{ 
                                             ($user->role === 'vehicle_owner' ? '#6f42c1' : '#6c757d') }}">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Delete this user permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fa-solid fa-users text-muted mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">No users found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="card-footer bg-white py-3 px-4">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>

<!-- Image Lightbox Modal -->
<div id="imageModal" class="image-modal" onclick="closeImage()">
    <img id="modalImage" src="" alt="Full Image">
</div>

<style>
    .image-modal {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.85);
        z-index: 1050;
        justify-content: center;
        align-items: center;
    }
    .image-modal img {
        max-height: 90%;
        max-width: 90%;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }
</style>

<script>
    function showFullImage(src) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        modal.style.display = 'flex';
        modalImg.src = src;
    }
    function closeImage() {
        document.getElementById('imageModal').style.display = 'none';
    }
</script>
@endsection
